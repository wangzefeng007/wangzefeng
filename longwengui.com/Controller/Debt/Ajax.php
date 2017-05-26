<?php
/**
 * @desc
 * Class Ajax
 */
class Ajax
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
     * @desc 律师援助信息
     */
    public function GetLegalAid(){
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MysqlWhere = '';

       if (trim($_POST['help_area'])!=''){
        $AreaID = intval($_POST['help_area']);
           $MysqlWhere .= ' and  Area like \'%'.$AreaID.'%\'';
        }
        if (trim($_POST['case_type'])!=''){
            $GoodAt = intval($_POST['case_type']);
            $MysqlWhere .= ' and MATCH (`GoodAt`) AGAINST (\'' . $GoodAt . '\' IN BOOLEAN MODE)';
        }
        //关键字
        $Rscount = $MemberLawfirmAidModule->GetListsNum($MysqlWhere);
        $Page = intval($_POST['Page']) < 1 ? 1 : intval($_POST['Page']); // 页码 可能是空
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=5;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $List= $MemberLawfirmAidModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($List as $key=>$value){
                $AreaInfo = json_decode($value['Area'],true);
                foreach($AreaInfo as $K=>$V){
                    $AreaInfo[$K]['province'] = $MemberAreaModule->GetCnNameByKeyID($V['province']);
                    $AreaInfo[$K]['city'] = $MemberAreaModule->GetCnNameByKeyID($V['city']);
                    $AreaInfo[$K]['area'] = $MemberAreaModule->GetCnNameByKeyID($V['area']);
                }
                $Data['Data'][$key]['Area'] = $AreaInfo;
                $UserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                $Data['Data'][$key]['Avatar'] = $UserInfo['Avatar'];
                $Data['Data'][$key]['CompanyName'] = $UserInfo['CompanyName'];
                $Data['Data'][$key]['ChargeMobile'] = $value['ChargeMobile'];
                $Data['Data'][$key]['Content'] = $value['Content'];
            }
            MultiPage($Data, 5);
            $Data['Message'] = '返回成功';
            $Data['ResultCode'] = 200;
        }else{
            $Data['ResultCode'] = 101;
            $Data['Message'] = '很抱歉，暂时无法找到符合您要求的律师援助信息';
            EchoResult($Data);exit;
        }
        EchoResult($Data);exit;
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
        $Intention = trim($_POST['Intention']);
        $MysqlWhere = ' and `Status` <= 7 ';
        if ($_POST) {
            $MysqlWhere .= $this->GetMysqlWhere($Intention);
        }
        $MysqlWhere .= ' order by Status asc , AddTime desc';
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
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                if ($DebtorsInfo['Province'])
                    $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                    $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                    $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
                $Data['Data'][$key]['AddTime']= !empty($value['AddTime'])? date('Y-m-d H:i:s',$value['AddTime']): '';
                $Data['Data'][$key]['Status'] = $value['Status'];
                $Data['Data'][$key]['StatusName'] = $NStatus[$value['Status']];
                $Data['Data'][$key]['Url'] = '/debt/'.$value['DebtID'].'.html';
            }
            MultiPage($Data, 5);
            $Data['ResultCode'] = 200;
        }else{
            $Data['ResultCode'] = 101;
            $Data['Message'] = '很抱歉，暂时无法找到符合您要求的债务。';
            EchoResult($Data);exit;
        }
        unset($Lists);
        EchoResult($Data);exit;
    }
    public function GetMysqlWhere($Intention = ''){
        $MemberAreaModule = new MemberAreaModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        if ($Intention=='GetDebtList'){
            $MysqlWhere ='';
            $Keyword = trim($_POST['Keyword']); // 搜索关键字
            $Type = trim($_POST['col_way']); //催收方式
            if($Type!='all'){
                $MysqlWhere .=" and CollectionType = $Type";
            }
            $Area =trim($_POST['col_area']); //催收地区
            $City =trim($_POST['col_city']); //催收地区
            if(!empty($Area) && $Area!='all'){
                $Areas = $MemberAreaModule->GetInfoByKeyID($Area);
                if ($Areas['Level']==1){
                    $AreaWhere = " and Province = $Area";
                }elseif($Areas['Level']==2){
                    $AreaWhere = " and City = $Area";
                }elseif($Areas['Level']==3){
                    $AreaWhere = " and Area = $Area";
                }

                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere($AreaWhere,true);
                if ($DebtorsInfo){
                    foreach ($DebtorsInfo  as $key=>$value){
                        $data[]=$value['DebtID'];
                    }
                    $data=implode(',',array_unique($data));
                    $MysqlWhere .= " and DebtID IN ($data)";
                }else{
                    $MysqlWhere .= " and DebtID<0";
                }
            }
            if(!empty($City) && $City!='all'){
                $AreaInfo = $MemberAreaModule->GetInfoByKeyID($City);
                if ($AreaInfo['Level']==1){
                    $CityWhere = " and Province = $City";
                }elseif($AreaInfo['Level']==2){
                    $CityWhere = " and City = $City";
                }elseif($AreaInfo['Level']==3){
                    $CityWhere = " and Area = $City";
                }
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere($CityWhere,true);
                if ($DebtorsInfo){
                    foreach ($DebtorsInfo  as $key=>$value){
                        $data[]=$value['DebtID'];
                    }
                    $data=implode(',',array_unique($data));
                    $MysqlWhere .= " and DebtID IN ($data)";
                }else{
                    $MysqlWhere .= " and DebtID<0";
                }
            }

            $DebtAmount = $_POST['col_money'];//债务金额
            if($DebtAmount!='all'){
                if ($DebtAmount=='1'){
                    $MysqlWhere .= ' and DebtAmount <= 30000 ';
                }elseif ($DebtAmount=='2'){
                    $MysqlWhere .= ' and DebtAmount >= 30000 and DebtAmount <=100000 ';
                }elseif ($DebtAmount=='3'){
                    $MysqlWhere .= ' and DebtAmount >= 100000 and DebtAmount <=500000 ';
                }elseif ($DebtAmount=='4'){
                    $MysqlWhere .= ' and DebtAmount >= 500000 and DebtAmount <=1000000 ';
                }elseif ($DebtAmount=='5'){
                    $MysqlWhere .= ' and DebtAmount >= 1000000 ';
                }
            }

            $Overduetime = $_POST['col_day'];//逾期时间
            if($Overduetime!='all'){
                if ($Overduetime=='1'){
                    $MysqlWhere .= ' and Overduetime <= 60 ';
                }elseif ($Overduetime=='2'){
                    $MysqlWhere .= ' and Overduetime >= 61 and Overduetime <=180 ';
                }elseif ($Overduetime=='3'){
                    $MysqlWhere .= ' and Overduetime >= 181 and Overduetime <=365 ';
                }elseif ($Overduetime=='4'){
                    $MysqlWhere .= ' and Overduetime >= 366 and Overduetime <=1095 ';
                }elseif ($Overduetime=='5'){
                    $MysqlWhere .= ' and Overduetime >= 1096 ';
                }
            }
            $Page = trim($_POST['Page']);
            if ($Keyword != '') {
                $KeywordWhere = ' and (Name like \'%'.$Keyword.'%\' or Card =\'' .$Keyword.'\')';
                $KeywordInfo = $MemberDebtorsInfoModule->GetInfoByWhere($KeywordWhere,true);
                if ($KeywordInfo){
                    foreach ($KeywordInfo  as $key=>$value){
                        $KeywordData[]=$value['DebtID'];
                    }
                    $KeywordData=implode(',',array_unique($KeywordData));
                    $MysqlWhere .= " and DebtID IN ($KeywordData)";
                }
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
     * @desc 催客、催收公司和律师接单申请
     */
    public function ApplyOrder(){
        $this->IsLogin();
        $Data['DebtID'] = trim($_POST['DebtId']);
        $Data['Money'] = trim($_POST['percent_money']);
        $Data['AdvantageInfo'] =trim($_POST['detail_info']);
        $Data['UserID'] = $_SESSION ['UserID'];//委托人用户ID
        $Data['DelegateTime'] = time();//委托时间
        $Data['Status'] = 1;//债权当前状态
        if ( $Data['Money']==='' && $Data['AdvantageInfo']===''){
            $json_result = array(
                'ResultCode' => 102,
                'Message' => '请输入必填',
            );
            echo json_encode($json_result);
            exit;
        }
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID = '.$_SESSION ['UserID']);
        if ($UserInfo['IdentityState']!=3){
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '请等待审核通过后方可接单，感谢您的配合！',
            );
            echo json_encode($json_result);
            exit;
        }
        if ($UserInfo['Identity']==2){
            $Url = '/memberperson/applydebtorder/';
        }elseif ($UserInfo['Identity']==3){
            $Url = '/memberfirm/applydebtorder/';
        }elseif ($UserInfo['Identity']==4){
            $Url = '/memberlawyer/applydebtorder/';
        }
        $ClaimsDisposal = $MemberClaimsDisposalModule->GetInfoByWhere(' and DebtID ='.$Data['DebtID'].' and UserID = '.$Data['UserID']);
        if (!$ClaimsDisposal){
            $Result = $MemberClaimsDisposalModule->InsertInfo($Data);
        }else{
            $json_result = array(
                'ResultCode' => 103,
                'Message' => '您已申请此债务订单，请勿重复提交',
            );
            echo json_encode($json_result);
            exit;
        }
        if ($Result){
            $json_result = array(
                'ResultCode' => 200,
                'Message' => '申请成功',
                'Url'=>$Url,
            );
        }else{
            $json_result = array(
                'ResultCode' => 104,
                'Message' => '申请失败',
            );
        }
        echo json_encode($json_result);
        exit;
    }

    /**
     * @desc 发布债务
     */
    public function ReleaseDebt(){
        $this->IsLogin();
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
            //是否有亲友联系方式
            $Data['DebtFamily'] = trim($AjaxData['haveDebtFamily']);
            if ($Data['DebtFamily']=='1'){
                //亲友联系方式信息
                foreach ($AjaxData['debtfamilyInfos'] as $key=>$value){
                    $DebtFamilyInfo[$key]['name'] = trim($value['name']);
                    $DebtFamilyInfo[$key]['relationship'] = trim($value['relationship']);
                    $DebtFamilyInfo[$key]['phoneNumber'] = trim($value['phoneNumber']);
                }
                $Data['DebtFamilyInfo'] = json_encode($DebtFamilyInfo,JSON_UNESCAPED_UNICODE);
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
            //逾期时间
            $Data['Overduetime'] = strtotime($AjaxData['overDay']);
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
                    $Datb['Address'] = trim($value['areaDetail']);
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
                    $Datc['AddTime'] = $Data['AddTime'];
                    $Datc['DebtID'] = $DebtID;
                    foreach ($debtorInfos as $key => $value) {
                        $Datc['Name'] = trim($value['name']);
                        $Datc['Card'] = trim($value['idNum']);
                        $Datc['Money'] = trim($value['debt_money']);
                        $Datc['Phone'] = trim($value['phoneNumber']);
                        $Datc['Province'] = trim($value['province']);
                        $Datc['City'] = trim($value['city']);
                        $Datc['Area'] = trim($value['area']);
                        $Datc['Address'] = trim($value['areaDetail']);
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
                                ToolService::SendSMSNotice($_SESSION['Account'], '尊敬的用户，您发布的债务正在审核，请您耐心等待，如有不便请见谅');
                                ToolService::SendSMSNotice(18039847468, '有用户上传债务请及时审核');
                                $result_json = array('ResultCode'=>200,'Message'=>'债务发布成功，请等待审核！','Url'=>WEB_MAIN_URL.'/debt/'.$DebtID.'.html');
                            }
                        }else{
                            $DB->query("COMMIT");//执行事务
                            ToolService::SendSMSNotice($_SESSION['Account'], '尊敬的用户，您发布的债务正在审核，请您耐心等待，如有不便请见谅');
                            ToolService::SendSMSNotice(18039847468, '有用户上传债务请及时审核');
                            $result_json = array('ResultCode'=>200,'Message'=>'债务发布成功，请等待审核！','Url'=>WEB_MAIN_URL.'/debt/'.$DebtID.'.html');
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
        $this->IsLogin();
        $MemberDebtImageModule = new MemberDebtImageModule();
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $savePath = '/Uploads/Debt/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
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
        $this->IsLogin();
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);

        $Data['RewardNum'] ='XS'.date("YmdHis").rand(100, 999);
        $Data['UserID'] = $_SESSION ['UserID'];
        $Data['AddTime'] = time();
        $Data['Type'] = $AjaxData['reword_type'];
        $Data['Status'] =2;
        $Data['Message'] =json_encode($AjaxData['findMsg'],JSON_UNESCAPED_UNICODE);
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
                    $result_json = array('ResultCode'=>200,'Message'=>'请等待审核！','Url'=>WEB_MAIN_URL.'/member/login');
                }
            }else{
                $DB->query("COMMIT");//执行事务
                $result_json = array('ResultCode'=>200,'Message'=>'请等待审核！','Url'=>WEB_MAIN_URL.'/member/login');
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
        $savePath = '/Uploads/Debt/'.date('Ymd').'/';
        $ImageUrl = SendToImgServ($savePath,$ImgBaseData);
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
    /**
     * @desc 寻找处置方（催收公司催客设置接单要求）
     */
    public function SetFirmDemand(){
        $this->IsLogin();
        $MemberOrderDemandModule = new MemberOrderDemandModule();
        if ($_POST){
            $ID = $_POST['ID'];
            $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
            $Data['CaseName'] = $AjaxData['case_name'];//方案名称
            $Data['Area'] = json_encode($AjaxData['area'],JSON_UNESCAPED_UNICODE);//地区
            $Data['FeeRate'] = json_encode($AjaxData['fee_rate'],JSON_UNESCAPED_UNICODE);//佣金比例
            $Data['AbilityDebt'] = $AjaxData['abilityDebt'];//债务人有无还款能力
            $Data['ArrivalSite'] = $AjaxData['arrivalSite'];//是否需要债权人到达现场
            $Data['ChargeName'] = $AjaxData['chargeName'];//负责人姓名
            $Data['ChargeMobile'] = $AjaxData['chargeMobile'];//负责人电话
            $Data['Content'] = $AjaxData['more'];//介绍
            $Data['AddTime'] = time();
            $Data['UpdateTime'] = $Data['AddTime'];
            $Data['UserID'] = $_SESSION ['UserID'];
            if ($_SESSION['Identity']==2){
                $Url = '/memberperson/demandlist/';
            }elseif ($_SESSION['Identity']==3){
                $Url = '/memberfirm/demandlist/';
            }
            if (empty($ID)){
                $Result = $MemberOrderDemandModule->InsertInfo($Data);
            }else{
                $Result = $MemberOrderDemandModule->UpdateInfoByKeyID($Data,$ID);
            }
            if ($Result){
                $result_json = array('ResultCode'=>200,'Message'=>'保存成功！','Url'=>$Url);
            }else{
                $result_json = array('ResultCode'=>102,'Message'=>'保存失败！');

            }
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 设置援助方案
     */
    public function SetLawFirmAid(){
        $this->IsLogin();
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        if ($_POST){
            $ID = $_POST['ID'];
            $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
            $Data['CaseName'] = $AjaxData['case_name'];//方案名称
            $Data['Area'] = json_encode($AjaxData['area'],JSON_UNESCAPED_UNICODE);//地区
            $Data['ChargeName'] = $AjaxData['chargeName'];//负责人姓名
            $Data['ChargeMobile'] = $AjaxData['chargeMobile'];//负责人电话
            $Data['Content'] = $AjaxData['more'];//介绍
            $Data['AddTime'] = time();
            $Data['UpdateTime'] = $Data['AddTime'];
            $Data['UserID'] = $_SESSION ['UserID'];
            $Data['GoodAt'] = implode(',',array_unique($AjaxData['goodAt']));
            if (empty($ID)){
                $Result = $MemberLawfirmAidModule->InsertInfo($Data);
            }else{
                $Result = $MemberLawfirmAidModule->UpdateInfoByKeyID($Data,$ID);
            }
            if ($Result){
                $result_json = array('ResultCode'=>200,'Message'=>'保存成功！','Url'=>'/memberlawfirm/aidlist/');
            }else{
                $result_json = array('ResultCode'=>102,'Message'=>'保存失败！');

            }
            EchoResult($result_json);
            exit;
        }
    }

    /**
     * @desc 获取客户SESSION信息
     */
    private function GetSession()
    {
        $MemberUserInfoModule = new MemberUserInfoModule ();
        $Data ['UserID'] = $_POST ['ID'];
        $Data ['Account'] = $_POST ['Account'];
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID ='.$Data ['UserID']);
        $Data ['Identity'] = $UserInfo['Identity'];
        $Data ['IdentityState'] = $UserInfo['IdentityState'];
        $Data ['NickName'] = $UserInfo ['NickName'];
        $Data ['Level'] = $UserInfo ['Level'];
        $Data ['Avatar'] = $UserInfo ['Avatar'];
        echo json_encode($Data);
    }
}