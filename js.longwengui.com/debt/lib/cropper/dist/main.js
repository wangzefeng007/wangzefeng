/**
 * Created by Foliage on 2017/1/22.
 */
$('#avatarInput').on('change', function(e) {
    //提交方法执行类型
    var _type = $(this).attr('data-type');
    //图片最大能上传多少
    var _size = $(this).attr('data-size');
    //错误提示
    var _msg = $(this).attr('data-msg');
    //裁剪比例
    var _ratio = $(this).attr('data-ratio');
    //上传图片大小限制
    var filemaxsize = 1024 * _size; //验证图片上传大小
    //获取上传的图片大小
    var target = $(e.target);
    var Size = target[0].files[0].size / 1024;
    //获取当前url
    var URL = window.URL || window.webkitURL;

    //创建图片
    var blobURL = URL.createObjectURL(target[0].files[0]);



    //验证图大小
    if(Size > filemaxsize) {
        layer.msg('请不要选择大于'+_msg+'');
        return
    }
    //验证图片格式
    if(!this.files[0].type.match(/image.*/)) {
        layer.msg('图片格式不正确!');
    } else {
        layer.open({
            type: 1,
            skin: 'UpAvatar',
            area: ['486px','495px'], //宽高
            closeBtn:0,
            title:'头像裁剪',
            content:"<div style=\"max-height:380px;max-width:480px;\"><img src=\"\" id=\"AvatarFile\"/></div>",
            btn: ['保存', '关闭'],
            yes: function(index, layero){
                //图片BASE64处理
                var ImgBaseData=$image.cropper("getCroppedCanvas").toDataURL('image/jpeg');
                //执行提交方法
                imagesInput(ImgBaseData,index,_type);
                //执行提交方法B
                // imagesInputB(ImgBaseData,index);
            },
            success:function(index,layero){
                $image=$("#AvatarFile");
                $image.one('built.cropper', function () {
                    // Revoke when load complete
                    URL.revokeObjectURL(blobURL);
                }).cropper({
                    aspectRatio:_ratio, //图裁剪比例
                    minContainerHeight:380,
                    minContainerWidth:480,
                }).cropper('replace', blobURL);
            },
            end:function(index,layero){
                layer.close(index);
            }
        });
    }
});
