<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>
<!--{template common/header}-->
<!-- header start -->
<header class="header">
    <div class="n5-bbslb">
		<div class="n5-lbftan n5-anzj y"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" title="{lang send_threads}">{lang send_threads}</a></div>
		<div class="n5-lbftan y"><a href="forum.php?forumlist=1">返回</a></div>
        <img class="z" alt="$_G['forum'][name]" src="<!--{if $_G['forum'][icon]}-->data/attachment/common/$_G['forum'][icon]<!--{else}-->template/zhikai_baibiansj/touch/style/forum$_G[fid].png<!--{/if}-->">
		<h3><a href="forum.php?mod=forumdisplay&fid=$_G[fid]">$_G['forum'][name]</a></h3>
		<i>主题：$_G[forum][threads] 新帖：$_G[forum][todayposts]</i>
    </div>
</header>
<!-- header end -->

<!--{if $quicksearchlist && !$_GET['archiveid']}-->
	<!--{/if}-->
    <!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || $_G['forum']['threadsorts']}-->
    <div class="n5-ztfl" style="display:block">
        <!--{if $_G['forum']['threadtypes']}-->                        
            <a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="<!--{if $_GET['filter'] != 'typeid'}-->a<!--{/if}-->">{lang forum_viewall}</a>
            <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
                 <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]" {if $_GET['filter'] == 'typeid' && $_GET['typeid'] == $id} class="a"{/if}>$name</a>
            <!--{/loop}-->
        <!--{/if}-->
        <!--{if $_G['forum']['threadsorts']}-->                        
            <!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
                <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]" class="<!--{if $_GET[sortid] == $id}-->a<!--{/if}-->">$name</a>
            <!--{/loop}-->            
        <!--{/if}-->
    </div>
	<!--{subtemplate forum/search_sortoption}-->
<!--{/if}-->

<!--{hook/forumdisplay_top_mobile}-->
<!-- main threadlist start -->
<!--{if !$subforumonly}-->
    <!--{if empty($_G['forum']['picstyle']) || $_G['cookie']['forumdefstyle']}-->
<div class="threadlist n5-ztlb">

			<ul>
			<!--{if $_G['forum_threadcount']}-->
				<!--{loop $_G['forum_threadlist'] $key $thread}-->
					<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->
						{eval continue;}
					<!--{/if}-->
                	<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->
                		{eval $displayorder_thread = 1;}
                    <!--{/if}-->
					<!--{if $thread['moved']}-->
						<!--{eval $thread[tid]=$thread[closed];}-->
					<!--{/if}-->
					<li>
					<span class="z"><img src="uc_server/avatar.php?uid=$thread[authorid]&size=small"></span>
					<!--{hook/forumdisplay_thread_mobile $key}-->
                    <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" $thread[highlight] >
					{$thread[subject]}
					<span class="by">$thread[author]</span>
					</a>
					<span class="num">{$thread[replies]}</span>
					<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
						<span class="icon_top"><img src="{STATICURL}image/mobile/images/icon_top.png"></span>
					<!--{elseif $thread['digest'] > 0}-->
						<span class="icon_top"><img src="{STATICURL}image/mobile/images/icon_digest.png"></span>
					<!--{elseif $thread['attachment'] == 2 && $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
						<span class="icon_tu"><img src="{STATICURL}image/mobile/images/icon_tu.png"></span>
					<!--{/if}-->
					</li>
                <!--{/loop}-->
            <!--{else}-->
			<li>{lang forum_nothreads}</li>
			<!--{/if}-->
		</ul>
</div>
        <!--{else}-->               
<div class="n5-pbl">
    	<ul>
            <!--{if $_G['forum_threadcount']}-->
				<!--{loop $_G['forum_threadlist'] $key $thread}-->
					<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->
						{eval continue;}
					<!--{/if}-->
                	<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->
                		{eval $displayorder_thread = 1;}
                    <!--{/if}-->
					<!--{if $thread['moved']}-->
						<!--{eval $thread[tid]=$thread[closed];}-->
					<!--{/if}-->
				<li class="n5-pbldg">
                 <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"  >   
                    <!--{if $thread['cover']}-->
                    <img src="$thread[coverpath]"   class=""/>
                    <!--{else}-->
                    <img  src="template/zhikai_baibiansj/touch/style/mtts.png" class=""/>
                    <!--{/if}-->
                  </a>
					<!--{hook/forumdisplay_thread_mobile $key}-->
                    <div class="n5-pblnr"> 
                    <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra"><h2 class="n5-pblbt">{$thread[subject]}</h2></a>
                    </div>
				</li>
                <!--{/loop}-->
            <!--{else}-->
			<li>{lang forum_nothreads}</li>
			<!--{/if}-->
		</ul>
</div>
        <!--{/if}-->
$multipage
<!--{/if}-->
<!-- main threadlist end -->
<!--{hook/forumdisplay_bottom_mobile}-->
<div class="pullrefresh" style="display:none;"></div>

<div class="n5-lbydb"></div>

<!--底部菜单-->
<div id="contactbar">
	<a href="forum.php?forumlist=1" class="bottom_history_on"></a>
	<a href="forum.php?mod=misc&action=nav" class="bottom_post"></a>
	<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="bottom_member"></a>
</div>

<!--{hook/global_footer_mobile}-->
<!--{eval $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''}-->
<!--{if strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';}-->
<!--{elseif strpos($useragent, 'android') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';}-->
<!--{elseif strpos($useragent, 'windows phone') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';}-->
<!--{/if}-->

<div id="mask" style="display:none;"></div>
</body>
</html>
<!--{eval updatesession();}-->
<!--{if defined('IN_MOBILE')}-->
	<!--{eval output();}-->
<!--{else}-->
	<!--{eval output_preview();}-->
<!--{/if}-->

