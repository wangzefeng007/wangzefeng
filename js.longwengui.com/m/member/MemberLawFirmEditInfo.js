var pageObj=$.extend({},pageObj,{
    /**
     * 律师事务所信息
     */
    companyRoleAuth:function(){
        var name = $('.tab-lawers input[name="name"]').val();
        var phone = $('.tab-lawers input[name="phone"]').val();
        var lawPerson = $('.tab-lawers input[name="lawPerson"]').val();
        var creditNum = $('.tab-lawers input[name="creditNum"]').val();
        var address = $('.tab-lawers input[name="address"]').attr("data-value")||"";
        var province = address.split(" ")[0];
        var city = address.split(" ")[1];
        var area = address.split(" ")[2];
        var agentName = $('.tab-lawers input[name="agentName"]').val();
        var agentIdNum = $('.tab-lawers input[name="agentIdNum"]').val();
        var agentPhone = $('.tab-lawers input[name="agentPhone"]').val();
        var license_images = ""; //营业执照图片
        var agent_images = []; //代理人证件照
        var inspection_date = $('.tab-lawers input[name="checkDate"]').val();


        if(name == ''){
            $.toast('请输入事务所名称');
            $('.tab-lawers input[name="name"]').focus();
            return;
        }
        if(!validate('chinese', name)){
            $.toast('事务所名称只能为中文');
            $('.tab-lawers input[name="name"]').focus();
            return;
        }
        if(phone == ''){
            $.toast('请输入手机电话');
            $('.tab-lawers input[name="phone"]').focus();
            return;
        }
        if(!validate('phone', phone)){
            $.toast('请输入正确的手机或电话');
            $('.tab-lawers input[name="phone"]').focus();
            return;
        }
        if(lawPerson == ''){
            $.toast('请输入法定代表人');
            $('.tab-lawers input[name="lawPerson"]').focus();
            return;
        }
        if(!validate('chinese', lawPerson)){
            $.toast('法定代表人只能为中文');
            $('.tab-lawers input[name="lawPerson"]').focus();
            return;
        }
        if(creditNum == ''){
            $.toast('请输入信用代码');
            $('.tab-lawers input[name="creditNum"]').focus();
            return;
        }
        if(!validate('creditNum', creditNum)){
            $.toast('请输入正确的信用代码');
            $('.tab-lawers input[name="creditNum"]').focus();
            return;
        }
        if(inspection_date == ''){
            $.toast('请输入年检到期日');
            $('.tab-lawers input[name="checkDate"]').focus();
            return;
        }

        /*if(!province || !city || !area){
            $.toast('请输入您的地址信息');
            return;
        }*/
        if(agentName == ''){
            $.toast('请输入代理人姓名');
            $('.tab-lawers input[name="agentName"]').focus();
            return;
        }
        if(!validate('chinese', agentName)){
            $.toast('代理人姓名只能为中文');
            $('.tab-lawers input[name="agentName"]').focus();
            return;
        }
        if(agentIdNum == ''){
            $.toast('请输入代理人身份证号');
            $('.tab-lawers input[name="agentIdNum"]').focus();
            return;
        }
        if(!validate('idNum', agentIdNum)){
            $.toast('请输入正确的身份证号');
            $('.tab-lawers input[name="agentIdNum"]').focus();
            return;
        }
        if(address==''){
            $.toast('请选择您的地址信息');
            return;
        }
        /*if(agentPhone == ''){
            $.toast('请输入代理人手机号');
            $('.tab-lawers input[name="agentPhone"]').focus();
            return;
        }
        if(!validate('mobilePhone', agentPhone)){
            $.toast('请输入正确的手机号');
            $('.tab-lawers input[name="agentPhone"]').focus();
            return;
        }*/
        //营业执照副本
        if($('.tab-lawers #license .imageUploadBox').find('img').attr('src')){
            license_images = $('.tab-lawers #license .imageUploadBox').find('img').attr('src');
        }else{
            $.toast('请上传营业执照');
            return;
        }
        $('.tab-lawers #agentPic .imageUploadBox').each(function(){
            if($(this).find('img').attr('src')){
                agent_images.push($(this).find('img').attr('src'));
            }
        });
        if(agent_images.length != 2){
            $.toast('请上传证件照');
            return;
        }

        var area_detail = $('.tab-lawers textarea[name="areaDetail"]').val();
        this.ajax({
            "name": name, //事务所名称
            "phone": phone, //手机电话
            "lawPerson": lawPerson, //法定代表人
            "creditNum": creditNum, //信用代码
            "inspectionDate": inspection_date, //年检时间
            "province": province, //省
            "city": city, //市
            "area": area, //县
            "license_images": license_images, //营业执照照片
            "agent_images": agent_images, //代理人照片
            "areaDetail": area_detail, //详细地址
            "agentName":agentName,  //代理人姓名
            "agentIdNum":agentIdNum,  //代理人身份证号
            "agentPhone":agentPhone,  //代理人手机号
            "type":6
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

