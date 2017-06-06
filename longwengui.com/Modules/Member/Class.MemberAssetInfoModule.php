<?php
/**
 * @desc  资产转让基础信息表
 * Class  MemberAssetInfoModule
 */
class MemberAssetInfoModule extends CommonModule
{
    public $KeyID = 'AssetID';
    public $TableName = 'member_asset_info';
    /**
     * @desc 前台订单状态
     * @var array
     */
    public $NStatus = [
        '1' => '待审核',
        '2' => '审核通过',
        '3' => '审核失败',
        '4' => '过期自动关闭',
    ];
    /**
     * @desc 产品上架状态
     * @var array
     */
    public $ProductStatus = [
        '0' => '下架',
        '1' => '上架',
    ];
    //库存减少
    public function SetInventory($AssetID,$Num){
        if($AssetID=='' || !is_numeric($AssetID)){
            return false;
        }
        global $DB;
        return $DB->update("update ".$this->TableName." set Inventory=Inventory-$Num where AssetID=$AssetID");
    }
}