//获得律师擅长方向元素
function getGoodAtData($wrap){
    //fixIE8Label();
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/Templates/Debt/data/Direction.json',
        success: function(data){
            fixIE8Label();
            var _html='<div class="check-all m-checkbox" onclick="goodAtCheck(this)">\
                    <label type="checkbox">\
                    <input type="checkbox"  name="goodAtAll" value="all">\
                    <i></i>全部\
                    </label>\
                    </div>';
            for(var i=0;i<data.length;i++){
                _html+='<div class="m-checkbox">\
                    <label type="checkbox">\
                    <input type="checkbox" name="goodAt" value="'+data[i].GoodID+'">\
                    <i></i>'+data[i].GoodName+'\
                    </label>\
                    </div>'
            }
            $wrap.addClass("m-checkbox-group");
            $wrap.html(_html);
        }
    });
}
//擅长类型初始化
getGoodAtData($("#goodAtBox"));

function goodAtCheck(tar){
    if($("input[name='goodAtAll']").is(":checked")){
        $("#goodAtBox :checkbox").prop("checked", true);
    }else{
        $("#goodAtBox :checkbox").prop("checked", false);
    }
}
$(
  function(){
      $("#goodAtBox").on("click","input[name='goodAt']",function(){
          if(!$(this).is(":checked")){
              $("input[name='goodAtAll']").prop("checked", false);
          }
          var checkAll=true;
          $("input[name='goodAt']").each(function(){
              if(!$(this).is(":checked")){
                  checkAll=false;
              }
          });
          if(checkAll){
              $("input[name='goodAtAll']").prop("checked", true);
          }
      });

      $("#goodAtBox.disabled").on("click","input[type='checkbox']",function(){
          return false;
      })


    //初始化地址信息
    initArea();
    $('#save').click(function(){
        ajax($('.set-debt').attr('data-id'));
    });
    //提交表单
    function ajax(id){
      var area_info = [];
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

      var goodAt=[];//擅长案件类型
        $("#goodAtBox input[name='goodAt']").each(function(){
            if($(this).is(":checked")){
                goodAt.push($(this).val());
            }
        });
        if(goodAt.length==0){
            showMsg('请选择案件擅长类型');
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
      if(!flag){
        return;
      }
      var more = $('textarea[name="more"]').val();
      $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajax.html",
        data: {
            "Intention":"SetLawFirmAid",//援助方案
            'ID': id,
            "AjaxJSON": JSON.stringify({
                "case_name": case_name,  //方案名称
                "goodAt":goodAt,    //擅长案件类型
                "area": area_info, //地区数组
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
 *  删除dom之后回调
 */
 function removeParentDomAfter(self,className){
   $("#set_fee_rate .blo").each(function(){
     var index=$(this).index()+1;
     $(this).find("input[type='radio']").attr("name","isLookForSb"+index);
   })
 }