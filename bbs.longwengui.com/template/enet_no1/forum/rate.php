<?php exit;?>
<!--{template common/header}-->
<!--{if empty($_GET['showratetip'])}-->
<!--{if empty($_GET['infloat'])}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> $navigation</div>
</div>
<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->

<!--{if $_GET[action] == 'rate'}-->
<div class="tm_c" id="floatlayout_topicadmin">
	<h3 class="flb">
		<em id="return_rate">{lang rate}</em>
		<span>
			<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('rate')" title="{lang close}">{lang close}</a><!--{/if}-->
		</span>
	</h3>
	<form id="rateform" method="post" autocomplete="off" action="forum.php?mod=misc&action=rate&ratesubmit=yes&infloat=yes" onsubmit="ajaxpost('rateform', 'return_rate', 'return_rate', 'onerror');">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="tid" value="$_G[tid]" />
		<input type="hidden" name="pid" value="$_GET[pid]" />
		<input type="hidden" name="referer" value="$referer" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="rate"><!--{/if}-->
		<div class="c">
			<table cellspacing="0" cellpadding="0" class="dt mbm">
				<tr>
					<th>&nbsp;</th>
					<th width="65">&nbsp;</th>
					<th width="65">{lang rate_raterange}</th>
					<th width="55">{lang rate_todayleft}</th>
				</tr>
				<!--{eval $rateselfflag = 0;}-->
				<!--{loop $ratelist $id $options}-->
					<tr>
						<td>{$_G['setting']['extcredits'][$id][img]} {$_G['setting']['extcredits'][$id][title]}</td>
						<td>
							<input type="text" name="score$id" id="score$id" class="px z" value="0" style="width: 25px;" />
							<a href="javascript:;" class="dpbtn" onclick="showselect(this, 'score$id', 'scoreoption$id')">^</a>
							<ul id="scoreoption$id" style="display:none">$options</ul>
						</td>
						<td>{$_G['group']['raterange'][$id]['min']} ~ {$_G['group']['raterange'][$id]['max']}</td>
						<!--{eval $rateselfflag = $_G['group']['raterange'][$id][isself] ? 1 : $rateselfflag;}-->
						<td>$maxratetoday[$id]</td>
					</tr>
				<!--{/loop}-->
			</table>

			<div class="tpclg">
				<h4>{lang user_operation_explain}:</h4>
				<table cellspacing="0" cellpadding="0" class="reason_slct">
					<!--{eval $selectreason = modreasonselect(0, 'userreasons')}-->
					<!--{if $selectreason}-->
					 	<tr>
					 		<td>
					 			<ul id="reasonselect" class="reasonselect pt">$selectreason</ul>
					 			<script type="text/javascript" reload="1">
					 				var reasonSelectOption = $('reasonselect').getElementsByTagName('li');
					 				if (reasonSelectOption) {
					 					for (i=0; i<reasonSelectOption.length; i++) {
					 						reasonSelectOption[i].onmouseover = function() { this.className = 'xi2 cur1'; }
					 						reasonSelectOption[i].onmouseout = function() { this.className = ''; }
					 						reasonSelectOption[i].onclick = function() {
					 							$('reason').value = this.innerHTML;
					 						}
					 					}
					 				}
					 			</script>
					 		</td>
					 	</tr>
					<!--{/if}-->
					<tr>
				 	 	<td><input type="text" name="reason" id="reason" class="px" onkeyup="seditor_ctlent(event, '$(\'rateform\').ratesubmit.click()')" /></td>
					</tr>
				</table>
			</div>
			<!--{if $rateselfflag}-->
				<div class="xg1">{lang admin_rate}</div>
			<!--{/if}-->
		</div>
		<p class="o pns">
			<label for="sendreasonpm"><input type="checkbox" name="sendreasonpm" id="sendreasonpm" class="pc"{if $_G['group']['reasonpm'] == 2 || $_G['group']['reasonpm'] == 3} checked="checked" disabled="disabled"{/if} />{lang admin_pm}</label>
			<button name="ratesubmit" type="submit" value="true" class="pn pnc"><span>{lang confirms}</span></button>
		</p>
	</form>
</div>

<!--{elseif $_GET[action] == 'removerate'}-->

<form id="rateform" method="post" autocomplete="off" action="forum.php?mod=misc&action=removerate&ratesubmit=yes&infloat=yes" onsubmit="ajaxpost('rateform', 'return_rate', 'return_rate', 'onerror');return false;">
	<div class="f_c">
		<h3 class="flb">
			<em id="return_rate">{lang thread_removerate}</em>
			<span>
				<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('rate')" title="{lang close}">{lang close}</a><!--{/if}-->
			</span>
		</h3>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="tid" value="$_G[tid]">
		<input type="hidden" name="pid" value="$_GET[pid]">
		<input type="hidden" name="referer" value="$referer" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="rate"><!--{/if}-->
		<div class="c floatwrap">
			<table class="list" cellspacing="0" cellpadding="0">
				<thead>
					<tr>
						<td>&nbsp;</td>
						<td>{lang username}</td>
						<td>{lang time}</td>
						<td>{lang credits}</td>
						<td>{lang reason}</td>
					</tr>
				</thead>
			<!--{loop $ratelogs $ratelog}-->
				<tr>
					<td><input type="checkbox" name="logidarray[]" value="$ratelog[uid] $ratelog[extcredits] $ratelog[dbdateline]" /></td>
					<td><a href="home.php?mod=space&uid=$ratelog[uid]">$ratelog[username]</a></td>
					<td>$ratelog[dateline]</td>
					<td>{$_G['setting']['extcredits'][$ratelog[extcredits]][title]} <span class="xw1">$ratelog[scoreview]</span> {$_G['setting']['extcredits'][$ratelog[extcredits]][unit]}</td>
					<td>$ratelog[reason]</td>
				</tr>
			<!--{/loop}-->
			</table>
		</div>
	</div>
	<div class="o pns">
		<label class="z" onclick="checkall(this.form, 'logid')"><input class="pc" type="checkbox" name="chkall" />{lang checkall}</label>
		<label for="sendreasonpm"><input type="checkbox" name="sendreasonpm" id="sendreasonpm" class="pc"{if $_G['group']['reasonpm'] == 2 || $_G['group']['reasonpm'] == 3} checked="checked" disabled="disabled"{/if} />{lang admin_pm}</label>
		{lang admin_operation_explain}: <input name="reason" class="px vm" />
		<button class="pn pnc vm" type="submit" value="true" name="ratesubmit"><span>{lang submit}</span></button>
	</div>
</form>
<!--{/if}-->

<script type="text/javascript" reload="1">
function succeedhandle_rate(locationhref) {
	<!--{if !empty($_GET['from'])}-->
		location.href = locationhref;
	<!--{else}-->
		ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid={$_GET['pid']}', 'post_{$_GET['pid']}', 'post_{$_GET['pid']}');
		hideWindow('rate');
	<!--{/if}-->
}
loadcss('forum_moderator');
</script>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{else}-->

	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang board_message}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c altw">
		<div class="alert_right">
			<p>{lang push_succeed}</p>
			<p class="alert_btnleft">
				<a href="javascript:;" class="xi1" onclick="hideWindow('$_GET[handlekey]');showWindow('rate', 'forum.php?mod=misc&action=rate&tid=$_GET[tid]&pid=$_GET[pid]', 'get', -1);return false;">{lang click_here}</a> {lang rate_thread}
			</p>
		</div>
		</div>
		<p class="o pns">
			<button onclick="hideWindow('rate');" id="closebtn" class="pn pnc" type="button" fwin="rate"><strong>{lang close}</strong></button>
		</p>

<!--{/if}-->
<!--{template common/footer}-->