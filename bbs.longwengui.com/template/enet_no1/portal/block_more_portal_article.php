<?php exit;?>
<!--{template common/header}-->

<div id="pt" class="bm cl">
	<div class="z">
		<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
		<a href="$_G[setting][navs][1][filename]">{lang portal}</a> <em>&rsaquo;</em>
		$navtitle
	</div>
</div>

<style id="diy_style" type="text/css"></style>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div id="ct" class="wp cl">
	<div class="mn">
		<!--[diy=listcontenttop]--><div id="listcontenttop" class="area"></div><!--[/diy]-->
		<div class="bm">
			<div class="bm_h cl">
				<h2>$navtitle</h2>
			</div>
			<!--{if $list}-->
				<div class="bm_c xld">
				<!--{loop $list $value}-->
					<!--{eval $article_url = fetch_article_url($value);}-->
					<dl class="bbda cl">
						<dt class="xs2"><a href="$article_url" target="_blank" class="xi2">$value[title]</a></dt>
						<dd class="xs2 cl">
							<!--{if $value[pic]}--><div class="atc"><a href="$article_url" target="_blank"><img src="$value[pic]" alt="$value[title]" class="tn" /></a></div><!--{/if}-->
							$value[summary]
						</dd>
						<dd>
							{lang category}: <label><a href="{$value[fields][caturl]}" class="xi2">{$value[fields][catname]}</a></label>&nbsp;&nbsp;
							<span class="xg1"> {$value[fields][dateline]}</span>
						</dd>
					</dl>
				<!--{/loop}-->
				</div>
				<!--[diy=listloopbottom]--><div id="listloopbottom" class="area"></div><!--[/diy]-->
			<!--{else}-->
				<p class="emp">{lang no_content}</p>
			<!--{/if}-->
		</div>
		<!--{if $multipage}--><div class="pgs cl">{$multipage}</div><!--{/if}-->

		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->

	</div>
</div>

<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<!--{template common/footer}-->