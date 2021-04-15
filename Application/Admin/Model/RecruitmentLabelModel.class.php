<?php
namespace Admin\Model;
use Think\Model;
class RecruitmentLabelModel extends Model{
	public function getAllWelfare($id){
		$DB_PREFIX = C("DB_PREFIX");
		// 这里使用join
		$str = "left join {$DB_PREFIX}label as l on rl.label_id = l.id";
		$res = $this->where("recruitment_id=$id and rl.isdel=0 and l.isdel=0")->alias("rl")->join($str)->field("labelname")->select();
		$Welfare = "";
		foreach($res as $k=>$v){
			$Welfare.="$v[labelname],";
		}
		$Welfare = trim($Welfare,",");
		return $Welfare;
	}		
}
 ?>