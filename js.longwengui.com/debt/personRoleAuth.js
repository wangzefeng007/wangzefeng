//个人注册完善资料
$(function(){
    // 切换选项卡
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
                    var _t = _sel.parents('.cont').find('.c-dropdown').find('ul');
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
                    var _t = _sel.parents('.cont').find('.a-dropdown').find('ul');
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
        if(selName == 'p-dropdown'){
            $(tar).parents('.cont').find('.c-dropdown').html(
                '<label type="checkbox">'
                +  '<span>请选择</span>'
                +  '<i></i>'
                +  '<input type="checkbox" name="dd_city" value="">'
                +  '<ul></ul>'
                + '</label>'
            );
            $(tar).parents('.cont').find('.a-dropdown').html(
                '<label type="checkbox">'
                +  '<span>请选择</span>'
                +  '<i></i>'
                +  '<input type="checkbox" name="dd_area" value="">'
                +  '<ul></ul>'
                + '</label>'
            );
        }
        if(selName == 'c-dropdown'){
            $(tar).parents('.cont').find('.a-dropdown').html(
                '<label type="checkbox">'
                +  '<span>请选择</span>'
                +  '<i></i>'
                +  '<input type="checkbox" name="dd_area" value="">'
                +  '<ul></ul>'
                + '</label>'
            );
        }
    }

    //个人用户认证
    $('#person_role_auth_save').click(function(){
        var nick_name = $('.tab-person input[name="nickName"]').val();
        var name = $('.tab-person input[name="name"]').val();
        var idNum = $('.tab-person input[name="idNum"]').val();
        var province = $('.tab-person input[name="dd_province"]').siblings('span').attr('data-id');
        var city = $('.tab-person input[name="dd_city"]').siblings('span').attr('data-id');
        var area = $('.tab-person input[name="dd_area"]').siblings('span').attr('data-id');
        var images = []; //证明图片

        if(name == ''){
            showMsg('请输入您的姓名');
            $('.tab-person input[name="name"]').focus();
            return;
        }
        if(!validate('chinese', name)){
            showMsg('姓名只能为中文');
            $('.tab-person input[name="name"]').focus();
            return;
        }

        if(idNum == ''){
            showMsg('请输入身份证号');
            $('.tab-person input[name="idNum"]').focus();
            return;
        }
        if(!validate('idNum', idNum)){
            showMsg('请输入正确的身份证号');
            $('.tab-person input[name="idNum"]').focus();
            return;
        }

        $('.tab-person .i-wrap').each(function(){
            if($(this).children('img').attr('src')){
                images.push($(this).children('img').attr('src'));
            }
        });

        // if(images.length != 2){
        //     showMsg('请上传所需的证件照片');
        //     return;
        // }

        if(!province || !city || !area){
            showMsg('请输入您的地址信息');
            return;
        }


        var area_detail = $('.tab-person textarea[name="areaDetail"]').val();
        var qq = $('.tab-person input[name="qq"]').val();
        var email = $('.tab-person input[name="email"]').val();
        if(qq==''){
            showMsg('请输入QQ号');
            $('.tab-person input[name="qq"]').focus();
            return;
        }
        if(qq != '' && !validate('qq', qq)){
            showMsg('请输入正确的qq号');

            $('.tab-person input[name="qq"]').focus();
            return;
        }

        if(email != '' && !validate('email', email)){
            showMsg('请输入正确的邮箱');
            $('.tab-person input[name="email"]').focus();
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
            "type": 1
        });
    });

    //企业用户认证
    $('#company_role_auth_save').click(function(){
      var company_name = $('.tab-company input[name="companyName"]').val();
      var law_person = $('.tab-company input[name="lawPerson"]').val();
      var fixed_phone = $('.tab-company input[name="fixedPhone"]').val();
      var credit_num = $('.tab-company input[name="creditNum"]').val();
      var province = $('.tab-company input[name="dd_province"]').siblings('span').attr('data-id');
      var city = $('.tab-company input[name="dd_city"]').siblings('span').attr('data-id');
      var area = $('.tab-company input[name="dd_area"]').siblings('span').attr('data-id');
      var area_detail = $('.tab-company textarea[name="areaDetail"]').val();
      var agent_name = $('.tab-company input[name="agentName"]').val();
      var agent_id_num = $('.tab-company input[name="agentIdNum"]').val();
      var registrant_images = [];
      var license;

      //机构名称
      if(company_name == ''){
          showMsg('请输入机构名称');
          $('.tab-company input[name="companyName"]').focus();
          return;
      }
      if(!validate('chinese', company_name)){
          showMsg('机构名称只能为中文');
          $('.tab-company input[name="companyName"]').focus();
          return;
      }
      //法定代理人
      if(law_person == ''){
          showMsg('请输入法定代表人');
          $('.tab-company input[name="lawPerson"]').focus();
          return;
      }
      if(!validate('chinese', law_person)){
          showMsg('法定代表人只能为中文');
          $('.tab-company input[name="lawPerson"]').focus();
          return;
      }
      //固定电话
      if(fixed_phone == ''){
        showMsg('请输入固定电话');
        $('.tab-company input[name="fixedPhone"]').focus();
        return;
      }
      if(!validate('fixedPhone', fixed_phone)){
        showMsg('请输入正确的固定电话');
        $('.tab-company input[name="fixedPhone"]').focus();
        return;
      }
      //信用代码
      if(credit_num == ''){
        showMsg('请输入统一社会信用代码');
        $('.tab-company input[name="creditNum"]').focus();
        return;
      }
      if(!validate('creditNum', credit_num)){
          showMsg('请输入正确的统一社会信用代码');
          $('.tab-company input[name="creditNum"]').focus();
          return;
      }

      //营业执照副本
      if($('#i_license .i-wrap').children('img').attr('src')){
          license = $('#i_license .i-wrap').children('img').attr('src');
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
        $('.tab-company input[name="agentName"]').focus();
        return;
      }
      if(!validate('chinese', agent_name)){
        showMsg('代理人姓名只能为中文');
        $('.tab-company input[name="agentName"]').focus();
        return;
      }
      //代理人身份证号
      if(agent_id_num == ''){
        showMsg('请输入代理人身份证号');
        $('.tab-company input[name="agentIdNum"]').focus();
        return;
      }
      if(!validate('idNum', agent_id_num)){
          showMsg('请输入正确的代理人身份证号');
          $('.tab-company input[name="agentIdNum"]').focus();
          return;
      }
      //代理人身份证照
      $('#agent_pic .i-wrap').each(function(){
          if($(this).children('img').attr('src')){
              registrant_images.push($(this).children('img').attr('src'));
          }
      });
      // if(registrant_images.length != 2){
      //     showMsg('请上传所需的证件照片');
      //     return;
      // }

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
          "agentInfo": {
            "agentName": agent_name, //代理人姓名
            "agentIdNum": agent_id_num, //代理人身份证号
            "registrantImages": registrant_images //代理人证件照
          },
          "type": 5
      });
    });

    function ajax(formData){
        $.ajax({
            type: "post",
            url: "/loginajax.html",
            dataType: "json",
            data: {
                "Intention":"AddInformation",
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

//个人证件照片上传裁剪方法
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
