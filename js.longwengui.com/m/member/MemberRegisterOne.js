var pageObj=$.extend({},pageObj,{
    /**
     * 获取验证码
     */
    getCode:function(tar){
        var _phoneNumber = $("input[name='phoneNumber']").val();
        if(_phoneNumber == ''){
            $.toast('请先填写手机号');
            return false;
        }
        if(!validate("mobilePhone", _phoneNumber)){
            $.toast('请填写正确的号码');
            return false;
        }
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: {
                "Intention":"RegisterSendCode",
                "phoneNumber": _phoneNumber
            },
            success: function(data){
                if(data.ResultCode == 200){
                    codeTimedown(tar);
                    $.toast('短信发送成功');
                }else{
                    $.toast(data.Message);
                }
            }
        });
    },
    /**
     * 点击下一步
     */
    registerNext:function(){
        var formData = this.validateForm();
        if(!formData){
            return;
        }
        formData.Intention=''; //设置Intention
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: formData,
            success: function(data){
                if(data.ResultCode == 200){
                    go("#MemberRegisterNext");
                }else{
                    $.toast(data.Message);
                }
            }
        });
    },
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
    /**
     *初始化方法
     */
    init:function(){

    }
})
$(document).ready(function(){
    pageObj.init();
});