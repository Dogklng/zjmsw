<?php
error_reporting(0);
/*
	判断是否为移动设备
*/
function is_mobile()
{ 
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    } 
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    { 
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    } 
    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
            ); 
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        } 
    } 
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    { 
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        } 
    } 
    return false;
}
include_once './func/db.class.php';

$out_trade_no = $_POST['orderId']?$_POST['orderId']:$_GET["orderId"];
$db=new Connection();
$header = mb_substr($out_trade_no,0,2,'utf-8');
if($header=='YU'){
    $query=$db->query("select * from `app_gift_order` where order_no='$out_trade_no'");
}else{
    $query=$db->query("select * from `app_order_crowd` where order_no='$out_trade_no'");
}
$order=$db->get_one($query);

if(is_mobile()){
	// 移动跳转到订单详情  待完成
    if($header=='YU'){
        $url = 'g=Wxin&m=Shop&a=link';
    }else{
        $url = 'g=Wxin&m=ArtCommunity&a=crowdFdot&id='.$order['crowd_id'];
    }
    //header("location:/index.php?g=Home&m=Orderlist&a=complete&order_id=$order[id]");

    header('location:/index.php?'.$url);
}else{

	// pc跳转到支付完成页面
    if($header=='YU'){
        $url = 'g=Home&m=Shop&a=link';
    }else{
        $url = 'g=Home&m=ArtCommunity&a=crowdFdot&id='.$order['crowd_id'];
    }
	//header("location:/index.php?g=Home&m=Orderlist&a=complete&order_id=$order[id]");

    header('location:/index.php?'.$url);
}
die;












//数据库连接
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpayzc/func/common.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpayzc/func/secureUtil.php';
//file_put_contents('front.log',var_export($_POST,true));
//重定向到订单列表
header("location:/index.php?m=User&a=index");
// header("location:/index.php?g=Weixin&m=Ucenter&a=order_list");	
?>
<!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>银联在线交易测试-结果</title>
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
			<th colspan="2" align="center">银联在线交易测试-交易结果</th>
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