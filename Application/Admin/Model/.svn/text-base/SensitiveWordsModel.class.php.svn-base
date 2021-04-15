<?php
namespace Admin\Model;
use Think\Model;
class SensitiveWordsModel extends Model{



	function getList(){
        $title     = I("title"); 
        $status    = I("status"); 
    	if($status !== ""){
			$where["status"] = $status;
			unset($where["1"]);
    	}

    	if($title !== "" ){
			$where["word"] = array("like","%$title%");
			unset($where["1"]);
    	}

        $count = $this->where($where)->count();
        $page = getpage($count,8);
        $result['data'] = $this->where($where)
        	->limit($page->firstRow, $page->listRows)
        	->select();
        $result['page'] = $page->show();
        return $result;
	}
		

}
