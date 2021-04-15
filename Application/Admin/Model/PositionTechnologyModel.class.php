<?php
namespace Admin\Model;
use Think\Model;
class PositionTechnologyModel extends Model{
	
	public function checkPT($techId, $positionId){
		$map['tech_id'] = $techId;
		$map['position_id'] = $positionId;
		$result = $this->field('id')->where($map)->find();
		return $result;
	}
}
 ?>