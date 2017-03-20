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
    default:
      return;
  }
}

//提交表单前验证
function validateForm(){
  var _phoneNumber = $("input[name='phoneNumber']").val();
  var _pass = $("input[name='pass']").val();

  if(_phoneNumber == '' || _pass == ''){
    showMsg('请完善登录信息');
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
    "password": _pass
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
      type: "get",
      dataType: "json",
      url: "../data/login.json",
      data: JSON.stringify(formData),
      beforeSend:　function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('登录成功');
          //路由跳转
        }else{
          showMsg(data.Message);
        }
      },
      complete: function(){
        closeLoading();
      }
    }
  )
}
