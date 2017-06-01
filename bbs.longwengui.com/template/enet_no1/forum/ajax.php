<?php exit;?>
<!--{subtemplate common/header_ajax}-->
<!--{if $_GET['action'] == 'quickclear'}-->
	<div class="tm_c">
		<h3 class="flb">
			<em id="return_$_GET['handlekey']">{lang quickclear}</em>
			<span>
				<a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a>
			</span>
		</h3>
		<form id="qclearform" method="post" autocomplete="off" action="forum.php?mod=ajax&action=quickclear&inajax=1" onsubmit="ajaxpost(this.id, 'return_$_GET['handlekey']', 'return_$_GET['handlekey']');return false;">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="uid" value="$uid" />
			<input type="hidden" name="redirect" value="{echo dreferer()}" />
			<input type="hidden" name="qclearsubmit" value="1" />
			<input type="hidden" name="handlekey" value="$_GET['handlekey']" />

			<div class="c">

				<ul>
					<li><label><input type="checkbox" name="operations[]" class="pc" value="avatar" />{lang quickclear_avatar}</label></li>
					<li><label><input type="checkbox" name="operations[]" class="pc" value="sightml" />{lang quickclear_sightml}</label></li>
					<li><label><input type="checkbox" name="operations[]" class="pc" value="customstatus" />{lang quickclear_customstatus}</label></li>
				</ul>
				<br />
				<!--{if $crimenum_avatar > 0}-->
					<div style="clear: both; text-align: right;">{lang quickclear_crime_avatar_nums}</div>
				<!--{/if}-->
				<!--{if $crimenum_sightml > 0}-->
					<div style="clear: both; text-align: right;">{lang quickclear_crime_sightml_nums}</div>
				<!--{/if}-->
				<!--{if $crimenum_customstatus > 0}-->
					<div style="clear: both; text-align: right;">{lang quickclear_crime_customstatus_nums}</div>
				<!--{/if}-->
				<div class="tpclg">
					<h4 class="cl"><a onclick="showselect(this, 'reason', 'reasonselect')" class="dpbtn" href="javascript:;">^</a><span>{lang admin_reason}:</span></h4>
					<p>
						<textarea id="reason" name="reason" class="pt" onkeyup="seditor_ctlent(event, '$(\'modsubmit\').click();')" rows="3"></textarea>
						<ul id="reasonselect" style="display: none"><!--{echo modreasonselect()}--></ul>
					</p>
				</div>

			</div>
			<p class="o">
				<label for="sendreasonpm"><input type="checkbox" name="sendreasonpm" id="sendreasonpm" class="pc"{if $_G['group']['reasonpm'] == 2 || $_G['group']['reasonpm'] == 3} checked="checked" disabled="disabled"{/if} />{lang admin_pm}</label>
				<button type="submit" name="modsubmit" id="modsubmit" class="pn pnc" value="true" tabindex="2"><strong>{lang submit}</strong></button>
			</p>
		</form>
	</div>
<!--{elseif $_GET['action'] == 'setnav'}-->
	<div class="tm_c">
		<h3 class="flb">
			<em id="return_$_GET['handlekey']">$navtitle</em>
			<span>
				<a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a>
			</span>
		</h3>
		<form id="setnav" method="post" autocomplete="off" action="forum.php?mod=ajax&action=setnav&type=portal&do=$do">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="type" value="$type" />
			<input type="hidden" name="funcsubmit" value="1" />
			<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
			<div class="c">
				<!--{if $do == 'open'}-->
				<ul>
					<!--{if $type != 'wall'}-->
					<li><label><input type="checkbox" name="location[header]" class="pc" value="1" />{lang main_nav}</label></li>
					<!--{/if}-->
					<li><label><input type="checkbox" name="location[quick]" class="pc" value="1" />{lang quick_nav}</label></li>
				</ul>
				<!--{else}-->
				$closeprompt
				<!--{/if}-->
			</div>
			<p class="o pns">
				<input type="submit" name="funcsubmit_btn" class="btn" value="{lang confirms}">
			</p>
		</form>
	</div>
<!--{/if}-->
<!--{subtemplate common/footer_ajax}-->