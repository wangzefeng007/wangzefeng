var pageObj=$.extend({},pageObj,{
    /**
     * 催收公司信息
     */
    companyRoleAuth:function(){
        var company_name = $('.tab-company input[name="companyName"]').val();
        var registrant_name = $('.tab-company input[name="registrantName"]').val();
        var idNum = $('.tab-company input[name="idNum"]').val();
        var credit_num = $('.tab-company input[name="creditNum"]').val();
        var address = $('.tab-company input[name="address"]').attr("data-value")||"";
        var province = address.split(" ")[0];
        var city = address.split(" ")[1];
        var area = address.split(" ")[2];
        var registrant_images = []; //证明图片
        var license;

        if(company_name == ''){
            $.toast('请输入您的公司名称');
            $('.tab-company input[name="companyName"]').focus();
            return;
        }
        if(!validate('chinese', company_name)){
            $.toast('公司名称只能为中文');
            $('.tab-company input[name="companyName"]').focus();
            return;
        }

        if(registrant_name == ''){
            $.toast('请输入公司注册人姓名');
            $('.tab-company input[name="registrantName"]').focus();
            return;
        }
        if(!validate('chinese', registrant_name)){
            $.toast('姓名只能为中文');
            $('.tab-company input[name="registrantName"]').focus();
            return;
        }

        if(idNum == ''){
            $.toast('请输入公司注册人身份证号');
            $('.tab-company input[name="idNum"]').focus();
            return;
        }
        if(!validate('idNum', idNum)){
            $.toast('请输入正确的身份证号');
            $('.tab-company input[name="idNum"]').focus();
            return;
        }
        if(credit_num == ''){
            $.toast('请输入信用代码');
            $('.tab-company input[name="creditNum"]').focus();
            return;
        }
        if(!validate('creditNum', credit_num)){
            $.toast('请输入正确的信用代码');
            $('.tab-company input[name="creditNum"]').focus();
            return;
        }
        var area_detail = $('.tab-company textarea[name="areaDetail"]').val();
        var qq = $('.tab-company input[name="qq"]').val();
        var email = $('.tab-company input[name="email"]').val();

        if(qq != '' && !validate('qq', qq)){
            $.toast('请输入正确的qq号');
            $('.tab-company input[name="qq"]').focus();
            return;
        }

        if(email != '' && !validate('email', email)){
            $.toast('请输入正确的邮箱');
            $('.tab-company input[name="qq"]').focus();
            return;
        }
        $('#i_registrant .imageUploadBox').each(function(){
            if($(this).find('img').attr('src')){
                registrant_images.push($(this).find('img').attr('src'));
            }
        });
        if(address==''){
            $.toast('请选择您的地址信息');
            return;
        }
        if(registrant_images.length != 2){
            $.toast('请上传所需的身份证照片');
            return;
        }


        if($('#i_license .imageUploadBox').find('img').attr('src')){
            license = $('#i_license .imageUploadBox').find('img').attr('src');
        }else{
            $.toast('请上传所需的营业执照');
            return;
        }

        if(!province || !city || !area){
            $.toast('请输入您的地址信息');
            return;
        }

        this.ajax({
            "companyName": company_name, //催收公司名称
            "registrantName": registrant_name, //公司注册人姓名
            "idNum": idNum, //注册人身份证号
            "creditNum": credit_num, //信用代码
            "province": province, //省
            "city": city, //市
            "area": area, //县
            "areaDetail": area_detail, //详细地址
            "registrantImages": registrant_images, //注册人身份证照
            "license": license, //营业执照照片
            "qq": qq, //qq
            "email": email, //邮箱
            "type":3
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
        //企业用户点击保存
        $("#company_role_auth_save").on("click",function(){
            _this.companyRoleAuth();
        })
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
                $(tar).siblings(".img-wrap").append("<img src='"+dataURL+"' />");
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

