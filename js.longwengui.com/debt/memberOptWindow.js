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
      "PreFee": 1, // 前期费用 0 无 1 有
      "SearchedAnytime": 1, // 是否随时找到 0 否 1 是
      "AbilityDebt": 1, //是否有偿还能力 0 否 1 是
      "Client": { //委托人信息
        "Name": "离地地",
        "PhoneNumber": "15763948801"
      }
      "DebtorInfos": [ //债务人信息 数组
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
      "DebtorOwnerInfos": [ //债权人信息 数组
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
      "BondsmanInfos": [ //保证人信息
        {
          "Name": "李霸天",
          "IdNum": 333333333333333333,
          "PhoneNumber": 15763948801,
          "BondsManRole": "个人"
        }
      ],
      "BondsgoodInfos": [ //保证无信息
        {
          "Name": "阿斯顿",
          "Details": "很牛逼的东西"
        }
      ]
    }
*/
function debtMatchDetails(details){
  var html = '';
  console.log(details);
  html += '<div class="debt-match">'
          +    '<div class="warn-hint">'
          +      '<div class="tl">'
          +        '处置方债务详情'
          +      '</div>'
          +      '<div class="debt-match-info">'
          +        '<div class="tt">债务基本信息</div>'
          +        '<div class="debtor-info">'
          +          '<div class="debtor-wrap">'
          +            '<div class="debtor-wrap-l">'
          +              '<p><span class="i-l">债务总额:</span>' + details.DebtAmount + '元</p>'
          +            '</div>'
          +            '<div class="debtor-wrap-r">'
          +              '<p><span class="i-l">前期费用:</span>' + (details.EarlyCost == 1 ? '有' : '无') + '</p>'
          +            '</div>'
          +            '<p class="m-0"><span class="i-l">保证人:</span>' + injectbminfo(details.WarrantorInfo) + '</p>'
          +            '<p><span class="i-l">抵押物:</span>' + injectbgInfo(details.GuaranteeInfo) + '</p>'
          +          '</div>'
          +        '</div>'
          +        '<div class="tt">处置方信息</div>'
          +        '<div class="debtor-info">'
          +          '<div class="debtor-wrap">'
          +            '<div class="debtor-wrap-l">'
          +              '<p><span class="i-l">公司名称:</span>' + details.Client.CompanyName + '</p>'
          +            '</div>'
          +            '<div class="debtor-wrap-r">'
          +              '<p><span class="i-l">电 话:</span>' + details.Client.Mobile + '</p>'
          +            '</div>'
          +          '</div>'
          +        '</div>'
          +        '<div class="tt">债务人信息</div>'
          +        '<div class="debtor-info">'
          +          injectDebtorInfo(details.DebtorInfos)
          +          '<div class="debtor-wrap">'
          +            '<p><span class="i-l">还款能力:</span>' + (details.RepaymentDebtor == 1 ? '有' : '无') + '</p>'
          +            '<p><span class="i-l">随时能找到:</span>' + (details.FindDebtor == 1 ? '是' : '否') + '</p>'
          +          '</div>'
          +        '</div>'
          +        '<div class="tt">债权人信息</div>'
          +        '<div class="debtor-info">'
          +         injectDebtorInfo(details.DebtorOwnerInfos)
          +        '</div>'
          +      '</div>'
          +      '<div class="btn mt-10">'
          +        '<button type="button" id="win_yes" name="ok">关闭</button>'
          +      '</div>'
          +  '</div>'


  var index = layer.open({
    type: 1,
    title: 0,
    area: ['810px', '710px'],
    closeBtn: 0,
    shadeClose: true,
    content: html
    });

    $('#win_yes').click(function(){
      layer.close(index);
    });

    //返回注入的保证人信息
    function injectbminfo(bondsmanInfos){
      if(!bondsmanInfos){
        return '无';
      }
      var temp = '';
      for(var i=0; i<bondsmanInfos.length; i++){
        if(i == 0){
          temp += bondsmanInfos.Name + (bondsmanInfos.PhoneNumber ? '(' + bondsmanInfos.PhoneNumber + ')' : '');
        }else{
          temp += '、' + bondsmanInfos.Name + (bondsmanInfos.PhoneNumber ? '(' + bondsmanInfos.PhoneNumber + ')' : '');
        }
      }
      return temp == '' ? '无' : temp;
    }
    //返回注入抵押物信息
    function injectbgInfo(bondsgoodInfos){
      if(!bondsgoodInfos){
        return '无';
      }
      var temp = '';
      for(var i=0; i<bondsgoodInfos.length; i++){
        if(i == 0){
          temp += bondsgoodInfos[i].Name;
        }else{
          temp += '、' + bondsgoodInfos[i].Name;
        }
      }
      return temp == '' ? '无' : temp;
    }
    //返回注入债务人信息
    function injectDebtorInfo(debtorInfos){
      var temp = '';
        temp += '<div class="debtor-wrap">'
              +   '<div class="debtor-wrap-l">'
              +     '<p><span class="i-l">姓 名:</span>' + debtorInfos.Name + '</p>'
              +     '<p><span class="i-l">身份证:</span>' + (debtorInfos.Card ? debtorInfos.Card : '无') + '</p>'
              +    '</div>'
              +    '<div class="debtor-wrap-r">'
              +      '<p><span class="i-l">电 话:</span>' + (debtorInfos.Phone ? debtorInfos.Phone : '无') + '</p>'
              +      '<p><span class="i-l">债务金额:</span>' + debtorInfos.Money + '元</p>'
              +    '</div>'
              +      '<p class="m-0"><span class="i-l">地 址:</span>' + debtorInfos.Province + '-' + debtorInfos.City + '-' + debtorInfos.Area + ' ' + debtorInfos.Address + '</p>'
              +    '</div>'
      return temp;
    }
}

//我的悬赏选中图片查看大图
$('.details-pt-big img').click(function(){
  var _imgs = [];
  _imgs.push($(this).attr('src'));
  $(this).parent().siblings().each(function(){
    _imgs.push($(this).find('img').attr('src'));
  });
  showImgs(_imgs);
});

$('.details-pt-small img').click(function(){
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
//取消债务关注
function cancelConcern(id){
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '/loginajax.html',
        data: {
            "Intention": 'CancelConcern',
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
}