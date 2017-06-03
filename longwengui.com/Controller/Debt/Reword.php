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
        $MysqlWhere ='';
        $AreaList = $MemberAreaModule->GetInfoByWhere(' and R1 =1 order by S1 asc',true);
        $MyUrl = WEB_MAIN_URL.'/reword/';
        $SoUrl = $_GET['SoUrl'];
        if (strstr ( $SoUrl, 'a1' )){
            $Type = 'a1';
            $MysqlWhere .= ' and Type =1 ';
        }elseif (strstr ( $SoUrl, 'a2' )){
            $Type = 'a2';
            $MysqlWhere .= ' and Type =2 ';
        }elseif (strstr ( $SoUrl, 'a3' )){
            $Type = 'a3';
            $MysqlWhere .= ' and Type =3 ';
        }
        $Keyword = trim($_GET['K']);
        if ($Keyword !=''){
            $MysqlWhere .= ' and  Message like \'%'.$Keyword.'%\'';
        }
        //分页查询开始-------------------------------------------------
        $Rscount = $MemberRewardInfoModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
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
        include template('RewordLists');
    }
    /**
     * @desc  发布悬赏
     */
    public function Publish(){
        $Title="发布悬赏-隆文贵债务处置";
        $Nav = 'rewordlists';
    include template('RewordPublish');
    }
}