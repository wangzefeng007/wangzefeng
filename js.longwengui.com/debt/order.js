/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    numberInp:function(tar,type){
        var $inp=$(tar).parent(".input-number").find("input[name='num']"),
            inpVal=$inp.val(),
            totalCount=$("#totalCount").text();
        if(type=="+"){
            inpVal++;
        }else if(type=="-"){
            if(inpVal==1){
                return;
            }else{
                inpVal--;
            }
        }
        $inp.val(inpVal);
        this.calcMoney($inp);
    },
    buyFun:function(obj){
        var goodsId = $(obj).attr("data-id");
        var userid = $(obj).attr("data-userid");
        var money = $(obj).attr("data-money");
        if(userid !==''){
            var buy_count=$("input[name='num']").val();
            if(buy_count==''){
                showMsg("请输入份数");
                return;
            }else{
                go("/asset/order?id="+goodsId+"&num="+buy_count+'&money='+pageObj.totalMoney);
            }
        }else {
            toLogin();
        }

    },
    calcMoney:function(tar){
        var totalCount=$("#totalCount").text();
        validateNumber(tar);
        var price=$("#price").text();
        var num=$(tar).val();
        if(parseInt(num)>parseInt(totalCount)){
            showMsg("库存不足");
            $(tar).val(totalCount);
            num=totalCount;
        }
        var totalMoney=(price*num).toFixed(2);
        $("#totalMoney").text("￥ "+totalMoney+" 元");
        pageObj.totalMoney=totalMoney;
    },
    /**
     * 立即支付跳转
     */
    goPay:function(url){
        go(url);
    },
    /**
     * 微信二维码扫码结果
     */
    payResult:function(orderId){
        var getResult=window.setInterval(function(){
            $.ajax({
                type:"get",
                url:"/asset/pay/",
                dataType: "json",
                data:{
                    "id":orderId,
                    "type":"wxpay"
                },
                success: function(data){
                    if(data.ResultCode == 200){
                        if(typeof data.Data=="object"){
                            go(data.Url);
                            clearInterval(getResult);
                        }
                    }
                }
            })
        },2000);
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {
        var _this = this;
        $("#Js_buy").on("click",function(){
            _this.buyFun(this);
        });
        //选择支付方式
        $(".pay-list li").on("click",function(){
            $(this).addClass("selected").siblings().removeClass("selected")
        });
        //付款方式跳转
        $("#goPay").on("click",function(){
            var pay_url="";
            var orderId="";
            $(".pay-list li").each(function(){
                if($(this).hasClass("selected")){
                    pay_url=$(this).attr("data-url");
                    orderId=$(this).attr("data-id");
                }
            });
            if(!pay_url&&orderId.length>0){
                $.ajax({
                    type:"get",
                    url:"/asset/pay/",
                    dataType: "json",
                    data:{
                        "id":orderId,
                        "type":"wxpay"
                    },
                    beforeSend:　function(){
                        showLoading();
                    },success: function(data){
                        if(data.ResultCode == 200){
                            layer.open({
                                title:"微信支付",
                                type: 1,
                                //skin: 'layui-layer-rim', //加上边框
                                area: ['700px', '300px'], //宽高
                                content: $("#wxDialog").html().replace("${ImageUrl}",data.ImageUrl)
                            });
                            _this.payResult(orderId);
                        }else{
                            showMsg(data.Message);
                        }
                    },complete: function(){
                        closeLoading();
                    }
                })
            }else{
                _this.goPay(pay_url);
            }
        });
        //合计金额计算
        //_this.calcMoney($(".input-number").find("input[name='num']"));
    }
});
pageObj.init();

$(function(){
    /*
     图片预览
     * */
    $(".grouped_elements").fancybox({
        showCloseButton:true,
        showNavArrows:true
    });

});