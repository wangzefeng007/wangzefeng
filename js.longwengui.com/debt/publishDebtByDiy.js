//自助催收发布债务
$(function(){
  var haveDebtFamily = 0; //是否有债物人亲友
  var haveBondsMan = 0; //是否有保证人
  var haveBondsGood = 0; //是否有保证物
  getProvinceData();


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

  //切换是否有保证人
  $('#bonds_man_info_btn').click(function(){
    if($(this).attr('data-checked') == 1){
      $(this).attr('data-checked', 0);
      $(this).attr('src', 'http://www.longwengui.net/Uploads/Debt/imgs/gou_b_off.png');
      $(this).siblings('.opt').hide();
      $('#bonds_man_info').children().hide();
      haveBondsMan = 0;
    }else{
      $(this).attr('data-checked', 1);
      $(this).attr('src', 'http://www.longwengui.net/Uploads/Debt/imgs/gou_b.png');
      $(this).siblings('.opt').show();
      $('#bonds_man_info').children().show();
      haveBondsMan = 1;
      addBondsManDpEvent();
    }
  });
  //切换是否有保证物
  $('#bonds_good_info_btn').click(function(){
    if($(this).attr('data-checked') == 1){
      $(this).attr('data-checked', 0);
      $(this).attr('src', 'http://www.longwengui.net/Uploads/Debt/imgs/gou_b_off.png');
      $(this).siblings('.opt').hide();
      $('#bonds_good_info').children().hide();
      haveBondsGood = 0;
    }else{
      $(this).attr('data-checked', 1);
      $(this).attr('src', 'http://www.longwengui.net/Uploads/Debt/imgs/gou_b.png');
      $(this).siblings('.opt').show();
      $('#bonds_good_info').children().show();
      haveBondsGood = 1;
    }
  });
  //发布债务
  $('#publish').click(function(){
    ajax();
  });

  //提交匹配条件
  function ajax(){
    var _debtOwnerInfos = [];
    var _preFee, _searchedAnytime, _abilityDebt;
    var _debtorInfos = [];
    var _debtfamilyInfos = [];
    var _bondsmanInfos = [];
    var _bondsgoodInfos = [];
    var _debtor_owner_money = 0, _debtor_money = 0;
    var _loan_reason, _loan_recent; //借款原因、借款近况
    var img_voucher = []; //债务凭证图片地址
    var overDay; //逾期时间

    //决定程序是否往下执行
    var flag = true;

    //注入债权人信息
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
          showMsg('请输入债务金额');
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
    if(!flag){
      return;
    }

    //注入债务人信息
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
    /*if(!validate('day', overDay)){
      showMsg('请输入正确的逾期时间');
      $('input[name="overDay"]').focus();
      return;
    }*/

    //是否能随时找到
    _searchedAnytime = $('input[name="searchedAnytime"]:checked').val();

    //是否有还款能力
    _abilityDebt = $('input[name="abilityDebt"]:checked').val();

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

    if(haveBondsMan == 1){
      //有保证人时注入
      $('#bonds_man_info').find('.blo').each(function(){
        if(flag){
          //保证人信息
          var _bonds_man_role = $(this).find('.m-dropdown span').text();
          var _name = $(this).find('input[name="name"]').val();
          var _idNum = $(this).find('input[name="idNum"]').val();
          var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();

          if(_name == ""){
            showMsg('请完善保证人信息');
            $(this).find('input[name="name"]').focus();
            flag = false;
            return;
          }
          if(!validate('chinese', _name)){
            showMsg('请输入正确的保证人姓名');
            $(this).find('input[name="name"]').focus();
            flag = false;
            return;
          }
          if(_idNum != '' && !validate('idNum', _idNum)){
            showMsg('请输入正确的保证人身份证');
            $(this).find('input[name="idNum"]').focus();
            flag = false;
            return;
          }
          if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
            showMsg('请输入正确的保证人手机号');
            $(this).find('input[name="phoneNumber"]').focus();
            flag = false;
            return;
          }
          _bondsmanInfos.push({
            "name": _name, //保证人姓名
            "idNum": _idNum, //保证人身份证号
            "phoneNumber": _phoneNumber, //保证人电话
            "bonds_man_role": _bonds_man_role //保证人 个人或企业
          });
        }
      });
      if(!flag){
        return;
      }
    }

    if(haveBondsGood){
      //有抵押物时注入
      $('#bonds_good_info').find('.blo').each(function(){
        if(flag){
          //债务人信息
          var _name = $(this).find('input[name="name"]').val();
          var _details = $(this).find('textarea[name="good_detail"]').val();

          if(_name == ""){
            showMsg('请完善抵押物信息');
            $(this).find('input[name="name"]').focus();
            flag = false;
            return;
          }
          _bondsgoodInfos.push({
            "name": _name, //保证物名称
            "details": _details //保证物详情
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

    _loan_reason = $('textarea[name="loan_reason"]').val();
    _loan_recent = $('textarea[name="loan_recent"]').val();


    var submitData = {
      "debtOwnerInfos": _debtOwnerInfos, //债权人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债权金额 areaDetail 详细地址}
      "debtorInfos": _debtorInfos, //债务人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债务金额 areaDetail 详细地址}
      "searchedAnytime": _searchedAnytime, //是否随时能找到 0 不能 1能
      "abilityDebt": _abilityDebt, //是否有能力还债 0 不能 1 能
      "haveDebtFamily": haveDebtFamily, //是否有债务人亲友 0 无 1 有
      "debtfamilyInfos": _debtfamilyInfos, //债权人亲友信息数组； haveDebtFamily为0: 数组为空;为1: {name: 名称; relationship: 与债权人关系; phoneNumber: 联系方式;}
      "haveBondsMan": haveBondsMan, //是否有保证人 0 无 1 有
      "bondsmanInfos": _bondsmanInfos, //保证人信息数组； haveBondsMan为0: 数组为空;为1: {name: 名称; idNum: 身份证号; phoneNumber: 联系方式; bonds_man_role: 保证人角色}
      "haveBondsGood": haveBondsGood,  //是否有抵押物 0 无 1 有
      "bondsgoodInfos": _bondsgoodInfos, //抵押物信息数组； haveBondsGood为0: 数组为空; 为1：{name：抵押物名称; details: 抵押物描述}
      "loan_reason": _loan_reason, //借款原因
      "loan_recent": _loan_recent, //借款近况
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
          "Type":3//债务催收类型1-律师，2-催收公司，3-自助催收
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

//添加保证人角色下拉框事件
function addBondsManDpEvent(){
  addEventToDropdown("bonds_man_role", function(tar){
    var _role = $(tar).attr("data-name");
    $(tar).parent().siblings("span").text(_role);
  });
}
//添加债权人亲友
function addDebtFamily(){
    if($('#debt_family_info').children('.blo').length < 3){
        addDom('debt_family_info', 'debt_family_tmpl');
    }
}
//添加新的保证人
function addBondsMan(){
  if($('#bonds_man_info').children('.blo').length < 5){
    addDom('bonds_man_info', 'bonds_man_tmpl', addBondsManDpEvent);
  }
}
//添加新的抵押物
function addBondsGood(){
  if($('#bonds_good_info').children('.blo').length < 5){
    addDom('bonds_good_info', 'bonds_good_tepl');
  }
}
//添加债权人事件
function addDebtDom(targetID, tempID){
  if($('#' + targetID).children('.blo').length < 3){
    addDom(targetID, tempID, getProvinceData);
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
