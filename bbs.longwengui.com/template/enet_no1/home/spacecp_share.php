<?php exit;?>
<!--{template common/header}-->
<!--{if !$_G[inajax]}-->
<div id="pt" class="bm cl">
	<div class="z">
		<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> <a href="home.php">$_G[setting][navs][4][navname]</a>
	</div>
</div>
	<div id="ct" class="ct2_a wp cl">
		<div class="mn">
			<div class="bm bw0">
<!--{/if}-->
<!--{if $_GET['op'] == 'delete'}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang delete_share}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form id="shareform_{$sid}" name="shareform_{$sid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=share&op=delete&sid=$sid&type=$_GET[type]" {if $_G[inajax] && $_GET[type]!='view'} onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c">{lang delete_share_message}</div>
		<p class="o pns">
			<button type="submit" name="deletesubmitbtn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
		</p>
	</form>
	<!--{if $_G[inajax] && $_GET[type]!='view'}-->
	<script type="text/javascript">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			share_delete(values['sid']);
		}
	</script>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'edithot'}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang adjust_hot}</em>
		<!--{if !empty($_GET['inajax'])}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=share&op=edithot&sid=$sid">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="hotsubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="c">{lang new_hot}:<input type="text" name="hot" value="$share[hot]" size="10" class="px" /></div>
		<p class="o pns">
			<button type="submit" name="btnsubmit" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
		</p>
	</form>
<!--{elseif $_GET['op']=='link'}-->
	<!--{if !$_G[inajax]}-->
		<h1 class="mt">
			<img src="static/image/feed/share.gif" class="vm" alt="share"> {lang share}
		</h1>
	<!--{else}-->
		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang share}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
	<!--{/if}-->
	<form id="shareform" name="shareform" action="home.php?mod=spacecp&ac=share&type=link" method="post" autocomplete="off" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="refer" value="home.php?mod=space&uid=$space[uid]&do=share&view=me" />
		<input type="hidden" name="topicid" value="$_GET[topicid]" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="sharesubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c tfm">
			<p>{lang share_web_music_flash}:</p>
			<p class="mtn mbm"><input type="text" size="30" class="px" name="link" onfocus="javascript:if('http://'==this.value)this.value='';" onblur="javascript:if(''==this.value)this.value='http://'" id="share_link" value="$linkdefault" /></p>
			<p>{lang description}:</p>
			<p class="mtn mbm"><textarea id="share_general" name="general" cols="30" rows="3" class="pt" onkeydown="ctrlEnter(event, 'sharesubmit_btn')">$generaldefault</textarea></p>
			<!--{if $type == 'thread'}-->
				<p><a href="javascript:;" onclick="setCopy($('share_general').value + '\n ' + $('share_link').value, '{lang share_copylink}')" />{lang share_im}</a></p>
			<!--{/if}-->
			<!--{if $secqaacheck || $seccodecheck}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" class="secq" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="sec"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
		</div>
		<p class="o pns">
			<button type="submit" name="sharesubmit_btn" id="sharesubmit_btn" value="true" class="pn pnc"><strong>{lang share}</strong></button>
		</p>
	</form>
	<!--{if $_G[inajax]}-->
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'](url, message, values) {
			showCreditPrompt();
		}
	</script>
	<!--{/if}-->
<!--{else}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang share}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form method="post" autocomplete="off" id="shareform_{$id}" name="shareform_{$id}" action="home.php?mod=spacecp&ac=share&type=$type&id=$id" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="sharesubmit" value="true">
		<input type="hidden" name="referer" value="{echo dreferer()}">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c">
			<p class="cl">
				<span class="y xg1">{lang share_count}&nbsp;&nbsp;</span>
				{lang share_description}:
			</p>
			<textarea id="general_{$id}" name="general" cols="50" rows="5" class="pt mtn" style="width: 400px;" onkeydown="ctrlEnter(event, 'sharesubmit_btn')" onkeyup="showPreview(this.value, 'quote_{$id}')"></textarea>
			<!--{if $secqaacheck || $seccodecheck}-->
			<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
			<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
			<ul id="share_preview" class="el mtm cl 1">
			<!--{eval $value = $arr;}-->
			<!--{subtemplate home/space_share_li}-->
			</ul>
		</div>
		<p class="o pns">
			<!--{if $commentcable[$type]}-->
			<label><input type="checkbox" class="pc" name="iscomment" value="1"/><!--{if $type == 'thread'}-->{lang post_add_inonetime}<!--{else}-->{lang comment_add_inonetime}<!--{/if}--></label>
			<!--{/if}-->
			<button type="submit" name="sharesubmit_btn" id="sharesubmit_btn" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
		</p>
	</form>
	<!--{if $_G[inajax]}-->
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			if(values['cid'] && $('comment_ul') && !$('replynum_'+values['id'])) {
				comment_add(values['cid']);
			}
			if($('replynum_'+values['id'])) {
				var a = parseInt($('replynum_'+values['id']).innerHTML);
				var b = a + 1;
				$('replynum_'+values['id']).innerHTML = b + '';
			}
			if(values['type'] == 'thread' || values['type'] == 'article') {
				setTimeout("location.href='" + url + "';", 3000);
			}
			showCreditPrompt();
		}
	</script>
	<!--{/if}-->
<!--{/if}-->

<!--{if !$_G[inajax]}-->
		</div>
	</div>
	<div class="appl"><!--{subtemplate common/userabout}--></div>
</div>
<!--{/if}-->
<!--{template common/footer}-->