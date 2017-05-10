/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{

    //地址数据
    addressInputs:function($wrap){
        return {
            addressId:$wrap.find("input[name='addressId']").val(),
            dd_province:$wrap.find("input[name='dd_province']").siblings("span").attr("data-id"),
            dd_city:$wrap.find("input[name='dd_city']").siblings("span").attr("data-id"),
            dd_area:$wrap.find("input[name='dd_area']").siblings("span").attr("data-id"),
            detail_area:$wrap.find("textarea[name='detail_area']").val(),
            to_name:$wrap.find("input[name='to_name']").val(),
            to_phone:$wrap.find("input[name='to_phone']").val(),
            is_default:$wrap.find("input[name='is_default']")[0].checked==true?1:0
        }
    },
    //保存验证
    validateForm:function($wrap){
        var addressInputs=this.addressInputs($wrap);
        if(!(addressInputs.dd_province*1) || !(addressInputs.dd_city*1) || !(addressInputs.dd_area*1) ||
            addressInputs.detail_area=='' || addressInputs.to_name=='' || addressInputs.to_phone == ''){
            showMsg('请完善地址信息');
            return false;
        }else{
            return true;
        }
    },
    /**
     * 保存收货地址
     * @returns {boolean}
     */
    saveAddress:function(tar){
        var $wrap=$(tar).parents(".address-manage");
        var validate=this.validateForm($wrap);
        if(!validate){
            return false;
        }
        var paramObj=this.addressInputs($wrap);
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"AddAddress",
                "AjaxJSON":JSON.stringify(paramObj)
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    showMsg(data.Message);
                    //路由跳转
                    setTimeout(function() {
                        window.location = data.Url;
                    }, 10);
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        })
    },
    /**
     * 设置地址
     */
    locationSet:function(){
        var _this = this;
        var getAddressObj=getAddress(_this.addressObj.Province,_this.addressObj.City,_this.addressObj.Area);
        $("input[name='dd_province']").siblings("span").text(getAddressObj.provinceText);
        $("input[name='dd_city']").siblings("span").text(getAddressObj.cityText);
        $("input[name='dd_area']").siblings("span").text(getAddressObj.areaText);

        getCityData(_this.addressObj.Province, $("input[name='dd_province']").siblings("span"));
        getAreaData(_this.addressObj.City, $("input[name='dd_city']").siblings("span"));
    },
    /**
     * 删除地址
     * @param addressId
     */
    delAddress:function(tar,addressId){
        //var addressId=$(tar).attr("data-id");
        var hasNum=parseInt($(".hasNum").text());
        var hasNumber=parseInt($(".hasNumber").text());
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"DeleteAddress",
                "id":addressId
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    showMsg(data.Message);
                    $(tar).parents("tr").remove();
                    hasNum--;
                    hasNumber++;
                    $(".hasNum").text(hasNum);
                    $(".hasNumber").text(hasNumber);
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        })
    },
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
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    showMsg(data.Message);
                    $(tar).parent().addClass("default").removeClass("set-default");
                    $(tar).text("默认地址");
                    $(tar).parents("tr").siblings("tr").find(".default").addClass("set-default").removeClass("default").text("设为默认");
                    //location.reload();
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        })
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {
        getProvinceData();
        var _this = this;
        _this.locationSet();

        //设置地址Id
        var addressId = GetQueryString("ID");
        $("input[name='addressId']").val(addressId);
        if(!(addressId*1)){
            $(".addOrEdit").text("新增");
        }else{
            $(".addOrEdit").text("修改");
        }
    }
});
pageObj.init();