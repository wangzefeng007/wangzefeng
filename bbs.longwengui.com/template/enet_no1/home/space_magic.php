<?php exit;?>
<!--{template common/header}-->
<div id="ct" class="ct7_a wp cl">
<div class="apps">
 <div class="tbn" style="margin:0">
			<h2 class="mt">{lang magic}</h2>
			<ul>
				<!--{if $_G['group']['allowmagics']}--><li$actives[shop]><a href="home.php?mod=magic&action=shop">{lang magics_shop}</a></li><!--{/if}-->
				<li$actives[mybox]><a href="home.php?mod=magic&action=mybox">{lang magics_user}</a></li>
				<li$actives[log]><a href="home.php?mod=magic&action=log&operation=uselog">{lang magics_log}</a></li>
				<!--{hook/magic_nav_extra}-->
			</ul>
</div>
</div>
	<div class="mn">
		<div class="bm bw0">
			<h1 class="mt">
				<img src="{STATICURL}image/feed/magic.gif" alt="{lang magic}" class="vm" />
				<!--{if $action == 'shop'}-->{lang magics_shop}
				<!--{elseif $action == 'mybox'}-->{lang magics_user}
				<!--{elseif $action == 'log'}-->{lang magics_log}
				<!--{else}-->{lang magics_title}<!--{/if}-->
			</h1>
			<!--{if !$_G['setting']['magicstatus'] && $_G['adminid'] == 1}-->
				<div class="emp">{lang magics_tips}</div>
			<!--{/if}-->

			<!--{if $action == 'shop'}-->
				<!--{subtemplate home/space_magic_shop}-->
			<!--{elseif $action == 'mybox'}-->
				<!--{subtemplate home/space_magic_mybox}-->
			<!--{elseif $action == 'log'}-->
				<!--{subtemplate home/space_magic_log}-->
			<!--{/if}-->
		</div>
	</div>
</div>
<!--{template common/footer}-->