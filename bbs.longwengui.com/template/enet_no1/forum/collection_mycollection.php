<?php exit;?>
<!--{template common/header}-->
<div id="pt" class="bm cl">
	<div class="z">
		<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
		<a href="forum.php?mod=collection">{lang collection}</a> <em>&rsaquo;</em>
		<a href="forum.php?mod=collection&amp;op=my">{lang collection_my}</a>
	</div>
</div>

<div id="ct" class="wp cl">
	<div class="bm">
		<div class="tb tb_h cl">
			<!--{subtemplate forum/collection_nav}-->
		</div>
		<div class="bm_c">
			<!--{hook/collection_index_top}-->
			<!--{subtemplate forum/collection_list}-->
			<!--{hook/collection_index_bottom}-->
		</div>
	</div>
</div>
<!--{template common/footer}-->