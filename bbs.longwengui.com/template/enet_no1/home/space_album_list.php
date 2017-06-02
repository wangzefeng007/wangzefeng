<?php exit;?>
<!--{eval $friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');}-->



<!--{if $diymode}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<!--{subtemplate home/space_header}-->
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
					<div class="bm_h">
						<!--{if $space[self] && helper_access::check_module('album')}--><span class="xi2 y"><a href="home.php?mod=spacecp&ac=upload" class="addnew">{lang upload_pic}</a></span><!--{/if}-->
						<h1 class="mt">{lang album}</h1>
					</div>
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->
		<div id="pt" class="bm cl">
			<div class="z">
				<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]">{$space[username]}</a> <em>&rsaquo;</em>
				<a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a>
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
			<a href="home.php?mod=space&do=album">{lang album}</a>
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
				<!--{if helper_access::check_module('album')}-->
					<div style="padding-top:5px;margin:0 20px"><a href="home.php?mod=spacecp&ac=upload" class="o pn pnc" style="height: 35px !important;display: block;margin:0;font-size:16px;border-radius:99px"><i style="background:url('template/enet_no1/images/fabu_album.png');_background: none;_filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='template/enet_no1/images/fabu_album.png');width:18px;height:18px;margin-left:68px;margin-top:8px;padding:0;float:left"></i><p style="line-height:33px;font-size:16px;float:left;margin-left:5px">{lang upload_pic}</p></a></div>
				<!--{/if}-->
			</div>
			<!--{/if}-->
				<div id="borderbox" style="padding-top: 10px;zoom:1">
				<!--{subtemplate common/userabout}-->
				</div>
			</div>
			<div class="mn pbm"  style="padding-top:5px;top:0">
			<div class="mn pbm"  style="padding-top:5px;top:0">
			<style>
			.tb {border-bottom:0}
			.tb a {display: block;padding: 0 10px;font-size: 14px;margin-bottom: 0;border-radius: 0;border-top:0;color:#1881BD;border-bottom:0;border-left:0;border-right:0;background: transparent !important;}
			.tb .a a, .tb .current a {font-weight: 700;border-bottom: 0px solid #59cbc7;color:#333;border-radius: 0;margin-bottom: 0;padding-bottom: 0;}
			#ct{background:transparent !important;border:0 !important;border-radius: 0px;}
            .ct2_a .mn {margin-right: 0px;background: transparent;margin-left: 0 !important;width: 710px;float:left;padding:0px !important;border: #ccc solid 0px;border-radius: 0px;}
            .ct2_a .appl {margin-bottom: 0px;width: 280px !important;float:right !important;border: #ccc solid 0px;border-left: 0px solid #DFDFDF;background: transparent;padding: 0px;border-radius: 0 5px 5px 0;left:0;top:0;height:auto !Important}
			.ct2_a .appl li{float:none !Important}
			#border-bottom {border-top:1px solid #59cbc7;border-radius:0 0 5px 5px}
			.tbmu a {color: #1881BD;}
			.tbmu {padding: 8px 10px 8px 20px;border-bottom: 0px dashed #dfdfdf;}
			.emp {padding-top: 5px}
			.tbmu .pipe {display:inline}
			.tbmu a{padding-left:2px !Important;padding-right:2px !important}
			.tbmu .a {color: #333 !important;font-weight: 700;background: none !important;border-radius: 5px}
			</style>
				<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
				<div id="borderbox" style="padding:0px;margin-bottom:10px">
					<ul class="tb cl" style="line-height:15px;padding-bottom: 10px;padding-top: 10px !important;">
						<li$actives[we]><a href="home.php?mod=space&do=album&view=we" style="border-right: 1px solid #dfdfdf;margin-left:10px">{lang friend_album}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=album&view=me" style="border-right: 1px solid #dfdfdf">{lang my_album}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=album&view=all">{lang view_all}</a></li>
					</ul>
		<div class="tbmu cl" id="border-bottom">
			<!--{if helper_access::check_module('album') && $space[self] && (($diymode && !$_G[setting][homepagestyle]) || (!$diymode && !1))}--><a href="home.php?mod=spacecp&ac=upload" class="y pn pnc"><strong>{lang upload_pic}</strong></a><!--{/if}-->

			<!--{if $space[self] && $_GET['view']=='me'}-->
				{lang explain_album}
			<!--{/if}-->

			<!--{if $_GET[view] == 'all'}-->
				<a href="home.php?mod=space&do=album&view=all" {if !$_GET[catid]}$orderactives[dateline]{/if}>{lang newest_update_album}</a><span class="pipe">|</span>
				<a href="home.php?mod=space&do=album&view=all&order=hot" $orderactives[hot]>{lang hot_pic_recommend}</a>
				<!--{if $_G['setting']['albumcategorystat'] && $category}-->
					<!--{loop $category $value}-->
						<span class="pipe">|</span>
						<a href="home.php?mod=space&amp;do=album&amp;catid={$value[catid]}&amp;view=all"{if $_GET[catid]==$value[catid]} class="a"{/if}>$value[catname]</a>
					<!--{/loop}-->
				<!--{/if}-->
			<!--{/if}-->

			<!--{if ($_GET['view'] == 'we') && $userlist}-->
				{lang filter_by_friend}
				<select name="fuidsel" onchange="fuidgoto(this.value);" class="ps" style="font-size:12px">
					<option value="">{lang all_friends}</option>
					<!--{loop $userlist $value}-->
					<option value="$value[fuid]"{$fuid_actives[$value[fuid]]}>$value[fusername]</option>
					<!--{/loop}-->
				</select>
			<!--{/if}-->
		</div>
				</div>
		<!--{else}-->
			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{lang album}</h2>
					<ul>
						<li$actives[we]><a href="home.php?mod=space&do=album&view=we">{lang friend_album}</a></li>
						<li$actives[me]><a href="home.php?mod=space&do=album&view=me" >{lang my_album}</a></li>
						<li$actives[all]><a href="home.php?mod=space&do=album&view=all">{lang view_all}</a></li>
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="top:0">
			<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
		<!--{/if}-->
<!--{/if}-->
		<div class="ptw" style="padding-top:0 !important;margin-right:-10px">
					<!--{if $picmode}-->

						<!--{if $pricount}-->
						<p class="mbw">{lang hide_pic}</p>
						<!--{/if}-->
						<!--{if $count}-->
						<ul class="ml mlp cl">
							<!--{loop $list $key $value}-->
							<li class="d">
								<div class="c">
									<a href="home.php?mod=space&uid=$value[uid]&do=album&picid=$value[picid]"><!--{if $value[pic]}--><img src="$value[pic]" alt="" /><!--{/if}--></a>
								</div>
								<p class="ptm"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]" class="xi2">$value[albumname]</a></p>
								<span><a href="home.php?mod=space&uid=$value[uid]">$value[username]</a></span>
							</li>
							<!--{/loop}-->
						</ul>
						<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
						<!--{else}-->
				            <div class="bf" id="borderbox" style="padding:20px;margin-right:10px">{lang no_album}</div>
						<!--{/if}-->
		
					<!--{else}-->
		
						<!--{if $searchkey}-->
						<p class="mbw">{lang follow_search_album} <span style="color: red; font-weight: 700;">$searchkey</span> {lang doing_record_list}</p>
						<!--{/if}-->
		
						<!--{if $pricount}-->
						<p class="mbw">{lang hide_album}</p>
						<!--{/if}-->
		
						<!--{if $count}-->
						<ul class="ml mla cl">
							<!--{loop $list $key $value}-->
							<!--{eval $pwdkey = 'view_pwd_album_'.$value['albumid'];}-->
							<li>
								<div class="c">
								<a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]" target="_blank" {if $_G['adminid'] != 1 && $value[uid]!=$_G[uid] && $value[friend]=='4' && $value[password] && empty($_G[cookie][$pwdkey])} onclick="showWindow('list_album_$value[albumid]', this.href, 'get', 0);"{/if}><!--{if $value[pic]}--><img src="$value[pic]" alt="$value[albumname]" /><!--{/if}-->
								<span class="pic-num-wrap">
								<!--{if $value[uid]==$_G[uid]}-->
								<!--{else}-->
									<div>$value[username]</div>
								<!--{/if}-->
								<div class="pic-num"><!--{if $value[picnum]}-->$value[picnum]<!--{/if}--></div>
								</span>
								</a>
								</div>
								<p class="ptn"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=$value[albumid]" target="_blank" {if $_G['adminid'] != 1 && $value[uid]!=$_G[uid] && $value[friend]=='4' && $value[password] && empty($_G[cookie][$pwdkey])} onclick="showWindow('list_album_$value[albumid]', this.href, 'get', 0);"{/if} class="xi2"><!--{if $value[albumname]}-->$value[albumname]<!--{else}-->{lang default_album}<!--{/if}--></a></p>
							</li>
							<!--{/loop}-->
							<!--{if $space[self] && $_GET['view']=='me'}-->
							<li>
								<div class="c">
									<a href="home.php?mod=space&uid=$value[uid]&do=album&id=-1"><img src="{IMGDIR}/nophoto.gif" alt="{lang default_album}" /></a>
								</div>
								<p class="ptn xi2"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=-1">{lang default_album}</a></p>
							</li>
							<!--{/if}-->
						</ul>
						<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
						<!--{else}-->
							<!--{if $space[self] && $_GET['view']=='me'}-->
								<ul class="ml mla cl">
									<li>
										<div class="c">
											<a href="home.php?mod=space&uid=$value[uid]&do=album&id=-1"><img src="{IMGDIR}/nophoto.gif" alt="{lang default_album}" /></a>
										</div>
										<p class="ptn xi2"><a href="home.php?mod=space&uid=$value[uid]&do=album&id=-1">{lang default_album}</a></p>
									</li>
								</ul>
							<!--{else}-->
				            <div class="bf" id="borderbox" style="padding:20px;margin-right:10px">{lang no_album}</div>
							<!--{/if}-->
						<!--{/if}-->
		
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

</div>
<script type="text/javascript">
function fuidgoto(fuid) {
	var parameter = fuid != '' ? '&fuid='+fuid : '';
	window.location.href = 'home.php?mod=space&do=album&view=we'+parameter;
}
</script>

<!--{template common/footer}-->