$(function(){
  /*
  图片预览
  * */
    $(".grouped_elements").fancybox({
        showCloseButton:true,
        showNavArrows:true
    });

});
function ajax(){
  var percent_money = $('#percent_money').val();
  var detail_info = $('#detail_info').val();
  var DebtId = $('button[name="button"]').attr('data-id');
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
      "detail_info":　detail_info,
      "DebtId":　DebtId
    },
    beforeSend: function () { //加载过程效果
        showLoading();
    },
    success: function(data){
      if(data.ResultCode=='200'){
        showMsg('申请成功');
          //路由跳转展示页面
          setTimeout(function() {
              window.location = data.Url;
          }, 10);
      }else{
        showMsg(data.Message)
      }
    },
    complete: function () { //加载完成提示
        closeLoading();
    }
  });
}

//关注债务
function concernDebt(debtId){
  $.ajax({
    type: 'post',
    dataType: 'json',
    url: '/loginajax.html',
    data: {
      "Intention": 'ConcernDebt',
      "debtId": debtId
    },
    beforeSend: function(){
      showLoading();
    },
    success: function(data){
      if(data.ResultCode == 200){
        showMsg(data.Message);
        window.location.reload();
      }else if(data.ResultCode == 101){
        showMsg(data.Message);
        //路由跳转展示页面
        toLogin();
      }else{
        showMsg(data.Message);
      }
    },
    complete: function(){
      closeLoading();
    }
  });
}
