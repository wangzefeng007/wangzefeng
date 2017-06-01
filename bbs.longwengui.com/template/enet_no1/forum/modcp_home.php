<?php exit;?>
<div class="bm bw0 mdcp">
	<h1 class="mt">{lang mod_notice_title}</h1>
	<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]" id="list_adminnote">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="op" value="addnote" />
		<div class="exfm">
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td rowspan="2" width="75%"><textarea name="newmessage" class="pt" rows="5" style="width: 95%; height: 120px;"></textarea></td>
					<td width="25%">
						<ul>
							<li>{lang modcp_home_adminnote_to}:</li>
							<li><label><input type="checkbox" name="newaccess[1]" class="pc" value="1" checked="checked" disabled="disabled" />{lang admin}</label></li>
							<li><label><input type="checkbox" name="newaccess[2]" class="pc" value="1" checked="checked" />{lang supermod}</label></li>
							<li><label><input type="checkbox" name="newaccess[3]" class="pc" value="1" checked="checked" />{lang moderator}</label></li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>
						<p>{lang expire}:
							<label><input type="text" id="newexpiration" name="newexpiration" autocomplete="off" value="30" class="px" tabindex="1" size="2" /> {lang days}</label>
						</p>
					</td>
				</tr>
				<tr>
					<td colspan="2"><button type="submit" class="pn" name="submit" value="true"><strong>{lang modcp_home_adminnote_add}</strong></button></td>
				</tr>
			</table>
		</div>
	</form>

	<h2 class="bbs pbm ptm">{lang modcp_home_message_list}</h2>
	<!--{if $notelist}-->
		<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]" name="notelist" id="notelist">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="op" value="delete" />
			<input type="hidden" name="notlistsubmit" value="yes" />

			<!--{loop $notelist $note}-->
			<div class="um">
				<p class="pbn"><span class="y">({lang expire}: $note[expiration] {lang days})</span>$note[checkbox] <span class="xi2">$note[admin]</span> <span class="xg1">$note[dateline]</span></p>
				<p>$note[message]</p>
			</div>
			<!--{/loop}-->
			<div class="um bw0 cl">
				<input type="checkbox" name="ncheck" id="ncheck" class="pc" onclick="checkall($('notelist'), 'delete', 'ncheck')" /> <label for="ncheck">{lang checkall}</label>
				<button type="submit" name="submit" id="submit" class="pn" value="true"><strong>{lang delete}</strong></button>
			</div>
		</form>
	<!--{else}-->
		<p class="emp">{lang modcp_home_adminnote_nonexistence}</p>
	<!--{/if}-->
</div>