//催客、催收公司、律师团队会员注册完善资料
$(function(){
    $('#mydatepicker').dcalendarpicker({format: 'yyyy-mm-dd', width: '340px'});
    $('#mydatepicker2').dcalendarpicker({format: 'yyyy-mm-dd', width: '340px'}); //初始化日期选择器
    $('#mycalendar').dcalendar(); //初始化日历
    //擅长赋值
    addEventToDropdown("goodAt",function(tar){
        $(tar).parent().siblings("span").text($(tar).text());
        $(tar).parent().siblings("input").val($(tar).text());
    });
    //根据url参数初始化选项卡
    var tab_cur = GetQueryString('T');
    if(tab_cur == 1){
      $('.bx-wraper .tl .act').removeClass('act');
      $('.bx-wraper .tl .tb').eq(1).addClass('act');
      $('.tab-lawer').hide();
      $('.tab-lawers').show();
    }


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
    //律师（个人）资料保存
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
            $('.tab-lawer input[name="name"]').focus();
            return;
        }
        if(!validate('chinese', name)){
            showMsg('姓名只能为中文');
            $('.tab-lawer input[name="name"]').focus();
            return;
        }

        if(idNum == ''){
            showMsg('请输入身份证号');
            $('.tab-lawer input[name="idNum"]').focus();
            return;
        }
        if(!validate('idNum', idNum)){
            showMsg('请输入正确的身份证号');
            $('.tab-lawer input[name="idNum"]').focus();
            return;
        }

        if(jobNo == ''){
            showMsg('请输入执业证号');
            $('.tab-lawer input[name="jobNo"]').focus();
            return;
        }
        if(!validate('lawJobNo', jobNo)){
            showMsg('请输入正确的执业证号');
            $('.tab-lawer input[name="jobNo"]').focus();
            return;
        }

        if(office == ''){
            showMsg('请输入您的所属律师事务所');
            $('.tab-lawer input[name="office"]').focus();
            return;
        }
        if(!validate('chinese', office)){
            showMsg('律师事务所名称为中文');
            $('.tab-lawer input[name="office"]').focus();
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
            $('.tab-lawer input[name="qq"]').focus();
            return;
        }

        if(email != '' && !validate('email', email)){
            showMsg('请输入正确的邮箱');
            $('.tab-lawer input[name="email"]').focus();
            return;
        }

        ajax(4, {
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
            "type":4
        });

    });


    //律师事务所资料保存
    $('#lawers_save').click(function(){
        var name = $('.tab-lawers input[name="name"]').val();
        var phone = $('.tab-lawers input[name="phone"]').val();
        var lawPerson = $('.tab-lawers input[name="lawPerson"]').val();
        var creditNum = $('.tab-lawers input[name="creditNum"]').val();
        var province = $('.tab-lawers input[name="dd_province"]').siblings('span').attr('data-id');
        var city = $('.tab-lawers input[name="dd_city"]').siblings('span').attr('data-id');
        var area = $('.tab-lawers input[name="dd_area"]').siblings('span').attr('data-id');
        var goodAt = $('.tab-lawers input[name="goodAt"]').siblings('span').text();
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

        $('.tab-lawers .license .i-wrap').each(function(){
            if($(this).children('img').attr('src')){
                license_images.push($(this).children('img').attr('src'));
            }
        });

        if(license_images.length != 1){
            showMsg('请上传营业执照');
            return;
        }
        if(!goodAt){
            showMsg('请选择擅长方向');
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

        $('.tab-lawers .agentPic .i-wrap').each(function(){
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
            "agent_images": agent_images, //营业执照照片
            "areaDetail": area_detail, //详细地址
            "goodAt": goodAt, //擅长方向
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

//证件图片上传方法
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
