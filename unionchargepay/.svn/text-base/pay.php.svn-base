<?php
error_reporting(0);
session_start();
// header ( 'Content-type:text/html;charset=utf-8' );
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionchargepay/func/common.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionchargepay/func/SDKConfig.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionchargepay/func/secureUtil.php';
include_once $_SERVER ['DOCUMENT_ROOT'] . '/unionchargepay/func/log.class.php';

//数据库连接
include_once './func/db.class.php';

//订单id
$order_id=$_GET ['order_id'];


if(!isset($order_id)){
	echo '<h3><center>充值订单ID不能为空</center></h3>';
	exit();
}
$db=new Connection();
$query=$db->query("select * from `app_money_order` where id=$order_id");
$order=$db->get_one($query);
if(empty($order)){
	echo '<h3><center>充值订单信息不存在</center></h3>';
	exit();
}

/*if($order["user_id"]!=$_SESSION["user_id"]){
	echo "<script>window.history.back()</script>";die;
}*/

if($order["status"]!=0){
	echo "<script>window.history.back()</script>";die;
}

$total_fee=$order['money']*100;			//单位分
//测试价格
//$total_fee = 100;
$out_trade_no=$order['order_no'];			//商户订单号


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
