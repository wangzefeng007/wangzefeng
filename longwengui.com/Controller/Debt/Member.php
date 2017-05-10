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
        $Nav = 'assetlist';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere = ' and UserID = '.$_SESSION['UserID'];
        $Status=  intval($_GET['S']);
        if ($Status){
            $MysqlWhere .= ' and Status = '.$Status;
        }
        $Page = intval($_GET['page'])<1?1:intval($_GET['page']);
        $pageSize = 4;
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
            $ClassPage = new Page($Rscount['Num'], $pageSize,2);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberAssetList');
    }
    /**
     * @desc 已卖出资产
     */
    public function SellOrderList(){

        $Nav = 'sellorderlist';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere = ' and UserID = '.$_SESSION['UserID'];
        $Status=  intval($_GET['S']);
        if ($Status){
            $MysqlWhere .= ' and Status = '.$Status;
        }
        $Page = intval($_GET['page'])<1?1:intval($_GET['page']);
        $pageSize = 4;
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
            $ClassPage = new Page($Rscount['Num'], $pageSize,2);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberSellOrderList');
    }
    /**
     * @desc 已买到资产
     */
    public function BuyOrderList(){
        $Nav = 'buyorderlist';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere = ' and UserID = '.$_SESSION['UserID'];
        $Status=  intval($_GET['S']);
        if ($Status){
            $MysqlWhere .= ' and Status = '.$Status;
        }
        $Page = intval($_GET['page'])<1?1:intval($_GET['page']);
        $pageSize = 4;
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
            $ClassPage = new Page($Rscount['Num'], $pageSize,2);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberBuyOrderList');
    }
}