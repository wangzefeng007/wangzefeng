var pageObj=$.extend({},pageObj,{
    ajaxData:{
        _type:1, // 债务类型 1、个人债务 2、企业债务
        _debtOwnerInfos:[], //债权人信息
        _debtor_owner_money:0, //债权总金额
        _debtInfos:[],  //债务人信息
        _debtor_money:0, //债务总金额
        overDay:"",     //逾期时间
        haveDebtFamily:"0", //是否有亲友
        _debtfamilyInfos:[], //债务人亲友
        img_voucher:[]      //借款凭证
    },
    //添加dom事件
     addDom:function(targetID, tempID){
         var dom_index=$('#' + targetID).children('.form-fieldset').length;
         var addData={
             addDomClass:"form-fieldset"+dom_index
         }
        if($('#' + targetID).children('.form-fieldset').length < 3){
            addRenderDom(targetID, tempID,addData,function(){
                //地址初始化
                $('#' + targetID).children(".form-fieldset"+dom_index).find("input[name='address']").cityPicker({
                    value:false
                });
            });
        }
    },
    //删除dom事件
    delDom:function(tar){
        $(tar).parents(".form-fieldset").remove();
    },
    //删除dom事件
    delDom2:function(tar){
        $(tar).parents(".form-box").remove();
    },
    /**
     * 债权人信息验证（个人）
     */
    validate1:function(){
        var _this=this;
        //决定程序是否往下执行
        var flag = true;
        _this.ajaxData._debtOwnerInfos=[];
        _this.ajaxData._debtor_owner_money=0;
        //债权人信息
        $("#debtor_owner_info .form-fieldset").each(function(){
            if(flag){
                var _name = $(this).find('input[name="name"]').val();
                var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();
                var _idNum = $(this).find('input[name="idNum"]').val();

                if(_name == ""){
                    $.toast('请输入债权人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }

                if(!validate('chinese', _name)){
                    $.toast('请输入正确的债权人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }
                if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                    $.toast('请输入正确的债权人手机号');
                    $(this).find('input[name="phoneNumber"]').focus();
                    flag = false;
                    return;
                }
                if(_idNum != '' && !validate('idNum', _idNum)){
                    $.toast('请输入正确的债权人身份证');
                    $(this).find('input[name="idNum"]').focus();
                    flag = false;
                    return;
                }

                //债权金额
                var _debt_money = $(this).find('input[name="debt_money"]').val();
                if(_debt_money == ''){
                    $.toast('请输入债权金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                if(!validate('+money', _debt_money)){
                    $.toast('请输入正确的债权金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                //债权人地区
                var address = $(this).find('input[name="address"]').attr("data-value")||"";
                var province = address.split(" ")[0];
                var city = address.split(" ")[1];
                var area = address.split(" ")[2];
                var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                if(address==""){
                    $.toast('请选择债权人地址');
                    flag = false;
                    return;
                }
                _this.ajaxData._debtor_owner_money += parseFloat(_debt_money); //债权总金额
                _this.ajaxData._debtOwnerInfos.push({
                    "type": 1, //债权人类型
                    "name": _name, //债权人姓名
                    "idNum": _idNum, //债权人身份证
                    "debt_money": _debt_money, //债权金额
                    "phoneNumber": _phoneNumber, //债权人电话
                    "province": province,
                    "city": city,
                    "area": area,
                    "areaDetail": _areaDetail
                });
            }
        });
        if(!flag){
            return false;
        }else{
            return true;
        }
    },

    /**
     * 债权人信息验证（企业）
     */
    validateCompany1:function(){
        var _this=this;
        //决定程序是否往下执行
        var flag = true;
        _this.ajaxData._debtOwnerInfos=[];
        _this.ajaxData._debtor_owner_money=0;
        //债权人信息
        $("#debtor_owner_company_info .form-fieldset").each(function(){
            if(flag){
                var _cname = $(this).find('input[name="companyName"]').val();
                var _name = $(this).find('input[name="name"]').val();
                var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();
                var _idNum = $(this).find('input[name="idNum"]').val();
                if(_cname == ""){
                    $.toast('请输入债权人公司名称');
                    $(this).find('input[name="companyName"]').focus();
                    flag = false;
                    return;
                }
                if(_idNum != '' && !validate('creditNum', _idNum)){
                    $.toast('请输入正确的信用代码');
                    $(this).find('input[name="idNum"]').focus();
                    flag = false;
                    return;
                }
                if(_name == ""){
                    $.toast('请输入法人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }

                if(!validate('chinese', _name)){
                    $.toast('请输入正确的法人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }
                if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                    $.toast('请输入正确的电话号码');
                    $(this).find('input[name="phoneNumber"]').focus();
                    flag = false;
                    return;
                }

                //债权金额
                var _debt_money = $(this).find('input[name="debt_money"]').val();
                if(_debt_money == ''){
                    $.toast('请输入债权金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                if(!validate('+money', _debt_money)){
                    $.toast('请输入正确的债权金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                //债权人地区
                var address = $(this).find('input[name="address"]').attr("data-value")||"";
                var province = address.split(" ")[0];
                var city = address.split(" ")[1];
                var area = address.split(" ")[2];
                var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                if(address==""){
                    $.toast('请选择公司地址');
                    flag = false;
                    return;
                }
                _this.ajaxData._debtor_owner_money += parseFloat(_debt_money); //债权总金额
                _this.ajaxData._debtOwnerInfos.push({
                    "type": 2, //债权人类型
                    "cname": _cname, //公司名称
                    "name": _name, //债权人姓名
                    "idNum": _idNum, //债权人身份证
                    "debt_money": _debt_money, //债权金额
                    "phoneNumber": _phoneNumber, //债权人电话
                    "province": province,
                    "city": city,
                    "area": area,
                    "areaDetail": _areaDetail
                });
            }
        });
        if(!flag){
            return false;
        }else{
            return true;
        }
    },
    /**
     * 债务人信息验证
     */
    validate2:function(){
        var _this=this;
        //决定程序是否往下执行
        var flag = true;
        _this.ajaxData._debtInfos=[];
        _this.ajaxData._debtor_money=0;
        //债务人信息
        $("#debtor_info .form-fieldset").each(function(){
            if(flag){
                var _name = $(this).find('input[name="name"]').val();
                var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();
                var _idNum = $(this).find('input[name="idNum"]').val();

                if(_name == ""){
                    $.toast('请输入债务人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }

                if(!validate('chinese', _name)){
                    $.toast('请输入正确的债务人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }
                if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                    $.toast('请输入正确的债务人手机号');
                    $(this).find('input[name="phoneNumber"]').focus();
                    flag = false;
                    return;
                }
                if(_idNum != '' && !validate('idNum', _idNum)){
                    $.toast('请输入正确的债务人身份证');
                    $(this).find('input[name="idNum"]').focus();
                    flag = false;
                    return;
                }

                //债务金额
                var _debt_money = $(this).find('input[name="debt_money"]').val();
                if(_debt_money == ''){
                    $.toast('请输入债务金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                if(!validate('+money', _debt_money)){
                    $.toast('请输入正确的债务金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                //债务人地区
                var address = $(this).find('input[name="address"]').attr("data-value")||"";
                var province = address.split(" ")[0];
                var city = address.split(" ")[1];
                var area = address.split(" ")[2];
                var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                if(address==""){
                    $.toast('请选择债务人地址');
                    flag = false;
                    return;
                }
                _this.ajaxData._debtor_money += parseFloat(_debt_money); //债务总金额
                _this.ajaxData._debtInfos.push({
                    "type": 1, //债务人类型
                    "name": _name, //债务人姓名
                    "idNum": _idNum, //债务人身份证
                    "debt_money": _debt_money, //债务金额
                    "phoneNumber": _phoneNumber, //债务人电话
                    "province": province,
                    "city": city,
                    "area": area,
                    "areaDetail": _areaDetail
                });
            }
        });
        if(!flag){
            return false;
        }else{
            if(_this.ajaxData._debtor_owner_money != _this.ajaxData._debtor_money){
                $.toast('债务人和债权人金额总和不统一');
                return false;
            }else{
                return true;
            }
        }
    },

    /**
     * 债务人信息验证
     */
    validateCompany2:function(){
        var _this=this;
        //决定程序是否往下执行
        var flag = true;
        _this.ajaxData._debtInfos=[];
        _this.ajaxData._debtor_money=0;
        //债务人信息
        $("#debtor_company_info .form-fieldset").each(function(){
            if(flag){
                var _cname = $(this).find('input[name="companyName"]').val();
                var _name = $(this).find('input[name="name"]').val();
                var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();
                var _idNum = $(this).find('input[name="idNum"]').val();

                if(_cname == ""){
                    $.toast('请输入债务人公司名称');
                    $(this).find('input[name="companyName"]').focus();
                    flag = false;
                    return;
                }
                if(_idNum != '' && !validate('creditNum', _idNum)){
                    $.toast('请输入正确的信用代码');
                    $(this).find('input[name="idNum"]').focus();
                    flag = false;
                    return;
                }
                if(_name == ""){
                    $.toast('请输入法人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }

                if(!validate('chinese', _name)){
                    $.toast('请输入正确的法人姓名');
                    $(this).find('input[name="name"]').focus();
                    flag = false;
                    return;
                }
                if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                    $.toast('请输入正确的电话号码');
                    $(this).find('input[name="phoneNumber"]').focus();
                    flag = false;
                    return;
                }

                //债务金额
                var _debt_money = $(this).find('input[name="debt_money"]').val();
                if(_debt_money == ''){
                    $.toast('请输入债务金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                if(!validate('+money', _debt_money)){
                    $.toast('请输入正确的债务金额');
                    $(this).find('input[name="debt_money"]').focus();
                    flag = false;
                    return;
                }
                //债务人地区
                var address = $(this).find('input[name="address"]').attr("data-value")||"";
                var province = address.split(" ")[0];
                var city = address.split(" ")[1];
                var area = address.split(" ")[2];
                var _areaDetail = $(this).find('textarea[name="areaDetail"]').val();

                if(address==""){
                    $.toast('请选择债务人地址');
                    flag = false;
                    return;
                }
                _this.ajaxData._debtor_money += parseFloat(_debt_money); //债务总金额
                _this.ajaxData._debtInfos.push({
                    "type": 2, //债务人类型
                    "cname": _cname, //公司名称
                    "name": _name, //债务人姓名
                    "idNum": _idNum, //债务人身份证
                    "debt_money": _debt_money, //债务金额
                    "phoneNumber": _phoneNumber, //债务人电话
                    "province": province,
                    "city": city,
                    "area": area,
                    "areaDetail": _areaDetail
                });
            }
        });
        if(!flag){
            return false;
        }else{
            if(_this.ajaxData._debtor_owner_money != _this.ajaxData._debtor_money){
                $.toast('债务人和债权人金额总和不统一');
                return false;
            }else{
                return true;
            }
        }
    },
    /**
     * 其它信息验证
     */
    validate3:function(){
        var _this=this;
        //决定程序是否往下执行
        var flag = true;
        //债务人亲友信息
        _this.ajaxData._debtfamilyInfos=[];
        if(_this.ajaxData.haveDebtFamily=="1"){
            $("#debt_family_info .form-box").each(function(){
                if(flag){
                    var _name = $(this).find('input[name="name"]').val();
                    var _phoneNumber = $(this).find('input[name="phoneNumber"]').val();
                    var _relationship = $(this).find('input[name="relationship"]').val();

                    if(_name == ""){
                        $.toast('请输入债务人亲友姓名');
                        $(this).find('input[name="name"]').focus();
                        flag = false;
                        return;
                    }
                    if(!validate('chinese', _name)){
                        $.toast('请输入正确的债务人亲友姓名');
                        $(this).find('input[name="name"]').focus();
                        flag = false;
                        return;
                    }
                    if(_phoneNumber != '' && !validate('phone', _phoneNumber)){
                        $.toast('请输入正确的债务人亲友手机号');
                        $(this).find('input[name="phoneNumber"]').focus();
                        flag = false;
                        return;
                    }
                    _this.ajaxData._debtfamilyInfos.push({
                        "name": _name, //债务人亲友姓名
                        "relationShip": _relationship, //债务亲友人关系
                        "phoneNumber": _phoneNumber, //债务人电话
                    });
                }
            });
        }
        if(!flag){
            return;
        }
        _this.ajaxData.overDay = $('input[name="overDay"]').val();
        if(_this.ajaxData.overDay == ''){
            $.toast('请设置逾期时间');
            $('input[name="overDay"]').focus();
            return false;
        }
        //借款凭证
        _this.ajaxData.img_voucher=[];
        $("#voucher .imageUploadBox").each(function(){
            if($(this).find('img').attr('src')){
                _this.ajaxData.img_voucher.push($(this).find('img').attr('src'));
            }
        })
        if(!flag){
            return false;
        }else{
            return true;
        }
    },
    /**
     * 下一步去第二步
     */
    goStep2:function(){
        var type=0;
        $("#publish-step1 .tab-con").children("div").each(function(i){
            if($(this).hasClass("active")){
                type=i;
            }
        });
        //0 债权人为个人 1债权人为企业
        if(type==0){
            var formData=this.validate1();
        }else if(type==1){
            var formData=this.validateCompany1();
        }
        if(!formData){
            return;
        }
        $("#publish-step1").removeClass("page-current");
        $("#publish-step2").addClass("page-current");
        $("#publish-step2 input[name='address']").cityPicker({
            value:false
        });
    },
    /**
     * 返回到第一步
     */
    gobackStep1:function(){
        $("#publish-step2").removeClass("page-current");
        $("#publish-step1").addClass("page-current");
    },
    /**
     * 下一步去第三步
     */
    goStep3:function(){
        var _this=this;
        var type=0;
        $("#publish-step2 .tab-con").children("div").each(function(i){
            if($(this).hasClass("active")){
                type=i;
            }
        });
        //0 债务人为个人 1债务人为企业
        if(type==0){
            var formData=this.validate2();
        }else if(type==1){
            var formData=this.validateCompany2();
        }
        if(!formData){
            return;
        }
        type==0?_this.ajaxData._type=1:_this.ajaxData._type=2
        $("#publish-step2").removeClass("page-current");
        $("#publish-step3").addClass("page-current");
        //初始化日期控件
        if(!pageObj.isOk){
            $("input[name='overDay']").calendar({
                maxDate:$("input[name='overDay']").attr("maxDate")
                //value: ['2015-12-05']
            });
            pageObj.isOk=true;
        }
    },
    /**
     * 返回到第二步
     */
    gobackStep2:function(){
        $("#publish-step3").removeClass("page-current");
        $("#publish-step2").addClass("page-current");
    },
    /**
     * 添加债务人亲友
     */
    addDebtFamily:function(){
        if($('#debt_family_info').children('.form-box').length < 3){
            addRenderDom('debt_family_info', 'debt_family_tmpl');
        }
    },
    /**
     * 第三步点击完成
     */
    subDebt:function(){
        var _this=this;
        var formData=this.validate3();
        if(!formData){
            return;
        }
        var submitData = {
            "debtOwnerInfos": _this.ajaxData._debtOwnerInfos, //债权人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债权金额 areaDetail 详细地址}
            "debtorInfos": _this.ajaxData._debtInfos, //债务人信息数组 {name: 姓名; idNum: 身份证号; phoneNumber: 联系方式; province: 省; city: 市; area: 县; debt_money 债务金额 areaDetail 详细地址}
            "haveDebtFamily": _this.ajaxData.haveDebtFamily, //是否有债务人亲友 0 无 1 有
            "debtfamilyInfos": _this.ajaxData._debtfamilyInfos, //债权人亲友信息数组； haveDebtFamily为0: 数组为空;为1: {name: 名称; relationship: 与债权人关系; phoneNumber: 联系方式;}
            "images": _this.ajaxData.img_voucher, //债务凭证图片
            "overDay": _this.ajaxData.overDay //逾期时间
        }
        //发布债务
        $.ajax({
            type: "post",
            url: "/ajax.html",
            dataType: "json",
            data: {
                "Intention":"ReleaseDebt",
                "AjaxJSON":JSON.stringify(submitData),
                "Type":_this.ajaxData._type//债务类型1-个人债务 2-企业债务
            },
            beforeSend: function () { //加载过程效果
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
            complete: function () { //加载完成提示
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
        $(".tab-con div.active input[name='address']").cityPicker();
        $(".tab-nav a").on("click",function(){
            $($(this).attr("href")).find("input[name='address']").cityPicker({
                value:false
            });
        });
        //去第二步
        $("#goStep2").on("click", function () {
            _this.goStep2();
        });
        //去第三步
        $("#goStep3").on("click", function () {
            _this.goStep3();
        });
        //点击第三步完成
        $("#subDebt").on("click",function(){
            _this.subDebt();
        })
        //是否有债务人亲友
        $("#if_family").on("click",function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active");
                $(this).parents(".form-fieldset").addClass("no-fieldset");
                $("#debt_family_info").hide();
                _this.ajaxData.haveDebtFamily=0;
            }else{
                $(this).addClass("active");
                $(this).parents(".form-fieldset").removeClass("no-fieldset");
                $("#debt_family_info").show();
                _this.ajaxData.haveDebtFamily=1;
            }
        });
        //图片裁剪
        $(".portrait").on('click',function () {
            $("#publish-step3").append(portraitHtml);
            imgClipper(this);
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
        'Intention': 'AddDebtImage', //债务凭证图像
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