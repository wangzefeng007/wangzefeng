<?php exit;?>
{eval
	$filter = array( 'common' => '{lang have_posted}', 'save' => '{lang draft}', 'close' => '{lang closed}', 'aduit' => '{lang pending}', 'ignored' => '{lang ignored}', 'recyclebin' => '{lang recyclebin}');
	$_G[home_tpl_spacemenus][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=thread&view=me\">{lang they_thread}</a>";
}

<!--{if $diymode}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<!--{subtemplate home/space_header}-->
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
					<div class="bm_h">
						<!--{if $space[self]}--><span class="xi2 y"><a href="forum.php?mod=misc&action=nav" onclick="showWindow('nav', this.href, 'get', 0)" class="addnew">{lang posted}</a></span><!--{/if}-->
						<h1 class="mt">
							<!--{if $_GET[type] == 'reply'}-->
							<span class="xs1 xw0"><a href="home.php?mod=space&do=thread&view=me&type=thread&uid=$space[uid]&from=space">{lang topic}</a><span class="pipe">|</span></span>{lang reply}
							<!--{else}-->
							{lang topic}<span class="xs1 xw0"><span class="pipe">|</span><a href="home.php?mod=space&do=thread&view=me&type=reply&uid=$space[uid]&from=space">{lang reply}</a></span>
							<!--{/if}-->
						</h1>
					</div>
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->
		<div id="pt" class="bm cl">
			<div class="z">
				<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]">{$space[username]}</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me">{lang thread}</a>
			</div>
		</div>
		<style id="diy_style" type="text/css"></style>
		<div class="wp">
			<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
		</div>
		<!--{template home/space_menu}-->
		<div id="ct" class="ct1 wp cl">
			<div class="mn">
				<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
				<div class="bm bw0">
					<div class="bm_c">
	<!--{/if}-->
<!--{else}-->
	<!--{template common/header}-->
	<style id="diy_style" type="text/css"></style>
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>
	<div id="ct" class="ct7_a wp cl">
	<!--{if $_G[setting][homestyle]}-->
		<div class="apps">
			<div class="tbn">
				<h2 class="mt bbda">{lang thread}</h2>
				<ul>
					<li$actives[we]><a href="home.php?mod=space&do=thread&view=we">{lang friend_post}</a></li>
					<li$actives[me]><a href="home.php?mod=space&do=thread&view=me">{lang my_post}</a></li>
				</ul>
			</div>
		</div>
		<div class="mn pbw">
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
	<!--{else}-->
		<div class="mn pbw">
		<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
	<!--{/if}-->
<!--{/if}-->
		
		<!--{if !$diymode && $space[self]}-->
			<!--{if $_GET['view'] == 'me'}-->
			<p class="tbmu bw0">
				<!--{if $viewtype != 'postcomment'}-->
					<span class="y">
					<a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&type=$viewtype&from=$_GET[from]&filter=" {if !$_GET[filter]}class="a"{/if}>{lang all}</a>
					<!--{loop $filter $key $name}--><span class="pipe">|</span><a href="home.php?mod=space&do=thread&view=me&type=$viewtype&from=$_GET[from]&filter=$key" {if $key == $_GET[filter]}class="a"{/if}>$name</a><!--{/loop}--> &nbsp;
						<select name="forumlist" id="forumlist" class="ps vm" onchange="viewforumthread(this.value);" style="width: 120px; word-wrap: normal;">
							<option value="0">{lang follow_select_forum}</option>
							$forumlist
						</select>
					</span>
				<!--{/if}-->
				<a href="home.php?mod=space&do=thread&view=me&type=thread" $orderactives[thread]>{lang topic}</a><span class="pipe">|</span>
				<a href="home.php?mod=space&do=thread&view=me&type=reply" $orderactives[reply]>{lang reply}</a><span class="pipe">|</span>
				<a href="home.php?mod=space&do=thread&view=me&type=postcomment" $orderactives[postcomment]>{lang post_comment}</a>
				<!--{if $viewtype != 'reply' && $viewtype != 'postcomment'}-->&nbsp; <input type="text" id="searchmypost" class="px vm" size="15" /> <button class="pn vm" onclick="searchpostbyusername($('searchmypost').value, '$_G[username]');"><em>{lang search}</em></button><!--{/if}-->
			</p>
			<!--{elseif $_GET['view'] == 'all'}-->
			<p class="tbmu bw0">
				<a href="home.php?mod=space&do=thread&view=all&order=dateline" $orderactives[dateline]>{lang newest_thread}</a><span class="pipe">|</span>
				<a href="home.php?mod=space&do=thread&view=all&order=hot" $orderactives[hot]>{lang top_thread}</a>
			</p>
			<!--{/if}-->
		<!--{/if}-->
		
		<!--{if $diymode && !$_G[setting][homepagestyle] }-->
			<p class="tbmu">
				<a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space&type=thread" $orderactives[thread]>{lang topic}</a>
				<span class="pipe">|</span>
				<a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space&type=reply" $orderactives[reply]>{lang reply}</a>
			</p>
		<!--{/if}-->
		
		<!--{if $userlist}-->
			<p class="tbmu bw0">
				{lang view_by_friend}
				<select name="fuidsel" onchange="fuidgoto(this.value);" class="ps" style="font-size:12px">
					<option value="">{lang all_friends}</option>
					<!--{loop $userlist $value}-->
					<option value="$value[fuid]"{$fuid_actives[$value[fuid]]}>$value[fusername]</option>
					<!--{/loop}-->
				</select>
			</p>
		<!--{/if}-->
		<div class="tl">
			<form method="post" autocomplete="off" name="delform" id="delform" action="home.php?mod=space&do=thread&view=all&order=dateline" onsubmit="showDialog('{lang del_select_thread_confirm}', 'confirm', '', '$(\'delform\').submit();'); return false;">
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<input type="hidden" name="delthread" value="true" />

					<table cellspacing="0" cellpadding="0">
						<tr class="th">
							<td class="icn">&nbsp;</td>
							<!--{if $_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid']}-->
								<td class="o">&nbsp;</td>
							<!--{/if}-->
							<th><!--{if $viewtype == 'reply' || $viewtype == 'postcomment'}-->{lang post}<!--{else}-->{lang topic}<!--{/if}--></th>
							<td class="frm">{lang forum}<!--{if $actives[me] && $space['uid'] == $_G['uid']}-->/{lang group}<!--{/if}--></td>
							<!--{if $viewtype != 'postcomment'}-->
								<!--{if !$actives[me]}-->
								<td class="by">{lang author}</td>
								<!--{/if}-->
								<td class="num">{lang replies}</td>
								<!--{if $actives[me]}-->
								<td class="by"><cite>{lang last_post}</cite></td>
								<!--{/if}-->
							<!--{/if}-->
						</tr>

					<!--{if $list}-->
						<!--{loop $list $stid $thread}-->
						<tr{if $actives[me] && $viewtype=='reply' || $viewtype=='postcomment'} class="bw0_all"{/if}>
							<td class="icn">
								<a href="forum.php?mod=viewthread&tid=$thread[tid]&highlight=$index[keywords]" title="{lang open_new_window}" target="_blank">
								<!--{if $thread[folder] == 'lock'}-->
									<img src="{IMGDIR}/folder_lock.gif" />
								<!--{elseif $thread['special'] == 1}-->
									<img src="{IMGDIR}/pollsmall.gif" alt="{lang poll}" />
								<!--{elseif $thread['special'] == 2}-->
									<img src="{IMGDIR}/tradesmall.gif" alt="{lang trade}" />
								<!--{elseif $thread['special'] == 3}-->
									<img src="{IMGDIR}/rewardsmall.gif" alt="{lang reward}" />
								<!--{elseif $thread['special'] == 4}-->
									<img src="{IMGDIR}/activitysmall.gif" alt="{lang activity}" />
								<!--{elseif $thread['special'] == 5}-->
									<img src="{IMGDIR}/debatesmall.gif" alt="{lang debate}" />
								<!--{elseif in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
									<img src="{IMGDIR}/pin_$thread[displayorder].gif" alt="$_G[setting][threadsticky][3-$thread[displayorder]]" />
								<!--{else}-->
									<img src="{IMGDIR}/folder_$thread[folder].gif" />
								<!--{/if}-->
								</a>
							</td>
							<!--{if $_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid']}-->
								<td class="o">
									<!--{if $thread['digest'] == 0}-->
										<!--{if $thread['displayorder'] == 0}-->
											<input type="checkbox" name="moderate[]" value="$thread[tid]" class="pc" />
										<!--{else}-->
											<input type="checkbox" class="pc" disabled="disabled" />
										<!--{/if}-->
									<!--{else}-->
										<input type="checkbox" class="pc" disabled="disabled" />
									<!--{/if}-->
								</td>
							<!--{/if}-->
							<th>
								<!--{if $viewtype == 'reply' || $viewtype == 'postcomment'}-->
									<a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$thread[pid]" target="_blank">$thread[subject]</a>
								<!--{else}-->
									<a href="forum.php?mod=viewthread&tid=$thread[tid]" target="_blank" {if $thread['displayorder'] == -1}class="recy"{/if}>$thread[subject]</a>
								<!--{/if}-->
								<!--{if $thread['digest'] > 0}-->
									<img src="{IMGDIR}/digest_$thread[digest].gif" alt="{lang digest} $thread[digest]" align="absmiddle" />
								<!--{/if}-->
								<!--{if $thread['attachment'] == 2}-->
									<img src="{STATICURL}image/filetype/image_s.gif" alt="{lang photo_accessories}" align="absmiddle" />
								<!--{elseif $thread['attachment'] == 1}-->
									<img src="{STATICURL}image/filetype/common.gif" alt="{lang accessory}" align="absmiddle" />
								<!--{/if}-->
								<!--{if $thread[multipage]}--><span class="tps">$thread[multipage]</span><!--{/if}-->
								<!--{if !$_GET['filter']}-->
									<!--{if $thread[$statusfield] == -1}--><span class="xg1">$filter[recyclebin]</span>
									<!--{elseif $thread[$statusfield] == -2}--><span class="xg1">$filter[aduit]</span>
									<!--{elseif $thread[$statusfield] == -3 && $thread[displayorder] != -4}--><span class="xg1">$filter[ignored]</span>
									<!--{elseif $thread[displayorder] == -4}--><span class="xg1">$filter[save]</span>
									<!--{elseif $thread['closed'] == 1}--><span class="xg1">$filter[close]</span>
									<!--{/if}-->
								<!--{/if}-->
							</th>
							<td>
								<a href="forum.php?mod=forumdisplay&fid=$thread[fid]" class="xg1" target="_blank">$forums[$thread[fid]]</a>
							</td>
							<!--{if $viewtype != 'postcomment'}-->
								<!--{if !$actives[me]}-->
								<td>
									<cite><a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">$thread[author]</a></cite>
									<em>$thread[dateline]</em>
								</td>
								<!--{/if}-->

								<td class="num">
									<a href="forum.php?mod=viewthread&tid=$thread[tid]" class="xi2" target="_blank">$thread[replies]</a>
									<em>$thread[views]</em>
								</td>

								<!--{if $actives[me]}-->
								<td class="by">
									<cite><a href="home.php?mod=space&username=$thread[lastposterenc]" target="_blank">$thread[lastposter]</a></cite>
									<em><a href="forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost#lastpost" target="_blank">$thread[lastpost]</a></em>
								</td>
								<!--{/if}-->
							<!--{/if}-->
						</tr>
						<!--{if $actives[me] && $viewtype=='reply'}-->
							<!--{loop $tids[$stid] $pid}-->
							<!--{eval $post = $posts[$pid];}-->
							<tr>
								<td colspan="5" class="xg1">&nbsp;<img src="{IMGDIR}/icon_quote_m_s.gif" style="vertical-align:middle;" /> <a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$pid" target="_blank"><!--{if $post[message]}-->{$post[message]}<!--{else}-->......<!--{/if}--></a> <img src="{IMGDIR}/icon_quote_m_e.gif" style="vertical-align:middle;" /></td>
							</tr>
							<!--{/loop}-->
						<!--{/if}-->
						<!--{if $actives[me] && $viewtype=='postcomment'}-->
						<tr>
							<td class="icn">&nbsp;</td>
							<td colspan="2" class="xg1">$thread[comment]</td>
						</tr>
						<!--{/if}-->
						<!--{/loop}-->
					<!--{else}-->
						<tr>
							<td colspan="{if $viewtype != 'postcomment'}{if ($_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid'])}6{else}5{/if}{else}3{/if}"><p class="emp">{lang no_related_posts}</p></td>
						</tr>
					<!--{/if}-->
					</table>

					<!--{if $_GET['view'] == 'all' && $pruneperm && !$_GET['archiveid'] && $list}-->
						<p class="mtm pns">
							<label for="chkall" onclick="checkall(this.form, 'moderate')"><input type="checkbox" name="chkall" id="chkall" class="pc vm" />{lang select_all}</label>
							<button type="submit" name="delsubmit" value="true" class="pn vm"><em>{lang del_select_thread}</em></button>
						</p>
					<!--{/if}-->
				</form>

				<!--{if $hiddennum}-->
					<p class="mtm">{lang hide_thread}</p>
				<!--{/if}-->
			</div>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->		
		
		<script type="text/javascript">
		function fuidgoto(fuid) {
			window.location.href = 'home.php?mod=space&do=thread&view=we&fuid='+fuid;
		}
		function viewforumthread(fid) {
			window.location.href = '{$forumurl}&fid='+fid;
		}
		</script>
		
		<!--{if !$_G[setting][homepagestyle]}--><!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]--><!--{/if}-->

		<!--{if $diymode}-->
					</div>
				</div>
			<!--{if $_G[setting][homepagestyle]}-->
			</div>
			<div class="sd">
				<!--{subtemplate home/space_userabout}-->
			<!--{/if}-->
		<!--{/if}-->
		</div>
	</div>

<!--{if !$_G[setting][homepagestyle]}-->
	<div class="wp mtn">
		<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
	</div>
<!--{/if}-->

<!--{template common/footer}-->