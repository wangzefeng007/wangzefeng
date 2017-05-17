/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 立即发货
     */
    immediateDelivery:function(tar){
        var _this=this;
        var orderId=$(tar).parents(".operate-td").attr("data-id");
        var orderObj={
            orderId:orderId
        };
        $.ajax({
            type:"post",
            url:"/ajaxorder",
            dataType: "json",
            async:false,
            data:{
                "Intention":"GetOrderAddress",
                "orderId":orderId
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    orderObj=$.extend({},orderObj,data.Data);
                    $("#confirmAddressHtml").empty();
                    $('#confirmAddressTemp').tmpl(orderObj).appendTo("#confirmAddressHtml");
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        });
        var index = layer.open({
            title:'确认收货地址',
            type: 1,
            area: ['700px','520px'],
            shadeClose: true,
            content: $("#confirmAddressHtml").html()
        });
    },
    validateForm:function($wrap){
        var logisticsName= $wrap.find("input[name='logisticsName']").val();
        var logisticsNo= $wrap.find("input[name='logisticsNo']").val();
        if(!logisticsName){
            showMsg('请输入物流名称');
            return false;
        }
        if(!logisticsNo){
            showMsg('请输入物流单号');
            return false;
        }
        else{
            return true;
        }
    },
    /**
     * 确认发货
     */
    confirmDelivery:function(tar){
        var _this=this;
        var $wrap=$(tar).parents(".order-pay-address");
        var validate=_this.validateForm($wrap);
        var orderId= $wrap.find("input[name='orderId']").val();
        var logisticsName= $wrap.find("input[name='logisticsName']").val();
        var logisticsNo= $wrap.find("input[name='logisticsNo']").val();
        if(!validate){
            return false;
        }else{
            $.ajax({
                type:"post",
                url:"/ajaxorder",
                dataType: "json",
                data:{
                    "Intention":"ConfirmDelivery",
                    "orderId":orderId,
                    "logisticsName":logisticsName,
                    "logisticsNo":logisticsNo
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
        }
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {

    }
});
pageObj.init();