<?php exit;?>
<!--{loop $settings $key $value}-->
<tr class="vt">
	<th>$value[title]<!--{if $value[comment]}--> <img src="{IMGDIR}/faq.gif" alt="Tip" class="vm" style="margin: 0;" onmouseover="showTip(this)" tip="$value[comment]" /><!--{/if}--></th>
	<td>$value[html]</td>
</tr>
<!--{/loop}-->