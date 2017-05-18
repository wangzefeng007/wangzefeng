//适配ie8
initIE8Label();
fixIE8Label();

//上传凭证
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajaximage/",
        data: {
            "Intention":"AddImage",
            "ImgBaseData": ImgBaseData
        },
        beforeSend: function () {
            showLoading();
        },
        success: function(data) {
            if(data.ResultCode=='200'){
                $(tar).parents(".img-wrap").find(".img").empty().append('<img src="'+data.url+'"/>');
                setTimeout(function(){
                    layer.close(index);
                }, 200);
            }else{
                layer.msg(data.Message);
            }
        },
        complete: function () { //加载完成提示
            closeLoading();
        }
    });
}

var pageObj=$.extend({},pageObj,{
    /**
     * 表单提交对象
     */
    formObj:function($form){
        var $form=$form||$("#formObj");
        return {
            orderId:$form.find("[name='orderId']").val(),
            Reason:$form.find("[name='returnReason']").val(),
            TotalAmount:$form.find("[name='returnMoney']").val(),
            Message:$form.find("[name='returnDes']").val(),
            ImageJson:function(){
                var imgArr=[];
                $("#returnVoucher .bx").each(function(){
                    if($(this).find("img").attr("src")){
                        imgArr.push($(this).find("img").attr("src"));
                    }
                });
                return imgArr;
            }()
        }
    },
    /**
     * 提交退款申请
     */
    applyReturn:function(){
        //添加Intention属性
        var ajaxData=this.formObj();
        ajaxData.Intention='RequestRefund';
        //提交信息验证
        if(!this.validateForm()){
            return false;
        }else{
            $.ajax({
                type:"post",
                url:"/ajaxorder",
                dataType: "json",
                data:ajaxData,
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
        }
    },
    /**
     * 表单验证
     */
    validateForm:function(){
        var formObj=this.formObj();
        if(formObj.Reason==''){
            layer.msg("请选择退款原因");
            return false;
        }else if(formObj.Message==''){
            layer.msg("请输入退款说明");
            return false;
        }else{
            return true;
        }
    },
    /**
     * 同意退货申请
     */
    agreeReturn:function(){
        var index = layer.open({
            title:'发送退货地址',
            type: 1,
            area: ['700px','550px'],
            shadeClose: true,
            content: $("#agree-section").html()
        });
        /*$(".agree-return").on("click","#agree_confirm",function(){
            layer.close(index);
        });*/
        $(".agree-return").on("click","#agree_cancel",function(){
            layer.close(index);
        });
    },
    /**
     * 确认同意退货申请
     */
    agreeConfirm:function(tar){
        var returnReason=$(tar).parents(".return-box").find("[name='agreeReason']").val();
        var toAddress=$(tar).parents(".return-box").find(".to_address").text();
        var toName=$(tar).parents(".return-box").find(".to_name").text();
        var toPhone=$(tar).parents(".return-box").find(".to_phone").text();
        if(returnReason==''){
            showMsg("请输入退款说明");
            return false;
        }else{
            $.ajax({
                type:"post",
                url:"",
                dataType: "json",
                data:{
                    "Intention":"AddAddress",
                    "returnReason":returnReason,
                    "toAddress":toAddress,
                    "toName":toName,
                    "toPhone":toPhone
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
        }
    },
    /**
     * 拒绝退货申请
     */
    refuseReturn:function(){
        var index = layer.open({
            title:'拒绝退货申请',
            type: 1,
            area: ['600px','360px'],
            shadeClose: true,
            //btn:['确认拒绝','取消'],
            content: $("#refuse-section").html()
        });
        $(".refuse-return").on("click","#refuse_cancel",function(){
            layer.close(index);
        });
    },
    /**
     * 确认拒绝退货申请
     */
    refuseConfirm:function(tar){
        var $refuseReason=$(tar).parents(".refuse-return").find("input[name='refuseReason']");
        var refuseReason="";
        $refuseReason.each(function(){
            if($(this).is(':checked')){
                refuseReason=$(this).val();
            }
        })
        $.ajax({
            type:"post",
            url:"",
            dataType: "json",
            data:{
                "Intention":"",
                "refuseReason":refuseReason,
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
     * 填写原因
     */
    writeReason:function(tar){
        var thisVal=$(tar).val();
        if(thisVal.length==0){
            $(tar).parents(".refuse-return").find(".otherReason").val("其它");
        }else{
            $(tar).parents(".refuse-return").find(".otherReason").val(thisVal);
        }
    },
    /**
     * 页面初始化方法
     */
    init:function(){
        var _this=this;
        //表单内容
        _this.formObj();
        //退款原因赋值
        addEventToDropdown("returnReason",function(tar){
            $(tar).parent().siblings("span").text($(tar).text());
            $(tar).parent().siblings("input").val($(tar).text());
        });
        /*
         图片预览
         * */
        $(".vouchImage").fancybox({
            showCloseButton:true,
            showNavArrows:true
        });
    }
});
window.onload=function(){
    pageObj.init();
}