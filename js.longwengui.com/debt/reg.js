//打开协议窗口
function openProtocalWindow(){
  $('.protocal-pop').show();
}

//关闭协议窗口
function closeProtocalWindow(){
  $('.protocal-pop').hide();
}

//同意协议
function agreeProtocal(){
  var _tar = $('.m-checkbox input[name="agreement"]')[0];
  _tar.checked = true;
  $('.protocal-pop').hide();
}

//失去焦点时验证
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
    case "confirm":
      var _pass = $('input[name="pass"]').val();
      if(text != _pass){
        err_hint.eq(0).show();
        return;
      }
      break;
    case "code":
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

//提交前的表单验证
function validateForm(){
  var _phoneNumber = $("input[name='phoneNumber']").val();
  var _pass = $("input[name='pass']").val();
  var _confirmPass = $("input[name='confirmPass']").val();
  var _code = $("input[name='code']").val();
  var agreement = $("input[name='agreement']")[0].checked;

  if(!agreement){
    showMsg('您还没有同意服务协议');
    return false;
  }

  if(_phoneNumber == '' || _pass == '' || _confirmPass == '' || _code == ''){
    showMsg('请完善注册信息');
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
    "phoneNumber": _phoneNumber,
    "password": _pass,
    "code": _code,
    "agreement": agreement
  }
}

//注册表单提交
function reg(){
  var formData = validateForm();
  if(!formData){
    return;
  }
  $.ajax(
    {
      type: "get",
      dataType: "json",
      url: "/Templates/Debt/data/reg.json",
      data: JSON.stringify(formData),
      beforeSend:　function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          $('#regForm').hide();
          $('.sel-role').show();
          var index = layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            content:    '<div class="popup">'
                      +    '<div class="hd">'
                      +      '会员注册'
                      +    '</div>'
                      +    '<div class="cont">'
                      +      '<div class="para">'
                      +        '<img src="/Uploads/Debt/imgs/gou_b.png" alt="">'
                      +        '恭喜您注册成功！'
                      +      '</div>'
                      +      '<div class="confirm-btn">'
                      +        '<button type="button" onclick="closeAll()" name="button">确定</button>'
                      +      '</div>'
                      +     '</div>'
                      +  '</div>'
          });
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

//关闭注册成功提示窗口
function closeHint(){
  $('#regSuccessHint').hide();
}

//获取验证码
function getCode(tar){
  var _phoneNumber = $("input[name='phoneNumber']").val();
  var _pass = $("input[name='pass']").val();
  var _confirmPass = $("input[name='confirmPass']").val();
  var agreement = $("input[name='agreement']")[0].checked;

  if(!agreement){
    showMsg('您还没有同意服务协议');
    return false;
  }
  if(_phoneNumber == ''){
    showMsg('请先填写手机号');
    return;
  }
  if(!validate("mobilePhone", _phoneNumber)){
    showMsg('请填写正确的号码');
    return;
  }
  if(_pass == ''){
    showMsg('请先设置密码');
    return false;
  }
  if(_pass.length < 6){
    showMsg('密码不能少于6位');
    return false;
  }
  if(!validate('password', _pass)){
    showMsg('您输入的密码有误');
    return false;
  }
  if(_confirmPass != _pass){
    showMsg('两次输入的密码不一致');
    return false;
  }
  codeTimedown(tar);
  $.ajax({
    type: 'get',
    dataType: 'json',
    url: '/Templates/Debt/data/getCode.json',
    data: {
      "phoneNumber": _phoneNumber
    },
    success: function(data){
      if(data.ResultCode == 200){
        showMsg('短信发送成功');
      }else{
        showMsg(data.Message);
      }
    }
  });
}
