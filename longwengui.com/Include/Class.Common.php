<?php
// -------------------------------- 主站公共调用 ----------------------------------------//



/**
 * 以表单方式发送
 * 
 * @param
 *            $Url
 * @param
 *            $Data
 * @return string
 */
function PostForm($Url, $Data)
{
    $sHtml = "<form id='postform' name='postform' action='$Url' method='post'>";
    foreach ($Data as $key => $val) {
        $sHtml .= "<input type='hidden' name='$key' value='$val' />";
    }
    $sHtml = $sHtml . "</form>";
    $sHtml = $sHtml . "<script>document.forms['postform'].submit();</script>";
    return $sHtml;
}

/**
 * CURL模拟浏览器请求
 * @param string $Url 采集地址
 * @param string $IP 模拟IP 值为random为随机
 * @param string $FromUrl 设置来源地址
 * @param string $Browser 浏览器编码 default为默认 空为不设置
 * @param string $WaitTime 连接前等待时间
 * @param string $OutTime 连接执行时间
 */
function CurlGetHtml($Url,$Browser='',$IP='',$FromUrl='',$WaitTime='',$OutTime=''){
    $queryServer = curl_init();
    if($IP!=''){
        if($IP=='random'){
            $IP = rand(1,222).'.'.rand(1,222).'.'.rand(1,222).'.'.rand(1,222);
        }
        curl_setopt($queryServer, CURLOPT_HTTPHEADER, array(
            'X-FORWARDED-FOR:' . $IP,
            'CLIENT-IP:' . $IP
        )); // 构造IP
    }
    if($FromUrl!=''){
        curl_setopt($queryServer, CURLOPT_REFERER, $FromUrl);
    }
    curl_setopt($queryServer, CURLOPT_URL, $Url);
    curl_setopt($queryServer, CURLOPT_HEADER, 0);
    curl_setopt($queryServer, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($queryServer, CURLOPT_RETURNTRANSFER, true);
    if($Browser!=''){
        if($Browser=='default'){
           curl_setopt($queryServer, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36");    
        }else{
           curl_setopt($queryServer, CURLOPT_USERAGENT,$Browser);     
        }
    }
    if($WaitTime){
        curl_setopt($queryServer, CURLOPT_CONNECTTIMEOUT, $WaitTime);
    }
    if($OutTime){
        curl_setopt($queryServer, CURLOPT_TIMEOUT, $OutTime);
    }
    //防止重定向
    curl_setopt($queryServer, CURLOPT_FOLLOWLOCATION, 1);    
    //最大重定向次数
    curl_setopt($queryServer, CURLOPT_MAXREDIRS,2);   
    $Html = curl_exec($queryServer);
    return $Html;
}

/**
 * 模拟POST请求
 * 
 * @param string $url
 *            请求地址
 * @param string|array $get
 *            GET请求参数
 * @param string|array $post
 *            POST请求参数
 *            上传文件文件路径之前必须要加@，例如'img_1'=>'@C:\androids.gif'
 * @param string $postType
 *            post请求参数类型
 * @param string $timeOut
 *            执行超时时间
 * @return string
 */
function ToolRequest($url, $get = array(), $post = array(), $postType = 'array', $timeOut = 10)
{
    $get = (! empty($get) && is_array($get)) ? http_build_query($get) : $get;
    $post = (! empty($post) && is_array($post)) ? http_build_query($post) : $post;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . (! empty($get) ? "?" . $get : ''));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);
    if (! empty($post)) {
        $header = array();
        switch ($postType) {
            case 'json':
                $header = array(
                    'Content-Type: application/json; charset=utf-8',
                    'Content-Length: ' . strlen($post)
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                break;
            case 'none':
                $header = array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Content-Length: ' . strlen($post)
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                break;
            default:
                $header = array(
                    'Content-Type: multipart/form-data; charset=utf-8'
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                break;
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    $str = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($str === false) {
        return var_export(array(
            $error,
            'url' => urldecode($url . (! empty($get) ? "?" . $get : '')),
            'post' => urldecode($post)
        ), true);
    }
    return $str;
}

/**
 * 判断是否登录
 */
function IsLogin()
{
    if (intval($_SESSION['AdminID']) == 0) {
        header("Location:" . WEB_ADMIN_URL);
        exit();
    }
}

function GetMyUrl()
{
    // 域名后面的地址
    $SCRIPT_URL = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME'] . ($_SERVER['QUERY_STRING'] ? "?" . $_SERVER['QUERY_STRING'] : '');
    // 域名（主机名）
    $SCRIPT_HOST = $_SERVER["HTTP_HOST"];
    define('HTTP_HOST', 'http://' . $SCRIPT_HOST); // 定义根目录
                                                      // 页面地址
    $REQUEST_URI = 'http://' . $SCRIPT_HOST . ($_SERVER["SERVER_PORT"] == 80 ? '' : $_SERVER["SERVER_PORT"]) . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
    return $REQUEST_URI;
}


/*
 * @desc 做文件日志
 *
 */
function WriteTxtLog()
{
    $SCRIPT_HOST = $_SERVER["HTTP_HOST"];
    $LogDir = SYSTEM_ROOTPATH.'/Log/'.$SCRIPT_HOST;
    if (!file_exists($LogDir)) {
        @mkdir($LogDir, 0777, true);
    }
    
    if ($_POST) {
        $ST = json_encode($_POST, JSON_UNESCAPED_UNICODE);
        $Type = 'POST';
    }
    if ($_GET) {
        $ST = json_encode($_GET, JSON_UNESCAPED_UNICODE);
        $Type = 'GET';
    }
    
    $MyIP = GetIP();
    $AdminID = $_SESSION['AdminID'];
    $UserID = $_SESSION['UserID'];
    $DateTime = date("Y-m-d H:i:s");
    $BackUrl = $_SERVER['HTTP_REFERER'];
    $MyUrl = GetMyUrl();
    $LogTxt = $LogDir.'/'.date("Y-m-d").'.txt';
    
    $WriteString = '';
    $WriteString .= $SCRIPT_HOST.' | ';
    $WriteString .= $DateTime.' | ';
    $WriteString .= $Type.' | ';
    $WriteString .= $UserID.' | ';
    $WriteString .= $AdminID.' | ';
    $WriteString .= $MyIP.' | ';
    $WriteString .= $BackUrl.' | ';
    $WriteString .= $MyUrl.' | ';
    
    $WriteString .= $ST;
    
    file_put_contents($LogTxt,$WriteString.'
', FILE_APPEND);
}


// 输出json
function EchoResult($JsonResult = '')
{
    echo json_encode($JsonResult);
    exit();
}

// 获取IP地址
function GetIP()
{
    if (getenv('HTTP_CLIENT_IP')) {
        $ip = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) { // 获取客户端用代理服务器访问时的真实ip 地址
        $ip = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ip = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ip = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        $ip = getenv('HTTP_FORWARDED');
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// 过滤字符串
function nl_addslashes($string, $force = 0)
{
    ! defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if (! MAGIC_QUOTES_GPC || $force) {
        if (is_array($string)) {
            foreach ($string as $key => $val) {
                $string[$key] = nl_addslashes($val, $force);
            }
        } else {
            $string = addslashes($string);
        }
    }
    return $string;
}

// 模板有用到
function htmlencode($string, $clear_rn = false)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = htmlencode($val);
        }
    } else {
        if ($clear_rn) {
            $string = str_replace(array(
                "\n",
                "\r"
            ), array(
                '',
                ''
            ), $string);
        }
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', str_replace(array(
            '&',
            '"',
            '<',
            '>'
        ), array(
            '&amp;',
            '&quot;',
            '&lt;',
            '&gt;'
        ), $string));
    }
    return $string;
}

// 调用js助手直接打印一个提示信息
function alert($message)
{
    echo ("<script language='javascript';charset='utf8'>alert('" . $message . "')</script>");
    exit();
}

// 调用js助手打印提示信息并返回上一步
function alertandback($message)
{
    echo ("<script language='javascript';charset='utf8'>alert('" . $message . "');history.back();</script>");
    exit();
}

// 调用js助手打印提示信息并转向新的网页地址
function alertandgotopage($message, $url)
{
    echo ("<script language='javascript';charset='utf8'>alert('" . $message . "');window.location.replace('" . $url . "');</script>");
    exit();
}

// 跳转助手
function tourl($tourl)
{
    echo "<script language=javascript>";
    echo "window.location='" . $tourl . "';";
    echo "</script>";
    exit();
}

/**
 * post函数
 * 
 * @param
 *            $url
 * @param array $data
 *            array
 * @return bool|mixed
 */
function curl_postsend($url, $data = array())
{
    $ch = curl_init();
    // 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 定义超时3秒钟
                                             // POST数据
    curl_setopt($ch, CURLOPT_POST, 1);
    // POST参数
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    // 执行并获取url地址的内容
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    // 释放curl句柄
    curl_close($ch);
    if (0 !== $errorCode) {
        return false;
    }
    return $output;
}
function curl_getsend($Url = '')
{
    $ch = curl_init();
    // 设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 去除SSL证书验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 去除SSL证书验证
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 定义超时3秒钟
    // 执行并获取url地址的内容
    $output = curl_exec($ch);
    $errorCode = curl_errno($ch);
    // 释放curl句柄
    curl_close($ch);
    if (0 !== $errorCode) {
        return false;
    }
    return $output;
}
// 分页函数
function MultiPage(&$multipages, $n = 10)
{
    if ($multipages['Page'] - 3 > 0)
        $multipages['FirstPage'] = 1;
    if ($multipages['Page'] - 1 > 0)
        $multipages['BackPage'] = $multipages['Page'] - 1;
    if ($multipages['Page'] < $multipages['PageCount'])
        $multipages['NextPage'] = ($multipages['Page'] + 1);
    if ($multipages['Page'] + $n < $multipages['PageCount'])
        $multipages['LastPage'] = $multipages['PageCount'];
    $n = $n - 1;
    $min = ($multipages['Page'] - 3) > 0 ? $multipages['Page'] - 3 : 1;
    $max = ($min + $n) < $multipages['PageCount'] ? ($min + $n) : $multipages['PageCount'];
    for ($i = $min; $i <= $max; $i ++) {
        $multipages['PageNums'][] = $i;
    }
}

// 没有图片赋值默认图片
function WriteTopPicture($Picture = '')
{
    if ($Picture == '')
        return ImageURL . '/img/study/man3.0.png';
    else
        if (strpos($Picture, 'http://') !== false) {
            return $Picture;
        } else {
            return LImageURL . $Picture;
        }
    return $Picture;
}

// ---------------------------图片服务器操作start--------------------------------
// 上传到图片服务器
function SendToImgServ($ImgText)
{

    include SYSTEM_ROOTPATH . '/Include/MultiUpload.class.php';
    $Upload = new MultiUpload('Image');
    $ImageUrl = $Upload->ImageUpload($ImgText);
    return $ImageUrl;
}

/**
 * 文件上传图片服务器
 *
 * @param $FileName 文件名称
 * @param $File 文件（进制文件）
 * @return bool|mixed
 */
function SendToFileServ($FileName, $File)
{
    $Data = array(
        'Action' => 'AddFile',
        'FileName' => $FileName,
        'File' => $File
    );
    $Data['Sign'] = ImageAPIVerify($Data);
    return curl_postsend('http://images.57us.com/57usapi.php', $Data);
}


// 验证图片信息
function ImageAPIVerify($para)
{
    if (! is_array($para)) {
        return false;
    } else {
        $arg = "";
        while (list ($key, $val) = each($para)) {
            $arg .= $key . "=" . $val . "&";
        }
        // 去掉最后一个&字符
        $arg = substr($arg, 0, count($arg) - 2);
        // 如果存在转义字符，那么去掉转义
        if (get_magic_quotes_gpc()) {
            $arg = stripslashes($arg);
        }
        $SignKey = '57usimg123qwe.&*';
        $sign = md5($arg . $SignKey);
        return $sign;
    }
}

/**
 * 处理内容图片地址问题
 *
 * @param string $String
 * @param string $Title
 * @param string $Type
 * @return mixed|string
 */
function StrReplaceImages($String = '', $Title = '', $Type = 'l')
{
    preg_match_all('/<img.*src=\"(.*)\".*>/isU', $String, $Matches);
    foreach ($Matches[0] as $Key => $Value) {
        if ($Title != '') {
            $AltString = $Title . '_图' . ($Key + 1);
        }
        if (strpos($Matches[1][$Key], "http://") === false && strpos($Matches[1][$Key], "https://") === false) {
            $NewImagesString = '<img src="http://images.longwengui.com/' . $Type . $Matches[1][$Key] . '" title="' . $AltString . '" alt="' . $AltString . '" />';
        } else {
            $NewImagesString = '<img src="' . $Matches[1][$Key] . '" title="' . $AltString . '" alt="' . $AltString . '" />';
        }
        $String = str_replace($Value, $NewImagesString, $String);
    }
    return $String;
}

// -------------------------图片服务器操作end------------------------------------

/**
 * 处理编辑器不能显示文字
 */
function DoEditorContent($String = '')
{
    if (is_array($String)) {
        // 只适合二维数组
        foreach ($String as $K => $Val) {
            $String[$K] = str_replace(array(
                '<div>',
                '</div>',
                '<ul>',
                '<li>',
                '</ul>',
                '</li>'
            ), array(
                '<p>',
                '</p>',
                '',
                '',
                '',
                ''
            ), $String[$K]);
            $String[$K] = str_replace(array(
                "\r\n",
                "\r",
                "\n"
            ), "", $String[$K]);
        }
    } else {
        $String = str_replace(array(
            '<div>',
            '</div>',
            '<ul>',
            '<li>',
            '</ul>',
            '</li>'
        ), array(
            '<p>',
            '</p>',
            '',
            '',
            '',
            ''
        ), $String);
        $String = str_replace(array(
            "\r\n",
            "\r",
            "\n"
        ), "", $String);
    }
    return $String;
}
