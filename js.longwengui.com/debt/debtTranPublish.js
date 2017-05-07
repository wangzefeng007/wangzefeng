//适配ie8
initIE8Label();
fixIE8Label();

$(function(){
  $('#end_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '200px'}); //初始化日期选择器
});

//截止时间改变时计算距离时间
function endTimeChange(obj){
  var end_time = $('#end_time').val();
  var day = calcTime(obj,end_time);
  if(day){
    $('#left_time').html('还有<span class="c-b">' + day + '</span>天')
  }
}

//计算时间距离
function calcTime(obj,end_time){
  var a = new Date();
  var now = new Date(a.getFullYear() + '-' + ((a.getMonth() + 1) > 9 ? (a.getMonth() + 1) : ('0' + (a.getMonth() + 1))) + '-' + (a.getDate() > 9 ? a.getDate() : ('0' + a.getDate())));
  var end_date = new Date(end_time);
  //如果截止日期不大于今天，不执行
  if(end_date > now){
    var dis = end_date.getTime() - now.getTime();
    return dis/(1000*3600*24);
  }else{
  	showTip(obj, '请选择今天之后的日期');
  	//$(tar).val('');
    return;
  }
}

//编辑器初始化

// 阻止输出log
// wangEditor.config.printLog = false;

var editor = new wangEditor('editor-trigger');

// 上传图片
editor.config.uploadImgUrl = '/ajaximage/';
editor.config.uploadParams = {
    // token1: 'abcde',
    // token2: '12345'
};
editor.config.uploadHeaders = {
    // 'Accept' : 'text/x-json'
}
// editor.config.uploadImgFileName = 'myFileName';

// 隐藏网络图片
// editor.config.hideLinkImg = true;

// 表情显示项
editor.config.emotionsShow = 'value';
editor.config.emotions = {
    'default': {
        title: '默认',
        data: '/Js/wangEditor-2.1.23/emotion.json'
    },
    'weibo': {
        title: '微博表情',
        data: [
            {
                icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/7a/shenshou_thumb.gif',
                value: '[草泥马]'
            },
            {
                icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/60/horse2_thumb.gif',
                value: '[神马]'
            },
            {
                icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/bc/fuyun_thumb.gif',
                value: '[浮云]'
            },
            {
                icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/c9/geili_thumb.gif',
                value: '[给力]'
            },
            {
                icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/f2/wg_thumb.gif',
                value: '[围观]'
            },
            {
                icon: 'http://img.t.sinajs.cn/t35/style/images/common/face/ext/normal/70/vw_thumb.gif',
                value: '[威武]'
            }
        ]
    }
};

// 插入代码时的默认语言
// editor.config.codeDefaultLang = 'html'

// 只粘贴纯文本
// editor.config.pasteText = true;

// 跨域上传
// editor.config.uploadImgUrl = 'http://localhost:8012/upload';

// 第三方上传
// editor.config.customUpload = true;

// 普通菜单配置
editor.config.menus = [
    'source',
    '|',
    'bold',
    'underline',
    'italic',
    'strikethrough',
    'eraser',
    'forecolor',
    'bgcolor',
    '|',
    'quote',
    'fontfamily',
    'fontsize',
    'head',
    'unorderlist',
    'orderlist',
    'alignleft',
    'aligncenter',
    'alignright',
    '|',
    'link',
    'unlink',
    'table',
    'emotion',
    '|',
    'img',
    'video',
    'location',
    'insertcode',
    '|',
    'undo',
    'redo',
    'fullscreen'
];
// 只排除某几个菜单（兼容IE低版本，不支持ES5的浏览器），支持ES5的浏览器可直接用 [].map 方法
// editor.config.menus = $.map(wangEditor.config.menus, function(item, key) {
//     if (item === 'insertcode') {
//         return null;
//     }
//     if (item === 'fullscreen') {
//         return null;
//     }
//     return item;
// });

// onchange 事件
editor.onchange = function () {
    //console.log(this.$txt.html());
    $("#editor-trigger-val").val(this.$txt.html());
};

// 取消过滤js
// editor.config.jsFilter = false;

// 取消粘贴过来
// editor.config.pasteFilter = false;

// 设置 z-index
// editor.config.zindex = 20000;

// 语言
// editor.config.lang = wangEditor.langs['en'];

// 自定义菜单UI
// editor.UI.menus.bold = {
//     normal: '<button style="font-size:20px; margin-top:5px;">B</button>',
//     selected: '.selected'
// };
// editor.UI.menus.italic = {
//     normal: '<button style="font-size:20px; margin-top:5px;">I</button>',
//     selected: '<button style="font-size:20px; margin-top:5px;"><i>I</i></button>'
// };
editor.create();

/**表单验证
 */

function validateForm(){
    var _trans_money = $("input[name='trans_money']").val();
    var _public_money= $("input[name='public_money']").val();
    var _trans_count= $("input[name='trans_count']").val();
    var _sell_phone = $("input[name='sell_phone']").val();
    var _trans_type = $("input[name='trans_type']").val();
    var _end_time = $("input[name='end_time']").val();
    var _sell_phone = $("input[name='sell_phone']").val();
    var _emsMoney = $("input[name='emsMoney']").val()||0;
    var _transTitle = $("input[name='transTitle']").val();
    var agreement = $("input[name='agreement']")[0].checked;
    if(!agreement){
        showMsg('您还没有同意服务协议');
        return false;
    }

    else if(_trans_money == ''|| _public_money=='' || _trans_count=='' || _trans_type=='' || _end_time=='' || _sell_phone == ''||_transTitle==''){
        showMsg('请完善发布信息');
        return false;
    }
    else if($(".uploaded-box").find(".img-preview").length==0){
        showMsg('请上传至少一张图片');
        return false;
    }
    else{
        return true;
    }
}
/*
* 发布资产转让*/
$(function(){
	$("#publish").on("click",function(){
        var paramObj={
            _trans_money : $("input[name='trans_money']").val(),
            _public_money : $("input[name='public_money']").val(),
            _trans_count : $("input[name='trans_count']").val(),
            _sell_phone : $("input[name='sell_phone']").val(),
            _trans_type : $("input[name='trans_type']").val(),
            _end_time : $("input[name='end_time']").val(),
            _sell_phone : $("input[name='sell_phone']").val(),
            _emsMoney : $("input[name='emsMoney']").val(),
            _transTitle : $("input[name='transTitle']").val(),
            transDetail:$("[name='transDetail']").val(),
            agreement : $("input[name='agreement']")[0].checked,
            imageList:function(){
                var imgArr=[];
                $(".uploaded-box .img-preview").each(function(){
                    imgArr.push(this.children("img").attr("src"));
                });
                return imgArr;
            }
        };
         console.log(JSON.stringify(paramObj));
        var formData = validateForm();
        if(!formData){
            return false;
        }
		$.ajax({
			type:"post",
			url:"/ajaxasset/",
            dataType: "json",
			data:{
                "Intention":"Publish",
                "AjaxJSON":JSON.stringify(paramObj)
			},
            beforeSend:　function(){
                showLoading();
            },success: function(data){
                if(data.ResultCode == 200){
                    showMsg('操作成功');
                    window.location.reload();
                }else{
                    showMsg(data.Message);
                }
            },complete: function(){
                closeLoading();
            }
		})
	})
})
//发布资产转让图片上传
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "post",
        dataType: "json",
        url: "/ajaximage/",
        data: {
            "Intention":"AddImage",
            "ImgBaseData": ImgBaseData
        },
        beforeSend: function () {
            showLoading();
        },
        success: function(data) {
            if(data.ResultCode=='200'){
                var imgLen=$(tar).parents(".img-upload-wrap").find(".uploaded-box").find("img-preview").length;
                if(imgLen==8){
                    $(tar).parents(".img-upload-wrap").find(".add-img").hide();
                }
                $(tar).parents(".img-upload-wrap").find(".uploaded-box").append('<div class="img-preview">\
                    <img src="' + data.url + '" alt="">\
                    </div>')
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
