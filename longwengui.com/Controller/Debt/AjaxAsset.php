<?php
/**
 * @desc 资产转让相关
 * Class AjaxAsset
 */
class AjaxAsset
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
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_MAIN_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 资产列表获取
     */
    public function Lists(){

    }
    /**
     * @desc 发布资产
     */
    public function Publish(){
        $this->IsLogin();
        if ($_POST){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $Data['Content'] = addslashes($AjaxData['transDetail']);//内容
        $Data['Title'] = addslashes($AjaxData['_transTitle']);//标题
        $Data['Price'] = trim($AjaxData['_trans_money']);//单价
        $Data['MarketPrice'] = trim($AjaxData['_public_money']);//市场单价
        $Data['Inventory'] = trim($AjaxData['_trans_count']);//库存量
        $Data['AssetsAmount'] = $Data['Price']*$Data['Inventory'];//资产总金额
        $Data['Freight'] = trim($AjaxData['_emsMoney']);//运费
        $Data['AfterPhone'] = trim($AjaxData['_sell_phone']);//售后电话
        $Data['Category'] = trim($AjaxData['_trans_type']);//产品类型
        $Data['ExpirationDate'] = strtotime($AjaxData['_end_time']);//截止时间
        $Data['UserID'] =  $_SESSION['UserID'];
        $Data['AddTime'] = time();
        $Data['Status'] =1;
        $AssetID = $MemberAssetInfoModule->InsertInfo($Data);
            if ($AssetID){
                foreach ($AjaxData['imageList'] as $key =>$value){
                    if ($key==0){
                        $IsDefault =1;
                    }else{
                        $IsDefault =0;
                    }
                  $InsertImage = $MemberAssetImageModule->InsertInfo(array('AssetID'=>$AssetID,'ImageUrl'=>$value,'IsDefault'=>$IsDefault));
                }
                if (!$InsertImage){
                    $result_json = array('ResultCode'=>102,'Message'=>'图片上传失败！');
                }else{
                    $result_json = array('ResultCode'=>200,'Message'=>'发布成功,请等待审核！','url'=>'');
                }
            }else{
                $result_json = array('ResultCode'=>103,'Message'=>'发布失败！');
            }
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 订单确认
     */
    public function ConfirmOrder(){
        $this->IsLogin();
        if ($_POST) {
            $MemberAssetInfoModule = new MemberAssetInfoModule();
            $MemberProductOrderModule = new MemberProductOrderModule();
            $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
            $AssetInfo =$MemberAssetInfoModule->GetInfoByKeyID($AjaxData['ProductID']);
            if (!$AssetInfo){
                $result_json = array('ResultCode'=>102,'Message'=>'不存在该产品！');
            }else{
                $Data['OrderNumber'] = 'D'.date("Ymd").rand(1000, 9999);;//订单编号
                $Data['Num'] = intval($AjaxData['Number']);//数量
                $Data['ProductID'] = intval($AjaxData['ProductID']);//产品ID
                $Data['TotalAmount'] = trim($AjaxData['Money']);//订单总金额
                $Data['UserID'] = $_SESSION['UserID'];
                $Data['AddTime'] = time();
                $Data['ExpirationTime'] = $Data['AddTime']+3600;
                $Data['Status'] = 1;
               $InsertInfo = $MemberProductOrderModule->InsertInfo($Data);
               if ($InsertInfo){
                   $result_json = array('ResultCode'=>200,'Message'=>'订单提交成功！',      'Url' => WEB_MAIN_URL . '/assetorder/' . $Data['OrderNumber'] . '.html');
               }else{
                   $result_json = array('ResultCode'=>103,'Message'=>'订单提交失败！');
               }
            }
            EchoResult($result_json);
            exit;
        }
    }
}