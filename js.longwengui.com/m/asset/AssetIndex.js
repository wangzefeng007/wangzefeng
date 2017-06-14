var pageObj=$.extend({},pageObj,{
    /**
     * ajax参数
     */
    ajaxData:{
        Intention:"TransferQuery",
        TransferType:"1",   //类型 1.资产转让 2.股权转让
        Sort:"",  //排序
        Keyword:"",  //关键字
        Page:1       //页数
    },
    /*
     * 查询列表*/
    getList:function(){
        var _this=this;
        $.ajax({
            type:"",
            url:"",
            data:_this.ajaxData,
            dataType:"json",
            success:function(data){

            }
        })
    },
    /**
     * 初始化方法
     */
    init:function() {
        var _this = this;

    }
})
$(document).ready(function(){
    pageObj.init();
});
