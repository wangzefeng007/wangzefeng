<?php exit;?>
<form id="shareform" name="shareform" action="home.php?mod=spacecp&ac=share&type=link&view=$_GET[view]&from=$_GET[from]" method="post" autocomplete="off" class="sfm bf"  style="margin-left:0" {if $_GET[view] == 'me'}onsubmit="ajaxpost(this.id, 'return_shareadd')"{/if}>
	<p class="mbn c cl"><span id="return_shareadd" class="y xi1"></span>{lang share_web_music_flash}</p>
	<p>
		<input type="text" name="link" id="share_link" class="px vm" tabindex="1" onfocus="javascript:if('http://'==this.value)this.value='';$('share_desc').style.display='block';" onblur="javascript:if(''==this.value)this.value='http://';" value="http://" />&nbsp;
		<button type="submit" name="sharesubmit_btn" id="sharesubmit_btn" class="pn vm" tabindex="3" value="true"><strong>{lang share}</strong></button>
		<a href="javascript:;" onclick="showDialog('{lang how_to_share_tips}', 'notice', '{lang share_description}', '', '', '', '');" class="xi2"><img src="{IMGDIR}/faq.gif" alt="faq" class="vm" /> {lang help}</a>
	</p>
	<div id="share_desc" class="cl" style="display: none;">
		<p class="mtm mbn">{lang description}</p>
		<p><textarea name="general" id="share_general" tabindex="2" rows="3" onkeydown="ctrlEnter(event, 'sharesubmit_btn')" class="pt"></textarea></p>
		<!--{if $secqaacheck || $seccodecheck}-->
			<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id)"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
			<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
		<!--{/if}-->
	</div>
	<input type="hidden" name="referer" value="home.php?mod=space&uid=$space[uid]&do=share&view=me&quickforward=1" />
	<input type="hidden" name="sharesubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<!--{if $_GET[view] == 'me'}-->
	<input type="hidden" name="handlekey" value="shareadd" />
	<!--{/if}-->
</form>