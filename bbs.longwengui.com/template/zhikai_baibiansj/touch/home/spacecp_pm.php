<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{template common/header}-->
<!--{if $op != ''}-->
<div class="bm_c">{lang user_mobile_pm_error}</div>
<!--{else}-->

<form id="pmform_{$pmid}" name="pmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid&pmid=$pmid&mobile=2" >
	<input type="hidden" name="referer" value="{echo dreferer();}" />
	<input type="hidden" name="pmsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />

<!-- header start -->
<header class="header">
    <div class="nav">
		<span class="y"><button id="pmsubmit_btn" class="btn_pn btn_pn_grey" disable="true"><span>{lang sendpm}</span></button></span>
		<input type="hidden" name="pmsubmit_btn" value="yes" />
        <a href="home.php?mod=space&do=pm" class="z"><img src="{STATICURL}image/mobile/images/icon_back.png" /></a>
		<span>{lang send_pm}</span>
    </div>
</header>
<!-- header end -->
<!-- main post_msg_box start -->
<div class="wp">
	<div class="post_msg_from">
		<ul>
			<!--{if !$touid}-->
			<li class="bl_line"><input type="text" value="" tabindex="1" class="px" size="30" autocomplete="off" id="username" name="username" placeholder="{lang addressee}"></li>
			<!--{/if}-->
			<li class="bl_none area">
				<textarea class="pt" tabindex="2" autocomplete="off" value="" id="sendmessage" name="message" cols="80" rows="7"  placeholder="{lang thread_content}"></textarea>
			</li>
		</ul>
	</div>
</div>
<!-- main postbox start -->
</form>
<script type="text/javascript">
	(function() {
		$('#sendmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
				$('.btn_pn').attr('disable', 'false');
			} else {
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
		var form = $('#pmform_{$pmid}');
		$('#pmsubmit_btn').on('click', function() {
			var obj = $(this);
			if(obj.attr('disable') == 'true') {
				return false;
			}
			$.ajax({
				type:'POST',
				url:form.attr('action') + '&handlekey='+form.attr('id')+'&inajax=1',
				data:form.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				popup.open(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				popup.open('{lang networkerror}', 'alert');
			});
			return false;
			});
	 })();
</script>
<!--{/if}-->
<!--{eval $nofooter = true;}-->

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?forumlist=1" class="bottom_history"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member_on"></a>
</div>

<!--{template common/footer}-->

