<?php exit;?>
<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
<dl class="bbda cl">
	<!--{if empty($post['deleted'])}-->
		<!--{if $post[author] && !$post['anonymous']}-->
		<dd class="m avt"><a href="home.php?mod=space&uid=$post[authorid]"><!--{avatar($post[authorid], small)}--></a></dd>
		<!--{else}-->
		<dd class="m avt"><img src="{STATICURL}image/magic/hidden.gif" alt="hidden" /></dd>
		<!--{/if}-->
		<dt>
			<span class="y xw0">
				<!--{if !$post[first] && $_G['forum_thread']['special'] == 5}-->
					<label class="pdbts pdbts_{echo intval($post[stand])}">
						<!--{if $post[stand] == 1}--><a class="v" href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&filter=debate&stand=1{if $_GET[from]}&from=$_GET[from]{/if}" title="{lang debate_view_square}">{lang debate_square}</a>
							<!--{elseif $post[stand] == 2}--><a class="v" href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&filter=debate&stand=2{if $_GET[from]}&from=$_GET[from]{/if}" title="{lang debate_view_opponent}">{lang debate_opponent}</a>
							<!--{else}--><a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&filter=debate&stand=0{if $_GET[from]}&from=$_GET[from]{/if}" title="{lang debate_view_neutral}">{lang debate_neutral}</a><!--{/if}-->
						<!--{if $post[stand]}-->
							<a class="b" href="forum.php?mod=misc&action=debatevote&tid=$_G[tid]&pid=$post[pid]{if $_GET[from]}&from=$_GET[from]{/if}" id="voterdebate_$post[pid]" onclick="ajaxmenu(this);doane(event);">{lang debate_support} $post[voters]</a>
						<!--{/if}-->
					</label>
				<!--{/if}-->
				<!--{if $_G['forum_thread']['special'] == 3 && ($_G['forum']['ismoderator'] && (!$_G['setting']['rewardexpiration'] || $_G['setting']['rewardexpiration'] > 0 && ($_G[timestamp] - $_G['forum_thread']['dateline']) / 86400 > $_G['setting']['rewardexpiration']) || $_G['forum_thread']['authorid'] == $_G['uid']) && $post['authorid'] != $_G['forum_thread']['authorid'] && $post['first'] == 0 && $_G['uid'] != $post['authorid'] && $_G['forum_thread']['price'] > 0}-->
					<a href="javascript:;" onclick="setanswer($post['pid'], '$_GET[from]')">{lang reward_set_bestanswer}</a>
				<!--{/if}-->

				<!--{if $_G['group']['raterange'] && $post['authorid']}-->
					<a href="javascript:;" onclick="showWindow('rate', 'forum.php?mod=misc&action=rate&tid=$_G[tid]&pid=$post[pid]{if $_GET[from]}&from=$_GET[from]{/if}', 'get', -1);return false;">{lang rate}</a>
				<!--{/if}-->
				<!--{if $allowpostreply && $post['invisible'] == 0}-->
					<!--{if $post['allowcomment']}-->
						<a href="javascript:;" onclick="showWindow('comment', 'forum.php?mod=misc&action=comment&tid=$post[tid]&pid=$post[pid]&extra=$_GET[extra]&page=$page{if $_GET[from]}&from=$_GET[from]{/if}{if $_G['forum_thread']['special'] == 127}&special=$specialextra{/if}', 'get', 0)">{lang comments}</a>
					<!--{/if}-->
					<!--{if !$needhiddenreply}-->
						<!--{if $post['first']}-->
							<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&reppost=$post[pid]&extra=$_GET[extra]&page=$page{if $_GET[from]}&from=$_GET[from]{/if}" onclick="showWindow('reply', this.href)">{lang reply}</a>
						<!--{else}-->
							<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page{if $_GET[from]}&from=$_GET[from]{/if}" onclick="showWindow('reply', this.href)">{lang reply}</a>
						<!--{/if}-->
					<!--{/if}-->
				<!--{/if}-->
				<!--{if (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit)))}-->
					<a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page{if $_GET[from]}&from=$_GET[from]{/if}"><!--{if $_G['forum_thread']['special'] == 2 && !$post['message']}-->{lang post_add_aboutcounter}<!--{else}-->{lang edit}</a><!--{/if}-->
				<!--{/if}-->

			</span>
			<!--{if $post['authorid'] && !$post['anonymous']}-->
				<a href="home.php?mod=space&uid=$post[authorid]" target="_blank" class="xi2">$post[author]</a>$authorverifys
				<!--{hook/viewthread_postheader $postcount}-->
				<em id="author_$post[pid]"> {lang poston}</em>
			<!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
				{lang anonymous}
				<!--{hook/viewthread_postheader $postcount}-->
				<em id="author_$post[pid]"> {lang poston}</em>
			<!--{elseif !$post['authorid'] && !$post['username']}-->
				{lang guest}
				<!--{hook/viewthread_postheader $postcount}-->
				<em id="author_$post[pid]"> {lang poston}</em>
			<!--{/if}-->
			<span class="xg1 xw0">$post[dateline]</span>
		</dt>
		<dd class="z">
			<!--{subtemplate forum/viewthread_node_body}-->
		</dd>
	<!--{else}-->
		<dd>{lang post_deleted}</dd>
	<!--{/if}-->
</dl>


<!--{if !empty($aimgs[$post[pid]])}-->
<script type="text/javascript" reload="1">
	aimgcount[{$post[pid]}] = [<!--{echo dimplode($aimgs[$post[pid]]);}-->];
	attachimggroup($post['pid']);
	<!--{if empty($_G['setting']['lazyload'])}-->
		<!--{if !$post['imagelistthumb']}-->
			attachimgshow($post[pid]);
		<!--{else}-->
			attachimgshow($post[pid], 1);
		<!--{/if}-->
	<!--{/if}-->
	<!--{if $post['imagelistthumb']}-->
		attachimglstshow($post['pid'], <!--{echo intval($_G['setting']['lazyload'])}-->, 0, '{$_G[setting][showexif]}');
	<!--{/if}-->
</script>
<!--{/if}-->
<!--{hook/viewthread_endline $postcount}-->

