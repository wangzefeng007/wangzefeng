<?php exit;?>
<!--{if count($list)-1 == $key && empty($lastanchor)}--><a name="last"></a><!--{eval $lastanchor=1;}--><!--{/if}-->
<dl id="pmlist_$value[pmid]" class="bbda cl">
	<!--{if $value['pmtype'] == 1 || $value['authorid'] && $value['authorid'] != $_G['uid'] && $_G['setting']['pmreportuser']}-->
	<dd class="y mtm pm_o">
		<a href="javascript:;" id="pm_o_$value[pmid]" class="o" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34'})">{lang menu}</a>
		<div id="pm_o_$value[pmid]_menu" class="p_pop" style="display: none;">
			<ul>
			<!--{if $value['pmtype'] == 1}-->
				<li><a href="javascript:;" id="a_pmdelete_$value[pmid]" onclick="ajaxget('home.php?mod=spacecp&ac=pm&op=delete&deletepm_pmid[]=$value[pmid]&touid=$touid&deletesubmit=1&handlekey=pmdeletehk_{$value[pmid]}', '', 'ajaxwaitid', '', 'none', 'changedeletedpm($value[pmid])');" title="{lang delete}">{lang delete}</a></li>
			<!--{/if}-->
			<!--{if $value['authorid'] && $value['authorid'] != $_G['uid'] && $_G['setting']['pmreportuser']}-->
				<li><a href="home.php?mod=spacecp&ac=pm&op=pm_report&pmid=$value[pmid]&handlekey=pmreporthk_{$value[pmid]}" id="a_pmreport_$value[pmid]" onclick="showWindow(this.id, this.href, 'get', 0);" title="{lang pmreport}">{lang pmreport}</a></li>
			<!--{/if}-->
			</ul>
		</div>
	</dd>
	<!--{/if}-->
	<dd class="m avt" {if count($list)-1 == $key}id="bottom"{/if}>
		<!--{if $value[authorid]}-->
		<a href="home.php?mod=space&uid=$value[authorid]" target="_blank"><!--{avatar($value[authorid],small)}--></a>
		<!--{/if}-->
	</dd>
	<dd class="ptm">
		<!--{if $value[authorid]}-->
			<!--{if $value[authorid] == $_G[uid]}-->
				<span class="xi2 xw1">{lang you}</span>
			<!--{else}-->
				<a href="home.php?mod=space&uid=$value[authorid]" target="_blank" class="xw1">{$value[author]}</a>
			<!--{/if}-->
			 &nbsp; 
		<!--{/if}--><br />
		$value[message]<br />
		<span class="xg1"><!--{date($value[dateline], 'u')}--></span>
	</dd>
	
</dl>