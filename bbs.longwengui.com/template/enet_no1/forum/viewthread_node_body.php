<?php exit;?>
<div>
	<!--{if $_G['forum_thread']['replycredit'] > 0 && $post['first']}-->
		<div class="locked replycredit">
			<strong>{$_G['forum_thread']['replycredit']} {$_G['setting']['extcredits'][$_G[forum_thread][replycredit_rule][extcreditstype]][unit]}{$_G['setting']['extcredits'][$_G[forum_thread][replycredit_rule][extcreditstype]][title]}</strong> {lang thread_replycredit_tips1} {lang thread_replycredit_tips2}<!--{if $_G['forum_thread']['replycredit_rule'][random] > 0}--><span class="xg1">{lang thread_replycredit_tips3}</span><!--{/if}-->
		</div>
	<!--{/if}-->

	<!--{if $rushreply && $post['first']}-->
		<div class="locked rewardfloor">
		<!--{if $rushresult[rewardfloor]}-->
			<span class="y">
			<!--{if $_G['uid'] == $_G['thread']['authorid'] || $_G['forum']['ismoderator']}--><a href="javascript:;" onclick="showWindow('membernum', 'forum.php?mod=ajax&action=get_rushreply_membernum&tid=$_G[tid]')" class="y pn xi2"><span>{lang thread_rushreply_statnum}</span></a><!--{/if}-->
			<!--{if !$_GET['checkrush']}-->
					<a href="forum.php?mod=viewthread&tid=$post[tid]&checkrush=1" rel="nofollow" class="y pn xi2"><span>{lang rushreply_view}</span></a>
			<!--{/if}-->
			</span>
		<!--{/if}-->
		<strong>{lang rushreply}</strong>
		<!--{if $rushresult[creditlimit] == ''}-->
			{lang thread_rushreply}&nbsp;
		<!--{else}-->
			{lang thread_rushreply_limit} &nbsp;
		<!--{/if}-->
		<!--{if $rushresult[starttimefrom]}-->
			{lang thread_rushreply_start}$rushresult[starttimefrom]&nbsp;
		<!--{/if}-->
		<!--{if $rushresult[starttimeto]}-->
			{lang thread_rushreply_over}$rushresult[starttimeto]&nbsp;
		<!--{/if}-->
		<!--{if $rushresult[stopfloor]}-->
			{lang thread_rushreply_end}$rushresult[stopfloor]&nbsp;
		<!--{/if}-->
		<!--{if $rushresult[rewardfloor]}-->
			{lang thread_rushreply_floor}: $rushresult[rewardfloor]&nbsp;
		<!--{/if}-->
		<!--{if $rushresult[rewardfloor] && $_GET['checkrush']}-->
			<p class="ptn">
				<!--{if $countrushpost}-->[<strong>$countrushpost</strong>]{lang thread_rushreply_rewardnum}&nbsp;&nbsp;<!--{/if}-->
				<a href="forum.php?mod=viewthread&tid=$_G[tid]" class="xi2">{lang thread_rushreply_check_back}</a>
			</p>
		<!--{/if}-->
		</div>
	<!--{/if}-->


<!--{if !$_G['forum']['ismoderator'] && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($_G['thread']['digest'] == 0 && ($post['groupid'] == 4 || $post['groupid'] == 5 || $post['memberstatus'] == '-1')))}-->
	<div class="locked">{lang message_banned}</div>
<!--{elseif !$_G['forum']['ismoderator'] && $post['status'] & 1}-->
	<div class="locked">{lang message_single_banned}</div>
<!--{elseif $needhiddenreply}-->
	<div class="locked">{lang message_ishidden_hiddenreplies}</div>
<!--{elseif $post['first'] && $_G['forum_threadpay']}-->
	<!--{template forum/viewthread_pay}-->
<!--{else}-->
	<!--{if !$post['first'] && !empty($post[subject])}-->
		<h2>$post[subject]</h2>
	<!--{/if}-->
	<!--{hook/viewthread_posttop $postcount}-->
	<!--{if $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($_G['thread']['digest'] == 0 && ($post['groupid'] == 4 || $post['groupid'] == 5 || $post['memberstatus'] == '-1')))}-->
		<div class="locked">{lang admin_message_banned}</div>
	<!--{elseif $post['status'] & 1}-->
		<div class="locked">{lang admin_message_single_banned}</div>
	<!--{/if}-->
	<!--{if !$post['first'] && $hiddenreplies && $_G['forum']['ismoderator']}-->
		<div class="locked">{lang message_ishidden_hiddenreplies}</div>
	<!--{/if}-->
	<!--{if $post['first']}-->
		<!--{if $_G['forum_thread']['price'] > 0 && $_G['forum_thread']['special'] == 0}-->
			<div class="locked"><em class="y"><a href="forum.php?mod=misc&action=viewpayments&tid=$_G[tid]" onclick="showWindow('pay', this.href)">{lang pay_view}</a></em>{lang pay_threads}: <strong>$_G[forum_thread][price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} </strong></div>
		<!--{/if}-->
		<!--{if $threadsort && $threadsortshow}-->
			<!--{if $threadsortshow['typetemplate']}-->
				$threadsortshow[typetemplate]
			<!--{elseif $threadsortshow['optionlist']}-->
				<div class="typeoption">
					<!--{if $threadsortshow['optionlist'] == 'expire'}-->
						{lang has_expired}
					<!--{else}-->
						<table summary="{lang threadtype_option}" cellpadding="0" cellspacing="0" class="cgtl mbm">
							<caption>$_G[forum][threadsorts][types][$_G[forum_thread][sortid]]</caption>
							<tbody>
								<!--{loop $threadsortshow['optionlist'] $option}-->
									<!--{if $option['type'] != 'info'}-->
										<tr>
											<th>$option[title]:</th>
											<td><!--{if $option['value']}-->$option[value] $option[unit]<!--{else}-->-<!--{/if}--></td>
										</tr>
									<!--{/if}-->
								<!--{/loop}-->
							</tbody>
						</table>
					<!--{/if}-->
				</div>
			<!--{/if}-->
		<!--{/if}-->
	<!--{/if}-->
	<div class="{if !$_G[forum_thread][special]}t_fsz{else}pcbs{/if}">
	$_G['forum_posthtml']['header'][$post[pid]]
		<!--{if $post['first']}-->
			<!--{if !$_G[forum_thread][special]}-->
				<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_$post[pid]">
				<!--{if !$_G['inajax']}-->
					<!--{if $ad_a_pr}-->
						$ad_a_pr
					<!--{/if}-->
				<!--{/if}-->
				$post[message]</td></tr></table>
			<!--{elseif $_G[forum_thread][special] == 1}-->
				<!--{template forum/viewthread_poll}-->
			<!--{elseif $_G[forum_thread][special] == 2}-->
				<!--{template forum/viewthread_trade}-->
			<!--{elseif $_G[forum_thread][special] == 3}-->
				<!--{template forum/viewthread_reward}-->
			<!--{elseif $_G[forum_thread][special] == 4}-->
				<!--{template forum/viewthread_activity}-->
			<!--{elseif $_G[forum_thread][special] == 5}-->
				<!--{template forum/viewthread_debate}-->
			<!--{elseif $_G[forum_thread][special] == 127}-->
				$threadplughtml
				<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_$post[pid]">$post[message]</td></tr></table>
			<!--{/if}-->
		<!--{else}-->
			<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_$post[pid]">
			<!--{if $post['invisible'] != '-2' || $_G['forum']['ismoderator']}-->$post[message]<!--{else}--><span class="xg1">{lang moderate_need}</span><!--{/if}--></td></tr></table>
		<!--{/if}-->

		<!--{if $post['attachment']}-->
			<div class="attach_nopermission">
				<div>
					<h3>{lang attach_nopermission_notice}</h3>
					<p><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{elseif $_G['connectguest']}-->{lang attach_nopermission_connect_fill_profile}<!--{else}-->{lang attach_nopermission_login} <!--{hook/global_login_text}--><!--{/if}--></p>
				</div>
			</div>
		<!--{elseif $post['imagelist'] || $post['attachlist']}-->
			<div class="pattl">
				<!--{if $post['imagelist'] && $_G['setting']['imagelistthumb'] && $post['imagelistcount'] >= $_G['setting']['imagelistthumb']}-->
					<!--{if !isset($imagelistkey)}-->
						<!--{eval $imagelistkey = rawurlencode(md5($_G[tid].'|100|100'))}-->
						<script type="text/javascript" reload="1">var imagelistkey = '$imagelistkey';</script>
					<!--{/if}-->
					<!--{eval $post['imagelistthumb'] = true;}-->
					<div class="bbda cl mtw mbm pbm">
						<strong>{lang more_images}</strong>
						<a href="javascript:;" onclick="attachimglst('$post[pid]', 0)" class="xi2 attl_g">{lang image_small}</a>
						<a href="javascript:;" onclick="attachimglst('$post[pid]', 1, {echo intval($_G['setting']['lazyload'])})" class="xi2 attl_m">{lang image_big}</a>
					</div>
					<div id="imagelist_$post[pid]" class="cl" style="display:none"><!--{echo showattach($post, 1)}--></div>
					<div id="imagelistthumb_$post[pid]" class="pattl_c cl"><img src="{IMGDIR}/loading.gif" width="16" height="16" class="vm" /> {lang image_list_openning}</div>
				<!--{else}-->
					<!--{echo showattach($post, 1)}-->
				<!--{/if}-->
				<!--{if $post['attachlist']}-->
					<!--{echo showattach($post)}-->
				<!--{/if}-->
			</div>
		<!--{/if}-->
	</div>
	<!--{hook/viewthread_postbottom $postcount}-->
	<!--{if !empty($post['ratelog'])}-->
			<h3 class="psth xs1"><span class="icon_ring vm"></span>{lang rate}</h3>
		<dl id="ratelog_$post[pid]" class="rate">
			<!--{if $_G['setting']['ratelogon']}-->
				<dd style="margin:0">
			<!--{else}-->
				<dt>
					<!--{if !empty($postlist[$post[pid]]['totalrate'])}-->
						<strong><a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]" onclick="showWindow('viewratings', this.href)" title="{lang have}{echo count($postlist[$post[pid]][totalrate]);}{lang people_score}, {lang rate_view}"><!--{echo count($postlist[$post[pid]][totalrate]);}--></a></strong>
						<p><a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]" onclick="showWindow('viewratings', this.href)">{lang rate_view}</a></p>
					<!--{/if}-->
				</dt>
				<dd>
			<!--{/if}-->
				<div id="post_rate_$post[pid]"></div>
				<!--{if $_G['setting']['ratelogon']}-->
					<table class="ratl">
						<tr>
							<th class="xw1" width="120"><a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]" onclick="showWindow('viewratings', this.href)" title="{lang rate_view}">{lang have} <span class="xi1"><!--{echo count($postlist[$post[pid]][totalrate]);}--></span> {lang people_score}</a></th>
							<!--{loop $post['ratelogextcredits'] $id $score}-->
							<th width="50"><i>{$_G['setting']['extcredits'][$id][title]}</i></th>
							<!--{/loop}-->
							<th>
								<i>{lang reason}</i>
							</th>
						</tr>
						<tbody class="ratl_l">
							<!--{loop $post['ratelog'] $uid $ratelog}-->
							<tr id="rate_{$post[pid]}_{$uid}">
								<td>
									<a href="home.php?mod=space&uid=$uid" target="_blank">$ratelog[username]</a>
								</td>
								<!--{loop $post['ratelogextcredits'] $id $score}-->
									<!--{if $ratelog['score'][$id] > 0}-->
										<td class="xi1"> + $ratelog[score][$id]</td>
									<!--{else}-->
										<td class="xg1">$ratelog[score][$id]</td>
									<!--{/if}-->
								<!--{/loop}-->
								<td class="xg1">$ratelog[reason]</td>
							</tr>
							<!--{/loop}-->
						</tbody>
					</table>
					<p class="ratc">
						{lang rate_total}:&nbsp;
						<!--{loop $post['ratelogextcredits'] $id $score}-->
							<!--{if $score > 0}-->
								<span class="xi1">{$_G['setting']['extcredits'][$id][title]} + $score</span>&nbsp;
							<!--{else}-->
								<span class="xg1">{$_G['setting']['extcredits'][$id][title]} $score</span>&nbsp;
							<!--{/if}-->
						<!--{/loop}-->
						&nbsp;<a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]" onclick="showWindow('viewratings', this.href)" title="{lang rate_view}" class="xi2">{lang rate_view}</a>
					</p>
				<!--{else}-->
					<ul class="cl">
						<!--{loop $post['ratelog'] $uid $ratelog}-->
							<li>
								<p id="rate_{$post[pid]}_{$uid}" onmouseover="showTip(this)" tip="<strong>$ratelog[reason]</strong>&nbsp;
										<!--{loop $ratelog['score'] $id $score}-->
											<!--{if $score > 0}-->
												<em class='xi1'>{$_G['setting']['extcredits'][$id][title]} + $score $_G['setting']['extcredits'][$id][unit]</em>
											<!--{else}-->
												<span>{$_G['setting']['extcredits'][$id][title]} $score $_G['setting']['extcredits'][$id][unit]</span>
											<!--{/if}-->
										<!--{/loop}-->" class="mtn mbn"><a href="home.php?mod=space&uid=$uid" target="_blank" class="avt"><!--{echo avatar($uid, 'small');}--></a></p>
								<p><a href="home.php?mod=space&uid=$uid" target="_blank">$ratelog[username]</a></p>
							</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
			</dd>
		</dl>
	<!--{else}-->
		<div id="post_rate_div_$post[pid]"></div>
	<!--{/if}-->
	<!--{/if}-->
</div>