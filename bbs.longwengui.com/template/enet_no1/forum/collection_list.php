<?php exit;?>
<!--{if count($collectiondata) > 0}-->
<div class="clct_list cl">
	<!--{loop $collectiondata $collectionvalues}-->
	<div class="xld xlda cl">
		<dl style="padding-left:65px">
			<dd class="m hm" style="margin-left:-65px;height:150px;position: absolute">
					<strong class="xi2" {if {$collectionvalues['displaynum']} > 999999}style="font-size: 10px;"{/if}>{$collectionvalues['displaynum']}</strong>
					<span><!--{if $orderby=='commentnum'}-->{lang collection_commentnum}<!--{elseif $orderby=='follownum'}-->{lang collection_follow}<!--{else}-->{lang collection_threadnum}<!--{/if}--></span>
				<!--{if $op == 'my'}-->
					<!--{if $collectionvalues['uid'] == $_G['uid']}-->
						<span class="ctag ctag0" style="margin-top:10px">{lang collection_mycreate}</span>
					<!--{elseif in_array($collectionvalues['ctid'], $twctid)}-->
						<span class="ctag ctag1" style="margin-top:10px">{lang collection_myteam}</span>
					<!--{else}-->
						<span class="ctag ctag2" style="margin-top:10px">{lang collection_mysubscribe}</span>
					<!--{/if}-->
				<!--{/if}-->
			</dd>
			<dt class="xw1">
				<div>
					<a href="forum.php?mod=collection&action=view&ctid={$collectionvalues['ctid']}{if $op}&fromop={$op}{/if}{if $tid}&fromtid={$tid}{/if}" style="font-size:14px;font-weight:100" class="xi2" {if $collectionvalues['updated'] && $op == 'my'}style='color:red;'{/if}>{$collectionvalues['name']}</a>
					<!--{if $collectionvalues['arraykeyword']}-->
					<span class="ctag_keyword">
						<!--{eval $keycount=0;}-->
						<!--{loop $collectionvalues['arraykeyword'] $unique_keyword}-->
							{if $keycount},&nbsp;{/if}<a href="search.php?mod={if $_G['setting']['search']['collection']['status']}collection{else}forum{/if}&srchtxt={echo rawurlencode($unique_keyword)}&formhash={FORMHASH}&searchsubmit=true&source=collectionsearch" target="_blank" class="xi2">$unique_keyword</a>
							<!--{eval $keycount++;}-->
						<!--{/loop}-->
					</span>
						<!--{/if}-->
				</div>
			</dt>
			<dd>
				<p>{$collectionvalues['shortdesc']}</p>
				<p>
				<!--{if $orderby=='commentnum'}-->
					{lang collection_follow} {$collectionvalues['follownum']}, {lang collection_threadnum} {$collectionvalues['threadnum']}
				<!--{elseif $orderby=='follownum'}-->
					{lang collection_threadnum} {$collectionvalues['threadnum']}, {lang collection_commentnum} {$collectionvalues['commentnum']}
				<!--{else}-->
					{lang collection_follow} {$collectionvalues['follownum']}, {lang collection_commentnum} {$collectionvalues['commentnum']}
				<!--{/if}-->
				</p>
				<p class="xg1"><a href="home.php?mod=space&uid=$collectionvalues['uid']">{$collectionvalues['username']}</a> {lang collection_createtime}, {lang collection_lastupdate} {$collectionvalues['lastupdate']}</p>
				<p>
					<!--{if $collectionvalues['lastpost']}-->
					{lang collection_lastthread} <a href="forum.php?mod=viewthread&tid={$collectionvalues['lastpost']}" class="xi2">{$collectionvalues['lastsubject']}</a>
					<!--{/if}-->
				</p>
			</dd>
		</dl>
	</div>
	<!--{/loop}-->
</div>
<!--{else}-->
	<div class="emp">{lang collection_nocollection}</div>
<!--{/if}-->