<?php exit;?>
<!--{template common/header_ajax}-->
<div id="flsrchdiv">
	<div class="mbm">{lang search_forum}: <input type="text" class="px vm" onkeyup="forumlistsearch(this.value)" /></div>
	<ul class="jump_bdl cl">
		<li>
			<p class="bbda xg1">{lang forumlist_allforum}</p>
		<!--{loop $forumlist $upfid $gdata}-->
			<!--{if $gdata['sub']}-->
				<p class="xw1{if $_GET['jfid'] == $upfid} a{/if}"><a href="forum.php?gid=$upfid">$gdata['name']</a></p>
				<!--{loop $gdata['sub'] $subfid $name}-->
					<p class="sub{if $_GET['jfid'] == $subfid} a{/if}"><a href="forum.php?mod=forumdisplay&fid=$subfid">$name</a></p>
					<!--{loop $gdata['child'][$subfid] $childfid $name}-->
						<p class="child{if $_GET['jfid'] == $childfid} a{/if}"><a href="forum.php?mod=forumdisplay&fid=$childfid">$name</a></p>
					<!--{/loop}-->
				<!--{/loop}-->
			<!--{/if}-->
		<!--{/loop}-->
		</li>

		<li>
			<p class="bbda xg1">{lang forumlist_recent}</p>
			<!--{loop $visitedforums $fid $forumname}-->
				<p{if $_GET['jfid'] == $fid} class="a"{/if}><a href="forum.php?mod=forumdisplay&fid=$fid">$forumname</a></p>
			<!--{/loop}-->
		</li>

		<li>
			<p class="bbda xg1">{lang forumlist_myfav}</p>
			<!--{loop $favforums $forum}-->
				<p{if $_GET['jfid'] == $forum[id]} class="a"{/if}><a href="forum.php?mod=forumdisplay&fid=$forum[id]">$forum['title']</a></p>
			<!--{/loop}-->
		</li>

	</ul>
</div>
<script type="text/javascript">
function forumlistsearch(srch) {
	srch = srch.toLowerCase();
	var p = $('flsrchdiv').getElementsByTagName('p');
	for(var i = 0;i < p.length;i++){
		p[i].style.display = p[i].innerText.toLowerCase().indexOf(srch) !== -1 ? '' : 'none';
	}
}
</script>
<!--{template common/footer_ajax}-->
