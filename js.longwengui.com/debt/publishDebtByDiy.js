//自助催收发布债务
var zqrType=$('input[name="debtor_owner_type"]:checked').val();    //债权人类型1、个人 2、企业
var zwrType=$('input[name="debtor_type"]:checked').val();    //债务人类型1、个人 2、企业
$(function(){
  var haveDebtFamily = 0; //是否有债物人亲友
  getProvinceData();

  //债务类型切换
    $(".choose-type input[type='radio']").on("change",function(){
        if($(this).val()=="1"){
            $(this).parents(".box").find(".tab-con").children("div").eq(0).addClass("active");
            $(this).parents(".box").find(".tab-con").children("div").eq(1).removeClass("active");
        }
        if($(this).val()=="2"){
            $(this).parents(".box").find(".tab-con").children("div").eq(0).removeClass("active");
            $(this).parents(".box").find(".tab-con").children("div").eq(1).addClass("active");
        }
    });
  $('#end_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '226px'}); //初始化日期选择器
    //切换是否有债务人亲友
    $('#debt_family_info_btn').click(function(){
        if($(this).attr('data-checked') == 1){
            $(this).attr('data-checked', 0);
            $(this).attr('src', 'http://www.longwengui.net/Uploads/Debt/imgs/gou_b_off.png');
            $(this).siblings('.opt').hide();
            $('#debt_family_info').children().hide();
            haveDebtFamily = 0;
        }else{
            $(this).attr('data-checked', 1);
            $(this).attr('src', 'http://www.longwengui.net/Uploads/Debt/imgs/gou_b.png');
            $(this).siblings('.opt').show();
            $('#debt_family_info').children().show();
            haveDebtFamily = 1;
        }
    });

  //发布债务
  $('#publish').click(function(){
      zqrType=$('input[name="debtor_owner_type"]:checked').val();    //债权人类型1、个人 2、企业
      zwrType=$('input[name="debtor_type"]:checked').val();    //债务人类型1、个人 2、企业
    ajax();
  });

  //提交匹配条件
  function ajax(){
    var _debtOwnerInfos = []; //债权人
    var _debtorInfos = [];  //债务人
    var _debtfamilyInfos = [];  //债物人亲友
    var _debtor_owner_money = 0, _debtor_money = 0;
    var img_voucher = []; //债务凭证图片地址
    var overDay; //逾期时间

    //决定程序是否往下执行
    var flag = true;
      _debtor_owner_money=0;
      _debtOwnerInfos=[];
    //注入债权人信息
      if(zqrType=="1"){
          $('#debtor_owner_info').find('.blo').each(function(){
              if(flag){
                  //债权人信息
                  var _name = $(this).find('input[name="name"]').val();
                  var _idNum = $(this).find('input[name="idNum"]').val();
                  var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();

                  if(_name == ""){
                      showMsg('请完善债权人信息');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }

                  if(!validate('chinese', _name)){
                      showMsg('请输入正确的债权人姓名');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }
                  if(_idNum != '' && !validate('idNum', _idNum)){
                      showMsg('请输入正确的债权人身份证');
                      $(this).find('input[name="idNum"]').focus();
                      flag = false;
                      return;
                  }
                  if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                      showMsg('请输入正确的债权人手机号');
                      $(this).find('input[name="phoneNumber"]').focus();
                      flag = false;
                      return;
                  }

                  //债权人地区
                  var _pid = $(this).find('.p-dropdown span').attr('data-id');
                  var _cid = $(this).find('.c-dropdown span').attr('data-id');
                  var _aid = $(this).find('.a-dropdown span').attr('data-id');
                  var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                  if(!_pid || !_cid || !_aid){
                      showMsg('请完善债权人地区信息');
                      flag = false;
                      return;
                  }

                  //债权金额
                  var _debt_money = $(this).find('input[name="debt_money"]').val();
                  if(_debt_money == ''){
                      showMsg('请输入债权金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  if(!validate('+money', _debt_money)){
                      showMsg('请输入正确的债权金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  _debtor_owner_money += parseFloat(_debt_money);
                  _debtOwnerInfos.push({
                      "type": 1, //债权人类型
                      "name": _name, //债权人姓名
                      "idNum": _idNum, //债权人身份证
                      "debt_money": _debt_money, //债权金额
                      "phoneNumber": _phoneNumber, //债权人电话
                      "province": _pid,
                      "city": _cid,
                      "area": _aid,
                      "areaDetail": _areaDetail
                  });
              }
          });
      }else if(zqrType=="2"){
          $('#debtor_owner_company_info').find('.blo').each(function(){
              if(flag){
                  //债权人信息
                  var _cname = $(this).find('input[name="companyName"]').val();
                  var _name = $(this).find('input[name="name"]').val();
                  var _idNum = $(this).find('input[name="idNum"]').val();
                  var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();

                  if(_cname == ""){
                      showMsg('请输入公司姓名');
                      $(this).find('input[name="companyName"]').focus();
                      flag = false;
                      return;
                  }
                  if(_idNum != '' && !validate('creditNum', _idNum)){
                      showMsg('请输入正确的信用代码');
                      $(this).find('input[name="idNum"]').focus();
                      flag = false;
                      return;
                  }
                  if(_name == ""){
                      showMsg('请输入法人姓名');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }

                  if(!validate('chinese', _name)){
                      showMsg('请输入正确的法人姓名');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }
                  if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                      showMsg('请输入正确的电话号码');
                      $(this).find('input[name="phoneNumber"]').focus();
                      flag = false;
                      return;
                  }

                  //债权人地区
                  var _pid = $(this).find('.p-dropdown span').attr('data-id');
                  var _cid = $(this).find('.c-dropdown span').attr('data-id');
                  var _aid = $(this).find('.a-dropdown span').attr('data-id');
                  var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                  if(!_pid || !_cid || !_aid){
                      showMsg('请完善债权人地区信息');
                      flag = false;
                      return;
                  }

                  //债权金额
                  var _debt_money = $(this).find('input[name="debt_money"]').val();
                  if(_debt_money == ''){
                      showMsg('请输入债权金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  if(!validate('+money', _debt_money)){
                      showMsg('请输入正确的债权金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  _debtor_owner_money += parseFloat(_debt_money);
                  _debtOwnerInfos.push({
                      "type": 2, //债权人类型
                      "cname": _cname, //债权人公司名称
                      "name": _name, //债权人法人姓名
                      "idNum": _idNum, //债权人信用代码
                      "debt_money": _debt_money, //债权金额
                      "phoneNumber": _phoneNumber, //债权人电话
                      "province": _pid,
                      "city": _cid,
                      "area": _aid,
                      "areaDetail": _areaDetail
                  });
              }
          });
      }
    if(!flag){
      return;
    }
      _debtor_money=0;
      _debtorInfos=[];
    //注入债务人信息
      if(zwrType=="1"){
          $('#debtor_info').find('.blo').each(function(){
              if(flag){
                  //债务人信息
                  var _name = $(this).find('input[name="name"]').val();
                  var _idNum = $(this).find('input[name="idNum"]').val();
                  var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();

                  if(_name == ""){
                      showMsg('请完善债务人信息');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }
                  if(!validate('chinese', _name)){
                      showMsg('请输入正确的债务人姓名');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }
                  if(_idNum != '' && !validate('idNum', _idNum)){
                      showMsg('请输入正确的债权人身份证');
                      $(this).find('input[name="idNum"]').focus();
                      flag = false;
                      return;
                  }
                  if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                      showMsg('请输入正确的债权人手机号');
                      $(this).find('input[name="phoneNumber"]').focus();
                      flag = false;
                      return;
                  }
                  //债务人地区
                  var _pid = $(this).find('.p-dropdown span').attr('data-id');
                  var _cid = $(this).find('.c-dropdown span').attr('data-id');
                  var _aid = $(this).find('.a-dropdown span').attr('data-id');
                  var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                  if(!_pid || !_cid || !_aid){
                      showMsg('请完善债务人地区信息');
                      flag = false;
                      return;
                  }

                  //债权金额
                  var _debt_money = $(this).find('input[name="debt_money"]').val();
                  if(_debt_money == ''){
                      showMsg('请输入债务金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  if(!validate('+money', _debt_money)){
                      showMsg('请输入正确的债务金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  _debtor_money += parseFloat(_debt_money);
                  _debtorInfos.push({
                      "type": 1, //债务人类型
                      "name": _name, //债务人姓名
                      "idNum": _idNum, //债务人身份证
                      "debt_money": _debt_money, //债务金额
                      "phoneNumber": _phoneNumber, //债务人电话
                      "province": _pid,
                      "city": _cid,
                      "area": _aid,
                      "areaDetail": _areaDetail
                  });
              }
          });
      }else if(zwrType=="2"){
          $('#debtor_company_info').find('.blo').each(function(){
              if(flag){
                  //债务人信息
                  var _cname = $(this).find('input[name="companyName"]').val();
                  var _name = $(this).find('input[name="name"]').val();
                  var _idNum = $(this).find('input[name="idNum"]').val();
                  var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();

                  if(_cname == ""){
                      showMsg('请输入公司姓名');
                      $(this).find('input[name="companyName"]').focus();
                      flag = false;
                      return;
                  }
                  if(_idNum != '' && !validate('creditNum', _idNum)){
                      showMsg('请输入正确的信用代码');
                      $(this).find('input[name="idNum"]').focus();
                      flag = false;
                      return;
                  }
                  if(_name == ""){
                      showMsg('请输入法人姓名');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }

                  if(!validate('chinese', _name)){
                      showMsg('请输入正确的法人姓名');
                      $(this).find('input[name="name"]').focus();
                      flag = false;
                      return;
                  }
                  if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                      showMsg('请输入正确的电话号码');
                      $(this).find('input[name="phoneNumber"]').focus();
                      flag = false;
                      return;
                  }

                  //债务人地区
                  var _pid = $(this).find('.p-dropdown span').attr('data-id');
                  var _cid = $(this).find('.c-dropdown span').attr('data-id');
                  var _aid = $(this).find('.a-dropdown span').attr('data-id');
                  var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                  if(!_pid || !_cid || !_aid){
                      showMsg('请完善债务人地区信息');
                      flag = false;
                      return;
                  }

                  //债权金额
                  var _debt_money = $(this).find('input[name="debt_money"]').val();
                  if(_debt_money == ''){
                      showMsg('请输入债务金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  if(!validate('+money', _debt_money)){
                      showMsg('请输入正确的债务金额');
                      $(this).find('input[name="debt_money"]').focus();
                      flag = false;
                      return;
                  }
                  _debtor_money += parseFloat(_debt_money);
                  _debtorInfos.push({
                      "type": 2, //债务人类型
                      "cname": _cname, //债务人公司名称
                      "name": _name, //债务人法人姓名
                      "idNum": _idNum, //债务人信用代码
                      "debt_money": _debt_money, //债务金额
                      "phoneNumber": _phoneNumber, //债务人电话
                      "province": _pid,
                      "city": _cid,
                      "area": _aid,
                      "areaDetail": _areaDetail
                  });
              }
          });
      }
    if(!flag){
      return;
    }
    //判断是否债权和债务总额统一
    if(_debtor_owner_money != _debtor_money){
      showMsg('债务人和债权人金额总和不统一');
      return;
    }
    //逾期时间
    overDay = $('input[name="overDay"]').val();
    if(overDay == ''){
      showMsg('请设置逾期时间');
      $('input[name="overDay"]').focus();
      return;
    }

    if(haveDebtFamily == 1){
        //有债务人亲友
        $('#debt_family_info').find('.blo').each(function(){
            if(flag){
                //债务人亲友信息
                var _name = $(this).find('input[name="name"]').val();
                var _relationship = $(this).find('input[name="relationship"]').val();
                var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();

                if(_name == ""){
                    showMsg('请完善债务人亲友信息');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }
                if(!validate('chinese', _name)){
                    showMsg('请输入正确的债务人亲友姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }
                if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                    showMsg('请输入正确的债务人亲友手机号');
                    $(this).find('input[name="phoneNumber"]').focus();
                    flag = false;
                    return;
                }
                _debtfamilyInfos.push({
                    "name": _name, //债务人亲友姓名
                    "idNum": _relationship, //债务人亲友关系
                    "phoneNumber": _phoneNumber //债务人亲友联系方式
                });
            }
        });
        if(!flag){
            return;
        }
    }
    $('.img-wrap').each(function(){
      if($(this).children('img').attr('src')){
        img_voucher.push($(this).children('img').attr('src'));
      }
    });

    var submitData = {
      "debtOwnerInfos": _debtOwnerInfos, //债权人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债权金额 areaDetail 详细地址}
      "debtorInfos": _debtorInfos, //债务人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债务金额 areaDetail 详细地址}
      "haveDebtFamily": haveDebtFamily, //是否有债务人亲友 0 无 1 有
      "debtfamilyInfos": _debtfamilyInfos, //债权人亲友信息数组； haveDebtFamily为0: 数组为空;为1: {name: 名称; relationship: 与债权人关系; phoneNumber: 联系方式;}
      "images": img_voucher, //债务凭证图片
      "overDay": overDay //逾期时间
    }

    $.ajax({
      type: "post",
      url: "/ajax.html",
      dataType: "json",
      data: {
          "Intention":"ReleaseDebt",
          "AjaxJSON":JSON.stringify(submitData),
          "Type":zwrType  //债务类型1-个人债务 2-企业债务
      },
      beforeSend: function () { //加载过程效果
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
      complete: function () { //加载完成提示
          closeLoading();
      }
    });

  }
});

//适配ie8label
initIE8Label();
fixIE8Label();

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

//添加债权人亲友
function addDebtFamily(){
    if($('#debt_family_info').children('.blo').length < 3){
        addDom('debt_family_info', 'debt_family_tmpl');
    }
}
//债权人添加
function addZQR(){
    zqrType=$('input[name="debtor_owner_type"]:checked').val();
    if(zqrType=="1"){
        addDebtDom('debtor_owner_info', 'debtor_owner_info_temp');
    }
    if(zqrType=="2"){
        addDebtDom('debtor_owner_company_info', 'debtor_owner_company_info_temp');
    }
}
//添加事件
function addDebtDom(targetID, tempID){
  if($('#' + targetID).children('.blo').length < 3){
    addDom(targetID, tempID, getProvinceData);
  }
}
//债务人添加
function addZWR(){
    zwrType=$('input[name="debtor_type"]:checked').val();
    if(zwrType=="1"){
        addDebtDom('debtor_info', 'debtor_info_temp');
    }
    if(zwrType=="2"){
        addDebtDom('debtor_company_info', 'debtor_company_info_temp');
    }
}
//图片上传裁剪方法
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajaximage",
        data: {
          "Intention":"AddDebtImage",
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
