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
        <style>

        </style>
    </head>
    <body>
    <div class="layui-container">
        <div class="layui-row">
            <div class="layui-col-md6">
                <h2 >REOPENED</h2>
                <ul id="reopened-list">
                    <li class="layui-anim layui-anim-upbit">
                        <p class="name">Seeking Dawn</p>
                        <p class="summary">SD 777: 呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵</p>
                        <div class="status">
                            <span class="fromName">emil</span>
                            <span class="fromString">Done</span>
                            <span class="to">TO</span>
                            <span class="toSting">Reopened</span>
                            <span class="toName">Alexi</span>
                            <span></span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="layui-col-md6">
                <h2>DONE</h2>
                <ul id="done-list">
                    <li class="layui-anim layui-anim-upbit">
                    <p class="name">Seeking Dawn</p>
                    <p class="summary">SD 777: 呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵</p>
                    <div class="status">
                        <span class="fromName">emil</span>
                        <span class="fromString">Done</span>
                        <span class="to">TO</span>
                        <span class="toSting">Reopened</span>
                        <span class="toName">Alexi</span>
                        <span></span>
                    </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <audio src="" id="audio"></audio>
    </body>
    <script src="/js/jQuery-3.2.1.min.js"></script>
    <script src="/layui/layui.all.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('2ef9566826373100cc30', {
            cluster: 'us2',
            encrypted: true
        });
        var reopened = document.getElementById('reopened-list');
        var channel = pusher.subscribe('my-channel');
        var x = document.getElementById("audio");
        channel.bind('my-event', function(data) {
            x.src = data.voiceUrl;
            x.play();
            /*var html = `
            <li class="layui-anim layui-anim-upbit">
            <p class="name">`+data.project_name+`</p>
            <p class="summary">`+data.summary+`</p>
            <div class="status">
                <span class="fromName">`+data.user_name+`</span>
                <span class="fromString">`+data.fromString+`</span>
                <span class="to">TO</span>
                <span class="toSting">`+data.toString+`</span>
                <span class="toName">data.reporter_name</span>
                <span></span>
            </div>
            </li>
        `;*/
            if (data.toString == 'Done'){
                $("#done-list").prepend(`
                  <li class="layui-anim layui-anim-upbit">
                    <p class="name">`+data.projectName+`</p>
                    <p class="summary">`+data.issueKey+`: `+data.summary+`</p>
                    <div class="status">
                        <span class="fromName">`+data.userName+`</span>
                        <span class="fromString">`+data.fromString+`</span>
                        <span class="to">TO</span>
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
                        <span class="to">TO</span>
                        <span class="toSting">`+data.toString+`</span>
                        <span class="toName">`+data.assignee_name+`</span>
                        <span></span>
                    </div>
                </li>
                `);
            }
        });

    </script>
</html>
