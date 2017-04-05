$(function(){
  $('#advice').click(function(){
    var adviceText = $('textarea[name="advice_text"]').val();
    if(adviceText == ''){
      showMsg('建议不能为空');
      return;
    }
    //提交建议
    $.ajax({
      type: "post",
      dataType: "json",
      url: "",
      data: {
        "advice": adviceText
      },
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('提交成功');

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
