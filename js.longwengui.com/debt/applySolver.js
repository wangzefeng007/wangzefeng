$(function(){
  var haveBondsMan = 0;
  var haveBondsGood = 0;
  getProvinceData();

  $('#bonds_man_info_btn').click(function(){
    if($(this).attr('data-checked') == 1){
      $(this).attr('data-checked', 0);
      $(this).attr('src', '/Uploads/Debt/imgs/gou_b_off.png');
      $(this).siblings('.opt').hide();
      $('#bonds_man_info').children().hide();
      haveBondsMan = 0;
    }else{
      $(this).attr('data-checked', 1);
      $(this).attr('src', '/Uploads/Debt/imgs/gou_b.png');
      $(this).siblings('.opt').show();
      $('#bonds_man_info').children().show();
      haveBondsMan = 1;
      addBondsManDpEvent();
    }
  });

  $('#bonds_good_info_btn').click(function(){
    if($(this).attr('data-checked') == 1){
      $(this).attr('data-checked', 0);
      $(this).attr('src', '/Uploads/Debt/imgs/gou_b_off.png');
      $(this).siblings('.opt').hide();
      $('#bonds_good_info').children().hide();
      haveBondsGood = 0;
    }else{
      $(this).attr('data-checked', 1);
      $(this).attr('src', '/Uploads/Debt/imgs/gou_b.png');
      $(this).siblings('.opt').show();
      $('#bonds_good_info').children().show();
      haveBondsGood = 1;
    }
  });

  $('#match').click(function(){
    ajax();
  });


  //提交匹配条件
  function ajax(Page){
    var _debtOwnerInfos = [];
    var _preFee, _searchedAnytime, _abilityDebt;
    var _debtorInfos = [];
    var _bondsmanInfos = [];
    var _bondsgoodInfos = [];
    var _debtor_owner_money = 0, _debtor_money = 0;

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
          flag = false;
          return;
        }

        if(_name != '' && !validate('chinese', _name)){
          showMsg('请输入正确的债权人姓名');
          flag = false;
          return;
        }
        if(_idNum != '' && !validate('idNum', _idNum)){
          showMsg('请输入正确的债权人身份证');
          flag = false;
          return;
        }
        if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
          showMsg('请输入正确的债权人手机号');
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
          flag = false;
          return;
        }
        if(parseInt(_debt_money) < 0){
          showMsg('请输入正确的债权金额');
          flag = false;
          return;
        }
        _debtor_owner_money += parseInt(_debt_money);
        _debtOwnerInfos.push({
          "name": _name,
          "idNum": _idNum,
          "debt_money": _debt_money,
          "phoneNumber": _phoneNumber,
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
          flag = false;
          return;
        }
        if(_name != '' && !validate('chinese', _name)){
          showMsg('请输入正确的债务人姓名');
          flag = false;
          return;
        }
        if(_idNum != '' && !validate('idNum', _idNum)){
          showMsg('请输入正确的债权人身份证');
          flag = false;
          return;
        }
        if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
          showMsg('请输入正确的债权人手机号');
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
          flag = false;
          return;
        }
        if(parseInt(_debt_money) < 0){
          showMsg('请输入正确的债务金额');
          flag = false;
          return;
        }
        _debtor_money += parseInt(_debt_money);
        _debtorInfos.push({
          "name": _name,
          "idNum": _idNum,
          "debt_money": _debt_money,
          "phoneNumber": _phoneNumber,
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

    if(_debtor_owner_money != _debtor_money){
      showMsg('债务人和债权人金额总和不一致');
      return;
    }

    //是否有前期费用
    _preFee = $('input[name="fee"]:checked').val();

    //是否能随时找到
    _searchedAnytime = $('input[name="searchedAnytime"]:checked').val();

    //是否有还款能力
    _abilityDebt = $('input[name="abilityDebt"]:checked').val();

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
            flag = false;
            return;
          }
          if(_name != '' && !validate('chinese', _name)){
            showMsg('请输入正确的保证人姓名');
            flag = false;
            return;
          }
          if(_idNum != '' && !validate('idNum', _idNum)){
            showMsg('请输入正确的保证人身份证');
            flag = false;
            return;
          }
          if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
            showMsg('请输入正确的保证人手机号');
            flag = false;
            return;
          }
          _bondsmanInfos.push({
            "name": _name,
            "idNum": _idNum,
            "phoneNumber": _phoneNumber,
            "bonds_man_role": _bonds_man_role,
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
            flag = false;
            return;
          }
          _bondsgoodInfos.push({
            "name": _name,
            "details": _details
          });
        }
      });
      if(!flag){
        return;
      }
    }

    var submitData = {
      "debtOwnerInfos": _debtOwnerInfos, //债权人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债权金额}
      "debtorInfos": _debtorInfos, //债务人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债务金额}
      "preFee": _preFee, //是否有前期费用 0 没有 1 有
      "searchedAnytime": _searchedAnytime, //是否随时能找到 0 不能 1能
      "abilityDebt": _abilityDebt, //是否有能力还债 0 不能 1 能
      "haveBondsMan": haveBondsMan, //是否有保证人 0 无 1 有
      "bondsmanInfos": _bondsmanInfos, //保证人信息数组； haveBondsMan为0: 数组为空;为1: {name: 名称; idNum: 身份证号; phoneNumber: 联系方式; bonds_man_role: 保证人角色}
      "haveBondsGood": haveBondsGood,  //是否有抵押物 0 无 1 有
      "bondsgoodInfos": _bondsgoodInfos, //抵押物信息数组； haveBondsGood为0: 数组为空; 为1：{name：抵押物名称; details: 抵押物描述}
      "Page": Page,
      "Type": window.location.href.charAt(window.location.href.length - 2)
    }

    $.ajax({
      type: "post",
      dataType: "json",
      url: "/ajax.html",
        data: {
            "Intention":"FindTeam",
            "AjaxJSON":JSON.stringify(submitData),
        },
      beforeSend: function () { //加载过程效果
          showLoading();
      },
      success: function(data){
          //设置匹配按钮不可点击
          $('#match')[0].disabled = true;
          $('#match').addClass('btn-disabled');
        if(data.ResultCode == 200){
          debtId = data.DebtId;
          console.log(data)
          dataSuccess(data.Data);
          //获得当前页
          cur_page = data.Page;
          //注入分页
          injectPagination('#result_tbl_pagination', cur_page, data.PageCount, function(){
            $('#result_tbl_pagination').find('.b').click(function(){
              var changeTo = pageChange($(this).attr('data-id'), cur_page, data.PageCount);
              if(changeTo){
                ajax(changeTo);
              }
            });
          });
        }else{
            layer.msg(data.Message);
        }
      },
      complete: function () { //加载完成提示
          closeLoading();
      }
    });

  }

  //数据注入
  function dataSuccess(data){
    $('#result_data').show();
    $('#result_tbl').empty();
    $('#result_data_tmpl').tmpl({resData: data}).appendTo('#result_tbl');
  }

});

var debtId;
//添加保证人角色下拉框事件
function addBondsManDpEvent(){
  addEventToDropdown("bonds_man_role", function(tar){
    var _role = $(tar).attr("data-name");
    $(tar).parent().siblings("span").text(_role);
  });
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

//申请处置方
function applyToSearch(UserID, money, tar){
  layer.open({
    content: '确定申请该处置方进行处理',
    title: 0,
    btnAlign: 'c',
    shadeClose: 'true',
    closeBtn: 0,
    btn: ['确定'],
    yes: function(index, layero){
      toApply(UserID, money, tar);
      layer.close(index);
    }
  });
  function toApply(uid, money, tar){
    $.ajax(
      {
        type: "post",
        dataType: "json",
        url: "/ajax.html",
        data: {
          "Intention":"DisposeApply",
          "uid": uid, //提交处置方userid
          "debtId": debtId, //该债务的id
          "money": money
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
              layer.msg(data.Message);
              $(tar)[0].disabled = true;
              $(tar).addClass("btn-disabled");
              $(tar).html("已申请");
          }else{
            layer.msg(data.Message); //例如申请不能超过3个
          }
        },
        complete: function () { //加载完成提示
            closeLoading();
        }
      }
    );
  }
}
