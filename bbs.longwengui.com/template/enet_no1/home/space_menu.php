<?php exit;?>
<!--{if $space[uid]}-->
<style>
.flw_feed {width:100% !important}
.flw_article{padding-left:0 !important}
#flw_header{width:701 !important}
.fow_ad{display:none}
.tl .th {background:none}
.flw_hd{width:auto !Important}
#moodfm textarea {width: 554px;height: 76px;margin-right:0px;border: 2px solid #59cbc7;overflow-y: hidden;font-size: 13px;padding: 10px;}
.moodfm_btn button {padding-left: 0px;margin-left:0;background: url(template/enet_no1/images/fow.png) no-repeat !important;width:100px;height:100px;opacity: 10;filter: alpha(opacity=100);border:0}
.moodfm_btn{padding-left:0;width:100px;height:100px;background:none}
.moodfm_btn button:hover{background: url(template/enet_no1/images/fow.png) 0 100px !Important;}
.tl tr .xg1{border-bottom:1px dotted #E6E6E6 !Important}
.xld .bbda .cl{padding-left:0 !important}
.bm_c .avt a{margin-left:0 !important}
.mn .avt{display:none}
.mn .cl{border:0 !important}
.bm_c .xld #borderbox{margin-left:-10px !important}
#feed_div .el .cl{padding-left:0 !important;padding-right:0 !important}
#uhd{border-radius:5px 5px 0 0}
.ct1{border-radius:0 0 5px 5px}
#shareform, #borderbox {background:transparent !important;border:0 !important}
#bbda-bottom{background:transparent !important;border:0 !important;padding:0}
.mn #bbda-bottom{padding-left:0}
.bm_c .ptw{padding:20px;margin-top:20px;padding-bottom:0}
.mn #borderbox{margin-bottom:0 !Important}
#followlist li,#borderbox dl,#ct .mn .bm .bm_c .xld dl{border-bottom:1px dotted #E4E4E4 !Important}
#share_ul div li{padding-left:0;padding-right:0;border-bottom:0}
#shareform{margin-bottom:0}
.tbmu{padding-bottom:0 !important}
#moodfm{padding-top:10px;padding-left:10px}
.mn .xs2{height:0 !important}
.bm_c .tb{border-bottom:0}
.mn .bm_c .tl{margin-top:15px}
#share_ul .cl{border-left:0 !important}
#share_ul .xg1{padding-left:10px}
</style>
<div id="uhd">
	<!--{if CURMODULE == 'follow'}-->
		<!--{subtemplate home/follow_user_header}-->
	<!--{elseif !$space[self]}-->
	<div class="mn">
		<ul>
			<!--{if helper_access::check_module('follow')}-->
			<li class="addflw">
				<!--{if !ckfollow($space['uid'])}-->
					<a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$space[uid]">{lang follow_add}TA</a>
				<!--{else}-->
					<a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$space[uid]">{lang follow_del}</a>
				<!--{/if}-->
			</li>
			<!--{/if}-->
			<li class="addf">
				<!--{if !$isfriend}-->
				<a href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=addfriendhk_{$space[uid]}" id="a_friend_li_{$space[uid]}" onclick="showWindow(this.id, this.href, 'get', 0);" class="xi2">{lang add_friend}</a>
				<!--{else}-->
				<a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$space[uid]&handlekey=ignorefriendhk_{$space[uid]}" id="a_ignore_{$space[uid]}" onclick="showWindow(this.id, this.href, 'get', 0);" class="xi2">{lang ignore_friend}</a>
				<!--{/if}-->
			</li>
			<li class="pm2">
				<a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$space[uid]&touid=$space[uid]&pmid=0&daterange=2" id="a_sendpm_$space[uid]" onclick="showWindow('showMsgBox', this.href, 'get', 0)" title="{lang send_pm}">{lang send_pm}</a>
			</li>
		</ul>
		<!--{if helper_access::check_module('follow')}-->
		<script type="text/javascript">
		function succeedhandle_followmod(url, msg, values) {
			var fObj = $('followmod');
			if(values['type'] == 'add') {
				fObj.innerHTML = '{lang follow_del}';
				fObj.href = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+values['fuid'];
			} else if(values['type'] == 'del') {
				fObj.innerHTML = '{lang follow_add}TA';
				fObj.href = 'home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid='+values['fuid'];
			}
		}
		</script>
		<!--{/if}-->
	</div>
	<!--{/if}-->
	<div class="h cl">
		<div class="icn avt"><a href="home.php?mod=space&uid=$space[uid]"><!--{avatar($space[uid],small)}--></a></div>
		<h2 class="mt">
			{$space[username]}
			<!--{if isset($flag[$_G['uid']])}-->
			<span class="xs1 xg1 xw0">
				<span id="followbkame_{$uid}"><!--{if $flag[$_G['uid']]['bkname']}-->$flag[$_G['uid']]['bkname']<!--{/if}--></span>
				<a href="home.php?mod=spacecp&ac=follow&op=bkname&fuid=$uid&handlekey=followbkame_$uid" id="fbkname_{$uid}" onclick="showWindow('followbkame_{$uid}', this.href, 'get', 0);"><!--{if $flag[$_G['uid']]['bkname']}-->[{lang follow_mod_bkname}]<!--{else}-->[{lang follow_add_bkname}]<!--{/if}--></a>
			</span>
			<!--{/if}-->
		</h2>
		<p>
			<a href="{$_G[siteurl]}?$uid" class="xg1">{$_G[siteurl]}?$uid</a>
			<!--{if checkperm('allowbanuser') || checkperm('allowedituser') || $_G[adminid] == 1}-->
				<span class="pipe">|</span>
					<!--{if checkperm('allowbanuser') || checkperm('allowedituser')}-->
							<!--{if checkperm('allowbanuser')}-->
							<a href="{if $_G[adminid] == 1}admin.php?action=members&operation=ban&username=$encodeusername&frames=yes{else}forum.php?mod=modcp&action=member&op=ban&uid=$space[uid]{/if}" id="usermanageli" onmouseover="showMenu(this.id)" class="showmenu" target="_blank">{lang member_manage}</a>
							<!--{else}-->
							<a href="{if $_G[adminid] == 1}admin.php?action=members&operation=search&username=$encodeusername&submit=yes&frames=yes{else}forum.php?mod=modcp&action=member&op=edit&uid=$space[uid]{/if}" id="usermanageli" onmouseover="showMenu(this.id)" class="showmenu" target="_blank">{lang member_manage}</a>
							<!--{/if}-->
					<!--{/if}-->
					
					<!--{if $_G[adminid] == 1}-->
						<a href="forum.php?mod=modcp&action=thread&op=post&do=search&searchsubmit=1&users=$encodeusername" id="umanageli" onmouseover="showMenu(this.id)" class="showmenu">{lang content_manage}</a>
					<!--{/if}-->
				<!--{if checkperm('allowbanuser') || checkperm('allowedituser')}-->
				<ul id="usermanageli_menu" class="p_pop" style="width: 80px; display:none;">
					<!--{if checkperm('allowbanuser')}-->
						<li><a href="{if $_G[adminid] == 1}admin.php?action=members&operation=ban&username=$encodeusername&frames=yes{else}forum.php?mod=modcp&action=member&op=ban&uid=$space[uid]{/if}" target="_blank">{lang user_ban}</a></li>
					<!--{/if}-->
					<!--{if checkperm('allowedituser')}-->
						<li><a href="{if $_G[adminid] == 1}admin.php?action=members&operation=search&username=$encodeusername&submit=yes&frames=yes{else}forum.php?mod=modcp&action=member&op=edit&uid=$space[uid]{/if}" target="_blank">{lang user_edit}</a></li>
					<!--{/if}-->
				</ul>
				<!--{/if}-->
				<!--{if $_G['adminid'] == 1}-->
					<ul id="umanageli_menu" class="p_pop" style="width: 80px; display:none;">
						<li><a href="forum.php?mod=modcp&action=thread&op=post&searchsubmit=1&do=search&users=$encodeusername" target="_blank">{lang manage_post}</a></li>
						<!--{if helper_access::check_module('doing')}-->
							<li><a href="admin.php?action=doing&searchsubmit=1&detail=1&search=true&fromumanage=1&users=$encodeusername" target="_blank">{lang manage_doing}</a></li>
						<!--{/if}-->
						<!--{if helper_access::check_module('blog')}-->
							<li><a href="admin.php?action=blog&searchsubmit=1&detail=1&search=true&fromumanage=1&uid=$space[uid]" target="_blank">{lang manage_blog}</a></li>
						<!--{/if}-->
						<!--{if helper_access::check_module('feed')}-->
							<li><a href="admin.php?action=feed&searchsubmit=1&detail=1&fromumanage=1&uid=$space[uid]" target="_blank">{lang manage_feed}</a></li>
						<!--{/if}-->
						<!--{if helper_access::check_module('album')}-->
							<li><a href="admin.php?action=album&searchsubmit=1&detail=1&search=true&fromumanage=1&uid=$space[uid]" target="_blank">{lang manage_album}</a></li>
							<li><a href="admin.php?action=pic&searchsubmit=1&detail=1&search=true&fromumanage=1&users=$encodeusername" target="_blank">{lang manage_pic}</a></li>
						<!--{/if}-->
						<!--{if helper_access::check_module('wall')}-->
							<li><a href="admin.php?action=comment&searchsubmit=1&detail=1&fromumanage=1&authorid=$space[uid]" target="_blank">{lang manage_comment}</a></li>
						<!--{/if}-->
						<!--{if helper_access::check_module('share')}-->
							<li><a href="admin.php?action=share&searchsubmit=1&detail=1&search=true&fromumanage=1&uid=$space[uid]" target="_blank">{lang manage_share}</a></li>
						<!--{/if}-->
						<!--{if helper_access::check_module('group')}-->
							<li><a href="admin.php?action=threads&operation=group&searchsubmit=1&detail=1&search=true&fromumanage=1&users=$encodeusername" target="_blank">{lang manage_group_threads}</a></li>
							<li><a href="admin.php?action=prune&searchsubmit=1&detail=1&operation=group&fromumanage=1&users=$encodeusername" target="_blank">{lang manage_group_prune}</a></li>
						<!--{/if}-->
					</ul>
				<!--{/if}-->
			<!--{/if}-->
		</p>
	</div>
	
	<!--{hook/space_menu_extra}-->
	<ul class="tb cl" style="padding-left: 75px;">
		<!--{if helper_access::check_module('follow')}-->
		<li{if CURMODULE == 'follow'} class="a"{/if}><a href="home.php?mod=follow&uid=$space[uid]&do=view&from=space">{lang follow}</a></li>
		<!--{/if}-->
		<li{if $do=='thread'} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space">{lang topic}</a></li>
		<!--{if helper_access::check_module('blog')}-->
		<li{if $do=='blog'} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang blog}</a></li>
		<!--{/if}-->
		<!--{if helper_access::check_module('album')}-->
		<li{if $do=='album'} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a></li>
		<!--{/if}-->
		<!--{if helper_access::check_module('doing')}-->
		<li{if $do=='doing'} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=doing&view=me&from=space">{lang doing}</a></li>
		<!--{/if}-->
		<!--{if helper_access::check_module('home')}-->
		<li{if $do=='home'} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=home&view=me&from=space">{lang feed}</a></li>
		<!--{/if}-->
		<!--{if helper_access::check_module('share')}-->
		<li{if $do=='share'} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=share&view=me&from=space">{lang share}</a></li>
		<!--{/if}-->
		<!--{if helper_access::check_module('wall')}-->
		<li{if $do==wall} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=wall&from=space">{lang message}</a></li>
		<!--{/if}-->
		<li{if $do==profile} class="a"{/if}><a href="home.php?mod=space&uid=$space[uid]&do=profile&from=space">{lang memcp_profile}</a></li>
	</ul>
</div>
<!--{/if}-->