<?php exit;?>
<!--{template common/header_ajax}-->
<!--{if $_GET['action'] == 'getpostfeed'}-->

	<!--{if !empty($_GET['type'])}-->
		$post['message']
	<!--{else}-->
		<div class="z flw_avt">
			<a href="home.php?mod=space&uid=$feed[uid]" c="1" shref="home.php?mod=space&uid=$feed[uid]" style="width:55px;height:55px;display:block"><!--{avatar($feed[uid],'middle')}--></a>
			<span class="cnr"></span>
				<div class="mls" style="margin-top:7px">
				<!--{if helper_access::check_module('follow') && $feed['uid'] != $_G[uid]}-->
						<!--{eval $follow = 0;}-->
						<!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $feed['uid']);}-->
						<!--{if !$follow}-->
							<span><a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$feed['uid']" style="margin-top:5px;text-decoration: none !important;background-color: #BDD3E0;color: white !important;padding: 1px 8px;margin-top: 4px">{lang follow_add}TA</a></span>
						<!--{else}-->
							<span><a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$feed[uid]" style="margin-top:5px;text-decoration: none !important;background-color: #BDD3E0;color: white !important;padding: 1px 4px;margin-top: 4px">{lang follow_del}</a></span>
						<!--{/if}-->
				<!--{/if}-->
				</div>
		</div>
	<div class="flw_article">
		<div class="flw_author">
		<a href="home.php?mod=space&uid=$feed[uid]" class="xi2" c="1">$feed['username']</a>
		</div>
		<!--{if $feed['note']}-->
		<div class="flw_quotenote xs2 pbw">
			$feed['note']
		</div>
		<div class="flw_quote">
		<!--{/if}-->
		<!--{if $thread[fid] != $_G[setting][followforumid]}-->
		<h2 class="wx pbm">
			<a href="forum.php?mod=viewthread&tid=$thread['tid']&extra=page%3D1">$thread['subject']</a>
		</h2>
		<!--{/if}-->

		<div class="pbm c cl" id="original_content_$feed[feedid]">$feed['content']</div>
		<div class="xg1 cl">
			<span class="y">
			<!--{if $feed[uid] == $_G[uid] || $_G['adminid'] == 1}-->
			&nbsp; <a href="home.php?mod=spacecp&ac=follow&feedid=$feed[feedid]&op=delete" id="c_delete_$feed['feedid']" onclick="showWindow(this.id, this.href, 'get', 0);" class="flw_delete">{lang delete}</a>
			<!--{/if}-->
			<a href="javascript:;" class="fow_zb" id="relay_$feed[feedid]" onclick="quickrelay($feed['feedid'], $thread['tid']);">{lang follow_relay}($feed['relay'])</a>&nbsp; 
			<a href="javascript:;" class="fow_reply" onclick="quickreply($thread['fid'], $thread['tid'], $feed['feedid'])">{lang follow_quickreply}($thread['replies'])</a>
			</span>
			<span class="xg1"><!--{eval echo dgmdate($feed['dateline'], 'u');}--></span>
			<!--{if $feed['note']}--><a href="home.php?mod=space&uid=$feed[uid]">$thread['author']</a> {lang poston} <!--{date($thread['dateline'])}-->&nbsp;<!--{/if}--><!--{if $thread[fid] != $_G[setting][followforumid] && $_G['cache']['forums'][$thread['fid']]['name']}-->#<a href="forum.php?mod=forumdisplay&fid=$thread['fid']">$_G['cache']['forums'][$thread['fid']]['name']</a><!--{/if}-->
		</div>
		<!--{if $feed['note']}--></div><!--{/if}-->
	</div>
	<div id="replybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>
	<div id="relaybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>

	<!--{/if}-->
<!--{else}-->
	<a href="home.php?mod=space&uid=$post['authorid']" class="d xg1">$post['author']:</a>$post['message']
<!--{/if}-->
<!--{template common/footer_ajax}-->