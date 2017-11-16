<?php

namespace App\Http\Controllers;

use App\Issue;
use Illuminate\Http\Request;

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
        $issueS = $request->issue;
        $fields = $issueS['fields'];
        $issue->id = $issueS['id'];
        $issue->self = $issueS['self'];
        $issue->key = $issueS['key'];
        $issue->user_id = $request->user_id;
        $issue->user_key = $request->user_key;
        $issue->fields = $fields;
        $issue->issuetype = $fields['issuetype'];
        //project
        $issue->project_id = $fields['project']['id'];
        $issue->project_key = $fields['project']['key'];
        $issue->project_name = $fields['project']['name'];
        $issue->project = $fields['project'];
        //assigneesda
        $issue->assignee_key = $fields->assignee->key;
        $issue->assignee_name = $fields->assignee->name;
        $issue->assignee = $fields->assignee;
        //creator
        $issue->creator_key = $fields->creator->key;
        $issue->creator_name = $fields->creator->name;
        $issue->creator = $fields->creator;
        //summary
        $issue->summary = $fields->summary;
        //reporter
        $issue->reporter_key = $fields->reporter->key;
        $issue->reporter_name = $fields->reporter->name;
        $issue->reporter = $fields->reporter;
        //changelog
        $issue->changelog = $request->changelog;
        //status
        $staus = $fields->status;
        $issue->status_id = $staus->id;
        $issue->status_name = $staus->name;
        $issue->statusCategory_key = $staus->statusCategory->key;
        $issue->statusCategory_id = $staus->statusCategory->id;
        $issue->status = $staus;
        $issue->remark = $request->all();
        dd($issue);
        //         $issue->save();
    }
}
