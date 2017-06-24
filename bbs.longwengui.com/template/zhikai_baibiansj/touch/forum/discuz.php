<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{if $_G['setting']['mobile']['mobilehotthread'] && $_GET['forumlist'] != 1}-->
	<!--{eval dheader('Location:forum.php?mod=guide&view=hot');exit;}-->
<!--{/if}-->
<!--{template common/header}-->

<script type="text/javascript">
	function getvisitclienthref() {
		var visitclienthref = '';
		if(ios) {
			visitclienthref = 'https://itunes.apple.com/cn/app/zhang-shang-lun-tan/id489399408?mt=8';
		} else if(andriod) {
			visitclienthref = 'http://www.discuz.net/mobile.php?platform=android';
		}
		return visitclienthref;
	}
</script>

<!--{if $_GET['visitclient']}-->

<header class="header">
    <div class="nav">
		<span>{lang warmtip}</span>
    </div>
</header>
<div class="cl">
	<div class="clew_con">
		<h2 class="tit">{lang zsltmobileclient}</h2>
		<p>{lang visitbbsanytime}<input class="redirect button" id="visitclientid" type="button" value="{lang clicktodownload}" href="" /></p>
		<h2 class="tit">{lang iphoneandriodmobile}</h2>
		<p>{lang visitwapmobile}<input class="redirect button" type="button" value="{lang clicktovisitwapmobile}" href="$_GET[visitclient]" /></p>
	</div>
</div>
<script type="text/javascript">
	var visitclienthref = getvisitclienthref();
	if(visitclienthref) {
		$('#visitclientid').attr('href', visitclienthref);
	} else {
		window.location.href = '$_GET[visitclient]';
	}
</script>

<!--{else}-->

<!-- header start -->
<div class="n5-header">
    <a class="n5-cebianlan" id="open-sb"><i class="n5-ico"></i></a>
	<a class="n5-logo" href="forum.php?mod=guide&view=hot"><img src="/template/zhikai_baibiansj/touch/style/logo.png" alt="$_G['setting']['sitename']" width="100%"></a>
	<a class="n5-fatie" href="forum.php?mod=misc&action=nav" rel="nofollow"><i class="n5-ico"></i></a>
</div>
<!--{template common/n5-cbl}-->
<!-- header end -->

<!--{hook/index_top_mobile}-->
<!-- main forumlist start -->
<div class="wp wm n5-bbs" id="wp">
	<!--{loop $catlist $key $cat}-->
	<div class="bm bmw fl">
		<div id="sub_forum_$cat[fid]" class="sub_forum bm_c">
			<ul>
				<!--{loop $cat[forums] $forumid}-->
				<!--{eval $forum=$forumlist[$forumid];}-->
				<li>
				
				<!--{if $forum[icon]}-->
                $forum[icon]
                <!--{else}-->
                <a href="forum.php?mod=forumdisplay&fid={$forum['fid']}"><img src="template/zhikai_baibiansj/touch/style/forum{$forum['fid']}.png" align="left" alt="$forum[name]" /></a>
                <!--{/if}-->
				
				<a href="forum.php?mod=forumdisplay&fid={$forum['fid']}" class="btdb"><!--{if $forum[todayposts] > 0}--><span class="num">$forum[todayposts]</span><!--{/if}-->{$forum[name]}</a>
				<i><!--{if empty($forum[redirect])}-->主题：<!--{echo dnumber($forum[threads])}--> 帖数：<!--{echo dnumber($forum[posts])}--><!--{/if}--></i>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/loop}-->
</div>
<!-- main forumlist end -->
<!--{hook/index_middle_mobile}-->
<script type="text/javascript">
	(function() {
		<!--{if !$_G[setting][mobile][mobileforumview]}-->
			$('.sub_forum').css('display', 'block');
		<!--{else}-->
			$('.sub_forum').css('display', 'none');
		<!--{/if}-->
		$('.subforumshow').on('click', function() {
			var obj = $(this);
			var subobj = $(obj.attr('href'));
			if(subobj.css('display') == 'none') {
				subobj.css('display', 'block');
				obj.find('img').attr('src', '{STATICURL}image/mobile/images/collapsed_yes.png');
			} else {
				subobj.css('display', 'none');
				obj.find('img').attr('src', '{STATICURL}image/mobile/images/collapsed_no.png');
			}
		});
	 })();
</script>

<!--{/if}-->

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?forumlist=1" class="bottom_history_on"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member"></a>
</div>

<!--{template common/footer}-->

