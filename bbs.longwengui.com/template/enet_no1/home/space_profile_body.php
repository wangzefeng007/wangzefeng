<?php exit;?>
<div class="bm_c u_profile">

	<div class="pbm mbm bbda cl">
		<h2 class="mbn">
			{$space[username]}
			<!--{if $_G['ols'][$space[uid]]}-->
				<img src="{IMGDIR}/ol.gif" alt="online" title="{lang online}" class="vm" />&nbsp;
			<!--{/if}-->
			<span class="xw0">(UID: {$space[uid]}
			<!--{eval $isfriendinfo = 'home_friend_info_'.$space['uid'].'_'.$_G[uid];}-->
			<!--{if $_G[$isfriendinfo][note]}-->
				, <span class="xg1">$_G[$isfriendinfo][note]</span>
			<!--{/if}-->
			)</span>
		</h2>
		<!--{if CURMODULE == 'space'}-->
			<!--{hook/space_profile_baseinfo_top}-->
		<!--{elseif CURMODULE == 'follow'}-->
			<!--{hook/follow_profile_baseinfo_top}-->
		<!--{/if}-->
		<ul class="pf_l cl pbm mbm">
			<!--{if $_G['setting']['allowspacedomain'] && $_G['setting']['domain']['root']['home'] && checkperm('domainlength') && !empty($space['domain'])}-->
			<!--{eval $spaceurl = 'http://'.$space['domain'].'.'.$_G['setting']['domain']['root']['home'];}-->
			<li><em>{lang second_domain}</em><a href="$spaceurl" onclick="setCopy('$spaceurl', '{lang copy_space_address}');return false;">$spaceurl</a></li>
			<!--{/if}-->
			<!--{if $_G[setting][homepagestyle]}-->
			<li><em>{lang space_visits}</em><strong class="xi1">$space[views]</strong></li>
			<!--{/if}-->
			<!--{if in_array($_G[adminid], array(1, 2))}-->
			<li><em>Email</em>$space[email]</li>
			<!--{/if}-->
			<li><em>{lang email_status}</em><!--{if $space[emailstatus] > 0}-->{lang profile_verified}<!--{else}-->{lang profile_no_verified}<!--{/if}--></li>
			<li><em>{lang video_certification}</em><!--{if $space[videophotostatus] > 0}-->{lang profile_certified} <!--{if $showvideophoto}-->&nbsp;&nbsp;(<a href="home.php?mod=space&uid=$space[uid]&do=videophoto" id="viewphoto" onclick="showWindow(this.id, this.href, 'get', 0)">{lang view_certification_photos}</a>)<!--{/if}--><!--{else}-->{lang profile_no_certified}<!--{/if}--></li>
		</ul>
		<ul>
			<!--{if $space[spacenote]}--><li><em class="xg1">{lang spacenote}&nbsp;&nbsp;</em>$space[spacenote]</li><!--{/if}-->
			<!--{if $space[customstatus]}--><li class="xg1"><em>{lang permission_basic_status}&nbsp;&nbsp;</em>$space[customstatus]</li><!--{/if}-->
			<!--{if $space[group][maxsigsize] && $space[sightml]}--><li><em class="xg1">{lang personal_signature}&nbsp;&nbsp;</em><table><tr><td>$space[sightml]</td></tr></table></li><!--{/if}-->
		</ul>
		<ul class="cl bbda pbm mbm">
			<li>
				<em class="xg2">{lang stat_info}</em>
				<a href="home.php?mod=space&uid=$space[uid]&do=friend&view=me&from=space" target="_blank">{lang friends_num} $space[friends]</a>
				<!--{if helper_access::check_module('doing')}-->
					<span class="pipe">|</span>
					<a href="home.php?mod=space&uid=$space[uid]&do=doing&view=me&from=space" target="_blank">{lang doings_num} $space[doings]</a>
				<!--{/if}-->
				<!--{if helper_access::check_module('blog')}-->
					<span class="pipe">|</span>
					<a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space" target="_blank">{lang blogs_num} $space[blogs]</a>
				<!--{/if}-->
				<!--{if helper_access::check_module('album')}-->
					<span class="pipe">|</span>
					<a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space" target="_blank">{lang albums_num} $space[albums]</a>
				<!--{/if}-->
				<!--{if $_G['setting']['allowviewuserthread'] !== false}-->
					<span class="pipe">|</span>
					<!--{eval $space['posts'] = $space['posts'] - $space['threads'];}-->
					<a href="{if CURMODULE != 'follow'}home.php?mod=space&uid=$space[uid]&do=thread&view=me&type=reply&from=space{else}home.php?mod=space&uid=$space[uid]&view=thread&type=reply{/if}" target="_blank">{lang replay_num} $space[posts]</a>
					<span class="pipe">|</span>
					<a href="{if CURMODULE != 'follow'}home.php?mod=space&uid=$space[uid]&do=thread&view=me&type=thread&from=space{else}home.php?mod=space&uid=$space[uid]&view=thread{/if}" target="_blank">{lang threads_num} $space[threads]</a>
				<!--{/if}-->
				<!--{if helper_access::check_module('share')}-->
					<span class="pipe">|</span>
					<a href="home.php?mod=space&uid=$space[uid]&do=share&view=me&from=space" target="_blank">{lang shares_num} $space[sharings]</a>
				<!--{/if}-->
			</li>
		</ul>
		<!--{if CURMODULE == 'space'}-->
			<!--{hook/space_profile_baseinfo_middle}-->
		<!--{elseif CURMODULE == 'follow'}-->
			<!--{hook/follow_profile_baseinfo_middle}-->
		<!--{/if}-->
		<ul class="pf_l cl">
			<!--{loop $profiles $value}-->
			<li><em>$value[title]</em>$value[value]</li>
			<!--{/loop}-->
		</ul>
	</div>
<!--{if CURMODULE == 'space'}-->
	<!--{hook/space_profile_baseinfo_bottom}-->
<!--{elseif CURMODULE == 'follow'}-->
	<!--{hook/follow_profile_baseinfo_bottom}-->
<!--{/if}-->
<!--{if $space['medals']}-->
	<div class="pbm mbm bbda cl">
		<h2 class="mbn">{lang medals}</h2>
		<p class="md_ctrl">
			<a href="home.php?mod=medal">
			<!--{loop $space['medals'] $medal}-->
				<img src="{STATICURL}/image/common/$medal[image]" alt="$medal[name]" id="md_{$medal[medalid]}" onmouseover="showMenu({'ctrlid':this.id, 'menuid':'md_{$medal[medalid]}_menu', 'pos':'12!'});" />
			<!--{/loop}-->
			</a>
		</p>
	</div>
	<!--{loop $space['medals'] $medal}-->
		<div id="md_{$medal[medalid]}_menu" class="tip tip_4" style="display: none;">
			<div class="tip_horn"></div>
			<div class="tip_c">
				<h4>$medal[name]</h4>
				<p>$medal[description]</p>
			</div>
		</div>
	<!--{/loop}-->
<!--{/if}-->
<!--{if $_G['setting']['verify']['enabled']}-->
	<!--{eval $showverify = true;}-->
	<!--{loop $_G['setting']['verify'] $vid $verify}-->
		<!--{if $verify['available']}-->
			<!--{if $showverify}-->
			<div class="pbm mbm bbda cl">
			<h2 class="mbn">{lang profile_verify}</h2>
			<!--{eval $showverify = false;}-->
			<!--{/if}-->

			<!--{if $space['verify'.$vid] == 1}-->
				<a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid" target="_blank"><!--{if $verify['icon']}--><img src="$verify['icon']" class="vm" alt="$verify[title]" title="$verify[title]" /><!--{else}-->$verify[title]<!--{/if}--></a>&nbsp;
			<!--{elseif !empty($verify['unverifyicon'])}-->
				<a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid" target="_blank"><!--{if $verify['unverifyicon']}--><img src="$verify['unverifyicon']" class="vm" alt="$verify[title]" title="$verify[title]" /><!--{/if}--></a>&nbsp;
			<!--{/if}-->

		<!--{/if}-->
	<!--{/loop}-->
	<!--{if !$showverify}--></div><!--{/if}-->
<!--{/if}-->
<!--{if $count}-->
	<div class="pbm mbm bbda cl">
		<h2 class="mbn">{lang manage_forums}</h2>
		<!--{loop $manage_forum $key $value}-->
		<a href="forum.php?mod=forumdisplay&fid=$key" target="_blank">$value</a> &nbsp;
		<!--{/loop}-->
	</div>
<!--{/if}-->
<!--{if $groupcount}-->
	<div class="pbm mbm bbda cl">
		<h2 class="mbn">{lang joined_group}</h2>
		<!--{loop $usergrouplist $key $value}-->
		<a href="forum.php?mod=group&fid={$value['fid']}" target="_blank">$value['name']</a> &nbsp;
		<!--{/loop}-->
	</div>
<!--{/if}-->
<div class="pbm mbm bbda cl">
	<h2 class="mbn">{lang active_profile}</h2>
	<ul>
		<!--{if $space[adminid]}--><li><em class="xg1">{lang management_team}&nbsp;&nbsp;</em><span style="color:{$space[admingroup][color]}"><a href="home.php?mod=spacecp&ac=usergroup&gid=$space[adminid]" target="_blank">{$space[admingroup][grouptitle]}</a></span> {$space[admingroup][icon]}</li><!--{/if}-->
		<li><em class="xg1">{lang usergroup}&nbsp;&nbsp;</em><span style="color:{$space[group][color]}"{if $upgradecredit !== false} class="xi2" onmouseover="showTip(this)" tip="{lang credits} $space[credits], {lang thread_groupupgrade} $upgradecredit {lang credits}"{/if}><a href="home.php?mod=spacecp&ac=usergroup&gid=$space[groupid]" target="_blank">{$space[group][grouptitle]}</a></span> {$space[group][icon]} <!--{if !empty($space['groupexpiry'])}-->&nbsp;{lang group_useful_life}&nbsp;<!--{date($space[groupexpiry], 'Y-m-d H:i')}--><!--{/if}--></li>
		<!--{if $space[extgroupids]}--><li><em class="xg1">{lang group_expiry_type_ext}&nbsp;&nbsp;</em>$space[extgroupids]</li><!--{/if}-->
	</ul>
	<ul id="pbbs" class="pf_l">
		<!--{if $space[oltime]}--><li><em>{lang online_time}</em>$space[oltime] {lang hours}</li><!--{/if}-->
		<li><em>{lang regdate}</em>$space[regdate]</li>
		<li><em>{lang last_visit}</em>$space[lastvisit]</li>
		<!--{if $_G[uid] == $space[uid] || $_G[group][allowviewip]}-->
		<li><em>{lang register_ip}</em>$space[regip] - $space[regip_loc]</li>
		<li><em>{lang last_visit_ip}</em>$space[lastip] - $space[lastip_loc]</li>
		<!--{/if}-->
		<!--{if $space[lastactivity]}--><li><em>{lang last_activity_time}</em>$space[lastactivity]</li><!--{/if}-->
		<!--{if $space[lastpost]}--><li><em>{lang last_post_time}</em>$space[lastpost]</li><!--{/if}-->
		<!--{if $space[lastsendmail]}--><li><em>{lang last_send_email}</em>$space[lastsendmail]</li><!--{/if}-->
		<li><em>{lang time_offset}</em>
			<!--{eval $timeoffset = array({lang timezone});}-->
			$timeoffset[$space[timeoffset]]
		</li>
	</ul>
</div>
<div id="psts" class="{if $clist}pbm mbm bbda {/if}cl">
	<h2 class="mbn">{lang stat_info}</h2>
	<ul class="pf_l">
		<li><em>{lang used_space}</em>$space[attachsize]</li>
		<!--{if $space[buyercredit]}-->
		<li><em>{lang eccredit_sellerinfo}</em><a href="home.php?mod=space&uid=$space[uid]&do=trade&view=eccredit#sellcredit" target="_blank">$space[buyercredit] <img src="{STATICURL}image/traderank/buyer/$space[buyerrank].gif" border="0" class="vm" /></a></li>
		<!--{/if}-->
		<!--{if $space[sellercredit]}-->
		<li><em>{lang eccredit_buyerinfo}</em><a href="home.php?mod=space&uid=$space[uid]&do=trade&view=eccredit#buyercredit" target="_blank">$space[sellercredit] <img src="{STATICURL}image/traderank/seller/$space[sellerrank].gif" border="0" class="vm" /></a></li>
		<!--{/if}-->
		<li><em>{lang credits}</em>$space[credits]</li>
		<!--{loop $_G[setting][extcredits] $key $value}-->
		<!--{if $value[title]}-->
		<li><em>$value[title]</em>{$space["extcredits$key"]} $value[unit]</li>
		<!--{/if}-->
		<!--{/loop}-->
	</ul>
</div>
<!--{if $clist}-->
<div class="cl">
	<h2 class="mbm">{lang crime_record}</h2>
	<table id="pcr" class="dt">
		<tr>
			<th width="15%">{lang crime_action}</th>
			<th width="15%">{lang crime_dateline}</th>
			<th>{lang crime_reason}</th>
			<th width="15%">{lang crime_operator}</th>
		</tr>
		<!--{loop $clist $crime}-->
		<tr>
			<td>
				<!--{if $crime[action] == 'crime_delpost'}-->
					{lang crime_delpost}
				<!--{elseif $crime[action] == 'crime_warnpost'}-->
					{lang crime_warnpost}
				<!--{elseif $crime[action] == 'crime_banpost'}-->
					{lang crime_banpost}
				<!--{elseif $crime[action] == 'crime_banspeak'}-->
					{lang crime_banspeak}
				<!--{elseif $crime[action] == 'crime_banvisit'}-->
					{lang crime_banvisit}
				<!--{elseif $crime[action] == 'crime_banstatus'}-->
					{lang crime_banstatus}
				<!--{elseif $crime[action] == 'crime_avatar'}-->
					{lang crime_avatar}
				<!--{elseif $crime[action] == 'crime_sightml'}-->
					{lang crime_sightml}
				<!--{elseif $crime[action] == 'crime_customstatus'}-->
					{lang crime_customstatus}
				<!--{/if}-->
			</td>
			<td><!--{date($crime[dateline])}--></td>
			<td>$crime[reason]</td>
			<td><a href="home.php?mod=space&uid=$crime[operatorid]" target="_blank">$crime[operator]</a></td>
		</tr>
		<!--{/loop}-->
	</table>
</div>
<!--{/if}-->
<!--{if CURMODULE == 'space'}-->
	<!--{hook/space_profile_extrainfo}-->
<!--{elseif CURMODULE == 'follow'}-->
	<!--{hook/follow_profile_extrainfo}-->
<!--{/if}-->
</div>