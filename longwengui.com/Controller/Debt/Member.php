<?php
/**
 * @desc  会员登录注册
 */
class Member
{
    public function __construct() {
    }
    /**
     * @desc 会员中心首页(我的主页)
     */
    public function Index()
    {
    }
    /**
     * @desc 登入页或登录操作
     */
    public function  Login(){
        $Title = '会员登录';
        //如果已登陆，直接跳转到会员中心
        MemberService::IsLogin();
        include template('MemberLogin');
    }
    /**
     * @desc  退出登录
     */
    public function SignOut()
    {
        unset($_SESSION);
        setcookie("UserID", '', time() - 1, "/", WEB_HOST_URL);
        setcookie("Account", '', time() - 1, "/", WEB_HOST_URL);
        setcookie("session_id", session_id(), time() - 1, "/", WEB_HOST_URL);
        session_destroy();
        header("location:" . WEB_MAIN_URL);
    }
    /**
     * @desc  注册
     */
    public function Register()
    {
        //如果已登陆，直接跳转到会员中心
        MemberService::IsLogin();
        $Title = '注册会员';
        include template('MemberRegister');
    }
    /**
     * @desc  会员注册完善资料(加入催收行业)
     */
    public function RegisterTwo()
    {
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=0)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $type = intval($_GET['T']);
        $Title = '会员注册完善资料';
        include template('MemberRegisterTwo');
    }
    /**
     * @desc  普通会员升级为催客
     */
    public function Upgrade(){
        $this->IsLogin();
        if ($_SESSION['Identity']!=1){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        //会员基本信息
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        if ($UserInfo['Province'])
            $UserInfo['province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['city'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberUpgrade');
    }

    /**
     * @desc  会员注册完善资料(加入发布债务)
     */
    public function RegisterThree()
    {
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=0)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $Title = '会员注册完善资料';
        include template('MemberRegisterThree');
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }
    }
    /**
     * @desc  找回密码
     */
    public function FindPasswd()
    {
        $Title = '会员登录_找回密码';
        include template('MemberFindPasswd');
    }
    /**
     * @desc 更改/绑定手机
     */
    public function ChangeMobile()
    {
        $this->IsLogin();
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Nav = 'changemobile';
        $Title = '会员_更改绑定手机';
        include template('MemberChangeMobile');
    }
    /**
     * @desc 修改密码
     */
    public function EditPassWord(){
        $Title = '会员-修改密码';
        $this->IsLogin();
        $Nav = 'editpassword';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberEditPassWord');
    }
    /**
     * @desc 注册会员用户中心选择
     */
    public function Center(){
        $Title = '会员-用户中心';
        $this->IsLogin();
        $Nav = 'center';
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=0)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberCenter');
    }
    /**
     * @desc 收货地址
     */
    public function Address(){
        $Title = '会员-收货地址';
        $this->IsLogin();
        $Nav = 'address';
        $ID = intval($_GET['ID']);
        $MemberShippingAddressModule = new MemberShippingAddressModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Rscount = $MemberShippingAddressModule->GetListsNum(' and UserID = '.$_SESSION['UserID']);
        $Number = 10-$Rscount['Num'];//剩余保存条数
        $AddressList = $MemberShippingAddressModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'],true);
        foreach ($AddressList as $key=>$value){
            $AddressList[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $AddressList[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $AddressList[$key]['Area']= $MemberAreaModule->GetCnNameByKeyID($value['Area']);
        }
        if (!empty($ID)){
            $AddressInfo = $MemberShippingAddressModule->GetInfoByKeyID($ID);
        }
        include template('MemberAddress');
    }
    /**
     * @desc 系统消息
     */
    public function SystemMessage(){
        $Title = '会员-系统消息';
        $this->IsLogin();
        $Nav = 'systemmessage';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberSystemMessage');
    }
    /**
     * @desc 投诉建议
     */
    public function Advice(){
        $Title = '会员-投诉建议';
        $this->IsLogin();
        $Nav = 'advice';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberAdvice');
    }

    /**
     * @desc 发布的资产
     */
    public function AssetList(){
        $Title = '会员-发布的资产';
        $this->IsLogin();
        $Nav = 'assetlist';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere = ' and UserID = '.$_SESSION['UserID'];
        $NStatus =$MemberAssetInfoModule->NStatus;
        $Status=  intval($_GET['S']);
        if ($Status){
            $MysqlWhere .= ' and Status = '.$Status;
        }
        $Page = intval($_GET['p'])<1?1:intval($_GET['p']);
        $pageSize = 5;
        $Rscount = $MemberAssetInfoModule->GetListsNum($MysqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($pageSize ? $pageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $pageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            if ($Page > $Data['PageCount'])
                $page = $Data['PageCount'];
            $Data['Data'] = $MemberAssetInfoModule->GetLists($MysqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$value['AssetID']);
                $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
            }
            $ClassPage = new Page($Rscount['Num'], $pageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberAssetList');
    }
    /**
     * @desc 已卖出资产
     */
    public function SellOrderList(){
        $Title = '会员-已卖订单列表';
        $this->IsLogin();
        $Nav = 'sellorderlist';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $AssetInfo = $MemberAssetInfoModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'],true);
        $NStatus = $MemberProductOrderModule->NStatus;
        $arr = '';
        $MysqlWhere = '';
        $Status=  intval($_GET['S']);
        if ($Status=='1'){
            $MysqlWhere .= ' and `Status` = 2 ';
        }elseif ($Status=='2'){
            $MysqlWhere .= ' and `Status` = 3 ';
        }elseif ($Status=='3'){
            $MysqlWhere .= ' and `Status` in (4,5) ';
        }elseif ($Status=='4'){
            $MysqlWhere .= ' and `Status` in (6,7) ';
        }elseif ($Status=='5'){
            $MysqlWhere .= ' and `Status` = 8 ';
        }else{
            $MysqlWhere .= ' and `Status` > 1 and `Status` <9 ';
        }
        foreach ($AssetInfo  as $key=>$value){
            $arr[] .=$value['AssetID'];
        }
        $arr=implode(',',array_unique($arr));
        if (!empty($arr)){
            $MysqlWhere .= " and ProductID IN ($arr)";
            $Page = intval($_GET['p'])<1?1:intval($_GET['p']);
            $pageSize = 4;
            $MysqlWhere .= ' order by AddTime desc';
            $Rscount = $MemberProductOrderModule->GetListsNum($MysqlWhere);
            if ($Rscount['Num']) {
                $Data = array();
                $Data['RecordCount'] = $Rscount['Num'];
                $Data['PageSize'] = ($pageSize ? $pageSize : $Data['RecordCount']);
                $Data['PageCount'] = ceil($Data['RecordCount'] / $pageSize);
                $Data['Page'] = min($Page, $Data['PageCount']);
                $Offset = ($Page - 1) * $Data['PageSize'];
                if ($Page > $Data['PageCount'])
                    $page = $Data['PageCount'];
                $Data['Data'] = $MemberProductOrderModule->GetLists($MysqlWhere, $Offset, $Data['PageSize']);
                foreach ($Data['Data'] as $key=>$value){
                    $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($value['ProductID']);//通过产品ID获取
                    $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$value['ProductID']);//通过产品ID获取
                    $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
                    $Data['Data'][$key]['Title'] = $AssetInfo['Title'];
                    $Data['Data'][$key]['Content'] = $AssetInfo['Content'];
                    $Data['Data'][$key]['Price'] = $AssetInfo['Price'];
                    $Data['Data'][$key]['MarketPrice'] = $AssetInfo['MarketPrice'];
                }
                $ClassPage = new Page($Rscount['Num'], $pageSize,3);
                $ShowPage = $ClassPage->showpage();
            }
        }
        include template('MemberSellOrderList');
    }
    /**
     * @desc 已买到资产
     */
    public function BuyOrderList(){
        $Title = '会员-已买订单列表';
        $this->IsLogin();
        $Nav = 'buyorderlist';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere = ' and UserID = '.$_SESSION['UserID'];
        $NStatus = $MemberProductOrderModule->NStatus;
        $Status=  intval($_GET['S']);
        $CurrentTime = time()+1296000;//当前时间后的15天
        if ($Status=='1'){
            $MysqlWhere .= ' and `Status` = 1';
        }elseif ($Status=='2'){
            $MysqlWhere .= ' and `Status` in (2,3)';
        }elseif ($Status=='3'){
            $MysqlWhere .= ' and `Status` =4';
        }elseif ($Status=='4'){
            $MysqlWhere .= ' and `Status` in (5,6,7,8)';
        }elseif ($Status=='5'){
            $MysqlWhere .= ' and `Status` in (9,10)';
        }
        $Page = intval($_GET['p'])<1?1:intval($_GET['p']);
        $pageSize = 4;
        $MysqlWhere .= ' order by AddTime desc';
        $Rscount = $MemberProductOrderModule->GetListsNum($MysqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($pageSize ? $pageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $pageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            if ($Page > $Data['PageCount'])
                $page = $Data['PageCount'];
            $Data['Data'] = $MemberProductOrderModule->GetLists($MysqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($value['ProductID']);//通过产品ID获取
                $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$value['ProductID']);//通过产品ID获取
                $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
                $Data['Data'][$key]['Title'] = $AssetInfo['Title'];
                $Data['Data'][$key]['Content'] = $AssetInfo['Content'];
                $Data['Data'][$key]['Price'] = $AssetInfo['Price'];
                $Data['Data'][$key]['MarketPrice'] = $AssetInfo['MarketPrice'];
            }
            $ClassPage = new Page($Rscount['Num'], $pageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberBuyOrderList');
    }
    /**
     * @desc 资产已买到订单详情页
     */
    public function BuyOrderDetail(){
        $MemberProductOrderModule = new MemberProductOrderModule();
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberAreaModule = new MemberAreaModule();
        $OrderNumber = trim($_GET['OrderNumber']);
        $NStatus = $MemberProductOrderModule->NStatus;
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);//通过产品ID获取
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$OrderInfo['ProductID'].' and IsDefault=1');
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $User = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
        $UserInfo['Mobile'] = $User['Mobile'];
        if ($UserInfo['Province'])
        $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
        $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
        $UserInfo['Area']= $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        if ($OrderInfo['Status']<5){
            include template('MemberBuyOrderDetail1');
        }elseif ($OrderInfo['Status']>4 && $OrderInfo['Status']<9){
            include template('MemberBuyOrderDetail2');
        }
    }
    /**
     * @desc 资产已买到订单详情页(退款)
     */
    public function BuyOrderRefund(){
        $MemberProductOrderModule = new MemberProductOrderModule();
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberAreaModule = new MemberAreaModule();
        $OrderNumber = trim($_GET['No']);
        $NStatus = $MemberProductOrderModule->NStatus;
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);//通过产品ID获取
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$OrderInfo['ProductID'].' and IsDefault=1');
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $User = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
        $UserInfo['Mobile'] = $User['Mobile'];
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area']= $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
            include template('MemberBuyOrderDetail2');
    }
    /**
     * @desc 资产已卖出订单详情页
     */
    public function SellOrderDetail(){
        $MemberProductOrderModule = new MemberProductOrderModule();
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberAreaModule = new MemberAreaModule();
        $OrderNumber = trim($_GET['OrderNumber']);
        $NStatus = $MemberProductOrderModule->NStatus;
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);//通过产品ID获取
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$OrderInfo['ProductID'].' and IsDefault=1');
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $User = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
        //买家信息
        $BuyUserInfo = $MemberUserInfoModule->GetInfoByUserID($OrderInfo['UserID']);
        $UserInfo['Mobile'] = $User['Mobile'];
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area']= $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberSellOrderDetail1');
    }
}