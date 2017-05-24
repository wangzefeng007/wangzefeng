$(
  function(){
    //初始化地址信息
    initArea();

    //新建佣金比例方案
    $('#save').click(function(){
      ajax($('.set-debt').attr('data-id'));
    });

    //提交表单
    function ajax(id){
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
        var chargeName=$("input[name='chargeName']").val();
        var chargeMobile=$("input[name='chargeMobile']").val();
        if(!chargeName){
            showMsg('请输入负责人姓名');
            flag = false;
            return;
        }
        if(!chargeMobile){
            showMsg('请输入负责人电话');
            flag = false;
            return;
        }
      //添加地区信息
      $('#set_area').find('.blo').each(function(){
        if(flag){
          //获取地区信息
          var _pid = $(this).find('.p-dropdown span').attr('data-id');
          var _cid = $(this).find('.c-dropdown span').attr('data-id');
          var _aid = $(this).find('.a-dropdown span').attr('data-id');
          if(!_pid||!_cid||!_aid){
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

      if(area_info.length == 0){
        showMsg('请完善地区信息');
        return;
      }

      if(area_info.length > 1 && !areaRepeatTest(area_info)){
        showMsg('地区不能重叠');
        return;
      }

      //添加佣金比例设置
      $('#set_fee_rate').find('.blo').each(function(){
        if(flag){
          //获取比例信息
          var _from = $(this).find('input[name="from"]').val();
          var _to = $(this).find('input[name="to"]').val();
          var _rate = $(this).find('input[name="rate"]').val();
          var _cost = $(this).find('input[name="cost"]').val();
          var _isLookFor=$(this).find('input[name^="isLookForSb"]:checked').val();

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

          if(parseFloat(_to) <= parseFloat(_from)){
            $(this).find('input[name="from"]').focus();
            showMsg('请设置正确的债务金额区间');
            flag = false;
            return;
          }

          if(_rate == ''){
            $(this).find('input[name="rate"]').focus();
            showMsg('请完善佣金比例信息');
            flag = false;
            return;
          }

          if(!validate('+number', _rate) || !(_rate > 0 && _rate <= 100)){
            $(this).find('input[name="rate"]').focus();
            showMsg('佣金比例请输入0-100整数');
            flag = false;
            return;
          }
          if(_cost == ''){
              $(this).find('input[name="cost"]').focus();
              showMsg('请输入前期费用');
              flag = false;
              return;
          }
          if(!validate('+money', _to)){
              $(this).find('input[name="cost"]').focus();
              showMsg('请输入正确的前期费用');
              flag = false;
              return;
          }

          fee_rate_info.push({
            "from": _from,
            "to": _to,
            "rate": _rate,
            "cost":_cost,
            "isLookFor":_isLookFor
          });

        }
      });

      if(!flag){
        return;
      }

      if(fee_rate_info.length == 0){
        showMsg('请完善佣金比例信息');
        return;
      }

      if(fee_rate_info.length > 1 && !rateRepeatTest(fee_rate_info)){
        showMsg('佣金比例区间不能重叠');
        return;
      }

      var abilityDebt = $('input[name="abilityDebt"]:checked').val();
      var arrivalSite = $('input[name="arrivalSite"]:checked').val();
      var more = $('textarea[name="more"]').val();
      $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajax.html",
        data: {
            "Intention":"SetFirmDemand",//催收公司设置佣金方案
            'ID': id,
            "AjaxJSON": JSON.stringify({
                "case_name": case_name,  //方案名称
                "area": area_info, //地区数组
                "fee_rate": fee_rate_info, //佣金比例数组{ from: 开始区间; to: 结束区间; rate: 比例 }
                "abilityDebt": abilityDebt, //是否有还款能力 1 是 0 否
                "arrivalSite": arrivalSite, //是否需要债权人到达现场  1 是 0 否
                "chargeName": chargeName, //负责人姓名
                "chargeMobile": chargeMobile, //负责人电话
                "more": more  //更多介绍

            }),
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('保存成功');
            setTimeout(function() {
                window.location = data.Url;
            }, 10);
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

//初始化省市县信息
function initArea(){
  var p_tar = $('input[name="dd_province"]');
  var p_id = p_tar.siblings('span').attr('data-id');
  var c_tar = $('input[name="dd_city"]');
  var c_id = c_tar.siblings('span').attr('data-id');

  getProvinceData();
  getCityData(p_id, p_tar);
  getAreaData(c_id, c_tar);
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

//提交佣金比例重复检测; rate长度至少为2
function rateRepeatTest(rate){
  var a;
  for(var i=0; i<rate.length-1; i++){
    a = rate[i];
    for(var j=i+1; j<rate.length; j++){
      if(isRateRepeated(a, rate[j])){
        return false;
      }
    }
  }
  return true;
}
//检测佣金比例是否重叠
function isRateRepeated(a, b){
  if(parseFloat(a.from) > parseFloat(b.to) || parseFloat(a.to) < parseFloat(b.from) || parseFloat(b.from) > parseFloat(a.to) || parseFloat(b.to) < parseFloat(a.from)){
    return false;
  }else{
    return true;
  }
}

//提交地区数据重复监测; area长度至少为2
function areaRepeatTest(area){
  var a;
  for(var i=0; i<area.length-1; i++){
    a = area[i];
    for(var j=i+1; j<area.length; j++){
      if(isAreaRepeated(a, area[j])){
        return false;
      }
    }
  }
  return true;
}
//检测两个地址是否有重叠
function isAreaRepeated(a, b){
  if(a.province == b.province){
    if(a.city && b.city){
      if(a.city == b.city){
        if(a.area && b.area){
          if(a.area == b.area){
            return true;
          }else{
            return false;
          }
        }else{
          return true;
        }
      }else{
        return false;
      }
    }else{
      return true;
    }
  }else{
    return false;
  }
}

//添加指定模板到指定dom中有data渲染
function addDom2(targetID, tempID, data , callback){
    $('#' + tempID).tmpl(data).appendTo('#' + targetID);
    if(isIE8() || isIE9()){
        $('#' + targetID).find('input').each(function(){
            $(this).placeholder();
        });
        fixIE8Label();
    }
    if(typeof callback == "function"){
        callback();
    }
}
/**
 * 添加设置地区
 * @param targetID
 * @param tempID
 */
function addSetAreaDom(targetID,tempID){
    if($('#' + targetID).children('.blo').length < 3){
        addDom(targetID, tempID, getProvinceData);
    }
}

/**
 * 添加佣金比例
 * @param targetID
 * @param tempID
 */
function addRateDom(targetID,tempID){
    if($('#' + targetID).children('.blo').length < 3){
      var len=$('#' + targetID).children('.blo').length+1;
      var data={
        num:len
      }
        addDom2(targetID, tempID,data);
    }
}

/**
 *  删除dom之后回调
 */
 function removeParentDomAfter(self,className){
   $("#set_fee_rate .blo").each(function(){
     var index=$(this).index()+1;
     $(this).find("input[type='radio']").attr("name","isLookForSb"+index);
   })
 }