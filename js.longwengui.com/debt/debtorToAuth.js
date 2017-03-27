$(function(){
  $('#mydatepicker').dcalendarpicker({format: 'yyyy-mm-dd', width: '340px'}); //初始化日期选择器
  $('#mycalendar').dcalendar(); //初始化日历

  $('.tb').click(function(){
    var tab_name = $(this).attr('data-tab');
    var pre_tab_name = $('.bx-wraper .act').attr('data-tab');
    $('.bx-wraper .act').removeClass('act');
    $(this).addClass('act');
    $('.tab-' + pre_tab_name).hide();
    $('.tab-' + tab_name).show();
  });

  getProvinceData();


  //获得省级元素
  function getProvinceData(){
    $.ajax({
      type: 'get',
      dataType: 'json',
      url: '/Templates/Debt/data/Province.json',
      success: function(data){
        $('input[name="dd_province"]').each(function(){
          var _t = $(this).siblings('ul');
          var _html = '';
          for(var i=0; i<data.length; i++){
            _html +=   "<li data-id='"+ data[i].AreaID +"' data-name='" + data[i].CnName + "'>"
                    +     data[i].CnName
                    +  "</li>";
          }
          _t.html(_html);
          _t.children('li').click(function(){
            resetAreaDropdown($(this), 'p-dropdown');
            var _id = $(this).attr("data-id");
            var _name = $(this).attr("data-name");
            var _sel = $(this).parent().siblings("span");
            _sel.text(_name);
            _sel.attr('data-id', _id);
            getCityData(_id, _sel);
          });
        });
      }
    });
  }
  //获得市级元素
  function getCityData(_pid, _sel){
    $.ajax(
      {
        type: "get",
        dataType: "json",
        url: "/Templates/Debt/data/City.json",
        success: function(data){
          var _city = [];
          for(var i=0; i<data.length; i++){
            if(data[i].ParentID == _pid){
              _city.push(data[i]);
            }
          }
          var _html = '';
          for(var i=0; i<_city.length; i++){
            _html  +=   "<li data-id='"+ _city[i].AreaID +"' data-name='" + _city[i].CnName + "'>"
                    +     _city[i].CnName
                    +  "</li>";
          }
          var tab_name = _sel.parents('.cont').attr('data-tab');
          var _t = $('.tab-' + tab_name + ' .c-dropdown').find('ul');
          _t.html(_html);
          _t.children('li').click(function(){
            resetAreaDropdown($(this), 'c-dropdown');
            var _id = $(this).attr("data-id");
            var _name = $(this).attr("data-name");
            var __sel = $(this).parent().siblings("span");
            __sel.text(_name);
            __sel.attr('data-id', _id);
            getAreaData(_id, __sel);
          });
        }
      }
    );
  }
  //获得县级元素
  function getAreaData(_pid, _sel){
    $.ajax(
      {
        type: "get",
        dataType: "json",
        url: "/Templates/Debt/data/Area.json",
        success: function(data){
          var _area = [];
          for(var i=0; i<data.length; i++){
            if(data[i].ParentID == _pid){
              _area.push(data[i]);
            }
          }

          var _html = '';
          for(var i=0; i<_area.length; i++){
            _html  +=   "<li data-id='"+ _area[i].AreaID +"' data-name='" + _area[i].CnName + "'>"
                    +     _area[i].CnName
                    +  "</li>";
          }
          var tab_name = _sel.parents('.cont').attr('data-tab');
          var _t = $('.tab-' + tab_name + ' .a-dropdown').find('ul');
          _t.html(_html);
          _t.children('li').click(function(){
            var _id = $(this).attr("data-id");
            var _name = $(this).attr("data-name");
            var __sel = $(this).parent().siblings("span");
            __sel.text(_name);
            __sel.attr('data-id', _id);
          });
        }
      }
    );
  }
  //重置省市县下拉框
  function resetAreaDropdown(tar, selName){
    var tab_name = tar.parents('.cont').attr('data-tab');
    if(selName == 'p-dropdown'){
      $('.tab-' + tab_name + ' .c-dropdown').html(
         '<label type="checkbox">'
        +  '<span>请选择</span>'
        +  '<i></i>'
        +  '<input type="checkbox" name="dd_city" value="">'
        +  '<ul></ul>'
        + '</label>'
      );
      $('.tab-' + tab_name + ' .a-dropdown').html(
         '<label type="checkbox">'
        +  '<span>请选择</span>'
        +  '<i></i>'
        +  '<input type="checkbox" name="dd_area" value="">'
        +  '<ul></ul>'
        + '</label>'
      );
    }
    if(selName == 'c-dropdown'){
      $('.tab-' + tab_name + ' .a-dropdown').html(
         '<label type="checkbox">'
        +  '<span>请选择</span>'
        +  '<i></i>'
        +  '<input type="checkbox" name="dd_area" value="">'
        +  '<ul></ul>'
        + '</label>'
      );
    }
  }

  $('#person_save').click(function(){
    var nick_name = $('.tab-person input[name="nickName"]').val();
    var name = $('.tab-person input[name="name"]').val();
    var idNum = $('.tab-person input[name="idNum"]').val();
    var province = $('.tab-person input[name="dd_province"]').siblings('span').attr('data-id');
    var city = $('.tab-person input[name="dd_city"]').siblings('span').attr('data-id');
    var area = $('.tab-person input[name="dd_area"]').siblings('span').attr('data-id');
    var images = []; //证明图片

    if(nick_name == ''){
      showMsg('请输入您的昵称');
      return;
    }

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

    $('.tab-person .i-wrap').each(function(){
      if($(this).children('img').attr('src')){
        images.push($(this).children('img').attr('src'));
      }
    });

    if(images.length != 3){
      showMsg('请上传所需的证件照片');
      return;
    }

    if(!province || !city || !area){
      showMsg('请输入您的地址信息');
      return;
    }


    var area_detail = $('.tab-person textarea[name="areaDetail"]').val();
    var qq = $('.tab-person input[name="qq"]').val();
    var email = $('.tab-person input[name="email"]').val();

    if(qq != '' && !validate('qq', qq)){
      showMsg('请输入正确的qq号');
      return;
    }

    if(email != '' && !validate('email', email)){
      showMsg('请输入正确的邮箱');
      return;
    }

    ajax(1, {
      "nickName": nick_name, //昵称
      "name": name, //姓名
      "idNum": idNum, //身份证号
      "province": province, //省
      "city": city, //市
      "area": area, //县
      "images": images, //身份证照
      "areaDetail": area_detail, //详细地址
      "qq": qq, //qq
      "email": email //邮箱
    });

  });

  $('#company_save').click(function(){
    var company_name = $('.tab-company input[name="companyName"]').val();
    var registrant_name = $('.tab-company input[name="registrantName"]').val();
    var idNum = $('.tab-company input[name="idNum"]').val();
    var credit_num = $('.tab-company input[name="creditNum"]').val();
    var province = $('.tab-company input[name="dd_province"]').siblings('span').attr('data-id');
    var city = $('.tab-company input[name="dd_city"]').siblings('span').attr('data-id');
    var area = $('.tab-company input[name="dd_area"]').siblings('span').attr('data-id');
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

    $('#i_registrant .i-wrap').each(function(){
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

    if($('#i_license .i-wrap').children('img').attr('src')){
      license = $(this).children('img').attr('src');
    }else{
      showMsg('请上传所需的营业执照');
      return;
    }

    if(!province || !city || !area){
      showMsg('请输入您的地址信息');
      return;
    }

    var area_detail = $('.tab-company textarea[name="areaDetail"]').val();
    var qq = $('.tab-company input[name="qq"]').val();
    var email = $('.tab-company input[name="email"]').val();

    if(qq != '' && !validate('qq', qq)){
      showMsg('请输入正确的qq号');
      return;
    }

    if(email != '' && !validate('email', email)){
      showMsg('请输入正确的邮箱');
      return;
    }

    ajax(2, {
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
      "email": email //邮箱
    });
  });

  $('#lawer_save').click(function(){
    var name = $('.tab-lawer input[name="name"]').val();
    var idNum = $('.tab-lawer input[name="idNum"]').val();
    var jobNo = $('.tab-lawer input[name="jobNo"]').val();
    var office = $('.tab-lawer input[name="office"]').val();
    var province = $('.tab-lawer input[name="dd_province"]').siblings('span').attr('data-id');
    var city = $('.tab-lawer input[name="dd_city"]').siblings('span').attr('data-id');
    var area = $('.tab-lawer input[name="dd_area"]').siblings('span').attr('data-id');
    var lawer_images = []; //证明图片
    var inspection_date = $('#mydatepicker').val();


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

    $('.tab-lawer .i-wrap').each(function(){
      if($(this).children('img').attr('src')){
        lawer_images.push($(this).children('img').attr('src'));
      }
    });

    if(lawer_images.length != 2){
      showMsg('请上传所需的证件照片');
      return;
    }


    if(!province || !city || !area){
      showMsg('请输入您的地址信息');
      return;
    }

    var area_detail = $('.tab-lawer textarea[name="areaDetail"]').val();
    var qq = $('.tab-lawer input[name="qq"]').val();
    var email = $('.tab-lawer input[name="email"]').val();

    if(qq != '' && !validate('qq', qq)){
      showMsg('请输入正确的qq号');
      return;
    }

    if(email != '' && !validate('email', email)){
      showMsg('请输入正确的邮箱');
      return;
    }

    ajax(3, {
      "name": name, //姓名
      "idNum": idNum, //身份证号
      "jobNo": jobNo, //执业证号
      "office": office, //所属律师事务所
      "province": province, //省
      "city": city, //市
      "area": area, //县
      "images": lawer_images, //照片
      "areaDetail": area_detail, //详细地址
      "qq": qq, //qq
      "email": email //邮箱
    });

  });

  //type: 1 保存为催客 2 保存为催收公司 3 保存为律师团队
  function ajax(type, formData){
    var url;
    switch (type) {
      case 1:
        url = "/Templates/Debt/data/save_as_person_auth.json";
        break;
      case 2:
        url = "/Templates/Debt/data/save_as_company_auth.json";
        break;
      case 3:
        url = "/Templates/Debt/data/save_as_lawer_auth.json";
        break;
      default:
        return;
    }
    $.ajax({
      type: "get",
      url: url,
      dataType: "json",
      data: JSON.stringify(formData),
      beforeSend: function(){
        showLoading();
      },
      success: function(data){
        if(data.ResultCode == 200){
          showMsg('保存成功');
          //路由跳转

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

//图片上传裁剪方法
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
              $(tar).parent().siblings('.i-wrap').html(
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