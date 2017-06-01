<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_footer_mobile'])) echo $_G['setting']['pluginhooks']['global_footer_mobile'];?><?php $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''?><?php if(strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';?><?php } elseif(strpos($useragent, 'android') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';?><?php } elseif(strpos($useragent, 'windows phone') !== false) { $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';?><?php } ?>


<script>
/*120ask£¨“∆∂Ø∂À£¨20:3 ¥¥Ω®”⁄ 2014-10-13*/
var cpro_id = "u1757943";
</script>
<style>
.WX_add{background-color:#F9F9F9;padding-bottom:13px;}
.WX_add .title{font-size:15px;line-height:15px;padding:18px 0 10px 19px;}
.WX_add .title b{color:#ff4e00;}
.WX_add_step{background-color:#fff;margin:0 15px;border:1px solid #DDDDDD;padding:14px 0px 14px 16px;}
.WX_add_step span{display:block;float:left;}
.WX_add_step ul{padding-left:135px;font-size:13px;padding-top:5px;}
.WX_add_step ul li{display:block;line-height:23px;}
.WX_add_step ul li i{display:block;float:left;}
.WX_add_step ul li var{display:block;padding-left:20px;}
i,var{font-style: normal;}

.m16_bottom{height:38px;background-color:#ddf7fd;padding:0 12px;border-top:1px solid #E5E5E5;border-bottom:1px solid #E5E5E5;}
.m16_bottom span{display:block;float:left;text-align:center;padding-top:12px;width:25%}
.m16_bottom span a{display:block;height:14px;position:relative;width:100%;border-right:1px solid #D5D5D5;line-height:14px;font-size:11px;color:#4a4a4a;box-sizing:border-box;padding-left:10px;}
.m16_bottom span a i{display:block;width:10px;height:10px;position:absolute;left:50%;margin-left:-31px;top:1px;background:url('./template/moke8_dztouch/touch/images/m_tubiao2.png') no-repeat 0 0;background-size:10px 10px;-webkit-background-size:10px 10px;}
.m16_bottom .m16_bottoma1 a i{background:url('./template/moke8_dztouch/touch/images/m_tubiao.png') no-repeat 0 0;background-size:10px 10px;-webkit-background-size:10px 10px;}
.m16_bottom span:last-child a{border-right:none;}
.m16_bottom1 p{text-align:left;line-height:20px;color:#666;padding-left:10px;padding-top:11px;font-size:11px;}
.m16_bottom1 p span{display:block;}
</style>
<?php if(!$nofooter) { ?>
<div class="m16_bot">
<div class="m16_bottom">
<span><a href="javascript:;"><i></i>Ëß¶Â±èÁâà</a></span>
<span><a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>"><i></i>ÁîµËÑëÁâà</a></span>

<?php if(!$_G['uid'] && !$_G['connectguest']) { ?>
<span><a href="member.php?mod=logging&amp;action=login"><i></i>ÁôªÂΩï</a></span>
<span><a href="<?php if($_G['setting']['regstatus']) { ?>member.php?mod=<?php echo $_G['setting']['regname'];?><?php } else { ?>javascript:;" style="color:#D7D7D7;<?php } ?>"><i></i>Ê≥®ÂÜå</a></span>
<?php } else { ?>
<span><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=profile&amp;mycenter=1"><i></i><?php echo $_G['member']['username'];?></a></span>
<span><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>"><i></i>ÈÄÄÂá∫</a></span>
<?php } ?>

</div>
</div>
<?php } ?>
<script src="./template/moke8_dztouch/touch/js/top_tog.js?<?php echo VERHASH;?>" type="text/javascript"></script><?php updatesession();?><?php if(defined('IN_MOBILE')) { output();?><?php } else { output_preview();?><?php } ?>
</body>
</html>
