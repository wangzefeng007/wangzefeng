<?php exit;?>
<!--{template common/header}-->

<style type="text/css">
.parentcat {}
.cat { margin-left: 20px; }
.lastchildcat, .childcat { margin-left: 40px; }
</style>
<!--{if $op == 'push'}-->
	<h3 class="flb">
	<em>{lang article_push}</em>
	<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>

	<div class="c" style="width:220px; height: 300px; overflow: hidden; overflow-y: scroll;">
		<p>{lang category_push_select}</p>
		<table class="mtw dt">
			$categorytree
		</table>
	</div>

<!--{else}-->

<div id="ct" class="ct7_a wp cl">
	<div class="apps">
		<!--{subtemplate portal/portalcp_nav}-->
	</div>
	<div class="mn">
		<div class="bm bw0 mdcp">
			<h1 class="mt">{lang panel_login}</h1>
			<div class="mbw">{lang panel_notice_login}</div>
			<form method="post" autocomplete="off" action="portal.php?mod=portalcp" class="exfm">
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<input type="hidden" name="submit" value="yes">
				<input type="hidden" name="login_panel" value="yes">
				<table cellspacing="0" cellpadding="5">
					<tr>
						<th width="60">{lang panel_login_username}:</th><td>{$_G[member][username]}</td>
					</tr>
					<tr>
						<th>{lang panel_login_password}:</th><td><input id="cppwd" type="password" name="cppwd" class="px" /></td>
					</tr>
					<tr>
						<th></th><td><button type="submit" class="pn" name="submit" id="submit" value="true"><strong>{lang submit}</strong></button></td>
					</tr>
				</table>
			</form>
		</div>
		<script type="text/javascript">
			$("cppwd").focus();
		</script>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->

