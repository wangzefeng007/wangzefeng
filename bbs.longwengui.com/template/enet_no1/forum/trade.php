<?php exit;?>
<!--{template common/header}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> {lang trade_confirm_buy}</div>
</div>
<div id="ct" class="ct2 wp cl">
	<h1 class="mt">{lang trade_confirm_goods}</h1>
	<div class="mn">
		<script type="text/javascript" src="{$_G[setting][jspath]}forum_viewthread.js?{VERHASH}"></script>
		<script type="text/javascript">
		zoomstatus = parseInt($_G[setting][zoomstatus]);
		var feevalue = 0;
		<!--{if $trade[price] > 0}-->var price = $trade[price];<!--{/if}-->
		<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->var credit = $trade[credit];var currentcredit = <!--{echo getuserprofile('extcredits'.$_G['setting']['creditstransextra'][5])}-->;<!--{/if}-->
		</script>

		<form method="post" autocomplete="off" id="tradepost" name="tradepost" action="forum.php?mod=trade&action=trade&tid=$_G[tid]&pid=$pid">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<div class="bm">
				<h3 class="bm_h">{lang trade_confirm_buy}</h3>
				<div class="torder bm_c cl">
					<div class="spvimg">
					<!--{if $trade['aid']}-->
						<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$trade[tid]&pid=$trade[pid]"><img src="{echo getforumimg($trade[aid])}" width="90" /></a>
					<!--{else}-->
						<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$trade[tid]&pid=$trade[pid]"><img src="{IMGDIR}/nophotosmall.gif" /></a>
					<!--{/if}-->
					</div>
					<div class="spi cl">
						<dl>
							<dt>{lang trade_price}</dt>
							<dd>
							<!--{if $trade[price] > 0}-->
								&nbsp;<strong>$trade[price]</strong>&nbsp;{lang payment_unit}
							<!--{/if}-->
							<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
								&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}&nbsp;<strong>$trade[credit]</strong>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
							<!--{/if}-->
							</dd>
							<!--{if $trade[locus]}-->
							<dt>{lang post_trade_locus}</dt><dd>$trade[locus]</dd><!--{/if}-->
							<dt>{lang trade_seller}</dt><dd><a href="home.php?mod=space&uid=$trade[sellerid]" target="_blank">$trade[seller]</a></dd>
						</dl>
					</div>
					<table summary="{lang trade_confirm_buy}" cellspacing="0" cellpadding="0" class="tfm">
						<tr>
							<th>{lang trade_credits_total}</th>
							<td>
								<!--{if $trade[price] > 0}--><strong id="caculate"></strong>&nbsp;{lang trade_units}&nbsp;&nbsp;<!--{/if}-->
								<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}&nbsp;<strong id="caculatecredit"></strong>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}&nbsp;<span id="crediterror"></span><!--{/if}-->
							</td>
						</tr>
						<tr>
							<th><label for="number">{lang trade_nums}</label></th>
							<td><input type="text" id="number" name="number" onkeyup="calcsum()" value="1" class="pt" /></td>
						</tr>
						<tr>
							<th>{lang post_trade_transport}</th>
							<td>
								<p>
								<!--{if $trade['transport'] == 1}--><input type="hidden" name="transport" value="1">{lang post_trade_transport_seller}<!--{/if}-->
								<!--{if $trade['transport'] == 2}--><input type="hidden" name="transport" value="2">{lang post_trade_transport_buyer}<!--{/if}-->
								<!--{if $trade['transport'] == 3}--><input type="hidden" name="transport" value="3">{lang post_trade_transport_virtual}<!--{/if}-->
								<!--{if $trade['transport'] == 4}--><input type="hidden" name="transport" value="4">{lang post_trade_transport_physical}<!--{/if}-->
								</p>
								<!--{if $trade['transport'] == 1 or $trade['transport'] == 2 or $trade['transport'] == 4}-->
									<!--{if !empty($trade['ordinaryfee'])}--><label class="lb"><input class="pr" type="radio" name="fee" value="1" checked="checked" {if $trade['transport'] == 2}onclick="feevalue = $trade[ordinaryfee];calcsum()"{/if} />{lang post_trade_transport_mail} $trade[ordinaryfee] {lang payment_unit}</label><!--{if $trade['transport'] == 2}--><script type="text/javascript">feevalue = $trade[ordinaryfee]</script><!--{/if}--><!--{/if}-->
									<!--{if !empty($trade['expressfee'])}--><label class="lb"><input class="pr" type="radio" name="fee" value="3" checked="checked" {if $trade['transport'] == 2}onclick="feevalue = $trade[expressfee];calcsum()"{/if} />{lang post_trade_transport_express} $trade[expressfee] {lang payment_unit}</label><!--{if $trade['transport'] == 2}--><script type="text/javascript">feevalue = $trade[expressfee]</script><!--{/if}--><!--{/if}-->
									<!--{if !empty($trade['emsfee'])}--><label class="lb"><input class="pr" type="radio" name="fee" value="2" checked="checked" {if $trade['transport'] == 2}onclick="feevalue = $trade[emsfee];calcsum()"{/if} /> EMS $trade[emsfee] {lang payment_unit}</label><!--{if $trade['transport'] == 2}--><script type="text/javascript">feevalue = $trade[emsfee]</script><!--{/if}--><!--{/if}-->
								<!--{/if}-->
							</td>
						</tr>
						<tr>
							<th>{lang trade_paymethod}</th>
							<td>
								<!--{if !$_G['uid']}-->
									<label><input type="hidden" name="offline" value="0" checked="checked" />{lang trade_pay_alipay}</label>
								<!--{elseif !$trade['account'] && !$trade['tenpayaccount']}-->
									<input type="hidden" name="offline" value="1" checked="checked" />{lang trade_pay_offline}
								<!--{else}-->
									<label class="lb"><input type="radio" class="pr" name="offline" value="0" checked="checked" />{lang trade_pay_alipay}</label>
									<label class="lb"><input type="radio" class="pr" name="offline" value="1" />{lang trade_pay_offline}</label>
								<!--{/if}-->
							</td>
						</tr>
						<!--{if $trade['transport'] != 3}-->
							<tr>
								<th><label for="buyername">{lang trade_buyername}</label></th>
								<td><input type="text" id="buyername" name="buyername" maxlength="50" value="$lastbuyerinfo[buyername]" class="pt" /></td>
							</tr>
							<tr>
								<th><label for="buyercontact">{lang trade_buyercontact}</label></th>
								<td><input type="text" id="buyercontact" name="buyercontact" maxlength="100" size="40" value="$lastbuyerinfo[buyercontact]" class="pt" /></td>
							</tr>
							<tr>
								<th><label for="buyerzip">{lang trade_buyerzip}</label></th>
								<td><input type="text" id="buyerzip" name="buyerzip" maxlength="10" value="$lastbuyerinfo[buyerzip]" class="pt" /></td>
							</tr>
							<tr>
								<th><label for="buyerphone">{lang trade_buyerphone}</label></th>
								<td><input type="text" id="buyerphone" name="buyerphone" maxlength="20" value="$lastbuyerinfo[buyerphone]" class="pt" /></td>
							</tr>
							<tr>
								<th><label for="buyermobile">{lang trade_buyermobile}</label></th>
								<td><input type="text" id="buyermobile" name="buyermobile" maxlength="20" value="$lastbuyerinfo[buyermobile]" class="pt" /></td>
							</tr>
						<!--{else}-->
							<input type="hidden" name="buyername" value="" />
							<input type="hidden" name="buyercontact" value="" />
							<input type="hidden" name="buyerzip" value="" />
							<input type="hidden" name="buyerphone" value="" />
							<input type="hidden" name="buyermobile" value="" />
						<!--{/if}-->
						<tr>
							<th valign="top"><label for="buyermsg">{lang trade_seller_remark}</label></th>
							<td>
								<textarea id="buyermsg" name="buyermsg" rows="5" class="pt"></textarea>
								<div class="xg2">{lang trade_seller_remark_comment}</div>
							</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td class="pns">
								<button class="pn pnc" type="submit" id="tradesubmit" name="tradesubmit" value="true"><span>{lang trade_buy_confirm}</span></button>
								<!--{if !$_G['uid']}--><em class="xg2">{lang trade_guest_alarm}</em><!--{/if}-->
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>

		<script type="text/javascript">
		function calcsum() {
			<!--{if $trade[price] > 0}-->$('caculate').innerHTML = (price * $('tradepost').number.value + feevalue);<!--{/if}-->
			<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
				v = (credit * $('tradepost').number.value + feevalue);
				if(v > currentcredit) {
					$('crediterror').innerHTML = '{lang trade_buy_crediterror}';
					$('tradesubmit').disabled = true;
				} else {
					$('crediterror').innerHTML = '';
				}
				$('caculatecredit').innerHTML = v;
			<!--{/if}-->
		}
		calcsum();
		</script>
	</div>

	<div class="sd">
		<!--{if $usertrades}-->
			<div class="bm">
				<h3 class="bm_h">$trade[seller] {lang trade_recommended_goods}</h3>
				<div class="bm_c">
					<ul class="ml tradl cl">
					<!--{loop $usertrades $usertrade}-->
						<li>
							<a href="forum.php?mod=viewthread&tid=$usertrade[tid]&do=tradeinfo&pid=$usertrade[pid]" class="tn">
								<!--{if $usertrade['displayorder'] > 0}--><em class="hot">{lang post_trade_sticklist}</em><!--{/if}-->
								<!--{if $usertrade['aid']}--><img src="{echo getforumimg($usertrade[aid])}" width="130" alt="$usertrade[subject]" /><!--{else}--><img src="{IMGDIR}/nophoto.gif" width="130" alt="$usertrade[subject]" /><!--{/if}-->
							</a>

							<!--{if $usertrade[price] > 0}-->
								<p class="p">&yen; <em class="xi1">$usertrade[price]</em></p>
							<!--{/if}-->
							<!--{if $_G['setting']['creditstransextra'][5] != -1 && $usertrade[credit]}-->
								<p class="{if $usertrade[price] > 0}xg1{else}p{/if}"><!--{if $usertrade[price] > 0}-->{lang trade_additional} <!--{/if}--><em class="xi1">$usertrade[credit]</em>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}</p>
							<!--{/if}-->
							<h4><a href="forum.php?mod=viewthread&tid=$usertrade[tid]&do=tradeinfo&pid=$usertrade[pid]">$usertrade[subject]</a></h4>
						</li>
					<!--{/loop}-->
					</ul>
				</div>
			</div>
		<!--{/if}-->
	</div>
</div>
<!--{template common/footer}-->