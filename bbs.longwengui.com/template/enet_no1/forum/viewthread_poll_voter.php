<?php exit;?>
<!--{template common/header}-->
<!--{if empty($_GET['inajax'])}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> $navigation</div>
</div>
<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->
<h3 class="flb">
	<em id="return_$_GET['handlekey']">{lang poll_voters}</em>
	<!--{if !empty($_GET['inajax'])}--><span><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a></span><!--{/if}-->
</h3>
<div class="c voterlist">
	<p>
		<select class="ps" onchange="{if !empty($_GET['inajax'])}showWindow('viewvote', 'forum.php?mod=misc&action=viewvote&tid=$_G[tid]&polloptionid=' + this.value){else}location.href = 'forum.php?mod=misc&action=viewvote&tid=$_G[tid]&polloptionid=' + this.value;{/if}">
		<!--{loop $polloptions $options}-->
			<option value="$options[polloptionid]"{if $options[polloptionid] == $polloptionid} selected="selected"{/if}>$options[polloption]</option>
		<!--{/loop}-->
		</select>
	</p>
	<ul class="ml mtm cl voterl">
	<!--{if !$voterlist}-->
		<li>{lang none}</li>
	<!--{else}-->
		<!--{loop $voterlist $voter}-->
			<li><p><a href="home.php?mod=space&uid=$voter[uid]" target="_blank">$voter[username]</a></p></li>
		<!--{/loop}-->
	<!--{/if}-->
	</ul>
</div>
<div class="c cl mbn">$multipage</div>
<!--{if !$_GET['inajax']}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->