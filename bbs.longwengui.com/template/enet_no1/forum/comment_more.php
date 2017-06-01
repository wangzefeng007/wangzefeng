<?php exit;?>
<!--{template common/header}-->
<!--{if $comments}-->
	<div class="cmtl xld" style="padding-left: 22px;margin-bottom: 10px;border: 1px solid #C2D5E3;border-radius: 5px;padding-top: 5px;padding-bottom: 5px;position:relative">
	<span class="icon_preview" style="top: -7px;left: 27px"></span>
	<!--{if $totalcomment}--><div class="mbm">$totalcomment[$post[pid]]</div><!--{/if}-->
	<!--{loop $comments $comment}-->
				<dl class="cl">
					<dd class="m"><a href="home.php?mod=space&uid=$comment[authorid]" class="avt">$comment[avatar]</a></dd>
					<dt style="font-weight:100">
						<!--{if $comment['authorid']}-->
						<a href="home.php?mod=space&uid=$comment[authorid]" class="xi2 xw1">$comment[author]</a>
						<!--{else}-->
						{lang guest}
						<!--{/if}-->
						<span class="xg1">
							{lang poston} <!--{date($comment[dateline], 'u')}-->
							<!--{if $comment['useip'] && $_G['group']['allowviewip']}-->&nbsp;IP:$comment[useip]<!--{/if}-->
							<!--{if $comment[rpid]}-->
								&nbsp;<a href="forum.php?mod=redirect&goto=findpost&pid=$comment[rpid]&ptid=$_G[tid]">{lang detail}</a>
								&nbsp;<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$comment[rpid]&extra=$_GET[extra]&page=$page{if $_GET[from]}&from=$_GET[from]{/if}" onclick="showWindow('reply', this.href)">{lang reply}</a>
							<!--{/if}-->
							<!--{if $_G['forum']['ismoderator'] && $_G['group']['allowdelpost']}-->&nbsp;<a href="javascript:;" onclick="modaction('delcomment', $comment[id])">{lang delete}</a><!--{/if}-->
						</span>
					</dt>
					<dd>$comment[comment]</dd>
				</dl>
	<!--{/loop}-->
	</div>
<!--{/if}-->
<!--{template common/footer}-->