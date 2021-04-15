<?php
error_reporting(0);
//数据库连接
include_once './func/db.class.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpaypm/func/common.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpaypm/func/secureUtil.php';
file_put_contents('./post.txt',var_export($_POST,true));
//订单编号
// echo "<pre>";
// $db=new Connection();
// $query = $db->query("select * from `twotree_order_goods` where `order_id` = 1");
// $goods = $db->fetch_assoc($query);
// // var_dump($goods);
// foreach($goods as $v){
// 	$query = $db->query("select distinct o.id from `twotree_order_goods` g INNER JOIN `twotree_order_info` as o on  g.order_id=o.id and o.is_yuyue=1 and o.user_id={$v[user_id]} and o.order_status != 7 where g.goods_id={$v[goods_id]}");
// 	// $query = $db->query("select * from `twotree_order_goods` as g where g.goods_id={$v[goods_id]} (inner join `twotree_order_info` as o on g.order_id=o.id and o.is_yuyue=1 and o.user_id={$v[user_id]} and o.order_status != 7)");
// 	$yuyue = $db->fetch_assoc($query);
// 	foreach($yuyue as $vv){
// 		$query = $db->query("update `twotree_order_info` set order_status=7 where id={$vv[id]} and user_id={$v[user_id]}");
// 	}
// }

// die;


$order_sn=$_POST['orderId'];

$total_fee=$_POST['txnAmt']/100;

// 判断是否支付成功

$respCode = $_POST ['respCode']; //判断respCode=00或A6即可认为交易成功

if($respCode!="00" && $respCode!="A6"){
	//  进入表示支付失败，不返还任何东西，应该在 取消订单 的时候返还
	/*
		这里处理积分和优惠券
		积分：order表中的consjifen     购物时使用的积分，购买失败，返还给用户
			将积分加到wechat_user中
		优惠券：order表中的couponsid   优惠券id   
			将my_coupons中对应id的数据status变为1
	*/
	// $score = $order["return_score"];
	// $userid = $order["user_id"];
	// $db->query("update `twotree_wechat_user` set jifen = jifen+$score where id = $userid");

	// // 得到优惠券id
	// $couponsid = $order["couponsid"];
	// $db->query("update `twotree_my_coupons` set status=1 where id = $couponsid");
	die();
}


// $order_sn="AUX20161015094107703";


$db=new Connection();
$type = mb_substr($order_sn,0,1,'utf-8');
$order_sn = mb_substr($order_sn,1,30,'utf-8');
if($type==1){
    $query=$db->query("select * from `app_order_pmding` where order_no='$order_sn'");
}elseif($type==2){
    $query=$db->query("select * from `app_ruzhu` where pay_order='$order_sn'");
}else{
    $query=$db->query("select * from `app_order_pm` where order_no='$order_sn'");
}
$order=$db->get_one($query);

// var_dump($query);
// var_dump($order);

/*if($order["order_status"]!=1){
	die;
}*/
if($order["pay_status"]!=0){
	die;
}
file_put_contents('./postjie.txt',var_export($order,true));
//file_put_contents('sql1.txt',"select * from `twotree_order_info` where order_sn='$order_sn'");

$time=time();
//付款金额【单位元】

// $total_fee=1;

//更新订单信息
/*
	更新订单状态
	1.is_valid   => 1      设置订单为有效
	2.pay_way    => 3      设置支付方式为银联支付
	3.pay_status => 1      设置订单为已支付
	4.pay_time   => time() 设置完成支付的时间
	5.pay_price  => 	   设置为订单的总金额
*/
if($type==1){
    $db->query("update `app_order_pmding` set order_status=1,pay_way=2,pay_status=1,pay_time=$time,pay_price=$total_fee where order_no='$order_sn'");
}elseif($type==2){
    $db->query("update `app_ruzhu` set pay_type=2,pay_status=1,pay_endtime=$time where pay_order='$order_sn'");
}else{
    $db->query("update `app_order_pm` set order_status=2,pay_way=2,pay_status=1,pay_time=$time,pay_price=$total_fee where order_no='$order_sn'");
}





/*
	这里处理积分和优惠券
	积分：order表中的return_score  购物后返利的积分
		将积分加到wechat_user中的jifen_dongjie中并写入记录
	优惠券：order表中的couponsid   优惠券id
		将my_coupons中对应id的数据status变为1
*/


//$score = $order["return_score"];
/*if($order['source']!=3){//手机下单
	$que='select * from twotree_jifen_config where id=1';
	$querys=$db->query($que);
	$jifenConfig=$db->get_one($querys);
	$mobile_jifne=$jifenConfig['mobile_jifen'];//手机下单送积分
	$res2=$db->query("insert into `twotree_jifen_water` (`user_id`,`type`,`amount`,`way`,`way_name`,`posttime`,`right_time`,`is_true`,`order_id`) values('$userid','1','$mobile_jifne','buy','手机下单','".time()."','".(time()+30*24*3600)."','1','$order[id]')");
	$score = $order["return_score"]-$mobile_jifne;
}*/
$userid = $order["user_id"];

/*if($score){
// 记入用户积分表
$res1=$db->query("insert into `twotree_jifen_water` (`user_id`,`type`,`amount`,`way`,`way_name`,`posttime`,`right_time`,`is_true`,`order_id`) values('$userid','1','$score','buy','购买获得','".time()."','".
	(time()+30*24*3600)."','1','$order[id]')");

}*/



/* $score = $order["return_score"];
$userid = $order["user_id"];
$res=$db->query("update `twotree_wechat_user` set jifen_dongjie = jifen_dongjie+$score where id = $userid");
if($res){
// 记入用户积分表
	$res1=$db->query("insert into `twotree_jifen_water` (`user_id`,`type`,`amount`,`way`,`way_name`,`posttime`,`right_time`,`is_true`,`order_id`) values('$userid','1','$score','buy','购买获得','".time()."','".
		(time()+30*24*3600)."','1','$order[id]')");

} */



/*
	储存值进入server组
*/
$_SESSION['service_id'] = 4;



/*
	这里触发自动发货
*/
/*$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	$isSecure = true;
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
	$isSecure = true;
}
$REQUEST_PROTOCOL = $isSecure ? 'https' : 'http';
$res = file_get_contents($REQUEST_PROTOCOL.'://'.$_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'].'Admin/admin/index.php?g=Service&m=Order&a=autoShipment&order_sn='.$out_trade_no);*/





//file_put_contents('sql2.txt',"update `twotree_order_info` set pay_way=3,pay_status=1,pay_time=$time,pay_money=$total_fee where order_sn='$order_sn'");
?>
<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>响应页面</title>

<style type="text/css">
body table tr td {
	font-size: 14px;
	word-wrap: break-word;
	word-break: break-all;
	empty-cells: show;
}
</style>
</head>
<body>
	<table width="800px" border="1" align="center">
		<tr>
			<th colspan="2" align="center">响应结果</th>
		</tr>
	
			<?php
			foreach ( $_POST as $key => $val ) {
				?>
			<tr>
			<td width='30%'><?php echo isset($mpi_arr[$key]) ?$mpi_arr[$key] : $key ;?></td>
			<td><?php echo $val ;?></td>
		</tr>
			<?php }?>
			<tr>
			<td width='30%'>验证签名</td>
			<td><?php			
			if (isset ( $_POST ['signature'] )) {
				
				echo verify ( $_POST ) ? '验签成功' : '验签失败';
				$orderId = $_POST ['orderId']; //其他字段也可用类似方式获取
			} else {
				echo '签名为空';
			}
			?></td>
		</tr>
	</table>
</body>
</html>
