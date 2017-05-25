$(function(){
    //初始化日期选择器
  $('#mydatepicker2').dcalendarpicker({format: 'yyyy-mm-dd', width: '340px'});
  //地区
    initArea();
    //律师事务所资料保存
    $('#lawers_save').click(function(){
        var name = $('.tab-lawers input[name="name"]').val();
        var phone = $('.tab-lawers input[name="phone"]').val();
        var lawPerson = $('.tab-lawers input[name="lawPerson"]').val();
        var creditNum = $('.tab-lawers input[name="creditNum"]').val();
        var province = $('.tab-lawers input[name="dd_province"]').siblings('span').attr('data-id');
        var city = $('.tab-lawers input[name="dd_city"]').siblings('span').attr('data-id');
        var area = $('.tab-lawers input[name="dd_area"]').siblings('span').attr('data-id');
        var agentName = $('.tab-lawers input[name="agentName"]').val();
        var agentIdNum = $('.tab-lawers input[name="agentIdNum"]').val();
        var agentPhone = $('.tab-lawers input[name="agentPhone"]').val();
        var license_images = []; //营业执照图片
        var agent_images = []; //代理人证件照
        var inspection_date = $('#mydatepicker2').val();


        if(name == ''){
            showMsg('请输入事务所名称');
            $('.tab-lawers input[name="name"]').focus();
            return;
        }
        if(!validate('chinese', name)){
            showMsg('事务所名称只能为中文');
            $('.tab-lawers input[name="name"]').focus();
            return;
        }
        if(phone == ''){
            showMsg('请输入手机电话');
            $('.tab-lawers input[name="phone"]').focus();
            return;
        }
        if(!validate('phone', phone)){
            showMsg('请输入正确的手机或电话');
            $('.tab-lawers input[name="phone"]').focus();
            return;
        }
        if(lawPerson == ''){
            showMsg('请输入法定代表人');
            $('.tab-lawers input[name="lawPerson"]').focus();
            return;
        }
        if(!validate('chinese', lawPerson)){
            showMsg('法定代表人只能为中文');
            $('.tab-lawers input[name="lawPerson"]').focus();
            return;
        }
        if(creditNum == ''){
            showMsg('请输入信用代码');
            $('.tab-lawers input[name="creditNum"]').focus();
            return;
        }
        if(!validate('creditNum', creditNum)){
            showMsg('请输入正确的信用代码');
            $('.tab-lawers input[name="creditNum"]').focus();
            return;
        }
        if(inspection_date == ''){
            showMsg('请输入年检到期日');
            $('.tab-lawers #mydatepicker2').focus();
            return;
        }

        $('.tab-lawers .license .img-wrap').each(function(){
            if($(this).children('img').attr('src')){
                license_images.push($(this).children('img').attr('src'));
            }
        });

        if(license_images.length != 1){
            showMsg('请上传营业执照');
            return;
        }
        if(!province || !city || !area){
            showMsg('请输入您的地址信息');
            return;
        }
        if(agentName == ''){
            showMsg('请输入代理人姓名');
            $('.tab-lawers input[name="agentName"]').focus();
            return;
        }
        if(!validate('chinese', agentName)){
            showMsg('代理人姓名只能为中文');
            $('.tab-lawers input[name="agentName"]').focus();
            return;
        }
        if(agentIdNum == ''){
            showMsg('请输入代理人身份证号');
            $('.tab-lawers input[name="agentIdNum"]').focus();
            return;
        }
        if(!validate('idNum', agentIdNum)){
            showMsg('请输入正确的身份证号');
            $('.tab-lawers input[name="agentIdNum"]').focus();
            return;
        }
        if(agentPhone == ''){
            showMsg('请输入代理人手机号');
            $('.tab-lawers input[name="agentPhone"]').focus();
            return;
        }
        if(!validate('mobilePhone', agentPhone)){
            showMsg('请输入正确的手机号');
            $('.tab-lawers input[name="agentPhone"]').focus();
            return;
        }

        $('.tab-lawers .agentPic .img-wrap').each(function(){
            if($(this).children('img').attr('src')){
                agent_images.push($(this).children('img').attr('src'));
            }
        });
        if(agent_images.length != 2){
            showMsg('请上传证件照');
            return;
        }

        var area_detail = $('.tab-lawers textarea[name="areaDetail"]').val();
        ajax(6, {
            "name": name, //事务所名称
            "phone": phone, //手机电话
            "lawPerson": lawPerson, //法定代表人
            "creditNum": creditNum, //信用代码
            "inspectionDate": inspection_date, //年检时间
            "province": province, //省
            "city": city, //市
            "area": area, //县
            "license_images": license_images, //营业执照照片
            "agent_images": agent_images, //代理人证件照照片
            "areaDetail": area_detail, //详细地址
            "agentName":agentName,  //代理人姓名
            "agentIdNum":agentIdNum,  //代理人身份证号
            "agentPhone":agentPhone,  //代理人手机号
            "type":6
        });

    });
    //type: 4 保存为律师（个人） 6为律师事务所
    function ajax(type, formData){
        $.ajax({
            type: "post",
            url: "/loginajax.html",
            dataType: "json",
            data: {
                "Intention":"AddInformation",
                "AjaxJSON":JSON.stringify(formData),
            },
            beforeSend: function(){
                showLoading();
            },
            success: function(data){
                if(data.ResultCode == 200){
                    showMsg('保存成功');
                    //路由跳转
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
      type: "get",
      dataType: "json",
      url: "/Templates/Debt/data/imageUpload.json",
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
        type: "get",
        dataType: "json",
        url: "/Templates/Debt/data/imageUpload.json",
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
