<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('guide');
0
|| checktplrefresh('./template/moke8_dztouch/touch/forum/guide.htm', './template/moke8_dztouch/touch/forum/guide_list_row.htm', 1496305505, '3', './data/template/3_3_touch_forum_guide.tpl.php', './template/moke8_dztouch', 'touch/forum/guide')
;?><?php include template('common/header'); ?><section class="s_top">
<form method="post" id="searchform" autocomplete="off" action="search.php?mod=forum&amp;mobile=2">
<section class="s_publicwarp">
<div class="s_publicsearch">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="searchsubmit" value="yes">
<input type="text" name="srchtxt" value="<?php echo $keyword;?>" autocomplete="off"  placeholder="搜索帖子" class="s-kw_box" id="w"></div>
<span class="srchtxt" onClick="javascript:$('#w').val('');$(this).hide();"></span>
<input type="submit" value="搜索" id="scform_submit"></section>
</form>
</section>
<section class="s_hdp">
<div class="s_box pr">
<div class="mid01_box pr" id="slider0">
<ul class="pr s_ul6 clears">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['carousel'];?>
</ul>
</div>
</div>
<div id="pagenavi0" class="img_page">
<a href="javascript:void(0)" class="active"></a>&nbsp;<a href="javascript:void(0)"></a>&nbsp;<a href="javascript:void(0)"></a>&nbsp;<a href="javascript:void(0)"></a>&nbsp;<a href="javascript:void(0)"></a>
</div>
</section>

<div class="module module-margin">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['newestpost'];?>
</div><?php if(is_array($data)) foreach($data as $key => $list) { if($list['threadcount']) { ?>
<div class="box_css">
<div class="s_shead">
<ul id="pagenavi1" class="page">
<li><a href="#" class="active"><?php echo $SC_LANG['essence'];?></a></li>
<li><a href="#"><?php echo $SC_LANG['hot'];?></a></li>
<li><a href="#"><?php echo $SC_LANG['bbs'];?></a></li>
</ul>
</div>
<div id="slider1" class="swipe">
<ul class="box01_list">

<li class="li_list">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['essencepost'];?>
</li>

<li class="li_list">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['hotpost'];?>
</li>
<li class="li_list">
<div class="m1 img">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['bbsplate'];?>
</div>
</li>
</ul>
</div>
</div>
<?php } else { ?>
<p>暂时还没有帖子</p>
<?php } } ?>

<section class="s_list">
<?php echo $_G['cache']['plugin']['superman_dz_manage']['indexadd'];?>
</section>




<script type="text/javascript">
var total=$(".box_css").length+1;
for(n=0;n<total;n++){
var page='pagenavi'+n;
var mslide='slider'+n;
var mtitle='emtitle'+n;
arrdiv = 'arrdiv' + n;
var as=document.getElementById(page).getElementsByTagName('a');
var tt=new TouchSlider({id:mslide,'auto':'-1',fx:'ease-out',direction:'left',speed:300,timeout:2000,'before':function(index){
var as=document.getElementById(this.page).getElementsByTagName('a');
as[this.p].className='';
as[index].className='active';
this.p=index;
}});
tt.page = page;
tt.p = 0;
for(var i=0;i<as.length;i++){
(function(){
var j=i;
as[j].tt = tt;
as[j].onclick=as[j].ontouchstart=function(){
this.tt.slide(j);
return false;
}
})();
}
}
</script><?php include template('common/footer'); ?>