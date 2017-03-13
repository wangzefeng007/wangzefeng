<?php

/**
 * Class Page 分页类
 */
class Page
{
    private $total;        //总记录
    private $pagesize;    //每页显示多少条
    private $limit;       //limit
    private $page;        //当前页码
    private $pagenum;    //总页码
    private $url;        //地址
    private $bothnum;   //两边保持数字分页的量
    private $class;     //选中样式
    private $type;      //类型  0-study_hotprofession_   1-.html  2-?status=1&page=
    private $suffix;    //自定义分页参数
    private $html;

    /**
     * @desc  构造方法初始化
     * Page constructor.
     * @param $_total
     * @param $_pagesize
     */
    public function __construct($_total, $_pagesize, $type = 0, $_class = 'on', $_suffix = '')
    {
        $this->type = $type;
        if ($this->type==1) {
            $this->html = '.html';
        }
        elseif($this->type == 0 || $this->type == '') {
            if ($_suffix == '')
            $this->html = '/';
        }
        elseif($this->type == 2){
            $this->html = '';
        } elseif($this->type == 3){
            $this->html = '';
        }
        $this->total = $_total ? $_total : 1;
        $this->pagesize = $_pagesize;
        $this->pagenum = ceil($this->total / $this->pagesize);
        $this->suffix = $_suffix;
        $this->page = $this->setPage();
        $this->limit = "LIMIT " . ($this->page - 1) * $this->pagesize . ",$this->pagesize";
        $this->url = $this->setUrl();
        $this->bothnum = 2;
        $this->class = $_class;
    }

    /**
     * @desc  拦截器
     * @param $_key
     * @return mixed
     */
    private function __get($_key)
    {
        return $this->$_key;
    }

    /**
     * @desc   获取当前页码
     * @return float|int
     */
    private function setPage()
    {
        if ($this->suffix) {
            if (!empty($_GET[$this->suffix])) {
                if ($_GET[$this->suffix] > 0) {
                    if ($_GET[$this->suffix] > $this->pagenum) {
                        return $this->pagenum;
                    } else {
                        return $_GET[$this->suffix];
                    }
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
        }elseif ($this->type==3){
            if (!empty($_GET['p'])) {
                if ($_GET['p'] > 0) {
                    if ($_GET['p'] > $this->pagenum) {
                        return $this->pagenum;
                    } else {
                        return $_GET['p'];
                    }
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
        } else {
            if (!empty($_GET['page'])) {
                if ($_GET['page'] > 0) {
                    if ($_GET['page'] > $this->pagenum) {
                        return $this->pagenum;
                    } else {
                        return $_GET['page'];
                    }
                } else {
                    return 1;
                }
            } else {
                return 1;
            }
        }
    }

    /**
     * @desc  获取地址
     * @return string
     */
    private function setUrl()
    {
        $_url = $_SERVER["REQUEST_URI"];
        if ($this->type == 1) {
            $_return_url = substr($_url, 0, strlen($_url) - 5);
            $_par = explode('_', $_return_url);
            $url = '';
            foreach ($_par as $key => $val) {
                if (is_numeric($val)) {
                    continue;
                }
                $url .= $val . '_';
            }
            $_return_url = $url;
        } elseif($this->type == 0) {
            if ($this->suffix != '') {
                $_url = preg_replace("/\?{$this->suffix}=\w*/i", '', $_url);
                $_return_url = $_url . '?' . $this->suffix . '=';
            } else {
                $_par = str_replace('/', '', $_url);
                $_par = explode('_', $_par);
                $_return_url = '/';
                foreach ($_par as $key => $val) {
                    if (is_numeric($val)) {
                        continue;
                    }
                    $_return_url .= $val . '_';
                }
            }
        }
        elseif($this->type == 2){
            $_par = explode('?', $_url);
            $_return_url = $_par[0].'?';
            $_par2 = $_par = explode('&', $_par[1]);
            foreach ($_par2 as $key=>$val){
                if(strpos($val,'page') === false){
                    $_return_url .= $val.'&';
                }
            }
        }elseif($this->type == 3){
            $_par = explode('?', $_url);
            $_return_url = $_par[0].'?';
            $_par2 = $_par = explode('&', $_par[1]);
            foreach ($_par2 as $key=>$val){
                if(strpos($val,'p') === false){
                    $_return_url .= $val.'&';
                }
            }
            $_return_url = str_replace('?&','?',$_return_url);
        }
        return $_return_url;
    }

    /**
     * @return string 数字目录
     */
    private function pageList()
    {
        $_pagelist = '';
        if($this->type == 0 || $this->type == 1){
            for ($i = $this->bothnum; $i >= 1; $i--) {
                $_page = $this->page - $i;
                if ($_page < 1) continue;
                $_pagelist .= ' <a href="' . $this->url . $_page . $this->html . '">' . $_page . '</a> ';
            }
            $_pagelist .= ' <a href="' . $this->url . $this->page . $this->html . '" class="' . $this->class . '">' . $this->page . '</a> ';
            for ($i = 1; $i <= $this->bothnum; $i++) {
                $_page = $this->page + $i;
                if ($_page > $this->pagenum) break;
                $_pagelist .= ' <a href="' . $this->url . $_page . $this->html . '">' . $_page . '</a> ';
            }
        }
        elseif ($this->type == 2){
            for ($i = $this->bothnum; $i >= 1; $i--) {
                $_page = $this->page - $i;
                if ($_page < 1) continue;
                $_pagelist .= ' <a href="' . $this->url . $this->html .'page='. $_page  . '">' . $_page . '</a> ';
            }
            $_pagelist .= ' <a href="' . $this->url .'page='.$this->page . $this->html . '" class="' . $this->class . '">' . $this->page . '</a> ';
            for ($i = 1; $i <= $this->bothnum; $i++) {
                $_page = $this->page + $i;
                if ($_page > $this->pagenum) break;
                $_pagelist .= ' <a href="'.$this->url.$this->html.'page='.$_page.'">' . $_page . '</a> ';
            }
        }elseif ($this->type == 3){
            for ($i = $this->bothnum; $i >= 1; $i--) {
                $_page = $this->page - $i;
                if ($_page < 1) continue;
                $_pagelist .= ' <a href="' . $this->url . $this->html .'p='. $_page  . '">' . $_page . '</a> ';
            }
            $_pagelist .= ' <a href="' . $this->url .'p='.$this->page . $this->html . '" class="' . $this->class . '">' . $this->page . '</a> ';
            for ($i = 1; $i <= $this->bothnum; $i++) {
                $_page = $this->page + $i;
                if ($_page > $this->pagenum) break;
                $_pagelist .= ' <a href="'.$this->url.$this->html.'p='.$_page.'">' . $_page . '</a> ';
            }
        }
        return $_pagelist;
    }

    /**
     * @desc  首页
     * @return string
     */
    private function first()
    {
        if ($this->page > $this->bothnum + 1 && $this->type != 3) {
            if ($this->page - $this->bothnum == 2) {
                if($this->type == 0){
                    //echo $this->url;exit;
                    return ' <a href="' . $this->url . '1' . $this->html . '">1</a>';
                }
                else{
                    return ' <a href="' . $this->url .'page='. '1' . $this->html . '">1</a>';
                }
            }
            return ' <a href="' . $this->url . '1' . $this->html . '">1</a> ...';
        }elseif ($this->page > $this->bothnum + 1 && $this->type==3){
            if ($this->page - $this->bothnum == 2) {
                return ' <a href="' . $this->url .'p='. '1' . $this->html . '">1</a>';
            }
            return ' <a href="' . $this->url .'p='. '1' . $this->html . '">1</a> ...';
        }
        else{

        }
    }

    /**
     * @desc  上一页
     * @return string
     */
    private function prev()
    {
        if ($this->page == 1) {
            return '<a href="javascript:void(0);">上一页</a>';
        }
        if($this->type == 0 || $this->type == 1){
            return ' <a href="' . $this->url . ($this->page - 1) . $this->html . '">上一页</a> ';
        }
        elseif($this->type == 2){

            return ' <a href="' . $this->url.$this->html.'page='.($this->page-1) . '">上一页</a> ';
        }elseif($this->type == 3){

            return ' <a href="' . $this->url.$this->html.'p='.($this->page-1) . '">上一页</a> ';
        }
    }

    /**
     * @desc  下一页
     * @return string
     */
    private function next()
    {
        if ($this->page == $this->pagenum) {
            return '<a href="javascript:void(0);">下一页</a>';
        }
        if($this->type == 0 || $this->type == 1){
            return ' <a href="' . $this->url . ($this->page + 1) . $this->html . '">下一页</a> ';
        }
        elseif($this->type == 2){
            return ' <a href="' . $this->url.$this->html.'page='.($this->page+1) . '">下一页</a> ';
        }elseif($this->type == 3){
            return ' <a href="' . $this->url.$this->html.'p='.($this->page+1) . '">下一页</a> ';
        }
    }

    /**
     * @desc  尾页
     * @return string
     */
    private function last()
    {
        if ($this->pagenum - $this->page > $this->bothnum) {
            if($this->type == 0 || $this->type == 1){
                if ($this->page + $this->bothnum == $this->pagenum - 1) {
                    return ' <a href="' . $this->url . $this->pagenum . $this->html . '">' . $this->pagenum . '</a> ';
                }
                return ' ...<a href="' . $this->url . $this->pagenum . $this->html . '">' . $this->pagenum . '</a> ';
            }elseif ($this->type==3){
                if ($this->page + $this->bothnum == $this->pagenum - 1) {
                    return ' <a href="' . $this->url . $this->html .'p='. $this->pagenum . '">' . $this->pagenum . '</a> ';
                }
                return ' ...<a href="' . $this->url . $this->html .'p='. $this->pagenum . '">' . $this->pagenum . '</a> ';
            }else{
                if ($this->page + $this->bothnum == $this->pagenum - 1) {
                    return ' <a href="' . $this->url . $this->html .'page='. $this->pagenum . '">' . $this->pagenum . '</a> ';
                }
                return ' ...<a href="' . $this->url . $this->html .'page='. $this->pagenum . '">' . $this->pagenum . '</a> ';
            }
        }
    }

    /**
     * @desc  分页信息
     * @return string
     */
    public function showpage()
    {
        if ($this->pagenum <= 1) {
            return '';
        }
        $_page = '';
        $_page .= $this->prev();
        $_page .= $this->first();
        $_page .= $this->pageList();
        $_page .= $this->last();
        $_page .= $this->next();
        return $_page;

    }
}

?>