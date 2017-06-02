Zepto(function($){
    $(".index-top .bottom-btn,.index-nav a,.btn,.btn-blue,.btn-red").on("touchstart",function(){
        $(this).addClass("touch");
    });
    $(".index-top .bottom-btn,.index-nav a,.btn,.btn-blue,.btn-red").on("touchend touchmove touchcancel",function(){
        $(this).removeClass("touch");
    });

    $(".switch").on("click",function(){
	    $(this).toggleClass("switch-open");
	});


	$(".radio-box").on("click",function(){
		$(this).addClass("active");
		$(this).siblings(".radio-box").removeClass("active");
		if($("#j-month").hasClass("active")){
	        $(this).parents(".row").find(".days").removeClass("hide");
	    }else{
	    	$(this).parents(".row").find(".days").addClass("hide");
	    }
		//$(this).children("input[type='radio']").attr("checked",true);
		//$(this).siblings(".radio-box").children("input[type='radio']").attr("checked",false);
	})
});