var pageObj=$.extend({},pageObj,{
    ajaxData:{},
    /**
     * 搜索
     */
    search:function(){
        var _this=this;
        _this.ajaxData={
            'Intention': 'GetDebtList',//提交方法
            'col_area':!$("#city").attr("data-value")==true?0:$("#city").attr("data-value").split(" ")[1], //地区
            'col_money':$("#money").attr("data-value")||0,        //催收金额
            'col_day':$("#day").attr("data-value")||0,            //逾期时间
            'page':1,         //当前页
            'Keyword':$("input[name='keyword']").val()||"all"        //搜索关键字
        };
        $.ajax({
            type: "post",	//提交类型
            dataType: "json",	//提交数据类型
            url: '/ajax.html',  //提交地址
            data: _this.ajaxData,
            beforeSend: function () { //加载过程效果
                $.showIndicator();
            },
            success: function (data) {	//函数回调
                console.log(data);
                if (data.ResultCode == "200") {

                } else {

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
        //选择地区
        $("#city").cityPicker();
        var toolbarTemplate= '<header class="bar bar-nav">\
                <button class="button button-link pull-right close-picker picker-indeed">确定</button>\
                <h1 class="title">请选择</h1>\
                </header>';
        //催收金额选择
        $("#money").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [
                {
                    textAlign: 'center',
                    values: ['0','1', '2', '3', '4 ','5'],
                    displayValues: ['全部','3万以下', '3万到10万', '10万到50万', '50万到100万 ','100万以上']
                }
            ],
            closeCallBack:function(){

            },
        });
        //逾期时间选择
        $("#day").picker({
            toolbarTemplate:toolbarTemplate,
            cols: [
                {
                    textAlign: 'center',
                    values: ['0','1', '2', '3', '4 ','5'],
                    displayValues: ['全部','0-60天', '61-180天', '181-365天', '366-1095天 ','1096天以上']
                }
            ],
            closeCallBack:function(){

            },
        });
        $(document).on("click",".picker-indeed",function(){
            _this.search();
        });
    }
})
$(document).ready(function(){
    pageObj.init();
});

/**
 * 地区选择
 */
+ (function($){
    "use strict";
    var toolbarTemplate= '<header class="bar bar-nav">\
                <button class="button button-link pull-right close-picker picker-indeed">确定</button>\
                <h1 class="title">请选择</h1>\
                </header>';
    var provinces = getProvince().map(function(d) {
        return d.CnName;
    });
    var provincesIds = getProvince().map(function(d) {
        return d.AreaID;
    });
    var initCities = getCity(getProvince()[0].AreaID);
    var initDistricts = [""];

    var currentProvince = provinces[0];
    var currentCity = initCities[0].AreaID;
    var currentDistrict = initDistricts[0];

    var t;
    var defaults = {

        cssClass: "city-picker",
        rotateEffect: false,  //为了性能

        onChange: function (picker, values, displayValues) {
            var newProvince = picker.cols[0].value;
            var newCity=[];
            var newCityDisplay=[];
            var newDistrict=[];
            var newDistrictDisplay=[];
            if(newProvince !== currentProvince) {
                // 如果Province变化，节流以提高reRender性能
                clearTimeout(t);

                t = setTimeout(function(){
                    var newCitiesObj = getCity(newProvince);
                    for(var i=0;i<newCitiesObj.length;i++){
                        newCity.push(newCitiesObj[i].AreaID);
                    }
                    for(var i=0;i<newCitiesObj.length;i++){
                        newCityDisplay.push(newCitiesObj[i].CnName);
                    }
                    picker.cols[1].replaceValues(newCity,newCityDisplay);
                    currentProvince = newProvince;
                    currentCity = newCity[0];
                    picker.updateValue();
                }, 200);
                return;
            }
            newCity = picker.cols[1].value;
        },
        toolbarTemplate:toolbarTemplate,
        cols: [
            {
                textAlign: 'center',
                values: provincesIds,
                displayValues:provinces,
                cssClass: "col-province"
            },
            {
                textAlign: 'center',
                values: initCities,
                displayValues:[],
                cssClass: "col-city"
            }
        ]
    };

    $.fn.cityPicker = function(params) {
        return this.each(function() {
            if(!this) return;
            var p = $.extend(defaults, params);
            //计算value
            if (p.value) {
                $(this).val(p.value.join(' '));
            } else {
                var val = $(this).attr("data-value");
                val && (p.value = val.split(' '));
            }

            if (p.value) {
                //p.value = val.split(" ");
                if(p.value[0]) {
                    currentProvince = p.value[0];
                    var cityValues=[];
                    var cityDisplayValues=[];
                    var citysObj=getCity(p.value[0]);
                    $.each(citysObj,function(i,v){
                        cityValues.push(v.AreaID);
                    });
                    $.each(citysObj,function(i,v){
                        cityDisplayValues.push(v.CnName);
                    });
                    p.cols[1].values = cityValues;
                    p.cols[1].displayValues = cityDisplayValues;
                }
            }
            $(this).picker(p);
        });
    };
})(Zepto)