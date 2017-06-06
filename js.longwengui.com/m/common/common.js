/**
 * 页面加载完毕
 */
window.onload=function(){
    $.init();
}
Zepto(function($){
    /*触摸添加样式 touch*/
    $(".index-top .bottom-btn,.index-nav a,.btn,.btn-blue,.btn-red").on("touchstart",function(){
        $(this).addClass("touch");
    });
    /*触摸结束删除样式 touch*/
    $(".index-top .bottom-btn,.index-nav a,.btn,.btn-blue,.btn-red").on("touchend touchmove touchcancel",function(){
        $(this).removeClass("touch");
    });
});

$(function(){
    /**
     * 头部返回事件
     */
    $(document).on("click",".header-left.icon-back",function(){
        window.history.go(-1);
    });
    /**
     * 首页底部添加按钮
     */
    $(".icon-nav-add").on("click",function(){
        if($(".publish-box").hasClass("open")){
            $(".publish-box").removeClass("open");
        }else{
            $(".publish-box").addClass("open");
        }
    });
})