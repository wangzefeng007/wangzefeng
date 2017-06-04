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

    public function Index()
    {
        $Intention = trim($_POST ['Intention']);
        if ($Intention == '') {
            $json_result = array(
                'ResultCode' => 500,
                'Message' => '系統錯誤',
                'Url' => ''
            );
            EchoResult($json_result);
            exit;
        }
        $this->$Intention ();
    }
    /**
     * @desc  判断是否登录
     */
    private function IsLogin()
    {
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_M_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 头像图片上传
     */
    public function AddHeadImage(){
        $this->IsLogin();
        //上传图片
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID ='.$_SESSION['UserID']);
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/Head/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
        $Data['Avatar'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['Avatar'] !==''){
            $UpdateAvatar = $MemberUserInfoModule->UpdateInfoByWhere($Data,' UserID =' .$_SESSION['UserID']);
            if ($UpdateAvatar){
                $_SESSION['Avatar'] = $Data['Avatar'];
                $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['Avatar']);
            }else{
                $result_json = array('ResultCode'=>101,'Message'=>'上传失败！');
            }
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 悬赏图片上传
     */
    public function AddRewardImage(){
        $this->IsLogin();
        $MemberRewardImageModule = new MemberRewardImageModule();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/Reward/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        $Data['IsDefault'] = 0;
        if ($Data['ImageUrl'] !==''){
            $RewardImage = $MemberRewardImageModule->InsertInfo($Data);
            if ($RewardImage){
                $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['ImageUrl']);
            }else{
                $result_json = array('ResultCode'=>101,'Message'=>'上传失败！');
            }
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 债务凭证图片上传
     */
    public function AddDebtImage(){
        $this->IsLogin();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/Debt/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['ImageUrl'] !==''){
            $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['ImageUrl']);
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 资产商城图片上传
     */
    public function AddAssetImage(){
        $this->IsLogin();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/Asset/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['ImageUrl'] !==''){
            $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['ImageUrl']);
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 证件照图片上传
     */
    public function AddCardImage(){
        $this->IsLogin();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/Card/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['ImageUrl'] !==''){
            $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['ImageUrl']);
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }

    /**
     * @desc 退款退货凭证图片上传
     */
    public function AddReturnImage(){
        $this->IsLogin();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/ReturnImage/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
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