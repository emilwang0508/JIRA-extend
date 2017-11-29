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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.css" />
</head>
<body>
    <form action="/sendMsg" method="post" class="layui-form layui-container">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label" style="color: yellow">文本(text)</label>
            <div class="layui-input-block">
                <textarea name="text" placeholder="请输入内容" class="layui-textarea" required></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit >send</button>
            </div>
        </div>
    </form>
    <audio src="" id="audio"></audio>
</body>
<script src="/js/jQuery-3.2.1.min.js"></script>
<script src="/layui/layui.all.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

{{--    <!-- This following line is optional. Only necessary if you use the option css3:false and you want to use other easing effects rather than "linear", "swing" or "easeInOutCubic". -->
    <script src="vendors/jquery.easings.min.js"></script>--}}


<!-- This following line is only necessary in the case of using the option `scrollOverflow:true` -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/vendors/scrolloverflow.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.5/jquery.fullpage.js"></script>

<script>
    /*var audioPlay = new function (Src) {
        this.Src = array();
        this._audio = document.getElementById('audio');
        arrayPush(this.Src,Src)
        this.Src.forEach(function (e) {
            console.log(e)
        })
    }*/
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
                        <div class="project"><div class="key fl">`+data.issueKey+`:</div><div class="summary fl">`+data.summary+`</div></div>
                        <div class="status">
                            <span class="fromName">`+data.userName+`</span>
                            <span class="to">TO:</span>
                            <span class="toName">`+data.reporterName+`</span>
                        </div>
                        <div class="project_key">`+data.projectKey+`</div>
                    </li>
                `);
        }
        if (data.toString == 'Reopened'){
            $("#reopened-list").prepend(`

                    <li class="layui-anim layui-anim-upbit">
                        <div class="project"><div class="key fl">`+data.issueKey+`:</div><div class="summary fl">`+data.summary+`</div></div>
                        <div class="status">
                            <span class="fromName">`+data.userName+`</span>
                            <span class="to">TO:</span>
                            <span class="toName">`+data.assigneeName+`</span>
                        </div>
                        <div class="project_key">`+data.projectKey+`</div>
                    </li>
                `);
        }
    });
    channel.bind('build-project-event', function(data){
        x.src = data.voiceUrl;
        x.play();
        if(data.event == 'success'){
            $("#build-project-area").prepend(`
                    <li class="success">
                        <p class="project-name">`+data.projectName+`</p>
                        <p class="event">`+data.buildName+`<span class="status">successful</span></p>
                    </li>
                `)
        }else if(data.event == 'failure'){
            $("#build-project-area").prepend(`
                    <li class="failure">
                        <p class="project-name">`+data.projectName+`</p>
                        <p class="event">`+data.buildName+`<span class="status">failed</span></p>
                    </li>
                `)
        }
    })
    //打卡事件
    channel.bind('punch-event', function(data){
        x.src = data.voiceUrl;
        x.play();
    })
    //
    channel.bind('play-voice-event', function(data){
        x.src = data.voiceUrl;
        x.play();
    })
    // am10 event
    channel.bind('am10checked-event', function(data){
        x.src = data.voiceUrl;
        x.play();
        var string = '';
        for (var i in data.name){
            string += '<li class="layui-col-md6">'+ i +'</li>'
        }
        $("#am").append(string);
    })
    // pm5:30 event
    channel.bind('done-issue-checked-event', function(data){
        x.src = data.voiceUrl;
        x.play();
        var string = '';
        for (var i in data.name){
            string += '<li class="layui-col-md6">'+ i +'</li>'
        }
        $("#pm").append(string);
    })
</script>
<script>
    $(document).ready(function() {
        $('#fullpage').fullpage({
            //Navigation
            menu: '#menu',
            lockAnchors: false,
            anchors:['firstPage', 'secondPage'],
            navigation: false,
            navigationPosition: 'right',
            navigationTooltips: ['firstSlide', 'secondSlide'],
            showActiveTooltip: false,
            slidesNavigation: false,
            slidesNavPosition: 'bottom',
            verticalCentered:false,
            setAutoScrolling: true,
            scrollOverflow: true
        });
    });
</script>
</html>
