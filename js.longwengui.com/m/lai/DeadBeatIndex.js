var pageObj=$.extend({},pageObj,{
    loading:false,  //是否正在加载
    pageCount:0,       //总页数
    //ajax参数
    ajaxData:{
        'Intention': 'debtorSearch',//提交方法
        "iname":"",       //名字名称
        "cardNum":"",           //身份证号/组织机构代码
        "areaName":"",           //地区
        'Page':1         //当前页
    },
    /**
     * 搜索
     * type add为滚动新增追加 update为条件筛选更新
     */
    search:function(type){
        $(".infinite-scroll-preloader").show();
        var _this=this;
        var iname=$.trim($("input[name='iname']").val());
        var cardNum=$.trim($("input[name='cardNum']").val());
        var areaName=$.trim($("input[name='areaName']").attr("data-value"));
        if(iname==""&&cardNum==""){
            $.toast("请输入必填");
            $(".infinite-scroll-preloader").hide();
            return;
        }
        var getParams={
            'iname':iname,      //名字名称
            'cardNum':cardNum,      //身份证号/组织机构代码
            'areaName':areaName      //地区
        }
        _this.ajaxData=$.extend({},_this.ajaxData,getParams);
        $.ajax({
            type: "post",	//提交类型
            dataType: "json",	//提交数据类型
            url: '/ajax.html',  //提交地址
            data: _this.ajaxData,
            success: function (data) {	//函数回调
                if (data.ResultCode == "200") {
                    $(".list-lai,.infinite-scroll-preloader").show();
                    $(".common-empty").hide();
                    var _html=template('lai_temp', data);
                    if(type=="update"){
                        _this.pageCount=data.PageCount;
                        $(".infinite-scroll-noData").hide();
                        $(".list-lai").empty(); //追加之前先清空
                    }
                    $(".list-lai").append(_html); //添加数据
                }else {
                    $(".list-lai,.infinite-scroll-preloader,.infinite-scroll-noData").hide();
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
        //地区初始化
        $("input[name='areaName']").picker({
            cols: [
                {
                    textAlign: 'center',
                    values:['全国', '北京', '天津', '河北', '山西', '内蒙古', '吉林', '黑龙江', '上海', '江苏', '浙江', '安徽', '福建', '江西', '山东', '河北', '湖北', '湖南', '广东', '广西', '海南', '重庆', '四川', '贵州', '云南', '西藏', '陕西', '甘肃', '青海', '宁夏', '新疆', '香港', '澳门', '台湾'],
                    displayValues:['全国', '北京', '天津', '河北', '山西', '内蒙古', '吉林', '黑龙江', '上海', '江苏', '浙江', '安徽', '福建', '江西', '山东', '河北', '湖北', '湖南', '广东', '广西', '海南', '重庆', '四川', '贵州', '云南', '西藏', '陕西', '甘肃', '青海', '宁夏', '新疆', '香港', '澳门', '台湾']
                }
            ]
        });
        //滚动加载
        $(".infinite-scroll-preloader").hide();
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
        //点击查询搜索
        $("#query").on("click",function(){
            _this.search("update");
        })
    }
})
$(document).ready(function(){
    pageObj.init();
});
