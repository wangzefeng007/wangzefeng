var ran;
$(function(){
  //第一步提交
  $('#step_1_next').click(function(){
    var phoneNumber = $('input[name="oldPhoneNumber"]').val();
    var code = $('input[name="code1"]').val();
    //原手机号
    if(phoneNumber == '' || !validate("mobilePhone", phoneNumber)){
      showMsg('不能修改原始手机号');
      return;
    }
    //验证码
    if(code.length < 4 || !validate("+number", code)){
      showMsg('验证码为4位数字');
      return;
    }

    $.ajax({
      type: 'post',
      dataType: 'json',
      url: '/loginajax.html',
      data: {
        "Intention":"ChangeMobileFirst",//修改绑定手机发送验证码
        "phoneNumber": phoneNumber,
        "code": code
      },
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          //后端返回一个随机数
          ran = data.Random;
          //进入第二步
          $('#step_1').hide();
          $('#step_2').show();

          $('.step-wrap').eq(1).children('.step').addClass('step-act');
          $('.step-wrap').eq(1).children('.step-tri').addClass('step-tri-act');
          $('.step-wrap').eq(1).children('.step-tri-pre').addClass('step-tri-pre-act');

        }else{
          showMsg(data.Message);
        }
      },
      complete: function(){
        closeLoading();
      }
    });

  });
  //第二步提交
  $('#step_2_next').click(function(){
    var phoneNumber = $('input[name="newPhoneNumber"]').val();
    var code = $('input[name="code2"]').val();
    //后端返回随机数验证
    if(!ran){
      showMsg('验证手机失败，请重新验证');
      return;
    }
    //新手机号
    if(phoneNumber == ''){
      showMsg('请输入手机号');
      return;
    }
    if(!validate("mobilePhone", phoneNumber)){
      showMsg('请输入正确的号码');
      return;
    }
    //验证码
    if(code.length < 4 || !validate("+number", code)){
      showMsg('验证码为4位数字');
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
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          //进入完成
          $('#step_2').hide();
          $('#step_3').show();

          $('.step-wrap').eq(2).children('.step').addClass('step-act');
          $('.step-wrap').eq(2).children('.step-tri-pre').addClass('step-tri-pre-act');
          $('#bind_phone').html(data.Mobile);

        }else{
          showMsg(data.Message);
        }
      },
      complete: function(){
        closeLoading();
      }
    });
  });
});

//验证验证码
function validateCode(tar){
  var text = $(tar).val();
  if(text == ''){
    showTip(tar, '请输入');
    return;
  }
  if(text.length < 4 || !validate("+number", text)){
    showTip(tar, '验证码输入有误');
    return;
  }
}

//获取验证码
function getCode(tar, inp){
  var _phoneNumber = $("input[name='" + inp + "']").val();
  if(inp == 'newPhoneNumber'){
    if(!ran){
      showMsg('验证手机失败，请重新验证');
      return;
    }
  }
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
      "Intention":"ChangeMobileCode",//修改绑定手机发送验证码
      "phoneNumber": _phoneNumber
    },
    success: function(data){
      if(data.ResultCode == 200){
        showMsg('短信发送成功');
        codeTimedown(tar);
      }else{
        showMsg(data.Message);
      }
    }
  });
}
