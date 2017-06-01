<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('guide');
0
|| checktplrefresh('./template/enet_no1/forum/guide.htm', './template/enet_no1/forum/guide_list_row.htm', 1496303471, '2', './data/template/2_2_forum_guide.tpl.php', './template/enet_no1', 'forum/guide')
;?><?php include template('common/header'); ?><style type="text/css">
.xl2 { background: url(<?php echo IMGDIR;?>/vline.png) repeat-y 50% 0; }
.xl2 li { width: 49.9%; }
.xl2 li em { padding-right: 10px; }
.xl2 .xl2_r em { padding-right: 0; }
.xl2 .xl2_r i { padding-left: 10px; }
</style>
<div class="boardnav" style="margin-top:10px">
<div id="ct" class="wp cl<?php if($_G['forum']['allowside']) { ?> ct2<?php } ?>"<?php if($leftside) { ?> style="margin-left:<?php echo $_G['leftsidewidth_mwidth'];?>px"<?php } ?>>
<div class="mn">
<?php if($view != 'index') { ?>
<div id="pgt" class="bw0 pgs cl y">
<a onclick="showWindow('nav', this.href, 'get', 0)" href="forum.php?mod=misc&amp;action=nav"><img src="<?php echo IMGDIR;?>/pn_post.png" alt="发新帖" /></a>
</div>
<?php } ?>
<ul id="thread_types" class="ttp bm cl">
<li <?php echo $currentview['hot'];?>><a href="forum.php?mod=guide&amp;view=hot">最新热门</a></li>
<li <?php echo $currentview['digest'];?>><a href="forum.php?mod=guide&amp;view=digest">最新精华</a></li>
<li <?php echo $currentview['new'];?>><a href="forum.php?mod=guide&amp;view=new">最新回复</a></li>
<li <?php echo $currentview['newthread'];?>><a href="forum.php?mod=guide&amp;view=newthread">最新发表</a></li>
<li <?php echo $currentview['sofa'];?>><a href="forum.php?mod=guide&amp;view=sofa">抢沙发</a></li>
<li <?php echo $currentview['my'];?>><a id="filter_special" href="forum.php?mod=guide&amp;view=my" onmouseover="showMenu(this.id)">我的帖子</a></li>
<?php if(!empty($_G['setting']['pluginhooks']['guide_nav_extra'])) echo $_G['setting']['pluginhooks']['guide_nav_extra'];?>
</ul>
<?php if(!empty($_G['setting']['pluginhooks']['guide_top'])) echo $_G['setting']['pluginhooks']['guide_top'];?>
<?php if($view == 'index') { if(is_array($data)) foreach($data as $key => $list) { ?><div class="bm bmw">
<div class="bm_h">
<a href="forum.php?mod=guide&amp;view=<?php echo $key;?>" class="y xi2">更多 &raquo;</a>
<h2>
<?php if($key == 'hot') { ?>最新热门<?php } elseif($key == 'digest') { ?>最新精华<?php } elseif($key == 'newthread') { ?>最新发表<?php } elseif($key == 'new') { ?>最新回复<?php } elseif($key == 'my') { ?>我的帖子<?php } ?>
</h2>
</div>
 <div class="bm_c">
 	<div class="xl xl2 cl">
 		<?php if($list['threadcount']) { ?>
 <?php $i=0;?> <?php if(is_array($list['threadlist'])) foreach($list['threadlist'] as $thread) { ?> <?php $i++;$newtd=$i%2;?> 			<li<?php if(!$newtd) { ?> class="xl2_r"<?php } ?>>
 			<em>
 			<?php if($key == 'hot') { ?><span class="xi1"><?php echo $thread['heats'];?>人参与</span><?php } ?>
 			<?php if($key == 'new') { ?><?php echo $thread['lastpost'];?><?php } ?>
 			</em>
 			
 			<i>&middot; <a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;<?php if($_GET['archiveid']) { ?>archiveid=<?php echo $_GET['archiveid'];?>&amp;<?php } ?>extra=<?php echo $extra;?>"<?php echo $thread['highlight'];?> target="_blank"><?php echo $thread['subject'];?></a></i>&nbsp;<span class="xg1"><a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $thread['fid'];?>" target="_blank"><?php echo $list['forumnames'][$thread['fid']]['name'];?></a></span>
 			</li>
 			<?php } ?>
 		<?php } else { ?>
 				<p class="emp">暂时还没有帖子</p>
 		<?php } ?>
 	</div>
</div>
</div>
<?php } } else { if(is_array($data)) foreach($data as $key => $list) { ?><div id="threadlist" class="tl bm bmw"<?php if($_G['uid']) { ?> style="position: relative;"<?php } ?>>
<?php if($view == 'my') { ?>
<div class="th tf">
<table cellspacing="0" cellpadding="0">
<tr>
<th colspan="2">
<a href="forum.php?mod=guide&amp;view=my&amp;type=thread" <?php echo $orderactives['thread'];?>>主题</a>
<a href="forum.php?mod=guide&amp;view=my&amp;type=reply" <?php echo $orderactives['reply'];?>>回复</a>
<a href="forum.php?mod=guide&amp;view=my&amp;type=postcomment" <?php echo $orderactives['postcomment'];?>>点评</a>
<?php if($viewtype != 'postcomment') { ?>
<a href="#" onclick="var displayvalue = $('searchbody').style.display == 'none' ? '' : 'none';$('searchbody').style.display=displayvalue; return false;">筛选</a>
<?php } if($view == 'my') { ?>
<tbody class="bw0_all" id="searchbody"<?php if(!$searchbody) { ?> style="display: none"<?php } ?>>
<tr>
<th colspan="6">
<form method="get" action="forum.php">
<input type="hidden" name="mod" value="guide">
<input type="hidden" name="view" value="my">
<input type="hidden" name="type" value="<?php echo $viewtype;?>">
<?php if($viewtype != 'postcomment') { ?>
状态:
<select name="filter" id="filter">
<option value="">全部</option><?php if(is_array($filter_array)) foreach($filter_array as $fkey => $name) { ?><option value="<?php echo $fkey;?>" <?php if($fkey == $_GET['filter']) { ?>selected<?php } ?>><?php echo $name;?></option>
<?php } ?>
</select>
选择版块:
<select name="fid" id="forumlist">
<option value="0">全部</option>
<?php echo $forumlist;?>
</select>
<?php } if($viewtype == 'thread') { ?>
&nbsp; 关键字: <input type="text" id="searchmypost" class="px vm" name="searchkey" size="20" value="<?php echo $searchkey;?>" >
<?php } ?><button class="pn vm"><strong>搜索</strong></button>
</form>
</th>
</tr>
</tbody>
<?php } ?>
</th>
</tr>
</table>
</div>
<?php } ?>
<div class="bm_c">
<div id="forumnew" style="display:none"></div>
<table cellspacing="0" cellpadding="0"><?php if($list['threadcount']) { if(is_array($list['threadlist'])) foreach($list['threadlist'] as $key => $thread) { ?><tbody id="<?php echo $thread['id'];?>">
<tr>
<td class="avt">
<?php if($thread['authorid'] && $thread['author']) { ?>
<a href="home.php?mod=space&amp;uid=<?php echo $thread['authorid'];?>"><?php echo avatar($thread[authorid],small);?></a>
<?php } else { ?>
<a><img src="<?php echo $_G['style']['styleimgdir'];?>/hidden.gif" title="<?php echo $_G['setting']['anonymoustext'];?>" alt="<?php echo $_G['setting']['anonymoustext'];?>" /></a>
<?php } ?>
</td>
<th class="<?php echo $thread['folder'];?>">
<?php if(!empty($_G['setting']['pluginhooks']['forumdisplay_thread'][$key])) echo $_G['setting']['pluginhooks']['forumdisplay_thread'][$key];?>
<?php if(!$thread['forumstick'] && $thread['closed'] > 1 && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { $thread[tid]=$thread[closed];?><?php } ?>
<span class="xst">
<?php echo $thread['typehtml'];?> <?php echo $thread['sorthtml'];?>
<?php if($thread['moved']) { ?>
移动:<?php $thread[tid]=$thread[closed];?><?php } ?>
<a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;<?php if($_GET['archiveid']) { ?>archiveid=<?php echo $_GET['archiveid'];?>&amp;<?php } ?>extra=<?php echo $extra;?>"<?php echo $thread['highlight'];?>><?php echo $thread['subject'];?></a>
</span>
<?php if($thread['icon'] >= 0) { ?>
<img src="<?php echo STATICURL;?>image/stamp/<?php echo $_G['cache']['stamps'][$thread['icon']]['url'];?>" alt="<?php echo $_G['cache']['stamps'][$thread['icon']]['text'];?>" align="absmiddle" />
<?php } if($thread['folder'] == 'lock') { ?>
<img src="<?php echo IMGDIR;?>/folder_lock.gif" title="关闭的主题" alt="关闭的主题" align="absmiddle" />
<?php } elseif($thread['special'] == 1) { ?>
<img src="<?php echo IMGDIR;?>/pollsmall.gif" title="投票" alt="投票" align="absmiddle" />
<?php } elseif($thread['special'] == 2) { ?>
<img src="<?php echo IMGDIR;?>/tradesmall.gif" title="商品" alt="商品" align="absmiddle" />
<?php } elseif($thread['special'] == 3) { ?>
<img src="<?php echo IMGDIR;?>/rewardsmall.gif" title="悬赏" alt="悬赏" align="absmiddle" />
<?php } elseif($thread['special'] == 4) { ?>
<img src="<?php echo IMGDIR;?>/activitysmall.gif" title="活动" alt="活动" align="absmiddle" />
<?php } elseif($thread['special'] == 5) { ?>
<img src="<?php echo IMGDIR;?>/debatesmall.gif" title="辩论" alt="辩论" align="absmiddle" />
<?php } elseif(in_array($thread['displayorder'], array(1, 2, 3, 4))) { ?>
<img src="<?php echo IMGDIR;?>/pin_<?php echo $thread['displayorder'];?>.gif" title="<?php echo $_G['setting']['threadsticky'][3-$thread['displayorder']];?>" alt="<?php echo $_G['setting']['threadsticky'][3-$thread['displayorder']];?>" align="absmiddle" />
<?php } if($thread['rushreply']) { ?>
<img src="<?php echo IMGDIR;?>/rushreply_s.png" alt="抢楼" align="absmiddle" />
<?php } if($stemplate && $sortid) { ?><?php echo $stemplate[$sortid][$thread['tid']];?><?php } if($thread['readperm']) { ?> - [阅读权限 <span class="xw1"><?php echo $thread['readperm'];?></span>]<?php } if($thread['price'] > 0) { if($thread['special'] == '3') { ?>
- <a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=specialtype&amp;specialtype=reward<?php echo $forumdisplayadd['specialtype'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>&amp;rewardtype=1" title="只看进行中的"><span class="xi1">[悬赏 <span class="xw1"><?php echo $thread['price'];?></span> <?php echo $_G['setting']['extcredits'][$_G['setting']['creditstransextra']['2']]['unit'];?><?php echo $_G['setting']['extcredits'][$_G['setting']['creditstransextra']['2']]['title'];?>]</span></a>
<?php } else { ?>
- [售价 <span class="xw1"><?php echo $thread['price'];?></span> <?php echo $_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['unit'];?><?php echo $_G['setting']['extcredits'][$_G['setting']['creditstransextra']['1']]['title'];?>]
<?php } } elseif($thread['special'] == '3' && $thread['price'] < 0) { ?>
- <a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>&amp;filter=specialtype&amp;specialtype=reward<?php echo $forumdisplayadd['specialtype'];?><?php if($_GET['archiveid']) { ?>&amp;archiveid=<?php echo $_GET['archiveid'];?><?php } ?>&amp;rewardtype=2" title="只看已解决的">[已解决]</a>
<?php } if($thread['attachment'] == 2) { ?>
<img src="<?php echo STATICURL;?>image/filetype/image_s.gif" alt="attach_img" title="图片附件" align="absmiddle" />
<?php } elseif($thread['attachment'] == 1) { ?>
<img src="<?php echo STATICURL;?>image/filetype/common.gif" alt="attachment" title="附件" align="absmiddle" />
<?php } if($thread['mobile']) { ?>
<img src="<?php echo IMGDIR;?>/mobile-attach-<?php echo $thread['mobile'];?>.png" alt="手机发帖" align="absmiddle" />
<?php } if($thread['digest'] > 0 && $filter != 'digest') { ?>
<img src="<?php echo IMGDIR;?>/digest_<?php echo $thread['digest'];?>.gif" align="absmiddle" alt="digest" title="精华 <?php echo $thread['digest'];?>" />
<?php } if($thread['displayorder'] == 0) { if($thread['recommendicon'] && $filter != 'recommend') { ?>
<img src="<?php echo IMGDIR;?>/recommend_<?php echo $thread['recommendicon'];?>.gif" align="absmiddle" alt="recommend" title="评价指数 <?php echo $thread['recommends'];?>" />
<?php } if($thread['heatlevel']) { ?>
<img src="<?php echo IMGDIR;?>/hot_<?php echo $thread['heatlevel'];?>.gif" align="absmiddle" alt="heatlevel" title="<?php echo $thread['heatlevel'];?> 热度" />
<?php } if($thread['rate'] > 0) { ?>
<img src="<?php echo IMGDIR;?>/agree.gif" align="absmiddle" alt="agree" title="帖子被加分" />
<?php } elseif($thread['rate'] < 0) { ?>
<img src="<?php echo IMGDIR;?>/disagree.gif" align="absmiddle" alt="disagree" title="帖子被减分" />
<?php } } if($thread['replycredit'] > 0) { ?>
- <span class="xi1">[回帖奖励 <strong> <?php echo $thread['replycredit'];?></strong> ]</span>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['forumdisplay_thread_subject'][$key])) echo $_G['setting']['pluginhooks']['forumdisplay_thread_subject'][$key];?>
<?php if($thread['multipage']) { ?>
<span class="tps"><?php echo $thread['multipage'];?></span>
<?php } if($thread['weeknew']) { ?>
<a href="forum.php?mod=redirect&amp;tid=<?php echo $thread['tid'];?>&amp;goto=lastpost#lastpost" class="xi1">New</a>
<?php } if(!$thread['forumstick'] && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])) { if($thread['related_group'] == 0 && $thread['closed'] > 1) { $thread[tid]=$thread[closed];?><?php } if($groupnames[$thread['tid']]) { ?>
<span class="fromg xg1"> [来自: <a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $groupnames[$thread['tid']]['fid'];?>" target="_blank" class="xg1"><?php echo $groupnames[$thread['tid']]['name'];?></a>]</span>
<?php } } if($view == 'my' && $viewtype=='reply' && !empty($tids[$thread['tid']])) { if(is_array($tids[$thread['tid']])) foreach($tids[$thread['tid']] as $pid) { $post = $posts[$pid];?><?php if($post['message']) { ?><p class="mtn xg1">&nbsp;<img src="<?php echo IMGDIR;?>/icon_quote_m_s.gif" class="vm" /> <a href="forum.php?mod=redirect&amp;goto=findpost&amp;ptid=<?php echo $thread['tid'];?>&amp;pid=<?php echo $pid;?>" target="_blank"><?php echo $post['message'];?></a> <img src="<?php echo IMGDIR;?>/icon_quote_m_e.gif" class="vm" /></p><?php } } } if($view == 'my' && $viewtype == 'postcomment') { ?>
<p class="mtn xg1"><?php echo $thread['comment'];?></p>
<?php } if($viewtype != 'postcomment') { ?>
<p class="mtn xg1" style="font-size: 12px">
<?php if(!empty($_G['setting']['pluginhooks']['forumdisplay_author'][$key])) echo $_G['setting']['pluginhooks']['forumdisplay_author'][$key];?>
<?php if($thread['authorid'] && $thread['author']) { ?>
<span>作者:</span><a href="home.php?mod=space&amp;uid=<?php echo $thread['authorid'];?>"><?php echo $thread['author'];?></a><?php if(!empty($verify[$thread['authorid']])) { ?> <?php echo $verify[$thread['authorid']];?><?php } } else { ?>
<span>作者:</span><?php echo $_G['setting']['anonymoustext'];?>
<?php } ?>
&nbsp;
<span>发布时间:</span><span<?php if($thread['istoday']) { ?> class="xi1"<?php } ?>><?php echo $thread['dateline'];?></span>
<span>&nbsp;最后发表: <?php if($thread['lastposter']) { ?><a href="<?php if($thread['digest'] != -2) { ?>home.php?mod=space&username=<?php echo $thread['lastposterenc'];?><?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?>&page=<?php echo max(1, $thread['pages']);; } ?>" c="1"><?php echo $thread['lastposter'];?></a>&nbsp;/<?php } else { ?><?php echo $_G['setting']['anonymoustext'];?>&nbsp;/<?php } ?>&nbsp;<a href="<?php if($thread['digest'] != -2) { ?>forum.php?mod=redirect&tid=<?php echo $thread['tid'];?>&goto=lastpost<?php echo $highlight;?>#lastpost<?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?>&page=<?php echo max(1, $thread['pages']);; } ?>"><?php echo $thread['lastpost'];?></a></span>
</p>
<?php } ?>
</th>
<td class="flt">
</td>
<td class="flt">
</td>
<td class="by">
<div class="xld" style="float: right"><dd class="m hm"><strong class="xi2"><?php echo $thread['replies'];?></strong><span>回复</span></dd><dd class="m hm"><strong class="xi2"><?php if($thread['isgroup'] != 1) { ?><?php echo $thread['views'];?><?php } else { ?><?php echo $thread['views'];?><?php } ?></strong><span>查看</span></dd></div>
</td>
</tr>
</tbody>
<?php } } else { ?>
<tbody class="bw0_all"><tr><th><p class="emp">暂时还没有帖子</p></th></tr></tbody>
<?php } ?></table>
</div>
</div>
<?php } ?>
<div class="bm bw0 pgs cl">
<?php echo $multipage;?>
<span class="pgb y"><a href="forum.php?mod=guide">导读首页</a></span>
</div>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['guide_bottom'])) echo $_G['setting']['pluginhooks']['guide_bottom'];?>
</div>
</div>
</div>
<?php if(!IS_ROBOT) { ?>
<div id="filter_special_menu" class="p_pop" style="display:none">
<ul>
<li><a href="home.php?mod=space&amp;do=poll&amp;view=me" target="_blank">投票</a></li>
<li><a href="home.php?mod=space&amp;do=trade&amp;view=me" target="_blank">商品</a></li>
<li><a href="home.php?mod=space&amp;do=reward&amp;view=me" target="_blank">悬赏</a></li>
<li><a href="home.php?mod=space&amp;do=activity&amp;view=me" target="_blank">活动</a></li>
</ul>
</div>
<?php } include template('common/footer'); ?>