<?php exit;?>
<ul>
	<!--{if helper_access::check_module('collection')}-->
	<li class="y o"><a href="forum.php?mod=collection&amp;action=edit">{lang collection_create}</a></li>
	<!--{/if}-->
	<li{if !$op && !$tid} class="a"{/if}><a href="forum.php?mod=collection">{lang collection_recommended}</a></li>
	<li{if $op == 'all'} class="a"{/if}><a href="forum.php?mod=collection&amp;op=all">{lang collection_all}</a></li>
	<li{if $op == 'my'} class="a"{/if}><a href="forum.php?mod=collection&amp;op=my">{lang collection_my}</a></li>
	<!--{if !$op && $tid}--><li class="a"><a href="forum.php?mod=collection&amp;tid=$tid">{lang collection_nav_related}</a></li><!--{/if}-->
	<!--{hook/collection_nav_extra}-->
</ul>