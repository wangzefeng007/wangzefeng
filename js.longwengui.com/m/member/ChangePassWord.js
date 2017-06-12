var pageObj=$.extend({},pageObj,{
    //验证密码输入
    validatePass:function(tar){
        var text = $(tar).val();
        if(text == ''){
            if($(tar).hasClass("new-pass")){
                $.toast("请输入新密码");
            }else{
                $.toast("请输入密码");
            }
            return false;
        }
        if(text.length < 6){
            $.toast("密码不能少于6位");
            return false;
        }
        if(!validate('password', text)){
            $.toast("密码为6-20位数字、字母、下划线");
            return false;
        }
        return true;
    },

    //验证确认密码
    validateComfirmPass:function(){
        var new_pass = $('input[name="newPass"]').val();
        var comfirm_pass = $('input[name="comfirmPass"]').val();
        if(new_pass != comfirm_pass){
            $.toast("两次密码输入不一致");
            return false;
        }
        return true;
    },
    /**
     * 修改密码提交
     */
    changePass:function(){
        var old_pass = $('input[name="oldPass"]').val(); //旧密码
        var new_pass = $('input[name="newPass"]').val(); //新密码
        var comfirm_pass = $('input[name="comfirmPass"]').val(); //确认密码

        if(!this.validatePass($('input[name="oldPass"]'))){
            return;
        }
        if(!this.validatePass($('input[name="newPass"]'))){
            return;
        }
        if(!this.validateComfirmPass()){
            return;
        }

        if(old_pass == new_pass){
            $.toast('新密码不能和旧密码相同');
            return;
        }

        $.ajax({
            type: 'post',
            url: '/loginajax.html',
            dataType: "json",
            data: {
                "Intention": "ChangePassword", //修改密码
                "oldPass": old_pass, //旧密码
                "newPass": new_pass  //新密码
            },
            beforeSend: function(){
                $.showIndicator();
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast('修改成功');
                    //路由跳转
                    setTimeout(function() {
                        window.location = data.Url;
                    }, 10);
                }else {
                    $.toast(data.Message);
                }
            },
            complete: function(){
                $.hideIndicator();
            }
        });
    },
    /**
     * 初始化方法
     */
    init:function(){
        var _this=this;
        $("#change_pass").on("click",function(){
            _this.changePass();
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});
