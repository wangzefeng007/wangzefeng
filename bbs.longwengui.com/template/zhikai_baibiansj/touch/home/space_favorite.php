<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{template common/header}-->
<!-- header start -->
<header class="header">
    <div class="nav">
		<a href="home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1" class="z"><img src="{STATICURL}image/mobile/images/icon_back.png" /></a>
		<!--{if $_GET['type'] == 'forum'}-->
		<span class="category">
			<span class="display name vm" href="#subname_list">
				<h2 class="tit">{lang favforum}</h2>
				<img src="{STATICURL}image/mobile/images/icon_arrow_down.png" />
			</span>
	        <div id="subname_list" class="subname_list" display="true">
				<ul>
				<li><a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">{lang favthread}</a></li>
				</ul>
	        </div>
		</span>
		<!--{else}-->
		<span class="category">
			<span class="display name vm" href="#subname_list">
				<h2 class="tit">{lang favthread}</h2>
				<img src="{STATICURL}image/mobile/images/icon_arrow_down.png" />
			</span>
	        <div id="subname_list" class="subname_list" display="true">
				<ul>
				<li><a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=forum">{lang favforum}</a></li>
				</ul>
	        </div>
		</span>
		<!--{/if}-->
    </div>
</header>

<!-- main collectlist start -->
<!--{if $_GET['type'] == 'forum'}-->
<div class="coll_list b_radius n5-scbk">
	<ul>
		<!--{if $list}-->
			<!--{loop $list $k $value}-->
			<li><a href="$value[url]">$value[title]</a></li>
			<!--{/loop}-->
		<!--{else}-->
		<li>{lang no_favorite_yet}</li>
		<!--{/if}-->

	</ul>
</div>
<!--{else}-->
<div class="threadlist n5-sczt">
	<ul>
		<!--{if $list}-->
			<!--{loop $list $k $value}-->
			<li><a href="$value[url]">$value[title]</a></li>
			<!--{/loop}-->
		<!--{else}-->
		<li>{lang no_favorite_yet}</li>
		<!--{/if}-->
	</ul>
</div>
<!--{/if}-->
<!-- main collectlist end -->
$multi
<!--{eval $nofooter = true;}-->

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?forumlist=1" class="bottom_history"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member_on"></a>
</div>

<!--{template common/footer}-->

