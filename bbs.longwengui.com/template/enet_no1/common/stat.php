<?php exit;?>
<div class="apps">
	<div class="tbn">
		<h2 class="mt bbda">{lang stats}</h2>
		<ul>
			<li class="cl{if $op == 'basic'} a{/if}"><a href="misc.php?mod=stat&op=basic">{lang basic_situation}</a></li>
			<li class="cl{if $op == 'forumstat'} a{/if}"><a href="misc.php?mod=stat&op=forumstat">{lang forum_stat}</a></li>
			<li class="cl{if $op == 'team'} a{/if}"><a href="misc.php?mod=stat&op=team">{lang manage_team}</a></li>
			<!--{if $_G['setting']['modworkstatus']}-->
				<li class="cl{if $op == 'modworks'} a{/if}"><a href="misc.php?mod=stat&op=modworks">{lang mod_works}</a></li>
			<!--{/if}-->
			<!--{if $_G['setting']['memliststatus']}-->
				<li class="cl{if $op == 'memberlist'} a{/if}"><a href="misc.php?mod=stat&op=memberlist">{lang member_list}</a></li>
			<!--{/if}-->
			<!--{if $_G['setting']['updatestat']}-->
				<li class="cl{if $op == 'trend'} a{/if}"><a href="misc.php?mod=stat&op=trend">{lang trend}</a></li>
			<!--{/if}-->
		</ul>
	</div>
</div>