<?php exit;?>
<!--{template common/header}-->

<div id="ct" class="ct7_a wp cl">
	<!--{subtemplate common/stat}-->
	<div class="mn">
		<div class="bm bw0">
			<h1 class="mt">{lang stats_trade_rank}</h1>
			<!--{if $tradesums}-->
				<table class="dt bm mbw">
					<caption><h2 class="mbn">{lang trade_price_sort}</h2></caption>
					<tr>
						<th>{lang post_trade_name}</th>
						<th width="160">{lang trade_seller}</th>
						<th width="80">{lang trade_totalprice}({lang payment_unit})</th>
					</tr>
					<!--{loop $tradesums $tradesum}-->
						<tr class="{echo swapclass('alt')}">
							<td><a target="_blank" href="forum.php?mod=viewthread&do=tradeinfo&tid=$tradesum[tid]&pid=$tradesum[pid]">$tradesum[subject]</a></td>
							<td><a target="_blank" href="space.php?uid=$tradesum[sellerid]">$tradesum[seller]</a></td>
							<td>$tradesum[tradesum]</td>
						</tr>
					<!--{/loop}-->
				</table>
			<!--{/if}-->

			<!--{if $totalitems}-->
				<table class="dt bm">
					<caption><h2 class="mbn">{lang trace_number_sort}</h2></caption>
					<tr>
						<th>{lang post_trade_name}</th>
						<th width="160">{lang trade_seller}</th>
						<th width="80">{lang trace_sell_number}</th>
					</tr>
					<!--{eval unset($swapc);}-->
					<!--{loop $totalitems $totalitem}-->
						<tr class="{echo swapclass('alt')}">
							<td><a target="_blank" href="forum.php?mod=viewthread&do=tradeinfo&tid=$tradesum[tid]&pid=$tradesum[pid]">$totalitem[subject]</a></td>
							<td><a target="_blank" href="space.php?uid=$totalitem[sellerid]">$totalitem[seller]</a></td>
							<td>$totalitem[totalitems]</td>
						</tr>
					<!--{/loop}-->
				</table>
			<!--{/if}-->

			<div class="notice">{lang stats_update}</div>
		</div>
	</div>
</div>
<!--{template common/footer}-->