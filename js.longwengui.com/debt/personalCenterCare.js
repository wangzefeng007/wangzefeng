$(function(){
  $('#care_way li').click(function(){
    var pre_sel = $('#care_way span').attr('data-type');
    var cur_sel = $(this).attr('data-type');
    if(pre_sel == 1){
      $('#debt_list').hide();
    }else if(pre_sel == 2){
      $('#debt_trans_list').hide();
    }else{
      $('#debt_reword_list').hide();
    }
    if(cur_sel == 1){
      $('#debt_list').show();
    }else if(cur_sel == 2){
      $('#debt_trans_list').show();
    }else{
      $('#debt_reword_list').show();
    }
    $('#care_way span').attr('data-type', cur_sel);
    $('#care_way span').html($(this).html());
  });
});
