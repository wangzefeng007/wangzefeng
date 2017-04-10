var debtId = $('.info-wrap').attr('data-id');
//同意申请 name 公司名称 id 公司id
function agreeApply(name, id){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint">'
            +    '<div class="tl">'
            +      '提示'
            +     '</div>'
            +    '<div class="tx">'
            +      '是否同意' + '<span>' + name + '</span>' + '的申请？'
            +    '</div>'
            +    '<div class="btn">'
            +      '<button type="button" id="win_yes" name="ok">确定</button>'
            +      '<button type="button" id="win_no" name="cancel">取消</button>'
            +    '</div>'
            +  '</div>'
    });
    $('#win_no').click(function(){
      layer.close(index);
    });
    $('#win_yes').click(function(){
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": 'AgreeApply',
          "id": id,
          "debtId": debtId
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('操作成功');
            window.location.reload();
          }else{
            showMsg(data.Message);
          }
        },
        complete: function(){
          closeLoading();
        }
      });
    });
}
//拒绝申请
function rejectApply(name, id){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint">'
            +    '<div class="tl">'
            +      '提示'
            +     '</div>'
            +    '<div class="tx">'
            +      '是否拒绝' + '<span>' + name + '</span>' + '的申请？'
            +    '</div>'
            +    '<div class="btn">'
            +      '<button type="button" id="win_yes" name="ok">确定</button>'
            +      '<button type="button" id="win_no" name="cancel">取消</button>'
            +    '</div>'
            +  '</div>'
    });
    $('#win_no').click(function(){
      layer.close(index);
    });
    $('#win_yes').click(function(){
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": 'RejectApply',
          "id": id,
          "debtId": debtId
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('操作成功');
            window.location.reload();
          }else{
            showMsg(data.Message);
          }
        },
        complete: function(){
          closeLoading();
        }
      });
    });
}
