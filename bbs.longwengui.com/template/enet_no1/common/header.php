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
</head>
<body id="nv_{$_G[basescript]}" class="pg_{CURMODULE}{if $_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)} {$cat['bodycss']}{/if}" onkeydown="if(event.keyCode==27) return false;">
<div class="absolute_body_bg"></div>
<!--{if $_G['style']['extstyle']}--><span href="javascript:void(0)" class="run" id="sslct">{lang changestyle}</span><!--{/if}-->
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
			    {lang your_mobile_browser}<a href="{$_G['siteurl']}forum.php?mobile=yes">{lang go_to_mobile}</a><span class="xg1">|</span> <a href="$_G['setting']['mobile']['nomobileurl']">{lang to_be_continue}</a>
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
		<!--{if !IS_ROBOT}-->
			<!--{if $_G['uid']}-->
			<ul id="myprompt_menu" class="p_pop" style="display: none;">				
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
<!--{if $_G['style']['extstyle']}-->
<script type="text/javascript">
var $ = function(){
	return document.getElementById(arguments[0]);
};

var btnFn = function( e ){
	alert( e.target );
	return false;
};

$('sslct').onclick = function(){
	easyDialog.open({
		container : {
			header : '{lang changestyle}',
			content : '<div><div class="login_text" {if $_G['uid']} style="display:none"{/if}></div>{if !empty($_G['style']['extstyle'])}{if !$_G[style][defaultextstyle]}<span class="sslct_btn" {if $_G['uid']} onclick="extstyle(\'\');document.getElementById(\'home_hear_bg\').src=\'./template/enet_no1/images/home_hear_bg.jpg\';return false;" style="cursor: pointer" {/if} title="{lang default}"><i style="background:url(template/enet_no1/images/preview.jpg)"></i><i style="background: rgba(0, 0, 0, 0.3);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = #30000000,endColorstr = #30000000);margin-top:-23px;padding-top:2px;text-align: center;color:#fff;height:20px;overflow: hidden;clear: both;">{lang default}</i></span>{/if}{loop $_G['style']['extstyle'] $extstyle}<span class="sslct_btn" {if $_G['uid']} onclick="extstyle(\'$extstyle[0]\');document.getElementById(\'home_hear_bg\').src=\'$extstyle[0]/home_hear_bg.jpg\';return false;" style="cursor:pointer" {/if} title="$extstyle[1]"><i style="background:url($extstyle[0]/preview.jpg)"></i><i style="background: rgba(0, 0, 0, 0.3);filter: progid:DXImageTransform.Microsoft.gradient(startColorstr = #30000000,endColorstr = #30000000);margin-top:-23px;padding-top:2px;text-align:center;color:#fff;height:20px;overflow:hidden;clear:both">$extstyle[1]</i></span>{/loop}{/if}<div style="clear:both"></div></div><div class="o pns" style="margin-top:10px;margin-bottom:-10px;margin-left:-10px;margin-right:-6px;text-align: left;line-height: 35px"><div style="float:left">&#x6CE8;&#xFF1A;&#x90E8;&#x5206;&#x6A21;&#x677F;&#x9009;&#x62E9;&#x5B8C;&#x540E;&#x4E0D;&#x80FD;&#x6B63;&#x786E;&#x663E;&#x793A;&#x51FA;&#x6548;&#x679C;&#xFF0C;&#x60A8;&#x53EF;&#x4EE5;&#x5355;&#x51FB;&#x786E;&#x5B9A;&#x6765;&#x89E3;&#x51B3;</div><button type="submit" {if $_G['uid']}class="pn pnc" onclick="history.go(0)" style="float:right;cursor: pointer;height:30px;margin-right:0"{else}class="pn" style="float:right;cursor: auto;height:30px;margin-right:0"{/if}><strong>{lang confirms}</strong></button><div style="clear:both"></div></div>'
		},
        overlay : false
	});
};

</script>
<!--{/if}-->
			<!--{if $_G['uid']}-->
				<ul id="myitem_menu" class="p_pop" style="display: none;">
					<li><a href="forum.php?mod=guide&view=my">{lang mypost}</a></li>
					<li><a href="home.php?mod=space&do=favorite&view=me">{lang favorite}</a></li>
					<li><a href="home.php?mod=space&do=friend">{lang friends}</a></li>
					<!--{hook/global_myitem_extra}-->
				</ul>
			<!--{/if}-->
				<div id="so_box" style="display: none;position: fixed;_position:absolute;top: 300px;left: 50%;margin-left: -463px;z-index:200;width:918px">
				 <a href="javascript:;" id="so_close" onclick="$('so_box').style.display='none'">{lang close}</a>	
				 <!--{if $_G['setting']['search']}-->
	                   <!--{eval $slist = array();}-->
	                   <!--{if $_G['fid'] && $_G['forum']['status'] != 3 && $mod != 'group'}--><!--{block slist[forumfid]}--><li><a href="javascript:;" rel="curforum" fid="$_G[fid]" >{lang search_this_forum}</a></li><!--{/block}--><!--{/if}-->
	                   <!--{if $_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><li> <a href="javascript:;" rel="article">{lang article}</a></li><!--{/block}--><!--{/if}-->
	                   <!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><li><a href="javascript:;" rel="forum" class="curtype">{lang thread}</a></li><!--{/block}--><!--{/if}-->
	                   <!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)}--><!--{block slist[blog]}--><li><a href="javascript:;" rel="blog">{lang blog}</a></li><!--{/block}--><!--{/if}-->
	                   <!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)}--><!--{block slist[album]}--><li><a href="javascript:;" rel="album">{lang album}</a></li><!--{/block}--><!--{/if}-->
	                   <!--{if $_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><li><a href="javascript:;" rel="group">$_G['setting']['navs'][3]['navname']</a></li><!--{/block}--><!--{/if}-->
	                   <!--{block slist[user]}--><li><a href="javascript:;" rel="user">{lang users}</a></li><!--{/block}-->
                   <!--{/if}-->
                   <!--{if $_G['setting']['search'] && $slist}-->
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".btn-slide").click(function(){
		jQuery("#panel").slideToggle("slow");
		jQuery(this).toggleClass("active"); return false;
	}); 
});
</script>
                 <div class="so_bg" style="position:relative">
                     <div class="sobg"></div>
                     <div id="scbar" style="background:transparent;border:0 !Important;border: 0 !important;padding:0;height:auto" class="{if $_G['setting']['srchhotkeywords'] && count($_G['setting']['srchhotkeywords']) > 5}scbar_narrow {/if}cl">
					   <table cellpadding="0" cellspacing="0" class="fwin"><tbody><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l"></td><td class="m_c" style="border:0">
	                   <div style="margin-top:9px;padding:0 10px;padding-bottom:9px">
					   <form id="scbar_form" method="{if $_G[fid] && !empty($searchparams[url])}get{else}post{/if}" autocomplete="off" onsubmit="searchFocus($('scbar_txt'))" action="{if $_G[fid] && !empty($searchparams[url])}$searchparams[url]{else}search.php?searchsubmit=yes{/if}" target="_blank">
		                   <input type="hidden" name="mod" id="scbar_mod" value="search" />
		                   <input type="hidden" name="formhash" value="{FORMHASH}" />
		                   <input type="hidden" name="srchtype" value="title" />
		                   <input type="hidden" name="srhfid" value="$_G[fid]" />
		                   <input type="hidden" name="srhlocality" value="$_G['basescript']::{CURMODULE}" />
		                   <!--{if !empty($searchparams[params])}-->
			                   <!--{loop $searchparams[params] $key $value}-->
			                   <!--{eval $srchotquery .= '&' . $key . '=' . rawurlencode($value);}-->
			                   <input type="hidden" name="$key" value="$value" />
			                   <!--{/loop}-->
			                   <input type="hidden" name="source" value="discuz" />
			                   <input type="hidden" name="fId" id="srchFId" value="$_G[fid]" />
			                   <input type="hidden" name="q" id="cloudsearchquery" value="" />
                               <div style="display: none; position: absolute; top:37px; left:44px;" id="sg">
                                   <div id="st_box" cellpadding="2" cellspacing="0"></div>
                               </div>
		                   <!--{/if}-->
		                   <table cellspacing="0" cellpadding="0">
			                   <tr>
				                   <td class="scbar_txt_td">
								   <input type="text" name="srchtxt" id="scbar_txt" style="line-height: 20px;" value="{lang enter_content}" autocomplete="off" x-webkit-speech speech /></td>
				                   <td class="scbar_type_td"><a href="javascript:;" id="scbar_type" class="xg1" onclick="showMenu(this.id)" hidefocus="true">{lang search}</a></td>
								   <td class="scbar_btn_td">
								   <button style="height: 44px !important;width: 83px;" type="submit" name="searchsubmit" id="scbar_btn" sc="1" class="pn pnc" value="true"><strong class="xi2" STYLE="text-indent: -99999px;width: 107px;opacity: 0;filter: alpha(opacity=0);cursor: pointer;">{lang search}</strong></button></td>
			                   </tr>
		                   </table>
						   <ul id="scbar_type_menu" class="p_pop" style="display: none;"><!--{echo implode('', $slist);}--></ul>
	                   </form>
                        <script type="text/javascript"> jQuery(document).ready(function() { var tags_a = jQuery("#scbar_hot a"); tags_a.each(function(){ var x = 9; var y = 0; var rand = parseInt(Math.random() * (x - y + 1) + y); jQuery(this).addClass("tags"+rand); }); }) </script> 
					   <div style="display: none;" id="panel"> 
							<div id="scbar_hot" style="margin-top:10px">
						<!--{if $_G['setting']['srchhotkeywords']}-->
							<a class="xw1">{lang hot_search}: </a>
							<!--{loop $_G['setting']['srchhotkeywords'] $val}-->
								<!--{if $val=trim($val)}-->
									<!--{eval $valenc=rawurlencode($val);}-->
									<!--{block srchhotkeywords[]}-->
										<!--{if !empty($searchparams[url])}-->
											<a href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}" target="_blank" class="xi2" sc="1">$val</a>
										<!--{else}-->
											<a href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch" target="_blank" class="xi2" sc="1">$val</a>
										<!--{/if}-->
									<!--{/block}-->
								<!--{/if}-->
							<!--{/loop}-->
							<!--{echo implode('', $srchhotkeywords);}-->
						<!--{/if}-->
					        </div>
                       </div>
					   </div>
                   </td> 
				   <td class="m_r"></td>
				   </tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></tbody> </table>
                   <div class="slide"><a href="javascript:;" class="btn-slide active"></a></div>	  	   
				   </div>
				   </div>
                   <script type="text/javascript">initSearchmenu('scbar', '$searchparams[url]');</script>
                   <!--{/if}-->  
				</div>
	             <div id="diy-tg_menu" style="display: none;">
		           <ul>
			         <li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();" class="xi2">{lang header_diy_mode_simple}</a></li>
			         <li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();" class="xi2">{lang header_diy_mode_adv}</a></li>
		           </ul>
	             </div>
			<!--{subtemplate common/header_myhome}-->
			<!--{subtemplate common/header_qmenu}-->
		<!--{/if}-->
		<script type="text/javascript" src="template/enet_no1/js/jquery.js"></script>
<script language="javascript">var t = null;t =setTimeout(time,1000);function time(){clearTimeout(t);dt = new Date();var h=dt.getHours();var m=dt.getMinutes(); var s=dt.getSeconds();document.getElementById("timeShow").innerHTML =  ""+h+":"+m+"";t = setTimeout(time,1000);}</script>   
<script type="text/javascript" src="template/enet_no1/js/weather.js" language="javascript" charset="UTF-8"></script>
<script type="text/javascript" src="template/enet_no1/js/weather_ip.js"></script>
<div class="weather"><div class="wtimg" id="T_weather_img"></div><div class="weather-background"></div><div class="weather-info"><span id="timeShow"></span><span id="T_weather"></span><div class="city_all"><span class="city"></span><div class="city_ico"></div></div><span id="T_temperature"></span></div></div>
		<!--{ad/headerbanner/wp a_h}-->
		<div id="toptb" class="wp common_toptb">
			<!--{hook/global_cpnav_top}-->
               <div class="z">
                <div class="zeen common_i">
					<!--{loop $_G['setting']['topnavs'][0] $nav}-->
						<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}-->$nav[code]<!--{/if}-->
					<!--{/loop}-->
					<!--{hook/global_cpnav_extra1}-->
				</div>
                </div>
				<div class="y common_i">
					<a id="switchblind" href="javascript:;" onclick="toggleBlind(this)" title="{lang switch_blind}" class="switchblind">{lang switch_blind}</a>
					<!--{hook/global_cpnav_extra2}-->
					<!--{loop $_G['setting']['topnavs'][1] $nav}-->
						<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}-->$nav[code]<!--{/if}-->
					<!--{/loop}-->
					<!--{if empty($_G['disabledwidthauto']) && $_G['setting']['switchwidthauto']}-->
						<a href="javascript:;" id="switchwidth" onclick="widthauto(this)" title="{if widthauto()}{lang switch_narrow}{else}{lang switch_wide}{/if}"><!--{if widthauto()}-->{lang switch_narrow}<!--{else}-->{lang switch_wide}<!--{/if}--></a>
					<!--{/if}-->
					<!--{if check_diy_perm($topic)}-->
						$diynav
					<!--{/if}-->
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="hearbg"></div>
		<div id="hear-box">
			<div class="wp">
					<!--{eval $mnid = getcurrentnav();}-->
					<h2><!--{if !isset($_G['setting']['navlogos'][$mnid])}--><a href="{if $_G['setting']['domain']['app']['default']}http://{$_G['setting']['domain']['app']['default']}/{else}./{/if}" title="$_G['setting']['bbname']"><img src="template/enet_no1/images/logo.png" onload="fixPNG(this)"></a><!--{else}-->$_G['setting']['navlogos'][$mnid]<!--{/if}--></h2>
					<!--{if $_G['uid']}-->
					<div id="um">
							<div class="y"><a href="home.php?mod=space&do=pm"  id="pm_ntc" {if $_G[member][newpm]}style="position: absolute;display: initial !Important;margin: -2px 0 0 34px;width: 16px;float:right;z-index:200;height: 14px;background: url(template/enet_no1/images/new_pm_2.png) no-repeat 100% 0;border:0px !important"{/if} style="display:none"></a></div>
                            <div class="y"><a href="home.php?mod=space&do=notice" id="pm_ntc" {if $_G[member][newprompt]}style="position: absolute;display: initial !Important;margin: -2px 0 0 34px;float:right;z-index:200;width: 16px;height: 14px;background: url(template/enet_no1/images/new_pm_2.png) no-repeat 100% 0;border:0px !important"{/if} style="display:none"></a></div>
						<div class="avt y"><a href="home.php?mod=space&uid=$_G[uid]"><!--{avatar($_G[uid],small)}--></a></div>
						<p class="top30">
		                    <a style="background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%" target="_blank" title="{lang visit_my_space}" id="myhome" class="showmenu" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'myhome'})">{$_G[member][username]}</a>
						</p>
					</div>
					<!--{elseif !empty($_G['cookie']['loginuser'])}-->
					<!--{elseif !$_G[connectguest]}-->
						<!--{template member/login_simple}-->
					<!--{else}-->
					<div id="um">
						<div class="avt y"><a><!--{avatar(0,small)}--></a></div>
						<p class="top30">
							<a id="myhome" class="showmenu" style="background: url(template/enet_no1/images/arrwd.png) no-repeat 100% 50%" onmouseover="showMenu({'ctrlid':this.id,'ctrlclass':'myhome'})">{$_G[member][username]}</a>
						</p>
					</div>
					<!--{/if}-->
				<!--{if !empty($_G['setting']['plugins']['jsmenu'])}-->
					<ul class="p_pop h_pop" id="plugin_menu" style="display: none">
					<!--{loop $_G['setting']['plugins']['jsmenu'] $module}-->
						 <!--{if !$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])}-->
						 <li>$module[url]</li>
						 <!--{/if}-->
					<!--{/loop}-->
					</ul>
				<!--{/if}-->
				$_G[setting][menunavs]
				<div style="clear:both"></div>
			</div>
		</div>
		<div id="nv" class="allnv">
		<div class="nvbg">
		 <div class="nvbgl"></div>
		   <div id="nvtext" class="wp nvtext">
			<a href="javascript:;" id="qmenu" onmouseover="delayShow(this, function () {showMenu({'ctrlid':'qmenu','pos':'34!','ctrlclass':'a','duration':2});showForummenu($_G[fid]);})">{lang my_nav}</a>
			<span href="javascript:;" id="so" onclick="$('so_box').style.display='block'" style="cursor: pointer">{lang search}</span>
			<ul>
			  <!--{loop $_G['setting']['navs'] $nav}-->
				<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}--><li {if $mnid == $nav[navid]}class="a" {/if}$nav[nav]></li><!--{/if}-->
			  <!--{/loop}-->
			</ul>
			  <!--{hook/global_nav_extra}-->
		   </div>
		</div>
		</div>
		  <div id="mu" class="cl">
			<!--{if $_G['setting']['subnavs']}-->
				<!--{loop $_G[setting][subnavs] $navid $subnav}-->
					<!--{if $_G['setting']['navsubhover'] || $mnid == $navid}-->
			<ul class="cl {if $mnid == $navid}current{/if}" id="snav_$navid" style="display:{if $mnid != $navid}none{/if}">
			<div class="wp">
			$subnav
			</div>
			</ul>
			<!--{/if}-->
			<!--{/loop}-->
		    <!--{/if}-->
		  </div>
		<!--{ad/subnavbanner/a_mu}-->
		<!--{hook/global_header}-->
	<!--{/if}-->
	<div id="wp" class="wp">