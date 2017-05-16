$(function(){
  /*
   图片预览
   * */
    $(".grouped_elements").fancybox({
        showCloseButton:true,
        showNavArrows:true
    });

});



//选择其他城市情况
function otherCitySel(){
  var sel_id = $('#other_city').attr('data-id');
  var way = $('#way .sel a').html();
  switch (way) {
    case '全部':
      window.location.href = '/reword/' + sel_id + '/'
      break;
    case '找人':
      window.location.href = '/reword/' + sel_id + 'a1/'
      break;
    case '找财产':
      window.location.href = '/reword/' + sel_id + 'a2/'
      break;
    default:
      return;
  }
}
