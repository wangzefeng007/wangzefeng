var pageObj=$.extend({},pageObj,{
    /**
     * ajax参数
     */
    ajaxData:{},
    //计算时间距离
    calcTime:function(obj,end_time){
        var a = new Date();
        var now = new Date(a.getFullYear() + '-' + ((a.getMonth() + 1) > 9 ? (a.getMonth() + 1) : ('0' + (a.getMonth() + 1))) + '-' + (a.getDate() > 9 ? a.getDate() : ('0' + a.getDate())));
        var end_date = new Date(end_time);
        //如果截止日期不大于今天，不执行
        if(end_date > now){
            var dis = end_date.getTime() - now.getTime();
            return dis/(1000*3600*24);
        }else{
            $.toast("请选择今天之后的日期");
            return;
        }
    },
    //截止时间改变时计算距离时间
    endTimeChange:function(obj){
        var end_time = $('#end_time').val();
        var day = this.calcTime(obj,end_time);
        if(day){
            if(day>50){
                $.toast("有效日期最多50天");
                var maxTime=$(obj).attr("max-time");
                $(obj).val(maxTime);
            }
        }
    },
    /**
     * 点击下一步方法
     */
    goStep2:function(){
        var _this=this;
        var _trans_money = $("input[name='trans_money']").val(); //转让单价
        var _public_money= $("input[name='public_money']").val(); //市场价格
        var _trans_count= $("input[name='trans_count']").val();     //份额数量
        var _sell_phone = $("input[name='sell_phone']").val();      //售后电话
        var _trans_type = $("input[name='trans_type']").val();      //资产种类
        var _end_time = $("input[name='end_time']").val();          //有效日期
        var _emsMoney = $("input[name='emsMoney']").val()||0;       //运费
        if(_trans_money==""){
            $.toast('请输入转让单价');
            $("input[name='trans_money']").focus();
            return false;
        }
        if(!validate("+money",_trans_money)){
            $.toast('请输入正确金额，最多保留2位小数');
            $("input[name='trans_money']").focus();
            return false;
        }
        if(_trans_count==""){
            $.toast('请输入份额数量');
            $("input[name='trans_count']").focus();
            return false;
        }
        if(!validate("+number",_trans_count)){
            $.toast('请输入正确的正整数');
            $("input[name='trans_count']").focus();
            return false;
        }
        if(_public_money==""){
            $.toast('请输入转让单价');
            $("input[name='public_money']").focus();
            return false;
        }
        if(!validate("+money",_public_money)){
            $.toast('请输入正确金额，最多保留2位小数');
            $("input[name='public_money']").focus();
            return false;
        }
        if(_emsMoney!=""&&!validate("+money",_public_money)){
            $.toast('请输入正确金额，最多保留2位小数');
            $("input[name='emsMoney']").focus();
            return false;
        }
        if(_trans_type==""){
            $.toast('请输入资产种类');
            $("input[name='trans_type']").focus();
            return false;
        }
        if(_end_time==""){
            $.toast('请选择有效日期');
            $("input[name='end_time']").focus();
            return false;
        }
        if(_sell_phone==""){
            $.toast('请输入售后电话');
            $("input[name='sell_phone']").focus();
            return false;
        }
        if(!validate("phone",_sell_phone)){
            $.toast('请输入正确电话号码');
            $("input[name='sell_phone']").focus();
            return false;
        }
        _this.ajaxData={
            "_trans_money":_trans_money,    //转让单价
            "_public_money":_public_money,  //市场价格
            "_trans_count":_trans_count,    //份额数量
            "_sell_phone": _sell_phone,      //售后电话
            "_trans_type": _trans_type,     //资产种类
            "_end_time": _end_time,          //有效日期
            "_emsMoney": _emsMoney       //运费

        };
        $("#step1").removeClass("page-current");
        $("#step2").addClass("page-current");
    },

    /**
     * 发布资产
     */
    publish:function(tar){
        var _this=this;
        var _transTitle = $("input[name='transTitle']").val();
        var transDetail = $("[name='transDetail']").val();
        var agreement = $("input[name='agreement']")[0].checked;
        var imageList= [];
        $(".goods-img-upload .imageUploadBox").each(function(){
            if($(this).find('img').attr('src')){
                imageList.push($(this).find('img').attr('src'));
            }
        })
        if(!agreement){
            $.toast("您还没有同意服务协议");
            return;
        }
        if(_transTitle==""){
            $.toast("请输入资产标题");
            $("input[name='transTitle']").val()
            return;
        }
        if(transDetail==""){

        }
        if(imageList==0){
            $.toast("请至少上传一张商品照片");
            return;
        }
        _this.ajaxData=$.extend({},_this.ajaxData,{
            "_transTitle":_transTitle,  //资产标题
            "transDetail":transDetail,  //资产详情
            "agreement":agreement,      //同意服务协议
            "imageList":imageList       //商品图片
        });
        var assetID=$(tar).attr("data-id")||"";    //修改时候的商品ID
        $.ajax({
            type:"post",
            url:"/ajaxasset/",
            dataType: "json",
            data:{
                "Intention":"Publish",
                "AjaxJSON":JSON.stringify(_this.ajaxData),
                "ID":assetID
            },
            beforeSend:　function(){
                $.showIndicator();
            },success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
                    //路由跳转
                    /*setTimeout(function() {
                        window.location = data.Url;
                    }, 10);*/

                }else{
                    $.toast(data.Message);
                }
            },error:function(data){
                console.log(data);
            },complete: function(){
                $.hideIndicator();
            }
        })
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //点击下一步
        $("#goStep2").on("click",function(){
            _this.goStep2();
        })
        //图片裁剪
        $(".portrait").on('click',function () {
            $("#step2").append(portraitHtml);
            imgClipper(this);
        });
        //点击发布
        $("#publish").on("click",function(){
            _this.publish(this);
        })
    }

})
$(document).ready(function(){
    pageObj.init();
});

/**
 * 图片裁剪ajax提交
 * @param dataURL base64位编码
 */
function imgSubmit(tar,dataURL) {
    var ajaxData ={
        'Intention': 'AddAssetImage', //资产图像
        'ImgBaseData':dataURL, //base64位编码
    }
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajaximage",
        data: ajaxData,
        beforeSend: function () {
            $.showPreloader('提交中');
        },
        success: function(data) {
            if(data.ResultCode == '200'){
                $("#portraitHtml").remove();
                $.toast(data.Message);
                $(tar).siblings(".img-wrap").empty();
                $(tar).parents(".imageUploadBox").addClass("fill");
                $(tar).siblings(".img-wrap").append("<img src='"+data.url+"' />");
                //$("#portrait").find('img').attr('src',dataURL);
            }else{
                $.toast(data.Message);
            }
        },
        complete: function () { //加载完成提示
            $.hidePreloader();
        }
    });
}