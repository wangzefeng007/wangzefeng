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
            'S':$("#status"+_this.assetType).attr("data-value"),
            'Intention':_this.ajaxData.Intention[_this.assetType]
        }
        var ajaxParams=$.extend({},_this.ajaxData,getParams);
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
     * 商品上架
     */
    GoodsShelf:function(assetId){
        $.confirm('请确认是否上架此商品？',
            function () {
                $.ajax({
                    type:"post",
                    url:"/ajaxasset/",
                    dataType: "json",
                    data:{
                        "Intention":"ProductShelves",
                        "AssetID":assetId
                    },
                    beforeSend:　function(){
                        $.showIndicator();
                    },success: function(data){
                        if(data.ResultCode == 200){
                            $.toast(data.Message);
                            location.reload();
                        }else{
                            $.toast(data.Message);
                        }
                    },complete: function(){
                        $.hideIndicator();
                    }
                })
            },
            function () {
                //$.alert('You clicked Cancel button');
            }
        );
    },
    /**
     * 商品下架
     */
    GoodsShelf2:function(assetId){
        $.confirm('请确认是否下架此商品？',
            function () {
                $.ajax({
                    type:"post",
                    url:"/ajaxasset/",
                    dataType: "json",
                    data:{
                        "Intention":"ProductShelves",
                        "AssetID":assetId
                    },
                    beforeSend:　function(){
                        $.showIndicator();
                    },success: function(data){
                        if(data.ResultCode == 200){
                            $.toast(data.Message);
                            location.reload();
                        }else{
                            $.toast(data.Message);
                        }
                    },complete: function(){
                        $.hideIndicator();
                    }
                })
            },
            function () {
                //$.alert('You clicked Cancel button');
            }
        );
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //进入页面搜索"
        _this.search("update");
        var toolbarTemplate= '<header class="bar bar-nav">\
                <button class="button button-link pull-right close-picker picker-indeed">确定</button>\
                <h1 class="title">请选择</h1>\
                </header>';

       var colsArray=[
           {
               textAlign: 'center',
               values: ['0','1', '2', '3'],
               displayValues: ['全部','待审核', '审核通过', '审核未通过']
           },
           {
               textAlign: 'center',
               values: ['0','1', '2', '3', '4 ','5'],
               displayValues: ['全部','未付款', '已付款', '交易完成', '申请售后 ','交易关闭']
           },
           {
               textAlign: 'center',
               values: ['0','1', '2', '3', '4 ','5'],
               displayValues: ['全部','已付款', '已发货', '交易完成', '售后中 ','售后完成']
           }
       ];
        $("#status0").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [colsArray[0]]
        });
        $("#status1").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [colsArray[1]]
        });
        $("#status2").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [colsArray[2]]
        });
        //筛选选择
        $(document).on("click",".picker-indeed",function(){
            _this.ajaxData.Page=1; //每次筛选page变为1
            _this.search("update");
        });
        //资产类型
        $(".tab-nav a").on("click",function(){
            $(".header-right").attr("data-value","0").text("筛选");
            _this.assetType=$(this).attr("data-type");
            _this.ajaxData.Page=1; //每次筛选page变为1
            _this.search("update");
            $("#status"+_this.assetType).show();
            $("#status"+_this.assetType).siblings(".header-right").hide();
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