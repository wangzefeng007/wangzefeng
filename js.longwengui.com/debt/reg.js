//打开协议窗口
function openProtocalWindow(){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    area: '600px',
    shadeClose: true,
    content: '<div class="reg">'
            +  '<div class="protocal-pop">'
            +    '<div class="popup">'
            +        '<div class="hd">'
            +            '隆文贵软件许可及服务协议'
            +            '<div class="close" id="close_protocal">'
            +                '<img src="/Uploads/Debt/imgs/close_grey.png" alt="">'
            +            '</div>'
            +        '</div>'
            +        '<div class="cont">'
            +            '<div class="para">'
            +                '<p>感谢您使用隆文贵服务!《隆文贵软件许可及服务协议》（以下简称“本协议”）由武夷山隆文贵互联网信息咨询有限公司（以下简称“隆文贵”）和您签订。</p>'
            +                '<p>您使用隆文贵软件（以下简称“本软件”）及服务前，应当阅读并遵守“本协议”，并务必审慎阅读、充分理解各条款内容。您的下载、安装、使用、浏览、注册账号、登录等行为即视为您已阅读并同意上述协议的约束。</p>'
            +                '<p>一、协议的范围</p>'
            +                '<p>1.1本协议是您与隆文贵之间关于您下载、安装、使用本软件及相关服务所订立的协议。本协议中的“用户”,一般指经过隆文贵实名认证的注册会员，包括“个人用户”、“单位用户”和“律师用户”。“个人用户”是指使用本软件相关服务的个人；“单位用户”是指使用本软件相关服务的法人或非法人组织；“律师用户”是指使用本软件相关服务的律师或律师事务所。“用户”在软件中也称为“您”。</p>'
            +                '<p>1.2本协议同时包括隆文贵可能不断发布的关于本服务的相关协议、规则、合同等内容。上述内容在本软件中一经发布，即为本协议不可分割的组成部分，您同样应当遵守。</p>'
            +                '<p>1.3隆文贵可能会变更本协议及相关协议、规则、合同等内容，变更内容在本软件中一经公布，即应生效。如您继续使用，视为同意内容变更。</p>'
            +                '<p>二、关于本服务</p>'
            +                '<p>2.1 本服务的内容</p>'
            +            '</div>'
            +            '<div class="confirm-btn">'
            +                '<button type="button" id="agree_protocal" name="button">同意并继续</button>'
            +            '</div>'
            +        '</div>'
            +    '</div>'
            +   '</div>'
            + '</div>'
    });

    //关闭
    $('#close_protocal').click(function(){
      layer.close(index);
    });
    //同意协议
    $('#agree_protocal').click(function(){
      var _tar = $('.m-checkbox input[name="agreement"]')[0];
      _tar.checked = true;
      layer.close(index);
    });
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
      type: "post",
      dataType: "json",
      url: "/loginajax.html",
      data: {
          "Intention":"Register",
          "AjaxJSON":JSON.stringify(formData),
      },
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
        showMsg('短信发送成功');
      }else{
       showMsg(data.Message);
      }
    }
  });
}
