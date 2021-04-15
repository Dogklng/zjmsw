<?php namespace Home\Controller;

use Think\Controller;

class BaseController extends Controller
{
	public $user_info  = "";
	public $user_id    = "";
	public $model_list = array();
	public $url		   = null;
	
	public function __construct()
	{
		parent::__construct();
        if($_SESSION['member_id']>0){
            $user_info = M('member')->where(array("id"=>$_SESSION['member_id'],"status"=>0, "isdel"=>0))->find();
            if($user_info){
                $this->user_info = $user_info;
                $this->user_id   = $_SESSION['member_id'];
            }else{
                session("member_id", null);
                $this->user_info = "";
                $this->user_id   = "";
                $this->redirect( U('Home/Index/Index', '', false));
            }
        }

        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $headimg = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
        $artistid = M('apply')->where(array('user_id'=>$headimg['id']))->getField('series_ids');
        $artists = M('apply')->where(array('user_id'=>$headimg['id']))->find();
        $this->assign('artists',$artists);
        //dump($headimg);exit;
        $this->assign('headimg',$headimg);
        $this->assign('artistid',$artistid);
        $head = M('goods')->where(array('is_del'=>0))->limit(5)->select();
        foreach ($head as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series_id']))->find();
            $head['classname'] = $series[$k]['classname'];
        }
        $this->assign('head',$head);

        $footer_cate = M('footer_cate')->order('sort asc')->select();
        foreach ($footer_cate as $k=>$v){
            $footer = M('footer_service')->where(array('cate'=>$v['id'],'is_show'=>0))->select();
//
            $footer_cate[$k]['title'] = $footer;
        }
        $this->assign('footer_cate',$footer_cate);
        //新闻分类
        $newsCate = M("news_cate")->field('id,name')->order('sort desc')->select();
        $this->assign('newsCate',$newsCate);
        //结束
        
        $m = M('series');
        $resh = $m->where(array('isdel'=>0,'cstores'=>0))->limit(0,5)->select();
        $resc = $m->where(array('isdel'=>0,'cstores'=>1))->limit(0,5)->select();
        //dump($resh);exit;
        //dump($resh);die;
        $this->assign('resh',$resh);//艺术品
        $this->assign('resc',$resc);//创意商店

        $foot_res = M('touch')->find();
        $this->assign('service_tel',$foot_res['service']);//创意商店
        //购物车数量
        $cartnum = M("cart")->where(array('user_id'=>$_SESSION['member_id']))->sum('num');
        $this->assign('cartnum',$cartnum);

        //注册店铺的状况
        $step = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('ruzhu_status');
        $this->assign('step',$step);
        //dump($step);exit;
        //注册类型
        $type = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('type');
        $this->assign('type',$type);

        $shenhe = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('shenhe');
        $this->assign('shenhe',$shenhe);

        $person_name = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('name');
        $this->assign('person_name',$person_name);

        //是否已经注册过发布众筹资格
        $crowd = M('crowd_apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('ruzhu_status');
        $this->assign('crowd',$crowd);

        //dump($type);exit;
        //dump($step);exit;
        //是否入驻拍卖
        $res = M('ruzhu')->where(array('user_id'=>$_SESSION['member_id'],'pay_status'=>1))->find();
        if($res){
            $this->assign('is_ruzhu',1);
        }else{
            $this->assign('is_ruzhu',0);
        }

        //是否成为云推荐
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('shenhe');
        $this->assign('yun',$yun);

        //艺术社区分类
        $person = M('art_cate')->where(array('type'=>0))->select();
        $organize = M('art_cate')->where(array('type'=>1))->select();
        $this->assign('person',$person);
        $this->assign('organize',$organize);

        //获取关键字信息
        $person_name = M('apply')
            ->alias('p')
            ->join('left join app_art_cate q on p.series_ids=q.id')
            ->field('p.name,q.name as cate_name')
            ->where(array('user_id'=>$member_id))->find();
        $this->assign('person_name',$person_name);
        //合作伙伴
        $partner = M('partner')->field('*,url as urla')->order('sort asc')->limit(6)->select();
        //dump($partner);exit;
        $this->assign('partner',$partner);
        $is_Mobile = isMobile();
        if($is_Mobile && (MODULE_NAME=='Home' || MODULE_NAME=='home')){
            $controller = CONTROLLER_NAME;
            $action = ACTION_NAME;
            $this->redirect(U('/Wxin/'.$controller.'/'.$action,$_GET));
        }

	}

    //上传图片
	public function addImage() {
		$data = $this->uploadImg();
		$this->ajaxReturn($data);
	}

	//上传图片处理
	public function uploadImg() {
		$upload = new \Think\UploadFile;
		//$upload->maxSize  = 5242880 ;// 设置附件上传大小
		//$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','svg');// 设置附件上传类型
		$savepath='./Uploads/Picture/uploads/'.date('Ymd').'/';
		if (!file_exists($savepath)){
			mkdir($savepath);
		}
		$upload->savePath =  $savepath;				// 设置附件上传目录
		if (!$upload->upload()) {					// 上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		} else {									// 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
		}
		return $info;
	}


    /**
     * 检测用户登录的方法
     */
    public function checkLogin(){
        if($_SESSION['member_id']>0){
            if($this->user_info['status']){
                unset($_SESSION);
                if(IS_AJAX){
                    $this->ajaxReturn(array('status'=>0, "info"=>"您未登录！"));
                }
                $this->redirect("Home/Index/index");
            }
        }else{
            if(IS_AJAX){
                $this->ajaxReturn(array('status'=>0, "info"=>"您未登录！"));
            }
            $this->redirect("Home/Index/index");
        }
    }


    /**
     * 获取手机短信验证码
     */
    public function sendmessage($code_type,$phone)
    {
        header("Content-Type: text/html; charset=UTF-8");
        if (empty($phone) || empty($code_type)) {
            return array("status"=>strval("0"),"info"=>"缺少发送验证码方式");
        }
        if (!in_array($code_type,array('1','2'))) {
            return array("status"=>strval("0"),"info"=>"获取验证码方式错误");
        }
        $over_time  = C('over_time');
        $code       = $this->randInt(6);
        switch($code_type)
        {
            case 1:
                $msg = "（注册验证）验证码".$code.",您正在注册（浙江美术网）会员,感谢您的支持！有效期".$over_time."秒！";
                break;

            case 2:
                $msg = "（忘记密码）验证码".$code."，您正在修改（浙江美术网）登陆密码，请妥善保管验证码！有效期".$over_time."秒！";
                break;
        }
        /*$post_data = array();
        $post_data['account'] = $config['account'];   //帐号
        $post_data['pswd'] = $config['pswd'];  //密码
        $post_data['msg'] =$msg; //短信内容需要用urlencode编码下
        $post_data['mobile'] = $phone; //手机号码， 多个用英文状态下的 , 隔开
        $post_data['product'] = ''; //产品ID  不需要填写
        $post_data['needstatus']='false'; //是否需要状态报告，需要true，不需要false
        $post_data['extrno']='';  //扩展码   不用填写
        $post_data['resptype']='json';  //扩展码   不用填写
        $url='http://116.62.64.214/msg/HttpBatchSendSM';
        $o='';
        foreach ($post_data as $k=>$v)
        {
           $o.="$k=".urlencode($v).'&';
        }
        $post_data=substr($o,0,-1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果需要将结果直接返回到变量里，那加上这句。
        $result = curl_exec($ch);
        $arr=json_decode($result,true);*/
        $arr['result'] = 0;
        if($arr['result'] == 0){
            //保存数据库
            $db=M('user_verify');
            $data['telephone']  = $phone;
            $data['code']       = $code;
            $data['msg']        = $msg;
            $data['create_at']  = NOW_TIME;
            $data['code_type']  = $code_type;
            $data['status']     = 0;
            $db->add($data);
            return array("status"=>1,"info"=>"短信发送成功,请查收！");
        }else{
            return array("status"=>0,"info"=>"短信发送失败，请重试！");
        }
    }



    /**
     * 验证手机短信验证码
     */
    public function checkMessage($phone, $identify, $code_type)
    {
        $over_time  = C('over_time');
        $now_time   = NOW_TIME;
        $data = array();
        $data['telephone']  = $phone;
        $data['status']     = 0;
        $data['code_type']  = $code_type;
        $res    = M("user_verify")->where($data)->order('create_at desc')->limit(1)->find();
        $time   = $res['create_at'];
        if ($now_time < ($time+$over_time)) {
            $code = $res['code'];


            if ($code == $identify) { // 验证码正确,修改验证码状态
                M("user_verify")->where(array('id'=>$res['id']))->save(array("status"=>1));
                return array("status"=>strval("1"),"info"=>"success");
            } else { // 验证码错误
                return array("status"=>strval("0"),"info"=>"验证码有误");
            }
        } else { //验证码过期
            M("user_verify")->where(array('id'=>$res['id']))->save(array("status"=>2));
            return array("status"=>strval("0"),"info"=>"验证码已过期");
        }
    }

    //随机数
    protected function randInt($int = 6, $caps = false) {
        $strings = '0123456789';
        $return = '';
        for ($i = 0; $i < $int; $i++) {
            srand();
            $rnd = mt_rand(0, 9);
            $return = $return . $strings[$rnd];
        }
        return $caps ? strtoupper($return) : $return;
    }


	/**
	 * 获取快递价格
	 */
	public function count_express()
	{
		//省份名字
		$province = I("province");
		$province = rtrim($province, '省');
		$province = rtrim($province, '市');
		$province = rtrim($province, '自治区');
        $province = mb_substr($province,0,2,"utf-8");
		$regin 	  		 = M("Region");				//省份表
		$frei_link_regin = M("Frei_link_region");	//中间表
		$frei_config	 = M("Freight_config");		//规则表
		
		//根据省份获取id
		$regin_id = $regin->where(array("region_name" => array("like","%$province%")) )->field("id")->find();
	
		if ($regin_id) {
			//根据省份id获取中间表对应规则表id
			$frei_id     =  $frei_link_regin->where(array("region_id" => $regin_id['id'] ))->field("freight_id")->find();	
		}
		if ($frei_id) {
			//根据对应规则id获取价格规则
			$frei_result = $frei_config->where(array("id" => $frei_id['freight_id']))->field("first_price,next_price")->find();
		}
		if ($frei_result) {
			$this->ajaxReturn(array("status" => 1, "info" => $frei_result['first_price']));
		} else {
			$this->ajaxReturn(array("status" => 0));
		}
	}

	/**
    * Json方式 查询订单物流轨迹
    */
     public function getOrderTracesByJson($express,$LogisticCode){

        //jaw 2016-12-28
        //
        // $name = array(
        //     '顺丰快递'=>'SF',
        //     '申通快递'=>'STO',
        //     '韵达快递'=>'YD',
        //     '圆通速递'=>'YTO',
        //     '天天快递'=>'HHTT',
        //     '德邦'=>'DBL',
        //     'EMS'=>'EMS',
        //     '中通快递'=>'ZTO'
        // );
        $ShipperCode = $express;
        $LogisticCode = $LogisticCode;

        $EBusinessID = '1265531';
        $AppKey = '2fac2b65-0f6e-4738-abcb-52ff176ca90a';
        $ReqURL = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

        $requestData= "{'OrderCode':'','ShipperCode':'".$ShipperCode."','LogisticCode':'".$LogisticCode."'}";
        $datas = array(
            'EBusinessID' => $EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = self::encrypt($requestData, $AppKey);
        $result=self::sendPost($ReqURL, $datas);

        //根据公司业务处理返回的信息......

        return $result;
    }


    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
   	public  function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }


    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    public  function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if($url_info['port']=='')
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }


	/**
     * 发送系统通知的方法
     * @param int     $userid    接受消息者的id
     * @param string  $msg       需要推送的消息
     * @param array   $data 	 需要修改的参数
     */
    public function sendSystemMessage($userid,$title, $msg, $data=array()){
        $data["title"]=$title;
        $data["msg"]       = $msg;
        $data['user_id']   = $userid;
        $data['create_at'] = time();
        $res = M("systemMessage")->add($data);
        if($res){
            return true;
        }else{
            return false;
        }
    }



    

    /**
     * 支付宝支付配置
     */
    protected function alipay_config($type = 0){
        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
        $config = M('setpay')->where(array('pay_type'=>2))->find();
        $alipay_config['partner']		= $config['hzsf_id'];
        //$alipay_config['partner']		= '2088621448707894';

        //收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
        $alipay_config['seller_id']	= $alipay_config['partner'];

        //收款支付宝帐户
        $alipay_config['seller_email']	= $config['account'];
        //$alipay_config['seller_email']	= 'wearejobear@163.com';

        // MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
        $alipay_config['key']			= $config['key'];
        //$alipay_config['key']			= 'ik88cxdav0xrus1lkunuri8m5d1pruw8';
        if ($type == 0) {//充值回调
            // 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
            $alipay_config['notify_url'] = "http://".$_SERVER['HTTP_HOST']."/Home/Pay/alipayNotify";

            // 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
            $alipay_config['return_url'] = "http://".$_SERVER['HTTP_HOST']."/Home/Pay/alipayCallBack";
        } elseif ($type == 1) {//购物回调
            // 服务器异步通知页面路径  需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
            $alipay_config['notify_url'] = "http://".$_SERVER['HTTP_HOST']."/Home/Pay/aliShoppingNotify";

            // 页面跳转同步通知页面路径 需http://格式的完整路径，不能加?id=123这类自定义参数，必须外网可以正常访问
            $alipay_config['return_url'] = "http://".$_SERVER['HTTP_HOST']."/Home/Pay/aliShoppingCallBack";
        }
        //签名方式
        $alipay_config['sign_type']    = strtoupper('MD5');

        //字符编码格式 目前支持 gbk 或 utf-8
        $alipay_config['input_charset']= strtolower('utf-8');

        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        $alipay_config['cacert']    = getcwd().'\\cacert.pem';

        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'http';

        // 支付类型 ，无需修改
        $alipay_config['payment_type'] = "1";

        // 产品类型，无需修改
        $alipay_config['service'] = "create_direct_pay_by_user";

        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        //↓↓↓↓↓↓↓↓↓↓ 请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        // 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
        $alipay_config['anti_phishing_key'] = "";
        // 客户端的IP地址 非局域网的外网IP地址，如：221.0.0.1
        $alipay_config['exter_invoke_ip']   = "";
        //↑↑↑↑↑↑↑↑↑↑请在这里配置防钓鱼信息，如果没开通防钓鱼功能，为空即可 ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
        return $alipay_config;
    }
    /**
     * 得到sku介绍的字符串
     */
    public function getSkuDes($skuid){
        if(!$skuid){
            return "";
        }
        $sku_l_m = M("sku_list");
        $sku_a_m = M("sku_attr");
        $skuids  = $sku_l_m->find($skuid);
        if(!$skuids){
            return "";
        }
        $sku_arr = array_filter(explode("-", $skuids['attr_list']));
        $str     = "";
        foreach($sku_arr as $v){
            $sku_info = $sku_a_m->where(array("id"=>$v))->find();
            $sku_pname = $sku_a_m->where(array("id"=>$sku_info['pid']))->getField('classname');
            $str .= $sku_pname.":".$sku_info['classname']."<br>";
        }
        return trim($str, "<br>");
    }
    /**
     * 判断一数组是否包含另一数组 zj  20170909
     */
    public function Is_Contain($a,$b)
    {
        $flag = 1;
        foreach ($a as $va)
        {
            if (in_array($va, $b)) {
                continue;
            }else {
                $flag = 0;
                break;
            }
        }
        return $flag;
    }

    /**
     *微信支付
     */
    public function wx_pay($order_res,$type)
    {
        if($type=='YU'){
            $m = M('gift_order');
        }else{
            $m = M('order_crowd');
        }
        $data_m['order_no'] = $order_res;
        $data_m['order_status'] = 1;
        $info = $m->where($data_m)->find();
        if (!$info) {
            return false;
        } else {
            $total_fee = $info['total_fee'];
            if($type=='YU'){
                // $total_fee    = 0.01;
                $or_g = M('yun_gift');
                $o_g_r = $or_g->where(array('id' => $info['gift_id']))->find();
                $o_g_r['goods_name'] = $o_g_r['name'];
            }else{
                // $total_fee    = 0.01;
                $or_g = M('crowd');
                $o_g_r = $or_g->where(array('id' => $info['crowd_id']))->find();
            }

            //===========测试数据=============
            $money = $total_fee * 100;
            $money = 1;
            //===========测试数据=============
            Vendor('WxPayPubHelper.WxPayApi');
            Vendor('WxPayPubHelper.WxPayNativePay');
            Vendor('WxPayPubHelper.log');
            $notify = new \WxPayNativePay();
            $input = new \WxPayUnifiedOrder();

            $input->SetBody("浙江美术网");
            $input->SetAttach($info['order_no']);
            $input->SetOut_trade_no($info['order_no']);
            $input->SetTotal_fee($money);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetGoods_tag($o_g_r['goods_name']);
            $input->SetNotify_url("http://" . $_SERVER['HTTP_HOST'] . "/Home/Pay/weixin_payzc");
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id($info['order_no']);
            $result = $notify->GetPayUrl($input);
            if ($result['error'] != "") {
                return $result;
            }
            $url = $result["code_url"];
            return $url;
        }
    }

    /**
     *微信支付  查询订单是否支付成功
     */
    public function order_status()
    {
        if (IS_POST) {
            $order_no = I('post.order_id');
            $header = mb_substr($order_no,0,2,'utf-8');
            if($header=='YU'){
                $m = M("gift_order");
            }else{
                $m = M("order_crowd");
            }
            $res = $m->where(array('order_no' => $order_no))->find();
            if ($res['order_status'] > 1) {
                if($header=='YU'){
                    $url = '/Home/Shop/link';
                }else{
                    $url = '/Home/ArtCommunity/crowdFdot/id/'.$res['crowd_id'];
                }

                $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
            }
        }
    }

    public function balance($order_no,$type){
        if($type=='YU'){
            $m = M('gift_order');
        }else{
            $m = M('order_crowd');
        }

        $data_m['order_no'] = $order_no;
        $data_m['order_status'] = 1;
        $info = $m->where($data_m)->find();
        if (!$info) {
            $this->ajaxReturn(array("status" => 0, 'info' => "无此订单！"));
        }

        if ($info['pay_status'] != 0) {
            $this->ajaxReturn(array("status" => 0, 'info' => "无此订单！"));
        }
        $total_fee = $info['total_fee'];
        $member = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
        if($member['wallet']<$total_fee){
            $this->ajaxReturn(array('info'=>"余额不足",'status'=>0));die;
        }
        //dump($_SESSION['member_id']);exit;
        M()->startTrans();
        $res = M('member')->where(array('id'=>$_SESSION['member_id']))->save(array('wallet'=>($member['wallet']-$total_fee)));
        if(!$res){
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }

        $data_w['user_id']=$_SESSION['member_id'];
        $data_w['type']=2;
        $data_w['posttime']=time();
        $data_w['order_id']=$info['id'];
        $data_w['cate']=0;
        $data_w['wallet']=$total_fee;
        if($type=='YU'){
            $data_w['way_name']="礼包支付";
        }else{
            $data_w['way_name']="众筹支付";
        }

        $res1 = M('money_water')->add($data_w);
        if(!$res1){
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }
        $order = $m->where(array("order_no" => $order_no))->find();
        $total_fee = $order['total_fee'];
        $data = array(
            "pay_status" => 1,
            "order_status" => 2,
            "pay_price" => $total_fee,
            "pay_way" => 4,//余额
            "pay_time" => time(),
        );

        if($type=='YU'){
            $info = M('yun_gift')->where(array('id'=>$order['gift_id']))->find();
            $info2 = M('yun_right')->where(array('level'=>$info['level']))->find();
            $data3['level'] = $info['level'];
            $data3['nums'] = $info2['num'];
            $data3['shenhe'] = 2;
            $data3['ruzhu_status'] = 3;
            $data3['user_id'] = $_SESSION['member_id'];
            $data3['addtime'] = time();
            $res4 = M('yun_apply')->add($data3);
            $yun = M('member')->where(array('id'=>$order['user_id']))->setField(array('yun_level'=>$info['level'],'user_type'=>1));
            if(!$res4){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
        }

        $res3 = $m->where(array('id' => $order['id']))->save($data);
        if (!$res3) {
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }
        M()->commit();
        if($type=='YU'){
            $url = "/Home/Shop/link";
        }else{
            $url = "/Home/ArtCommunity/crowdFdot/id/".$order['crowd_id'];
        }
        $this->ajaxReturn(array('info'=>$url,'status'=>4));
    }
	
}

