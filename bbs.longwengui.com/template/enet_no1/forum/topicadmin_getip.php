<?php exit;?>
<!--{template common/header}-->
<b>$member[useip]{if $member[port]}:$member[port]{/if}</b> $member[iplocation]
<!--{if $_G['group']['allowviewip']}-->
	<br /><a href="admin.php?action=members&operation=ipban&ip=$member[useip]&frames=yes" target="_blank" class="xg2">{lang admin_ban_this_ip}</a>
	<a href="admin.php?action=members&operation=search&regip=$member[useip]&submit=yes&frames=yes" target="_blank" class="xg2">{lang admin_user_this_ip}</a>
<!--{/if}-->
<!--{template common/footer}-->