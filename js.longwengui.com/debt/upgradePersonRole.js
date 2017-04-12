//初始化省市县
initArea();

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
                var _t = $('.c-dropdown').find('ul');
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
                var _t = $('.a-dropdown').find('ul');
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
        $('.c-dropdown').html(
            '<label type="checkbox">'
            +  '<span>请选择</span>'
            +  '<i></i>'
            +  '<input type="checkbox" name="dd_city" value="">'
            +  '<ul></ul>'
            + '</label>'
        );
        $('.a-dropdown').html(
            '<label type="checkbox">'
            +  '<span>请选择</span>'
            +  '<i></i>'
            +  '<input type="checkbox" name="dd_area" value="">'
            +  '<ul></ul>'
            + '</label>'
        );
    }
    if(selName == 'c-dropdown'){
        $('.a-dropdown').html(
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

    ajax(2, {
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
        "type":2
    });

});

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
