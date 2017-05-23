/**
 * Created by irene on 2017/5/23.
 */
var pageObj=$.extend({},pageObj,{
    /**
     * 点击查看
     * @param tar
     */
    seekShow:function(tar){
        $(tar).parents("li").toggleClass("active");
    },
    suggestion:function(){

    },
    /**
     * 初始方法
     */
    init:function(){
        //省市区初始化
        getProvinceData();
    }
});
window.onload=function(){
    pageObj.init();
}