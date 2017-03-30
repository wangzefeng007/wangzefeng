<?php

Class CommonService{

    /**
     * @desc  发送手机验证码，验证手机
     */
    public static function SendMobileVerificationCode($Mobile)
    {
        $Data['Account'] = trim($Mobile);
        $Data['VerifyCode'] = mt_rand(1000, 9999);
        $Data['XpirationDate'] = Time() + 60 * 30;
        $Data ['Type'] = 0;
        $Authentication = new MemberAuthenticationModule ();
        $ID = $Authentication->GetInfoByWhere(' and Account=\''.$Data ['Account'].'\'');
        if ($ID) {
            $result = $Authentication->UpdateInfoByKeyID($Data, $ID);
        } else {
            $result = $Authentication->InsertInfo($Data);
        }
        if ($result) {
            $result1 = ToolService::SendSMSNotice($Data['Account'],'亲爱的57美国网用户,您认证的验证码为:' . $Data['VerifyCode'] . '。如非本人操作，请忽略。');
            if ($result1) {
                $json_result = array('ResultCode' => 200, 'Message' => '发送成功');
            } else {
                $json_result = array('ResultCode' => 100, 'Message' => '验证码发送失败,请重试');
            }
        } else {
            $json_result = array('ResultCode' => 100, 'Message' => '发送失败,系统异常');
        }
        echo json_encode($json_result);
    }
    /**
     * @desc  上传图片
     */
    public static function UploadPictures($directory){
        include SYSTEM_ROOTPATH . '/Include/fileupload.class.php';
        $up = new fileupload;

        //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
        $SavePath = 'Uploads/'.$directory.'/'.date('Ymd').'/';
        $up->set("path",$SavePath);
        $up->set("maxsize", 2000000);
        $up->set("allowtype", array("gif", "png", "jpg", "jpeg"));
        $up->set("israndname", true);
        //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
        if ($up->upload("image")) {
            $FileName = $up->getFileName();
            if (is_array($FileName)) {
                $ImageInfo['ImageUrl'] = $SavePath . $FileName[0];
                $ImageInfo['ImageUrl2'] = $SavePath . $FileName[1];
            }
            $ImageInfo['IsDefault'] = 1;
            $ImageInfo['RewardID'] = 1;
        } else {
            echo '<pre>';
            //获取上传失败以后的错误提示
            var_dump($up->getErrorMsg());
            echo '</pre>';
        }
    }

}

