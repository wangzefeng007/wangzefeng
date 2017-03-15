$(function(){
  $('.main-i img').click(function(){
    var _imgs = [];
    _imgs.push($(this).attr('src'));
    $(this).parent().siblings().each(function(){
      _imgs.push($(this).find('img').attr('src'));
    });
    showImgs(_imgs);
  });

  $('.det-i img').click(function(){
    var _imgs = [];
    _imgs.push($(this).attr('src'));
    $(this).parent().siblings().each(function(){
      _imgs.push($(this).find('img').attr('src'));
    });
    showImgs(_imgs);
  });

  function showImgs(imgs){
    layer.open({
      type: 1,
      title: 0,
      area: ["880px", "560px"],
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
});
