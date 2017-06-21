var pageObj=$.extend({},pageObj,{
    /**
     * 立即发货
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
     * 立即发货
     */
    immediateDelivery:function(orderId) {
        var _this = this;
        var logisticsName=$.trim($("input[name='logisticsName']").val());
        var logisticsNo=$.trim($("input[name='logisticsNo']").val());
        if(logisticsName==""){
            $.toast("物流公司不能为空！");
            return;
        }
        if(logisticsNo==""){
            $.toast("物流单号不能为空！");
            return;
        }
        $.ajax({
            type: "post",
            url: "/ajaxorder",
            dataType: "json",
            async: false,
            data:{
                "Intention":"ConfirmDelivery",
                "orderId":orderId,
                "logisticsName":logisticsName,
                "logisticsNo":logisticsNo
            },
            beforeSend: function () {
                $.showIndicator();
            }, success: function (data) {
                if (data.ResultCode == 200) {
                    $.toast(data.Message);
                    location.reload();
                } else {
                    $.toast(data.Message);
                }
            }, complete: function () {
                $.hideIndicator();
            }
        });
    },
    /**
     * 初始化方法
     */
    init:function(){
        var _this=this;
        //点击立即发货
        $("#immediate").on("click",function(){
            $.popup(".popup-logistics");
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});
