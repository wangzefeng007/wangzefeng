<?php exit;?>
<div class="tbn">
	<h2 class="mt bbda">{lang post}</h2>
	<ul>
		<li $opactives['thread']><a href="forum.php?mod=guide&view=my">{lang all}</a></li>
		<li $opactives['activity']><a href="home.php?mod=space&do=activity&view=me">{lang activity}</a></li>
		<li $opactives['poll']><a href="home.php?mod=space&do=poll&view=me">{lang poll}</a></li>
		<li $opactives['reward']><a href="home.php?mod=space&do=reward&view=me">{lang reward}</a></li>
		<li $opactives['trade']><a href="home.php?mod=space&do=trade&view=me">{lang trade}</a></li>
		<!--{if !empty($_G['setting']['plugins']['space_thread'])}-->
			<!--{loop $_G['setting']['plugins']['space_thread'] $id $module}-->
				<!--{if !$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])}--><li{if $_GET[id] == $id} class="a"{/if}><a href="home.php?mod=space&do=plugin&op=thread&id=$id">$module[name]</a></li><!--{/if}-->
			<!--{/loop}-->
		<!--{/if}-->
	</ul>
</div>