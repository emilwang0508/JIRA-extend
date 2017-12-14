<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JIRA Extend</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="/layui/css/layui.css">
        <link rel="stylesheet" href="{{  mix('css/app.css') }}">
        <link rel="stylesheet" type="text/css" href="/fullpage/jquery.fullpage.css" />
    </head>
    <body>
    <div id="fullpage">
        <div class="section">
            <div class="slide">
                <div class="layui-row">
                    <div class="layui-col-md5">
                        <h2 class="reopened-title">-REOPENED</h2>
                        <ul id="reopened-list">

                        </ul>
                    </div>
                    <div class="layui-col-md5">
                        <h2 class="done-title">-DONE</h2>
                        <ul id="done-list">

                        </ul>
                    </div>
                    <div class="layui-col-md2">
                        <h2 class="builds-title">-BUILDS</h2>
                        <ul id="build-project-area">

                        </ul>
                    </div>
                </div>
            </div>
            <div class="slide">
                <div id="amEvent" class="layui-col-md6">
                    <p class="title" id="amEventTilte">需要加快进度</p>
                    <ul  id="am">

                    </ul>
                </div>
                <div id="pmEvent" class="layui-col-md6">
                    <p class="title" id="pmEventTilte">需要验收任务</p>
                    <ul id="pm" >
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <audio id="audio" autoplay></audio>
    </body>
    <script src="/js/jQuery-3.2.1.min.js"></script>
    <script src="/layui/layui.all.js"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>

{{--    <!-- This following line is optional. Only necessary if you use the option css3:false and you want to use other easing effects rather than "linear", "swing" or "easeInOutCubic". -->
    <script src="vendors/jquery.easings.min.js"></script>--}}


    <!-- This following line is only necessary in the case of using the option `scrollOverflow:true` -->
    <script type="text/javascript" src="/fullpage/scrolloverflow.min.js"></script>

    <script type="text/javascript" src="/fullpage/jquery.fullpage.js"></script>
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
        //定义一个数组

        var _index = 0;
        var arr = []
        var x = document.getElementById('audio')
        Array.prototype.removeByValue = function(val) {
            for(var i=0; i<this.length; i++) {
                if(this[i] == val) {
                    this.splice(i, 1);
                    break;
                }
            }
        }
        /*function playAudio() {
            if(x.ended === false){
                console.log(arr)
                x.src = arr[0];
                x.load()
            }
            if(x.ended === true){
                arr.removeByValue(arr[0])
            }
        }*/
        function playAudio(e) {
                console.log(e)
                x.src = e;
                x.load()
        }
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: 'us2',
            encrypted: true
        });
        var reopened = document.getElementById('reopened-list');
        var channel = pusher.subscribe('my-channel');

        channel.bind('my-event', function(data) {
            if (isIntime('10:00','10:30')||isIntime('17:30','18:00')){
                console.log('第二屏')
            }else {
                $.fn.fullpage.moveTo('#firstPage',0)
            }
            playAudio(data.voiceUrl);
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
            playAudio(data.voiceUrl);
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
//            arr.push(data.voiceUrl)
            playAudio(data.voiceUrl)
        })
        //
        channel.bind('play-voice-event', function(data){
            playAudio(data.voiceUrl);
        })
        // am10 event
        channel.bind('am10checked-event', function(data){
            playAudio(data.voiceUrl);
            var string = '';
            data.list.forEach(function (e) {
                string += '<li class="layui-col-md6"><img class="avatar" src="'+ e.avatar["48x48"] +'" alt="avatar" />'+ e.name +'</li>'
            })
            $("#am").html('')
            $("#am").append(string);
            var amInterval = setInterval(function(){   //定时器 10秒一执行
                $.fn.fullpage.moveSlideRight();  //向右侧滚动
            }, 10000);
            setTimeout(function () {
                clearInterval(amInterval)
                $.fn.fullpage.moveTo('#firstPage',0)
            },1800000)
        })
        // pm5:30 event
        channel.bind('done-issue-checked-event', function(data){
            playAudio(data.voiceUrl);
            var string = '';
            data.list.forEach(function (e) {
                string += '<li class="layui-col-md6"><img class="avatar" src="'+ e.avatar["48x48"] +'" alt="avatar" />'+ e.name +'</li>'
            })
            $("#pm").html('')
            $("#pm").append(string);
            var pmInterval = setInterval(function(){   //定时器 10秒一执行
                $.fn.fullpage.moveSlideRight();  //向右侧滚动
            }, 10000);
            setTimeout(function () {
                clearInterval(pmInterval)
                $.fn.fullpage.moveTo('#firstPage',0)
            },1800000)
        })
        // am0:00 event
        channel.bind('am0-event', function(data){
            if(data.event='locationReload'){
                window.location.reload()
            }
        })
        function isIntime(startTime,endTime) {
            let now = new Date();
            let year = now.getFullYear();//年
            let month = now.getMonth() + 1;//月
            let day = now.getDate();//日期

            let h = now.getHours();//时
            let m = now.getMinutes();//分

            let date = year + "-";
            if(month < 10)
                date += "0";

            date += month + "-";

            if(day < 10)
                date += "0";

            date += day + " ";

            if(h < 10)
                date += "0";

            date += h + ":";
            if (m < 10) date += '0';
            date += m;

            let startDate = year + '-' + month + '-' + day + ' ' + startTime;
            let endDate = year + '-' + month + '-' + day + ' ' + endTime;
            let timestamp  = new Date().valueOf();
            if (timestamp>(new Date(startDate)).valueOf()&&timestamp<(new Date(endDate)).valueOf()){
                return true;
            }else {
                return false;
            }
        }
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
                setAutoScrolling: false,
                scrollOverflow: true,
                setScrollingSpeed:10000,
                continuousVertical: true,
                loopHorizontal: true,
                controlArrowColor:'rgba(0,0,0,0)',
            });
        });
    </script>
</html>
