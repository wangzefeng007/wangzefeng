<?php exit;?>
<!--{if $list}-->
<ul>
<!--{loop $list $value}-->
	<!--{if $value[uid]}-->
	<div class="ptn p_box pbn{$value['class']}" style="$value[style]">
	    <a href="home.php?mod=space&uid=$value[uid]" class="p_avt"><!--{avatar($value[uid],small)}--></a>
		<div style="padding-left:43px">
		<div>
		<a href="home.php?mod=space&uid=$value[uid]" class="lit">$value[username]</a><span class="xg1"> {lang reply} </span> $value[message] <span id="pipe"></span>
		<!--{if $_G[uid] && helper_access::check_module('doing')}-->
		<a href="javascript:;" onclick="docomment_form($value[doid], $value[id], '$_GET[key]');">{lang reply}</a>
		<!--{/if}-->
		<!--{if $value[uid]==$_G[uid] || $dv['uid']==$_G[uid] || checkperm('managedoing')}-->
			 <a href="home.php?mod=spacecp&ac=doing&op=delete&doid=$value[doid]&id=$value[id]&handlekey=doinghk_{$value[doid]}_$value[id]" id="{$_GET[key]}_doing_delete_{$value[doid]}_{$value[id]}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a>
		<!--{/if}-->
		<!--{if checkperm('managedoing')}-->
		<span class="xg1 xw0">IP: $value[ip]</span>
		<!--{/if}-->
		</div>
		<div class="xg1" style="margin-top:3px"><!--{date($value['dateline'], 'n-j H:i')}--></div>
		<div id="{$_GET[key]}_form_{$value[doid]}_{$value[id]}"></div>
		</div>
	</div>
	<!--{/if}-->
<!--{/loop}-->
</ul>
<!--{/if}-->
<div class="tri"></div>