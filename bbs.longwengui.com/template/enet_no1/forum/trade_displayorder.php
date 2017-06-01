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

<script type="text/javascript" reload="1">
	var max_obj = {$_G['group']['tradestick']};
	var p = $stickcount;
	function checkbox(obj) {
		if(obj.checked) {
			p++;
			for (var i = 0; i < $('tradeform').elements.length; i++) {
				var e = tradeform.elements[i];
				if(p == max_obj) {
					if(e.name.match('stick') && !e.checked) {
						e.disabled = true;
					}
				}
			}
		} else {
			p--;
			for (var i = 0; i < $('tradeform').elements.length; i++) {
				var e = tradeform.elements[i];
				if(e.name.match('stick') && e.disabled) {
					e.disabled = false;
				}
			}
		}
	}
</script>

<form id="tradeform" method="post" autocomplete="off" action="forum.php?mod=misc&action=tradeorder&tid=$_G[tid]&tradesubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('tradeform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
<div class="f_c">
	<h3 class="flb">
		<em id="return_$_GET['handlekey']">{lang trade_displayorder}</em>
		<span>
			<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
		</span>
	</h3>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="c">
			<table class="list" cellspacing="0" cellpadding="0" style="width: 700px">
				<thead class="th">
					<tr>
						<td>{lang trade_show_order}</td>
						<td style="width: 30px;">{lang trade_update_stick}</td>
						<th>{lang post_trade_name}</th>
						<td>{lang post_trade_price}</td>
						<td style="width: 80px;">{lang trade_remaindays}</td>
						<td style="width: 40px;"></td>
					</tr>
				</thead>
				<!--{loop $trades $trade}-->
				<tr>
					<td><input size="1" name="displayorder[{$trade[pid]}]" value="$trade[displayorderview]" class="px pxs" /></td>
					<td><input class="pc" type="checkbox" onclick="checkbox(this)" name="stick[{$trade[pid]}]" value="yes" {if $trade[displayorder] > 0}checked="checked"{elseif $_G['group']['tradestick'] <= $stickcount}disabled="disabled"{/if} /></td>
					<th>$trade[subject]</th>
					<td>
						<!--{if $trade[price] > 0}-->
							$trade[price] {lang payment_unit}
						<!--{/if}-->
						<!--{if $trade[credit] > 0}-->
							{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]} $trade[credit] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
						<!--{/if}-->
					</td>
					<td>
					<!--{if $trade[closed]}-->
						{lang trade_timeout}
					<!--{elseif $trade[expiration] > 0}-->
						{$trade[expiration]}{lang days}{$trade[expirationhour]}{lang trade_hour}
					<!--{elseif $trade[expiration] == -1}-->
						{lang trade_timeout}
					<!--{/if}-->
					</td>
					<td><a href="forum.php?mod=post&action=edit&fid=$thread[fid]&tid=$_G[tid]&pid=$trade[pid]" target="_blank">{lang edit}</a></td>
				</tr>
				<!--{/loop}-->
			</table>
		</div>
</div>
<!--{if empty($_GET['infloat'])}--><div class="m_c"><!--{/if}-->
<div class="o pns">
	<span class="z">{lang trade_update_stickmax} {$_G['group']['tradestick']}</span>
	<button tabindex="1" class="pn pnc" type="submit" name="tradesubmit" value="true"><span>{lang save}</span></button>
</div>
<!--{if empty($_GET['infloat'])}--></div><!--{/if}-->
</form>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	location.href = locationhref;
}
</script>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->