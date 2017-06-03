<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{if $param['login']}-->
	<!--{if $_G['inajax']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login&inajax=1&infloat=1');exit;}-->
	<!--{else}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
	<!--{/if}-->
<!--{/if}-->
<!--{template common/header}-->
<!--{if $_G['inajax']}-->
<div class="tip" style="height:150px;">
	<dt id="messagetext">
		<p>$show_message</p>
        <!--{if $_G['forcemobilemessage']}-->
        	<p >
            	<a href="{$_G['setting']['mobile']['pageurl']}" class="mtn">{lang continue}</a><br />
                <a href="javascript:history.back();">{lang goback}</a>
            </p>
        <!--{/if}-->
		<!--{if $url_forward && !$_GET['loc']}-->
			<!--<p><a class="grey" href="$url_forward">{lang message_forward_mobile}</a></p>-->
			<script type="text/javascript">
				setTimeout(function() {
					window.location.href = '$url_forward';
				}, '3000');
			</script>
		<!--{elseif $allowreturn}-->
			<p><input type="button" class="button" onclick="popup.close();" value="{lang close}"></p>
		<!--{/if}-->
	</dt>
</div>
<!--{else}-->

<!-- header start -->
<div class="n5-header">
    <a class="n5-cebianlan" id="open-sb"><i class="n5-ico"></i></a>
	<a class="n5-logo" href="forum.php?mod=guide&view=hot"><img src="$_G['style']['logo地址']" alt="$_G['setting']['sitename']" width="100%"></a>
	<a class="n5-fatie" href="forum.php?mod=misc&action=nav" rel="nofollow"><i class="n5-ico"></i></a>
</div>
<!--{template common/n5-cbl}-->
<!-- header end -->

<!-- main jump start -->
<div class="jump_c">
	<p>$show_message</p>
    <!--{if $_G['forcemobilemessage']}-->
		<p>
            <a href="{$_G['setting']['mobile']['pageurl']}" class="mtn">{lang continue}</a><br />
            <a href="javascript:history.back();">{lang goback}</a>
        </p>
    <!--{/if}-->
	<!--{if $url_forward}-->
		<p><a class="grey" href="$url_forward">{lang message_forward_mobile}</a></p>
	<!--{elseif $allowreturn}-->
		<p><a class="grey" href="javascript:history.back();">{lang message_go_back}</a></p>
	<!--{/if}-->
</div>
<!-- main jump end -->

<!--{/if}-->

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?mod=guide&view=hot" class="bottom_index"></a>
	<a href="forum.php?forumlist=1" class="bottom_history"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member"></a>
</div>

<!--{template common/footer}-->

