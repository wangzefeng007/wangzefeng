<?php exit;?>
<!--{template common/header}-->
<!--{template home/spacecp_header}-->

<div class="c_form">
	<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=password&op=">
	<table cellspacing="0" cellpadding="0" class="formtable">
		<caption>
			<h2>{lang my_login_password}</h2>
			<p>{lang modify_password_login}</p>
		</caption>
		<tr>
			<th width="100">{lang login_username}</th>
			<td>$space[username]</td>
		</tr>
		<tr>
			<th width="100">{lang old_password}</th>
			<td><input type="password" id="password" name="password" value="" class="t_input" /></td>
		</tr>
		<tr>
			<th>{lang new_password}</th>
			<td><input type="password" id="newpasswd1" name="newpasswd1" value="" class="t_input"></td>
		</tr>
		<tr>
			<th>{lang confirm_new_password}</th>
			<td><input type="password" id="newpasswd2" name="newpasswd2" value="" class="t_input"></td>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<td><input type="submit" name="pwdsubmit" value="{lang modify_password}" class="submit" /></td>
		</tr>
	</table>
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
</div>

<!--{template common/footer}-->