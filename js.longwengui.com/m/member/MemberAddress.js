var pageObj=$.extend({},pageObj,{
    /**
     * 设为默认地址
     * @param addressId
     */
    setDefaultAddress:function(tar,addressId){
        //var addressId=$(tar).attr("data-id");
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"DefaultAddress",
                "id":addressId
            },
            beforeSend:　function(){
                $.showIndicator();
            },success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    /*$(tar).parent().addClass("default").removeClass("set-default");
                    $(tar).text("默认地址");
                    $(tar).parents("tr").siblings("tr").find(".default").addClass("set-default").removeClass("default");
                    $(tar).parents("tr").siblings("tr").find(".set-default").find("span").text("设为默认")*/
                    location.reload();
                }else{
                    $.toast(data.Message);
                }
            },complete: function(){
                $.hideIndicator();
            }
        })
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {
        var _this = this;
    }
});
pageObj.init();