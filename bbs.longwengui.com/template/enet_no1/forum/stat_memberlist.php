<?php exit;?>
<!--{template common/header}-->

<div id="ct" class="ct7_a wp cl">
	<!--{subtemplate common/stat}-->
	<div class="mn">
		<div class="bm bw0">
			<div class="cl">
				<form method="post" action="misc.php?mod=stat&op=memberlist" class="mbm y">
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<input type="text" name="srchmem" class="px vm" size="15" />
					&nbsp;<button type="submit" class="pn vm"><em>{lang search}</em></button>
				</form>
				<h1 class="mt">{lang member_list}</h1>
			</div>
			<table summary="{lang member_list}" class="dt bm">
				<tr>
					<th><a href="misc.php?mod=stat&op=memberlist&order=username{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang username}</a></th>
					<th><a href="misc.php?mod=stat&op=memberlist&order=uid{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang uid}</a></th>
					<th><a href="misc.php?mod=stat&op=memberlist&order=gender{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang gender}</a></th>
					<th><a href="misc.php?mod=stat&op=memberlist&order=regdate{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang regdate}</a></th>
					<th><a href="misc.php?mod=stat&op=memberlist&order=lastvisit{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang lastvisit}</a></th>
					<th><a href="misc.php?mod=stat&op=memberlist&order=posts{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang posts}</a></th>
					<th><a href="misc.php?mod=stat&op=memberlist&order=credits{if !$_GET[asc]}&asc=1{/if}" class="showmenu">{lang credits}</a></th>
				</tr>
				<!--{loop $memberlist $member}-->
					<tr class="{echo swapclass('alt')}">
						<td><a href="home.php?mod=space&uid=$member[uid]" class="xw1">$member[username]</a></td>
						<td>$member[uid]</td>
						<td><!--{if $member['gender'] == '1'}-->{lang male}<!--{elseif $member['gender'] == 2}-->{lang female}<!--{else}-->&nbsp;<!--{/if}--></td>
						<td>$member[regdate]</td>
						<td>$member[lastvisit]</td>
						<td>$member[posts]</td>
						<td>$member[credits]</td>
					</tr>
				<!--{/loop}-->
			</table>
			<!--{if !empty($multipage)}--><div class="pgs cl">$multipage</div><!--{/if}-->
		</div>
	</div>
</div>
<!--{template common/footer}-->