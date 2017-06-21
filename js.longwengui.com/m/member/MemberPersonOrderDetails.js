var pageObj=$.extend({},pageObj,{
    /**
     * 取消订单
     * @param tar
     */
    cancelOrder:function(orderId){
        var _this=this;
        $.confirm('是否取消订单？', function () {
            $.ajax({
                type:"post",
                url:"/ajaxorder",
                dataType: "json",
                data:{
                    "Intention":'CancelOrder',
                    "orderId":orderId
                },
                beforeSend:　function(){
                    $.showIndicator();
                },success: function(data){
                    if(data.ResultCode == 200){
                        $.toast(data.Message);
                        window.location.reload();
                    }else{
                        $.toast(data.Message);
                    }
                },complete: function(){
                    $.hideIndicator();
                }
            })
        });
    },
    /**
     * 提醒卖家发货
     * @param tar
     */
    remind:function(orderId){
        var _this=this;
        $.ajax({
            type:"post",
            url:"/ajaxorder",
            dataType: "json",
            data:{
                "Intention":'RemindSell',
                "orderId":orderId
            },
            beforeSend:　function(){
                $.showIndicator();
            },success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    window.location.reload();
                }else{
                    $.toast(data.Message);
                }
            },complete: function(){
                $.hideIndicator();
            }
        })
    },
    /**
     * 初始化方法
     */
    init:function(){
        var _this=this;

    }
})
$(document).ready(function(){
    pageObj.init();
});
