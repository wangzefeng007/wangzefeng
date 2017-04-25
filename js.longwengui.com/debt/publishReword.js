//适配ie8label
initIE8Label();
fixIE8Label();

//获得省级地区信息
getProvinceData();

//打开协议窗口
function openProtocalWindow(){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    area: '600px',
    shadeClose: true,
    content: '<div class="public-reword">'
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
      $('.m-checkbox input[name="agreement"]').siblings('i').addClass('m-checked');
      layer.close(index);
    });
}

//表单提交
function publish(){
  ajax();
}

function ajax(){
  var debt_owner, debtor;

  if(!$('input[name="agreement"]')[0].checked){
    showMsg('请先同意线索悬赏协议');
    return;
  }

  //验证债权人信息
  var debt_owner_phoneNumber = $('#debt_owner input[name="phoneNumber"]').val();
  if(debt_owner_phoneNumber == ''){
    $('#debt_owner input[name="phoneNumber"]').focus();
    showMsg('请完善债权人信息');
    return;
  }
  if(!validate('mobilePhone', debt_owner_phoneNumber)){
    $('#debt_owner input[name="phoneNumber"]').focus();
    showMsg('手机号格式有误');
    return;
  }

  debt_owner = {
    "phoneNumber": debt_owner_phoneNumber //债权人手机号
  };

  //验证债务人信息
  var debtor_name = $('#debtor input[name="name"]').val();
  var debtor_idNum = $('#debtor input[name="idNum"]').val();
  var debtor_phoneNumber = $('#debtor input[name="phoneNumber"]').val();
  var debtor_pid = $('#debtor .p-dropdown span').attr('data-id');
  var debtor_cid = $('#debtor .c-dropdown span').attr('data-id');
  var debtor_aid = $('#debtor .a-dropdown span').attr('data-id');
  var debtor_areaDetail = $('#debtor textarea[name="areaDetail"]').val();

  if(debtor_name == ''){
    $('#debtor input[name="name"]').focus();
    showMsg('请填写债务人姓名');
    return;
  }
  if(!validate('chinese', debtor_name)){
    $('#debtor input[name="name"]').focus();
    showMsg('请输入正确的债务人姓名');
    return;
  }
  if(debtor_idNum != '' && !validate('idNum', debtor_idNum)){
    $('#debtor input[name="idNum"]').focus();
    showMsg('请输入正确的债务人身份证');
    return;
  }
  if(debtor_phoneNumber != '' && !validate('phone', debtor_phoneNumber)){
    $('#debtor input[name="phoneNumber"]').focus();
    showMsg('请输入正确的债务人手机号');
    return;
  }
  if(!debtor_pid || !debtor_cid || !debtor_aid){
    showMsg('请完善债务人地址信息');
    return;
  }

  debtor = {
    "name": debtor_name, //债务人姓名
    "idNum": debtor_idNum, //债务人身份证号
    "phoneNumber": debtor_phoneNumber,  //债务人手机号
    "province": debtor_pid,  //债务人省份
    "city": debtor_cid, //债务人城市
    "area": debtor_aid,  //债务人地区
    "areaDetail": debtor_areaDetail  //债务人详细地址
  }

  var reword_type = $('input[name="rewordType"]:checked').val(); //悬赏类型
  var img_voucher = []; //债务凭证图片地址

  $('.img-wrap').each(function(){
    if($(this).children('img').attr('src')){
      img_voucher.push($(this).children('img').attr('src'));
    }
  });

  if(img_voucher.length == 0){
    showMsg('请至少上传一张悬赏图片');
    return;
  }

  $.ajax({
    type: "post",
    dataType: "json",
    url: "/ajax.html",
      data: {
          "Intention":"ReleaseReward",
          "AjaxJSON":JSON.stringify({
              "debt_owner": debt_owner, //债权人信息
              "debtor": debtor, //债务人信息
              "images": img_voucher, //债务凭证
              "reword_type": reword_type //悬赏类型
          }),
      },
    beforeSend: function(){
      showLoading();
    },
    success: function(data){
      if(data.ResultCode == 200){
          layer.msg(data.Message);
          //路由跳转
          setTimeout(function() {
              window.location = data.Url;
          }, 10);
      }else{
          layer.msg(data.Message);
      }
    },
    complete: function(){
      closeLoading();
    }
  });
}

//图片上传裁剪方法
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajax.html",
        data: {
            "Intention":"AddRewardImage",
            "ImgBaseData": ImgBaseData,
        },
        beforeSend: function () {
            showLoading();
        },
        success: function(data) {
          if(data.ResultCode=='200'){
              showMsg('上传成功');
              $(tar).parent().siblings('.img-wrap').html(
                "<img src='" + data.url + "' alt=''>"
              );
              setTimeout(function(){
                layer.close(index);
              }, 200);
          }else{
              layer.msg(data.Message);
          }
        },
        complete: function () { //加载完成提示
            closeLoading();
        }
    });
}
