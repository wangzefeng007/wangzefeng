var pageObj=$.extend({},pageObj,{
    loading:false,  //是否正在加载
    pageCount:0,       //总页数
    //ajax参数
    ajaxData:{
        'Intention': 'GetDebtList',//提交方法
        'Page':1         //当前页
    },
    /**
     * 获取数据
     */
    getDebt:function(type){
        var _this=this;
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:_this.ajaxData,
            success: function(data){
                if (data.ResultCode == "200") {
                    $(".item-list,.infinite-scroll-preloader").show();
                    $(".common-empty").hide();
                    var _html=template('debt_temp', data);
                    if(type=="update"){
                        _this.pageCount=data.PageCount;
                        $(".infinite-scroll-noData").hide();
                        $(".item-list").empty(); //追加之前先清空
                    }
                    $(".item-list").append(_html); //添加数据
                }else {
                    $(".item-list,.infinite-scroll-preloader,.infinite-scroll-noData").hide();
                    $(".common-empty").show();
                    //$.toast(data.Message);
                }
                _this.loading=false;
                $(".infinite-scroll-preloader").hide();
            }
        })
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {
        var _this = this;
        //获取债权列表
        _this.getDebt("update");
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
            _this.getDebt("add");
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
});
pageObj.init();