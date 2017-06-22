<?php
/**
 * @desc  会员中心
 */
class Member
{
    public function __construct() {
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
        header("location:" . WEB_M_URL);
    }
    /**
     * @desc 登入页或登录操作
     */
    public function  Login(){
        $Title = '登录-文贵网';
        MService::IsLogin();
        include template('MemberLogin');
    }
    /**
     * @desc  注册
     */
    public function Register()
    {
        $Title = '注册-文贵网';
        include template('MemberRegisterOne');
    }
    /**
     * @desc 用户选择会员类型
     */
    public function ChooseType(){
        MService::IsNoLogin();
        $Type = trim($_GET['T']);//判断进页面
        $Title = '选择会员类型-文贵网';
        include template('MemberChooseType');
    }

    /**
     * @desc  会员注册完善资料(企业或者个人)
     */
    public function RegisterTwo(){
        $Title = '完善资料-文贵网';
        MService::IsNoLogin();
        $MemberUserInfoModule = new MemberUserInfoModule();
        include template('MemberRegisterTwo');
    }
    /**
     * @desc  会员注册完善资料(催收公司和催客)
     */
    public function RegisterThree(){
        $Title = '完善资料-文贵网';
        MService::IsNoLogin();
        include template('MemberRegisterThree');
    }
    /**
     * @desc  会员注册完善资料(律师事务所和律师)
     */
    public function RegisterFour(){
        $Title = '完善资料-文贵网';
        MService::IsNoLogin();
        include template('MemberRegisterFour');
    }
    /**
     * @desc  普通会员升级为催客
     */
    public function Upgrade(){
        MService::IsNoLogin();
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
     * @desc  找回密码
     */
    public function FindPasswd()
    {
        $Title = '找回密码-文贵网';
        include template('MemberFindPasswd');
    }
    /**
     * @desc 更改/绑定手机第一步
     */
    public function ChangeMobile()
    {
        MService::IsNoLogin();
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Nav = 'changemobile';
        $Title = '更改绑定手机-文贵网';
        include template('MemberChangeMobileOne');
    }
    /**
     * @desc 修改密码
     */
    public function ChangePassWord(){
        MService::IsNoLogin();
        $Title = '修改密码-文贵网';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('ChangePassWord');
    }
    /**
     * @desc 关于我们
     */
    public function AboutUs(){
        MService::IsNoLogin();
        $Title = '关于我们-文贵网';
        include template('MemberAboutUs');
    }
    /**
     * @desc 用户协议
     */
    public function Agreement(){
        MService::IsNoLogin();
        $Title = '用户协议-文贵网';
        include template('MemberAgreement');
    }
    /**
     * @desc 投诉建议
     */
    public function Advice(){
        MService::IsNoLogin();
        $Title = '投诉建议-文贵网';
        $Nav = 'advice';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberAdvice');
    }
    /**
     * @desc 收货地址
     */
    public function Address(){
        MService::IsNoLogin();
        $Title = '收货地址-文贵网';
        $MemberShippingAddressModule = new MemberShippingAddressModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Rscount = $MemberShippingAddressModule->GetListsNum(' and UserID = '.$_SESSION['UserID']);
        $AddressList = $MemberShippingAddressModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'],true);
        foreach ($AddressList as $key=>$value){
            $AddressList[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $AddressList[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $AddressList[$key]['Area']= $MemberAreaModule->GetCnNameByKeyID($value['Area']);
        }
        include template('MemberAddress');
    }
    /**
     * @desc 管理收货地址
     */
    public function AddressEdit(){
        $Title = '管理收货地址-文贵网';
        MService::IsNoLogin();
        $MemberShippingAddressModule = new MemberShippingAddressModule();
        $MemberAreaModule = new MemberAreaModule();
        $AddressList = $MemberShippingAddressModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'],true);
        foreach ($AddressList as $key=>$value){
            if ($value['Province'])
            $AddressList[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            if ($value['City'])
            $AddressList[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            if ($value['Area'])
            $AddressList[$key]['Area']= $MemberAreaModule->GetCnNameByKeyID($value['Area']);
        }
        include template('MemberAddressEdit');
    }
    /**
     * @desc 添加收货地址
     */
    public function AddressAdd(){
        $Title = '添加收货地址-文贵网';
        MService::IsNoLogin();
        $ID = intval($_GET['ID']);
        $MemberShippingAddressModule = new MemberShippingAddressModule();
        $MemberAreaModule = new MemberAreaModule();
        if (!empty($ID)){
            $AddressInfo = $MemberShippingAddressModule->GetInfoByKeyID($ID);
            if ($AddressInfo['Province'])
            $AddressInfo['province'] = $MemberAreaModule->GetCnNameByKeyID($AddressInfo['Province']);
            if ($AddressInfo['City'])
            $AddressInfo['city'] = $MemberAreaModule->GetCnNameByKeyID($AddressInfo['City']);
            if ($AddressInfo['Area'])
            $AddressInfo['area']= $MemberAreaModule->GetCnNameByKeyID($AddressInfo['Area']);
        }
        include template('MemberAddressAdd');
    }

    /**
     * @desc 我的悬赏
     */
    public function Reword(){
        MService::IsNoLogin();
        $Title = '我的悬赏-文贵网';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Nav = 'reword';
        $MysqlWhere = ' and UserID = '.$_SESSION['UserID'];
        $Status = intval($_GET['S']);
        if ($Status==1){
            $MysqlWhere .= ' and Status IN (2,3) ';
        }elseif ($Status==2){
            $MysqlWhere .= ' and Status =4 ';
        }
        //分页查询开始-------------------------------------------------
        $Rscount = $MemberRewardInfoModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=7;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberRewardInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $Message =json_decode($value['Message'],true);
                if ($Message['dd_province'])
                    $Message['province'] = $MemberAreaModule->GetCnNameByKeyID($Message['dd_province']);
                if ($Message['dd_city'])
                    $Message['city'] = $MemberAreaModule->GetCnNameByKeyID($Message['dd_city']);
                if ($Message['dd_area'])
                    $Message['area'] = $MemberAreaModule->GetCnNameByKeyID($Message['dd_area']);
                if ($Message['idNum'])
                    $Message['idNum'] = strlen($Message['idNum']) ? substr_replace($Message['idNum'], '****', 10, 4) : '';
                if ($Message['find_idCard'])
                    $Message['find_idCard'] = strlen($Message['find_idCard']) ? substr_replace($Message['find_idCard'], '****', 10, 4) : '';
                $Data['Data'][$key]['Message'] = $Message;
                $RewardImage = $MemberRewardImageModule->GetInfoByWhere(' and RewardID = '.$value['RewardID'],true);
                $Data['Data'][$key]['Image'] = $RewardImage;
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }

        include template('MemberReword');
    }
    /**
     * @desc 系统消息
     */
    public function SystemMessage(){
        MService::IsNoLogin();
        $Title = '系统消息-文贵网';
        $Nav = 'systemmessage';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberSystemMessage');
    }

    /**
     * @desc 我的钱包
     */
    public function Wallet(){
        MService::IsNoLogin();
        $Title = '我的钱包-文贵网';
        $Nav = 'wallet';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberWallet');
    }
    /**
     * @desc 提现银行卡
     */
    public function WithdrawalsBank(){
        MService::IsNoLogin();
        $Title = '提现银行卡-文贵网';
        include template('MemberWithdrawalsBank');
    }
    /**
     * @desc 提现支付宝
     */
    public function WithdrawalsAlipay(){
        MService::IsNoLogin();
        $Title = '提现支付宝-文贵网';
        include template('MemberWithdrawalsAlipay');
    }
    /**
     * @desc 提现协议
     */
    public function WithdrawalAgreement(){
        MService::IsNoLogin();
        $Title = '提现协议-文贵网';
        include template('MemberWithdrawalAgreement');
    }
    /**
     * @desc 我的设置
     */
    public function  Setting(){
        MService::IsNoLogin();
        $Title = '我的设置-文贵网';
        include template('MemberSetting');
    }
    /**
     * @desc 关注/收藏
     */
    public function Focus(){
        $Title = '关注/收藏-文贵网';
        MService::IsNoLogin();
        include template('MemberPersonFocus');
    }
    /**
     * @desc 我的资产
     */
    public function Asset(){
        $Title = '我的资产-文贵网';
        MService::IsNoLogin();
        include template('MemberPersonAsset');
    }
    /**
     * @desc 资产订单详情（已卖出的）
     */
    public function SellOrderDetail(){
        $Title = '资产订单详情-文贵网';
        $MemberProductOrderModule = new MemberProductOrderModule();
        $OrderID = trim($_GET['id']);
        $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
        if (!$OrderInfo){
            alertandback("不存在该订单！");
        }
        $NStatus = $MemberProductOrderModule->NStatus;
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberAreaModule = new MemberAreaModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);//通过产品ID获取
        $OrderInfo['Amount'] = $OrderInfo['TotalAmount']- $AssetInfo['Freight'];
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$OrderInfo['ProductID'].' and IsDefault=1');
        include template('MemberPersonOrderDetail');
    }
    /**
     * @desc 资产订单详情（已买到的）
     */
    public function BuyOrderDetail(){
        $Title = '资产订单详情-文贵网';
        MService::IsNoLogin();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $OrderNumber = trim($_GET['OrderNumber']);
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        if (!$OrderInfo){
            alertandback("不存在该订单！");
        }
        $NStatus = $MemberProductOrderModule->NStatus;
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberAreaModule = new MemberAreaModule();
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
        include template('MemberPersonOrderDetails');
    }

}