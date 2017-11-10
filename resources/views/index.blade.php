<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JIRA Extend</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    </head>
    <body>
        <h1>获得服务器更新</h1>
        <div id="result"></div>
    </body>
    <script>
        if(typeof(EventSource)!=="undefined")
        {
            var source=new EventSource("/server-sent");
            source.onmessage=function(event)
            {
                document.getElementById("result").innerHTML+=event.data + "<br />";
            };
        }
        else
        {
            document.getElementById("result").innerHTML="抱歉，您的浏览器不支持 server-sent 事件 ...";
        }
    </script>
</html>
