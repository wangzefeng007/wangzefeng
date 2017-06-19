var pageObj=$.extend({},pageObj,{
    /**
     * 收藏
     * @param tar
     */
    favoFun:function(tar){
        $.ajax({
            type:"post",
            url: "/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"ConcernInfo",
                "Id":$(tar).attr("data-id"),
                "Type":2
            },
            beforeSend:　function(){
                $.showIndicator();
            },success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    $(tar).addClass("favo-ed");
                }else{
                    $.toast(data.Message);
                }
            },complete: function(){
                $.hideIndicator();
            }
        })
    },
    /**
     * number输入框加减
     * @param tar
     * @param type
     */
    numberInp:function(tar,type){
        var $inp=$(tar).parent(".input-number").find("input[name='num']"),
            inpVal=$inp.val();
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
    /**
     * 计算总价
     * @param tar
     */
    calcMoney:function(tar){
        var totalCount=$("#totalCount").text();
        if(!validate("+number",$(tar).val())){
            $.toast("请输入正确的正整数");
            $(tar).val(1)
        }
        var price=$("#price").text();
        var num=$(tar).val();
        if(parseInt(num)>parseInt(totalCount)){
            $.toast("库存不足");
            $(tar).val(totalCount);
            num=totalCount;
        }
        var emsMoney=$("#ems-money").text();
        var totalMoney=parseFloat((price*num).toFixed(2))+parseFloat(emsMoney);
        $("#totalMoney").text(totalMoney);
        pageObj.totalMoney=totalMoney;
    },
    /**
     * 立即购买
     * @param obj
     */
    buyFun:function(obj){
        var goodsId = $(obj).attr("data-id");
        var userid = $(obj).attr("data-userid");
        if(userid !==''){
            var buy_count=$("input[name='num']").val();
            if(buy_count==''){
                $.toast("请输入份数");
                return;
            }else{
                go("/asset/order?id="+goodsId+"&num="+buy_count+'&money='+pageObj.totalMoney);
            }
        }else {
            $.toast("请先登录");
        }

    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //进入页面计算money
        var $inp=$(".input-number").find("input[name='num']");
        _this.calcMoney($inp);
    }
})
$(document).ready(function(){
    pageObj.init();
});
