<?php
namespace Home\Model;
use Think\Model;
class RegionModel extends Model{
	
	// 通过
	/**
	 * $name  城市名
	 * $level 城市级别 
	 */
	public function get_id_by_name($name, $level){	
		$keyword = preg_replace("/(省|市|区|县)$/", "", $name);
		$id = $this->where(array('region_type'=>$level, "region_name"=>array('like',"%$keyword%")))->getField('id');	
		return $id?$id:0;
	}

	// 通过id得到地区名称
	public function get_name_by_id($id){
		return $this->where(array('id'=>$id))->getField("region_name");
	}
}
?>