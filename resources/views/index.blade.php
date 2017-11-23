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
                <h2 class="reopened-title">-REOPENED</h2>
                <ul id="reopened-list">
                    {{--<li class="layui-anim layui-anim-upbit">
                        <div class="project"><div class="key fl">SD128:</div><div class="summary fl">呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵</div></div>
                        <div class="status">
                            <span class="fromName">Emil Wong</span>
                            <span class="to">TO:</span>
                            <span class="toName">Alexis</span>
                            <span></span>
                        </div>
                        <div class="project_key">SD</div>
                    </li>--}}
                </ul>
            </div>
            <div class="layui-col-md5">
                <h2 class="done-title">-DONE</h2>
                <ul id="done-list">
                    {{--<li class="layui-anim layui-anim-upbit">
                        <div class="project"><div class="key fl">SD128:</div><div class="summary fl">呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵呵</div></div>
                        --}}{{--<span  class="name">SeekingDawn</span>--}}{{--
                        <div class="status">
                            <span class="fromName">Emil Wong</span>
                            <span class="to">TO:</span>
                            <span class="toName">Alexis</span>
                            <span></span>
                        </div>
                        <div class="project_key">SD</div>
                    </li>--}}
                </ul>
            </div>
            <div class="layui-col-md2">
                <h2 class="builds-title">-BUILDS</h2>
                <ul id="build-project-area">
{{--                    <li class="success">
                        <p class="project-name">data.projectName</p>
                        <p class="event">data.buildName<span class="status">successful.</span></p>
                    </li>
                    <li class="failure">
                        <p class="project-name">data.projectName</p>
                        <p class="event">data.buildName <span class="status">failed.</span></p>
                    </li>--}}
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
        // “()()”表示自执行函数
        (function (doc, win) {
            var docEl = doc.documentElement,
                // 手机旋转事件,大部分手机浏览器都支持 onorientationchange 如果不支持，可以使用原始的 resize
                resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
                recalc = function () {
                    //clientWidth: 获取对象可见内容的宽度，不包括滚动条，不包括边框
                    var clientWidth = docEl.clientWidth;
                    if (!clientWidth) return;
                    docEl.style.fontSize = 10*(clientWidth / 320) + 'px';
                };

            recalc();
            //判断是否支持监听事件 ，不支持则停止
            if (!doc.addEventListener) return;
            //注册翻转事件
            win.addEventListener(resizeEvt, recalc, false);

        })(document, window);
    </script>
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
    </script>
</html>
