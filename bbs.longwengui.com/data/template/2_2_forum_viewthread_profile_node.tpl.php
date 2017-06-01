<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 
function profile_node_numbercard() {
?><?php 
return $return;
}

function profile_node_authortitle($post, $s, $e) {
?><?php
$return = <<<EOF
{$s}<a href="home.php?mod=spacecp&amp;ac=usergroup&amp;gid={$post['groupid']}" target="_blank">{$post['authortitle']}</a>{$e}
EOF;
?><?php 
return $return;
}

function profile_node_upgradeprogress($post, $s, $e, $upgrademenu = 1) {
if($post['upgradecredit'] !== false) {
$menu = profile_node_upgrade_menu($post);
?><?php
$return = <<<EOF

{$s}<span class="pbg2" 
EOF;
 if($upgrademenu) { 
$return .= <<<EOF
 id="upgradeprogress_{$post['pid']}" onmouseover="showMenu({'ctrlid':this.id, 'pos':'12!', 'menuid':'g_up{$post['pid']}_menu'});"
EOF;
 } 
$return .= <<<EOF
><span class="pbr2" style="width:{$post['upgradeprogress']}%;"></span></span>{$e}

EOF;
 if($upgrademenu) { 
$return .= <<<EOF
{$menu}
EOF;
 } 
$return .= <<<EOF


EOF;
?><?php 
return $return;
}
}

function profile_node_upgrade_menu($post) {
global $_G;
?><?php
$return = <<<EOF
<div id="g_up{$post['pid']}_menu" class="tip tip_4" style="display: none;"><div class="tip_horn"></div><div class="tip_c">{$post['authortitle']}, 积分 {$post['credits']}, 距离下一级还需 {$post['upgradecredit']} 积分</div></div>
EOF;
?><?php 
return $return;
}

function profile_node_baseinfo($post, $s, $e, $extra) {
$str = viewthread_baseinfo($post, $extra);
return $str !== '' ? $s.$str.$e : '';
}
?>