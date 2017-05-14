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
            $MemberProductOrderModule = new MemberProductOrderModule();
        }
    }
    /**
     * 提醒卖家
     */
    public function RemindSell(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $MemberProductOrderModule = new MemberProductOrderModule();
        }

    }
    /**
     * 确认签收
     */
    public function ConfirmReceipt(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $MemberProductOrderModule = new MemberProductOrderModule();
        }

    }
    /**
     * 删除订单
     */
    public function DelOrder(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $MemberProductOrderModule = new MemberProductOrderModule();
        }
    }
    /**
     * 取消申请
     */
    public function CancelApply(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $MemberProductOrderModule = new MemberProductOrderModule();
            $MemberProductOrderModule->GetInfoByKeyID($OrderID);
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
                $MemberProductOrderModule->UpdateInfoByKeyID(array("Status"=>8),$OrderID);

            }else{
                $result_json = array('ResultCode' => 102, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
}