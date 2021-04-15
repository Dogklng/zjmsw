<?php
namespace Admin\Model;
use Think\Model;
class PositionClassModel extends Model{



	public function check_category($classname,$pid,$id){
        if($id){
            $date=array(
                "classname"=>$classname,
                "parid" => $pid,
                "id"=> array("neq",$id)
            );
        }else{
            $date=array(
                "classname"=>$classname,
                "parid" => $pid
            );
        }
        $date["isdel"] = 0;
            $rs=$this->where($date)->find();
            return $rs;

		}
		
	//获得二级分类
	public function get_category($category){
        foreach($category as $k => $v){
			if($v['parid']==0){
				$arr[$v['id']]=$v;
			}
		}
		foreach($category as $k => $v){
			if($v['parid']!=0){
				$arr[$v['parid']]['cate'][$k]=$v;
			}
		}
        return $arr;
	}

	// 删除分类下的所有分类
	public function del_category($id){
		$where = array(
				"id" => $id,
				"parid" => $id
			);
		$where["_logic"] = "or";
		$data["isdel"] = 1;
		$result = $this->where($where)->save($data);
		return $result;
	}
}

 ?>