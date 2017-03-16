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
        $Intention = trim($_GET ['Intention']);
        if ($Intention == '') {
            $json_result = array(
                'ResultCode' => 500,
                'Message' => '系統錯誤',
                'Url' => ''
            );
            echo $json_result;
            exit;
        }
        $this->$Intention ();
    }
    /**
     * @desc 债务催收信息
     */
    public function GetDebtList(){
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtInfoModule->GetLists();
        $StatusInfo = $MemberDebtInfoModule->Status;
        if (!$_POST) {
            $Data['ResultCode'] = 100;
            EchoResult($Data);
        }
        $Keyword = trim($_POST['Keyword']);
        $Intention = trim($_POST['Intention']);
        $MysqlWhere = '';
        if ($_POST) {
            $MysqlWhere .= $this->GetMysqlWhere($Intention);
            $Sort = trim($_POST['Sort']);
            if ($Sort=='Default'){
                $MysqlWhere .=' order by HighSchoolID ASC';
            }
        }
        $Page = intval($_POST['Page']) < 1 ? 1 : intval($_POST['Page']); // 页码 可能是空
        $PageSize = 10;
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
                $Data['Data'][$key]['Study_name'] = $value['HighSchoolName'];
                $Data['Data'][$key]['StudyID'] = $value['HighSchoolID'];
                $Data['Data'][$key]['StudyLocation'] = $value['Location'];
                $Data['Data'][$key]['StudySAT'] = $value['SAT'];
                $Data['Data'][$key]['StudyAP'] = $value['AP'];
                $Data['Data'][$key]['StudyAnnualCost'] = $value['Cost'];
                $Data['Data'][$key]['StudyAccommodationMode'] = $value['Stay'];
                $Data['Data'][$key]['StudyImg'] = $value['Icon'];
                $Data['Data'][$key]['StudyUrl'] = "/highschool/".$value['HighSchoolID'].'.html';
            }
            MultiPage($Data, 5);
            if ($Keyword != '') {
                $Data['ResultCode'] = 102;
            } else {
                $Data['ResultCode'] = 200;
            }
        }
        unset($Lists);
        EchoResult($Data);
    }
    public function GetMysqlWhere($Intention = ''){
        $MemberAreaModule = new MemberAreaModule();
        if ($Intention=='GetDebtList'){
            $MysqlWhere ='';
            $Keyword = trim($_POST['Keyword']); // 搜索关键字
            $Type = $_POST['col_way']; //催收方式
            if($Type[0]!=''){
                $MysqlWhere ='';
            }
            $Area = $_POST['col_area']; //催收地区
            if($Area[0]!=''){
            foreach ($Area as $value){
                $MemberAreaModule->GetInfoByKeyID($value);
            }
            }
            $Money = $_POST['col_money'];//催收金额
            if($Money[0]!=''){
            }
            $Day = $_POST['col_day'];//催收天数
            if($Day[0]!=''){
            }

            $Location = $_POST['Location'];
            if($Location[0]!='All'){
                $Location=implode(',', $Location);
                $MysqlWhere .=" and Province in ($Location)";
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
        $iname =trim($_GET['iname']);
        $cardNum =trim($_GET['cardNum']);
        $areaName =trim($_GET['areaName']);
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