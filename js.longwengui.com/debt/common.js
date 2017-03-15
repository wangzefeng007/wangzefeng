//跳转事件
function go(url){
  window.location.href = url;
};

//loading显示隐藏
var loading;
function showLoading(){
  if(!loading){
    loading = layer.load(1, {
      shade: [0.5,'#666'],
      area: ['10px', '40px']
    });
  }
  return loading;
};
function closeLoading(){
  if(loading){
    layer.close(loading);
  }
};

//跟据name返回checkbox选中的值，数组形式返回
function getCheckboxSelectedByName(name){
  var _arr = [];
  var  _targets = $('input[name="' + name + '"]:checked');
  for(var i=0; i<_targets.length; i++){
    _arr.push(_targets[i].value)
  }
  return JSON.stringify(_arr);
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
    offset: '240px'
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
