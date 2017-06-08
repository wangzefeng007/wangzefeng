<?php
/**
 * @desc  寻找处置方
 */
class Find
{
    public function __construct() {

    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=1 && $_SESSION['Identity']!=2 && $_SESSION['Identity']!=5)
                alertandgotopage("访问被拒绝！您没有此项权限", WEB_MAIN_URL.'/choicefind/');
        }
    }
    /**
     * @desc  寻找处置方
     */
    public function ChoiceFind(){
        $Title="寻找处置方-文贵网";
        $Nav ='find';
        $MemberOrderDemandModule = new MemberOrderDemandModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //分页查询开始-------------------------------------------------
        $MysqlWhere = ' ';
        //关键字
        $Province = trim($_GET['dd_province']);
        if ($Province!=''){
            $MysqlWhere .= ' and  Area like \'%'.$Province.'%\'';
        }
        $City = trim($_GET['dd_city']);
        if ($City!=''){
            $MysqlWhere .= ' and  Area like \'%'.$City.'%\'';
        }
        $Rscount = $MemberOrderDemandModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberOrderDemandModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $AreaInfo = json_decode($value['Area'],true);
                foreach($AreaInfo as $K=>$V){
                    $AreaInfo[$K]['province'] = $MemberAreaModule->GetCnNameByKeyID($V['province']);
                    $AreaInfo[$K]['city'] = $MemberAreaModule->GetCnNameByKeyID($V['city']);
                    $AreaInfo[$K]['area'] = $MemberAreaModule->GetCnNameByKeyID($V['area']);
                }
                $Data['Data'][$key]['Area'] = $AreaInfo;
                $FeeRateInfo = json_decode($value['FeeRate'],true);
                $Data['Data'][$key]['FeeRate'] = $FeeRateInfo;
                $UserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                $Data['Data'][$key]['Identity'] = $UserInfo['Identity'];
                $Data['Data'][$key]['Avatar'] = $UserInfo['Avatar'];
                if ($UserInfo['Identity']==2){
                    $Data['Data'][$key]['Name'] = $UserInfo['RealName'];
                }elseif ($UserInfo['Identity']==3){
                    $Data['Data'][$key]['Name'] = $UserInfo['CompanyName'];
                }
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
//     echo "<pre>";print_r($Data['Data']);
        include template('ChoiceFind');
    }

}