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
		<em id="return_$_GET['handlekey']">{lang thread_moderations}</em>
		<span>
			<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
		</span>
	</h3>
	<div class="c floatwrap">
		<table class="list" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<td>{lang thread_moderations_username}</td>
					<td>{lang time}</td>
					<td>{lang thread_moderations_action}</td>
					<td>{lang expire}</td>
				</tr>
			</thead>
			<!--{loop $loglist $log}-->
				<tr>
					<td><!--{if $log['uid']}--><a href="home.php?mod=space&uid=$log['uid']" target="_blank">$log[username]</a><!--{else}-->{lang thread_moderations_cron}<!--{/if}--></td>
					<td>$log[dateline]</td>
					<td $log[status]>{$modactioncode[$log['action']]}<!--{if $log['magicid']}-->($log[magicname])<!--{/if}-->
						<!--{if $log['action'] == 'REB'}-->{lang to} $log['reason']<!--{/if}-->
					</td>
					<td $log[status]><!--{if $log['expiration']}-->$log[expiration]<!--{elseif in_array($log['action'], array('STK', 'HLT', 'DIG', 'CLS', 'OPN'))}-->{lang expiration_unlimit}<!--{/if}--></td>
				</tr>
			<!--{/loop}-->
		</table>
	</div>
</div>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->