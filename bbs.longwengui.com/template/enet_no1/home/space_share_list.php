<?php exit;?>
<!--{if $diymode}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<!--{subtemplate home/space_header}-->
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
					<div class="bm_h">
						<h1 class="mt">{lang share}</h1>
					</div>
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->
		<div id="pt" class="bm cl">
			<div class="z">
				<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]">{$space[username]}</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]&do=share&view=me&from=space">{lang share}</a>
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
	<!--{if helper_access::check_module('share') && $space[self]}-->
	<!--{template home/space_share_form}-->
	<!--{/if}-->
<!--{else}-->
	<!--{template common/header}-->
<style>
#toptb a#sslct, .switchwidth, #toptb a.switchblind {display: none;}
#moodfm textarea {width: 540px;height: 56px;border: 1px solid;border-color: #848484 #E0E0E0 #E0E0E0 #848484;overflow-y: auto;}
#moodfm {margin-bottom: 10px;}
.bw0 {background: transparent;}
.sl .h {background:none;font-size:14px;border:0;padding:0}
</style>
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="home.php?mod=space&do=share">{lang share}</a>
		</div>
	</div>
	<style id="diy_style" type="text/css"></style>
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>
	<div id="ct" class="ct2_a wp cl" style="margin:0;padding:0;width:auto !important">
		<!--{if 1}-->
			
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
			<div class="mn pbm" style="padding-top:5px;top:0">

				<div id="borderbox" style="padding:0px;margin-bottom:10px">
				<ul class="tb cl" style="line-height:15px;padding-bottom: 10px;padding-top: 10px;">
						<li$actives[we]><a href="home.php?mod=space&do=share&view=we" style="border-right: 1px solid #dfdfdf;margin-left:10px">{lang friend_share}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=share&view=me" style="border-right: 1px solid #dfdfdf">{lang my_share}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=share&view=all">{lang view_all}</a></li>
					</ul>
				</div>
			<style>
			.tb {border-bottom:0}
			#shareform {margin-bottom:10px}
			.tb a {display: block;padding: 0 10px;font-size: 14px;margin-bottom: 0;border-radius: 0;border-top:0;color:#1881BD;border-bottom:0;border-left:0;border-right:0;background: transparent !important;}
			.tb .a a, .tb .current a {font-weight: 700;border-bottom: 0px solid #0ad;color:#333;border-radius: 0;margin-bottom: 0;padding-bottom: 0;}
			#ct{background:transparent !important;border:0 !important;border-radius: 0px;}
            .ct2_a .mn {margin-right: 0px;background: transparent;margin-left: 0 !important;width: 710px;float:left;padding:0px !important;border: #ccc solid 0px;border-radius: 0px;}
            .ct2_a .appl {margin-bottom: 0px;width: 280px !important;float:right !important;border: #ccc solid 0px;border-left: 0px solid #DFDFDF;background: transparent;padding: 0px;border-radius: 0 5px 5px 0;left:0;top:0;height:auto !Important}
			.ct2_a .appl li{float:none !Important}
			#border-bottom {border-top:1px solid #27A5EC}
			.tbmu a {color: #1881BD;}
			.tbmu {padding: 8px 10px 8px 20px;border-bottom: 0px dashed #dfdfdf;}
			#share_ul li{padding-left:70px !important;border-bottom: 1px dotted #EFEFEF;padding-top:0;margin-bottom:10px}
			</style>
				<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
				<!--{if helper_access::check_module('share') && $space[self]}-->
				<!--{template home/space_share_form}-->
				<!--{/if}-->
		<!--{else}-->
			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{lang share}</h2>
					<ul>
						<li$actives[we]><a href="home.php?mod=space&do=share&view=we">{lang friend_share}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=share&view=me">{lang my_share}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=share&view=all">{lang view_all}</a></li>
					</ul>
				</div>
			</div>
			<style>
            .ct2_a .mn {width: 710px;}
            </style>
			<div class="mn pbm" style="top:0">
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
			<!--{if helper_access::check_module('share') && $space[self]}-->
			<!--{template home/space_share_form}-->
			<!--{/if}-->
		<!--{/if}-->
<!--{/if}-->
		<p class="tbmu" id="borderbox" style="margin-bottom:10px">
			<a href="$navtheurl&type=all"$sub_actives[type_all]>{lang share_all}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=link"$sub_actives[type_link]>{lang share_link}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=video"$sub_actives[type_video]>{lang share_video}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=music"$sub_actives[type_music]>{lang share_music}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=flash"$sub_actives[type_flash]>{lang share_flash}</a><span class="pipe">|</span>
			<!--{if helper_access::check_module('blog')}-->
			<a href="$navtheurl&type=blog"$sub_actives[type_blog]>{lang share_blog}</a><span class="pipe">|</span>
			<!--{/if}-->
			<!--{if helper_access::check_module('album')}-->
			<a href="$navtheurl&type=album"$sub_actives[type_album]>{lang share_album}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=pic"$sub_actives[type_pic]>{lang share_pic}</a><span class="pipe">|</span>
			<!--{/if}-->
			<a href="$navtheurl&type=poll"$sub_actives[type_poll]>{lang share_poll}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=space"$sub_actives[type_space]>{lang share_space}</a><span class="pipe">|</span>
			<a href="$navtheurl&type=thread"$sub_actives[type_thread]>{lang share_thread}</a>
			<!--{if helper_access::check_module('portal')}-->
			<span class="pipe">|</span>
			<a href="$navtheurl&type=article"$sub_actives[type_article]>{lang share_article}</a>
			<!--{/if}-->
		</p>
<div class="bf" id="borderbox">
		<!--{if $list}-->
			<ul id="share_ul" class="el sl">
				<!--{loop $list $k $value}-->
					<!--{template home/space_share_li}-->
				<!--{/loop}-->
			</ul>
			<!--{if $pricount}-->
				<p class="mtm">{lang hide_share}</p>
			<!--{/if}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<ul id="share_ul" class="el sl"></ul>
			<p class="emp">{lang not_share_yet}</p>
		<!--{/if}-->
		</div>
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


<script type="text/javascript">
	function succeedhandle_shareadd(url, msg, values) {
		share_add(values['sid']);
	}
</script>
<!--{template common/footer}-->