<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{template common/header}-->

<!-- header start -->
<header class="header">
    <div class="nav">
       <a href="home.php?mod=space&uid=1&do=profile&mycenter=1" class="z"><img src="{STATICURL}image/mobile/images/icon_back.png" /></a>
	   <span>{lang mythread}</span>
   </div>
</header>
<!-- header end -->
<!-- main threadlist start -->
<div class="threadlist n5-wdzt">
	<ul>
	<!--{if $list}-->
		<!--{loop $list $thread}-->
			<li>
			<!--{if $viewtype == 'reply' || $viewtype == 'postcomment'}-->
			<a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$thread[pid]" target="_blank">$thread[subject]</a>
			<!--{else}-->
			<a href="forum.php?mod=viewthread&tid=$thread[tid]" target="_blank" {if $thread['displayorder'] == -1}class="grey"{/if}>$thread[subject]</a>
			<!--{/if}-->
			<span class="num">{$thread[replies]}</span>
			<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
				<span class="icon_top"><img src="{STATICURL}image/mobile/images/icon_top.png"></span>
			<!--{elseif $thread['attachment'] == 2}-->
				<span class="icon_tu"><img src="{STATICURL}image/mobile/images/icon_tu.png"></span>
			<!--{/if}-->
			</li>
		<!--{/loop}-->
	<!--{else}-->
		<li>{lang no_related_posts}</li>
	<!--{/if}-->
	</ul>
	$multi
</div>
<!-- main threadlist end -->
<!--{eval $nofooter = true;}-->
<div class="n5-lbydb"></div>
<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?mod=guide&view=hot" class="bottom_index"></a>
	<a href="forum.php?forumlist=1" class="bottom_history"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member_on"></a>
</div>

<!--{template common/footer}-->

