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
        MService::IsLogin();
        include template('MemberLogin');
    }
    /**
     * @desc  注册
     */
    public function Register()
    {
        include template('MemberRegisterOne');
    }
    /**
     * @desc 用户选择会员类型
     */
    public function ChooseType(){
        MService::IsNoLogin();
        $Title = '会员-选择类型';
        include template('MemberChooseType');
    }

    /**
     * @desc  会员注册完善资料(企业或者个人)
     */
    public function RegisterTwo(){
        MService::IsNoLogin();
        $MemberUserInfoModule = new MemberUserInfoModule();
        include template('MemberRegisterTwo');
    }
    /**
     * @desc  会员注册完善资料(催收公司和催客)
     */
    public function RegisterThree(){
        MService::IsNoLogin();
        include template('MemberRegisterThree');
    }
    /**
     * @desc  会员注册完善资料(律师事务所和律师)
     */
    public function RegisterFour(){
        MService::IsNoLogin();
        include template('MemberRegisterFour');
    }
    /**
     * @desc  普通会员升级为催客
     */
    public function Upgrade(){
        MService::IsNoLogin();
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
        MService::IsNoLogin();
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
        MService::IsNoLogin();
        $Title = '会员-修改密码';
        $Nav = 'editpassword';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberEditPassWord');
    }
    /**
     * @desc 关于我们
     */
    public function AboutUs(){
        MService::IsNoLogin();
        $Title = '会员-关于我们';
        include template('MemberAboutUs');
    }
    /**
     * @desc 用户协议
     */
    public function Agreement(){
        MService::IsNoLogin();
        $Title = '会员-用户协议';
        include template('MemberAgreement');
    }
    /**
     * @desc 投诉建议
     */
    public function Advice(){
        MService::IsNoLogin();
        $Title = '会员-投诉建议';
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
        $Title = '会员-收货地址';
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
     * @desc 我的悬赏
     */
    public function Reword(){
        MService::IsNoLogin();
        $Title = '会员-我的悬赏';
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
        $Title = '会员-系统消息';
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
        $Title = '会员-我的钱包';
        $Nav = 'wallet';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberWallet');
    }
    /**
     * @desc 我的设置
     */
    public function  Setting(){
        MService::IsNoLogin();
        $Title = '会员-我的设置';
        include template('MemberSetting');
    }
}