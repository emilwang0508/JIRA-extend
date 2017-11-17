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
    </head>
    <body>
        <h1>JIRA任务语音播报</h1>
        <div id="result"></div>
        <audio src="" id="audio"></audio>
    </body>
    <script src="/layui/layui.all.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('2ef9566826373100cc30', {
            cluster: 'us2',
            encrypted: true
        });

        var channel = pusher.subscribe('my-channel');
        var x = document.getElementById("audio");
        channel.bind('my-event', function(data) {
            x.src = data.voiceUrl;
            x.play();
            layer.msg(data.message,{
                offset:'t',
                anim: 6
            });
        });

    </script>
</html>
