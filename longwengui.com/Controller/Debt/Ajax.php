<?php

/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2017/3/9
 * Time: 16:42
 */
class Ajax
{    public function __construct()
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
        $MysqlWhere = '';
        if ($_POST) {
            $MysqlWhere .= $this->GetMysqlWhere($Intention);
        }
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
            }
            MultiPage($Data, 5);
            if ($Keyword != '') {
                $Data['ResultCode'] = 102;
            } else {
                $Data['ResultCode'] = 200;
            }
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
        $Html = curl_getsend('https://sp0.baidu.com/8aQDcjqpAAV3otqbppnN2DJv/api.php?resource_id=6899&query=%E5%A4%B1%E4%BF%A1%E8%A2%AB%E6%89%A7%E8%A1%8C%E4%BA%BA%E5%90%8D%E5%8D%95&cardNum='.$cardNum.'&iname='.$iname.'&areaName='.$areaName.'&ie=utf-8&oe=utf-8&format=json&_='.$Time.$Num);
        $Html = json_decode($Html,true);
        if (empty($Html['data'])){
            $json_result = array(
                'ResultCode' => 101,
                'Message' => '未找到相关失信被执行人',
            );
        }else{
            $json_result = array(
                'ResultCode' => 200,
                'Message' => '返回成功',
            );
            $json_result['Data'] =  $Html['data'][0]['result'];
        }
        echo stripslashes(json_encode($json_result,JSON_UNESCAPED_UNICODE));
        exit;
    }
}