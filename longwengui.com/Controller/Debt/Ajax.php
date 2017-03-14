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
            echo $json_result;
            exit;
        }
        $this->$Intention ();
    }
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
        }else{
            //搜索无数据，返回6所热门高中院校
            $MysqlWhere =' and HotRecommend = 1 ';
            $Lists = $MemberDebtInfoModule->GetLists($MysqlWhere,0,6);
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
            if ($Keyword != '') {
                $Data['ResultCode'] = 102;
            } else {
                $Data['ResultCode'] = 101;
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
}