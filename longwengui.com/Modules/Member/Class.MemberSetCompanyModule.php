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
    public function GetTeamInfoByWhere($MysqlWhere = '',$Money=''){
        global $DB;
        $sql = "select  me.*,b.mobile,c.* from (SELECT SetID,min(MoneyScale) from member_set_company GROUP BY UserID) a
left JOIN member_set_company me ON me.SetID = a.SetID 
left JOIN member_user b ON me.UserID = b.UserID 
left JOIN member_user_info c ON me.UserID = c.UserID where me.Province IN ($MysqlWhere) and c.IdentityState=3 and c.Identity=3 and   me.FromMoney <= $Money and me.ToMoney >= $Money order by me.MoneyScale asc";
        return $DB->select($sql);
    }
}