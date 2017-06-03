<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>

<section class="sidebar">
<div class="n5-cbl">
    <div class="n5-cbltx">
        <a href="<?php if($_G['uid']) { ?>home.php?mod=space&uid=<?php echo $_G['uid'];?>&do=profile&mycenter=1<?php } else { ?>member.php?mod=logging&action=login<?php } ?>" class="n5-tx"><?php echo avatar($_G[uid]);?></a>
<a href="<?php if($_G['uid']) { ?>home.php?mod=space&uid=<?php echo $_G['uid'];?>&do=profile&mycenter=1<?php } else { ?>member.php?mod=logging&action=login<?php } ?>" class="n5-hym"><?php if(empty($_G['uid'])) { ?>游客<?php } if($_G['uid']) { ?><?php echo $_G['username'];?><?php } ?>，<script language="JavaScript">
                        var mess1="";
                        day = new Date( )
                        hr = day.getHours( )
                        if (( hr >= 0 ) && (hr <= 4 ))
                        mess1="夜深好！"
                        if (( hr >= 4 ) && (hr < 7))
                        mess1="早上好！"
                        if (( hr >= 7 ) && (hr < 12))
                        mess1="上午好！"
                        if (( hr >= 12) && (hr <= 13))
                        mess1="中午好！"
                        if (( hr >= 13) && (hr <= 18))
                        mess1="下午好！"
                        if (( hr >= 18) && (hr <= 19))
                        mess1="傍晚好！"
                        if ((hr >= 19) && (hr <= 23))
                        mess1="晚上好！"
                        document.write(mess1)
                        </script></a>
</div>
<div class="n5-cblxm">
    <li class="shouye"><a href="forum.php?mod=guide">全站首页</a></li>
<li class="luntan"><a href="forum.php?forumlist=1">论坛导航</a></li>
<li class="geren"><a href="<?php if($_G['uid']) { ?>home.php?mod=space&uid=<?php echo $_G['uid'];?>&do=profile&mycenter=1<?php } else { ?>member.php?mod=logging&action=login<?php } ?>">个人中心</a></li>
<li class="sousuo"><a href="search.php?mod=forum">搜索一下</a></li>
<li class="shoucang"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=favorite&amp;view=me&amp;type=thread">我的收藏</a></li>
<li class="zhuti"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>&amp;do=thread&amp;view=me">我的主题</a></li>
<li class="xiaoxi"><a href="home.php?mod=space&amp;do=pm">我的消息</a></li>
<li class="ziliao"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>">我的资料</a></li>
</div>

</div>				
</section>

<script>
var jq = jQuery.noConflict(); 
jq( document ).ready(function() {
jq.ajaxSetup({
cache: false
});
jq( '.sidebar' ).simpleSidebar({
settings: {
opener: '#open-sb',
wrapper: '.wrapper',
animation: {
duration: 500,
easing: 'easeOutQuint'
}
},
sidebar: {
align: 'left',
width: 250,
closingLinks: 'a',
}
});
});
</script>

