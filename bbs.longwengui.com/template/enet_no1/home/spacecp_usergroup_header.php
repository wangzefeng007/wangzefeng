<?php exit;?>
<ul class="tb cl">
	<!--{if $usergroups}-->
		<li class="y$activegs[my] showmenu" id="gmy" onmouseover="showMenu(this.id)"><a href="home.php?mod=spacecp&ac=usergroup">{lang my_usergroups}</a></li>
		<li class="y$activegs[upgrade] showmenu" id="gupgrade" onmouseover="showMenu(this.id)"><a>{lang usergroup_group2}</a></li>
		<li class="y$activegs[user] showmenu" id="guser" onmouseover="showMenu(this.id)"><a>{lang usergroup_group1}</a></li>
		<li class="y$activegs[admin] showmenu"id="gadmin" onmouseover="showMenu(this.id)"><a>{lang usergroup_group3}</a></li>
	<!--{/if}-->
	<li$activeus[usergroup]><a href="home.php?mod=spacecp&ac=usergroup">{lang my_usergroups}</a></li>
	<li$activeus[list] $activeus[expiry]><a href="home.php?mod=spacecp&ac=usergroup&do=list">{lang usergroups_joinbuy}</a></li>
	<li$activeus[forum]><a href="home.php?mod=spacecp&ac=usergroup&do=forum">{lang my}{$_G['setting']['navs'][2]['navname']}{lang rights}</a></li>
</ul>