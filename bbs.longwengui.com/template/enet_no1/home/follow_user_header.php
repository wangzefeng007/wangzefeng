<?php exit;?>

<div class="flw_hd">
	<!--{if helper_access::check_module('follow')}-->
	<div class="tns">
		<table cellspacing="0" cellpadding="0">
			<tr>
				<li style="margin-left:-10px">
				<a href="home.php?mod=follow&uid=$uid&do=view">
					<p class="xw1">$space['feeds']</p>
					<span>{lang follow}</span>
				</a>
				</li>
				<li>
				<a href="home.php?mod=follow&do=following&uid=$uid">
					<p class="xw1">$space['following']</p>
					<span>{lang follow_add}</span>
				</a>
				</li>
				<li style="border:0 !important">
				<a href="home.php?mod=follow&do=follower&uid=$uid" id="followernum_$uid">
					<p class="xw1">$space['follower']</p>
					<span>{lang follow_follower}</span>
				</a>
				</li>
			</tr>
		</table>
	</div>
	<!--{/if}-->
<!--{if !$viewself}-->
	<div class="mtm o cl">
		<div id="followflag" {if !isset($flag[$_G['uid']])}style="display: none"{/if}>
			<!--{if helper_access::check_module('follow')}-->
			<a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&special={if $flag[$_G['uid']]['status'] == 1}2{else}1{/if}&fuid=$uid&from=head" class="{if $flag[$_G['uid']]['status'] == 1}flw_specialunfo{else}flw_specialfo{/if}" id="specialflag_$uid" onclick="ajaxget(this.href);doane(event);" title="{if $flag[$_G['uid']]['status'] == 1}{lang follow_del_special_following}{else}{lang follow_add_special_following}{/if}"><!--{if $flag[$_G['uid']]['status'] == 1}-->{langfollow_del_special_following}<!--{else}-->{lang follow_add_special_following}<!--{/if}--></a>
			<!--{/if}-->
			<!--{if $flag[$_G['uid']]['mutual']}-->
			<span class="z flw_status_2">{lang follow_follower_mutual}</span>
			<!--{else}-->
			<span class="z flw_status_1">{lang follow_followed},</span>
			<!--{/if}-->
			<a id="a_followmod_{$uid}" href="home.php?mod=spacecp&ac=follow&op=del&fuid=$uid&from=head" onclick="ajaxget(this.href);doane(event);" class="xi2">{lang follow_del}</a>
		</div>
		<div id="unfollowflag" {if isset($flag[$_G['uid']])}style="display: none"{/if}>
			<!--{if isset($flag[$uid])}-->
			<span class="z flw_status_1">{lang follow_user_followed}</span>
			<!--{/if}-->
			<!--{if helper_access::check_module('follow')}-->
			<a id="a_followmod_{$uid}" href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$uid&from=head" onclick="ajaxget(this.href);doane(event);" class="flw_btn_fo">{lang follow_add}</a>
			<!--{/if}-->
		</div>
	</div>
<!--{/if}-->
</div>