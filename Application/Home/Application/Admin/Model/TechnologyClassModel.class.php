<?php
namespace Admin\Model;
use Think\Model;
class TechnologyClassModel extends Model{

	protected $technology = array();

	public function get_technology($data){
		$DB_PREFIX        = C("DB_PREFIX");
		$str 	          = "right join {$DB_PREFIX}position_technology as a on t.id = a.tech_id";
		$where["a.isdel"] = 0;
		$where["t.isdel"] = 0;
		$this->technology = $this->alias("t")->where($where)->join($str)->select();

		$this->mix_tech_position($data);
		foreach($this->technology as $k=>$v){
			$res[$v["position_id"]][] = $v; 
		}
		$this->technology = $res;
		$result           = $this->mix_tech_position($data);
		return $result;
	}

	protected function mix_tech_position($data){
		// foreach($this->technology as $k => $v){
		// 	$this->technology[$k]["position_className"] = $data[$v['position_id']]["classname"];
		// }
		foreach($data as $k => $v){
			$data[$k]["tech"] = $this->technology[$v["id"]];
		}
		return $data;
	}

	public function check_tech($classname,$id){
		$map = array(
				"id" => array("neq",$id),
				"classname" => $classname,
				"isdel"  => 0
			);
		$res = $this->field('id')->where($map)->find();
		if($res === false){
			return false;
		}else{
			return $res;
		}
	}
}

 ?>