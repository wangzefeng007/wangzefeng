<?php exit;?>
<!--{template common/header}-->
<table cellspacing="0" cellpadding="0" class="dt">
	<caption>
		<p class="tbmu bw0" style="padding: 10px 0;">
		<!--{if in_array($filter, array('thisweek', 'thismonth', 'halfyear', 'before')) && in_array($from, array('buyer', 'seller'))}-->
			<a class="a" href="javascript:;" hidefocus="true">
			<!--{if $filter == 'thisweek'}-->{lang eccredit_1week}<!--{elseif $filter == 'thismonth'}-->{lang eccredit_1month}<!--{elseif $filter == 'halfyear'}-->{lang eccredit_6month}<!--{else}-->{lang eccredit_6monthbefore}<!--{/if}--> {lang from}<!--{if $from == 'buyer'}-->{lang trade_buyer}<!--{else}-->{lang trade_seller}<!--{/if}-->{lang eccredit_s}<!--{if $level == 'good'}-->{lang eccredit_good}<!--{elseif $level == 'soso'}-->{lang eccredit_soso}<!--{elseif $level == 'bad'}-->{lang eccredit_bad}<!--{else}-->{lang eccredit1}<!--{/if}-->
			</a><span class="pipe">|</span>
		<!--{/if}-->
		<!--{if !$from}-->
			<a class="a" href="javascript:;" hidefocus="true">{lang eccredit_list_all}</a>
		<!--{else}-->
			<a href="home.php?mod=spacecp&ac=eccredit&op=list&uid=$uid" onclick="ajaxget(this.href, 'ajaxrate', 'specialposts');doane(event);">{lang eccredit_list_all}</a>
		<!--{/if}-->
		<!--{if $from == 'buyer' && !$filter}-->
			<span class="pipe">|</span><a class="a" href="javascript:;" hidefocus="true">{lang eccredit_list_buyer}</a>
		<!--{else}-->
			<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=eccredit&op=list&uid=$uid&from=buyer" hidefocus="true" onclick="ajaxget(this.href, 'ajaxrate', 'specialposts');doane(event);">{lang eccredit_list_buyer}</a>
		<!--{/if}-->
		<!--{if $from == 'seller' && !$filter}-->
			<span class="pipe">|</span><a class="a" href="javascript:;" hidefocus="true">{lang eccredit_list_seller}</a>
		<!--{else}-->
			<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=eccredit&op=list&uid=$uid&from=seller" hidefocus="true" onclick="ajaxget(this.href, 'ajaxrate', 'specialposts');doane(event);">{lang eccredit_list_seller}</a>
		<!--{/if}-->
		<!--{if $from == 'myself'}-->
			<span class="pipe">|</span><a class="a" href="javascript:;" hidefocus="true">{lang eccredit_list_other}</a>
		<!--{else}-->
			<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=eccredit&op=list&uid=$uid&from=myself" hidefocus="true" onclick="ajaxget(this.href, 'ajaxrate', 'specialposts');doane(event);">{lang eccredit_list_other}</a>
		<!--{/if}-->
		</p>
	</caption>
	<tr class="alt">
		<td style="width: 45px;">&nbsp;</td>
		<td>{lang eccredit_content}</td>
		<td>{lang eccredit_goodsname_seller}</td>
		<td style="width: 90px;">{lang eccredit_tradeprice}</td>
	</tr>
	<!--{if $comments}-->
		<!--{loop $comments $comment}-->
			<tr>
				<td>
					<!--{if $comment[score] == 1}-->
						<img src="{STATICURL}image/traderank/good.gif" width="14" height="16" alt="good" class="vm" /> <span style="color:red">{lang eccredit_good}</span>
					<!--{elseif $comment[score] == 0}-->
						<img src="{STATICURL}image/traderank/soso.gif" width="14" height="16" alt="soso" class="vm" /> <span style="color:green">{lang eccredit_soso}</span>
					<!--{else}-->
						<img src="{STATICURL}image/traderank/bad.gif" width="14" height="16" alt="bad" class="vm" /> {lang eccredit_bad}
					<!--{/if}-->
				</td>
				<td>
					<span class="xg1">$comment[dateline]</span><br />$comment[message]<br />
					<!--{if $comment[explanation]}-->
						{lang eccredit_explanation}: $comment[explanation]
					<!--{elseif $_G['uid'] && $_G['uid'] == $comment[rateeid] && $comment[dbdateline] >= TIMESTAMP - 30 * 86400}-->
						<span id="ecce_$comment[id]"><a href="home.php?mod=spacecp&ac=eccredit&op=explain&id=$comment[id]&ajaxmenuid=ajax_$comment[id]_explain_menu" id="ajax_$comment[id]_explain" onclick="ajaxmenu(this, 0, 0);doane(event);">[ {lang eccredit_needexplanation} ]</a><br /><span class="xg1">{lang eccredit_explanationexpiration}</span></span>
					<!--{/if}-->
				</td>
				<td>
					<a href="forum.php?mod=redirect&goto=findpost&pid=$comment[pid]" target="_blank">$comment[subject]</a><br />
					<!--{if $from == 'myself'}-->
						<!--{if $comment[type]}-->{lang trade_buyer}: <!--{else}-->{lang trade_seller}: <!--{/if}--><a href="home.php?mod=space&uid=$comment[rateeid]" target="_blank">$comment[ratee]</a>
					<!--{else}-->
						<!--{if $comment[type]}-->{lang trade_seller}: <!--{else}-->{lang trade_buyer}: <!--{/if}--><a href="home.php?mod=space&uid=$comment[raterid]" target="_blank">$comment[rater]</a>
					<!--{/if}-->
				</td>
				<td>
					<!--{if $comment[price] > 0}-->
						$comment[price] {lang trade_units}&nbsp;&nbsp;
					<!--{/if}-->
					<!--{if $_G['setting']['creditstransextra'][5] != -1 && $comment['credit'] > 0}-->
						<!--{if $comment[price] > 0}--><br /><!--{/if}-->{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]} $comment[credit] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}
					<!--{/if}-->
				</td>
			</tr>
		<!--{/loop}-->
	<!--{else}-->
		<tr><td colspan="4"><p class="emp">{lang eccredit_nofound}</p></td></tr>
	<!--{/if}-->
</table>
<!--{if $multipage}--><div class="pgs cl mtm">$multipage</div><!--{/if}-->
<!--{template common/footer}-->