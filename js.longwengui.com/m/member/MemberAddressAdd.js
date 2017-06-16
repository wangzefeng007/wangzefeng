var pageObj=$.extend({},pageObj,{
    //保存验证
    validateForm:function($wrap){
        var addressId=$("input[name='addressId']").val();
        var address=$("input[name='address']").attr("data-value")||"";
        var detail_area=$("textarea[name='detail_area']").val();
        var to_name=$("input[name='to_name']").val();
        var to_phone=$("input[name='to_phone']").val();
        var is_default=$(".default").hasClass("active")?1:0;
        if(to_name==""){
            $.toast("请输入收货人姓名");
            $("input[name='to_name']").val();
            return false;
        }
        if(to_phone==""){
            $.toast("请输入手机号码");
            $("input[name='to_phone']").val();
            return false;
        }
        if(!validate("mobilePhone",to_phone)){
            $.toast("请输入正确的手机号码");
            $("input[name='to_phone']").val();
            return false;
        }
        if(address==""){
            $.toast("请选择地址");
            $("input[name='addressId']").focus();
            return false;
        }
        if(detail_area==""){
            $.toast("请输入详细地址");
            $("textarea[name='detail_area']").val()
            return false;
        }
        return {
            addressId:addressId,        //地址ID 修改的时候用
            to_name:to_name,            //收货人姓名
            to_phone:to_phone,          //收货人手机号
            dd_province:address.split(" ")[0],  //地址 省
            dd_city:address.split(" ")[1],      //地址 市
            dd_area:address.split(" ")[2],      //地址 区
            detail_area:detail_area,            //详细地址
            is_default:is_default               //是否默认地址 1、是 2、否
        }
    },
    /**
     * 保存收货地址
     * @returns {boolean}
     */
    saveAddress:function(tar){
        var validate=this.validateForm();
        if(!validate){
            return false;
        }
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"AddAddress",
                "AjaxJSON":JSON.stringify(validate)
            },
            beforeSend:　function(){
                $.showIndicator();
            },success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    //路由跳转
                    setTimeout(function() {
                        window.location = data.Url;
                    }, 10);
                }else{
                    $.toast(data.Message);
                }
            },complete: function(){
                $.hideIndicator();
            }
        })
    },
    /**
     * 设为默认地址
     * @param addressId
     */
    setDefaultAddress:function(tar,addressId){
        //var addressId=$(tar).attr("data-id");
        if($(tar).parent().hasClass("default")){
            return;
        }
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
                    $(tar).parent().addClass("default").removeClass("set-default");
                    $(tar).text("默认地址");
                    $(tar).parents("tr").siblings("tr").find(".default").addClass("set-default").removeClass("default");
                    $(tar).parents("tr").siblings("tr").find(".set-default").find("span").text("设为默认")
                    //location.reload();
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
        //设置地址Id
        var addressId = GetQueryString("ID");
        $("input[name='addressId']").val(addressId);
        //地址初始化
        $("input[name='address']").cityPicker();
        //默认切换
        $(".default").on("click",function(){
            $(this).toggleClass("active");
        })
    }
});
pageObj.init();