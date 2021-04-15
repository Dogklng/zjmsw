<?php
namespace Admin\Model;
use Think\Model;
class OrderlistModel extends Model
{
    public function orderlist($tasks,$userids = "")
    {
    	$orderstate = I("orderstate");
    	$order_no   = I("order_no");
        $telephone  = I("telephone");
        $person_name= I("person_name");
    	$starttime  = I("starttime"); 
        $endtime    = I("endtime"); 
    	if($orderstate!==""){
    		$where['orderstate'] = $orderstate;
    	}

    	if($where["order_no"] !== ""){
			$where["order_no"] = array("like","%$order_no%");
    	}

        if($telephone !== ""){
            $where["telephone"] = array("like","%$telephone%");
        }

        if($person_name !== ""){
            $where["person_name"] = array("like","%$person_name%");
        }

        if($starttime){
            $where['a.addtime']=array('egt',$starttime);
        }
        
        if($endtime){
            $where['a.addtime']=array('elt',$endtime);
        }
        

        // $where["a.isdel"] = 0;
       	$DB_PREFIX = C("DB_PREFIX");
        $str = "left join {$DB_PREFIX}member as u on u.id = a.userid and u.isdel = 0 and u.status=0";
        $count = $this->alias("a")->where($where)->count();
        $page = getpage($count,8);
        $result['data'] = $this->alias("a")->where($where)->join($str)->
                field("
        			telephone as tel,realname as username,
		        	a.id,
					a.type,task,title,
					a.addtime,
					content,special,remuneration,
					prepay,pay_type,
					orderstate,a.status,
					work_type,pay_time,refundtime,
					refund_fee,refund_state,userid,
					longitude,latitude,btime,
					order_no,audio,pic1,pic2,pic3,
					pic4,pic5,pic6,a.isdel
		        	")
        	->limit($page->firstRow, $page->listRows)
            ->order("addtime desc")
        	->select();
        foreach($result['data'] as $k=>$v){
        	$result['data'][$k]['type'] = $tasks[$v['type']];
        }
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