<?php exit;?>
<!--{template common/header}-->
<div id="ajax_explain_menu">
	<h2 class="cl">{lang eccredit_needexplanation}</h2>
	<form method="post" autocomplete="off" id="explainform_$id" action="home.php?mod=spacecp&ac=eccredit&op=explain&explainsubmit=yes">
		<div class="mtm">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="id" value="$id" />
			<textarea name="explanation" rows="5" style="width: 300px" class="pt"></textarea>
			<p class="pns mtm">
				<button class="pn pnc" type="button" name="explainsubmit" value="true" onclick="ajaxpost('explainform_$id', 'ecce_$id');hideMenu();"><span>{lang submit}</span></button>
				<button class="pn" type="button" value="true" onclick="hideMenu()"><span>{lang close}</span></button>
			</p>
		</div>
	</form>
</div>
<!--{template common/footer}-->