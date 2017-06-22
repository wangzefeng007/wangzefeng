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
        $Title ='债务催收处置平台-文贵网';
        $Keywords=" 追讨债务，怎样追讨债务，个人债务追讨，催收跟踪，催收管理，信用卡催收，话费催收，水电费催收，物业费催收";
        $Description="文贵网是福建首家安全、诚信、免费的催收服务平台，平台旨在拓宽债权人追回欠款的渠道，运用互联网、大数据构建不良资产服务平台。文贵网致力于打造诚信社会，让债权人无忧追债，催客事成领赏；我们建立全国催客大本营，实现精准便捷的催收服务，让全民参与构建社会诚信，促进社会诚信的发展。";
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