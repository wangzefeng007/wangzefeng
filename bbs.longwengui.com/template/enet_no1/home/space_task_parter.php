<?php exit;?>
<!--{eval 
	$_G[home_tpl_titles] = array('{lang task}');
}-->
<!--{template common/header}-->
<ul class="ml mls cl">
	<!--{loop $parterlist $parter}-->
		<li>
			<a href="home.php?mod=space&uid=$parter[uid]" title="{if $parter[status] == 1}{lang task_complete}{elseif $parter[status] == -1}{lang task_failed}{elseif $parter[status] == 0}{lang task_complete} $parter[csc]%{/if}" target="_blank" class="avt">$parter[avatar]</a>
			<p><a href="home.php?mod=space&uid=$parter[uid]" title="{lang member_viewpro}" target="_blank">$parter[username]</a></p>
		</li>
	<!--{/loop}-->
</ul>
<!--{template common/footer}-->