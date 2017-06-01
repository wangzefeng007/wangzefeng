/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 商品上架
     */
    GoodsShelf:function(assetId){
        layer.confirm('请确认是否上架此商品？', {
            btn: ['确定','取消'] //按钮
        },function(){
            $.ajax({
                type:"post",
                url:"",
                dataType: "json",
                data:{
                    "Intention":"",
                    "AssetID":assetId
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
        });
    },
    /**
     * 商品下架
     */
    GoodsShelf2:function(assetId){
        layer.confirm('请确认是否下架此商品？', {
            btn: ['确定','取消'] //按钮
        },function(){
            $.ajax({
                type:"post",
                url:"",
                dataType: "json",
                data:{
                    "Intention":"",
                    "AssetID":assetId
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
        });
    },
    /**
     * 进入页面初始化方法
     */
    init:function() {

    }
});
pageObj.init();