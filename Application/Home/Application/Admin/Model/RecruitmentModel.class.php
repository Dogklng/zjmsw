<?php
namespace Admin\Model;
use Think\Model;
class RecruitmentModel extends Model{
		
	public function getAllSalary(){
		$position = I('get.title');
		$where['position'] = array("like","%$position%");
		$where["r.isdel"] = 0;
		$where["c.isdel"] = 0;
		$DB_PREFIX = C("DB_PREFIX");
		$str = "left join {$DB_PREFIX}company as c on company_id = c.id";
		$result = $this ->alias("r")-> where($where) -> join($str) ->field("c.company_name,r.*") -> select();
		return $result;
	}	
}
 ?>