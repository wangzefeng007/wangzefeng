<?php exit;?>
<!--{template common/header}-->

<!--{if $_GET['op'] == 'getcomment'}-->

	<div class="cmt brm">
		<div id="comment_ol_$feedid" class="xld xlda">
		<!--{loop $list $k $value}-->
			<!--{template home/space_comment_li}-->
		<!--{/loop}-->
		</div>
		<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<form id="feedform_{$feedid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=feed&feedid=$feedid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<span id="face_{$feedid}" title="{lang insert_emoticons}" onclick="showFace(this.id, 'feedmessage_{$feedid}');return false;" class="cur1"><img src="{IMGDIR}/facelist.gif" alt="facelist" class="vm" /></span>
			<span id="note_{$feedid}"></span>
			<textarea id="feedmessage_{$feedid}" name="message" rows="2" class="pt"  onkeydown="return ctrlEnter(event, 'feedbutton');"></textarea>
			<!--{if $secqaacheck || $seccodecheck}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="mtm mbm sec"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
			<input type="hidden" name="commentsubmit" value="true" />
			<p class="pns"><button type="submit" name="feedbutton" id="feedbutton" class="pn" value="true"><strong>{lang comment}</strong></button></p>
			<span id="return_$_GET[handlekey]"></span>
			<input type="hidden" name="referer" value="home.php?mod=space&do=hot&id=$feedid" />
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="quickcomment" value="1" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		</form>
	</div>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			feedcomment_add(values['cid'], $feedid);
			hideWindow('$_GET['handlekey']');
			<!--{if $sechash}-->
				<!--{if $secqaacheck}-->
				updatesecqaa('$sechash');
				<!--{/if}-->
				<!--{if $seccodecheck}-->
				updateseccode('$sechash');
				<!--{/if}-->
			<!--{/if}-->

		}
	</script>

<!--{elseif $_GET['op'] == 'menu'}-->

	<!--{if $feed[uid]==$_G[uid]}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang delete_feed}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form method="post" autocomplete="off" id="feedform_{$feedid}" name="feedform_{$feedid}" action="home.php?mod=spacecp&ac=feed&op=delete&feedid=$feedid&handlekey=$_GET[handlekey]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="feedsubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="c altw">
			<div class="alert_info">{lang determine_delete_feed}</div>
		</div>
		<p class="o pns">
			<button name="feedsubmitbtn" type="submit" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
			<!--
			<!--{if checkperm('managefeed')}-->
			<a href="home.php?mod=spacecp&ac=feed&op=edit&feedid=$feedid" target="_blank" class="pn"><strong class="z">{lang edit}</strong></a>
			<!--{/if}-->
			-->
		</p>
	</form>
	<!--{else}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang shield_feed}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form method="post" autocomplete="off" id="feedform_{$feedid}" name="feedform_{$feedid}" action="home.php?mod=spacecp&ac=feed&op=ignore&icon=$feed[icon]&feedid=$feedid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="feedignoresubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c altw">
			<p>{lang next_visit_not_view_feed}</p>
			<p class="ptn"><label for="uid1"><input type="radio" name="uid" id="uid1" value="$feed[uid]" checked="checked" />{lang shield_this_friend}</label></p>
			<p class="ptn"><label for="uid0"><input type="radio" name="uid" id="uid0" value="0" />{lang shield_all_friend}</label></p>
		</div>
		<p class="o pns">
			<button name="feedignoresubmitbtn" type="submit" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
			<!--
			<!--{if checkperm('managefeed')}-->
			<a href="admin.php?action=feed&operation=edit&feedid=$feedid" target="_blank" class="pn"><strong class="z">{lang edit}</strong></a>
			<!--{/if}-->
			-->
		</p>
	</form>
	<!--{/if}-->
	<script type="text/javascript">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			var obj = $('feed_'+ values['feedid'] +'_li');
			obj.style.display = "none";
			hideWindow('$_GET['handlekey']');
		}
	</script>
<!--{/if}-->

<!--{template common/footer}-->
