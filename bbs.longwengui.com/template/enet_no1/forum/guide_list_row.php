<?php exit;?>
<!--{if $list['threadcount']}-->
	<!--{loop $list['threadlist'] $key $thread}-->
		<tbody id="$thread[id]">
			<tr>
				<td class="avt">
					<!--{if $thread['authorid'] && $thread['author']}-->
						<a href="home.php?mod=space&uid=$thread[authorid]"><!--{avatar($thread[authorid],small)}--></a>
					<!--{else}-->
						<a><img src="$_G['style']['styleimgdir']/hidden.gif" title="$_G[setting][anonymoustext]" alt="$_G[setting][anonymoustext]" /></a>
					<!--{/if}-->
				</td>
				<th class="$thread[folder]">
					<!--{hook/forumdisplay_thread $key}-->
					<!--{if !$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
						<!--{eval $thread[tid]=$thread[closed];}-->
					<!--{/if}-->
					<span class="xst">
						$thread[typehtml] $thread[sorthtml]
						<!--{if $thread['moved']}-->
							{lang thread_moved}:<!--{eval $thread[tid]=$thread[closed];}-->
						<!--{/if}-->
						<a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"$thread[highlight]>$thread[subject]</a>
					</span>
					<!--{if $thread[icon] >= 0}-->
						<img src="{STATICURL}image/stamp/{$_G[cache][stamps][$thread[icon]][url]}" alt="{$_G[cache][stamps][$thread[icon]][text]}" align="absmiddle" />
					<!--{/if}-->

					<!--{if $thread[folder] == 'lock'}-->
						<img src="{IMGDIR}/folder_lock.gif" title="{lang closed_thread}" alt="{lang closed_thread}" align="absmiddle" />
					<!--{elseif $thread['special'] == 1}-->
						<img src="{IMGDIR}/pollsmall.gif" title="{lang thread_poll}" alt="{lang thread_poll}" align="absmiddle" />
					<!--{elseif $thread['special'] == 2}-->
						<img src="{IMGDIR}/tradesmall.gif" title="{lang thread_trade}" alt="{lang thread_trade}" align="absmiddle" />
					<!--{elseif $thread['special'] == 3}-->
						<img src="{IMGDIR}/rewardsmall.gif" title="{lang thread_reward}" alt="{lang thread_reward}" align="absmiddle" />
					<!--{elseif $thread['special'] == 4}-->
						<img src="{IMGDIR}/activitysmall.gif" title="{lang thread_activity}" alt="{lang thread_activity}" align="absmiddle" />
					<!--{elseif $thread['special'] == 5}-->
						<img src="{IMGDIR}/debatesmall.gif" title="{lang thread_debate}" alt="{lang thread_debate}" align="absmiddle" />
					<!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
						<img src="{IMGDIR}/pin_$thread[displayorder].gif" title="$_G[setting][threadsticky][3-$thread[displayorder]]" alt="$_G[setting][threadsticky][3-$thread[displayorder]]" align="absmiddle" />
					<!--{/if}-->

					<!--{if $thread['rushreply']}-->
						<img src="{IMGDIR}/rushreply_s.png" alt="{lang rushreply}" align="absmiddle" />
					<!--{/if}-->
					<!--{if $stemplate && $sortid}-->$stemplate[$sortid][$thread[tid]]<!--{/if}-->
					<!--{if $thread['readperm']}--> - [{lang readperm} <span class="xw1">$thread[readperm]</span>]<!--{/if}-->
					<!--{if $thread['price'] > 0}-->
						<!--{if $thread['special'] == '3'}-->
						- <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype=1" title="{lang show_rewarding_only}"><span class="xi1">[{lang thread_reward} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][title]}]</span></a>
						<!--{else}-->
						- [{lang price} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][title]}]
						<!--{/if}-->
					<!--{elseif $thread['special'] == '3' && $thread['price'] < 0}-->
						- <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype=2" title="{lang show_rewarded_only}">[{lang reward_solved}]</a>
					<!--{/if}-->
					<!--{if $thread['attachment'] == 2}-->
						<img src="{STATICURL}image/filetype/image_s.gif" alt="attach_img" title="{lang attach_img}" align="absmiddle" />
					<!--{elseif $thread['attachment'] == 1}-->
						<img src="{STATICURL}image/filetype/common.gif" alt="attachment" title="{lang attachment}" align="absmiddle" />
					<!--{/if}-->
					<!--{if $thread['mobile']}-->
						<img src="{IMGDIR}/mobile-attach-$thread['mobile'].png" alt="{lang post_mobile}" align="absmiddle" />
					<!--{/if}-->
					<!--{if $thread['digest'] > 0 && $filter != 'digest'}-->
						<img src="{IMGDIR}/digest_$thread[digest].gif" align="absmiddle" alt="digest" title="{lang thread_digest} $thread[digest]" />
					<!--{/if}-->
					<!--{if $thread['displayorder'] == 0}-->
						<!--{if $thread[recommendicon] && $filter != 'recommend'}-->
							<img src="{IMGDIR}/recommend_$thread[recommendicon].gif" align="absmiddle" alt="recommend" title="{lang thread_recommend} $thread[recommends]" />
						<!--{/if}-->
						<!--{if $thread[heatlevel]}-->
							<img src="{IMGDIR}/hot_$thread[heatlevel].gif" align="absmiddle" alt="heatlevel" title="$thread[heatlevel] {lang heats}" />
						<!--{/if}-->
						<!--{if $thread['rate'] > 0}-->
							<img src="{IMGDIR}/agree.gif" align="absmiddle" alt="agree" title="{lang rate_credit_add}" />
						<!--{elseif $thread['rate'] < 0}-->
							<img src="{IMGDIR}/disagree.gif" align="absmiddle" alt="disagree" title="{lang posts_deducted}" />
						<!--{/if}-->
					<!--{/if}-->
					<!--{if $thread['replycredit'] > 0}-->
						- <span class="xi1">[{lang replycredit} <strong> $thread['replycredit']</strong> ]</span>
					<!--{/if}-->
					<!--{hook/forumdisplay_thread_subject $key}-->
					<!--{if $thread[multipage]}-->
						<span class="tps">$thread[multipage]</span>
					<!--{/if}-->
					<!--{if $thread['weeknew']}-->
						<a href="forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost#lastpost" class="xi1">New</a>
					<!--{/if}-->
					<!--{if !$thread['forumstick'] && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
						<!--{if $thread['related_group'] == 0 && $thread['closed'] > 1}-->
							<!--{eval $thread[tid]=$thread[closed];}-->
						<!--{/if}-->
						<!--{if $groupnames[$thread[tid]]}-->
							<span class="fromg xg1"> [{lang from}: <a href="forum.php?mod=forumdisplay&fid={$groupnames[$thread[tid]][fid]}" target="_blank" class="xg1">{$groupnames[$thread[tid]][name]}</a>]</span>
						<!--{/if}-->
					<!--{/if}-->

					<!--{if $view == 'my' && $viewtype=='reply' && !empty($tids[$thread[tid]])}-->
						<!--{loop $tids[$thread[tid]] $pid}-->
						<!--{eval $post = $posts[$pid];}-->
							<!--{if $post[message]}--><p class="mtn xg1">&nbsp;<img src="{IMGDIR}/icon_quote_m_s.gif" class="vm" /> <a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$pid" target="_blank">{$post[message]}</a> <img src="{IMGDIR}/icon_quote_m_e.gif" class="vm" /></p><!--{/if}-->
						<!--{/loop}-->
					<!--{/if}-->

					<!--{if $view == 'my' && $viewtype == 'postcomment'}-->
						<p class="mtn xg1">$thread[comment]</p>
					<!--{/if}-->

					<!--{if $viewtype != 'postcomment'}-->
										<p class="mtn xg1" style="font-size: 12px">
											<!--{hook/forumdisplay_author $key}-->
											<!--{if $thread['authorid'] && $thread['author']}-->
												<span>{lang author}:</span><a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
											<!--{else}-->
												<span>{lang author}:</span>$_G[setting][anonymoustext]
											<!--{/if}-->
											&nbsp;
											<span>{lang dateline}:</span><span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span>
										<span>&nbsp;{lang lastpost}: <!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}" c="1">$thread[lastposter]</a>&nbsp;/<!--{else}-->$_G[setting][anonymoustext]&nbsp;/<!--{/if}-->&nbsp;<a href="{if $thread[digest] != -2}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}">$thread[lastpost]</a></span>
										</p>
					<!--{/if}-->
				</th>
									<td class="flt">
									</td>
									<td class="flt">
									</td>
				<td class="by">
				<div class="xld" style="float: right"><dd class="m hm"><strong class="xi2">$thread[replies]</strong><span>{lang reply}</span></dd><dd class="m hm"><strong class="xi2"><!--{if $thread['isgroup'] != 1}-->$thread[views]<!--{else}-->$thread[views]<!--{/if}--></strong><span>{lang focus_show}</span></dd></div>
				</td>
			</tr>
		</tbody>
	<!--{/loop}-->
<!--{else}-->
	<tbody class="bw0_all"><tr><th><p class="emp">{lang guide_nothreads}</p></th></tr></tbody>
<!--{/if}-->