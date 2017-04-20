<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/3/14
 * Time: 14:31
 */
class Reword
{
    public function __construct() {

    }
    /**
     * @desc  线索悬赏列表
     */
    public function Index(){
        $Title="线索悬赏-隆文贵债务处置";
        $Nav = 'rewordlists';
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $MemberAreaModule = new MemberAreaModule();
        $MysqlWhere =' and `Status` >2';
        $AreaList = $MemberAreaModule->GetInfoByWhere(' and R1 =1 order by S1 asc',true);
        $MyUrl = WEB_MAIN_URL.'/reword/';
        $SoUrl = $_GET['SoUrl'];
        if (strstr ( $SoUrl, 'a1' )){
            $Type = 'a1';
            $MysqlWhere .= ' and Type =1 ';
        }elseif (strstr ( $SoUrl, 'a2' )){
            $Type = 'a2';
            $MysqlWhere .= ' and Type =2 ';
        }
        $Keyword = trim($_GET['K']);
        if ($Keyword !=''){
            $MysqlWhere .= ' and (DebtName like \'%'.$Keyword.'%\' or DebtCard =\'' .$Keyword.'\')';
        }
        if (strstr ($SoUrl, 'a' )){
            $Area = strstr($SoUrl,"a",true);
        }else{
            $Area = $SoUrl;
        }
        if ($Area){
            if ($Area==1009 || $Area==1001){
                $MysqlWhere .= ' and Province = '.$Area;
            }elseif ($Area==1153 || $Area==1236){
                $MysqlWhere .= ' and City = '.$Area;
            }else{
                $MysqlWhere .= ' and Area = '.$Area;
            }
        }
        //分页查询开始-------------------------------------------------
        $Rscount = $MemberRewardInfoModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $MysqlWhere .=' order by AddTime desc';
            $PageSize=4;
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
                if ($value['Province'])
                $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                if ($value['City'])
                    $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                if ($value['Area'])
                    $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
                $Data['Data'][$key]['DebtCard'] = strlen($value['DebtCard']) ? substr_replace($value['DebtCard'], '****', 10, 4) : '';
               $RewardImage = $MemberRewardImageModule->GetInfoByWhere(' and RewardID = '.$value['ID'],true);
               foreach ($RewardImage as $K=>$V){
                if ($V['IsDefault']==1){
                    $Data['Data'][$key]['DefaultImage'] = $V['ImageUrl'];
                }else{
                    $Data['Data'][$key]['Image'][] = $V['ImageUrl'];
                }
               }
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('RewordLists');
    }
    /**
     * @desc  发布悬赏
     */
    public function RewordPublish(){
        $Title="发布悬赏-隆文贵债务处置";
        $Nav = 'rewordlists';
    include template('RewordPublish');
    }
}