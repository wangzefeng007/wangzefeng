<?php exit;?>
<!--{template common/header}-->

<div id="ct" class="ct7_a wp cl">
	<!--{subtemplate common/stat}-->
	<div class="mn">
		<div class="bm bw0">
			<h1 class="mt">{lang stats_team}</h1>
			<!--{if $team['admins']}-->
				<div id="team_admins_c" class="umh">
					<h3 onclick="toggle_collapse('team_admins', 1, 1);">{lang stats_team_admins}</h3>
					<div class="umh_act">
						<p class="umh_cb" onclick="toggle_collapse('team_admins', 1, 1);">[ {lang open} ]</p>
					</div>
				</div>
				<table summary="{lang stats_team_admins}" id="team_admins" class="dt bm mbw">
					<tr>
						<th>{lang username}</th>
						<th>{lang admin_usergroup_title}</th>
						<th>{lang admin_status}</th>
						<th>{lang lastvisit}</th>
						<th>{lang stats_team_offdays}</th>
						<th>{lang credits}</th>
						<th>{lang posts}</th>
						<th width="50">{lang stats_posts_thismonth}</th>
						<!--{if $_G[setting][modworkstatus]}--><th width="30">{lang stats_modworks_thismonth}</th><!--{/if}-->
						<!--{if $_G[setting][oltimespan]}-->
							<th width="50">{lang onlinetime_total}({lang hours})</th>
							<th width="50">{lang onlinetime_thismonth}({lang hours})</th>
						<!--{/if}-->
					</tr>
					<!--{loop $team['admins'] $uid}-->
						<tr class="{echo swapclass('alt')}">
							<td><a target="_blank" href="home.php?mod=space&uid=$uid">$team[members][$uid][username]</a></td>
							<td>$team[members][$uid][grouptitle]</td>
							<td><!--{if $team['members'][$uid]['adminid'] == 1}-->{lang admin}<!--{elseif $team['members'][$uid]['adminid'] == 2}-->{lang supermod}<!--{elseif $team['members'][$uid]['adminid'] == 3}-->{lang moderator}<!--{/if}--></td>
							<td>$team[members][$uid][lastactivity]</td>
							<td>$team[members][$uid][offdays]</td>
							<td>$team[members][$uid][credits]</td>
							<td>$team[members][$uid][posts]</td>
							<td>$team[members][$uid][thismonthposts]</td>
							<!--{if $_G[setting][modworkstatus]}-->
								<td><a href="misc.php?mod=stat&op=modworks&uid=$uid">$team[members][$uid][modactions]</a></td>
							<!--{/if}-->
							<!--{if $_G[setting][oltimespan]}-->
								<td>$team[members][$uid][totalol]</td>
								<td>$team[members][$uid][thismonthol]</td>
							<!--{/if}-->
						</tr>
					<!--{/loop}-->
				</table>
			<!--{/if}-->

			<!--{loop $team['categories'] $category}-->
				<div id="category_$category[fid]_c" class="umh">
					<h3 onclick="toggle_collapse('category_$category[fid]', 1, 1);">$category[name]</h3>
					<div class="umh_act">
						<p class="umh_cb" onclick="toggle_collapse('category_$category[fid]', 1, 1);">[ {lang open} ]</p>
					</div>
				</div>
				<table id="category_$category[fid]" summary="$category[fid]" class="dt bm mbw">
					<tr>
						<th>{lang forum}</th>
						<th>{lang username}</th>
						<th>{lang admin_usergroup_title}</th>
						<th>{lang admin_status}</th>
						<th>{lang lastvisit}</th>
						<th>{lang stats_team_offdays}</th>
						<th>{lang credits}</th>
						<th>{lang posts}</th>
						<th width="50">{lang stats_posts_thismonth}</th>
						<th width="30">{lang stats_modworks_thismonth}</th>
						<!--{if $_G['setting']['oltimespan']}-->
							<th width="50">{lang onlinetime_total}({lang hours})</th>
							<th width="50">{lang onlinetime_thismonth}({lang hours})</th>
						<!--{/if}-->
					</tr>
					<!--{eval unset($swapc);}-->
					<!--{loop $team['forums'][$category['fid']] $fid $forum}-->
						<!--{loop $team['moderators'][$fid] $key $uid}-->
							<tr class="{echo swapclass('alt')}">
							<!--{if $key == 0}--><td rowspan="$forum[moderators]"><!--{if $forum[type] == 'group'}--><a href="forum.php?gid=$fid"><!--{else}--><a href="forum.php?mod=forumdisplay&fid=$fid"><!--{/if}-->$forum[name]</a></td><!--{/if}-->
							<td><a href="home.php?mod=space&uid=$uid"><!--{if $forum['inheritedmod']}--><b>$team[members][$uid][username]</b><!--{else}-->$team[members][$uid][username]<!--{/if}--></a></td>
							<td>$team[members][$uid][grouptitle]</td>
							<td><!--{if $team['members'][$uid]['adminid'] == 1}-->{lang admin}<!--{elseif $team['members'][$uid]['adminid'] == 2}-->{lang supermod}<!--{elseif $team['members'][$uid]['adminid'] == 3}-->{lang moderator}<!--{/if}--></td>
							<td>$team[members][$uid][lastactivity]</td>
							<td>$team[members][$uid][offdays]</td>
							<td>$team[members][$uid][credits]</td>
							<td>$team[members][$uid][posts]</td>
							<td>$team[members][$uid][thismonthposts]</td>
							<td><!--{if $_G['setting']['modworkstatus']}--><a href="misc.php?mod=stat&op=modworks&uid=$uid">$team[members][$uid][modactions]</a><!--{else}-->N/A<!--{/if}--></td>
							<!--{if $_G['setting']['oltimespan']}-->
								<td>$team[members][$uid][totalol]</td>
								<td>$team[members][$uid][thismonthol]</td>
							<!--{/if}-->
							</tr>
						<!--{/loop}-->
					<!--{/loop}-->
				</table>
			<!--{/loop}-->
			<div class="notice">{lang stats_update}</div>
		</div>
	</div>
</div>
<!--{template common/footer}-->