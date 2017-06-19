<?php
if ($_GET['A'] == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
}
define('SYSTEM_ROOTPATH', dirname(__FILE__));
header('Content-Type: text/html; charset=utf-8');
if (PHP_VERSION > '5.1') {
    date_default_timezone_set('Asia/Shanghai');
}
// 获取域名
$SERVER_NAME = $_SERVER['SERVER_NAME'];

$KeyWord = trim($_POST['keyword']);
$Type = trim($_POST['t']);
if ($_POST) {
    if ($SERVER_NAME == 'www.57us.net' || $SERVER_NAME == '57us.net') {
        if ($KeyWord == '') {
            $Url = '/';
        } elseif ($KeyWord == '赴美留学') {
            $Url = '/search_study_' . $KeyWord . '.html';
        } else {
            $Url = '/search_' . $Type . '_' . $KeyWord . '.html';
        }
    }elseif ($SERVER_NAME == 'tour.57us.net'){

        if($_SERVER['HTTP_REFERER'] == 'http://zuche.57us.net/'){
            $Url = 'http://www.57us.net/search_tour_'.$KeyWord.'.html';
            header('HTTP/1.1 301 Moved Permanently');
            header('Location:' . $Url);
            exit();
        }

         if ($Type == 'search') {
             $Url = '/tour/'.$Type. '/?K='.$KeyWord;
         }elseif ($Type == 'home' || $Type == 'local') {
            $Url = '/group/' . $Type . '/?K='.$KeyWord;
        }elseif($Type == 'ask'){
            $Url='/ask/search/?K='.$KeyWord;
        }else {
            $Url = '/play/' . $Type . '/?K='.$KeyWord;
        }
    }elseif ($SERVER_NAME == 'hotel.57us.net'){
        $Url = '/hotel/hotelsearchlist/?K='.$KeyWord;
    }elseif ($SERVER_NAME == 'visa.57us.net'){
        $Url = '/visa/lists/?K='.$KeyWord;
    }elseif($SERVER_NAME == 'study.57us.net'){
        if($Type == 'index'){
            $Url='/study/search/';
        }elseif($Type == 'highschool'){
            $Url='/highschool/';
        }elseif($Type == 'college'){
            $Url='/college/';
        }elseif($Type == 'graduateschool'){
            $Url='/graduateschool/';
        }elseif($Type == 'consultant'){
            $Url='/consultant/';
        }elseif($Type == 'teacher'){
            $Url='/teacher/';
        }elseif($Type == 'service'){
            $Url='/consultant_service/';
        }elseif($Type == 'course'){
            $Url='/teacher_course/';
        }elseif($Type =='ask'){
            $Url='/ask/search/';
        }elseif($Type =='studytour'){
            $Url='/studytour/';
        }else{
            $Url='/consultant_service/';
        }
        $Url.='?K='.$KeyWord;
    }elseif ($SERVER_NAME == 'm.57us.net') {
        if ($KeyWord == '') {
            $Url = '/';
        } elseif ($Type == 'home' || $Type == 'local') {
            $Url = '/group/' . $Type . '/?K=' . $KeyWord;
        } elseif ($Type == 'feature' || $Type == 'daily' || $Type == 'ticket') {
            $Url = '/play/' . $Type . '/?K=' . $KeyWord;
        } else {
            $Url = '/news/search_' . $Type . '_' . $KeyWord . '.html';
        }
    }
    header('HTTP/1.1 301 Moved Permanently');
    header('Location:' . $Url);
    exit();
}