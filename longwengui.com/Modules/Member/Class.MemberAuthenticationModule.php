<?php
/**
 * @desc  验证码表
 * Class  MemberAuthenticationModule
 */
Class MemberAuthenticationModule extends CommonModule {

    public $KeyID = 'ID';
    public $TableName = 'member_authentication';

    /**
     * @desc  查询帐号
     * @param $Account
     * @return bool
     */
    public function searchAccount($Account)
    {
        global $DB;
        $sql = 'select ' . $this->KeyID . ' from ' . $this->TableName . ' where Account=\'' . $Account . '\'';
        $result = $DB->GetOne($sql);
        if ($result) {
            return $result[$this->KeyID];
        } else {
            return false;
        }
    }

    /**
     * @desc  账号验证
     * @param $Account
     * @param $VerifyCode
     * @param int $Type
     * @return bool
     */
    public function ValidateAccount($Account, $VerifyCode, $Type = 0)
    {
        global $DB;
        $sql = 'select ' . $this->KeyID . ' from ' . $this->TableName . ' where Account=\'' . $Account . '\' and VerifyCode=' . $VerifyCode . ' and Type=' . $Type;
        $result = $DB->GetOne($sql);
        if ($result) {
            return $result[$this->KeyID];
        } else {
            return false;
        }
    }
    /**
     * @desc  验证信息
     * @param $Account
     * @param $VerifyCode
     * @param int $Type
     * @return array
     */
    public function GetAccountInfo($Account, $VerifyCode, $Type = 0)
    {
        global $DB;
        $sql = 'select * from ' . $this->TableName . ' where Account=\'' . $Account . '\' and VerifyCode=' . $VerifyCode . ' and Type=' . $Type;
        return $DB->GetOne($sql);
    }
    /**
     * @desc  添加数据
     * @param $Data
     * @return int
     */
    public function InsertUser($Data)
    {
        global $DB;
        return $DB->insertArray($this->TableName, $Data);
    }

    /**
     * @desc  更新数据
     * @param $Data
     * @param $ID
     * @return bool|int
     */
    public function UpdateUser($Data, $ID)
    {
        global $DB;
        return $DB->UpdateWhere($this->TableName, $Data, '`' . $this->KeyID . '`=' . $ID);
    }
}
