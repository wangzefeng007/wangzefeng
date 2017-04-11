<?php
/**
 * @desc 律师佣金设置表
 * Class MemberSetLawyerFeeModule
 */
class MemberSetLawyerFeeModule extends CommonModule{
    public $KeyID = 'SetID';
    public $TableName = 'member_set_lawyerfee';

    /**
     * @desc  寻找处置方获取委托方数据
     */
    public function GetTeamInfoByWhere($MysqlWhere = ''){
        global $DB;
        $sql = "select  me.*,b.mobile,c.* from member_set_lawyerfee me
left JOIN (SELECT SetID,min(Money) from member_set_lawyerfee GROUP BY UserID) a ON me.SetID = a.SetID left JOIN (SELECT UserID,Mobile from member_user) b ON me.UserID = b.UserID left JOIN (SELECT UserID,CompanyName,Province,City,Area from member_user_info) c ON me.UserID = c.UserID
where me.Province IN ($MysqlWhere) order by me.Money asc";
        return $DB->select($sql);
    }
}