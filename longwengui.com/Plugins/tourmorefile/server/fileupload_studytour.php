<?php
session_start();
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

#!! 注意
#!! 此文件只是个示例，不要用于真正的产品之中。
#!! 不保证代码安全性。

#!! IMPORTANT:
#!! this file is just an example, it doesn't incorporate any security checks and
#!! is not recommended to be used in production environment as it is. Be sure to
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (PHP_VERSION > '5.1') {
    date_default_timezone_set ( 'Asia/Shanghai' );
}

// Support CORS
// header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}


if ( !empty($_REQUEST[ 'debug' ]) ) {
    $random = rand(0, intval($_REQUEST[ 'debug' ]) );
    if ( $random === 0 ) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}

// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
//$targetDir = 'upload_tmp';
$uploadDir = '/up/'.date('Y').'/'.date('md');
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
//if (!file_exists($targetDir)) {
//    @mkdir($targetDir);
//}

// Create target dir
//if (!file_exists($uploadDir)) {
//    @mkdir($uploadDir);
//}

// Get a file name
if (isset($_REQUEST["name"])) {
    $fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
    $fileName = $_FILES["file"]["name"];
} else {
    $fileName = uniqid("file_");
}

$pics = preg_replace('/.*\.(.*[^\.].*)*/iU','\\1',$fileName);
$fileName = iconv('UTF-8', 'GB2312', $fileName);//转编码
$fileName = date('YmdHis').mt_rand(1000,9999).'.'.$pics;//重新命名图片名称
//定义图片路径
$filePath = $uploadPath ='http://images.57us.com/l'.$uploadDir.'/'.$fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;

if (!empty($_FILES)) {
    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }

    // Read binary input stream and append it to temp file
    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
} else {
    if (!$in = @fopen("php://input", "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
}

while ($buff = fread($in, 4096)) {
    $imgStr.=$buff;
}

//@fclose($out);
@fclose($in);

//上传图片服务器
include '../../../Include/Class.Common.php';;
if(SendToImgServ($uploadDir.'/'.$fileName,base64_encode($imgStr))!='true'){
    die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to upload file."}, "id" : "id"}');
}

// var_dump($uploadPath);
// Return Success JSON-RPC response
//添加图片
//$uploadPath
//初始化数据库连接类
include '../../../Include/Class.Databasedriver.Mysql.php';
include  '../../../Config.php';
$DB = new DatabaseDriver_MySql ( $NewsDbConfig );
$InsertPicInf['Image'] = $uploadDir.'/'.$fileName;
$InsertPicInf['YoosureID'] = $_SESSION['YoosureID'];
$DB-> insertArray('study_yoosure_image', $InsertPicInf);


die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');