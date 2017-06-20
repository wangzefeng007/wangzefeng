var pageObj=$.extend({},pageObj,{
    loading:false,  //是否正在加载
    pageCount:0,       //总页数
    //ajax参数
    ajaxData:{
        'Intention':'GetRewordList', //方法
        'Page':1   //当前页
    },
    /**
     * 搜索
     * type add为滚动新增追加 update为条件筛选更新
     */
    search:function(type){
        var _this=this;
        $.ajax({
            type: "post",	//提交类型
            dataType: "json",	//提交数据类型
            url: '/loginajax.html',  //提交地址
            data: _this.ajaxData,
            success: function (data) {	//函数回调
                if (data.ResultCode == "200") {
                    $(".list-clue,.infinite-scroll-preloader").show();
                    $(".common-empty").hide();
                    var _html=template('clue_temp', data);
                    if(type=="update"){
                        _this.pageCount=data.PageCount;
                        $(".infinite-scroll-noData").hide();
                        $(".list-clue").empty(); //追加之前先清空
                    }
                    $(".list-clue").append(_html); //添加数据
                }else {
                    $(".list-clue,.infinite-scroll-preloader,.infinite-scroll-noData").hide();
                    $(".common-empty").show();
                    $.toast(data.Message);
                }
                _this.loading=false;
                $(".infinite-scroll-preloader").hide();
            }
        });
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //进入页面搜索"
        _this.search("update");
        //滚动加载
        _this.loading = false;
        $(document).on('infinite', '.infinite-scroll-bottom',function() {
            // 如果正在加载，则退出
            if (_this.loading) return;
            if(_this.ajaxData.Page>=_this.pageCount){
                $(".infinite-scroll-preloader").hide();
                $(".infinite-scroll-noData").show();
                return;
            }
            // 设置flag
            _this.loading = true;
            $(".infinite-scroll-preloader").show();
            _this.ajaxData.Page++;
            _this.search("add");
        });
        // 下拉刷新
        $(document).on('refresh', '.pull-to-refresh-content',function(e) {
            // 模拟2s的加载过程
            setTimeout(function() {
                //刷新页面
                location.reload();
                // 加载完毕需要重置
                $.pullToRefreshDone('.pull-to-refresh-content');
            }, 1000);
        });
    }
})
$(document).ready(function(){
    pageObj.init();
});