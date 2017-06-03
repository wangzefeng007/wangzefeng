<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('mobile');
0
|| checktplrefresh('./source/plugin/mobile/template/mobile.htm', './template/enet_no1/common/header.htm', 1496404115, 'mobile', './data/template/2_mobile_mobile.tpl.php', './source/plugin/mobile/template', 'mobile')
|| checktplrefresh('./source/plugin/mobile/template/mobile.htm', './template/enet_no1/common/footer.htm', 1496404115, 'mobile', './data/template/2_mobile_mobile.tpl.php', './source/plugin/mobile/template', 'mobile')
|| checktplrefresh('./source/plugin/mobile/template/mobile.htm', './template/enet_no1/common/header_common.htm', 1496404115, 'mobile', './data/template/2_mobile_mobile.tpl.php', './source/plugin/mobile/template', 'mobile')
|| checktplrefresh('./source/plugin/mobile/template/mobile.htm', './template/enet_no1/common/header_myhome.htm', 1496404115, 'mobile', './data/template/2_mobile_mobile.tpl.php', './source/plugin/mobile/template', 'mobile')
|| checktplrefresh('./source/plugin/mobile/template/mobile.htm', './template/enet_no1/common/header_qmenu.htm', 1496404115, 'mobile', './data/template/2_mobile_mobile.tpl.php', './source/plugin/mobile/template', 'mobile')
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<?php if($_G['config']['output']['iecompatible']) { ?><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE<?php echo $_G['config']['output']['iecompatible'];?>" /><?php } ?>
<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> Powered by Discuz!</title>
<?php echo $_G['setting']['seohead'];?>

<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />
<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } if(empty($nobbname)) { ?>,<?php echo $_G['setting']['bbname'];?><?php } ?>" />
<meta name="generator" content="Discuz! <?php echo $_G['setting']['version'];?>" />
<meta name="author" content="Www.AdminBuy.Cn" />
<meta name="copyright" content="2001-2013 Comsenz Inc." />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<base href="<?php echo $_G['siteurl'];?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_2_common.css?<?php echo VERHASH;?>" /><?php if($_G['uid'] && isset($_G['cookie']['extstyle']) && strpos($_G['cookie']['extstyle'], TPLDIR) !== false) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['cookie']['extstyle'];?>/style.css" /><?php } elseif($_G['style']['defaultextstyle']) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['style']['defaultextstyle'];?>/style.css" /><?php } ?><script src="template/enet_no1/js/jquery1.3.2.js" type="text/javascript" type="text/javascript"></script>
<script type="text/javascript">var scrollSpeed = 1;var step = 1;var current = 0;var imageWidth = 2015;var headerWidth = 2015;var restartPosition = -(imageWidth - headerWidth); function scrollBg(){current -= step;if (current == restartPosition){current = 0;}jQuery('.Horizontalscroll').css("background-position",current+"px 0");}var init = setInterval("scrollBg()", scrollSpeed);</script>
<script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>', CSSPATH = '<?php echo $_G['setting']['csspath'];?>', DYNAMICURL = '<?php echo $_G['dynamicurl'];?>';</script>
<script src="<?php echo $_G['setting']['jspath'];?>common.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="template/enet_no1/js/floating.min.js" type="text/javascript"></script>
<?php if(empty($_GET['diy'])) { $_GET['diy'] = '';?><?php } if(!isset($topic)) { $topic = array();?><?php } ?>
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
<![endif]--><meta name="application-name" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-tooltip" content="<?php echo $_G['setting']['bbname'];?>" />
<?php if($_G['setting']['portalstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['1']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G['siteurl'].'portal.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/portal.ico" /><?php } ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['2']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G['siteurl'].'forum.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/bbs.ico" />
<?php if($_G['setting']['groupstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['3']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G['siteurl'].'group.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/group.ico" /><?php } if(helper_access::check_module('feed')) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['4']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G['siteurl'].'home.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/home.ico" /><?php } if($_G['basescript'] == 'forum' && $_G['setting']['archiver']) { ?>
<link rel="archives" title="<?php echo $_G['setting']['bbname'];?>" href="<?php echo $_G['siteurl'];?>archiver/" />
<?php } if(!empty($rsshead)) { ?><?php echo $rsshead;?><?php } if(widthauto()) { ?>
<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_widthauto.css?<?php echo VERHASH;?>" />
<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
<?php } if($_G['basescript'] == 'forum' || $_G['basescript'] == 'group') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>forum.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'home' || $_G['basescript'] == 'userapp') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>home.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'portal') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<link rel="stylesheet" type="text/css" id="diy_common" href="data/cache/style_<?php echo STYLEID;?>_css_diy.css?<?php echo VERHASH;?>" />
<?php } ?>
</head>
<body id="nv_<?php echo $_G['basescript'];?>" class="pg_<?php echo CURMODULE;?><?php if($_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)) { ?> <?php echo $cat['bodycss'];?><?php } ?>" onkeydown="if(event.keyCode==27) return false;">
<div class="absolute_body_bg"></div>
<?php if($_G['style']['extstyle']) { ?><span href="javascript:void(0)" class="run" id="sslct">切换风格</span><?php } ?>
<div id="append_parent"></div><div id="ajaxwaitid"></div>
<?php if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { include template('common/header_diy'); } if(check_diy_perm($topic)) { include template('common/header_diynav'); } if(CURMODULE == 'topic' && $topic && empty($topic['useheader']) && check_diy_perm($topic)) { ?>
<?php echo $diynav;?>
<?php } if(empty($topic) || $topic['useheader']) { if($_G['setting']['mobile']['allowmobile'] && (!$_G['setting']['cacheindexlife'] && !$_G['setting']['cachethreadon'] || $_G['uid']) && ($_GET['diy'] != 'yes' || !$_GET['inajax']) && ($_G['mobile'] != '' && $_G['cookie']['mobile'] == '' && $_GET['mobile'] != 'no')) { ?>
<div class="xi1 bm bm_c">
    请选择 <a href="<?php echo $_G['siteurl'];?>forum.php?mobile=yes">进入手机版</a><span class="xg1">|</span> <a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>">继续访问电脑版</a>
</div>
<?php } if($_G['setting']['shortcut'] && $_G['member']['credits'] >= $_G['setting']['shortcut']) { ?>
<div id="shortcut">
<span><a href="javascript:;" id="shortcutcloseid" title="关闭">关闭</a></span>
您经常访问 <?php echo $_G['setting']['bbname'];?>，试试添加到桌面，访问更方便！
<a href="javascript:;" id="shortcuttip">添加 <?php echo $_G['setting']['bbname'];?> 到桌面</a>

</div>
<script type="text/javascript">setTimeout(setShortcut, 2000);</script>
<?php } if(!IS_ROBOT) { if($_G['uid']) { ?>
<ul id="myprompt_menu" class="p_pop" style="display: none;">				
<li><a href="home.php?mod=space&amp;do=pm" id="pm_ntc" style="background-repeat: no-repeat; background-position: 0 50%;"><em class="prompt_news<?php if(empty($_G['member']['newpm'])) { ?>_0<?php } ?>"></em>消息</a></li>
<li><a href="home.php?mod=follow&amp;do=follower"><em class="prompt_follower<?php if(empty($_G['member']['newprompt_num']['follower'])) { ?>_0<?php } ?>"></em>新听众<?php if($_G['member']['newprompt_num']['follower']) { ?>(<?php echo $_G['member']['newprompt_num']['follower'];?>)<?php } ?></a></li>
<?php if($_G['member']['newprompt'] && $_G['member']['newprompt_num']['follow']) { ?>
<li><a href="home.php?mod=follow"><em class="prompt_concern"></em>我关注的(<?php echo $_G['member']['newprompt_num']['follow'];?>)</a></li>
<?php } if($_G['member']['newprompt']) { if(is_array($_G['member']['category_num'])) foreach($_G['member']['category_num'] as $key => $val) { ?><li><a href="home.php?mod=space&amp;do=notice&amp;view=<?php echo $key;?>"><em class="notice_<?php echo $key;?>"></em><?php echo lang('template', 'notice_'.$key); ?>(<span class="rq"><?php echo $val;?></span>)</a></li>
<?php } } if(empty($_G['cookie']['ignore_notice'])) { ?>
<li class="ignore_noticeli"><a href="javascript:;" onclick="setcookie('ignore_notice', 1);hideMenu('myprompt_menu')" title="暂不提醒"><em class="ignore_notice"></em></a></li>
<?php } ?>
</ul>
<?php } if($_G['style']['extstyle']) { ?>
<script type="text/javascript">
var $ = function(){
return document.getElementById(arguments[0]);
};

var btnFn = function( e ){
alert( e.target );
return false;
};

$('sslct').onclick = function(){
easyDialog.open({
container : {
header : '切换风格',
content : '<div><div class="login_text" <?php if($_G['uid']) { ?> style="display:none"<?php } ?>></div><?php if(!empty($_G['style']['extstyle'])) { if(!$_G['style']['defaultextstyle']) { ?><span class="sslct_btn" <?php if($_G['uid']) { ?> onclick="extstyle(\'\');document.getElementById(\'home_hear_bg\').src=\'./template/enet_no1/images/home_hear_bg.jpg\';return false;" style="cursor: pointer" <?php } ?> title="默认"><i style="background:url(template/enet_no1/images/preview.jpg)"></i><i style="background: rgba(0, 0, 0, 0.3);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = #30000000,endColorstr = #30000000);margin-top:-23px;padding-top:2px;text-align: center;color:#fff;height:20px;overflow: hidden;clear: both;">默认</i></span><?php } if(is_array($_G['style']['extstyle'])) foreach($_G['style']['extstyle'] as $extstyle) { ?><span class="sslct_btn" <?php if($_G['uid']) { ?> onclick="extstyle(\'<?php echo $extstyle['0'];?>\');document.getElementById(\'home_hear_bg\').src=\'<?php echo $extstyle['0'];?>/home_hear_bg.jpg\';return false;" style="cursor:pointer" <?php } ?> title="<?php echo $extstyle['1'];?>"><i style="background:url(<?php echo $extstyle['0'];?>/preview.jpg)"></i><i style="background: rgba(0, 0, 0, 0.3);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = #30000000,endColorstr = #30000000);margin-top:-23px;padding-top:2px;text-align:center;color:#fff;height:20px;overflow:hidden;clear:both"><?php echo $extstyle['1'];?></i></span><?php } } ?><div style="clear:both"></div></div><div class="o pns" style="margin-top:10px;margin-bottom:-10px;margin-left:-10px;margin-right:-6px;text-align: left;line-height: 35px"><div style="float:left">&#x6CE8;&#xFF1A;&#x90E8;&#x5206;&#x6A21;&#x677F;&#x9009;&#x62E9;&#x5B8C;&#x540E;&#x4E0D;&#x80FD;&#x6B63;&#x786E;&#x663E;&#x793A;&#x51FA;&#x6548;&#x679C;&#xFF0C;&#x60A8;&#x53EF;&#x4EE5;&#x5355;&#x51FB;&#x786E;&#x5B9A;&#x6765;&#x89E3;&#x51B3;</div><button type="submit" <?php if($_G['uid']) { ?>class="pn pnc" onclick="history.go(0)" style="float:right;cursor: pointer;height:30px;margin-right:0"<?php } else { ?>class="pn" style="float:right;cursor: auto;height:30px;margin-right:0"<?php } ?>><strong>确定</strong></button><div style="clear:both"></div></div>'
},
        overlay : false
});
};

</script>
<?php } if($_G['uid']) { ?>
<ul id="myitem_menu" class="p_pop" style="display: none;">
<li><a href="forum.php?mod=guide&amp;view=my">帖子</a></li>
<li><a href="home.php?mod=space&amp;do=favorite&amp;view=me">收藏</a></li>
<li><a href="home.php?mod=space&amp;do=friend">好友</a></li>
<?php if(!empty($_G['setting']['pluginhooks']['global_myitem_extra'])) echo $_G['setting']['pluginhooks']['global_myitem_extra'];?>
</ul>
<?php } ?>
<div id="so_box" style="display: none;position: fixed;_position:absolute;top: 300px;left: 50%;margin-left: -463px;z-index:200;width:918px">
 <a href="javascript:;" id="so_close" onclick="$('so_box').style.display='none'">关闭</a>	
 <?php if($_G['setting']['search']) { ?>
                   <?php $slist = array();?>                   <?php if($_G['fid'] && $_G['forum']['status'] != 3 && $mod != 'group') { ?><?php
$slist[forumfid] = <<<EOF
<li><a href="javascript:;" rel="curforum" fid="{$_G['fid']}" >本版</a></li>
EOF;
?><?php } ?>
                   <?php if($_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)) { ?><?php
$slist[portal] = <<<EOF
<li> <a href="javascript:;" rel="article">文章</a></li>
EOF;
?><?php } ?>
                   <?php if($_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)) { ?><?php
$slist[forum] = <<<EOF
<li><a href="javascript:;" rel="forum" class="curtype">帖子</a></li>
EOF;
?><?php } ?>
                   <?php if(helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)) { ?><?php
$slist[blog] = <<<EOF
<li><a href="javascript:;" rel="blog">日志</a></li>
EOF;
?><?php } ?>
                   <?php if(helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)) { ?><?php
$slist[album] = <<<EOF
<li><a href="javascript:;" rel="album">相册</a></li>
EOF;
?><?php } ?>
                   <?php if($_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)) { ?><?php
$slist[group] = <<<EOF
<li><a href="javascript:;" rel="group">{$_G['setting']['navs']['3']['navname']}</a></li>
EOF;
?><?php } ?>
                   <?php
$slist[user] = <<<EOF
<li><a href="javascript:;" rel="user">用户</a></li>
EOF;
?>
                   <?php } ?>
                   <?php if($_G['setting']['search'] && $slist) { ?>
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery(".btn-slide").click(function(){
jQuery("#panel").slideToggle("slow");
jQuery(this).toggleClass("active"); return false;
}); 
});
</script>
                 <div class="so_bg" style="position:relative">
                     <div class="sobg"></div>
                     <div id="scbar" style="background:transparent;border:0 !Important;border: 0 !important;padding:0;height:auto" class="<?php if($_G['setting']['srchhotkeywords'] && count($_G['setting']['srchhotkeywords']) > 5) { ?>scbar_narrow <?php } ?>cl">
   <table cellpadding="0" cellspacing="0" class="fwin"><tbody><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l"></td><td class="m_c" style="border:0">
                   <div style="margin-top:9px;padding:0 10px;padding-bottom:9px">
   <form id="scbar_form" method="<?php if($_G['fid'] && !empty($searchparams['url'])) { ?>get<?php } else { ?>post<?php } ?>" autocomplete="off" onsubmit="searchFocus($('scbar_txt'))" action="<?php if($_G['fid'] && !empty($searchparams['url'])) { ?><?php echo $searchparams['url'];?><?php } else { ?>search.php?searchsubmit=yes<?php } ?>" target="_blank">
                   <input type="hidden" name="mod" id="scbar_mod" value="search" />
                   <input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
                   <input type="hidden" name="srchtype" value="title" />
                   <input type="hidden" name="srhfid" value="<?php echo $_G['fid'];?>" />
                   <input type="hidden" name="srhlocality" value="<?php echo $_G['basescript'];?>::<?php echo CURMODULE;?>" />
                   <?php if(!empty($searchparams['params'])) { ?>
                   <?php if(is_array($searchparams['params'])) foreach($searchparams['params'] as $key => $value) { ?>                   <?php $srchotquery .= '&' . $key . '=' . rawurlencode($value);?>                   <input type="hidden" name="<?php echo $key;?>" value="<?php echo $value;?>" />
                   <?php } ?>
                   <input type="hidden" name="source" value="discuz" />
                   <input type="hidden" name="fId" id="srchFId" value="<?php echo $_G['fid'];?>" />
                   <input type="hidden" name="q" id="cloudsearchquery" value="" />
                               <div style="display: none; position: absolute; top:37px; left:44px;" id="sg">
                                   <div id="st_box" cellpadding="2" cellspacing="0"></div>
                               </div>
                   <?php } ?>
                   <table cellspacing="0" cellpadding="0">
                   <tr>
                   <td class="scbar_txt_td">
   <input type="text" name="srchtxt" id="scbar_txt" style="line-height: 20px;" value="请输入搜索内容" autocomplete="off" x-webkit-speech speech /></td>
                   <td class="scbar_type_td"><a href="javascript:;" id="scbar_type" class="xg1" onclick="showMenu(this.id)" hidefocus="true">搜索</a></td>
   <td class="scbar_btn_td">
   <button style="height: 44px !important;width: 83px;" type="submit" name="searchsubmit" id="scbar_btn" sc="1" class="pn pnc" value="true"><strong class="xi2" STYLE="text-indent: -99999px;width: 107px;opacity: 0;filter: alpha(opacity=0);cursor: pointer;">搜索</strong></button></td>
                   </tr>
                   </table>
   <ul id="scbar_type_menu" class="p_pop" style="display: none;"><?php echo implode('', $slist);; ?></ul>
                   </form>
                        <script type="text/javascript"> jQuery(document).ready(function() { var tags_a = jQuery("#scbar_hot a"); tags_a.each(function(){ var x = 9; var y = 0; var rand = parseInt(Math.random() * (x - y + 1) + y); jQuery(this).addClass("tags"+rand); }); }) </script> 
   <div style="display: none;" id="panel"> 
<div id="scbar_hot" style="margin-top:10px">
<?php if($_G['setting']['srchhotkeywords']) { ?>
<a class="xw1">热搜: </a><?php if(is_array($_G['setting']['srchhotkeywords'])) foreach($_G['setting']['srchhotkeywords'] as $val) { if($val=trim($val)) { $valenc=rawurlencode($val);?><?php
$__FORMHASH = FORMHASH;$srchhotkeywords[] = <<<EOF


EOF;
 if(!empty($searchparams['url'])) { 
$srchhotkeywords[] .= <<<EOF

<a href="{$searchparams['url']}?q={$valenc}&source=hotsearch{$srchotquery}" target="_blank" class="xi2" sc="1">{$val}</a>

EOF;
 } else { 
$srchhotkeywords[] .= <<<EOF

<a href="search.php?mod=forum&amp;srchtxt={$valenc}&amp;formhash={$__FORMHASH}&amp;searchsubmit=true&amp;source=hotsearch" target="_blank" class="xi2" sc="1">{$val}</a>

EOF;
 } 
$srchhotkeywords[] .= <<<EOF


EOF;
?>
<?php } } echo implode('', $srchhotkeywords);; } ?>
        </div>
                       </div>
   </div>
                   </td> 
   <td class="m_r"></td>
   </tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></tbody> </table>
                   <div class="slide"><a href="javascript:;" class="btn-slide active"></a></div>	  	   
   </div>
   </div>
                   <script type="text/javascript">initSearchmenu('scbar', '<?php echo $searchparams['url'];?>');</script>
                   <?php } ?>  
</div>
             <div id="diy-tg_menu" style="display: none;">
           <ul>
         <li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();" class="xi2">简洁模式</a></li>
         <li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();" class="xi2">高级模式</a></li>
           </ul>
             </div>				<ul id="myhome_menu" class="p_pop" style="display: none;margin-left: 71px;top: 31px !important;width: 800px;height:0px;background:transparent;border: 0;box-shadow: transparent 0 0 0;">
<div class="membercard">
<div style="margin:3px;background:transparent">
<div class="um_hear" style="width:230px">
<div class="j_um">
<div class="avt"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" id="background_avt"><?php echo avatar($_G[uid],small);?></a></div>
<p><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" title="访问我的空间" id="username"><?php echo $_G['member']['username'];?></a></p>
    <p><a href="home.php?mod=spacecp&amp;ac=usergroup" id="usergroup">用户组: <?php echo $_G['group']['grouptitle'];?><?php if($_G['member']['freeze']) { ?><span> (已冻结)</span><?php } ?></a></p>
<p class="um_pm" style="padding-left:70px;padding-right:14px">
<a href="home.php?mod=space&amp;do=pm" id="pm_ntc" title="消息">消息</a>
<?php if($_G['member']['newpm']) { ?><em style="margin-right:3px">N</em><?php } ?>
<a href="home.php?mod=space&amp;do=notice" id="myprompt" title="提醒">提醒</a><?php if($_G['member']['newprompt']) { ?><em style="margin-right:3px"><?php echo $_G['member']['newprompt'];?></em><?php } ?>
<a href="home.php?mod=follow&amp;do=follower" id="notice_follower" title="新听众">新听众</a><?php if($_G['member']['newprompt_num']['follower']) { ?><em style="margin-right:3px"><?php echo $_G['member']['newprompt_num']['follower'];?></em><?php } ?>
<a href="home.php?mod=follow" id="notice_follow" title="我关注的">我关注的</a><?php if($_G['member']['newprompt'] && $_G['member']['newprompt_num']['follow']) { ?><em style="margin-right:3px"><?php echo $_G['member']['newprompt_num']['follow'];?></em><?php } if($_G['member']['newprompt']) { if(is_array($_G['member']['category_num'])) foreach($_G['member']['category_num'] as $key => $val) { ?><a href="home.php?mod=space&amp;do=notice&amp;view=<?php echo $key;?>" id="notice_<?php echo $key;?>" title="<?php echo lang('template', 'notice_'.$key); ?>"></a><em><?php echo $val;?></em>
<?php } } ?>
<div style="clear:both"></div>
</p>
<p id="plug_i"><?php if($_G['uid']) { ?><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?><?php } elseif(!empty($_G['cookie']['loginuser'])) { } elseif(!$_G['connectguest']) { } else { } ?><?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?><?php $upgradecredit = $_G['uid'] && $_G['group']['grouptype'] == 'member' && $_G['group']['groupcreditslower'] != 999999999 ? $_G['group']['groupcreditslower'] - $_G['member']['credits'] : false;?></p>						
        </div>
<div class="user_hear_bottom"></div>
</div>
<div class="umdivtb">
<div class="umrights" style="margin:0;padding:0;overflow: hidden;padding-top: 7px;margin-bottom:-5px;width:228px">
<ul>
                             <?php if($_G['uid']) { ?>
         <?php } elseif(!empty($_G['cookie']['loginuser'])) { ?>
         <?php } elseif(!$_G['connectguest']) { ?>
         <?php } else { ?>
                             <?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?>
         <?php } if(is_array($_G['setting']['mynavs'])) foreach($_G['setting']['mynavs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { $nav[code] = str_replace('style="', '_style="', $nav[code]);?><?php echo $nav['code'];?>
<?php } } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra3'])) echo $_G['setting']['pluginhooks']['global_usernav_extra3'];?>
<a href="home.php?mod=spacecp">设置</a>
<?php if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
<a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a>
<?php } if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
<a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a>
<?php } if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
<a href="admin.php" target="_blank">管理中心</a>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra4'])) echo $_G['setting']['pluginhooks']['global_usernav_extra4'];?>
<?php if($_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])) { ?><a href="home.php?mod=task&amp;item=doing" class="new">进行中的任务</a>
<?php } ?>
</ul>
</div>
<div style="width:100%"><a id="logout_a" href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a></div>
<div style="width:100%;height:10px"></div>
</div>		
</div>
</div>
<?php if(!empty($_G['setting']['pluginhooks']['global_myitem_extra'])) echo $_G['setting']['pluginhooks']['global_myitem_extra'];?>
</ul><div id="qmenu_menu" class="p_pop <?php if(!$_G['uid']) { ?>blk<?php } ?>" style="display: none;">
<?php if(!empty($_G['setting']['pluginhooks']['global_qmenu_top'])) echo $_G['setting']['pluginhooks']['global_qmenu_top'];?>
<?php if($_G['uid']) { ?>
<ul class="cl nav"><?php if(is_array($_G['setting']['mynavs'])) foreach($_G['setting']['mynavs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>
<li><?php echo $nav['code'];?></li>
<?php } } ?>
</ul>
<?php } elseif($_G['connectguest']) { ?>
<div class="ptm pbw hm">
请先<br /><a class="xi2" href="member.php?mod=connect"><strong>完善帐号信息</strong></a> 或 <a href="member.php?mod=connect&amp;ac=bind" class="xi2 xw1"><strong>绑定已有帐号</strong></a><br />后使用快捷导航
</div>
<?php } else { ?>
<div class="ptm pbw hm">
请 <a href="javascript:;" class="xi2" onclick="lsSubmit()"><strong>登录</strong></a> 后使用快捷导航<br />没有帐号？<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" class="xi2 xw1"><?php echo $_G['setting']['reglinkname'];?></a>
</div>
<?php } if($_G['setting']['showfjump']) { ?><div id="fjump_menu" class="btda"></div><?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_qmenu_bottom'])) echo $_G['setting']['pluginhooks']['global_qmenu_bottom'];?>
</div><?php } ?>
<script src="template/enet_no1/js/jquery.js" type="text/javascript"></script>
<script language="javascript">var t = null;t =setTimeout(time,1000);function time(){clearTimeout(t);dt = new Date();var h=dt.getHours();var m=dt.getMinutes(); var s=dt.getSeconds();document.getElementById("timeShow").innerHTML =  ""+h+":"+m+"";t = setTimeout(time,1000);}</script>   
<script src="template/enet_no1/js/weather.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="template/enet_no1/js/weather_ip.js" type="text/javascript"></script>
<div class="weather"><div class="wtimg" id="T_weather_img"></div><div class="weather-background"></div><div class="weather-info"><span id="timeShow"></span><span id="T_weather"></span><div class="city_all"><span class="city"></span><div class="city_ico"></div></div><span id="T_temperature"></span></div></div><?php echo adshow("headerbanner/wp a_h");?><div id="toptb" class="wp common_toptb">
<?php if(!empty($_G['setting']['pluginhooks']['global_cpnav_top'])) echo $_G['setting']['pluginhooks']['global_cpnav_top'];?>
               <div class="z">
                <div class="zeen common_i"><?php if(is_array($_G['setting']['topnavs']['0'])) foreach($_G['setting']['topnavs']['0'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?><?php echo $nav['code'];?><?php } } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_cpnav_extra1'])) echo $_G['setting']['pluginhooks']['global_cpnav_extra1'];?>
</div>
                </div>
<div class="y common_i">
<a id="switchblind" href="javascript:;" onclick="toggleBlind(this)" title="开启辅助访问" class="switchblind">开启辅助访问</a>
<?php if(!empty($_G['setting']['pluginhooks']['global_cpnav_extra2'])) echo $_G['setting']['pluginhooks']['global_cpnav_extra2'];?><?php if(is_array($_G['setting']['topnavs']['1'])) foreach($_G['setting']['topnavs']['1'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?><?php echo $nav['code'];?><?php } } if(empty($_G['disabledwidthauto']) && $_G['setting']['switchwidthauto']) { ?>
<a href="javascript:;" id="switchwidth" onclick="widthauto(this)" title="<?php if(widthauto()) { ?>切换到窄版<?php } else { ?>切换到宽版<?php } ?>"><?php if(widthauto()) { ?>切换到窄版<?php } else { ?>切换到宽版<?php } ?></a>
<?php } if(check_diy_perm($topic)) { ?>
<?php echo $diynav;?>
<?php } ?>
</div>
<div style="clear:both"></div>
</div>
<div class="hearbg"></div>
<div id="hear-box">
<div class="wp"><?php $mnid = getcurrentnav();?><h2><?php if(!isset($_G['setting']['navlogos'][$mnid])) { ?><a href="<?php if($_G['setting']['domain']['app']['default']) { ?>http://<?php echo $_G['setting']['domain']['app']['default'];?>/<?php } else { ?>./<?php } ?>" title="<?php echo $_G['setting']['bbname'];?>"><img src="template/enet_no1/images/logo.png" onload="fixPNG(this)"></a><?php } else { ?><?php echo $_G['setting']['navlogos'][$mnid];?><?php } ?></h2>
<?php if($_G['uid']) { ?>
<div id="um">
<div class="y"><a href="home.php?mod=space&amp;do=pm"  id="pm_ntc" <?php if($_G['member']['newpm']) { ?>style="position: absolute;display: initial !Important;margin: -2px 0 0 34px;width: 16px;float:right;z-index:200;height: 14px;background: url(template/enet_no1/images/new_pm_2.png) no-repeat 100% 0;border:0px !important"<?php } ?> style="display:none"></a></div>
                            <div class="y"><a href="home.php?mod=space&amp;do=notice" id="pm_ntc" <?php if($_G['member']['newprompt']) { ?>style="position: absolute;display: initial !Important;margin: -2px 0 0 34px;float:right;z-index:200;width: 16px;height: 14px;background: url(template/enet_no1/images/new_pm_2.png) no-repeat 100% 0;border:0px !important"<?php } ?> style="display:none"></a></div>
<div class="avt y"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>"><?php echo avatar($_G[uid],small);?></a></div>
<p class="top30">
                    <a style="background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%" target="_blank" title="访问我的空间" id="myhome" class="showmenu" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'myhome'})"><?php echo $_G['member']['username'];?></a>
</p>
</div>
<?php } elseif(!empty($_G['cookie']['loginuser'])) { } elseif(!$_G['connectguest']) { include template('member/login_simple'); } else { ?>
<div id="um">
<div class="avt y"><a><?php echo avatar(0,small);?></a></div>
<p class="top30">
<a id="myhome" class="showmenu" style="background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'myhome'})"><?php echo $_G['member']['username'];?></a>
</p>
</div>
<?php } if(!empty($_G['setting']['plugins']['jsmenu'])) { ?>
<ul class="p_pop h_pop" id="plugin_menu" style="display: none"><?php if(is_array($_G['setting']['plugins']['jsmenu'])) foreach($_G['setting']['plugins']['jsmenu'] as $module) { ?> <?php if(!$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])) { ?>
 <li><?php echo $module['url'];?></li>
 <?php } } ?>
</ul>
<?php } ?>
<?php echo $_G['setting']['menunavs'];?>
<div style="clear:both"></div>
</div>
</div>
<div id="nv" class="allnv">
<div class="nvbg">
 <div class="nvbgl"></div>
   <div id="nvtext" class="wp nvtext">
<a href="javascript:;" id="qmenu" onmouseover="delayShow(this, function () {showMenu({'ctrlid':'qmenu','pos':'34!','ctrlclass':'a','duration':2});showForummenu(<?php echo $_G['fid'];?>);})">快捷导航</a>
<span href="javascript:;" id="so" onclick="$('so_box').style.display='block'" style="cursor: pointer">搜索</span>
<ul>
  <?php if(is_array($_G['setting']['navs'])) foreach($_G['setting']['navs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?><li <?php if($mnid == $nav['navid']) { ?>class="a" <?php } ?><?php echo $nav['nav'];?>></li><?php } ?>
  <?php } ?>
</ul>
  <?php if(!empty($_G['setting']['pluginhooks']['global_nav_extra'])) echo $_G['setting']['pluginhooks']['global_nav_extra'];?>
   </div>
</div>
</div>
  <div id="mu" class="cl">
<?php if($_G['setting']['subnavs']) { if(is_array($_G['setting']['subnavs'])) foreach($_G['setting']['subnavs'] as $navid => $subnav) { if($_G['setting']['navsubhover'] || $mnid == $navid) { ?>
<ul class="cl <?php if($mnid == $navid) { ?>current<?php } ?>" id="snav_<?php echo $navid;?>" style="display:<?php if($mnid != $navid) { ?>none<?php } ?>">
<div class="wp">
<?php echo $subnav;?>
</div>
</ul>
<?php } } ?>
    <?php } ?>
  </div><?php echo adshow("subnavbanner/a_mu");?><?php if(!empty($_G['setting']['pluginhooks']['global_header'])) echo $_G['setting']['pluginhooks']['global_header'];?>
<?php } ?>
<div id="wp" class="wp"><link rel="stylesheet" type="text/css" href="source/plugin/mobile/template/style.css" />
<?php if($_G['adminid'] == 1) { ?>
<script type="text/javascript">
function hiddentips() {
setcookie("mobiletips", "1");
display('admintips');
}
</script>
<?php } ?>
<div id="ct" class="wp cl ptw pbw">
<?php if($_G['cache']['mobileoem_data']['iframeUrl']) { ?>
<iframe frameborder="0" width="100%" scrolling="no" height="810" src="<?php echo $_G['cache']['mobileoem_data']['iframeUrl'];?>"></iframe>
<?php } else { if($_G['adminid'] == 1 && !$_G['cookie']['mobiletips']) { ?>
  <div class="wrap">
<div id="admintips" class="tips"><span class="y"><a href="javascript:hiddentips();" class="close">关闭</a></span>尊敬的站长，您可以在Discuz!程序根目录上传"mobile.png"图片(尺寸178x178)，以确保论坛客户端能成功获得到论坛的logo</div>
    <?php } ?>
<div class="content">
<ul class="platform">
<li><a href="http://www.discuz.net/mobile.php?platform=ios"><img src="./source/plugin/mobile/template/image/iphone.jpg" alt="iphone-适用于苹果手机"/></a></li>
<li><a href="http://www.discuz.net/mobile.php?platform=android"><img src="./source/plugin/mobile/template/image/android.jpg" alt="Android-适用于装有安卓系统的三星/HTC/小米等手机"/></a></li>
<li><a href="http://www.discuz.net/mobile.php?platform=windowsphone"><img src="./source/plugin/mobile/template/image/wp7.jpg" alt="WinodwsPhone-适用于装有微软WindowsPhone7 系统的手机"/></a></li>
</ul>
<div class="inner cl">
<div class="intro z">
<h2><img src="./source/plugin/mobile/template/image/title_intro.jpg" alt="掌上论坛优势"></h2>
<dl>
<dt>随时随地，快速访问</dt>
<dd>只要手机在手，您都可以快速、方便地看贴发帖，与论坛好友收发短消息。</dd>
<dt>极致优化，畅快"悦"读</dt>
<dd>独有的论坛界面和触屏设计，手机论坛也变得赏心悦目，操作自如。</dd>
<dt>即拍即发，分享生活</dt>
<dd>不管是风景图画，还是新闻现场，拍照发帖一气呵成，让您在论坛出尽风头。</dd>
</dl>
</div>
<div class="code y">
<dl>
<dt class="shoot">下载客户端后，拍摄二维码快速访问本站:</dt>
<dd class="code_img"><img src="data/cache/mobile_siteqrcode.png" alt="二维码"/></dd>
<dt>或者通过以下地址访问:</dt>
<dd class="url"><a href="<?php echo $_G['siteurl'];?>" target="_blank"><?php echo $_G['siteurl'];?></a></dd>
</dl>
</div>
</div>
</div>
<?php } ?>
</div>
</div>	</div>
<?php if(empty($topic) || ($topic['usefooter'])) { $focusid = getfocus_rand($_G[basescript]);?><?php if($focusid !== null) { $focus = $_G['cache']['focus']['data'][$focusid];?><?php $focusnum = count($_G['setting']['focus'][$_G[basescript]]);?><div class="focus" id="sitefocus">
<div class="bm">
<div class="bm_h cl">
<a href="javascript:;" onclick="setcookie('nofocus_<?php echo $_G['basescript'];?>', 1, <?php echo $_G['cache']['focus']['cookie'];?>*3600);$('sitefocus').style.display='none'" class="y" title="关闭">关闭</a>
<h2>
<?php if($_G['cache']['focus']['title']) { ?><?php echo $_G['cache']['focus']['title'];?><?php } else { ?>站长推荐<?php } ?>
<span id="focus_ctrl" class="fctrl"><img src="<?php echo IMGDIR;?>/pic_nv_prev.gif" alt="上一条" title="上一条" id="focusprev" class="cur1" onclick="showfocus('prev');" /> <em><span id="focuscur"></span>/<?php echo $focusnum;?></em> <img src="<?php echo IMGDIR;?>/pic_nv_next.gif" alt="下一条" title="下一条" id="focusnext" class="cur1" onclick="showfocus('next')" /></span>
</h2>
</div>
<div class="bm_c" id="focus_con">
</div>
</div>
</div><?php $focusi = 0;?><?php if(is_array($_G['setting']['focus'][$_G['basescript']])) foreach($_G['setting']['focus'][$_G['basescript']] as $id) { ?><div class="bm_c" style="display: none" id="focus_<?php echo $focusi;?>">
<dl class="xld cl bbda">
<dt><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" class="xi2" target="_blank"><?php echo $_G['cache']['focus']['data'][$id]['subject'];?></a></dt>
<?php if($_G['cache']['focus']['data'][$id]['image']) { ?>
<dd class="m"><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" target="_blank"><img src="<?php echo $_G['cache']['focus']['data'][$id]['image'];?>" alt="<?php echo $_G['cache']['focus']['data'][$id]['subject'];?>" /></a></dd>
<?php } ?>
<dd><?php echo $_G['cache']['focus']['data'][$id]['summary'];?></dd>
</dl>
<p class="ptn cl"><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" class="xi2 y" target="_blank">查看 &raquo;</a></p>
</div><?php $focusi ++;?><?php } ?>
<script type="text/javascript">
var focusnum = <?php echo $focusnum;?>;
if(focusnum < 2) {
$('focus_ctrl').style.display = 'none';
}
if(!$('focuscur').innerHTML) {
var randomnum = parseInt(Math.round(Math.random() * focusnum));
$('focuscur').innerHTML = Math.max(1, randomnum);
}
showfocus();
var focusautoshow = window.setInterval('showfocus(\'next\', 1);', 5000);
</script>
<?php } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1) { ?>
<div class="focus patch" id="patch_notice"></div>
<?php } ?><?php echo adshow("footerbanner/wp a_f/1");?><?php echo adshow("footerbanner/wp a_f/2");?><?php echo adshow("footerbanner/wp a_f/3");?><?php echo adshow("float/a_fl/1");?><?php echo adshow("float/a_fr/2");?><?php echo adshow("couplebanner/a_fl a_cb/1");?><?php echo adshow("couplebanner/a_fr a_cb/2");?><?php echo adshow("cornerbanner/a_cn");?><?php if(!empty($_G['setting']['pluginhooks']['global_footer'])) echo $_G['setting']['pluginhooks']['global_footer'];?>
<div id="ft" class="cl wp">
</div>
<?php } ?>
<div id="footer">
<div class="ltwmes"></div>
<div id="footertext">
<div class="bbsname">
<?php if($_G['setting']['site_qq']) { ?><a href="http://wpa.qq.com/msgrd?V=3&amp;Uin=<?php echo $_G['setting']['site_qq'];?>&amp;Site=<?php echo $_G['setting']['bbname'];?>&amp;Menu=yes&amp;from=discuz" target="_blank" title="QQ"><img src="<?php echo IMGDIR;?>/site_qq.jpg" alt="QQ" /></a><span class="pipe">|</span><?php } if(is_array($_G['setting']['footernavs'])) foreach($_G['setting']['footernavs'] as $nav) { if($nav['available'] && ($nav['type'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1)) ||
!$nav['type'] && ($nav['id'] == 'stat' && $_G['group']['allowstatdata'] || $nav['id'] == 'report' && $_G['uid'] || $nav['id'] == 'archiver' || $nav['id'] == 'mobile' || $nav['id'] == 'darkroom'))) { ?><?php echo $nav['code'];?><span class="pipe">|</span><?php } } ?>
<strong><a href="<?php echo $_G['setting']['siteurl'];?>" target="_blank"><?php echo $_G['setting']['sitename'];?></a></strong>
<?php if($_G['setting']['icp']) { ?>( <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo $_G['setting']['icp'];?></a> )<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_footerlink'])) echo $_G['setting']['pluginhooks']['global_footerlink'];?>
<?php if($_G['setting']['statcode']) { ?><?php echo $_G['setting']['statcode'];?><?php } ?>
</div>
<div class="xs0" id="time">
GMT<?php echo $_G['timenow']['offset'];?>, <?php echo $_G['timenow']['time'];?>
<span id="debuginfo">
<?php if(debuginfo()) { ?>, Processed in <?php echo $_G['debuginfo']['time'];?> second(s), <?php echo $_G['debuginfo']['queries'];?> queries
<?php if($_G['gzipcompress']) { ?>, Gzip On<?php } if(C::memory()->type) { ?>, <?php echo ucwords(C::memory()->type); ?> On<?php } ?>.
<?php } ?>
</span>
</div>
   <div class="discuzby">Powered by <strong><a href="http://www.adminbuy.cn" target="_blank">Discuz模板</a></strong> <em><?php echo $_G['setting']['version'];?></em><?php if(!empty($_G['setting']['boardlicensed'])) { ?> <a href="http://license.comsenz.com/?pid=1&amp;host=<?php echo $_SERVER['HTTP_HOST'];?>" target="_blank">Licensed</a><?php } ?> Style by <strong><a href="http://eduenet.com" target="_blank">ENET</a> </strong><em> v1.2</em></p><?php updatesession();?><?php if($_G['uid'] && $_G['group']['allowinvisible']) { ?>
<script type="text/javascript">
var invisiblestatus = '<?php if($_G['session']['invisible']) { ?>隐身<?php } else { ?>在线<?php } ?>';
var loginstatusobj = $('loginstatusid');
if(loginstatusobj != undefined && loginstatusobj != null) loginstatusobj.innerHTML = invisiblestatus;
</script>
<?php } ?>
       </div>
  <div class="xs0" id="banquan">&copy; 2001-2013 <a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a></p></div>
    </div>
</div>

<?php if(!$_G['setting']['bbclosed'] && !$_G['member']['freeze'] && !$_G['member']['groupexpiry']) { if($_G['uid'] && !isset($_G['cookie']['checkpm'])) { ?>
<script src="home.php?mod=spacecp&ac=pm&op=checknewpm&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } if($_G['uid'] && helper_access::check_module('follow') && !isset($_G['cookie']['checkfollow'])) { ?>
<script src="home.php?mod=spacecp&ac=follow&op=checkfeed&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } if(!isset($_G['cookie']['sendmail'])) { ?>
<script src="home.php?mod=misc&ac=sendmail&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && !isset($_G['cookie']['checkpatch'])) { ?>
<script src="misc.php?mod=patch&action=checkpatch&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } } if($_GET['diy'] == 'yes') { if(check_diy_perm($topic) && (empty($do) || $do != 'index')) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>common_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="<?php echo $_G['setting']['jspath'];?>portal_diy<?php if(!check_diy_perm($topic, 'layout')) { ?>_data<?php } ?>.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($space['self'] && CURMODULE == 'space' && $do == 'index') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>common_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="<?php echo $_G['setting']['jspath'];?>space_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1) { ?>
<script type="text/javascript">patchNotice();</script>
<?php } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && empty($_G['cookie']['pluginnotice'])) { ?>
<div class="focus plugin" id="plugin_notice"></div>
<script type="text/javascript">pluginNotice();</script>
<?php } if(!$_G['setting']['bbclosed'] && !$_G['member']['freeze'] && !$_G['member']['groupexpiry'] && $_G['setting']['disableipnotice'] != 1 && $_G['uid'] && !empty($_G['cookie']['lip'])) { ?>
<div class="focus plugin" id="ip_notice"></div>
<script type="text/javascript">ipNotice();</script>
<?php } if($_G['member']['newprompt'] && (empty($_G['cookie']['promptstate_'.$_G['uid']]) || $_G['cookie']['promptstate_'.$_G['uid']] != $_G['member']['newprompt']) && $_GET['do'] != 'notice') { ?>
<script type="text/javascript">noticeTitle();</script>
<?php } if(($_G['member']['newpm'] || $_G['member']['newprompt']) && empty($_G['cookie']['ignore_notice'])) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>html5notification.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script type="text/javascript">
var h5n = new Html5notification();
if(h5n.issupport()) {
<?php if($_G['member']['newpm'] && $_GET['do'] != 'pm') { ?>
h5n.shownotification('pm', '<?php echo $_G['siteurl'];?>home.php?mod=space&do=pm', '<?php echo avatar($_G[uid],small,true);?>', '新的短消息', '有新的短消息，快去看看吧');
<?php } if($_G['member']['newprompt'] && $_GET['do'] != 'notice') { if(is_array($_G['member']['category_num'])) foreach($_G['member']['category_num'] as $key => $val) { $noticetitle = lang('template', 'notice_'.$key);?>h5n.shownotification('notice_<?php echo $key;?>', '<?php echo $_G['siteurl'];?>home.php?mod=space&do=notice&view=<?php echo $key;?>', '<?php echo avatar($_G[uid],small,true);?>', '<?php echo $noticetitle;?> (<?php echo $val;?>)', '有新的提醒，快去看看吧');
<?php } } ?>
}
</script>
<?php } userappprompt();?><?php if($_G['basescript'] != 'userapp') { ?>
<div id="scrolltop">
<?php if($_G['fid'] && $_G['mod'] == 'viewthread') { ?>
<span><a href="forum.php?mod=post&amp;action=reply&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?><?php if($_GET['from']) { ?>&amp;from=<?php echo $_GET['from'];?><?php } ?>" onclick="showWindow('reply', this.href)" class="replyfast" title="快速回复"><b>快速回复</b></a></span>
<?php } ?>
<span hidefocus="true"><a title="返回顶部" onclick="window.scrollTo('0','0')" class="scrolltopa" ><b>返回顶部</b></a></span>
<?php if($_G['fid']) { ?>
<span>
<?php if($_G['mod'] == 'viewthread') { ?>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>" hidefocus="true" class="returnlist" title="返回列表"><b>返回列表</b></a>
<?php } else { ?>
<a href="forum.php" hidefocus="true" class="returnboard" title="返回版块"><b>返回版块</b></a>
<?php } ?>
</span>
<?php } ?>
</div>
<script type="text/javascript">_attachEvent(window, 'scroll', function () { showTopLink(); });checkBlind();</script>
<?php } if(isset($_G['makehtml'])) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>html2dynamic.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script type="text/javascript">
var html_lostmodify = <?php echo TIMESTAMP;?>;
htmlGetUserStatus();
<?php if(isset($_G['htmlcheckupdate'])) { ?>
htmlCheckUpdate();
<?php } ?>
</script>
<?php } output();?></body>
</html>
