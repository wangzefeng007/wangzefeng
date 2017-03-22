<?php

/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2017/3/9
 * Time: 16:42
 */
class Ajax
{
    public function __construct()
    {
        $_SESSION ['UserID']=1;
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
     * @desc 债务催收信息
     */
    public function GetDebtList(){
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        if (!$_POST) {
            $Data['ResultCode'] = 100;
            EchoResult($Data);exit;
        }
        $Keyword = trim($_POST['Keyword']);
        $Intention = trim($_POST['Intention']);
        $MysqlWhere = ' and `Status` < 8 ';
        if ($_POST) {
            $MysqlWhere .= $this->GetMysqlWhere($Intention);
        }
        $MysqlWhere .= ' order by Status asc';
        $Page = intval($_POST['Page']) < 1 ? 1 : intval($_POST['Page']); // 页码 可能是空
        $PageSize = 7;
        $Rscount = $MemberDebtInfoModule->GetListsNum($MysqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            if ($Data['Page'] < $Data['PageCount']) {
                $Data['NextPage'] = $Data['Page'] + 1;
            }
            $Offset = ($Page - 1) * $Data['PageSize'];
            if ($Page > $Data['PageCount']) {
                $Page = $Data['PageCount'];
            }
            $Lists = $MemberDebtInfoModule->GetLists($MysqlWhere, $Offset, $Data['PageSize']);
            foreach ($Lists as $key=>$value){
                $Data['Data'][$key]['DebtNum'] = $value['DebtNum'];
                $Data['Data'][$key]['DebtAmount'] = $value['DebtAmount'];
                $Data['Data'][$key]['Overduetime'] = $value['Overduetime'];
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere("  and Type =1 and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                $Province = $MemberAreaModule->GetInfoByKeyID($DebtorsInfo['Province']);
                $Data['Data'][$key]['Province'] = $Province['CnName'];
                $City = $MemberAreaModule->GetInfoByKeyID($DebtorsInfo['City']);
                $Data['Data'][$key]['City'] = $City['CnName'];
                $Area = $MemberAreaModule->GetInfoByKeyID($DebtorsInfo['Area']);
                $Data['Data'][$key]['Area'] = $Area['CnName'];
                $Data['Data'][$key]['AddTime']= !empty($value['AddTime'])? date('Y-m-d H:i:s',$value['AddTime']): '';
                $Data['Data'][$key]['Status'] = $value['Status'];
                $Data['Data'][$key]['StatusName'] = $NStatus[$value['Status']];
                $Data['Data'][$key]['Url'] = '/debt/'.$value['DebtID'].'.html';
            }
            MultiPage($Data, 5);
            if ($Keyword != '') {
                $Data['ResultCode'] = 102;
            } else {
                $Data['ResultCode'] = 200;
            }
        }else{
            $Data['ResultCode'] = 101;
            $Data['Message'] = '很抱歉，暂时无法找到符合您要求的债务。';

            EchoResult($Data);exit;
        }

        unset($Lists);
        EchoResult($Data);exit;
    }
    public function GetMysqlWhere($Intention = ''){
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        if ($Intention=='GetDebtList'){
            $MysqlWhere ='';
            $Keyword = trim($_POST['Keyword']); // 搜索关键字
            $Type = trim($_POST['col_way']); //催收方式
            if($Type!=''){
                $MysqlWhere .=" and CollectionType IN ($Type)";
            }
            $Area =trim($_POST['col_area']); //催收地区
            if($Area!=''){
                $AreaWhere = " and City IN ($Area)";
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere($AreaWhere,true);
                if ($DebtorsInfo){
                    foreach ($DebtorsInfo  as $key=>$value){
                        $data[]=$value['DebtID'];
                    }
                    $data=implode(',',array_unique($data));
                    $MysqlWhere .= " and DebtID IN ($data)";
                }
            }
            $DebtAmount = $_POST['col_money'];//债务金额
            if($DebtAmount!=''){
                if ($DebtAmount=='0-3'){
                    $MysqlWhere .= ' and DebtAmount <= 30000 ';
                }elseif ($DebtAmount=='3-10'){
                    $MysqlWhere .= ' and DebtAmount >= 30000 and DebtAmount <=100000 ';
                }elseif ($DebtAmount=='10-50'){
                    $MysqlWhere .= ' and DebtAmount >= 100000 and DebtAmount <=500000 ';
                }elseif ($DebtAmount=='50-100'){
                    $MysqlWhere .= ' and DebtAmount >= 500000 and DebtAmount <=1000000 ';
                }elseif ($DebtAmount=='100-All'){
                    $MysqlWhere .= ' and DebtAmount >= 1000000 ';
                }
                if (strstr($DebtAmount,',')){
                    $MysqlWhere .='and (';
                    if (strstr($DebtAmount,'0-3') && $DebtAmount!='0-3'){
                        $MysqlWhere .= ' or (DebtAmount <= 100000) ';
                    }
                    if (strstr($DebtAmount,'3-10') && $DebtAmount!='3-10'){
                        $MysqlWhere .= ' or (DebtAmount >= 30000 and DebtAmount <=100000) ';
                    }
                    if (strstr($DebtAmount,'10-50') && $DebtAmount!='10-50'){
                        $MysqlWhere .= ' or (DebtAmount >= 100000 and DebtAmount <=500000) ';
                    }
                    if (strstr($DebtAmount,'50-100') && $DebtAmount!='50-100'){
                        $MysqlWhere .= ' or (DebtAmount >= 500000 and DebtAmount <=1000000) ';
                    }
                    if (strstr($DebtAmount,'100-All') && $DebtAmount!='100-All'){
                        $MysqlWhere .= ' or (DebtAmount >= 1000000) ';
                    }
                    $MysqlWhere .=')';
                }
                $MysqlWhere =preg_replace('/or/','',$MysqlWhere,1);
            }
            $Overduetime = $_POST['col_day'];//逾期时间
            if($Overduetime!=''){
                if ($Overduetime=='0-60'){
                    $MysqlWhere .= ' and Overduetime <= 60 ';
                }elseif ($Overduetime=='61-180'){
                    $MysqlWhere .= ' and Overduetime >= 61 and Overduetime <=180 ';
                }elseif ($Overduetime=='181-365'){
                    $MysqlWhere .= ' and Overduetime >= 181 and Overduetime <=365 ';
                }elseif ($Overduetime=='366-1095'){
                    $MysqlWhere .= ' and Overduetime >= 366 and Overduetime <=1095 ';
                }elseif ($Overduetime=='1096-All'){
                    $MysqlWhere .= ' and Overduetime >= 1096 ';
                }
                if (strstr($Overduetime,',')){
                    $OverduetimeWhere =' and (';
                    if (strstr($Overduetime,'0-60') && $Overduetime!='0-60'){
                        $OverduetimeWhere .= ' or (Overduetime <= 60) ';
                    }
                    if (strstr($Overduetime,'61-180') && $Overduetime!='61-180'){
                        $OverduetimeWhere .= ' or (Overduetime >= 61 and Overduetime <=180) ';
                    }
                    if (strstr($Overduetime,'181-365') && $Overduetime!='181-365'){
                        $OverduetimeWhere .= ' or (Overduetime >= 181 and Overduetime <=365) ';
                    }
                    if (strstr($Overduetime,'366-1095') && $Overduetime!='366-1095'){
                        $OverduetimeWhere .= ' or (Overduetime >= 366 and Overduetime <=1095) ';
                    }
                    if (strstr($Overduetime,'1096-All') && $Overduetime!='1096-All'){
                        $OverduetimeWhere .= ' or (Overduetime >= 1096) ';
                    }
                    $OverduetimeWhere .=')';
                    $OverduetimeWhere =preg_replace('/or/','',$OverduetimeWhere,1);
                }
                $MysqlWhere .= $OverduetimeWhere;
            }
            $Page = trim($_POST['Page']);
            if ($Keyword != '') {
                $MysqlWhere .= " and (HighSchoolName like '%$Keyword%' or HighSchoolNameEng like '%$Keyword%')";
            }
            return $MysqlWhere;
        }
    }
    /**
     * @desc 老赖信息
     */
    public function debtorSearch(){
        $Time = time();
        $Num = rand(100, 999);
        $iname =trim($_POST['iname']);
        $cardNum =trim($_POST['cardNum']);
        $areaName =trim($_POST['areaName']);
        $Page =trim($_POST['Page']);
        $pn = ($Page-1)*10;
        if ($areaName=='全国'){
            $areaName='';
        }
        if ($iname==='' && $cardNum===''){
            $json_result = array(
                'ResultCode' => 102,
                'Message' => '请输入必填',
            );
            echo json_encode($json_result);
            exit;
        }
        $Html = curl_getsend('https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?resource_id=6899&query=%E5%A4%B1%E4%BF%A1%E8%A2%AB%E6%89%A7%E8%A1%8C%E4%BA%BA%E5%90%8D%E5%8D%95&cardNum='.$cardNum.'&iname='.$iname.'&areaName='.$areaName.'&pn='.$pn.'&rn=10&ie=utf-8&oe=utf-8&format=json&_='.$Time.$Num);
        $Html = json_decode($Html,true);
        $PageCount = ceil($Html['data'][0]['listNum']/10);
        if (empty($Html['data'])){
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '未找到相关失信被执行人',
            );
        }else{
            $json_result = array(
                'ResultCode' => 200,
                'Message' => '返回成功',
                "PageSize"=> 10,
                "PageCount"=>$PageCount,
                "Page"=>intval($Page),
            );
            $Result = array_slice($Html['data'][0]['result'],0,10);
            $json_result['Data'] = $Result;

        }
        echo stripslashes(json_encode($json_result,JSON_UNESCAPED_UNICODE));
        exit;
    }
    /**
     * @desc 处置方接单申请
     */
    public function ApplyOrder(){

        $_POST['DebtID']=1;
        $Data['DebtID'] = trim($_POST['DebtID']);
        $Data['Money'] = trim($_POST['percent_money']);
        $Data['AdvantageInfo'] =trim($_POST['detail_info']);
        $Data['MandatorID'] = $_SESSION ['UserID'];//委托人用户ID
        $Data['DelegateTime'] = time();//委托时间
        if ( $Data['Money']==='' && $Data['AdvantageInfo']===''){
            $json_result = array(
                'ResultCode' => 102,
                'Message' => '请输入必填',
            );
            echo json_encode($json_result);
            exit;
        }
        $_POST['Type']=1;//1-普通债务申请
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $ClaimsDisposal = $MemberClaimsDisposalModule->GetInfoByWhere(' and DebtID ='.$Data['DebtID'].' and MandatorID = '.$Data['MandatorID']);
        if (!$ClaimsDisposal){
            $Result = $MemberClaimsDisposalModule->InsertInfo($Data);
        }else{
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '您已申请此债务订单，请勿重复提交',
            );
            echo json_encode($json_result);
            exit;
        }
        if ($Result){
            $json_result = array(
                'ResultCode' => 200,
                'Message' => '申请成功',
            );
        }else{
            $json_result = array(
                'ResultCode' => 103,
                'Message' => '申请失败',
            );
        }
        echo json_encode($json_result);
        exit;
    }

    /**
     * @desc 寻找处置方(找律师团队和催收公司)
     */

    public function FindTeam(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '请先登录',
            );
            EchoResult($json_result);exit;
        }
        $MemberFindDisposalDebtModule = new MemberFindDisposalDebtModule();
        $MemberCreditorsInfoModule = new MemberCreditorsInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $Data['DebtNum'] ='MD'.date("YmdHis").rand(100, 999);
        $Data['UserID'] = $_SESSION ['UserID'];
        $Data['AddTime'] = time();
        $Data['UpdateTime'] = $Data['AddTime'];
        $Data['Status'] = 1;
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        //1律师团队，2催收公司
        $Data['Type'] = trim($AjaxData['Type']);
        //是否有前期费用
        $Data['EarlyCost'] = $AjaxData['preFee'];
        //是否随时能找到
        $Data['FindDebtor'] = $AjaxData['searchedAnytime'];
        //是否有能力还债
        $Data['RepaymentDebtor'] = $AjaxData['abilityDebt'];
        //是否有保证人
        $Data['Warrantor'] = $AjaxData['haveBondsMan'];
        if ($Data['Warrantor']=='1'){
            //保证人信息
            foreach ($AjaxData['bondsmanInfos'] as $key=>$value){
                $WarrantorInfo[$key]['type'] = trim($value['bonds_man_role']);
                $WarrantorInfo[$key]['name'] = trim($value['name']);
                $WarrantorInfo[$key]['card'] = trim($value['idNum']);
                $WarrantorInfo[$key]['phone'] = trim($value['phoneNumber']);
            }
            $Data['WarrantorInfo'] = json_encode($WarrantorInfo,JSON_UNESCAPED_UNICODE);
        }
        //是否有抵押物
        $Data['Guarantee'] = trim($AjaxData['haveBondsGood']);
        if ($Data['Guarantee']=='1'){
            //抵押物信息
            foreach ($AjaxData['bondsgoodInfos'] as $key=>$value){
                $GuaranteeInfo[$key]['name'] = trim($value['name']);
                $GuaranteeInfo[$key]['content'] = trim($value['details']);
            }
            $Data['GuaranteeInfo'] = json_encode($GuaranteeInfo,JSON_UNESCAPED_UNICODE);
        }
        $debtOwnerInfos = $AjaxData['debtOwnerInfos'];
        $debtorInfos = $AjaxData['debtorInfos'];
        $Data['BondsNum'] = count($debtOwnerInfos);//债权人数量
        $Data['DebtorNum'] = count($debtorInfos);//债务人数量
        //计算债务人和债权人金额start
        $debtOwnermoney =0;
        $debtormoney =0;
        foreach ($debtOwnerInfos as  $value) {
            $debtOwnermoney = $debtOwnermoney+trim($value['debt_money']);
        }
        foreach ($debtorInfos as  $value) {
            $debtormoney = $debtormoney+trim($value['debt_money']);
        }
        if ($debtOwnermoney!==$debtormoney){
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '债务人和债权人金额总和不一致',
            );
            EchoResult($json_result);exit;
        }else{
            $Data['DebtAmount'] = $debtOwnermoney;
        }
        //计算债务人和债权人金额end
        if (empty($debtOwnerInfos)) {
            $json_result = array(
                'ResultCode' => 103,
                'Message' => '债权人信息未填写完整',
            );
            EchoResult($json_result);exit;
        }
        if (empty($debtorInfos)){
            $json_result = array(
                'ResultCode' => 102,
                'Message' => '债务人信息未填写完整',
            );
            EchoResult($json_result);exit;
        }
        //开启事务
        global $DB;
        $DB->query("BEGIN");//开始事务定义
        $DebtID = $MemberFindDisposalDebtModule->InsertInfo($Data);
        if (!$DebtID){
            $DB->query("ROLLBACK");//判断当执行失败时回滚
            $result_json = array('ResultCode'=>102,'Message'=>'录入债务基本信息失败');
        }else{
            $DB->query("COMMIT");//执行事务
            //债权人信息
            $Datb['Type'] = 2;//类型(1:普通发布债务；2:寻找处置方债务；)
            $Datb['AddTime'] = $Data['AddTime'];
            $Datb['DebtID'] = $DebtID;
            foreach ($debtOwnerInfos as $key => $value) {
                $Datb['Name'] = trim($value['name']);
                $Datb['Card'] = trim($value['idNum']);
                $Datb['Money'] = trim($value['debt_money']);
                $Datb['Phone'] = trim($value['phoneNumber']);
                $Datb['Province'] = trim($value['province']);
                $Datb['City'] = trim($value['city']);
                $Datb['Area'] = trim($value['area']);
                $Datb['Address'] = trim($value['area']);
                $InsertCreditorsInfo = $MemberCreditorsInfoModule->InsertInfo($Datb);
                if(!$InsertCreditorsInfo){
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode'=>102,'Message'=>'录入债权人信息失败');
                    EchoResult($result_json);exit;
                }
            }
            if ($InsertCreditorsInfo){
                $DB->query("COMMIT");//执行事务
                //债务人信息
                $Datc['Type'] = 2;//类型(1:普通发布债务；2:寻找处置方债务；)
                $Datc['AddTime'] = $Data['AddTime'];
                $Datc['DebtID'] = $DebtID;
                foreach ($debtOwnerInfos as $key=>$value){
                    $Datc['Name'] = trim($value['name']);
                    $Datc['Card'] = trim($value['idNum']);
                    $Datc['Money'] = trim($value['debt_money']);
                    $Datc['Phone'] = trim($value['phoneNumber']);
                    $Datc['Province'] = trim($value['province']);
                    $Datc['City'] = trim($value['city']);
                    $Datc['Area'] = trim($value['area']);
                    $Datc['Address'] = trim($value['area']);
                    $InsertDebtorsInfo = $MemberDebtorsInfoModule->InsertInfo($Datc);
                    if(!$InsertDebtorsInfo){
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $result_json = array('ResultCode'=>103,'Message'=>'录入债务人信息失败');
                        EchoResult($result_json);exit;
                    }
                }
                if ($InsertDebtorsInfo){
                    $DB->query("COMMIT");//执行事务
                    $MemberSetCommissionModule = new MemberSetCommissionModule();
                    $MemberUserInfoModule = new MemberUserInfoModule();
                    $MemberUserModule = new MemberUserModule();
                    //1律师团队，2催收公司
                    if ($Data['Type']==1){
                        $UserInfoWhere = ' and Identity =4 ';
                    }elseif($Data['Type']==2){
                        $UserInfoWhere = ' and Identity =3 ';
                    }
                    foreach ($debtOwnerInfos  as $key=>$value){
                        $Area[] = $value['area'];
                    }
                    $Area=implode(',',array_unique($Area));
                    $MysqlWhere = " and AreaService IN ($Area)";//匹配条件待完善
                    $Commission = $MemberSetCommissionModule->GetInfoByWhere($MysqlWhere,true);
                    if (!$Commission){
                        $result_json = array('ResultCode'=>104,'Message'=>'非常抱歉，暂无找到相应的处置方！');
                        EchoResult($result_json);exit;
                    }
                    foreach ($Commission as $key =>$value){
                        $UserID[] = $value['UserID'];
                    }
                    $UserIDLists=implode(',',array_unique($UserID));
                    $UserInfoWhere .= " and IdentityState=3 and UserID IN ($UserIDLists)";
                    $UserInfo = $MemberUserInfoModule->GetLists($UserInfoWhere, 0,10);
                    if ($UserInfo){
                        foreach ($UserInfo as $key=>$value){
                            $Result['Data'][$key]['UserID'] = $value['UserID'];
                            $Result['Data'][$key]['CompanyName'] = $value['CompanyName'];
                            $Result['Data'][$key]['province'] = $value['Province'];
                            $Result['Data'][$key]['city'] = $value['City'];
                            $Result['Data'][$key]['area'] = $value['Area'];
                            $User = $MemberUserModule->GetInfoByKeyID($value['UserID']);
                            $Result['Data'][$key]['phoneNumber'] = $User['Mobile'];
                            $Result['Data'][$key]['fee'] = 1111;//佣金比例待完善
                        }
                        $Result['ResultCode'] = 200;
                        $Result['Page'] = 1;
                        $Result['PageCount'] = 1;
                        $Result['DebtId'] = $DebtID;
                        EchoResult($Result);exit;
                    }else{
                        $result_json = array('ResultCode'=>104,'Message'=>'非常抱歉，暂无找到相应的处置方！');
                        EchoResult($result_json);exit;
                    }
                }else{
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode'=>103,'Message'=>'录入债务人信息失败');
                }
            }else{
                $DB->query("ROLLBACK");//判断当执行失败时回滚
                $result_json = array('ResultCode'=>102,'Message'=>'录入债权人信息失败');
            }
        }
        EchoResult($result_json);exit;
    }
    /**
     * @desc 申请处置方
     */
    public function DisposeApply(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '请先登录',
            );
            EchoResult($json_result);exit;
        }
        $Data['MandatorID'] = $_POST['uid'];
        $Data['DebtID'] = $_POST['debtId'];
        $Data['Type'] = 2;//类型：2-寻找处置方接单申请
        $Data['Money'] = $_POST['money'];
        $Data['DelegateTime'] = time();
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $Rscount = $MemberClaimsDisposalModule->GetListsNum(' and Type =2 and DebtID = '.$Data['DebtID']);
        if ($Rscount ['Num']>='3'){
            $result_json = array('ResultCode'=>102,'Message'=>'非常抱歉，您最多只可申请三个处置方');

        }else{
            $InsertDisposal = $MemberClaimsDisposalModule->InsertInfo($Data);
            if (!$InsertDisposal){
                $result_json = array('ResultCode'=>104,'Message'=>'申请失败');
            }else{
                $result_json = array('ResultCode'=>200,'Message'=>'申请成功');
            }
        }
        EchoResult($result_json);exit;
    }
    /**
     * @desc 发布债务
     */
    public function ReleaseDebt(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '请先登录',
            );
            EchoResult($json_result);exit;
        }
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberCreditorsInfoModule = new MemberCreditorsInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        if ($_POST){
            $Data['DebtNum'] ='DB'.date("YmdHis").rand(100, 999);
            $Data['UserID'] = $_SESSION ['UserID'];
            $Data['AddTime'] = time();
            $Data['UpdateTime'] = $Data['AddTime'];
            $Data['Status'] = 8;//发布待审核
            $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
            //1律师团队，2催收公司,3自助催收
            $Data['CollectionType'] = intval($_POST['Type']);
            //是否有前期费用
            $Data['EarlyCost'] = $AjaxData['preFee'];
            //是否随时能找到
            $Data['FindDebtor'] = $AjaxData['searchedAnytime'];
            //是否有能力还债
            $Data['RepaymentDebtor'] = $AjaxData['abilityDebt'];
            //是否有保证人
            $Data['Warrantor'] = $AjaxData['haveBondsMan'];
            if ($Data['Warrantor']=='1'){
                //保证人信息
                foreach ($AjaxData['bondsmanInfos'] as $key=>$value){
                    $WarrantorInfo[$key]['type'] = trim($value['bonds_man_role']);
                    $WarrantorInfo[$key]['name'] = trim($value['name']);
                    $WarrantorInfo[$key]['card'] = trim($value['idNum']);
                    $WarrantorInfo[$key]['phone'] = trim($value['phoneNumber']);
                }
                $Data['WarrantorInfo'] = json_encode($WarrantorInfo,JSON_UNESCAPED_UNICODE);
            }
            //是否有抵押物
            $Data['Guarantee'] = trim($AjaxData['haveBondsGood']);
            if ($Data['Guarantee']=='1'){
                //抵押物信息
                foreach ($AjaxData['bondsgoodInfos'] as $key=>$value){
                    $GuaranteeInfo[$key]['name'] = trim($value['name']);
                    $GuaranteeInfo[$key]['content'] = trim($value['details']);
                }
                $Data['GuaranteeInfo'] = json_encode($GuaranteeInfo,JSON_UNESCAPED_UNICODE);
            }
            //借款原因
            $Data['ReasonsBorrowing'] = trim($AjaxData['loan_reason']);
            //借款近况
            $Data['DebtRecent'] = trim($AjaxData['loan_recent']);

            $debtOwnerInfos = $AjaxData['debtOwnerInfos'];
            $debtorInfos = $AjaxData['debtorInfos'];
            $Data['BondsNum'] = count($debtOwnerInfos);//债权人数量
            $Data['DebtorNum'] = count($debtorInfos);//债务人数量
            //计算债务人和债权人金额start
            $debtOwnermoney =0;
            $debtormoney =0;
            foreach ($debtOwnerInfos as  $value) {
                $debtOwnermoney = $debtOwnermoney+trim($value['debt_money']);
            }
            foreach ($debtorInfos as  $value) {
                $debtormoney = $debtormoney+trim($value['debt_money']);
            }
            if ($debtOwnermoney!==$debtormoney){
                $json_result = array(
                    'ResultCode' => 101,
                    'Message' => '债务人和债权人金额总和不一致',
                );
                EchoResult($json_result);exit;
            }else{
                $Data['DebtAmount'] = $debtOwnermoney;
            }
            //计算债务人和债权人金额end
            if (empty($debtOwnerInfos)) {
                $json_result = array(
                    'ResultCode' => 102,
                    'Message' => '债权人信息未填写完整',
                );
                EchoResult($json_result);exit;
            }
            if (empty($debtorInfos)){
                $json_result = array(
                    'ResultCode' => 103,
                    'Message' => '债务人信息未填写完整',
                );
                EchoResult($json_result);exit;
            }
            //开启事务
            global $DB;
            $DB->query("BEGIN");//开始事务定义
            $DebtID = $MemberDebtInfoModule->InsertInfo($Data);
            if ($DebtID){
                $DB->query("COMMIT");//执行事务
                //债权人信息
                $Datb['Type'] = 1;//类型(1:普通发布债务)
                $Datb['AddTime'] = $Data['AddTime'];
                $Datb['DebtID'] = $DebtID;
                foreach ($debtOwnerInfos as $key => $value) {
                    $Datb['Name'] = trim($value['name']);
                    $Datb['Card'] = trim($value['idNum']);
                    $Datb['Money'] = trim($value['debt_money']);
                    $Datb['Phone'] = trim($value['phoneNumber']);
                    $Datb['Province'] = trim($value['province']);
                    $Datb['City'] = trim($value['city']);
                    $Datb['Area'] = trim($value['area']);
                    $Datb['Address'] = trim($value['area']);
                    $InsertCreditorsInfo = $MemberCreditorsInfoModule->InsertInfo($Datb);
                    if (!$InsertCreditorsInfo) {
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $result_json = array('ResultCode' => 104, 'Message' => '录入债权人信息失败');
                        EchoResult($result_json);
                        exit;
                    }
                }
                if ($InsertCreditorsInfo) {
                    $DB->query("COMMIT");//执行事务
                    //债务人信息
                    $Datc['Type']  =1;//类型(1:普通发布债务)
                    $Datc['AddTime'] = $Data['AddTime'];
                    $Datc['DebtID'] = $DebtID;
                    foreach ($debtOwnerInfos as $key => $value) {
                        $Datc['Name'] = trim($value['name']);
                        $Datc['Card'] = trim($value['idNum']);
                        $Datc['Money'] = trim($value['debt_money']);
                        $Datc['Phone'] = trim($value['phoneNumber']);
                        $Datc['Province'] = trim($value['province']);
                        $Datc['City'] = trim($value['city']);
                        $Datc['Area'] = trim($value['area']);
                        $Datc['Address'] = trim($value['area']);
                        $InsertDebtorsInfo = $MemberDebtorsInfoModule->InsertInfo($Datc);
                        if (!$InsertDebtorsInfo) {
                            $DB->query("ROLLBACK");//判断当执行失败时回滚
                            $result_json = array('ResultCode' => 105, 'Message' => '录入债务人信息失败');
                            EchoResult($result_json);
                            exit;
                        }
                    }
                    if ($InsertDebtorsInfo){
                        $MemberDebtImageModule = new MemberDebtImageModule();
                        if (!empty($AjaxData['images'])){
                            $Date['DebtID']= $DebtID;
                            foreach ($AjaxData['images'] as $key=>$value){
                                if ($key==0){
                                    $Date['IsDefault']= 1;
                                }else{
                                    $Date['IsDefault']= 0;
                                }
                                $UpdateDebtImage = $MemberDebtImageModule->UpdateInfoByWhere($Date,' `ImageUrl` = \'' . $value . '\'');
                            }
                            if (!$UpdateDebtImage){
                                $DB->query("ROLLBACK");//判断当执行失败时回滚
                                $result_json = array('ResultCode'=>102,'Message'=>'添加借款凭证失败');
                            }else{
                                $DB->query("COMMIT");//执行事务
                                $result_json = array('ResultCode'=>200,'Message'=>'债务发布成功，请等待审核！');
                            }
                        }else{
                            $DB->query("COMMIT");//执行事务
                            $result_json = array('ResultCode'=>200,'Message'=>'债务发布成功，请等待审核！');
                        }
                    }else{
                        $result_json = array('ResultCode' => 106, 'Message' => '录入债务人信息失败');
                    }
                }
            }else{
                $DB->query("ROLLBACK");//判断当执行失败时回滚
                $result_json = array('ResultCode'=>106,'Message'=>'录入债务基本信息失败');
            }

        }else {
            $result_json = array('ResultCode'=>107,'Message'=>'录入债务基本信息失败');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 发布债务添加借款凭证
     */
    public function AddBorrowImage(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '请先登录',
            );
            EchoResult($json_result);exit;
        }
        $MemberDebtImageModule = new MemberDebtImageModule();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $ImageUrl = SendToImgServ($ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        $Data['IsDefault'] = 0;
        if ($Data['ImageUrl'] !==''){
            $DebtImage = $MemberDebtImageModule->InsertInfo($Data);
            if ($DebtImage){
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
     * @desc 发布悬赏
     */
    public function ReleaseReward(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '请先登录',
            );
            EchoResult($json_result);exit;
        }
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $Data['RewardNum'] ='XS'.date("YmdHis").rand(100, 999);
        $Data['UserID'] = $_SESSION ['UserID'];
        $Data['AddTime'] = time();
        $Data['Type'] = $AjaxData['reword_type'];
        $Data['CreditorsPhone'] =$AjaxData['debt_owner']['phoneNumber'];
        $Data['DebtName'] =$AjaxData['debtor']['name'];
        $Data['DebtCard'] =$AjaxData['debtor']['idNum'];
        $Data['DebtPhone'] =$AjaxData['debtor']['phoneNumber'];
        $Data['Province'] =$AjaxData['debtor']['province'];
        $Data['City'] =$AjaxData['debtor']['city'];
        $Data['Area'] =$AjaxData['debtor']['area'];
        $Data['Address'] =$AjaxData['debtor']['areaDetail'];
        $Data['Status'] =2;
        //开启事务
        global $DB;
        $DB->query("BEGIN");//开始事务定义
        $ID = $MemberRewardInfoModule->InsertInfo($Data);
        if (!$ID){
            $DB->query("ROLLBACK");//判断当执行失败时回滚
            $result_json = array('ResultCode'=>101,'Message'=>'悬赏发布失败');
        }else{
            if (!empty($AjaxData['images'])){
                $Date['RewardID']= $ID;
                foreach ($AjaxData['images'] as $key=>$value){
                    if ($key==0){
                        $Date['IsDefault']= 1;
                    }else{
                        $Date['IsDefault']= 0;
                    }
                  $UpdateRewardImage = $MemberRewardImageModule->UpdateInfoByWhere($Date,' `ImageUrl` = \'' . $value . '\'');
                }
                if (!$UpdateRewardImage){
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode'=>102,'Message'=>'添加悬赏图片失败');
                }else{
                    $DB->query("COMMIT");//执行事务
                    $result_json = array('ResultCode'=>200,'Message'=>'请等待审核！');
                }
            }else{
                $DB->query("COMMIT");//执行事务
                $result_json = array('ResultCode'=>200,'Message'=>'请等待审核！');
            }

        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 添加发布悬赏图片
     */
    public function AddRewardImage(){
        $MemberRewardImageModule = new MemberRewardImageModule();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $ImageUrl = SendToImgServ($ImgBaseData);
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
}