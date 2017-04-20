$(function(){
  $('#end_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '424px'}); //初始化日期选择器
  $('#send_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '424px'}); //初始化日期选择器
  $('#edit').editable({inlineMode: false, alwaysBlank: true});
});

//截止时间改变
function endTimeChange(){
  var end_time = $('#end_time').val();
  var day = calcTime(end_time);
  $('#left_time').html('还有<span class="c-b">' + day + '</span>天')
}

//计算时间距离
function calcTime(end_time){
  var a = new Date();
  var now = new Date(a.getFullYear() + '-' + ((a.getMonth() + 1) > 9 ? (a.getMonth() + 1) : ('0' + (a.getMonth() + 1))) + '-' + (a.getDate() > 9 ? a.getDate() : ('0' + a.getDate())));
  var end_date = new Date(end_time);
  //如果截止日期不大于今天，不执行
  if(end_date > now){
    var dis = end_date.getTime() - now.getTime();
    return dis/(1000*3600*24);
  }else{
    return;
  }
}
