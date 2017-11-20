<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JIRA Extend</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/layui/css/layui.css">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
    {{--<div class="layui-container">--}}
        <div class="layui-row">
            <div class="layui-col-md5">
                <h2 >REOPENED</h2>
                <ul id="reopened-list">
                </ul>
            </div>
            <div class="layui-col-md5">
                <h2>DONE</h2>
                <ul id="done-list">
                </ul>
            </div>
            <div class="layui-col-md2">
                <ul id="build-project-area">
                </ul>
            </div>
        </div>
    {{--</div>--}}
    <audio src="" id="audio"></audio>
    </body>
    <script src="/js/jQuery-3.2.1.min.js"></script>
    <script src="/layui/layui.all.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: 'us2',
            encrypted: true
        });
        var reopened = document.getElementById('reopened-list');
        var channel = pusher.subscribe('my-channel');
        var x = document.getElementById("audio");
        channel.bind('my-event', function(data) {
            x.src = data.voiceUrl;
            x.play();
            if (data.toString == 'Done'){
                $("#done-list").prepend(`
                  <li class="layui-anim layui-anim-upbit">
                    <p class="name">`+data.projectName+`</p>
                    <p class="summary">`+data.issueKey+`: `+data.summary+`</p>
                    <div class="status">
                        <span class="fromName">`+data.userName+`</span>
                        <span class="fromString">`+data.fromString+`</span>
                        <span class="to">\></span>
                        <span class="toSting">`+data.toString+`</span>
                        <span class="toName">`+data.reporterName+`</span>
                        <span></span>
                    </div>
                    </li>
                `);
            }
            if (data.toString == 'Reopened'){
                $("#reopened-list").prepend(`
                <li class="layui-anim layui-anim-upbit">
                    <p class="name">`+data.projectName+`</p>
                    <p class="summary">`+data.issueKey+`: `+data.summary+`</p>
                    <div class="status">
                        <span class="fromName">`+data.userName+`</span>
                        <span class="fromString">`+data.fromString+`</span>
                        <span class="to">\></span>
                        <span class="toSting">`+data.toString+`</span>
                        <span class="toName">`+data.assigneeName+`</span>
                        <span></span>
                    </div>
                </li>
                `);
            }
        });
        channel.bind('build-project-event', function(data){
            if(data.event == 'success'){
                $("#build-project-area").prepend(`
                    <li class="success">“`+data.buildName+`”Build成功</li>
                `)
            }else if(data.event == 'failure'){
                $("#build-project-area").prepend(`
                    <li class="failure">“`+data.buildName+`”Build失败</li>
                `)
            }
        })
    </script>
</html>
