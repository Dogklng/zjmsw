<?php
namespace Admin\Model;
use Think\Model;
class DistributeOrderModel extends Model
{
    public function getList($tasks)
    {
    	$orderstate = I("orderstate");
    	$order_no   = I("order_no");
        $telephone  = I("telephone");
        $person_name= I("person_name");
    	$starttime  = strtotime(I("starttime")); 
        $endtime    = strtotime(I("endtime")); 
        $type    = I("type"); 

        if($type != ""){
            $where['type'] = $type;
        }

    	if($orderstate!==""){
    		$where['orderstate'] = $orderstate;
    	}

    	if($order_no != ""){
			$where["order_no"] = array("like","%$order_no%");
    	}

        if($telephone !== ""){
            $where["telephone"] = array("like","%$telephone%");
        }

        if($person_name !== ""){
            $where["person_name"] = array("like","%$person_name%");
        }

        if($starttime){
            $where['a.create_at']=array('egt',$starttime);
        }
        
        if($endtime){
            $where['a.create_at']=array('elt',$endtime);
        }
        
        // $where["a.isdel"] = 0;
       	$DB_PREFIX = C("DB_PREFIX");
        $str = "left join {$DB_PREFIX}member as u on u.id = a.user_id and u.isdel = 0 and u.status=0";
        $count = $this->alias("a")->where($where)->count();
        $page = getpage($count,8);
        $result['data'] = $this->alias("a")->where($where)->join($str)->
                field("
                    a.*, u.telephone, u.person_name, u.realname
		        	")
        	->limit($page->firstRow, $page->listRows)
            ->order("addtime desc")
        	->select();
        $result['page'] = $page->show();
        return $result;
    }
	
	/*--------------经纬度计算距离-----------------------*/
    function getDistance($lat1, $lng1, $lat2, $lng2) {
        $earthRadius = 6367000; // approximate radius of earth in meters
         
        // Convert these degrees to radians to work with the formula
        $lat1 = ($lat1 * pi ()) / 180;
        $lng1 = ($lng1 * pi ()) / 180;
    
        $lat2 = ($lat2 * pi ()) / 180;
        $lng2 = ($lng2 * pi ()) / 180;
    
        // Using the Haversine formula http://en.wikipedia.org/wiki/Haversine_formula calculate the distance
    
        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow ( sin ( $calcLatitude / 2 ), 2 ) + cos ( $lat1 ) * cos ( $lat2 ) * pow ( sin ( $calcLongitude / 2 ), 2 );
        $stepTwo = 2 * asin ( min ( 1, sqrt ( $stepOne ) ) );
        $calculatedDistance = $earthRadius * $stepTwo;
    
        return round ( $calculatedDistance );
    }
}


 ?>