<?php exit;?>
<!--{template common/header}-->
<div id="pt" class="bm cl">
	<div class="z">
		<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
		<a href="forum.php?mod=collection">{lang collection}</a> <em>&rsaquo;</em>
		<a href="forum.php?mod=collection&action=view&ctid=$ctid">{$_G['collection']['name']}</a> <em>&rsaquo;</em>
		{lang collection_commentlist}
	</div>
</div>
<script type="text/javascript" src="{$_G[setting][jspath]}home_friendselector.js?{VERHASH}"></script>
<script type="text/javascript">
	var fs;
	var clearlist = 0;
</script>

<div id="ct" class="wp cl">
		<div class="bm bml pbn">
			<div class="bm_h cl">
				<a href="forum.php?mod=collection&action=view&ctid={$_G['collection']['ctid']}" class="y pn"><span class="xi2">&laquo; {lang collection_backcollection}</span></a>
				<h1 class="xs2">
					<a href="forum.php?mod=collection&action=view&ctid={$_G['collection']['ctid']}">{$_G['collection']['name']}</a>
				</h1>
			</div>
			<div class="bm_c">
				<div title="$avgrate" class="pbn xg1 cl">
				<!--{if $_G['collection']['ratenum'] > 0}-->
					<span class="clct_ratestar"><span class="star star$star">&nbsp;</span></span>
					 &nbsp;{lang collection_totalrates}
				<!--{else}-->
					{lang collection_norate}
				<!--{/if}-->
				</div>
				<div>{$_G['collection']['desc']}</div>
			</div>
		</div>

		<!--{if $_G['collection']['commentnum'] > 0}-->
		<div class="bm">
			<!--{if $permission}-->
				<form action="forum.php?mod=collection&action=comment&op=del" method="POST">
			<!--{/if}-->
			<div class="tb tb_h cl">
				<ul>
					<li class="a"><a href="forum.php?mod=collection&action=view&op=comment&ctid={$_G['collection']['ctid']}">{lang collection_commentlist}</a></li>
					<li><a href="forum.php?mod=collection&action=view&op=followers&ctid={$_G['collection']['ctid']}">{lang collection_followlist}</a></li>
					<!--{hook/collection_nav_extra}-->
				</ul>
			</div>
			<div class="bm_c xld xlda">
			<!--{loop $commentlist $comment}-->
				<dl class="bbda cl">
					<dd class="m avt"><a href="home.php?mod=space&uid=$comment['uid']"><!--{avatar($comment['uid'],small)}--></a></dd>
					<dt>
						<!--{if $permission}-->
						<span class="y"><input type="checkbox" value="$comment[cid]" name="delcomment[]" /></span>
						<!--{/if}-->
						<a href="home.php?mod=space&uid={$comment['uid']}" c="1">$comment[username]</a>
						<span class="xg1 xw0">$comment[dateline]</span>
					</dt>
					<!--{if $comment[rate]}-->
					<dd class="cl"><span class="clct_ratestar"><span class="star star$comment[rateimg]">&nbsp;</span></span></dd>
					<!--{/if}-->
					<dd>$comment[message]</dd>
				</dl>
			<!--{/loop}-->
			</div>
		
			<div class="bm_c cl">
				<!--{if $permission}-->
				<input type="hidden" value="{$ctid}" name="ctid" />
			    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
				<button type="submit" class="pn pnc"><span>{lang delete}</span></button>
				<!--{/if}-->
				<!--{if $multipage}-->$multipage<!--{/if}-->
			</div>
			<!--{if $permission}--></form><!--{/if}-->
			
			<div class="pgs mtm cl"></div>
		</div>
		<!--{/if}-->

		<!--{if $_G['group']['allowcommentcollection']}-->
		<div class="bm">
			<form action="forum.php?mod=collection&action=comment&ctid={$_G['collection']['ctid']}" method="POST">
			<div class="bm_h">
				<h2>{lang collection_ratecollection}</h2>
			</div>
			<div class="bm_c {if $memberrate}bbda{/if}">
				<!--{if !$memberrate}-->
				<div class="cl">
					<input type="hidden" name="ratescore" id="ratescore" />
					<span class="clct_ratestar">
						<span class="btn">
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',1)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',1,'ratescore')">1</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',2)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',2,'ratescore')">2</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',3)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',3,'ratescore')">3</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',4)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',4,'ratescore')">4</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',5)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',5,'ratescore')">5</a>
						</span>
						<span id="clct_ratestar_star" class="star star$memberrate"></span>
					</span>
				</div>
				<!--{/if}-->
				<div class="pbn">
					<textarea name="message" rows="4" class="pt" style="width: 94%"></textarea>
				</div>
				<div><button type="submit" class="pn pnc"><span>{lang collection_comment_submit}</span></button></div>
			</div>
			<!--{if $memberrate}-->
				<div class="bm_c ptn pbn cl">
					<span class="z">{lang collection_rated}&nbsp;</span>
					<span class="clct_ratestar"><span class="star star$memberrate"></span></span>
				</div>
			<!--{/if}-->
			</form>
		</div>
		<!--{/if}-->


	</div>
</div>
<!--{template common/footer}-->