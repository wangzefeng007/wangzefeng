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
    public function Index(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        include template('AssetIndex');
        echo 'asset';exit;
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        include template('AssetPublish');
    }
    /**
     * @desc  发布资产转让成功待审核页面
     */
    public function Audit(){
        include template('AssetAudit');
    }
    /**
     * @desc  资产转让详情页
     */
    public function Details(){
        $ID = $_GET['ID'];
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        if ($AssetInfo['Status']!=2){
            alertandback("该资产未审核通过！");
        }
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$AssetInfo['AssetID'],true);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $MemberUser = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
        $UserInfo['Mobile'] =$MemberUser['Mobile'];
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and `Status` > 1 and ProductID = '.$AssetInfo['AssetID'],true);
        $TotalAmount =0;
        foreach ($OrderInfo as $value){
            $TotalAmount =$TotalAmount+ $value['TotalAmount'];
        }
        include template('AssetDetails');
    }
    /**
     * @desc  订单填写页
     */
    public function  Order(){
        if ($_SESSION ['Identity']!=1 && $_SESSION['Identity']!=2){
            alertandback("个人会员和催客方可购买商品！");
        }
        include template('AssetOrder');
    }
    /**
     * 选择支付页
     */
    public function ChoicePay()
    {

    }
    /**
     * 准备支付
     */
    public function Pay()
    {
    }
}