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

//信息提示窗
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
    fixIE8Label();
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

/**
 * 根据省code获取name
 * @param code
 * @returns {string}
 */
function getProvinceById(code){
  var provinceText="省";
  $.ajax({
      type: 'get',
      dataType: 'json',
      async:false,
      url: '/Templates/Debt/data/Province.json',
      success:function(data){
        for(var i=0;i<data.length;i++){
          if(data[i].AreaID==code){
              provinceText=data[i].CnName;
              return;
          }
        }
      }
  });
  return provinceText;
}

function getCityById(code){
    var cityText="市";
    $.ajax({
        type: 'get',
        dataType: 'json',
        async:false,
        url: '/Templates/Debt/data/City.json',
        success:function(data){
            for(var i=0;i<data.length;i++){
                if(data[i].AreaID==code){
                    cityText=data[i].CnName;
                }
            }
        }
    });
    return cityText;
}

function getAreaById(code){
    var areaText="县";
    $.ajax({
        type: 'get',
        dataType: 'json',
        async:false,
        url: '/Templates/Debt/data/Area.json',
        success:function(data){
            for(var i=0;i<data.length;i++){
                if(data[i].AreaID==code){
                    areaText=data[i].CnName;
                }
            }
        }
    });
    return areaText;
}
function getAddress(p_code,c_code,a_code){
  return {
      provinceText:getProvinceById(p_code),
      cityText:getCityById(c_code),
      areaText:getAreaById(a_code)
  }
};
//获得省级元素
function getProvinceData(){
  fixIE8Label();
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
        fixIE8Label();
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
        fixIE8Label();
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
        fixIE8Label();
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
    case 'phone': //验证电话
      return /^1[3|4|5|8][0-9]\d{8}$/.test(text) || /^0[\d]{2,3}-[\d]{7,8}$/.test(text);
      break;
    case 'fixedPhone': //验证固定电话
      return /^0[\d]{2,3}-[\d]{7,8}$/.test(text);
      break;
    case 'chinese': //验证中文
      for(var i=0; i<text.length; i++){
        if(!(/^[\u4E00-\u9FA5]|[\uF900-\uFA2D]$/.test(text[i]))){
          return false;
        }
      }
      return true;
      break;
    case 'idNum': //验证身份证
      return /^\d{17}(\d|X|x)$/.test(text);
    case '+number': //验证正整数
      return /^[0-9]*[1-9][0-9]*$/.test(text);
    case 'day': //验证天数
      return /^[0-9]*[0-9]*$/.test(text);
    case '+money': //验证金额
      return /^[0-9]+(\.[0-9]{1,2})?$/.test(text);
    case 'mobilePhone': //验证手机号码
      return /^1[3|4|5|7|8][0-9]\d{8}$/.test(text);
    case 'password': //验证密码
      return /^(\w){6,20}$/.test(text);
    case 'email': //验证邮箱
      return /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(text);
    case 'qq': //验证qq
      return /^[1-9][0-9]{6,12}$/.test(text);
    case 'creditNum': //验证信用代码
      return /^[0-9A-Za-z]+$/.test(text);
    case 'lawJobNo': //验证执业证号
      return /^[0-9]{17}$/.test(text);
    default:
      return false;
  }
}
/**
 * 验证正整数
 * @param tar
 */
function validateNumber(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('+number', _text)){
        showTip(tar, '请输入正确的正整数');
        $(tar).val('');
        return;
    }
}

//验证时间
function validateDay(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
  if(!validate('day', _text)){
    showTip(tar, '请输入正确的天数');
    return;
  }
}
//验证手机号码
function validateMobilePhone(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('mobilePhone', _text)){
        showTip(tar, '请输入正确的手机号码');
        $(tar).val("");
        return;
    }
}

//验证固定电话
function validateFixedPhone(tar){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
  if(!validate('fixedPhone', _text)){
    showTip(tar, '请输入正确的固定电话号码');
    return;
  }
}

//律师执业证号验证
function validateLawJobNo(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
  if(!validate('lawJobNo', _text)){
    showTip(tar, '请输入正确的律师执业证号');
    return;
  }
}
//社会信用代码验证
function validateCreditNum(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    showTip(tar, '请输入');
    return;
  }
  if(!validate('creditNum', _text)){
    showTip(tar, '请输入正确的社会信用代码');
    return;
  }
}
//qq验证
function validateQQ(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    if(isNeed){
      showTip(tar, '请输入');
    }
    return;
  }
  if(!validate('qq', _text)){
    showTip(tar, '请输入正确的qq');
    return;
  }
}
//邮箱验证
function validateEmail(tar, isNeed){
  var _text = $(tar).val();
  if(_text == ''){
    if(isNeed){
      showTip(tar, '请输入');
    }
    return;
  }
  if(!validate('email', _text)){
    showTip(tar, '请输入正确的邮箱');
    return;
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
    $(tar).val("");
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
  if(!validate('+money', _text)){
    showTip(tar, '请输入正确金额，最多保留2位小数');
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

//适配ie8 label定制单选、多选、下拉、文件上传框无法使用
function fixIE8Label(){
  if(isIE8()){
    $('label').each(function(){
      if(!$(this).attr('data-add')){
        $(this).attr('data-add', '1'); //添加事件添加后的标记
        $(this).children('input').click(function(e){
          e.stopPropagation();  //阻止事件冒泡
        });
        $(this).click(function(){
          $(this).children('input').click(); //模拟label点击事件
          if($(this).children('input')[0].checked){
            //如果是下拉框
            if($(this).children('input').siblings('ul')){
              $(this).children('input').siblings('ul').show();
            }
          }else{
            //如果是下拉框
            if($(this).children('input').siblings('ul')){
              $(this).children('input').siblings('ul').hide();
            }
          }
          //如果是单多选框
          if($(this).parents('.m-checkbox') || $(this).parents('.m-radio')){
            var name = $(this).children('input').attr('name');
            $('input[name="' + name + '"]').each(function(){
              if($(this)[0].checked){
                $(this).siblings('i').addClass('m-checked');
              }else{
                $(this).siblings('i').removeClass('m-checked');
              }
            });
          }
        });
      }else{
        return;
      }
    });
  }
}
//适配ie8 label 单选、多选状态初始化
function initIE8Label(){
  if(isIE8()){
    $('.m-checkbox').each(function(){
      if($(this).find('input')[0].checked){
        $(this).find('i').addClass('m-checked');
      }
    });
    $('.m-radio').each(function(){
      if($(this).find('input')[0].checked){
        $(this).find('i').addClass('m-checked');
      }
    });
  }
}

//图片裁剪上传
function imageUpload(tar, callback){
  //提交方法执行类型
  var _type = $(tar).attr('data-type');
  //图片最大能上传多少
  var _size = $(tar).attr('data-size');
  //错误提示
  var _msg = $(tar).attr('data-msg');
  //裁剪比例
  var _ratio = $(tar).attr('data-ratio');
  //上传图片大小限制
  var filemaxsize = _size; //验证图片上传大小

  //获取上传的图片大小
  var target = $(tar);

  if(!target[0].files[0]){
    return;
  }

  //验证图片格式
  if(!target[0].files[0].type.match(/image.*/)) {
    layer.msg('图片格式不正确!');
    return;
  }
  var Size = target[0].files[0].size / 1024;
  //获取当前url
  var URL = window.URL || window.webkitURL;
  //创建图片
  var blobURL = URL.createObjectURL(target[0].files[0]);
  //验证图大小
  // if(Size > filemaxsize) {
  //   layer.msg('图片大小请不要超过' + _msg + '');
  //   return;
  // }

  layer.open({
    type: 1,
    skin: 'UpAvatar',
    area: ['486px','495px'], //宽高
    closeBtn:0,
    title:'头像裁剪',
    content:"<div style=\"max-height:380px;max-width:480px;\"><img src=\"\" id=\"AvatarFile\"/></div>",
    btn: ['保存', '关闭'],
    yes: function(index, layero){
      //图片BASE64处理
      var ImgBaseData = $image.cropper("getCroppedCanvas").toDataURL('image/jpeg');
      //执行提交方法
      if(typeof callback == 'function'){
        callback(tar, ImgBaseData, index, _type);
      }else{
        imagesInput(tar, ImgBaseData, index, _type);
      }
      //执行提交方法B
      // imagesInputB(ImgBaseData,index);
    },
    success:function(index, layero){
      $image = $("#AvatarFile");
      $image.one('built.cropper', function () {
        if(!isIE8()){
          // Revoke when load complete
          URL.revokeObjectURL(blobURL);
        }
      }).cropper({
        // aspectRatio: _ratio, //图裁剪比例
        autoCropArea: 1,
        minContainerHeight: 380,
        minContainerWidth: 480,
        zoomable: false
      }).cropper('replace', blobURL);
    },
    end:function(index, layero){
      layer.close(index);
    }
  });
}

//关闭弹窗
function closeAll(){
  layer.closeAll();
}

//获得cookie
function getCookie(name){
  var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
  if(arr=document.cookie.match(reg))
  return unescape(arr[2]);
  else
  return null;
}

var times;
//弹窗登录表单
function doLogin(){
  var formData = validateForm();
  if(!formData){
    return;
  }
  $.ajax(
    {
      type: "post",
      dataType: "json",
      url: "/loginajax.html",
        data: {
            "Intention":"Login",
            "AjaxJSON":JSON.stringify(formData),
        },
      success: function(data){
        if(data.ResultCode == 200){
          closeAll();
            location.reload();
            setTimeout(function(){
            showMsg('登录成功');
          }, 300);
        }else{
          showMsg(data.Message);
          times = getCookie('PasswordErrTimes');
          if($('#code').attr('data-show') == 0 && times == 3){
            $('#code').show();
            $('#code').attr('data-show', 1);
          }
        }
      }
    }
  )
}

//弹窗登录
function toLogin(){
  var index = layer.open({
    type: 3,
    title: false,
    offset: '100px',
    area: '460px',
    closeBtn: 0,
    shadeClose: true,
    content:  '<div class="login" id="login">'
            +'<div class="form-login">'
            + '<div class="hd">'
            +   '会员登录'
            + '</div>'
            + '<div class="cont">'
            +   '<div class="line">'
            +     '<div class="info">'
            +       '手 机'
            +     '</div>'
            +     '<div class="det">'
            +       '<input type="text" name="phoneNumber" onblur="validateErr(\'phoneNumber\', this)" class="input-1" placeholder="请输入您的手机号">'
            +     '</div>'
            +     '<div class="error-hint">'
            +       '请输入手机号！'
            +     '</div>'
            +     '<div class="error-hint">'
            +       '您输入的手机号有误！'
            +     '</div>'
            +   '</div>'
            +   '<div class="line">'
            +     '<div class="info">'
            +       '密 码'
            +     '</div>'
            +     '<div class="det">'
            +       '<input type="password" name="pass" maxlength="20" onblur="validateErr(\'pass\', this)" class="input-1" placeholder="请输入密码">'
            +     '</div>'
            +     '<div class="error-hint">'
            +       '请输入密码!'
            +     '</div>'
            +     '<div class="error-hint">'
            +       '密码不能少于6位！'
            +     '</div>'
            +     '<div class="error-hint">'
            +       '密码格式有误！'
            +     '</div>'
            +   '</div>'
            +   '<div class="line" id="code" data-show="0">'
            +     '<div class="info">'
            +       '验证码'
            +     '</div>'
            +     '<div class="det">'
            +       '<input type="text" name="code" class="input-3" maxlength="4" onblur="validateErr(\'code\', this)"  placeholder="验证码">'
            +       '<img src="/code/pic.jpg" onclick="this.src=\'/code/pic.jpg?\'+Math.random();" class="v-code" alt="">'
            +     '</div>'
            +     '<div class="error-hint">'
            +       '请输入验证码!'
            +     '</div>'
            +   '</div>'
            +   '<div class="forget-pass">'
            +     '<span onclick="go(\'/member/findpasswd/\')">忘记密码？</span>'
            +   '</div>'
            +   '<div class="line">'
            +     '<div class="info">'
            +     '</div>'
            +     '<div class="det">'
            +       '<button type="button" class="btn-login" onclick="doLogin()" name="button">登 录</button>'
            +     '</div>'
            +   '</div>'
            +   '<div class="hav">'
            +     '还没有账号 <a href="/member/register/"><span>立即注册</span></a>'
            +   '</div>'
            +  '</div>'
            + '</div>'
            + '</div>'
   });
   $('input[name="phoneNumber"]').placeholder();
   $('input[name="pass"]').placeholder();
   times = getCookie('PasswordErrTimes');
   if($('#code').attr('data-show') == 0 && times >= 3){
     $('#code').show();
     $('#code').attr('data-show', 1);
   }
}

//打开城市选择弹窗
function openCitySelector(callback){
  var index = layer.open(
    {
      type: 3,
      title: false,
      offset: '100px',
      area: '460px',
      closeBtn: 0,
      shadeClose: true,
      content: '<div class="city-picker">'
              +    '<div class="city-head">'
              +      '<li class="city-tab tab-sel" onclick="changeCityPickerTab(0, this)" data-name="省份">'
              +        '省份'
              +      '</li>'
              +      '<li class="city-tab" onclick="changeCityPickerTab(1, this)" data-name="城市">'
              +        '城市'
              +      '</li>'
              +      '<li class="city-tab" onclick="changeCityPickerTab(2, this)" data-name="地区">'
              +        '地区'
              +      '</li>'
              +      '<span class="c-close" onclick="closeAll()">×</span>'
              +    '</div>'
              +    '<div class="city-body">'
              +      '<div id="city_0"></div>'
              +      '<div id="city_1"></div>'
              +      '<div id="city_2"></div>'
              +    '</div>'
              +  '</div>'
    }
  );
  getWinProvinceData(callback);
}

//获得省级元素
function getWinProvinceData(callback){
  $.ajax({
    type: 'get',
    dataType: 'json',
    url: '/Templates/Debt/data/Province.json',
    success: function(data){
      var _html = '';
      for(var i=0; i<data.length; i++){
        _html +=   "<a data-id='"+ data[i].AreaID +"' data-name='" + data[i].CnName + "'>"
                +     data[i].CnName
                +  "</a>";
      }

      $('#city_0').html(_html);

      $('#city_0 a').click(function(){
        $('#city_0 .provS').removeClass('provS');
        $(this).addClass('provS');
        $('#city_0').hide();
        $('#city_1').show();
        $('#city_2').hide();
        $('.tab-sel').removeClass('tab-sel');
        $('.city-head li').eq(1).addClass('tab-sel');
        getWinCityData($(this).attr('data-id'), callback);
      });
    }
  });
}
//获得市级元素
function getWinCityData(_pid, callback){
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
          _html  +=   "<a data-id='"+ _city[i].AreaID +"' data-name='" + _city[i].CnName + "'>"
                  +     _city[i].CnName
                  +  "</a>";
        }
        $('#city_1').html(_html);
        $('#city_1 a').click(function(){
          $('#city_1 .cityS').removeClass('cityS');
          $(this).addClass('cityS');
          $('#city_0').hide();
          $('#city_1').hide();
          $('#city_2').show();
          $('.tab-sel').removeClass('tab-sel');
          $('.city-head li').eq(2).addClass('tab-sel');
          getWinAreaData($(this).attr('data-id'), callback);
        });
      }
    }
  );
}
//获得县级元素
function getWinAreaData(_pid, callback){
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
          _html  +=   "<a data-id='"+ _area[i].AreaID +"' data-name='" + _area[i].CnName + "'>"
                  +     _area[i].CnName
                  +  "</a>";
        }
        $('#city_2').html(_html);
        $('#city_2 a').click(function(){
          $('#city_2 .areaS').removeClass('areaS');
          $(this).addClass('areaS');
          $('#other_city').attr('data-id', $(this).attr('data-id'));
          $('#other_city').html(
            $(this).attr('data-name')
          );
          layer.closeAll();
          callback();
        });
      }
    }
  );
}

//切换地区选择tab
function changeCityPickerTab(index, tar){
  $('.tab-sel').removeClass('tab-sel');
  $(tar).addClass('tab-sel');
  switch (index) {
    case 0:
      $('#city_0').show();
      $('#city_1').hide();
      $('#city_2').hide();
      $('#city_1').html('');
      $('#city_2').html('');
      break;
    case 1:
      $('#city_0').hide();
      $('#city_1').show();
      $('#city_2').hide();
      $('#city_2').html('');
      break;
    case 2:
      $('#city_0').hide();
      $('#city_1').hide();
      $('#city_2').show();
      break;
    default:
      return;
  }
}

//退出登录
$('#login_out').click(function(){
  loginOut();
});
function loginOut(){
  $.ajax({
    type: "get",
    url: "/Templates/Debt/data/loginout.json",
    dataType: "json",
    beforeSend: function(){
      showLoading();
    },
    success: function(data){
      if(data.ResultCode == 200){
        showMsg('退出成功');
        //跳转到首页

      }
    },
    complete: function(){
      closeLoading();
    }
  })
}

//选择债务催收方式弹窗->发布债务
function selDebtWayPop(){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    area: ['600px','450px'], //宽高
    shadeClose: false,
    content:   '<div class="sel-debt-way-pop">'
              +    '<div class="tl">请选择债务催收方式</div>'
              +    '<div class="way">'
              +      '<div class="m-radio mr-40">'
              +        '<label type="radio">'
              +        '<input type="radio" name="selWay" checked value="a">'
              +        '<i></i>'
              +        '自助催收'
              +        '</label>'
              +      '</div>'
              +      '<div class="m-radio">'
              +        '<label type="radio">'
              +          '<input type="radio" name="selWay" value="b">'
              +          '<i></i>'
              +          '委托催收'
              +        '</label>'
              +      '</div>'
              +      '<div class="m-dropdown">'
              +        '<label>'
              +          '<span id="to_sel" data-id="1">律师团队</span>'
              +          '<input type="checkbox" value="">'
              +          '<ul>'
              +            '<li data-id="1">律师团队</li>'
              +            '<li data-id="2">催收公司</li>'
              +          '</ul>'
              +          '<i></i>'
              +        '</label>'
              +      '</div>'
              +    '</div>'
              +    '<div class="btn">'
              +      '<button type="button" id="sel_way_ok" name="ok">确定</button>'
              +      '<button type="button" id="sel_way_cancel" name="cancel">取消</button>'
              +    '</div>'
              +    '<div class="info">'
              +      '<div class="mb-15">说明: </div>'
              +      '<p><span class="danger">自助催收：</span>小额债权早期部分欠款人非恶意欠款， 可以选择自助催收，我们提供外呼和对不还款恶意行为的债务人信息传送到各金融机构、生活平台、消费平台，因此能够起到长期的低成本催收作用，避免债权不了了之，催收成本极低，目前平台只收取回款额的5%的服务费用。</p>'
              +      '<p><span class="danger">委托催收：</span>由用户自己选择律师、催收团队或者催客帮助拿回资金，用户可以根据律师、催收团队或者催客的优势和报价来进行选择由谁接单。</p>'
              +    '</div>'
              +  '</div>'
  });
  //路由跳转  /debt/publish/ + 1 律师团队 2 催收公司 3 自助催收
  $('#sel_way_ok').click(function(){
    var way = $('input[name="selWay"]:checked').val();
    if(way == "a"){
      layer.close(index);
      window.location.href = '/debt/publish/3';
    }
    if(way == "b"){
      layer.close(index);
      window.location.href = '/debt/publish/' + $('#to_sel').attr('data-id');
    }
  });
  $('.sel-debt-way-pop .m-dropdown li').click(function(){
    var id = $(this).attr('data-id');
    $(this).parent().siblings('span').attr('data-id', id);
    $(this).parent().siblings('span').html($(this).html());
  });
  //取消提示窗口
  $('#sel_way_cancel').click(function(){
    layer.close(index);
    var index1 = layer.open({
      type: 1,
      title: 0,
      closeBtn: 0,
      area: ['330px','200px'], //宽高
      shadeClose: false,
      content: '<div class="warn-hint">'
              +    '<div class="tl">'
              +      '警告提醒'
              +     '</div>'
              +    '<div class="tx">'
              +      '<img src="/Uploads/Debt/imgs/warn.png" alt="">'
              +      '确定取消债务吗?'
              +    '</div>'
              +    '<div class="btn">'
              +      '<button type="button" id="cacel_yes" name="ok">确定</button>'
              +      '<button type="button" id="cacel_no" name="cancel">取消</button>'
              +    '</div>'
              +  '</div>'
    });
    $('#cacel_no').click(function(){
      layer.close(index1);
      selDebtWayPop();
    });
    $('#cacel_yes').click(function(){
      layer.close(index1);
    });
  });
}

//获取url参数
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var result = window.location.search.substr(1).match(reg);
    return result ? decodeURIComponent(result[2]) : null;
}
//个人中心弹窗，提示是否删除
function toDelete(text, id, intention){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint">'
            +    '<div class="tl">'
            +      '提示'
            +     '</div>'
            +    '<div class="tx">'
            +      text
            +    '</div>'
            +    '<div class="btn">'
            +      '<button type="button" id="win_yes" name="ok">确定</button>'
            +      '<button type="button" id="win_no" name="cancel">取消</button>'
            +    '</div>'
            +  '</div>'
    });
    $('#win_no').click(function(){
      layer.close(index);
    });
    $('#win_yes').click(function(){
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": intention,
          "id": id
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('操作成功');
            window.location.reload();
          }else{
            showMsg(data.Message);
          }
        },
        complete: function(){
          closeLoading();
        }
      });
    });
}

//悬赏完成确认弹窗
function confirmReword(id){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint">'
            +    '<div class="tl">'
            +      '提示'
            +     '</div>'
            +    '<div class="tx">'
            +      '是否确认该悬赏已完成?'
            +    '</div>'
            +    '<div class="btn">'
            +      '<button type="button" id="win_yes" name="ok">确定</button>'
            +      '<button type="button" id="win_no" name="cancel">取消</button>'
            +    '</div>'
            +  '</div>'
    });
    $('#win_no').click(function(){
      layer.close(index);
    });
    $('#win_yes').click(function(){
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": 'ConfirmReword',
          "id": id
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('操作成功');
            window.location.reload();
          }else{
            showMsg(data.Message);
          }
        },
        complete: function(){
          closeLoading();
        }
      });
    });
}

//左边菜单二级菜单下拉
$('.menu-level-1').each(function(){
  if($(this).attr('can-down') == 1){
    add_menu_event($(this));
  }
});
//初始化已进入页面是否展开
$('.menu-level-2-act').each(function(){
  var _for = $(this).parent().attr('data-for');
  $(this).parent().show();
  $('#' + _for).children('.i-right').attr('src', '/Uploads/Debt/imgs/tri_arrow_up.png');
  $('#' + _for).next().show();
  $('#' + _for).attr('data-open', 1);
});
function add_menu_event(tar){
  tar.click(function(e){
    var c = tar.children('.i-right');
    if(tar.attr('data-open') == 0){
      //表示此时是闭合状态
      tar.children('.i-right').attr('src', '/Uploads/Debt/imgs/tri_arrow_up.png');
      tar.next().show();
      tar.attr('data-open', 1);
    }else{
      //表示此时是展开状态
      tar.children('.i-right').attr('src', '/Uploads/Debt/imgs/arrow_tri_down.png');
      tar.next().hide();
      tar.attr('data-open', 0);
    }
  });
}

//升级成为催客
function upgradPersonRole(){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="upgrad-person-role">'
            +  '<div class="pop">'
            +    '<div class="tl">'
            +      '升级提示'
            +    '</div>'
            +    '<p>普通用户无催客权益权限</p>'
            +    '<div class="info">'
            +      '<img src="/Uploads/Debt/imgs/rock.png" alt="">升级为催客'
            +    '</div>'
            +    '<div class="btn">'
            +      '<button type="button" name="ok">确定</button>'
            +      '<button type="button" name="cancel">取消</button>'
            +    '</div>'
            +  '</div>'
            + '</div>'
    });
    $('.upgrad-person-role button[name="ok"]').click(function(){
      window.location.href = "/member/upgrade/";
    });
    $('.upgrad-person-role button[name="cancel"]').click(function(){
      layer.close(index);
    });
}

//认证中权限弹窗
function authingHint(){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint">'
            +    '<div class="tl">'
            +      '提示'
            +     '</div>'
            +    '<div class="tx">'
            +      '认证审核中，请您耐心等待!'
            +    '</div>'
            +    '<div class="btn">'
            +      '<button type="button" id="win_yes" name="ok">确定</button>'
            +    '</div>'
            +  '</div>'
    });
    $('#win_yes').click(function(){
      layer.close(index);
    });
}

//打开隆文贵服务协议
function openProtocalWindow(){
    var index = layer.open({
        type: 1,
        title: 0,
        closeBtn: 0,
        area: '600px',
        shadeClose: true,
        content: '<div class="reg">'
        +  '<div class="protocal-pop">'
        +    '<div class="popup">'
        +        '<div class="hd">'
        +            '隆文贵软件许可及服务协议'
        +            '<div class="close" id="close_protocal">'
        +                '<img src="/Uploads/Debt/imgs/close_grey.png" alt="">'
        +            '</div>'
        +        '</div>'
        +        '<div class="cont">'
        +            '<div class="para">'
        +                '<p>感谢您使用隆文贵服务!《隆文贵软件许可及服务协议》（以下简称“本协议”）由武夷山隆文贵互联网信息咨询有限公司（以下简称“隆文贵”）和您签订。您使用隆文贵软件（以下简称“本软件”）及服务前，应当阅读并遵守“本协议”，并务必审慎阅读、充分理解各条款内容。您的下载、安装、使用、浏览、注册账号、登录等行为即视为您已阅读并同意上述协议的约束。</p>'
        +                '<p>一、协议的范围</p>'
        +                '<p>1.1本协议是您与隆文贵之间关于您下载、安装、使用本软件及相关服务所订立的协议。本协议中的“用户”,一般指经过隆文贵实名认证的注册会员，包括“个人用户”、“单位用户”和“律师用户”。“个人用户”是指使用本软件相关服务的个人；“单位用户”是指使用本软件相关服务的法人或非法人组织；“律师用户”是指使用本软件相关服务的律师或律师事务所。“用户”在软件中也称为“您”。</p>'
        +                '<p>1.2本协议同时包括隆文贵可能不断发布的关于本服务的相关协议、规则、合同等内容。上述内容在本软件中一经发布，即为本协议不可分割的组成部分，您同样应当遵守。</p>'
        +                '<p>1.3隆文贵可能会变更本协议及相关协议、规则、合同等内容，变更内容在本软件中一经公布，即应生效。如您继续使用，视为同意内容变更。</p>'
        +                '<p>二、关于本服务</p>'
        +                '<p>2.1 本服务的内容</p>'
        +                '<p>本软件提供的服务（以下简称“本服务”）是指隆文贵向用户提供债权、法律服务的在线交流、交易平台的软件工具。用户依托本软件发布债权、法律服务的需求或提供债权、法律服务的供给，通过在线交流，订立合同，以及相关功能或内容的许可及服务。包括但不限于以下主要内容：</p>'
        +                '<p>2.1.1债务催收：在软件界面显示为“催收”或“债务催收”，是指：发单用户（债权人或债权人的委托人）对他人拥有债权，需要委托接单用户负责清收债权，可在“催收”功能下发布债权信息和委托需求；愿意接受委托的接单用户会向发单用户发送提供法律服务的意愿；发单用户确认委托其中之一接单用户后，双方可签订《委托追债合同》，约定双方建立法律服务委托关系，接单用户按照实际回款的约定比例收取佣金。隆文贵作为《委托追债合同》一方，提供在线交流签约、履约保证金保管、代付佣金等服务。使用本服务，需遵守《委托追债规则》。</p>'
        +                '<p>2.1.1债务催收：在软件界面显示为“催收”或“债务催收”，是指：发单用户（债权人或债权人的委托人）对他人拥有债权，需要委托接单用户负责清收债权，可在“催收”功能下发布债权信息和委托需求；愿意接受委托的接单用户会向发单用户发送提供法律服务的意愿；发单用户确认委托其中之一接单用户后，双方可签订《委托追债合同》，约定双方建立法律服务委托关系，接单用户按照实际回款的约定比例收取佣金。隆文贵作为《委托追债合同》一方，提供在线交流签约、履约保证金保管、代付佣金等服务。使用本服务，需遵守《委托追债规则》。</p>'
        +                '<p>2.1.3债权转让：在软件页面显示为“转”，是指：（1）用户对他人拥有金钱债权，希望将该债权转让，可在软件“转”页面上发布债权转让消息；（2）用户对其他用户发布的债权转让信息有受让意向，可回复该信息；（3）本软件为用户在线推荐进行债权转让的专业律师。</p>'
        +                '<p>2.1.4在线咨询：用户在“咨询”页面可咨询在线注册、认证、发单、债权服务等问题，由平台客服给予答复。</p>'
        +                '<p>2.2 服务形式</p>'
        +                '<p>2.2.1您可通过隆文贵网站（www.longwengui.net或www.longcheng513.com）、隆文贵移动客户端、隆文贵微信公众号等方式获取服务。对于这些服务，隆文贵给予您一项个人的、不可转让及非排他性的许可。您仅可为访问和使用本服务的目的使用这些软件及服务。本条及本协议其他条款未明示授权的其他一切权利仍由隆文贵保留。</p>'
        +                '<p>2.2.2本服务中隆文贵客户端软件提供包括但不限于iOS、Android等多个应用版本，用户必须选择与所安装终端设备相匹配的软件版本。</p>'
        +                '<p>三、软件的获取、安装与卸载</p>'
        +                '<p>3.1 您可以直接从隆文贵网站（www.longwengui.net或www.longcheng513.com）获取本软件，也可从隆文贵授权的第三方平台获取。如果您从未经隆文贵授权的第三方获取本软件或与本软件名称相同的安装程序，隆文贵无法保证该软件能正常使用，并对因此给您造成的损失不负责任。</p>'
        +                '<p>3.2 隆文贵可能为不同的终端设备开发了不同的软件版本，您应当根据实际情况选择下载合适的版本并按照该程序提示的步骤正确安装。</p>'
        +                '<p>3.3 为提供更加优质、安全的服务，在本软件安装时隆文贵可能推荐您安装其他软件，您可以选择安装或不安装。</p>'
        +                '<p>3.4 如果您不再需要使用本软件或者需要安装新版软件，可以自行卸载。软件卸载后，为保障交易安全，账户下的发布、交易等涉及其他方权利义务的信息记录，隆文贵仍有权予以保留。</p>'
        +                '<p>四、软件的更新</p>'
        +                '<p>4.1 隆文贵将不断开发新的服务，并不时提供软件更新，这些更新可能会采取软件替换、修改、功能强化、版本升级等形式。</p>'
        +                '<p>4.2 为保证本软件及服务的安全性和功能的一致性，隆文贵有权不经向您特别通知而对软件进行更新，或者对软件的部分功能进行改变或限制。</p>'
        +                '<p>4.3 本软件新版本发布后，旧版本可能无法使用。隆文贵不保证旧版本软件的继续可用及相应的客户服务，请您随时核对并下载最新版本。</p>'
        +                '<p>五、个人信息保护</p>'
        +                '<p>5.1 保护用户个人信息是隆文贵的基本原则。隆文贵将按照国家网络安全相关规定和国家信息安全等级保护制度的要求，设置完善的防火墙、入侵检测、数据加密以及灾难恢复等网络安全设施和管理制度，采取完善的管控措施和技术手段，严格保护用户的个人信息安全。用户在注册账号或使用本服务的过程中，需要您提供或者隆文贵需获取一些必要信息，如姓名/名称、证照号码、电话/手机号码、地理位置信息等。除法律法规规定、软件正常公开信息功能的情形外，未经用户许可隆文贵不会向第三方公开、透露用户个人信息。</p>'
        +                '<p>5.2 您理解并同意：本软件的某些功能可能会让第三方知晓用户的信息，例如：用户发布消息或回复其他用户消息时，其他用户可以查询用户头像、名字等可公开的个人资料，债务人的名称、地址、电话、手机号码、债务金额、债权凭证等信息。在线交流时，用户头像、名字/名称、消息内容、图片等信息，交互方可以查询。查看合同时，用户的真实姓名/名称、证件号码、地址、联系方式等内容，可供相对方查阅。</p>'
        +                '<p>5.3 您了解并同意，如政府部门（包括司法及行政部门）要求，隆文贵将向其提供您在软件中的信息和交易记录等必要信息。如您涉嫌侵犯他人合法权益，隆文贵亦有权在初步判断涉嫌侵权行为存在的情况下，向权利人提供您必要的信息。</p>'
        +                '<p>六、账号注册、认证与使用</p>'
        +                '<p>6.1 您在未经注册前，只能浏览本软件的部分内容，不能进行其他操作。</p>'
        +                '<p>6.2 使用本软件查看完整信息和进行任何实质操作，都需完成账号注册。您了解并同意：</p>'
        +                '<p>6.2.1 您至少满足以下一个条件：</p>'
        +                '<p>（1）年满十八周岁，具有民事权利能力和民事行为能力的自然人；</p>'
        +                '<p>（2）无民事行为能力人或限制民事行为能力人应经过其监护人的同意；</p>'
        +                '<p>（3）根据中国法律、法规、行政规章成立并合法存在的机关、企事业单位、社团组织和其他组织。</p>'
        +                '<p>不满足上述条件之一的用户与隆文贵之间的协议自始无效，隆文贵一经发现，有权立即终止本服务，并追究其一切法律责任。</p>'
        +                '<p>6.2.2 账号注册时，个人需提供本人手机号码，单位需提供单位名称、操作人员手机号码，律师需提供本人执业证号/实习证号、手机号码等真实信息，完成注册。</p>'
        +                '<p>6.2.3 一个手机号码只能验证注册一个账号，具体验证方式以本网站页面提示为准。</p>'
        +                '<p>6.2.4 您注册账户中设置的昵称、头像、签名、留言等必须遵守法律法规、公序良俗、社会公德，且不会侵害其他第三方的合法权益，否则隆文贵可能会取消您的昵称、头像、签名。</p>'
        +                '<p>6.3 实名认证。用户在进行发单、接单等操作前，还需提供相关证件信息和证照彩色照片等进行实名认证。您了解并同意，您有义务保证您提供信息的真实性及有效性。</p>'
        +                '<p>6.3.1 个人用户需提供您的真实姓名、身份证号码，同时必须上传有效身份证件正反面彩色照片等；</p>'
        +                '<p>6.3.2 单位用户应当提供单位全称、组织机构代码（或三证合一的营业执照）、单位地址、单位负责人、操作人姓名及身份证号等真实信息，同时必须上传组织机构代码证（或三证合一的营业执照）、操作人单位授权书的彩色照片等；</p>'
        +                '<p>6.3.3 律师用户需要提供您的真实姓名、身份证号码、执业证号/实习证号、所在律师事务所名称及律师事务所地址，同时必须上传执业证/实习证首页和年检页的彩色照片等。</p>'
        +                '<p>6.3.4 隆文贵将依据您提供的信息进行实名认证，若您提供的信息资料错误、不实、过时或不完整，隆文贵有权向您发出询问及/或要求改正的通知，并有权直接做出删除相应资料的处理，直至中止、终止对您提供部分或全部服务。隆文贵对此不承担任何责任，您将承担因此产生的任何直接或间接支出。</p>'
        +                '<p>6.4 您的信息发生变化时，应当及时更新您提交给隆文贵的相关信息。</p>'
        +                '<p>6.5 您提供的电子邮件地址、联系电话等联系方式应当真实准确有效，以便隆文贵或其他用户与您进行有效联系，因通过您提供的联系方式无法与您取得联系，导致您产生任何损失或费用增加的，应由您完全独自承担。</p>'
        +                '<p>6.6 一般情况下，您可随时浏览、修改自己提交的账户信息，但出于安全性和身份识别的考虑，经实名认证的信息，除有合理理由外，您无法再行修改。</p>'
        +                '<p>6.7 您的账户由您自行设置和保管，您有责任妥善保管账户信息及账户密码安全，需对使用账户及密码的行为承担法律责任。账户因您泄露或遭受他人攻击、诈骗、盗取等行为导致的损失及后果，均由您自行承担。</p>'
        +                '<p>6.8 如发现任何未经授权使用您账户登录本软件或其他可能导致您账户遭窃、遗失的情况，建议您立即通知隆文贵。请您理解隆文贵对您的任何请求采取行动均需要合理时间，除隆文贵存在过错外，隆文贵对在采取行动前已经产生的后果不承担责任。</p>'
        +                '<p>6.9 账户的所有权归隆文贵所有，用户完成申请注册手续后，仅获得账户的使用权，且该使用权仅属于注册本人。同时，注册本人不得赠与、借用、租用、转让或售卖账户或者以其他方式许可非注册本人使用账户。非注册本人不得通过受赠、继承、承租、受让或者其他任何方式使用账户。因注册本人违反以上规定，由非注册本人使用账户发生的一切后果，由注册本人承担。</p>'
        +                '<p>6.10 如出现以下情况，隆文贵有权暂停、中止、回收或删除该账号及封存或删除账号下信息，由此带来的任何损失均由用户自行承担：</p>'
        +                '<p>（1） 未通过实名认证；</p>'
        +                '<p>（2）连续六个月未登录，且不存在未到期的有效业务等；</p>'
        +                '<p>（3）违反法律法规、本软件各服务协议或业务规则的规定。</p>'
        +                '<p>七、隆文贵公司的权利与义务</p>'
        +                '<p>7.1 本软件下的个人用户、单位用户和律师用户，隆文贵对其身份和注册信息予以合理审查，但您应同意并理解因隆文贵审查能力有限，隆文贵不能完全确保审查结果的准确，您仍应尽到谨慎注意义务。</p>'
        +                '<p>7.2 本软件仅为用户提供一个信息交流和交易平台，是发单方发布需求和接单方提供法律服务的一个交易市场，本平台对交易双方均不加以控制，合同关系的建立是交易双方自主确定的结果，隆文贵不对任何一方提供担保义务。</p>'
        +                '<p>7.3 隆文贵对用户交易形成的电子合同通过第三方服务器端进行保管，适用《中华人民共和国电子签名法》等相关法律法规。</p>'
        +                '<p>7.4 本软件有权在提供服务的过程中自行或由第三方广告商向您发送广告、推广或宣传信息（包括商业与非商业信息），其方式和范围可不经向您特别通知而变更。您应当自行判断广告信息的真实性并为自己的判断行为负责，除法律明确规定外，您因依该广告信息进行的交易或前述广告商提供的内容而遭受的损失或损害，隆文贵不承担责任。</p>'
        +                '<p>7.5 本软件在现有技术水平的基础上努力确保网上交流、交易平台的正常运行，尽力避免服务中断或将中断时间限制在最短时间内；</p>'
        +                '<p>7.6 隆文贵对您使用本软件中所遇到的问题及反映的情况及时回复；</p>'
        +                '<p>7.7 隆文贵有权在不通知用户的前提下，删除或采取其他限制性措施处理下列信息：存在欺诈等恶意或虚假内容；与网上交易无关或不以交易为目的；存在恶意竞价或其他试图扰乱正常交易秩序因素；违反公共利益或可能严重损害隆文贵和其他用户合法利益。</p>'
        +                '<p>7.8 因网上信息平台的特殊性，隆文贵没有义务对所有用户的交易行为以及与交易有关的其他事项进行事先审查，但如发生以下情形，隆文贵有权无需征得用户的同意限制用户的活动、向用户核实有关资料、发出警告通知、暂时中止、无限期中止及拒绝向该用户提供服务：</p>'
        +                '<p>（1）用户违反本协议或本软件的相关协议及规则；</p>'
        +                '<p>（2）存在用户或其他第三方通知隆文贵，认为某个用户或具体交易事项存在违法或不当行为，并提供相关证据，而本平台无法联系到该用户核证或验证该用户向本软件提供的任何资料；</p>'
        +                '<p>（3）存在用户或其他第三方通知隆文贵，认为某个用户或具体交易存在违法或不当行为，并提供相关证据。本平台以普通非专业交易者的知识水平标准对相关内容进行判别，可以明显认为这些内容或行为可能对本软件用户或隆文贵造成损失或法律责任。</p>'
        +                '<p>7.9 根据国家法律、法规、行政规章、本协议的内容和隆文贵所掌握的事实依据，可以认定该用户存在违法或违反本协议行为以及在本软件交易平台上的其他不当行为，隆文贵有权无需征得用户同意在本软件交易平台及所在软件上以网络发布形式公布该用户的违法行为，并有权随时作出删除相关信息、终止提供服务等处理；</p>'
        +                '<p>7.10 隆文贵依据本协议及相关规则，可以冻结、使用、先行赔付、退款、处置用户充值或托管在本软件账户内的资金。被封号的用户如果账户中有资金，在扣除用户不正当收入后，用户可申请提现。</p>'
        +                '<p>八、用户使用规范</p>'
        +                '<p>8.1 您在使用本软件服务过程中的所有行为均应遵守国家法律、法规等规范性文件及本软件各项规则的规定和要求，不能违背社会公共利益或公共道德，不得损害他人的合法权益，不违反本协议及相关规则。如违反前述承诺，产生任何法律后果，您应独立承担所有法律责任，并确保隆文贵免于因此产生的任何损失。</p>'
        +                '<p>8.2 您必须为自己注册账号下的一切行为负责。您应对本服务的内容自行判断，并承担所有风险，包括因对内容的正确性、完整性或实用性的依赖而产生的风险。隆文贵无法且不会对因前述风险而导致的任何损失或损害承担责任。</p>'
        +                '<p>8.3 除非法律允许或隆文贵书面许可，您不得从事下列行为：</p>'
        +                '<p>（1） 提交、发布虚假信息，或冒充、利用他人名义的；</p>'
        +                '<p>（2）诱导其他用户点击链接页面或分享信息的；</p>'
        +                '<p>（3）虚构事实、隐瞒真相以误导、欺骗他人的；</p>'
        +                '<p>（4）侵害他人名誉权、肖像权、隐私权、知识产权、商业秘密等合法权利的；</p>'
        +                '<p>（5）未经隆文贵书面许可利用账号和任何功能，以及第三方运营平台进行推广或互相推广的；</p>'
        +                '<p>（6）对本软件上的任何数据作商业性利用，包括但不限于在未经隆文贵事先书面同意的情况下，以复制、传播等任何方式使用本软件上展示的资料的；</p>'
        +                '<p>（7） 利用账号或本软件及服务从事任何违法犯罪活动的；</p>'
        +                '<p>（8）使用任何装置、软件或例行程序干预或试图干预本软件正常运作或正在本软件上进行的任何交易、活动的；</p>'
        +                '<p>（9）制作、发布与以上行为相关的方法、工具，或对此类方法、工具进行运营或传播，无论这些行为是否为商业目的；</p>'
        +                '<p>（10） 其他违反法律法规规定、侵犯其他用户合法权益、干扰产品正常运营或隆文贵未明示授权的行为。</p>'
        +                '<p>8.4 您在与其他用户交易过程中，应遵守诚实信用原则，不采取不正当竞争行为，不扰乱网上交易的正常秩序，不从事与交易无关的行为。用户的行为应当基于真实的需求和供给，不得实施虚假交易、恶意磋商、恶意交易、恶意维权等扰乱本软件平台正常交易秩序的行为。</p>'
        +                '<p>8.5 您在使用本软件服务过程中，所产生的应纳税赋，以及一切硬件、软件、服务及其它方面的费用，均由您自行承担。</p>'
        +                '<p>8.6您发现其他用户发布的信息或进行的其他违反国家法律法规或本软件各项协议与规则的行为，或侵害自己或他人的合法权益的，有权通过“举报”和“客服”通道进行举报。</p>'
        +                '<p>九、交易争议处理</p>'
        +                '<p>您在交易过程中与其他用户发生争议的，有权选择以下途径解决，必要时可申请隆文贵给予适当的协助：</p>'
        +                '<p>（1）与争议相对方自主协商；</p>'
        +                '<p>（2）请求律师协会或者其他依法成立的调解组织调解；</p>'
        +                '<p>（3）向有关行政部门投诉；</p>'
        +                '<p>（4）根据与争议相对方达成的仲裁协议（如有）提请仲裁机构仲裁；</p>'
        +                '<p>（5）向人民法院提起诉讼。</p>'
        +                '<p>十、费用</p>'
        +                '<p>除本软件相关交易规则中规定的收费业务外，隆文贵向您提供的服务目前是免费的。隆文贵向您提供这些服务需要成本，如未来向您收取合理费用，隆文贵会采取合理途径并以足够合理的期限提前通过法定程序并以本协议约定的方式通知您，确保您有充分选择的权利。</p>'
        +                '<p>十一、责任限制</p>'
        +                '<p>11.1 隆文贵负责“按现状”和“可得到”的状态向您提供平台服务。隆文贵依法律规定承担基础保障义务，但无法对由于信息网络设备维护、连接故障，电脑、通讯、病毒或其他系统的故障，电力故障，罢工，暴乱，火灾，洪水，风暴，爆炸，战争，政府行为，司法行政机关的命令或因第三方原因而给您造成的损害结果承担责任。</p>'
        +                '<p>11.2 隆文贵将会尽其商业上的合理努力保障您在本软件及服务中的数据存储安全，但是对本软件服务不作任何明示或暗示的保证，包括但不限于本软件服务的适用性、没有错误或疏漏、持续性、准确性、可靠性、适用于某一特定用途。同时，隆文贵也不对本软件服务所涉及的技术及信息的有效性、准确性、正确性、可靠性、质量、稳定、完整和及时性作出任何承诺和保证。对此您应谨慎判断，并自行承担因此产生的责任与损失。</p>'
        +                '<p>11.3 您了解并同意，隆文贵不对下述情况导致的任何损害赔偿承担责任：</p>'
        +                '<p>（1）使用或未能使用本软件服务；</p>'
        +                '<p>（2）第三方未经批准地使用您的账户或更改您的数据；</p>'
        +                '<p>（3）通过本软件服务获取任何数据、信息或进行交易等行为或替代行为产生的费用及损失；</p>'
        +                '<p>（4）您对本软件服务的误解；</p>'
        +                '<p>（5）任何非因隆文贵的原因而引起的与本软件服务有关的其它损失。</p>'
        +                '<p>十二、用户注意事项</p>'
        +                '<p>12.1 为了向您提供有效的服务，本软件会利用您终端设备的处理器和带宽等资源。本软件使用过程中可能产生数据流量的费用，用户需自行承担。</p>'
        +                '<p>12.2 本软件用户应加强信息安全及个人信息的保护意识，注意密码保护，以免遭受损失。 在任何情况下，您不应轻信转款、索要密码或其他涉及财产的网络信息。涉及财产操作的，请一定先核实对方身份，并请经常留意隆文贵有关防范诈骗犯罪的提示。</p>'
        +                '<p>12.3  您在使用本软件服务或要求平台提供特定服务时，若使用或访问的结果由第三方提供的，隆文贵不保证通过第三方提供服务及内容的安全性、准确性、有效性及其他不确定的风险，由此若引发的任何争议及损害，与隆文贵无关，隆文贵不承担任何责任。您在使用本软件第三方提供的产品或服务时，除遵守本协议约定外，还应遵守第三方的用户协议。</p>'
        +                '<p>十三、知识产权声明</p>'
        +                '<p>13.1 隆文贵是本软件的知识产权权利人。本软件的一切知识产权，以及与本软件相关的所有信息内容均受中华人民共和国法律法规和相应的国际条约保护，隆文贵享有上述知识产权，但相关权利人依照法律规定应享有的权利除外。</p>'
        +                '<p>13.2 未经隆文贵或相关权利人书面同意，您不得为任何商业或非商业目的自行或许可任何第三方实施、利用、转让上述知识产权。</p>'
        +                '<p>13.3 除非法律允许或隆文贵书面许可，您不得从事下列行为：</p>'
        +                '<p>（1） 删除本软件及其副本上关于著作权的信息；</p>'
        +                '<p>（2） 对本软件进行反向工程、反向汇编、反向编译，或者以其他方式尝试发现本软件的源代码；</p>'
        +                '<p>（3）对隆文贵拥有知识产权的内容进行使用、出租、出借、复制、修改、链接、转载、汇编、发表、出版、建立镜像站点等；</p>'
        +                '<p>（4） 对本软件的任何数据进行复制、修改、增加、删除、挂接运行或创作任何衍生作品等；</p>'
        +                '<p>（5）修改或伪造软件运行中的指令、数据，增加、删减、变动软件的功能或运行效果，或者将用于上述用途的软件、方法进行运营或向公众传播；</p>'
        +                '<p>（6） 通过非隆文贵开发、授权的第三方软件、插件、外挂、系统，登录或使用本软件及服务，或制作、发布、传播上述工具；</p>'
        +                '<p>（7） 自行或授权他人对本软件及其组件、模块、数据进行干扰；</p>'
        +                '<p>（8）其他未经隆文贵明示授权的行为。</p>'
        +                '<p>十四、用户的违约及处理</p>'
        +                '<p>14.1 隆文贵可在相关规则中约定违约认定的标准和程序。发生如下情形之一的，视为您违约：</p>'
        +                '<p>（1）使用隆文贵服务时违反有关法律法规规定的；</p>'
        +                '<p>（2）违反本协议或本软件相关协议及规则的。</p>'
        +                '<p>14.2 违约处理措施</p>'
        +                '<p>【信息处理】构成违约的，可立即对相应信息进行删除、屏蔽处理。</p>'
        +                '<p>【行为限制】构成违约的，可对您执行警告、账户扣分、中止提供部分或全部服务、扣罚履约保证金、收取违约金等处理措施。如构成根本违约的，可冻结账户，终止服务。</p>'
        +                '<p>【隆文贵账户处理】违约的同时存在欺诈、盗用他人账户等特定情形或存在危及他人交易安全或账户安全风险的，依照行为的风险程度对该用户隆文贵账户采取取消收款、资金止付等强制措施。</p>'
        +                '<p>【处理结果公示】隆文贵可对违约行为处理措施信息以及其他经国家行政或司法机关生效法律文书确认的违法信息在隆文贵上予以公示。</p>'
        +                '<p>14.3 赔偿责任</p>'
        +                '<p>（1）违约行为使隆文贵遭受损失（包括直接损失和间接损失），违约用户应赔偿隆文贵全部损失；</p>'
        +                '<p>（2）违约行为使隆文贵遭受第三人主张权利，隆文贵可就全部损失向违约用户追偿；</p>'
        +                '<p>（3）因违约行为使第三人遭受损失或违约用户怠于履行本协议及相关规则的，隆文贵可从该用户隆文贵账户中划扣相应款项进行支付。如该隆文贵账户余额不足的，可直接抵减其在隆文贵其它协议项下的权益，并可继续追偿。</p>'
        +                '<p>十五、协议终止</p>'
        +                '<p>15.1 您了解并同意，隆文贵有权可不经事先通知以任何理由自行全权决定关停本软件，这将导致终止向您提供本软件的全部服务，且无须为此向您或任何第三方承担任何责任。在终止服务后，隆文贵除负责未完成的履约保证金服务和隆文贵提现功能外，不再提供其他服务。</p>'
        +                '<p>15.2 账户注销。您有权向隆文贵申请注销账户，经审核同意注销后，您与隆文贵的合同关系即行终止。账户注销后，您在隆文贵的注册信息和所有交易信息不可查询。注销账户应满足以下条件：</p>'
        +                '<p>（1）合同交易全部履行完毕，与交易相对方不存在任何争议，隆文贵账户下没有履约保证金；</p>'
        +                '<p>（2）不存在尚未处理完毕违反法律法规、违反本协议和相关规则、侵害人隆文贵或第三方利益等事项；</p>'
        +                '<p>（3）满足《隆文贵服务协议》规定的注销隆文贵账户条件；</p>'
        +                '<p>（4）根据实际情况需要满足的其他合理要求。</p>'
        +                '<p>15.3 您不同意接受变更事项，应在变更事项生效前停止使用本软件，并向隆文贵书面明示不愿接受变更事项并终止本协议。在满足15.2条件时，账户自动注销，本协议终止。</p>'
        +                '<p>15.4 出现以下情况时，隆文贵可通知您终止本协议：</p>'
        +                '<p>（1）严重违反本协议及相关协议约定，包括但不限于盗用他人账户、发布违禁信息、骗取他人财物、扰乱市场秩序、采取不正当手段谋利等行为的；</p>'
        +                '<p>（2）多次违反本软件规则等相关规定，经警告，仍不改正或情节严重的；</p>'
        +                '<p>（3）账户被隆文贵依据本协议注销的；</p>'
        +                '<p>（4）其它应当终止服务的情况。</p>'
        +                '<p>15.5 您同意，您与隆文贵的合同关系终止后，隆文贵仍享有下列权利：</p>'
        +                '<p>（1）继续保留您的注册信息及您使用本软件服务期间的所有交易信息；</p>'
        +                '<p>（2）继续保留涉及到侵害其他用户或第三方权益，或公权力机关要求予以保留的信息；</p>'
        +                '<p>（3）您在使用本软件服务期间存在违法行为或违反本协议和/或规则的行为，隆文贵仍可向您主张权利。</p>'
        +                '<p>15.6 服务终止后，对于您之前的交易行为，您应独立处理并完全承担进行以下处理所产生的任何争议、损失或增加的任何费用，并应确保隆文贵免于因此产生任何损失或承担任何费用：</p>'
        +                '<p>（1）您在服务中止或终止之前已经在本软件发布消息但尚未形成交易的，隆文贵有权在中止或终止服务的同时删除相关信息；</p>'
        +                '<p>（2）您在服务中止或终止之前，已经与其他用户形成交易的，隆文贵可以不删除该项交易，但隆文贵有权在中止或终止服务的同时将相关情形通知您的交易对方。</p>'
        +                '<p>15.7您的账户被注销后，隆文贵没有义务为您保留或向您披露您账户中的任何信息。</p>'
        +                '<p>十六、其他</p>'
        +                '<p>16.1 您使用本软件即视为您已阅读并同意接受本协议的约束。隆文贵有权在必要时修改本协议条款。您可以在本软件的最新版本中查阅相关协议条款。本协议条款变更后，如果您继续使用本软件，即视为您已接受修改后的协议。如果您不接受修改后的协议，应当停止使用本软件。</p>'
        +                '<p>16.2 本协议签订地为中华人民共和国福建省武夷山。</p>'
        +                '<p>16.3 本协议的成立、生效、履行、解释及纠纷解决，适用中华人民共和国大陆地区法律（不包括冲突法）。</p>'
        +                '<p>16.4 若您和隆文贵之间发生任何纠纷或争议，首先应友好协商解决；协商不成的，您同意将纠纷或争议提交本协议签订地有管辖权的人民法院管辖。</p>'
        +                '<p>16.5 本协议所有条款的标题仅为阅读方便，本身并无实际涵义，不能作为本协议涵义解释的依据。</p>'
        +                '<p>16.6 本协议条款无论因何种原因部分无效或不可执行，其余条款仍有效，对双方具有约束力。</p>'
        +                '<p>16.7隆文贵对本服务协议包括基于本协议制定的各项规则拥有最终解释权。</p>'
        +            '</div>'
        +            '<div class="confirm-btn">'
        +                '<button type="button" id="agree_protocal" name="button">同意并继续</button>'
        +            '</div>'
        +        '</div>'
        +    '</div>'
        +   '</div>'
        + '</div>'
    });

    //关闭
    $('#close_protocal').click(function(){
        layer.close(index);
    });
    //同意协议
    $('#agree_protocal').click(function(){
        var _tar = $('.m-checkbox input[name="agreement"]')[0];
        _tar.checked = true;
        $('.m-checkbox input[name="agreement"]').siblings('i').addClass('m-checked');
        layer.close(index);
    });
}

