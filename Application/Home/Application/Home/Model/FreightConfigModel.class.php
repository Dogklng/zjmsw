<?php
namespace Home\Model;
use Think\Model;
class FreightConfigModel extends Model{
	/**
	 * 得到快递费
	 * 重量，省份
	 */
	public function get_freight($weight="", $province_id="",$user_id=0){
		if($province_id=="" || $weight==""){
			// 取第一个
			//$config = $this->order('sort desc')->find();
			return 0;
		}else{
			$config_id = D('frei_link_region')->where(array("region_id"=>$province_id,'user_id'=>$user_id))->getField('freight_id');

			if(!$config_id){
				$config = $this->where(array('user_id'=>$user_id))->order('sort desc')->find();
			}else{
				$config = $this->find($config_id);
			}
		}
		return $this->count_express_fee($weight, $config);
	}

	
	/**
	 * 根据运费配置计算快递费
	 */
	public function count_express_fee($weight, $config){
		$weight = floatval($weight);
		$express_fee = 0;
		$express_fee += $config['first_price']*$config['ratio'];
		if($weight<=1){
			return $express_fee;
		}
		$express_fee += $config['next_price']*$config['ratio']*($weight-1);
		return $express_fee;
	}
}
?>