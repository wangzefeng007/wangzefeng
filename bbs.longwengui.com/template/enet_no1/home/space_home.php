<?php exit;?>
<!--{if empty($diymode)}-->
	<!--{template common/header}-->
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<!--{if 1}--><a href="home.php">{lang feed}</a></a><!--{/if}-->
		</div>
	</div>

	<!--{if 1}--><!--{ad/text/wp a_t}--><!--{/if}-->
	<style id="diy_style" type="text/css"></style>
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>
<style>
.mn .xld .m{margin-left:-65px !important;margin-right:0 !important}
.ct3_a .mn {border:0 !Important;width:601px;margin: 0;}
.appl{width:117px}
.bm_h{background:transparent}
.sd{margin-left: 20px;}
.el .cl{font-size: 14px;padding-left: 0}
.cmt .cl {font-size: 12px}
.cmt span,.brm span,.cmt a, .brm a,.cmt div, .brm div,.cmt span, .brm span{font-size:12px}
.cmt{margin-top:0 !Important}
.ec{font-size:12px}
.avt a{padding:0;border:0}
.tb {margin-top: 0}
.xlda .el li {padding-top: 10px}
.xlda dl {padding-left: 65px !important;padding-top: 10px}
.bbda{border-bottom: 1px dotted #E4E4E4}
.tbmu .a {color: white;font-weight: 700;background: #0A8CD2;border-radius:5px}
.tbmu a {color: #369;padding: 4px 8px}
.tbmu .pipe{display:none}
.tbmu{border-bottom:0;padding-left:10px}
.appl{float:left;background:transparent;border:0 !Important;}
#ct{border:1px solid #dfdfdf !important;border-radius:5px}
.ct3_a .sd{width:230px}
.ct3_a .mn{padding:0 !important;padding-top:15px !Important;margin-top:0}
.avts img{width:50px !important;height:50px !important;border-radius:5px}
.appl{float:left;background:transparent;border:0 !Important}
.mn th{display:none}
.bbda .avt a{border-radius:5px}
.bbda .avt a img{border-radius:5px}
.ml li a{border-radius:5px}
.ml li a img{border-radius:5px}
.mls li {width: 73px;}
</style>
	<div id="ct" class="{if 1}ct3_a{else}ct10_a{/if} wp cl bf">
		<div class="appl">
		<!--{if 1}-->
		<!--{if $_G['uid']}-->
			<div style="width:248px;height:55px;margin-bottom:8px"><div style="width: 100%;height: 55px;"><div class="avtss" style="width: 50px;Float:left"><a href="home.php?mod=space&uid=$_G[uid]">
			<div style="width: 50px;height: 50px;margin: 0 !important;" class="avts"><!--{avatar($_G[uid],big)}--></div></a></div>
              <div class="name" style="margin-left:8px;float: left;width: 120px;margin-top: 5px;font-weight: bold">
                  <a href="home.php?mod=space&uid=$_G[uid]" style="float:left">{$_G[member][username]}</a>
				  <th class="alt"><span class="notice" style="float:left;font-weight: normal;background:none;padding-left:0">{lang credits}: $space[credits]</span></th>
                 </div>
				 </div>
					</div>
		<!--{/if}-->
				<!--{template common/userabout}-->
			<!--{else}-->
				<div class="tbn">
					<h2 class="mt bbda">{lang feed}</h2>
					<ul>
						<li$actives[we]><a href="home.php?mod=space&do=home&view=we">{lang friend_feed}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=home&view=me">{lang my_feed}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=home&view=all">{lang view_all}</a></li>
						<!--{if $_G['setting']['my_app_status']}-->
						<li$actives[app]><a href="home.php?mod=space&do=home&view=app">{lang view_app_feed}</a></li>
						<!--{/if}-->
						<!--{hook/space_home_navlink}-->
					</ul>
				</div>
			<!--{/if}-->
		</div>
		<!--/sidebar-->
		<!--{if 1}-->
		<div class="sd ptm">
			<!--{hook/space_home_side_top}-->
			<div class="drag">
				<!--[diy=diysidetop]--><div id="diysidetop" class="area"></div><!--[/diy]-->
			</div>
			<!--{if $_G[uid] }-->
				<!--{if $space[profileprogress] != 100}-->
					<div class="bm">
						<div class="bm_c">
							<div class="pbg mbn"><div class="pbr" style="width: {if $space[profileprogress] < 2}2{else}$space[profileprogress]{/if}%;"></div></div>
							<p>{lang profile_completed} $space[profileprogress]%, <a href="home.php?mod=spacecp&ac=profile" class="xi2">{lang fix_profile}</a></p>
						</div>
					</div>
				<!--{/if}-->
				<!--{if $_G['setting']['taskon'] && !empty($task) && is_array($task)}-->
				<div class="bm">
					<div class="bm_h cl">
						<span class="y">
							<a href="home.php?mod=task">{lang all}</a>
						</span>
						<h2>{lang task}</h2>
					</div>
					<div class="bm_c">
						<p class="pbm">{lang space_home_message}</p>
						<hr class="da m0" />
						<dl class="xld cl">
							<dd class="m mbw"><img src="$task[icon]" width="64" height="64" alt="Icon" /></dd>
							<dt><a href="home.php?mod=task&do=view&id=$task[taskid]">$task[name]</a></dt>
							<dd>
								<p>$task[description]</p>
								<!--{if in_array($task['reward'], array('credit', 'magic', 'medal', 'invite', 'group'))}-->
									<p class="mtn">
										<!--{if $task['reward'] == 'credit'}-->
											{lang gettable}$_G['setting']['extcredits'][$task[prize]][title] <strong class="xi1">$task[bonus]</strong> $_G['setting']['extcredits'][$task[prize]][unit]
										<!--{elseif $task['reward'] == 'magic'}-->
											{lang gettable}{lang magics_title} $listdata[$task[prize]] <strong class="xi1">$task[bonus]</strong> {lang magics_unit}
										<!--{elseif $task['reward'] == 'medal'}-->
											{lang gettable}{lang medals} <strong class="xi1">1</strong> {lang unit}
										<!--{elseif $task['reward'] == 'invite'}-->
											{lang gettable}{lang invite_code} <strong class="xi1">$task[prize]</strong> {lang unit}
										<!--{elseif $task['reward'] == 'group'}-->
											{lang step_up}{lang usergroup}{lang level}
										<!--{/if}-->
									</p>
								<!--{/if}-->
							</dd>
						</dl>
					</div>
				</div>
				<!--{/if}-->
				<div class="drag">
					<!--[diy=diymagictop]--><div id="diymagictop" class="area"></div><!--[/diy]-->
				</div>
				<!--{if !empty($magic) && is_array($magic)}-->
				<div class="bm">
					<div class="bm_h cl">
						<span class="y">
							<a href="home.php?mod=magic">{lang all}</a>
						</span>
						<h2>{lang magic}</h2>
					</div>
					<div class="bm_c">
						<dl class="xld cl">
							<dd class="m mbw"><img src="{STATICURL}/image/magic/$magic[pic]" alt="$magic[name]" title="$magic[description]" /></dd>
							<dt>$magic[name]</dt>
							<dd>
								<p>$magic[description]</p>
								<p class="mtn">{lang magics_price}
									<!--{if {$_G['setting']['extcredits'][$magic[credit]][unit]}}-->
										{$_G['setting']['extcredits'][$magic[credit]][title]} <strong class="xi1">$magic[price]</strong> {$_G['setting']['extcredits'][$magic[credit]][unit]}/{lang magics_unit}
									<!--{else}-->
										<strong class="xi1">$magic[price]</strong> {$_G['setting']['extcredits'][$magic[credit]][title]}/{lang magics_unit}
									<!--{/if}-->
								</p>
								<p class="mtn">
									<!--{if $magic[num] > 0}-->
										<a href="home.php?mod=magic&action=shop&operation=buy&mid=$magic[identifier]" onclick="showWindow('magics', this.href);return false;" class="xi2 xw1">{lang magics_operation_buy}</a>
										<!--{if $_G['group']['allowmagics'] > 1}-->
											<span class="pipe">|</span>
											<a href="home.php?mod=magic&action=shop&operation=give&mid=$magic[identifier]" onclick="showWindow('magics', this.href);return false;" class="xi2">{lang magics_operation_present}</a>
										<!--{/if}-->
									<!--{else}-->
										<span class="xg1">{lang magic_empty}</span>
									<!--{/if}-->
								</p>
							</dd>
						</dl>
					</div>
				</div>
				<!--{/if}-->
			<!--{/if}-->
				<div class="drag">
					<!--[diy=diydefaultusertop]--><div id="diydefaultusertop" class="area"></div><!--[/diy]-->
				</div>
				<!--{if $defaultusers}-->
				<div class="bm">
					<div class="bm_h cl">
						<h2>{lang friends_recommended}</h2>
					</div>
					<div class="bm_c">
						<ul class="ml mls cl">
							<!--{loop $defaultusers $key $value}-->
							<li>
								<a href="home.php?mod=space&uid=$value[uid]" title="{if $ols[$value[uid]]}{lang online}{/if}" class="avt">
									<!--{if $ols[$value[uid]]}--><em class="gol"></em><!--{/if}-->
									<!--{avatar($value[uid],small)}-->
								</a>
								<p><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></p>
							</li>
							<!--{/loop}-->
						</ul>
					</div>
				</div>
				<!--{/if}-->

				<div class="drag">
					<!--[diy=diynewusertop]--><div id="diynewusertop" class="area"></div><!--[/diy]-->
				</div>

				<!--{if $showusers}-->
				<div class="bm">
					<div class="bm_h cl">
						<span class="y">
							<a href="misc.php?mod=ranklist&type=member">{lang all}</a>
						</span>
						<h2>{lang home_show_members}</h2>
					</div>
					<div class="bm_c">
						<ul class="ml mls cl">
							<!--{loop $showusers $key $value}-->
							<li>
								<a href="home.php?mod=space&uid=$value[uid]" title="{if $ols[$value[uid]]}{lang online}{/if}" class="avt">
									<!--{if $ols[$value[uid]]}--><em class="gol"></em><!--{/if}-->
									<!--{avatar($value[uid],small)}-->
								</a>
								<p><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></p>
								<!--span><span title="$value[credit]">$value[credit]</span></span-->
							</li>
							<!--{/loop}-->
						</ul>
					</div>
				</div>
				<!--{/if}-->

				<!--{if $newusers}-->
				<div class="bm">
					<div class="bm_h cl">
						<h2>{lang new_join_members}</h2>
					</div>
					<div class="bm_c">
						<ul class="ml mls cl">
							<!--{loop $newusers $key $value}-->
							<li>
								<a href="home.php?mod=space&uid=$value[uid]" title="{if $ols[$value[uid]]}{lang online}{/if}" class="avt">
									<!--{if $ols[$value[uid]]}--><em class="gol"></em><!--{/if}-->
									<!--{avatar($value[uid],small)}-->
								</a>
								<p><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></p>
								<span>$value[regdate]</span>
							</li>
							<!--{/loop}-->
						</ul>
					</div>
				</div>
				<!--{/if}-->

				<div class="drag">
					<!--[diy=diyvisitorlisttop]--><div id="diyvisitorlisttop" class="area"></div><!--[/diy]-->
				</div>

				<!--{if $visitorlist}-->
				<div class="bm">
					<div class="bm_h cl">
						<span class="y">
							<!--{if $_G['setting']['magicstatus'] && $_G['setting']['magics']['visit']}-->
							<a id="a_magic_visit" href="home.php?mod=magic&mid=visit" onclick="showWindow('magics',this.href,'get', 0)" class="xg1" style="display: inline-block; padding-left: 18px; background: url({STATICURL}image/magic/visit.small.gif) no-repeat 0 50%;">{$_G[setting][magics][visit]}</a>
							<!--{/if}-->
							<a href="home.php?mod=space&uid=$space[uid]&do=friend&view=visitor">{lang all}</a>
						</span>
						<h2>{lang recent_visit}</h2>
					</div>
					<div class="bm_c">
						<ul class="ml mls cl">
							<!--{loop $visitorlist $key $value}-->
							<li>
								<!--{if $value[vusername] == ''}-->
								<div class="avt"><img src="{STATICURL}image/magic/hidden.gif" alt="{lang anonymity}" /></div>
								<p>{lang anonymity}</p>
								<span><!--{date($value[dateline], 'u', 9999, $_G[setting][dateformat])}--></span>
								<!--{else}-->
								<a href="home.php?mod=space&uid=$value[vuid]" title="{if $ols[$value[vuid]]}{lang online}{/if}" class="avt" c="1">
									<!--{if $ols[$value[vuid]]}--><em class="gol"></em><!--{/if}-->
									<!--{avatar($value[vuid],small)}-->
								</a>
								<p><a href="home.php?mod=space&uid=$value[vuid]" title="$value[vusername]">$value[vusername]</a></p>
								<span><!--{date($value[dateline], 'u', 9999, $_G[setting][dateformat])}--></span>
								<!--{/if}-->
							</li>
							<!--{/loop}-->
						</ul>
					</div>
				</div>
				<!--{/if}-->

				<div class="drag">
					<!--[diy=diyfriendtop]--><div id="diyfriendtop" class="area"></div><!--[/diy]-->
				</div>

				<!--{if $olfriendlist}-->
				<div class="bm">
					<div class="bm_h cl">
						<span class="y">
							<!--{if $_G['setting']['magicstatus'] && $_G['setting']['magics']['detector']}-->
							<a id="a_magic_detector" href="home.php?mod=magic&mid=detector" onclick="showWindow('magics',this.href,'get', 0)" class="xg1" style="display: inline-block; padding-left: 18px; background: url({STATICURL}image/magic/detector.small.gif) no-repeat 0 50%;">{$_G[setting][magics][detector]}</a>
							<!--{/if}-->
							<a href="home.php?mod=space&uid=$space[uid]&do=friend">{lang all}</a>
						</span>
						<h2>{lang my_friends}</h2>
					</div>
					<div class="bm_c">
						<ul class="ml mls cl">
							<!--{loop $olfriendlist $key $value}-->
							<li>
								<a href="home.php?mod=space&uid=$value[uid]" title="{if $ols[$value[uid]]}{lang online}{/if}" class="avt" c="1">
									<!--{if $ols[$value[uid]]}--><em class="gol"></em><!--{/if}-->
									<!--{avatar($value[uid],small)}-->
								</a>
								<p><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></p>
								<span><!--{if $value[lastactivity]}--><!--{date($value[lastactivity], 'u', 9999, $_G[setting][dateformat])}--><!--{else}-->{lang hot}($value[num])<!--{/if}--></span>
							</li>
							<!--{/loop}-->
						</ul>
					</div>
				</div>
				<!--{/if}-->

				<div class="drag">
					<!--[diy=diybirthtop]--><div id="diybirthtop" class="area"></div><!--[/diy]-->
				</div>

				<!--{if $birthlist}-->
				<div class="bm">
					<div class="bm_h cl">
						<h2>{lang friends_birthday_reminder}</h2>
					</div>
					<div class="bm_c">
						<table cellpadding="2" cellspacing="4">
						<!--{loop $birthlist $key $values}-->
						<tr>
							<td align="right" valign="top">
							<!--{if $values[0]['istoday']}-->{lang today}<!--{else}-->{$values[0][birthmonth]}-{$values[0][birthday]}<!--{/if}-->
							</td>
							<td style="padding-left:10px;">
								<ul>
								<!--{loop $values $value}-->
								<li><a href="home.php?mod=space&uid=$value[uid]">$value[username]</a></li>
								<!--{/loop}-->
								</ul>
							</td>
						</tr>
						<!--{/loop}-->
						</table>
					</div>
				</div>
				<!--{/if}-->

			<div class="drag">
				<!--[diy=diysidebottom]--><div id="diysidebottom" class="area"></div><!--[/diy]-->
			</div>

			<!--{hook/space_home_side_bottom}-->
		</div>
		<!--{/if}-->
		<div class="mn ptm pbm bf">
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
			<!--{if $space['uid'] && $space[self]}-->	
		<!--{if 1}-->
		<!--{else}-->
		<!--{/if}-->
			 <!--{if 1}-->
				<div class="bw0">
					<table cellpadding="0" cellspacing="0" class="mi">
						<tr>
							<th>
								<div class="avatar mbn cl">
									<a href="home.php?mod=spacecp&ac=avatar" title="{lang memcp_avatar}" id="edit_avt"><span id="edit_avt_tar">{lang memcp_avatar}</span><!--{avatar($_G[uid],middle)}--></a>
								</div>
								<p><a href="home.php?mod=space&uid=$space[uid]" target="_blank" class="o xi2">{lang view_my_space}</a></p>
							</th>
							<td>
								<h3 class="xs2">
									<!--{eval g_icon($space[groupid]);}-->
								</h3>
								<!--{template home/space_status}-->
							</td>
						</tr>
					</table>
					<!--[diy=diycontentmiddle]--><div id="diycontentmiddle" class="area"></div><!--[/diy]-->
					<!--{hook/space_home_top}-->

				</div>

				<!--{ad/feed/bm}-->

				<div class="bm bw0">
					<ul class="tb cl">
						<li$actives[we]><a href="home.php?mod=space&do=home&view=we">{lang friend_feed}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=home&view=me">{lang my_feed}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=home&view=all">{lang view_all}</a></li>
						<!--{if $_G['setting']['my_app_status']}-->
						<li$actives[app]><a href="home.php?mod=space&do=home&view=app">{lang view_app_feed}</a></li>
						<!--{/if}-->
						<!--{hook/space_home_navlink}-->
						<!--{if $_G['setting']['magicstatus'] && $_G['setting']['magics']['thunder']}-->
						<li class="y"><a id="a_magic_thunder" href="home.php?mod=magic&mid=thunder" onclick="showWindow('magics', this.href, 'get', 0)" style="padding-left: 18px; background: url({STATICURL}image/magic/thunder.small.gif) no-repeat 0 50%;">{$_G[setting][magics][thunder]}</a></li>
						<!--{/if}-->
					</ul>
				<!--{/if}-->
			<!--{else}-->
				<div class="bm bw0">
				<!--{eval
					$_G['home_tpl_spacemenus'][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=home&view=me\">{lang they_feed}</a>";
				}-->
				<!--{template home/space_menu}-->

			<!--{/if}-->

			<!--{if $_GET[view] == 'all'}-->
				<p class="tbmu">
					<!--{if !1 && $_G['setting']['magicstatus'] && $_G['setting']['magics']['thunder']}-->
					<a id="a_magic_thunder" href="home.php?mod=magic&mid=thunder" onclick="showWindow('magics', this.href, 'get', 0)" style="padding-left: 18px; background: url({STATICURL}image/magic/thunder.small.gif) no-repeat 0 50%;" class="y">{$_G[setting][magics][thunder]}</a>
					<!--{/if}-->
					<a href="home.php?mod=space&do=home&view=all&order=dateline"$orderactives[dateline]>{lang newest_feed}</a><span class="pipe">|</span>
					<a href="home.php?mod=space&do=home&view=all&order=hot"$orderactives[hot]>{lang hot_feed}</a>
				</p>
			<!--{elseif $_GET[view] == 'app' && $_G['setting']['my_app_status']}-->
				<p class="tbmu">
					<a href="home.php?mod=space&do=home&view=app&type=we"$typeactives[we]>{lang what_friend_playing}</a><span class="pipe">|</span>
					<a href="home.php?mod=space&do=home&view=app&type=me"$typeactives[me]>{lang own}</a><span class="pipe">|</span>
					<a href="home.php?mod=space&do=home&view=app&type=all"$typeactives[all]>{lang what_everybody_playing}</a>
				</p>
			<!--{elseif $groups}-->
				<p class="tbmu">
					<!--{if !1 && $_G['setting']['magicstatus'] && $_G['setting']['magics']['thunder']}-->
					<a id="a_magic_thunder" href="home.php?mod=magic&mid=thunder" onclick="showWindow('magics', this.href, 'get', 0)" style="padding-left: 18px; background: url({STATICURL}image/magic/thunder.small.gif) no-repeat 0 50%;" class="y">{$_G[setting][magics][thunder]}</a>
					<!--{/if}-->
					<a href="home.php?mod=space&do=home&view=we"{$gidactives[-1]}>{lang all_friends}</a><!--{loop $groups $key $value}--><span class="pipe">|</span><a href="home.php?mod=space&do=home&view=we&gid=$key"{$gidactives[$key]}>$value</a><!--{/loop}-->
				</p>
			<!--{elseif !1 && $_G['setting']['magicstatus'] && $_G['setting']['magics']['thunder']}-->
				<p class="tbmu cl">
					<a id="a_magic_thunder" href="home.php?mod=magic&mid=thunder" onclick="showWindow('magics', this.href, 'get', 0)" style="padding-left: 18px; background: url({STATICURL}image/magic/thunder.small.gif) no-repeat 0 50%;" class="y">{$_G[setting][magics][thunder]}</a>
				</p>
			<!--{/if}-->

<!--{else}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<!--{subtemplate home/space_header}-->
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
					<div class="bm_h">
						<h1 class="mt">{lang feed}</h1>
					</div>
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->
		<div id="pt" class="bm cl">
			<div class="z">
				<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]">{$space[username]}</a> <em>&rsaquo;</em>
				{lang memcp_profile}
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
<!--{/if}-->

			<div id="feed_div" class="e">
			<!--{if $hotlist}-->
				<h4 class="et"><a href="home.php?mod=space&do=home&view=all&order=hot" class="y xw0">{lang view_more_hot} <em>&rsaquo;</em></a>{lang recent_recommended_hot}</h4>
				<ul class="el">
				<!--{loop $hotlist $value}-->
				<!--{eval $value = mkfeed($value);}-->
				<!--{template home/space_feed_li}-->
				<!--{/loop}-->
				</ul>
			<!--{/if}-->

			<!--{if $list}-->
				<!--{if $_GET[view] == 'app' && $_G['setting']['my_app_status']}-->
					<!--{template home/space_home_feed_app}-->
				<!--{else}-->
					<!--{loop $list $day $values}-->
						<!--{if $_GET['view']!='hot'}-->
						<!--{/if}-->

						<ul class="el">
						<!--{loop $values $value}-->
							<!--{template home/space_feed_li}-->
						<!--{/loop}-->
						</ul>
					<!--{/loop}-->
				<!--{/if}-->
			<!--{elseif $feed_users}-->
				<div class="xld xlda">
				<!--{loop $feed_users $day $users}-->
				<!--{loop $users $user}-->
				<!--{eval $daylist = $feed_list[$day][$user[uid]];}-->
				<!--{eval $morelist = $more_list[$day][$user[uid]];}-->
				<dl class="bbda cl">
					<dd class="m avt">
						<!--{if $user[uid]}-->
						<a href="home.php?mod=space&uid=$user[uid]" target="_blank" c="1"><!--{avatar($user[uid],small)}--></a>
						<!--{else}-->
						<img src="{IMGDIR}/systempm.png" alt="" />
						<!--{/if}-->
					</dd>
					<dd class="cl">
						<ul class="el">
						<!--{loop $daylist $value}-->
							<!--{template home/space_feed_li}-->
						<!--{/loop}-->
						</ul>

						<!--{if $morelist}-->
						<p class="xg1 cl"><span onclick="showmore('$day', '$user[uid]', this);" class="unfold">{lang open}</span></p>
						<div id="feed_more_div_{$day}_{$user[uid]}" style="display:none;">
							<ul class="el">
							<!--{loop $morelist $value}-->
								<!--{template home/space_feed_li}-->
							<!--{/loop}-->
							</ul>
						</div>
						<!--{/if}-->
					</dd>
				</dl>
				<!--{/loop}-->
				<!--{/loop}-->
				</div>
			<!--{else}-->
				<p class="emp"><!--{if $_GET[view] == 'app' && $_G['setting']['my_app_status']}-->{lang no_app_feed}<!--{else}-->{lang no_feed}<!--{/if}--></p>
			<!--{/if}-->

			<!--{if $filtercount}-->
				<div class="i" id="feed_filter_notice_{$start}">
					{lang depending_your}<a href="home.php?mod=spacecp&ac=privacy&op=filter" target="_blank" class="xi2 xw1">{lang filter_settings}</a>,{lang shield_feed_message} (<a href="javascript:;" onclick="filter_more($start);" id="a_feed_privacy_more" class="xi2">{lang click_view}</a>)
				</div>
				<div id="feed_filter_div_{$start}" style="display:none;">
					<h4 class="et">{lang following_feed_shielding}</h4>
					<ul class="el">
					<!--{loop $filter_list $value}-->
					<!--{template home/space_feed_li}-->
					<!--{/loop}-->
					<li><a href="javascript:;" onclick="filter_more($start);">&laquo; {lang pack_up}</a></li>
					</ul>
				</div>
			<!--{/if}-->

			</div>
			<!--/id=feed_div-->

<!--{if empty($diymode)}-->

			<!--{if $multi}-->
				<div class="pgs cl mtm">$multi</div>
			<!--{/if}-->

			<!--{hook/space_home_bottom}-->
			<div id="ajax_wait"></div>
		</div>

		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->
	</div>
	<!--/content-->
</div>

<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<!--{else}-->

			</div>
		</div>
	<!--{if $_G[setting][homepagestyle]}-->
	</div>
	<div class="sd">
		<!--{subtemplate home/space_userabout}-->
	<!--{/if}-->
</div>
<!--{/if}-->

<!--{eval helper_manyou::checkupdate();}-->

<script type="text/javascript">
	function filter_more(id) {
		if($('feed_filter_div_'+id).style.display == '') {
			$('feed_filter_div_'+id).style.display = 'none';
			$('feed_filter_notice_'+id).style.display = '';
		} else {
			$('feed_filter_div_'+id).style.display = '';
			$('feed_filter_notice_'+id).style.display = 'none';
		}
	}

	function close_feedbox() {
		var x = new Ajax();
		x.get('home.php?mod=spacecp&ac=common&op=closefeedbox', function(s){
			$('feed_box').style.display = 'none';
		});
	}

	function showmore(day, uid, e) {
		var obj = 'feed_more_div_'+day+'_'+uid;
		$(obj).style.display = $(obj).style.display == ''?'none':'';
		if(e.className == 'unfold'){
			e.innerHTML = '{lang pack_up}';
			e.className = 'fold';
		} else if(e.className == 'fold') {
			e.innerHTML = '{lang open}';
			e.className = 'unfold';
		}
	}

	var elems = selector('li[class~=magicthunder]', $('feed_div'));
	for(var i=0; i<elems.length; i++){
		magicColor(elems[i]);
	}

	function showEditAvt(id) {
		$(id).style.display = $(id).style.display == '' ? 'block' : '';
	}
	if($('edit_avt') && BROWSER.ie && BROWSER.ie == 6) {
		_attachEvent($('edit_avt'), 'mouseover', function () { showEditAvt('edit_avt_tar'); });
		_attachEvent($('edit_avt'), 'mouseout', function () { showEditAvt('edit_avt_tar'); });
	}
</script>

<!--{template common/footer}-->