<?php exit;?>
<!--{template common/header}-->
<style id="diy_style" type="text/css"></style>

<!--[diy=diyranklisttop]--><div id="diyranklisttop" class="area"></div><!--[/diy]-->

<div id="ct" class="ct7_a wp cl">
	<div class="apps">
		<!--[diy=diysidetop]--><div id="diysidetop" class="area"></div><!--[/diy]-->
		<!--{subtemplate ranklist/side_left}-->
		<!--[diy=diysidebottom]--><div id="diysidebottom" class="area"></div><!--[/diy]-->
	</div>
	<div class="mn">
		<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
		<div class="bm bw0">
			<h1 class="mt">{lang ranklist_member}</h1>
			<ul class="tb cl">
				<li{$a_actives[show]}><a href="misc.php?mod=ranklist&type=member">{lang auction_ranking}</a></li>
				<li{$a_actives[beauty]}><a href="misc.php?mod=ranklist&type=member&view=beauty">{lang ranklist_beauty}</a></li>
				<li{$a_actives[handsome]}><a href="misc.php?mod=ranklist&type=member&view=handsome">{lang ranklist_handsome}</a></li>
				<li{$a_actives[credit]}><a href="misc.php?mod=ranklist&type=member&view=credit">{lang credit_ranking}</a></li>
				<li{$a_actives[friendnum]}><a href="misc.php?mod=ranklist&type=member&view=friendnum">{lang friend_num_ranking}</a></li>
				<li{$a_actives[invite]}><a href="misc.php?mod=ranklist&type=member&view=invite">{lang ranklist_invite}</a></li>
				<li{$a_actives[post]}><a href="misc.php?mod=ranklist&type=member&view=post">{lang ranklist_post_num}</a></li>
				<!--{if helper_access::check_module('blog')}-->
					<li{$a_actives[blog]}><a href="misc.php?mod=ranklist&type=member&view=blog">{lang ranklist_blog}</a></li>
				<!--{/if}-->
				<li{$a_actives[onlinetime]}><a href="misc.php?mod=ranklist&type=member&view=onlinetime">{lang ranklist_onlinetime}</a></li>
			</ul>

			<script type="text/javascript">
				function checkCredit(id) {
					var maxCredit = parseInt($space[credit]);
					var idval = parseInt($(id).value);
					if(/^(\d+)$/.test(idval) == false) {
						showDialog('{lang credit_is_not_number}', 'notice', '{lang reminder}', null, 0);
						return false;
					} else if(idval > maxCredit) {
						showDialog('{lang credit_title_message}', 'notice', '{lang reminder}', null, 0);
						return false;
					} else if(idval < 1) {
						showDialog('{lang credit_title_error}', 'notice', '{lang reminder}', null, 0);
						return false;
					}
					if(id == 'showcredit') {
						var price = parseInt($('unitprice').value);
						if(/^(\d+)$/.test(price) == false) {
							showDialog('{lang unitprice_is_not_number}', 'notice', '{lang reminder}', null, 0);
							return false;
						} else if(price < 1) {
							showDialog('{lang unitprice_title_error}', 'notice', '{lang reminder}', null, 0);
							return false;
						} else if(price > idval+parseInt($myallcredit)) {
							showDialog('{lang price_can_not_be_higher_than_the_total}', 'notice', '{lang reminder}', null, 0);
							return false;
						}
					}
					return true;
				}
			</script>
			<!--{if $creditsrank_change}-->
				<p id="orderby" class="tbmu">
					<a href="misc.php?mod=ranklist&type=member&view=credit&orderby=all" id="all"{if $now_choose == 'all'} class="a"{/if}>{lang all}</a>
					<!--{if $extcredits}-->
						<!--{loop $extcredits $key $credit}-->
							<span class="pipe">|</span><a href="misc.php?mod=ranklist&type=member&view=credit&orderby=$key" id="$key"{if $now_choose == $key} class="a"{/if}>{$credit[title]}</a>
						<!--{/loop}-->
					<!--{/if}-->
				</p>
			<!--{/if}-->
			<!--{if $now_pos >= 0}-->
				<div class="tbmu">
					<!--{if $_GET[view]=='show'}-->
						<h3 class="mbn">{lang friend_top_note}:</h3>
						<!--{if $space[unitprice]}-->
						{lang your_current_bid}: $space[unitprice] {$extcredits[$creditid][unit]},{lang current_ranking} <span style="font-size:20px;color:red;">$now_pos</span> ,{lang make_persistent_efforts}!
						<!--{else}-->
						{lang ranking_message_0}
						<!--{/if}-->
						<br />{lang ranking_message_1}
						<br />{lang ranking_message_2}
					<!--{else}-->
						<!--{if $_GET[view]=='credit'}-->
						<a href="home.php?mod=spacecp&ac=credit">{lang self_current_credit}<!--{if $now_choose=='all'}-->{lang credits}<!--{else}-->{$extcredits[$now_choose][title]}<!--{/if}-->: $mycredits</a>
						<!--{elseif $_GET[view]=='friendnum'}-->
						<a href="home.php?mod=space&do=friend">{lang self_current_friend_num}: $space[friends]</a>
						<!--{/if}-->
						,{lang current_ranking} <span style="font-size:20px;color:red;">$now_pos</span> ,{lang make_persistent_efforts}!
					<!--{/if}-->
					<!--{if $cache_mode}-->
					<p>
						{lang top_100_update}
					</p>
					<!--{/if}-->
				</div>

				<!--{if $_GET[view]=='show' && $_G[uid]}-->
					<!--{if $creditid}-->
					<div class="tbmu mbm pbw cl">
						<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=top" onsubmit="return checkCredit('showcredit');" class="z">
							<table>
								<caption><h3 class="mbn">{lang i_ranking}</h3></caption>
								<tr>
									<th class="pbn">
										{lang my_ranking_declaration}
										<p class="xg1">{lang max_char_ranking}</p>
									</th>
									<th class="pbn">
										{lang show_unitprice}
										<p class="xg1"><!--{if $_G[uid]}--><a href="home.php?mod=spacecp&ac=common&op=modifyunitprice" id="a_modify_unitprice" onclick="showWindow(this.id, this.href, 'get', 0);">({lang edit_price})</a><!--{/if}--></p>
									</th>
									<th class="pbn">
										{lang increase_bid}{$extcredits[$creditid][title]}
										<p class="xg1">{lang not_exceed}{$extcredits[$creditid][title]} $space[credit] {$extcredits[$creditid][unit]}</p>
									</th>
								</tr>
								<tr>
									<td><input type="text" name="note" class="px" value="" size="25" /></td>
									<td>
										&nbsp;<input type="text" id="unitprice" name="unitprice" class="px vm" value="1" size="7" onblur="checkCredit('showcredit');" />
									</td>
									<td>
										&nbsp;<input type="text" id="showcredit" name="showcredit" class="px vm" value="100" size="7" onblur="checkCredit('showcredit');" />&nbsp;
										<button type="submit" name="show_submit" class="pn vm"><em>{lang increase}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="showsubmit" value="true" />
							<input type="hidden" name="formhash" value="{FORMHASH}" />
						</form>

						<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=top" onsubmit="return checkCredit('stakecredit');" class="y">
							<table>
								<caption><h3 class="mbn">{lang help_friend_in_top}</h3></caption>
								<tr>
									<td class="pbn">
										{lang friend_need_help}
										<p class="xg1">{lang please_input_friend_name}</p>
									</td>
									<td class="pbn">
										{lang handsel_bid}{$extcredits[$creditid][title]}
										<p class="xg1">{lang not_exceed}{$extcredits[$creditid][title]} $space[credit] {$extcredits[$creditid][unit]}</p>
									</td>
								</tr>
								<tr>
									<td><input type="text" name="fusername" class="px" value="" size="15" /></td>
									<td>
										&nbsp;<input type="text" name="stakecredit" id="stakecredit" class="px vm" value="20" size="7" onblur="checkCredit('stakecredit');" />&nbsp;
										<button type="submit" name="friend_submit" class="pn vm"><em>{lang handsel}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="friendsubmit" value="true" />
							<input type="hidden" name="formhash" value="{FORMHASH}" />
						</form>
					</div>
					<!--{else}-->
						<div class="mbm bbda emp">{lang close_ranking_note}</div>
					<!--{/if}-->
				<!--{/if}-->
			<!--{/if}-->

			<!--{template ranklist/member_list}-->
		</div>
		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->
	</div>
</div>

<!--[diy=diyranklistbottom]--><div id="diyranklistbottom" class="area"></div><!--[/diy]-->

<!--{template common/footer}-->
