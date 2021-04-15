<?php
error_reporting(0);
session_start();
// header ( 'Content-type:text/html;charset=utf-8' );
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpaypm/func/common.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpaypm/func/SDKConfig.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpaypm/func/secureUtil.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionpaypm/func/log.class.php';

//数据库连接
include_once './func/db.class.php';

//订单号
$order_no=$_GET ['order_no'];
$type = $_GET ['type'];


if(!isset($order_no)){
	echo '<h3><center>订单号不能为空</center></h3>';
	exit();
}

$db=new Connection();
if($type==1){
    $query=$db->query("select * from `app_order_pmding` where order_no='$order_no'");
    $order['total_fee'] = $order['baoding'];
}elseif($type==2){
    $query=$db->query("select * from `app_ruzhu` where pay_order='$order_no'");
    $order['total_fee'] = $order['price'];
    $order['order_no'] = $order['pay_order'];
}else{
    $query=$db->query("select * from `app_order_pm` where order_no='$order_no'");
}

$order=$db->get_one($query);

if(empty($order)){
	echo '<h3><center>订单信息不存在</center></h3>';
	exit();
}

/*if($order["user_id"]!=$_SESSION["user_id"]){
	echo "<script>window.history.back()</script>";die;
}*/
if($type==3){
    if($order["order_status"]!=1){
        echo "<script>window.history.back()</script>";die;
    }
}
if($order["pay_status"]!=0){
	echo "<script>window.history.back()</script>";die;
}

if($order['pay_status']==1){
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

	if(is_mobile()){
		// 移动跳转
		if($type==1){
			$url = 'g=Wxin&m=Pm&a=pmxq&id='.$order['goods_id'];
		}elseif($type==2){
			$url = 'g=Wxin&m=PersonalCenter&a=buyerAddPm&tag=buyerAddPm';
		}else{
			$url = 'g=Wxin&m=PersonalCenter&a=buyerXia&tag=buyerXia';
		}
	}else{
		if($type==1){
			$url = 'g=Home&m=Pm&a=pmxq&id='.$order['goods_id'];
		}elseif($type==2){
			$url = 'g=Home&m=PersonalCenter&a=buyerAddPm&tag=buyerAddPm';
		}else{
			$url = 'g=Home&m=PersonalCenter&a=buyerXia&tag=buyerXia';
		}
	}

	header('location:http://'.$_SERVER['HTTP_HOST'].'/index.php?'.$url);die;
}

//如果待支付金额==0,为vip订单修改订单状态为已支付



$total_fee=$order['total_fee']*100;			//单位分
//测试价格
//$total_fee = 100;
$out_trade_no=$type.$order['order_no'];			//商户订单号


/**
 * 消费交易-前台 
 */


/**
 *	以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考
 */
// 初始化日志
$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
$log->LogInfo ( "============处理前台请求开始===============" );
// 初始化日志
$params = array(
		'version' => '5.0.0',				//版本号
		'encoding' => 'utf-8',				//编码方式
		'certId' => getSignCertId (),			//证书ID
		'txnType' => '01',				//交易类型	
		'txnSubType' => '01',				//交易子类
		'bizType' => '000201',				//业务类型
		'frontUrl' =>  SDK_FRONT_NOTIFY_URL,  		//前台通知地址
		'backUrl' => SDK_BACK_NOTIFY_URL,		//后台通知地址	
		'signMethod' => '01',		//签名方法
		'channelType' => '08',		//渠道类型，07-PC，08-手机
		'accessType' => '0',		//接入类型
		'merId' => '310420173990262',		        //商户代码，请改自己的测试商户号
		'orderId' => $out_trade_no,	//商户订单号
		'txnTime' => date('YmdHis'),	//订单发送时间
		'txnAmt' => $total_fee,		//交易金额，单位分
		'currencyCode' => '156',	//交易币种
		'defaultPayType' => '0001',	//默认支付方式	
		//'orderDesc' => '订单描述',  //订单描述，网关支付和wap支付暂时不起作用
		'reqReserved' =>' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
		);


// 签名
sign ( $params );

// 前台请求地址
$front_uri = SDK_FRONT_TRANS_URL;
$log->LogInfo ( "前台请求地址为>" . $front_uri );
// 构造 自动提交的表单
$html_form = create_html ( $params, $front_uri );
echo $html_form;exit;
$log->LogInfo ( "-------前台交易自动提交表单>--begin----" );
$log->LogInfo ( $html_form );
$log->LogInfo ( "-------前台交易自动提交表单>--end-------" );
$log->LogInfo ( "============处理前台请求 结束===========" );
echo $html_form;
