<?php exit;?>
<div id="pcd" class="bm cl">
	<!--{eval $encodeusername = rawurlencode($space[username]);}-->
	<div class="bm_c">
		<div class="hm">
			<p><a href="home.php?mod=space&uid=$space[uid]" class="avtm"><!--{avatar($space[uid],middle)}--></a></p>
			<h2 class="xs2"><a href="home.php?mod=space&uid=$space[uid]">$space[username]</a></h2>
		</div>
			<ul class="xl xl2 cl ul_list">
			<!--{if $space[self]}-->
				<!--{if $_G[setting][homepagestyle]}-->
				<li class="ul_diy"><a href="home.php?mod=space&do=index&diy=yes">{lang diy_space}</a></li>
				<!--{/if}-->
				<!--{if helper_access::check_module('wall')}-->
					<li class="ul_msg"><a href="home.php?mod=space&do=wall">{lang view_message}</a></li>
				<!--{/if}-->
				<li class="ul_avt"><a href="home.php?mod=spacecp&ac=avatar">{lang edit_avatar}</a></li>
				<li class="ul_profile"><a href="home.php?mod=spacecp&ac=profile">{lang update_profile}</a></li>
			<!--{else}-->
				<!--{if helper_access::check_module('follow')}-->
				<li class="ul_broadcast"><a href="home.php?mod=space&uid=$space[uid]">{lang follow_view_feed}</a></li>
				<!--{/if}-->
				<!--{if helper_access::check_module('follow') && $space[uid] != $_G[uid]}-->
					<li class="ul_flw">
						<!--{eval $follow = 0;}-->
						<!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $space['uid']);}-->
						<!--{if !$follow}-->
							<a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$space[uid]">{lang follow_add}TA</a>
						<!--{else}-->
							<a id="followmod" onclick="showWindow(this.id, this.href, 'get', 0);" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$space[uid]">{lang follow_del}</a>
						<!--{/if}-->
					</li>
				<!--{/if}-->
				<!--{eval require_once libfile('function/friend');$isfriend=friend_check($space[uid]);}-->
				<!--{if !$isfriend}-->
				<li class="ul_add"><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=addfriendhk_{$space[uid]}" id="a_friend_li_{$space[uid]}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang add_friend}</a></li>
				<!--{else}-->
				<li class="ul_ignore"><a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$space[uid]&handlekey=ignorefriendhk_{$space[uid]}" id="a_ignore_{$space[uid]}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang ignore_friend}</a></li>
				<!--{/if}-->
				<!--{if helper_access::check_module('wall')}-->
					<li class="ul_contect"><a href="home.php?mod=space&uid=$space[uid]&do=wall">{lang connect_me}</a></li>
				<!--{/if}-->
				<li class="ul_poke"><a href="home.php?mod=spacecp&ac=poke&op=send&uid=$space[uid]&handlekey=propokehk_{$space[uid]}" id="a_poke_{$space[uid]}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang say_hi}</a></li>

				<li class="ul_pm"><a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$space[uid]&touid=$space[uid]&pmid=0&daterange=2" id="a_sendpm_$space[uid]" onclick="showWindow('showMsgBox', this.href, 'get', 0)">{lang send_pm}</a></li>
			<!--{/if}-->
			</ul>
			<!--{if checkperm('allowbanuser') || checkperm('allowedituser') || $_G[adminid] == 1}-->
				<hr class="da mtn m0">
				<ul class="ptn xl xl2 cl">
					<!--{if checkperm('allowbanuser') || checkperm('allowedituser')}-->
						<li>
							<!--{if checkperm('allowbanuser')}-->
							<a href="{if $_G[adminid] == 1}admin.php?action=members&operation=ban&username=$encodeusername&frames=yes{else}forum.php?mod=modcp&action=member&op=ban&uid=$space[uid]{/if}" id="usermanageli" onmouseover="showMenu(this.id)" class="showmenu" target="_blank">{lang member_manage}</a>
							<!--{else}-->
							<a href="{if $_G[adminid] == 1}admin.php?action=members&operation=search&username=$encodeusername&submit=yes&frames=yes{else}forum.php?mod=modcp&action=member&op=edit&uid=$space[uid]{/if}" id="usermanageli" onmouseover="showMenu(this.id)" class="showmenu" target="_blank">{lang member_manage}</a>
							<!--{/if}-->
						</li>
					<!--{/if}-->

					<!--{if $_G[adminid] == 1}-->
						<li><a href="forum.php?mod=modcp&action=thread&op=post&do=search&searchsubmit=1&users=$encodeusername" id="umanageli" onmouseover="showMenu(this.id)" class="showmenu">{lang content_manage}</a></li>
					<!--{/if}-->
				</ul>
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
		</div>
	</div>
</div>
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