//债务催收

var cur_page; //声明当前页

//给搜索添加点击事件
addSearchEvent();

//添加搜索事件
function addSearchEvent(){
  $('#btn_search').click(function(){
    ajax(1);
  });
};

//添加选中事件
addSelectEvent(['way', 'area', 'money', 'day']);
function addSelectEvent(id_array){
  adaptIE8_forEach();
  id_array.forEach(function(id, i){
    $('#' + id + ' .span-1').click(function(){
      $('#' + id + ' .sel').removeClass('sel');
      $(this).addClass('sel');
      if(id == 'area' && $('#other_city').attr('data-id')){
        $('#other_city').attr('data-id', null)
        $('#other_city').html('其他城市');
      }
      ajax(1, true);
    });
    $('#' + id + ' .span-2').click(function(){
      $('#' + id + ' .sel').removeClass('sel');
      $(this).addClass('sel');
      if(id == 'area' && $('#other_city').attr('data-id')){
        $('#other_city').attr('data-id', null)
        $('#other_city').html('其他城市');
      }
      ajax(1, true);
    });
  });
}

//ajax请求数据
function ajax(Page, isSearched) {
    resetChoices();

    var col_way = $('#way .sel').attr('data-id'); //催收方式
    var col_city = $('#area .sel').attr('data-id'); //催收地区
    var col_area = $('#other_city').attr('data-id'); //其他城市
    var col_money = $('#money .sel').attr('data-id'); //催收金额
    var col_day = $('#day .sel').attr('data-id'); //逾期时间
    var Keyword = $('#keyword').val(); //搜索关键词

    $.ajax({
        type: "post",	//提交类型
        dataType: "json",	//提交数据类型
        url: '/ajax.html',  //提交地址
        data: {
            'Intention': 'GetDebtList',//提交方法
            'col_way': col_way == 0 ? 'all' : col_way, //催收方式 1-选择律师债权 2-选择催收团队债权
            'col_city': col_city == 0 ? 'all' : col_city, //催收地区 1-北京市 2-上海市 3-深圳市 4-广州市 5-厦门市
            'col_area': col_area == 0 ? 'all' : col_area, //催收地区 其他城市
            'col_money': col_money == 0 ? 'all' : col_money, //催收金额 1- <3w; 2- 3~10w; 3- 10~50w; 4- 50~100w; 5- >100w
            'col_day': col_day == 0 ? 'all' : col_day, //逾期时间 1- 0~60d; 2- 61~180d; 3- 181~365d; 4- 366~1095; 5- 1096d以上
            'Page': Page, //当前页
            'Keyword': isSearched ? 'all' : Keyword, //搜索关键词
        },
        beforeSend: function () { //加载过程效果
            showLoading();
        },
        success: function (data) {	//函数回调
            if (data.ResultCode == "200") {
                $('.no-data').hide();
                $('#collection_info').show();
                $('#collection_page_pagination').show();
                dataSuccess(data.Data); //搜索结果数据注入
                //获得当前页
                cur_page = data.Page;

                //注入分页
                injectPagination('#collection_page_pagination', cur_page, data.PageCount, function () {
                    $('#collection_page_pagination').find('.b').click(function () {
                        var changeTo = pageChange($(this).attr('data-id'), cur_page, data.PageCount);
                        if (changeTo) {
                            ajax(changeTo);
                        }
                    });
                });
            } else {
                layer.msg(data.Message);
                $('#collection_info').hide();
                $('#collection_page_pagination').hide();
                $('.no-data').show();
            }
        },
        complete: function () { //加载完成提示
            closeLoading();
        }
    });
};

//筛选成功执行;data.Status---- 1:未接单；2:催收中；3-未收回；4-部分收回；5-全部收回；6:未曝光；7-已曝光
function dataSuccess(data){
  $('#collection_info').empty();
  var _arr = [];
  _arr.push(data);
  $('#collection_table_head').tmpl(_arr).appendTo('#collection_info');
};

//其他城市选中刷新
function otherCitySel(){
  $('#area .sel').removeClass('sel');
  ajax(1, true);
}

//重置选中条件
function resetChoices(){
  var html = '';
  var array = [
    'way',
    'money',
    'day'
  ]
  for(var i=0; i<array.length; i++){
    var item = $('#' + array[i] + ' .sel');
    if(item.attr('data-id') != 0){
      html += '<span data-attr="' + array[i] + '" onclick="delChoice(this)">' + item.html() + '</span>';
    }
  }
  if($('#other_city').attr('data-id')){
    html += '<span data-attr="other_city" onclick="delChoice(this)">' + $('#other_city').html() + '</span>';
  }else{
    if($('#area .sel').attr('data-id') && $('#area .sel').attr('data-id') != 0){
      html += '<span data-attr="area" onclick="delChoice(this)">' + $('#area .sel').html() + '</span>';
    }
  }
  if($('#keyword').val() != ''){
    html += '<span data-attr="keyword" onclick="delChoice(this)">' + $('#keyword').val() + '</span>';
  }
  $('#choices').html(html);
}

//删除选中条件
function delChoice(tar){
  var type = $(tar).attr('data-attr');
  if(type == 'keyword'){
    $('#keyword').val('');
    $('#btn_search').click();
  }else if(type == 'other_city'){
    $('#other_city').attr('data-id', null)
    $('#other_city').html('其他城市');
    $('#area .span-1').addClass('sel');
    $('#btn_search').click();
  }else{
    $('#' + type).find('.span-1').click();
  }
}

//判断属于哪种情况
function whichState(status){
  if(status == 1){
    return 1;
  }else if(status == 2){
    return 2;
  }else{
    return 3;
  }
}
