<?php

namespace App\Http\Controllers;

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
}
