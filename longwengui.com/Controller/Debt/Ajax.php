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
        if ($Intention=='GetDebtList'){
            $MysqlWhere ='';
            $Keyword = trim($_POST['Keyword']); // 搜索关键字
            $AP = $_POST['AP']; //AP数量
            if($AP[0]!='All'){
                $MysqlWhere.=' and (';
                foreach($AP as $val){
                    if ($val=='0-10'){
                        $MysqlWhere .='(AP<= 10) or ';
                    }elseif ($val=='10-15'){
                        $MysqlWhere .='(AP >= 10 and AP <= 15) or ';
                    }elseif ($val=='15-20'){
                        $MysqlWhere .='(AP >= 15 and AP <= 20) or ';
                    }elseif ($val=='20-All'){
                        $MysqlWhere .='(AP >= 20) or ';
                    }
                }
                $MysqlWhere=rtrim($MysqlWhere,' or ').')';
            }
            $AnnualCost = $_POST['AnnualCost'];//天数
            if($AnnualCost[0]!='All'){
                $MysqlWhere.=' and (';
                foreach($AnnualCost as $val){
                    if ($val=='0-30000'){
                        $MysqlWhere .='(Cost<= 30000) or ';
                    }elseif ($val=='30000-40000'){
                        $MysqlWhere .='(Cost >= 30000 and Cost <= 40000) or ';
                    }elseif ($val=='40000-50000'){
                        $MysqlWhere .='(Cost >= 40000 and Cost <= 50000) or ';
                    }elseif ($val=='50000-All'){
                        $MysqlWhere .='(Cost >= 50000) or ';
                    }
                }
                $MysqlWhere=rtrim($MysqlWhere,' or ').')';
            }
            $AccommodationMode = $_POST['AccommodationMode'];//住宿方式
            if($AccommodationMode[0]!='All'){
                $MysqlWhere.=' and (';
                foreach($AccommodationMode as $val){
                    if ($val ==1){
                        $Stay='寄宿家庭';

                    }elseif ($val ==2){
                        $Stay='学校宿舍';
                    }elseif($val ==3){
                        $Stay='两者都提供';
                    }
                    $MysqlWhere .="Stay ='$Stay' or ";
                }
                $MysqlWhere=rtrim($MysqlWhere,' or ').')';
            }

            $Location = $_POST['Location'];
            if($Location[0]!='All'){
                $Location=implode(',', $Location);
                $MysqlWhere .=" and Province in ($Location)";
            }

            $Sort = trim($_POST['Sort']);
            $Page = trim($_POST['Page']);

            if ($Keyword != '') {
                $MysqlWhere .= " and (HighSchoolName like '%$Keyword%' or HighSchoolNameEng like '%$Keyword%')";
            }
            if ($Sort =='APAsce'){
                $MysqlWhere .=' order by AP ASC';
            }elseif ($Sort =='APDown'){
                $MysqlWhere .=' order by AP DESC';
            }elseif($Sort =='ExpensesAsce'){
                $MysqlWhere .=' order by Cost ASC';
            }elseif ($Sort =='ExpensesDown'){
                $MysqlWhere .=' order by Cost DESC';
            }

            return $MysqlWhere;
        }
    }
}