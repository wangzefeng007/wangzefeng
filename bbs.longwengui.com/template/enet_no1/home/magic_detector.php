<?php exit;?>
<!--{if $op == 'show'}-->
	<!--{template common/header}-->
	<script type="text/javascript">
		var html = ''
	<!--{if $list}-->
			+ '<ul class="mtm ml mls cl" style="width:370px;">'
		<!--{loop $list $value}-->
			+ "<li>"
			+ '<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" target="_blank">$value[avatar]</a></div>'
			+ '<p><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]" target="_blank">$value[username]</a></p>'
			+ '</li>'
		<!--{/loop}-->
			+ '</ul>';
	<!--{else}-->
			+ '<p style="padding:8px;">{lang no_redbag_space}</p>';
	<!--{/if}-->
		$('hkey_$_GET[handlekey]').innerHTML = html;
		$('hbtn_$_GET[handlekey]').style.display = 'none';
		setMenuPosition('fwin_$_GET[handlekey]', 'fwin_$_GET[handlekey]', '00');
	</script>
	<!--{template common/footer}-->
<!--{/if}-->