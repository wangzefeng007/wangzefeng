<?php exit;?>
<!--{template common/header}-->
<!--{if empty($_GET['infloat'])}-->
<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->

<form method="post" autocomplete="off" id="commentform" action="forum.php?mod=post&action=reply&comment=yes&tid=$post[tid]&pid=$_GET[pid]&extra=$extra{if !empty($_GET[page])}&page=$_GET[page]{/if}&commentsubmit=yes&infloat=yes" onsubmit="{if !empty($_GET['infloat'])}ajaxpost('commentform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;{/if}">
	<div class="f_c">
		<h3 class="flb">
			<em id="return_$_GET['handlekey']">{lang comments}</em>
			<span>
				<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
			</span>
		</h3>
		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<input type="hidden" name="handlekey" value="$_GET['handlekey']" />
		<div class="c">
			<div class="tedt">
				<div class="bar cm">
					<!--{eval $seditor = array('comment', array('bold', 'color'));}-->
					<!--{subtemplate common/seditor}-->
					<span id="itemdiv"></span>
				</div>
				<div class="area">
					<textarea rows="2" cols="50" name="message" id="commentmessage" onKeyUp="strLenCalc(this, 'checklen')" onKeyDown="seditor_ctlent(event, '$(\'commentsubmit\').click();')" tabindex="2" class="pt" style="overflow: auto"></textarea>
				</div>
				<script type="text/javascript" reload="1">
				<!--{if $commentitem}-->
					var items = itemrow = itemcmm = '';
					<!--{eval $items = range(0, 5);$itemlang = array('{lang comment_1}', '{lang comment_2}', '{lang comment_3}', '{lang comment_4}', '{lang comment_5}', '{lang comment_6}');$i = $cmm = 0;}-->
					<!--{loop $commentitem $item}-->
						<!--{eval $item = trim($item);}-->
						<!--{if $item}-->
							items += '<input type="hidden" id="itemc_$i" name="commentitem[$item]" value="" />';
							itemrow = '<span id="itemt_$i" class="z xg1 cur1" title="{lang comment_give_ip}" onclick="itemdisable($i)">&nbsp;$item</span>';
							itemstar = '';
							<!--{loop $items $j}-->
							itemstar += '<em onclick="itemclk($i, $j)" onmouseover="itemop($i, $j)" onmouseout="itemset($i)" title="$itemlang[$j]($j)"{if !$j} style="width: 10px;"{/if}>$itemlang[$j]</em>';
							<!--{/loop}-->
							itemrow += '<span id="item_$i" class="z cmstar">' + itemstar + '</span>';
							<!--{eval $i++;}-->
							<!--{if !$cmm}-->items += itemrow;<!--{else}-->itemcmm += '<div class="cl cmm" style="margin:5px">' + itemrow + '</div>';<!--{/if}-->
						<!--{elseif !$cmm}-->
							items += '<span class="z" id="itemmore" onmouseover="showMenu({\'ctrlid\':this.id,\'pos\':\'13\'})">&nbsp;&raquo; {lang more}</span>';
							<!--{eval $cmm = 1;}-->
						<!--{/if}-->
					<!--{/loop}-->
					$('itemdiv').innerHTML = items;
					if(itemcmm) {
						cmmdiv = document.createElement('div');
						cmmdiv.id = 'itemmore_menu';
						cmmdiv.style.display = 'none';
						cmmdiv.className = 'p_pop';
						cmmdiv.innerHTML = itemcmm;
						$('append_parent').appendChild(cmmdiv);
					}
				<!--{/if}-->
				$('commentmessage').focus();
				</script>
			</div>
			<div id="seccheck_comment">
				<!--{if $secqaacheck || $seccodecheck}-->
					<!--{subtemplate forum/seccheck_post}-->
				<!--{/if}-->
			</div>
		</div>
	</div>
	<div class="o pns cl{if empty($_GET['infloat'])} mtm{/if}">
		<button type="submit" id="commentsubmit" class="pn pnc z" value="true" name="commentsubmit" tabindex="3"{if !$seccodecheck} onmouseover="checkpostrule('seccheck_comment', 'ac=reply&infloat=yes&handlekey=$_GET[handlekey]');this.onmouseover=null"{/if}><span>{lang publish}</span></button>
		<span class="y">{lang comment_message1} <strong id="checklen">200</strong> {lang comment_message2}</span>
	</div>
</form>

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->