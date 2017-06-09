var pageObj=$.extend({},pageObj,{
    /**
     * 律师个人信息
     */
    personRoleAuth:function(){
        var name = $('.tab-lawer input[name="name"]').val();
        var idNum = $('.tab-lawer input[name="idNum"]').val();
        var jobNo = $('.tab-lawer input[name="jobNo"]').val();
        var office = $('.tab-lawer input[name="office"]').val();
        var address = $('.tab-lawer input[name="address"]').attr("data-value")||"";
        var province = address.split(" ")[0];
        var city = address.split(" ")[1];
        var area = address.split(" ")[2];
        var city = $('.tab-lawer input[name="dd_city"]').siblings('span').attr('data-id');
        var area = $('.tab-lawer input[name="dd_area"]').siblings('span').attr('data-id');
        var lawer_images = []; //证明图片
        var inspection_date =$('.tab-lawer input[name="checkDate"]').val();


        if(name == ''){
            $.toast('请输入您的姓名');
            $('.tab-lawer input[name="name"]').focus();
            return;
        }
        if(!validate('chinese', name)){
            $.toast('姓名只能为中文');
            $('.tab-lawer input[name="name"]').focus();
            return;
        }

        if(idNum == ''){
            $.toast('请输入身份证号');
            $('.tab-lawer input[name="idNum"]').focus();
            return;
        }
        if(!validate('idNum', idNum)){
            $.toast('请输入正确的身份证号');
            $('.tab-lawer input[name="idNum"]').focus();
            return;
        }

        if(jobNo == ''){
            $.toast('请输入执业证号');
            $('.tab-lawer input[name="jobNo"]').focus();
            return;
        }
        if(!validate('lawJobNo', jobNo)){
            $.toast('请输入正确的执业证号');
            $('.tab-lawer input[name="jobNo"]').focus();
            return;
        }

        if(office == ''){
            $.toast('请输入您的所属律师事务所');
            $('.tab-lawer input[name="office"]').focus();
            return;
        }
        if(!validate('chinese', office)){
            $.toast('律师事务所名称为中文');
            $('.tab-lawer input[name="office"]').focus();
            return;
        }

        if(inspection_date == ''){
            $.toast('请输入您的年检日期');
            return;
        }
        var area_detail = $('.tab-lawer textarea[name="areaDetail"]').val();
        var qq = $('.tab-lawer input[name="qq"]').val();
        var email = $('.tab-lawer input[name="email"]').val();

        if(qq != '' && !validate('qq', qq)){
            $.toast('请输入正确的qq号');
            $('.tab-lawer input[name="qq"]').focus();
            return;
        }

        if(email != '' && !validate('email', email)){
            $.toast('请输入正确的邮箱');
            $('.tab-lawer input[name="email"]').focus();
            return;
        }
        if(address==''){
            $.toast('请选择您的地址信息');
            return;
        }
        $('.tab-lawer .imageUploadBox').each(function(){
            if($(this).find('img').attr('src')){
                lawer_images.push($(this).find('img').attr('src'));
            }
        });

        if(lawer_images.length != 2){
            $.toast('请上传所需的证件照片');
            return;
        }


        /*if(!province || !city || !area){
            $.toast('请输入您的地址信息');
            return;
        }*/


        this.ajax({
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

