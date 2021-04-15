<?php namespace Home\Controller;

use Think\Controller;

class IndexController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 24:00:00');
        //$map['start'] = array('egt',strtotime($start));
        //$map['start'] = array('elt',strtotime($end));
        //拍卖场次
        //$num = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1,'start_time'=>array('lt',time()),'end_time'=>array('gt',time())))->order('start_time')->find();
//        $num = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1,'end_time'=>array('gt',time())))->order('start_time')->find();
        $num = M('pm_num')->where(array('is_del'=>0, 'end_time'=>array('gt',time())))->order('start_time')->find();
        $this->assign('num',$num);

        $map['is_shang']=1;
        $map['num_id']=$num['id'];
        $res = M('pm')->where(array('is_del' => 0,'is_shang'=>1,'end'=>array('gt',time())))->order('start')->limit(3)->select();
        if(count($res)<3){
            $limit = 3-count($res);
            if($limit!=3){
                $id = array_column($res,'id');
                $new_map['id'] = array('notin',$id);
            }
            $new_map['is_shang'] = 1;
            $new_map['is_del'] = 0;
            $new_res = M('pm')->where($new_map)->order('end desc')->limit($limit)->select();
        }

        if($new_res && $res){
            $res = array_merge($res,$new_res);
        }elseif($new_res){
            $res = $new_res;
        }
        //$res = M('pm')->where($map)->limit(3)->select();
        $this->assign('res',$res);
        //dump($res);


        $res1 = M('goods')->where(array('is_del'=>0,'is_sale'=>1,'store'=>1,'cstore'=>0,'is_show'=>1,'activity_id'=>0))->order('sort desc,id desc')->limit(6)->select();
        foreach($res1 as $k=>$v){
            if($res1[$k]['promulgator'] != 0){
                $res3 = M('apply')->where(array('id'=>$res1[$k]['promulgator']))->field('logo_pic,name')->find();
                $res1[$k]['logo_pic'] = $res3['logo_pic'];
                $res1[$k]['name'] = $res3['name'];
            }
        }
        $this->assign('res1',$res1);

        // 活动商品
        $activity = M('Activities')->where(array('is_del'=>0))
            ->where(array('started_at'=>array('elt',date("Y-m-d H:i:s" )), 'expired_at'=>array('egt', date("Y-m-d H:i:s"))))
            ->order('started_at desc')
            ->limit(1)
            ->select();
//        dd($activity);
//        $activity_goods = M('goods')->where(array('is_del'=>0,'is_sale'=>1,'store'=>1,'cstore'=>0,'is_show'=>1,'activity_id'=>$activity[0]['id']))
//            ->order('sort desc,id desc')
//            ->limit(6)
//            ->select();

        $activity_goods = M('Goods')->where(array('is_del'=>0,'activity_id'=>$activity[0]['id']))->order('sort desc')->limit(3)->select();
        foreach ($activity_goods as $key=>$value) {
            if ($activity[0]['type'] == 2) {
//                if ($value['price'] >= $activity['amount']) {
//                    $value['zhehoujia'] = bcsub($value['price'], $activity['discount_amount']);
//                } else {
//                    $value['zhehoujia'] = $value['price']
//                }
                $activity_goods[$key]['zhehoujia'] = bcdiv(bcmul($value['price'], $activity[0]['discount']), 100);
            }
        }
//        dd($activity_goods);
        $activity[0]['expired_at'] = strtotime($activity[0]['expired_at']);
        $this->assign('activity', $activity[0]);
        $this->assign('activity_goods', $activity_goods);

        $art['type'] = 0;
        $art['ruzhu_status'] = 5;
        $art['shenhe']  = 2;
        $art['is_show']  = 1;
        $res2 = M('apply')
            ->where($art)->limit(4)->order('sorting desc')->select();
        /*$art['a.art_cate'] = array('in','2,3,4,5');
        $art['a.shenhe']  = 1;
        $art['a.school_id']  = array('neq','');
        $res2 = M('artist')->alias('a')
            ->join('app_school_cate as b on a.school_id=b.id')
            ->field('a.*,b.name')
            ->where($art)->limit(3)->select();*/
        $this->assign('res2',$res2);

        $news = M('news')->where(array('status'=>0,'shenhe'=>1,'is_show'=>1))->limit(4)->order('addtime desc')->select();
        $this->assign('news',$news);

        $banner = M('banner')->where(array('type'=>1,'isdel'=>0))->select();
        $this->assign('banner',$banner);
        $this->display();
    }
    public function contact(){
        if (IS_AJAX){
            $foot_res = M('touch')->find();
            $this->ajaxReturn(array('status'=>1, 'info'=>$foot_res));
        }
        $res = M('touch')->find();
        $this->assign('res',$res);

        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $this->display();
    }

    public function addLiuyan(){
        if (IS_AJAX){
            $data = I('post.');
            /*if ($data['sex']=='男'){
                $data['sex']=1;
            }else{
                $data['sex']=2;
            }*/
            $res = M('liuyan')->add($data);
            if ($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"留言成功！"));
            }
            $this->ajaxReturn(array('status'=>0,'info'=>"留言失败！"));

        }
    }

    public function cloud(){
        if(IS_AJAX){
            $id = I('post.id');
            $res = M('yun_gift')->where(array('id'=>$id))->find();
            $order_no = 'YUN' . date('YmdHis', time()) . rand(1111, 9999);
            $data['gift_id'] = $id;
            $data['user_id'] = $_SESSION['member_id'];
            $data['total_fee'] = $res['price'];
            $data['order_time'] = time();
            $data['order_status'] = 1;
            $data['total_price'] = $res['price'];
            $data['order_no'] = $order_no;
            $res1 = M('gift_order')->add($data);
            if(!$res1){
                $this->ajaxReturn(array('status'=>0,'info'=>'下单失败!'));
            }else{
                $this->ajaxReturn(array('status'=>1,'info'=>'下单成功!'));
            }
        }
        $artist = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($artist['ruzhu_status']==5){
            $art = 1;
        }else{
            $art = 0;
        }
        $this->assign('art',$art);
        //$level = M('yun_apply')->where(array('id'=>))->getField('level');
        $rule = M('yun_rule')->getField('content');
        $gift = M('yun_gift')->select();
        //print_r($rule);exit;
        $step = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('shenhe');
        $user = M('member')->where(array('id'=>$_SESSION['member_id']))->getField('yun_level');
        $ruzhu = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('ruzhu_status');
        //dump($_SESSION['member_id']);exit;
        $this->assign('user',$user);
        $this->assign('step',$step);
        $this->assign('rule',$rule);
        $this->assign('ruzhu',$ruzhu);
        $this->assign('gift',$gift);
        $this->display();
    }

    public function yunIdentity(){
        if(IS_AJAX){
            $data = I('post.');
            $date['name'] = $data['name'];
            $date['tel'] = $data['tel'];
            $date['f_card'] = $data['cardID'];
            $date['address'] = $data['address'];
            $date['f_zpic'] = $data['pic1'];
            $date['f_fpic'] = $data['pic2'];
            $date['s_province'] = $data['province'];
            $date['s_city'] = $data['city'];
            $date['s_county'] = $data['district'];
            $date['addtime'] = time();
            $date['shenhe'] = 1;
            $date['user_id'] = $_SESSION['member_id'];
            $data['level'] = $data['level'];
            //$date['ruzhu_status'] = 3;]
            $user = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
            if($user){
                $res = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->save($date);
            }else{
                $res = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->add($date);
            }
           // $res = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->add($date);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'上传成功,请等待审核!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败,请重新上传!'));
            }
        }
        $this->display();
    }

    public function yunAudit()
    {
        $member_id =$_SESSION['member_id'];

        $res = M('yun_apply')->where(array('user_id'=>$member_id))->find();
        //dump($member_id);exit;
        //$res = M('artist')->where(array('member_id'=>$member_id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    public function pay(){
        $id = I('get.id');
        $userId = $_SESSION['member_id'];
        if(!$userId){
            $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
        }
        $res = M('yun_gift')->where(array('id'=>$id))->find();
        $info = M('gift_order')->where(array('gift_id'=>$res['id'],'user_id'=>$userId))->find();
        $res['order_no'] = $info['order_no'];
        //dump($info);exit;
       /* $order_no = 'YUN' . date('YmdHis', time()) . rand(1111, 9999);
        $data['gift_id'] = $id;
        $data['user_id'] = $_SESSION['member_id'];
        $data['total_fee'] = $res['price'];
        $data['order_time'] = time();
        $data['order_status'] = 1;
        $data['total_price'] = $res['price'];
        $data['order_no'] = $order_no;
        $res1 = M('gift_order')->add($data);
        if(!$res1){
            $this->error('下单失败!','/Home/Index/cloud');
        }*/
        //dump($res);exit;

        $this->assign('res',$res);
        $this->display();
    }

    //礼包支付
    public function PayOrder(){
        if(IS_AJAX){
            $order_no = I('post.order_no');
            $userId = $_SESSION['member_id'];
            if(!$userId){
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }

            $order = M("gift_order")->where(array('user_id'=>$userId,'order_no'=>$order_no,'order_status'=>1))->find();
            //print_r($userId);
            //print_r($order_no);exit;
            if(!$order){
                $this->ajaxReturn(array('status' => 0, 'info' => '订单无法支付'));
            }
            $pay_way = $_POST['pay_way'];
            switch ($pay_way) {
                case "1";
                    $this->ajaxReturn(array('info'=>'请支付','url'=>"/Home/Pm/alipay/style/libao/type/1/order_no/".$order_no,'status'=>1));
                    break;
                case "3";
                    $url = $this->wx_pay($order_no,'YU');
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 3, "order_id" => $order_no, 'url' => $url));
                    break;
                case "2";
                    //$this->ajaxReturn(array("status" => 0, "info" => "在线支付暂无开通!"));
                    $this->ajaxReturn(array("status" => 2,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpayzc/pay.php?order_no={$order_no}"));
                    break;
                case "4";
                    //$this->ajaxReturn(array("status" => 0, "info" => "余额支付暂无开通!"));
                    $this->balance($order_no,'YU');
                    break;
                default:
                    $this->ajaxReturn(array("status" => 0, 'info' => "无效的支付方式！"));
                    break;
            }
        }
    }

    /*
    *礼包支付同步
    */
    public function ReturnLURL(){

        $arr = $_GET;
        log_result("./ReturnURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $result = $alipaySevice->check($arr);
        if ($result) {
            //验证成功
            ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
            $total_amount = htmlspecialchars($_GET['total_amount']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            //验证订单
            $m = M("gift_order");
            $order = $m->where(array("order_no" => $out_trade_no,'pay_status'=>1))->find();

            if ($order) {
                $this->redirect('/Home/Shop/link');
            } else {
                $this->order_error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->order_error("订单支付失败！");
        }
    }
    /*
    *礼包支付异步
    */
    public function NotifyLURl(){
        $arr = $_POST;
        log_result("./NotifyURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);
        if ($result) {
            //验证成功
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //订单的资金总额
            $total_amount = $_POST['total_amount'];
            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
                $m = M("gift_order");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
                $info = M('yun_gift')->where(array('id'=>$order['gift_id']))->find();
                $info2 = M('yun_right')->where(array('level'=>$info['level']))->find();
                $data3['level'] = $info['level'];
                $data3['nums'] = $info2['num'];
                $data3['shenhe'] = 2;
                $data3['ruzhu_status'] = 3;
                $data3['user_id'] = $_SESSION['member_id'];
                $data3['addtime'] = time();
                $res1 = M('yun_apply')->add($data3);
                $member = M('member')->where(array('id'=>$order['user_id']))->save(array('yun_level'=>$info['level'],'user_type'=>1));
                $total_fee = $order['total_fee'];
                if($order['pay_status'] == 0){
                    $r_data['pay_type'] = 1;
                    $r_data['pay_status'] = 1;
                    $r_data['pay_price'] = $total_fee;
                    $r_data['order_status'] = 2;
                    $r_data['pay_time'] = time();

                    $m->where(array('id' => $order['id']))->save($r_data);
                    $data_w['user_id']=$order['user_id'];
                    $data_w['type']=2;
                    $data_w['posttime']=time();
                    $data_w['order_id']=$order['id'];
                    $data_w['cate']=0;
                    $data_w['expend']=$total_amount;
                    $data_w['way_name']="礼包支付";
                    M('money_water')->add($data_w);
                }
            }
            //2.记录流水账

            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////

            echo "success";    //请不要修改或删除

        } else {
            //验证失败
            echo "fail";
        }
    }

    /** 20170713 wzz
     *电脑支付配置
     **/
    protected  function alipay_config($style = '')
    {
        if($style == 'baoding'){

            $returnUrl = 'http://msw.unohacha.com/Home/Pm/ReturnBURL';
            $notufyUrl = 'http://msw.unohacha.com/Home/Pm/NotifyBURl';
        }else if($style == 'ruzhu'){
            $returnUrl = 'http://msw.unohacha.com/Home/Pm/ReturnRURL';
            $notufyUrl = 'http://msw.unohacha.com/Home/Pm/NotifyRURl';
        }else if($style == 'pm'){
            $returnUrl = 'http://msw.unohacha.com/Home/Pm/ReturnPURL';
            $notufyUrl = 'http://msw.unohacha.com/Home/Pm/NotifyPURl';
        }
        $alipay_config = array(
            //APPID 即创建应用后生成       更新5-1
            'app_id' => "2015122301028610",
            //同步跳转地址，公网可以访问   更新5-2
            //'return_url' => "http://msw.unohacha.com/Home/CrowedPay/ReturnURL",
            'return_url' => $returnUrl,
            //异步通知地址，公网可以访问   更新5-3
            //'notify_url' => "http://msw.unohacha.com/Home/CrowedPay/NotifyURL",
            'notify_url' => $notufyUrl ,
            //开发者私钥，由开发者自己生成 更新5-4 https://openhome.alipay.com/platform/keyManage.htm
            'merchant_private_key' => "MIIEpAIBAAKCAQEA3gocNFZmdhg1K3QcgTeKoPadg87+d+n/XWo7rqYxQG06w/4pGCUfV7xRTElTA1R0neWYWAMT7TUNZ4sYFEN9ioUGoin22pbinjXGGAwN5ShqyTNeBeJYK67UsMM06mjrOD5FYrf7GMOjkkD8GBqIAm7f23Th6j36GkFMm4Z9AA0ixPQTCAiWVhXEMG20/SamnYsgd1mvDP3y0LBQlCDZ1/Hczl1QxPfZd4rY/gGhYUGe87vvXmU1PUG4KIBM00vwStUml/JQcr90/7KziB1Akio5vzwkbWzbY474IFFBIb9D62yIWqjg0hdFLnIFtnwZMEhciR3w60+5BK9PVVY4uwIDAQABAoIBADcEjE6Pph3XC72zrKh8CbauxQL3FGjEK4mLHDS/a27KYghUfvxDnouP1xkvBgnKMIc7b89HG/Xn8mVYuuOygXYEVktyWH97abXIH0iwG/VPWX53YvHUTwKr9HnENOVsj/REwc6fRfGx8GL6BT03vcHUlVV8lcoEB2fgDEpxPaH4KO2QysWNr7qaN8vAj+vM8eqqpL6/n9iTLQ+bTu5m2y5Decih4WrCj+D4GvAxha4Ts0dCO4mDQrtTFP9EhQcdmenUrly+gP9tuhxZN7/9TQYRcok6nsjwen9YXOEvHYTU5jsKTcA2nejjEqaAdaTYqsb8Y6HjYj8eejkv2G7fpxECgYEA/MPfOdng8Y0QU1k3Nje6rLZcmVQQSh2ybWnxJwOhb1r4pGvBm0a2SeFuIi3b7b7xhhG5WIik+s0vRgnTkyLqcqMLMuYDHQvR6BDwaritPpLwH5rQv6r5VjB/loZRy8ZK7ZQKYYisnOTE/lPR9v/6MU5gRhPTODMIin+7Hxaw7TkCgYEA4OGSlLGbonKRyTePWWNGJVMc0V3ksmoJhVNx9H1pBWuDCG2Fx5y+uJjnGbcG8nZCxUS8ODhojtTvtiNhUaoo4UfGCg7mXGgZTeeo4t+ojg8UIbLVbO66yOksisUVF48nzK/AOMidkOGn6rudXARtMnhIHYw+qNpRaFE+wrefCZMCgYEAh2XdE740ku//iMZHnxFnO9FL9Q5k027o/1c6yK1XMrFGc70NLsJIL3dEaaarIsWf1zNzV4uK5JY49omY/j473ECeZRt1G4ATZv576o8WrmhDnIpvu9w4SAUes2EsO73ysSUWEn0GCd058QqxdGBWg0b6p09DW91qe9ZERDkBeXECgYB2vgU1KJcibtaV5hV2QJowaTNlRevVXXJLiSU50OKcbwmQcKxcG2MFfA9DH8a2TkWxfjrYgMiM6tjsVsAza+MMGWbztqxijMEXxsQBj9GjuUiLBq/1RhUwsxbG64vYlcmRJhgco6m3b7/HjWtoxBmYtbR2jbAkXqrvpz65eFWsqwKBgQCFr8ARaCgXYb0ih7nsriNMj4zTMNfN5wR8cNhYe4khuKtwnw2YhngKQJQwH3mdK7CrINC59bjZXiCo7UC6aAvY8Qu8/cnlXytFmHmr1NKkPXsmYKMlTVQ09nlv5n7EDaha7LwSvi5XUJs70l+W/iJgXY4CQcGaUjKoJTH28X+Qxg==",
            //支付宝公钥，由支付宝生成 更新5-5 https://openhome.alipay.com/platform/keyManage.htm
            'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmPjlstEsSTWqspVb9pJa+vxqvNm1T6R1VNEzFEsQ6IOj2eAD9keP6EoZNklfLDJpXPFHu4jb/31nW/F76Joao8cEERqbb9ehNzOQcc/l7wRCgvKdG8IaUTpuqbvshF5uBrUhJu5A7nVCBeVMny4cc6kmxQlgMF2m05iKQPmznXnmrVwQuP0SbYuNKFeHmAY96t1YMjufpbiKpmsfIkDNGROGAx5wUwzWnE/WW+6Rm2ntlhrMuXYlwaOL9KJoQSeyETj0G3sWuTxEjIAw+yLeJF2sdZ1XTApMpLQ+EPP5HX+o0XJMxeAiS4zXSOPxuYYHFHq3EoNVM5wNYvMG1T7WlQIDAQAB",
            //编码格式
            'charset' => "UTF-8",
            //签名方式
            'sign_type' => "RSA2",
            //支付宝网关
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        );
        return $alipay_config;
    }
   /* public function cloud()
    {
		$yun = M('yunrecomm')->where(array('is_del'=>0))->select();
		$array=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		foreach($yun as $key => $val){
			$yun[$key]['zm'] = $array[$key];
			if($key > 25){
			$yun[$key]['zm'] = "ZM";
			}
		}
        $res = M('banner')->where(array('type'=>7,'isdel'=>0))->select();
		//print_r($yun);
        $this->assign('res',$res);
        $this->assign('yun',$yun);
        $this->display();
    }*/

    public function novice()
    {
        $cate = M('footer_cate')->select();
        foreach ($cate as $k=>$v){
            $footer = M('footer_service')->where(array('cate'=>$v['id'],'is_show'=>0))->select();
//
            $cate[$k]['title'] = $footer;
        }
        $this->assign('cate',$cate);


        $res = M('footer_service')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);


        $this->assign('id',$_GET['id']);
        $this->display();
    }

    public function payment()
    {
        $this->display();
    }

    public function free()
    {
        $this->display();
    }

    public function credit()
    {
        $this->display();
    }

    public function bigMoney()
    {
        $this->display();
    }

    public function ensure()
    {
        $this->display();
    }

    public function promise()
    {
        $this->display();
    }

    public function bond()
    {
        $this->display();
    }

    public function join()
    {   
        $key = '';
        if(I('get.key')){
            $key = I('get.key');
            $this->assign('key',$key);
        }
        $res = M('join')->where(array('is_del'=>0,'join_status'=>1,'name'=>array('like',"%".$key."%")))->order('join_time desc')->select();
        //print_r($res);
        $this->assign('res',$res);
        $this->display();
    }

    public function jobDetails()
    {
        if(IS_AJAX){
            if(!$_SESSION['member_id']){

                $this->ajaxReturn(array('status'=>2,'info'=>'请登录！'));
            }
            $data = I('post.');
            if(!$data['zhid']){
                $this->ajaxReturn(array('status'=>0,'info'=>'请重新选择岗位！'));
            }
            if(!$data['pic']){
                $this->ajaxReturn(array('status'=>0,'info'=>'请上传简历！'));
            }
            $res1= M('join')->where(array('is_del'=>0,'join_status'=>1))->find($data['zhid']);
            if(!$res1){
                $this->ajaxReturn(array('status'=>0,'info'=>'请重新选择岗位！'));
            }
            $count = M('resume')->where(array('member_id'=> $_SESSION['member_id'],'join_id'=>$data['zhid']))->count();
            if($count > 0){

                $this->ajaxReturn(array('status'=>0,'info'=>'一个职位只能投递一次！'));
            }
            $datar['member_id'] = $_SESSION['member_id'];
            $datar['join_pic'] = $data['pic'];
            $datar['join_id'] = $data['zhid'];
            $datar['addtime'] = time();

            $resume = M('resume')->add($datar);
            if($resume){

                $this->ajaxReturn(array('status'=>1,'info'=>'投递简历成功！'));
            }
        }
        if(I('get.id')){
            $id = I('get.id');
        }
        $res = M('join')->where(array('is_del'=>0,'join_status'=>1))->find($id);
        //print_r($res);
        $this->assign('res',$res);
        $this->display();
    }

    public function addVisitLog()
    {
        $date = date("Y-m-d");
        $log = M('visitLog')->where(array('date' => $date))->find();
        if ($log) {
            $result = M('visitLog')->where(array('date' => $date))->setInc('visit_num');

            exit;
        } else {
            $data['date'] = $date;
            $data['visit_num'] = 1;

            $result = M('visitLog')->add($data);
        }
        exit;
    }
}

