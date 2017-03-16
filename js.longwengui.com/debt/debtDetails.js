$(function(){

  $('#debt_imgs').find('img').click(function(){
    var _imgs = [];
    _imgs.push($(this).attr('src'));
    $(this).siblings('img').each(function(){
      _imgs.push($(this).attr('src'));
    });
    showImgs(_imgs);
  });


  function showImgs(imgs){
    layer.open({
      type: 1,
      title: 0,
      area: ["880px", "560px"],
      closeBtn: 0,
      shadeClose: true,
      content:    '<div class="slide-container">'
                + '</div>'
    });
    var _imgData = [
      {
        "imgs": imgs
      }
    ];
    $('#slide-tmpl').tmpl(_imgData).appendTo('.slide-container');
    $('.slide-container').slide({"effect": "fold"});
  }

});
function ajax(){
  var percent_money = $('#percent_money').val();
  var detail_info = $('#detail_info').val();
  if(percent_money == "" || detail_info == ""){
    showMsg('完善表单信息');
    return;
  }
  if(!(percent_money > 0 && percent_money < 100)){
    showMsg('请输入0-100间的数');
    return;
  }
  //处置方接单申请
  $.ajax({
    type: "post",
    dataType: "json",
    url: '/ajax.html',
    data: {
      "Intention":"ApplyOrder",
      "percent_money": percent_money,
      "detail_info":　detail_info
    },
    beforeSend: function () { //加载过程效果
        showLoading();
    },
    success: function(data){
      if(data.ResultCode=='200'){
        showMsg('申请成功');
      }else{
        showMsg(data.Message)
      }
    },
    complete: function () { //加载完成提示
        closeLoading();
    }
  });
}
