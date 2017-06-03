<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{template common/header}-->
<script type="text/javascript" src="{$_G[setting][jspath]}common.js?{VERHASH}"></script>

<!-- header start -->
<div class="n5-header">
    <a class="n5-cebianlan" id="open-sb"><i class="n5-ico"></i></a>
	<a class="n5-logo" href="forum.php?mod=guide&view=hot"><img src="$_G['style']['logo地址']" alt="$_G['setting']['sitename']" width="100%"></a>
	<a class="n5-fatie" href="forum.php?mod=misc&action=nav" rel="nofollow"><i class="n5-ico"></i></a>
</div>
<!--{template common/n5-cbl}-->
<!-- header end -->

<div class="n5-xs">
	<ul id="fs_group">$grouplist</ul>
	<ul id="fs_forum_common">$commonlist</ul>
	<!--{loop $forumlist $forumid $forum}-->
		<ul id="fs_forum_$forumid">$forum</ul>
	<!--{/loop}-->
	<!--{loop $subforumlist $forumid $forum}-->
		<ul id="fs_subforum_$forumid">$forum</ul>
	<!--{/loop}-->
</div>
<div class="n5-ksft">
	<ul class="pbl cl">
		<li id="block_group"></li>
		<li id="block_forum"></li>
		<li id="block_subforum"></li>
	</ul>
	<p class="cl">
		<!--{if $_G['group']['allowpost'] || !$_G['uid']}-->
			<!--{if $special === null}-->
				<button id="postbtn" class="n5-qh n5-fq" onclick="hideWindow('nav');showWindow('newthread', 'forum.php?mod=post&action=newthread&fid=' + selectfid)" disabled="disabled"><span>{lang send_posts}</span></button>
			<!--{else}-->
				<button id="postbtn" class="n5-qh n5-bk" onclick="hideWindow('nav');window.location.href='forum.php?mod=post&action=newthread&fid=' + selectfid + '&special=$special'" disabled="disabled"><span>$actiontitle</span></button>
			<!--{/if}-->
		<!--{/if}-->
		<span class="n5-xs"><span id="pbnv"></span> <a id="enterbtn" class="xg1" href="javascript:;" onclick="locationforums(currentblock, currentfid)">[{lang nav_forum}]</a></span>
	</p>
</div>

<script type="text/javascript" reload="1">
var s = '<!--{if $commonfids}--><p><a id="commonforum" href="javascript:;" onclick="switchforums(this, 1, \'common\')" class="pbsb lightlink">{lang nav_forum_frequently}</a></p><!--{/if}-->';
var lis = $('fs_group').getElementsByTagName('LI');
for(i = 0;i < lis.length;i++) {
	var gid = lis[i].getAttribute('fid');
	if($('fs_forum_' + gid)) {
		s += '<p><a href="javascript:;" ondblclick="locationforums(1, ' + gid + ')" onclick="switchforums(this, 1, ' + gid + ')" class="pbsb">' + lis[i].innerHTML + '</a></p>';
	}

}
$('block_group').innerHTML = s;
var lastswitchobj = null;
var selectfid = 0;
var switchforum = switchsubforum = '';

switchforums($('commonforum'), 1, 'common');

function switchforums(obj, block, fid) {
	if(lastswitchobj != obj) {
		if(lastswitchobj) {
			lastswitchobj.parentNode.className = '';
		}
		obj.parentNode.className = 'pbls';
	}
	var s = '';
	if(fid != 'common') {
		$('enterbtn').className = 'xi2';
		currentblock = block;
		currentfid = fid;
	} else {
		$('enterbtn').className = 'xg1';
	}
	if(block == 1) {
		var lis = $('fs_forum_' + fid).getElementsByTagName('LI');
		for(i = 0;i < lis.length;i++) {
			fid = lis[i].getAttribute('fid');
			if(fid != '') {
				s += '<p><a href="javascript:;" ondblclick="locationforums(2, ' + fid + '\)" onclick="switchforums(this, 2, ' + fid + ')"' + ($('fs_subforum_' + fid) ?  ' class="pbsb"' : '') + '>' + lis[i].innerHTML + '</a></p>';
			}
		}
		$('block_forum').innerHTML = s;
		$('block_subforum').innerHTML = '';
		switchforum = switchsubforum = '';
		selectfid = 0;
		$('postbtn').setAttribute("disabled", "disabled");
		$('postbtn').className = 'n5-qh n5-bk';
	} else if(block == 2) {
		selectfid = fid;
		if($('fs_subforum_' + fid)) {
			var lis = $('fs_subforum_' + fid).getElementsByTagName('LI');
			for(i = 0;i < lis.length;i++) {
				fid = lis[i].getAttribute('fid');
				s += '<p><a href="javascript:;" ondblclick="locationforums(3, ' + fid + ')" onclick="switchforums(this, 3, ' + fid + ')">' + lis[i].innerHTML + '</a></p>';
			}
			$('block_subforum').innerHTML = s;
		} else {
			$('block_subforum').innerHTML = '';
		}
		switchforum = obj.innerHTML;
		switchsubforum = '';
		$('postbtn').removeAttribute("disabled");
		$('postbtn').className = 'n5-qh n5-fq';
	} else {
		selectfid = fid;
		switchsubforum = obj.innerHTML;
		$('postbtn').removeAttribute("disabled");
		$('postbtn').className = 'n5-qh n5-fq';
	}
	lastswitchobj = obj;
	$('pbnv').innerHTML = switchforum ? '&nbsp;&gt;&nbsp;' + switchforum + (switchsubforum ? '&nbsp;&gt;&nbsp;' + switchsubforum : '') : '';
}

function locationforums(block, fid) {
	location.href = block == 1 ? 'forum.php?gid=' + fid : 'forum.php?mod=forumdisplay&fid=' + fid;
}

</script>

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?mod=guide&view=hot" class="bottom_index"></a>
	<a href="forum.php?forumlist=1" class="bottom_history"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post_on"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member"></a>
</div>

<!--{template common/footer}-->
