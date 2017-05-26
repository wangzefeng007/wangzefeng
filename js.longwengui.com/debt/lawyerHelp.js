/**
 * Created by irene on 2017/5/23.
 */
//其他城市选中刷新
function otherCitySel(){
    $('#area .sel').removeClass('sel');
    pageObj.param.help_area= $("#other_city").attr("data-id");
    pageObj.search(pageObj.param);
}

var pageObj=$.extend({},pageObj,{

    param:{
        help_area:"",
        case_type:""
    },
    /**
     * 点击查看
     * @param tar
     */
    seekShow:function(tar){
        $(tar).parents("li").addClass("active");
        var mobile=$(tar).parents("li").find(".mobile").attr("data-phone");
        $(tar).parents("li.active").find(".mobile").text(mobile);
    },
    /**
     * 投诉建议
     */
    suggestion:function(){
        var index = layer.open({
            title:'投诉与建议',
            type: 1,
            area: ['700px','280px'],
            shadeClose: true,
            content: $("#suggestionTemp").html()
        });
        $(".suggestion-box .btn-default").on("click",function(){
            layer.close(index);
        })
    },
    /**
     * 投诉建议提交
     */
    suggestionSub:function(tar){
        var suggestion=$(tar).parents(".suggestion-box").find("textarea[name='suggestion']").val();
        if(!suggestion){
            showMsg("投诉建议不能为空");
        }else{
            $.ajax({
                type:"post",
                url:"/loginajax.html",
                dataType: "json",
                data:{
                    "Intention":"AddAdvice",
                    "suggestion":suggestion
                },
                beforeSend:　function(){
                    showLoading();
                },success: function(data){
                    if(data.ResultCode == 200){
                        showMsg(data.Message);
                        location.reload();
                    }else{
                        showMsg(data.Message);
                    }
                },complete: function(){
                    closeLoading();
                }
            })
        }
    },
    //获得律师擅长方向元素
    getGoodAtData:function($wrap){
    //fixIE8Label();
    $.ajax({
        type: 'get',
        dataType: 'json',
        url: '/Templates/Debt/data/Direction.json',
        success: function(data){
            fixIE8Label();
            var _html='<div class="check-all m-checkbox sel">\
                    <label type="checkbox" data-id="">全部\
                    </label>\
                    </div>';
            for(var i=0;i<data.length;i++){
                _html+='<div class="m-checkbox">\
                    <label type="checkbox" data-id="'+data[i].GoodID+'">'+data[i].GoodName+'\
                    </label>\
                    </div>'
            }
            $wrap.addClass("m-checkbox-group");
            $wrap.html(_html);
        }
        });
    },
    /**
     * 搜索方法
     * @param param
     */
    search:function(param){
        //console.log(param);
        param.Intention="GetLegalAid";
        var _this=this;
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:param,
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == "200"){
                    $('.no-data').hide();
                    $('.lawyer-help-list').show();
                    $('#collection_page_pagination').show();
                    _this.dataSuccess(data.Data); //搜索结果数据注入
                    //获得当前页
                    _this.param.cur_page = data.Page;

                    //注入分页
                    injectPagination('#collection_page_pagination', _this.param.cur_page, data.PageCount, function(){
                        $('#collection_page_pagination').find('.b').click(function(){
                            var changeTo = pageChange($(this).attr('data-id'), _this.param.cur_page, data.PageCount);
                            if(changeTo){
                                ajax(changeTo);
                            }
                        });
                    });
                }else{
                    layer.msg(data.Message);
                    $('#collection_info').hide();
                    $('#collection_page_pagination').hide();
                    $('.no-data').show();
                }
            },complete: function(){
                closeLoading();
            }
        })
    },
    /**
     * 初始化方法
     */
    init:function(){
        var _this=this;
        //初始化案件类别
        _this.getGoodAtData($(".case-type"));
        $("#direction").on("click",".m-checkbox",function(){
            $(this).addClass("sel").siblings().removeClass("sel");
           var case_type= $(this).find("label").attr("data-id");
            _this.param.case_type=case_type;
            _this.search(_this.param);
        });
        $("#area span.span-2").on("click",function(){
            $(this).addClass("sel").siblings().removeClass("sel");
            var help_area= $(this).attr("data-id");
            _this.param.help_area=help_area;
            _this.search(_this.param);
        });
    },
});

window.onload=function(){
    pageObj.init();
}