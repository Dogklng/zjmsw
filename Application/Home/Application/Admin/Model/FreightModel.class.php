<?php
namespace Admin\Model;
use Think\Model;
class FreightModel extends Model{
		
		
		function Freightlist($val){
            if(!is_null($val)){
                $where="dealerid='$val'";
            }
			$count = $this->where($where)->count();
			$p = getpage($count,10);
			$list = $this->field(true)->where($where)->order('id desc')->limit($p->firstRow, $p->listRows)->select();
			$date['list']=$list; // 赋值数据集
			$date['page']= $p->show();// 赋值分页输出
			$date['count']= $count;
			return $date;
		}
		
		
		// 添加
		function addFreight($privonce,$sweight,$sprice,$xwprice,$dealerid){
			
			$data=array(
				"privonce"=>$privonce,
				"sweight"=>$sweight,
				"sprice"=>$sprice,
				"xwprice"=>$xwprice,
				"dealerid"=>$dealerid
			);
				$is_ok = $this->data($data)->add();	
				if($is_ok)
				{
					return 1;
				}else{
					return 2;
				}
		
		}
		
		//编辑
		function editFreight($id,$privonce,$sweight,$sprice,$xwprice,$dealerid){

				$postdata=array(
					"id"=>$id,
					"privonce"=>$privonce,
					"sweight"=>$sweight,
					"sprice"=>$sprice,
					"xwprice"=>$xwprice,
					"dealerid"=>$dealerid
				);
				$this->save($postdata);
				return 1;	

		}

		
		// 删除
		function del($id){

			$result = $this->where("id=$id")->delete();
			if($result)
			{
				return 1; // 成功
			}
			else
			{
				return 0; // 失败
			}
			
		
		}
		
			
		function getone($name){
			$userid = $_SESSION['admin_id'];
			$rs = $this->where('id='.$userid)->getField($name);
			return $rs;

		}	
		

		//所属商圈导入
		function deimport($dea,$dealer){
			$data=$this->where("dealerid=".$dea)->select();
			foreach($data as &$val){
				$val['dealerid']=$dealer;
				unset($val['id']);

			}
			$num=count($data);		
			for($i=0;$i<$num;$i++){
				$rs=$this->add($data[$i]);
			}
			return $rs;
		}
	}
 ?>