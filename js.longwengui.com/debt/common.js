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
      for(var i=0; i<text.length; i++){
        if(!(/^[\u4E00-\u9FA5]|[\uF900-\uFA2D]$/.test(text[i]))){
          return false;
        }
      }
      return true;
      break;
    case 'idNum':
      return /^\d{15}$/.test(text) || /^\d{17}(\d|X|x)$/.test(text);
    case '+number':
      return /^[0-9]*[1-9][0-9]*$/.test(text);
    case '+money':
      return /^[0-9]+(\.[0-9]{1,2})?$/.test(text);
    case 'mobilePhone':
      return /^1[3|4|5|7|8][0-9]\d{8}$/.test(text);
    case 'password':
      return /^(\w){6,20}$/.test(text);
    case 'email':
      return /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(text);
    case 'qq':
      return /^[1-9][0-9]{6,12}$/.test(text);
    case 'creditNum':
      return /^[0-9A-Za-z]+$/.test(text);
    case 'lawJobNo':
      return /^[0-9]{17}$/.test(text);
    default:
      return false;
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
    $('label').children('input').click(function(e){
      e.stopPropagation();
    });
    $('label').click(function(){
      $(this).children('input').click();
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
  var Size = target[0].files[0].size / 1024;

  //获取当前url
  var URL = window.URL || window.webkitURL;

  //创建图片
  var blobURL = URL.createObjectURL(target[0].files[0]);

  //验证图大小
  if(Size > filemaxsize) {
      layer.msg('图片大小请不要超过' + _msg + '');
      return;
  }


  //验证图片格式
  if(!target[0].files[0].type.match(/image.*/)) {
    layer.msg('图片格式不正确!');
  }else{
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
                // Revoke when load complete
                URL.revokeObjectURL(blobURL);
            }).cropper({
                aspectRatio: _ratio, //图裁剪比例
                minContainerHeight: 380,
                minContainerWidth: 480,
            }).cropper('replace', blobURL);
        },
        end:function(index, layero){
            layer.close(index);
        }
    });
  }
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
    content:  '<div class="login">'
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
            +     '<span>忘记密码？</span>'
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

//选择债务催收方式弹窗
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
  //1 律师团队 2 催收公司 3 自助催收 /debt/publish/
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
