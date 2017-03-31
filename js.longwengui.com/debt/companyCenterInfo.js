$(function(){
  initArea();

  $('#save').click(function(){
    var company_name = $('input[name="companyName"]').val();
    var registrant_name = $('input[name="registrantName"]').val();
    var idNum = $('input[name="idNum"]').val();
    var credit_num = $('input[name="creditNum"]').val();
    var province = $('input[name="dd_province"]').siblings('span').attr('data-id');
    var city = $('input[name="dd_city"]').siblings('span').attr('data-id');
    var area = $('input[name="dd_area"]').siblings('span').attr('data-id');
    var registrant_images = []; //证明图片
    var license;

    if(company_name == ''){
      showMsg('请输入您的公司名称');
      return;
    }
    if(!validate('chinese', company_name)){
      showMsg('公司名称只能为中文');
      return;
    }

    if(registrant_name == ''){
      showMsg('请输入公司注册人姓名');
      return;
    }
    if(!validate('chinese', registrant_name)){
      showMsg('姓名只能为中文');
      return;
    }

    if(idNum == ''){
      showMsg('请输入公司注册人身份证号');
      return;
    }
    if(!validate('idNum', idNum)){
      showMsg('请输入正确的身份证号');
      return;
    }

    $('#i_registrant .img-wrap').each(function(){
      if($(this).children('img').attr('src')){
        registrant_images.push($(this).children('img').attr('src'));
      }
    });

    if(registrant_images.length != 2){
      showMsg('请上传所需的身份证照片');
      return;
    }

    if(credit_num == ''){
      showMsg('请输入信用代码');
      return;
    }
    if(!validate('creditNum', credit_num)){
      showMsg('请输入正确的信用代码');
      return;
    }

    if($('#i_license .img-wrap').children('img').attr('src')){
      license = $('#i_license .img-wrap').children('img').attr('src');
    }else{
      showMsg('请上传所需的营业执照');
      return;
    }

    if(!province || !city || !area){
      showMsg('请输入完整的地址信息');
      return;
    }

    var area_detail = $('textarea[name="areaDetail"]').val();
    var qq = $('input[name="qq"]').val();
    var email = $('input[name="email"]').val();
    var head_img = $('.head-portrait img').attr('src');

    if(qq != '' && !validate('qq', qq)){
      showMsg('请输入正确的qq号');
      return;
    }

    if(email != '' && !validate('email', email)){
      showMsg('请输入正确的邮箱');
      return;
    }

    ajax({
      "companyName": company_name, //催收公司名称
      "registrantName": registrant_name, //公司注册人姓名
      "idNum": idNum, //注册人身份证号
      "creditNum": credit_num, //信用代码
      "province": province, //省
      "city": city, //市
      "area": area, //县
      "registrantImages": registrant_images, //注册人身份证照
      "license": license, //营业执照照片
      "areaDetail": area_detail, //详细地址
      "qq": qq, //qq
      "email": email, //邮箱
      "headImg": head_img //头像
    });
  });

  function ajax(formData){
    $.ajax({
      type: "post",
      url: "/loginajax.html",
      dataType: "json",
      data: JSON.stringify(formData),
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('保存成功');
          //路由跳转展示页面

        }else{
          showMsg(data.Message);
        }
      },
      complete: function(){
        closeLoading();
      }
    });
  }
});

//初始化省市县信息
function initArea(){
  var p_tar = $('input[name="dd_province"]');
  var p_id = p_tar.siblings('span').attr('data-id');
  var c_tar = $('input[name="dd_city"]');
  var c_id = c_tar.siblings('span').attr('data-id');

  getProvinceData();
  getCityData(p_id, p_tar);
  getAreaData(c_id, c_tar);
}

//修改头像
function changeHeadImg(tar, ImgBaseData, index){
  $.ajax({
      type: "post",
      dataType: "json",
      url: "/loginajax.html",
      data: {
          "Intention":"AddHeadImage",
          "ImgBaseData": ImgBaseData,
      },
      beforeSend: function () {
          showLoading();
      },
      success: function(data) {
        if(data.ResultCode=='200'){
            showMsg('上传成功');
            $(tar).parent().siblings('img').attr("src", data.url);
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

//上传证件照
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/loginajax.html",
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
