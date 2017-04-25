//选中大图展示
$('.main-i img').click(function(){
  var _imgs = [];
  _imgs.push($(this).attr('src'));
  $(this).parent().siblings().each(function(){
    _imgs.push($(this).find('img').attr('src'));
  });
  showImgs(_imgs);
});

//选中小图展示
$('.det-i img').click(function(){
  var _imgs = [];
  _imgs.push($(this).attr('src'));
  $(this).parent().siblings().each(function(){
    _imgs.push($(this).find('img').attr('src'));
  });
  showImgs(_imgs);
});

//展示图片
function showImgs(imgs){
  layer.open({
    type: 1,
    title: 0,
    area: "880px",
    closeBtn: 0,
    shadeClose: true,
    content:    '<div class="slide-container">'
              + '</div>'
  });
  var _imgData = [
    {
      "imgs": imgs
    }
  ];
  $('#slide-tmpl').tmpl(_imgData).appendTo('.slide-container');
  $('.slide-container').slide({"effect": "fold"});
}

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
