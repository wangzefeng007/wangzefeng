<?php exit;?>
<tr>
	<td>
		<div{if $_G[inajax]} style="width:520px;height:{if $hasinblocks}310px{else}225px{/if};overflow-x:hidden;overflow-y:auto;"{/if}>
			<!--{if $hasinblocks}-->
				<div id="hasinblocks">
					<h3 class="ptn pbn">{lang block_recommend_data_in_block}</h3>
					<ul class="xl xl2 mbm cl" id="recommenditem_ul">
					<!--{loop $hasinblocks $block}-->
						<li id="recommenditem_$block[dataid]">
							<span class="cur1 xi2"{if $op=='recommend'} onclick="if($('recommendto')){$('recommendto').value=(this.innerText ? this.innerText : this.textContent);}recommenditem_byblock('$block[bid]', '$_GET[id]', '$_GET[idtype]')"{/if}><!--{if empty($block['name'])}-->#$block[bid]<!--{else}-->$block[name]<!--{/if}--></span>
							<a href="javascript:;" onclick="delete_recommenditem($block[dataid], $block[bid]);">[{lang cancel}]</a>
						</li>
					<!--{/loop}-->
					</ul>
					<hr class="mtn mbn da" />
				</div>
			<!--{/if}-->

			<!--{if !empty($blocks)}-->
				<h3 class="ptn pbn">{lang select_block}</h3>
				<ul class="xl xl2 cl">
				<!--{loop $blocks $block}-->
					<li {if !$block[favorite]}onmouseover="display('bfav_$block[bid]');" onmouseout="display('bfav_$block[bid]');"{/if}>
						<span class="cur1 xi2"{if $op=='recommend'} onclick="if($('recommendto')){$('recommendto').value=(this.innerText ? this.innerText : this.textContent);}recommenditem_byblock('$block[bid]', '$_GET[id]', '$_GET[idtype]')"{/if}>$block[name]</span>
						<a href="javascript:;" id="bfav_$block[bid]" onclick="blockFavorite($block[bid]);"{if !$block[favorite]} style="visibility:hidden"{/if}><!--{if $block[favorite]}--><img src="{IMGDIR}/fav.gif" alt="fav" title="{lang block_cancel_favorite}" class="favmark" /><!--{else}--><img src="{IMGDIR}/fav_grey.gif" alt="normal" title="{lang block_favorite}" class="favmark" /><!--{/if}--></a>
					</li>
				<!--{/loop}-->
				</ul>
			<!--{else}-->
				<p class="emp">{lang has_no_block}</p>
			<!--{/if}-->
		</div>
		<!--{if $multi}--><div class="pgs mtm cl">$multi</div><!--{/if}-->
	</td>
</tr>
