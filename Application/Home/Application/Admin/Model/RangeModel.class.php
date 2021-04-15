<?php
namespace Admin\Model;
use Think\Model;
class RangeModel extends Model{



	function check_repeat($range,$id=""){
        if($id !== ""){
            $map["id"] = array("neq",$id);
        }
        $map["isdel"] = 0;
        $map['range'] = $range;
        return $this->where($map)->find();
	}
		

}
