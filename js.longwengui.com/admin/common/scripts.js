
//根据域名后缀判断引用的通用的js
var Js = {
    com: 'http://js.57us.com',
    cn: 'http://js.57us.cn',
    net:'http://js.57us.net',
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

(function() {
    "use strict";

    // custom scrollbar

    $("html").niceScroll({styler:"fb",cursorcolor:"#65cea7", cursorwidth: '6', cursorborderradius: '0px', background: '#424f63', spacebarenabled:false, cursorborder: '0',  zindex: '1000'});

    $(".left-side").niceScroll({styler:"fb",cursorcolor:"#65cea7", cursorwidth: '3', cursorborderradius: '0px', background: '#424f63', spacebarenabled:false, cursorborder: '0'});

    $(".left-side").getNiceScroll();
    if ($('body').hasClass('left-side-collapsed')) {
        $(".left-side").getNiceScroll().hide();
    }

    // Toggle Left Menu
    jQuery('.menu-list > a').click(function() {

        var parent = jQuery(this).parent();
        var sub = parent.find('> ul');

        if(!jQuery('body').hasClass('left-side-collapsed')) {
            if(sub.is(':visible')) {
                sub.slideUp(200, function(){
                    parent.removeClass('nav-active');
                    jQuery('.main-content').css({height: ''});
                    mainContentHeightAdjust();
                });
            } else {
                visibleSubMenuClose();
                parent.addClass('nav-active');
                sub.slideDown(200, function(){
                    mainContentHeightAdjust();
                });
            }
        }
        return false;
    });

    function visibleSubMenuClose() {
        jQuery('.menu-list').each(function() {
            var t = jQuery(this);
            if(t.hasClass('nav-active')) {
                t.find('> ul').slideUp(200, function(){
                    t.removeClass('nav-active');
                });
            }
        });
    }

    function mainContentHeightAdjust() {
        // Adjust main content height
        var docHeight = jQuery(document).height();
        if(docHeight > jQuery('.main-content').height())
            jQuery('.main-content').height(docHeight);
    }

    //  class add mouse hover
    jQuery('.custom-nav > li').hover(function(){
        jQuery(this).addClass('nav-hover');
    }, function(){
        jQuery(this).removeClass('nav-hover');
    });

    // Menu Toggle
    jQuery('.toggle-btn').click(function(){
        $(".left-side").getNiceScroll().hide();

        if ($('body').hasClass('left-side-collapsed')) {
            $(".left-side").getNiceScroll().hide();
        }
        var body = jQuery('body');
        var bodyposition = body.css('position');

        if(bodyposition != 'relative') {

            if(!body.hasClass('left-side-collapsed')) {
                body.addClass('left-side-collapsed');
                jQuery('.custom-nav ul').attr('style','');

                jQuery(this).addClass('menu-collapsed');

            } else {
                body.removeClass('left-side-collapsed chat-view');
                jQuery('.custom-nav li.active ul').css({display: 'block'});

                jQuery(this).removeClass('menu-collapsed');

            }
        } else {

            if(body.hasClass('left-side-show'))
                body.removeClass('left-side-show');
            else
                body.addClass('left-side-show');

            mainContentHeightAdjust();
        }

    });

    searchform_reposition();

    jQuery(window).resize(function(){

        if(jQuery('body').css('position') == 'relative') {

            jQuery('body').removeClass('left-side-collapsed');

        } else {

            jQuery('body').css({left: '', marginRight: ''});
        }

        searchform_reposition();

    });

    function searchform_reposition() {
        if(jQuery('.searchform').css('position') == 'relative') {
            jQuery('.searchform').insertBefore('.left-side-inner .logged-user');
        } else {
            jQuery('.searchform').insertBefore('.menu-right');
        }
    }

    // panel collapsible
    $('.panel .tools .fa').click(function () {
        var el = $(this).parents(".panel").children(".panel-body");
        if ($(this).hasClass("fa-chevron-down")) {
            $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
            el.slideUp(200);
        } else {
            $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
            el.slideDown(200); }
    });

    $('.todo-check label').click(function () {
        $(this).parents('li').children('.todo-title').toggleClass('line-through');
    });

    $(document).on('click', '.todo-remove', function () {
        $(this).closest("li").remove();
        return false;
    });

    $("#sortable-todo").sortable();


    // panel close
    $('.panel .tools .fa-times').click(function () {
        $(this).parents(".panel").parent().remove();
    });

    var Position = $(".position").text();
    $('.menu-list li').each(function () {
        var menutext = $(this).find('a').text();
        if(Position == menutext){
            $(this).addClass('active');
            $(this).parents('.menu-list').addClass('nav-active');
        }
    })

    // nav-active
    // tool tips

    $('.tooltips').tooltip();

    // popovers

    $('.popovers').popover();

    //注销账号提示
    $('.signout').click(function () {
        layer.confirm('您确定要退出系统吗？', {
            title: '注销',
            btn: ['确定','取消'] //按钮
        }, function(){
            window.location.href='/index.php?Module=Admin&Action=Layout';
            layer.msg('退出成功');
        });
    })
    //图片点击显示大图
    $('.special-details-img img').click(function () {
        var imgurl = $(this).attr('src');
        var ww = $(this).attr('data-width');
        var hh = $(this).attr('data-height');
        if(ww > 1200){
            var www = 1000;
        }else {
            var www = ww;
        }
        if (hh > 600){
            var hhh = 600;
        }else {
            var hhh = hh;
        }
        var p = 15;
        var w = Number(www)+Number(p)+'px';
        var h = Number(hhh)+Number(p)+'px';
        layer.open({
            type: 2,
            title: false,
            shade: 0.8,
            closeBtn: 1,
            skin: 'layui-layer-demo', //样式类名
            area: [w, h],
            shadeClose: true,
            content: imgurl,
        });
    })

    //页码
    var page = $(".pagination").attr('data-id');
    $(".pagination li a").each(function () {
        var p = $(this).text();
        if(p == page){
            $(this).parent().addClass('active');
        }
    })
})(jQuery);
