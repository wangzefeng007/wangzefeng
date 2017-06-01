<?php exit;?>
<!--{template common/header}-->

<div id="ct" class="ct7_a wp cl">
	<div class="apps">
		<!--{subtemplate portal/portalcp_nav}-->
	</div>
	<div class="mn">
		<h1 class="mt">$_G['setting']['plugins']['portalcp'][$_GET['id']]['name']</h1>
		<div class="bm bw0">
			<div id="block_selection">
				<!--{eval include(template($_GET['id']));}-->
			</div>
		</div>
	</div>
</div>

<!--{template common/footer}-->