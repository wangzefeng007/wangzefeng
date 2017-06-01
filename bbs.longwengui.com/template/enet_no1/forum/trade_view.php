<?php exit;?>
<!--{template common/header}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> {lang trade_order}</div>
</div>
<div id="ct" class="ct2 wp cl">
	<h1 class="mt">2.{lang trade_order}</h1>
	<div class="mn">
		<form method="post" autocomplete="off" id="tradepost" name="tradepost" action="forum.php?mod=trade&orderid=$orderid">
			<!--{if !empty($_G['gp_modthreadkey'])}-->
				<input type="hidden" name="modthreadkey" value="$_G[gp_modthreadkey]" />
			<!--{/if}-->
			<!--{if !empty($_G['gp_tid'])}-->
				<input type="hidden" name="tid" value="$_G[gp_tid]" />
			<!--{/if}-->
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<div class="bm">
				<h3 class="bm_h"><!--{if !$tradelog[offline]}-->{lang trade_pay_alipay}<!--{else}-->{lang trade_pay_offline}<!--{/if}--></h3>
				<div class="bm_c">
					<table summary="{lang trade_order}" cellspacing="0" cellpadding="0" class="tfm" style="table-layout:fixed">
						<tr>
							<th>{lang status}</th>
							<td>$tradelog[statusview] ($tradelog[lastupdate])</td>
						</tr>
						<!--{if $tradelog[offline] && $offlinenext}-->
							<tr>
								<th><label for="password">{lang trade_password}</label></th>
								<td><input id="password" name="password" type="password" class="px" /></td>
							</tr>
							<tr>
								<th valign="top"><label for="message">{lang trade_message}</label></th>
								<td>
									<textarea id="buyermsg" id="message" name="message" rows="5" class="pt"></textarea>
									<p class="d">$trade_message {lang trade_seller_remark_comment}</p>
								</td>
							</tr>
							<tr>
								<th>&nbsp;</th>
								<td class="pns">
									<!--{loop $offlinenext $nextid $nextbutton}-->
										<button class="pn" type="button" onclick="$('tradepost').offlinestatus.value = '$nextid';$('offlinesubmit').click();"><em>$nextbutton</em></button>&nbsp;
									<!--{/loop}-->
									<input type="hidden" name="offlinestatus" value="" />
									<input type="submit" id="offlinesubmit" name="offlinesubmit" style="display: none" />
								</td>
							</tr>
						<!--{/if}-->
						<!--{if trade_typestatus('successtrades', $tradelog[status]) || trade_typestatus('refundsuccess', $tradelog[status])}-->
							<tr>
								<!--{if $tradelog[ratestatus] == 3}-->
									<th>{lang eccredit_post_between}</th><td>&nbsp;</td>
								<!--{elseif ($_G['uid'] == $tradelog[buyerid] && $tradelog[ratestatus] == 1) || ($_G['uid'] == $tradelog[sellerid] && $tradelog[ratestatus] == 2)}-->
									<th>{lang eccredit_post_waiting}</th><td>&nbsp;</td>
								<!--{else}-->
									<!--{if ($_G['uid'] == $tradelog[buyerid] && $tradelog[ratestatus] == 2) || ($_G['uid'] == $tradelog[sellerid] && $tradelog[ratestatus] == 1)}-->
										<th>{lang eccredit_post_already}</th>
									<!--{else}-->
										<th>&nbsp;</th>
									<!--{/if}-->
									<td class="pns">
									<!--{if $_G['uid'] == $tradelog[buyerid]}-->
										<button class="pn" type="button" onclick="window.open('home.php?mod=spacecp&ac=eccredit&op=rate&orderid=$tradelog[orderid]&type=0', '', '')"><span>{lang eccredit1}</span></button>
									<!--{elseif $_G['uid'] == $tradelog[sellerid]}-->
										<button class="pn" type="button" onclick="window.open('home.php?mod=spacecp&ac=eccredit&op=rate&orderid=$tradelog[orderid]&type=1', '', '')"><span>{lang eccredit1}</span></button>
									<!--{/if}-->
									</td>
								<!--{/if}-->
								</td>
							</tr>
						<!--{elseif !$tradelog[offline]}-->
							<tr>
								<th>{lang trade_online_tradeurl}</th>
								<td class="pns">
									<!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}-->
										<!--{if $tradelog[tenpayaccount]}-->
											<button class="pn" type="button" name="" onclick="window.open('forum.php?mod=trade&orderid=$orderid&pay=yes&apitype=tenpay','','')"><span>{lang trade_online_tenpay}</span></button>
										<!--{/if}-->
									<!--{else}-->
										<!--{if $tradelog[paytype] == 1}-->
											<button class="pn" type="button" onclick="window.open('$loginurl', '', '')"><span>{lang trade_order_status}</span></button>
										<!--{/if}-->
										<!--{if $tradelog[paytype] == 2}-->
											<button class="pn" type="button" onclick="window.open('$loginurl', '', '')"><span>{lang tenpay_trade_order_status}</span></button>
										<!--{/if}-->
									<!--{/if}-->
								</td>
							</tr>
						<!--{/if}-->
					</table>
				</div>
			</div>
			<div class="bm torder">
				<h3 class="bm_h">{lang trade_order}</h3>
				<div class="bm_c">
					<div class="spvimg">
						<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$trade[tid]&pid=$trade[pid]"><!--{if $trade['aid']}--><img src="{echo getforumimg($trade[aid])}" width="90" /><!--{else}--><img src="{IMGDIR}/nophotosmall.gif" /><!--{/if}--></a>
					</div>
					<div class="spi cl">
						<h4 class="wx mbm bbda"><a href="forum.php?mod=viewthread&do=tradeinfo&tid=$tradelog[tid]&pid=$tradelog[pid]" target="_blank">$tradelog[subject]</a></h4>
						<dl>
							<dt>{lang trade_payment}</dt>
							<dd>
								<!--{if $tradelog[price] > 0}--><strong>$tradelog[price]</strong>&nbsp;{lang payment_unit}&nbsp;&nbsp;<!--{/if}-->
								<!--{if $_G['setting']['creditstransextra'][5] != -1 && $tradelog[credit]}-->{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}&nbsp;<strong>$tradelog[credit]</strong>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}&nbsp;&nbsp;<!--{/if}-->
								<!--{if $tradelog[status] == 0}--><span class="xg2">{lang trade_payment_comment}</span><!--{/if}-->
							</dd>
						<!--{if $tradelog[tradeno]}-->
							<dt>{lang trade_order_no}</dt>
							<dd><a href="$loginurl" class="xg2" target="_blank">$tradelog[tradeno]</a></dd>
						<!--{/if}-->

							<dt>{lang trade_seller}</dt>
							<dd>
								<a href="home.php?mod=space&uid=$tradelog[sellerid]" class="xg2" target="_blank">$tradelog[seller]</a>
								<!--{if $_G['uid'] != $tradelog['sellerid']}-->&nbsp;<a onclick="showWindow('sendpm', this.href)" href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$tradelog[sellerid]&touid=$tradelog[sellerid]&pmid=0&daterange=2" class="xg2" target="_blank"><img src="{IMGDIR}/pmto.gif" title="{lang send_pm}" class="vm" /></a><!--{/if}-->
							</dd>
							<dt style="clear:left">{lang trade_buyer}</dt>
							<dd>
								<a href="home.php?mod=space&uid=$tradelog[buyerid]" target="_blank">$tradelog[buyer]</a>
								<!--{if $_G['uid'] != $tradelog['buyerid']}-->&nbsp;<a onclick="showWindow('sendpm', this.href)" href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$tradelog[buyerid]&touid=$tradelog[buyerid]&pmid=0&daterange=2" class="xg2" target="_blank"><img src="{IMGDIR}/pmto.gif" title="{lang send_pm}" class="vm" /></a><!--{/if}-->
							</dd>
						<!--{if $tradelog[status] == 0 && $tradelog[sellerid] == $_G['uid']}-->
							<dt style="clear:left"><label for="newprice">{lang trade_baseprice}</label></dt>
							<dd>
								<span><input type="text" id="newprice" name="newprice" value="$tradelog[baseprice]" class="px" style="width:100px" /></span> {lang payment_unit}&nbsp;&nbsp;
								<!--{if $_G['setting']['creditstransextra'][5] != -1 && $tradelog[credit]}-->
									{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]} <input type="text" id="newcredit" name="newcredit" value="$tradelog[basecredit]" class="px" style="width:100px" /> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
								<!--{/if}-->
							</dd>
						<!--{/if}-->
							<dt style="clear:left"><label for="newnumber">{lang trade_nums}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newnumber" name="newnumber" value="$tradelog[number]" class="px" style="width:100px" /></span><!--{else}-->$tradelog[number]<!--{/if}--></dd>
							<dt>{lang post_trade_transport}</dt>
							<dd>
								<!--{if $tradelog['transport'] == 0}-->{lang post_trade_transport_offline}<!--{/if}-->
								<!--{if $tradelog['transport'] == 1}-->{lang post_trade_transport_seller}<!--{/if}-->
								<!--{if $tradelog['transport'] == 2}-->{lang post_trade_transport_buyer}<!--{/if}-->
								<!--{if $tradelog['transport'] == 3}-->{lang post_trade_transport_virtual}<!--{/if}-->
								<!--{if $tradelog['transport'] == 4}-->{lang post_trade_transport_physical}<!--{/if}-->
								<!--{if $tradelog['transport']}-->
									&nbsp;{lang trade_transportfee}
									<!--{if $tradelog[status] == 0 && $tradelog[sellerid] == $_G['uid']}--><span><input type="text" name="newfee" value="$tradelog['transportfee']" class="px" style="width:100px" /></span>&nbsp;<!--{else}-->$tradelog[transportfee]&nbsp;<!--{/if}-->
									{lang payment_unit}
								<!--{/if}-->
							</dd>
						<!--{if $tradelog['transport'] != 3}-->
							<dt><label for="newbuyername">{lang trade_buyername}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyername" name="newbuyername" value="$tradelog[buyername]" maxlength="50" class="px" /></span><!--{else}-->$tradelog[buyername]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyercontact">{lang trade_buyercontact}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyercontact" name="newbuyercontact" value="$tradelog[buyercontact]" maxlength="100" size="40" class="px" /></span><!--{else}-->$tradelog[buyercontact]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyerzip">{lang trade_buyerzip}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyerzip" name="newbuyerzip" value="$tradelog[buyerzip]" maxlength="10" class="px" /></span><!--{else}-->$tradelog[buyerzip]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyerphone">{lang trade_buyerphone}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyerphone" name="newbuyerphone" value="$tradelog[buyerphone]" maxlength="20" class="px" /></span><!--{else}-->$tradelog[buyerphone]<!--{/if}-->&nbsp;</dd>
							<dt><label for="newbuyermobile">{lang trade_buyermobile}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><input type="text" id="newbuyermobile" name="newbuyermobile" value="$tradelog[buyermobile]" maxlength="20" class="px" /></span><!--{else}-->$tradelog[buyermobile]<!--{/if}-->&nbsp;</dd>
						<!--{else}-->
							<input type="hidden" name="newbuyername" value="" />
							<input type="hidden" name="newbuyercontact" value="" />
							<input type="hidden" name="newbuyerzip" value="" />
							<input type="hidden" name="newbuyerphone" value="" />
							<input type="hidden" name="newbuyermobile" value="" />
						<!--{/if}-->
							<dt valign="top"><label for="newbuyermsg">{lang trade_seller_remark}</label></dt>
							<dd><!--{if $tradelog[status] == 0 && $tradelog[buyerid] == $_G['uid']}--><span><textarea id="newbuyermsg" name="newbuyermsg" rows="5" class="pt">$tradelog[buyermsg]</textarea></span><!--{else}-->$tradelog[buyermsg]<!--{/if}--></dd>
						<!--{if $tradelog[status] == 0 && ($_G['uid'] == $tradelog['sellerid'] || $_G['uid'] == $tradelog['buyerid'])}-->
							<dt>&nbsp;</dt>
							<dd class="pns">
								<button class="pn" type="submit" name="tradesubmit" value="true"><span>{lang trade_submit_order}</span></button>
							</dd>
						<!--{/if}-->
						</dl>
					</div>
				</div>
			</div>
		<!--{if $tradelog['offline'] && !empty($messagelist)}-->
			<h3 class="bbda pbm mtw">{lang trade_message}</h3>
			<div class="xld xlda">
			<!--{loop $messagelist $message}-->
				<dl class="bbda cl">
					<dd class="m avt"><!--{avatar($message[0],small)}--></dd>
					<dt><a href="home.php?mod=space&uid=$message[0]" target="_blank">$message[1]</a>&nbsp;<span class="xg1 xw0" $message[2]</span></dt>
					<dd>$message[3]</dd>
				</dl>
			<!--{/loop}-->
			</div>
		<!--{/if}-->
		</form>
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