/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    //默认搜索参数
    queryParam:{
        Intention:"TransferQuery",
        TransferType:"1",   //类型 1.资产转让 2.股权转让
        Sort:"",  //排序
        Keyword:"",  //关键字
        Page:1       //页数
    },
    /*
     * 进入页面初始化方法*/
    init:function(){
        var _this=this;
        /*
         排序方式切换
         * */
        $("#selectTab li").on("click",function(){
            var sort=$(this).attr("data-sort");
            $(this).addClass("active").siblings().removeClass("active");
            _this.queryParam.Sort=sort;
        });

        /*
         * 搜索按钮
         * */
        /*$("#searchBtn").on("click",function(){
            var $inp=$("#keyword");
            _this.queryParam.Keyword=$inp.val();
            _this.getList();
        });*/
        /*按下enter键搜索*/
        /*$("#searchBtn").on("keyup",function(e){
            if(e.keyCode==13){
                _this.queryParam.Keyword=$inp.val();
                _this.getList();
            }
        });*/
    },
    /*
     * 查询列表*/
    getList:function(){
        var _this=this;
        $.ajax({
            type:"",
            url:"",
            data:_this.queryParam,
            dataType:"json",
            beforeSend:function(){
                showLoading();
            },
            success:function(data){
                if(data.ResultCode == "200"){
                    $('.no-data').hide();
                    $('#result_info').show();
                    $('#result_page_pagination').show();
                    dataSuccess(data.Data); //搜索结果数据注入
                    //获得当前页
                    _this.queryParam.Page= data.Page;

                    //注入分页
                    injectPagination('#result_page_pagination', _this.queryParam.Page, data.PageCount, function(){
                        $('#result_page_pagination').find('.b').click(function(){
                            var changeTo = pageChange($(this).attr('data-id'), _this.queryParam.Page, data.PageCount);
                            if(changeTo){
                                ajax(changeTo);
                            }
                        });
                    });
                }else{
                    layer.msg(data.Message);
                    $('#result_info').hide();
                    $('#result_page_pagination').hide();
                    $('.no-data').show();
                }
            },
            complete:function(){
                closeLoading();
            }
        })
    },
    favoFun:function(tar){
        var paramObj={
            assetId:$(tar).attr("data-id")
        };
        $.ajax({
            type:"post",
            url:"/ajaxasset/",
            dataType: "json",
            data:{
                "Intention":"",
                "AjaxJSON":JSON.stringify(paramObj)
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    showMsg(data.Message);
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        })
    }
    /*
     模板渲染数据并插入页面
     * */
    /*dataSuccess:function(data){
        $('#result_info').empty();
        var _arr = [];
        _arr.push(data);
        $('#resultListTemp').tmpl(_arr).appendTo('#result_info ul');
    }*/
});
pageObj.init();