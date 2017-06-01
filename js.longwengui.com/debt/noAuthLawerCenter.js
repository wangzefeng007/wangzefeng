$(function(){
  $('#mydatepicker').dcalendarpicker({format: 'yyyy-mm-dd', width: '340px'}); //初始化日期选择器
  initArea();

  $('#save').click(function(){
    var name = $('input[name="name"]').val();
    var idNum = $('input[name="idNum"]').val();
    var jobNo = $('input[name="jobNo"]').val();
    var office = $('input[name="office"]').val();
    var province = $('input[name="dd_province"]').siblings('span').attr('data-id');
    var city = $('input[name="dd_city"]').siblings('span').attr('data-id');
    var area = $('input[name="dd_area"]').siblings('span').attr('data-id');
    var lawer_images = []; //证明图片
    var inspection_date = $('#mydatepicker').val();
    var type = $('#save').attr('data-type'); //类型

    if(name == ''){
      showMsg('请输入您的姓名');
      return;
    }
    if(!validate('chinese', name)){
      showMsg('姓名只能为中文');
      return;
    }

    if(idNum == ''){
      showMsg('请输入身份证号');
      return;
    }
    if(!validate('idNum', idNum)){
      showMsg('请输入正确的身份证号');
      return;
    }

    if(jobNo == ''){
      showMsg('请输入执业证号');
      return;
    }
    if(!validate('lawJobNo', jobNo)){
      showMsg('请输入正确的执业证号');
      return;
    }

    if(office == ''){
      showMsg('请输入您的所属律师事务所');
      return;
    }
    if(!validate('chinese', office)){
      showMsg('律师事务所名称为中文');
      return;
    }

    if(inspection_date == ''){
      showMsg('请输入您的年检日期');
      return;
    }

    $('.img-wrap').each(function(){
      if($(this).children('img').attr('src')){
        lawer_images.push($(this).children('img').attr('src'));
      }
    });

    if(lawer_images.length != 2){
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
      "name": name, //姓名
      "idNum": idNum, //身份证号
      "jobNo": jobNo, //执业证号
      "office": office, //所属律师事务所
      "inspectionDate": inspection_date, //年检时间
      "province": province, //省
      "city": city, //市
      "area": area, //县
      "images": lawer_images, //照片
      "areaDetail": area_detail, //详细地址
      "qq": qq, //qq
      "email": email, //邮箱
      "headImg": head_img, //头像
      "type":type //类型
    });
  });
  function ajax(formData){
    $.ajax({
      type: "post",
      url: "/loginajax.html",
      dataType: "json",
        data: {
            "Intention":"AddInformation",//保存个人资料
            "AjaxJSON": JSON.stringify(formData),
        },
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('保存成功');
          //路由跳转展示页面
            setTimeout(function() {
                window.location = data.Url;
            }, 10);
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
      url: "/ajaximage",
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
