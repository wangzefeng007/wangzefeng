<?php exit;?>
<!--{template common/header}-->
<!--{if empty($_GET['infloat'])}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> $navigation</div>
</div>
<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->

<div class="f_c">
	<h3 class="flb">
		<em id="return_$_GET['handlekey']">{lang pay_view}</em>
		<span>
			<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
		</span>
	</h3>

	<div class="c floatwrap">
		<table class="list" cellspacing="0" cellpadding="0"{if empty($_GET['infloat'])} style="margin: 0;"{/if}>
			<tr>
				<th>{lang username}</th>
				<th>{lang time}</th>
				<th>{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}</th>
			</tr>
			<!--{if $loglist}-->
				<!--{loop $loglist $log}-->
					<tr>
						<td><a href="home.php?mod=space&uid=$log[uid]">$log[username]</a></td>
						<td>$log[dateline]</td>
						<td>{$log[$extcreditname]} {$_G[setting][extcredits][$_G[setting][creditstransextra][1]][unit]}</td>
					</tr>
				<!--{/loop}-->
			<!--{else}-->
				<tr><td colspan="3"><div class="emp">{lang attachment_buy_not}</div></td></tr>
			<!--{/if}-->
		</table>
	</div>
</div>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->