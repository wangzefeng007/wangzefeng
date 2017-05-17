<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/12
 * Time: 16:33
 */
class AjaxOrder
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
     * 取消订单
     */
    public function CancelOrder(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                if ($OrderInfo['Status']==1){
                    $Result = $MemberProductOrderModule->UpdateInfoByKeyID(array("Status"=>10,"UpdateTime"=>time()),$OrderID);
                    if ($Result){
                        $OrderLogModule = new MemberOrderLogModule();
                        $LogMessage ='买家取消订单';
                        $LogData = array(
                            'OrderNumber' =>$OrderInfo['OrderNumber'],
                            'UserID' => $_SESSION['UserID'],
                            'OldStatus' => 1,
                            'NewStatus' => 10,
                            'OperateTime' => date("Y-m-d H:i:s", time()),
                            'IP' => GetIP(),
                            'Remarks' => $LogMessage,
                            'Type' => 1
                        );
                        $LogResult = $OrderLogModule->InsertInfo($LogData);
                        $result_json = array('ResultCode' => 200, 'Message' => '取消订单成功',);
                    }else{
                        $result_json = array('ResultCode' => 102, 'Message' => '取消订单失败',);
                    }
                }else{
                    $result_json = array('ResultCode' => 104, 'Message' => '该订单无法取消',);
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 提醒卖家
     */
    public function RemindSell(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                $MemberAssetInfoModule = new MemberAssetInfoModule();
                $MemberUserModule = new MemberUserModule();
                $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);
                $UserInfo = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
                ToolService::SendSMSNotice($UserInfo['Mobile'], '亲爱的隆文贵用户，您发布的资产转让已售出。请您及时发货！'.'订单号：'.$OrderInfo['OrderNumber'].'，您可登陆http://www.longwengui.com/，用户中心已卖出的资产，及时查看您资产售卖情况。');//发送短信给卖家
                $result_json = array('ResultCode' => 200, 'Message' => '提醒成功',);
                EchoResult($result_json);
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }

    }
    /**
     * 确认签收
     */
    public function ConfirmReceipt(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID(array("Status"=>4,"UpdateTime"=>time()),$OrderID);
                if ($Result){
                    $OrderLogModule = new MemberOrderLogModule();
                    $LogMessage ='买家已确认收货';
                    $LogData = array(
                        'OrderNumber' =>$OrderInfo['OrderNumber'],
                        'UserID' => $_SESSION['UserID'],
                        'OldStatus' => 3,
                        'NewStatus' => 4,
                        'OperateTime' => date("Y-m-d H:i:s", time()),
                        'IP' => GetIP(),
                        'Remarks' => $LogMessage,
                        'Type' => 1
                    );
                    $LogResult = $OrderLogModule->InsertInfo($LogData);
                    $result_json = array('ResultCode' => 200, 'Message' => '确认签收成功',);
                }else{
                    $result_json = array('ResultCode' => 102, 'Message' => '确认签收失败',);
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }

    }
    /**
     * 删除订单
     */
    public function DelOrder(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                $Result = $MemberProductOrderModule->DeleteByKeyID($OrderID);
                if ($Result){
                    $result_json = array('ResultCode' => 200, 'Message' => '删除订单成功',);
                }else{
                    $result_json = array('ResultCode' => 102, 'Message' => '删除订单失败',);
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 取消申请
     */
    public function CancelApply(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID(array("Status"=>3,"UpdateTime"=>time()),$OrderID);
                if ($Result){
                    $OrderLogModule = new MemberOrderLogModule();
                    $LogMessage ='买家取消申请退款';
                    $LogData = array(
                        'OrderNumber' =>$OrderInfo['OrderNumber'],
                        'UserID' => $_SESSION['UserID'],
                        'OldStatus' => 7,
                        'NewStatus' => 3,
                        'OperateTime' => date("Y-m-d H:i:s", time()),
                        'IP' => GetIP(),
                        'Remarks' => $LogMessage,
                        'Type' => 1
                    );
                    $LogResult = $OrderLogModule->InsertInfo($LogData);
                    $result_json = array('ResultCode' => 200, 'Message' => '确认退款成功',);
                }else{
                    $result_json = array('ResultCode' => 102, 'Message' => '确认退款失败',);
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 确认退款
     */
    public function ConfirmRefund(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID(array("Status"=>8,"UpdateTime"=>time()),$OrderID);
                if ($Result){
                    $OrderLogModule = new MemberOrderLogModule();
                    $LogMessage ='买家确认退款';
                    $LogData = array(
                        'OrderNumber' =>$OrderInfo['OrderNumber'],
                        'UserID' => $_SESSION['UserID'],
                        'OldStatus' => 6,
                        'NewStatus' => 8,
                        'OperateTime' => date("Y-m-d H:i:s", time()),
                        'IP' => GetIP(),
                        'Remarks' => $LogMessage,
                        'Type' => 1
                    );
                    $LogResult = $OrderLogModule->InsertInfo($LogData);
                    $result_json = array('ResultCode' => 200, 'Message' => '确认退款成功',);
                }else{
                    $result_json = array('ResultCode' => 102, 'Message' => '确认退款失败',);
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 获取订单地址信息
     */
    public function GetOrderAddress(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'].' and OrderID='.$OrderID);
            if ($OrderInfo){
                $Data['Address']= $OrderInfo['Address'];
                $Data['Contacts']= $OrderInfo['Contacts'];
                $Data['Tel']= $OrderInfo['Tel'];
                $result_json = array('ResultCode' => 200, 'Message' => '返回成功','Data'=>$Data);
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
}