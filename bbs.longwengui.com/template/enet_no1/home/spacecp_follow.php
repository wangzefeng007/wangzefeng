<?php exit;?>
<!--{template common/header}-->

<!--{if $op == 'bkname'}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang follow_for}$followuser['fusername']{lang follow_add_bkname}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<!--{if !submitcheck('editbkname')}-->
	<form method="post" autocomplete="off" id="bknameform_{$_GET[handlekey]}" name="bknameform_{$_GET[handlekey]}" action="home.php?mod=spacecp&ac=follow&op=bkname&fuid=$followuser['followuid']" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editbkname" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="c">
			<table>
				<tr>
					<th valign="top" width="60" class="avt"><a href="home.php?mod=space&uid=$followuser['followuid']"><!--{avatar($followuser['followuid'],small)}--></th>
					<td valign="top">{lang follow_editnote}: <input type="text" name="bkname" value="$followuser['bkname']" size="35" class="px"  onkeydown="ctrlEnter(event, 'editsubmit_btn');" />
					</td>
				</tr>
			</table>
		</div>
		<p class="o pns">
			<button type="submit" name="editsubmit_btn" id="editsubmit_btn" value="true" class="pn pnc"><strong>{lang save}</strong></button>
		</p>
	</form>
	<!--{/if}-->
	<script type="text/javascript" reload="1">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			$('$_GET[handlekey]').innerHTML = values['bkname'];
			$('fbkname_$followuser[followuid]').innerHTML = values['btnstr'];
		}
	</script>
<!--{elseif $op == 'relay'}-->
	<!--{if $_GET['from'] == 'forum'}-->

		<h3 class="flb">
			<em id="return_$_GET[handlekey]">{lang follow_reply}</em>
			<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
		</h3>
		<form method="post" autocomplete="off" id="relayform_{$tid}" name="relayform_{$tid}" action="home.php?mod=spacecp&ac=follow&op=relay&tid=$tid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<input type="hidden" name="relaysubmit" value="true">
			<input type="hidden" name="referer" value="{echo dreferer()}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="tid" value="$tid" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
			<div class="c">
				<p>{lang follow_add_note}:</p>
				<textarea id="note_{$tid}" name="note" cols="50" rows="5" class="pt mtn" style="width: 425px;" onkeydown="ctrlEnter(event, 'relaysubmit_btn')" onkeyup="strLenCalc(this, 'checklen{$tid}', 140);"></textarea>
				<!--{if $secqaacheck || $seccodecheck}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
				<!--{/if}-->
				<br/>{lang follow_can_enter}<span id="checklen{$tid}" class="xg1">140</span>{lang follow_word}
			</div>
			<p class="o pns">
				<label class="lb"><input type="checkbox" name="addnewreply" checked="checked" class="pc" value="1" />{lang post_add_inonetime}</label>
				<button type="submit" name="relaysubmit_btn" id="relaysubmit_btn" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
			</p>
		</form>
		<script type="text/javascript">
			$('note_{$tid}').focus();
			function succeedhandle_$_GET['handlekey'](url, message, param) {
				<!--{if $fastpost}-->
					succeedhandle_fastpost(url, message, param);
				<!--{/if}-->
				hideWindow('$_GET[handlekey]');
				showCreditPrompt();
			}
		</script>
	<!--{else}-->
		<span class="cnr" style="margin: -22px 66px 0 0;"></span>
		<form method="post" autocomplete="off" id="postform_{$tid}" action="home.php?mod=spacecp&ac=follow&op=relay&tid=$tid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
			<input type="hidden" name="relaysubmit" value="true">
			<input type="hidden" name="referer" value="{echo dreferer()}">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="tid" value="$tid" />
			<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->

			<table cellspacing="0" cellpadding="0">
				<tr>
					<td class="flw_autopt">
						<textarea id="note_{$tid}" name="note" class="pts" cols="80" rows="4" onkeyup="resizeTx(this);strLenCalc(this, 'checklen{$tid}', 140);" onkeydown="resizeTx(this);" onpropertychange="resizeTx(this);" oninput="resizeTx(this);" style="height:54px">


						</textarea>
					</td>
					<td style="vertical-align:top;">
						<table cellspacing="0" cellpadding="0" style="margin-left: 5px;">
							<tr>
								<td style="vertical-align:top;"><button type="submit" name="relaysubmit_btn" id="relaysubmit_btn" class="pn pnc" value="true" name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{/if}" tabindex="23"><span>{lang follow_reply}</span></button></td>
								<td width="100" class="ptn" style="vertical-align:top;"><label><input type="checkbox" name="addnewreply" class="pc" value="1" checked="checked" />{lang post_add_inonetime}</label></td>
							</tr>
							<tr>
								<td colspan="2" class="ptm">{lang follow_can_enter}<span id="checklen{$tid}" class="xg1">140</span>{lang follow_word}</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>

			<!--{if $secqaacheck || $seccodecheck}-->
			<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':this.id,'win':'{$_GET[handlekey]}'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
			<div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
			<div id="return_$_GET[handlekey]"></div>
		</form>

		<div class="cl">
			<a href="javascript:;" onclick="display('relaybox_{$_GET['feedid']}')" class="y xg1">&uarr; {lang close}</a>
		</div>

		<script type="text/javascript">
			$('note_{$tid}').focus();
			function succeedhandle_$_GET['handlekey'](url, message, values) {
				$('relaybox_$_GET[feedid]').style.display = 'none';
				showCreditPrompt();
			}
		</script>
	<!--{/if}-->
<!--{elseif $op == 'getfeed'}-->
	<!--{if !empty($list)}-->
	<!--{subtemplate home/follow_feed_li}-->
	<!--{else}-->
	false
	<!--{/if}-->
<!--{elseif $op == 'delete'}-->
	<h3 class="flb">
		<em id="return_$_GET[handlekey]">{lang follow_del_feed}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');return false;" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<form method="post" autocomplete="off" id="deletefeed_{$_GET['feedid']}" name="deletefeed_{$_GET['feedid']}" action="home.php?mod=spacecp&ac=follow&op=delete&feedid=$_GET['feedid']" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="c altw mtm mbm">{lang follow_del_feed_confirm}</div>
		<p class="o pns">
			<button type="submit" name="btnsubmit" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
		</p>
	</form>
	<script type="text/javascript">
		function succeedhandle_{$_GET[handlekey]}(url, msg, values) {
			$('feed_li_'+values.feedid).style.display = 'none';
		}
	</script>
<!--{/if}-->

<!--{template common/footer}-->