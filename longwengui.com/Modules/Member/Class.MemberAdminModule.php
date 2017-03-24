<?php
/**
 * @desc 管理员信息表
 * Class MemberAdminModule
 */
Class MemberAdminModule extends CommonModule {
    public function __construct() {
        $this->TableName = 'member_admin';
        $this->KeyID = 'AdminID';
    }
    /**
     * 登录验证
     * 成功返回 数组
     * @param string Account
     * @param string PassWord
     * @return boolean
     */
    public function CheckUser($Account,$PassWord){
        global $DB;
        $Sql = 'SELECT * FROM ' . $this->TableName . ' where AdminName=\''.$Account.'\' and PassWord=\''.$PassWord.'\'';
        $result=$DB->GetOne($Sql);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}
