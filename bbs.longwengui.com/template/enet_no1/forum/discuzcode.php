<?php exit;?>
<!--{eval}-->
<!--
function tpl_hide_credits_hidden($creditsrequire) {
	global $_G;
-->
<!--{/eval}-->
<!--{block return}--><div class="locked"><!--{if $_G[uid]}-->{$_G[username]}<!--{else}-->{lang guest}<!--{/if}-->{lang post_hide_credits_hidden}</div><!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function tpl_hide_credits($creditsrequire, $message) {
-->
<!--{/eval}-->
<!--{block return}--><div class="locked">{lang post_hide_credits}</div>
$message<br /><br />
<!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function tpl_codedisp($code) {
	$randomid = 'code_'.random(3);
-->
<!--{/eval}-->
<!--{block return}--><div class="blockcode"><div id="$randomid"><ol><li>$code</ol></div><em onclick="copycode($('$randomid'));">{lang discuzcode_copyclipboard}</em></div><!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function tpl_quote() {
-->
<!--{/eval}-->
<!--{block return}--><div class="quote"><blockquote>\\1</blockquote></div><!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function tpl_free() {
-->
<!--{/eval}-->
<!--{block return}--><div class="quote"><blockquote>\\1</blockquote></div><!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function tpl_hide_reply() {
	global $_G;
-->
<!--{/eval}-->
<!--{block return}--><div class="showhide"><h4>{lang post_hide}</h4>\\1</div>
<!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function tpl_hide_reply_hidden() {
	global $_G;
-->
<!--{/eval}-->
<!--{block return}--><div class="locked"><!--{if $_G[uid]}-->{$_G[username]}<!--{else}-->{lang guest}<!--{/if}-->{lang post_hide_reply_hidden}</div><!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function attachlist($attach) {
	global $_G;
	$attach['refcheck'] = (!$attach['remote'] && $_G['setting']['attachrefcheck']) || ($attach['remote'] && ($_G['setting']['ftp']['hideurl'] || ($attach['isimage'] && $_G['setting']['attachimgpost'] && strtolower(substr($_G['setting']['ftp']['attachurl'], 0, 3)) == 'ftp')));
	$aidencode = packaids($attach);
	$widthcode = attachwidth($attach['width']);
	$is_archive = $_G['forum_thread']['is_archived'] ? "&fid=".$_G['fid']."&archiveid=".$_G[forum_thread][archiveid] : '';
	$pluginhook = !empty($_G['setting']['pluginhooks']['viewthread_attach_extra'][$attach[aid]]) ? $_G['setting']['pluginhooks']['viewthread_attach_extra'][$attach[aid]] : '';
-->
<!--{/eval}-->
<!--{block return}-->
<ignore_js_op>
	<dl class="tattl">
		<dt>
			$attach[attachicon]
		</dt>
		<dd>
			<p class="attnm">
				<!--{if !$attach['price'] || $attach['payed']}-->
					<a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode" {if $_GET['from'] != 'preview'}onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})"{/if} id="aid$attach[aid]" target="_blank">$attach[filename]</a>
				<!--{else}-->
					<a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]" onclick="showWindow('attachpay', this.href)">$attach[filename]</a>
				<!--{/if}-->
				<div class="tip tip_4" id="aid$attach[aid]_menu" style="display: none" disautofocus="true">
					<div class="tip_c">
						<p class="y">$attach[dateline] {lang upload}</p>
						<p>{lang clicktodownload}</p>
						<!--{if !$attach['attachimg'] && $_G['getattachcredits']}-->{lang attachcredits}: $_G[getattachcredits]<br /><!--{/if}-->
					</div>
					<div class="tip_horn"></div>
				</div>
			</p>
			<p>$attach[attachsize]<!--{if $attach['readperm']}-->, {lang readperm}: <strong>$attach[readperm]</strong><!--{/if}-->, {lang downloads}: $attach[downloads]<!--{if !$attach['attachimg'] && $_G['getattachcredits']}-->, {lang attachcredits}: $_G[getattachcredits]<!--{/if}--></p>
			<p>
				<!--{if $attach['price']}-->
					{lang price}: <strong>$attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}</strong> &nbsp;[<a href="forum.php?mod=misc&action=viewattachpayments&aid=$attach[aid]" onclick="showWindow('attachpay', this.href)" target="_blank">{lang pay_view}</a>]
					<!--{if !$attach['payed']}-->
						&nbsp;[<a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]" onclick="showWindow('attachpay', this.href)">{lang attachment_buy}</a>]
					<!--{/if}-->
				<!--{/if}-->
			</p>
			<!--{if $attach['description']}--><p class="xg2">{$attach[description]}</p><!--{/if}-->
			$pluginhook
		</dd>
	</dl>
</ignore_js_op>
<!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function imagelist($attach, $firstpost = 0) {
	global $_G;
	$attach['refcheck'] = (!$attach['remote'] && $_G['setting']['attachrefcheck']) || ($attach['remote'] && ($_G['setting']['ftp']['hideurl'] || ($attach['isimage'] && $_G['setting']['attachimgpost'] && strtolower(substr($_G['setting']['ftp']['attachurl'], 0, 3)) == 'ftp')));
	$aidencode = packaids($attach);
	$widthcode = attachwidth($attach['width']);
	$is_archive = $_G['forum_thread']['is_archived'] ? "&fid=".$_G['fid']."&archiveid=".$_G[forum_thread][archiveid] : '';
	$attachthumb = getimgthumbname($attach['attachment']);
	$pluginhook = !empty($_G['setting']['pluginhooks']['viewthread_attach_extra'][$attach[aid]]) ? $_G['setting']['pluginhooks']['viewthread_attach_extra'][$attach[aid]] : '';
	$guestviewthumb = !empty($_G['setting']['guestviewthumb']['flag']) && !$_G['uid'];
	if($guestviewthumb) {
		$guestviewthumbcss = guestviewthumbstyle();
	}
-->
<!--{/eval}-->
<!--{block return}-->
	<!--{if $attach['attachimg'] && $_G['setting']['showimages'] && (($_G['group']['allowgetimage'] || $_G['uid'] == $attach['uid']) || (($guestviewthumb)))}-->
	<ignore_js_op>
		<!--{if !IS_ROBOT}-->
			<dl class="tattl attm">
				<dt></dt>
				<dd>
					<!--{if !$guestviewthumb}-->
						<p class="mbn">
							<a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode&nothumb=yes" {if $_GET['from'] != 'preview'}onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})" id="aid$attach[aid]"{/if} class="xw1" target="_blank">$attach[filename]</a>
							<em class="xg1">($attach[attachsize], {lang downloads}: $attach[downloads])</em>
						</p>
						<div class="tip tip_4" id="aid$attach[aid]_menu" style="display: none" disautofocus="true">
							<div>
								<p>
									<a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode&nothumb=yes" target="_blank">{lang download}</a>
									<!--{if helper_access::check_module('album')}-->
										&nbsp;<a href="javascript:;" onclick="showWindow(this.id, this.getAttribute('url'), 'get', 0);" id="savephoto_$attach[aid]" url="home.php?mod=spacecp&amp;ac=album&amp;op=saveforumphoto&amp;aid=$attach[aid]&amp;handlekey=savephoto_$attach[aid]">{lang save_to_album}</a>
									<!--{/if}-->
									<!--{if $firstpost && $_G['fid'] && $_G['forum']['picstyle'] && ($_G['forum']['ismoderator'] || $_G['uid'] == $attach['uid'])}-->
										&nbsp;<a href="forum.php?mod=ajax&action=setthreadcover&aid=$attach[aid]&fid=$_G[fid]" onclick="showWindow('setcover{$attach[aid]}', this.href)">{lang set_cover}</a>
									<!--{/if}-->
								</p>
								<p>
									<span class="y">$attach[dateline] {lang upload}</span>
									<a href="javascript:;" onclick="imageRotate('aimg_$attach[aid]', 1)"><img src="{STATICURL}image/common/rleft.gif" class="vm" /></a>
									<a href="javascript:;" onclick="imageRotate('aimg_$attach[aid]', 2)"><img src="{STATICURL}image/common/rright.gif" class="vm" /></a>
								</p>
							</div>
							<div class="tip_horn"></div>
						</div>
						<p class="mbn">
							<!--{if $attach['readperm']}-->{lang readperm}: <strong>$attach[readperm]</strong><!--{/if}-->
							<!--{if $attach['price']}-->{lang price}: <strong>$attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}</strong> &nbsp;[<a href="forum.php?mod=misc&action=viewattachpayments&aid=$attach[aid]" onclick="showWindow('attachpay', this.href)" target="_blank">{lang pay_view}</a>]
								<!--{if !$attach['payed']}-->
									&nbsp;[<a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]" onclick="showWindow('attachpay', this.href)" target="_blank">{lang attachment_buy}</a>]
								<!--{/if}-->
							<!--{/if}-->
						</p>
						<!--{if $attach['description']}--><p class="mbn xg2">{$attach[description]}</p><!--{/if}-->
					<!--{/if}-->
					$pluginhook
					<!--{if $guestviewthumb}-->
						<!--{eval}-->
						<!--
							$thumbpath = helper_attach::attachpreurl().'image/'.helper_attach::makethumbpath($attach['aid'], $_G['setting']['guestviewthumb']['width'], $_G['setting']['guestviewthumb']['height']);
							$makefile = 'forum.php?mod=image&aid='.$attach['aid'].'&size='.$_G['setting']['guestviewthumb']['width'].'x'.$_G['setting']['guestviewthumb']['height'].'&key='.dsign($attach['aid'].'|'.$_G['setting']['guestviewthumb']['width'].'|'.$_G['setting']['guestviewthumb']['height']).'&type=1';
						-->
						<!--{/eval}-->
						{$guestviewthumbcss}
						<div class="guestviewthumb">
							<img id="aimg_$attach[aid]" class="guestviewthumb_cur" aid="$attach[aid]" src="{STATICURL}image/common/none.gif" onclick="showWindow('login', 'member.php?mod=logging&action=login'+'&referer='+encodeURIComponent(location))" onerror="javascript:if(this.getAttribute('makefile')){this.src=this.getAttribute('makefile'); this.removeAttribute('makefile');}" file="$thumbpath" makefile="$makefile" alt="$attach[imgalt]" title="$attach[imgalt]"/>
							<br>
							<a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href+'&referer='+encodeURIComponent(location));">{lang guestviewthumb}</a>
						</div>
					<!--{elseif !$attach['price'] || $attach['payed']}-->
						<div class="mbn savephotop">
						<!--{if $_G['setting']['thumbstatus'] && $attach['thumb']}-->
							<a href="javascript:;"><img id="aimg_$attach[aid]" aid="$attach[aid]" src="{STATICURL}image/common/none.gif" onclick="zoom(this, this.getAttribute('zoomfile'), 0, 0, '{$_G[setting][showexif]}')" zoomfile="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes&nothumb=yes{else}{$attach[url]}$attach[attachment]{/if}" file="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode{else}{$attach[url]}$attachthumb{/if}" alt="$attach[imgalt]" title="$attach[imgalt]" w="$attach[width]" /></a>
						<!--{else}-->
							<img id="aimg_$attach[aid]" aid="$attach[aid]" src="{STATICURL}image/common/none.gif" zoomfile="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes&nothumb=yes{else}{$attach[url]}$attach[attachment]{/if}" file="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes{else}{$attach[url]}$attach[attachment]{/if}" $widthcode alt="$attach[imgalt]" title="$attach[imgalt]" w="$attach[width]" />
						<!--{/if}-->
						</div>
					<!--{/if}-->
				</dd>
			</dl>
		<!--{else}-->
			<dl class="tattl attm">
			<!--{if !$attach['price'] || $attach['payed']}-->
				<dd>
					<!--{if $attach['description']}--><p>{$attach[description]}</p><!--{/if}-->
					<img src="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes{else}{$attach[url]}$attach[attachment]{/if}" alt="$attach[imgalt]" title="$attach[imgalt]" />
				</dd>
			<!--{/if}-->
			</dl>
		<!--{/if}-->
	</ignore_js_op>
	<!--{/if}-->
<!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}

function attachinpost($attach, $post) {
	global $_G;
	$firstpost = $post['first'];
	$attach['refcheck'] = (!$attach['remote'] && $_G['setting']['attachrefcheck']) || ($attach['remote'] && ($_G['setting']['ftp']['hideurl'] || ($attach['isimage'] && $_G['setting']['attachimgpost'] && strtolower(substr($_G['setting']['ftp']['attachurl'], 0, 3)) == 'ftp')));
	$aidencode = packaids($attach);
	$widthcode = attachwidth($attach['width']);
	$is_archive = $_G['forum_thread']['is_archived'] ? '&fid='.$_G['fid'].'&archiveid='.$_G[forum_thread][archiveid] : '';
	$attachthumb = getimgthumbname($attach['attachment']);
	$musiccode = getstatus($post[status], 7) && fileext($attach['attachment']) == 'mp3' ? (browserversion('ie') > 8 || browserversion('safari') ? '<audio controls="controls"><source src="'.$attach['url'].$attach['attachment'].'"></audio>' : parseaudio($attach['url'].$attach['attachment'], 400)) : '';
	$guestviewthumb = !empty($_G['setting']['guestviewthumb']['flag']) && !$_G['uid'];
	if($guestviewthumb) {
		$guestviewthumbcss = guestviewthumbstyle();
	}
-->
<!--{/eval}-->
<!--{block return}-->
<ignore_js_op>
	<!--{if $attach['attachimg'] && $_G['setting']['showimages'] && (((!$attach['price'] || $attach['payed']) && ($_G['group']['allowgetimage'] || $_G['uid'] == $attach['uid'])) || (($guestviewthumb)))}-->
		<!--{if !IS_ROBOT}-->
				<!--{if $guestviewthumb}-->
					<!--{eval}-->
					<!--
						$thumbpath = helper_attach::attachpreurl().'image/'.helper_attach::makethumbpath($attach['aid'], $_G['setting']['guestviewthumb']['width'], $_G['setting']['guestviewthumb']['height']);
						$makefile = 'forum.php?mod=image&aid='.$attach['aid'].'&size='.$_G['setting']['guestviewthumb']['width'].'x'.$_G['setting']['guestviewthumb']['height'].'&key='.dsign($attach['aid'].'|'.$_G['setting']['guestviewthumb']['width'].'|'.$_G['setting']['guestviewthumb']['height']).'&type=1';
					-->
					<!--{/eval}-->
					{$guestviewthumbcss}
					<div class="guestviewthumb">
						<div style="margin: 0 auto;">
							<img id="aimg_$attach[aid]" class="guestviewthumb_cur" aid="$attach[aid]" src="{STATICURL}image/common/none.gif" onclick="showWindow('login', 'member.php?mod=logging&action=login'+'&referer='+encodeURIComponent(location))" onerror="javascript:if(this.getAttribute('makefile')){this.src=this.getAttribute('makefile'); this.removeAttribute('makefile');}" file="$thumbpath" makefile="$makefile" inpost="1" alt="$attach[imgalt]" title="$attach[imgalt]"/>
							<br>
							<a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href+'&referer='+encodeURIComponent(location));">{lang guestviewthumb}</a>
						</div>
					</div>
				<!--{else}-->
					<!--{if $_G['setting']['thumbstatus'] && $attach['thumb']}-->
						<img{if $attach['price'] && $_G['forum_attachmentdown'] && $_G['uid'] != $attach['uid']} class="attprice"{/if} style="cursor:pointer" id="aimg_$attach[aid]" aid="$attach[aid]" src="{STATICURL}image/common/none.gif" onclick="zoom(this, this.getAttribute('zoomfile'), 0, 0, '{$_G[setting][showexif]}')" zoomfile="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes&nothumb=yes{else}{$attach[url]}$attach[attachment]{/if}" file="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode{else}{$attach[url]}$attachthumb{/if}" inpost="1"{if $_GET['from'] != 'preview'} onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})"{/if} />
					<!--{else}-->
						<img{if $attach['price'] && $_G['forum_attachmentdown'] && $_G['uid'] != $attach['uid']} class="attprice"{/if} id="aimg_$attach[aid]" aid="$attach[aid]" src="{STATICURL}image/common/none.gif" zoomfile="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes&nothumb=yes{else}{$attach[url]}$attach[attachment]{/if}" file="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes{else}{$attach[url]}$attach[attachment]{/if}" $widthcode id="aimg_$attach[aid]" inpost="1"{if $_GET['from'] != 'preview'} onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})"{/if} />
					<!--{/if}-->
				<!--{/if}-->
			<div class="tip tip_4 aimg_tip" id="aimg_$attach[aid]_menu" style="position: absolute; display: none" disautofocus="true">
				<div class="xs0">
					<p><strong>$attach[filename]</strong> <em class="xg1">($attach[attachsize], {lang downloads}: $attach[downloads])</em></p>
					<p>
						<a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode&nothumb=yes" target="_blank">{lang download}</a>
						<!--{if helper_access::check_module('album')}-->
							&nbsp;<a href="javascript:;" onclick="showWindow(this.id, this.getAttribute('url'), 'get', 0);" id="savephoto_$attach[aid]" url="home.php?mod=spacecp&amp;ac=album&amp;op=saveforumphoto&amp;aid=$attach[aid]&amp;handlekey=savephoto_$attach[aid]">{lang save_to_album}</a>
						<!--{/if}-->
						<!--{if $firstpost && $_G['fid'] && $_G['forum']['picstyle'] && ($_G['forum']['ismoderator'] || $_G['uid'] == $attach['uid'])}-->
							&nbsp;<a href="forum.php?mod=ajax&action=setthreadcover&aid=$attach[aid]&fid=$_G[fid]" onclick="showWindow('setcover{$attach[aid]}', this.href)">{lang set_cover}</a>
						<!--{/if}-->
					</p>
					<!--{if $attach[description]}--><p>$attach[description]</p><!--{/if}-->
					<p class="xg1 y">$attach[dateline] {lang upload}</p>
		<!--{else}-->
			<!--{if $attach['description']}--><p>{$attach[description]}</p><!--{/if}-->
			<img src="{if $attach[refcheck]}forum.php?mod=attachment{$is_archive}&aid=$aidencode&noupdate=yes{else}{$attach[url]}$attach[attachment]{/if}" alt="$attach[imgalt]" title="$attach[imgalt]" />
		<!--{/if}-->
	<!--{else}-->
		<!--{if $musiccode}-->
			<div>$musiccode</div>
		<!--{/if}-->
		$attach[attachicon]
		<span style="white-space: nowrap" id="attach_$attach[aid]" {if $_GET['from'] != 'preview'}onmouseover="showMenu({'ctrlid':this.id,'pos':'12'})"{/if}>
			<!--{if !$attach['price'] || $attach['payed']}-->
				<a href="forum.php?mod=attachment{$is_archive}&aid=$aidencode" target="_blank">$attach[filename]</a>
			<!--{else}-->
				<a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]" onclick="showWindow('attachpay', this.href)">$attach[filename]</a>
			<!--{/if}-->
			<em class="xg1">($attach[attachsize], {lang downloads}: $attach[downloads]<!--{if $attach['price']}-->, {lang price}: $attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}<!--{/if}-->)</em>
		</span>
		<div class="tip tip_4" id="attach_$attach[aid]_menu" style="position: absolute; display: none" disautofocus="true">
			<div class="tip_c xs0">
				<div class="y">$attach[dateline] {lang upload}</div>
				{lang clicktodownload}
				<!--{if $attach['description']}--><br />$attach[description]<!--{/if}-->
				<!--{if $attach['readperm']}--><br />{lang readperm}: $attach[readperm]<!--{/if}-->
	<!--{/if}-->
	<!--{if !IS_ROBOT && !$guestviewthumb}-->
		<!--{if $attach['price']}-->
			<br />{lang price}: $attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}	&nbsp;<a href="forum.php?mod=misc&action=viewattachpayments&aid=$attach[aid]" onclick="showWindow('attachpay', this.href)" target="_blank">[{lang pay_view}]</a>
			<!--{if !$attach['payed']}-->
				&nbsp;[<a href="forum.php?mod=misc&action=attachpay&aid=$attach[aid]&tid=$attach[tid]" onclick="showWindow('attachpay', this.href)" target="_blank">{lang attachment_buy}</a>]
			<!--{/if}-->
		<!--{/if}-->
		<!--{if !$attach['attachimg'] && $_G['getattachcredits']}--><br />{lang attachcredits}: $_G[getattachcredits]<!--{/if}-->
				</div>
				<div class="tip_horn"></div>
			</div>
		<!--{if $musiccode}-->
			<br />
		<!--{/if}-->
	<!--{/if}-->
</ignore_js_op>
<!--{/block}-->
<!--{eval}-->
<!--
	return $return;
}
-->
<!--{/eval}-->
