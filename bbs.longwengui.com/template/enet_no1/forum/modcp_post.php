<?php exit;?>
<div class="bm bw0 mdcp">
	<h1 class="mt">{lang mod_option_subject}</h1>
	<ul class="tb cl">
		<li><a href="{$cpscript}?mod=modcp&action=thread&op=thread{$forcefid}" hidefocus="true">{lang mod_option_subject_forum}</a></li>
		<li class="a"><a href="{$cpscript}?mod=modcp&action=thread&op=post{$forcefid}" hidefocus="true">{lang mod_option_subject_delete}</a></li>
		<li><a href="{$cpscript}?mod=modcp&action=recyclebin{$forcefid}" hidefocus="true">{lang mod_option_subject_recyclebin}</a></li>
		<li><a href="{$cpscript}?mod=modcp&action=recyclebinpost{$forcefid}" hidefocus="true">{lang mod_option_subject_recyclebinpost}</a></li>
	</ul>
	<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
	<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op">
		<input type="hidden" name="do" value="search">
		<input type="hidden" name="formhash" value="{FORMHASH}">
		<div class="exfm">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<th width="15%">{lang mod_option_selectforum}:</th>
					<td width="35%">
						<span class="ftid">
							<select name="fid" id="fid" class="ps" width="168">
								<option value="">{lang modcp_select_forum}</option>
								<!--{loop $modforums[list] $id $name}-->
								<option value="$id" {if $id == $_G[fid]}selected{/if}>$name</option>
								<!--{/loop}-->
							</select>
						</span>
					</td>
					<th width="15%">{lang modcp_posts_type}:</th>
					<td width="35%">
						<span class="ftid">
							<select name="threadoption" id="threadoption" class="ps" width="168">
								<option value="0" $threadoptionselect[0]>{lang all}</option>
								<option value="1" $threadoptionselect[1]>{lang modcp_posts_threadfirst}</option>
								<option value="2" $threadoptionselect[2]>{lang modcp_posts_threadreply}</option>
							</select>
						</span>
					</td>
				</tr>
				<tr>
					<th>{lang modcp_posts_author}:</th>
					<td><input type="text" name="users" class="px" size="20" value="$result[users]" style="width: 180px"/></td>
					<th>{lang modcp_posts_dateline_range}:</th>
					<td><input type="text" name="starttime" class="px" size="10" value="$result[starttime]" onclick="showcalendar(event, this)"/> {lang modcp_posts_to}
						<!--{if $_G['adminid'] == 1}-->
							<input type="text" name="endtime" class="px" size="10" value="$result[endtime]" onclick="showcalendar(event, this)"/>
						<!--{else}-->
							<input type="text" name="endtime" class="px" size="10" value="$result[endtime]" readonly="readonly" disabled="disabled" />
							<!--{if $_G['adminid'] == 2}-->
								<br />{lang modcp_posts_week_2}
							<!--{elseif $_G['adminid'] == 3}-->
								<br />{lang modcp_posts_week_1}
							<!--{/if}-->

						<!--{/if}-->
					 </td>
				</tr>
				<tr>
					<th>{lang modcp_posts_keyword}:</th>
					<td><input type="text" name="keywords" class="px" size="20" value="$result[keywords]" style="width: 180px"/></td>
					<th>{lang modcp_posts_ip}:</th>
					<td><input type="text" name="useip" class="px" value="$result[useip]" style="width: 180px" /></td>
				</tr>
				<!--{if $posttableselect}-->
				<tr>
					<th>{lang posttable_branch}</th>
					<td colspan="3"><span class="ftid">$posttableselect</span></td>
				</tr>
				<!--{/if}-->
				<tr>
					<td>&nbsp;</td>
					<td colspan="3">
						<button type="submit" name="searchsubmit" id="searchsubmit" class="pn" value="true"><strong>{lang submit}</strong></button>
					</td>
				</tr>
			</table>
		</div>
	</form>
	<!--{if $error == 1}-->
		<p class="xi1">{lang modcp_posts_error_1}</p>
	<!--{elseif $error == 2}-->
		<p class="xi1">{lang modcp_posts_error_2}</p>
	<!--{elseif $error == 3}-->
		<p class="xi1">{lang modcp_posts_error_3}</p>
	<!--{elseif $error == 4}-->
		<p class="xi1">{lang modcp_posts_error_4}</p>
	<!--{elseif $do=='list' && empty($error)}-->
		<h2 class="mtm mbm">{lang modcp_forum}: <a href="forum.php?mod=forumdisplay&fid=$_G[fid]" target="_blank" class="xi2">$_G['forum'][name]</a>, {lang modcp_posts_search}</h2>
		<!--{if $postlist}-->
		<div id="threadlist" class="tl">
			<form method="post" autocomplete="off" name="moderate" id="moderate" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="fid" value="$_G[fid]" />
			<input type="hidden" name="do" value="delete" />
			<input type="hidden" name="posttableid" value="$posttableid" />
			<table cellspacing="0" cellpadding="0">
				<tr class="th">
					<!--{if $_G['group']['allowmassprune']}--><td width="40">&nbsp;</td><!--{/if}-->
					<th>&nbsp;</th>
					<td class="frm">{lang forum}</td>
					<td class="by">{lang author}</td>
				</tr>
				<!--{loop $postlist $post}-->
					<tr>
						<!--{if $_G['group']['allowmassprune']}--><td><input type="checkbox" name="delete[]" class="pc" value="$post[pid]" /></td><!--{/if}-->
						<th>
							{lang modcp_posts_thread}: &nbsp;<a target="_blank" href="forum.php?mod=redirect&goto=findpost&pid=$post[pid]&ptid=$post[tid]{if $post[invisible] == -2}&modthreadkey=$post[modthreadkey]{/if}">$post[tsubject]</a><br />
							<span class="xg1">$post[message]</span>
						</th>
						<td class="frm">
							<a href="forum.php?mod=forumdisplay&fid=$post[fid]">$post['forum']</a>
						</td>
						<td class="by">
							<cite>
							<!--{if $post['authorid'] && $post['author']}-->
								<a href="home.php?mod=space&uid=$post[authorid]" target="_blank">$post[author]</a>
							<!--{else}-->
								<a href="home.php?mod=space&uid=$post[authorid]" target="_blank">{lang anonymous}</a>
							<!--{/if}-->
							</cite>
							<em>$post[dateline]</em>
						</td>
					</tr>
				<!--{/loop}-->

					<tr class="bw0_all">
						<td colspan="{if $_G['group']['allowmassprune']}4{else}3{/if}" class="ptm">
							<!--{if $multipage}-->$multipage<!--{/if}-->
							<!--{if $postlist && $_G['group']['allowmassprune']}-->
								<label for="chkall"><input type="checkbox" name="chkall" id="chkall" class="pc" onclick="checkall(this.form, 'delete')" />{lang delete_check}</label>
								<button type="submit" name="deletesubmit" id="deletesubmit" class="pn" value="true"><strong>{lang delete}</strong></button>
								<label for="nocredit"><input type="checkbox" name="nocredit" id="nocredit" class="pc" value="1" checked="checked" />{lang modcp_posts_member_credits}</label>
							<!--{/if}-->
						</td>
					</tr>
				</table>
			</form>
		</div>
		<!--{/if}-->
	<!--{/if}-->
</div>
<script type="text/javascript" reload="1">
	simulateSelect('fid');
	simulateSelect('threadoption');
	simulateSelect('posttableid');
</script>