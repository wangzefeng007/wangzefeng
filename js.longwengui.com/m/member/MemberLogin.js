times = getCookie('PasswordErrTimes'); //判断是否重复错误登录3次，如果是则需要添加验证码
if($('#code').attr('data-show') == 0 && times >= 3){
    $('#code').show();
    $('#code').attr('data-show', 1);
}
//失去焦点时表单验证
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
        case "code": //验证验证码
            if(text == ''){
                err_hint.eq(0).show();
                return;
            }
        default:
            return;
    }
}

//提交表单前验证
function validateForm(){
    var _phoneNumber = $("#login input[name='phoneNumber']").val();
    var _pass = $("#login input[name='pass']").val();
    var _code;

    if($('#code').attr('data-show') == 1 && getCookie('PasswordErrTimes') >= 3){
        _code = $("input[name='code']").val();
    }

    if(_phoneNumber == ''){
        $.toast("请输入手机号！");
        return false;
    }
    if(!validate("mobilePhone", _phoneNumber)){
        $.toast("您输入的手机号有误！");
        return false;
    }

    if(_pass == ''){
        $.toast("请输入密码!");
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

    if(_code && _code == ''){
        $.toast("请输入验证码！");
        return false;
    }

    return {
        "phoneNumber": _phoneNumber, //手机号
        "password": _pass, //密码
        "ImageCode": _code //图片验证码
    }
}

//登录表单
function login(){
    var formData = validateForm();
    if(!formData){
        return;
    }
    $.ajax(
        {
            type: "post",
            dataType: "json",
            url: "/loginajax.html",
            data: {
                "Intention":"Login",
                "AjaxJSON":JSON.stringify(formData),
            },
            beforeSend:　function(){
                $.showIndicator();
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast("登录成功");
                    //路由跳转
                    setTimeout(function() {
                        location.reload();
                    }, 10);
                }else{
                    $.toast(data.Message);
                    times = getCookie('PasswordErrTimes');
                    if($('#code').attr('data-show') == 0 && times == 3){
                        $('#code').show();
                        $('#code').attr('data-show', 1);
                    }
                }
            },
            complete: function(){
                $.hideIndicator();
            }
        }
    )
}
