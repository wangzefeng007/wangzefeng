$(
  function(){
    //保存点击事件
    $('#save').click(function(){
      ajax();
    });

    //提交表单
    function ajax(){
      var area_info = [];
      var fee_rate_info = [];
      //决定程序是否往下执行
      var flag = true;

      // 设置方案名称
      var case_name = $('input[name="name"]').val();
      if(case_name == ''){
        $('input[name="name"]').focus();
        showMsg('请输入方案名称');
        flag = false;
        return;
      }
      if(!flag){
        return;
      }

      //添加地区信息
      $('#set_area').find('.blo').each(function(){
        if(flag){
          //获取地区信息
          var _pid = $(this).find('.p-dropdown span').attr('data-id');
          var _cid = $(this).find('.c-dropdown span').attr('data-id');
          var _aid = $(this).find('.a-dropdown span').attr('data-id');

          if(!_pid){
            showMsg('请完善地区信息');
            flag = false;
            return;
          }

          area_info.push({
            "province": _pid,
            "city": _cid,
            "area": _aid
          });
        }
      });

      if(!flag){
        return;
      }

      //添加佣金比例设置
      $('#set_fee_rate').find('.blo').each(function(){
        if(flag){
          //获取比例信息
          var _from = $(this).find('input[name="from"]').val();
          var _to = $(this).find('input[name="to"]').val();
          var is_fee = $(this).find('input[name="is_fee"]')[0].checked;
          var fee = $(this).find('input[name="fee"]').val();
          // 二期版本
          // var is_pre_fee = $(this).find('input[name="is_pre_fee"]')[0].checked;
          // var pre_fee = $(this).find('input[name="pre_fee"]').val();
          // var pre_fee_deposit = $(this).find('input[name="pre_fee_deposit"]').val();

          if(_from == ''){
            $(this).find('input[name="from"]').focus();
            showMsg('请完善佣金比例信息');
            flag = false;
            return;
          }

          if(!validate('+money', _from)){
            $(this).find('input[name="from"]').focus();
            showMsg('请输入正确的债务金额');
            flag = false;
            return;
          }

          if(_to == ''){
            $(this).find('input[name="to"]').focus();
            showMsg('请完善佣金比例信息');
            flag = false;
            return;
          }

          if(!validate('+money', _to)){
            $(this).find('input[name="to"]').focus();
            showMsg('请输入正确的债务金额');
            flag = false;
            return;
          }

          if(_to <= _from){
            $(this).find('input[name="from"]').focus();
            showMsg('请设置正确的债务金额区间');
            flag = false;
            return;
          }

          var i = {
            "from": _from,
            "to": _to
          };

          if(is_fee){
            i.isFee = 1;
            if(fee == ''){
              $(this).find('input[name="fee"]').focus();
              showMsg('请设置债务费用');
              flag = false;
              return;
            }
            if(!validate('+money', fee)){
              $(this).find('input[name="fee"]').focus();
              showMsg('请设置正确的债务费用');
              flag = false;
              return;
            }
            i.fee = fee;
          }else{
            i.isFee = 0;
          }

          // 前期费用及回款后佣金，二期版本加
          // if(is_pre_fee){
          //   i.isPreFee = 1;
          //   if(pre_fee == ''){
          //     $(this).find('input[name="pre_fee"]').focus();
          //     showMsg('请设置前期费用');
          //     flag = false;
          //     return;
          //   }
          //   if(!validate('+money', pre_fee)){
          //     $(this).find('input[name="pre_fee"]').focus();
          //     showMsg('请设置正确的前期费用');
          //     flag = false;
          //     return;
          //   }
          //   if(pre_fee_deposit == ''){
          //     $(this).find('input[name="pre_fee_deposit"]').focus();
          //     showMsg('请设置前期费用回款押金');
          //     flag = false;
          //     return;
          //   }
          //   if(!validate('+money', pre_fee_deposit)){
          //     $(this).find('input[name="pre_fee_deposit"]').focus();
          //     showMsg('请设置正确的前期费用回款押金');
          //     flag = false;
          //     return;
          //   }
          //   i.preFee = pre_fee;
          //   i.preFeeDeposit = pre_fee_deposit;
          // }else{
          //   i.isPreFee = 0;
          // }
          fee_rate_info.push(i);
        }
      });

      if(!flag){
        return;
      }

      if(area_info.length == 0){
        showMsg('请完善地区信息');
        return;
      }

      if(fee_rate_info.length == 0){
        showMsg('请完善佣金比例信息');
        return;
      }

      $.ajax({
        type: "get",
        dataType: "json",
        url: "../data/setDebt.json",
        data: JSON.stringify({
          "caseName": case_name,  //方案名称
          "feeRate": fee_rate_info, //佣金比例数组{ from: 开始区间; to: 结束区间; isFee: 1 表示有费用(此时多传fee)，0 表示无费用;
                                  //(二期版本)isPreFee: 1表示有前期费用(此时多传preFee-前期费用 preFeeDeposit-回款后押金)}； 0表示无前期费用
          "area": area_info //地区数组
        }),
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('保存成功');
            //路由跳转

          }else{
            showMsg(data.Message);
          }
        },
        complete: function(){
          closeLoading();
        }
      });

    }
  }
);

//失去焦点校验
function validateForm(type, tar){
  var text = $(tar).val();
  if(text == ''){
    showTip(tar, '请输入');
    return;
  }
  switch (type) {
    case "money":
      if(!validate("+money", text)){
        showTip(tar, '请输入正确金额');
        return;
      }
      break;
    case "rate":
      if(!validate('+number', text) || !(text > 0 && text <= 100)){
        showTip(tar, '请输入0-100整数');
        return;
      }
      break;
    default:
      return;
  }
}

//初始化省市县联动
getProvinceData();

//添加设置区域
function addAreaSet(){
  if($('#set_area').children('.blo').length < 3){
    addDom('set_area', 'set_area_tmpl', getProvinceData);
  }
}

//添加佣金比例设置
function addFeeRateSet(){
  if($('#set_fee_rate').children('.blo').length < 3){
    addDom('set_fee_rate', 'set_fee_rate_tmpl');
  }
}

//覆盖重置省市县下拉框
function resetAreaDropdown(tar, selName){
  if(selName == 'p-dropdown'){
    $(tar).parents('.p-dropdown').siblings('.c-dropdown').html(
       '<label type="checkbox">'
      +  '<span>城市</span>'
      +  '<i></i>'
      +  '<input type="checkbox" name="dd_city" value="">'
      +  '<ul></ul>'
      + '</label>'
    );
    $(tar).parents('.p-dropdown').siblings('.a-dropdown').html(
       '<label type="checkbox">'
      +  '<span>区县/市</span>'
      +  '<i></i>'
      +  '<input type="checkbox" name="dd_area" value="">'
      +  '<ul></ul>'
      + '</label>'
    );
  }
  if(selName == 'c-dropdown'){
    $(tar).parents('.c-dropdown').siblings('.a-dropdown').html(
       '<label type="checkbox">'
      +  '<span>区县/市</span>'
      +  '<i></i>'
      +  '<input type="checkbox" name="dd_area" value="">'
      +  '<ul></ul>'
      + '</label>'
    );
  }
}
