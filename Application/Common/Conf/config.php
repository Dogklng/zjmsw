<?php
//return array(
//	//'配置项'=>'配置值'
//);
function J($str){
    return str_replace('./', '', str_replace('//', '/', $str));
}
return array(
    'MODULE_ALLOW_LIST' => array('Home','Admin','Wxin'),
    'DEFAULT_MODULE'     => 'Home', //默认模块
    'URL_MODEL'          => '2', //URL模式
    'SESSION_AUTO_START' => true, //是否开启session
    'URL_CASE_INSENSITIVE' =>true, //忽略url大小写
    'URL_ROUTER_ON'      => "on",
    //更多配置参数


    // 多个伪静态后缀设置 用|分割
//    'URL_HTML_SUFFIX' => 'html|shtml|xml',

    //数据库配置
    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',     // 数据库类型
    ///'DB_HOST'               => '120.27.199.103', // 服务器地址
  	///'DB_NAME'               => 'meishu',    // 数据库名
  	///'DB_USER'               => 'root',      // 用户名
  	///'DB_PWD'                => 'ARKJ6N674bjVtX7G',      // 密码  	
//	'DB_HOST'               => '127.0.0.1', // 服务器地址
//  	'DB_HOST'               => 'localhost', // 服务器地址
  	'DB_HOST'               => '47.99.120.25', // 服务器地址
    'DB_NAME'               => 'meishu',    // 数据库名
//    'DB_USER'               => 'root',      // 用户名
    'DB_USER'               => 'meishu',      // 用户名
  	'DB_PWD'                => '123456z...',      // 密码
//  	'DB_PWD'                => '',      // 密码
    'DB_PORT'               => '3306',      // 端口
    'DB_PREFIX'             => 'app_',       // 数据库表前缀
    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
    'DB_FIELDS_CACHE'       => false,       // 启用字段缓存
    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
    'DB_DEPLOY_TYPE'        => 0, 			// 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'DB_RW_SEPARATE'        => false,       // 数据库读写是否分离 主从式有效
    'DB_MASTER_NUM'         => 1, 			// 读写分离后 主服务器数量
    'DB_SLAVE_NO'           => '', 			// 指定从服务器序号
    'DB_SQL_BUILD_CACHE'    => false, 		// 数据库查询的SQL创建缓存
    'DB_SQL_BUILD_QUEUE'    => 'file',   	// SQL缓存队列的缓存方式 支持 file xcache和apc
    'DB_SQL_BUILD_LENGTH'   => 20000, 		// SQL缓存的队列长度
    'DB_SQL_LOG'            => false, 		// SQL执行日志记录


    "over_time"             => 120, // 验证码过期时间
	'MESSFGE'				=>array(//短信配置
			'account'		=>'sanhu',//账号
			'pswd'			=>'84CF9E913A88B459A05A0DD5CE86'//密码
	),
	
	
	
);
