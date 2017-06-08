<?php echo 'NVbing5商业模板保护！购买正版模板请联系NVbing5客服QQ：2474414433';exit;?>

<section class="sidebar">
<div class="n5-cbl">
    <div class="n5-cbltx">
        <a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="n5-tx"><!--{avatar($_G[uid])}--></a>
		<a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" class="n5-hym"><!--{if empty($_G['uid'])}-->游客<!--{/if}--><!--{if $_G['uid']}-->$_G['username']<!--{/if}-->，<script language="JavaScript">
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
        <li class="ziliao"><a href="home.php?mod=space&uid={$_G[uid]}">我的资料</a></li>
        <li class="sousuo"><a href="search.php?mod=forum">搜索一下</a></li>
		<li class="zhuti"><a href="home.php?mod=space&uid={$_G[uid]}&do=thread&view=me">我的主题</a></li>
        <li class="shoucang"><a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">我的收藏</a></li>
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

