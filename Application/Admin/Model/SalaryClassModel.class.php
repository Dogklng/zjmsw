<?php
namespace Admin\Model;
use Think\Model;
class SalaryClassModel extends Model{



	function check_repeat($area,$id=""){
        if($id !== ""){
            $map["id"] = array("neq",$id);
        }
        $map["isdel"] = 0;
        $map['area'] = $area;
        return $this->where($map)->find();
	}
		

}
