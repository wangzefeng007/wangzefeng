<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/2
 * Time: 9:41
 */
class M
{
    public function __construct(){

    }
    /**
     * 首页
     */
    public function Index(){
        $Nav ='index';
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $Data['Data'] = $MemberAssetInfoModule->GetLists(' and `Status` = 2  and `S1` =1', 0,3);
        foreach ($Data['Data'] as $key=>$value){
            $Data['Data'][$key]['Number'] = intval($value['Amount'])-intval($value['Inventory']);//已买量
            $AssetImage = $MemberAssetImageModule->GetInfoByWhere(" and AssetID = ".$value['AssetID'].' and IsDefault = 1');
            $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
            $Data['Data'][$key]['AddTime'] = date("Y-m-d",$value['AddTime']);
        }
        include template('Index');
    }


}