<?php exit;?>
<!--{template common/header}-->
<!--{if ($op == 'manual')}-->
	<!--{if $ra}-->
		<li id="$ra[aid]">
			<em>$ra[title]</em>
			<span class="xg1">
				<a href="javascript:;" onclick="uparticle($ra[aid]);" title="{lang move_up}"><img class="vm" src="{IMGDIR}/icon_top.gif" alt="{lang move_up}" /></a>
				<a href="javascript:;" onclick="downarticle($ra[aid]);" title="{lang move_down}"><img class="vm" src="{IMGDIR}/icon_down.gif" alt="{lang move_down}" /></a>
				<a href="javascript:;" onclick="delarticle($ra[aid]);" title="{lang delete}"><img class="vm" src="{IMGDIR}/data_invalid.gif" alt="{lang delete}" /></a>
			</span>
		</li>
	<!--{/if}-->
<!--{elseif ($op == 'get')}-->
	<!--{loop $articlelist $list}-->
		<li id="$list[aid]">
			<em>$list[title]</em>
			<span class="xg1">
				<a href="javascript:;" onclick="uparticle($list[aid]);" title="{lang move_up}"><img class="vm" src="{IMGDIR}/icon_top.gif" alt="{lang move_up}" /></a>
				<a href="javascript:;" onclick="downarticle($list[aid]);" title="{lang move_down}"><img class="vm" src="{IMGDIR}/icon_down.gif" alt="{lang move_down}" /></a>
				<a href="javascript:;" onclick="delarticle($list[aid]);" title="{lang delete}"><img class="vm" src="{IMGDIR}/data_invalid.gif" alt="{lang delete}" /></a>
			</span>
		</li>
	<!--{/loop}-->
<!--{elseif ($op == 'search')}-->
	<!--{loop $articlelist $list}-->
		<li>
			<input type="checkbox" name="article" id="article_$list[aid]_pc" class="pc" value="$list[aid]" onclick="getarticlenum();"/>
			<label for="article_$list[aid]_pc" id="article_$list[aid]">$list[title]</label>
		</li>
	<!--{/loop}-->
<!--{elseif ($op == 'add')}-->
	<!--{loop $articlelist $ra}-->
		<li id="raid_li_$ra[aid]">
			<input type="hidden" name="raids[]" value="$ra[aid]" size="5">
			<a href="{echo fetch_article_url($ra);}" target="_blank">$ra[title]</a>
			({lang article_id}: $ra[aid])
			<a href="javascript:;" onclick="raid_delete($ra[aid]);" class="xg1">{lang delete}</a>
		</li>
	<!--{/loop}-->
<!--{else}-->
	<h3 class="flb">
		<em>{lang manage_related_article}</em>
		<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
	</h3>
	<div class="c bart">
		<div class="pns cl">
			<div class="y">
				{lang article_id}:
				<input type="text" name="manualid" id="manualid" class="px vm" value="0" size="10" />&nbsp;
				<button type="button" name="raid_button" class="pn" value="false" onclick="manualadd();"><em>{lang add_by_self}</em></button>
			</div>
			{$category}&nbsp;
			<input type="text" name="searchkey" id="searchkey" class="px vm" value="$searchkey" size="10" />&nbsp;
			<button type="button" name="search_button" class="pn vm" value="false" onclick="articlesearch();"><em>{lang search}</em></button>
		</div>
		<div class="cl">
			<div class="z" id="chkalldiv">
				<p class="mtm mbn cl">
					<span class="xg1 y">{lang wait_select}(<span id="articlenum">0</span>/<span id="articlenumall">$count</span> {lang max_wait_select})</span>
					<label class="chkall"><input type="checkbox" name="chkall" id="chkall" class="pc" value="" onclick="selectall();"/>{lang select_all}</label>
				</p>
				<ul id="articlelist" class="bartl">
				<!--{loop $articlelist $list}-->
					<li>
						<input type="checkbox" name="article" id="article_$list[aid]_pc" class="pc" value="$list[aid]" onclick="getarticlenum();"/><label for="article_$list[aid]_pc" id="article_$list[aid]">$list[title]</label>
					</li>
				<!--{/loop}-->
				</ul>
			</div>
			<div class="barto">
				<button name="choosebutton" class="pn" onclick="choosearticle();" title="{lang selected_tag_selected}"><em>&gt;</em></button>
			</div>
			<div class="y">
				<p class="mtm mbn">{lang already_select}(<strong id="selectednum" class="xi1">0</strong>)</p>
				<ul id="selectedarticle" class="bartl"></ul>
			</div>
		</div>
	</div>
	<p class="o pns">
		<input type="hidden" id="selectedarray" name="selectedarray" value="" />
		<!--{if $_GET['update']}-->
		<input type="hidden" id="update" name="update" value="1" />
		<!--{/if}-->
		<button type="submit" name="dsf" class="pn pnc" onclick="addrelatearticle();"><span>{lang confirms}</span></button>
		<button type="reset" name="dsf" class="pn" onclick="hideWindow('$_GET[handlekey]');"><em>{lang cancel}</em></button>
	</p>

	<script type="text/javascript" reload="1">
	function choosearticle() {
		var article = document.getElementsByName("article");
		for(var i = 0; i < article.length; i++){
			if(article[i].checked) {
				var choosed = $("article_"+article[i].value).innerHTML;
				choosed ='<li id="'+article[i].value+'"><em>'+choosed+'</em><span class="xg1"><a href="javascript:;" onclick="uparticle('+article[i].value+');" title="{lang move_up}"><img class="vm" src="{IMGDIR}/icon_top.gif" alt="{lang move_up}" /></a> <a href="javascript:;" onclick="downarticle('+article[i].value+');" title="{lang move_down}"><img class="vm" src="{IMGDIR}/icon_down.gif" alt="{lang move_down}" /></a> <a href="javascript:;" onclick="delarticle('+article[i].value+');" title="{lang delete}"><img class="vm" src="{IMGDIR}/data_invalid.gif" alt="{lang delete}" /></a></span></li>';
				if(!$(article[i].value)) {
					$("selectedarticle").innerHTML += choosed;
				}
			}
		}
		updatearticlearray();
	}
	function uparticle(id) {
		var lastid = getdivid(id, 'last');
		if(lastid) {
			var lastdiv = $(lastid);
	        var div = $(id);
			$("selectedarticle").insertBefore(div,lastdiv);
		}
		updatearticlearray();
	}
	function downarticle(id) {
		var nextid = getdivid(id, 'next');
		if(nextid) {
			var nextdiv = $(nextid);
	        var div = $(id);
			$("selectedarticle").insertBefore(nextdiv,div);
		}
		updatearticlearray();
	}
	function delarticle(id) {
		var div = $(id);
		div.parentNode.removeChild(div);
		updatearticlearray();
	}
	function updatearticlearray() {
		var list = document.getElementById("selectedarticle").getElementsByTagName("li");
		var str = '';
		for(var i = 0; i < list.length; i++)
		{
			if(str == '') {
				str = list[i].id;
			} else {
				str = str + ',' + list[i].id;
			}

		}
		$('selectedarray').value = str;
		$('selectednum').innerHTML = list.length;
	}
	function getdivid(id,type) {
		var str = $('selectedarray').value;
	    var arr = new Array();
		var rstr = '';
		arr = str.split(",");

		for (var i = 0; i < arr.length; i++) {
			if (arr[i] == id) {
				if(type == 'last') {
					if(arr[i-1]) {
						rstr = arr[i-1];
					}
				} else if(type == 'next') {
					if(arr[i+1]) {
						rstr = arr[i+1];
					}
				}
				break;
			}
		}
		return rstr;
	}
	function manualadd() {
		var manualid = $('manualid').value;
		if($(manualid)) {
			alert('{lang article_validate_has_added}');
			return false;
		}
		var url = 'portal.php?mod=portalcp&ac=related&op=manual&catid=$catid&aid=$aid&inajax=1&manualid='+manualid;
		var x = new Ajax();
		x.get(url, function(s){
			s = trim(s);
			if(s) {
				$('selectedarticle').innerHTML += s;
				updatearticlearray();
			} else {
				alert('{lang article_validate_noexist}');
				return false;
			}
		});
	}
	function articlesearch() {
		var searchkey = $('searchkey').value;
		var searchcate = $('searchcate').value;
		var url = 'portal.php?mod=portalcp&ac=related&op=search&catid=$catid&aid=$aid&inajax=1&searchkey='+searchkey+'&searchcate='+searchcate;
		var x = new Ajax();
		x.get(url, function(s){
			s = trim(s);
			if(s) {
				$('articlelist').innerHTML = s;
				getarticlenum();
			} else {
				$('articlelist').innerHTML = '';
				getarticlenum();
				return false;
			}
		});

	}
	function getarticlenum() {
		var article = document.getElementsByName("article");
		for(var i = 0, j = 0; i < article.length; i++){
			if(article[i].checked) {
				j++;
			}
		}
		$('articlenum').innerHTML = j;
		$('articlenumall').innerHTML = article.length;
	}
	function addrelatearticle() {
		var relatedid = $("selectedarray").value;
		if(relatedid) {
			var url = 'portal.php?mod=portalcp&ac=related&op=add&catid=$catid&aid=$aid&inajax=1&relatedid='+relatedid;
			if($('update')) {
				url += '&update=1';
			}
			var x = new Ajax();
			x.get(url, function(s){
				s = trim(s);
				if(s) {
					if($('portalview')) {
						showDialog('{lang add_portal_related_success}', 'right', '', 'window.location.reload();');
					} else {
						$('raid_div').innerHTML = '';
						$('raid_div').innerHTML = s;
					}
				}
			});
		} else {
			$('raid_div').innerHTML = '';
		}
		hideWindow('$_GET[handlekey]');
	}
	function getrelatedarticle() {
		var input = document.getElementById("raid_div").getElementsByTagName("input");
		if(input) {
			var id = '';
			for(var i = 0;i < input.length;i++)
			{
				if(id) {
					id = id + ',' + input[i].value;
				} else {
					id = input[i].value;
				}
			}
			if(id != '') {
				var url = 'portal.php?mod=portalcp&ac=related&op=get&catid=$catid&aid=$aid&inajax=1&id='+id;
				var x = new Ajax();
				x.get(url, function(s){
				s = trim(s);
				if(s) {
					$("selectedarray").value = id;
					$('selectedarticle').innerHTML = s;
					$('selectednum').innerHTML = input.length;
				}
				});
			}

		} else {
			return true;
		}
	}
	function selectall() {
		var input = document.getElementById("chkalldiv").getElementsByTagName("input");
		var checkall = 'chkall';
		count = 0;
		for(var i = 0; i < input.length; i++) {
			var e = input[i];
			if(e.name && e.name != checkall) {
				e.checked = input[checkall].checked;
				if(e.checked) {
					count++;
				}
			}
		}
		return count;
	}
	getrelatedarticle();
	</script>
<!--{/if}-->
<!--{template common/footer}-->