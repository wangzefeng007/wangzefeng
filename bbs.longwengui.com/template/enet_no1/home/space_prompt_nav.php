<?php exit;?>
<div class="tbn">
	<h2 class="mt bbda">{lang prompt}</h2>
	<ul>
		<li $opactives['pm']><em class="notice_pm"></em><a href="home.php?mod=space&do=pm">{lang news} <!--{if $newpmcount}--><strong class="xi1">($newpmcount)</strong><!--{/if}--></a></li>
		<!--{loop $_G['notice_structure'] $key $type}-->
		<li $opactives[$key]><em class="notice_$key"></em><a href="home.php?mod=space&do=notice&view=$key"><!--{eval echo lang('template', 'notice_'.$key)}--><!--{if $_G['member']['category_num'][$key]}-->($_G['member']['category_num'][$key])<!--{/if}--></a></li>
		<!--{/loop}-->
		<!--{if $_G['setting']['my_app_status']}-->
		<li$actives[userapp]><em class="notice_userapp"></em><a href="home.php?mod=space&do=notice&view=userapp">{lang applications_news}{if $mynotice}($mynotice){/if}</a></li>
		<!--{/if}-->
	</ul>
</div>