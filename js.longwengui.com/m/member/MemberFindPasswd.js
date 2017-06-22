var pageObj=$.extend({},pageObj,{
    /**
     * 第一步原手机号码验证
     * @returns {*}
     */
    validateForm:function(){
        var _phoneNumber = $("input[name='phoneNumber']").val();
        var _code = $("input[name='code']").val();
        if(_phoneNumber == ''){
            $.toast('请先填写手机号');
            return false;
        }
        if(!validate("mobilePhone", _phoneNumber)){
            $.toast('请填写正确的号码');
            return false;
        }
        if(_code == ''){
            $.toast('请输入验证码！');
            return false;
        }
        if(_code.length < 4 || !validate("+number", _code)){
            $.toast('您输入的验证码有误！');
            return false;
        }
        return {
            "phoneNumber":_phoneNumber,
            "code":_code
        };
    },
    //获取验证码
    getCode:function(tar, inp){
        if($(tar).hasClass("dis")){
            return;
        }
        var _phoneNumber = $("input[name='" + inp + "']").val();
        if(_phoneNumber == ''){
            $.toast('请先填写手机号');
            return;
        }
        if(!validate("mobilePhone", _phoneNumber)){
            $.toast('请填写正确的号码');
            return;
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: {
                "Intention":"ChangeMobileCode",//修改绑定手机发送验证码
                "phoneNumber": _phoneNumber
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast('短信发送成功');
                    codeTimedown(tar);
                }else{
                    $.toast(data.Message);
                }
            }
        });
    },

    /**
     * 点击下一步
     */
    goStep:function(){
        var formData = this.validateForm();
        if(!formData){
            return;
        }
        formData.Intention='ChangeMobileFirst'; //设置Intention
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: formData,
            success: function(data){
                if(data.ResultCode == 200){
                    //后端返回一个随机数
                    $("#firstStep").removeClass("page-current");
                    $("#nextStep").addClass("page-current");
                }else{
                    $.toast(data.Message);
                }
            }
        });
    },
    /**
     * 注册第二步设置密码
     * @returns {*}
     */
    validateForm2:function(){
        var _phoneNumber = $("input[name='phoneNumber']").val();
        var _pass = $("input[name='pass']").val();
        var _confirmPass = $("input[name='confirmPass']").val();
        var _agreement = $("input[name='agreement']")[0].checked;
        if(!_agreement){
            $.toast('您还没有同意服务协议');
            return false;
        }
        if(_pass==""){
            $.toast("请设置密码！");
            return false;
        }

        if(_pass.length < 6){
            $.toast("密码不能少于6位！");
            return false;
        }

        if(!validate('password', _pass)){
            $.toast("密码格式有误！");
            return false;
        }

        if(_confirmPass != _pass){
            $.toast("两次密码不一致！");
            return false;
        }
        return {
            "phoneNumber": _phoneNumber, //手机号
            "password": _pass, //密码
            "agreement": _agreement //同意协议
        };
    },

    /**
     * 第二步点击完成
     */
    goStepOver:function(){
        var formData = this.validateForm2();
        if(!formData){
            return;
        }
        formData.Intention="RetrievePassword";
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: formData,
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    setTimeout(function(){
                        go("/member/login/");
                    },500);
                }else{
                    $.toast(data.Message);
                }
            }
        });
    },

    /**
     *初始化方法
     */
    init:function(){
        var _this=this;

        //下一步
        $("#goStep").on("click",function(){
            _this.goStep();
        });
        //新手机绑定完成
        $("#goStepOver").on("click",function(){
            _this.goStepOver();
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});