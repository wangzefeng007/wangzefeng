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
        //债权人地区
        var _province = $(this).find('input[name="province"]').val();
        var _city = $(this).find('input[name="city"]').val();
        var _county = $(this).find('input[name="county"]').val();

        if(_province == "" || _city == "" || _county == ""){
          showMsg('请完善债权人地区信息');
          flag = false;
          return;
        }

        //债权金额
        var _debt_money = $(this).find('input[name="debt_money"]').val();
        if(_debt_money && parseInt(_debt_money) < 0){
          showMsg('请输入正确的债权金额');
          flag = false;
          return;
        }
        _debtOwnerInfos.push({
          "name": _name,
          "idNum": _idNum,
          "debt_money": _debt_money,
          "phoneNumber": _phoneNumber,
          "province": _province,
          "city": _city,
          "area": _county
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
        //债务人地区
        var _province = $(this).find('input[name="province"]').val();
        var _city = $(this).find('input[name="city"]').val();
        var _county = $(this).find('input[name="county"]').val();

        if(_province == "" || _city == "" || _county == ""){
          showMsg('请完善债务人地区信息');
          flag = false;
          return;
        }

        //债权金额
        var _debt_money = $(this).find('input[name="debt_money"]').val();
        if(_debt_money && parseInt(_debt_money) < 0){
          showMsg('请输入正确的债务金额');
          flag = false;
          return;
        }
        _debtorInfos.push({
          "name": _name,
          "idNum": _idNum,
          "debt_money": _debt_money,
          "phoneNumber": _phoneNumber,
          "province": _province,
          "city": _city,
          "area": _county
        });
      }
    });
    if(!flag){
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
      "Page": Page
    }

    $.ajax({
      type: "post",
      url: "/ajax.html",
        data: {
            "Intention":"FindTeam",
            "AjaxJSON":JSON.stringify(submitData),
        },
      beforeSend: function () { //加载过程效果
          showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          dataSuccess(data.Data);
          //获得当前页
          cur_page = data.Page;

          //注入分页
          injectPagination('#result_tbl_pagination', cur_page, data.PageCount, function(){
            $('#result_tbl_pagination').find('.b').click(function(){
              var changeTo = pageChange($(this).attr('data-id'), cur_page, data.PageCount);
              console.log(changeTo)
              if(changeTo){
                ajax(changeTo);
              }
            });
          });
        }else{
          showMsg("未找到相应信息");
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



//添加保证人角色下拉框事件
function addBondsManDpEvent(){
  addEventToDropdown("bonds_man_role", function(tar){
    var _role = $(tar).attr("data-name");
    $(tar).parent().siblings("span").text(_role);
  });
}
//添加新的保证人
function addBondsMan(){
  addDom('bonds_man_info', 'bonds_man_tmpl', addBondsManDpEvent);
}
//添加债权人事件
function addDebtDom(targetID, tempID){
  addDom(targetID, tempID, getProvinceData);
}

//申请寻找处置方
function applyToSearch(UserID){
  layer.open({
    content: '确定申请该处置方进行处理',
    title: 0,
    btnAlign: 'c',
    shadeClose: 'true',
    closeBtn: 0,
    btn: ['确定'],
    yes: function(index, layero){
      toApply(UserID);
      layer.close(index);
    }
  });
  function toApply(uid){
    $.ajax(
      {
        type: "get",
        dataType: "json",
        url: "/data/applyDebtSolver.json",
        data: {
          "uid": uid //提交处置方userid
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('申请成功');
          }else{
            show(data.Message); //例如申请不能超过3个
          }
        },
        complete: function () { //加载完成提示
            closeLoading();
        }
      }
    );
  }
}
