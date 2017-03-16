<?php

/**
 * @param 悬赏信息管理
 */
class Reward
{
    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc  发布悬赏信息
     */
    public function Publish()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $MemberAreaModule = new MemberAreaModule();
        $ProvinceLists = $MemberAreaModule->GetInfoByWhere(' and `ParentID` = 0', true);
        $code = 'XS';
        
        if ($_POST) {
            $Data['CreditorsPhone'] = trim($_POST['CreditorsPhone']);
            $Data['DebtName'] = trim($_POST['DebtName']);
            $Data['DebtCard'] = trim($_POST['DebtCard']);
            $Data['DebtPhone'] = trim($_POST['DebtPhone']);
            $Data['Address'] = trim($_POST['Address']);
            $Data['Type'] = intval($_POST['Type']);
            $Data['AddTime'] = time();
            $Data['RewardNum'] = $code . time();

//            if ($_POST['CreditorsPhone'] == '' || $_POST['DebtName'] == '' || $_POST['DebtPhone'] == '' || $_POST['DebtPhone'] == '' || $_POST['Address'] == '') {
//                alertandback('信息填写不完整');
//            }
            // 上传图片
            include SYSTEM_ROOTPATH . '/Include/fileupload.class.php';
            $up = new fileupload;
      
            //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
            $SavePath = 'Uploads/Reword/'.date('Ymd').'/';
            $up->set("path",$SavePath);
            $up->set("maxsize", 2000000);
            $up->set("allowtype", array("gif", "png", "jpg", "jpeg"));
            $up->set("israndname", true);
//            http://www.jb51.net/article/57510.htm
            //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false
            if ($up->upload("image")) {
                $ImageInfo['ImageUrl'] = $SavePath;
                $ImageInfo['IsDefault'] = 1;
                $ImageInfo['RewardID'] = 1;
            } else {
                echo '<pre>';
                //获取上传失败以后的错误提示
                var_dump($up->getErrorMsg());
                echo '</pre>';
            }
        
            $result = $MemberRewardInfoModule->InsertInfo($Data);
            $uploadImage = $MemberRewardImageModule->InsertInfo($ImageInfo);
            if ($result && $uploadImage) {
                alertandgotopage("操作成功", '/index.php?Module=Reward&Action=RewardLists');
 
            } else {
                alertandgotopage("操作失败", '/index.php?Module=Reward&Action=RewardLists');
            }
        }
        include template('RewardPublish');
    }

    /**
     * @desc  悬赏信息列表
     */
    public function RewardLists()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $StatusInfo = $MemberRewardInfoModule->NStatus;
        $SqlWhere = '';
        // 搜索条件
        $PageUrl = '';
        $keyword = trim($_GET['keyword']);
        if ($keyword != '') {
            $SqlWhere .= ' and (RewardNum=\'' . $keyword . '\' or concat(DebtName) like \'%' . $keyword . '%\')';
            $PageUrl .= '&keyword=' . $keyword;
        }
        if ($_GET ['Status']) {
            $Status = trim($_GET ['Status']);
            $SqlWhere .=' and `Status` = \'' . $Status . '\'';
            $PageUrl .='&Status=' . $Status;
        }
        // 跳转到该页面
        if ($_POST['page']) {
            $page = $_POST['page'];
            tourl('/index.php?Module=Reward&Action=RewardLists&Page=' . $page . $PageUrl);
        }
        // 分页开始
        $Page = intval($_GET['Page']);
        $Page = $Page ? $Page : 1;
        $PageSize = 10;
        $Rscount = $MemberRewardInfoModule->GetListsNum($SqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];

            if ($Page > $Data['PageCount']) {
                $page = $Data['PageCount'];
            }
            $Data['Data'] = $MemberRewardInfoModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data']as $key => $value) {
                $Data['Data'][$key]['AddTime'] = !empty($value['AddTime']) ? date('Y-m-d H:i:s', $value['AddTime']) : '';
            }
            MultiPage($Data, $Data['PageCount']);
        }
        include template('RewardLists');
    }
     /**
     * @desc  悬赏信息详情与审核
     */
    public function RewardDetail()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        if ($_POST['ID']) {
            $Data['Status'] = intval($_POST['Status']);
            $ID = intval($_POST['ID']);
            $result = $MemberRewardInfoModule->UpdateInfoByWhere($Data, ' ID= ' . $ID);
            if ($result) {
                alertandgotopage('操作成功!', '/index.php?Module=Reward&Action=RewardDetail&ID=' . $ID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        if ($_GET['ID']) {
            $ID = $_GET['ID'];
            $UserInfo = $MemberRewardInfoModule->GetInfoByKeyID($ID);
            $UserInfo['AddTime'] = !empty($UserInfo['AddTime']) ? date('Y-m-d H:i:s', $UserInfo['AddTime']) : '';
        }
        include template('RewardDetail');
    }

    /**
     * @desc  悬赏信息删除
     */
    public function Delete()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $ID = $_GET['ID'];
        $result = $MemberRewardInfoModule->DeleteByKeyID($ID);
        if (!$result) {
            alertandgotopage("删除失败", '/index.php?Module=Reward&Action=RewardLists');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=Reward&Action=RewardLists');
        }
    }

}