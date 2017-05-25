/**
 * Created by irene on 2017/5/23.
 */
//其他城市选中刷新
function otherCitySel(){
    $('#area .sel').removeClass('sel');
    //ajax(1, true);
}

var pageObj=$.extend({},pageObj,{
    /**
     * 点击查看
     * @param tar
     */
    seekShow:function(tar){
        $(tar).parents("li").addClass("active");
        var mobile=$(tar).parents("li").find(".mobile").attr("data-phone");
        $(tar).parents("li.active").find(".mobile").text(mobile);
    },
    /**
     * 投诉建议
     */
    suggestion:function(){
        var index = layer.open({
            title:'投诉与建议',
            type: 1,
            area: ['700px','280px'],
            shadeClose: true,
            content: $("#suggestionTemp").html()
        });
        $(".suggestion-box .btn-default").on("click",function(){
            layer.close(index);
        })
    },
    /**
     * 投诉建议提交
     */
    suggestionSub:function(tar){
        var suggestion=$(tar).parents(".suggestion-box").find("textarea[name='suggestion']").val();
        if(!suggestion){
            showMsg("投诉建议不能为空");
        }else{
            $.ajax({
                type:"post",
                url:"/loginajax.html",
                dataType: "json",
                data:{
                    "Intention":"AddAdvice",
                    "suggestion":suggestion
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
});