<?php exit;?>
<!--{template common/header}-->
<h3 class="flb">
	<em>{lang collection_comment_thread}</em>
	<span><a href="javascript:;" onclick="hideWindow('$_GET['handlekey']');" class="flbc" title="{lang close}">{lang close}</a></span>
</h3>
<form action="forum.php?mod=collection&action=comment&ctid={$ctid}" method="POST">
	<div class="c">
		<textarea name="message" class="pt" cols="60" rows="5">{lang collection_comment_specthread}
		</textarea> 
	</div>
	<div class="o pns">
		<button type="submit" class="pn pnc"><span>{lang collection_comment_submit}</span></button>
	</div>
</form>
<!--{template common/footer}-->