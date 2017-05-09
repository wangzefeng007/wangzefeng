var pageObj=$.extend({},pageObj,{
    addressInputs:function(addressId){
        var addressId=addressId||"";
        return {
            addressId:addressId,
            dd_province:$("input[name='dd_province']").siblings("span").attr("data-id"),
            dd_city:$("input[name='dd_city']").siblings("span").attr("data-id"),
            dd_area:$("input[name='dd_area']").siblings("span").attr("data-id"),
            detail_area:$("textarea[name='detail_area']").val(),
            to_name:$("input[name='to_name']").val(),
            to_phone:$("input[name='to_phone']").val(),
            is_default:$("input[name='is_default']")[0].checked==true?1:0
        }
    },
    /**
     * 新增地址
     */
    addAddress:function(){
        var index = layer.open({
            type: 1,
            title: 0,
            area: '700px',
            closeBtn: 0,
            shadeClose: true,
            content:  '<div class="order-pay-address">'
            + '<div class="line">'
            +    '<div class="left">'
            +      '<span class="a-t">新增收货地址</span>'
            +    '</div>'
            +    '<div class="right lh-30">'
            +      '<span class="form-need">*</span>均为必须项'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">'
            +      '所在区域<span class="form-need">*</span>'
            +    '</div>'
            +    '<div class="right">'
            +      '<div class="p-dropdown mr-10">'
            +          '<label type="checkbox">'
            +              '<span>*省</span>'
            +              '<i></i>'
            +              '<input type="checkbox" name="dd_province" value="">'
            +              '<ul></ul>'
            +          '</label>'
            +      '</div>'
            +      '<div class="c-dropdown mr-10">'
            +          '<label type="checkbox">'
            +              '<span>*市</span>'
            +              '<i></i>'
            +              '<input type="checkbox" name="dd_city" value="">'
            +              '<ul></ul>'
            +          '</label>'
            +      '</div>'
            +      '<div class="a-dropdown mr-10">'
            +          '<label type="checkbox">'
            +              '<span>*县</span>'
            +              '<i></i>'
            +              '<input type="checkbox" name="dd_area" value="">'
            +              '<ul></ul>'
            +          '</label>'
            +      '</div>'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">'
            +      '详细地址<span class="form-need">*</span>'
            +    '</div>'
            +    '<div class="right">'
            +      '<textarea name="detail_area" placeholder="建议您如实填写详细收货地址, 例如街道名称、门牌号码、楼层和房间号等信息" rows="5" cols="66"></textarea>'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">'
            +      '收货人姓名<span class="form-need">*</span>'
            +    '</div>'
            +    '<div class="right">'
            +      '<input type="text" name="to_name" maxlength="12"  placeholder="不超过12个字" value="">'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">'
            +      '手机号码 <span class="form-need">*</span>'
            +    '</div>'
            +    '<div class="right">'
            +      '<input type="text" name="to_phone" onblur="validateMobilePhone(this)"  value="">'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">&nbsp;</div>'
            +    '<div class="right">'
            +      '<div class="m-checkbox">'
            +          '<label type="checkbox">'
            +              '<input type="checkbox" name="is_default"  checked>'
            +              '<i></i>'
            +              '设置为默认地址'
            +          '</label>'
            +      '</div>'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">&nbsp;</div>'
            +    '<div class="right">'
            +      '<button type="button" id="saveAddress" onclick="pageObj.saveAddress()" name="button">保存</button>'
            +    '</div>'
            +  '</div>'
            + '</div>'
        });
        getProvinceData();
    },
    /**
     * 修改地址
     */
    editAddress:function(tar){
        var addressId=$(tar).attr("data-id");
        var addressObj={};
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            async:false,
            data:{
                "Intention":"GetAddress",
                "id":addressId
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    addressObj=data.Data;
                    $("#editAddressHtml").empty();
                    $('#editAddressTemp').tmpl(addressObj).appendTo("#editAddressHtml");
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
                var index = layer.open({
                    type: 1,
                    title: 0,
                    area: '700px',
                    closeBtn: 0,
                    shadeClose: true,
                    content: $("#editAddressHtml").html()
                });
            }
        })
        getProvinceData();
    },
    validateForm:function(){
        var addressInputs=this.addressInputs();
        if(addressInputs.dd_province == ''|| addressInputs.dd_city=='' || addressInputs.dd_area=='' ||
            addressInputs.detail_area=='' || addressInputs.to_name=='' || addressInputs.to_phone == ''){
            showMsg('请完善地址信息');
            return false;
        }else{
            return true;
        }
    },
    /**
     * 新增收货地址
     * @returns {boolean}
     */
    saveAddress:function(){
        var validate=this.validateForm();
        if(!validate){
            return false;
        }
        var paramObj=this.addressInputs();
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
                    location.reload();
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        })
    },
    /**
     * 提交订单
     */
    subOrder:function () {
        var Num = GetQueryString("num");
        var ID = GetQueryString("id");
        var ajaxData = {
            'ProductID':ID, //产品ID
            'Number':Num, //购买数量
            'Money':$("#Js_order").attr("data-money") //订单总金额
        }
        $.ajax({
            type:"post",
            url:"/ajaxasset/",
            dataType: "json",
            data: {
                "Intention":"ConfirmOrder",
                "AjaxData":ajaxData
            },
            beforeSend: function () { //加载过程效果
                // $("#paybtn").text('提交中...');
                // $("#paybtn").addClass('course');
                // $("#paybtn").attr('id','');
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
    init:function(){
        var _this=this;
        $("#add_address").on("click",function(){
            _this.addAddress();
        });
        $("#Js_order").on("click",function(){
            _this.subOrder();
        });
    }
});
pageObj.init();


