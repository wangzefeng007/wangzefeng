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

<form id="applylistform" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplylist&tid=$_G[tid]&applylistsubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat']) && empty($_GET['from'])} onsubmit="ajaxpost('applylistform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if} style="width: 590px;">
	<div class="f_c">
		<h3 class="flb">
			<em id="return_$_GET['handlekey']"><!--{if $isactivitymaster}-->{lang activity_applylist_manage}<!--{else}-->{lang activity_applylist}<!--{/if}--></em>
			<span>
				<!--{if !empty($_GET['infloat'])}--><a href="javascript:;" class="flbc" onclick="hideWindow('$_GET['handlekey']')" title="{lang close}">{lang close}</a><!--{/if}-->
			</span>
		</h3>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="operation" value="" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="c floatwrap">
			<table class="list" cellspacing="0" cellpadding="0" style="table-layout: fixed;">
				<thead>
					<tr>
						<!--{if $isactivitymaster}--><th width="25">&nbsp;</th><!--{/if}-->
						<th width="105">{lang activity_join_members}</th>
						<th>{lang leaveword}</th>
						<th width="70">{lang extension_project}</th>
						<!--{if $activity['cost']}-->
						<th width="70">{lang activity_payment}</th>
						<!--{/if}-->
						<th width="70">{lang activity_jointime}</th>
						<!--{if $isactivitymaster}--><th width="70">{lang status}</th><!--{/if}-->
					</tr>
				</thead>
				<!--{loop $applylist $apply}-->
					<tr>
						<!--{if $isactivitymaster}-->
							<td>
							<!--{if $apply[uid] != $_G[uid]}-->
								<input type="checkbox" name="applyidarray[]" class="pc" value="$apply[applyid]" />
							<!--{else}-->
								<input type="checkbox" class="pc" disabled="disabled" />
							<!--{/if}-->
							</td>
						<!--{/if}-->
						<td>
							<a target="_blank" href="home.php?mod=space&uid=$apply[uid]">$apply[username]</a>
							<!--{if $apply[uid] != $_G[uid]}-->
								<a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$apply[uid]&touid=$apply[uid]&pmid=0&daterange=2" onclick="hideMenu('aplayuid{$apply[uid]}_menu');showWindow('sendpm', this.href)" title="{lang send_pm}"><img src="{IMGDIR}/pmto.gif" alt="{lang send_pm}" class="vm" /></a>
							<!--{/if}-->
						</td>
						<td><!--{if $apply[message]}-->$apply[message]<!--{/if}--></td>
						<td>
							<!--{if $apply[ufielddata]}-->
								<div><a href="javascript:;" id="actl_$apply[uid]" class="showmenu" onmouseover="showMenu({'ctrlid':this.id, 'pos':'34!'});">{lang views}</a></div>
								<div id="actl_$apply[uid]_menu" class="p_pop p_opt actl_pop" style="display:none;"><ul>$apply[ufielddata]</ul></div>
							<!--{else}-->
								{lang no_informations}
							<!--{/if}-->
						</td>
						<!--{if $activity['cost']}-->
						<td><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></td>
						<!--{/if}-->
						<td>$apply[dateline]</td>
						<!--{if $isactivitymaster}-->
							<td><!--{if $apply[verified] == 1}-->
									<img src="{IMGDIR}/data_valid.gif" class="vm" alt="{lang activity_allow_join}" /> {lang activity_allow_join}
								<!--{elseif $apply[verified] == 2}-->
									{lang activity_do_replenish}
								<!--{else}-->
									{lang activity_cant_audit}
								<!--{/if}-->
							</td>
						<!--{/if}-->
					</tr>
				<!--{/loop}-->
			</table>
		</div>
	</div>
	<!--{if $isactivitymaster}-->
		<div class="o pns">
			<label{if !empty($_GET['infloat'])} class="z"{/if}><input class="pc" type="checkbox" name="chkall" onclick="checkall(this.form, 'applyid')" />{lang checkall} </label>
			<label>{lang activity_ps}: <input name="reason" class="px vm" size="25" /> </label>
			<button class="pn pnc vm" type="submit" value="true" name="applylistsubmit"><span>{lang confirm}</span></button>
			<button class="pn vm" type="submit" value="true" name="applylistsubmit" onclick="$('applylistform').operation.value='replenish';"><span>{lang to_improve}</span></button>
			<button class="pn vm" type="submit" value="true" name="applylistsubmit" onclick="$('applylistform').operation.value='notification';"><span>{lang send_notification}</span></button>
			<button class="pn vm" type="submit" value="true" name="applylistsubmit" onclick="$('applylistform').operation.value='delete';"><span>{lang activity_refuse}</span></button>
		</div>
	<!--{/if}-->
</form>

<!--{if !empty($_GET['infloat'])}-->
<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$_GET[pid]', 'post_$_GET[pid]');
	hideWindow('$_GET['handlekey']');
}
</script>
<!--{/if}-->

<!--{if empty($_GET['infloat'])}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->