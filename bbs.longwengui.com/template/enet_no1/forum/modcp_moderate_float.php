<?php exit;?>
<!--{template common/header}-->

<div class="f_c">
	<h3 class="flb">
		<em id="return_mods">
			<!--{if $modact == 'delete'}-->{lang delete}<!--{elseif $modact == 'ignore'}-->{lang ignore}<!--{elseif $modact == 'invalidate'}-->{lang invalidate}<!--{else}-->{lang validate}<!--{/if}-->
			<!--{if $op == 'members'}-->{lang mod_moderate_member}<!--{elseif $op == 'threads'}-->{lang mod_moderate_thread}<!--{elseif $op == 'replies'}-->{lang mod_moderate_reply}<!--{/if}-->
			(<!--{echo count($list)}-->)</em>
		<span>
			<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('mods')" title="{lang close}">{lang close}</a><!--{/if}-->
		</span>
	</h3>

	<form id="moderateform" method="post" autocomplete="off" action="{$cpscript}?mod=modcp&action=$_GET[action]&op=$op&infloat=yes" onsubmit="ajaxpost('moderateform', 'return_mods', 'return_mods', 'onerror');return false;">
		<div class="c">
		<!--{if $list}-->
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="filter" value="$filter" />
			<input type="hidden" name="modact" value="$modact" />
			<input type="hidden" name="modsubmit" value="1" />
			<!--{if $op == 'replies'}-->
			<!--{eval $_GET['posttableid'] = intval($_GET['posttableid']);}-->
			<input type="hidden" name="posttableid" value="$_GET['posttableid']" />
			<!--{/if}-->
			<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
			<!--{loop $list $id}-->
				<input type="hidden" name="moderate[]" value="$id" />
			<!--{/loop}-->
			<p>{lang mod_moderate_reason}: </p>
			<p><textarea name="reason" cols="50" rows="3" class="pt mtn"></textarea></p>
		<!--{else}-->
			{lang mod_moderate_nonexistence}
		<!--{/if}-->
		</div>
		<p class="o">
			<button type="submit" name="modsubmit" id="modsubmit" class="pn pnc" value="true" tabindex="2"><strong>{lang submit}</strong></button>
			<!--{if $op=='members'}--><label for="sendemail"><input type="checkbox" name="sendemail" id="sendemail" class="pc" value="1" />{lang mod_moderate_member_sendemail}</label><!--{/if}-->
		</p>
	</form>
</div>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	<!--{loop $list $id}-->
		$('pidcheck_$id').parentNode.removeChild($('pidcheck_$id'));
		$('pid_$id').style.display = 'none';
	<!--{/loop}-->
	recountobj();
	hideWindow('mods');
}
</script>

<!--{template common/footer}-->