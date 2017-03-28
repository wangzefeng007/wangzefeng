<?php

/**
 * @desc 用户资料表
 * Class MemberAdminModule
 * @return array|int
 */
Class MemberUserInfoModule extends CommonModule  {

    public $KeyID = 'InfoID';
    public $TableName = 'member_user_info';

    /**
     * @desc 用户状态
     * @var array
     */
    public $IdentityStatus = array(
        '1' => '未提交审核',
        '2' => '审核中',
        '3' => '审核通过',
        '4' => '审核不通过',
    );
    /**
     * @desc 用户身份
     * @var array
     */
    public $Identity = array(
        '0' => '注册用户',
        '1' => '个人用户',
        '2' => '催客',
        '3' => '公司会员',
        '4' => '律师企业会员',
    );
   /**
	 * @desc  根据keyID查询单条数据详情
	 * @param string $KeyID
	 * @return array|int
	 */
    public function GetInfoByUserID($UserID = '') {

        global $DB;
        if ($UserID == '')
            return 0;
        $sql = 'select * from ' . $this->TableName . ' where  UserID = ' . $UserID;
        return $DB->getone ( $sql );
    }

}
