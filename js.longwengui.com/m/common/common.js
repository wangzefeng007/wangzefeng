/**
 * 页面加载完毕
 */
window.onload=function(){
    $.init();
}
Zepto(function($){
	/*触摸添加样式 touch*/
    $(".index-top .bottom-btn,.index-nav a,.btn,.btn-blue,.btn-red").on("touchstart",function(){
        $(this).addClass("touch");
    });
	/*触摸结束删除样式 touch*/
    $(".index-top .bottom-btn,.index-nav a,.btn,.btn-blue,.btn-red").on("touchend touchmove touchcancel",function(){
        $(this).removeClass("touch");
    });
});

$(function(){
    /**
     * 头部返回事件
     */
    $(document).on("click",".header-left.icon-back",function(){
        window.history.go(-1);
    });
    /**
     * 首页底部添加按钮
     */
    $(".icon-nav-add").on("click",function(){
        if($(".publish-box").hasClass("open")){
            $(".publish-box").removeClass("open");
        }else{
            $(".publish-box").addClass("open");
        }
    });
    /**
	 * tab 切换
     */
    $(".tab-nav a").on("click",function(e){
        e.preventDefault();
        $(this).addClass("active").siblings("a").removeClass("active");
        var forTab=$(this).parents(".tab-nav").attr("for")||"";
        var targetCon=$(this).attr("href");
        $(forTab+".tab-con").children("div"+targetCon).addClass("active");
        $(forTab+".tab-con").children("div"+targetCon).siblings().removeClass("active");
    });
})



//获得cookie
function getCookie(name){
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr=document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}
//验证方法
function validate(type, text){
    switch (type) {
        case 'phone': //验证电话
            return /^1[3|4|5|8][0-9]\d{8}$/.test(text) || /^0[\d]{2,3}-[\d]{7,8}$/.test(text);
            break;
        case 'fixedPhone': //验证固定电话
            return /^0[\d]{2,3}-[\d]{7,8}$/.test(text);
            break;
        case 'chinese': //验证中文
            for(var i=0; i<text.length; i++){
                if(!(/^[\u4E00-\u9FA5]|[\uF900-\uFA2D]$/.test(text[i]))){
                    return false;
                }
            }
            return true;
            break;
        case 'idNum': //验证身份证
            return /^\d{17}(\d|X|x)$/.test(text);
        case '+number': //验证正整数
            return /^[0-9]*[1-9][0-9]*$/.test(text);
        case 'day': //验证天数
            return /^[0-9]*[0-9]*$/.test(text);
        case '+money': //验证金额
            return /^[0-9]+(\.[0-9]{1,2})?$/.test(text);
        case 'mobilePhone': //验证手机号码
            return /^1[3|4|5|7|8][0-9]\d{8}$/.test(text);
        case 'password': //验证密码
            return /^(\w){6,20}$/.test(text);
        case 'email': //验证邮箱
            return /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/.test(text);
        case 'qq': //验证qq
            return /^[1-9][0-9]{6,12}$/.test(text);
        case 'creditNum': //验证信用代码
            return /^[0-9A-Za-z]+$/.test(text);
        case 'lawJobNo': //验证执业证号
            return /^[0-9]{17}$/.test(text);
        default:
            return false;
    }
}
/**
 * 验证正整数
 * @param tar
 */
function validateNumber(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('+number', _text)){
        showTip(tar, '请输入正确的正整数');
        $(tar).val('');
        return;
    }
}

//验证时间
function validateDay(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('day', _text)){
        showTip(tar, '请输入正确的天数');
        return;
    }
}
//验证手机号码
function validateMobilePhone(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('mobilePhone', _text)){
        showTip(tar, '请输入正确的手机号码');
        $(tar).val("");
        return;
    }
}

//验证固定电话
function validateFixedPhone(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('fixedPhone', _text)){
        showTip(tar, '请输入正确的固定电话号码');
        return;
    }
}

//律师执业证号验证
function validateLawJobNo(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('lawJobNo', _text)){
        showTip(tar, '请输入正确的律师执业证号');
        return;
    }
}
//社会信用代码验证
function validateCreditNum(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('creditNum', _text)){
        showTip(tar, '请输入正确的社会信用代码');
        return;
    }
}
//qq验证
function validateQQ(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        if(isNeed){
            showTip(tar, '请输入');
        }
        return;
    }
    if(!validate('qq', _text)){
        showTip(tar, '请输入正确的qq');
        return;
    }
}
//邮箱验证
function validateEmail(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        if(isNeed){
            showTip(tar, '请输入');
        }
        return;
    }
    if(!validate('email', _text)){
        showTip(tar, '请输入正确的邮箱');
        return;
    }
}
//号码验证
function validatePhone(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        if(isNeed){
            showTip(tar, '请输入');
        }
        return;
    }
    if(!validate('phone', _text)){
        showTip(tar, '请输入有效号码');
        $(tar).val("");
        return;
    }
}
//中文验证
function validateChinese(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    for(var i=0; i<_text.length; i++){
        if(!validate('chinese', _text[i])){
            showTip(tar, '请输入中文');
            return;
        }
    }
}
//身份证验证
function validateIDNumber(tar, isNeed){
    var _text = $(tar).val();
    if(_text == ''){
        if(isNeed){
            showTip(tar, '请输入');
        }
        return;
    }
    if(!validate('idNum', _text)){
        showTip(tar, '请输入有效身份证');
        return;
    }
}
//验证金额
function validateMoney(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
    if(!validate('+money', _text)){
        showTip(tar, '请输入正确金额，最多保留2位小数');
        $(tar).val('');
        return;
    }
}
//检验是否必须
function validateNeed(tar){
    var _text = $(tar).val();
    if(_text == ''){
        showTip(tar, '请输入');
        return;
    }
}

//发送验证码倒计时 60秒不能重复提交 tar为button
function codeTimedown(tar){
    var pre_text = $(tar).html();
    var totalTime = 60;
    $(tar)[0].disabled = true;
    $(tar).html(totalTime + 's');
    var inr = setInterval(function(){
        totalTime--;
        var html = totalTime + 's';
        $(tar).html(html);
        if(totalTime == 0){
            $(tar).html(pre_text);
            clearInterval(inr);
            $(tar)[0].disabled = false;
        }
    }, 1000);
}