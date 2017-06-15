var pageObj=$.extend({},pageObj,{
    loading:false,  //是否正在加载
    pageCount:0,  //总页数
    /**
     * ajax参数
     */
    ajaxData:{
        Intention:"GetAssetList",
        TransferType:"1",   //类型 1.资产转让 2.股权转让
        Type:"0",  //类别 0.最新 1.热卖 2.最后促销
        Keyword:"all",  //关键字
        Page:1       //页数
    },
    /*
     * 查询列表*/
    search:function(type){
        var _this=this;
        var getParams={
            Type:$("tab-nav a.active").attr("data-type"),
            Keyword:$.trim($("input[name='keyword']").val())||"all",
        };
        _this.ajaxData=$.extend({},_this.ajaxData,getParams);
        console.log(_this.ajaxData);
        $.ajax({
            type:"post",
            url:"/ajaxasset",
            data:_this.ajaxData,
            dataType:"json",
            success:function(data){
                if (data.ResultCode == "200") {
                    $(".assets-list,.infinite-scroll-preloader").show();
                    $(".common-empty").hide();
                    var _html=template('assets_temp', data);
                    if(type=="update"){
                        _this.pageCount=data.PageCount;
                        $(".infinite-scroll-noData").hide();
                        $(".assets-list ul").empty(); //追加之前先清空
                    }
                    $(".assets-list ul").append(_html); //添加数据
                }else {
                    $(".assets-list,.infinite-scroll-preloader,.infinite-scroll-noData").hide();
                    $(".common-empty").show();
                    $.toast(data.Message);
                }
                _this.loading=false;
                $(".infinite-scroll-preloader").hide();
            }
        })
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //进入页面获取数据
        _this.search("update");

        //选择类型
        $(".tab-nav a").on("click",function(){
            _this.ajaxData.Type=$(this).attr("data-type");
            _this.ajaxData.Page=1; //每次筛选page变为1
            _this.search("update");
        });

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
        //输入框输入
        $("input[name='keyword']").on("keyup",function(e){
            if(e.keyCode==13){
                var val=$.trim($(this).val());
                if(val==""){
                    $.toast("请输入你需要查询的资产");
                }else{
                    _this.ajaxData.Keyword=val;
                    _this.search("update");
                }
            }
        });
    }
})
$(document).ready(function(){
    pageObj.init();
});
