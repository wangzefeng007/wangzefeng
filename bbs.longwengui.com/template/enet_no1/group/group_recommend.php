<?php exit;?>
<!--{template common/header}-->
<style>
.fl .bm_h {padding-top: 0px;}
</style>
<h3 class="flb">
	<em>{lang group_push_to_forum}</em>
	<span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span>
</h3>
<form method="post" autocomplete="off" id="form_$_GET[handlekey]" name="form_$_GET[handlekey]" action="forum.php?mod=group&action=recommend&fid=$_G[fid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'form_$_GET[handlekey]');"{/if}>
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="grouprecommend" value="true" />
	<input type="hidden" name="inajax" value="$_G[inajax]" />
	<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="c" id="return_$_GET[handlekey]">
		<select id="recommend" name="recommend" class="ps mtw mbw">
			<option value="0">{lang group_do_not_push}</option>
			$forumselect
		</select>
	</div>
	<p class="o pns">
		<button type="submit" value="true" class="pn pnc"><strong>{lang confirms}</strong></button>
	</p>
</form>
<!--{template common/footer}-->