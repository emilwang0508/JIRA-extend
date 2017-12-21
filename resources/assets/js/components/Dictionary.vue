<template>
        <div class="layui-container">
            <h2 style="margin-top: 50px;text-align: center;font-size: 1.8rem">用户词典</h2>
            <div class="text-center">

                <table class="layui-table excel">
                    <colgroup>
                        <col width="150">
                        <col width="200">
                        <col width="20">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>昵称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(v, k) in partners">
                        <td><input type="text" class="layui-input-block" v-model="v.key"></td>
                        <td><input type="text" class="layui-input-block"  v-model="v.value"></td>
                        <td><div class="layui-icon" v-on:click="deleteDictionary(k)">&#xe640;</div></td>
                    </tr>
                    </tbody>

                </table>
                <button class="layui-btn" lay-submit lay-filter="formDemo" v-on:click="saveDictionary()">保存当前用户词典</button>
                <button class="layui-btn" lay-submit lay-filter="formDemo" v-on:click="addDictionary()">增加</button>
            </div>
        </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Dashboard Component mounted.')
            let _this = this
            axios.get('/getDictionary')
                .then(function(res){
                    console.log(res.data)
                    _this.partners = res.data
                })
                .catch(function(err){
                    console.log(err);
                })
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
            saveDictionary(){
                let url = '/saveDictionary';
                let _this = this
                let res  = _this.partners.filter(function (e) {
                    if(e.key===null||e.key===''||e.value===null||e.value===''){
                        return true
                    }else {
                        return false
                    }
                })
                console.log(res)
                if (res.length===0){
                    axios.post(url,{
                        param:_this.partners
                    })
                        .then(function(res){
                            if(res.data>0){
                                layer.msg('保存成功！！！')
                            }
                        })
                        .catch(function(err){
                            console.log(err);
                        })
                }else{
                    layer.msg('不要保存空值')
                }

            },
            addDictionary(){
                let item  = {};
                item.key = '';
                item.value = '';
                this.partners.push(item)
                console.log(this.partners)
            },
            deleteDictionary(e){
                this.partners.splice(e,1)
            }
        }
    }
</script>
