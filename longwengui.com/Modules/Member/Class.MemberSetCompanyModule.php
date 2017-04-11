<?php

/**
 * @desc 催收公司佣金设置表
 * Class MemberSetCompanyModule
 */
class MemberSetCompanyModule extends CommonModule{
    public $KeyID = 'SetID';
    public $TableName = 'member_set_company';

    /**
     * @desc  寻找处置方获取委托方数据
     */
    public function GetTeamInfoByWhere($MysqlWhere = ''){
        global $DB;
        $sql = "select  me.*,b.mobile,c.* from member_set_company me
left JOIN (SELECT SetID,min(MoneyScale) from member_set_company GROUP BY UserID) a ON me.SetID = a.SetID left JOIN (SELECT UserID,Mobile from member_user) b ON me.UserID = b.UserID left JOIN (SELECT UserID,CompanyName,Province,City,Area from member_user_info) c ON me.UserID = c.UserID
where me.Province IN ($MysqlWhere) order by me.MoneyScale asc";
        return $DB->select($sql);
    }
}