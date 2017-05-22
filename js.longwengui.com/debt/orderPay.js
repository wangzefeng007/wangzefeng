var pageObj=$.extend({},pageObj,{
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
    selectedAddress:{

    },
    /**
     * 新增地址
     */
    addAddress:function(){
        var index = layer.open({
            title:'新增收货地址',
            type: 1,
            //title: 0,
            area: ['700px','510px'],
            //closeBtn: 0,
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
            +  '<input type="hidden" name="addressId" value="">'
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
            +      '<input class="w-300" type="text" name="to_name" maxlength="12"  placeholder="不超过12个字" value="">'
            +    '</div>'
            +  '</div>'
            +  '<div class="line">'
            +    '<div class="left">'
            +      '手机号码 <span class="form-need">*</span>'
            +    '</div>'
            +    '<div class="right">'
            +      '<input class="w-300" type="text" name="to_phone" onblur="validateMobilePhone(this)" placeholder="请输入手机号码"   value="">'
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
            +      '<button type="button" id="saveAddress" onclick="pageObj.saveAddress(this)" name="button">保存</button>'
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
        var addressObj={
            addressId:addressId
        };
        var address="";
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
                    addressObj=$.extend({},addressObj,data.Data);
                    address=getAddress(addressObj.Province,addressObj.City,addressObj.Area);
                    addressObj=$.extend({},addressObj,address);
                    $("#editAddressHtml").empty();
                    $('#editAddressTemp').tmpl(addressObj).appendTo("#editAddressHtml");
                    if(addressObj.IsDefault==0){
                        $(tar).parents(".order-pay-address").find("input[name='is_default']").removeAttr("checked");
                    }
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        });
        var index = layer.open({
            title:'修改收货地址',
            type: 1,
            //title: 0,
            area: ['700px','510px'],
            //closeBtn: 0,
            shadeClose: true,
            content: $("#editAddressHtml").html()
        });
        getCityData(addressObj.Province, $("input[name='dd_province']").siblings("span"));
        getAreaData(addressObj.City, $("input[name='dd_city']").siblings("span"));
        getProvinceData();
    },
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
     * 新增收货地址
     * @returns {boolean}
     */
    saveAddress:function(tar){
        var $wrap=$(tar).parents(".order-pay-address");
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
        var Money = GetQueryString("money");
        var Freight =$("#Js_order").attr("data-money");
        Money = parseInt(Money) +  parseInt(Freight);
        var AddressId=$(".address-box.active").find(".edit").attr("data-id");
        if(!AddressId){
            showMsg("收货地址不能为空");
            return ;
        }
        var formData = {
            'AddressId':AddressId, //收货地址ID
            'ProductID':ID, //产品ID
            'Number':Num, //购买数量
            'Money':Money //订单总金额

        };
        $.ajax({
            type:"post",
            url:"/ajaxasset/",
            dataType: "json",
            data: {
                "Intention":"ConfirmOrder",
                "AjaxJSON":JSON.stringify(formData)
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
                    showMsg(data.Message);
                }else{
                    showMsg(data.Message);
                }
            }
        })
    },
    finalAddress:function(finalObj){
        return {
            to_name:finalObj.to_name,
            to_phone:finalObj.to_phone,
            provinceText:finalObj.provinceText,
            cityText:finalObj.cityText,
            areaText:finalObj.areaText,
            detailArea:finalObj.detailArea
        };
    },
    /**
    * 收货地址渲染
    */
    addressRender:function($addressBox){
        var to_name = $addressBox.find(".address_name").text();
        var to_phone = $addressBox.find(".address_phone").text();
        var provinceText = $addressBox.find(".address_province").text();
        var cityText = $addressBox.find(".address_city").text();
        var areaText = $addressBox.find(".address_area").text();
        var detailArea = $addressBox.find(".address_detail").text();
        var finalObj={
            to_name:to_name,
            to_phone:to_phone,
            provinceText:provinceText,
            cityText:cityText,
            areaText:areaText,
            detailArea:detailArea
        };
        $("#finalAddressBox").empty();
        $("#addressTemp").tmpl(pageObj.finalAddress(finalObj)).appendTo("#finalAddressBox");
    },
    /**
     * 默认地址设置
     */
    defaultAddress:function() {
        $(".address-box").each(function () {
            if($(this).hasClass("active")){
                pageObj.addressRender($(this));
            }
        });
    } ,
    init:function(){
        var _this=this;
        $("#add_address").on("click",function(){
            _this.addAddress();
        });
        $("#Js_order").on("click",function(){
            _this.subOrder();
        });
        /*默认地址添加*/
        _this.defaultAddress();
        /*收货地址选择*/
        $(".address-box").on("click",function(){
            $(this).addClass("active").siblings(".address-box").removeClass("active");
            _this.addressRender($(this));
        });
    }
});
pageObj.init();


