<?php exit;?>
<script type="text/javascript">
	function checkform(theform) {
		if (theform.message.value.length > 200) {
			alert('{lang activiy_guest_more}');
			theform.message.focus();
			return false;
		}
		return true;
	}
</script>

<div class="act pbm cl">
	<div class="spvimg">
		<!--{if $activity['thumb']}--><a href="javascript:;"><img src="$activity['thumb']" onclick="zoom(this, '$activity[attachurl]')" width="{if $activity[width] > 300}300{else}$activity[width]{/if}" /></a><!--{else}--><img src="{IMGDIR}/nophoto.gif" width="300" height="300" /><!--{/if}-->
	</div>
	<div class="spi">
		<dl>
			<dt>{lang activity_type}:</dt>
			<dd><strong>$activity[class]</strong></dd>
			<dt>{lang activity_starttime}:</dt>
			<dd>
				<!--{if $activity['starttimeto']}-->
					{lang activity_start_between}
				<!--{else}-->
					$activity[starttimefrom]
				<!--{/if}-->
			</dd>
			<dt>{lang activity_space}:</dt>
			<dd>$activity[place]</dd>
			<dt>{lang gender}:</dt>
			<dd>
				<!--{if $activity['gender'] == 1}-->
					{lang male}
				<!--{elseif $activity['gender'] == 2}-->
					{lang female}
				<!--{else}-->
					 {lang unlimited}
				<!--{/if}-->
			</dd>
			<!--{if $activity['cost']}-->
				<dt>{lang activity_payment}:</dt>
				<dd>$activity[cost] {lang payment_unit}</dd>
			<!--{/if}-->
			<!--{hook/viewthread_activity_extra1}-->
		</dl>
		<!--{if !$_G['forum_thread']['is_archived']}-->
		<dl class="nums mtw">
			<dt>{lang activity_already}:</dt>
			<dd>
				<em>$allapplynum</em> {lang activity_member_unit}
				<!--{if $post['invisible'] == 0 && ($_G['forum_thread']['authorid'] == $_G['uid'] || (in_array($_G['group']['radminid'], array(1, 2)) && $_G['group']['alloweditactivity']) || ( $_G['group']['radminid'] == 3 && $_G['forum']['ismoderator'] && $_G['group']['alloweditactivity']))}-->
					<span class="pipe">|</span>
					<span class="xi2"><a href="misc.php?mod=invite&action=thread&id=$_G[tid]&activity=1" onclick="showWindow('invite', this.href, 'get', 0);">{lang invite}</a></span> &nbsp;
					<span class="xi2"><a href="forum.php?mod=misc&action=activityapplylist&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}" onclick="showWindow('activity', this.href, 'get', 0)" title="{lang manage}">{lang manage}</a> &nbsp; <a href="forum.php?mod=misc&action=activityexport&tid=$_G[tid]" title="{lang pm_archive}">{lang pm_archive}</a></span>
				<!--{/if}-->
			</dd>
		</dl>
		<dl>
			<!--{if $activity['number']}-->
			<dt>{lang activity_about_member}:</dt>
			<dd>
				$aboutmembers {lang activity_member_unit}
			</dd>
			<!--{/if}-->
			<!--{if $activity['expiration']}-->
				<dt>{lang post_closing}:</dt>
				<dd>$activity[expiration]</dd>
			<!--{/if}-->
			<!--{hook/viewthread_activity_extra2}-->
			<dt></dt>
			<dd>
				<!--{if $post['invisible'] == 0}-->
					<!--{if $applied && $isverified < 2}-->
						<p class="xg1 xs1"><!--{if !$isverified}-->{lang activity_wait}<!--{else}-->{lang activity_join_audit}<!--{/if}--></p>
						<!--{if !$activityclose}--><p><button class="pn vm" type="submit" value="true" name="applylistsubmit" onclick="showDialog($('activityjoincancel').innerHTML, 'info', '{lang activity_join_cancel}')"><span>{lang activity_join_cancel}</span></button></p><!--{/if}-->
					<!--{elseif !$activityclose}-->
						<p class="pns">
							<!--{if $isverified != 2}-->
								<!--{if !$activity['number'] || $aboutmembers > 0}--><button class="pn" value="true" name="ijoin" onclick="{if $_G['uid']}showDialog($('activityjoin').innerHTML, 'info', '{lang activity_join}'){else}showWindow('login', 'member.php?mod=logging&action=login&guestmessage=yes'){/if}"><span>{lang activity_join}</span></button><!--{/if}-->
							<!--{else}-->
								<button class="pn" value="true" name="ijoin" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')"><span>{lang complete_data}</span></button>
							<!--{/if}-->
						</p>
					<!--{/if}-->
				<!--{/if}-->
			</dd>
		</dl>
		<!--{/if}-->
	</div>
</div>

<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_$post[pid]">$post[message]</td></tr></table>


<!--{if $_G['uid'] && !$activityclose && (!$applied || $isverified == 2)}-->
	<div id="activityjoin" style="display:none">
	<!--{if $_G['forum']['status'] == 3 && helper_access::check_module('group') && $isgroupuser != 'isgroupuser'}-->
		<div class="c">
			<p>{lang activity_no_member}</p>
			<p><a href="forum.php?mod=group&action=join&fid=$_G[fid]" class="xi2">{lang activity_join_group}</a></p>
		</div>
	<!--{else}-->
		<form name="activity" id="activity" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplies&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}" onsubmit="ajaxpost('activity', 'return_activityapplies', 'return_activityapplies', 'onerror');return false;">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="handlekey" value="activityapplies" />
			<div class="c">
				<!--{if $_G['setting']['activitycredit'] && $activity['credit'] && !$applied}--><p class="xi1">{lang activity_need_credit} $activity[credit] {$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]}</p><!--{/if}-->
				<div class="actfm">
					<table summary="{lang activity_join}" cellpadding="0" cellspacing="0" class="actl">
					<!--{if $activity['cost']}-->
						<tr>
							<th>{lang activity_paytype}</th>
							<td>
								<p class="mbn"><label for="payment_0"><input class="pr" type="radio" value="0" name="payment" id="payment_0" checked="checked" />{lang activity_pay_myself}</label></p>
								<p><label for="payment_1"><input type="radio" name="payment" id="payment_1" class="pr" value="1" />{lang activity_would_payment}</label> <input name="payvalue"class="px pxs vm" size="3" onfocus="$('payment_1').checked = true;" /> {lang payment_unit}</p>
							</td>
						</tr>
					<!--{/if}-->
					<!--{if !empty($activity['ufield']['userfield'])}-->
						<!--{loop $activity['ufield']['userfield'] $fieldid}-->
						<!--{if $settings[$fieldid][available]}-->
							<tr>
								<th id="th_$fieldid"><strong class="rq y">*</strong>$settings[$fieldid][title]</th>
								<td id="td_$fieldid">
							<!--{if $settings[$fieldid][formtype] != 'file'}-->
									$htmls[$fieldid]
							<!--{else}-->
								 <input id="activitypic_$fieldid" type="text" tabindex="1" value="" class="px" name="$fieldid" onblur="if(!this.value.match(/^https?:\/\/.+\/.+\.(jpg|png|gif|jpeg|bmp)$/i)){$('showerror_$fieldid').innerHTML='{lang activity_imgurl_error}';}else{$('showerror_$fieldid').innerHTML='&nbsp;';}"><div id="showerror_$fieldid" class="rq mtn">{lang activity_enter_imgurl}</div>
							<!--{/if}-->
								</td>
							</tr>
						<!--{/if}-->
						<!--{/loop}-->
					<!--{/if}-->
					<!--{if !empty($activity['ufield']['extfield'])}-->
						<!--{loop $activity['ufield']['extfield'] $extname}-->
							<tr>
								<th>$extname</th>
								<td><input type="text" name="$extname" maxlength="200" class="px" value="{if !empty($ufielddata)}$ufielddata[extfield][$extname]{/if}" /></td>
							</tr>
						<!--{/loop}-->
					<!--{/if}-->
						<tr>
							<th>{lang leaveword}</th>
							<td><textarea name="message" maxlength="200" cols="38" rows="3" class="pt">$applyinfo[message]</textarea></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="o pns">
				<!--{if $_G['setting']['activitycredit'] && $activity['credit'] && checklowerlimit(array('extcredits'.$_G['setting']['activitycredit'] => '-'.$activity['credit']), $_G['uid'], 1, 0, 1) !== true}-->
					<p class="xi1">{$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]} {lang not_enough}$activity['credit']</p>
				<!--{else}-->
					<input type="hidden" name="activitysubmit" value="true">
					<em class="xi1" id="return_activityapplies"></em>
					<button type="submit" class="pn pnc"><span>{lang submit}</span></button>
				<!--{/if}-->
			</div>
		</form>

		<script type="text/javascript">
			function succeedhandle_activityapplies(locationhref, message) {
				showDialog(message, 'right', '', 'location.href="' + locationhref + '"');
			}
		</script>
	<!--{/if}-->
	</div>
<!--{elseif $_G['uid'] && !$activityclose && $applied}-->
	<div id="activityjoincancel" style="display:none">
		<form name="activity" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplies&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<div class="c">
				<table summary="{lang activity_join}" cellpadding="0" cellspacing="0" class="actl">
					<tr>
						<th>{lang leaveword}</th>
						<td><input type="text" name="message" maxlength="200" class="px" value="" /></td>
					</tr>
				</table>
			</div>
			<div class="o pns"><button type="submit" name="activitycancel" class="pn pnc" value="true"><span>{lang submit}</span></button></div>
		</form>
	</div>
<!--{/if}-->

<!--{if $applylist}-->
	<div class="ptm pbm xs1" id="applylist_$_G[tid]">
		<h2>{lang activity_new_join} ($applynumbers {lang activity_member_unit})</h2>
		<table class="dt">
			<tr>
				<th width="140">&nbsp;</th>
				<th>{lang leaveword}</th>
				<!--{if $activity['cost']}-->
				<th width="60">{lang activity_payment}</th>
				<!--{/if}-->
				<th width="110">{lang activity_jointime}</th>
			</tr>
			<!--{loop $applylist $apply}-->
				<tr>
					<td>
						<a target="_blank" href="home.php?mod=space&uid=$apply[uid]" class="ratl vm"><!--{echo avatar($apply[uid], 'small')}--></a>
						<a target="_blank" href="home.php?mod=space&uid=$apply[uid]">$apply[username]</a>
					</td>
					<td><!--{if $apply[message]}--><p>$apply[message]</p><!--{/if}--></td>
					<!--{if $activity['cost']}-->
					<td><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></td>
					<!--{/if}-->
					<td>$apply[dateline]</td>
				</tr>
			<!--{/loop}-->
		</table>
		<!--{if $applynumbers > $_G['setting']['activitypp']}-->
		<br \>
		<div class="pgs mbm cl">
			<div class="pg">
				<a onclick="ajaxget('forum.php?mod=misc&amp;action=getactivityapplylist&amp;tid=$_G[tid]&amp;page=2', 'applylist_$_G[tid]')" class="nxt" href="javascript:;">{lang next_page}</a>
			</div>
		</div>
		<!--{/if}-->
	</div>
<!--{/if}-->

<!--{if $applylistverified}-->
	<div class="ptm pbm xs1">
		<h2>{lang activity_new_signup} ($noverifiednum {lang activity_member_unit})</h2>
		<table class="dt">
			<tr>
				<th width="140">&nbsp;</th>
				<th>{lang leaveword}</th>
				<!--{if $activity['cost']}-->
				<th width="60">{lang activity_payment}</th>
				<!--{/if}-->
				<th width="110">{lang activity_jointime}</th>
			</tr>
			<!--{loop $applylistverified $apply}-->
				<tr>
					<td>
						<a target="_blank" href="home.php?mod=space&uid=$apply[uid]" class="ratl vm"><!--{echo avatar($apply[uid], 'small')}--></a>
						<a target="_blank" href="home.php?mod=space&uid=$apply[uid]">$apply[username]</a>
					</td>
					<td><!--{if $_G['forum_thread']['authorid'] == $_G['uid'] && $apply[message]}-->$apply[message]<!--{/if}--></td>
					<!--{if $activity['cost']}-->
					<td><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></td>
					<!--{/if}-->
					<td>$apply[dateline]</td>
				</tr>
			<!--{/loop}-->
		</table>
	</div>
<!--{/if}-->