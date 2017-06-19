var pageObj=$.extend({},pageObj,{
    /**
     * 订单提交生成订单
     */
    subOrder:function () {
        var Num = GetQueryString("num");    //数量
        var ID = GetQueryString("id");      //商品ID
        var Money = GetQueryString("money");    //总金额
        var AddressId=$("input[name='addressId']").val();   //地址ID
        var type=$(".pay-list .radio.active").parents(".item-con").attr("data-type")    //支付方式
        if(!AddressId){
            $.toast("收货地址不能为空");
            return ;
        }
        var formData = {
            'AddressId':AddressId, //收货地址ID
            'ProductID':ID, //产品ID
            'Number':Num, //购买数量
            'Money':Money, //订单总金额
            'Type':type     //支付方式

        };
        $.ajax({
            type:"post",
            url:"/ajaxasset/",
            dataType: "json",
            data: {
                "Intention":"ConfirmOrder",
                "AjaxJSON":JSON.stringify(formData)
            },
            success: function (data) { //函数回调
                if(data.ResultCode == '200'){
                    var Url = data.Url;
                    window.location.href = Url;
                }else if(data.ResultCode == '100'){
                    $.toast(data.Message);
                }else{
                    $.toast(data.Message);
                }
            }
        })
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //支付方式选择
        $(".pay-list .item-con").on("click",function(){
            $(this).find(".radio").addClass("active");
            $(this).siblings().find(".radio").removeClass("active");
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});
