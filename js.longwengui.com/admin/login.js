/**
 * Created by Foliage on 2016/9/5.
 */
//根据域名后缀判断引用的通用的js
var Js = {
    com: 'http://js.longwengui.com',
    cn: 'http://js.longwengui.cn',
    net:'http://js.longwengui.net',
};
host = window.location.host.split('.');
var suffix = host[2];

//js直接引对应的css
function W_creatLink(cssUrl) {
    var link = document.createElement("link");
    link.type = "text/css";
    link.rel = "stylesheet";
    if(suffix == 'cn') {
        link.href = Js.cn + cssUrl;
    } else if(suffix == 'com') {
        link.href = Js.com + cssUrl;
    } else if (suffix == 'net') {
        link.href == Js.net + cssUrl;
    }
    document.getElementsByTagName("head")[0].appendChild(link);
}

$(function () {
    $('.registration a').click(function () {
        layer.msg('暂不支持注册功能');
    })

    $('#reset').on('click',function () {
        layer.msg('功能开发中...');
    })
})