<?php
header('Content-Type: text/html; charset=utf-8');
if (PHP_VERSION > '5.1') {
    date_default_timezone_set('Asia/Shanghai');
}

ini_set('display_errors', '0');
if ($_GET['A'] == 1) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

// -----------------------   常量定义    -------------------------------------//
define('SYSTEM_ROOTPATH', dirname(__FILE__));
//网站一级域名
define('WEB_HOST_URL', 'longwengui.net');
//网站主域名
define('WEB_MAIN_URL', 'http://www.longwengui.net');
//网站后台管理
define('WEB_ADMIN_URL', 'http://admin.longwengui.net');
//公共路径
define('WEB_COMMON_URL', 'http://www.longwengui.net/Common');

//JS、Css、Image
define('JsURL', 'http://js.longwengui.net');
define('CssURL', 'http://css.longwengui.net');

//图片服务器
define('ImageURLP2', 'http://images.57us.com/p2');
define('ImageURLP4', 'http://images.57us.com/p4');
define('ImageURLP6', 'http://images.57us.com/p6');
define('ImageURLP8', 'http://images.57us.com/p8');
define('LImageURL', 'http://images.57us.com/l');

// --------------------------- 公共文件引入 ----------------------------------//
include dirname(__FILE__) . '/Include/UserSession.php';     //加载session文件
include SYSTEM_ROOTPATH . '/Include/Global.Functions.php';
include SYSTEM_ROOTPATH . '/Include/Class.Databasedriver.Mysql.php';
include SYSTEM_ROOTPATH . '/Include/Class.Common.php';
include SYSTEM_ROOTPATH . '/Config.php';
include SYSTEM_ROOTPATH . '/Include/Class.Paging.php';
include SYSTEM_ROOTPATH . '/Include/Functions.Spider.php';
include SYSTEM_ROOTPATH . '/Include/Class.301.php';
include SYSTEM_ROOTPATH . '/Include/Class.WebCommon.php';

//------------------------- 自动加载Modules,Service类库 --------------------------//
spl_autoload_register(function($ClassName){
    if(!function_exists('ClassAutoLoad')){
        function ClassAutoLoad($RootDir,$ClassName){
            $DirList=dir($RootDir);
            while($DirName=$DirList->read()){
                if($DirName!='.' && $DirName!='..' && is_dir($RootDir.$DirName)){
                    if(file_exists($RootDir.$DirName.'/Class.'.$ClassName.'.php')){
                            include_once($RootDir.$DirName.'/Class.'.$ClassName.'.php');
                            return true;
                    }else{
                            ClassAutoLoad($RootDir.$DirName.'/',$ClassName);
                    }
                }
            }			
        }
    }
    $DirArr=array('Modules','Service');
    foreach($DirArr as $DVal){
        if(ClassAutoLoad(SYSTEM_ROOTPATH.'/'.$DVal.'/',$ClassName)){
            break;
        }
    }
});

// ------------------------  链接数据库  ------------------------------//
//初始化数据库连接类
$DB = new DatabaseDriver_MySql ($NewsDbConfig);

// ------------------------ 模块  ----------------------------//
if ($_GET)
    $_GET = nl_addslashes($_GET);
if ($_POST)
    $_POST = nl_addslashes($_POST);

$DoMain = $_SERVER ["HTTP_HOST"];//域名
define('WEB_HOME_URL', 'http://' . $DoMain);
$DoMainList = array(
    'admin.longwengui.net' => 'Admin', //后台
    'www.longwengui.net' => 'Debt', //前台

);
$_SESSION['AdminID']=15;
$_SESSION['UserID']=30;
$Group = $DoMainList[$DoMain];
if ($Group == 'Member') {
    include SYSTEM_ROOTPATH . '/Include/Class.Log.php';
    if ($_COOKIE['UserID'] != '' && $_COOKIE['Account'] != '') {
        $_SESSION['UserID'] = $_COOKIE['UserID'];
        $_SESSION['Account'] = $_COOKIE['Account'];
        setcookie("session_id", session_id(), time() + 3600 * 24, "/", WEB_HOST_URL);
    } else {
        //同步SESSIONID
        if ($_SESSION['UserID'] != '') {
            setcookie("session_id", session_id(), time() + 3600 * 24, "/", WEB_HOST_URL);
        }
    }
}
if ($Group == 'Muser') {
    include SYSTEM_ROOTPATH . '/Include/Class.Log.php';
    if ($_COOKIE['UserID'] != '' && $_COOKIE['Account'] != '') {
        $_SESSION['UserID'] = $_COOKIE['UserID'];
        $_SESSION['Account'] = $_COOKIE['Account'];
        setcookie("session_id", session_id(), time() + 3600 * 24, "/", WEB_HOST_URL);
    } else {
        //同步SESSIONID
        if ($_SESSION['UserID'] != '') {
            setcookie("session_id", session_id(), time() + 3600 * 24, "/", WEB_HOST_URL);
        }
    }
}
$Module = ucfirst($_GET ['Module'] ? $_GET ['Module'] : $Group);
$Action = ucfirst($_GET ['Action'] ? $_GET ['Action'] : 'Index');

include SYSTEM_ROOTPATH . '/Include/Template.Functions.php'; //模板加载文件
include SYSTEM_ROOTPATH . '/Route/' . $Group . '.php';             //加载路由文件

//获取真实模块跟方法start
$UrlString = $RouteArr[strtolower($Module) . '@' . strtolower($Action)];
if ($UrlString) {
    $UrlArray = explode('@', $UrlString);
    $Module = $UrlArray[0];
    $Action = $UrlArray[1];
}
unset($_GET['Action'], $_GET['Module']);
//获取真实模块跟方法end
$ControllerDir = SYSTEM_ROOTPATH . '/Controller/' . $Group . '/' . $Module . '.php';
include_once($ControllerDir);
$ControllerObj = new $Module();
$ControllerObj->$Action();
unset ($Module, $Action);


