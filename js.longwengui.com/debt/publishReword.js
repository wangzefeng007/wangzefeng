//适配ie8label
initIE8Label();
fixIE8Label();

//获得省级地区信息
//getProvinceData();
$(function(){
    //进入页面默认选中悬赏类型
    $("input[name='rewordType']").each(function(){
        if($(this).is(":checked")){
            typeChange(this);
        }
    });
    //修改悬赏类型
    $("input[name='rewordType']").on("change",function(){
        typeChange(this);
    });
});

/**
 * 悬赏类型变换
 * @param target
 */
function typeChange(tar){
    var target=$(tar).attr("target");
    $("#tab-con").empty();
    $("#"+target).tmpl().appendTo("#tab-con");
    $('#end_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '206px'}); //初始化日期选择器
    getProvinceData();
}
//打开协议窗口
function openProtocalWindow(){
  var index = layer.open({
    type: 1,
    title: 0,
    closeBtn: 0,
    area: '600px',
    shadeClose: true,
    content: '<div class="public-reword">'
            +  '<div class="protocal-pop">'
            +    '<div class="popup">'
            +        '<div class="hd">'
            +            '隆文贵软件许可及服务协议'
            +            '<div class="close" id="close_protocal">'
            +                '<img src="/Uploads/Debt/imgs/close_grey.png" alt="">'
            +            '</div>'
            +        '</div>'
            +        '<div class="cont">'
            +            '<div class="para">'
            +                '<p>感谢您使用隆文贵服务!《隆文贵软件许可及服务协议》（以下简称“本协议”）由武夷山隆文贵互联网信息咨询有限公司（以下简称“隆文贵”）和您签订。</p>'
            +                '<p>您使用隆文贵软件（以下简称“本软件”）及服务前，应当阅读并遵守“本协议”，并务必审慎阅读、充分理解各条款内容。您的下载、安装、使用、浏览、注册账号、登录等行为即视为您已阅读并同意上述协议的约束。</p>'
            +                '<p>一、协议的范围</p>'
            +                '<p>1.1本协议是您与隆文贵之间关于您下载、安装、使用本软件及相关服务所订立的协议。本协议中的“用户”,一般指经过隆文贵实名认证的注册会员，包括“个人用户”、“单位用户”和“律师用户”。“个人用户”是指使用本软件相关服务的个人；“单位用户”是指使用本软件相关服务的法人或非法人组织；“律师用户”是指使用本软件相关服务的律师或律师事务所。“用户”在软件中也称为“您”。</p>'
            +                '<p>1.2本协议同时包括隆文贵可能不断发布的关于本服务的相关协议、规则、合同等内容。上述内容在本软件中一经发布，即为本协议不可分割的组成部分，您同样应当遵守。</p>'
            +                '<p>1.3隆文贵可能会变更本协议及相关协议、规则、合同等内容，变更内容在本软件中一经公布，即应生效。如您继续使用，视为同意内容变更。</p>'
            +                '<p>二、关于本服务</p>'
            +                '<p>2.1 本服务的内容</p>'
            +            '</div>'
            +            '<div class="confirm-btn">'
            +                '<button type="button" id="agree_protocal" name="button">同意并继续</button>'
            +            '</div>'
            +        '</div>'
            +    '</div>'
            +   '</div>'
            + '</div>'
    });

    //关闭
    $('#close_protocal').click(function(){
      layer.close(index);
    });
    //同意协议
    $('#agree_protocal').click(function(){
      var _tar = $('.m-checkbox input[name="agreement"]')[0];
      _tar.checked = true;
      $('.m-checkbox input[name="agreement"]').siblings('i').addClass('m-checked');
      layer.close(index);
    });
}

//表单提交
function publish(){
  ajax();
}

function ajax() {
    var debt_owner, debtor;

    if (!$('input[name="agreement"]')[0].checked) {
        showMsg('请先同意线索悬赏协议');
        return;
    }
    var reword_type = $('input[name="rewordType"]:checked').val(); //悬赏类型
    var findMsg={};

    //找人
    if (reword_type == 1) {
        var find_name = $('#tab-con input[name="name"]').val();
        var find_sex = $('#tab-con input[name="sex"]').val();
        var find_age = $('#tab-con input[name="age"]').val();
        var find_height = $('#tab-con input[name="height"]').val();
        var find_idCard = $('#tab-con input[name="idNum"]').val();
        var last_time = $('#tab-con input[name="lastTime"]').val();
        var find_detail = $('#tab-con textarea[name="areaDetail"]').val();
        var contact_phone = $('#tab-con input[name="contactPhone"]').val();
        if (!find_name || !find_sex || !find_age || !find_height || !last_time || !find_detail||!contact_phone) {
            showMsg('请完善寻人信息');
            return;
        }
        findMsg={
            find_name:find_name,  //姓名
            find_sex:find_sex,    //性别
            find_age:find_age,     //年龄
            find_height:find_height,    //身高
            find_idCard:find_idCard,    //身份证号
            last_time:last_time,        //失联时间
            find_detail:find_detail,     //详细内容
            contact_phone:contact_phone     //联系电话号码
        }
    }
    //找财产
    if (reword_type == 2) {
        var dd_province = $('#tab-con input[name="dd_province"]').siblings("span").attr("data-id");
        var dd_city = $('#tab-con input[name="dd_city"]').siblings("span").attr("data-id");
        var dd_area = $('#tab-con input[name="dd_area"]').siblings("span").attr("data-id");
        var name = $('#tab-con input[name="name"]').val();
        var idNum = $('#tab-con input[name="idNum"]').val();
        var detailAddress = $('#tab-con input[name="detailAddress"]').val();
        var find_detail = $('#tab-con textarea[name="areaDetail"]').val();
        var contact_phone = $('#tab-con input[name="contactPhone"]').val();
        if (!dd_province || !dd_city || !dd_area || !name || !idNum || !detailAddress ||!find_detail||!contact_phone) {
            showMsg('请完善财产信息');
            return;
        }
        findMsg={
            dd_province:dd_province,    //省份
            dd_city:dd_city,            //城市
            dd_area:dd_area,            //区县
            name:name,                  //姓名
            idNum:idNum,                // 身份证号
            detail_address:detailAddress,   //地址
            find_detail:find_detail,        //详细内容
            contact_phone:contact_phone     //联系电话号码
        }
    }
    if(reword_type==3){
        var dd_province = $('#tab-con input[name="dd_province"]').siblings("span").attr("data-id");
        var dd_city = $('#tab-con input[name="dd_city"]').siblings("span").attr("data-id");
        var dd_area = $('#tab-con input[name="dd_area"]').siblings("span").attr("data-id");
        var lost_name = $('#tab-con input[name="name"]').val();
        var lost_time = $('#tab-con input[name="lastTime"]').val();
        var detailAddress = $('#tab-con input[name="detailAddress"]').val();
        var find_detail = $('#tab-con textarea[name="areaDetail"]').val();
        var contact_phone = $('#tab-con input[name="contactPhone"]').val();
        if (!dd_province || !dd_city || !dd_area || !lost_name || !lost_time || !detailAddress ||!find_detail||!contact_phone) {
            showMsg('请完善物品信息');
            return;
        }
        findMsg={
            dd_province:dd_province,        //省份
            dd_city:dd_city,                //城市
            dd_area:dd_area,                //区县
            lost_name:lost_name,            //丢失物品名称
            lost_time:lost_time,            //丢失时间
            detail_address:detailAddress,   //丢失地址
            find_detail:find_detail,        //详细内容
            contact_phone:contact_phone     //联系电话
        }
    }

  var img_voucher = []; //债务凭证图片地址

  $('.img-wrap').each(function(){
    if($(this).children('img').attr('src')){
      img_voucher.push($(this).children('img').attr('src'));
    }
  });

  if(img_voucher.length == 0){
    showMsg('请至少上传一张悬赏图片');
    return;
  }

  $.ajax({
    type: "post",
    dataType: "json",
    url: "/ajax.html",
      data: {
          "Intention":"ReleaseReward",
          "AjaxJSON":JSON.stringify({
              "findMsg":findMsg, //寻找信息
              "images": img_voucher, //债务凭证
              "reword_type": reword_type //悬赏类型
          }),
      },
    beforeSend: function(){
      showLoading();
    },
    success: function(data){
      if(data.ResultCode == 200){
          layer.msg(data.Message);
          //路由跳转
          setTimeout(function() {
              window.location = data.Url;
          }, 10);
      }else{
          layer.msg(data.Message);
      }
    },
    complete: function(){
      closeLoading();
    }
  });
}

//图片上传裁剪方法
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajax.html",
        data: {
            "Intention":"AddRewardImage",
            "ImgBaseData": ImgBaseData,
        },
        beforeSend: function () {
            showLoading();
        },
        success: function(data) {
          if(data.ResultCode=='200'){
              showMsg('上传成功');
              $(tar).parent().siblings('.img-wrap').html(
                "<img src='" + data.url + "' alt=''>"
              );
              setTimeout(function(){
                layer.close(index);
              }, 200);
          }else{
              layer.msg(data.Message);
          }
        },
        complete: function () { //加载完成提示
            closeLoading();
        }
    });
}
