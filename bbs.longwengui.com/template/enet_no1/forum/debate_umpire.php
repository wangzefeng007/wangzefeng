<?php exit;?>
<!--{template common/header}-->
<!--{if empty($_GET['infloat'])}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> $navigation</div>
</div>
<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm bw0">
<!--{/if}-->

<form method="post" autocomplete="off" id="postform" action="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&umpiresubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('postform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
	<div class="f_c">
		<h3 class="flb">
			<em id="return_$_GET['handlekey']">{lang debate_umpirecomment}</em>
			<span>
				<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
			</span>
		</h3>

		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="c">
			<table class="tfm" cellspacing="0" cellpadding="0">
				<tr>
					<th>{lang debate_winner}</th>
					<td>
						<label class="lb"><input type="radio" name="winner" value="1" class="pr" $winnerchecked[1] id="winner1" />{lang debate_square}</label>
						<label class="lb"><input type="radio" name="winner" value="2" class="pr" $winnerchecked[2] id="winner2" />{lang debate_opponent}</label>
						<label class="lb"><input type="radio" name="winner" value="3" class="pr" $winnerchecked[3] id="winner3" />{lang debate_draw}</label>
					</td>
				</tr>

				<tr>
					<th><label for="bestdebater">{lang debate_bestdebater}</label></th>
					<td>
						<p>
							<select onchange="$('bestdebater').value=this.options[this.options.selectedIndex].value" class="ps">
								<option value=""><strong>{lang debate_recommend_list}</strong></option>
								<option value="">------------------------------</option>
								<!--{loop $candidates $candidate}-->
									<option value="$candidate[username]"{if $candidate[username] == $debate[bestdebater]} selected="selected"{/if}>$candidate[username] ( $candidate[voters] {lang debate_poll}, <!--{if $candidate[stand] == 1}-->{lang debate_square}<!--{elseif $candidate[stand] == 2}-->{lang debate_opponent}<!--{/if}-->)</option>
								<!--{/loop}-->
							</select>
						</p>
						<p class="mtn"><input type="text" name="bestdebater" id="bestdebater" class="px" value="$debate[bestdebater]" size="20" /></p>
						<p class="d">{lang debate_list_nonexistence}</p>
					</td>
				</tr>

				<tr>
					<th><label for="umpirepoint">{lang debate_umpirepoint}</label></th>
					<td><textarea id="umpirepoint" name="umpirepoint" class="pt" style="height: 100px;">$debate[umpirepoint]</textarea></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="o pns">
		<button class="pn pnc" type="submit" name="umpiresubmit" value="true" class="submit"><span>{lang submit}</span></button>
	</div>
</form>

<!--{if !empty($_GET['infloat'])}-->
<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	<!--{if !empty($_GET['from'])}-->
		location.href = locationhref;
	<!--{else}-->
		ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$_GET[pid]', 'post_$_GET[pid]');
		hideWindow('$_GET['handlekey']');
	<!--{/if}-->
}
</script>
<!--{/if}-->

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->