<?php exit;?>
<!--{eval
	$_G[home_tpl_titles] = array('{lang videophoto}');
}-->
<!--{template common/header}-->
	<h3 class="flb">
	<em>{lang video_certification_photo}</em>
	<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<div class="c">
		<p>{lang this_is_certification_photo}</p>
		<p class="mtm hm"><a href="$videophoto" target="_blank"><img src="$videophoto" alt="{lang video_certification_photo}"></a></p>
	</div>
<!--{template common/footer}-->