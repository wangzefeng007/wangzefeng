<?php exit;?>
<!--{template common/header}-->
<div id="pt" class="bm cl">
	<div class="z">
		<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
		<a href="$_G[setting][navs][1][filename]">{lang portal}</a> <em>&rsaquo;</em>
		$navtitle
	</div>
</div>

<!--{ad/text/wp a_t}-->
<style id="diy_style" type="text/css"></style>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div id="ct" class="wp cl">
	<div class="mn">
		<!--[diy=listcontenttop]--><div id="listcontenttop" class="area"></div><!--[/diy]-->
		<div class="bm tl">
			<div class="th">
				<table cellspacing="0" cellpadding="0">
					<tr>
						<th><h2>$navtitle</h2></th>
						<td class="by">$_G[setting][navs][3][navname]</td>
						<td class="by">{lang author}</td>
					</tr>
				</table>
			</div>
			<div class="bm_c">
				<!--{if $list}-->
					<table cellspacing="0" cellpadding="0">
						<!--{loop $list $value}-->
							<tr>
								<th>
									<a href="$value['url']" target="_blank">$value['title']</a>

								</th>
								<td class="by"><a href="$value['fields']['groupurl']">$value['fields']['groupname']</a></td>
								<td class="by">
									<cite>
										<!--{if $value['fields']['authorid'] && $value['fields']['author']}-->
											<a href="home.php?mod=space&uid=$value[authorid]" c="1">$value['fields'][author]</a>
										<!--{else}-->
											{lang anonymous}
										<!--{/if}-->
									</cite>
									<em><span>$value['fields']['dateline']</span></em>
								</td>
							</tr>
						<!--{/loop}-->
					</table>
					<!--{if $multipage}--><div class="pgs mtm cl">$multipage</div><!--{/if}-->
				<!--{else}-->
					<p class="emp">{lang no_content}</p>
				<!--{/if}-->
			</div>
		</div>

		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->

	</div>
</div>

<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<!--{template common/footer}-->