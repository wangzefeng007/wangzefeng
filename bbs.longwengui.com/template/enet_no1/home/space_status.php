<?php exit;?>
<style>
	.moodfm_btn {padding-left: 5px;background: url(template/enet_no1/images/flw_post.png) no-repeat 5px 0;}
	.moodfm_btn button{width:77px;height:33px}
	#maxlimit{font-weight: 700;font-size: 22px;font-style: italic;font-family: Constantia, Georgia;}
	.mi .moodfm_input{ !important;border: 1px solid #DFDFDF;border-radius:5px}
    #mood_statusinput{margin-top:30px;width: 599px;height:80px;background:transparent !important}
	#moodfm textarea {width: 568px !important;height:70px !Important}
</style>
<script type="text/javascript">
	var msgstr = '$defaultstr';
	function handlePrompt(type) {
		var msgObj = $('mood_message');
		if(type) {
			$('moodfm').className = 'hover';
			if(msgObj.value == msgstr) {
				msgObj.value = '';
				msgObj.className = 'msgfocus xg2';
			}
			if($('mood_message_menu')) {
				if($('mood_message_menu').style.display === 'block') {
					showFace('mood_message', 'mood_message', msgstr);
				}

			}
			if(BROWSER.firefox || BROWSER.chrome) {
				showFace('mood_message', 'mood_message', msgstr);
			}
		} else {
			$('moodfm').className = '';
			if(msgObj.value == ''){
				msgObj.value = msgstr;
				msgObj.className = 'xg1';
			}
		}
	}
	function reloadMood(showid) {
		var x = new Ajax();
		x.get('home.php?mod=spacecp&ac=doing&op=spacenote&inajax=1', function(s){
			$('mood_mystatus').innerHTML = '<a href="home.php?mod=space&uid=$space[uid]&do=doing&view=me" title="{lang view_all_my_doings}" class="xi2">'+s+'</a>';
		});
		$('mood_message').value = '';
		strLenCalc($('mood_message'), 'maxlimit');
		handlePrompt(0);
	}
</script>
<!--{if helper_access::check_module('doing')}-->
<div style="width: 100%;height: 30px;">
<div id="mood_mystatus" class="mtn mbn" style="float:left;overflow: hidden;word-break: break-all;height:22px;font-size:15px">
	<span style="float:left"><!--{if $space[spacenote]}--><a href="home.php?mod=space&uid=$space[uid]&do=doing&view=me" title="{lang view_all_my_doings}" class="xi2" style="word-break: break-all;">$space[spacenote]</a><!--{else}--><label for="mood_message" class="xi2">{lang no_update_record}</label><!--{/if}--></span>
	</div>
		<span class="y">{lang doing_maxlimit_char}</span>
</div>
<div id="moodfm" style="margin-top:0;padding-top:0">
	<form method="post" autocomplete="off" id="mood_addform" action="home.php?mod=spacecp&ac=doing&handlekey=doing" onsubmit="if($('mood_message').value != msgstr) {ajaxpost(this.id, 'return_doing');} else {return false;}">
		<table cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<div id="mood_statusinput" class="moodfm_input" style="margin-top:0;padding-top:0">
					<textarea name="message" id="mood_message" class="xg1" onclick="showFace(this.id, 'mood_message', msgstr);" onfocus="handlePrompt(1);" onblur="handlePrompt(0);" onkeydown="if(ctrlEnter(event, 'addsubmit_btn')){if(event.keyCode == 13 ){ doane(event);}}" onkeyup="strLenCalc(this, 'maxlimit');">$defaultstr</textarea>
				</div>
			</tr>
			<tr>
				<td class="moodfm_f">
					<!--{if !empty($_G['setting']['pluginhooks']['space_home_doing_sync_method'])}-->
						<span>
							{lang doing_sync}:
							<!--{if $_G['group']['maxsigsize']}-->
								<a title="{lang doing_update_personal_signature}" id="syn_signature" class="syn_signature" href="javascript:void(0);" onclick="checkSynSignature()">{lang doing_update_personal_signature}</a>
								<input type="hidden" name="to_signhtml" id="to_signhtml" value="0" />
							<!--{/if}-->
							<!--{hook/space_home_doing_sync_method}-->
						</span>
					<!--{else}-->
						<!--{if $_G['group']['maxsigsize']}-->
							<label for="to_sign" style="float:left"><input type="checkbox" name="to_signhtml" id="to_sign" class="pc" value="1" />{lang doing_update_personal_signature}</label>
						<!--{/if}-->
					<!--{/if}-->
					<div id="return_doing" class="xi1 xw1"></div>
				<div class="moodfm_btn" style="float:right;padding-right:5px;padding-left:0">
					<button type="submit" name="addsubmit_btn" id="addsubmit_btn">{lang publish}</Button>
				</div>
				</td>
				<td></td>
			</tr>
		</table>
		<input type="hidden" name="addsubmit" value="true" />
		<input type="hidden" name="spacenote" value="true" />
		<input type="hidden" name="referer" value="home.php" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
	<script type="text/javascript">
		function succeedhandle_doing(url, msg, values) {
			if(values['message']) {
				showDialog(values['message']);
				return false;
			}
			reloadMood(values['doid']);
		}
	</script>
</div>
<!--{/if}-->
