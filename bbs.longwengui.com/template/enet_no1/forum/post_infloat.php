<?php exit;?>
<!--{template common/header}-->
<h3 class="flb">
	<em id="return_$_GET['handlekey']">
		<!--{if $_GET[action] == 'newthread'}-->{lang post_newthread}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{/if}-->
	</em>
	<!--{if $_GET[action] == 'newthread' && $modnewthreads}--><span class="needverify">{lang approve}</span><!--{/if}-->
	<!--{if $_GET[action] == 'reply' && $modnewreplies}--><span class="needverify">{lang approve}</span><!--{/if}-->
	<span>
		<a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a>
	</span>
</h3>

<form method="post" autocomplete="off" id="postform" action="forum.php?mod=post&infloat=yes&action=$_GET[action]&fid=$_G[fid]&extra=$extra{if $_GET[action] == 'newthread'}&topicsubmit=yes{elseif $_GET[action] == 'reply'}&tid=$_G[tid]&replysubmit=yes{/if}" onsubmit="this.message.value = parseurl(this.message.value);{if !empty($_GET['infloat'])}ajaxpost('postform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;{/if}">
	<div class="c" id="floatlayout_$_GET[action]">
		<div class="p_c">
			<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
			<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
			<!--{if $_GET[action] == 'reply'}-->
				<input type="hidden" name="noticeauthor" value="$noticeauthor" />
				<input type="hidden" name="noticetrimstr" value="$noticetrimstr" />
				<input type="hidden" name="noticeauthormsg" value="$noticeauthormsg" />
				<input type="hidden" name="usesig" value="{if $_G['group']['maxsigsize']}1{else}0{/if}"/>
				<!--{if $reppid}-->
					<input type="hidden" name="reppid" value="$reppid" />
				<!--{/if}-->
				<!--{if $_GET[reppost]}-->
					<input type="hidden" name="reppost" value="$_GET[reppost]" />
				<!--{elseif $_GET[repquote]}-->
					<input type="hidden" name="reppost" value="$_GET[repquote]" />
				<!--{/if}-->
			<!--{/if}-->
			<!--{hook/post_infloat_top}-->
			<div class="pbt cl">
				<!--{if $_GET[action] == 'newthread' && ($threadsorts = $_G['forum'][threadsorts])}-->
					<div class="ftid">
						<select name="sortid" id="sortid" width="80" change="if($('sortid').value) {switchAdvanceMode('forum.php?mod=post&action=$_GET[action]&fid=$_G[fid]{if !empty($_G[tid])}&tid=$_G[tid]{/if}{if !empty($pid)}&pid=$pid{/if}{if !empty($modelid)}&modelid=$modelid{/if}&extra=$extra&sortid=' + $('sortid').value)}">
						<!--{if !$sortid}--><option value="0">{lang threadtype_option}</option><!--{/if}-->
						<!--{loop $threadsorts[types] $tsortid $name}-->
							<!--{if !empty($modelid) && $threadsorts[modelid][$tsortid] == $modelid || empty($modelid)}-->
								<option value="$tsortid"{if $sortid == $tsortid} selected="selected"{/if}><!--{echo strip_tags($name);}--></option>
							<!--{/if}-->
						<!--{/loop}-->
						</select>
					</div>
					<script type="text/javascript" reload="1">simulateSelect('sortid');</script>
				<!--{/if}-->
				<!--{if $isfirstpost && $_G['forum'][threadtypes][types]}-->
					<div class="ftid">
						<select name="typeid" id="typeid_float" width="80">
						<option value="0">{lang select_thread_catgory}</option>
						<!--{loop $_G['forum'][threadtypes][types] $typeid $name}-->
							<!--{if empty($_G['forum']['threadtypes']['moderators'][$typeid]) || $_G['forum']['ismoderator']}-->
							<option value="$typeid"{if $thread['typeid'] == $typeid} selected="selected"{/if}><!--{echo strip_tags($name);}--></option>
							<!--{/if}-->
						<!--{/loop}-->
						</select>
					</div>
					<script type="text/javascript" reload="1">simulateSelect('typeid_float');</script>
				<!--{/if}-->
				<!--{if $_GET[action] != 'reply'}-->
					<span><input name="subject" id="subject" class="px" value="$postinfo[subject]" tabindex="21" style="width: 25em" /></span>
				<!--{else}-->
					<span id="subjecthide" class="z">RE: $thread[subject] [<a href="javascript:;" onclick="display('subjecthide');display('subjectbox');$('subject').value='RE: {echo dhtmlspecialchars(str_replace('\'', '\\\'', $thread[subject]))}'">{lang modify}</a>]</span>
					<span id="subjectbox" style="display:none"><input name="subject" id="subject" class="px" value="" tabindex="21" style="width: 25em" /></span>
				<!--{/if}-->
			</div>
			<!--{if !$isfirstpost && $thread[special] == 5 && empty($firststand)}-->
			<div class="pbt cl">
				<div class="ftid sslt">
					<select id="stand" name="stand">
						<option value="">{lang debate_viewpoint}</option>
						<option value="0">{lang debate_neutral}</option>
						<option value="1"{if $stand == 1} selected{/if}>{lang debate_square}</option>
						<option value="2"{if $stand == 2} selected{/if}>{lang debate_opponent}</option>
					</select>
				</div>
				<script type="text/javascript" reload="1">simulateSelect('stand');</script>
			</div>
			<!--{/if}-->
			<!--{if $_GET[action] == 'reply' && $quotemessage}-->
				<div class="pbt cl">$quotemessage</div>
			<!--{/if}-->

			<div class="tedt">
				<div class="bar">
					<span class="y">
						<a href="forum.php?mod=post&action=$_GET[action]&fid=$_G[fid]&extra=$extra{if $_GET[action] == 'reply'}&tid=$_G[tid]{if !empty($_GET[reppost])}&reppost=$_GET[reppost]{/if}{if !empty($_GET[repquote])}&repquote=$_GET[repquote]{/if}{if !empty($page)}&page=$page{/if}{/if}{if $stand}&stand=$stand{/if}" onclick="switchAdvanceMode(this.href);doane(event);">{lang post_advancemode}</a>
					</span>
					<!--{eval $seditor = array('post', array('bold', 'color', 'img', 'link', 'quote', 'code', 'smilies', 'at'));}-->
					<!--{subtemplate common/seditor}-->
				</div>
				<div class="area">
				<textarea rows="7" cols="80" name="message" id="postmessage" onKeyDown="seditor_ctlent(event, '$(\'postsubmit\').click();')" tabindex="22" class="pt">$message</textarea>
				</div>
			</div>
			<div id="seccheck_$_GET[action]">
				<!--{if $secqaacheck || $seccodecheck}-->
					<!--{subtemplate forum/seccheck_post}-->					
				<!--{/if}-->
			</div>
		</div>
	</div>
	<!--{hook/post_infloat_middle}-->
	<div class="o pns" id="moreconf">
		<!--{if $_GET[action] == 'newthread' && $_G['setting']['sitemessage'][newthread] || $_GET[action] == 'reply' && $_G['setting']['sitemessage'][reply]}-->
			<a href="javascript:;" id="custominfo" class="y" style="margin-left:5px"><img src="{IMGDIR}/info_small.gif" alt="{lang faq}" /></a>
		<!--{/if}-->
		<a href="home.php?mod=spacecp&ac=credit&op=rule&fid=$_G[fid]" class="y" target="_blank">{lang post_credits_rule}</a>
		<button type="submit" id="postsubmit" class="pn pnc z" value="true"{if !$seccodecheck} onmouseover="checkpostrule('seccheck_$_GET[action]', 'ac=$_GET[action]&infloat=yes&handlekey=$_GET[handlekey]');this.onmouseover=null"{/if} name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{/if}" tabindex="23"><span><!--{if $_GET[action] == 'newthread'}-->{lang post_newthread}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{/if}--></span></button>
		<!--{hook/post_infloat_btn_extra}-->
	</div>
</form>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET[action](locationhref, message) {
	<!--{if $_GET[action] == 'reply'}-->
		try {
			var pid = locationhref.lastIndexOf('#pid');
			if(pid != -1) {
				pid = locationhref.substr(pid + 4);
				ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=' + pid<!--{if $_GET['from']}--> + '&from=$_GET[from]'<!--{/if}-->, 'post_new', 'ajaxwaitid', '', null, 'appendreply()');
				if(replyreload) {
					var reloadpids = replyreload.split(',');
					for(i = 1;i < reloadpids.length;i++) {
						ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=' + reloadpids[i]<!--{if $_GET['from']}--> + '&from=$_GET[from]'<!--{/if}-->, 'post_' + reloadpids[i]);
					}
				}
			} else {
				showDialog(message, 'notice', '', 'location.href="' + locationhref + '"');
			}
		} catch(e) {
			location.href = locationhref;
		}
	<!--{elseif $_GET[action] == 'newthread'}-->
		var hastid = locationhref.lastIndexOf('tid=');
		if(hastid == -1) {
			showDialog(message, 'notice', '', 'location.href="' + locationhref + '"');
		} else {
			location.href = locationhref;
		}
	<!--{/if}-->
	hideWindow('$_GET[action]');
}
<!--{if $_GET[action] == 'newthread' && $_G['setting']['sitemessage'][newthread] || $_GET[action] == 'reply' && $_G['setting']['sitemessage'][reply]}-->
	showPrompt('custominfo', 'mouseover', '<!--{if $_GET[action] == 'newthread'}--><!--{echo trim($_G['setting']['sitemessage'][newthread][array_rand($_G['setting']['sitemessage'][newthread])])}--><!--{elseif $_GET[action] == 'reply'}--><!--{echo trim($_G['setting']['sitemessage'][reply][array_rand($_G['setting']['sitemessage'][reply])])}--><!--{/if}-->', $_G['setting']['sitemessage'][time]);
<!--{/if}-->

	if($('subjectbox')) {
		$('postmessage').focus();
	} else if($('subject')) {
		$('subject').select();
		$('subject').focus();
	}
</script>

<!--{template common/footer}-->