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
    }
});
window.onload=function(){
    pageObj.init();
}