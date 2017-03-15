<?php
/**
 * @desc  地区管理
 */
class Area
{
    public function __construct() {
        IsLogin();
    }
    /**
     * @desc  添加或更新地区信息
     */
    public function AreaAdd()
    {
        $MemberAreaModule = new MemberAreaModule();
        $AreaID = intval($_GET['AreaID']);
        $AreaDetails = $MemberAreaModule->GetInfoByKeyID($AreaID);
        $AreaLists = $MemberAreaModule->GetInfoByWhere(' and `ParentID` = 0',true);
        foreach ($AreaLists as $key => $value) {
            $AreaAddprovince = $MemberAreaModule->GetInfoByWhere(' and `ParentID` = '.$value['AreaID'],true);
            $AreaLists[$key]['Province'] = $AreaAddprovince;
            if ($AreaAddprovince) {
                foreach ($AreaAddprovince as $k => $v) {
                    $AreaAddCity = $MemberAreaModule->GetInfoByWhere(' and `ParentID` = '.$v['AreaID'],true);
                    $AreaLists[$key]['Province'][$k]['City'] = $AreaAddCity;
                }
            }
        }
        if ($AreaDetails['ParentID'] > 0)
            $TourParent = $MemberAreaModule->GetInfoByKeyID($AreaDetails['ParentID']);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!$_POST['CnName']) {
                alertandgotopage("必填选项不能为空", '/index.php?Module=Area&Action=AreaAdd');
            }
        }
        if ($_POST) {
            $AreaID = intval($_POST['AreaID']);
            $Data['ParentID'] = $_POST['ParentID'];
            $Data['CnName'] = trim($_POST['CnName']);
            $Data['Level'] = $_POST['Level'];
            if ($AreaID > 0) {
                $AreaUpdate = $MemberAreaModule->UpdateInfoByKeyID($Data, $AreaID);
            } else {
                $AreaID = $MemberAreaModule->InsertInfo($Data);
            }
            if ($AreaID == true || $AreaUpdate == true) {
                alertandgotopage("操作成功", '/index.php?Module=Area&Action=AreaAdd&AreaID=' . $AreaID);
            } else {
                alertandgotopage("操作失败", '/index.php?Module=Area&Action=AreaAdd&AreaID=' . $AreaID);
            }
        }
        include template('AreaAdd');
    }

    /**
     * @desc  地区列表信息
     */
    public function AreaLists()
    {
        $MemberAreaModule = new MemberAreaModule();
        $AreaLists = $MemberAreaModule->GetInfoByWhere(' and `ParentID` = 0',true);
        if ($AreaLists) {
            foreach ($AreaLists as $key => $value) {
                $AreaAddprovince = $MemberAreaModule->GetInfoByWhere(' and `ParentID` = '.$value['AreaID'],true);
                $AreaLists[$key]['Province'] = $AreaAddprovince;
            }
        }
        $Get = $_GET;
        $SqlWhere = '';
        if ($Get['PName'] != '') {
            $SqlWhere .= ' and concat(CnName) like \'%' . $Get['PName'] . '%\'';
            $AreaLists = $MemberAreaModule->GetInfoByWhere($SqlWhere,true);
        }
        $PName = $Get['PName'];
        include template('AreaLists');
    }
}