<?php
namespace Admin\Model;
use Think\Model;
class LabelModel extends Model{
	public function check_repeat($labelname,$id=""){
		$where['labelname'] = $labelname;
		$where['isdel'] = 0;
		if($id !== ""){
			$where['sequence'] = array("neq",$id);
		}
		$res = $this->where($where)->find();
		return $res;
	}
}
 ?>