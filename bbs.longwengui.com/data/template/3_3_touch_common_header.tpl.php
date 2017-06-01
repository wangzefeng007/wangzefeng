<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); require DISCUZ_ROOT .'template/moke8_dztouch/lang_'.CHARSET.'.php';?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>">
<meta http-equiv="Cache-control" content="<?php if($_G['setting']['mobile']['mobilecachetime'] > 0) { ?><?php echo $_G['setting']['mobile']['mobilecachetime'];?><?php } else { ?>no-cache<?php } ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />
<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } ?>,<?php echo $_G['setting']['bbname'];?>" />
<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> 手机版 - Powered by Discuz!</title>
<link rel="stylesheet" href="<?php echo STATICURL;?>image/mobile/style.css?<?php echo VERHASH;?>" type="text/css" media="all">
<script src="<?php echo STATICURL;?>js/mobile/jquery-1.8.3.min.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>';</script>
<script src="<?php echo STATICURL;?>js/mobile/common.js?<?php echo VERHASH;?>" type="text/javascript" charset="<?php echo CHARSET;?>"></script>
<link rel="stylesheet" href="./template/moke8_dztouch/touch/css/m_pub.css?<?php echo VERHASH;?>" />
<?php if($_G['mod'] == forumdisplay) { ?>
<link rel="stylesheet" href="./template/moke8_dztouch/touch/css/m_list.css?<?php echo VERHASH;?>" />
<?php } elseif($_G['mod'] == viewthread) { ?>
<link rel="stylesheet" href="./template/moke8_dztouch/touch/css/m_content.css?<?php echo VERHASH;?>" />
<?php } else { ?>
<link rel="stylesheet" href="./template/moke8_dztouch/touch/css/m_index.css?<?php echo VERHASH;?>" />
<?php } ?>
<script src="./template/moke8_dztouch/touch/js/touchslider_min.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="./template/moke8_dztouch/touch/js/fx120_x.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<style>
.online-doctor{padding:13px 15px;border:1px solid #E2E2E2;margin:15px 10px;width:auto;position:relative;}
.online-doctor dt{float:left;padding-right:12px;}
.online-doctor dd h3{font-size:16px;padding-bottom:6px;font-weight: bold;}
.online-doctor dd{overflow:hidden;zoom: 1;}
.online-doctor dd p{color:#666;font-size:1.2rem;}
.lead-bg{display:block;position:absolute;top:29px;right:4px;background:url("./template/moke8_dztouch/touch/images/downlood.png") no-repeat;width:6px;height:12px;background-size:6px 12px;margin-right:3px;}
.ad_but{width: 34px;height:42px;padding-top:4px;display: block;float: left;background: #36a033;position: absolute;right: 7px;
margin-top: -42px;margin-right: 14px;text-align: center;line-height: 18px;color: #fff;}
</style>
</head>
<body>
<header class="s_header">
<nav>
<a href="<?php echo $_G['setting']['siteurl'];?>" class="<?php if($_G['mod'] == forumdisplay || $_G['mod'] == viewthread) { ?>logo<?php } else { ?>index_logo<?php } ?>"><?php echo $_G['setting']['sitename'];?></a>

<?php if($_G['mod'] == forumdisplay ||  $_G['mod'] == viewthread) { ?>
<span class="navline fl"></span>
<p>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['forum']['fid'];?>&amp;"><?php echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];?></a>
</p>
<?php } ?>
<span class="more" id="more"><span class="navline"></span><i class="bg"></i></span>
</nav>
</header>
<div id="toplistwrap" style="height:140px;display:none">
<div class="s_toplist-n" id="toplist" style="height:115px;display:none">
<div class="s_topwrap-n">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['customnav'];?>
</div>
<div class="s_topline-n"></div>
<div class="up-n pr"><i id="slideup"></i></div>
</div>
</div>