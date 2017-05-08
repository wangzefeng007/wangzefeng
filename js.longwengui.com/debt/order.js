/**
 * Created by irene on 2017/5/5.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 进入页面初始化方法
     */
    init:function() {
        var _this = this;
        $("#Js_buy").on("click",function(){
        _this.buyFun(this);
        });
    },
    numberInp:function(tar,type){
        var $inp=$(tar).parent(".input-number").find("input[name='num']"),
            inpVal=$inp.val();
        if(type=="+"){
            inpVal++;
        }else if(type=="-"){
            if(inpVal==1){
                return;
            }else{
                inpVal--;
            }
        }
        $inp.val(inpVal);
    },
    buyFun:function(obj){
        var goodsId=$(obj).attr("data-id");
        var buy_count=$("input[name='num']").val();
        go("/asset/order?id="+goodsId+"&num="+buy_count);
    },
});
pageObj.init();