<?php exit;?>
<!--{if $diymode}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<!--{subtemplate home/space_header}-->
<style>
#toptb a#sslct, .switchwidth, #toptb a.switchblind {display: none;}
.ct2_a .mn {float: left;}
#moodfm textarea {width: 554px;height: 76px;margin-right:0px;border: 2px solid #0ad;overflow-y: hidden;font-size: 13px;padding: 10px;}
.moodfm_btn button {padding-left: 0px;margin-left:0;background: url(template/enet_no1/images/fow.png) no-repeat !important;width:100px;height:100px;opacity: 10;filter: alpha(opacity=100);border:0}
.moodfm_btn{padding-left:0;width:100px;height:100px;background:none}
.moodfm_btn button:hover{background: url(template/enet_no1/images/fow.png) 0 100px !Important;}
.xld .avt img {border-radius:27px !important}
.xld .avt a {border-radius:27px !important}
</style>
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
					<div class="bm_h">
						<h1 class="mt">{lang doing}</h1>
					</div>
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->
		<div id="pt" class="bm cl">
			<div class="z">
				<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]">{$space[username]}</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]&do=doing&view=me&from=space">{lang doing}</a>
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
	<!--{if $space[self] && helper_access::check_module('doing')}--><!--{template home/space_doing_form}--><!--{/if}-->
<!--{else}-->
	<!--{template common/header}-->
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="home.php?mod=space&do=doing">{lang doing}</a>
		</div>
	</div>

	<style id="diy_style" type="text/css"></style>
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>
	<div id="ct" class="ct2_a wp cl" style="margin:0;padding:0;width:auto !important">
		<!--{if 1}-->
<style>
#toptb a#sslct, .switchwidth, #toptb a.switchblind {display: none;}
.ct2_a .mn {float: left;}
#moodfm textarea {width: 554px;height: 76px;margin-right:0px;border: 2px solid #0ad;overflow-y: hidden;font-size: 13px;padding: 10px;}
.moodfm_btn button {padding-left: 0px;margin-left:0;background: url(template/enet_no1/images/fow.png) no-repeat !important;width:100px;height:100px;opacity: 10;filter: alpha(opacity=100);border:0}
.moodfm_btn{padding-left:0;width:100px;height:100px;background:none}
.moodfm_btn button:hover{background: url(template/enet_no1/images/fow.png) 0 100px !Important;}
.xld .avt img {border-radius:27px !important}
.xld .avt a {border-radius:27px !important}
</style>
			<div class="appl" style="position:relative">
            <!--{if $_G['uid']}-->
			<style>
			.tbmu {padding: 8px 10px 8px 10px;border-bottom: 0px dashed #dfdfdf;}
			.appl .avtss img {margin:0 !important;width:70px;height:70px;border-radius: 45px;}
			.appl .avtss a {width:70px;height:70px;padding:2px;border: 1px solid #DADFE6;border-radius: 45px;display:block;margin:0 auto;margin-top:50px}
			.appl ul{border:0 !important}
			.home_avt_box a,.home_avt_box p{text-align: center;font-size:14px;z-index:2}
			</style>
			<div id="borderbox" class="home_avt_box" style="padding:0;height:200px;margin-bottom:10px">
			<div class="avtss" style="position:absolute;width:278px;z-index:3">
			<a href="home.php?mod=space&uid=$_G[uid]" class="bf"><!--{avatar($_G[uid],big)}--></a>
			</div>
			<div style="height:130px;position:absolute;z-index:0">{if $_G[uid] && isset($_G[cookie][extstyle]) && strpos($_G[cookie][extstyle], TPLDIR) !== false}<img id="home_hear_bg" src="$_G[cookie][extstyle]/home_hear_bg.jpg" width="278" height="88" style="margin:0;border-radius:5px 5px 0 0"/>{else}<img id="home_hear_bg" src="./template/enet_no1/images/home_hear_bg.jpg" width="278" height="88" style="margin:0;border-radius:5px 5px 0 0"/>{/if}</div>
             <div style="height:130px;z-index:0"></div> 
			  <p>{$_G[member][username]}</p>
				 <p class="notice" style="font-weight: normal;background:none;padding-left:0;padding-right:0">{lang credits}: $space[credits]</p>
			</div>
			<!--{/if}-->
				<div id="borderbox" style="padding-top: 10px;zoom:1">
				<!--{subtemplate common/userabout}-->
				</div>
			</div>
			<div class="mn pbm"  style="padding-top:5px;top:0">
			<style>
			.tb {border-bottom:0}
			.tb a {display: block;padding: 0 10px;font-size: 14px;margin-bottom: 0;border-radius: 0;border-top:0;color:#1881BD;border-bottom:0;border-left:0;border-right:0;background: transparent !important;}
			.tb .a a, .tb .current a {font-weight: 700;border-bottom: 0px solid #0ad;color:#333;border-radius: 0;margin-bottom: 0;padding-bottom: 0;}
			#ct{background:transparent !important;border:0 !important;border-radius: 0px;}
            .ct2_a .mn {margin-right: 0px;background: transparent;margin-left: 0 !important;width: 710px;float:left;padding:0px !important;border: #ccc solid 0px;border-radius: 0px;}
            .ct2_a .appl {margin-bottom: 0px;width: 280px !important;float:right !important;border: #ccc solid 0px;border-left: 0px solid #DFDFDF;background: transparent;padding: 0px;border-radius: 0 5px 5px 0;left:0;top:0;height:auto !Important}
			.ct2_a .appl li{float:none !Important}
			#border-bottom {border-top:1px solid #27A5EC}
			.tbmu a {color: #1881BD;}
			.tbmu {padding: 8px 10px 8px 20px;border-bottom: 0px dashed #DFDFDF;}
			.xlda .m {margin:0}
			.xlda dl {padding-left:0}
			</style>
					<ul class="tb cl" id="borderbox" style="padding:15px;line-height: 15px;padding-bottom: 15px;padding-top: 13px;padding-left:0px;margin-top:0px;margin-bottom:30px">
						<li$actives[we]><a href="home.php?mod=space&do=$do&view=we" style="border-right: 1px solid #dfdfdf;margin-left: 10px;">{lang me_friend_doing}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=$do&view=me" style="border-right: 1px solid #dfdfdf">{lang doing_view_me}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=$do&view=all">{lang view_all}</a></li>
					</ul>
				<!--{hook/space_doing_top}-->
				<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
				 <!--{if $_G['uid']}-->
				<div class="bf" id="borderbox" style="margin-top:-20px;margin-bottom:32px;padding-bottom:5px;">
					<!--{if helper_access::check_module('doing')}-->
					<!--{template home/space_doing_form}-->
					<!--{/if}-->
					<!--{hook/space_doing_bottom}-->

				</div>
				<!--{/if}-->
		<!--{else}-->
			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{lang doing}</h2>
					<ul>
						<li$actives[we]><a href="home.php?mod=space&do=$do&view=we">{lang me_friend_doing}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=$do&view=me">{lang doing_view_me}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=$do&view=all">{lang view_all}</a></li>
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="top:0">
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
			<!--{if $space[self] && helper_access::check_module('doing')}--><!--{template home/space_doing_form}--><!--{/if}-->
		<!--{/if}-->
		
<!--{/if}-->
		
		<!--{if $searchkey}-->
			<p class="tbmu">{lang doing_search_record} <span style="color: red; font-weight: 700;">$searchkey</span> {lang doing_record_list}</p>
		<!--{/if}-->
		
		<!--{if $dolist}-->
			<div class="xld {if empty($diymode)}xlda{/if}">
			<!--{loop $dolist $dv}-->
			<!--{eval $doid = $dv[doid];}-->
			<!--{eval $_GET[key] = $key = random(8);}-->
			<div id="borderbox" style="margin-bottom:32px;padding: 5px 15px 0 15px;position:relative;zoom:1">
				<dl id="{$key}dl{$doid}" class="pbn cl">
					<dd class="xs2 top_avt" style="margin-top:3px;height:28px;">
					<!--{if empty($diymode)}--><div><div class="avt" style="width:58px;height:58px;position:absolute;top:-25px;z-index:3"><a href="home.php?mod=space&uid=$dv[uid]" c="1" style="position: relative;"><!--{avatar($dv[uid],small)}--></a></div></div><p style="padding-left:65px"><a href="home.php?mod=space&uid=$dv[uid]">$dv[username]</a></p><!--{/if}-->
					</dd>
					<dd style="font-size:14px">
					<span>$dv[message]</span> <!--{if $dv[status] == 1}--> <span style="font-weight: bold">({lang moderate_need})</span><!--{/if}-->
					</dd>
					<!--{eval $list = $clist[$doid];}-->
					<dd class="cmt brm" id="{$key}_$doid"{if empty($list) || !$showdoinglist[$doid]} style="display:none;"{/if}>
						<span id="{$key}_form_{$doid}_0"></span>
						<!--{template home/space_doing_li}-->
					</dd>
					<dd class="ptn xg1">
						<span class="y">
						<!--{if helper_access::check_module('doing')}-->
						<a href="javascript:;" onclick="docomment_form($doid, 0, '$key');">{lang reply}</a>
						<!--{/if}-->
						<!--{if $dv[uid]==$_G[uid]}--><span class="pipe"></span><a href="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$dv[id]&handlekey=doinghk_{$doid}_$dv[id]" id="{$key}_doing_delete_{$doid}_{$dv[id]}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a><!--{/if}-->
						</span>
					    <!--{date($dv['dateline'], 'u')}--> {lang from} {lang doing}
						<!--{if checkperm('managedoing')}-->
						<!--{/if}-->
					</dd>
				</dl>
			</div>
			<!--{/loop}-->
			<!--{if $pricount}-->
				<p class="mtm">{lang hide_doing}</p>
			<!--{/if}-->
			</div>
			<!--{if $multi}-->
			<div class="pgs cl mtm">$multi</div>
			<!--{elseif $_GET[highlight]}-->
			<div class="pgs cl mtm"><div class="pg"><a href="home.php?mod=space&do=doing&view=me">{lang viewmore}</a></div></div>
			<!--{/if}-->
		<!--{else}-->
			<div class="emp bf" id="borderbox">{lang doing_no_replay}<!--{if $space[self]}-->{lang doing_now}<!--{/if}--></div>
		<!--{/if}-->
		
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