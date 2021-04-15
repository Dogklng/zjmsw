<?php
namespace Admin\Model;
use Think\Model;
class TaskClassModel extends Model{



	function check_category($classname,$pid,$id){
        if($id){
            $date=array(
                "classname"=>$classname,
                "parid" => $pid,
                "id"=> array("neq",$id)
            );
        }else{
            $date=array(
                "classname"=>$classname,
                "parid" => $pid,
            );
        }
        $data["isdel"] = 0;

        $rs=$this->where($date)->find();
        return $rs;

		}
		
	//获得二级分类
	function get_category($category){
		foreach($category as $k => $v){
            if($v['parid'] == 0){
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

}
