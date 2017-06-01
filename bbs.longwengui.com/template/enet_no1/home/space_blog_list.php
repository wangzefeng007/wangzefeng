<?php exit;?>
{eval
	$_G[home_tpl_spacemenus][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=blog&view=me\">{lang they_blog}</a>";
	$friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');
}


<!--{if $diymode}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<!--{subtemplate home/space_header}-->
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
					<div class="bm_h">
						<!--{if $space[self] && helper_access::check_module('blog')}--><span class="xi2 y"> <a href="home.php?mod=spacecp&ac=blog" class="addnew">{lang post_new_blog}</a></span><!--{/if}-->
						<h1 class="mt">{lang blog}</h1>
					</div>
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->
		<div id="pt" class="bm cl">
			<div class="z">
				<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]">{$space[username]}</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me">{lang blog}</a>
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
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="home.php?mod=space&do=blog">{lang blog}</a>
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
			<div id="borderbox" class="home_avt_box" style="padding:0;height:250px;margin-bottom:10px">
			<div class="avtss" style="position:absolute;width:278px;z-index:3">
			<a href="home.php?mod=space&uid=$_G[uid]" class="bf"><!--{avatar($_G[uid],big)}--></a>
			</div>
			<div style="height:130px;position:absolute;z-index:0">{if $_G[uid] && isset($_G[cookie][extstyle]) && strpos($_G[cookie][extstyle], TPLDIR) !== false}<img id="home_hear_bg" src="$_G[cookie][extstyle]/home_hear_bg.jpg" width="278" height="88" style="margin:0;border-radius:5px 5px 0 0"/>{else}<img id="home_hear_bg" src="./template/enet_no1/images/home_hear_bg.jpg" width="278" height="88" style="margin:0;border-radius:5px 5px 0 0"/>{/if}</div>
             <div style="height:130px;z-index:0"></div> 
			  <p>{$_G[member][username]}</p>
				 <p class="notice" style="font-weight: normal;background:none;padding-left:0;padding-right:0;padding-top:0">{lang credits}: $space[credits]</p>
				<!--{if helper_access::check_module('blog')}-->
					<div style="padding-top:5px;margin:0 20px"><a href="home.php?mod=spacecp&ac=blog" class="o pn pnc" style="height: 35px !important;display: block;margin:0;font-size:16px;border-radius:99px"><i style="background:url(template/enet_no1/images/fabu_blog.png);_background: none;_filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='template/enet_no1/images/fabu_blog.png');width:18px;height:18px;margin-left:58px;margin-top:8px;padding:0;float:left"></i><p style="line-height:33px;font-size:16px;float:left;margin-left:5px">{lang post_new_blog}</p></a></div>
				<!--{/if}-->
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
			#border-bottom {border-top:1px solid #27A5EC;border-radius:0 0 5px 5px}
			.tbmu a {color: #1881BD;}
			.tbmu {padding: 8px 10px 8px 20px;border-bottom: 0px dashed #dfdfdf;}
			.tbmu .pipe {display:inline}
			.tbmu a{padding-left:2px !Important;padding-right:2px !important}
			.tbmu .a {color: #333 !important;font-weight: 700;background: none !important;border-radius: 5px}
			</style>
				<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
				<div id="borderbox" style="padding:0px;margin-bottom:10px">
					<h1 class="mt"><img alt="blog" src="{STATICURL}image/feed/blog.gif" class="vm" /> {lang blog}</h1>
					<ul class="tb cl" style="line-height:15px;padding-bottom: 10px;padding-top: 10px;">
						<li$actives[we] style="border-right: 1px solid #dfdfdf;margin-left:10px"><a href="home.php?mod=space&do=blog&view=we">{lang friend_blog}</a></li>
						<li$actives[me] style="border-right: 1px solid #dfdfdf"><a href="home.php?mod=space&do=blog&view=me">{lang my_blog}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=blog&view=all">{lang view_all}</a></li>
					</ul>
			<div class="tbmu cl" id="border-bottom">
				<!--{if $_GET[view] == 'all'}-->
					<a href="home.php?mod=space&do=blog&view=all" {if !$_GET[catid]}$orderactives[dateline]{/if}>{lang newest_blog}</a><span class="pipe">|</span>
					<a href="home.php?mod=space&do=blog&view=all&order=hot" $orderactives[hot]>{lang recommend_blog}</a>
					<!--{if $category}-->
						<!--{loop $category $value}-->
							<span class="pipe">|</span>
							<a href="home.php?mod=space&do=blog&catid=$value[catid]&view=all&order=$_GET[order]"{if $_GET[catid]==$value[catid]} class="a"{/if}>$value[catname]</a>
						<!--{/loop}-->
					<!--{/if}-->
				<!--{/if}-->

				<!--{if $userlist}-->
					{lang filter_by_friend}
					<select name="fuidsel" onchange="fuidgoto(this.value);" class="ps" style="font-size:12px">
						<option value="">{lang all_friends}</option>
						<!--{loop $userlist $value}-->
						<option value="$value[fuid]"{$fuid_actives[$value[fuid]]}>$value[fusername]</option>
						<!--{/loop}-->
					</select>
				<!--{/if}-->

				<!--{if $_GET[view] == 'me' && $classarr}-->
					<!--{loop $classarr $classid $classname}-->
						<a href="home.php?mod=space&uid=$space[uid]&do=blog&classid=$classid&view=me" id="classid$classid" onmouseover="showMenu(this.id);"{if $_GET[classid]==$classid} class="a"{/if}>$classname</a><span class="pipe">|</span>
						<!--{if $space[self]}-->
						<div id="classid{$classid}_menu" class="p_pop" style="display: none; zoom: 1;">
							<a href="home.php?mod=spacecp&ac=class&op=edit&classid=$classid" id="c_edit_$classid" onclick="showWindow(this.id, this.href, 'get', 0);">{lang edit}</a>
							<a href="home.php?mod=spacecp&ac=class&op=delete&classid=$classid" id="c_delete_$classid" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a>
						</div>
						<!--{/if}-->
					<!--{/loop}-->
				<!--{/if}-->
			</div>
				</div>
		<!--{else}-->
			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{lang blog}</h2>
					<ul>
						<li$actives[we]><a href="home.php?mod=space&do=blog&view=we">{lang friend_blog}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=blog&view=me">{lang my_blog}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=blog&view=all">{lang view_all}</a></li>
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="padding-top: 0px;top:0">
			<style>
			.bbda .cl{margin-top:18px !Important}
			.m{padding-left:0 !Important}
              </style>
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
		<!--{/if}-->
<!--{/if}-->


			<!--{if $searchkey}-->
				<p class="tbmu">{lang follow_search_blog} <span style="color: red; font-weight: 700;">$searchkey</span> {lang doing_record_list}</p>
			<!--{/if}-->
					<style>
					.xld .atc {margin-left: 5px;}
					.xlda .m {display: inline;margin: 0px 0 0px 0px;}
					.bbda .m .avt img{border-radius:5px}
					.bbda .m .avt a{border-radius:5px !Important}
					.bbda .cl{padding-left: 15px;margin-top:18px}
					</style>
		<!--{if $count}-->
			<div class="xld {if empty($diymode)}xlda{/if}">
			<!--{loop $list $k $value}-->
				<dl class="bbda bf" id="borderbox" style="padding-top: 10px !important;padding: 10px 0 0 0;margin-bottom: 10px;margin-left:0 !important">
					<!--{if empty($diymode)}-->
					<dd class="m" style="padding-right: 7px;padding-left: 15px;">
						<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" c="1"><!--{avatar($value[uid],small)}--></a></div>
					</dd>
					<!--{/if}-->
					<dd style="padding-top:5px">
						<!--{if $value['friend']}-->
						<span class="y"><a href="$theurl&friend=$value[friend]">{$friendsname[$value[friend]]}</a></span>
						<!--{/if}-->
						<!--{if empty($diymode)}--><a href="home.php?mod=space&uid=$value[uid]" style="font-size:15px">$value[username]</a> <!--{/if}--><div style="padding-top:5px">$value[dateline]</div>
					</dd>
                      <dd class="cl" id="blog_article_$value[blogid]" style="font-size: 13px;padding-right: 15px;">
					  <div style="margin-bottom: 5px;">
						<!--{eval $stickflag = isset($value['stickflag']) ? 0 : 1;}-->
						<!--{if !$stickflag}--><span class="xi1">{lang stick}</span> &middot;<!--{/if}-->
	
						<a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]"{if $value[magiccolor]} style="color: {$_G[colorarray][$value[magiccolor]]};"{/if} target="_blank" style="font-size: 15px;">$value[subject]</a>
						<!--{if $value[status] == 1}--> <span class="xi1">({lang pending})</span><!--{/if}-->
						</div>
						<div>
						<!--{if $value[pic]}--><div class="atc"><a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]" target="_blank"><img src="$value[pic]" alt="$value[subject]" class="tn" /></a></div><!--{/if}-->
						$value[message]
						</div>
					</dd>
					<dd id="bbda-bottom" style="margin-top:5px">
						<!--{if $classarr[$value[classid]]}-->{lang personal_category}: <a href="home.php?mod=space&uid=$value[uid]&do=blog&classid=$value[classid]&view=me">{$classarr[$value[classid]]}</a><span class="pipe">|</span><!--{/if}-->
						<!--{if $value[viewnum]}--><a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]" target="_blank">$value[viewnum] {lang blog_read}</a><span class="pipe">|</span><!--{/if}-->
						<a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]#comment" target="_blank"><span id="replynum_$value[blogid]">$value[replynum]</span> {lang blog_replay}</a>
						<!--{if helper_access::check_module('share')}-->
						<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=share&type=blog&id=$value[blogid]&handlekey=lsbloghk_{$value[blogid]}" id="a_share_$value[blogid]" style="float:inherit" onclick="showWindow(this.id, this.href, 'get', 0);" class="xs1 xw0">{lang share}</a>
						<!--{/if}-->
						<!--{hook/space_blog_list_status $k}-->
						<!--{if $_GET['view']=='me' && $space['self']}-->
							<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=blog&blogid=$value[blogid]&op=edit">{lang edit}</a><span class="pipe">|</span>
							<a href="home.php?mod=spacecp&ac=blog&blogid=$value[blogid]&op=delete&handlekey=delbloghk_{$value[blogid]}" id="blog_delete_$value[blogid]" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a>
							<!--{if empty($value['status'])}-->
							<span class="pipe">|</span>
							<a href="home.php?mod=spacecp&ac=blog&blogid=$value[blogid]&op=stick&stickflag=$stickflag&handlekey=stickbloghk_{$value[blogid]}" id="blog_stick_$value[blogid]" onclick="showWindow(this.id, this.href, 'get', 0);"><!--{if $stickflag}-->{lang stick}<!--{else}-->{lang cancel_stick}<!--{/if}--></a>
							<!--{/if}-->
						<!--{/if}-->
						<!--{if $value['hot']}--><span class="pipe">|</span><span class="hot">{lang hot} $value[hot]</span><!--{/if}-->
					</dd>
				</dl>
			<!--{/loop}-->
			<!--{if $pricount}-->
				<p class="mtm">{lang hide_blog}</p>
			<!--{/if}-->
			</div>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<div class="emp bf" id="borderbox" style="padding:20px">{lang no_related_blog}</div>
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

<script type="text/javascript">
	function fuidgoto(fuid) {
		var parameter = fuid != '' ? '&fuid='+fuid : '';
		window.location.href = 'home.php?mod=space&do=blog&view=we'+parameter;
	}
</script>

<!--{template common/footer}-->