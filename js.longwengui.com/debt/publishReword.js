//适配ie8label
fixIE8Label();

//获得省级地区信息
getProvinceData();

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
    showMsg('请完善债权人信息');
    return;
  }
  if(!validate('mobilePhone', debt_owner_phoneNumber)){
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

  if(debtor_name == '' || !debtor_pid || !debtor_cid || !debtor_aid){
    showMsg('请完善债务人信息');
    return;
  }


  if(!validate('chinese', debtor_name)){
    showMsg('请输入正确的债务人姓名');
    return;
  }
  if(debtor_idNum != '' && !validate('idNum', debtor_idNum)){
    showMsg('请输入正确的债务人身份证');
    return;
  }
  if(debtor_phoneNumber != '' && !validate('phone', debtor_phoneNumber)){
    showMsg('请输入正确的债务人手机号');
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

  $.ajax({
    type: "post",
    dataType: "json",
    url: "/ajax.html",
      data: {
          "Intention":"ReleaseReward",
          "AjaxJSON":JSON.stringify({
              "debt_owner": debt_owner,
              "debtor": debtor,
              "images": img_voucher,
              "reword_type": reword_type
          }),
      },
    beforeSend: function(){
      showLoading();
    },
    success: function(data){
      if(data.ResultCode == 200){
          layer.msg(data.Message);
        //路由跳转
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
        type: "get",
        dataType: "json",
        url: "../data/getImg.json",
        data: {
          'ImgBaseData': ImgBaseData,
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
