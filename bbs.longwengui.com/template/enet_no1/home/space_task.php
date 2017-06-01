<?php exit;?>
<!--{template common/header}-->
<div id="ct" class="ct7_a wp cl">
<div class="apps">
 <div class="tbn" style="margin:0">
 			<h2 class="mt">{lang task}</h2>
			<ul>
				<li$actives[new]><a href="home.php?mod=task&item=new">{lang task_new}</a></li>
				<li$actives[doing]><a href="home.php?mod=task&item=doing">{lang task_doing}</a></li>
				<li$actives[done]><a href="home.php?mod=task&item=done">{lang task_done}</a></li>
				<li$actives[failed]><a href="home.php?mod=task&item=failed">{lang task_failed}</a></li>
			</ul>
		</div>
</div>
	<div class="mn">
		<div class="bm bw0">
		<!--{if empty($do)}-->
			<!--{subtemplate home/space_task_list}-->
		<!--{elseif $do == 'view'}-->
			<!--{subtemplate home/space_task_detail}-->
		<!--{/if}-->
		</div>
	</div>
</div>
<!--{template common/footer}-->