//个人会员资料修改
$(function(){
  initArea();
  //保存修改
  $('#save').click(function(){
    var nick_name = $('input[name="nickName"]').val();
    var name = $('input[name="name"]').val();
    var idNum = $('input[name="idNum"]').val();
    var province = $('input[name="dd_province"]').siblings('span').attr('data-id');
    var city = $('input[name="dd_city"]').siblings('span').attr('data-id');
    var area = $('input[name="dd_area"]').siblings('span').attr('data-id');
    var images = []; //证明图片

    if(nick_name == ''){
      showMsg('昵称不能为空');
      return;
    }

    if(name == ''){
      showMsg('姓名不能为空');
      return;
    }
    if(!validate('chinese', name)){
      showMsg('姓名只能为中文');
      return;
    }

    if(idNum == ''){
      showMsg('身份证号不能为空');
      return;
    }
    if(!validate('idNum', idNum)){
      showMsg('身份证号输入有误');
      return;
    }

    $('.img-wrap').each(function(){
      if($(this).children('img').attr('src')){
        images.push($(this).children('img').attr('src'));
      }
    });

    if(images.length != 2){
      showMsg('请上传所需的证件照片');
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
      "nickName": nick_name, //昵称
      "name": name, //姓名
      "idNum": idNum, //身份证号
      "province": province, //省
      "city": city, //市
      "area": area, //县
      "images": images, //身份证照
      "areaDetail": area_detail, //详细地址
      "qq": qq, //qq
      "email": email, //邮箱
      "headImg": head_img//头像

    });
  });
  function ajax(formData){
    $.ajax({
      type: "post",
      url: "/loginajax.html",
      dataType: "json",
        data: {
            "Intention":"fdgd",
            "AjaxJSON":JSON.stringify(formData),
        },
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
          "Intention":"AddCardImage",
          "ImgBaseData": ImgBaseData,
      },
      beforeSend: function () {
          showLoading();
      },
      success: function(data) {
        if(data.ResultCode=='200'){
            showMsg('上传成功');
            $('.head-portrait img').attr("src", data.url);
            $('.menu-bar .u-img').attr("src", data.url);
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
        url: "/ajaximage",
        data: {
            "Intention":"AddCardImage",
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
