//跳转事件
function go(url){
  window.location.href = url;
};

//loading显示隐藏
var loading;
function showLoading(){
  loading = layer.load(1, {
    shade: [0.5,'#666'],
    area: ['10px', '40px']
  });
  return loading;
};
function closeLoading(){
  layer.close(loading);
};

//跟据name返回checkbox选中的值，数组形式返回
function getCheckboxSelectedByName(name){
  var _arr = '';
  var  _targets = $('input[name="' + name + '"]:checked');
  for(var i=0; i<_targets.length; i++){
    if(_arr == ''){
      _arr += _targets[i].value;
    }else{
      _arr += ',' + _targets[i].value;
    }
  }
  return _arr;
};

//添加全选按钮点击事件
function addSelectAllEvent(names, callback){
  adaptIE8_forEach();
  names.forEach(function(name){
    $('#' + name + '_all').click(function(){
      cancelAllCheckbox(name);
      callback(name);
    });
  })
};

//判断是否已经全选
function isSelectAll(name){
  if($('input[name="' + name + '"]:checked').length == $('input[name="' + name + '"]').length){
    return true;
  }
  return false;
}

//判断是否添加限制条件
function isLimited(name){
  if($('input[name="' + name + '"]:checked').length > 0){
    return true;
  }
  return false;
}

//全选、取消全选checkbox
function selectAllCheckbox(name){
  $('input[name="' + name + '"]').attr("checked","true");
};

function cancelAllCheckbox(name){
  $('input[name="' + name + '"]').removeAttr("checked");
};

//给下拉框添加事件
function addEventToDropdown(name, callback){
  var _this = $(".m-dropdown input[name='" + name + "']");
  _this.siblings('ul').children().each(function(){
    $(this).click(function(){
      callback(this);
    });
  });
}

//根据name给input添加事件，指定回调事件
function addInputEventByNames(names, callback){
  adaptIE8_forEach();
  names.forEach(function(name){
    var _this = $("input[name='" + name + "']");
    if(isIE8()){
      _this.parent().click(function(){
        callback(name);
      });
    }else{
      _this.click(function(){
        callback(name);
      });
    }
  });
};

//注入分页dom
function injectPagination(id, Page, LastPage, callback){
  $(id).empty();
  //总数=1，不显示分页
  if(LastPage == 1){
    callback();
  }else{
    var htmls = "<div class='b' data-id='first'>首页</div>"
              +  "<div class='b' data-id='pre'><</div>";

    var _arr = calcPageNums(LastPage, Page);

    for(var i=0; i<_arr.length; i++){
      if(_arr[i] == 0){
        htmls += "<span class='s-elipse'>...</span>"
      }else{
        //如果是当前页，则添加选中样式
        if(_arr[i] == Page){
          htmls += "<div class='b sel' data-id='" + _arr[i] + "'>" + _arr[i] + "</div>";
        }else{
          htmls += "<div class='b' data-id='" + _arr[i] + "'>" + _arr[i] + "</div>";
        }
      }
    }

    htmls += "<div class='b' data-id='next'>></div>";
    $(id).html(htmls);
    callback();
  }
};

//分页显示计算:如果page-1<=3,则前面几页全部显示; 如果pageCount-page<=3,则后面几页全部显示;其余情况均省略
function　calcPageNums(pageCount, page){
  //数组中的0表示省略
  var _arr = [];
  if(page - 1 <= 3){
    for(var i=0; i<page; i++){
      _arr.push(i + 1);
    }
  }else{
    _arr.push(1);
    _arr.push(0);
    _arr.push(page - 2);
    _arr.push(page - 1);
    _arr.push(page);
  }
  if(pageCount - page <= 3){
    for(var i=page; i<pageCount; i++){
      _arr.push(i + 1);
    }
  }else{
    _arr.push(page + 1);
    _arr.push(page + 2);
    _arr.push(0);
    _arr.push(pageCount);
  }
  return _arr;
}

//错误提示窗
function showMsg(text){
  layer.msg(text, {
    offset: '320px'
  });
}


//分页操作
function pageChange(dataId, Page, PageCount){
  switch (dataId) {
    case "next":
      if(Page < PageCount){
        return ++Page;
      }
      break;
    case "pre":
      if(Page > 1){
        return --Page;
      }
      break;
    case "first":
      return 1;
      break;
    default:
      return dataId;
  }
}

//适配ie8 不支持forEach
function adaptIE8_forEach(){
  if(!Array.prototype.forEach){
    Array.prototype.forEach = function forEach(callback, thisArg){
      var T, k;
      if(this == null){
        throw new TypeError("this is null or not defined");
      }
      var o = Object(this);
      var len = o.length >>> 0;
      if(typeof callback !== "function"){
          throw new TypeError(callback + "is not a function");
      }
      if(arguments.length > 1){
        T = thisArg;
      }
      k = 0;
      while(k < len){
        var kValue;
        if(k in o){
          kValue = o[k];
          callback.call(T, kValue, k, o);
        }
        k++;
      }
    };
  }
}

//显示提示
function showTip(id, text){
  layer.tips(text, '#' + id, {
    tips: [1, '#35bdfc'] //还可配置颜色
  });
}

//错误提示
function showErr(text){
  layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content:    "<div class='layer-err'>"
              +  "<div class='hd'>错误提示</div>"
              +   "<div class='cont'>"
              +     text
              +   "</div>"
              + "</div>"
  });
}

//判断是否ie8
function isIE8(){
  var _r = false;
   var Sys = {};
  var ua = navigator.userAgent.toLowerCase();
  if (window.ActiveXObject) {
      Sys.ie = ua.match(/msie ([\d.]+)/)[1];
      //获取版本
      var ie_version;
      if (Sys.ie.indexOf("8") > -1) {
          ie_version = 8;
          _r = true;
      }
  }
  return _r;
}

//判断是否ie9
function isIE9(){
  var _r = false;
   var Sys = {};
  var ua = navigator.userAgent.toLowerCase();
  if (window.ActiveXObject) {
      Sys.ie = ua.match(/msie ([\d.]+)/)[1];
      //获取版本
      var ie_version;
      if (Sys.ie.indexOf("9") > -1) {
          ie_version = 9;
          _r = true;
      }
  }
  return _r;
}

//添加指定模板到指定dom中
function addDom(targetID, tempID, callback){
  $('#' + tempID).tmpl().appendTo('#' + targetID);
  if(isIE8() || isIE9()){
    $('#' + targetID).find('input').each(function(){
      $(this).placeholder();
    });
  }
  if(typeof callback == "function"){
    callback();
  }
}
//删除指定父级元素
function removeParentDom(self, className){
  if($(self).parents('.' + className).siblings('.' + className).length > 0){
    $(self).parents('.' + className).remove();
  }
}

//获得省级元素
function getProvinceData(){
  $.ajax({
    type: 'get',
    dataType: 'json',
    url: '/Templates/Debt/data/Province.json',
    success: function(data){
      $('input[name="dd_province"]').each(function(){
        var _t = $(this).siblings('ul');
        var _html = '';
        for(var i=0; i<data.length; i++){
          _html +=   "<li data-id='"+ data[i].AreaID +"' data-name='" + data[i].CnName + "'>"
                  +     data[i].CnName
                  +  "</li>";
        }
        _t.html(_html);
        _t.children('li').click(function(){
          resetAreaDropdown($(this), 'p-dropdown');
          var _id = $(this).attr("data-id");
          var _name = $(this).attr("data-name");
          var _sel = $(this).parent().siblings("span");
          _sel.text(_name);
          _sel.attr('data-id', _id);
          getCityData(_id, _sel);
        });
      });
    }
  });
}
//获得市级元素
function getCityData(_pid, _sel){
  $.ajax(
    {
      type: "get",
      dataType: "json",
      url: "/Templates/Debt/data/City.json",
      success: function(data){
        var _city = [];
        for(var i=0; i<data.length; i++){
          if(data[i].ParentID == _pid){
            _city.push(data[i]);
          }
        }
        var _html = '';
        for(var i=0; i<_city.length; i++){
          _html  +=   "<li data-id='"+ _city[i].AreaID +"' data-name='" + _city[i].CnName + "'>"
                  +     _city[i].CnName
                  +  "</li>";
        }
        var _t = _sel.parents('.p-dropdown').siblings('.c-dropdown').find('ul');
        _t.html(_html);
        _t.children('li').click(function(){
          resetAreaDropdown($(this), 'c-dropdown');
          var _id = $(this).attr("data-id");
          var _name = $(this).attr("data-name");
          var __sel = $(this).parent().siblings("span");
          __sel.text(_name);
          __sel.attr('data-id', _id);
          getAreaData(_id, __sel);
        });
      }
    }
  );
}
//获得县级元素
function getAreaData(_pid, _sel){
  $.ajax(
    {
      type: "get",
      dataType: "json",
      url: "/Templates/Debt/data/Area.json",
      success: function(data){
        var _area = [];
        for(var i=0; i<data.length; i++){
          if(data[i].ParentID == _pid){
            _area.push(data[i]);
          }
        }

        var _html = '';
        for(var i=0; i<_area.length; i++){
          _html  +=   "<li data-id='"+ _area[i].AreaID +"' data-name='" + _area[i].CnName + "'>"
                  +     _area[i].CnName
                  +  "</li>";
        }
        var _t = _sel.parents('.c-dropdown').siblings('.a-dropdown').find('ul');
        _t.html(_html);
        _t.children('li').click(function(){
          var _id = $(this).attr("data-id");
          var _name = $(this).attr("data-name");
          var __sel = $(this).parent().siblings("span");
          __sel.text(_name);
          __sel.attr('data-id', _id);
        });
      }
    }
  );
}
//重置省市县下拉框
function resetAreaDropdown(tar, selName){
  if(selName == 'p-dropdown'){
    $(tar).parents('.p-dropdown').siblings('.c-dropdown').html(
       '<label type="checkbox">'
      +  '<span>*城市</span>'
      +  '<i></i>'
      +  '<input type="checkbox" name="dd_city" value="">'
      +  '<ul></ul>'
      + '</label>'
    );
    $(tar).parents('.p-dropdown').siblings('.a-dropdown').html(
       '<label type="checkbox">'
      +  '<span>*区县/市</span>'
      +  '<i></i>'
      +  '<input type="checkbox" name="dd_area" value="">'
      +  '<ul></ul>'
      + '</label>'
    );
  }
  if(selName == 'c-dropdown'){
    $(tar).parents('.c-dropdown').siblings('.a-dropdown').html(
       '<label type="checkbox">'
      +  '<span>*区县/市</span>'
      +  '<i></i>'
      +  '<input type="checkbox" name="dd_area" value="">'
      +  '<ul></ul>'
      + '</label>'
    );
  }
}

//验证方法
function validate(type, text){
  switch (type) {
    case 'phone':
      return /^1[3|4|5|8][0-9]\d{8}$/.test(text) || /^0[\d]{2,3}-[\d]{7,8}$/.test(text);
      break;
    case 'chinese':
      return /^[\u4E00-\u9FA5]|[\uF900-\uFA2D]$/.test(text);
      break;
    case 'idNum':
      return /^\d{15}$/.test(text) || /^\d{17}(\d|X|x)$/.test(text);
    case '+number':
      return /^[0-9]*[1-9][0-9]*$/.test(text);
    case '+money':
      return /^[0-9]+(\.[0-9]{1,2})?$/.test(text);
    case 'mobilePhone':
      return /^1[3|4|5|8][0-9]\d{8}$/.test(text);
    case 'password':
      return /^(\w){6,20}$/.test(text);
    default:
      return false;
  }
}

//号码验证
function validatePhone(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    if(isNeed){
      showTip(tar, '请输入');
    }
    return;
  }
  if(!validate('phone', _text)){
    showTip(tar, '请输入有效号码');
    return;
  }
}
//中文验证
function validateChinese(tar){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
  for(var i=0; i<_text.length; i++){
    if(!validate('chinese', _text[i])){
      showTip(tar, '请输入中文');
      return;
    }
  }
}
//身份证验证
function validateIDNumber(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    if(isNeed){
      showTip(tar, '请输入');
    }
    return;
  }
  if(!validate('idNum', _text)){
    showTip(tar, '请输入有效身份证');
    return;
  }
}
//验证金额
function validateMoney(tar){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
  if(!validate('+number', _text)){
    showTip(tar, '请输入正确的数字');
    $(tar).val('');
    return;
  }
}
//检验是否必须
function validateNeed(tar){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
}

//表单提示
function showTip(tar, text){
  layer.tips(text, tar, {
    tips: [1, '#35bdfc']
  });
}

//发送验证码倒计时 60秒不能重复提交 tar为button
function codeTimedown(tar){
  var pre_text = $(tar).html();
  var totalTime = 60;
  $(tar)[0].disabled = true;
  $(tar).html(totalTime + 's');
  var inr = setInterval(function(){
    totalTime--;
    var html = totalTime + 's';
    $(tar).html(html);
    if(totalTime == 0){
      $(tar).html(pre_text);
      clearInterval(inr);
      $(tar)[0].disabled = false;
    }
  }, 1000);
}
