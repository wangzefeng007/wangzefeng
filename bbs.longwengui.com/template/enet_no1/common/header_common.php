<?php exit;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}" />
	<!--{if $_G['config']['output']['iecompatible']}--><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE{$_G['config']['output']['iecompatible']}" /><!--{/if}-->
	<title><!--{if !empty($navtitle)}-->$navtitle - <!--{/if}--><!--{if empty($nobbname)}--> $_G['setting']['bbname'] - <!--{/if}--> Powered by Discuz!</title>
	$_G['setting']['seohead']

	<meta name="keywords" content="{if !empty($metakeywords)}{echo dhtmlspecialchars($metakeywords)}{/if}" />
	<meta name="description" content="{if !empty($metadescription)}{echo dhtmlspecialchars($metadescription)} {/if}{if empty($nobbname)},$_G['setting']['bbname']{/if}" />
	<meta name="generator" content="Discuz! $_G['setting']['version']" />
	<meta name="author" content="Www.AdminBuy.Cn" />
	<meta name="copyright" content="2001-2013 Comsenz Inc." />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	<meta http-equiv="MSThemeCompatible" content="Yes" />
	<base href="{$_G['siteurl']}" />
	<!--{csstemplate}-->
	<script src="template/enet_no1/js/jquery1.3.2.js" type="text/javascript"></script>
	<script type="text/javascript">var scrollSpeed = 1;var step = 1;var current = 0;var imageWidth = 2015;var headerWidth = 2015;var restartPosition = -(imageWidth - headerWidth); function scrollBg(){current -= step;if (current == restartPosition){current = 0;}jQuery('.Horizontalscroll').css("background-position",current+"px 0");}var init = setInterval("scrollBg()", scrollSpeed);</script>
	<script type="text/javascript">var STYLEID = '{STYLEID}', STATICURL = '{STATICURL}', IMGDIR = '{IMGDIR}', VERHASH = '{VERHASH}', charset = '{CHARSET}', discuz_uid = '$_G[uid]', cookiepre = '{$_G[config][cookie][cookiepre]}', cookiedomain = '{$_G[config][cookie][cookiedomain]}', cookiepath = '{$_G[config][cookie][cookiepath]}', showusercard = '{$_G[setting][showusercard]}', attackevasive = '{$_G[config][security][attackevasive]}', disallowfloat = '{$_G[setting][disallowfloat]}', creditnotice = '<!--{if $_G['setting']['creditnotice']}-->$_G['setting']['creditnames']<!--{/if}-->', defaultstyle = '$_G[style][defaultextstyle]', REPORTURL = '$_G[currenturl_encode]', SITEURL = '$_G[siteurl]', JSPATH = '$_G[setting][jspath]', CSSPATH = '$_G[setting][csspath]', DYNAMICURL = '$_G[dynamicurl]';</script>
	<script type="text/javascript" src="{$_G[setting][jspath]}common.js?{VERHASH}"></script>
	<script src="template/enet_no1/js/floating.min.js"></script>
	<!--{if empty($_GET['diy'])}--><!--{eval $_GET['diy'] = '';}--><!--{/if}-->
	<!--{if !isset($topic)}--><!--{eval $topic = array();}--><!--{/if}-->
<!--[if lte IE 6]>
<script type="text/javascript">
var arVersion = navigator.appVersion.split("MSIE")
var version = parseFloat(arVersion[1])
function fixPNG(myImage)
{
     if ((version >= 5.5) && (version < 7) && (document.body.filters))
    {
       var imgID = (myImage.id) ? "id='" + myImage.id + "' " : ""
    var imgClass = (myImage.className) ? "class='" + myImage.className + "' " : ""
    var imgTitle = (myImage.title) ?
                 "title='" + myImage.title  + "' " : "title='" + myImage.alt + "' "
    var imgStyle = "display:inline-block;" + myImage.style.cssText
    var strNewHTML = "<span " + imgID + imgClass + imgTitle
                  + " style=\"" + "width:" + myImage.width
                  + "px; height:" + myImage.height
                  + "px;" + imgStyle + ";"
                  + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
                  + "(src=\'" + myImage.src + "\', sizingMethod='scale');\"></span>"
    myImage.outerHTML = strNewHTML
    }
}
</script>
<![endif]-->