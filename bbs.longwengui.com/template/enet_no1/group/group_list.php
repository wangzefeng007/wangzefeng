<?php exit;?>
<!--{if $_G['forum']['ismoderator']}-->
	<script type="text/javascript" src="{$_G[setting][jspath]}forum_moderate.js?{VERHASH}"></script>
<!--{/if}-->
<style>
.fl .bm_h {padding-top: 0px;}
</style>
<div id="pgt" class="bm bw0 pgs cl">
	$multipage
	<!--{if helper_access::check_module('group')}-->
	<span {if $_G[setting][visitedforums]}id="visitedforums" onmouseover="$('visitedforums').id = 'visitedforumstmp';this.id = 'visitedforums';showMenu({'ctrlid':this.id})"{/if} class="pgb y"><a href="forum.php?mod=group&fid=$_G[fid]">{lang return_index}</a></span>
	
	<a href="javascript:;" id="newspecial" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})" onclick="showWindow('newthread', 'forum.php?mod=post&action=newthread&fid=$_G[fid]')" title="{lang send_posts}"><img src="{IMGDIR}/pn_post.png" alt="{lang send_posts}" /></a>
	<!--{/if}-->
	<!--{hook/forumdisplay_postbutton_top}-->
</div>
<!--{if $_G['forum']['threadtypes']}-->
	<ul class="ttp bm cl">
		<li id="ttp_all"{if !$_GET['typeid']} class="xw1 a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]">{lang forum_viewall}</a></li>
		<!--{if $_G['forum']['threadtypes']}-->
			<!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
				<li{if $_GET['typeid'] == $id} class="xw1 a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]{if $_GET['typeid'] != $id}&filter=typeid&typeid=$id$forumdisplayadd[typeid]{/if}">$name</a>
			<!--{/loop}-->
		<!--{/if}-->
		<!--{hook/forumdisplay_filter_extra}-->
	</ul>
<!--{/if}-->
<div id="threadlist" class="tl bm" style="position: relative;margin-bottom:10px">
	<div class="bm_c">
		<form method="post" autocomplete="off" name="moderate" id="moderate" action="forum.php?mod=topicadmin&action=moderate&fid=$_G[fid]&infloat=yes&nopost=yes">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="listextra" value="$extra" />
			<table cellpadding="0" cellspacing="0" border="0">
				<!--{if $_G['forum_threadcount']}-->
					<!--{loop $_G['forum_threadlist'] $key $thread}-->
						<!--{ad/threadlist}-->
						<tbody id="$thread[id]">
							<tr>
								<td class="avt" style="width:60px">
										<!--{if $thread['authorid'] && $thread['author']}-->
											<a href="home.php?mod=space&uid=$thread[authorid]"><!--{avatar($thread[authorid],small)}--></a>
										<!--{else}-->
											<a><img src="$_G['style']['styleimgdir']/hidden.gif" title="$_G[setting][anonymoustext]" alt="$_G[setting][anonymoustext]" /></a>
										<!--{/if}-->
								</td>
								<!--{if $_G['forum']['ismoderator']}-->
								<td class="o">
									<!--{if $thread['fid'] == $_G[fid]}-->
										<!--{if $thread['displayorder'] <= 3 || $_G['adminid'] == 1}-->
											<input onclick="tmodclick(this)" type="checkbox" name="moderate[]" class="pc" value="$thread[tid]" />
										<!--{else}-->
											<input type="checkbox" disabled="disabled" class="pc"/>
										<!--{/if}-->
									<!--{else}-->
										<input type="checkbox" disabled="disabled" class="pc"/>
									<!--{/if}-->
								</td>
								<!--{/if}-->
								<th class="common">
									<!--{hook/forumdisplay_thread $key}-->
									<!--{if $thread['moved']}-->
										<!--{if $_G['forum']['ismoderator']}-->
											<a href="forum.php?mod=topicadmin&action=moderate&optgroup=3&operation=delete&tid=$thread[moved]" onclick="showWindow('mods', this.href);return false">{lang thread_moved}:</a>
										<!--{else}-->
											{lang thread_moved}:
										<!--{/if}-->
									<!--{/if}-->
									$thread[typehtml]
									<span id="thread_$thread[tid]" class="xst"><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"$thread[highlight] class="xst">$thread[subject]</a></span>
									<!--{if $thread['readperm']}--> - [{lang readperm} <span class="xw1">$thread[readperm]</span>]<!--{/if}-->
									<!--{if $thread['price'] > 0}-->
										<!--{if $thread['special'] == '3'}-->
										- <span style="color: #C60">[{lang thread_reward}<span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][title]}]</span>
										<!--{else}-->
										- [{lang price} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][title]}]
										<!--{/if}-->
									<!--{elseif $thread['special'] == '3' && $thread['price'] < 0}-->
										- <span style="color: #269F11">[{lang reward_solved}]</span>
									<!--{/if}-->
									<!--{if $thread['attachment'] == 2}-->
										<img src="{STATICURL}image/filetype/image_s.gif" alt="{lang attach_img}" align="absmiddle" />
									<!--{elseif $thread['attachment'] == 1}-->
										<img src="{STATICURL}image/filetype/common.gif" alt="{lang attachment}" align="absmiddle" />
									<!--{/if}-->
									<!--{if $thread['displayorder'] == 0}-->
										<!--{if $thread[recommendicon]}-->
											<img src="{IMGDIR}/recommend_$thread[recommendicon].gif" align="absmiddle" alt="recommend" title="{lang thread_recommend} $thread[recommends]" />
										<!--{/if}-->
										<!--{if $thread[heatlevel]}-->
											<img src="{IMGDIR}/hot_$thread[heatlevel].gif" align="absmiddle" alt="heatlevel" title="$thread[heatlevel] {lang heats}" />
										<!--{/if}-->
										<!--{if $thread['digest'] > 0}-->
											<img src="{IMGDIR}/digest_$thread[digest].gif" align="absmiddle" alt="digest" title="{lang thread_digest} $thread[digest]" />
										<!--{/if}-->
										<!--{if $thread['rate'] > 0}-->
											<img src="{IMGDIR}/agree.gif" align="absmiddle" alt="agree" title="{lang rate_credit_add}" />
										<!--{/if}-->
									<!--{/if}-->
									<!--{if $thread[multipage]}-->
										<span class="tps">$thread[multipage]</span>
									<!--{/if}-->
										<p class="mtn xg1" style="font-size: 12px">
											<!--{hook/forumdisplay_author $key}-->
											<!--{if $thread['authorid'] && $thread['author']}-->
												<span>{lang author}:</span><a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
											<!--{else}-->
												<span>{lang author}:</span>$_G[setting][anonymoustext]
											<!--{/if}-->
											&nbsp;
											<span>{lang group_live_post}{lang time}:</span><span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span>
										<span>&nbsp;{lang lastpost}: <!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}" c="1">$thread[lastposter]</a>&nbsp;/<!--{else}-->$_G[setting][anonymoustext]&nbsp;/<!--{/if}-->&nbsp;<a href="{if $thread[digest] != -2}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}">$thread[lastpost]</a></span>
										</p>
								</th>
									<td class="flt">
									</td>
									<td class="flt">
									</td>
								<td class="by" style="padding-right:0">
								<div class="xld" style="float: right;padding-right:0"><dd class="m hm"><strong class="xi2">$thread[allreplies]</strong><span>{lang reply}</span></dd><dd class="m hm" style="margin-right:0"><strong class="xi2">$thread[views]</strong><span>{lang focus_show}</span></dd></div>
								</td>
							</tr>
						</tbody>
					<!--{/loop}-->
				<!--{else}-->
					<tbody><tr><th colspan="6"><p class="emp">{lang forum_nothreads}</p></th></tr></tbody>
				<!--{/if}-->
			</table>
			<!--{if $_G['forum']['ismoderator'] && $_G['forum_threadcount']}-->
				<!--{template forum/topicadmin_modlayer}-->
			<!--{/if}-->
		</form>
	</div>
</div>
<!--{if helper_access::check_module('group')}-->
<div class="bm bw0 pgs cl">
	$multipage
	<span {if $_G[setting][visitedforums]}id="visitedforums" onmouseover="$('visitedforums').id = 'visitedforumstmp';this.id = 'visitedforums';showMenu({'ctrlid':this.id})"{/if} class="pgb y"><a href="forum.php?mod=group&fid=$_G[fid]">{lang return_index}</a></span>
	<a href="javascript:;" id="newspecialtmp" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})" onclick="showWindow('newthread', 'forum.php?mod=post&action=newthread&fid=$_G[fid]')" title="{lang send_posts}"><img src="{IMGDIR}/pn_post.png" alt="{lang send_posts}" /></a>
	<!--{hook/forumdisplay_postbutton_bottom}-->
</div>

<!--{if $_G['setting']['fastpost']}-->
	<!--{template forum/forumdisplay_fastpost}-->
<!--{/if}-->

<!--{if $_G['group']['allowpost'] && ($_G['group']['allowposttrade'] || $_G['group']['allowpostpoll'] || $_G['group']['allowpostreward'] || $_G['group']['allowpostactivity'] || $_G['group']['allowpostdebate'] || $_G['setting']['threadplugins'] || $_G['forum']['threadsorts'])}-->
	<ul class="p_pop" id="newspecial_menu" style="display: none">
		<!--{if !$_G['forum']['allowspecialonly']}--><li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" onclick="showWindow('newthread', this.href);doane(event)">{lang post_newthread}</a></li><!--{/if}-->
		<!--{if $_G['group']['allowpostpoll']}--><li class="poll"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=1">{lang post_newthreadpoll}</a></li><!--{/if}-->
		<!--{if $_G['group']['allowpostreward']}--><li class="reward"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=3">{lang post_newthreadreward}</a></li><!--{/if}-->
		<!--{if $_G['group']['allowpostdebate']}--><li class="debate"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=5">{lang post_newthreaddebate}</a></li><!--{/if}-->
		<!--{if $_G['group']['allowpostactivity']}--><li class="activity"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=4">{lang post_newthreadactivity}</a></li><!--{/if}-->
		<!--{if $_G['group']['allowposttrade']}--><li class="trade"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=2">{lang post_newthreadtrade}</a></li><!--{/if}-->
		<!--{if $_G['setting']['threadplugins']}-->
			<!--{loop $_G['forum']['threadplugin'] $tpid}-->
				<!--{if array_key_exists($tpid, $_G['setting']['threadplugins']) && @in_array($tpid, $_G['group']['allowthreadplugin'])}-->
					<li class="popupmenu_option"{if $_G['setting']['threadplugins'][$tpid][icon]} style="background-image:url($_G[setting][threadplugins][$tpid][icon])"{/if}><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&specialextra=$tpid">{$_G[setting][threadplugins][$tpid][name]}</a></li>
				<!--{/if}-->
			<!--{/loop}-->
		<!--{/if}-->
	</ul>
<!--{/if}-->
<!--{/if}-->