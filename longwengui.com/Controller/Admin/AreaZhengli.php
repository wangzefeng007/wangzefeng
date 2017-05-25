<?php

/**
 * 数据整理
 */
class AreaZhengli
{

    public function __construct()
    {
        set_time_limit(0);
    }
    public function Area(){
        global $DB;
        $provinces = $DB->select('SELECT * FROM provinces WHERE 1=1');
        $cities = $DB->select('SELECT * FROM cities WHERE 1=1');
        $areas = $DB->select('SELECT * FROM areas WHERE 1=1');
//        foreach ($provinces as $key=>$value){
//            $areaprovince = $DB->select('SELECT * FROM member_area WHERE CnName = \''.$value['province'].'\'');
//            if (!$areaprovince){
//                $province = '\''.$value['province'].'\''.',0'.',1';
//                $DB->select("INSERT INTO member_area (CnName, ParentID,Level) VALUES ($province)");
//            }
//        }
//        foreach ($cities as $key=>$value){
//            $ProvinceInfo = $DB->select('SELECT province FROM provinces WHERE provinceid='.$value['provinceid']);
//            $AreaprovinceInfo = $DB->select('SELECT * FROM member_area WHERE CnName = \''.$ProvinceInfo[0]['province'].'\'');
//            $Areacity = $DB->select('SELECT * FROM member_area WHERE ParentID = '.$AreaprovinceInfo[0]['AreaID'].' and CnName = \''.$value['city'].'\'');
//            if (!$Areacity){
//                $city = '\''.$value['city'].'\''.','.$AreaprovinceInfo[0]['AreaID'].',2';
//                $DB->select("INSERT INTO member_area (CnName, ParentID,Level) VALUES ($city)");
//            }
//        }
        foreach ($areas as $key=>$value){
            $cityInfo = $DB->select('SELECT * FROM cities WHERE cityid='.$value['cityid']);
            $ProvinceInfo = $DB->select('SELECT * FROM provinces WHERE provinceid='.$cityInfo[0]['provinceid']);
            $province = $DB->select('SELECT * FROM member_area WHERE CnName = \''.$ProvinceInfo['0']['province'].'\'');
            $Areacity = $DB->select('SELECT * FROM member_area WHERE ParentID = '.$province[0]['AreaID'].' and CnName = \''.$cityInfo[0]['city'].'\'');
            $areanum = $DB->select('SELECT * FROM member_area WHERE ParentID = '.$Areacity[0]['AreaID'].' and CnName = \''.$value['area'].'\'');
            if (!$areanum){
                $citys = '\''.$value['area'].'\''.','.$Areacity[0]['AreaID'].',3';
                $DB->select("INSERT INTO member_area (CnName, ParentID,Level) VALUES ($citys)");
            }
        }
        var_dump($cities);exit;
    }
    public function AreaProvince(){
        $MemberAreaModule = new MemberAreaModule();
        $province = $MemberAreaModule->GetInfoByWhere(' and Level=1',true);
        foreach ($province as $Key=>$Value)
        {
            $provinceJson[$Value['AreaID']] = $Value['CnName'];
        }
        $provinceJsonString = json_encode($provinceJson,JSON_UNESCAPED_UNICODE);
        file_put_contents(SYSTEM_ROOTPATH.'/Templates/Debt/data/ProvincePHP.json',$provinceJsonString);
    }
    public function AreaCity(){
        $MemberAreaModule = new MemberAreaModule();
        $city = $MemberAreaModule->GetInfoByWhere(' and Level=2',true);
        foreach ($city as $Key=>$Value)
        {
            $cityJson[$Value['AreaID']] = $Value['CnName'];
        }
        $cityJsonString = json_encode($cityJson,JSON_UNESCAPED_UNICODE);
        file_put_contents(SYSTEM_ROOTPATH.'/Templates/Debt/data/CityPHP.json',$cityJsonString);
    }
    public function Areas(){
        $MemberAreaModule = new MemberAreaModule();
        $city = $MemberAreaModule->GetInfoByWhere(' and Level=3',true);
        foreach ($city as $Key=>$Value)
        {
            $cityJson[$Value['AreaID']] = $Value['CnName'];
        }
        $cityJsonString = json_encode($cityJson,JSON_UNESCAPED_UNICODE);
        file_put_contents(SYSTEM_ROOTPATH.'/Templates/Debt/data/AreaPHP.json',$cityJsonString);
    }
    public function Direction(){
        $MemberLawyerDirectionModule = new MemberLawyerDirectionModule();
        $Direction = $MemberLawyerDirectionModule->GetInfoByWhere('',true);
        foreach ($Direction as $Key=>$Value)
        {
            $DirectionJson[$Key]['GoodID'] = $Value['GoodID'];
            $DirectionJson[$Key]['GoodName'] = $Value['GoodName'];
        }
        $DirectionJsonString = json_encode($DirectionJson,JSON_UNESCAPED_UNICODE);
        file_put_contents(SYSTEM_ROOTPATH.'/Templates/Debt/data/Direction.json',$DirectionJsonString);
    }


}