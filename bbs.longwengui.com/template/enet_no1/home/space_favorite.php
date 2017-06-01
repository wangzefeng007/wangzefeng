<?php exit;?>
<!--{if empty($diymode)}-->
<!--{template common/header}-->
<style id="diy_style" type="text/css"></style>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div id="ct" class="ct7_a wp cl">
<div class="apps">
		<div class="tbn" style="margin:0">
			<h2 class="mt">{lang favorite}</h2>
			<ul>
				<li$actives[all]><a href="home.php?mod=space&do=favorite&type=all">{lang favorite_all}</a></li>
				<li$actives[thread]><a href="home.php?mod=space&do=favorite&type=thread">{lang favorite_thread}</a></li>
				<li$actives[forum]><a href="home.php?mod=space&do=favorite&type=forum">{lang favorite_forum}</a></li>
				<!--{if helper_access::check_module('group')}--><li$actives[group]><a href="home.php?mod=space&do=favorite&type=group">{lang favorite_group}</a></li><!--{/if}-->
				<!--{if helper_access::check_module('blog')}--><li$actives[blog]><a href="home.php?mod=space&do=favorite&type=blog">{lang favorite_blog}</a></li><!--{/if}-->
				<!--{if helper_access::check_module('album')}--><li$actives[album]><a href="home.php?mod=space&do=favorite&type=album">{lang favorite_album}</a></li><!--{/if}-->
				<!--{if helper_access::check_module('portal')}--><li$actives[article]><a href="home.php?mod=space&do=favorite&type=article">{lang favorite_article}</a></li><!--{/if}-->
				<!--{hook/space_favorite_nav_extra}-->
			</ul>
		</div>
</div>
	<div class="mn">
		<!--[diy=diycontenttop]--><div id="diycontenttop" class="area"></div><!--[/diy]-->
		<div class="bm bw0">
			<h1 class="mt bbs">
				<img alt="favorite" src="{STATICURL}image/feed/favorite.gif" class="vm" />
				<!--{if $_GET[type] == "thread"}-->{lang favorite_thread}
				<!--{elseif $_GET[type] == "forum"}-->{lang favorite_forum}
				<!--{elseif $_GET[type] == "group"}-->{lang favorite_group}
				<!--{elseif $_GET[type] == "blog"}-->{lang favorite_blog}
				<!--{elseif $_GET[type] == "album"}-->{lang favorite_album}
				<!--{elseif $_GET[type] == "article"}-->{lang favorite_article}
				<!--{else}-->{lang favorite_all}</a><!--{/if}-->
			</h1>

<!--{else}-->
<!--{template home/space_header}-->
	<div id="ct" class="wp n cl">
		<div class="mn">
			<div class="bm">
				<h1 class="mt">{lang favorite}</h1>
<!--{/if}-->
			<!--{if $list}-->
			<form method="post" autocomplete="off" name="delform" id="delform" action="home.php?mod=spacecp&ac=favorite&op=delete&type=$_GET[type]&checkall=1" onsubmit="showDialog('{lang del_select_favorite_confirm}', 'confirm', '', '$(\'delform\').submit();'); return false;">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="delfavorite" value="true" />
			<ul id="favorite_ul" class="">
				<!--{loop $list $k $value}-->
				<li id="fav_$k" class="bbda ptm pbm">
					<a class="y" id="a_delete_$k" href="home.php?mod=spacecp&ac=favorite&op=delete&favid=$k" onclick="showWindow(this.id, this.href, 'get', 0);">{lang delete}</a>
					<input type="checkbox" name="favorite[]" class="pc" value="$k" vid="$value[id]" />
					<!--{if $_GET['type'] == 'all'}--><span>$value[icon]</span><!--{/if}-->
					<a href="$value[url]" target="_blank">$value[title]</a> <span class="xg1"><!--{date($value[dateline], 'u')}--></span>
					<!--{if $value[description]}-->
					<div class="quote">
						<blockquote id="quote_preview">$value[description]</blockquote>
					</div>
					<!--{/if}-->
				</li>
				<!--{/loop}-->
			</ul>
			<p class="mtm pns">
				<label for="chkall" onclick="checkall(this.form, 'favorite')"><input type="checkbox" name="chkall" id="chkall" class="pc vm" />{lang select_all}</label>
				<button type="submit" name="delsubmit" value="true" class="pn vm"><em>{lang del_favorite}</em></button>
				<!--{if $_GET[type] == "thread"}-->
					<button type="button" name="collectionsubmit" value="true" class="pnc pn vm" onclick="collection_favorite()"><em>{lang collection_favorite}</em></button>
				<!--{/if}-->
			</p>
			</form>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
			<!--{else}-->
			<p class="emp">{lang no_favorite_yet}</p>
			<!--{/if}-->
<!--{if empty($diymode)}-->
		</div>
		<!--[diy=diycontentbottom]--><div id="diycontentbottom" class="area"></div><!--[/diy]-->
	</div>
</div>

<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<!--{else}-->
		</div>
	</div>
</div>
<!--{/if}-->
<script type="text/javascript">
	function favorite_delete(favid) {
		var el = $('fav_' + favid);
		if(el) {
			el.style.display = "none";
		}
	}
	<!--{if $_GET[type] == "thread"}-->
	function collection_favorite() {
		var form = $('delform');
		var prefix = '^favorite';
		var tids = '';
		for(var i = 0; i < form.elements.length; i++) {
			var e = form.elements[i];		
			if(e.name.match(prefix) && e.checked) {
				tids += 'tids[]=' + e.getAttribute('vid') + '&';
			}
		}
		if(tids) {
			showWindow(null, 'forum.php?mod=collection&action=edit&op=addthread&' + tids);
		}
	}
	function update_collection() {}
	<!--{/if}-->
</script>
<!--{template common/footer}-->
