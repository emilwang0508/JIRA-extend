<?php

namespace App\Http\Controllers;

use App\Issue;
use Illuminate\Http\Request;
use Pusher\Pusher;

class HomeController extends Controller
{
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
    public function weekdays5pm()
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
    //        $issue->fields = json_encode($fields);
    //        $issue->issuetype = json_encode($fields['issuetype']);
    //        dd(strlen($issue->issuetype));
            //project
            $issue->project_id = $fields['project']['id'];
            $issue->project_key = $fields['project']['key'];
            $issue->project_name = $fields['project']['name'];
    //        $issue->project = json_encode($fields['project']);
            //assigneesda
            $issue->assignee_key = $fields['assignee']['key'];
            $issue->assignee_name = $fields['assignee']['name'];
    //        $issue->assignee = json_encode($fields['assignee']);
            //creator
            $issue->creator_key = $fields['creator']['key'];
            $issue->creator_name = $fields['creator']['name'];
    //        $issue->creator = json_encode($fields['creator']);
            //summary
            $issue->summary = $fields['summary'];
            //reporter
            $issue->reporter_key = $fields['reporter']['key'];
            $issue->reporter_name = $fields['reporter']['name'];
    //        $issue->reporter = json_encode($fields['reporter']);
            //changelog
    //        $issue->changelog = json_encode($request->changelog);
            //status
            $staus = $fields['status'];
    //        echo(json_encode($staus));
            $issue->status_id = $staus['id'];
            $issue->status_name = $staus['name'];
            $issue->statusCategory_key = $staus['statusCategory']['key'];
            $issue->statusCategory_id = $staus['statusCategory']['id'];
    //        $issue->status = json_encode($staus);
    //        $issue->remark = json_encode($request->all());
    //        dd($issue);
            $issue->save();
            $message = $issue->user_id."将".$issue->project_name.'的'.$issue->key.'任务的状态改称为：'.$issue->statusCategory_key;
            $this->send_pusher($message);
            }
    }
    public function send_pusher($message)
    {
        $options = array(
            'cluster' => 'us2',
            'encrypted' => true
        );
//        Pusher::pusher();
        $pusher = new Pusher(
            '2ef9566826373100cc30',
            'd6dda86cc65a256681df',
            '432251',
            $options
        );

        $data['message'] = $message;
        $access_token = '24.d985bc11e0e7346eb70b26d7a6cf5cd8.2592000.1513493401.282335-10346057';
        $tex = $message;
        $cuid = 'fe80::5dfa:a924:40e9:a2d%6';
        $client = new \GuzzleHttp\Client();
        $client->request('get', 'http://tsn.baidu.com/text2audio?tex='.$tex.'&lan=zh&cuid='.$cuid.'&ctp=1&tok='.$access_token);
        $data['voiceUrl'] = 'http://tsn.baidu.com/text2audio?tex='.$tex.'&lan=zh&cuid='.$cuid.'&ctp=1&tok='.$access_token;
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
}
