var ran;
var pageObj=$.extend({},pageObj,{
    /**
     * 第一步原手机号码验证
     * @returns {*}
     */
    validateForm:function(){
        var _phoneNumber = $("input[name='oldPhoneNumber']").val();
        var _code = $("input[name='code1']").val();
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

    /**
     * 第一步点击更换手机号
     */
    goStepTwo:function(){
        $("#stepOne").removeClass("page-current");
        $("#stepTwo").addClass("page-current");
    },
    //获取验证码
    getCode:function(tar, inp){
        var _phoneNumber = $("input[name='" + inp + "']").val();
        if(inp == 'newPhoneNumber'){
            if(!ran){
                $.toast('验证手机失败，请重新验证');
                return;
            }
        }
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
     * 第二步点下一步
     */
    goStepThree:function(){
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
                    ran = data.Random;
                    $("#stepTwo").removeClass("page-current");
                    $("#stepThree").addClass("page-current");
                }else{
                    $.toast(data.Message);
                }
            }
        });
    },

    /**
     * 第三部点击完成
     */
    goStepOver:function(){
        var phoneNumber = $('input[name="newPhoneNumber"]').val();
        var code = $('input[name="code2"]').val();
        //后端返回随机数验证
        if(!ran){
            $.toast('验证手机失败，请重新验证');
            return;
        }
        //新手机号
        if(phoneNumber == ''){
            $.toast('请输入手机号');
            return;
        }
        if(!validate("mobilePhone", phoneNumber)){
            $.toast('请输入正确的号码');
            return;
        }
        //验证码
        if(code.length < 4 || !validate("+number", code)){
            $.toast('验证码为4位数字');
            return;
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: {
                "Intention":"ChangeMobileSecond",//修改绑定手机
                "phoneNumber": phoneNumber,
                "code": code,
                "random": ran
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    setTimeout(function(){
                        go("/member/setting/");
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
        //隐藏手机号
        $(".phone").mobileHide();
        //更换手机到第二步
        $("#goStepTwo").on("click",function(){
            _this.goStepTwo();
        });

        //下一步到第三步
        $("#goStepThree").on("click",function(){
            _this.goStepThree();
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