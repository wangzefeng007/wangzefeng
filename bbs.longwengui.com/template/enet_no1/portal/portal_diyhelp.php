<?php exit;?>
<!--{if !$ref && $_GET['action'] == 'get'}-->
	<!--{if $allowdiy}-->
		if(!$('diypage') && $('wp')) {
			var dom = document.createElement('div');
			dom.id = 'diypage';
			dom.className = 'area';
			$('wp').appendChild(dom);
		}
		$('diypage').innerHTML = '<div class="hm" style="border: 2px dashed #DFDFDF; padding:200px 0;"><p class="mbn"><button type="button" class="pn pnc" onclick="saveUserdata(\'diy_advance_mode\', 1);openDiy();"><strong>{lang diyhelp_start_diy}</strong></button></p>\n\<p>{lang diyhelp_doit}\n\
			<a href="javascript:saveUserdata(\'diy_advance_mode\', \'1\');saveUserdata(\'openfn\',\'drag.openFrameImport(1)\');openDiy();" class="xi2">{lang diyhelp_import}</a></p></div>';

	<!--{else}-->

		if(!$('diypage') && $('wp')) {
			var dom = document.createElement('div');
			dom.id = 'diypage';
			dom.className = 'area';
			$('wp').appendChild(dom);
		}
		$('diypage').innerHTML = '<div class="bm hm xs2 xg1" style="padding:200px 0;">{lang diyhelp_no_content}</div>';

	<!--{/if}-->
<!--{/if}-->