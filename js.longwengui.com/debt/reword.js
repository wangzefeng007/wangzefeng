$(function(){
  var cur_page; //声明当前页

  //给多选框添加点击事件
  addInputEventByNames(["way", "area"], function(name){
    ajax(1);
    if(isLimited(name)){
      $('#' + name + '_all').removeClass('sel');
    }else{
      $('#' + name + '_all').addClass('sel');
    }
  });

  //给搜索添加点击事件
  addSearchEvent();

  //添加全部按钮事件
  addSelectAllEvent(["way", "area"], function(name){
    ajax(1);
    $('#' + name + '_all').addClass('sel');
  });


  //搜索事件处理
  function addSearchEvent(){
    $('#btn_search').click(function(){
      ajax(1);
    });
  };

  //ajax请求数据
  function ajax(Page){
    var reword_way = getCheckboxSelectedByName("way");
    var reword_area = getCheckboxSelectedByName("area");
    var Keyword = $('#keyword').val();

    $.ajax({
          type: "get",	//提交类型
          dataType: "json",	//提交数据类型
          url: '../data/reword.json',  //提交地址
          data: {
              'reword_way': reword_way, //催收方式 1-找人 2-找财产
              'reword_area': reword_area, //催收地区 1-北京市 2-上海市 3-深圳市 4-广州市 5-厦门市
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
              injectPagination('#reword_page_pagination', cur_page, data.LastPage, function(){
                $('#reword_page_pagination').find('.b').click(function(){
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

  //筛选成功执行
  function dataSuccess(data){
    $('#reword_info').empty();
    //data.Status: 1:未提交审核；2:审核中；3:悬赏中；4:已完成
    $('#reword_box').tmpl(data).appendTo('#reword_info');
  };

});
