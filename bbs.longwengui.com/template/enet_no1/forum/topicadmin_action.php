<?php exit;?>
<!--{template common/header}-->
<!--{if empty($_GET['infloat'])}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> $navigation</div>
</div>
<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->

<div class="tm_c" id="floatlayout_topicadmin">
	<h3 class="flb">
		<em id="return_mods"><!--{if in_array($_GET[action], array('delpost', 'banpost', 'warn', 'stickreply'))}-->{lang admin_select_piece}<!--{elseif $_GET['action'] == 'delcomment'}-->{lang topicadmin_select_comment}<!--{else}-->{lang admin_select_one_piece}<!--{/if}--></em>
		<span>
			<a href="javascript:;" class="flbc" onclick="{if $_GET[action] == 'stamp'}if ($('threadstamp')) $('threadstamp').innerHTML = oldthreadstamp;{/if}hideWindow('mods')" title="{lang close}">{lang close}</a>
		</span>
	</h3>
	<form id="topicadminform" method="post" autocomplete="off" action="forum.php?mod=topicadmin&action=$_GET[action]&modsubmit=yes&infloat=yes&modclick=yes" onsubmit="ajaxpost('topicadminform', 'return_mods', 'return_mods', 'onerror');return false;">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="fid" value="$_G[fid]">
		<input type="hidden" name="tid" value="$_G[tid]">
		<!--{if !empty($_GET['page'])}--><input type="hidden" name="page" value="$_GET['page']" /><!--{/if}-->
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="c">
			<div class="{if $_GET[action] != 'split'}tplw{else}tpmh{/if}">
			<!--{if $_GET[action] == 'delpost'}-->
				$deleteid
				{lang admin_delposts}

				<!--{if ($modpostsnum == 1 || $authorcount == 1) && $crimenum > 0}-->
					<br /><div style="clear: both; text-align: right;">{lang topicadmin_crime_delpost_nums}</div>
				<!--{/if}-->
			<!--{elseif $_GET[action] == 'delcomment'}-->
				$deleteid
				{lang topicadmin_delet_comment}
			<!--{elseif $_GET[action] == 'restore'}-->
				<input type="hidden" name="archiveid" value="$archiveid" />
				{lang admin_threadsplit_restore}
			<!--{elseif $_GET[action] == 'copy'}-->
				<p class="mbn tahfx">
					{lang admin_target}: <select name="copyto" id="copyto" class="ps vm" onchange="ajaxget('forum.php?mod=ajax&action=getthreadtypes&fid=' + this.value, 'threadtypes')">
						$forumselect
					</select>
				</p>
				<p class="mbn tahfx">
					{lang admin_targettype}: <span id="threadtypes"><select name="threadtypeid" class="ps vm"><option value="0" /></option></select></span>
				</p>
			<!--{elseif $_GET[action] == 'banpost'}-->
				$banid
				<ul class="llst">
					<li><label><input type="radio" name="banned" class="pr" value="1" $checkban />{lang admin_banpost}</label></li>
					<li><label><input type="radio" name="banned" class="pr" value="0" $checkunban />{lang admin_unbanpost}</label></li>
				</ul>
				<!--{if ($modpostsnum == 1 || $authorcount == 1) && $crimenum > 0}-->
					<br /><div style="clear: both; text-align: right;">{lang topicadmin_crime_banpost_nums}</div>
				<!--{/if}-->
			<!--{elseif $_GET[action] == 'warn'}-->
				$warnpid
				<ul class="llst">
					<li><label><input type="radio" name="warned" class="pr" value="1" $checkwarn />{lang topicadmin_warn_add}</label></li>
					<li><label><input type="radio" name="warned" class="pr" value="0" $checkunwarn />{lang topicadmin_warn_delete}</label></li>
				</ul>
				<!--{if ($modpostsnum == 1 || $authorcount == 1) && $authorwarnings > 0}-->
					<br /><div style="clear: both; text-align: right;" title="{lang topicadmin_warn_prompt}">{lang topicadmin_warn_nums}</div>
				<!--{/if}-->
			<!--{elseif $_GET[action] == 'merge'}-->
				<table cellspacing="0" cellpadding="0">
					<tr>
						<td><label for="othertid">{lang admin_merge} &larr;</label></td>
						<td>{lang admin_merge_tid}</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><input type="text" name="othertid" id="othertid" class="px" size="10" /></td>
					</tr>
				</table>
			<!--{elseif $_GET[action] == 'refund'}-->
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th>{lang pay_buyers}</th>
						<td>$payment[payers]</td>
					</tr>
					<tr>
						<th>{lang pay_author_income}</th>
						<td>$payment[netincome] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][title]}</td>
					</tr>
				</table>
			<!--{elseif $_GET[action] == 'split'}-->
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td><label for="subject">{lang admin_split_newsubject}</label></td>
					</tr>
					<tr>
						<td><input type="text" name="subject" id="subject" class="px" size="20" /></td>
					</tr>
					<tr>
						<td><label for="split">{lang admin_split_comment}</label></td>
					</tr>
					<tr>
						<td><textarea name="split" id="split" class="pt" style="width: 212px; height:120px" /></textarea></td>
					</tr>
				</table>
			<!--{elseif $_GET[action] == 'live'}-->
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td>
							<ul class="llst">
								<li><label><input type="radio" name="live" class="pr" value="1" <!--{if $_G[forum][livetid] != $_G[tid]}-->checked<!--{/if}-->/>{lang admin_live}</label></li>
								<li><label><input type="radio" name="live" class="pr" value="0" <!--{if $_G[forum][livetid] == $_G[tid]}-->checked<!--{/if}-->/>{lang admin_live_cancle}</label></li>
							</ul>
						</td>
					</tr>
					<tr>
						<td><br>{lang admin_live_tips}</td>
					</tr>
				</table>
			<!--{elseif $_GET[action] == 'stamp'}-->
				<p>{lang admin_stamp_select}:</p>
				<p class="tah_body">
					<select name="stamp" id="stamp" class="ps" onchange="updatestampimg()">
						<option value="">{lang admin_stamp_none}</option>
					<!--{loop $_G['cache']['stamps'] $stampid $stamp}-->
						<!--{if $stamp['type'] == 'stamp'}-->
							<option value="$stampid"{if $thread[stamp] == $stampid} selected="selected"{/if}>$stamp[text]</option>
						<!--{/if}-->
					<!--{/loop}-->
					</select>
				</p>
				<script type="text/javascript" reload="1">
				if($('threadstamp')) {
					var oldthreadstamp = $('threadstamp').innerHTML;
				}
				var stampurls = new Array();
				<!--{loop $_G['cache']['stamps'] $stampid $stamp}-->
				stampurls[$stampid] = '$stamp[url]';
				<!--{/loop}-->
				function updatestampimg() {
					if($('threadstamp')) {
						$('threadstamp').innerHTML = $('stamp').value ? '<img src="{STATICURL}image/stamp/' + stampurls[$('stamp').value] + '">' : '<img src="{STATICURL}image/common/none.gif">';
					}
				}
				</script>
			<!--{elseif $_GET[action] == 'stamplist'}-->
				<p>{lang admin_stamplist_select}:</p>
				<p class="tah_body mbm">
					<select name="stamplist" id="stamplist" class="ps" onchange="updatestamplistimg()">
					<!--{if $thread[icon] >= 0}--><option value="$thread[icon]">{lang admin_stamplist_current}</option><!--{/if}-->
					<option value="">{lang admin_stamplist_none}</option>
					<!--{loop $_G['cache']['stamps'] $stampid $stamp}-->
						<!--{if $stamp['type'] == 'stamplist' && $stamp['icon']}-->
							<option value="$stampid"{if $thread[icon] == $stampid} selected="selected"{/if}>$stamp[text]</option>
						<!--{/if}-->
					<!--{/loop}-->
					</select>
				</p>
				<p class="tah_body" id="stamplistprev"></p>
				<script type="text/javascript" reload="1">
				var stampurls = new Array();
				<!--{loop $_G['cache']['stamps'] $stampid $stamp}-->
				stampurls[$stampid] = '$stamp[url]';
				<!--{/loop}-->
				function updatestamplistimg(icon) {
					icon = !icon ? $('stamplist').value : icon;

					if($('stamplistprev')) {
						$('stamplistprev').innerHTML = icon && icon >= 0 ? '<img src="{STATICURL}image/stamp/' + stampurls[icon] + '">' : '<img src="{STATICURL}image/common/none.gif">';
					}
				}
				<!--{if $thread[icon]}-->
					updatestamplistimg($thread[icon]);
				<!--{/if}-->
				</script>
			<!--{elseif $_GET[action] == 'stickreply'}-->
				$stickpid
				<ul class="llst">
					<li><label><input type="radio" name="stickreply" class="pr" value="1"{if empty($_GET['undo'])} checked="checked"{/if}/>{lang admin_stickreply} </label></li>
					<li><label><input type="radio" name="stickreply" class="pr" value="0"{if !empty($_GET['undo'])} checked="checked"{/if}/>{lang admin_unstickreply} </label></li>
				</ul>
			<!--{/if}-->
			</div>
			<div class="tpclg">
				<h4>
					<a onclick="showselect(this, 'reason', 'reasonselect')" class="dpbtn y" href="javascript:;">^</a>
					{lang admin_operation_explain}:
				</h4>
				<p><textarea name="reason" id="reason" class="pt" onkeyup="seditor_ctlent(event, '$(\'modsubmit\').click()')"></textarea></p>
				<ul id="reasonselect" style="display: none"><!--{echo modreasonselect()}--></ul>
			</div>
		</div>
		<div class="o pns">
			<!--{if $_GET[action] == 'delpost'}-->
			<label for="crimerecord"><input type="checkbox" name="crimerecord" id="crimerecord" class="pc" />{lang crimerecord}</label>
			<!--{/if}-->
			<label for="sendreasonpm"><input type="checkbox" name="sendreasonpm" id="sendreasonpm" class="pc"{if $_G['group']['reasonpm'] == 2 || $_G['group']['reasonpm'] == 3} checked="checked" disabled="disabled"{/if} />{lang admin_pm}</label>
			<button type="submit" name="modsubmit" id="modsubmit" value="ture" class="pn pnc"><span>{lang confirms}</span></button>
		</div>
	</form>
</div>
<script type="text/javascript" reload="1">
function succeedhandle_mods(locationhref) {
	<!--{if $_GET[action] == 'delcomment'}-->
		ajaxget('forum.php?mod=misc&action=commentmore&tid=$_G[tid]&pid=$pid', 'comment_$pid');
		hideWindow('mods');
	<!--{elseif $_GET[action] == 'banpost' || $_GET[action] == 'warn'}-->
		<!--{loop $topiclist $pid}-->
			ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$pid&modclick=yes', 'post_$pid', 'post_$pid');
			if($('topiclist_$pid')) {
				$('modactions').removeChild($('topiclist_$pid'));
			}
		<!--{/loop}-->
		hideWindow('mods');
		resetmodcount();
	<!--{else}-->
		hideWindow('mods');
		location.href = locationhref;
	<!--{/if}-->
}
</script>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->
