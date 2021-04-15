<?php
namespace Admin\Model;
use Think\Model;
class CompanyClassModel extends Model{
	public function check_repeat($classname,$id=""){
		$where['classname'] = $classname;
		$where['isdel'] = 0;
		if($id !== ""){
			$where['id'] = array("neq",$id);
		}
		$res = $this->where($where)->find();
		return $res;
	}
}
 ?>