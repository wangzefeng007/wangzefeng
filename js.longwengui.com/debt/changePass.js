$(function(){
  //修改提交
  $('#change_pass').click(function(){
    var old_pass = $('input[name="oldPass"]').val();
    var new_pass = $('input[name="newPass"]').val();
    var comfirm_pass = $('input[name="comfirmPass"]').val();

    if(!validatePass($('input[name="oldPass"]'))){
      return;
    }
    if(!validatePass($('input[name="newPass"]'))){
      return;
    }
    if(!validateComfirmPass()){
      return;
    }

    if(old_pass == new_pass){
      showMsg('新密码不能和旧密码相同');
      return;
    }

    $.ajax({
      type: 'get',
      url: '/Templates/Debt/data/changePass.json',
      dataType: "json",
      data: JSON.stringify({
        "oldPass": old_pass, //旧密码
        "newPass": new_pass  //新密码
      }),
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('修改成功');
          //路由跳转

        }
      },
      complete: function(){
        closeLoading();
      }
    });
  });
});

//验证密码输入
function validatePass(tar){
  $('.error-hint').hide();
  var text = $(tar).val();
  var err_hint = $(tar).siblings('.error-hint');

  if(text == ''){
    err_hint.eq(0).show();
    return false;
  }
  if(text.length < 6){
    err_hint.eq(1).show();
    return false;
  }
  if(!validate('password', text)){
    err_hint.eq(2).show();
    return false;
  }
  return true;
}

//验证确认密码
function validateComfirmPass(){
  $('.error-hint').hide();
  var new_pass = $('input[name="newPass"]').val();
  var comfirm_pass = $('input[name="comfirmPass"]').val();
  var err_hint = $('input[name="comfirmPass"]').siblings('.error-hint');
  if(new_pass != comfirm_pass){
    err_hint.eq(0).show();
    return false;
  }
  return true;
}
