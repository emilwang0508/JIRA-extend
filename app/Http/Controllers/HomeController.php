<?php

namespace App\Http\Controllers;

use App\Issue;
use Aws\Credentials\Credentials;
use Aws\Laravel\AwsFacade;
use Aws\Polly\PollyClient;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Pusher\Pusher;
use JiraRestApi\Configuration\ArrayConfiguration;
use JiraRestApi\Issue\IssueService;

class HomeController extends Controller
{
    public function __construct($sprintId)
    {
        $this->sprintId = $sprintId;
    }
    public function sent()
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $time = date('r');
        echo "data: The server time is: {$time}\n\n";
        flush();
    }
    //获取当前项目所有属性
    public function getAllIssue()
    {

    }
    public function webhooks(Request $request)
    {
        $json_string = file_get_contents('js/webhooks.json');
        $json_string==''?$json_string= json_encode($request->all()):$json_string = $json_string .','. json_encode($request->all());
        file_put_contents('js/webhooks.json',$json_string);
    }

    public function webhooksTest(Request $request)
    {
        $issue = new Issue;
        if ($request==''){

        }{
            $issueS = $request->issue;
            $fields = $issueS['fields'];
            $issue->id = $issueS['id'];
            $issue->self = $issueS['self'];
            $issue->key = $issueS['key'];
            $issue->user_id = $request->user_id;
            $issue->user_key = $request->user_key;
            $issue->user_name = $request->user['displayName'];
            //project
            $issue->project_id = $fields['project']['id'];
            $issue->project_key = $fields['project']['key'];
            $issue->project_name = $fields['project']['name'];
            //assigneesda
            $issue->assignee_key = $fields['assignee']['key'];
            $issue->assignee_name = $fields['assignee']['displayName'];
            //creator
            $issue->creator_key = $fields['creator']['key'];
            $issue->creator_name = $fields['creator']['displayName'];
            //summary
            $issue->summary = $fields['summary'];
            $issue->issue_key = $fields['summary'];
            //reporter
            $issue->reporter_key = $fields['reporter']['key'];
            $issue->reporter_name = $fields['reporter']['displayName'];
            //issue
            $issue->reporter_key = $fields['reporter']['key'];
            $issue->reporter_name = $fields['reporter']['displayName'];
            //issue
            if (array_key_exists('tester',$fields)){
                $issue->tester_key = $fields['tester']['key'];
                $issue->tester_name = $fields['tester']['displayName'];
            }else{
                $issue->tester_key = '';
                $issue->tester_name = '';
            }

            //status
            $staus = $fields['status'];
            $issue->status_id = $staus['id'];
            $issue->status_name = $staus['name'];
            $issue->statusCategory_key = $staus['statusCategory']['key'];
            $issue->statusCategory_id = $staus['statusCategory']['id'];

            $changelog  = $request->changelog;
            $items = $changelog['items'];
            foreach ($items as $item){
                if ($item['field'] == 'status'){
                    $issue->toString = $item['toString'];
                    $issue->fromString = $item['fromString'];
                }
            }
            if ($issue->toString == 'Done'||$issue->toString == 'Reopened'){

                $this->send_pusher($issue);
            }
            }
    }
    public function send_pusher($issue)
    {
        $options = array(
            'cluster' => 'us2',
            'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );
        ($issue->tester_name == '')?$repoter = $issue->reporter_name: $repoter = $issue->tester_name;
        if($issue->toString == 'Done'){
            $message = '<speak>'.$issue->user_name.' task done.<break time="0.5s" />'.$repoter." please check.</speak>";
        }
        if ($issue->toString == 'Reopened'){
            $message = '<speak>'.$issue->assignee_name." task reopened.</speak>";
        }
        $data['message'] = $message;
        print_r($message);
        $data['voiceUrl'] =  $this->polly($message);
        $data['toString'] = $issue->toString;
        $data['fromString'] = $issue->fromString;
        $text = $message;
        $data['projectName'] = $issue->project_name;
        $data['projectKey'] = $issue->project_key;
        $data['userName'] = $issue->user_name;
        $data['summary'] = $issue->summary;
        $data['reporterName'] = $repoter;
        $data['assigneeName'] = $issue->assignee_name;
        $data['issueKey'] = $issue->key;
        $pusher->trigger('my-channel', 'my-event', $data);
    }
    public function sendVoice(){
        $client = new \GuzzleHttp\Client();
        $access_token = '24.d985bc11e0e7346eb70b26d7a6cf5cd8.2592000.1513493401.282335-10346057';
        $tex = 'Hello, is me';
        $cuid = 'fe80::5dfa:a924:40e9:a2d%6';
        $res =  $client->request('get', 'http://tsn.baidu.com/text2audio?tex='.$tex.'&lan=zh&cuid='.$cuid.'&ctp=1&tok='.$access_token);
        dd($res);
    }
    /*
     * build  通知
     * */
    public function buildEventPusher(Request $request)
    {
        $json_string = file_get_contents('js/test.json');
        $json_string==''?$json_string= json_encode($request->all()):$json_string = $json_string .','. json_encode($request->all());
        file_put_contents('js/test.json',$json_string);
        if ($request->buildName!==''&$request->event!==''){
            $options = array(
                'cluster' => 'us2',
                'encrypted' => true
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $data = array();
            $data['buildName']=$request->buildName;
            $data['projectName']=$request->projectName;
            $data['event'] = $request->event;
            if ( $data['event'] == 'success'){
                $text = $request->buildName.' build successful.';
            }
            else if($data['event'] == 'failure'){
                $text = $request->buildName.' build failed.';
            }

            $data['voiceUrl'] = $this->polly($text,'text');
            $pusher->trigger('my-channel', 'build-project-event', $data);
        }
    }
    /*
     * pm5:30 event
     * 机器会自动校准查验done中的任务数量，对于同一个reporter，done中的任务>1的，
     * 需要语音提示，如“A未检查的任务达到B个，请留意JIRA done面板，及时向小伙伴给出回馈”。
     * 若有人满足以上条件，则这些文字会呈红色出现在屏幕上，每分钟刷新一次，直到没有人满足条件。
     * AAAA please verify completed tasks.
     * */
    public function doneIssueChecked()
    {
        $jql = 'project = SD AND status = Done AND Sprint = '.env('SPRINT_ID').' order by lastViewed DESC';
        $res = $this->jira($jql);
        $issues = $res->issues;//获得任务数组
        //  定义推送数组
        $datas =  array();

        foreach ($issues as $issue){
            if (array_key_exists('customfield_10034',$issue->fields->customFields)){
                array_push($datas,$issue->fields->customFields['customfield_10034']->displayName);
            }else{
                array_push($datas,$issue->fields->reporter->displayName);
            }

        }
        $name = array_count_values ($datas);
        $data['name'] = $name;
        $string = '';
        foreach($name as $k=>$v){
            $string .= $k.'<break time="0.2s" />';
        };
        $text = '<speak>'.$string.'please verify completed tasks.</speak>';
        $voiceUrl = $this->polly($text);
        $data['voiceUrl'] = $voiceUrl;
        $res = $this->push($data,'done-issue-checked-event');
    }
    /*
     * 本sprint有任务超过1小时无人接取，会每隔5分钟语音播报“编号A、B、C任务超过1h无人接取，请技术人员尽快处理”。
     * */
    public function todoChecked()
    {
        $jql = 'project = SD AND status = "To Do" AND Sprint = '.env('SPRINT_ID').' AND assignee in (EMPTY) order by lastViewed DESC';
        $res = $this->jira($jql);
        $total = $res->total;//获得任务数组
        if ($total!==''){
            $text = '<speak>Please volunteer for unassigned task.</speak>';
            $voiceUrl = $this->polly($text);
            $data['voiceUrl'] = $voiceUrl;
            $res = $this->push($data,'play-voice-event');
            dd($res);
        }

    }
    /*
     *
     * pusher
     * */
    public function push($data, $event='my-event', $channels = 'my-channel')
    {
            $options = array(
                'cluster' => 'us2',
                'encrypted' => true
            );
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            $pusher->trigger($channels, $event, $data);
    }
    /*
     * 每天上午十点，进行一次检测，若todo、reopen中的任务的总时长超过sprint剩余工作时长，
     * 进行一次提示“A、B、C的todo、reopen任务的总时长已经超过了剩余工作日的时长，
     * 请注意工作时间的分配，帮助PO同学留出测试时间”
     * */
    public function amChecked()
    {
        $friends = [
            ['name'=>'alexis', 'displayName'=>'alexis'],
            ['name'=>'644633115','displayName'=>'lianghaoming'],
            ['name'=>'azoom11131','displayName'=>'ZengZhiXiong'],
            ['name'=>'blinkseedcitrus','displayName'=>'HePingChuan'],
            ['name'=>'chenggong19890215','displayName'=>'chenggong'],
            ['name'=>'chenquanhong86','displayName'=>'chenquanhong'],
            ['name'=>'"Chenwen Chen"','displayName'=>'ccw'],
            ['name'=>'emptyxu','displayName'=>'xuyi'],
            ['name'=>'eric1990zhang','displayName'=>'Zhang DaoYang'],
            ['name'=>'haomajf','displayName'=>'liangjifen'],
            ['name'=> 'huang.zacc','displayName'=>'Zachary Huang'],
            ['name'=>'huskycharmin','displayName'=>'ChenQiaMing'],
            ['name'=>'jinlinhan11111','displayName'=>'jinlinhan'],
            ['name'=>'jiwon','displayName'=>'Jiwon Kang'],
            ['name'=>'leebo2012','displayName'=>'LIBO'],
            ['name'=>'liufan331','displayName'=>'LiuFan'],
            ['name'=>'lynch.xu','displayName'=>'lynch'],
            ['name'=>'penggaohua2017','displayName'=>'penggaohua'],
            ['name'=>'pengqian9086','displayName'=>'PQ'],
            ['name'=>'xiongfei8548','displayName'=>'XIONG FEI'],
            ['name'=>'xucheng93161','displayName'=>'xucheng'],
            ['name'=> 'yohan.duval','displayName'=>'Yohan'],
        ];
        $StrugglingFriends = array();
        foreach ($friends as $friend){
            $name = $friend["name"];
            $jql = 'project = SD AND issuetype = Story AND status in ("In Progress", Reopened, "To Do") AND Sprint = '.env('SPRINT_ID').' AND assignee in ('.$name.') order by lastViewed DESC ';
            $res = $this->jira($jql);
            if ($res->total===0){

            }
            else{
                $issues = $res->issues;
                $goingHours = 0;
                $endDate = strtotime(env('SPRINT_END_DATE'));
                $nowDate = strtotime(date('Y-m-d'));
                $remainingWorkingHours = ($endDate-$nowDate)/86400*8+7;
                foreach ($issues as $issue){
                    if(isset($issue->fields->customfield_10022)){
                        $goingHours += $issue->fields->customfield_10022;
                    }
                }
                if($goingHours>$remainingWorkingHours){
                    array_push($StrugglingFriends,$friend['displayName']);
                }
            }
        }

        // 拼接语音字符串
        if (count($StrugglingFriends)>0){
            $string = '';
            foreach($StrugglingFriends as $key=>$value){
                $string .= $value.' ';
            }
            $text = $string.',please check sprint progress.';
            $data['voiceUrl'] = $this->polly($text,'text');
            $data['name'] = $StrugglingFriends;
            $res = $this->push($data,'am10checked-event');
        }


    }
    /*
     *
     * */
    public function PunchEvent()
    {
        $text = '<speak>Please Da Ka<break time="0.5s" />Please Da Ka Please Da Ka</speak>';
        $data['voiceUrl'] = $this->polly($text);
        $this->push($data,'punch-event');
        print_r($data);
    }
    /*
     * $jql
     * */
    public function issueSearch($jql)
    {


        $iss = new IssueService(new ArrayConfiguration(
            array(
                'jiraHost' => 'https://your-jira.host.com',
                'jiraUser' => 'jira-username',
                'jiraPassword' => 'jira-password',
            )
        ));
        $client = new \GuzzleHttp\Client();
        $res = $client->request('post','https://multiverseinc.atlassian.net/rest/api/2/search',[
            'form_params' => [
                'jql' => $jql,
                'maxResults'=>100
            ]
        ]);
        return $res;
    }
    /*
     * TTS
     * */
    public function tts($text)
    {
        $client = new \GuzzleHttp\Client();
        $access_token = '24.d985bc11e0e7346eb70b26d7a6cf5cd8.2592000.1513493401.282335-10346057';
        $cuid = 'fe80::5dfa:a924:40e9:a2d%6';
        $url = 'http://tsn.baidu.com/text2audio?tex='.$text.'&lan=zh&cuid='.$cuid.'&ctp=1&tok='.$access_token;
        $res =  $client->request('get', $url);
        return $url;
    }
    /*
     * amazon polly tts
     * */
    public function polly($text,$textType = 'ssml'){
        $credentials = new Credentials(env('AWS_KEY'),env('AWS_SECRET'));
        $polly = new PollyClient([
               'version'     => 'latest',
                'region'      => 'us-west-2',
                'credentials' => $credentials,
                'http'    => [
                    'verify' => base_path('cacert.pem')
                ]
        ]);
        $res = $polly->synthesizeSpeech([
            'OutputFormat' => 'mp3', // REQUIRED
            'Text' => $text, // REQUIRED
            'TextType' => $textType,
            'VoiceId' => 'Joanna', // REQUIRED
        ]);
        $resultData = $res->get('AudioStream')->getContents();//获得mp3文件
        $myfile = fopen(time().'-polly.mp3','w');
        fwrite($myfile,$resultData);

        // 创建临时文件
        $fileName = time().'-polly.mp3';
        $s3region = 'us-west-2';
        $s3 = new S3Client(
            [
                'version' => 'latest',
                'credentials' => $credentials,
                'region' => $s3region,
                'http'    => [
                    'verify' => base_path('cacert.pem')
                ]
            ]
        );
        $s3bucket = 'multiverse.upload';
        $url = base_path('public/'.$fileName);
        $file = fopen($url, 'r');
        $resultS3 = $s3->putObject([
            'Key'=>$fileName,
            'ACL'=>'public-read',
            'Body'=>$file ,
            'Bucket'=>$s3bucket,
            'ContentType'=>'audio/mpeg',
        ]);
        $ObjectURL = $resultS3->get('ObjectURL');
        fclose($file);
        fclose($myfile);
        unlink(base_path('public/').$fileName);
        if ($ObjectURL){

            return $ObjectURL;
        }

    }
    /*
     * jira
     * */
    public function jira($jql,$startAt=0,$maxResult=100)
    {
        $iss = new IssueService(new ArrayConfiguration(
            array(
                'jiraHost' => env('JIRA_HOST'),
                'jiraUser' => env('JIRA_USER'),
                'jiraPassword' => env('JIRA_PASS'),
            )
        ));
        $res = $iss->search($jql,$startAt,$maxResult);
        return $res;
    }

}
