<?php
/**
 * @desc 管理员账号表
 * Class MemberUserModule
 */
Class MemberUserModule extends CommonModule  {

    public $KeyID = 'UserID';
    public $TableName = 'member_user';

    /**
     * @desc  查询账号
     * @param $Account
     * @return array|bool
     */
    public function AccountExists($Account){
            global $DB;
            if(is_numeric($Account)){
                $Sql = 'SELECT '.$this->KeyID.' FROM ' . $this->TableName . ' where Mobile='.$Account;
            }elseif(strpos($Account,'@')){
                $Sql = 'SELECT '.$this->KeyID.' FROM ' . $this->TableName . ' where `E-Mail`=\''.$Account.'\'';
            }else{
                return false;
            }
            return $DB->GetOne($Sql);
    }

    /**
     * @desc  登录验证
     * @param $Account
     * @param $PassWord
     * @return bool
     */
    public function CheckUser($Account,$PassWord){
        global $DB;
        if(is_numeric($Account)){
            $Sql = 'SELECT '.$this->KeyID.' FROM ' . $this->TableName . ' where Mobile='.$Account.' and PassWord=\''.$PassWord.'\'';
        }elseif(strpos($Account,'@')){
            $Sql = 'SELECT '.$this->KeyID.' FROM ' . $this->TableName . ' where `E-Mail`=\''.$Account.'\' and PassWord=\''.$PassWord.'\'';
        }else{
            return false;
        }
        $result=$DB->GetOne($Sql);
        if($result){
            return $result[$this->KeyID];
        }else{
            return false;
        }
    }
}