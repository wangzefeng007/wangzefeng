<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array('{lang trends_and_statistics}');}-->
<!--{template common/header}-->

<div id="ct" class="ct7_a wp cl">
	<!--{subtemplate common/stat}-->
	<div class="mn">
		<div class="bm bw0">
			<h1 class="mt">{lang trends_and_statistics}</h1>
			<form method="get" action="misc.php?mod=stat&op=trend">
			<table cellspacing="0" cellpadding="0" class="dt bm mbw">
				<caption>
					<h2>{lang stat_classification}</h2>
					<p class="pbm xg1">{lang stat_message}</p>
				</caption>
				<tr class="tbmu">
					<th>{lang basic_data}:</th>
					<td>
						<a href="misc.php?mod=stat&op=trend"$actives[all]>{lang comprehensive_overview}</a> &nbsp;
						<!--{loop $cols['login'] $value}-->
						<label$actives[$value]><input type="checkbox" name="types[]" value="$value" class="pc" {if in_array($value, $_GET[types])} checked="checked"{/if} /><!--{eval echo lang('spacecp', "do_stat_$value");}--></label> &nbsp;
						<!--{/loop}-->
					</td>
				</tr>
				<tr class="tbmu">
					<th>$_G[setting][navs][2][navname]:</th>
					<td>
						<!--{loop $cols['forum'] $value}-->
						<label$actives[$value]><input type="checkbox" name="types[]" value="$value" class="pc" {if in_array($value, $_GET[types])} checked="checked"{/if} /><!--{eval echo lang('spacecp', "do_stat_$value");}--></label> &nbsp;
						<!--{/loop}-->
					</td>
				</tr>
				<tr class="tbmu">
					<th>{lang tgroup}:</th>
					<td>
						<!--{loop $cols['tgroup'] $value}-->
						<label $actives[$value]><input type="checkbox" name="types[]" value="$value" class="pc" {if in_array($value, $_GET[types])} checked="checked"{/if} /><!--{eval echo lang('spacecp', "do_stat_$value");}--></label> &nbsp;
						<!--{/loop}-->
					</td>
				</tr>
				<tr class="tbmu">
					<th>{lang home}:</th>
					<td>
						<!--{loop $cols['home'] $value}-->
						<label$actives[$value]><input type="checkbox" name="types[]" value="$value" class="pc" {if in_array($value, $_GET[types])} checked="checked"{/if} /><!--{eval echo lang('spacecp', "do_stat_$value");}--></label> &nbsp;
						<!--{/loop}-->
					</td>
				</tr>

				<!--tr class="tbmu">
					<th>{lang info_interactive}:</th>
					<td>
						<!--{loop $cols['comment'] $value}-->
						<label$actives[$value]><input type="checkbox" name="types[]" value="$value" class="pc" {if in_array($value, $_GET[types])} checked="checked"{/if} /><!--{eval echo lang('spacecp', "do_stat_$value");}--></label> &nbsp;
						<!--{/loop}-->
					</td>
				</tr-->
				<tr class="tbmu">
					<th>{lang member_interactive}:</th>
					<td>
						<!--{loop $cols['space'] $value}-->
						<label$actives[$value]><input type="checkbox" name="types[]" value="$value" class="pc" {if in_array($value, $_GET[types])} checked="checked"{/if} /><!--{eval echo lang('spacecp', "do_stat_$value");}--></label> &nbsp;
						<!--{/loop}-->
					</td>
				</tr>
				<tr class="tbmu">
					<th>{lang stat_date_range}:</th>
					<td>
						<script type="text/javascript" src="{$_G[setting][jspath]}calendar.js?{VERHASH}"></script>
						<input type="text" name="primarybegin" class="px" value="$primarybegin" onclick="showcalendar(event, this, false)"/> - <input type="text" name="primaryend" class="px" value="$primaryend" onclick="showcalendar(event, this, false)" />
						<label><input type="checkbox" name="merge" value="1" class="pc" {if !empty($merge)} checked="checked"{/if} />{lang stat_merge_statistic}</label>
						<button type="submit" class="pn pnc"><strong>{lang show}</strong></button>
					</td>
				</tr>
			</table>
			<input type="hidden" name="type" value="$_GET[type]" />
			<input type="hidden" name="mod" value="stat" />
			<input type="hidden" name="op" value="trend" />
			</form>
			<table cellspacing="0" cellpadding="0" width="100%">
				<!--{if $type=='all'}-->
				<caption>
					<h2>{lang comprehensive_overview}</h2>
					<p class="xg1">{lang comprehensive_overview_message}</p>
				</caption>
				<tr>
					<td>
						<ul class="ptn pbm xl">
							{lang interactive_help_message}
						</ul>
					</td>
				</tr>
				<!--{else}-->
				<caption>
					<h2>
						<!--{loop $_GET[types] $key $type}-->
						&nbsp;
						<!--{eval echo lang('spacecp', "do_stat_$type");}-->
						&nbsp;
						<!--{/loop}-->
					</h2>
				</caption>
				<!--{/if}-->
				<tr><td>
				<script type="text/javascript">
						document.write(AC_FL_RunContent(
							'width', '100%', 'height', '300',
							'src', '{STATICURL}image/common/stat.swf?$statuspara',
							'quality', 'high', 'wmode', 'transparent'
						));
					</script>
				</td></tr>
			</table>

		</div>
	</div>
</div>
<!--{template common/footer}-->