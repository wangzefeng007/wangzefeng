<?php exit;?>
<!--{subtemplate search/header}-->
<div id="ct" class="w">
	<form class="searchform" method="post" autocomplete="off" action="search.php?mod=portal" onsubmit="if($('scform_srchtxt')) searchFocus($('scform_srchtxt'));">
		<input type="hidden" name="formhash" value="{FORMHASH}" />

		<!--{subtemplate search/pubsearch}-->
		<!--{hook/portal_top}-->

	</form>
	<!--{if !empty($searchid) && submitcheck('searchsubmit', 1)}-->
	<!--{subtemplate search/portal_list}-->
	<!--{/if}-->

</div>
<!--{hook/portal_bottom}-->

<!--{subtemplate search/footer}-->