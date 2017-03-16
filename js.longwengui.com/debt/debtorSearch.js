$(function(){
  //声明当前页
  var cur_page;

  //添加下拉框事件
  addEventToDropdown("area", function(tar){
    var areaName = $(tar).attr("data-name");
    $("#area_sel").text(areaName == "" ? "all" : areaName);
  });

  //添加搜索事件
  $("#search").click(function(){
    ajax(1);
  });

  //请求数据
  function ajax(Page){
    var key = $("#keyword").val();
    var area_sel = $("#area_sel").text();
    var id_num = $("#id_num").val();

    $.ajax({
          type: "post",	//提交类型
          dataType: "json",	//提交数据类型
          url: '/ajax.html',  //提交地址
          data: {
              'Intention':'debtorSearch',
              'iname': key, //姓名
              'Page': Page, //当前页
              'cardNum': id_num, //身份证号
              'areaName': area_sel //地区
          },
          beforeSend: function () { //加载过程效果
              showLoading();
          },
          success: function(data) {	//函数回调
              //注入列表
                if(data.ResultCode=='200'){
                    dataSuccess(data.Data);
                    // 注入分页
                    injectPagination('#search_result_pagination', cur_page, 10, function(){
                        $('#search_result_pagination').find('.b').click(function(){
                            var changeTo = pageChange($(this).attr('data-id'), cur_page, data.PageSize);
                            if(changeTo){
                                ajax(changeTo);
                            }
                        });
                    });
                }else{
                    layer.msg(data.Message);
                }
              // 获得当前页
              cur_page = data.Page;


          },
          complete: function () { //加载完成提示
              closeLoading();
          }
      });
  };

  //注入dom
  function dataSuccess(data){
    $('.map').hide();
    $('.result').show();
    $('#result').empty();
    $('#search_result').tmpl(data).appendTo('#result');
    $('.result .tbl-wrap .i-5 img').click(function(){
      if($(this).attr('data-show') == 1){
        $(this).attr('src', "/Uploads/Debt/imgs/db_arrow_right.png");
        $(this).attr('data-show', 0);
        $(this).parents('.hd-wrap').removeClass('act');
        $(this).parents('.hd-wrap').siblings('.cont').hide();
      }else{
        $(this).attr('data-show', 1);
        $(this).attr('src', "/Uploads/Debt/imgs/db_arrow_down.png");
        $(this).parents('.hd-wrap').addClass('act');
        $(this).parents('.hd-wrap').siblings('.cont').show();
      }
    });
  }
});
