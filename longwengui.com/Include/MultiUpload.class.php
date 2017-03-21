<?php
class MultiUpload{
    public $maxSize = 2097152;//Byte 2M
    public $allowExts=array('.jpg','.jpeg','.gif','.png','.bmp','.rar','.zip','.pdf','.swf');
    public  $error= array();
    private $count =0;
    public  $savePath ='';
    public  $field='userfile';
    public  $uploadReplace=0;
    public $thumbFile =	'';
    public $thumbMaxWidth=100;
    public $thumbMaxHeight=100;
    public $thumbPrefix = 's_';
    public $thumbSuffix  =  '';
    public $imageClassPath = '@.ORG.Image';
    public $thumbRemoveOrigin=0;
    public $autoSub=0;

    public $thumb = 0;
    public $savedName =array();
    public $sourceFileName=1;
    function __construct($fieldName){
        $this->savePath='/Uploads/Reword/'.date('Ymd').'/';
        if(!empty($fieldName)){$this->field=$fieldName;}
        foreach ($_FILES[$this->field]['size'] as $filename){
            $this->count++;
        }
    }
    public function upload(){
        //$this->checkSavePath();
        for($i=0;$i<$this->count;$i++){
            $filename = $_FILES[$this->field]["name"][$i];
            $filename = mb_convert_encoding ( $filename, "GBK", "UTF-8" );
            $tmp_name =  $_FILES[$this->field]['tmp_name'][$i];
            $file['ext']  = $this->getExt($filename);
            $file['size'] = $_FILES[$this->field]['size'][$i];
            $file['tmp_name']  = $tmp_name;
            if($this->check($file,$i)){
                $saveName = $this->getSaveName($filename);
                $savedPath = $this->savePath.$saveName;
                if (!file_exists(SYSTEM_ROOTPATH.$this->savePath) && !mkdir(SYSTEM_ROOTPATH.$this->savePath, 0777, true)) {
                    return false;
                } else if (!is_writeable(SYSTEM_ROOTPATH.$this->savePath)) {
                    return false;
                }
                $PushImage = file_put_contents(SYSTEM_ROOTPATH.$savedPath, base64_decode(base64_encode(file_get_contents($tmp_name))));
                if ($PushImage){
                    return $savedPath;
                }else{
                    return false;
                }
            }else{
                $this->savedName[] = '';
            }
        }
        return $this->savedName;
    }
    public function getUploadFileInfo(){
        return $this->savedName;
    }
    private function getSaveName($filename)
    {
        $preStr = '';
        if ($this->sourceFileName) {
            $array = array();
            $array = explode('.', $filename);
            $preStr = $array[0];
        }
        //生成一个唯一的字符串。
        return date("YmdHis") . rand(1000, 9999) . '.' . strtolower($array[count($array) - 1]);
    }

    private function check($file,$file_number) {
        //文件上传成功，进行自定义规则检查
        //检查文件大小

        if(!$this->checkSize($file['size'])) {
            $this->error[$file_number] = '上传文件大小不符！';
            return false;
        }
        //检查文件类型
        if(!$this->checkExt($file['ext'])) {
            $this->error[$file_number] ='上传文件类型不允许';
            return false;
        }

        //检查是否合法上传
        if(!$this->checkUpload($file['tmp_name'])) {var_dump($this->checkUpload($file['tmp_name']));exit;
            $this->error[$file_number] = '非法上传文件！';
            return false;
        }
         $this->error[$file_number] = '';
        return true;
    }

    private function checkSize($size)
    {
        return $size < $this->maxSize ? true :false;
    }
    private function checkExt($ext)
    {
        if(!empty($this->allowExts))
            return in_array(strtolower($ext),$this->allowExts,true);
        return true;
    }
    private function checkUpload($file_tmp_name)
    {
        return is_uploaded_file($file_tmp_name);
    }
    private function getExt($file_name)
    {

    $extend =explode("." , $file_name);
    $va=count($extend)-1;
    return '.'.strtolower($extend[$va]);
    }
    private function checkSavePath(){
    if(!is_dir($this->savePath)){
	    self::mkDir($this->savePath);
            return;
    }
    }
    private static function mkDir($dir) {
		mkdir($dir);
		chmod($dir,0777);
    }
    public function getErrorMsg()
    {
        return $this->error;
    }
}
?>