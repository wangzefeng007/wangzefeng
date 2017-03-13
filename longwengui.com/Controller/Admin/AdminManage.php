<?php

/**
 * Class AdminManage
 * @desc  管理员
 */
class AdminManage
{
    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc  管理员列表
     */
    public function Lists()
    {
        $AdminModule = new MemberAdminModule();
        $Keywords = trim($_GET['Keywords']);
        //分页开始
        $Page = intval($_GET['Page']);
        $Page = $Page ? $Page : 1;
        $PageSize = 20;
        $MysqlWhere = " and AdminName like '%$Keywords%' and GroupID=1 order by AdminID asc";
        $Rscount = $AdminModule->GetListsNum($MysqlWhere);
        if ($Rscount ['Num']) {
            $Data = array();
            $Data ['RecordCount'] = $Rscount ['Num'];
            $Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
            $Data ['PageCount'] = ceil($Data ['RecordCount'] / $PageSize);
            $Data ['Page'] = min($Page, $Data ['PageCount']);
            $Offset = ($Page - 1) * $Data ['PageSize'];
            if ($Page > $Data ['PageCount'])
                $page = $Data ['PageCount'];
            $Data ['Data'] = $AdminModule->GetLists($MysqlWhere, $Offset, $Data ['PageSize']);
            MultiPage($Data, 10);
        }
        //分页结束
        include template('AdminManageLists');
    }

    /**
     * @desc 添加或编辑管理员
     */
    public function AddAdmin()
    {
        $AdminModule = new MemberAdminModule();
        if (empty($_POST)) {
            $AdminID = intval($_GET['ID']);
            if ($AdminID) {
                $AdminInfo = $AdminModule->GetInfoByWhere(" and AdminID=$AdminID and GroupID=1");
            }
            include template('AdminManageAddAdmin');
        } else {
            $Data['AdminName'] = trim($_POST['Name']);
            $AdminInfo = $AdminModule->GetInfoByWhere(" and AdminName='{$Data['AdminName']}'");
            $Pass = trim($_POST['Pass']);
            if ($Pass) {
                $Data['PassWord'] = md5($Pass);
            }
            if (isset($_POST['ID']) && $_POST['ID'] > 1) {
                if ($AdminInfo && $AdminInfo['AdminID'] != $_POST['ID']) {
                    alertandgotopage("账号已经存在", WEB_ADMIN_URL . '/index.php?Module=AdminManage&Action=Lists');
                    exit;
                } else {
                    $result = $AdminModule->UpdateInfoByKeyID($Data, $_POST['ID']);
                }
            } else {
                if ($AdminInfo) {
                    alertandgotopage("账号已经存在", WEB_ADMIN_URL . '/index.php?Module=AdminManage&Action=Lists');
                    exit;
                } else {
                    $Data['GroupID'] = 1;
                    $Data['LastLogin'] = date('Y-m-d H:i:s');
                    $result = $AdminModule->InsertInfo($Data);
                }
            }
            if ($result !== false) {
                alertandgotopage("保存成功", WEB_ADMIN_URL . '/index.php?Module=AdminManage&Action=Lists');
            } else {
                alertandgotopage("保存失败", WEB_ADMIN_URL . '/index.php?Module=AdminManage&Action=Lists');
            }
        }
    }

    /**
     * @desc 删除管理员
     */
    public function DelAdmin()
    {
        $AdminModule = new MemberAdminModule();
        $AdminID = intval($_GET['ID']);
        $result = $AdminModule->DeleteByWhere(" and AdminID=$AdminID and GroupID=1");
        if ($result) {
            alertandgotopage("删除成功", $_SERVER['HTTP_REFERER']);
        } else {
            alertandgotopage("删除失败", $_SERVER['HTTP_REFERER']);
        }
    }
    
    //修改密码
    public function EditPassWord(){
        if($_POST){
            $OldPass=md5(trim($_POST['OldPass']));
            $NewPass=md5(trim($_POST['NewPass']));
            $QNewPass=md5(trim($_POST['QNewPass']));
            $AdminModule = new MemberAdminModule();
            $AdminInfo=$AdminModule->GetInfoByWhere(" and AdminID={$_SESSION['AdminID']} and PassWord='$OldPass'");
            if($AdminInfo){
                if($NewPass==$QNewPass){
                    $result=$AdminModule->UpdateInfoByKeyID(array('PassWord'=>$NewPass),$_SESSION['AdminID']);
                    if($result!==false){
                        alertandgotopage("修改成功", $_SERVER['HTTP_REFERER']);
                    }else{
                        alertandgotopage("修改失败,更新发生异常", $_SERVER['HTTP_REFERER']);
                    }
                }else{
                    alertandgotopage("修改失败,新密码与确认密码不一致", $_SERVER['HTTP_REFERER']);
                }
            }else{
                alertandgotopage("修改失败,原密码错误", $_SERVER['HTTP_REFERER']);
            }
        }
        include template("AdminManageEditPassWord");
    }
}
