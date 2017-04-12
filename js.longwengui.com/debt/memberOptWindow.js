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
          "Intention": 'ConfirmCompletion',//委托方选择完成情况
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

//债务发布方取消处置方匹配
function cancelDebtMatch(id){
  var index = layer.open({
    type: 1,
    title: 0,
    area: '540px',
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint" id="cancel_debt_match">'
            +    '<div class="tl">'
            +      '请选择取消理由'
            +     '</div>'
            +    '<div class="tx">'
            +      '<div class="tx-l mb-10">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="cancelReason" data-name="债务金额已收回，取消发布" checked value="1">'
            +          '<i></i>'
            +          '债务金额已收回，取消申请'
            +        '</label>'
            +      '</div>'
            +      '</div>'
            +      '<div class="tx-l mb-10">'
            +      '<div class="m-radio ml-10">'
            +        '<label type="radio">'
            +          '<input type="radio" name="cancelReason" data-name="债务人无法找到" value="2">'
            +          '<i></i>'
            +          '处置方长时间未做出回应，重新匹配'
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
      var r = $('#cancel_debt_match input[name="cancelReason"]:checked').val();
      var reason;
      if(r != 0){
        reason = $('#cancel_debt_match input[name="cancelReason"]:checked').attr('data-name');
      }else{
        reason = $('#cancel_debt_match textarea[name="otherReason"]').val();
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
          "Intention": 'CancelDebtMatch',
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

//处置方申请同意、拒绝
function debtMatchAgree(id, debtNum){
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
            +      '是否同意(债务编号: <span class="debt-num">' + debtNum + '</span>)债权的申请?'
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
          "Intention": 'DebtMatchAgree',
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
function debtMatchReject(id, debtNum){
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
            +      '是否拒绝(债务编号: <span class="debt-num">' + debtNum + '</span>)债权的申请?'
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
          "Intention": 'DebtMatchReject',
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

//律师团队、催收公司、催客处置方债权完成情况操作
function debtMatchCompleteStatus(id){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="warn-hint" id="debt_match_complete">'
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
      var status = $('#debt_match_complete input[name="completeStatus"]:checked').val();
      // Type 1 未完成 2 部分完成 3 全部完成
      $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
          "Intention": 'DebtMatchConfirmCompletion',//委托方选择完成情况
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

/*查看处置方详情
    details: {
      "DebtTotalMoney": 1000,
      "PreFee": 1,
      "SearchedAnytime": 1,
      "AbilityDebt": 1,
      "DebtorInfos": [
        {
          "Name": "李霸天",
          "IdNum": 333333333333333333,
          "PhoneNumber": 15763948801,
          "DebtMoney": 111,
          "Province": '福建省',
          "City": '厦门市',
          "Area": '思明区',
          "AreaDetail": '软件园二期'
        }
      ],
      "DebtorOwnerInfos": [
        {
          "Name": "李霸天",
          "IdNum": 333333333333333333,
          "PhoneNumber": 15763948801,
          "DebtMoney": 111,
          "Province": '福建省',
          "City": '厦门市',
          "Area": '思明区',
          "AreaDetail": '软件园二期'
        }
      ],
      "BondsmanInfos": [
        {
          "Name": "李霸天",
          "IdNum": 333333333333333333,
          "PhoneNumber": 15763948801,
          "BondsManRole": "个人"
        }
      ],
      "BondsgoodInfos": [
        {
          "Name": "阿斯顿",
          "Details": "很牛逼的东西"
        }
      ]
    }
*/
function debtMatchDetails(details){
  var html;

  var index = layer.open({
    type: 1,
    title: 0,
    area: '806px',
    closeBtn: 0,
    shadeClose: true,
    content: '<div class="debt-match">'
            +    '<div class="warn-hint">'
            +      '<div class="tl">'
            +        '处置方债务详情'
            +      '</div>'
            +      '<div class="debt-match-info">'
            +        '<div class="tt">债务基本信息</div>'
            +        '<div class="debtor-info">'
            +          '<div class="debtor-wrap">'
            +            '<div class="debtor-wrap-l">'
            +              '<p><span class="i-l">债务总额:</span>10000元</p>'
            +            '</div>'
            +            '<div class="debtor-wrap-r">'
            +              '<p><span class="i-l">前期费用:</span>有</p>'
            +            '</div>'
            +            '<p class="m-0"><span class="i-l">保证人:</span>李清河(15763948802)</p>'
            +            '<p><span class="i-l">抵押物:</span>车</p>'
            +          '</div>'
            +        '</div>'
            +        '<div class="tt">债务人信息</div>'
            +        '<div class="debtor-info">'
            +          '<div class="debtor-wrap">'
            +            '<div class="debtor-wrap-l">'
            +              '<p><span class="i-l">姓 名:</span>李霸天</p>'
            +              '<p><span class="i-l">身份证:</span>333333333333333333</p>'
            +            '</div>'
            +            '<div class="debtor-wrap-r">'
            +              '<p><span class="i-l">电 话:</span>15763948801</p>'
            +              '<p><span class="i-l">债务金额:</span>10000元</p>'
            +            '</div>'
            +            '<p class="m-0"><span class="i-l">地 址:</span>福建省-厦门市-思明区 软件园二期</p>'
            +          '</div>'
            +          '<div class="debtor-wrap">'
            +            '<p><span class="i-l">还款能力:</span>有</p>'
            +            '<p><span class="i-l">随时能找到:</span>是</p>'
            +          '</div>'
            +        '</div>'
            +        '<div class="tt">债权人信息</div>'
            +        '<div class="debtor-info">'
            +          '<div class="debtor-wrap">'
            +            '<div class="debtor-wrap-l">'
            +              '<p><span class="i-l">姓 名:</span>让你不还钱</p>'
            +              '<p><span class="i-l">身份证:</span>333333333333333333</p>'
            +            '</div>'
            +            '<div class="debtor-wrap-r">'
            +              '<p><span class="i-l">电 话:</span>15763948801</p>'
            +              '<p><span class="i-l">债务金额:</span>10000元</p>'
            +            '</div>'
            +            '<p class="m-0"><span class="i-l">地 址:</span>福建省-厦门市-思明区 软件园二期</p>'
            +        '</div>'
            +      '</div>'
            +    '</div>'
            +      '<div class="btn mt-10">'
            +        '<button type="button" id="win_yes" name="ok">确定</button>'
            +      '</div>'
            +  '</div>'
    });
}
