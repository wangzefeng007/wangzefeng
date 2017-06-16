var pageObj=$.extend({},pageObj,{
    /**
     * 删除地址
     * @param addressId
     */
    delAddress:function(tar,addressId){
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"DeleteAddress",
                "id":addressId
            },
            beforeSend:　function(){
                $.showIndicator();
            },success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    $(tar).parents(".form-fieldset").remove();
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