/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 取消订单
     * @param tar
     */
    cancelOrder:function(tar){
        var _this=this;
        var param={};
        layer.confirm('是否取消订单？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("cancelOrder",param,function(){
                layer.msg('订单取消成功！', {icon: 1});
            })
        });
    },
    /**
     * 提醒卖家
     * @param tar
     */
    remind:function(tar){
        var _this=this;
        var param={};
        _this.commonAjax("cancelOrder",param,function(){
            $(tar).addClass("btn-disabled").removeClass("btn-primary");
            layer.msg('操作成功！');
        })

    },
    /**
     * 确认签收
     * @param tar
     */
    indeedReceipt:function(tar){
        var _this=this;
        var param={};
        layer.confirm('是否确认签收？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("indeedReceipt",param,function(){
                layer.msg('签收成功！', {icon: 1});
            })

        });
    },
    /**
     * 删除订单
     * @param tar
     */
    delOrder:function(tar){
        var _this=this;
        var param={};
        layer.confirm('是否删除订单？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("delOrder",param,function(){
                layer.msg('删除成功！', {icon: 1});
            })
        });
    },
    /**
     * 取消申请
     * @param tar
     */
    cancelApply:function(tar){
        var _this=this;
        var param={};
        layer.confirm('是否取消申请？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("cancelApply",param,function(){
                layer.msg('取消成功！', {icon: 1});
            })
        });
    },
    /**
     * 确认退款
     * @param tar
     */
    indeedReturn:function(tar){
        var _this=this;
        var param={};
        layer.confirm('是否确认退款？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("indeedReturn",param,function(){
                layer.msg('操作成功！', {icon: 1});
            })
        });
    },
    /**
     * 共同询问框
     * @param confirmMsg
     * @param okMsg
     * @param btn
     */
    /*orderConfirm:function(confirmMsg,okMsg,btn,okFn){
        var defaultConfig={
            confirmMsg:"是否确认操作？",
            okMsg:"操作成功！",
            btn:['确定','取消']
        };

        //询问框
        layer.confirm(confirmMsg, {
            btn: btn //按钮
        }, function(){
            layer.msg(okMsg, {icon: 1});
        });
    },*/

    commonAjax:function(Intention,param,successFn){
        $.ajax({
            type:"post",
            url:"/loginajax.html",
            dataType: "json",
            data:{
                "Intention":Intention,
                "AjaxJSON":param
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    //成功之后调用回调函数
                    successFn.call(this);
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        })
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {

    }
});
pageObj.init();