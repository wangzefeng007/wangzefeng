<?php exit;?>
<!--{eval}-->
<!--
function profile_node_numbercard() {
-->
<!--{/eval}-->
<!--{eval}-->
<!--
	return $return;
}

function profile_node_authortitle($post, $s, $e) {
-->
<!--{/eval}-->
<!--{block return}-->$s<a href="home.php?mod=spacecp&ac=usergroup&gid=$post[groupid]" target="_blank">{$post[authortitle]}</a>$e<!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function profile_node_upgradeprogress($post, $s, $e, $upgrademenu = 1) {
	if($post['upgradecredit'] !== false) {
		$menu = profile_node_upgrade_menu($post);
-->
<!--{/eval}-->
<!--{block return}-->
	$s<span class="pbg2" {if $upgrademenu} id="upgradeprogress_$post[pid]" onmouseover="showMenu({'ctrlid':this.id, 'pos':'12!', 'menuid':'g_up$post[pid]_menu'});"{/if}><span class="pbr2" style="width:$post['upgradeprogress']%;"></span></span>$e
	<!--{if $upgrademenu}-->$menu<!--{/if}-->
<!--{/block}-->
<!--{eval}-->
<!--
		return $return;
	}
}

function profile_node_upgrade_menu($post) {
	global $_G;
-->
<!--{/eval}-->
<!--{block return}--><div id="g_up$post[pid]_menu" class="tip tip_4" style="display: none;"><div class="tip_horn"></div><div class="tip_c">$post['authortitle'], {lang credits} $post['credits'], {lang thread_groupupgrade} $post['upgradecredit'] {lang credits}</div></div><!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function profile_node_baseinfo($post, $s, $e, $extra) {
	$str = viewthread_baseinfo($post, $extra);
	return $str !== '' ? $s.$str.$e : '';
}
-->
<!--{/eval}-->