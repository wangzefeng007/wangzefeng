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
		<em id="return_$_GET['handlekey']">{lang rate_view}</em>
		<span>
			<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
		</span>
	</h3>
	<div class="c floatwrap">
		<table class="list" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<td>{lang credits}</td>
					<td>{lang username}</td>
					<td>{lang time}</td>
					<td>{lang reason}</td>
				</tr>
			</thead>
			<!--{loop $loglist $log}-->
			<tr>
				<td>{$_G['setting']['extcredits'][$log[extcredits]][title]} $log[score] {$_G['setting']['extcredits'][$log[extcredits]][unit]}</td>
				<td><a href="home.php?mod=space&uid=$log[uid]">$log[username]</a></td>
				<td>$log[dateline]</td>
				<td>$log[reason]</td>
			</tr>
			<!--{/loop}-->
		</table>
	</div>
</div>
<div class="o pns">
	{lang total}:
	<!--{loop $logcount $id $count}-->
	&nbsp;{$_G['setting']['extcredits'][$id][title]} <!--{if $count>0}-->+<!--{/if}-->$count {$_G['setting']['extcredits'][$id][unit]} &nbsp;
	<!--{/loop}-->
</div>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->