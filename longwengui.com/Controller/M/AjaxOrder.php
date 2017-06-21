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
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_M_URL.'/member/login/');
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
            if ($OrderInfo['Remarks']=='提醒成功'){
                $result_json = array('ResultCode' => 104, 'Message' => '只能提醒一次哦！');
                EchoResult($result_json);
            }
            if ($OrderInfo){
                $MemberProductOrderModule->UpdateInfoByKeyID(array('Remarks'=>'提醒成功'),$OrderID);
                $MemberAssetInfoModule = new MemberAssetInfoModule();
                $MemberUserModule = new MemberUserModule();
                $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);
                $UserInfo = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
                ToolService::SendSMSNotice($UserInfo['Mobile'], '亲爱的隆文贵用户，您发布的资产转让已售出。请您及时发货！'.'订单号：'.$OrderInfo['OrderNumber'].'，您可登陆http://www.longwengui.net/，用户中心已卖出的资产，及时查看您资产售卖情况。');//发送短信给卖家
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
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID(array("Status"=>4,"UpdateTime"=>time()),$OrderID);
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
                    $result_json = array('ResultCode' => 200, 'Message' => '取消申请成功',);
                }else{
                    $result_json = array('ResultCode' => 102, 'Message' => '取消申请失败',);
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
            $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
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
    /**
     * 卖家提交发货物流单号确认发货
     */
    public function ConfirmDelivery(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
            if ($OrderInfo){
                $Data['Status']= 3;
                $Data['UpdateTime'] = time();
                $Data['LogisticsCompany']= trim($_POST['logisticsName']);
                $Data['WaybillNumber']= trim($_POST['logisticsNo']);
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID($Data,$OrderID);
                if ($Result){
                    $result_json = array('ResultCode' => 200, 'Message' => '发货成功');
                }else{
                    $result_json = array('ResultCode' => 200, 'Message' => '发货失败');
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 买家发起申请退款
     */
    public function RequestRefund(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $MemberOrderRefundModule = new MemberOrderRefundModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
            if ($OrderInfo){
                $Data['OrderID'] = $OrderInfo['OrderID'];
                $Data['ProductID'] = $OrderInfo['ProductID'];
                $Data['UserID'] = $OrderInfo['UserID'];
                $Data['AddTime'] = time();
                $Data['UpdateTime'] = $Data['AddTime'];
                $Data['FromIP'] =GetIP();
                $Data['Status'] ='买家发起申请退款';
                $Data['Reason']= trim($_POST['Reason']);//原因
                $Data['TotalAmount']= trim($_POST['TotalAmount']);//退款金额
                $Data['Message']= trim($_POST['Message']);//说明
                $Data['ImageJson']= json_encode($_POST['ImageJson'],JSON_UNESCAPED_UNICODE);//凭证
                global $DB;
                $DB->query("BEGIN");//开始事务定义
                $UpdateStatus = $MemberProductOrderModule->UpdateInfoByKeyID(array('Status'=>5,'UpdateTime'=>$Data['AddTime']),$OrderID);
                if ($UpdateStatus){
                    $DB->query("COMMIT");//执行事务
                    $OrderRefund = $MemberOrderRefundModule->GetInfoByWhere(' and OrderID= '.$OrderID);
                    if (empty($OrderRefund)){
                        $Result = $MemberOrderRefundModule->InsertInfo($Data);
                        if ($Result){
                            $DB->query("COMMIT");//执行事务
                            $result_json = array('ResultCode' => 200, 'Message' => '申请成功');
                        }else{
                            $DB->query("ROLLBACK");//判断当执行失败时回滚
                            $result_json = array('ResultCode' => 102, 'Message' => '申请失败');
                        }
                    }else{
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $result_json = array('ResultCode' => 102, 'Message' => '您只有一次申请机会哦！');
                    }
                }else{
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode' => 103, 'Message' => '订单状态更新失败');
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 卖家处理申请退款（同意并发送退款地址）
     */
    public function AgreeRefund(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $MemberOrderRefundModule = new MemberOrderRefundModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
            if ($OrderInfo){
                $Data['UpdateTime'] = time();
                $Data['Status'] ='卖家同意退款申请';
                $Data['Remarks'] =trim($_POST['returnReason']);
                $Data['Contacts'] =trim($_POST['toName']);
                $Data['Address'] =trim($_POST['toAddress']);
                $Data['Tel'] =trim($_POST['toPhone']);
                global $DB;
                $DB->query("BEGIN");//开始事务定义
                $UpdateStatus = $MemberProductOrderModule->UpdateInfoByKeyID(array('Status'=>6,'UpdateTime'=>$Data['AddTime']),$OrderID);
                if ($UpdateStatus){
                    $DB->query("COMMIT");//执行事务
                    $OrderRefund = $MemberOrderRefundModule->GetInfoByWhere(' and OrderID= '.$OrderID);
                    if ($OrderRefund){
                        $Result = $MemberOrderRefundModule->UpdateInfoByWhere($Data,' OrderID= '.$OrderID);
                        if ($Result){
                            $DB->query("COMMIT");//执行事务
                            $result_json = array('ResultCode' => 200, 'Message' => '同意退款退货成功');
                        }else{
                            $DB->query("ROLLBACK");//判断当执行失败时回滚
                            $result_json = array('ResultCode' => 102, 'Message' => '同意退款退货失败');
                        }
                    }else{
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $result_json = array('ResultCode' => 103, 'Message' => '找不到该订单');
                    }
                }else{
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode' => 103, 'Message' => '订单状态更新失败');
                }
            }else{
                $result_json = array('ResultCode' => 103, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
    /**
     * 卖家处理申请退款（拒绝退款）
     */
     public function RefuseRefund(){
         $this->IsLogin();
         if ($_POST['orderId']) {
             $OrderID = intval($_POST['orderId']);
             $MemberProductOrderModule = new MemberProductOrderModule();
             $MemberOrderRefundModule = new MemberOrderRefundModule();
             $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
             if ($OrderInfo) {
                 $Data['Status'] ='卖家拒绝退款';
                 $Data['Remarks'] =trim($_POST['returnReason']);
                 global $DB;
                 $DB->query("BEGIN");//开始事务定义
                 $UpdateStatus = $MemberProductOrderModule->UpdateInfoByKeyID(array('Status'=>7,'UpdateTime'=>$Data['AddTime']),$OrderID);
                 if ($UpdateStatus){
                     $DB->query("COMMIT");//执行事务
                     $OrderRefund = $MemberOrderRefundModule->GetInfoByWhere(' and OrderID= '.$OrderID);
                     if ($OrderRefund){
                         $Result = $MemberOrderRefundModule->UpdateInfoByWhere($Data,' OrderID= '.$OrderID);
                         if ($Result){
                             $DB->query("COMMIT");//执行事务
                             $result_json = array('ResultCode' => 200, 'Message' => '拒绝成功');
                         }else{
                             $DB->query("ROLLBACK");//判断当执行失败时回滚
                             $result_json = array('ResultCode' => 102, 'Message' => '拒绝失败');
                         }
                     }else{
                         $DB->query("ROLLBACK");//判断当执行失败时回滚
                         $result_json = array('ResultCode' => 103, 'Message' => '找不到该订单');
                     }
                 }else{
                     $DB->query("ROLLBACK");//判断当执行失败时回滚
                     $result_json = array('ResultCode' => 104, 'Message' => '订单状态更新失败');
                 }
             }else{
                 $result_json = array('ResultCode' => 103, 'Message' => '找不到该订单');
             }
         }else{
             $result_json = array('ResultCode' => 105, 'Message' => '返回失败');
         }
         EchoResult($result_json);
     }
    /**
     * 买家退货提交物流信息(订单状态改为退货中)
     */
     public function SubmitLogistics(){
         $this->IsLogin();
         if ($_POST['orderId']) {
             $OrderID = intval($_POST['orderId']);
             $MemberProductOrderModule = new MemberProductOrderModule();
             $MemberOrderRefundModule = new MemberOrderRefundModule();
             $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
             if ($OrderInfo) {
                 $Data['Status'] ='买家提交物流信息';
                 $Data['LogisticsCompany'] =trim($_POST['logisticsName']);
                 $Data['WaybillNumber'] =trim($_POST['logisticsNo']);
                 $Data['UpdateTime'] = time();
                 global $DB;
                 $DB->query("BEGIN");//开始事务定义
                 $UpdateStatus = $MemberProductOrderModule->UpdateInfoByKeyID(array('Status'=>11,'UpdateTime'=>$Data['UpdateTime'],'Message'=>'买家提交物流信息'),$OrderID);
                 if ($UpdateStatus){
                     $DB->query("COMMIT");//执行事务
                     $OrderRefund = $MemberOrderRefundModule->GetInfoByWhere(' and OrderID= '.$OrderID.' and LogisticsCompany is Null and WaybillNumber is Null');
                     if ($OrderRefund){
                         $Result = $MemberOrderRefundModule->UpdateInfoByWhere($Data,' OrderID= '.$OrderID);
                         if ($Result){
                             $DB->query("COMMIT");//执行事务
                             $result_json = array('ResultCode' => 200, 'Message' => '提交物流信息成功');
                         }else{
                             $DB->query("ROLLBACK");//判断当执行失败时回滚
                             $result_json = array('ResultCode' => 102, 'Message' => '请勿重复提交');
                         }
                     }else{
                         $DB->query("ROLLBACK");//判断当执行失败时回滚
                         $result_json = array('ResultCode' => 103, 'Message' => '已提交物流信息，请勿重复提交');
                     }
                 }else{
                     $DB->query("ROLLBACK");//判断当执行失败时回滚
                     $result_json = array('ResultCode' => 104, 'Message' => '订单状态更新失败');
                 }
             }else{
                 $result_json = array('ResultCode' => 105, 'Message' => '找不到该订单');
             }
         }else{
             $result_json = array('ResultCode' => 106, 'Message' => '返回失败');
         }
         EchoResult($result_json);
     }
    /**
     * 卖家确认收货并退款
     */
    public function GoodsRefund(){
        $this->IsLogin();
        if ($_POST['orderId']){
            $OrderID = intval($_POST['orderId']);
            $MemberProductOrderModule = new MemberProductOrderModule();
            $MemberOrderRefundModule = new MemberOrderRefundModule();
            $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
            if ($OrderInfo){
                $Data['UpdateTime'] = time();
                $Data['Status'] ='卖家确认收货并退款';
                global $DB;
                $DB->query("BEGIN");//开始事务定义
                $UpdateStatus = $MemberProductOrderModule->UpdateInfoByKeyID(array('Status'=>8,'UpdateTime'=>$Data['UpdateTime']),$OrderID);
                if ($UpdateStatus){
                        $Result = $MemberOrderRefundModule->UpdateInfoByWhere($Data,' OrderID = '.$OrderID);
                        if ($Result){
                            $DB->query("COMMIT");//执行事务
                            $result_json = array('ResultCode' => 200, 'Message' => '确认收货并退款成功！');
                        }else{
                            $DB->query("ROLLBACK");//判断当执行失败时回滚
                            $result_json = array('ResultCode' => 102, 'Message' => '确认收货并退款失败！');
                        }
                }else{
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode' => 104, 'Message' => '已确认收货并退款！');
                }
            }else{
                $result_json = array('ResultCode' => 105, 'Message' => '不存在该订单',);
            }
            EchoResult($result_json);
        }
    }
}