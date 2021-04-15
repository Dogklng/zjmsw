<?php
/**
 * Created by PhpStorm.
 * User: zhangjie
 * Date: 2017/11/03
 * Time: 11:00
 */
namespace Org\Util;
class Arraypage {
    private $total;      //总记录
    private $pagesize;    //每页显示多少条
    private $limit;          //limit
    private $page;           //当前页码
    private $pagenum;      //总页码
    private $url;           //地址
    private $bothnum;      //两边保持数字分页的量

    //构造方法初始化
    public function __construct($_total, $_pagesize) {
        header('Content-Type:text/html;charset=utf-8;');
        $this->total = $_total ? $_total : 1;
        $this->pagesize = $_pagesize;
        $this->pagenum = ceil($this->total / $this->pagesize);
        $this->page = $this->setPage();
        $this->limit = "LIMIT ".($this->page-1)*$this->pagesize.",$this->pagesize";
        // $this->url = $this->setUrl();
        $this->bothnum = 2;
    }
    /**
     * 数组分页函数 核心函数 array_slice
     * 用此函数之前要先将数据库里面的所有数据按一定的顺序查询出来存入数组中
     * $count  每页多少条数据
     * $page  当前第几页
     * $array  查询出来的所有数组
     * order 0 - 不变   1- 反序
     */
    public function page_array($array,$order)
    {
        if($order==1){
            $array=array_reverse($array);
        }
        $pagedata=array_slice($array,($this->page-1)*$this->pagesize,$this->pagesize);
        return $pagedata; #返回查询数据
    }

    //拦截器
    public  function __get($_key) {
        return $this->$_key;
    }

    //获取当前页码
    private function setPage() {
        $_POST['page'] = isset($_POST['page']) ? $_POST['page'] : $_GET['page'];
        if (!empty($_POST['page'])) {
            if ($_POST['page'] > 0) {
                if ($_POST['page'] > $this->pagenum) {
                    return $this->pagenum;
                } else {
                    return $_POST['page'];
                }
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    //获取地址
    private function pageList() {
        for ($i=$this->bothnum;$i>=1;$i--) {
            $_page = $this->page-$i;
            if ($_page < 1) continue;
            $_pagelist .= "<span data-page='$_page'>$_page</span> ";
        }
        $_pagelist .= ' <span class="me">'.$this->page.'</span> ';
        for ($i=1;$i<=$this->bothnum;$i++) {
            $_page = $this->page+$i;
            if ($_page > $this->pagenum) break;
            $_pagelist .="<span data-page='$_page'>$_page</span> ";
        }
        return $_pagelist;
    }

    //首页
    private function first() {
        if ($this->page > $this->bothnum+1) {
            return "<span data-page=1>首页</span> ";
        }
    }

    //上一页
    private function prev() {
        if ($this->page == 1) {
            return '<span class="disabled">上一页</span>';
        }
        $pre = intval($this->page)-1;
        return "<span data-page= '$pre' >上一页</span> ";
    }

    //下一页
    private function next() {
        if ($this->page == $this->pagenum) {
            return '<span class="disabled">下一页</span>';
        }
        $next = $this->page+1;
        return "<span data-page= '$next'>下一页</span> ";

    }

    //尾页
    private function last() {
        if ($this->pagenum - $this->page > $this->bothnum) {
            return  "<span data-page='$this->pagenum'>末页</span> ";
        }
    }

    //分页信息
    public function showpage() {
        $_page .= $this->first();
        $_page .= $this->prev();
        $_page .= $this->pageList();
        $_page .= $this->next();
        $_page .= $this->last();
        if($this->pagesize > $this->total){
            $_page ='';
        }
        return $_page;
    }
}