<?php exit;?>
<!--{if $op=='use'}-->
	<h4 class="mtm mbn">{lang add_friend_max_10}</h4>
	<p>
		<input type="hidden" name="id" value="'.$id.'" />
		<input type="hidden" name="idtype" value="'.$idtype.'" />
		<input type="text" id="friendinput" class="px vm" />&nbsp;<button type="button" class="pn vm" onclick="addFriendCall();"><span>{lang add}</span></button>
	</p>
	<div id="friendscall" class="mtn"></div>
<!--{elseif $op=='show'}-->
	<!--{template common/header}-->
	<script type="text/javascript">
		var html = '<p>{lang sent_following_friends}</p>'
			+ '<ul class="mtm ml mls cl" style="width:370px;">'
	<!--{loop $list $value}-->
			+ "<li>"
			+ '<div class="avt"><a href="home.php?mod=space&uid=$value[fuid]" target="_blank">$value[avatar]</a></div>'
			+ '<p><a href="home.php?mod=space&uid=$value[fuid]" title="$value[fusername]" target="_blank">$value[fusername]</a></p>'
			+ '</li>'
	<!--{/loop}-->
			+ '</ul>';
		$('hkey_$_GET[handlekey]').innerHTML = html;
		$('hbtn_$_GET[handlekey]').style.display = 'none';
		setMenuPosition('fwin_$_GET[handlekey]', 'fwin_$_GET[handlekey]', '00');
	</script>
	<!--{template common/footer}-->
<!--{/if}-->