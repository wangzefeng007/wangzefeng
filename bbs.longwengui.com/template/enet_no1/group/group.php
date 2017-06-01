<?php exit;?>
<!--{subtemplate common/header_common}-->
	<meta name="application-name" content="$_G['setting']['bbname']" />
	<meta name="msapplication-tooltip" content="$_G['setting']['bbname']" />
	<!--{if $_G['setting']['portalstatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][1]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G[siteurl].'portal.php'};icon-uri={$_G[siteurl]}{IMGDIR}/portal.ico" /><!--{/if}-->
	<meta name="msapplication-task" content="name=$_G['setting']['navs'][2]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G[siteurl].'forum.php'};icon-uri={$_G[siteurl]}{IMGDIR}/bbs.ico" />
	<!--{if $_G['setting']['groupstatus']}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][3]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G[siteurl].'group.php'};icon-uri={$_G[siteurl]}{IMGDIR}/group.ico" /><!--{/if}-->
	<!--{if helper_access::check_module('feed')}--><meta name="msapplication-task" content="name=$_G['setting']['navs'][4]['navname'];action-uri={echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G[siteurl].'home.php'};icon-uri={$_G[siteurl]}{IMGDIR}/home.ico" /><!--{/if}-->
	<!--{if $_G['basescript'] == 'forum' && $_G['setting']['archiver']}-->
		<link rel="archives" title="$_G['setting']['bbname']" href="{$_G[siteurl]}archiver/" />
	<!--{/if}-->
	<!--{if !empty($rsshead)}-->$rsshead<!--{/if}-->
	<!--{if widthauto()}-->
		<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_{STYLEID}_widthauto.css?{VERHASH}" />
		<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
	<!--{/if}-->
	<!--{if $_G['basescript'] == 'forum' || $_G['basescript'] == 'group'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}forum.js?{VERHASH}"></script>
	<!--{elseif $_G['basescript'] == 'home' || $_G['basescript'] == 'userapp'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}home.js?{VERHASH}"></script>
	<!--{elseif $_G['basescript'] == 'portal'}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}portal.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)}-->
		<script type="text/javascript" src="{$_G[setting][jspath]}portal.js?{VERHASH}"></script>
	<!--{/if}-->
	<!--{if $_GET['diy'] == 'yes' && check_diy_perm($topic)}-->
	<link rel="stylesheet" type="text/css" id="diy_common" href="data/cache/style_{STYLEID}_css_diy.css?{VERHASH}" />
	<!--{/if}-->
<link rel="stylesheet" type="text/css" href="template/enet_no1/common/toptb.css" />
	<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_group_forumdisplay.css?{VERHASH}" />
</head>

<body id="qbg" class="pg_{CURMODULE}{if $_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)} {$cat['bodycss']}{/if}" onkeydown="if(event.keyCode==27) return false;">
	<div id="append_parent"></div><div id="ajaxwaitid"></div>
	<!--{if $_GET['diy'] == 'yes' && check_diy_perm($topic)}-->
		<!--{template common/header_diy}-->
	<!--{/if}-->
	<!--{if check_diy_perm($topic)}-->
		<!--{template common/header_diynav}-->
	<!--{/if}-->
	<!--{if CURMODULE == 'topic' && $topic && empty($topic['useheader']) && check_diy_perm($topic)}-->
		$diynav
	<!--{/if}-->
	<!--{if empty($topic) || $topic['useheader']}-->
		<!--{if $_G['setting']['mobile']['allowmobile'] && (!$_G['setting']['cacheindexlife'] && !$_G['setting']['cachethreadon'] || $_G['uid']) && ($_GET['diy'] != 'yes' || !$_GET['inajax']) && ($_G['mobile'] != '' && $_G['cookie']['mobile'] == '' && $_GET['mobile'] != 'no')}-->
			<div class="xi1 bm bm_c">
			    {lang your_mobile_browser}<a href="{$_G['siteurl']}forum.php?mobile=yes">{lang go_to_mobile}</a> <span class="xg1">|</span> <a href="$_G['setting']['mobile']['nomobileurl']">{lang to_be_continue}</a>
			</div>
		<!--{/if}-->
		<!--{if $_G['setting']['shortcut'] && $_G['member'][credits] >= $_G['setting']['shortcut']}-->
			<div id="shortcut">
				<span><a href="javascript:;" id="shortcutcloseid" title="{lang close}">{lang close}</a></span>
				{lang shortcut_notice}
				<a href="javascript:;" id="shortcuttip">{lang shortcut_add}</a>

			</div>
			<script type="text/javascript">setTimeout(setShortcut, 2000);</script>
		<!--{/if}-->
				 <div id="diy-tg_menu" style="display: none;">
		           <ul>
			         <li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();" class="xi2">{lang header_diy_mode_simple}</a></li>
			         <li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();" class="xi2">{lang header_diy_mode_adv}</a></li>
		           </ul>
	             </div>
		<div style="position: fixed;width:100%;left: 0;top: 0;_position: absolute;_top: expression(documentElement.scrollTop);z-index: 300;">
			<div id="toptb" class="cl toptbs qtoptb"><!--{hook/global_cpnav_top}-->
			<div class="wp">
               <div class="z" style="color:#fff;width:700px">
                <a href="./group.php" style="height:auto;padding: 0;"><div class="qlogo"></div></a>
				<div class="zeen" >
				<div id="nv">
					<ul>
						<!--{loop $_G['setting']['navs'] $nav}-->
							<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}--><li {if $mnid == $nav[navid]}class="a" {/if}$nav[nav]></li><!--{/if}-->
						<!--{/loop}-->
					</ul>
					<!--{hook/global_nav_extra}-->
				</div>
				</div>
				<!--{if !empty($_G['setting']['plugins']['jsmenu'])}-->
					<ul class="p_pop h_pop" id="plugin_menu" style="display: none;top:36px !Important">
					<!--{loop $_G['setting']['plugins']['jsmenu'] $module}-->
						 <!--{if !$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])}-->
						 <li>$module[url]</li>
						 <!--{/if}-->
					<!--{/loop}-->
					</ul>
				<!--{/if}-->
                </div>
				<!--{if $_G['uid']}-->
				<div class="y" style="margin-top: 4px;">
						$diynav
							<span class="pipe">|</span><a style="padding-right: 15px !Important;color:#fff;float:right;background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%;" href="home.php?mod=space&do=notice" class="a showmenu" onmouseover="showMenu({'ctrlid':'myprompt'});" initialized="true" id="myprompt"{if $_G[member][newprompt]} class="new"{/if}>{lang remind}<!--{if $_G[member][newprompt]}-->($_G[member][newprompt])<!--{/if}--></a><span id="myprompt_check"></span>
		                    <a href="home.php?mod=space&uid=$_G[uid]" style="padding-right: 15px !Important;float:right;color:#fff;background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%;" target="_blank" title="{lang visit_my_space}" id="myhome" class="showmenu" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'a'})">{$_G[member][username]}</a>							
					<!--{hook/global_cpnav_extra2}-->
					<!--{loop $_G['setting']['topnavs'][1] $nav}-->
						<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}-->$nav[code]<!--{/if}-->
					<!--{/loop}-->
					<!--{if empty($_G['disabledwidthauto']) && $_G['setting']['switchwidthauto']}-->
						<a href="javascript:;" id="switchwidth" onclick="widthauto(this)" title="{if widthauto()}{lang switch_narrow}{else}{lang switch_wide}{/if}" class="switchwidth"><!--{if widthauto()}-->{lang switch_narrow}<!--{else}-->{lang switch_wide}<!--{/if}--></a>
					<!--{/if}-->
					<!--{if $_G['uid'] && !empty($_G['style']['extstyle'])}--><a id="sslct" href="javascript:;" onmouseover="delayShow(this, function() {showMenu({'ctrlid':'sslct','pos':'34!'})});">{lang changestyle}</a><!--{/if}-->
					<!--{if check_diy_perm($topic)}-->
					<!--{/if}-->
				</div>
			<!--{elseif !empty($_G['cookie']['loginuser'])}-->
			<div class="y" style="margin-top: 4px;">
				<a id="loginuser" class="xw1">$_G['cookie']['loginuser']</a>
				<a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)">{lang activation}</a>
				<a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a>
			</div>
		<!--{elseif $_G['connectguest']}-->
			<div class="y" style="margin-top: 4px;">
				{lang connect_fill_profile_to_view}
			</div>
		<!--{else}-->
			<div class="y" style="margin-top: 4px;">
				<a href="member.php?mod={$_G[setting][regname]}" style="color:#fff">$_G['setting']['reglinkname']</a>
				<a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" style="color:#fff">{lang login}</a>
			</div>
		<!--{/if}-->
			</div>
			</div>
			<!--{if $_G['uid']}-->
			<!--{subtemplate common/header_myhome}-->
			<!--{/if}-->
			<!--{if $_G['uid']}-->
			<ul id="myprompt_menu" class="p_pop" style="display: none;top:36px !important">				
				<li><a href="home.php?mod=space&do=pm" id="pm_ntc" style="background-repeat: no-repeat; background-position: 0 50%;"><em class="prompt_news{if empty($_G[member][newpm])}_0{/if}"></em>{lang pm_center}</a></li>
				<li><a href="home.php?mod=follow&do=follower"><em class="prompt_follower{if empty($_G[member][newprompt_num][follower])}_0{/if}"></em><!--{lang notice_interactive_follower}-->{if $_G[member][newprompt_num][follower]}($_G[member][newprompt_num][follower]){/if}</a></li>
				<!--{if $_G[member][newprompt] && $_G[member][newprompt_num][follow]}-->
					<li><a href="home.php?mod=follow"><em class="prompt_concern"></em><!--{lang notice_interactive_follow}-->($_G[member][newprompt_num][follow])</a></li>
				<!--{/if}-->
				<!--{if $_G[member][newprompt]}-->
					<!--{loop $_G['member']['category_num'] $key $val}-->
						<li><a href="home.php?mod=space&do=notice&view=$key"><em class="notice_$key"></em><!--{echo lang('template', 'notice_'.$key)}-->(<span class="rq">$val</span>)</a></li>
					<!--{/loop}-->
				<!--{/if}-->
				<!--{if empty($_G['cookie']['ignore_notice'])}-->
					<li class="ignore_noticeli"><a href="javascript:;" onclick="setcookie('ignore_notice', 1);hideMenu('myprompt_menu')" title="{lang temporarily_to_remind}"><em class="ignore_notice"></em></a></li>
				<!--{/if}-->
			</ul>
			<!--{/if}-->
		</div>
		
		<!--{if !IS_ROBOT}-->
							<ul id="umnav_menu" class="p_pop nav_pop" style="display: none;position: fixed;_position: absolute;_top: expression(documentElement.scrollTop);top:33px !important">
								<!--{loop $_G['setting']['mynavs'] $nav}-->
									<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}-->
										{eval $nav[code] = str_replace('style="', '_style="', $nav[code]);}
										<li>$nav[code]</li>
									<!--{/if}-->
								<!--{/loop}-->
								<!--{hook/global_usernav_extra3}-->
								<li><a href="home.php?mod=spacecp">{lang setup}</a></li>
								<!--{if ($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))}-->
									<li><a href="portal.php?mod=portalcp"><!--{if $_G['setting']['portalstatus'] }-->{lang portal_manage}<!--{else}-->{lang portal_block_manage}<!--{/if}--></a></li>
								<!--{/if}-->
								<!--{if $_G['uid'] && $_G['group']['radminid'] > 1}-->
									<li><a href="forum.php?mod=modcp&fid=$_G[fid]" target="_blank">{lang forum_manager}</a></li>
								<!--{/if}-->
								<!--{if $_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)}-->
									<li><a href="admin.php" target="_blank">{lang admincp}</a></li>
								<!--{/if}-->
								<!--{hook/global_usernav_extra4}-->
								<li><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a></li>
							</ul>
			<!--{if $_G['uid'] && !empty($_G['style']['extstyle'])}-->
				<div id="sslct_menu" class="cl p_pop" style="display: none;">
					<!--{if !$_G[style][defaultextstyle]}--><span class="sslct_btn" onclick="extstyle('')" title="{lang default}"><i></i></span><!--{/if}-->
					<!--{loop $_G['style']['extstyle'] $extstyle}-->
						<span class="sslct_btn" onclick="extstyle('$extstyle[0]')" title="$extstyle[1]"><i style='background:$extstyle[2]'></i></span>
					<!--{/loop}-->
				</div>
			<!--{/if}-->
			<!--{subtemplate common/header_qmenu}-->
		<!--{/if}-->

		<!--{ad/headerbanner/wp a_h}-->

		<!--{hook/global_header}-->
	<!--{/if}-->
<!--{if $_G['fid']}--><div class="gbanner" style="width:100%;height:190px;z-index: -1;background:url(template/enet_no1/images/group_banner.jpg);<!--{if $_G['forum']['banner']}-->background:url($_G[forum][banner]);<!--{else}--><!--{/if}-->border-bottom: 5px solid #09F;margin-bottom: 20px;">
	<div class="bm" style="padding-top: 57px;border: 0px solid #DFDFDF;width:960px;margin:0 auto;height:130px;background: transparent;">
						<div class="bm_c xld xlda cl" style="width: 730px;float: left;padding:0;position:relative;z-index:9">
							<dl>
								<dd class="m" style="margin-top:0;height:100px;margin-right:10px;margin-left: -65px;"><img src="$_G[forum][icon]" alt="$_G[forum][name]" width="48" height="48" style="border-radius:5px"/></dd>
								<dt style="width:640px;font-size: 30px;color: #fff;text-shadow: #999 1px 1px 1px;height:36px;font-weight:100;line-height:35px;padding-bottom:3px;padding-top:0">$_G[forum][name]<span style="font-size: 12px;margin-left:10px;font-weight: 100"><a href="home.php?mod=spacecp&ac=favorite&type=group&id={$_G[forum][fid]}&handlekey=sharealbumhk_{$_G[forum][fid]}&formhash={FORMHASH}" id="a_favorite" onclick="showWindow(this.id, this.href, 'get', 0);" title="{lang favorite}" style="color:#fff">{lang favorite}</a><span class="pipe" style="color:#fff">|</span><!--{if $_G[setting][rssstatus] && !$_GET['archiveid']}--><a href="forum.php?mod=rss&fid=$_G[fid]&auth=$rssauth" target="_blank" title="RSS" style="color:#fff">RSS</a><!--{/if}--><!--{if $status == 'isgroupuser' && helper_access::check_module('group')}--><span class="pipe" style="color:#fff">|</span><a href="javascript:;" onclick="showWindow('invite','misc.php?mod=invite&action=group&id=$_G[fid]')" style="color:#fff"><strong class="xi2" style="color:#fff">{lang my_buddylist_invite}</strong></a><!--{/if}--></span></dt>
								<!--{if $_G[forum][description]}--><dd style="overflow: hidden;height: 20px;width:640px;font-size: 14px;color: #fff;text-shadow: #999 1px 1px 1px;">$_G[forum][description]</dd><!--{/if}-->
								<dd class="cl" style="width:640px;color:#fff;height:20px;margin-left:1px;text-shadow: #999 1px 1px 1px;">
									<!--{if $_G['current_grouplevel']['icon']}--><img src="$_G[current_grouplevel][icon]" title="{lang group_level}: $_G[current_grouplevel][leveltitle]" class="vm"> <!--{/if}-->{lang credits}: $_G[forum][commoncredits]<span class="pipe" style="color:#fff">|</span>{lang group_moderator_title}: <!--{eval $i = 1;}--><!--{loop $groupmanagers $manage}--><!--{if $i <= 0}-->, <!--{/if}--><!--{eval $i--;}--><a href="home.php?mod=space&uid=$manage[uid]" target="_blank" style="color:#fff" class="xi2">$manage[username]</a> <!--{/loop}-->
									<span class="pipe" style="color:#fff">|</span><span>{lang posts}: $_G[forum][posts]</span><span class="pipe" style="color:#fff">|</span><span>{lang member}: $_G[forum][membernum]</span><span class="pipe" style="color:#fff">|</span><span>{lang group_member_rank}: $groupcache[ranking][data][today]</span>
								</dd>
								<!--{if $action == 'index' && ($status == 2 || $status == 3 || $status == 5)}-->
								<dd>
									{lang group_join_type}:
									<!--{if $_G['forum']['jointype'] == 1}-->
										<strong>{lang group_join_type_invite}</strong>
									<!--{elseif $_G['forum']['jointype'] == 2}-->
										<strong>{lang group_join_type_moderate}</strong>
									<!--{else}-->
										<strong>{lang group_join_type_free}</strong>
									<!--{/if}-->
									{lang group_perm_visit}: <strong><!--{if $_G['forum']['gviewperm'] == 0}-->{lang group_perm_member_only}<!--{else}-->{lang group_perm_all_user}<!--{/if}--></strong>
								</dd>
								<dd class="xi1">
									<!--{if $status == 3 || $status == 5}-->
										{lang group_has_joined}
									<!--{elseif helper_access::check_module('group')}-->
									<!--{/if}-->
								</dd>
								<!--{/if}-->
								<!--{if $status == 'isgroupuser'}--><dd class="xi1"><button type="button" class="pn" style="height: 25px !important;border: 1px solid #DFDFDF;background:#fff" onclick="showDialog('{lang group_exit_confirm}', 'confirm', '', function(){location.href='forum.php?mod=group&action=out&fid=$_G[fid]'})" href="javascript:;"><em style="font-size: 12px;padding:0;line-height: 17px !important;">{lang group_exit}</em></button><dd><!--{/if}-->
							</dl>
							<!--{if $status != 2 && $status != 3 && $status != 5}-->
								<!--{if helper_access::check_module('group') && $status != 'isgroupuser'}-->
								<div class="ptm pbm" style="padding: 0px !important;margin-top: -3px;padding-left:65px !Important">
										<button type="button" class="pn" style="height: 25px !important;border: 1px solid #DFDFDF;background:#fff" onclick="location.href='forum.php?mod=group&action=join&fid=$_G[fid]'"><em style="font-size: 12px;line-height: 17px !important;padding:0;">{lang group_join_group}</em></button>
								</div>
								<!--{/if}-->
								<!--{if CURMODULE == 'group'}--><!--{hook/group_navlink}--><!--{else}--><!--{hook/forumdisplay_navlink}--><!--{/if}-->
							<!--{/if}-->
						</div>
	</div>
</div>
<style>
#diy-tg {float: left !Important}
.z .p_pop a{float:none !important;line-height: 2 !important;height: auto !important}
.hasfsl {margin-right: 170px;zoom: 1;}
.p_fre{margin-bottom:10px}
select,.tfm th,.tfm td{font-size:12px !Important}
</style>
	<!--{/if}-->
	<div id="wp" class="wp">

	<!--{ad/text/wp a_t}-->

	<style id="diy_style" type="text/css"></style>
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>

	<div id="gct" class="ct2 wp cl" style="margin-top:50px;<!--{if $_G['fid']}-->padding-top:0px;margin-top:0;<!--{/if}-->border: 1px solid #DFDFDF;border-radius: 5px;">
		<div class="mn" style="width:710px;padding:10px;padding-top:0;<!--{if $_G['fid']}-->padding:10px;<!--{/if}-->">
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
			<!--{if $action != 'create'}-->
				<!--[diy=diycontentmiddle]--><div id="diycontentmiddle" class="area"></div><!--[/diy]-->
				<!--{if CURMODULE == 'group'}--><!--{hook/group_top}--><!--{else}--><!--{hook/forumdisplay_top}--><!--{/if}-->
				<!--{if $status != 2 && $status != 3}-->
				<div class="tb cl{if $action != 'manage'} mbm{/if}">
					<!--{if in_array($_G['adminid'], array(1,2))}--><span class="a bw0_all y xi2"><a href="javascript:;" onclick="showWindow('grecommend$_G[fid]', 'forum.php?mod=group&action=recommend&fid=$_G[fid]');return false;">{lang group_push_to_forum}</a></span><!--{/if}-->
					<ul id="groupnav">
						<li {if $action == 'index'}class="a"{/if}><a href="forum.php?mod=group&fid=$_G[fid]#groupnav" title="">{lang home}</a></li>
						<li {if $action == 'list'}class="a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]#groupnav" title="">{lang group_discuss_area}</a></li>
						<li {if $action == 'memberlist' || $action == 'invite'}class="a"{/if}><a href="forum.php?mod=group&action=memberlist&fid=$_G[fid]#groupnav" title="">{lang group_member_list}</a></li>
						<!--{if $_G['forum']['ismoderator']}--><li {if $action == 'manage'}class="a"{/if}><a href="forum.php?mod=group&action=manage&fid=$_G[fid]#groupnav">{lang group_admin}</a></li><!--{/if}-->
						<!--{if CURMODULE == 'group'}--><!--{hook/group_nav_extra}--><!--{else}--><!--{hook/forumdisplay_nav_extra}--><!--{/if}-->
					</ul>
				</div>
				<!--{/if}-->
			<!--{/if}-->
			<!--{if $action == 'index' && $status != 2 && $status != 3}-->
				<!--{subtemplate group/group_index}-->
			<!--{elseif $action == 'list'}-->
				<!--{subtemplate group/group_list}-->
			<!--{elseif $action == 'memberlist'}-->
				<!--{subtemplate group/group_memberlist}-->
			<!--{elseif $action == 'create'}-->
				<!--{subtemplate group/group_create}-->
			<!--{elseif $action == 'invite'}-->
				<!--{subtemplate group/group_invite}-->
			<!--{elseif $action == 'manage'}-->
				<!--{subtemplate group/group_manage}-->
			<!--{/if}-->
			<!--{if CURMODULE == 'group'}--><!--{hook/group_bottom}--><!--{else}--><!--{hook/forumdisplay_bottom}--><!--{/if}-->
			<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->
		</div>
		<div class="sd" style="width: 228px">
			<div class="drag">
				<!--[diy=diysidetop]--><div id="diysidetop" class="area"></div><!--[/diy]-->
			</div>
			<!--{subtemplate group/group_right}-->
			<!--{if CURMODULE == 'group'}--><!--{hook/group_side_bottom}--><!--{else}--><!--{hook/forumdisplay_side_bottom}--><!--{/if}-->

			<div class="drag">
				<!--[diy=diy2]--><div id="diy2" class="area"></div><!--[/diy]-->
			</div>

		</div>
	</div>

<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<!--{template common/footer}-->