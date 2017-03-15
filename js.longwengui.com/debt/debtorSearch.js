$(function(){
  //声明当前页
  var cur_page;

  //添加下拉框事件
  addEventToDropdown("area", function(tar){
    var areaName = $(tar).attr("data-name");
    $("#area_sel").text(areaName == "" ? "全国" : areaName);
  });

  //添加搜索事件
  $("#search").click(function(){
    getImgVerification();
  });
  function　getImgVerification(){
    //获取验证码图片
    $.ajax({
      type: "get",
      url: "../data/imgVerification.json", //提交的地址
      beforeSend: function () { //加载过程效果
          showLoading();
      },
      success: function(data){
        var ly_img_code = layer.open({
          type: 1,
          title: 0,
          closeBtn: 0,
          offset: '160px',
          area: ["400px", "100px"],
          shadeClose: true,
          content:    "<div class='layer-verf'>"
                    +   "<div class='line'>"
                    +     "<input type='text' id='img_code' maxlength='4' placeholder='验证码'>"
                    +     "<img src='" + data.Data.url + "' alt='' />"
                    +     "<div class='confirm-btn'>"
                    +        "<button type='button' id='to_verf'>确定</button>"
                    +     "</div>"
                    +   "</div>"
                    + "</div>"
        });
        $('#to_verf').click(function(){
          var img_code = JSON.stringify($('#img_code').val());
          if(img_code == "" || img_code.length < 4){
            layer.msg('请输入正确的验证码',{
              offset: '240px'
            });
            return;
          }
          //验证图片
          $.ajax({
            type: "get",
            dataType: "json",
            url: "../data/vericatImg.json", //提交的图片验证
            data: {
              'img_code': img_code
            },
            beforeSend: function () { //加载过程效果
                showLoading();
            },
            success: function(data){
              if(data.ResultCode == 200){
                layer.close(ly_img_code);
                ajax(1);
              }else{
                layer.msg('验证码输入错误', {
                  offset: '240px'
                });
              }
            },
            complete: function () { //加载完成提示
                closeLoading();
            }
          });
        })
      },
      complete: function () { //加载完成提示
          closeLoading();
      }
    });
  }


  //请求数据
  function ajax(Page){
    var key = $("#keyword").val();
    var area_sel = $("#area_sel").text();
    var id_num = $("#id_num").val();

    $.ajax({
          type: "get",	//提交类型
          dataType: "json",	//提交数据类型
          url: '../data/debtorSearch.json',  //提交地址
          data: {
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
              dataSuccess(data.Data);

              // 获得当前页
              cur_page = data.Page;

              // 注入分页
              injectPagination('#search_result_pagination', cur_page, data.LastPage, function(){
                $('#search_result_pagination').find('.b').click(function(){
                  var changeTo = pageChange($(this).attr('data-id'), cur_page, data.PageSize);
                  if(changeTo){
                    ajax(changeTo);
                  }
                });
              });
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
        $(this).attr('src', "../imgs/db_arrow_right.png");
        $(this).attr('data-show', 0);
        $(this).parents('.hd-wrap').removeClass('act');
        $(this).parents('.hd-wrap').siblings('.cont').hide();
      }else{
        $(this).attr('data-show', 1);
        $(this).attr('src', "../imgs/db_arrow_down.png");
        $(this).parents('.hd-wrap').addClass('act');
        $(this).parents('.hd-wrap').siblings('.cont').show();
      }
    });
  }
});
