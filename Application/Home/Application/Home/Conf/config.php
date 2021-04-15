<?php
return array(
	//'配置项'=>'配置值'

        'MODULE_ALLOW_LIST' => array('home'),
        'DEFAULT_MODULE'     => 'Home', //默认模块
        'URL_MODEL'          => '2', //URL模式
        'SESSION_AUTO_START' => true, //是否开启session
		'URL_CASE_INSENSITIVE' =>false, //忽略url大小写
  		// 'TMPL_CACHE_ON'      => true,
		'URL_HTML_SUFFIX'       => '',
        'URL_ROUTER_ON'   => true,
        'URL_MAP_RULES'=>array(
            'zhuce'         => 'Home/User/zhuce',
            'login'         => 'Home/User/login',
            'logout'         => 'Home/User/logout',
            'forget'        => 'Home/User/forget',
            'shopcar'       => 'Home/PersonalCenter/shopcar',
            'news'          => 'Home/News/index',
            'hall'          => 'Home/goods/hall',
            'contest'       => 'Home/News/Contest',
            'video'         => 'Home/News/video',
            'recommend'     => 'Home/News/recommend',
            'artwork'       => 'Home/Artwork/index',
            'ArtCommunity'  => 'Home/ArtCommunity/index',
            'artist'        => 'Home/ArtCommunity/artistList',//artist1
            'inherit'       => 'Home/ArtCommunity/inherit',
            'association'   => 'Home/ArtCommunity/association',
            'comic'         => 'Home/ArtCommunity/comic',
            'game'          => 'Home/ArtCommunity/game',
            'exhibition'    => 'Home/ArtCommunity/exhibition',
            'train'         => 'Home/ArtCommunity/train',
            'crowdFunding'  => 'Home/ArtCommunity/crowdFunding',
            //'auction'       => 'Home/Auction/index',
            'result'        => 'Home/Auction/result',
            'timeLimit'     => 'Home/Auction/timeLimit',
            //'welfare'       => 'Home/Auction/welfare',
            'welfare'       => 'Home/Pm/paimaiW',
            'products'      => 'Home/Products/index',
            'personality'   => 'Home/Products/personality',
            'cloud'         => 'Home/Index/cloud',
            'auction'         => 'Home/Pm/paimaiS',
            'Auctionpreview'         => 'Home/Pm/paimaiY',
            'Auctionresult'         => 'Home/Pm/result',
            'limitedauction'         => 'Home/Pm/paimaiXS',
            'Gallery'         => 'Home/ArtCommunity/hualang',
            'Newsdot'         => 'Home/News/details',
            'overseas'        => 'Home/ArtCommunity/overseas',
        ),

        'TMPL_PARSE_STRING'  =>array(
            '__JS__'        => '/Public/Home/Js',
            '__CSS__'       => '/Public/Home/Css',
            '__IMAGES__'    => '/Public/Home/Images',
			'__UNOHACHA__'  => '/Public/Home/unohacha',
            '__FONTS__'     => '/Public/Home/Fonts',
            '__IMG__'       => '/Public/Home/Img_1',
            '__JEDATE__'    => '/Public/Home/Jedate',
            '__XZDQ__'      => '/Public/Home/xzdq',
            '__MAP__'       => '/Public/Home/map',
            '__LAYDATE__'   => '/Public/Home/layer',
            '__UEDITOR__' => '/Public/Home/Ueditor',
            '__LHG__' => '/Public/Home/lhgcalendar',
        ),
    );
