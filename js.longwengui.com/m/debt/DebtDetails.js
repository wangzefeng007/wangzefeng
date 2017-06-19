var pageObj=$.extend({},pageObj,{
    /**
     * 关注债务
     */
    concernDebt:function(tar,debtId){
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/loginajax.html',
            data: {
                "Intention": 'ConcernInfo',
                "Id": debtId,
                "Type":1
            },
            beforeSend: function(){
                $.showIndicator();
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    $(tar).addClass("follow-ed");
                    //window.location.reload();
                }else if(data.ResultCode == 101){
                    $.toast(data.Message);
                }else{
                    $.toast(data.Message);
                }
            },
            complete: function(){
                $.hideIndicator();
            }
        });
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        $(".icon-follow").on("click",function(){
            var debtId=$(this).attr("data-id");  //债务ID
            _this.concernDebt(this,debtId);
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});