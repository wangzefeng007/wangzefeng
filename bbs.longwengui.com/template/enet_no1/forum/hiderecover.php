<?php exit;?>
<!--{template common/header}-->
<h3 class="flb">
	<em id="return_$_GET['handlekey']">
		{lang hiderecover}
	</em>	
	<span>
		<a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a>
	</span>
</h3>

<form method="post" autocomplete="off" id="hiderecoverform" action="forum.php?mod=misc&action=hiderecover&tid=$_GET[tid]&infloat=yes" onsubmit="ajaxpost('hiderecoverform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;">
	<div class="c">
		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
		<!--{eval $sectpl = '<table cellspacing="0" cellpadding="0" class="tfm"><tr><th><sec></th><td><sec><p class="d"><sec></p></td></tr></table>';}-->
		<!--{subtemplate common/seccheck}-->
	</div>
	<div class="o pns" id="moreconf">		
		<button type="submit" id="postsubmit" class="pn pnc z" value="true" name="hiderecoversubmit"><span>{lang submit}</span></button>
	</div>
</form>

<script type="text/javascript" reload="1">
function succeedhandle_hiderecover(locationhref, message) {
	hideWindow('$_GET['handlekey']');
	$('hiderecover').style.display = 'none';
	showDialog(message, 'notice', '', '', 0, null, '', '', '', 3);
}
</script>

<!--{template common/footer}-->