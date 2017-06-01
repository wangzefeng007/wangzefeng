<?php exit;?>
<h1 class="mt">
	<img src="{STATICURL}image/feed/task.gif" alt="{lang task}" class="vm" />
	<!--{if $_GET['item'] == "doing"}-->{lang task_doing}
	<!--{elseif $_GET['item'] == "done"}-->{lang task_done}
	<!--{elseif $_GET['item'] == "failed"}-->{lang task_failed}
	<!--{else}-->{lang task_new}<!--{/if}-->
</h1>
<div class="ptm">
	<!--{if $tasklist}-->
		<table cellspacing="0" cellpadding="0" width="100%">
			<!--{loop $tasklist $task}-->
				<tr>
					<td width="80" class="bbda"><img src="$task[icon]" width="64" height="64" alt="$task[name]" /></td>
					<td class="bbda ptm pbm">
						<h3 class="xs2 xi2"><a href="home.php?mod=task&do=view&id=$task[taskid]">$task[name]</a> <span class="xs1 xg2 xw0">({lang task_applies}: <a href="home.php?mod=task&do=view&id=$task[taskid]#parter">$task[applicants]</a> )</span></h3>
						<p class="xg2">$task[description]</p>
						<!--{if $_GET['item'] == 'doing'}-->
						<div class="pbg mtm mbm">
							<div class="pbr" style="width: {if $task[csc]}$task[csc]%{else}8px{/if};"></div>
							<div class="xs0">{lang task_complete} <span id="csc_$task[taskid]">$task[csc]</span>%</div>
						</div>
						<!--{/if}-->
					</td>
					<td class="xi1 bbda hm" width="200">
						<!--{if $task['reward'] == 'credit'}-->
							{lang credits} $_G['setting']['extcredits'][$task[prize]][title] $task[bonus] $_G['setting']['extcredits'][$task[prize]][unit]
						<!--{elseif $task['reward'] == 'magic'}-->
							{lang magics_title} $listdata[$task[prize]] $task[bonus] {lang magics_unit}
						<!--{elseif $task['reward'] == 'medal'}-->
							{lang medals} $listdata[$task[prize]] <!--{if $task['bonus']}-->{lang expire} $task[bonus] {lang days} <!--{/if}-->
						<!--{elseif $task['reward'] == 'invite'}-->
							{lang invite_code} $task[prize] {lang expire} $task[bonus] {lang days}
						<!--{elseif $task['reward'] == 'group'}-->
							{lang usergroup} $listdata[$task[prize]] <!--{if $task['bonus']}--> $task[bonus] {lang days} <!--{/if}-->
						<!--{/if}-->
					</td>
					<td width="120" class="bbda">
						<!--{if $_GET['item'] == 'new'}-->
							<!--{if $task['noperm']}-->
								<a href="javascript:;" onclick="doane(event);showDialog('{lang task_group_nopermission}')"><img src="{STATICURL}image/task/disallow.gif" title="{lang task_group_nopermission}" alt="disallow" /></a>
							<!--{elseif $task['appliesfull']}-->
								<a href="javascript:;" onclick="doane(event);showDialog('{lang task_applies_full}')"><img src="{STATICURL}image/task/disallow.gif" title="{lang task_applies_full}" alt="disallow" /></a>
							<!--{else}-->
								<a href="home.php?mod=task&do=apply&id=$task[taskid]"><img src="{STATICURL}image/task/apply.gif" alt="apply" /></a>
							<!--{/if}-->
						<!--{elseif $_GET['item'] == 'doing'}-->
							<p><a href="home.php?mod=task&do=draw&id=$task[taskid]"><img src="{STATICURL}image/task/{if $task[csc] >=100}reward.gif{else}rewardless.gif{/if}"  alt="" /></a></p>
						<!--{elseif $_GET['item'] == 'done'}-->
							<p style="white-space:nowrap">{lang task_complete_on} $task[dateline]
							<!--{if $task['period'] && $task[t]}--><br /><!--{if $task[allowapply]}--><a href="home.php?mod=task&do=apply&id=$task[taskid]">{lang task_applyagain_now}</a><!--{else}-->{$task[t]}{lang task_applyagain}<!--{/if}--><!--{/if}--></p>
						<!--{elseif $_GET['item'] == 'failed'}-->
							<p style="white-space:nowrap">{lang task_lose_on} $task[dateline]
							<!--{if $task['period'] && $task[t]}--><br /><!--{if $task[allowapply]}--><a href="home.php?mod=task&do=apply&id=$task[taskid]">{lang task_applyagain_now}</a><!--{else}-->{$task[t]}{lang task_reapply}<!--{/if}--><!--{/if}--></p>
						<!--{/if}-->
					</td>
				</tr>
			<!--{/loop}-->
		</table>
	<!--{else}-->
		<p class="emp"><!--{if $_GET['item'] == 'new'}-->{lang task_nonew}<!--{elseif $_GET['item'] == 'doing'}-->{lang task_nodoing}<!--{else}-->{lang data_nonexistence}<!--{/if}--></p>
	<!--{/if}-->
</div>