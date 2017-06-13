var pageObj=$.extend({},pageObj,{

    /**
     * 悬赏发布
     */
    publish:function(){
        var debt_owner, debtor;
        var reword_type = $(".tab-nav a.active").attr("rewordtype"); //悬赏类型
        var findMsg={};

        //找人
        if (reword_type == 1) {
            var find_name = $('#tab1 input[name="name"]').val();
            var find_sex = $('#tab1 input[name="sex"]').val();
            var find_age = $('#tab1 input[name="age"]').val();
            var find_height = $('#tab1 input[name="height"]').val();
            var find_idCard = $('#tab1 input[name="idNum"]').val();
            var last_time = $('#tab1 input[name="lastTime"]').val();
            var find_detail = $('#tab1 textarea[name="areaDetail"]').val();
            var contact_phone = $('#tab1 input[name="contactPhone"]').val();
            if (!find_name || !find_sex || !find_age || !find_height || !last_time || !find_detail||!contact_phone) {
                $.toast('请完善寻人信息');
                return;
            }
            findMsg={
                find_name:find_name,  //姓名
                find_sex:find_sex,    //性别
                find_age:find_age,     //年龄
                find_height:find_height,    //身高
                find_idCard:find_idCard,    //身份证号
                last_time:last_time,        //失联时间
                find_detail:find_detail,     //详细内容
                contact_phone:contact_phone     //联系电话号码
            }
        }
        //找财产
        if (reword_type == 2) {
            var address = $('#tab2 input[name="address"]').attr("data-value")||"";
            var dd_province = address.split(" ")[0];
            var dd_city = address.split(" ")[1];
            var dd_area = address.split(" ")[2];
            var name = $('#tab2 input[name="name"]').val();
            var idNum = $('#tab2 input[name="idNum"]').val();
            var detailAddress = $('#tab2 input[name="detailAddress"]').val();
            var find_detail = $('#tab2 textarea[name="areaDetail"]').val();
            var contact_phone = $('#tab2 input[name="contactPhone"]').val();
            if (!address || !name || !idNum || !detailAddress ||!find_detail||!contact_phone) {
                $.toast('请完善财产信息');
                return;
            }
            findMsg={
                dd_province:dd_province,    //省份
                dd_city:dd_city,            //城市
                dd_area:dd_area,            //区县
                name:name,                  //姓名
                idNum:idNum,                // 身份证号
                detail_address:detailAddress,   //地址
                find_detail:find_detail,        //详细内容
                contact_phone:contact_phone     //联系电话号码
            }
        }
        if(reword_type==3){
            var address = $('#tab3 input[name="address"]').attr("data-value")||"";
            var dd_province = address.split(" ")[0];
            var dd_city = address.split(" ")[1];
            var dd_area = address.split(" ")[2];
            var lost_name = $('#tab3 input[name="name"]').val();
            var lost_time = $('#tab3 input[name="lastTime"]').val();
            var detailAddress = $('#tab3 input[name="detailAddress"]').val();
            var find_detail = $('#tab3 textarea[name="areaDetail"]').val();
            var contact_phone = $('#tab3 input[name="contactPhone"]').val();
            if (!address || !lost_name || !lost_time || !detailAddress ||!find_detail||!contact_phone) {
                $.toast('请完善物品信息');
                return;
            }
            findMsg={
                dd_province:dd_province,        //省份
                dd_city:dd_city,                //城市
                dd_area:dd_area,                //区县
                lost_name:lost_name,            //丢失物品名称
                lost_time:lost_time,            //丢失时间
                detail_address:detailAddress,   //丢失地址
                find_detail:find_detail,        //详细内容
                contact_phone:contact_phone     //联系电话
            }
        }

        var img_voucher = []; //债务凭证图片地址

        $("#pics .imageUploadBox").each(function(){
            if($(this).find('img').attr('src')){
                img_voucher.push($(this).find('img').attr('src'));
            }
        })

        if(img_voucher.length == 0){
            $.toast('请至少上传一张悬赏图片');
            return;
        }

        $.ajax({
            type: "post",
            dataType: "json",
            url: "/ajax.html",
            data: {
                "Intention":"ReleaseReward",
                "AjaxJSON":JSON.stringify({
                    "findMsg":findMsg, //寻找信息
                    "images": img_voucher, //债务凭证
                    "reword_type": reword_type //悬赏类型
                }),
            },
            beforeSend: function(){
                $.showIndicator();
            },
            success: function(data){
                if(data.ResultCode == 200){
                    $.toast(data.Message);
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
     * 初始化方法
     */
    init:function() {
        var _this = this;
        //地址初始化
        $("input[name='address']").cityPicker();
        //点击发布
        $("#publish").on("click",function(){
            _this.publish();
        })
        //图片裁剪
        $(".portrait").on('click',function () {
            $("#rewardInformation").append(portraitHtml);
            imgClipper(this);
        });
    }

})
$(document).ready(function(){
    pageObj.init();
});

/**
 * 图片裁剪ajax提交
 * @param dataURL base64位编码
 */
function imgSubmit(tar,dataURL) {
    var ajaxData ={
        'Intention': 'AddRewardImage', //悬赏图像
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