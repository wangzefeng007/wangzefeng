<?php exit;?>
<!--{eval
	$_G[home_tpl_spacemenus][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=debate&view=me\">{lang they_debate}</a>";
}-->
<!--{template common/header}-->

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
			<h1 class="mt"><img alt="debate" src="{IMGDIR}/debatesmall.gif" class="vm" /> {lang debate}</h1>
		<!--{/if}-->
		<!--{if $space[self]}-->
			<ul class="tb cl">
				<li$actives[we]><a href="home.php?mod=space&do=debate&view=we">{lang friend_debate}</a></li>
				<li$actives[me]><a href="home.php?mod=space&do=debate&view=me">{lang my_debate}</a></li>
				<!--{if $_G[group][allowpostdebate]}-->
					<li class="o">
						<!--{if $_G[setting][debateforumid]}-->
						<a href="forum.php?mod=post&action=newthread&fid=$_G[setting][debateforumid]&special=5">{lang create_new_debate}</a>
						<!--{else}-->
						<a href="forum.php?mod=misc&action=nav&special=5" onclick="showWindow('nav', this.href)">{lang create_new_debate}</a>
						<!--{/if}-->
					</li>
				<!--{/if}-->
			</ul>
		<!--{else}-->
			<!--{template home/space_menu}-->
		<!--{/if}-->

		<!--{if $_GET[view] == 'me'}-->
			<p class="tbmu">
				<a href="home.php?mod=space&do=debate&view=me"$typeactives[orig]>{lang my_create_debate}</a><span class="pipe">|</span>
				<a href="home.php?mod=space&do=debate&view=me&type=reply"$typeactives[reply]>{lang my_join_debate}</a>
			</p>
		<!--{/if}-->

		<!--{if $userlist}-->
			<p class="tbmu">
				{lang view_by_friend}
				<select name="fuidsel" onchange="fuidgoto(this.value);" class="ps" style="font-size:12px">
					<option value="">{lang all_friends}</option>
					<!--{loop $userlist $value}-->
					<option value="$value[fuid]"{$fuid_actives[$value[fuid]]}>$value[fusername]</option>
					<!--{/loop}-->
				</select>
			</p>
		<!--{/if}-->

		<!--{if $count}-->
			<!--{loop $special $tid $thread}-->
			<div class="ds bbda mbw">
				<h3 class="ph mbn"><a href="forum.php?mod=viewthread&tid=$thread[tid]" class="xi2" target="_blank">$thread[subject]</a></h3>
				<p class="xg2 mbw hm">$thread[message]</p>
				<table summary="{lang debate_all_point}" cellspacing="0" cellpadding="0">
					<tr>
						<td class="si_1">
							<div class="point">
								<strong>{lang affirm_votes} ($thread[affirmvotes])</strong>
								<p>$thread[affirmpoint]</p>
							</div>
						</td>
						<td class="sc_1">
							<div class="point_chart cur1" title="{lang chart_support}" href="forum.php?mod=misc&action=debatevote&tid=$thread[tid]&stand=1" id="affirmbutton_$thread[tid]" onclick="ajaxmenu(this);doane(event);" >
								<div class="chart" style="height: $thread[affirmvotesheight];" title="{lang debate_square} ($thread[affirmvotes])"></div>
							</div>
						</td>
						<th><div></div></th>
						<td class="sc_2">
							<div class="point_chart cur1" title="{lang chart_support}" href="forum.php?mod=misc&action=debatevote&tid=$thread[tid]&stand=2" id="negabutton_$thread[tid]" onclick="ajaxmenu(this);doane(event);">
								<div class="chart" style="height: $thread[negavotesheight];" title="{lang debate_opponent} ($thread[negavotes])"></div>
							</div>
						</td>
						<td class="si_2">
							<div class="point">
								<strong>{lang nega_votes} ($thread[negavotes])</strong>
								<p>$thread[negapoint]</p>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<!--{/loop}-->

			<div class="tl">
				<!--{if $list}-->
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td class="icn">&nbsp;</td>
						<th>&nbsp;</th>
						<td class="num">{lang affirm}</td>
						<td class="num">{lang nega}</td>
						<td class="num">{lang popularity}</td>
						<td width="55">{lang rate}</td>
					</tr>
					<!--{loop $list $tid $thread}-->
					<tr>
						<td>
							<a href="forum.php?mod=viewthread&tid=$thread[tid]" title="{lang open_new_window}" target="_blank">
								<!--{if $thread[folder] == 'lock'}-->
									<img src="{IMGDIR}/folder_lock.gif" class="vm" />
								<!--{elseif $thread['special'] == 5}-->
									<img src="{IMGDIR}/debatesmall.gif" alt="{lang debate}" class="vm" />
								<!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
									<img src="{IMGDIR}/pin_$thread[displayorder].gif" alt="$_G[setting][threadsticky][3-$thread[displayorder]]" class="vm" />
								<!--{else}-->
									<img src="{IMGDIR}/folder_$thread[folder].gif" class="vm" />
								<!--{/if}-->
							</a>
						</td>
						<th height="45">
							<a href="forum.php?mod=viewthread&tid=$thread[tid]" class="xi2" target="_blank">$thread[subject]</a>
							<!--{if $thread['digest'] > 0}-->
								<img src="{IMGDIR}/digest_$thread[digest].gif" alt="{lang digest} $thread[digest]" align="absmiddle" />
							<!--{/if}-->
							<!--{if $thread['attachment'] == 2}-->
								<img src="{STATICURL}image/filetype/image_s.gif" alt="{lang photo_accessories}" align="absmiddle" />
							<!--{elseif $thread['attachment'] == 1}-->
								<img src="{STATICURL}image/filetype/common.gif" alt="{lang accessory}" align="absmiddle" />
							<!--{/if}-->
							<!--{if $thread[multipage]}--><span class="tps">$thread[multipage]</span><!--{/if}-->
						</th>
						<td class="xi1">$thread[affirmvotes]</td>
						<td class="xi2">$thread[negavotes]</td>
						<td>$thread[replies]</td>
						<td><!--{if !$thread[closed]}-->{lang ongoing}<!--{else}--><!--{if $thread[winner]}--><!--{if $thread[winner]==1}-->{lang affirm}<!--{else}-->{lang nega}<!--{/if}-->{lang win}<!--{else}-->{lang draw}<!--{/if}--><!--{/if}--></td>
					</tr>
					<!--{/loop}-->
				</table>
				<!--{/if}-->
				<!--{if $hiddennum}-->
					<p class="mtm">{lang hide_debate}</p>
				<!--{/if}-->
			</div>

			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp">{lang no_debate}</div>
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
		window.location.href = 'home.php?mod=space&do=debate&view=we'+parameter;
	}
</script>

<!--{template common/footer}-->