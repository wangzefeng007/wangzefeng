<?php exit;?>
<script type="text/javascript" src="{$_G[setting][jspath]}seditor.js?{VERHASH}"></script>
<div class="fpd">
	<!--{if in_array('bold', $seditor[1])}-->
		<a href="javascript:;" title="{lang e_bold}" class="fbld"{if empty($seditor[2])} onclick="seditor_insertunit('$seditor[0]', '[b]', '[/b]');doane(event);"{/if}>B</a>
	<!--{/if}-->
	<!--{if in_array('color', $seditor[1])}-->
		<a href="javascript:;" title="{lang e_forecolor}" class="fclr" id="{$seditor[0]}forecolor"{if empty($seditor[2])} onclick="showColorBox(this.id, 2, '$seditor[0]');doane(event);"{/if}>Color</a>
	<!--{/if}-->
	<!--{if in_array('img', $seditor[1])}-->
		<a id="{$seditor[0]}img" href="javascript:;" title="{lang e_image}" class="fmg"{if empty($seditor[2])} onclick="seditor_menu('$seditor[0]', 'img');doane(event);"{/if}>Image</a>
	<!--{/if}-->
	<!--{if in_array('link', $seditor[1])}-->
		<a id="{$seditor[0]}url" href="javascript:;" title="{lang e_url}" class="flnk"{if empty($seditor[2])} onclick="seditor_menu('$seditor[0]', 'url');doane(event);"{/if}>Link</a>
	<!--{/if}-->
	<!--{if in_array('quote', $seditor[1])}-->
		<a id="{$seditor[0]}quote" href="javascript:;" title="{lang e_quote}" class="fqt"{if empty($seditor[2])} onclick="seditor_menu('$seditor[0]', 'quote');doane(event);"{/if}>Quote</a>
	<!--{/if}-->
	<!--{if in_array('code', $seditor[1])}-->
		<a id="{$seditor[0]}code" href="javascript:;" title="{lang e_code}" class="fcd"{if empty($seditor[2])} onclick="seditor_menu('$seditor[0]', 'code');doane(event);"{/if}>Code</a>
	<!--{/if}-->
	<!--{if in_array('smilies', $seditor[1])}-->
		<a href="javascript:;" class="fsml" id="{$seditor[0]}sml"{if empty($seditor[2])} onclick="showMenu({'ctrlid':this.id,'evt':'click','layer':2});return false;"{/if}>{lang smilies}</a>
		<!--{if empty($seditor[2])}-->
			<script type="text/javascript" reload="1">smilies_show('{$seditor[0]}smiliesdiv', $_G['setting']['smcols'], '$seditor[0]');</script>
		<!--{/if}-->
	<!--{/if}-->
		<script type="text/javascript" src="{$_G['setting']['jspath']}at.js?{VERHASH}"></script>
		<a id="{$seditor[0]}at" href="javascript:;" title="{lang e_at}" class="fat"{if empty($seditor[2])} onclick="seditor_menu('$seditor[0]', 'at');doane(event);"{/if}>{lang at_friend}</a>
		<div id="file">$seditor[3]</div>
</div>