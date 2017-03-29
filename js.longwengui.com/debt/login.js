var times;
//失去焦点时表单验证
function validateErr(type, tar){
  $('.error-hint').hide();
  var text = $(tar).val();
  var err_hint = $(tar).parent().siblings('.error-hint');
  switch (type) {
    case "phoneNumber":
      if(text == ''){
        err_hint.eq(0).show();
        return;
      }
      if(!validate("mobilePhone", text)){
        err_hint.eq(1).show();
        return;
      }
      break;
    case "pass":
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
    case "code":
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
  var _phoneNumber = $("input[name='phoneNumber']").val();
  var _pass = $("input[name='pass']").val();
  var _code;

  if($('#code').attr('data-show') == 1 && getCookie('PasswordErrTimes') == 3){
    _code = $("input[name='code']").val();
  }

  if(_code && _code == ''){
    showMsg('请输入验证码');
    return;
  }

  if(_phoneNumber == ''){
    showMsg('请填写手机号');
    return false;
  }

  if(_pass == ''){
    showMsg('请填写登录密码');
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

  return {
    "phoneNumber": _phoneNumber,
    "password": _pass,
    "ImageCode": _code
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
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
            layer.msg("登录成功");
            setTimeout(function() {
                window.location = data.Url;
            }, 10);
          //路由跳转
        }else{
            layer.msg(data.Message);
            times = getCookie('PasswordErrTimes');
          if($('#code').attr('data-show') == 0 && times == 3){
            $('#code').show();
            $('#code').attr('data-show', 1);
          }
        }
      },
      complete: function(){
        closeLoading();
      }
    }
  )
}
