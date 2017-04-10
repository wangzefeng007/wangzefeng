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

//债务发布方取消发布
function cancelDebt(id){
  var index = layer.open({
    type: 1,
    title: 0,
    area: '540px',
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint" id="cancel_debt">'
            +    '<div class="tl">'
            +      '请选择取消理由'
            +     '</div>'
            +    '<div class="tx">'
            +      '<div class="tx-l mb-10">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="cancelReason" data-name="债务金额已收回，取消发布" checked value="1">'
            +          '<i></i>'
            +          '债务金额已收回，取消发布'
            +        '</label>'
            +      '</div>'
            +      '</div>'
            +      '<div class="tx-l mb-10">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="cancelReason" data-name="债务人无法找到" value="2">'
            +          '<i></i>'
            +          '债务人无法找到'
            +        '</label>'
            +      '</div>'
            +      '</div>'
            +      '<div class="tx-l mb-10">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="cancelReason" data-name="债务人无偿还债务能力" value="3">'
            +          '<i></i>'
            +          '债务人无偿还债务能力'
            +        '</label>'
            +      '</div>'
            +      '</div>'
            +      '<div class="tx-l mb-10">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="cancelReason" value="0">'
            +          '<i></i>'
            +          '其它原因'
            +        '</label>'
            +      '</div>'
            +      '</div>'
            +      '<div class="tx-l mb-10">'
            +      '<textarea placeholder="请输入理由，不超过50个字" name="otherReason"></textarea>'
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
      var r = $('#cancel_debt input[name="cancelReason"]:checked').val();
      var reason;
      if(r != 0){
        reason = $('#cancel_debt input[name="cancelReason"]:checked').attr('data-name');
      }else{
        reason = $('#cancel_debt textarea[name="otherReason"]').val();
        if(reason == ''){
          showMsg('请输入其它原因');
          return;
        }
      }
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": 'CancelDebt',
          "id": id,
          "reason": reason
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

//继续发布
function publishAgain(id){
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
            +      '债务未能完成，是否继续发布?'
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
          "Intention": 'PublishAgain',
          "id": id
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
//去曝光
function goExport(id){
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
            +      '债务未能完成，是否立即曝光该债务?'
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
          "Intention": 'GoExport',
          "id": id
        },
        beforeSend: function(){
          showLoading();
        },
        success: function(data){
          if(data.ResultCode == 200){
            showMsg('操作成功');
            layer.close(index);
            //去曝光路由跳转

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
