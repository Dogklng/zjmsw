<?php
// cvn2加密 1：加密 0:不加密
//const SDK_CVN2_ENC = 0;
define('SDK_CVN2_ENC',0);
// 有效期加密 1:加密 0:不加密
//const SDK_DATE_ENC = 0;
define('SDK_DATE_ENC',0);
// 卡号加密 1：加密 0:不加密
//const SDK_PAN_ENC = 0;
define('SDK_PAN_ENC',0);
// ######(以下配置为PM环境：入网测试环境用，生产环境配置见文档说明)#######

//【url为ip地址的为测试地址，域名的为正式地址】

// 签名证书路径
define('SDK_ROOT',$_SERVER['DOCUMENT_ROOT']);

//const SDK_SIGN_CERT_PATH = '/data/www/mally/unionpay/certs/yinlian312.pfx';
//const SDK_SIGN_CERT_PATH='/data/www/mally/unionpay/certs/PM_700000000000001_acp.pfx';
define('SDK_SIGN_CERT_PATH',SDK_ROOT.'/unionpaypm/certs/meishu2017.pfx');
// 签名证书密码
//const SDK_SIGN_CERT_PWD = '312';		//
define('SDK_SIGN_CERT_PWD','069190');

// 密码加密证书（这条用不到的请随便配）verify_sign_acp
//const SDK_ENCRYPT_CERT_PATH = '/data/www/mally/unionpay/certs/312cer.cer';
//define('SDK_ENCRYPT_CERT_PATH',SDK_ROOT.'/unionpay/certs/312cer.cer');

// 验签证书路径（请配到文件夹，不要配到具体文件）
//const SDK_VERIFY_CERT_DIR = '/data/www/mally/unionpay/certs/';
define('SDK_VERIFY_CERT_DIR',SDK_ROOT.'/unionpaypm/certs/');

// 前台请求地址
//const SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';
//const SDK_FRONT_TRANS_URL = 'https://gateway.95516.com/gateway/api/frontTransReq.do';
define('SDK_FRONT_TRANS_URL','https://gateway.95516.com/gateway/api/frontTransReq.do');
// 后台请求地址
//const SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do';
//const SDK_BACK_TRANS_URL = 'https://gateway.95516.com/gateway/api/backTransReq.do';
define('SDK_BACK_TRANS_URL','https://gateway.95516.com/gateway/api/backTransReq.do');
// 批量交易
//const SDK_BATCH_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do';
//const SDK_BATCH_TRANS_URL='https://gateway.95516.com/gateway/api/batchTrans.do';
define('SDK_BATCH_TRANS_URL','https://gateway.95516.com/gateway/api/batchTrans.do');

//单笔查询请求地址
//const SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/queryTrans.do';
//const SDK_SINGLE_QUERY_URL = 'https://gateway.95516.com/gateway/api/queryTrans.do';
define('SDK_SINGLE_QUERY_URL','https://gateway.95516.com/gateway/api/queryTrans.do');
//文件传输请求地址
//const SDK_FILE_QUERY_URL = 'https://101.231.204.80:9080/';
//const SDK_FILE_QUERY_URL = 'https://filedownload.95516.com/';
define('SDK_FILE_QUERY_URL','https://filedownload.95516.com/');

//有卡交易地址
//const SDK_Card_Request_Url = 'https://101.231.204.80:5000/gateway/api/cardTransReq.do';
//const SDK_Card_Request_Url='https://gateway.95516.com/gateway/api/cardTransReq.do';
define('SDK_Card_Request_Url','https://gateway.95516.com/gateway/api/cardTransReq.do');
//App交易地址
//const SDK_App_Request_Url = 'https://101.231.204.80:5000/gateway/api/appTransReq.do';
//const SDK_App_Request_Url = 'https://gateway.95516.com/gateway/api/appTransReq.do';
define('SDK_App_Request_Url','https://gateway.95516.com/gateway/api/appTransReq.do');
// 前台通知地址 (商户自行配置通知地址)
//const SDK_FRONT_NOTIFY_URL = 'http://m.eshopaux.com/unionpay/FrontReceive.php';
define('SDK_FRONT_NOTIFY_URL','http://'.$_SERVER['HTTP_HOST'].'/unionpaypm/FrontReceive.php');
// 后台通知地址 (商户自行配置通知地址)
//const SDK_BACK_NOTIFY_URL = 'http://m.eshopaux.com/unionpay/BackReceive.php';
define('SDK_BACK_NOTIFY_URL','http://'.$_SERVER['HTTP_HOST'].'/unionpaypm/BackReceive.php');

//文件下载目录 
//const SDK_FILE_DOWN_PATH = '/data/www/mally/unionpay/file/';
define('SDK_FILE_DOWN_PATH',SDK_ROOT.'/unionpaypm/file/');

//日志 目录 
//const SDK_LOG_FILE_PATH = '/data/www/mally/unionpay/logs/';
define('SDK_LOG_FILE_PATH',SDK_ROOT.'/unionpaypm/logs/');

//日志级别
//const SDK_LOG_LEVEL = 'INFO';
define('SDK_LOG_LEVEL','INFO');


	
?>