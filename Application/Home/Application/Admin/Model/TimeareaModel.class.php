<?php
namespace Admin\Model;
use Think\Model;
class TimeareaModel extends Model{



	function check_repeat($timearea,$id=""){
        if($id !== ""){
            $map["id"] = array("neq",$id);
        }
        $map["isdel"] = 0;
        $map['timearea'] = $timearea;
        return $this->where($map)->find();
	}
		

}
