<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{if $_GET['mycenter'] && !$_G['uid']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
<!--{/if}-->
<!--{template common/header}-->
<!--{if !$_GET['mycenter']}-->

<!-- header start -->
<header class="header">
    <div class="nav">
		<a href="javascript:;" onclick="history.go(-1);" class="z"><img src="{STATICURL}image/mobile/images/icon_back.png" /></a>
		<span><!--{if $_G['uid'] == $space['uid']}-->{lang myprofile}<!--{else}-->$space[username]{lang otherprofile}<!--{/if}--></span>
    </div>
</header>
<!-- header end -->
<!-- userinfo start -->
<div class="userinfo">
	<div class="user_avatar">
		<div class="avatar_m"><span><img src="<!--{avatar($space[uid], small, true)}-->" /></span></div>
		<h2 class="name">$space[username]</h2>
	</div>
	<div class="user_box">
		<ul>
			<li><span>$space[credits]</span>{lang credits}</li>
			<!--{loop $_G[setting][extcredits] $key $value}-->
			<!--{if $value[title]}-->
			<li><span>{$space["extcredits$key"]} $value[unit]</span>$value[title]</li>
			<!--{/if}-->
			<!--{/loop}-->
		</ul>
	</div>
	<!--{if $space['uid'] == $_G['uid']}-->
	<div class="btn_exit"><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout_mobile}</a></div>
	<!--{/if}-->
</div>
<!-- userinfo end -->

<!--{else}-->

<!-- header start -->
<div class="n5-header">
    <a class="n5-cebianlan" id="open-sb"><i class="n5-ico"></i></a>
	<a class="n5-logo" href="forum.php?mod=guide&view=hot"><b>$_G[username]</b></a>
	<a class="n5-fatie" href="forum.php?mod=misc&action=nav" rel="nofollow"><i class="n5-ico"></i></a>
</div>
<!--{template common/n5-cbl}-->
<!-- header end -->

<!-- userinfo start -->
<div class="userinfo">
	<div class="n5-grsyzl">
		<div class="avatar_m"><span><img src="<!--{avatar($_G[uid], small, true)}-->" /></span></div>
		<h2 class="n5-name"><p>$_G['member'][credits]</p><p>积分</p></h2>
		<h2 class="n5-name"><p>$space[threads]</p><p>帖子</p></h2>
		<h2 class="n5-name n5-grbl"><p>$space[friends]</p><p>好友</p></h2>
	</div>
	<div class="myinfo_list cl">
		<ul>
			<li><a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">{lang myfavorite}</a></li>
			<li><a href="home.php?mod=space&uid={$_G[uid]}&do=thread&view=me">{lang mythread}</a></li>
			<li class="tit_msg"><a href="home.php?mod=space&do=pm">{lang mypm}<!--{if $_G[member][newpm]}--><img src="{STATICURL}image/mobile/images/icon_msg.png" /><!--{/if}--></a></li>
			<li><a href="home.php?mod=space&uid={$_G[uid]}">{lang myprofile}</a></li>
		</ul>
	</div>
</div>
<!-- userinfo end -->

<!--{/if}-->
<!--{eval $nofooter = true;}-->

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?mod=guide&view=hot" class="bottom_index"></a>
	<a href="forum.php?forumlist=1" class="bottom_history"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member_on"></a>
</div>

<!--{template common/footer}-->

