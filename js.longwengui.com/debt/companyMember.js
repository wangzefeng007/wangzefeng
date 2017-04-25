$(function(){
    initArea();

    //保存修改
    $('#save').click(function(){
      var company_name = $('input[name="companyName"]').val();
      var law_person = $('input[name="lawPerson"]').val();
      var fixed_phone = $('input[name="fixedPhone"]').val();
      var credit_num = $('input[name="creditNum"]').val();
      var province = $('input[name="dd_province"]').siblings('span').attr('data-id');
      var city = $('input[name="dd_city"]').siblings('span').attr('data-id');
      var area = $('input[name="dd_area"]').siblings('span').attr('data-id');
      var area_detail = $('textarea[name="areaDetail"]').val();
      var agent_name = $('input[name="agentName"]').val();
      var agent_id_num = $('input[name="agentIdNum"]').val();
      var type = $('#save').attr('data-type'); //类型
      var registrant_images = [];
      var license;

      //机构名称
      if(company_name == ''){
          showMsg('请输入机构名称');
          $('input[name="companyName"]').focus();
          return;
      }
      if(!validate('chinese', company_name)){
          showMsg('机构名称只能为中文');
          $('input[name="companyName"]').focus();
          return;
      }
      //法定代理人
      if(law_person == ''){
          showMsg('请输入法定代表人');
          $('input[name="lawPerson"]').focus();
          return;
      }
      if(!validate('chinese', law_person)){
          showMsg('法定代表人只能为中文');
          $('input[name="lawPerson"]').focus();
          return;
      }
      //固定电话
      if(fixed_phone == ''){
        showMsg('请输入固定电话');
        $('input[name="fixedPhone"]').focus();
        return;
      }
      if(!validate('fixedPhone', fixed_phone)){
        showMsg('请输入正确的固定电话');
        $('input[name="fixedPhone"]').focus();
        return;
      }
      //信用代码
      if(credit_num == ''){
        showMsg('请输入统一社会信用代码');
        $('input[name="creditNum"]').focus();
        return;
      }
      if(!validate('creditNum', credit_num)){
          showMsg('请输入正确的统一社会信用代码');
          $('input[name="creditNum"]').focus();
          return;
      }

      //营业执照副本
      if($('#i_license .img-wrap').children('img').attr('src')){
          license = $('#i_license .img-wrap').children('img').attr('src');
      }else{
          showMsg('请上传所需的营业执照');
          return;
      }
      //省市县信息
      if(!province || !city || !area){
          showMsg('请输入机构的地址信息');
          return;
      }
      //代理人姓名
      if(agent_name == ''){
        showMsg('请输入代理人姓名');
        $('input[name="agentName"]').focus();
        return;
      }
      if(!validate('chinese', agent_name)){
        showMsg('代理人姓名只能为中文');
        $('input[name="agentName"]').focus();
        return;
      }
      //代理人身份证号
      if(agent_id_num == ''){
        showMsg('请输入代理人身份证号');
        $('input[name="agentIdNum"]').focus();
        return;
      }
      if(!validate('idNum', agent_id_num)){
          showMsg('请输入正确的代理人身份证号');
          $('input[name="agentIdNum"]').focus();
          return;
      }
      //代理人身份证照
      $('#agent_pic .img-wrap').each(function(){
          if($(this).children('img').attr('src')){
              registrant_images.push($(this).children('img').attr('src'));
          }
      });
      if(registrant_images.length != 2){
          showMsg('请上传所需的证件照片');
          return;
      }

      ajax({
          "companyName": company_name, //机构名称
          "lawPerson": law_person, //法定代表人
          "fixedPhone": fixed_phone, //固定电话
          "province": province, //省
          "city": city, //市
          "area": area, //县
          "areaDetail": area_detail, //详细地址
          "creditNum": credit_num, //统一社会信用代码
          "license": license, //营业执照
          "type":type, //类型
          "agentInfo": {
            "agentName": agent_name, //代理人姓名
            "agentIdNum": agent_id_num, //代理人身份证号
            "registrantImages": registrant_images //代理人证件照
          }

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
