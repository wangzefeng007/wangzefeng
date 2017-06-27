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
    //企业用户认证
    companyRoleAuth:function(){
        var company_name = $('.tab-company input[name="companyName"]').val();
        var law_person = $('.tab-company input[name="lawPerson"]').val();
        var fixed_phone = $('.tab-company input[name="fixedPhone"]').val();
        var credit_num = $('.tab-company input[name="creditNum"]').val();
        var address = $('.tab-company input[name="address"]').attr("data-value")||"";
        var province = address.split(" ")[0];
        var city = address.split(" ")[1];
        var area = address.split(" ")[2];
        var area_detail = $('.tab-company textarea[name="areaDetail"]').val();
        var agent_name = $('.tab-company input[name="agentName"]').val();
        var agent_id_num = $('.tab-company input[name="agentIdNum"]').val();
        var registrant_images = [];
        var license;

        //机构名称
        if(company_name == ''){
            $.toast('请输入机构名称');
            $('.tab-company input[name="companyName"]').focus();
            return;
        }
        if(!validate('chinese', company_name)){
            $.toast('机构名称只能为中文');
            $('.tab-company input[name="companyName"]').focus();
            return;
        }
        //法定代理人
        if(law_person == ''){
            $.toast('请输入法定代表人');
            $('.tab-company input[name="lawPerson"]').focus();
            return;
        }
        if(!validate('chinese', law_person)){
            $.toast('法定代表人只能为中文');
            $('.tab-company input[name="lawPerson"]').focus();
            return;
        }
        //固定电话
        if(fixed_phone == ''){
            $.toast('请输入固定电话');
            $('.tab-company input[name="fixedPhone"]').focus();
            return;
        }
        if(!validate('fixedPhone', fixed_phone)){
            $.toast('请输入正确的固定电话');
            $('.tab-company input[name="fixedPhone"]').focus();
            return;
        }
        //代理人姓名
        if(agent_name == ''){
            $.toast('请输入代理人姓名');
            $('.tab-company input[name="agentName"]').focus();
            return;
        }
        if(!validate('chinese', agent_name)){
            $.toast('代理人姓名只能为中文');
            $('.tab-company input[name="agentName"]').focus();
            return;
        }
        //代理人身份证号
        if(agent_id_num == ''){
            $.toast('请输入代理人身份证号');
            $('.tab-company input[name="agentIdNum"]').focus();
            return;
        }
        if(!validate('idNum', agent_id_num)){
            $.toast('请输入正确的代理人身份证号');
            $('.tab-company input[name="agentIdNum"]').focus();
            return;
        }
        //信用代码
        if(credit_num == ''){
            $.toast('请输入统一社会信用代码');
            $('.tab-company input[name="creditNum"]').focus();
            return;
        }
        if(!validate('creditNum', credit_num)){
            $.toast('请输入正确的统一社会信用代码');
            $('.tab-company input[name="creditNum"]').focus();
            return;
        }
        //代理人身份证照
        $('#agent_pic .imageUploadBox').each(function(){
            if($(this).find('img').attr('src')){
                registrant_images.push($(this).find('img').attr('src'));
            }
        });
        if(address==''){
            $.toast('请选择您的地址信息');
            return;
        }
        /*if(registrant_images.length<2){
            $.toast("请上传代理人身份证照");
            return;
        }*/
        //营业执照副本
        if($('#license .imageUploadBox').find('img').attr('src')){
            license = $('#license .imageUploadBox').find('img').attr('src');
        }else{
            $.toast('请上传所需的营业执照');
            return;
        }
        this.ajax({
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

