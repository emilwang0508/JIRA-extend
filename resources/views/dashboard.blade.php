<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>JIRA Extend</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/layui/css/layui.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.css" />
    <style>
        .dashboard .home-btn{
            font-size: 50px;
        }
    </style>
</head>
<body style="background-color: #eeeeee">
    <div id="app">
        <dash></dash>
        <send-msg style="margin-top: 100px"></send-msg>
        <dict style="margin: 50px auto"></dict>
    </div>
</body>
<script src="/js/jQuery-3.2.1.min.js"></script>
<script src="/layui/layui.all.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>

{{--    <!-- This following line is optional. Only necessary if you use the option css3:false and you want to use other easing effects rather than "linear", "swing" or "easeInOutCubic". -->
    <script src="vendors/jquery.easings.min.js"></script>--}}


<!-- This following line is only necessary in the case of using the option `scrollOverflow:true` -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/vendors/scrolloverflow.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.js"></script>

<script>

</script>
</html>
