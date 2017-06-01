<?php exit;?>
<!--{template common/header}-->
<style>
.cttp{padding: 0;border: 0}
#cloudsearch_relate{margin:0 auto;width:90px;margin-bottom:10px}
.wp,.ct4{width:1000px;padding-right:0 !Important}
.ct4 .mn{width:770px !Important}
#switchwidth{display:none}
</style>
<script type="text/javascript" src="{$_G[setting][jspath]}home_friendselector.js?{VERHASH}"></script>
<script type="text/javascript">
	var fs;
	var clearlist = 0;
	var followstatus = <!--{if $collectionfollowdata['ctid']}-->1<!--{else}-->0<!--{/if}-->;
	
	function succeedhandle_addComment(url, msg, commentdata) {
		$("btnCommentSubmit").disabled='';
		showDialog(msg, 'right', '', 'location.href="' + url + '"', null, null, null, null, null, null, 3);
	}
	function errorhandle_addComment(msg, commentdata) {
		$("btnCommentSubmit").disabled='';
		showError(msg);
	}
	function succeedhandle_followcollection(url, msg, collectiondata) {
		if(collectiondata['status'] == 1) { //关注成功
			followstatus = 1;
			$("followlink").innerHTML = '<i class="u">{lang collection_unfollow}</i>';
			$("followlink").href = followcollectionurl();
			$("rightcolfollownum").innerHTML = $("follownum_display").innerHTML = parseInt($("follownum_display").innerHTML) + 1;
		} else if(collectiondata['status'] == 2) { //取消关注成功
			followstatus = 0;
			$("followlink").innerHTML = '<i>{lang collection_follow}</i>';
			$("followlink").href = followcollectionurl();
			$("rightcolfollownum").innerHTML = $("follownum_display").innerHTML = parseInt($("follownum_display").innerHTML) - 1;
		}
	}
	function errorhandle_followcollection(msg, collectiondata) {
		showError(msg);
	}
	function followcollectionurl() {
		return 'forum.php?mod=collection&action=follow&op='+(followstatus ? 'unfo': 'follow')+'&ctid={$_G['collection']['ctid']}&formhash={FORMHASH}';
	}
</script>
<div id="username_menu" style="display: none;">
	<ul id="friends" class="pmfrndl"></ul>
</div>
<div class="p_pof" id="showSelectBox_menu" unselectable="on" style="display:none;">
	<div class="pbm">
		<select class="ps" onchange="clearlist=1;getUser(1, this.value)">
			<option value="-1">{lang collection_inviteallfriend}</option>
			<!--{loop $friendgrouplist $groupid $group}-->
				<option value="$groupid">$group</option>
			<!--{/loop}-->
		</select>
	</div>
	<div id="selBox" class="ptn pbn">
		<ul id="selectorBox" class="xl xl2 cl"></ul>
	</div>
	<div class="cl">
		<button type="button" class="y pn" onclick="fs.showPMFriend('showSelectBox_menu','selectorBox', $('showSelectBox'));doane(event)"><span>{lang close}</span></button>
	</div>
</div>
<div id="ct" class="ct4 wp cl" style="margin-top:10px">
		<div class="bm bml pbn" style="position:relative">
		<div style="height:200px;z-index:0;overflow: hidden;position: relative">{if $_G[uid] && isset($_G[cookie][extstyle]) && strpos($_G[cookie][extstyle], TPLDIR) !== false}<img id="home_hear_bg" src="$_G[cookie][extstyle]/home_hear_bg.jpg" style="width:1000px;height:300px;margin:0;border-radius:5px 5px 0 0;"/>{else}<img id="home_hear_bg" src="./template/enet_no1/images/home_hear_bg.jpg" style="width:1000px;height:300px;margin:0;border-radius:5px 5px 0 0;"/>{/if}<span class="pic-num-wrap"></span></div>
			<style>
			.avtss{width:148px;height:148px;top:110px;left:30px}
			.avtss a{width:140px;height:140px}
			.avtss a img{width:140px;height:140px;border-radius:5px}
			</style>
			<div class="avtss" style="position:absolute;z-index:3">
			<a href="home.php?mod=space&uid={$_G['collection']['uid']}" class="bf" style="padding: 4px;border-radius: 5px;box-shadow: 0 1px 5px #999;display: block;border:1px solid #d9d9d9"><!--{avatar($_G['collection']['uid'],big)}--></a>
			</div>
			<div class="bm_h cl" style="position:absolute;top:160px;left:180px">
				<h1 class="xs2 z">
					<a href="forum.php?mod=collection&action=view&ctid={$_G['collection']['ctid']}" style="font-size:20px;font-weight:100;color:#fff">{$_G['collection']['name']}</a>
				</h1>
			</div>
			<div class="bm_c" style="padding-left: 190px;padding-top:7px">
				<div class="cl">
					<div class="ptn y">
						<!--{hook/collection_viewoptions}-->
						<!--{if $permission}-->
							<a href="forum.php?mod=collection&action=edit&op=invite&ctid=$ctid" id="k_invite" onclick="showWindow(this.id, this.href, 'get', 0);" class="xi2">{lang collection_invite_team}</a>
							<span class="pipe">|</span>
							<a href="forum.php?mod=collection&action=edit&op=edit&ctid={$_G['collection']['ctid']}&formhash={FORMHASH}" class="xi2">{lang edit}</a>
							<span class="pipe">|</span>
							<a href="forum.php?mod=collection&action=edit&op=remove&ctid={$_G['collection']['ctid']}&formhash={FORMHASH}" onclick="showDialog('{lang collection_delete_confirm}','confirm','','window.location=\''+this.href+'\';');return false;" class="xi2">{lang delete}</a>
						<!--{/if}-->
						<!--{if $_G['uid']!=$_G['collection']['uid']}-->
							<!--{if $permission}-->
								<span class="pipe">|</span>
							<!--{/if}-->
							<a href="forum.php?mod=collection&action=comment&op=recommend&ctid=$ctid" id="k_recommened" onclick="showWindow(this.id, this.href, 'get', 0);" class="xi2">{lang collection_recommend}</a>
						<!--{/if}-->
						<!--{if $isteamworkers}-->
							<span id="exitpipe" class="pipe">|</span>
							<span><a href="forum.php?mod=collection&action=edit&op=removeworker&ctid={$_G['collection']['ctid']}&uid={$_G['uid']}&formhash={FORMHASH}"  onclick="showDialog('{lang collection_exit_team_confirm}','confirm','','window.location=\''+this.href+'\';');return false;" class="xi2">{lang collection_exit_team}</a></span>
						<!--{/if}-->
					</div>
					<div title="$avgrate" class="ptn pbn xg1 cl">
						<!--{if $_G['collection']['ratenum'] > 0}-->
							<span class="clct_ratestar" style="margin-bottom:-5px"><span class="star star$star">&nbsp;</span></span>
							 &nbsp;{lang collection_totalrates}
						<!--{else}-->
							{lang collection_norate}
						<!--{/if}-->
					</div>
				</div>
				<div class="mbn cl">
					<!--{if $_G['collection']['arraykeyword']}-->
						<span class="mbn">
							{lang collection_keywords}
							<!--{loop $_G['collection']['arraykeyword'] $unique_keyword}-->
								<a href="search.php?mod={if $_G['setting']['search']['collection']['status']}collection{else}forum{/if}&srchtxt={echo rawurlencode($unique_keyword)}&formhash={FORMHASH}&searchsubmit=true&source=collectionsearch" target="_blank" class="xi2">$unique_keyword</a>&nbsp;
							<!--{/loop}-->
						</span>
					<!--{/if}-->
					<span>
						{lang collection_creator}<a href="home.php?mod=space&uid={$_G['collection']['uid']}" class="xi2" c="1">{$_G['collection']['username']}</a>
						<!--{if $collectionteamworker}-->
							<span class="pipe">|</span>
							{lang collection_teamworkers}
							<!--{loop $collectionteamworker $collectionworker}-->
								<span id="k_worker_uid_{$collectionworker['uid']}">
								<a href="home.php?mod=space&uid={$collectionworker['uid']}" c="1" class="xi2">{$collectionworker['username']}</a>&nbsp;
								<!--{if $permission}-->
									<a href="forum.php?mod=collection&action=edit&op=removeworker&ctid={$_G['collection']['ctid']}&uid={$collectionworker['uid']}&formhash={FORMHASH}"  onclick="showDialog('{lang collection_delete_confirm}','confirm','','ajaxget(\''+this.href+'\',\'k_worker_uid_{$collectionworker['uid']}\')');return false;" class="xi2">[{lang delete}]</a>&nbsp;
								<!--{/if}-->
								</span>
							<!--{/loop}-->
						<!--{/if}-->
					</span>
				</div>
				<div>{$_G['collection']['desc']}</div>
				<div class="clct_flw">
					<!--{if $_G['group']['allowfollowcollection'] && $_G['collection']['uid'] != $_G['uid']}-->
						<!--{if !$collectionfollowdata['ctid']}-->
							<a href="javascript;" id="followlink" onclick="ajaxget(followcollectionurl());doane(event);"><i>{lang collection_follow}</i></a>
						<!--{else}-->
							<a href="javascript;" id="followlink" onclick="ajaxget(followcollectionurl());doane(event);"><i class="u">{lang collection_unfollow}</i></a>
						<!--{/if}-->
					<!--{else}-->
						<i>{lang collection_follow}</i>
					<!--{/if}-->
				</div>
			</div>
		</div>
	<div class="mn">
		<!--{hook/collection_view_top}-->
		<!--{if !$op}-->
			<div id="threadlist" class="tl bm" style="padding:0 15px">
				<!--{if $threadlist}-->
					<!--{if $permission}-->
						<form action="forum.php?mod=collection&action=edit&op=delthread" method="POST">
					<!--{/if}-->

					<div class="bm_c">
						<table cellspacing="0" cellpadding="0">
						<!--{loop $collectiontids $thread}-->
							<tr>
								<td class="avt" style="width:55px">
										<!--{if $thread['authorid'] && $thread['author']}-->
											<a style="margin-left:0" href="home.php?mod=space&uid=$thread[authorid]"><!--{avatar($thread[authorid],small)}--></a>
										<!--{else}-->
											<a style="margin-left:0"><img src="$_G['style']['styleimgdir']/hidden.gif" title="$_G[setting][anonymoustext]" alt="$_G[setting][anonymoustext]" /></a>
										<!--{/if}-->
								</td>
								<!--{if $permission}-->
								<td class="o"><input type="checkbox" value="$thread[tid]" name="delthread[]" /></td>
								<!--{/if}-->
								<th class="$thread[folder]">
									<a href="forum.php?mod=viewthread&tid=$thread[tid]{if !$memberrate AND $_G['uid']}&ctid=$ctid{/if}" target="_blank" class="xst {if $thread[updatedthread]}xw1 xi2{/if}" title="$thread['htmlsubject']">$thread['cutsubject']</a>
									<!--{if $thread['readperm']}--> - [{lang readperm} <span class="xw1">$thread[readperm]</span>]<!--{/if}-->
									<!--{if $thread['price'] > 0}-->
										<!--{if $thread['special'] == '3'}-->
										- <span style="color: #C60">[{lang thread_reward} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][2]][title]}]</span>
										<!--{else}-->
										- [{lang price} <span class="xw1">$thread[price]</span> {$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][1]][title]}]
										<!--{/if}-->
									<!--{elseif $thread['special'] == '3' && $thread['price'] < 0}-->
										- [{lang reward_solved}]
									<!--{/if}-->
									<!--{if $thread['attachment'] == 2}-->
										<img src="{STATICURL}image/filetype/image_s.gif" alt="attach_img" title="{lang attach_img}" align="absmiddle" />
									<!--{elseif $thread['attachment'] == 1}-->
										<img src="{STATICURL}image/filetype/common.gif" alt="attachment" title="{lang attachment}" align="absmiddle" />
									<!--{/if}-->
									<!--{if $thread['digest'] > 0 && $filter != 'digest'}-->
										<img src="{IMGDIR}/digest_$thread[digest].gif" align="absmiddle" alt="digest" title="{lang thread_digest} $thread[digest]" />
									<!--{/if}-->
										<p class="mtn xg1">
											<!--{hook/forumdisplay_author $key}-->
											<!--{if $thread['authorid'] && $thread['author']}-->
												<span>{lang author}: </span><a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
											<!--{else}-->
												<span>{lang author}: </span>$_G[setting][anonymoustext]
											<!--{/if}-->
											&nbsp;
											<span>{lang dateline}: </span><span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span>
										<span>&nbsp;{lang lastpost}: <!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}" c="1">$thread[lastposter]</a>&nbsp;/<!--{else}-->$_G[setting][anonymoustext]&nbsp;/<!--{/if}-->&nbsp;<a href="{if $thread[digest] != -2}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}">$thread[lastpost]</a></span>
										</p>
									</th>
									<td class="flt">
									</td>
									<td class="flt">
									</td>
								<td class="by">
									<div class="xld" style="float: right"><dd class="m hm"><strong class="xi2">$thread[replies]</strong><span>{lang reply}</span></dd><dd class="m hm" style="margin-right:0"><strong class="xi2"><!--{if $thread['isgroup'] != 1}-->$thread[views]<!--{else}-->{$groupnames[$thread[tid]][views]}<!--{/if}--></strong><span>{lang focus_show}</span></dd></div>
								</td>
							</tr>
							<!--{/loop}-->
						</table>
					</div>

					<!--{if $permission}-->
					<div class="bm_c cl">
						<input type="hidden" value="{$ctid}" name="ctid" />
					    <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />

						<button type="submit" class="pn pnc" style="margin-bottom:10px;width:100%"><span>{lang delete}</span></button>
					</div>
					</form>
					<!--{/if}-->
				<!--{else}-->
					<div class="emp hm">
					<!--{if $search_status && $isteamworkers && $permission}-->
					{lang collection_cloud_search}
					<!--{else}-->
					{lang no_content}
					<!--{/if}-->
					</div>
				<!--{/if}-->
				
				<!--{hook/collection_threadlistbottom}-->
			</div>
			<!--{if $multipage}--><div class="pgs mtm cl">$multipage</div><br /><!--{/if}-->
		<!--{elseif $op == 'related'}-->
			<!--{hook/collection_relatedop}-->
		<!--{/if}-->
		
		<!--{if $_G['collection']['commentnum'] > 0}-->
		<div class="bm">
			<div class="bm_h">
				<span class="y"><a href="forum.php?mod=collection&action=view&op=comment&ctid=$ctid" class="xi2">{lang collection_allcomment}</a></span>
				<h2>{lang collection_newcomment}</h2>
			</div>
			<div class="bm_c">
			<!--{loop $commentlist $comment}-->
				<div class="pbn">
					<a href="home.php?mod=space&uid={$comment['uid']}" class="xi2 xw1" c="1">$comment[username]</a>
					<span class="xg1">$comment[dateline]:</span>
				</div>
				<div class="pbm">
					$comment[message]
					<!--{if $comment[rateimg]}-->
						<!--{if trim($comment[message])}--><br /><!--{/if}-->
						<span class="clct_ratestar"><span class="star star$comment[rateimg]"></span></span><br />
					<!--{/if}-->
				</div>
			<!--{/loop}-->
			</div>
		</div>
		<!--{/if}-->
		
		<!--{if $_G['group']['allowcommentcollection']}-->
		<div class="bm">
			<form action="forum.php?mod=collection&action=comment&ctid={$_G['collection']['ctid']}" method="POST" onsubmit="$('btnCommentSubmit').disabled=true;ajaxpost(this.id, 'ajaxreturn');" id="form_addComment" name="form_addComment">
			<div class="bm_h">
				<h2>{lang collection_ratecollection}</h2>
			</div>
			<div class="bm_c {if $memberrate}bbda{/if}">
				<!--{if !$memberrate}-->
				<div class="cl">
					<input type="hidden" name="ratescore" id="ratescore" />
					<span class="clct_ratestar">
						<span class="btn">
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',1)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',1,'ratescore')">1</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',2)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',2,'ratescore')">2</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',3)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',3,'ratescore')">3</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',4)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',4,'ratescore')">4</a>
							<a href="javascript:;" onmouseover="rateStarHover('clct_ratestar_star',5)" onmouseout="rateStarHover('clct_ratestar_star',0)" onclick="rateStarSet('clct_ratestar_star',5,'ratescore')">5</a>
						</span>
						<span id="clct_ratestar_star" class="star star$memberrate"></span>
					</span>
				</div>
				<!--{/if}-->
				<div class="pbn">
					<textarea name="message" rows="4" class="pt" style="width: 94%"></textarea>
				</div>
				<div><button type="submit" class="pn pnc" id="btnCommentSubmit"><span>{lang collection_comment_submit}</span></button></div>
			</div>
			<!--{if $memberrate}-->
				<div class="bm_c ptn pbn cl">
					<span class="z">{lang collection_rated}&nbsp;</span>
					<span class="clct_ratestar"><span class="star star$memberrate"></span></span>
				</div>
			<!--{/if}-->
			<input type="hidden" name="inajax" value="1">
			<input type="hidden" name="handlekey" value="k_addComment">
			</form>
		</div>
		<!--{/if}-->
		
		<!--{hook/collection_view_bottom}-->
	</div>
	<div class="sd">
		<div class="bm bml tns">
			<table cellspacing="0" cellpadding="4">
				<tr>
					<th>
						<p>{$_G['collection']['threadnum']}</p>{lang collection_threadnum}
					</th>
					<th>
						<p>{$_G['collection']['commentnum']}</p>{lang collection_commentnum}
					</th>
					<td>
						<p><span id="rightcolfollownum">{$_G['collection']['follownum']}</span></p>{lang collection_follow}
					</td>
				</tr>
			</table>
		</div>

		<!--{if $followers}-->
		<div class="bm">
			<div class="bm_h">
				<span class="y"><a href="forum.php?mod=collection&action=view&op=followers&ctid=$ctid" class="xi2">{lang collection_allfollowers}</a></span>
				<h2>{lang collection_newfollowers}</h2>
			</div>
			<div class="bm_c">
				<ul class="ml mls cl">
					<!--{loop $followers $follower}-->
						<li>
							<a href="home.php?mod=space&uid=$follower[uid]" class="avt"><!--{avatar($follower[uid],small)}--></a>
							<p><a href="home.php?mod=space&uid=$follower[uid]" c="1">$follower[username]</a></p>
						</li>
					<!--{/loop}-->
				</ul>
			</div>
		</div>
		<!--{/if}-->
		
		<!--{if $userCollections}-->
		<div class="bm">
			<div class="bm_h">
				<h2>{lang collection_creators}</h2>
			</div>
			<div class="bm_c">
			<!--{loop $userCollections $ucollection}-->
				<div class="pbn">
					<a href="forum.php?mod=collection&action=view&ctid={$ucollection['ctid']}" class="xi2 xw1">$ucollection[name]</a>
				</div>
				<div class="pbm">
					{lang collection_threadnum} $ucollection[threadnum], {lang collection_follow} $ucollection[follownum], {lang collection_commentnum} $ucollection[commentnum]
				</div>
			<!--{/loop}-->
			</div>
		</div>
		<!--{/if}-->
		<!--{hook/collection_side_bottom}-->
	</div>
</div>
<span id='ajaxreturn' style='display:none;'></span>
<!--{template common/footer}-->