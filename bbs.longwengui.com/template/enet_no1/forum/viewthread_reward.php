<?php exit;?>
<div class="rwd cl">
	<div class="{if $_G['forum_thread']['price'] > 0}rusld{elseif $_G['forum_thread']['price'] < 0}rsld{/if} z">
		<cite>$rewardprice</cite>{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
	</div>
	<div class="rwdn">
		<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_$post[pid]">$post[message]</td></tr></table>
		<!--{if $_G['forum_thread']['price'] > 0 && !$_G['forum_thread']['is_archived']}-->
			<p class="pns mtw"><button name="answer" value="ture" class="pn" onclick="showWindow('reply', 'forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]{if $_GET[from]}&from=$_GET[from]{/if}')"><span>{lang reward_answer}</span></button></p>
		<!--{/if}-->
	</div>
</div>

<!--{if $post['attachment']}-->
	<div class="locked">{lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{elseif $_G['connectguest']}-->{lang attach_nopermission_connect_fill_profile}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em></div>
<!--{elseif $post['imagelist'] || $post['attachlist']}-->
	<div class="pattl">
		<!--{if $post['imagelist']}-->
			 <!--{echo showattach($post, 1)}-->
		<!--{/if}-->
		<!--{if $post['attachlist']}-->
			 <!--{echo showattach($post)}-->
		<!--{/if}-->
	</div>
<!--{/if}-->
<!--{eval $post['attachment'] = $post['imagelist'] = $post['attachlist'] = '';}-->

<!--{if $bestpost}-->
	<div class="rwdbst">
		<h3 class="psth">{lang reward_bestanswer}</h3>
		<div class="pstl">
			<div class="psta vm"><a href="home.php?mod=space&uid=$comment[authorid]" c="1">$bestpost[avatar]</a> <a href="home.php?mod=space&uid=$bestpost[authorid]" class="xi2 xw1">$bestpost[author]</a></div>
			<div class="psti">
				<p class="xi2"><a href="javascript:;" onclick="window.open('forum.php?mod=redirect&goto=findpost&ptid=$bestpost[tid]&pid=$bestpost[pid]')">{lang view_full_content}</a></p>
				<div class="mtn">$bestpost[message]</div>
			</div>
		</div>
	</div>
<!--{/if}-->