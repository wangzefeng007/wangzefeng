<?php exit;?>
<h1 class="mt cl">
	<img src="{STATICURL}image/feed/task.gif" alt="{lang task}" class="vm" /> {lang task_detail}
</h1>
<!--{if $task['endtime']}--><p class="xg2">{lang task_endtime}</p><!--{/if}-->
<div>
	<table cellpadding="0" cellspacing="0" class="tfm">
		<tr>
			<td width="80"><img src="$task[icon]" alt="Icon" width="64" height="64" /></td>
			<td class="bbda">
				<h1 class="xs2 ptm pbm">$task[name]</h1>
				<!--{if $task[period]}-->
					<div class="xg1">
					<!--{if $task[periodtype] == 0}-->
						( {lang task_period_hour} )
					<!--{elseif $task[periodtype] == 1}-->
						( {lang task_period_day} )
					<!--{elseif $task[periodtype] == 2}-->
						<!--{eval $periodweek = $_G['lang']['core']['weeks'][$task[period]];}-->
						( {lang task_period_week} )
					<!--{elseif $task[periodtype] == 3}-->
						( {lang task_period_month} )
					<!--{/if}-->
					</div>
				<!--{/if}-->
				<div>$task[description]</div>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<table cellpadding="0" cellspacing="0" class="tfm">
					<tr>
						<th class="bbda">{lang task_reward}</th>
						<td class="bbda xi1">
							<!--{if $task['reward'] == 'credit'}-->
								{lang credits} $_G['setting']['extcredits'][$task[prize]][title] $task[bonus] $_G['setting']['extcredits'][$task[prize]][unit]
							<!--{elseif $task['reward'] == 'magic'}-->
								{lang magics_title} $task[rewardtext] $task[bonus] {lang magics_unit}
							<!--{elseif $task['reward'] == 'medal'}-->
								{lang medals} $task[rewardtext] <!--{if $task['bonus']}-->{lang expire} $task[bonus] {lang days} <!--{/if}-->
							<!--{elseif $task['reward'] == 'invite'}-->
								{lang invite_code} $task[prize] {lang expire} $task[bonus] {lang days}
							<!--{elseif $task['reward'] == 'group'}-->
								{lang usergroup} $task[rewardtext] <!--{if $task['bonus']}--> $task[bonus] {lang days} <!--{/if}-->
							<!--{else}-->
								{lang nothing}
							<!--{/if}-->
						</td>
					</tr>
					<!--{if $task['viewmessage']}-->
					<tr>
						<th class="bbda">&nbsp;</th>
						<td class="bbda">$task[viewmessage]</td>
					</tr>
					<!--{else}-->
					<tr>
						<th class="bbda">{lang task_complete_condition}</th>
						<td class="bbda">
						<!--{if $taskvars['complete']}-->
							<ul>
								<!--{loop $taskvars['complete'] $taskvar}-->
									<li>$taskvar[name] : $taskvar[value]</li>
								<!--{/loop}-->
							</ul>
						<!--{else}-->
							<p>{lang unlimited}</p>
						<!--{/if}-->
						</td>
					<!--{/if}-->
					<tr>
						<th class="bbda">{lang task_apply_condition}</th>
						<td class="bbda">
							<!--{if $task[applyperm] || $task[relatedtaskid] || $task[tasklimits] || $taskvars['apply']}-->
								<ul>
									<li><!--{if $task[grouprequired]}-->{lang usergroup}: $task[grouprequired] <!--{elseif $task['applyperm'] == 'member'}-->{lang task_general_users}<!--{elseif $task['applyperm'] == 'admin'}-->{lang task_admins}<!--{/if}--></li>
									<!--{if $task[relatedtaskid]}--><li>{lang task_relatedtask}: <a href="home.php?mod=task&do=view&id=$task[relatedtaskid]">$_G['taskrequired']</a></li><!--{/if}-->
									<!--{if $task[tasklimits]}--><li>{lang task_numlimit}: $task[tasklimits]</li><!--{/if}-->
									<!--{if $taskvars['apply']}-->
										<!--{loop $taskvars['apply'] $taskvar}-->
											<li>$taskvar[name]: $taskvar[value]</li>
										<!--{/loop}-->
									<!--{/if}-->
								</ul>
							<!--{else}-->
								<p>{lang unlimited}</p>
							<!--{/if}-->
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<!--{if $allowapply == '-1'}-->
					<div class="pbg mtm mbm">
						<div class="pbr" style="width: {if $task[csc]}$task[csc]%{else}8px{/if};"></div>
						<div class="xs0">{lang task_complete} <span id="csc_$task[taskid]">$task[csc]</span>%</div>
					</div>
					<p class="mbw">
						<a href="home.php?mod=task&do=draw&id=$task[taskid]"><img src="{STATICURL}image/task/{if $task[csc] >=100}reward.gif{else}rewardless.gif{/if}" /></a>
						<!--{if $task[csc] < 100}--><a href="home.php?mod=task&do=delete&id=$task[taskid]"><img src="{STATICURL}image/task/cancel.gif" alt="{lang task_quit}" /></a><!--{/if}-->
					</p>
				<!--{elseif $allowapply == '-2'}-->
					<p class="xg2 mbn">{lang task_group_nopermission}</p>
					<a href="javascript:;" onclick="doane(event);showDialog('{lang task_group_nopermission}')"><img src="{STATICURL}image/task/disallow.gif" title="{lang task_group_nopermission}" alt="{lang task_group_nopermission}" /></a>
				<!--{elseif $allowapply == '-3'}-->
					<p class="xg2 mbn">{lang task_applies_full}</p>
					<a href="javascript:;" onclick="doane(event);showDialog('{lang task_applies_full}')"><img src="{STATICURL}image/task/disallow.gif" title="{lang task_applies_full}" alt="{lang task_applies_full}" /></a>
				<!--{elseif $allowapply == '-4'}-->
					<p class="xg2 mbn">{lang task_lose_on}$task[dateline]</p>
				<!--{elseif $allowapply == '-5'}-->
					<p class="xg2 mbn">{lang task_complete_on}$task[dateline]</p>
				<!--{elseif $allowapply == '-6'}-->
					<p class="xg2 mbn">{lang task_complete_on}$task[dateline] &nbsp; {$task[t]}{lang task_applyagain}</p>
					<a href="javascript:;" onclick="doane(event);showDialog('{$task[t]}{lang task_applyagain}')"><img src="{STATICURL}image/task/disallow.gif" title="{$task[t]}{lang task_applyagain}" alt="{lang task_applies_full}" /></a>
				<!--{elseif $allowapply == '-7'}-->
					<p class="xg2 mbn">{lang task_lose_on}$task[dateline] &nbsp; {$task[t]}{lang task_reapply}</p>
					<a href="javascript:;" onclick="doane(event);showDialog('{$task[t]}{lang task_reapply}')"><img src="{STATICURL}image/task/disallow.gif" title="{$task[t]}{lang task_reapply}" alt="{lang task_applies_full}" /></a>
				<!--{elseif $allowapply == '2'}-->
					<p class="xg2 mbn">{lang task_complete_on}$task[dateline] &nbsp; {lang task_applyagain_now}</p>
				<!--{elseif $allowapply == '3'}-->
					<p class="xg2 mbn">{lang task_lose_on}$task[dateline] &nbsp; {lang task_reapply_now}</p>
				<!--{/if}-->

				<!--{if $allowapply > '0'}-->
					<a href="home.php?mod=task&do=apply&id=$task[taskid]"><img src="{STATICURL}image/task/apply.gif" alt="{lang task_newbie_apply}" /></a>
				<!--{/if}-->
			</td>
		</tr>
		<!--{if $task[applicants]}-->
		<tr>
			<td>&nbsp;</td>
			<td>
				<a name="parter"></a>
				<div class="mtm">
					<h2 class="mbm">{lang task_applicants}</h2>
					<div id="ajaxparter"></div>
				</div>
				<script type="text/javascript">ajaxget('home.php?mod=task&do=parter&id=$task[taskid]', 'ajaxparter');</script>
			</td>
		</tr>
		<!--{/if}-->
	</table>
</div>