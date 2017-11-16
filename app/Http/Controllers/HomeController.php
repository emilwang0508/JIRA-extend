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
        $request = `{
	"timestamp": 1510829745851,
	"webhookEvent": "jira:issue_updated",
	"issue_event_type_name": "issue_generic",
	"user": {
		"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/user?username=emil",
		"name": "emil",
		"key": "emil",
		"accountId": "557058:e3611fb9-c0fe-45ce-8cfa-e527e94f8317",
		"emailAddress": "emil@multiverseinc.com",
		"avatarUrls": {
			"48x48": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=48&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D48%26noRedirect%3Dtrue",
			"24x24": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=24&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D24%26noRedirect%3Dtrue",
			"16x16": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=16&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D16%26noRedirect%3Dtrue",
			"32x32": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=32&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D32%26noRedirect%3Dtrue"
		},
		"displayName": "Emil Wong",
		"active": true,
		"timeZone": "Asia\/Shanghai"
	},
	"issue": {
		"id": "12296",
		"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/issue\/12296",
		"key": "SD-2139",
		"fields": {
			"issuetype": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/issuetype\/10001",
				"id": "10001",
				"description": "Created by Jira Agile - do not edit or delete. Issue type for a user story.",
				"iconUrl": "https:\/\/multiverseinc.atlassian.net\/images\/icons\/issuetypes\/story.svg",
				"name": "\u6545\u4e8b",
				"subtask": false
			},
			"timespent": null,
			"customfield_10030": null,
			"customfield_10031": null,
			"project": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/project\/10001",
				"id": "10001",
				"key": "SD",
				"name": "Seeking Dawn",
				"avatarUrls": {
					"48x48": "https:\/\/multiverseinc.atlassian.net\/secure\/projectavatar?avatarId=10324",
					"24x24": "https:\/\/multiverseinc.atlassian.net\/secure\/projectavatar?size=small&avatarId=10324",
					"16x16": "https:\/\/multiverseinc.atlassian.net\/secure\/projectavatar?size=xsmall&avatarId=10324",
					"32x32": "https:\/\/multiverseinc.atlassian.net\/secure\/projectavatar?size=medium&avatarId=10324"
				}
			},
			"customfield_10032": null,
			"fixVersions": [],
			"customfield_10033": null,
			"customfield_10034": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/user?username=alexis",
				"name": "alexis",
				"key": "alexis",
				"accountId": "557058:f134d2c6-2924-4b24-b9be-e3598c50fd66",
				"emailAddress": "alexis@multiverseinc.com",
				"avatarUrls": {
					"48x48": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=48&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D48%26noRedirect%3Dtrue",
					"24x24": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=24&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D24%26noRedirect%3Dtrue",
					"16x16": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=16&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D16%26noRedirect%3Dtrue",
					"32x32": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=32&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D32%26noRedirect%3Dtrue"
				},
				"displayName": "Alexis",
				"active": true,
				"timeZone": "Asia\/Shanghai"
			},
			"aggregatetimespent": null,
			"resolution": null,
			"customfield_10027": null,
			"customfield_10028": null,
			"customfield_10029": null,
			"resolutiondate": null,
			"workratio": -1,
			"lastViewed": null,
			"watches": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/issue\/SD-2139\/watchers",
				"watchCount": 1,
				"isWatching": false
			},
			"created": "2017-11-16T18:28:14.672+0800",
			"customfield_10022": 0,
			"priority": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/priority\/1",
				"iconUrl": "https:\/\/multiverseinc.atlassian.net\/images\/icons\/priorities\/highest.svg",
				"name": "Highest",
				"id": "1"
			},
			"customfield_10025": null,
			"customfield_10026": null,
			"labels": [],
			"timeestimate": null,
			"aggregatetimeoriginalestimate": null,
			"versions": [],
			"issuelinks": [],
			"assignee": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/user?username=emil",
				"name": "emil",
				"key": "emil",
				"accountId": "557058:e3611fb9-c0fe-45ce-8cfa-e527e94f8317",
				"emailAddress": "emil@multiverseinc.com",
				"avatarUrls": {
					"48x48": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=48&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D48%26noRedirect%3Dtrue",
					"24x24": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=24&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D24%26noRedirect%3Dtrue",
					"16x16": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=16&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D16%26noRedirect%3Dtrue",
					"32x32": "https:\/\/avatar-cdn.atlassian.com\/c85ab5ebce9dd18a7a62cd91b1ae34d5?s=32&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2Fc85ab5ebce9dd18a7a62cd91b1ae34d5%3Fd%3Dmm%26s%3D32%26noRedirect%3Dtrue"
				},
				"displayName": "Emil Wong",
				"active": true,
				"timeZone": "Asia\/Shanghai"
			},
			"updated": "2017-11-16T18:55:45.833+0800",
			"status": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/status\/3",
				"description": "\u6b64\u95ee\u9898\u6b63\u5728\u88ab\u7ecf\u529e\u4eba\u79ef\u6781\u5904\u7406\u3002",
				"iconUrl": "https:\/\/multiverseinc.atlassian.net\/images\/icons\/statuses\/inprogress.png",
				"name": "\u5904\u7406\u4e2d",
				"id": "3",
				"statusCategory": {
					"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/statuscategory\/4",
					"id": 4,
					"key": "indeterminate",
					"colorName": "yellow",
					"name": "\u5904\u7406\u4e2d"
				}
			},
			"components": [],
			"timeoriginalestimate": null,
			"description": null,
			"customfield_10010": ["com.atlassian.greenhopper.service.sprint.Sprint@2121871c[id=27,rapidViewId=2,state=ACTIVE,name=SDVR Sprint 1 (11\/13 to 11\/24),goal=,startDate=2017-11-13T01:00:49.217Z,endDate=2017-11-24T10:00:00.000Z,completeDate=<null>,sequence=27]"],
			"customfield_10011": "0|i00csn:",
			"customfield_10012": null,
			"customfield_10013": null,
			"timetracking": [],
			"security": null,
			"customfield_10008": null,
			"customfield_10009": null,
			"attachment": [],
			"aggregatetimeestimate": null,
			"summary": "D - \u6e23\u6e23\u4f73\u7684\u5475\u5475\u6d4b\u8bd5\u4efb\u52a1",
			"creator": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/user?username=alexis",
				"name": "alexis",
				"key": "alexis",
				"accountId": "557058:f134d2c6-2924-4b24-b9be-e3598c50fd66",
				"emailAddress": "alexis@multiverseinc.com",
				"avatarUrls": {
					"48x48": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=48&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D48%26noRedirect%3Dtrue",
					"24x24": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=24&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D24%26noRedirect%3Dtrue",
					"16x16": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=16&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D16%26noRedirect%3Dtrue",
					"32x32": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=32&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D32%26noRedirect%3Dtrue"
				},
				"displayName": "Alexis",
				"active": true,
				"timeZone": "Asia\/Shanghai"
			},
			"subtasks": [],
			"reporter": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/user?username=alexis",
				"name": "alexis",
				"key": "alexis",
				"accountId": "557058:f134d2c6-2924-4b24-b9be-e3598c50fd66",
				"emailAddress": "alexis@multiverseinc.com",
				"avatarUrls": {
					"48x48": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=48&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D48%26noRedirect%3Dtrue",
					"24x24": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=24&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D24%26noRedirect%3Dtrue",
					"16x16": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=16&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D16%26noRedirect%3Dtrue",
					"32x32": "https:\/\/avatar-cdn.atlassian.com\/173d6f9b85629ca5f5910b7fd635e62c?s=32&d=https%3A%2F%2Fsecure.gravatar.com%2Favatar%2F173d6f9b85629ca5f5910b7fd635e62c%3Fd%3Dmm%26s%3D32%26noRedirect%3Dtrue"
				},
				"displayName": "Alexis",
				"active": true,
				"timeZone": "Asia\/Shanghai"
			},
			"aggregateprogress": {
				"progress": 0,
				"total": 0
			},
			"customfield_10000": "{}",
			"customfield_10001": null,
			"customfield_10002": null,
			"customfield_10003": null,
			"customfield_10004": null,
			"environment": null,
			"duedate": null,
			"progress": {
				"progress": 0,
				"total": 0
			},
			"comment": {
				"comments": [],
				"maxResults": 0,
				"total": 0,
				"startAt": 0
			},
			"votes": {
				"self": "https:\/\/multiverseinc.atlassian.net\/rest\/api\/2\/issue\/SD-2139\/votes",
				"votes": 0,
				"hasVoted": false
			}
		}
	},
	"changelog": {
		"id": "24456",
		"items": [{
			"field": "status",
			"fieldtype": "jira",
			"fieldId": "status",
			"from": "10000",
			"fromString": "To Do",
			"to": "3",
			"toString": "In Progress"
		}]
	},
	"attachment_id": null,
	"board_id": null,
	"comment_id": null,
	"issue_id": "12296",
	"issue_key": "SD-2139",
	"mergedVersion_id": null,
	"modifiedUser_key": null,
	"modifiedUser_name": null,
	"project_id": "10001",
	"project_key": "SD",
	"sprint_id": null,
	"version_id": null,
	"worklog_id": null,
	"user_id": "emil",
	"user_key": "emil"
}
`;
        $issue = new Issue;
        $issue = $request->issue;
        $fields = $issue->fields;
        $issue->id = $request->issue->id;
        $issue->self = $request->issue->self;
        $issue->key = $request->issue->key;
        $issue->user_id = $request->user_id;
        $issue->user_key = $request->user_key;
        $issue->fields = $fields;
        $issue->issuetype = $fields->fields_issuetype;
        //project
        $issue->project_id = $fields->project->id;
        $issue->project_key = $fields->project->key;
        $issue->project_name = $fields->project->name;
        $issue->project = $fields->project;
        //assignee
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
        $issue->save();
    }
}
