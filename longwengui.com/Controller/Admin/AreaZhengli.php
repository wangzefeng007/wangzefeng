<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/3/15
 * Time: 12:02
 */
class AreaZhengli
{

    public function __construct()
    {
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
            $Areacity = $DB->select('SELECT * FROM member_area WHERE ParentID = '.$province[0]['AreaID'].' and CnName = \''.$cityInfo['city'].'\'');
            var_dump($province);
            var_dump($cityInfo,$ProvinceInfo,$Areacity);exit;

            if (!$Areacity){
                $city = '\''.$value['area'].'\''.','.$AreacityInfo[0]['AreaID'].',3';
                $DB->select("INSERT INTO member_area (CnName, ParentID,Level) VALUES ($city)");
            }
        }
        var_dump($cities);exit;
    }
}