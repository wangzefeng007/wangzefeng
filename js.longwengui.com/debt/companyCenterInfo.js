$(function(){
  initArea();
});

//初始化省市县信息
function initArea(){
  var p_tar = $('input[name="dd_province"]');
  var p_id = p_tar.siblings('span').attr('data-id');
  var c_tar = $('input[name="dd_city"]');
  var c_id = c_tar.siblings('span').attr('data-id');

  getProvinceData();
  getCityData(p_id, p_tar);
  getAreaData(c_id, c_tar);
}

//修改头像
function changeHeadImg(tar, ImgBaseData, index){
  $.ajax({
      type: "get",
      dataType: "json",
      url: "/Templates/Debt/data/imageUpload.json",
      data: {
          "Intention":"AddRewardImage",
          "ImgBaseData": ImgBaseData,
      },
      beforeSend: function () {
          showLoading();
      },
      success: function(data) {
        if(data.ResultCode=='200'){
            showMsg('上传成功');
            $(tar).parent().siblings('img').attr("src", data.url);
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

//上传证件照
function imagesInput(tar, ImgBaseData, index) {
    $.ajax({
        type: "get",
        dataType: "json",
        url: "/Templates/Debt/data/imageUpload.json",
        data: {
            "Intention":"AddRewardImage",
            "ImgBaseData": ImgBaseData,
        },
        beforeSend: function () {
            showLoading();
        },
        success: function(data) {
          if(data.ResultCode=='200'){
              showMsg('上传成功');
              $(tar).parent().siblings('.img-wrap').html(
                "<img src='" + data.url + "' alt=''>"
              );
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
