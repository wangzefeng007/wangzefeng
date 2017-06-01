<?php exit;?>
<!--{eval $carray = array();}-->
<!--{eval $beforeuser = 0;}-->
<!--{eval $hiddennum = 0;}-->
<!--{loop $list['feed'] $feed}-->
	<!--{eval $content = $list['content'][$feed['tid']];}-->
	<!--{eval $thread = $list['threads'][$content['tid']];}-->
	<!--{if !empty($thread) && $thread['displayorder'] >= 0 || !empty($feed['note'])}-->
	<li class="cl{if $lastviewtime && $feed[dateline] > $lastviewtime} unread{/if}" id="feed_li_$feed['feedid']" onmouseover="this.className='flw_feed_hover cl'" onmouseout="this.className='cl'">
		<!--{if $_GET['do'] != 'view' && !isset($_GET[banavatar])}-->
		<div class="z flw_avt">
			<!--{eval $beforeuser = $feed['uid'];}-->
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
		<!--{/if}-->
		<div class="flw_article" {if $_GET['do'] == 'view' || $_GET[banavatar]}style="padding-left:0 !Important"{/if}>
			<!--{if $feed[uid] == $_G[uid] || $_G['adminid'] == 1}-->
			<a href="home.php?mod=spacecp&ac=follow&feedid=$feed[feedid]&op=delete" id="c_delete_$feed['feedid']" onclick="showWindow(this.id, this.href, 'get', 0);" class="flw_delete">{lang delete}</a>
			<!--{/if}-->
			<div class="flw_author">
			<!--{if $_GET['do'] != 'view' && !isset($_GET[banavatar])}-->
			<a href="home.php?mod=space&uid=$feed[uid]" class="xi2" c="1" shref="home.php?mod=space&uid=$feed[uid]">$feed['username']</a>
			<!--{/if}-->
			</div>
			<!--{if $feed['note']}-->
			<div class="flw_quotenote xs2 pbw">
				$feed['note']
			</div>
			<div class="flw_quote">
			<!--{/if}-->
			<!--{if !empty($thread) && $thread['displayorder'] >= 0}-->
			<h2 class="wx pbn">
				<!--{if isset($carray[$feed['cid']])}-->
				<a href="javascript:;" onclick="vieworiginal(this, 'original_content_$feed[feedid]');return false;" class="flw_readfull y xw0 xs1 xi2">+ {lang follow_open_feed}</a>
				<!--{/if}-->
				<!--{if $thread[fid] != $_G[setting][followforumid]}-->
				<a href="forum.php?mod=viewthread&tid=$content['tid']&extra=page%3D1" target="_blank">$thread['subject']</a>
				<!--{/if}-->
			</h2>

			<div class="pbm c cl" id="original_content_$feed[feedid]" {if isset($carray[$feed['cid']])} style="display: none"{/if}>
				$content['content']
				<!--{if $thread['special'] && $thread[fid] != $_G[setting][followforumid]}-->
				<br/>
				<a href="forum.php?mod=viewthread&tid=$content['tid']&extra=page%3D1" target="_blank">{lang follow_special_thread_tip}</a>
				<!--{/if}-->
			</div>
			
			<!--{if $feed['note']}-->
			<div class="xg1 cl">
				<a href="home.php?mod=space&uid=$feed[uid]">$thread['author']</a> {lang follow_post_by_time} <!--{date($thread['dateline'])}-->
			</div>
			<!--{/if}-->
			
			<!--{if $feed['note']}--></div><!--{/if}-->
			<div class="xg1 cl">
				<span class="y">
				<!--{if helper_access::check_module('follow')}-->
				<a href="javascript:;" class="fow_zb" id="relay_$feed[feedid]" onclick="quickrelay($feed['feedid'], $thread['tid']);">{lang follow_reply}($content['relay'])</a>&nbsp;
				<!--{/if}--> 
				<a href="javascript:;" class="fow_reply" onclick="quickreply($thread['fid'], $thread['tid'], $feed['feedid'])">{lang reply}($thread['replies'])</a>
				</span>
				<span class="xg1"><!--{eval echo dgmdate($feed['dateline'], 'u');}--></span>
				<!--{if $thread[fid] != $_G[setting][followforumid] && $_G['cache']['forums'][$thread['fid']]['name']}-->#<a href="forum.php?mod=forumdisplay&fid=$thread['fid']">$_G['cache']['forums'][$thread['fid']]['name']</a><!--{/if}-->
			</div>
			<!--{else}-->
			<div class="pbm c cl" id="original_content_$feed[feedid]" {if isset($carray[$feed['cid']])} style="display: none"{/if}>
			{lang follow_thread_deleted}
			</div>
			<!--{/if}-->
		</div>
		<div id="replybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>
		<div id="relaybox_$feed['feedid']" class="flw_replybox cl" style="display: none;"></div>
	</li>
	<!--{else}-->
		<!--{eval $hiddennum++;}-->
	<!--{/if}-->
	<!--{if !isset($carray[$feed['cid']])}-->
		<!--{eval $carray[$feed['cid']] = $feed['cid'];}-->
	<!--{/if}-->
<!--{/loop}-->