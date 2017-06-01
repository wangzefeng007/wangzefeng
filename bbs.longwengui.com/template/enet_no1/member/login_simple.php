<?php exit;?>
<!--{if CURMODULE != 'logging'}-->
<script type="text/javascript" src="{$_G[setting][jspath]}logging.js?{VERHASH}"></script>
  <form method="post" autocomplete="off" id="lsform" action="member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes" onsubmit="{if $_G['setting']['pwdsafety']}pwmd5('ls_password');{/if}return lsSubmit();">

  <div id="um" style="color:#fff !important"> 
	<div class="avt y"><a><!--{avatar($_G[uid],small)}--></a></div>
	<p class="top30">
	<!--{hook/global_usernav_extra2}-->
	 <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" style="text-decoration: none;" title="{lang login}">{lang login}</a>&nbsp;or&nbsp;<a href="member.php?mod={$_G[setting][regname]}" style="text-decoration: none;" title="$_G['setting']['reglinkname']">$_G['setting']['reglinkname']</a>
	</p>
  </div>
	</form>
	<!--{if $_G['setting']['pwdsafety']}-->
		<script type="text/javascript" src="{$_G['setting']['jspath']}md5.js?{VERHASH}" reload="1"></script>
	<!--{/if}-->

<!--{/if}-->