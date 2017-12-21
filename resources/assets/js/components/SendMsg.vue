<template>
    <div class="layui-container">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label" >Message</label>
                <div class="layui-input-block">
                    <textarea name="text" placeholder="Enter text" class="layui-textarea" required v-model="text"> </textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit v-on:click="sendMsg('English')" >send</button>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">文本(text)</label>
                <div class="layui-input-block">
                    <textarea name="text" placeholder="请输入内容" class="layui-textarea" required v-model="cnText"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit  v-on:click="sendMsg('Chinese')">发送</button>
                </div>
            </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('SendMsg Component mounted.')
        },
        data(){
          return {
            text:'',
            cnText:''
          }
        },
        methods:{
            sendMsg(lang){
                let _this = this
                let text = ''
                if (lang=='English'){
                    text = _this.text
                }
                if (lang=='Chinese'){
                    text = _this.cnText
                }
                if (text==''||text==null){
                    layer.msg('内容不能为空')
                }else{
                    axios.post('/sendMsg',{
                        lang:lang,
                        text:text
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
    }
</script>
