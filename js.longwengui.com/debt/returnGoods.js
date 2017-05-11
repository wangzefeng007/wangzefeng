//适配ie8
initIE8Label();
fixIE8Label();

//上传凭证
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
                $(tar).parents(".img-wrap").find(".img").empty().append('<img src="'+data.url+'"/>');
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
