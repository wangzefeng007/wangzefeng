//重置密码

//失去焦点时验证
function validateErr(type, tar){
    $('.error-hint').hide();
    var text = $(tar).val();
    var err_hint = $(tar).parent().siblings('.error-hint');
    switch (type) {
        case "phoneNumber": //验证手机号
            if(text == ''){
                err_hint.eq(0).show();
                return;
            }
            if(!validate("mobilePhone", text)){
                err_hint.eq(1).show();
                return;
            }
            break;
        case "pass": //验证密码
            if(text == ''){
                err_hint.eq(0).show();
                return;
            }
            if(text.length < 6){
                err_hint.eq(1).show();
                return;
            }
            if(!validate('password', text)){
                err_hint.eq(2).show();
                return;
            }
            break;
        case "confirm": //确认密码
            var _pass = $('input[name="pass"]').val();
            if(text != _pass){
                err_hint.eq(0).show();
                return;
            }
            break;
        case "code": //验证手机验证码
            if(text == ''){
                err_hint.eq(0).show();
                return;
            }
            if(text.length < 4 || !validate("+number", text)){
                err_hint.eq(1).show();
                return;
            }
            break;
        default:
            return;
    }
}

//提交前表单验证
function validateForm(){
    var _phoneNumber = $("input[name='phoneNumber']").val();
    var _pass = $("input[name='pass']").val();
    var _confirmPass = $("input[name='confirmPass']").val();
    var _code = $("input[name='code']").val();

    if(_phoneNumber == '' || _pass == '' || _confirmPass == '' || _code == ''){
        showMsg('请完善重置密码信息');
        return false;
    }

    if(!validate("mobilePhone", _phoneNumber)){
        $('input[name="phoneNumber"]').parent().siblings('.error-hint').eq(1).show();
        return false;
    }

    if(_pass.length < 6){
        $('input[name="pass"]').parent().siblings('.error-hint').eq(1).show();
        return false;
    }

    if(!validate('password', _pass)){
        $('input[name="pass"]').parent().siblings('.error-hint').eq(2).show();
        return false;
    }

    if(_confirmPass != _pass){
        $('input[name="confirmPass"]').parent().siblings('.error-hint').eq(0).show();
        return false;
    }

    if(_code.length < 4 || !validate("+number", _code)){
        $('input[name="code"]').parent().siblings('.error-hint').eq(1).show();
        return false;
    }

    return {
        "phoneNumber": _phoneNumber, //手机号
        "password": _pass, //密码
        "Code": _code //验证码
    }
}

//重置密码表单提交
function reset(){
    var formData = validateForm();
    if(!formData){
        return;
    }
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/loginajax.html",
        data: {
            "Intention":"RetrievePassword",
             "AjaxJSON":JSON.stringify(formData),
        },
        beforeSend:　function(){
            showLoading();
        },
        success: function(data){
            if(data.ResultCode == 200){
                showMsg('重置成功');
                //重置成功跳转登录页面
                setTimeout(function() {
                    window.location = data.Url;
                }, 10);
            }else{
                showMsg(data.Message);
            }
        },
        complete: function(){
            closeLoading();
        }
    });
}

//获取验证码
function getCode(tar){
    var _phoneNumber = $("input[name='phoneNumber']").val();
    if(_phoneNumber == ''){
        showMsg('请先填写手机号');
        return;
    }
    if(!validate("mobilePhone", _phoneNumber)){
        showMsg('请填写正确的号码');
        return;
    }

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
            "Intention":"RegisterVerifyCode",
            "phoneNumber": _phoneNumber
        },
        success: function(data){
            if(data.ResultCode == 200){
                codeTimedown(tar);
                showMsg('短信发送成功');
            }else{
                showMsg(data.Message);
            }
        }
    });
}
