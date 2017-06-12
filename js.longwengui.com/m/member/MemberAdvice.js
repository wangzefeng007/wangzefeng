var pageObj=$.extend({},pageObj,{
    /**
     * 提交建议
     */
    subAdvice:function(){
        var adviceText = $('textarea[name="advice_text"]').val(); //建议内容
        if(adviceText == ''){
            $.toast('建议不能为空');
            return;
        }
        //提交建议
        $.ajax({
            type: "post",
            dataType: "json",
            url: "/loginajax.html",
            data: {
                "Intention": "AddAdvice",//投诉建议
                "suggestion": adviceText  //内容
            },
            beforeSend: function () {
                $.showIndicator();
            },
            success: function (data) {
                if (data.ResultCode == 200) {
                    $.toast('提交成功');
                    //路由跳转展示页面
                    setTimeout(function () {
                        window.location = data.Url;
                    }, 10);
                } else {
                    $.toast(data.Message);
                }
            },
            complete: function () {
                $.hideIndicator();
            }
        })
    },
    /**
     * 初始化方法
     */
    init:function(){
        var _this=this;
        $("#advice").on("click",function(){
            _this.subAdvice();
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});
