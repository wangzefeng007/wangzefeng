<?php exit;?>
<div class="bm bw0 mdcp">
	<h1 class="mt">{lang mod_option_member_access}</h1>
	<div class="mbm">{lang mod_notice_access}</div>
	<!--{if $modforums['fids']}-->
		<script type="text/javascript">
		function chkallaccess(obj) {
			$('new_post').checked
				= $('new_post').disabled
				= $('new_reply').checked
				= $('new_reply').disabled
				= $('new_postattach').checked
				= $('new_postattach').disabled
				= $('new_getattach').checked
				= $('new_getattach').disabled
				= $('new_getimage').checked
				= $('new_getimage').disabled
				= $('new_postimage').disabled
				= obj.checked;
		}

		function disallaccess(obj) {
			$('new_view').checked
				= $('new_post').checked
				= $('new_post').checked
				= $('new_reply').checked
				= $('new_postattach').checked
				= $('new_getattach').checked
				= $('new_getimage').checked
				= $('new_postimage').disabled
				= false;
			$('customaccess').disabled
				= $('new_view').disabled
				= $('new_view').disabled
				= $('new_post').disabled
				= $('new_post').disabled
				= $('new_reply').disabled
				= $('new_postattach').disabled
				= $('new_getattach').disabled
				= $('new_getimage').disabled
				= $('new_postimage').disabled
				= obj.checked;
		}

		</script>
		<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="op" value="$op" id="operation" />
			<div class="exfm">
				<table cellspacing="0" cellpadding="0">
					<!--{if $adderror || $successed}-->
					<tr>
						<th>&nbsp;</th>
						<td>
							<span class="rq"> *
							<!--{if $successed}-->
								{lang mod_message_access_updatepermission}
							<!--{elseif $adderror == 1}-->
								{lang mod_message_access_user_nonexistence}
							<!--{elseif $adderror == 2}-->
								{lang mod_message_access_user_invalid}
							<!--{elseif $adderror == 3}-->
								{lang mod_message_access_admin_invalid}
							<!--{/if}-->
							</span>
						</td>
					</tr>
					<!--{/if}-->
					<tr>
						<th width="15%">{lang mod_moderate_selectforum}:</th>
						<td width="80%">
							<span class="ftid">
								<select name="fid" id="fid" class="ps" width="108">
									<!--{loop $modforums[list] $id $name}-->
									<option value="$id" {if $id == $_G[fid]}selected="selected"{/if}>$name</option>
									<!--{/loop}-->
								</select>
							</span>
						</td>
					</tr>
					<tr>
						<th>{lang username}:</th>
						<td>
							<input type="text" size="20" value="$new_user" name="new_user" class="px" /> &nbsp;&nbsp;
						</td>
					</tr>
					<tr>
						<th>{lang mod_access_change}:</th>
						<td>
							<label for="deleteaccess" class="lb"><input type="checkbox" value="1" name="deleteaccess" id="deleteaccess" onclick="disallaccess(this)" class="pc" />{lang mod_access_recover}</label>
							<span id="customaccess">
								<label for="new_view" class="lb"><input type="checkbox" value="-1" name="new_view" id="new_view" onclick="chkallaccess(this)" class="pc" />{lang mod_access_ban_viewthread}</label>
								<label for="new_post" class="lb"><input type="checkbox" value="-1" name="new_post" id="new_post" class="pc" />{lang mod_access_ban_postthread}</label>
								<label for="new_reply" class="lb"><input type="checkbox" value="-1" name="new_reply" id="new_reply" class="pc" />{lang mod_access_ban_postreply}</label>
								<label for="new_getattach" class="lb"><input type="checkbox" value="-1" name="new_getattach" id="new_getattach" class="pc" />{lang mod_access_ban_download}</label>
								<label for="new_getimage" class="lb"><input type="checkbox" value="-1" name="new_getimage" id="new_getimage" class="pc" />{lang mod_access_ban_getimage}</label>
								<label for="new_postattach" class="lb"><input type="checkbox" value="-1" name="new_postattach" id="new_postattach" class="pc" />{lang mod_access_ban_upload}</label>
								<label for="new_postimage" class="lb"><input type="checkbox" value="-1" name="new_postimage" id="new_postimage" class="pc" />{lang mod_access_ban_uploadimage}</label>
							</span>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><button type="submit" class="pn" name="addsubmit" value="true"><strong>{lang submit}</strong></button></td>
					</tr>
				</table>
			</div>
			<script type="text/javascript">
			<!--{if !empty($deleteaccess)}-->
				var obj = $('deleteaccess');
				obj.checked = true;
				disallaccess(obj);
			<!--{elseif !empty($new_view)}-->
				var obj = $('new_view');
				obj.checked = true;
				chkallaccess(obj);
			<!--{/if}-->
			</script>
		</form>
	<!--{/if}-->
	<div class="ptm pbm cl">
		<div class="y pns">
			<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				{lang username}: <input type="text" name="suser" class="px vm" value="$suser" onclick="this.value='';" />&nbsp;
				<select name="fid" class="ps vm">
					<option>{lang all}{lang forum}</option>
					$forumlistall
				</select>&nbsp;
				<button type="submit" name="searchsubmit" id="searchsubmit" class="pn vm" value="true"><strong>{lang search}</strong></button>
			</form>
		</div>
		<h2>{lang mod_access_specialuser}</h2>
	</div>

	<table id="list_member" cellspacing="0" cellpadding="0" class="dt">
		<thead>
			<tr>
				<th>{lang member}</th>
				<th>{lang forum}</th>
				<th>{lang mod_access_viewthread}</th>
				<th>{lang mod_access_postthread}</th>
				<th>{lang mod_access_postreply}</th>
				<th>{lang mod_access_download}</th>
				<th>{lang mod_access_getimage}</th>
				<th>{lang mod_access_upload}</th>
				<th>{lang mod_access_uploadimage}</th>
				<th>{lang mod_access_optime}</th>
				<th>{lang moderator}</th>
			</tr>
		</thead>
		<!--{if $list[data]}-->
			<!--{loop $list[data] $access}-->
				<tr>
					<td><!--{if $users[$access[uid]] != ''}--><a href="home.php?mod=space&uid=$access[uid]" target="_blank" class="xi2">{$users[$access[uid]]}</a><!--{else}-->UID $access[uid]<!--{/if}--></td>
					<td>$access['forum']</td>
					<td>$access['allowview']</td>
					<td>$access['allowpost']</td>
					<td>$access['allowreply']</td>
					<td>$access['allowgetattach']</td>
					<td>$access['allowgetimage']</td>
					<td>$access['allowpostattach']</td>
					<td>$access['allowpostimage']</td>
					<td>$access[dateline]</td>
					<td><!--{if $users[$access[adminuser]] != ''}--><a href="home.php?mod=space&uid=$access[adminuser]" target="_blank" class="xi2">{$users[$access[adminuser]]}</a><!--{else}-->UID $access[adminuser]<!--{/if}--></td>
				</tr>
			<!--{/loop}-->
		<!--{else}-->
			<tr><td colspan="11"><p class="emp">{lang mod_message_access_nonexistence}</p></td></tr>
		<!--{/if}-->
	</table>
	<!--{if !empty($list[pagelink])}--><div class="pgs cl mtm">$list[pagelink]</div><!--{/if}-->
</div>
<script type="text/javascript" reload="1">
	if($('fid')) {
		simulateSelect('fid');
	}
</script>