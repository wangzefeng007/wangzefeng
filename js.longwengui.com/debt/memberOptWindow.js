//律师团队、催收公司、催客债权完成情况操作
function debtCompleteStatus(id){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint" id="debt_complete">'
            +    '<div class="tl">'
            +      '请选择完成情况'
            +     '</div>'
            +    '<div class="tx">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="completeStatus" checked value="3">'
            +          '<i></i>'
            +          '未完成'
            +        '</label>'
            +      '</div>'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="completeStatus" value="4">'
            +          '<i></i>'
            +          '部分完成'
            +        '</label>'
            +      '</div>'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="completeStatus" value="5">'
            +          '<i></i>'
            +          '全部完成'
            +        '</label>'
            +      '</div>'
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
      var status = $('#debt_complete input[name="completeStatus"]:checked').val();
      // Type 1 未完成 2 部分完成 3 全部完成
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": '',
          "id": id,
          "Status": status
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
