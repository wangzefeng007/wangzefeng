<?php exit;?>
<div class="bm bw0 mdcp">
<!--{if $op == 'edit' || $op == 'ban'}-->
	<h1 class="mt"><!--{if $op == 'edit'}-->{lang mod_member_edit}<!--{else}-->{lang mod_member_ban}<!--{/if}--></h1>
	<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op">
		<input type="hidden" name="formhash" value="{FORMHASH}">
		<div class="exfm">
			<table cellspacing="0" cellpadding="0">
				<caption>
					<!--{if !empty($error)}-->
						<!--{if $error == 1}-->
							{lang mod_message_member_search}
						<!--{elseif $error == 2}-->
							{lang mod_message_member_nonexistence}
						<!--{elseif $error == 3}-->
							{lang mod_message_member_nopermission}
							<!--{if $_G['adminid'] == 1}-->
								, <a href="admin.php?action=members&operation=search&username={$usernameenc}&submit=yes&frames=yes" target="_blank" class="xi2">{lang mod_message_goto_admincp}</a>
							<!--{/if}-->
						<!--{/if}-->
					<!--{/if}-->
				</caption>
				<tr>
					<th width="15%">{lang username}:</th>
					<td width="85%"><input type="text" name="username" class="px" value="" size="20" /></td>
				</tr>
				<tr>
					<th>UID:</th>
					<td><input type="text" name="uid" class="px" value="" size="20" /> [{lang optional}]</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><button type="submit" name="submit" id="searchsubmit" class="pn" value="true"><strong>{lang modcp_logs_search}</strong></button></td>
				</tr>
			</table>
		</div>
	</form>
<!--{/if}-->

<!--{if $op == 'edit' && $member && !$error}-->
	<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op" class="schresult">
		<input type="hidden" name="formhash" value="{FORMHASH}">
		<input type="hidden" name="username" value="$_GET['username']">
		<input type="hidden" name="uid" value="$_GET['uid']">
		<table cellspacing="0" cellpadding="0" class="tfm">
			<tr>
				<th>&nbsp;</th>
				<td>
					<table width="100%">
						<tr>
							<td width="10%" rowspan="2" class="avt"><!--{echo avatar($member[uid], 'small');}--></td>
							<td>
								<p><a href="home.php?mod=space&uid=$member[uid]" target="_blank" class="xi2">$member[username]</a></p>
								<p>UID: $member[uid]</p>
								<p><label><input type="checkbox" name="clearavatar" class="pc" value="1" />{lang avatar_del}</label></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th>{lang bio}</th>
				<td><textarea name="bionew" class="pt" rows="4" cols="80">$member['bio']</textarea></td>
			</tr>
			<tr>
				<th>{lang signature}</th>
				<td><textarea name="signaturenew" class="pt" rows="4" cols="80">$member[signature]</textarea></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><button type="submit" name="editsubmit" id="submit" class="pn" value="true"><strong>{lang submit}</strong></button></td>
			</tr>
		</table>
	</form>
<!--{/if}-->

<!--{if $op == 'ban' && $member && !$error}-->
	<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op" class="schresult">
		<input type="hidden" name="formhash" value="{FORMHASH}">
		<input type="hidden" name="username" value="$_GET['username']">
		<input type="hidden" name="uid" value="$_GET['uid']">
		<table cellspacing="0" cellpadding="0" class="tfm">
			<tr>
				<th>&nbsp;</th>
				<td>
					<table width="100%">
						<tr>
							<td width="10%" rowspan="2" class="avt"><!--{echo avatar($member[uid], 'small');}--></td>
							<td>
								<p><a href="home.php?mod=space&uid=$member[uid]" target="_blank" class="xi2">$member[username]</a></p>
								<p>UID: $member[uid]</p>
								<p><!--{if $member[groupid] == 4}-->{lang modcp_members_status_banpost}<!--{elseif $member[groupid] == 5}-->{lang modcp_members_status_banvisit}<!--{else}-->{lang modcp_members_status_normal}<!--{/if}--> <!--{if $member['banexpiry']}-->( {lang valid_before} $member['banexpiry'] )<!--{/if}--></p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!--{if $clist}-->
				<tr>
					<th>{lang crime_record}</th>
					<td style="padding-top: 0;">
						<table cellspacing="0" cellpadding="0" class="dt">
							<tr>
								<td width="15%">{lang crime_action}</td>
								<td width="15%">{lang crime_dateline}</td>
								<td>{lang crime_reason}</td>
								<td width="15%">{lang crime_operator}</td>
							</tr>
							<!--{loop $clist $crime}-->
							<tbody id="$crime[cid]">
								<tr>
									<td>
										<!--{if $crime[action] == 'crime_delpost'}-->
										{lang crime_delpost}
										<!--{elseif $crime[action] == 'crime_warnpost'}-->
										{lang crime_warnpost}
										<!--{elseif $crime[action] == 'crime_banpost'}-->
										{lang crime_banpost}
										<!--{elseif $crime[action] == 'crime_banspeak'}-->
										{lang crime_banspeak}
										<!--{elseif $crime[action] == 'crime_banvisit'}-->
										{lang crime_banvisit}
										<!--{elseif $crime[action] == 'crime_banstatus'}-->
										{lang crime_banstatus}
										<!--{elseif $crime[action] == 'crime_avatar'}-->
										{lang crime_avatar}
										<!--{elseif $crime[action] == 'crime_sightml'}-->
										{lang crime_sightml}
										<!--{elseif $crime[action] == 'crime_customstatus'}-->
										{lang crime_customstatus}
										<!--{/if}-->
									</td>
									<td>
										<!--{date($crime[dateline])}-->
									</td>
									<td>$crime[reason]</td>
									<td>
										<a href="home.php?mod=space&uid=$crime[operatorid]" class="xi2">$crime[operator]</a>
									</td>
								</tr>
							</tbody>
							<!--{/loop}-->
						</table>
					</td>
				</tr>
			<!--{/if}-->
			<tr>
				<th>{lang changeto}:</th>
				<td>
					<!--{if $member[groupid] == 4 || $member[groupid] == 5}-->
						<label for="bannew_0" class="lb"><input type="radio" name="bannew" id="bannew_0" value="0" checked="checked" class="pr" />{lang modcp_members_status_normal}</label>
					<!--{/if}-->
					<!--{if $member[groupid] != 4 && $_G[group][allowbanuser]}--><label for="bannew_4" class="lb"><input type="radio" name="bannew" id="bannew_4" class="pr" value="4" {if $member[groupid] != 4 && $member[groupid] != 5}checked="checked"{/if} />{lang modcp_members_status_banpost}</label><!--{/if}-->
					<!--{if $member[groupid] != 5 && $_G[group][allowbanvisituser]}--><label for="bannew_5" class="lb"><input type="radio" name="bannew" id="bannew_5" class="pr" value="5" {if $member[groupid] != 4 && $member[groupid] != 5 && !$_G[group][allowbanuser]}checked="checked"{/if} />{lang modcp_members_status_banvisit}</label><!--{/if}-->
				</td>
			</tr>
			<tr>
				<th>{lang expiry}:</th>
				<td>
					<p class="hasd cl">
						<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
						<input type="text" id="banexpirynew" name="banexpirynew" autocomplete="off" value="" class="px" tabindex="1" style="margin-right: 0; width: 100px;" />
						<a href="javascript:;" class="dpbtn" onclick="showselect(this, 'banexpirynew', 1, 1)">^</a>
					</p>
					<p class="d">{lang modcp_members_ban_days_comment}</p>
				</td>
			</tr>
			<tr>
				<th valign="top">{lang reason}:</th>
				<td><textarea name="reason" class="pt" rows="4" cols="80">$member[signature]</textarea></td>
			</tr>
			<tr>
				<th>&nbsp;</th>
				<td><button type="submit" name="bansubmit" id="submit" class="pn" value="true"><strong>{lang submit}</strong></button></td>
			</tr>
		</table>
	</form>
<!--{/if}-->

<!--{if $op == 'ipban'}-->
	<h1 class="mt">{lang mod_option_member_ipban}</h1>
	<form method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op">
		<input type="hidden" name="formhash" value="{FORMHASH}">
		<div class="exfm">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<th width="15%">{lang add_new}</th>
					<td width="85%">
						<input type="text" name="ip1new" class="px" value="$iptoban[0]" size="2" maxlength="3"/> .
						<input type="text" name="ip2new" class="px" value="$iptoban[1]" size="2" maxlength="3" /> .
						<input type="text" name="ip3new" class="px" value="$iptoban[2]" size="2" maxlength="3" /> .
						<input type="text" name="ip4new" class="px" value="$iptoban[3]" size="2" maxlength="3" />
						&nbsp;&nbsp;{lang modcp_ip_message}
					</td>
				</tr>
				<tr>
					<th width="15%">{lang expiry}:</th>
					<td width="85%" class="hasd cl">
						<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
						<input type="text" id="validitynew" name="validitynew" autocomplete="off" value="" class="px" tabindex="1" style="width: 100px;" />
						<a href="javascript:;" class="dpbtn" onclick="showselect(this, 'validitynew', 0, 1)">^</a>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<button type="submit" name="ipbansubmit" id="submit" class="pn" value="true"><strong>{lang submit}</strong></button>
						<!--{if $adderror}-->
							<!--{if $adderror == 1}-->
								{lang modcp_members_ip_error_1}
							<!--{elseif $adderror == 2}-->
								{lang modcp_members_ip_error_2}
							<!--{elseif $adderror == 3}-->
								{lang modcp_members_ip_error_3}
							<!--{elseif $updatecheck || $deletecheck || $addcheck}-->
								{lang modcp_members_ip_succed}
							<!--{else}-->
								{lang modcp_members_ip_error_4}
							<!--{/if}-->
						<!--{/if}-->
					</td>
				</tr>
			</table>
		</div>

		<h2 class="mtm mbm">{lang modcp_ban_ip}</h2>
		<table cellspacing="0" cellpadding="0" class="dt">
			<thead>
				<tr>
					<th class="c">{lang delete}</th>
					<th>{lang online_ip}</th>
					<th>{lang ip_location}</th>
					<th>{lang modcp_members_ip_addadmin}</th>
					<th>{lang starttime}</th>
					<th>{lang endtime}</th>
				</tr>
			</thead>
			<!--{if $iplist}-->
				<!--{loop $iplist $ip}-->
				<tr>
					<td><input type="checkbox" name="delete[]" class="pc" value="$ip[id]" $ip[disabled]></td>
					<td>$ip[theip]</td>
					<td>$ip[location]</td>
					<td>$ip[admin]</td>
					<td>$ip[dateline]</td>
					<td class="hasd cl">
						<input type="text" id="expirationnew[{$ip[id]}]" name="expirationnew[{$ip[id]}]" autocomplete="off" value="$ip[expiration]" class="px" tabindex="1"/>
						<a href="javascript:;" class="dpbtn" onclick="showselect(this, 'expirationnew[{$ip[id]}]', 0, 1)">^</a>
					</td>
				</tr>
				<!--{/loop}-->
				<tr class="bw0_all">
					<td><label for="chkall" onclick="checkall(this.form)"><input type="checkbox" name="chkall" id="chkall" class="pc" />{lang checkall}</label></td>
					<td colspan="5"><button type="submit" name="ipbansubmit" id="submit" class="pn" value="true"><strong>{lang submit}</strong></button></td>
				</tr>
			<!--{else}-->
				<tr><td colspan="6"><p class="emp">{lang no_ban_ip}</p></td></tr>
			<!--{/if}-->
		</table>
	</form>
<!--{/if}-->
</div>