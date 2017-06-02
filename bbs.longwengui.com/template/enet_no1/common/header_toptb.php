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
<style>
.z .p_pop a{float:none !important;line-height: 2 !important;height: auto !important}
.talkss {display: inline-block !important;}
.fow_ad{display: inline-block !important;}
.wp{width:960px !important}
.appl{margin-right:0 !important;margin-left:0 !Important}
.ct2_a {margin-right:0 !important}
.tb .a a, .tb .current a {font-weight: 700;border-bottom: 2px solid #59cbc7 !important;padding-bottom:0}
.wp #tct .mn .tbmu a,.wp #tct .mn .tb a{display: block;padding: 0 10px;font-size: 12px;border-radius: 0;border-top: 0;border-bottom: 2px solid #d0d0d0;border-left: 0;border-right: 0;background: transparent !important;color:#333 !important}
#sslct{float: right;margin-top: -20px;margin-right: -20px;margin-bottom: -10px;border-radius: 0 5px 0 0;position:relative;z-index:99}
</style>
</head>

<body id="tbg" class="pg_{CURMODULE}{if $_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)} {$cat['bodycss']}{/if}" onkeydown="if(event.keyCode==27) return false;">
<div class="tbg_body">
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
		<div style="position: fixed;width:100%;left: 0;top: 0;_position: absolute;_top: expression(documentElement.scrollTop);z-index: 300;">
			<div id="toptb" class="cl"><!--{hook/global_cpnav_top}-->
			<div class="wp">
               <div class="z" style="width:700px">
                <a href="./home.php?mod=follow" style="height:auto;padding: 0;"><div class="tlogo"></div></a>
				<div class="zeen">
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
				<div class="y" style="margin-top: 4px;">
						<p style="width:260px;float:left">
							<span class="pipe">|</span><a style="padding: 0 4px !important;padding-right: 15px !Important;float:right;background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%;" href="home.php?mod=space&do=notice" class="a showmenu" onmouseover="showMenu({'ctrlid':'myprompt'});" initialized="true" id="myprompt"{if $_G[member][newprompt]} class="new"{/if}>{lang remind}<!--{if $_G[member][newprompt]}-->($_G[member][newprompt])<!--{/if}--></a><span id="myprompt_check"></span>
		                    <a href="home.php?mod=space&uid=$_G[uid]" style="padding: 0 4px !important;padding-right: 15px !Important;float:right;background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%;" target="_blank" title="{lang visit_my_space}" id="myhome" class="showmenu" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'a'})">{$_G[member][username]}</a>							
						</p>
				</div>
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
							<ul id="umnav_menu" class="p_pop nav_pop" style="display: none;position: fixed;_position: absolute;_top: expression(documentElement.scrollTop);top:32px">
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
				    <div id="diy-tg_menu" style="display: none;">
		           <ul>
			         <li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();" class="xi2">{lang header_diy_mode_simple}</a></li>
			         <li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();" class="xi2">{lang header_diy_mode_adv}</a></li>
		           </ul>
	             </div>
			<!--{subtemplate common/header_qmenu}-->
		<!--{/if}-->

		<!--{ad/headerbanner/wp a_h}-->

		<!--{hook/global_header}-->
	<!--{/if}-->
			
	<div id="wp" class="wp twp">