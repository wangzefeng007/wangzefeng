<?php exit;?>
<!--{template common/header}-->
<!--{if empty($gid)}-->
	<!--{ad/text/wp a_t}-->
<!--{/if}-->

	<style id="diy_style" type="text/css"></style>

<!--{if empty($gid)}-->
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>
<!--{/if}-->

<div id="ct" class="wp cl{if $_G['setting']['forumallowside']} ct2{/if}">
	<!--{if empty($gid)}-->
		<div id="chart" class="bm cl xi2">
			<p class="chart z">{lang index_today}: <em>$todayposts</em><span class="pipe">|</span>{lang index_yesterday}: <em>$postdata[0]</em><span class="pipe">|</span>{lang index_posts}: <em>$posts</em><span class="pipe">|</span>{lang index_members}: <em>$_G['cache']['userstats']['totalmembers']</em><!--{if $_G['cache']['userstats']['newsetuser']}--><span class="pipe">|</span>{lang welcome_new_members}: <em><a href="home.php?mod=space&username={echo rawurlencode($_G['cache']['userstats']['newsetuser'])}" target="_blank" class="xi2">$_G['cache']['userstats']['newsetuser']</a></em><!--{/if}--></p>
			<div class="y" style="line-height: 21px">
				<!--{hook/index_nav_extra}-->
				<!--{if $_G['uid']}--><a href="forum.php?mod=guide&view=my" title="{lang my_posts}" class="xi2">{lang my_posts}</a><!--{/if}--><!--{if !empty($_G['setting']['search']['forum']['status'])}--><!--{if $_G['uid']}--><span class="pipe">|</span><!--{/if}--><a href="forum.php?mod=guide&view=new" title="{lang show_newthreads}" class="xi2">{lang show_newthreads}</a><!--{/if}-->
			</div>
		</div>
	<!--{/if}-->
	<!--[diy=diy_chart]--><div id="diy_chart" class="area"></div><!--[/diy]-->
	<div class="mn">

		<!--{if !empty($_G['setting']['grid']['showgrid'])}-->
		<!-- index four grid -->
			<div class="bm bmw cl" style="margin-bottom:10px;border:0 !important">
				<div id="category_grid" class="bm_c" style="border:0 !Important;margin:0 !Important">
					<table cellspacing="0" cellpadding="0"><tr>
					<!--{if !$_G['setting']['grid']['gridtype']}-->
						<td valign="top" class="category_l1">
							<div class="newimgbox">
								<h4><span class="tit_newimg"></span>{lang latest_images}</h4>
								<div class="module cl slidebox_grid" style="width:218px">
									<script type="text/javascript">
									var slideSpeed = 5000;
									var slideImgsize = [218,200];
									var slideBorderColor = '{$_G['style']['specialborder']}';
									var slideBgColor = '{$_G['style']['commonbg']}';
									var slideImgs = new Array();
									var slideImgLinks = new Array();
									var slideImgTexts = new Array();
									var slideSwitchColor = '{$_G['style']['tabletext']}';
									var slideSwitchbgColor = '{$_G['style']['commonbg']}';
									var slideSwitchHiColor = '{$_G['style']['specialborder']}';
									{eval $k = 1;}
									<!--{loop $grids['slide'] $stid $svalue}-->
										slideImgs[<!--{echo $k}-->] = '$svalue[image]';
										slideImgLinks[<!--{echo $k}-->] = '{$svalue[url]}';
										slideImgTexts[<!--{echo $k}-->] = '$svalue[subject]';
										{eval $k++;}
									<!--{/loop}-->
									</script>
									<script language="javascript" type="text/javascript" src="{$_G[setting][jspath]}forum_slide.js?{VERHASH}"></script>
								</div>
							</div>
						</td>
					<!--{/if}-->
					<td valign="top" class="category_l2">
						<div class="subjectbox">
							<h4><span class="tit_subject"></span>{lang collection_lastthread}</h4>
					        <ul class="category_newlist">
					        	<!--{loop $grids['newthread'] $thread}-->
					        	<!--{if !$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
									<!--{eval $thread[tid]=$thread[closed];}-->
								<!--{/if}-->
								<li><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"{if $thread['highlight']} $thread['highlight']{/if}{if $_G['setting']['grid']['showtips']} tip="{lang title}: <strong>$thread[oldsubject]</strong><br/>{lang author}: $thread[author] ($thread[dateline])<br/>{lang show}/{lang reply}: $thread[views]/$thread[replies]" onmouseover="showTip(this)"{else} title="$thread[oldsubject]"{/if}{if $_G['setting']['grid']['targetblank']} target="_blank"{/if}>$thread[subject]</a></li>
								<!--{/loop}-->
					         </ul>
				         </div>
					</td>
					<td valign="top" class="category_l3">
						<div class="replaybox">
							<h4><span class="tit_replay"></span>{lang show_newthreads}</h4>
					        <ul class="category_newlist">
					        	<!--{loop $grids['newreply'] $thread}-->
					        	<!--{if !$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
									<!--{eval $thread[tid]=$thread[closed];}-->
								<!--{/if}-->
								<li><a href="forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost#lastpost"{if $thread['highlight']} $thread['highlight']{/if}{if $_G['setting']['grid']['showtips']}tip="{lang title}: <strong>$thread[oldsubject]</strong><br/>{lang author}: $thread[author] ($thread[dateline])<br/>{lang show}/{lang reply}: $thread[views]/$thread[replies]" onmouseover="showTip(this)"{else} title="$thread[oldsubject]"{/if}{if $_G['setting']['grid']['targetblank']} target="_blank"{/if}>$thread[subject]</a></li>
								<!--{/loop}-->
					         </ul>
				         </div>
					</td>
					<td valign="top" class="category_l3">
						<div class="hottiebox">
							<h4><span class="tit_hottie"></span>{lang hot_thread}</h4>
					        <ul class="category_newlist">
					        	<!--{loop $grids['hot'] $thread}-->
					        	<!--{if !$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
									<!--{eval $thread[tid]=$thread[closed];}-->
								<!--{/if}-->
								<li><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"{if $thread['highlight']} $thread['highlight']{/if}{if $_G['setting']['grid']['showtips']} tip="{lang title}: <strong>$thread[oldsubject]</strong><br/>{lang author}: $thread[author] ($thread[dateline])<br/>{lang show}/{lang reply}: $thread[views]/$thread[replies]" onmouseover="showTip(this)"{else} title="$thread[oldsubject]"{/if}{if $_G['setting']['grid']['targetblank']} target="_blank"{/if}>$thread[subject]</a></li>
								<!--{/loop}-->
					         </ul>
				         </div>
					</td>
					<!--{if $_G['setting']['grid']['gridtype']}-->
						<td valign="top" class="category_l4">
							<div class="goodtiebox">
								<h4><span class="tit_goodtie"></span>{lang post_digest_thread}</h4>
								<ul class="category_newlist">
									<!--{loop $grids['digest'] $thread}-->
										<!--{if !$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
											<!--{eval $thread[tid]=$thread[closed];}-->
										<!--{/if}-->
										<li><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"{if $thread['highlight']} $thread['highlight']{/if}{if $_G['setting']['grid']['showtips']} tip="{lang title}: <strong>$thread[oldsubject]</strong><br/>{lang author}: $thread[author] ($thread[dateline])<br/>{lang show}/{lang reply}: $thread[views]/$thread[replies]" onmouseover="showTip(this)"{else} title="$thread[oldsubject]"{/if}{if $_G['setting']['grid']['targetblank']} target="_blank"{/if}>$thread[subject]</a></li>
									<!--{/loop}-->
								 </ul>
						 	</div>
						</td>
					<!--{/if}-->
					</table>
				</div>
			</div>
		<!-- index four grid end -->
		<!--{/if}-->
		<!--{hook/index_top}-->
		<!--{if !empty($_G['cache']['heats']['message'])}-->
			<div class="bm">
				<div class="bm_h cl">
					<h2 class="xs2">{lang hotthreads_forum}</h2>
				</div>
				<div class="bm_c cl">
					<div class="heat z">
						<!--{loop $_G['cache']['heats']['message'] $data}-->
							<dl class="xld">
								<dt><!--{if $_G['adminid'] == 1}--><a class="d" href="forum.php?mod=misc&action=removeindexheats&tid=$data[tid]" onclick="return removeindexheats()">delete</a><!--{/if}-->
								<a href="forum.php?mod=viewthread&tid=$data[tid]" target="_blank" class="xi2">$data[subject]</a></dt>
								<dd>$data[message]</dd>
							</dl>
						<!--{/loop}-->
					</div>
					<ul class="xl xl1 heatl">
					<!--{loop $_G['cache']['heats']['subject'] $data}-->
						<li><!--{if $_G['adminid'] == 1}--><a class="d" href="forum.php?mod=misc&action=removeindexheats&tid=$data[tid]" onclick="return removeindexheats()">delete</a><!--{/if}-->&middot; <a href="forum.php?mod=viewthread&tid=$data[tid]" target="_blank" class="xi2">$data[subject]</a></li>
					<!--{/loop}-->
					</ul>
				</div>
			</div>
		<!--{/if}-->

		<!--{hook/index_catlist_top}-->
		<div class="fl">
			<div style="margin-top:-10px;padding-bottom:10px">
			<!--{if empty($gid) && !empty($forum_favlist)}-->
			<!--{eval $forumscount = count($forum_favlist);}-->
			<!--{eval $forumcolumns = $forumscount > 3 ? ($forumscount == 4 ? 4 : 5) : 1;}-->

			<!--{eval $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';}-->

			<div class="{if $forumcolumns}flg {/if}cl list">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_0_img" src="{IMGDIR}/$collapse['collapseimg_0']" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_0');" />
					</span>
					<h2><a href="home.php?mod=space&do=favorite&type=forum" class="xs2">{lang forum_myfav}</a></h2>
				</div>
				<div id="category_0" class="bm_c" style="{echo $collapse['category_0']}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $favorderid = 0;}-->
						<!--{eval $i = 1;}-->
						<!--{loop $forum_favlist $key $favorite}-->
						<!--{if $favforumlist[$favorite[id]]}-->
						<!--{eval $forum=$favforumlist[$favorite[id]];}-->
						<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
							<!--{if $forumcolumns>1}-->
								<!--{if $favorderid && ($favorderid % $forumcolumns == 0)}-->
									</tr>
									<!--{if $favorderid < $forumscount}-->
										<tr class="fl_row">
									<!--{/if}-->
								<!--{/if}-->
								<td class="fl_g"{if $forumcolwidth} width="$forumcolwidth"{/if}>
									<div class="fl_icn_g"{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
									<!--{if $forum[icon]}-->
										$forum[icon]
									<!--{else}-->
	                                    <a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['styleimgdir']/0{$i}.png" alt="$forum[name]" /></a>	
	                                    <!--{eval $i >= 9 ? $i = 1 : $i++;}-->	
	                                <!--{/if}-->
									</div>
									<dl{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="margin-left: {$forum[extra][iconwidth]}px;"{/if}>
										<dt><a href="$forumurl" class="bbstil xi2"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1 jinri" title="{lang forum_todayposts}">$forum[todayposts]</em><!--{/if}--></dt>
										<!--{if empty($forum[redirect])}--><dd class="xg1"><em><span class="t">{lang forum_threads}:</span><!--{echo dnumber($forum[threads])}--></em><em><span style="margin-left:4px" class="t">{lang forum_posts}:</span><!--{echo dnumber($forum[posts])}--></em></dd><!--{/if}-->
	<dd class="xg1">			
	<!--{if $forum['permission'] == 1}-->	
	<em>{lang private_forum}</em>					
	<!--{else}-->								
	<em class="l">								
	<span class="t">{lang latest}:</span>
	<!--{if $forum['redirect']}-->
	<a href="$forumurl" class="xi2">{lang url_link}</a>
	<!--{elseif is_array($forum['lastpost'])}--><a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost">$forum[lastpost][dateline]</a>
	<!--{else}-->{lang never}<!--{/if}-->						
	</em>							
	<!--{/if}-->					
	</dd>
										<!--{hook/index_favforum_extra $forum[fid]}-->
									</dl>
								</td>
								<!--{eval $favorderid++;}-->
							<!--{else}-->
								<td class="fl_icn" {if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
									<!--{if $forum[icon]}-->
										$forum[icon]
									<!--{else}-->
										<a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['styleimgdir']/0{$i}.png" alt="$forum[name]" /><!--{eval $i >= 9 ? $i = 1 : $i++;}-->	</a>
									<!--{/if}-->
								</td>
								<td>
									<h2><a href="$forumurl" class="bbstil xi2"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1 jinri" title="{lang forum_todayposts}">$forum[todayposts]</em><!--{/if}--></h2>
									<!--{if $forum[description]}--><p class="xg2" style="margin-top:2px">$forum[description]</p><!--{/if}-->
									<!--{if $forum['subforums']}--><p style="margin-top:3px">{lang forum_subforums}: $forum['subforums']</p><!--{/if}-->
									<!--{if $forum['moderators']}--><p style="margin-top:3px">{lang forum_moderators}: <span class="xi2">$forum[moderators]</span></p><!--{/if}-->
									<!--{hook/index_favforum_extra $forum[fid]}-->
								</td>
								<td class="fl_i">
									<!--{if empty($forum[redirect])}--><span class="xi2"><!--{echo dnumber($forum[threads])}--></span><span class="xg1"> / <!--{echo dnumber($forum[posts])}--></span><!--{/if}-->
								</td>
								<td class="fl_by">
									<div>
									<!--{if $forum['permission'] == 1}-->
										{lang private_forum}
									<!--{else}-->
										<!--{if $forum['redirect']}-->
											<a href="$forumurl" class="xi2">{lang url_link}</a>
										<!--{elseif is_array($forum['lastpost'])}-->
											<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($forum[lastpost][subject], 30)}--></a> <cite>$forum[lastpost][dateline] <!--{if $forum['lastpost']['author']}-->$forum['lastpost']['author']<!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></cite>
										<!--{else}-->
											{lang never}
										<!--{/if}-->
									<!--{/if}-->
									</div>
								</td>
							</tr>
							<tr class="fl_row">

							<!--{/if}-->
						<!--{/if}-->
						<!--{/loop}-->
						<!--{if ($columnspad = $favorderid % $forumcolumns) > 0}--><!--{echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);}--><!--{/if}-->
						</tr>
					</table>

				</div>
			</div>
			<!--{ad/intercat/bm a_c/-1}-->
		<!--{/if}-->
		<!--{if !empty($collectiondata['follows'])}-->

			<!--{eval $forumscount = count($collectiondata['follows']);}-->
			<!--{eval $forumcolumns = 4;}-->

			<!--{eval $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';}-->

			<div class="{if $forumcolumns}flg {/if}cl list">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_-1_img" src="{IMGDIR}/$collapse['collapseimg_-1']" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_-1');" />
					</span>
					<h2><a href="forum.php?mod=collection&op=my" class="xs2">{lang my_order_collection}</a></h2>
				</div>
				<div id="category_-1" class="bm_c" style="{echo $collapse['category_-1']}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $ctorderid = 0;}-->
						<!--{eval $i = 1;}-->
						<!--{loop $collectiondata['follows'] $key $colletion}-->
							<!--{if $ctorderid && ($ctorderid % $forumcolumns == 0)}-->
								</tr>
								<!--{if $ctorderid < $forumscount}-->
									<tr class="fl_row">
								<!--{/if}-->
							<!--{/if}-->
							<td class="fl_g"{if $forumcolwidth} width="$forumcolwidth"{/if}>
								<div class="fl_icn_g">
								<a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}" target="_blank"><img src="$_G['style']['styleimgdir']/0{$i}.png" alt="$forum[name]" /></a><!--{eval $i >= 9 ? $i = 1 : $i++;}--></a>
								</div>
								<dl>
									<dt><a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}" class="bbstil xi2">$colletion[name]</a></dt>
									<dd class="xg1"><em><span class="t">{lang forum_threads}:</span><!--{echo dnumber($forum[threads])}--></em><em><span style="margin-left:4px" class="t">{lang forum_posts}:</span><!--{echo dnumber($forum[posts])}--></em></dd>
									<dd class="xg1">
									<span class="t">{lang latest}:</span>
									<!--{if $colletion['lastpost']}-->
										<!--{if $forumcolumns < 3}-->
											<a href="forum.php?mod=redirect&tid=$colletion[lastpost]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($colletion[lastsubject], 30)}--></a> <cite><!--{date($colletion[lastposttime])}--> <!--{if $colletion['lastposter']}-->$colletion['lastposter']<!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></cite>
										<!--{else}-->
											<a href="forum.php?mod=redirect&tid=$colletion[lastpost]&goto=lastpost#lastpost"><!--{date($colletion[lastposttime])}--></a>
										<!--{/if}-->
									<!--{else}-->
										{lang never}
									<!--{/if}-->
									</dd>
									<!--{hook/index_followcollection_extra $colletion[ctid]}-->
								</dl>
							</td>
							<!--{eval $ctorderid++;}-->

						<!--{/loop}-->
						<!--{if ($columnspad = $ctorderid % $forumcolumns) > 0}--><!--{echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);}--><!--{/if}-->
						</tr>
					</table>

				</div>
			</div>

			<!--{/if}-->
		<!--{loop $catlist $key $cat}-->
			<!--{hook/index_catlist $cat[fid]}-->
			<div class="{if $cat['forumcolumns']}flg {/if}cl list">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_$cat[fid]_img" src="{IMGDIR}/$cat[collapseimg]" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_$cat[fid]');" />
					</span>
					<!--{if $cat['moderators']}--><span class="y">{lang forum_category_modedby}: $cat[moderators]</span><!--{/if}-->
					<!--{eval $caturl = !empty($cat['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$cat['domain'].'.'.$_G['setting']['domain']['root']['forum'] : '';}-->
					<h2><a href="{if !empty($caturl)}$caturl{else}forum.php?gid=$cat[fid]{/if}" style="{if $cat[extra][namecolor]}color: {$cat[extra][namecolor]};{/if}" class="xs2">$cat[name]</a></h2>
				</div>
				<div id="category_$cat[fid]" class="bm_c" style="{echo $collapse['category_'.$cat[fid]]}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $i = 1;}-->		
						<!--{loop $cat[forums] $forumid}-->
						<!--{eval $forum=$forumlist[$forumid];}-->
						<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
						<!--{if $cat['forumcolumns']}-->
							<!--{if $forum['orderid'] && ($forum['orderid'] % $cat['forumcolumns'] == 0)}-->
								</tr>
								<!--{if $forum['orderid'] < $cat['forumscount']}-->
									<tr class="fl_row">
								<!--{/if}-->
							<!--{/if}-->
							<td class="fl_g" width="$cat[forumcolwidth]">
								<div class="fl_icn_g"{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
								<!--{if $forum[icon]}-->
									$forum[icon]
								<!--{else}-->
										<a href="$forumurl" class="bbstil xi2"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['styleimgdir']/0{$i}.png" alt="$forum[name]" /></a>	
										<!--{eval $i >= 9 ? $i = 1 : $i++;}-->		
								<!--{/if}-->
								</div>
								<dl{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="margin-left: {$forum[extra][iconwidth]}px;"{/if}>
									<dt><a href="$forumurl" class="bbstil xi2"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1 jinri" title="{lang forum_todayposts}">$forum[todayposts]</em><!--{/if}--></dt>
									<!--{if empty($forum[redirect])}--><dd class="xg1"><em><span class="t">{lang forum_threads}:</span><!--{echo dnumber($forum[threads])}--></em><em><span style="margin-left:4px" class="t">{lang forum_posts}:</span><!--{echo dnumber($forum[posts])}--></em></dd><!--{/if}-->
	<dd class="xg1">			
	<!--{if $forum['permission'] == 1}-->	
		<em>{lang private_forum}</em>					
	<!--{else}-->								
	<em class="l">								
	<span class="t">{lang latest}:</span>
    <!--{if $forum['redirect']}-->
	<a href="$forumurl" class="xi2">{lang url_link}</a>
	<!--{elseif is_array($forum['lastpost'])}--><a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost">$forum[lastpost][dateline]</a>
	<!--{else}-->{lang never}
	<!--{/if}-->						
	</em>							
	<!--{/if}-->					
	</dd>
									<!--{hook/index_forum_extra $forum[fid]}-->
								</dl>
							</td>
						<!--{else}-->
							<td class="fl_icn" {if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
								<!--{if $forum[icon]}-->
									$forum[icon]
								<!--{else}-->
										<a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['styleimgdir']/0{$i}.png" alt="$forum[name]" /></a>	
										<!--{eval $i >= 9 ? $i = 1 : $i++;}-->	
								<!--{/if}-->
							</td>
							<td>
								<h2><a href="$forumurl" class="bbstil xi2"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1 jinri" title="{lang forum_todayposts}">$forum[todayposts]</em><!--{/if}--></h2>
								<!--{if $forum[description]}--><p class="xg2" style="margin-top:2px">$forum[description]</p><!--{/if}-->
								<!--{if $forum['subforums']}--><p style="margin-top:3px">{lang forum_subforums}: $forum['subforums']</p><!--{/if}-->
								<!--{if $forum['moderators']}--><p style="margin-top:3px">{lang forum_moderators}: <span class="xi2">$forum[moderators]</span></p><!--{/if}-->
								<!--{hook/index_forum_extra $forum[fid]}-->
							</td>
							<td class="fl_i">
								<!--{if empty($forum[redirect])}--><span class="xi2"><!--{echo dnumber($forum[threads])}--></span><span class="xg1"> / <!--{echo dnumber($forum[posts])}--></span><!--{/if}-->
							</td>
							<td class="fl_by">
								<div>
								<!--{if $forum['permission'] == 1}-->
									{lang private_forum}
								<!--{else}-->
									<!--{if $forum['redirect']}-->
										<a href="$forumurl" class="xi2">{lang url_link}</a>
									<!--{elseif is_array($forum['lastpost'])}-->
										<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($forum[lastpost][subject], 30)}--></a> <cite>$forum[lastpost][dateline] <!--{if $forum['lastpost']['author']}-->$forum['lastpost']['author']<!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></cite>
									<!--{else}-->
										{lang never}
									<!--{/if}-->
								<!--{/if}-->
								</div>
							</td>
						</tr>
						<tr class="fl_row">
						<!--{/if}-->
						<!--{/loop}-->
						$cat['endrows']
						</tr>
					</table>
				</div>
			</div>
			<!--{ad/intercat/bm a_c/$cat[fid]}-->
		<!--{/loop}-->
			<!--{if !empty($collectiondata['data'])}-->

			<!--{eval $forumscount = count($collectiondata['data']);}-->
			<!--{eval $forumcolumns = 4;}-->

			<!--{eval $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';}-->

			<div class="{if $forumcolumns}flg {/if}cl list">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_-2_img" src="{IMGDIR}/$collapse['collapseimg_-2']" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_-2');" />
					</span>
					<h2><a href="forum.php?mod=collection" class="xs2">{lang recommend_collection}</a></h2>
				</div>
				<div id="category_-2" class="bm_c" style="{echo $collapse['category_-2']}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $ctorderid = 0;}-->
						<!--{eval $i = 1;}-->	
						<!--{loop $collectiondata['data'] $key $colletion}-->
							<!--{if $ctorderid && ($ctorderid % $forumcolumns == 0)}-->
								</tr>
								<!--{if $ctorderid < $forumscount}-->
									<tr class="fl_row">
								<!--{/if}-->
							<!--{/if}-->
							<td class="fl_g"{if $forumcolwidth} width="$forumcolwidth"{/if}>
								<div class="fl_icn_g">
								<a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}" target="_blank"><img src="$_G['style']['styleimgdir']/0{$i}.png" alt="$forum[name]" /></a>
								<!--{eval $i >= 9 ? $i = 1 : $i++;}-->		
								</div>
								<dl>
									<dt><a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}" class="bbstil xi2">$colletion[name]</a></dt>
									<dd><em>{lang forum_threads}: <!--{echo dnumber($colletion[threadnum])}--></em>, <em>{lang collection_commentnum}: <!--{echo dnumber($colletion[commentnum])}--></em></dd>
	<dd class="xg1">			
	<!--{if $forum['permission'] == 1}-->	
	<em>{lang private_forum}</em>					
	<!--{else}-->								
	<em class="l">								
	<span class="t">{lang latest}:</span>
    <!--{if $forum['redirect']}-->
	<a href="$forumurl" class="xi2">{lang url_link}</a>
	<!--{elseif is_array($forum['lastpost'])}--><a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost">$forum[lastpost][dateline]</a>
	<!--{else}-->{lang never}<!--{/if}-->						
	</em>							
	<!--{/if}-->					
	</dd>
									<!--{hook/index_datacollection_extra $colletion[ctid]}-->
								</dl>
							</td>
							<!--{eval $ctorderid++;}-->

						<!--{/loop}-->
						<!--{if ($columnspad = $ctorderid % $forumcolumns) > 0}--><!--{echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);}--><!--{/if}-->
						</tr>
					</table>

				</div>
			</div>

			<!--{/if}-->
           </div>
		</div>

		<!--{hook/index_middle}-->
		<div class="wp mtn">
			<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
		</div>

		<!--{if empty($gid) && $_G['setting']['whosonlinestatus']}-->
			<div id="online" class="bm oll" style="margin-bottom:10px;margin-top:10px;zoom:1">
				<div class="bm_h" style="border-bottom:0;line-height:40px;border-radius: 5px;padding-bottom: 10px;background:transparent">
				<!--{if $detailstatus}-->
					<span class="o"><a href="forum.php?showoldetails=no#online" title="{lang spread}"><img src="{IMGDIR}/collapsed_no.gif" alt="{lang spread}" style="margin-top:9px" /></a></span>
					<h3>
						<strong><a href="home.php?mod=space&do=friend&view=online&type=member">{lang onlinemember}</a></strong>
						<span class="xs1">- <strong>$onlinenum</strong> {lang onlines}
						- <strong>$membercount</strong> {lang index_members}(<strong>$invisiblecount</strong> {lang index_invisibles}),
						<strong>$guestcount</strong> {lang index_guests}
						- {lang index_mostonlines} <strong>$onlineinfo[0]</strong> {lang on} <strong>$onlineinfo[1]</strong>.</span>
					</h3>
				<!--{else}-->
					<!--{if empty($_G['setting']['sessionclose'])}-->
						<span class="o"><a href="forum.php?showoldetails=yes#online" title="{lang spread}"><img src="{IMGDIR}/collapsed_yes.gif" alt="{lang spread}" style="margin-top:9px" /></a></span>
					<!--{/if}-->
					<h3>
						<strong>
							<!--{if !empty($_G['setting']['whosonlinestatus'])}-->
								{lang onlinemember}
							<!--{else}-->
								<a href="home.php?mod=space&do=friend&view=online&type=member">{lang onlinemember}</a>
							<!--{/if}-->
						</strong>
						<span class="xs1">- {lang total} <strong>$onlinenum</strong> {lang onlines}
						<!--{if $membercount}-->- <strong>$membercount</strong> {lang index_members},<strong>$guestcount</strong> {lang index_guests}<!--{/if}-->
						- {lang index_mostonlines} <strong>$onlineinfo[0]</strong> {lang on} <strong>$onlineinfo[1]</strong>.</span>
					</h3>
				<!--{/if}-->
				</div>
			<!--{if $_G['setting']['whosonlinestatus'] && $detailstatus}-->
				<dl id="onlinelist" class="bm_c">
					<dt class="ptm pbm bbda">$_G[cache][onlinelist][legend]</dt>
					<!--{if $detailstatus}-->
						<dd class="ptm pbm">
						<ul class="cl">
						<!--{if $whosonline}-->
							<!--{loop $whosonline $key $online}-->
								<li title="{lang time}: $online[lastactivity]">
								<img src="{STATICURL}image/common/$online[icon]" alt="icon" />
								<!--{if $online['uid']}-->
									<a href="home.php?mod=space&uid=$online[uid]">$online[username]</a>
								<!--{else}-->
									$online[username]
								<!--{/if}-->
								</li>
							<!--{/loop}-->
						<!--{else}-->
							<li style="width: auto">{lang online_only_guests}</li>
						<!--{/if}-->
						</ul>
					</dd>
					<!--{/if}-->
				</dl>
			<!--{/if}-->
			</div>
		<!--{/if}-->

		<!--{if empty($gid) && ($_G['cache']['forumlinks'][0] || $_G['cache']['forumlinks'][1] || $_G['cache']['forumlinks'][2])}-->
		<div class="bm lk">
			<div id="category_lk" class="bm_c ptm">
				<!--{if $_G['cache']['forumlinks'][0]}-->
					<ul class="m mbn cl">$_G['cache']['forumlinks'][0]</ul>
				<!--{/if}-->
				<!--{if $_G['cache']['forumlinks'][1]}-->
					<div class="mbn cl">
						$_G['cache']['forumlinks'][1]
					</div>
				<!--{/if}-->
				<!--{if $_G['cache']['forumlinks'][2]}-->
					<ul class="x mbm cl">
						$_G['cache']['forumlinks'][2]
					</ul>
				<!--{/if}-->
			</div>
		</div>
		<!--{/if}-->

		<!--{hook/index_bottom}-->
	</div>

	<!--{if $_G['setting']['forumallowside']}-->
		<div id="sd" class="sd">
			<!--{hook/index_side_top}-->
			<div class="drag">
				<!--[diy=diy2]--><div id="diy2" class="area"></div><!--[/diy]-->
			</div>
			<!--{hook/index_side_bottom}-->
		</div>
	<!--{/if}-->
</div>
<!--{if $_G['group']['radminid'] == 1}-->
	<!--{eval helper_manyou::checkupdate();}-->
<!--{/if}-->
<!--{if empty($_G['setting']['disfixednv_forumindex']) }--><script>fixed_top_nv();</script><!--{/if}-->
<!--{template common/footer}-->
