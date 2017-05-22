/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 取消订单
     * @param tar
     */
    cancelOrder:function(orderId){
        var _this=this;
        layer.confirm('是否取消订单？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("CancelOrder",orderId,function(){
                layer.msg('订单取消成功！', {icon: 1});
            })
        });
    },
    /**
     * 提醒卖家
     * @param tar
     */
    remind:function(orderId){
        var _this=this;
        _this.commonAjax("RemindSell",orderId,function(){
            $(tar).addClass("btn-disabled").removeClass("btn-primary");
            layer.msg('操作成功！');
        })

    },
    /**
     * 确认签收
     * @param tar
     */
    indeedReceipt:function(orderId){
        var _this=this;
        layer.confirm('是否确认签收？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("ConfirmReceipt",orderId,function(){
                layer.msg('签收成功！', {icon: 1});
            })
        });
    },
    /**
     * 删除订单
     * @param tar
     */
    delOrder:function(orderId){
        var _this=this;
        layer.confirm('是否删除订单？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("DelOrder",orderId,function(){
                layer.msg('删除成功！', {icon: 1});
            })
        });
    },
    /**
     * 撤销退货申请
     * @param tar
     */
    cancelApply:function(orderId){
        var _this=this;
        layer.confirm('是否取消申请？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("CancelApply",orderId,function(){
                layer.msg('取消成功！', {icon: 1});
            })
        });
    },
    /**
     * 立即退货
     * @param tar
     */
    immediatelyReturnGoods:function(orderId){
        var _this=this;
        var orderObj={
            orderId:orderId
        };
        $.ajax({
            type:"post",
            url:"/ajaxorder",
            dataType: "json",
            async:false,
            data:{
                "Intention":"GetOrderAddress",
                "orderId":orderId
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    orderObj=$.extend({},orderObj,data.Data);
                    $("#confirmReturnGoodsHtml").empty();
                    $('#confirmReturnGoodsTemp').tmpl(orderObj).appendTo("#confirmReturnGoodsHtml");
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
        });
        var index = layer.open({
            title:'退货并填写物流信息',
            type: 1,
            area: ['700px','450px'],
            shadeClose: true,
            content: $("#confirmReturnGoodsHtml").html()
        });
        //物流名称赋值
        addEventToDropdown("logisticsName",function(tar){
            $(tar).parent().siblings("span").text($(tar).text());
            $(tar).parent().siblings("input").val($(tar).text());
        });
    },
    /**
     * 确认退款
     * @param tar
     */
    indeedReturn:function(orderId){
        var _this=this;
        layer.confirm('请确认您是否拿到退款？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            _this.commonAjax("ConfirmRefund",orderId,function(){
                layer.msg('操作成功！', {icon: 1});
            })
        });
    },
    /**
     * 买家退货提交物流信息
     */
    subLogistics:function(tar){
        var $wrap=$(tar).parents(".return-goods-box");
        var logisticsName=$wrap.find("input[name='logisticsName']").val();
        var logisticsNo=$wrap.find("input[name='logisticsNo']").val();
        var orderId=$wrap.find("input[name='orderId']").val();
        if(!logisticsName){
            showMsg("请选择物流名称");
            return false;
        }else if(!logisticsNo){
            showMsg("请输入物流单号");
            return false;
        }else{
            $.ajax({
                type:"post",
                url:"/ajaxorder",
                dataType: "json",
                data:{
                    "Intention":"SubmitLogistics",
                    "logisticsName":logisticsName,
                    "logisticsNo":logisticsNo,
                    "orderId":orderId
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

    commonAjax:function(Intention,orderId,successFn){
        $.ajax({
            type:"post",
            url:"/ajaxorder",
            dataType: "json",
            data:{
                "Intention":Intention,
                "orderId":orderId
            },
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    showMsg(data.Message);
                    window.location.reload();
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