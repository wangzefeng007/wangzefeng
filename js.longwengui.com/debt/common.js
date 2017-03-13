//跳转事件
function go(url){
  window.location.href = url;
};

//loading显示隐藏
var loading;
function showLoading(){
  if(!loading){
    loading = layer.load(1, {
      shade: [0.1,'#fff'],
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
  names.forEach(function(name){
    $('#' + name + '_all').click(function(){
      selectAllCheckbox(name);
      callback();
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

//全选、取消全选checkbox
function selectAllCheckbox(name){
  $('input[name="' + name + '"]').attr("checked","true");
};

function cancelAllCheckbox(name){
  $('input[name="' + name + '"]').removeAttr("checked");
};

//根据name给input添加事件，指定回调事件
function addInputEventByNames(names, callback){
  for(var i=0; i<names.length; i++){
    $("input[name='" + names[i] + "']").click(callback);
  }
};

//分页点击事件
function pagination(page, callback){
  callback(page);
};

//注入分页dom
function injectPagination(id, PageNums, Page, LastPage, callback){
  var htmls = "<div class='b' data-id='first'>首页</div>"
            +  "<div class='b' data-id='pre'><</div>";
  for(var i=0; i<PageNums.length; i++){
    if(PageNums[i] == Page){
      htmls += "<div class='b sel' data-id='" + PageNums[i] + "'>" + PageNums[i] + "</div>";
    }else{
      htmls += "<div class='b' data-id='" + PageNums[i] + "'>" + PageNums[i] + "</div>";
    }
  }
  htmls += "<div class='b' data-id='next'>></div>";
  $(id).html(htmls);
  callback();
};

//分页操作
function pageChange(dataId, Page, PageCount){
  console.log(dataId)
  switch (dataId) {
    case "next":
      if(Page < PageCount){
        return Page++;
      }
      break;
    case "pre":
      if(Page > 1){
        return Page--;
      }
      break;
    case "first":
      return 1;
      break;
    default:
      return dataId;
  }
}
