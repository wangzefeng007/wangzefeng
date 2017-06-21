$(function(){
    $("#getCash").on("click",function(){
        var money=parseFloat($("#money").text());
        if(money<100){
            $.toast("账户余额不足！");
            return false;
        }
    })
})