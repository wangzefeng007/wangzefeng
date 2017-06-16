var pageObj=$.extend({},pageObj,{
    loading:false,  //是否正在加载
    pageCount:0,       //总页数
    //ajax参数
    ajaxData:{
        'Intention': 'GetLegalAid',//提交方法
        'help_area':0, //地区
        'case_type':"",        //案件类型
        'Page':1         //当前页
    },
    /**
     * 获取案件类型
     */
    caseTypeData:function(){
        var caseTypeIds=[""];  //案件类型ID数组
        var caseTypeNames=["全部"];    //案件类型NAME数组
        $.ajax({
            type: 'get',
            async:false,
            dataType: 'json',
            url: '/Templates/Debt/data/Direction.json',
            success: function(data){
                for(var i=0;i<data.length;i++){
                    caseTypeIds.push(data[i].GoodID);
                    caseTypeNames.push(data[i].GoodName);
                }
            }
        });
        return {
            ids:caseTypeIds,
            names:caseTypeNames
        };
    },
    /**
     * 查看
     */
    detailShow:function(tar){
        $(tar).parents("li").toggleClass("active");
        $(tar).parents("li").find(".disposal-con").toggleClass("hide");
    },
    /**
     * 搜索
     * type add为滚动新增追加 update为条件筛选更新
     */
    search:function(type){
        var _this=this;
        var getParams={
            'help_area':!$("#city").attr("data-value")==true?0:$("#city").attr("data-value").split(" ")[2], //地区
            'case_type':$("#type").attr("data-value")||"",        //案件类型
        }
        _this.ajaxData=$.extend({},_this.ajaxData,getParams);
        $.ajax({
            type: "post",	//提交类型
            dataType: "json",	//提交数据类型
            url: '/ajax.html',  //提交地址
            data: _this.ajaxData,
            success: function (data) {	//函数回调
                if (data.ResultCode == "200") {
                    $(".disposal-list,.infinite-scroll-preloader").show();
                    $(".common-empty").hide();
                    var _html=template('lawyer_temp', data);
                    if(type=="update"){
                        _this.pageCount=data.PageCount;
                        $(".infinite-scroll-noData").hide();
                        $(".disposal-list>ul").empty(); //追加之前先清空
                    }
                    $(".disposal-list>ul").append(_html); //添加数据
                }else {
                    $(".disposal-list,.infinite-scroll-preloader,.infinite-scroll-noData").hide();
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
        //选择地区
        $("#city").cityPicker();
        //进入页面搜索
        _this.search("update");
        //案件类型
        $("#type").picker({
            cols: [
                {
                    textAlign: 'center',
                    values: _this.caseTypeData().ids,
                    displayValues: _this.caseTypeData().names
                }
            ]
        });
        $(document).on("click",".close-picker",function(){
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