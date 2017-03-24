<?php
/**
 *@desc  资产转让管理
 */
class AssetTransfer
{

    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc  添加或更新资产转让
     */
    public function Add()
    {
        alertandback('待开发');exit;
        include template('AssetTransferAdd');
    }

    /**
     * @desc  资产转让列表
     */
    public function AssetTransferLists()
    {
        alertandback('待开发');exit;
        include template('AssetTransferLists');
    }

    /**
     * @desc  删除资产转让
     */
    public function Delete()
    {
        $TourAreaModule = new TourAreaModule();
        $AreaID = $_GET['AreaID'];
        $TourAreaModules = $TourAreaModule->DeleteByKeyID($AreaID);
        if (!$TourAreaModules) {
            alertandgotopage("删除失败", '/index.php?Module=TourArea&Action=TourAreaList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=TourArea&Action=TourAreaList');
        }
    }
}