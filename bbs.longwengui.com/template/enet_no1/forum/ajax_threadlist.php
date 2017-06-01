<?php exit;?>
<!--{template common/header_ajax}-->
	<script type="text/javascript">
		if(!isUndefined(checkForumnew_handle)) {
			clearTimeout(checkForumnew_handle);
		}
		<!--{if $threadlist}-->
			if($('separatorline')) {
				var table = $('separatorline').parentNode;
			} else {
				var table = $('forum_' + $fid);
			}
			var newthread = [];
			<!--{eval $i = 0;}-->
			<!--{loop $threadlist $thread}-->
				newthread[{$i}] = {'tid':$thread[tid], 'thread': {'icn':{'className':'avt','val':<!--{if $thread['authorid'] && $thread['author']}-->'<a href="home.php?mod=space&uid=$thread[authorid]"><img src="{avatar($thread[authorid],small,true)}" onerror="this.onerror=null;this.src=\'{$_G[setting][ucenterurl]}/images/noavatar_middle.gif\'" /></a>'<!--{else}-->'<a><img src="{$_G[style][styleimgdir]}/hidden.gif" title="$_G[setting][anonymoustext]" alt="$_G[setting][anonymoustext]" /></a>'<!--{/if}-->}<!--{if $_G['forum']['ismoderator']}-->, 'o':{'className':'o','val':'<input type="checkbox" value="{$thread[tid]}" name="moderate[]" onclick="tmodclick(this)">'}<!--{/if}--> ,'common':{'className':'new','val':'$thread[threadurl]<p class="mtn xg1" style="font-size: 12px"><!--{hook/forumdisplay_author $key}--><!--{if $thread['authorid'] && $thread['author']}--><span>{lang author}: </span><a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}-->$verify[$thread[authorid]]<!--{/if}-->&nbsp;<!--{else}--><span>{lang author}: </span>$_G[setting][anonymoustext]&nbsp;&nbsp;<!--{/if}--><span>{lang dateline}: </span><span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span><span>&nbsp;{lang lastpost}: <!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}" c="1">$thread[lastposter]</a>&nbsp;/<!--{else}-->$_G[setting][anonymoustext]&nbsp;/<!--{/if}-->&nbsp;<a href="{if $thread[digest] != -2}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}">$thread[lastpost]</a></span></p>'},'flt':{'className':'flt','val':''},'flts':{'className':'flts','val':''},'lastpost':{'className':'by','val':'<div class="xld" style="float: right"><dd class="m hm"><strong class="xi2">{$thread[replies]}</strong><span>{lang reply}</span></dd><dd class="m hm"><strong class="xi2"><!--{if $thread['isgroup'] != 1}-->$thread[views]<!--{else}-->{$groupnames[$thread[tid]][views]}<!--{/if}--></strong><span>{lang focus_show}</span></dd></div>'}}};
				<!--{eval $i++;}-->
			<!--{/loop}-->
			removetbodyrow(table, '');
			for(var i = 0; i < newthread.length; i++) {
				if(newthread[i].tid) {
					addtbodyrow(table, ['tbody', 'newthread'], ['normalthread_', 'normalthread_'], 'separatorline', newthread[i]);
				}
			}
			function readthread(tid) {
				if($("checknewthread_"+tid)) {
					$("checknewthread_"+tid).className = "";
				}
			}
		<!--{elseif !$threadlist && $_GET['uncheck'] == 2}-->
			showDialog('{lang none_newthread}', 'notice', null, null, 0, null, null, null, null, 3);
		<!--{/if}-->
		checkForumnew_handle = setTimeout(function () {checkForumnew('{$fid}', '{$_G[timestamp]}');}, checkForumtimeout);
	</script>
<!--{template common/footer_ajax}-->