<?php exit;?>
<!--{eval
	$_G[home_tpl_spacemenus][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=activity&view=me\">{lang they_activity}</a>";
}-->
<!--{template common/header}-->
<!--{eval 
	$weekarr = array(0 => '{lang day}', 1 => '{lang one}', 2 => '{lang two}', 3 => '{lang three}', 4 => '{lang four}', 5 => '{lang five}', 6 => '{lang six}');
}-->
<style id="diy_style" type="text/css"></style>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>
<div id="ct" class="ct7_a wp cl">
	<div class="apps">
		<!--{subtemplate home/space_thread_nav}-->

		<div class="drag">
			<!--[diy=diy2]--><div id="diy2" class="area"></div><!--[/diy]-->
		</div>
	</div>
	<div class="mn">
		<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
		<div class="bm bw0">
		<!--{if (!$_G['uid'] && !$space[uid]) || $space[self]}-->
			<h1 class="mt"><img alt="activity" src="{IMGDIR}/activitysmall.gif" class="vm" /> {lang activity}</h1>
		<!--{/if}-->
		<!--{if $space[self]}-->
			<ul class="tb cl">
				<li$actives[we]><a href="home.php?mod=space&do=activity&view=we">{lang friend_activity}</a></li>
				<li$actives[me]><a href="home.php?mod=space&do=activity&view=me">{lang my_activity}</a></li>
				<!--{if $_G[group][allowpostactivity]}-->
					<li class="o">
						<!--{if $_G[setting][activityforumid]}-->
						<a href="forum.php?mod=post&action=newthread&fid=$_G[setting][activityforumid]&special=4">{lang create_new_activity}</a>
						<!--{else}-->
						<a href="forum.php?mod=misc&action=nav&special=4" onclick="showWindow('nav', this.href)">{lang create_new_activity}</a>
						<!--{/if}-->
					</li>
				<!--{/if}-->
			</ul>
		<!--{else}-->
			<!--{template home/space_menu}-->
		<!--{/if}-->

		<!--{if $_GET[view] == 'me'}-->
			<div class="tbmu">
				<a href="home.php?mod=space&do=activity&view=me" $orderactives[orig]>{lang my_create_activity}</a><span class="pipe">|</span>
				<a href="home.php?mod=space&do=activity&view=me&type=apply" $orderactives[apply]>{lang my_join_activity}</a>
			</div>
		<!--{/if}-->

		<!--{if $userlist}-->
			<p class="tbmu">
				{lang filter_by_friend}
				<select name="fuidsel" onchange="fuidgoto(this.value);" style="font-size:12px">
					<option value="">{lang all_friends}</option>
					<!--{loop $userlist $value}-->
					<option value="$value[fuid]"{$fuid_actives[$value[fuid]]}>$value[fusername]</option>
					<!--{/loop}-->
				</select>
			</p>
		<!--{/if}-->
		<!--{if $list}-->
			<!--{loop $list $key $activitylist}-->
			<!--{eval $caption = true;}-->
			<table cellpadding="0" cellspacing="0" class="acl mbm">
				<!--{loop $activitylist $tid $thread}-->
				<!--{if $caption}-->
				<caption>
					<h3 class="cl">
						<span><strong>$thread[month]</strong><em>$thread[day]</em></span>
						$thread[time]<br />
						<cite class="xs1">{lang week}$weekarr[$thread[week]]<cite>
					</h3>
				</caption>
				<!--{eval $caption = false;}-->
				<!--{/if}-->
				<tr>
					<td class="type"><!--{if $thread[aid]}--><img src="{echo getforumimg($thread[aid])}" alt="$thread[subject]" width="80" /><!--{else}--><img src="{IMGDIR}/nophotosmall.gif" alt="nophoto" width="80" height="80" /><!--{/if}--></td>
					<td>
						<h4><a href="forum.php?mod=viewthread&tid=$thread[tid]" target="_blank">$thread[subject]</a></h4>
						<p>$thread[message]</p>
					</td>
					<td class="addr">
						<strong>$thread[class]</strong><br />
						$thread[place]<br />
						<strong>{lang have} <em class="xi1">$thread[applynumber]</em> {lang join_num}</strong><br />
						$thread[replies] {lang some_message}
					</td>
					<td class="orgr">
						<ul class="ml mls cl">
							<li>
								<a href="home.php?mod=space&uid=$thread[authorid]" class="avt" c="1" target="_blank"><!--{avatar($thread[authorid],small)}--></a>
								<p><a title="$thread[author]" href="home.php?mod=space&uid=$thread[authorid]" target="_blank">$thread[author]</a></p>
							</li>
						</ul>
					</td>
				</tr>
				<!--{/loop}-->
			</table>
			<!--{/loop}-->
			<!--{if $hiddennum}-->
			<p class="mtm">{lang hide_activity}</p>
			<!--{/if}-->
			<!--{if $multi}--><div class="pgs cl">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp">{lang no_activity}</div>
		<!--{/if}-->
		</div>
		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->
	</div>
</div>
<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<script type="text/javascript">
function fuidgoto(fuid) {
	var parameter = fuid != '' ? '&fuid='+fuid : '';
	window.location.href = 'home.php?mod=space&do=activity&view=we'+parameter;
}
</script>

<!--{template common/footer}-->