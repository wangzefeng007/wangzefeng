/**
 * Created by irene on 2017/5/23.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 点击查看
     * @param tar
     */
    seekShow:function(tar){
        $(tar).parents("li").toggleClass("active");
    },
    /**
     * 搜索
     */
    search:function(){
        var dd_province= $(".search-box").find("input[name='dd_province']").siblings("span").attr("data-id");
        var dd_city= $(".search-box").find("input[name='dd_city']").siblings("span").attr("data-id");
        var dd_area= $(".search-box").find("input[name='dd_area']").siblings("span").attr("data-id");
//?dd_province="+dd_province+"&dd_city="+dd_city"
        $.ajax({
            type:"get",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":"xxx",
                "dd_province":dd_province,
                "dd_city":dd_city,
                "dd_area":dd_area
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
                url:"/",
                dataType: "json",
                data:{
                    "Intention":"",
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
    /**
     * 初始方法
     */
    init:function(){
        //省市区初始化
        getProvinceData();
    }
});
window.onload=function(){
    pageObj.init();
}