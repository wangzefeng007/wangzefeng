$(function(){
  /*
   图片预览
   * */
    $(".grouped_elements").fancybox({
        showCloseButton:true,
        showNavArrows:true
    });

});

var pageObj=$.extend({},pageObj,{
    /**
     * 删除悬赏
     */
    delReword:function(rewordId){
        layer.confirm('确认删除该发布的悬赏？', {
            btn: ['确认','取消'] //按钮
        },function(){
            $.ajax({
                type:"post",
                url:"",
                dataType: "json",
                data:{
                    "Intention":"",
                    "rewordId":rewordId
                },
                beforeSend:　function(){
                    showLoading();
                },success: function(data){
                    if(data.ResultCode == 200){
                        showMsg(data.Message);
                        location.reload();
                    }else{
                        showMsg(data.Message);
                    }
                },complete: function(){
                    closeLoading();
                }
            })
        });
    },
    /**
     * 完成悬赏
     */
    completeReword:function(rewordId){
        layer.confirm('确认该发布的悬赏已完成？', {
            btn: ['确认','取消'] //按钮
        },function(){
            $.ajax({
                type:"post",
                url:"",
                dataType: "json",
                data:{
                    "Intention":"",
                    "rewordId":rewordId
                },
                beforeSend:　function(){
                    showLoading();
                },success: function(data){
                    if(data.ResultCode == 200){
                        showMsg(data.Message);
                        location.reload();
                    }else{
                        showMsg(data.Message);
                    }
                },complete: function(){
                    closeLoading();
                }
            })
        });
    }
});