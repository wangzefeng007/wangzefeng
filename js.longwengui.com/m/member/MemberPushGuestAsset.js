var pageObj=$.extend({},pageObj,{
    loading:false,  //是否正在加载
    pageCount:0,       //总页数
    assetType:'0',     //资产分类 0、我发布的 1、已买到的 2、已卖出的
    //ajax参数
    ajaxData:{
        'Intention':['GetAssetList','GetBuyOrderList','GetSellOrderList'],    //0、我发布的 1、已买到的 2、已卖出的
        'S':0,        //状态
        'Page':1   //当前页
    },
    /**
     * 搜索
     * type add为滚动新增追加 update为条件筛选更新
     */
    search:function(type){
        var _this=this;
        var getParams={
            'S':$(".tab-nav a.active").attr("data-value"),
            'Intention':_this.ajaxData.Intention[_this.assetType]
        }
        var ajaxParams=$.extend({},_this.ajaxData,getParams);
        console.log(ajaxParams);
        $.ajax({
            type: "post",	//提交类型
            dataType: "json",	//提交数据类型
            url: '/loginajax.html',  //提交地址
            data: ajaxParams,
            success: function (data) {	//函数回调
                if (data.ResultCode == "200") {
                    $(".item-goods-list,.infinite-scroll-preloader").show();
                    $(".common-empty").hide();
                    data.assetType=_this.assetType; //不同资产类型模板
                    var _html=template('asset_temp', data);
                    if(type=="update"){
                        _this.pageCount=data.PageCount;
                        $(".infinite-scroll-noData").hide();
                        $(".item-goods-list").empty(); //追加之前先清空
                    }
                    $(".item-goods-list").append(_html); //添加数据
                }else {
                    $(".item-goods-list,.infinite-scroll-preloader,.infinite-scroll-noData").hide();
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
        //资产类型
        $(".tab-nav a").on("click",function(){
            $("#my_assets").text("我发布的");
            $("#buy_assets").text("已买到的");
            $("#sale_assets").text("已卖出的");
            _this.assetType=$(this).attr("data-type");
            _this.ajaxData.Page=1; //每次筛选page变为1
            _this.search("update");
        })
        //进入页面搜索"
        _this.search("update");
        var toolbarTemplate= '<header class="bar bar-nav">\
                <button class="button button-link pull-right close-picker picker-indeed">确定</button>\
                <h1 class="title">请选择</h1>\
                </header>';
       /* //我发布的选择
        $("#my_assets").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [
                {
                    textAlign: 'center',
                    values: ['0','1', '2', '3'],
                    displayValues: ['全部','待审核', '审核通过', '审核未通过']
                }
            ]
        });
        //已买到的选择
        $("#buy_assets").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [
                {
                    textAlign: 'center',
                    values: ['0','1', '2', '3', '4 ','5'],
                    displayValues: ['全部','未付款', '已付款', '交易完成', '申请售后 ','交易关闭']
                }
            ]
        });

        //已卖出的选择
        $("#sale_assets").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [
                {
                    textAlign: 'center',
                    values: ['0','1', '2', '3', '4 ','5'],
                    displayValues: ['全部','未付款', '已付款', '交易完成', '申请售后 ','售后完成']
                }
            ]
        });*/
        $(document).on("click",".picker-indeed",function(){
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
    }
})
$(document).ready(function(){
    pageObj.init();
});