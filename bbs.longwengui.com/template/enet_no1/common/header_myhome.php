<?php exit;?>
				<ul id="myhome_menu" class="p_pop" style="display: none;margin-left: 71px;top: 31px !important;width: 800px;height:0px;background:transparent;border: 0;box-shadow: transparent 0 0 0;">
				<div class="membercard">
				<div style="margin:3px;background:transparent">
				<div class="um_hear" style="width:230px">
				<div class="j_um">
				<div class="avt"><a href="home.php?mod=space&uid=$_G[uid]" id="background_avt"><!--{avatar($_G[uid],small)}--></a></div>
				<p><a href="home.php?mod=space&uid=$_G[uid]" title="{lang visit_my_space}" id="username">{$_G[member][username]}</a></p>
			    <p><a href="home.php?mod=spacecp&ac=usergroup" id="usergroup">{lang usergroup}: $_G[group][grouptitle]<!--{if $_G[member]['freeze']}--><span> ({lang freeze})</span><!--{/if}--></a></p>
				<p class="um_pm" style="padding-left:70px;padding-right:14px">
				<a href="home.php?mod=space&do=pm" id="pm_ntc" title="{lang pm_center}">{lang pm_center}</a>
				{if $_G[member][newpm]}<em style="margin-right:3px">N</em>{/if}
				<a href="home.php?mod=space&do=notice" id="myprompt" title="{lang remind}">{lang remind}</a><!--{if $_G[member][newprompt]}--><em style="margin-right:3px">$_G[member][newprompt]</em><!--{/if}-->
				<a href="home.php?mod=follow&do=follower" id="notice_follower" title="{lang notice_interactive_follower}"><!--{lang notice_interactive_follower}--></a>{if $_G[member][newprompt_num][follower]}<em style="margin-right:3px">$_G[member][newprompt_num][follower]</em>{/if}
				<a href="home.php?mod=follow" id="notice_follow" title="{lang notice_interactive_follow}"><!--{lang notice_interactive_follow}--></a><!--{if $_G[member][newprompt] && $_G[member][newprompt_num][follow]}--><em style="margin-right:3px">$_G[member][newprompt_num][follow]</em><!--{/if}-->
				<!--{if $_G[member][newprompt]}-->
					<!--{loop $_G['member']['category_num'] $key $val}-->
						<a href="home.php?mod=space&do=notice&view=$key" id="notice_$key" title="<!--{echo lang('template', 'notice_'.$key)}-->"></a><em>$val</em>
					<!--{/loop}-->
				<!--{/if}-->
				<div style="clear:both"></div>
				</p>
				<p id="plug_i"><!--{if $_G['uid']}--><!--{hook/global_usernav_extra1}--><!--{elseif !empty($_G['cookie']['loginuser'])}--><!--{elseif !$_G[connectguest]}--><!--{else}--><!--{/if}--><!--{hook/global_usernav_extra2}--><!--{eval $upgradecredit = $_G['uid'] && $_G['group']['grouptype'] == 'member' && $_G['group']['groupcreditslower'] != 999999999 ? $_G['group']['groupcreditslower'] - $_G['member']['credits'] : false;}--></p>						
		        </div>
				<div class="user_hear_bottom"></div>
				</div>
					<div class="umdivtb">
							<div class="umrights" style="margin:0;padding:0;overflow: hidden;padding-top: 7px;margin-bottom:-5px;width:228px">
							<ul>
                             <!--{if $_G['uid']}-->
					         <!--{elseif !empty($_G['cookie']['loginuser'])}-->
					         <!--{elseif !$_G[connectguest]}-->
					         <!--{else}-->
                             <!--{hook/global_usernav_extra1}-->
					         <!--{/if}-->
								<!--{loop $_G['setting']['mynavs'] $nav}-->
									<!--{if $nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))}-->
										{eval $nav[code] = str_replace('style="', '_style="', $nav[code]);}
										$nav[code]
									<!--{/if}-->
								<!--{/loop}-->
								<!--{hook/global_usernav_extra3}-->
								<a href="home.php?mod=spacecp">{lang setup}</a>
								<!--{if ($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))}-->
									<a href="portal.php?mod=portalcp"><!--{if $_G['setting']['portalstatus'] }-->{lang portal_manage}<!--{else}-->{lang portal_block_manage}<!--{/if}--></a>
								<!--{/if}-->
								<!--{if $_G['uid'] && $_G['group']['radminid'] > 1}-->
									<a href="forum.php?mod=modcp&fid=$_G[fid]" target="_blank">{lang forum_manager}</a>
								<!--{/if}-->
								<!--{if $_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)}-->
									<a href="admin.php" target="_blank">{lang admincp}</a>
								<!--{/if}-->
								<!--{hook/global_usernav_extra4}-->
								<!--{if $_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])}--><a href="home.php?mod=task&item=doing" class="new">{lang task_doing}</a>
							<!--{/if}-->
							</ul>
							</div>
							<div style="width:100%"><a id="logout_a" href="member.php?mod=logging&action=logout&formhash={FORMHASH}">{lang logout}</a></div>
						<div style="width:100%;height:10px"></div>
					</div>		
				</div>
				</div>
				<!--{hook/global_myitem_extra}-->
				</ul>