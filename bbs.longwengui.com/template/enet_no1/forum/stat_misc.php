<?php exit;?>
<!--{template common/header}-->

<div id="ct" class="ct7_a wp cl">
	<!--{subtemplate common/stat}-->
	<div class="mn">
		<!--{if $op == 'views'}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_views}</h1>
				<table summary="{lang stats_week}" class="dt bm">
					<caption><h2 class="mbn">{lang stats_week}</h2></caption>
					$statsbar_week
				</table>

				<table summary="{lang stats_hour}" class="dt bm">
					<caption><h2 class="mbn">{lang stats_hour}</h2></caption>
					$statsbar_hour
				</table>
			</div>
		<!--{elseif $op == 'agent'}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_agent}</h1>
				<table summary="{lang stats_agent}" class="dt bm">
					<caption><h2 class="mbn">{lang stats_os}</h2></caption>
					$statsbar_os
				</table>

				<table summary="{lang stats_browser}" class="dt bm">
					<caption><h2 class="mbn">{lang stats_browser}</h2></caption>
					$statsbar_browser
				</table>
			</div>
		<!--{elseif $op == 'posts'}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_posthist}</h1>
				<table summary="{lang stats_month_posts}" class="dt bm">
					<caption><h2 class="mbn">{lang stats_month_posts}</h2></caption>
					$statsbar_monthposts
				</table>

				<table summary="{lang stats_day_posts}" class="dt bm">
					<caption><h2 class="mbn">{lang stats_day_posts}</h2></caption>
					$statsbar_dayposts
				</table>
		<!--{elseif $op == 'forumstat' && !$_GET['fid']}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_forums_stat}</h1>
				<table summary="{lang stats_forum_stat}" class="dt bm">
					<tr>
						<th class="xw1">{lang stats_forums_forumname}</td>
						<th class="xw1">{lang stats_main_posts_count}</td>
					</tr>
					<!--{loop $forums $forum}-->
						<tr class="{echo swapclass('alt')}">
							<td><a href="misc.php?mod=stat&op=forumstat&fid={$forum['fid']}">$forum['name']</a><!--{if $forum['type'] == 'sub'}--><span class="xg1"> ({lang stats_forums_sub})</span><!--{/if}--></td>
							<td>$forum['posts']</td>
						</tr>
					<!--{/loop}-->
				</table>
			</div>
		<!--{elseif $op == 'forumstat' && $_GET['fid']}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_forum_stat_log} - $foruminfo[name] - $month</h1>
				<script type="text/javascript">
					document.write(AC_FL_RunContent(
						'width', '100%', 'height', '300',
						'src', '{STATICURL}image/common/stat.swf?$statuspara',
						'quality', 'high'
					));
				</script>
				<!--{if $logs}-->
				<table summary="{lang stats_forum_stat_log}" class="dt bm mtw mbw">
					<tr>
						<th width="100">{lang stats_date}</th>
						<th>{lang stats_main_total_posted}</th>
					</tr>
					<!--{loop $logs $log}-->
					<tr>
						<td>$log['logdate']</td>
						<td>$log['value']</td>
					</tr>
					<!--{/loop}-->
				</table>
				<!--{/if}-->

				<table class="dt bm">
					<caption><h2 class="mbn">{lang stats_history} - $foruminfo[name]</h2></caption>
					<tr>
						<th width="100">{lang stats_forums_month}</th>
						<th>{lang stats_main_total_posted}</th>
					</tr>
					<!--{loop $monthlist $month}-->
						<tr>
							<td><a href="misc.php?mod=stat&op=forumstat&fid={$_GET['fid']}&month=$month">$month</a></td>
							<td>$monthposts[$month]</td>
						</tr>
					<!--{/loop}-->
				</table>
			</div>
		<!--{elseif $op == 'modworks' && $uid}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_modworks} - $username</h1>
				<h3>$username {lang stats_modworks_in} {$starttime} {lang stats_modworks_to} {$endtime} {lang stats_modworks_data} &nbsp; <a href="misc.php?mod=stat&op=modworks&exportexcel=1&uid=$uid&modworks_starttime=$starttime&modworks_endtime=$endtime" class="xi2">[{lang stats_modworks_export}]</a></h3>
				<ul class="ttp cl">
					<!--{loop $monthlinks $link}-->
					$link
					<!--{/loop}-->
					<li>
						<script src="{$_G[setting][jspath]}calendar.js?{VERHASH}" type="text/javascript"></script>
						<form action="misc.php?mod=stat&op=modworks&uid=$uid" method="post">
							<input type="hidden" name="formhash" value="{FORMHASH}" />
							{lang stats_modworks_timerange}: <input type="text" name="modworks_starttime" class="px vm" size="10" onclick="showcalendar(event, this, false)" autocomplete="off" /> {lang stats_modworks_to} <input type="text" name="modworks_endtime" class="px vm" size="10" onclick="showcalendar(event, this, false)" autocomplete="off" />
							<button type="submit" class="pn vm" name="modworkssubmit" value="true"><em>{lang focus_show}</em></button></td>
						</form>
					</li>
				</ul>
				<div class="cl">
					<div class="stl">
						<table class="dt bm">
							<tr>
								<th>{lang time}</th>
							</tr>
							<!--{loop $modactions $day $modaction}-->
								<tr class="{echo swapclass('alt')}">
									<td>$day</td>
								</tr>
							<!--{/loop}-->
							<tr>
								<td>{lang stats_modworks_total}</td>
							</tr>
						</table>
					</div>
					<div class="str">
						<table class="dt" style="width: 3000px;">
							<tr>
								<!--{loop $modactioncode $key $val}--><th width="$tdwidth">$val</th><!--{/loop}-->
								<th width="$tdwidth">{lang stats_modworks_total}</th>
							</tr>
							<!--{eval unset($swapc);}-->
							<!--{loop $modactions $day $modaction}-->
								<tr class="{echo swapclass('alt')}">
									<!--{loop $modactioncode $key $val}-->
										<!--{if $modaction[$key]['posts']}--><td title="{lang posts}: $modaction[$key][posts]">$modaction[$key][count]<!--{else}--><td>&nbsp;<!--{/if}--></td>
									<!--{/loop}-->
									<td>$modaction[total]</td>
								</tr>
							<!--{/loop}-->
							<tr>
								<!--{loop $modactioncode $key $val}-->
									<!--{if $totalactions[$key]['posts']}--><td class="{$bgarray[$key]}" title="{lang posts}: {$totalactions[$key][posts]}">$totalactions[$key][count]<!--{else}--><td>&nbsp;<!--{/if}--></td>
								<!--{/loop}-->
								<td>$totalactions[total]</td>
							</tr>
						</table>
					</div>
				</div>
			</div>

		<!--{elseif $op == 'modworks'}-->
			<div class="bm bw0">
				<h1 class="mt">{lang stats_modworks} - {lang stats_modworks_all}</h1>
				<h3>{$starttime} {lang stats_modworks_to} {$endtime} {lang stats_modworks_data} &nbsp; <a href="misc.php?mod=stat&op=modworks&exportexcel=1&modworks_starttime=$starttime&modworks_endtime=$endtime" class="xi2">[{lang stats_modworks_export}]</a></h3>
				<ul class="ttp cl">
					<!--{loop $monthlinks $link}-->
					$link
					<!--{/loop}-->
					<li>
						<script src="{$_G[setting][jspath]}calendar.js?{VERHASH}" type="text/javascript"></script>
						<form action="misc.php?mod=stat&op=modworks" method="post">
							<input type="hidden" name="formhash" value="{FORMHASH}" />
							{lang stats_modworks_timerange}: <input type="text" name="modworks_starttime" class="px vm" size="10" onclick="showcalendar(event, this, false)" autocomplete="off" /> {lang stats_modworks_to} <input type="text" name="modworks_endtime" class="px vm" size="10" onclick="showcalendar(event, this, false)" autocomplete="off" />
							<button type="submit" class="pn vm" name="modworkssubmit" value="true"><em>{lang focus_show}</em></button></td>
						</form>
					</li>
				</ul>
				<div class="cl">
					<div class="stl">
						<table class="dt bm">
							<tr>
								<th>{lang username}</th>
							</tr>
							<!--{loop $members $uid $member}-->
								<tr class="{echo swapclass('alt')}">
									<td><a href="misc.php?mod=stat&op=modworks{if isset($_GET[before])}&before=$_GET[before]{/if}&uid=$uid{if $starttime || $endtime}&modworks_starttime=$starttime&modworks_endtime=$endtime{/if}" title="{lang stats_modworks_details}">{$member[username]}</a></td>
								</tr>
							<!--{/loop}-->
							<!--{if $members}-->
								<tr>
									<td>{lang stats_modworks_total}</td>
								</tr>
							<!--{/if}-->
						</table>
					</div>

					<div class="str">
						<table class="dt" style="width: 3000px;">
							<tr>
								<!--{loop $modactioncode $key $val}--><th width="$tdwidth">$val</th><!--{/loop}-->
								<th width="$tdwidth">{lang stats_modworks_total}</th>
							</tr>
							<!--{eval unset($swapc);}-->
							<!--{loop $members $uid $member}-->
								<tr class="{echo swapclass('alt')}">
									<!--{loop $modactioncode $key $val}-->
										<!--{if $member[$key]['posts']}--><td title="{lang posts}: {$member[$key]['posts']}">{$member[$key][count]}<!--{else}--><td>&nbsp;<!--{/if}--></td>
									<!--{/loop}-->
									<td>$member[total]</td>
								</tr>
							<!--{/loop}-->
							<!--{if $members}-->
								<tr>
									<!--{loop $modactioncode $key $val}-->
										<!--{if $total[$key]['posts']}--><td title="{lang posts}: {$total[$key]['posts']}">{$total[$key][count]}<!--{else}--><td>&nbsp;<!--{/if}--></td>
									<!--{/loop}-->
									<td>$total[total]</td>
								</tr>
							<!--{/if}-->
						</table>
					</div>
				</div>
			</div>
		<!--{/if}-->

	</div>
</div>

<!--{template common/footer}-->