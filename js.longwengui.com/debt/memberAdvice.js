$(function(){
  $('#advice').click(function(){
    var adviceText = $('textarea[name="advice_text"]').val(); //建议内容
    if(adviceText == ''){
      showMsg('建议不能为空');
      return;
    }
    //提交建议
    $.ajax({
      type: "post",
      dataType: "json",
      url: "/loginajax.html",
      data: {
        "Intention":"AddAdvice",//投诉建议
        "suggestion": adviceText  //内容
      },
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('提交成功');
            //路由跳转展示页面
            setTimeout(function() {
                window.location = data.Url;
            }, 10);
        }else{
          showMsg(data.Message);
        }
      },
      complete: function(){
        closeLoading();
      }
    });
  });
});
