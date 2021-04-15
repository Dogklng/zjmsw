<?php
namespace Admin\Model;
use Think\Model;
class ReceiveOrderModel extends Model
{

	// 内容要求
	// 1.关联用户表，根据用户id得到用户数据
    function orderlist($p)
    {
        $orderstate = I("orderstate");
        $order_no   = I("order_no");
        $telephone  = I("telephone");
        $starttime  = I("starttime"); 
        $endtime    = I("endtime"); 
        $where["u.isdel"] = 0;
        $where["a.isdel"] = 0;
        $where["o.isdel"] = 0;
        if($orderstate!==""){
            $where['orderstate'] = $orderstate;
        }

        if($where["order_no"] !== ""){
            $where["order_no"] = array("like","%$order_no%");
        }

        if($telephone !== ""){
            $where["phone"] = array("like","%$telephone%");
        }
    	$DB_PREFIX = C("DB_PREFIX");
        $str = "left join {$DB_PREFIX}member as u on u.id = userid";
        $str2 = "left join {$DB_PREFIX}orderlist as o on o.id = orderid";
        $count = $this->alias("a")->where($where)->join($str)->join($str2)->count();
        $page = getpage($count,8);
        $result['data'] = $this->alias("a")->where($where)->join($str)->join($str2)->field("a.id,
        	telephone as tel,realname as username,
        	charge,phone,message,
        	a.status,a.pay_time,a.refund_fee,a.userid,
        	orderid,orderid,
        	a.addtime,o.refund_state,
            o.orderstate,o.order_no,o.refund_fee"
            )
        	->limit($page->firstRow, $page->listRows)
        	->select();
        $result['page'] = $page->show();
        return $result;
    }

    function count_type_n($state){
        $DB_PREFIX = C("DB_PREFIX");
        $str = "left join {$DB_PREFIX}orderlist as o on o.id = orderid";
        $where["orderstate"] = $state;
        $where["a.isdel"] = 0;
        $where["o.isdel"] = 0;
        $count = $this->alias("a")->join($str)->where($where)->count();
        return $count;
    }

}


 ?>