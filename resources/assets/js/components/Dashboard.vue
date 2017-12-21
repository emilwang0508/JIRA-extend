<template>
    <div class="layui-container dashboard">
        <h1 style="text-align: center;margin: 50px">Jira Dashboard</h1>
        <div class="text-center">
            <div class="layui-btn-group ">
                <button class="layui-btn layui-btn-lg"  v-on:click="goHome()">
                    <i class="layui-icon">&#xe68e;</i>
                </button>
                <button class="layui-btn layui-btn-lg" v-on:click="goLeft()" >
                    <i class="layui-icon">&#xe65a;</i>
                </button>
                <button class="layui-btn layui-btn-lg" v-on:click="goRight()" >
                    <i class="layui-icon">&#xe65b;</i>
                </button>
                <button class="layui-btn layui-btn-lg" v-on:click="goPre()" >
                    <i class="layui-icon">&#xe619;</i>
                </button>
                <button class="layui-btn layui-btn-lg" v-on:click="goNext()" >
                    <i class="layui-icon">&#xe61a;</i>
                </button>
                <button class="layui-btn layui-btn-lg " v-on:click="reload()" >
                    <i class="layui-icon">&#x1002;</i>
                </button>
            </div>
        </div>
        <div class="">
            <h3 style="margin-top: 50px">用户词典</h3>
            <div class="text-center">

                <table class="layui-table excel">
                    <colgroup>
                        <col width="150">
                        <col width="200">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>昵称</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="p in partners">
                        <td><input type="text" class="layui-input-block" v-model="p.key"></td>
                        <td><input type="text" class="layui-input-block"  v-model="p.value"></td>
                    </tr>
                    </tbody>

                </table>
                <button class="layui-btn" lay-submit lay-filter="formDemo" v-on:click="saveDictionary()">保存当前用户词典</button>
                <button class="layui-btn" lay-submit lay-filter="formDemo" v-on:click="menuEvent()">测试</button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Dashboard Component mounted.')
        },
        data(){
            return {
              partners:[
                  {key:"EmilWong",value:"Emil"},
                  {key:"Alexis",value:"Alexis"}
              ]
            }
        },
        methods:{
            reload(){
                let _this = this
                layer.open({
                    title:"",
                    content:"确定刷新吗？刷新后屏幕会被清除！！！",
                    btn:['确定','以后再说'],
                    yes:function (index) {
                        layer.close(index);
                        _this.menuEvent('ClickReloadBtn')
                    }
                })
            },
            goHome(){
                let _this = this
                layer.open({
                    title:"",
                    content:"确定回到首屏吗？",
                    btn:['确定','以后再说'],
                    yes:function (index) {
                        layer.close(index);
                        _this.menuEvent('ClickHomeBtn')
                    }
                })
            },
            goNext(){
                let _this = this
                layer.msg('Success!!!')
                _this.menuEvent('ClickNextBtn')
            },
            goPre(){
                let _this = this
                _this.menuEvent('ClickPreviousBtn')
                layer.msg('Success!!!')

            },
            goRight(){
                let _this = this
                _this.menuEvent('ClickRightBtn')
                layer.msg('Success!!!')
            },
            goLeft(){
                let _this = this
                _this.menuEvent('ClickLeftBtn')
                layer.msg('Success!!!')
            },
            saveDictionary(){
                let url = '/saveDictionary';
                let _this = this
                axios.post(url,{
                    param:_this.partners
                })
                    .then(function(res){
                        console.log(res);
                    })
                    .catch(function(err){
                        console.log(err);
                    })
            },
            menuEvent(event){
                let url = '/menuEvent';
                let _this = this
                let data = []
                axios.post(url,{
                        event: event
                    })
                    .then(function(res){
                        console.log(res);
                    })
                    .catch(function(err){
                        console.log(err);
                    })
            }
        }
    }
</script>
