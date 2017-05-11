<?php

/**
 * @desc  债务催收
 */
class Debt
{
    public function __construct() {
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=1 && $_SESSION['Identity']!=2 && $_SESSION['Identity']!=5)
                alertandgotopage("访问被拒绝,目前只有普通会员和催客可以发布债务！", WEB_MAIN_URL.'/debtlists/');
        }
    }
    public function Index(){
        $Title ='隆文贵债务处置';
        $Nav='index';
        include template('Index');
    }
    /**
     * @desc 前端测试静态页
     */
    public function Test(){
        $notify_url = WEB_MAIN_URL . '/pay/alipaynotify/';
        $return_url = WEB_MAIN_URL . '/pay/alipaynotify/'; //必填

        $out_trade_no = 'D12312312312153'; //必填
        $subject = stripslashes('测试订单名称'); //必填
        $total_fee = 0.01; //必填
        $body = stripslashes('测试订单描述');
        $show_url = WEB_MAIN_URL.'/myorder.html';
        $Data['OrderID'] = 23;
        $Data['NotifyUrl'] = WEB_MAIN_URL . '/ReturnUrl/';
        $Data['PayType'] = 0;
        $Data['CreateTime'] = time();
        $Data['ResultCode'] = 0;
        include SYSTEM_ROOTPATH.'/Include/AliPay/AliPay.php';
        $AliPay = new AliPay();
        $AliPay->SubmitOrder(1, $notify_url, $return_url, $out_trade_no, $subject, $total_fee, $body, $show_url);
//        include SYSTEM_ROOTPATH . '/Include/WXPay/WxPay.NativePay.php';
//        $notify = new NativePay();
//        $input = new WxPayUnifiedOrder();
//        $input->SetBody(stripslashes('订单号显示')); //订单描述
//        $input->SetDetail(stripslashes('订单名称'));
//        $input->SetOut_trade_no('LWG3453dfgdfg4535453'); //必填
//        $input->SetTotal_fee(0.01 * 100); //必填
//        $input->SetNotify_url(WEB_MAIN_URL . '/pay/wxpaynotify/'); //必填
//        $input->SetTrade_type("NATIVE");
//        $input->SetSpbill_create_ip(GetIP());
//        $input->SetProduct_id('LWG3453dfgdfg4535453');
//        $result = $notify->GetPayUrl($input);
//        var_dump($result);exit;
      include template('Test');
    }
    /**
     * @desc  债务催收列表
     */
    public function DebtLists(){
        $Nav='debt';
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $AreaList = $MemberAreaModule->GetInfoByWhere(' and R1 =1 order by S1 asc',true);
        $NStatus = $MemberDebtInfoModule->NStatus;
        //分页查询开始-------------------------------------------------
        $MysqlWhere = ' and `Status` <= 7 order by Status asc , AddTime desc';
        //关键字
        $Rscount = $MemberDebtInfoModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberDebtInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                if ($DebtorsInfo['Province'])
                $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
                $Data['Data'][$key]['AddTime'] = !empty($value['AddTime'])? date('Y-m-d',$value['AddTime']): '';
                $Data['Data'][$key]['Url'] = '/debt/'.$value['DebtID'].'.html';
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        $Title="债务催收|债务追讨-隆文贵债务处置";
        $Keywords="催收平台,催收系统，债务清算,债务追讨,欠款催收,债务案源";
        $Description="债权人在隆文贵债务处置平台发布单笔或多笔债权信息后，债务信息展现在隆文贵债务处置债务催收栏目版块，执业律师或催收公司在此页面可根据地域分布和佣金比例等因素选择接单，进行催收，从而赚取佣金。";
        include template('DebtLists');
    }
    public function DebtDetails(){
        $Nav='debt';
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberDebtImageModule = new MemberDebtImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberFocusDebtModule = new MemberFocusDebtModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        $ID = intval($_GET['ID']);
        //债务信息
        $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($ID);
        if ($DebtInfo['Status'] ==8  && $DebtInfo['UserID']!=$_SESSION['UserID']){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL.'/debtlists/');
        }
        //债务关注
        if (!empty ($_SESSION ['UserID'])){
            $FocusDebt = $MemberFocusDebtModule->GetInfoByWhere(' and DebtID = '.$ID.' and UserID= '.$_SESSION['UserID']);
        }

        //保证人信息
        if ($DebtInfo['Warrantor']){
            $WarrantorInfo = json_decode($DebtInfo['WarrantorInfo'],true);
            foreach ($WarrantorInfo as $key=>$value){
                $WarrantorInfo[$key]['card'] = strlen($value['card']) ? substr_replace($value['card'], '****', 10, 4) : '';
                $WarrantorInfo[$key]['phone'] = strlen($value['phone']) ? substr_replace($value['phone'], '****', 7, 4) : '';
            }
        }
        //抵押物信息
        if ($DebtInfo['Guarantee']){
            $GuaranteeInfo = json_decode($DebtInfo['GuaranteeInfo'],true);
        }
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $DebtInfo['UserID']);
        //债务人信息
        $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        foreach ($DebtorsInfo as $key=>$value){
            $DebtorsInfo[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $DebtorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $DebtorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            $DebtorsInfo[$key]['Card'] = strlen($value['Card']) ? substr_replace($value['Card'], '****', 10, 4) : '';
        }
        //债务人图片
        $DebtImage = $MemberDebtImageModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        if (isset ($_SESSION ['UserID']) || !empty ($_SESSION ['UserID'])){
            //浏览人信息
            $browseUserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $_SESSION['UserID']);
        }
        //关联的债务信息
        if ($DebtorsInfo[0]['Card'] !==''){
            $AssociatedDebtors = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID != ".$ID.' and Card = \''.$DebtorsInfo[0]['Card'].'\'',true);
            foreach ($AssociatedDebtors as $key =>$value){
                $AssociatedDebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($value['DebtID']);
                $AssociatedDebtors[$key]['DebtNum'] = $AssociatedDebtInfo['DebtNum'];
                $AssociatedDebtors[$key]['Overduetime'] = $AssociatedDebtInfo['Overduetime'];
                $AssociatedDebtors[$key]['AddTime'] = $AssociatedDebtInfo['AddTime'];
                $AssociatedDebtors[$key]['DebtAmount'] = $AssociatedDebtInfo['DebtAmount'];
                $AssociatedDebtors[$key]['Status'] = $AssociatedDebtInfo['Status'];
                if ($value['Province'])
                $AssociatedDebtors[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                if ($value['City'])
                $AssociatedDebtors[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                if ($value['Area'])
                $AssociatedDebtors[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            }
        }
        $Title="债务详情-隆文贵债务处置";
        //处置方接单申请
        if ($DebtInfo['UserID']==$_SESSION['UserID']){
            $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
            $Data['Data'] = $MemberClaimsDisposalModule->GetInfoByWhere(' and DebtID ='.$DebtInfo['DebtID'],true);
            foreach ( $Data['Data'] as $key=>$value){
               $ClaimsUserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
               if ($ClaimsUserInfo['Identity']==3 ||$ClaimsUserInfo['Identity']==4){
                   $Data['Data'][$key]['CompanyName'] = $ClaimsUserInfo['CompanyName'];
               }elseif ($ClaimsUserInfo['Identity']==2){
                   $Data['Data'][$key]['CompanyName'] = $ClaimsUserInfo['RealName'];
               }
            }
        }
        include template('DebtDetails');
    }
    /**
     * @desc  发布债务
     */
    public function DebtPublish()
    {
        $this->IsLogin();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION ['UserID']);
//        if ($UserInfo['IdentityState']!=3)
//            alertandgotopage("请等待审核通过方可发布债务！", WEB_MAIN_URL.'/debtlists/');
        $Nav='debt';
        $Type = intval($_GET['T']);
        $Title="发布债务-隆文贵债务处置";
        if ($Type===1){
            include template('DebtPublishLawer');
        }elseif ($Type===2){
            include template('DebtPublishCollectors');
        }elseif ($Type===3){
            include template('DebtPublishDiy');
        }
    }
    /**
     * @desc  债权转让/股权转让暂定
     */
    public function Transfer(){
        $Title="债权转让-隆文贵债务处置";
        $Nav ='transfer';
        include template('DebtTransfer');
    }
}
