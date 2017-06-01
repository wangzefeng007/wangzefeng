<?php exit;?>
<!--{template common/header}-->
	<!--{subtemplate home/spacecp_header}-->
			<form action="home.php?mod=spacecp&ac=sendmail" method="post" autocomplete="off">
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="setsendemailsubmit" value="true" />
				<input type="hidden" name="referer" value="{echo dreferer()}" />
			<!--{if empty($space['emailstatus']) }-->
				<div class="bm bml">
					<div class="bm_h cl">
						<h2 class="xs2">{lang activate_mailbox_first}</h2>
					</div>
					<div class="bm_c">
						<p>{lang activate_mailbox_message}</p>
						<p class="mtm">
							<a href="home.php?mod=spacecp&ac=profile&op=password&resend=1" class="xs2 xi2">{lang click_activate_mailbox} <strong>$space[email]</strong></a>
							(<a href="home.php?mod=spacecp&ac=profile&op=password&from=contact#contact" class="xi2">{lang modify_email}</a>)
						</p>
					</div>
				</div>
			<!--{else}-->
				{eval
					$mailtype = array(
						'mail_my' => array(
							'piccomment' => '{lang mail_piccomment}',
							'clickpic' => '{lang mail_clickpic}',
							'blogcomment' => '{lang mail_blogcomment}',
							'clickblog' => '{lang mail_clickblog}',
							'doing' => '{lang mail_doing}',
							'sharecomment' => '{lang mail_sharecomment}',
							'pcomment' => '{lang mail_pcomment}',
							'post' => '{lang mail_post}',
							'sharenotice' => '{lang mail_sharenotice}',
							'reward' => '{lang mail_reward}',
							'pusearticle' => '{lang mail_pusearticle}',
							'wall' => '{lang mail_wall}',
						),
	
						'mail_system' => array(
							
							'verify' => '{lang mail_system_verify}',
							'magic' => '{lang mail_system_magic}',
							'credit' => '{lang mail_system_credit}',
							'goods' => '{lang mail_system_goods}',
							'activity' => '{lang mail_system_activity}',
							'report' => '{lang mail_system_report}',
							'group' => '{lang mail_system_group}',
							'task' => '{lang mail_system_task}',
							'pmreport' => '{lang mail_system_pmreport}',
							'myapp' => '{lang mail_system_myapp}',
							'mod_member' => '{lang mail_system_mod_member}',
							'friend' => '{lang mail_system_friend}',
							'show' => '{lang mail_system_show}',
							'system' => '{lang mail_system_insys}',
						)
					);
				}
				<p class="bbda pbm mbm">{lang reminder_mail_message_1}$_G[setting][sendmailday]{lang reminder_mail_message_2}</p>
				<table cellspacing="0" cellpadding="0" class="tfm">
					<!--{loop $mailtype $group $types}-->
						<tr>
							<th><!--{eval echo lang('spacecp', $group)}--></th>
							<td class="pcl">
								<!--{loop $types $key $desc}-->
									<label><input type="checkbox" name="sendmail[$key]" class="pc" value="1" {if $sendmail[$key]} checked="checked"{/if} />$desc</label>
								<!--{/loop}-->
							</td>
						</tr>
					<!--{/loop}-->

					<tr>
						<th>{lang mail_frequency}</th>
						<td class="pcl">
							<select name="sendmail[frequency]" class="ps">
								<option value="0">{lang send_real_time}</option>
								<option value="86400" $sendmail[frequency][86400]>{lang send_once_per_day}</option>
								<option value="604800" $sendmail[frequency][604800]{if !$sendmail} selected="selected"{/if}>{lang send_once_per_week}</option>
							</select>
							<p class="d">
								{lang mail_send_your_mail} $space[email] (<a href="home.php?mod=spacecp&ac=profile&op=password">{lang modify_mailbox}</a>)
							</p>
						</td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
							<button type="submit" name="setsendemail" class="pn pnc"><em>{lang save}</em></button>
						</td>
					</tr>
				</table>
			<!--{/if}-->

			</form>
		</div>
	</div>
</div>
<!--{template common/footer}-->