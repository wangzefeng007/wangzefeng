<?php exit;?>
<!--{eval $_G[home_tpl_titles] = array('{lang personal_category}');}-->
<!--{template common/header}-->

<!--{if !$_G[inajax]}-->
	<div id="pt" class="bm cl">
		<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> <a href="home.php">$_G[setting][navs][4][navname]</a></div>
	</div>
	<div id="ct" class="ct2_a wp cl">
		<div class="mn">
			<div class="bm bw0">
<!--{/if}-->

<!--{if $_GET['op'] == 'edit'}-->

	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang modify_category}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form id="classform" name="classform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=class&op=edit&classid=$classid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editsubmit" value="true">
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c">
			<p class="mtm mbm"><label for="classname">{lang new_category_name}: <input type="text" name="classname" id="classname" class="px" value="$class[classname]" size="30" /></label></p>
		</div>
		<p class="o pns">
			<button type="submit" name="editsubmit_btn" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
		</p>
	</form>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			$('classid'+values['classid']).innerHTML = values['classname'];
		}
	</script>
<!--{elseif $_GET['op'] == 'delete'}-->

	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang delete_category}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form id="classform" name="classform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=class&op=delete&classid=$classid">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->

		<div class="c">{lang delete_category_message}</div>
		<p class="o pns">
			<button type="submit" name="deletesubmit_btn" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
		</p>
	</form>
<!--{/if}-->

<!--{if !$_G[inajax]}-->
		</div>
	</div>
	
</div>
<!--{/if}-->
<!--{template common/footer}-->