<?php
/**
 * @desc  资产转让
 */
class Asset
{
    public function __construct() {

    }
    /**
     * @desc  资产转让列表
     */
    public function Lists(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $Title ='隆文贵债务处置-资产转让';
        $Nav='transfer';
        $S = intval($_GET['S']);
        $Keywords = trim($_GET['K']);
        if ($S ==1){
            $MysqlWhere = ' and `Status` = 2 and `S1` =1 ';
        }elseif($S ==2){
            $MysqlWhere = ' and `Status` = 2 and `S1` =2 ';
        }else{
            $MysqlWhere = ' and `Status` = 2 ';
        }
        if ($Keywords!=''){
            $MysqlWhere .= ' and Title like \'%' . $Keywords . '%\'';
        }
        //分页查询开始-------------------------------------------------
        $MysqlWhere .= ' order by AddTime desc';
        //关键字
        $Rscount = $MemberAssetInfoModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=9;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberAssetInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $AssetImage = $MemberAssetImageModule->GetInfoByWhere(" and AssetID = ".$value['AssetID'].' and IsDefault = 1');
                $UserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
                $Data['Data'][$key]['Avatar'] = $UserInfo['Avatar'];
                $Data['Data'][$key]['AddTime'] = date('m'.'月'.'d'.'日',$value['AddTime']);
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('AssetLists');
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        $Nav='transfer';
        $EndTime = time()+ 2592000;
        include template('AssetPublish');
    }
    /**
     * @desc  资产转让详情页
     */
    public function Details(){
        $Nav='transfer';
        $ID = $_GET['ID'];
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$AssetInfo['AssetID'],true);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        include template('AssetDetails');
    }
    /**
     * @desc  资产转让订单填写提交页
     */
    public function Order(){
        $Nav='transfer';
        $ID = $_GET['ID'];
        $Num = $_GET['Num'];
        include template('AssetOrder');
    }

}