var pageObj=$.extend({},pageObj,{

    //个人用户认证
    personRoleAuth:function(){
        var nick_name = $('.tab-person input[name="nickName"]').val();
        var name = $('.tab-person input[name="name"]').val();
        var idNum = $('.tab-person input[name="idNum"]').val();
        var address = $('.tab-person input[name="address"]').attr("data-value")||"";
        var province = address.split(" ")[0];
        var city = address.split(" ")[1];
        var area = address.split(" ")[2];
        var area_detail = $('.tab-person textarea[name="areaDetail"]').val();
        var qq = $('.tab-person input[name="qq"]').val();
        var email = $('.tab-person input[name="email"]').val();

        if(name == ''){
            $.toast('请输入您的姓名');
            $('.tab-person input[name="name"]').focus();
            return;
        }
        if(!validate('chinese', name)){
            $.toast('姓名只能为中文');
            $('.tab-person input[name="name"]').focus();
            return;
        }

        if(idNum == ''){
            $.toast('请输入身份证号');
            $('.tab-person input[name="idNum"]').focus();
            return;
        }
        if(!validate('idNum', idNum)){
            $.toast('请输入正确的身份证号');
            $('.tab-person input[name="idNum"]').focus();
            return;
        }

        if(qq==''){
            $.toast('请输入QQ号');
            $('.tab-person input[name="qq"]').focus();
            return;
        }
        if(qq != '' && !validate('qq', qq)){
            $.toast('请输入正确的qq号');

            $('.tab-person input[name="qq"]').focus();
            return;
        }
        if(email != '' && !validate('email', email)){
            $.toast('请输入正确的邮箱');
            $('.tab-person input[name="email"]').focus();
            return;
        }
        if(address==''){
            $.toast('请选择您的地址信息');
            return;
        }

        this.ajax({
            "nickName": nick_name, //昵称
            "name": name, //姓名
            "idNum": idNum, //身份证号
            "province": province, //省
            "city": city, //市
            "area": area, //县
            "areaDetail": area_detail, //详细地址
            "qq": qq, //qq
            "email": email, //邮箱
            "type": 1
        });
    },
    ajax:function(formData){
        $.ajax({
            type: "post",
            url: "/loginajax.html",
            dataType: "json",
            data: {
                "Intention":"AddInformation",
                "AjaxJSON": JSON.stringify(formData),
            },
            beforeSend: function(){
                $.showIndicator();
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast('保存成功');
                    //路由跳转
                    setTimeout(function() {
                        window.location = data.Url;
                    }, 10);
                }else{
                    $.toast(data.Message);
                }
            },
            complete: function(){
                $.hideIndicator();
            }
        });
    },
    /**
     *初始化方法
     */
    init:function(){
        var _this=this;
        //图片裁剪
        $(".portrait").on('click',function () {
            $("#information").append(portraitHtml);
            imgClipper(this);
        });
        /*地址初始化*/
        $("input[name='address']").cityPicker();
        //个人用户点击保存
        $('#person_role_auth_save').on("click",function(){
            _this.personRoleAuth();
        });
    }
})
$(document).ready(function(){
    pageObj.init();
});

/**
 * 图片裁剪ajax提交
 * @param dataURL base64位头像编码
 */
function imgSubmit(tar,dataURL) {
    var ajaxData ={
        'Intention': 'AddCardImage', //头像提交方法
        'ImgBaseData':dataURL, //base64位编码
    }
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajaximage",
        data: ajaxData,
        beforeSend: function () {
            $.showPreloader('提交中');
        },
        success: function(data) {
            if(data.ResultCode == '200'){
                $("#portraitHtml").remove();
                $.toast(data.Message);
                $(tar).siblings(".img-wrap").empty();
                $(tar).parents(".imageUploadBox").addClass("fill");
                $(tar).siblings(".img-wrap").append("<img src='"+data.url+"' />");
                //$("#portrait").find('img').attr('src',dataURL);
            }else{
                $.toast(data.Message);
            }
        },
        complete: function () { //加载完成提示
            $.hidePreloader();
        }
    });
}

