<?php exit;?>
<style>
.fl .bm_h {padding-top: 0px;}
.el dl{padding: 5px 0 0 0;height: 35px;border-bottom: 1px dotted #DFDFDF;}
</style>
<!--{if $status != 2}-->
	<!--{if $livethread}-->
		<div id="livethread" class="tl bm bmw cl" style="padding:10px 15px;">
			<div class="livethreadtitle vm">
				<span class="replynumber xg1">{lang reply} <span id="livereplies" class="xi1">$livethread[replies]</span></span>
				<a href="forum.php?mod=viewthread&tid=$livethread[tid]" target="_blank">$livethread[subject]</a> <img src="{IMGDIR}/livethreadtitle.png" />
			</div>
			<div class="livethreadcon">$livemessage</div>
			<div id="livereplycontentout">
				<div id="livereplycontent">
				</div>
			</div>
			<div id="liverefresh">{lang group_live_newreply_refresh}</div>
			<div id="livefastreply">
				<form id="livereplypostform" method="post" action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$livethread[tid]&replysubmit=yes&infloat=yes&handlekey=livereplypost&inajax=1" onsubmit="return livereplypostvalidate(this)">
					<div id="livefastcomment">
						<textarea id="livereplymessage" name="message" style="color:gray;<!--{if !$liveallowpostreply}-->display:none;<!--{/if}-->">{lang group_live_fastreply_notice}</textarea>
						<!--{if !$liveallowpostreply}-->
							<div>
								<!--{if !$_G[uid]}-->
									{lang login_to_reply} <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a>
								<!--{else}-->
									{lang no_permission_to_post}<a href="javascript:;" onclick="ajaxpost('livereplypostform', 'livereplypostreturn', 'livereplypostreturn', 'onerror', $('livereplysubmit'));" class="xi2">{lang click_to_show_reason}</a>
								<!--{/if}-->
							</div>
						<!--{/if}-->
					</div>
					<div id="livepostsubmit" style="display:none;">
					<!--{if $secqaacheck || $seccodecheck}-->
						<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id)"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
						<div class="mtm sec" style="text-align:right;"><!--{subtemplate common/seccheck}--></div>
					<!--{/if}-->
					<p class="ptm pnpost" style="margin-bottom:10px;">
					<button type="submit" name="replysubmit" class="pn pnc vm" style="float:right;" value="replysubmit" id="livereplysubmit">
						<strong>{lang group_live_post}</strong>
					</button>
					</p>
					</div>
					<input type="hidden" name="formhash" value="{FORMHASH}">
					<input type="hidden" name="subject" value="  ">
				</form>
			</div>
			<span id="livereplypostreturn"></span>
		</div>
		<script type="text/javascript" src="{$_G['setting']['jspath']}seditor.js?{VERHASH}"></script>
		<script type="text/javascript">
			var postminchars = parseInt('$_G['setting']['minpostsize']');
			var postmaxchars = parseInt('$_G['setting']['maxpostsize']');
			var disablepostctrl = parseInt('{$_G['group']['disablepostctrl']}');
			var replycontentlist = new Array();
			var addreplylist = new Array();
			var timeoutid = timeid = movescrollid = waitescrollid = null;
			var replycontentnum = 0;
			getnewlivepostlist(1);
			timeid = setInterval(getnewlivepostlist, 5000);
			$('livereplycontent').style.width = ($('livereplycontentout').clientWidth - 50) + 'px';
			$('livereplymessage').onfocus = function() {
				if(this.style.color == 'gray') {
					this.value = '';
					this.style.color = 'black';
					$('livepostsubmit').style.display = 'block';
					this.style.height = '56px';
					$('livefastcomment').style.height = '57px';
				}
			};
			$('livereplymessage').onblur = function() {
				if(this.value == '') {
					this.style.color = 'gray';
					this.value = '{lang group_live_fastreply_notice}';
				}
			};

			$('liverefresh').onclick = function() {
				$('livereplycontent').style.position = 'absolute';
				getnewlivepostlist();
				this.style.display = 'none';
			};

			$('livereplycontentout').onmouseover = function(e) {

				if($('livereplycontent').style.position == 'absolute' && $('livereplycontent').clientHeight > 215) {
					$('livereplycontent').style.position = 'static';
					this.scrollTop = this.scrollHeight;
				}

				if(this.scrollTop + this.clientHeight != this.scrollHeight) {
					clearInterval(timeid);
					clearTimeout(timeoutid);
					clearInterval(movescrollid);
					timeid = timeoutid = movescrollid = null;

					if(waitescrollid == null) {
						waitescrollid = setTimeout(function() {
							$('liverefresh').style.display = 'block';
						}, 60000 * 10);
					}
				} else {
					clearTimeout(waitescrollid);
					waitescrollid = null;
				}
			};

			$('livereplycontentout').onmouseout = function(e) {

				if(this.scrollTop + this.clientHeight == this.scrollHeight) {
					$('livereplycontent').style.position = 'absolute';
					clearInterval(timeid);
					timeid = setInterval(getnewlivepostlist, 10000);
				}
			};

			function getnewlivepostlist(first) {
				var x = new Ajax('JSON');
				x.getJSON('forum.php?mod=misc&action=livelastpost&fid=$livethread[fid]', function(s, x) {
					var count = s.data.count;
					$('livereplies').innerHTML = count;
					var newpostlist = s.data.list;
					for(i in newpostlist) {
						var postid = i;
						var postcontent = '';
						postcontent += '<dt><a href="home.php?mod=space&uid=' + newpostlist[i].authorid + '" target="_blank">' + newpostlist[i].avatar + '</a></dt>';
						postcontent += '<dd><a href="home.php?mod=space&uid=' + newpostlist[i].authorid + '" target="_blank">' + newpostlist[i].author + '</a></dd>';
						postcontent += '<dd>' + newpostlist[i].message + '</dd>';
						postcontent += '<dd class="dateline">' + newpostlist[i].dateline + '</dd>';
						if(replycontentlist[postid]) {
							$('livereply_' + postid).innerHTML = postcontent;
							continue;
						}
						addreplylist[postid] = '<dl id="livereply_' + postid + '">' + postcontent + '</dl>';
					}
					if(first) {
						for(i in addreplylist) {
							replycontentlist[i] = addreplylist[i];
							replycontentnum++;
							var div = document.createElement('div');
							div.innerHTML = addreplylist[i];
							$('livereplycontent').appendChild(div);
							delete addreplylist[i];
						}
					} else {
						livecontentfacemove();
					}
				});
			}

			function livecontentfacemove() {
				//note 从队列中取出数据
				var reply = '';
				for(i in addreplylist) {
					reply = replycontentlist[i] = addreplylist[i];
					replycontentnum++;
					delete addreplylist[i];
					break;
				}
				if(reply) {
					var div = document.createElement('div');
					div.innerHTML = reply;
					var oldclientHeight = $('livereplycontent').clientHeight;
					$('livereplycontent').appendChild(div);
					$('livereplycontentout').style.overflowY = 'hidden';
					$('livereplycontent').style.bottom = oldclientHeight - $('livereplycontent').clientHeight + 'px';

					if(replycontentnum > 20) {
						$('livereplycontent').removeChild($('livereplycontent').firstChild);
						for(i in replycontentlist) {
							delete replycontentlist[i];
							break;
						}
						replycontentnum--;
					}

					if(!movescrollid) {
						movescrollid = setInterval(function() {
							if(parseInt($('livereplycontent').style.bottom) < 0) {
								$('livereplycontent').style.bottom =
									((parseInt($('livereplycontent').style.bottom) + 5) > 0 ? 0 : (parseInt($('livereplycontent').style.bottom) + 5)) + 'px';
							} else {
								$('livereplycontentout').style.overflowY = 'auto';
								clearInterval(movescrollid);
								movescrollid = null;
								timeoutid = setTimeout(livecontentfacemove, 1000);
							}
						}, 100);
					}
				}
			}

			function livereplypostvalidate(theform) {
				var s;
				if(theform.message.value == '' || $('livereplymessage').style.color == 'gray') {
					s = '{lang group_live_nocontent_error}';
				}
				if(s) {
					showError(s);
					doane();
					$('livereplysubmit').disabled = false;
					return false;
				}
				$('livereplysubmit').disabled = true;
				theform.message.value = theform.message.value.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, '$1[img]$2[/img]');
				theform.message.value = parseurl(theform.message.value);
				ajaxpost('livereplypostform', 'livereplypostreturn', 'livereplypostreturn', 'onerror', $('livereplysubmit'));
				return false;
			}

			function succeedhandle_livereplypost(url, msg, param) {
				$('livereplymessage').value = '';
				$('livereplycontent').style.position = 'absolute';
				if(param['sechash']) {
					updatesecqaa(param['sechash']);
					updateseccode(param['sechash']);
				}
				getnewlivepostlist();
			}
		</script>
	<!--{/if}-->
	<!--{if helper_access::check_module('group')}-->
	<div id="pgt" class="bm bw0 pgs cl">
		<div class="pg">
			<a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]" class="nxt">{lang view_all_threads}</a>
		</div>
		<a href="javascript:;" id="newspecial" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})" onclick="showWindow('newthread', 'forum.php?mod=post&action=newthread&fid=$_G[fid]')" title="{lang send_posts}"><img src="{IMGDIR}/pn_post.png" alt="{lang send_posts}" /></a>
	</div>
	<!--{/if}-->
	<div class="tl bm bml" id="threadlist">
		<div>
		<!--{if $newthreadlist['dateline']['data']}-->
			<table cellpadding="0" cellspacing="0" border="0">
				<!--{loop $newthreadlist['dateline']['data'] $thread}-->
					<tbody>
						<tr>
									<td class="avt" style="width:60px;padding-left:0">
										<!--{if $thread['authorid'] && $thread['author']}-->
											<a href="home.php?mod=space&uid=$thread[authorid]"><!--{avatar($thread[authorid],small)}--></a>
										<!--{else}-->
											<a><img src="$_G['style']['styleimgdir']/hidden.gif" title="$_G[setting][anonymoustext]" alt="$_G[setting][anonymoustext]" /></a>
										<!--{/if}-->
									</td>
									<th class="$thread[folder]">
										<!--{hook/forumdisplay_thread $key}-->
										<!--{if !$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
											<!--{eval $thread[tid]=$thread[closed];}-->
										<!--{/if}-->
										<span class="xst">
											$thread[typehtml] $thread[sorthtml]
											<!--{if $thread['moved']}-->
												{lang thread_moved}:<!--{eval $thread[tid]=$thread[closed];}-->
											<!--{/if}-->
											<a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"$thread[highlight]{if $thread['isgroup'] == 1 || $thread['forumstick']} target="_blank"{else} onclick="atarget(this)"{/if}>$thread[subject]</a>
										</span>
										<!--{if $thread['replycredit'] > 0}-->
											- <span class="xi1">[{lang replycredit} <strong> $thread['replycredit']</strong> ]</span>
										<!--{/if}-->
										<!--{hook/forumdisplay_thread_subject $key}-->
										<!--{if $thread[multipage]}-->
											<span class="tps">$thread[multipage]</span>
										<!--{/if}-->
										<!--{if $thread['weeknew']}-->
											<a href="forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost#lastpost" class="xi1">New</a>
										<!--{/if}-->
										<!--{if !$thread['forumstick'] && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
											<!--{if $thread['related_group'] == 0 && $thread['closed'] > 1}-->
												<!--{eval $thread[tid]=$thread[closed];}-->
											<!--{/if}-->
											<!--{if $groupnames[$thread[tid]]}-->
												<span class="fromg xg1"> [{lang from}: <a href="forum.php?mod=forumdisplay&fid={$groupnames[$thread[tid]][fid]}" target="_blank" class="xg1">{$groupnames[$thread[tid]][name]}</a>]</span>
											<!--{/if}-->
										<!--{/if}-->

										<p class="mtn xg1" style="font-size: 12px">
											<!--{hook/forumdisplay_author $key}-->
											<!--{if $thread['authorid'] && $thread['author']}-->
												<span>{lang author}:</span><a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
											<!--{else}-->
												<span>{lang author}:</span>$_G[setting][anonymoustext]
											<!--{/if}-->
											&nbsp;
											<span>{lang group_live_post}{lang time}:</span><span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span>
										<span>&nbsp;{lang lastpost}: <!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}" c="1">$thread[lastposter]</a>&nbsp;/<!--{else}-->$_G[setting][anonymoustext]&nbsp;/<!--{/if}-->&nbsp;<a href="{if $thread[digest] != -2}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}">$thread[lastpost]</a></span>
										</p>
									</th>
									<td class="flt">
									</td>
									<td class="flt">
									</td>
									<td class="by" style="padding-right:0">
									<div class="xld" style="float: right"><dd class="m hm"><strong class="xi2">$thread[allreplies]</strong><span>{lang reply}</span></dd><dd class="m hm" style="margin-right:0"><strong class="xi2"><!--{if $thread['isgroup'] != 1}-->$thread[views]<!--{else}-->{$groupnames[$thread[tid]][views]}<!--{/if}--></strong><span>{lang focus_show}</span></dd></div>
									</td>
						</tr>
					</tbody>
				<!--{/loop}-->
				<!--{if $_G['forum']['threads'] > 10}-->
					<tbody>
						<tr class="bw0_all">
							<td colspan="5" class="ptm"><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]#groupnav" class="y xi2">{lang click_to_readmore}</a></td>
						</tr>
					</tbody>
				<!--{/if}-->
			</table>
		<!--{else}-->
			<p class="emp">{lang forum_nothreads}</p>
		<!--{/if}-->
		</div>
	</div>
	<div class="bm bml">
		<div class="bm_h cl">
			<h2>{lang group_member_status}</h2>
		</div>
		<div class="bm_c">
			<!--{if $groupfeedlist}-->
				<ul class="el">
					<!--{loop $groupfeedlist $feed}-->
					<dl>
					<div style="padding-left:37px">
						<!--{if $user[uid]}-->
						<dd style="width: 35px;margin-left:-37px;float:left;display: inline"><a href="home.php?mod=space&uid=$user[uid]" target="_blank" c="1" class="avt elavt"><!--{avatar($user[uid],small)}--></a></dd>
						<!--{/if}-->
						<dd style="float:left;overflow: hidden;width: 100%;height:20px;margin-top:6px"><ul><!--{if !empty($feed[title_template])}-->$feed[title_template]<!--{/if}--> <!--{if !empty($feed[body_data][subject])}-->$feed[body_data][subject]<!--{/if}--></ul></dd>
					</div>
					</dl>
					<!--{/loop}-->
				</ul>
			<!--{else}-->
				<p class="emp">{lang group_no_latest_feeds}</p>
			<!--{/if}-->
		</div>
	</div>
	<!--{if $_G['group']['allowpost'] && ($_G['group']['allowposttrade'] || $_G['group']['allowpostpoll'] || $_G['group']['allowpostreward'] || $_G['group']['allowpostactivity'] || $_G['group']['allowpostdebate'] || $_G['setting']['threadplugins'] || $_G['forum']['threadsorts'])}-->
		<ul class="p_pop" id="newspecial_menu" style="display: none">
			<!--{if !$_G['forum']['allowspecialonly']}--><li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" onclick="showWindow('newthread', this.href);doane(event)">{lang post_newthread}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostpoll']}--><li class="poll"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=1">{lang post_newthreadpoll}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostreward']}--><li class="reward"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=3">{lang post_newthreadreward}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostdebate']}--><li class="debate"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=5">{lang post_newthreaddebate}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowpostactivity']}--><li class="activity"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=4">{lang post_newthreadactivity}</a></li><!--{/if}-->
			<!--{if $_G['group']['allowposttrade']}--><li class="trade"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&special=2">{lang post_newthreadtrade}</a></li><!--{/if}-->
			<!--{if $_G['setting']['threadplugins']}-->
				<!--{loop $_G['forum']['threadplugin'] $tpid}-->
					<!--{if array_key_exists($tpid, $_G['setting']['threadplugins']) && @in_array($tpid, $_G['group']['allowthreadplugin'])}-->
						<li class="popupmenu_option"{if $_G['setting']['threadplugins'][$tpid][icon]} style="background-image:url($_G[setting][threadplugins][$tpid][icon])"{/if}><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&specialextra=$tpid">{$_G[setting][threadplugins][$tpid][name]}</a></li>
					<!--{/if}-->
				<!--{/loop}-->
			<!--{/if}-->
			<!--{if $_G['forum']['threadsorts'] && !$_G['forum']['allowspecialonly']}-->
				<!--{loop $_G['forum']['threadsorts']['types'] $id $threadsorts}-->
					<!--{if $_G['forum']['threadsorts']['show'][$id]}-->
						<li class="popupmenu_option"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&extra=$extra&sortid=$id">$threadsorts</a></li>
					<!--{/if}-->
				<!--{/loop}-->
			<!--{/if}-->
		</ul>
	<!--{/if}-->
<!--{/if}-->
