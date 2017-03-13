$(function(){
  //声明当前页
  var cur_page;
  //给多选框添加点击事件
  addInputEventByNames(["way", "area", "money", "day"], function(name){
    ajax(1);
    if(isLimited(name)){
      $('#' + name + '_all').removeClass('sel');
    }else{
      $('#' + name + '_all').addClass('sel');
    }
  });
  //给搜索添加点击事件
  addSearchEvent();

  addSelectAllEvent(["way", "area", "money", "day"], function(name){
    ajax(1);
    $('#' + name + '_all').addClass('sel');
  });


  //添加搜索事件
  function addSearchEvent(){
    $('#btn_search').click(function(){
      ajax(1);
    });
  };

  //ajax请求数据
  function ajax(Page){
    var col_way = getCheckboxSelectedByName("way");
    var col_area = getCheckboxSelectedByName("area");
    var col_money = getCheckboxSelectedByName("money");
    var col_day = getCheckboxSelectedByName("day");
    var Keyword = $('#keyword').val();

    $.ajax({
          type: "get",	//提交类型
          dataType: "json",	//提交数据类型
          url: '../data/collection.json',  //提交地址
          data: {
              'col_way': col_way, //催收方式 1-选择律师债权 2-选择催收团队债权
              'col_area': col_area, //催收地区 1-北京市 2-上海市 3-深圳市 4-广州市 5-厦门市
              'col_money': col_money, //催收金额 1- <3w; 2- 3~10w; 3- 10~50w; 4- 50~100w; 5- >100w
              'col_day': col_day, //逾期时间 1- 0~60d; 2- 61~180d; 3- 181~365d; 4- 366~1095; 5- 1096d以上
              'Page': Page, //当前页
              'Keyword': Keyword, //搜索关键词
          },
          beforeSend: function () { //加载过程效果
              showLoading();
          },
          success: function(data) {	//函数回调
              //注入列表
              dataSuccess(data.Data);

              //获得当前页
              cur_page = data.Page;

              //注入分页
              injectPagination('#collection_page_pagination', cur_page, data.LastPage, function(){
                $('#collection_page_pagination').find('.b').click(function(){
                  var changeTo = pageChange($(this).attr('data-id'), cur_page, data.PageSize);
                  if(changeTo){
                    ajax(changeTo);
                  }
                });
              });

              if(data.ResultCode == "200"){
                  // DataSuccess(data);
              }else if(data.ResultCode == "100"){
                  layer.msg('加载出错，请刷新页面重新选择!');
              }else if(data.ResultCode == "101"){
                  // DataFailure(data);
              }else if(data.ResultCode == "102"){     //搜索有内容
                  // $("#Position").empty();
                  // $("#Search").hide();
                  // $("#Position").append('> 搜索<span  style="color:red">'+'“'+Keyword+'”'+'</span>结果');
                  // DataSuccess(data);
              }else if(data.ResultCode == "103"){ //搜索无内容
                  // $("#Position").empty();
                  // $("#Position").append('> 搜索<span  style="color:red">'+'“'+Keyword+'”'+'</span>结果');
                  // $("#Search").hide();
                  // $("#Nosearch").empty();
                  // $("#Nosearch").append('很抱歉，暂时无法找到符合您要求的产品。');
                  // $("#Filter").hide();
                  // $("#conditionpanel").hide();
                  // $(".Sequence").hide();
                  // DataFailure(data);
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
});
