<?php exit;?>
<script type="text/javascript" src="{$_G[setting][jspath]}forum_moderate.js?{VERHASH}"></script>
<div class="bm bw0 mdcp">
	<h1 class="mt">{lang mod_option_subject}</h1>
	<ul class="tb cl">
		<li><a href="{$cpscript}?mod=modcp&action=thread&op=thread{$forcefid}" hidefocus="true">{lang mod_option_subject_forum}</a></li>
		<li><a href="{$cpscript}?mod=modcp&action=thread&op=post{$forcefid}" hidefocus="true">{lang mod_option_subject_delete}</a></li>
		<li class="a"><a href="{$cpscript}?mod=modcp&action=recyclebin{$forcefid}" hidefocus="true">{lang mod_option_subject_recyclebin}</a></li>
		<li><a href="{$cpscript}?mod=modcp&action=recyclebinpost{$forcefid}" hidefocus="true">{lang mod_option_subject_recyclebinpost}</a></li>
	</ul>
	<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
	<div class="datalist">
		<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=search">
			<input type="hidden" name="formhash" value="{FORMHASH}">
			<div class="exfm">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<th width="15%">{lang mod_option_selectforum}:</th>
						<td width="35%">
							<span class="ftid">
								<select name="fid" id="fid" class="ps" width="168" change="getthreadclass();">
									<option value="">{lang modcp_select_forum}</option>
									<!--{loop $modforums[list] $id $name}-->
										<!--{if $modforums['recyclebins'][$id]}-->
											<option value="$id" {if $id == $_G[fid]}selected{/if}>$name</option>
										<!--{/if}-->
									<!--{/loop}-->
								</select>
							</span>
						</td>
						<th width="15%">{lang modcp_posts_type}:</th>
						<td width="35%">
							<span class="ftid">
								<select name="threadoption" id="threadoption" class="ps" width="168">
									<option value="0" $threadoptionselect[0]>{lang all}</option>
									<option value="1" $threadoptionselect[1]>{lang thread_poll}</option>
									<option value="2" $threadoptionselect[2]>{lang thread_trade}</option>
									<option value="3" $threadoptionselect[3]>{lang thread_reward}</option>
									<option value="4" $threadoptionselect[4]>{lang thread_activity}</option>
									<option value="5" $threadoptionselect[5]>{lang thread_debate}</option>
									<option value="999" $threadoptionselect[999]>{lang thread_digest}</option>
									<option value="888" $threadoptionselect[888]>{lang thread_stick}</option>
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<th>{lang modcp_posts_author}:</th>
						<td><input type="text" name="users" class="px" size="20" value="$result[users]" style="width: 180px"/></td>
						<th>{lang modcp_dateline_range}:</th>
						<td><input type="text" name="starttime" class="px" size="10" value="$result[starttime]" onclick="showcalendar(event, this);" /> {lang modcp_posts_to} <input type="text" name="endtime" class="px" size="10" value="$result[endtime]" onclick="showcalendar(event, this);" /></td>
					</tr>
					<tr>
						<th>{lang modcp_subject_keyword}:</th>
						<td><input type="text" name="keywords" class="px" size="20" value="$result[keywords]" style="width: 180px"/></td>
						<th>{lang modcp_views_range}:</th>
						<td><input type="text" name="viewsmore" class="px" size="10" value="$result[viewsmore]" /> {lang modcp_posts_to} <input type="text" name="viewsless" class="px" size="10" value="$result[viewsless]" /></td>
					</tr>
					<tr>
						<th>{lang modcp_no_reply_range}:</th>
						<td><input type="text" name="noreplydays" class="px" size="20" value="$result[noreplydays]" style="width: 180px"/></td>
						<th>{lang modcp_reply_range}:</th>
						<td><input type="text" name="repliesmore" class="px" size="10" value="$result[repliesmore]" /> {lang modcp_posts_to} <input type="text" name="repliesless" class="px" size="10" value="$result[repliesless]" /></td>
					</tr>
					<tr>
						<th width="15%">{lang mod_option_selectthreadclass}:</th>
						<td width="35%">
							<span class="ftid" id="threadclass">
								<select name="typeid" id="typeid" width="168" class="ps">
								<!--{if $threadclasslist}-->
									<option value="">{lang modcp_select_threadclass}</option>
								<!--{loop $threadclasslist $threadclass}-->
									<option value="$threadclass[typeid]" {if $_GET['typeid'] == $threadclass[typeid]}selected{/if}>$threadclass[name]</option>
								<!--{/loop}-->
								<!--{else}-->
									<option value="">{lang none}</option>
								<!--{/if}-->
								</select>
							</span>
						</td>
						<th></th><td></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td colspan="3">
							<button type="submit" name="searchsubmit" id="searchsubmit" class="pn" value="true"><strong>{lang submit}</strong></button>
						</td>
					</tr>
				</table>
			</div>
		</form>
	</div>

	<!--{if $_G[fid]}-->
		<h2 class="mtm mbm">{lang modcp_forum}: <a href="forum.php?mod=forumdisplay&fid=$_G[fid]" target="_blank" class="xi2">$_G['forum'][name]</a></h2>
		<!--{if $postlist}-->
		<div id="threadlist" class="tl">
			<form method="post" autocomplete="off" name="moderate" id="moderate" action="$cpscript?mod=modcp&fid=$_G[fid]&action=$_GET[action]">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="op" value="" />
				<input type="hidden" name="oldop" value="$op" />
				<input type="hidden" name="dosubmit" value="submit" />
				<table cellspacing="0" cellpadding="0">
					<tr class="th">
						<td class="icn">&nbsp;</td>
						<td class="o">&nbsp;</td>
						<td>&nbsp;</td>
						<td class="by">{lang author}</td>
						<td class="num">{lang replies}</td>
						<td class="by">{lang lastpost}</td>
						<td class="by">{lang reason}</td>
					</tr>
					<!--{loop $postlist $thread}-->
						<tbody id="$thread[id]">
							<tr>
								<td class="icn">
									<!--{if $thread['special'] == 1}-->
										<img src="{IMGDIR}/pollsmall.gif" alt="{lang thread_poll}" />
									<!--{elseif $thread['special'] == 2}-->
										<img src="{IMGDIR}/tradesmall.gif" alt="{lang thread_trade}" />
									<!--{elseif $thread['special'] == 3}-->
										<img src="{IMGDIR}/rewardsmall.gif" alt="{lang thread_reward}" {if $thread['price'] < 0}class="solved"{/if} />
									<!--{elseif $thread['special'] == 4}-->
										<img src="{IMGDIR}/activitysmall.gif" alt="{lang thread_activity}" />
									<!--{elseif $thread['special'] == 5}-->
										<img src="{IMGDIR}/debatesmall.gif" alt="{lang thread_debate}" />
									<!--{else}-->
										<img src="{IMGDIR}/folder_$thread[folder].gif" />
									<!--{/if}-->
								</td>
								<td class="o"><input class="pc" type="checkbox" name="moderate[]" value="$thread[tid]" /></td>
								<th class="$thread[folder]">
									<span id="thread_$thread[tid]"><a href="forum.php?mod=viewthread&tid=$thread[tid]&modthreadkey=$thread[modthreadkey]" target="_blank" $thread['highlight']>$thread[subject]</a></span>
									<!--{if $thread['readperm']}--> - [{lang readperm} <span class="xw1">$thread[readperm]</span>]<!--{/if}-->
									<!--{if $thread['price'] > 0}-->
										<!--{if $thread['special'] == '3'}-->
											- <span style="color: #C60">[{lang thread_reward} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][title]}]</span>
										<!--{else}-->
											- [{lang price} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][title]}]
										<!--{/if}-->
									<!--{elseif $thread['special'] == '3' && $thread['price'] < 0}-->
											- <span style="color: #269F11">[{lang reward_solved}]</span>
									<!--{/if}-->

									<!--{if $thread['displayorder'] == 1}-->
										- <span style="color: #C60">{lang modcp_threadstick_1}</span>
									<!--{elseif $thread['displayorder'] == 2}-->
										- <span style="color: #C60">{lang modcp_threadstick_2}</span>
									<!--{elseif $thread['displayorder'] == 3}-->
										- <span style="color: #C60">{lang modcp_threadstick_3}</span>
									<!--{/if}-->

									<!--{if $thread['attachment'] == 2}-->
											<img src="{STATICURL}image/filetype/image_s.gif" alt="{lang attach_img}" align="absmiddle" />
									<!--{elseif $thread['attachment'] == 1}-->
											<img src="{STATICURL}image/filetype/common.gif" alt="{lang attachment}" align="absmiddle" />
									<!--{/if}-->
								</th>
								<td class="by">
									<cite>
										<!--{if $thread['authorid'] && $thread['author']}-->
											<a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">$thread[author]</a>
										<!--{else}-->
											<a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">{lang anonymous}</a>
										<!--{/if}-->
									</cite>
									<em>$thread[dateline]</em>
								</td>
								<td class="num"><strong>$thread[replies]</strong><em>$thread[views]</em></td>
								<td class="by">
									<cite><!--{if $thread['lastposter']}--><a target="_blank" href="home.php?mod=space&username=$thread[lastposterenc]">$thread[lastposter]</a><!--{else}-->{lang anonymous}<!--{/if}--></cite>
									<em><a target="_blank" href="forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost">$thread[lastpost]</a></em>
								</td>
								<td class="by">$thread[reason]</td>
							</tr>
						</tbody>
					<!--{/loop}-->
					<tbody>
						<tr class="bw0_all">
							<td>&nbsp;</td>
							<td><input class="pc" type="checkbox" onclick="checkall(this.form, 'moderate')" name="chkall" id="chkall"/></td>
							<td colspan="5" class="ptm">
								<!--{if $multipage}-->$multipage<!--{/if}-->
								<!--{if $_G['group']['allowclearrecycle']}-->
								<button onclick="modthreads('delete')" class="pn"><strong>{lang delete}</strong></button>
								<!--{/if}-->
								<button onclick="modthreads('restore')" class="pn"><strong>{lang modcp_restore}</strong></button>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<!--{/if}-->
		<!--{if !$total}-->
			<p class="emp">{lang modcp_thread_msg}</p>
		<!--{/if}-->
		<script type="text/javascript">
			function modthreads(operation) {
				document.moderate.op.value = operation;
				document.moderate.submit();
			}
		</script>

	<!--{else}-->
		<p class="xi1">{lang modcp_forum_select_msg}</p>
	<!--{/if}-->
</div>
<script type="text/javascript" reload="1">
	simulateSelect('fid');
	simulateSelect('typeid');
	simulateSelect('threadoption');
</script>