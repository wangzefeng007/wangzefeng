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