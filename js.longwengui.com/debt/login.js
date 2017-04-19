times = getCookie('PasswordErrTimes');
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
  var _phoneNumber = $("#login input[name='phoneNumber']").val();
  var _pass = $("#login input[name='pass']").val();
  var _code;

  if($('#code').attr('data-show') == 1 && getCookie('PasswordErrTimes') >= 3){
    _code = $("input[name='code']").val();
  }

  if(_phoneNumber == ''){
    $('#login input[name="phoneNumber"]').parent().siblings('.error-hint').eq(0).show();
    return false;
  }
  if(!validate("mobilePhone", _phoneNumber)){
    $('#login input[name="phoneNumber"]').parent().siblings('.error-hint').eq(1).show();
    return false;
  }

  if(_pass == ''){
  $('#login input[name="pass"]').parent().siblings('.error-hint').eq(0).show();
    return false;
  }
  if(_pass.length < 6){
    $('#login input[name="pass"]').parent().siblings('.error-hint').eq(1).show();
    return false;
  }

  if(!validate('password', _pass)){
    $('#login input[name="pass"]').parent().siblings('.error-hint').eq(2).show();
    return false;
  }

  if(_code && _code == ''){
    showMsg('请输入验证码');
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
          //路由跳转
            setTimeout(function() {
                location.reload();
            }, 10);
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
