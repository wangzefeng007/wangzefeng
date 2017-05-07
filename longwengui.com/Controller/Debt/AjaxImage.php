<?php
/**
 * @desc 图片上传
 * Class AjaxImage
 */
class AjaxImage
{
    public function __construct()
    {
    }
    //上传图片
    public function Index()
    {
        $ImgBaseData = $_POST['ImgBaseData'];
        $ImageUrl = SendToImgServ($ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['ImageUrl'] !==''){
            $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['ImageUrl']);
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }

}