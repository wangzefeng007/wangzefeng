<?php exit;?>
<!--{eval
	$_G['home_tpl_titles'] = array('{lang magic}');
}-->
<!--{template common/header}-->
<!--{if empty($_GET['infloat'])}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> $navigation</div>
</div>
<div id="ct" class="ct2_a wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->

<form id="magicform" method="post" action="home.php?mod=magic&action=shop&infloat=yes"{if $_G[inajax]} onsubmit="ajaxpost('magicform', 'return_$_GET[handlekey]', 'return_$_GET[handlekey]', 'onerror');return false;"{/if}>
<div class="f_c">
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">
		<!--{if $operation == 'buy'}-->
			{lang magics_operation_buy}{lang magic}
		<!--{elseif $operation == 'give'}-->
			{lang magics_operation_present}{lang magic}
		<!--{/if}-->
		</em>
		<span><!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET[handlekey]');return false;" title="{lang close}">{lang close}</a><!--{/if}--></span>
	</h3>
	<div class="c">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="operation" value="$operation" />
		<input type="hidden" name="mid" value="$_GET['mid']" />
		<!--{if !empty($_GET['idtype']) && !empty($_GET['id'])}-->
			<input type="hidden" name="idtype" value="$_GET[idtype]" />
			<input type="hidden" name="id" value="$_GET[id]" />
		<!--{/if}-->
		<!--{if $operation == 'buy'}-->
			<dl class="xld cl">
				<dd class="m">
					<div class="mg_img"><img src="$magic[pic]" alt="" /></div>
				</dd>
				<dt class="z">
					<div class="mbm pbm bbda">
						<p>$magic[name]</p>
						<p class="mtn xw0 xg1">$magic[description]</p>
						<p class="mtm xw0 mbn">{lang magics_price}: <span{if $magic[discountprice] && $magic[price] != $magic[discountprice]} style="text-decoration:line-through;"{/if}>{$_G['setting']['extcredits'][$magic[credit]][title]} <span class="xi1 xw1 xs2" id="magicprice">$magic[price]</span> {$_G['setting']['extcredits'][$magic[credit]][unit]}</span></p>
						<!--{if $magic[discountprice] && $magic[price] != $magic[discountprice]}-->
							<p class="xw0 mbn">{lang magics_discountprice}: {$_G['setting']['extcredits'][$magic[credit]][title]} <span class="xi1 xw1 xs2" id="discountprice">$magic[discountprice]</span> $_G['setting']['extcredits'][$magic[credit]][unit]</p>
						<!--{/if}-->
						<p class="xw0 xg1">{lang magics_yourcredit} <!--{echo getuserprofile('extcredits'.$magic[credit])}--> {$_G['setting']['extcredits'][$magic[credit]][unit]}</p>
						<p class="mtm xw0 mbn">{lang magics_weight}: <span class="xi1 xw1 xs2" id="magicweight">$magic[weight]</span></p>
						<p class="xw0 xg1">{lang my_magic_volume} $allowweight</p>
					</div>
					<div class="xw0">
						<p class="mtn xw0">{lang stock}: <span class="xi1 xw1 xs2">$magic[num]</span> {lang magics_unit}</p>
						<!--{if $useperoid !== true}-->
							<p class="xi1 mtn"><!--{if $magic['useperoid'] == 1}-->{lang magics_outofperoid_1}<!--{elseif $magic['useperoid'] == 2}-->{lang magics_outofperoid_2}<!--{elseif $magic['useperoid'] == 3}-->{lang magics_outofperoid_3}<!--{elseif $magic['useperoid'] == 4}-->{lang magics_outofperoid_4}<!--{/if}--><!--{if $useperoid > 0}-->{lang magics_outofperoid_value}<!--{else}-->{lang magics_outofperoid_noperm}<!--{/if}--></p>
						<!--{/if}-->
						<!--{if !$useperm}--><p class="xi1 mtn">{lang magics_permission_no}</p><!--{/if}-->
						<p class="mtn">{lang memcp_usergroups_buy} <input id="magicnum" name="magicnum" type="text" size="2" autocomplete="off" value="1" class="px pxs" onkeyup="compute();" /> {lang magics_unit}</p>
					</div>
				</dt>
			</dl>
			<input type="hidden" name="operatesubmit" value="yes" />
		<!--{elseif $operation == 'give'}-->
			<table cellspacing="0" cellpadding="0" class="tfm">
				<tr>
					<th>&nbsp;</th>
					<td>{lang magics_operation_present}"$magic[name]"</td>
				</tr>
				<tr>
					<th>{lang magics_target_present}</th>
					<td class="hasd cl">
						<input type="text" id="selectedusername" name="tousername" size="12" autocomplete="off" value="" class="px p_fre" style="margin-right: 0;" />
						<!--{if $buddyarray}-->
						<a href="javascript:;" onclick="showselect(this, 'selectedusername', 'selectusername')" class="dpbtn">&nabla;</a>
						<ul id="selectusername" style="display:none">
							<!--{loop $buddyarray $buddy}-->
							<li>$buddy[fusername]</li>
							<!--{/loop}-->
						</ul>
						<!--{/if}-->
					</td>
				</tr>
				<tr>
					<th>{lang magics_num}</th>
					<td><input name="magicnum" type="text" size="12" autocomplete="off" value="1" class="px p_fre" /></td>
				</tr>
				<tr>
					<th>{lang magics_present_message}</th>
					<td><textarea name="givemessage" rows="3" class="pt">{lang magics_present_message_text}</textarea></td>
				</tr>
			</table>
			<input type="hidden" name="operatesubmit" value="yes" />
		<!--{/if}-->
	</div>
</div>
<!--{if empty($_GET['infloat'])}--><div class="m_c"><!--{/if}-->
<div class="o pns">
	<!--{if $operation == 'buy'}-->
		<button class="pn pnc" type="submit" name="operatesubmit" id="operatesubmit" value="true"><span>{lang magics_operation_buy}</span></button>
	<!--{elseif $operation == 'give'}-->
		<button class="pn pnc" type="submit" name="operatesubmit" id="operatesubmit" value="true" onclick="return confirmMagicOp(e)"><span>{lang magics_operation_present}</span></button>
	<!--{/if}-->
</div>
<!--{if empty($_GET['infloat'])}--></div><!--{/if}-->
</form>

<script type="text/javascript" reload="1">
	function succeedhandle_$_GET[handlekey](url, msg) {
		hideWindow('$_GET[handlekey]');
		<!--{if !$location}-->
			showDialog(msg, 'notice', null, function () { location.href=url; }, 0);
		<!--{else}-->
			showWindow('$_GET[handlekey]', 'home.php?$querystring');
		<!--{/if}-->
		showCreditPrompt();
	}
	function confirmMagicOp(e) {
		e = e ? e : window.event;
		showDialog('{lang magics_confirm}', 'confirm', '', 'ajaxpost(\'magicform\', \'return_magics\', \'return_magics\', \'onerror\');');
		doane(e);
		return false;
	}
	function compute() {
		var totalcredit = <!--{echo getuserprofile('extcredits'.$magic[credit])}-->;
		var totalweight = $allowweight;
		var magicprice = $('magicprice').innerHTML;
		if($('discountprice')) {
			magicprice = $('discountprice').innerHTML;
		}
		if(isNaN(parseInt($('magicnum').value))) {
			$('magicnum').value = 0;
			return;
		}
		if(!$('magicnum').value || totalcredit < 1 || totalweight < 1) {
			$('magicnum').value = 0;
			return;
		}
		var curprice = $('magicnum').value * magicprice;
		var curweight = $('magicnum').value * $('magicweight').innerHTML;
		if(curprice > totalcredit) {
			$('magicnum').value = parseInt(totalcredit / magicprice);
		} else if(curweight > totalweight) {
			$('magicnum').value = parseInt(totalweight / $('magicweight').innerHTML);
		}
		$('magicnum').value = parseInt($('magicnum').value);
	}
</script>

<!--{if empty($_GET['infloat'])}-->
	</div></div>
	<div class="appl"><!--{subtemplate common/userabout}--></div>
</div>
<!--{/if}-->
<!--{template common/footer}-->