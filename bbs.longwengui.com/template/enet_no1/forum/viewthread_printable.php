<?php exit;?>
<html>
<head>
<title>$_G[forum_thread][subject] - $_G['setting']['bbname'] - Powered by Discuz!</title>
<meta http-equiv="Content-Type" content="text/html; charset={CHARSET}" />
<style type="text/css">
body 	   {margin: 10px 80px;}
body,table {font-size: {FONTSIZE}; font-family: {FONT};}
h1 { font-size: 24px; margin-bottom: 20px; color: #999; }
</style>
<script type="text/javascript" src="{$_G['setting']['jspath']}common.js?{VERHASH}"></script>
<script type="text/javascript" src="{$_G['setting']['jspath']}forum_viewthread.js?{VERHASH}"></script>
<script type="text/javascript">var STYLEID = '{STYLEID}', STATICURL = '{STATICURL}', IMGDIR = '{IMGDIR}', VERHASH = '{VERHASH}', charset = '{CHARSET}', discuz_uid = '$_G[uid]', cookiepre = '{$_G[config][cookie][cookiepre]}', cookiedomain = '{$_G[config][cookie][cookiedomain]}', cookiepath = '{$_G[config][cookie][cookiepath]}', showusercard = '{$_G[setting][showusercard]}', attackevasive = '{$_G[config][security][attackevasive]}', disallowfloat = '{$_G[setting][disallowfloat]}', creditnotice = '<!--{if $_G['setting']['creditnotice']}-->$_G['setting']['creditnames']<!--{/if}-->', defaultstyle = '$_G[style][defaultextstyle]', REPORTURL = '$_G[currenturl_encode]', SITEURL = '$_G[siteurl]', JSPATH = '$_G[setting][jspath]';</script>
</head>

<body>
<h1>$_G['setting']['bbname']</h1>
<b>{lang subject}: </b>$_G[forum_thread][subject] <b><a href="###" onclick="this.style.visibility='hidden';window.print();this.style.visibility='visible'">[{lang thread_print}]</a></b></span><br />
<script type="text/javascript">var zoomstatus = 0;var aimgcount = new Array();</script>
<!--{loop $postlist $post}-->
	<hr noshade size="2" width="100%" color="#808080">
	<b>{lang author}: </b><!--{if $post['author'] && !$post['anonymous']}-->$post[author]<!--{else}-->{lang anonymous}<!--{/if}-->&nbsp; &nbsp; <b>{lang time}: </b>$post[dateline]
	<br />
	<!--{if $_G['adminid'] != 1 && $_G['setting']['bannedmessages'] && (($post['authorid'] && !$userinfo[$post[authorid]]['username']) || ($userinfo[$post[authorid]]['groupid'] == 4 || $userinfo[$post[authorid]]['groupid'] == 5))}-->
		{lang message_banned}
	<!--{elseif $_G['adminid'] != 1 && $post['status'] & 1}-->
		{lang message_single_banned}
	<!--{elseif $post['first'] && $_G['forum_threadpay']}-->
		{lang pay_comment}
	<!--{else}-->
		<!--{if $post['subject']}--><b>{lang subject}: </b>$post[subject]<br /><!--{/if}-->
		$post[message]
		<!--{if $post['imagelist']}-->
			<!--{echo showattach($post, 1)}-->
		<!--{/if}-->
		<!--{if $post['attachlist']}-->
			<!--{echo showattach($post)}-->
		<!--{/if}-->
	<!--{/if}-->
	<!--{if !empty($aimgs[$post[pid]])}-->
	<script type="text/javascript" reload="1">
		aimgcount[{$post[pid]}] = [<!--{echo dimplode($aimgs[$post[pid]]);}-->];
		attachimggroup($post['pid']);
		<!--{if empty($_G['setting']['lazyload'])}-->
			<!--{if !$post['imagelistthumb']}-->
				attachimgshow($post[pid]);
			<!--{else}-->
				attachimgshow($post[pid], 1);
			<!--{/if}-->
		<!--{/if}-->
		<!--{if $post['imagelistthumb']}-->
			attachimglstshow($post['pid'], <!--{echo intval($_G['setting']['lazyload']), 0, 0}-->);
		<!--{/if}-->
		<!--{if !IS_ROBOT && !empty($_G[setting][lazyload])}-->
			new lazyload();
		<!--{/if}-->
	</script>
	<!--{/if}-->
<!--{/loop}-->

<br /><br /><br /><br /><hr noshade size="2" width="100%" color="{BORDERCOLOR}">
<table cellspacing="0" cellpadding="0" border="0" width="95%" align="center" style="font-size: {SMFONTSIZE}; font-family: {SMFONT}">
<tr><td>{lang welcometo} $_G['setting']['bbname'] ($_G[siteurl])</td>
<td align="right">
Powered by Discuz! $_G['setting']['version']</td></tr></table>

</body>
</html>