<?php exit;?>
<!--{template common/header}-->
<style id="diy_style" type="text/css"></style>

<!--[diy=diyranklisttop]--><div id="diyranklisttop" class="area"></div><!--[/diy]-->

<div id="ct" class="ct7_a wp cl">
	<div class="apps">
		<!--[diy=diysidetop]--><div id="diysidetop" class="area"></div><!--[/diy]-->
		<!--{subtemplate ranklist/side_left}-->
		<!--[diy=diysidebottom]--><div id="diysidebottom" class="area"></div><!--[/diy]-->
	</div>
	<div class="mn">
		<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
		<div class="bm bw0">
			<h1 class="mt">{lang ranklist_forum}</h1>
			<ul class="tb cl">
				<li{if $_GET[view] == 'threads'} class="a"{/if}><a href="misc.php?mod=ranklist&type=forum&view=threads">{lang ranklist_post}</a></li>
				<li{if $_GET[view] == 'posts'} class="a"{/if}><a href="misc.php?mod=ranklist&type=forum&view=posts">{lang ranklist_reply}</a></li>
				<li{if $_GET[view] == 'today'} class="a"{/if}><a href="misc.php?mod=ranklist&type=forum&view=today">{lang ranklist_post_day}</a></li>
			</ul>
			<!--{if $forumsrank}-->
				<div class="tl">
					<table cellspacing="0" cellpadding="0">
						<tr>
							<td class="icn" height="36">&nbsp;</td>
							<th>{lang forum}</th>
							<td width="100">
								<!--{if $_GET[view] == 'today'}-->{lang ranklist_forum_day_post}
								<!--{elseif $_GET[view] == 'posts'}-->{lang reply}
								<!--{elseif $_GET[view] == 'thismonth'}-->{lang ranklist_forum_month_post}
								<!--{else}-->{lang ranklist_forum_post}<!--{/if}-->
							</td>
						</tr>
						<!--{loop $forumsrank $forum}-->
							<tr>
								<td class="icn" height="36"><!--{if $forum['rank'] <= 3}--><img src="{IMGDIR}/rank_$forum['rank'].gif" alt="$forum['rank']" /><!--{else}-->$forum['rank']<!--{/if}--></td>
								<th><a href="forum.php?mod=forumdisplay&fid=$forum['fid']" target="_blank">$forum['name']</a></th>
								<td>
									$forum['posts']
								</td>
							</tr>
						<!--{/loop}-->
					</table>
				</div>
			<!--{else}-->
				<div class="emp">{lang none_data}</div>
			<!--{/if}-->
			<div class="notice">{lang ranklist_update}</div>
		</div>
		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->
	</div>
</div>

<!--[diy=diyranklistbottom]--><div id="diyranklistbottom" class="area"></div><!--[/diy]-->

<!--{template common/footer}-->