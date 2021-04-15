<?php namespace Wxin\Controller;

use Think\Controller;

class ArtCommunityController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',1);
    }

    public function hualang()
    {
        $id = I('get.id');
        $style = I('get.style');
        if($id){
            $map['series_ids'] = $id;
        }else{
            $map['series_ids'] = 13;
            $id = 13;
        }
        if($style){
            $map['style'] = $style;
        }
        //$map['series_ids'] = $id;
        //$res = M('gallery')->where(array('id'=>$_GET['id']))->find();
        //$this->assign('res',$res);
        //M('apply')->where(array('id'=>$_GET['id']))->setInc('browser',1);
        M('apply')->where($map)->setInc('browser',1);
        //print_r($id);exit;
        $name = M('art_cate')->where(array('id'=>$id))->getField('name');
        $count = M('apply')
            ->where($map)
            ->where(array('shenhe'=>2))->count();
        $Page  = getpage($count,10);
        $res = M('apply')
            ->where($map)
            ->where(array('shenhe'=>2))
            ->order('addtime desc')->limit($Page->firstRow,$Page->listRows)->select();

        $slogan = M('slogan')->getField('content');
        $this->assign('slogan',$slogan);
        //$level = M('artist_level')->select();
        //$this->assign('level',$level);
        //dump($res);exit;
        //dump($res);exit;
        $this->assign('res',$res);
        $this->assign('name',$name);
        $this->img();
		//dump($res);exit;
        $this->display();
    }

    public function get_hualang(){
        if (IS_AJAX) {
            $id = I('post.id');
            $style = I('post.style');
            $p = I("post.p");
            $_GET['p'] = $p;
            if($id){
                $map['series_ids'] = $id;
            }else{
                $map['series_ids'] = 13;
                $id = 13;
            }
            if($style){
                $map['style'] = $style;
            }

            M('apply')->where($map)->setInc('browser',1);
            $count = M('apply')
                ->where($map)
                ->where(array('shenhe'=>2))->count();
            $Page  = getpage($count,10);
            $res = M('apply')
                ->where($map)
                ->where(array('shenhe'=>2))
                ->order('addtime desc')->limit($Page->firstRow,$Page->listRows)->select();
            if($res){
                $str = '';
                foreach($res as $k=>$v){

                    $str .= '<div class="list_cont_item">';
                    $str .= '<a href="/Wxin/ArtCommunity/hualangList?id='.$v['id'].'&type='.$id.'">';
                    $str .= '<div class="contant">';
                    $str .= '<div class="contant_one"> <img src="'.$v['gallery_index'].'" width="100%" />';
                    $str .= '<div class="contant-shade"> <img src="'.$v['logo_pic'].'" /> </div>';
                    $str .= '</div><div class="contant-text">';
                    $str .= '<h3>'.$v['artist_name'].'</h3>';
                    $str .= '<p>'.htmlspecialchars_decode(stripslashes($v['detail'])).'</p>';
                    $str .= '</div></div> </a> </div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    public function img(){
        $images = M('banner')->where(array('type'=>4,'isdel'=>0))->find();
        $this->assign('images',$images);
    }
	
	public function hualangList(){
        $type = I('get.type');
        if ($type==''){
            $map['series_ids'] = 13;
        }else{
            $map['series_ids'] = $type;
        }

        $name = M('art_cate')->where(array('id'=>$type))->getField('name');
        M('apply')->where(array('id'=>$_GET['id']))->setInc('browser',1);
        //$id = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->getField('id');
        $id = $_GET['id'];
        $member_id = $_SESSION['member_id'];
		$this->assign('member_id',$member_id);
		$res = M('apply')->where($map)->where(array('shenhe'=>2,'id'=>$_GET['id'],'is_del'=>0))->find();
		$res1 = M('goods')->where(array('promulgator'=>$id,'shenhe'=>1,'is_del'=>0,'is_buy'=>0))->select();
		$num = M('goods')->where(array('promulgator'=>$id,'shenhe'=>1,'is_del'=>0,'is_buy'=>0))->count();
		$this->assign('num',$num);
		$this->assign('name',$name);
		$this->assign('res',$res);
		$this->assign('res1',$res1);
        //dump($res1);exit;
		$this->display();
	}
	
	public function lease(){
		$this->display();
	}
	
	public function buy(){
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $id=I('get.id');
        M("gallery_goods")->where(array('id'=>$id))->setInc('browser',1);
        $res1 = M('gallery_slide')->where(array('goods_id'=>$id,'status'=>1))->field('pic')->select();
        $this->assign('goods_slide',$res1);
        $res = M('gallery_goods')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $rel = M('gallery_goods')->where(array('auth'=>$res['auth']))->limit(4)->select();
        $this->assign('rel',$rel);
        /*$cate = M('cate')->where(array('is_show'=>1,'is_del'=>0))->select();
        $this->assign('cate',$cate);*/

        $like = M('gallery_goods')->where(array('is_del'=>0))->limit(4)->select();
        $this->assign('like',$like);

        /*$count = M('goods_collect')->where(array('good_id'=>$id))->count();
        $this->assign('count',$count);
        $this->assign('is_groom',$res['is_groom']);

        $like_collect =  M('goods_collect')->where(array('user_id'=>$_SESSION['member_id'],'good_id'=>$id))->count();
        $this->assign('like_collect',$like_collect);

        $recommend = M('recommend')->where(array('user_id'=>$_SESSION['member_id'],'good_id'=>$id))->count();
        $this->assign('recommend',$recommend);

        $count1 = M('recommend')->where(array('good_id'=>$id))->count();
        $this->assign('count1',$count1);*/
        $this->display();
    }

    public function galleryShop(){
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $id = I('get.id');
        //dump($id);exit;
        $res1 = M('gallery_goods')->where(array('gallery_id'=>$id))->select();
        $res = M('gallery')->where(array('id'=>$id))->find();
        $this->assign('res1',$res1);       
        $this->assign('res',$res);
        $num = M('gallery_goods')->where(array('gallery_id'=>$id))->count();
        $this->assign('num',$num);
        //dump($res1);exit;
        $this->display();
    }

    public function pay(){
        if(IS_POST){
            $post_data = json_decode($_POST['post_data'], true);
            //dump($post_data);exit;
            $goods_id = $post_data['id'];
            $user_id  = $post_data['member_id'];
            $total_fee    = $post_data['price'];
            $total_price = M('crowd')->where(array('id'=>$goods_id))->getField('total_price');
            //dump($total_price);exit;
            $order_no = 'ZC' . date('YmdHis', time()) . rand(1111, 9999);
            $data['user_id'] = $user_id;
            $data['crowd_id'] = $goods_id;
            $data['order_no'] = $order_no;
            $data['total_fee'] = $total_fee;
            $data['total_price'] = $total_price;
            $data['order_status']  = 1;
            $data['pay_way'] = 1;
            $data['order_time'] = time();
            $res = M('order_crowd')->add($data);
            //dump($res);exit;
        }

        if(empty($_GET['id'])){
            $result = M('order_crowd')->alias('a')->join('app_crowd b on a.crowd_id=b.id ')->where(array('a.id'=>$res))->find();
        }else{
            $result = M('order_crowd')->alias('a')->join('app_crowd b on a.crowd_id=b.id ')->where(array('a.id'=>$_GET['id']))->find();
        }
		//dump($data);exit;

        $this->assign('goods_id',$result['crowd_id']);
        $this->assign('user_id',$result['user_id']);
        $this->assign('price',$result['total_fee']);
        $this->assign('order_no',$result['order_no']);
		$this->assign('res',$result);
        $this->display();
    }

    public function PayOrder(){
        if(IS_AJAX){
            $order_no = $_POST['order_no'];
            $userId = $_SESSION['member_id'];
            if(!$userId){
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $order = M("order_crowd")->where(array('user_id'=>$userId,'order_no'=>$order_no,'order_status'=>1))->find();
            if(!$order){
                $this->ajaxReturn(array('status' => 0, 'info' => '订单无法支付'));
            }
            $pay_way = $_POST['pay_way'];
            switch ($pay_way) {
                case "1";
                    $this->ajaxReturn(array('status'=>1,'info'=>$order_no));
                    break;
                case "3";
                    $url = $this->wx_pay($order_no);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = 'http://paysdk.weixin.qq.com/example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 3, "order_id" => $order_no, 'url' => $url));
                    break;
                case "2";
                    //$this->ajaxReturn(array("status" => 0, "info" => "在线支付暂无开通!"));
                    $this->ajaxReturn(array("status" => 2,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpayzc/pay.php?order_no={$order_no}"));
                    break;
                case "4";
                    //$this->ajaxReturn(array("status" => 0, "info" => "余额支付暂无开通!"));
                    $this->balance($order_no);
                    break;
                default:
                    $this->ajaxReturn(array("status" => 0, 'info' => "无效的支付方式！"));
                    break;
            }
        }
    }

    public function balance($order_no){
        $m = M('order_crowd');
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
        $data_w['way_name']="众筹支付";
        $res1 = M('money_water')->add($data_w);
        if(!$res1){
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }


        $m = M("order_crowd");
        $order = $m->where(array("order_no" => $order_no))->find();
        $total_fee = $order['total_fee'];
        $data = array(
            "pay_status" => 1,
            "order_status" => 2,
            "pay_price" => $total_fee,
            "pay_way" => 4,//余额
            "pay_time" => time(),
        );
        $res3 = $m->where(array('id' => $order['id']))->save($data);
        if (!$res3) {
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }

        /*$crowd_id = M('order_crowd')->where(array('order_no'=>$order_no))->getField('crowd_id');
        $money = M('order_crowd')->where(array('crowd_id'=>$crowd_id))->sum('total_fee');
        if($money>)*/
        M()->commit();
        $this->ajaxReturn(array('info'=>"/Wxin/ArtCommunity/crowdFdot/id/".$order['crowd_id'],'status'=>4));
    }
    /**
     *微信支付
     */
    public function wx_pay($order_res)
    {
        $m = M('order_crowd');
        $data_m['order_no'] = $order_res;
        $data_m['order_status'] = 1;
        $info = $m->where($data_m)->find();
        if (!$info) {
            return false;
        } else {
            $total_fee = $info['total_fee'];
            // $total_fee    = 0.01;
            $or_g = M('crowd');
            $o_g_r = $or_g->where(array('id' => $info['crowd_id']))->find();
            //===========测试数据=============
            $money = $total_fee * 100;
            //$money = 1;
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
            $input->SetNotify_url("http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pay/weixin_payzc");
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
            $id = I('post.order_id');
            $order = M('order_crowd');
            $res = $order->where(array('order_no' => $id))->find();
            if ($res['order_status'] > 1) {
                $url = '/Wxin/ArtCommunity/crowdFdot/id/'.$res['crowd_id'];
                $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
            }
        }
    }

    public function artist()
    {

        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $name = M('art_cate')->where(array('id'=>$_GET['id']))->getField('name');
        $this->assign('name',$name);
        //dump($name);exit;
        $level = M('artist_level')->select();
        $this->assign('level',$level);

        $res = M('artist')->where(array('shenhe'=>1,'art_cate'=>$_GET['id']))->select();
        M('artist')->where(array('id'=>$_GET['id']))->setInc('browser',1);

        $count =count($res);
        $ArrayObj = new \Org\Util\Arraypage($count,10);
        $page =  $ArrayObj->showpage();//分页显示
        $res = $ArrayObj->page_array($res,0);//数组分页
        $this->assign('page',$page);
        $slogan = M('slogan')->getField('content');
        $this->assign('slogan',$slogan);
        $this->assign('res',$res);


        $this->img();
        $this->display();
    }

    public function artList(){
        $res = M('art')->where(array('person_cate'=>$_GET['id']))->select();
        $this->assign('res',$res);
        $person_cate = M('person_cate')->select();
        $this->assign('person_cate',$person_cate);
        $name = M('person_cate')->where(array('id'=>$_GET['id']))->getField('name');
        $this->assign('name',$name);


        $this->img();
        $this->display();
    }

    public function inherit()
    {
        $this->display();
    }

    public function association()
    {
        $res = M('school_cate')->select();
        //dump($res);
        $this->assign('res',$res);

        $map = 
        $this->img();
        $this->display();
    }

    public function comic()
    {
        $this->img();
        $this->display();
    }

    public function game()
    {
       $game =  M('game')->select();
       $this->assign('game',$game);

        $this->img();
        $this->display();
    }

    public function exhibition()
    {
        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }


        $res = M('art_show')->where(array('is_sale'=>1,'status'=>2,'end'=>array('gt',time())))->find();
        if($res){
            $res['content'] = html_entity_decode($res['content']);
        }
        $this->assign('res',$res);

        $show = M('art_show')->where(array('is_sale'=>1,'status'=>2))->order('start desc')->select();
        $count =count($show);
        $ArrayObj = new \Org\Util\Arraypage($count,10);
        $page =  $ArrayObj->showpage();//分页显示
        $show = $ArrayObj->page_array($show,0);//数组分页
        $this->assign('page',$page);
        $this->assign('show',$show);

        $this->img();
        $this->display();
    }

    public function detail(){
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $res = M('art_show')->where(array('id'=>$_GET['id']))->find();

        $this->assign('res',$res);
        $this->display();
    }

    public function train()
    {
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }

        $count = M('art_train')->where(array('is_sale'=>1,'type'=>1))->count();
        $Page  = getpage($count,10);
        $res = M('art_train')->where(array('is_sale'=>1,'type'=>1))->order('start desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('res',$res);

        $this->display();
    }

    public function get_train(){
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $count = M('art_train')->where(array('is_sale'=>1,'type'=>1))->count();
            $Page  = getpage($count,10);
            $res = M('art_train')->where(array('is_sale'=>1,'type'=>1))->order('start desc')->limit($Page->firstRow,$Page->listRows)->select();
            if($res){
                $str = '';
                foreach($res as $k=>$v){

                    $str .= '<li><a href="/Wxin/ArtCommunity/traindot?id='.$v['id'].'">';
                    $str .= '<div class="CraUl-img"><img src="'.$v['logo'].'" /></div>';
                    $str .= '<div class="CraUl-txt"><h2>'.$v['title'].'</h2>';
                    $str .= '<span> <i class="fa fa-clock-o"></i>时间：'.date('Y-m-d',$v['start']).'——'.date('Y-m-d',$v['end']).'</span>';
                    $str .= '<span> <i class="fa fa-map-marker" style=" font-size:16px;">';
                    $str .= '</i>地点：'.$v['address'].'</span> </div>';
                    $str .= '</a><h3 class="peixunH peixunH3">';
                    $str .= '<a href="/Wxin/ArtCommunity/traindot?id='.$v['id'].'">';
                    $str .= '<i class="fa fa-plus-square"></i>查看详情</a></h3>';
                    $str .= '<h4 class="peixunH peixunH4">';
                    $str .= '<a href="javascript:;" id="'.$v['id'].'" onclick="myFunction(this)">';
                    $str .= '<i class="fa fa-user-plus"></i>我要报名</a></h4></li>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }

    public function addTrain(){
        $train = M('art_train')->where(array('id'=>$_POST['train_id']))->find();
        if ($train['end']<time()){
            if($train['type']==1){
                $this->ajaxReturn(array('status'=>0,'info'=>"该培训已结束！"));die;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"该交流已结束！"));die;
            }

        }
        $res = M('tel_train')->where(array('user_id'=>$_SESSION['member_id'],'train_id'=>$_POST['train_id']))->find();
        if($res != null){
            $this->ajaxReturn(array('status'=>1,'info'=>"您已提交短信通知"));
        }
        $data = I('post.');
        $data['user_id'] = $_SESSION['member_id'];
        $data['addtime'] = time();
        $res = M('tel_train')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"短信通知添加成功"));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"短信通知添加失败"));
        }
    }

    //观展
    public function addgtrain(){
        $train = M('art_show')->where(array('id'=>$_POST['show_id']))->find();
        if ($train['end']<time()){

            $this->ajaxReturn(array('status'=>0,'info'=>"该展览已结束！"));die;


        }
        $res = M('tel_gtrain')->where(array('user_id'=>$_SESSION['member_id'],'show_id'=>$_POST['show_id']))->find();
        if($res != null){
            $this->ajaxReturn(array('status'=>1,'info'=>"您已提交短信通知"));
        }
        $data = I('post.');
        $data['user_id'] = $_SESSION['member_id'];
        $data['addtime'] = time();
        $res = M('tel_gtrain')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"短信通知添加成功"));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"短信通知添加失败"));
        }
    }

    public function crowdFunding()
    {
        $cate = M('crowd_cate')->where(array('is_sale1'=>1,'shenhe'=>1))->group('name')->select();
        $this->assign('cate',$_GET['cate']);
        $this->assign('cate',$cate);
        if($_GET['cate'] == ''){
            $count = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->count();
            $Page  = getpage($count,10);
            $res = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->limit($Page->firstRow,$Page->listRows)->select();
            $time1 = NOW_TIME;
            foreach ($res as $k=>$v){
                $d_time                 = $v['end'];
                $del_time               = $d_time-$time1;
                $day                    = floor($del_time/86400);
                $shi                    = floor($del_time/86400%3600);
                $res[$k]['day']        = $day;
                $res[$k]['shi']        = $shi;
                
                $order_crowd = M('order_crowd')->where(array('crowd_id'=>$v['id'],'pay_status'=>1))->Sum('total_fee');
                $res[$k]['width'] = $order_crowd/$res[$k]['total_price']/100;
                $res[$k]['width'] = $res[$k]['width']."%";
                $res[$k]['price'] = $order_crowd;
            }
        }else{
            $cates = I('get.cate');
            if (!$cates =='' && !$cates==null){
                $map['cate_id'] = array('in',$cates);
            }
            $this->assign('cates',$cates);
            $count = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->where($map)->count();
            $Page  = getpage($count,10);
            $res = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->where($map)->limit($Page->firstRow,$Page->listRows)->select();
            $time1 = NOW_TIME;
            foreach ($res as $k=>$v){
                $d_time                 = $v['end'];
                $del_time               = $d_time-$time1;
                $day                    = floor($del_time/86400);
                $shi                    = floor($del_time/86400%3600);
                $res[$k]['day']        = $day;
                $res[$k]['shi']        = $shi;

                $order_crowd = M('order_crowd')->where(array('crowd_id'=>$v['id'],'pay_status'=>1))->Sum('total_fee');
                $res[$k]['width'] = $order_crowd/$res[$k]['total_price']/100;
                $res[$k]['width'] = $res[$k]['width']."%";
                $res[$k]['price'] = $order_crowd;
            }


        }
        $this->assign('res',$res);

        $images = M('banner')->where(array('type'=>5,'isdel'=>0))->find();
        $this->assign('images',$images);

        $this->display();
    }

    public function get_crowdFunding(){
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;

            if($_POST['cate'] == ''){
                $count = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->count();
                $Page  = getpage($count,10);
                $res = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->limit($Page->firstRow,$Page->listRows)->select();
                $time1 = NOW_TIME;
                foreach ($res as $k=>$v){
                    $d_time                 = $v['end'];
                    $del_time               = $d_time-$time1;
                    $day                    = floor($del_time/86400);
                    $shi                    = floor($del_time/86400%3600);
                    $res[$k]['day']        = $day;
                    $res[$k]['shi']        = $shi;

                    $order_crowd = M('order_crowd')->where(array('crowd_id'=>$v['id'],'pay_status'=>1))->Sum('total_fee');
                    $res[$k]['width'] = $order_crowd/$res[$k]['total_price']/100;
                    $res[$k]['width'] = $res[$k]['width']."%";
                    $res[$k]['price'] = $order_crowd;
                }
            }else{
                $cates = I('post.cate');
                if (!$cates =='' && !$cates==null){
                    $map['cate_id'] = array('in',$cates);
                }
                $count = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->where($map)->count();
                $Page  = getpage($count,10);
                $res = M('crowd')->where(array('is_sale1'=>1,'shenhe'=>1))->where($map)->limit($Page->firstRow,$Page->listRows)->select();
                $time1 = NOW_TIME;
                foreach ($res as $k=>$v){
                    $d_time                 = $v['end'];
                    $del_time               = $d_time-$time1;
                    $day                    = floor($del_time/86400);
                    $shi                    = floor($del_time/86400%3600);
                    $res[$k]['day']        = $day;
                    $res[$k]['shi']        = $shi;

                    $order_crowd = M('order_crowd')->where(array('crowd_id'=>$v['id'],'pay_status'=>1))->Sum('total_fee');
                    $res[$k]['width'] = $order_crowd/$res[$k]['total_price']/100;
                    $res[$k]['width'] = $res[$k]['width']."%";
                    $res[$k]['price'] = $order_crowd;
                }


            }

            if($res){
                $str = '';
                foreach($res as $k=>$v){

                    $str .= '<li><a href="/Wxin/ArtCommunity/overseasdot?id='.$v['id'].'">';
                    $str .= '<div class="CraUl-img"><img src="'.$v['logo'].'" /></div>';
                    $str .= '<div class="CraUl-txt"><h2>'.$v['title'].'</h2>';
                    $str .= '<span> <i class="fa fa-clock-o"></i>时间：'.date('Y-m-d',$v['start']).'——'.date('Y-m-d',$v['end']).'</span>';
                    $str .= '<span> <i class="fa fa-map-marker" style=" font-size:16px;">';
                    $str .= '</i>地点：'.$v['address'].'</span> </div>';
                    $str .= '</a><h3 class="peixunH peixunH3">';
                    $str .= '<a href="/Wxin/ArtCommunity/overseasdot?id='.$v['id'].'">';
                    $str .= '<i class="fa fa-plus-square"></i>查看详情</a></h3>';
                    $str .= '<h4 class="peixunH peixunH4">';
                    $str .= '<a href="javascript:;" id="'.$v['id'].'" onclick="myFunction(this)">';
                    $str .= '<i class="fa fa-user-plus"></i>我要报名</a></h4></li>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
	public function get_data(){
		if(IS_AJAX){
			$cate_id = I('post.cate');
			$map['is_sale1'] = 1;
			$map['shenhe'] = 1;
			$map['cate'] = $cate_id;
			$crowd = M('crowd')->where($map)->select();
			//dump($crowd);exit;
			$this->ajaxReturn(array('status'=>1,'crowd'=>$crowd));
		}
	}

/*    public function gallery()
    {
        $res = M('hualang')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        M("hualang")->where(array('id'=>$_GET['id']))->setInc('browser',1);
        $res1 = M('hualang')->where(array('is_sale'=>1))->select();
        $this->assign('res1',$res1);
        $this->display();
    }*/

    public function designerdot()
    {
        $res = M('art')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*public function college()
    {


        $level = M('artist_level')->select();
        $this->assign('level',$level);
   
        if($_GET['level'] != ''){
           
            $res = M('artist')->where(array('shenhe'=>1,'school_id'=>$_GET['id'],'level_id'=>$_GET['level']))->select();
        }else{
            $res = M('artist')->where(array('shenhe'=>1,'school_id'=>$_GET['id']))->select();

        }
        $this->assign('res',$res);

        $this->img();
        $this->display();
    }*/

    public function exhibitors()
    {
        if(IS_POST){
            $user = $_SESSION['member_id'];
            if($user == '' | $user == null){
                $this->ajaxReturn(array('status'=>0,'info'=>"请先登录！"));die;
                //$this->error("请先登录！",U('Home/User/login'));
            }
            $m      = M("cz");
            $cf = $m->where(array('user_id'=>$_SESSION['member_id'],'show_id'=>$_POST['show_id'],'cate'=>$_POST['cate'],'series'=>$_POST['series']))->find();
            if($cf){
                $this->ajaxReturn(array('status'=>0,'info'=>"您已提交过该类型数据！"));die;
                //$this->error("您已提交过该类型数据！",U('Home/ArtCommunity/exhibition'));
            }
            $g_s_m  = M("cz_pic");
            $data   = I("post.");
            $data['user_id'] = $_SESSION['member_id'];
            $slide_pic = $data['pic'];
            unset($data['pic1']);
            $data['create_time'] = NOW_TIME;
            $res = $m->add($data);
            if($res){
                foreach($slide_pic as $k=>$v){
                    $slide_data = array(
                        "cz_id"   => $res,
                        "create_time"  => time(),
                        "pic"        => $v,
                        "status"     => 1,
                    );
                    $g_s_m->add($slide_data);
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"提交失败！"));die;
                //$this->error("提交失败！",U('Home/ArtCommunity/exhibition'));
            }
            $this->ajaxReturn(array('status'=>1,'info'=>"提交成功！"));die;
            //$this->redirect('Home/ArtCommunity/exhibition');
        }
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $series = M('series')->where(array('isdel'=>0,'pid'=>0))->select();
        $this->assign('series',$series);
        $this->display();
    }

    public function upExhibitors()
    {
        if(IS_POST){
            $user = $_SESSION['member_id'];
            if($user == '' | $user == null){
                $this->ajaxReturn(array('status'=>0,'info'=>"请先登录！"));die;
                //$this->error("请先登录！",U('Home/User/login'));
            }
            $m      = M("art_show");
            /*$cf = $m->where(array('user_id'=>$_SESSION['member_id']))->find();
            if($cf){
                $this->ajaxReturn(array('status'=>0,'info'=>"您已提交过该类型数据！"));die;
                //$this->error("您已提交过该类型数据！",U('Home/ArtCommunity/exhibition'));
            }*/
            $data   = I("post.");
            $data['user_id'] = $_SESSION['member_id'];
            $data['create_time'] = NOW_TIME;
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $data['is_sale'] = 0;
            $data['status'] = 1;
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已经提交成功！"));die;
                //$this->error("您的资料已经提交成功",U('Home/ArtCommunity/exhibition'));
            }else{
                $this->ajaxReturn(array('status'=>1,'info'=>"提交失败！"));die;
                //$this->error("提交失败！",U('Home/ArtCommunity/exhibition'));
            }
        }
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $series = M('series')->where(array('isdel'=>0,'pid'=>0))->select();
        $this->assign('series',$series);
        $this->display();
    }

    public function traindot()
    {
        $res = M('art_train')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }

    public function crowdFdot()
    {   
		//判断该众筹作品时间是否超过截止日期
        /*$time = time();
        $data1 = M('crowd')->select();
        foreach($data1 as $k=>$v){
            if($data1[$k]['end']<$time){
                $sql = "update app_crowd set is_sale1=0 where id=".$data1[$k]['id'];
                $res1 = M()->execute($sql);
            }
        }

        //设置展示众筹结束，众筹失败的作品
        $data2 = M('crowd')->where(array('is_sale1'=>0))->select();//获取所有的众筹结束的作品
        //dump($data2);exit;
        foreach($data2 as $k=>$v){
            $res2 = M('order_crowd')->where(array('crowd_id'=>$data2[$k]['id']))->sum('total_fee');
            //遍历获得这些作品的总金额，比较是否为众筹失败，再添加一个字段为is_zc为0时众筹成功，1为众筹失败
            if(($data2[$k]['total_price']*10000) > $res2){
                $sql3 = "update app_crowd set is_zc=1 where id=".$data2[$k]['id'];
                $res3 = M()->execute($sql3);
                $sql5 = "update app_order_crowd set is_refund=0 where id=".$data2[$k]['id'];
                $res5 = M()->execute($sql5);
            }
        }*/
		
        $id = $_GET['id'];
        M('crowd')->where(array('id'=>$id))->setInc('num',1);
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }

        $goods_remind = M('goods_remind')->find();
        $this->assign('goods_remind',$goods_remind);   
        $res = M('crowd')->where(array('id'=>$id))->find();
        $order_crowd = M('order_crowd')->where(array('crowd_id'=>$id,'pay_status'=>1))->sum("total_fee");
        $res['width'] = $order_crowd/$res['total_price']*100;
        $res['width'] = ($res['width']/10000)."%";
        $this->assign('res',$res);
        $now = NOW_TIME;
        $this->assign('now',$now);
        $price =  M('order_crowd')->where(array('crowd_id'=>$id,'pay_status'=>1))->Sum('total_fee');
        $this->assign('price',$price);

        $jilu =  M('order_crowd')->alias('a')->where(array('crowd_id'=>$id,'pay_status'=>1))->join('app_member b ON b.id= a.user_id')->select();
        $this->assign('jilu',$jilu);

        $this->img();
        $this->display();
    }
	
    /*public function artist1(){
        $name = M('art_cate')->where(array('id'=>$_GET['id']))->getField('name');
        $this->assign('name',$name);
        //dump($name);exit;
        $level = M('artist_level')->select();
        $this->assign('level',$level);

        $res = M('artist')->where(array('shenhe'=>1,'art_cate'=>$_GET['id'],'is_del'=>1))->select();
		//dump($res);exit;
        M('artist')->where(array('id'=>$_GET['id']))->setInc('browser',1);
        $this->assign('res',$res);

        $this->img();
        $this->display();
    }*/

    public function artistShow(){
        $artist_id = $_GET['id'];
        //$id = M('apply')->where(array('user_id'=>$artist_id))->getField('id');

        $res = M('apply')->where(array('shenhe'=>2,'id'=>$artist_id))->find();
        //dump($res);exit;
        //$res = M('art')->where(array('shenhe'=>1,'id'=>$artist_id))->find();
        /*$res1 = M('goods')->where(array('is_shenhe'=>1,'promulgator'=>$artist_id,'is_del'=>0,'is_sale'=>1,'is_buy'=>0))->limit('0,3')->select();*/
        $res1 = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id,'is_del'=>0,'is_sale'=>1,'is_buy'=>0))->select();
		
		//dump($res1);exit;
        $num = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id,'is_del'=>0,'is_sale'=>1,'is_buy'=>0))->count();
        $myname = M('art_cate')->where(array('id'=>$res['series_ids']))->getField('name');
        //dump($name);exit;
		//print_r($myname);
        $this->assign('myname',$myname);
        $this->assign('res',$res);
        $this->assign('res1',$res1);
        $this->assign('num',$num);
        $this->display('artistShow');
    }


    public function artistZy(){
        header('content-Type:text/html;charset=utf-8;');
        $id = $_GET['id'];

        M('apply')->where(array('id'=>$_GET['id']))->setInc('browser',1);
        //$artist_id = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->getField('id');

        $res = M('apply')->where(array('id'=>$id,'is_del'=>0,'shenhe'=>2))->find();
        //print_r($res);
        $res1 = M('goods')->where(array('promulgator'=>$res['id'],'is_del'=>0,'is_sale'=>1,'shenhe'=>1,'is_buy'=>0))->select();//店铺产品
		//dump($res1);exit;

        $num = M('goods')->where(array('promulgator'=>$res['id'],'is_del'=>0,'is_buy'=>0,'is_sale'=>1,'shenhe'=>1))->count();
        //dump($num);exit;

        foreach($res1 as $key=>$val){
            $res1[$key]['tj_status'] = 0;
        }

       //推荐来的商品 /*ZQJ20171107*/
        $userid  = M('yun_apply')->where(array('user_id'=>$res['user_id']))->getField('id');
        //$rec = M('recommend')->where(array('artist_id'=>$res['id']))->select();
        $rec = M('recommend')->where(array('artist_id'=>$userid))->select();
        //print_r($rec);
        $goodids =   array();
        if($rec){
            foreach($rec as $Key=>$val){
                $goodids[] = $val['good_id'];
            }
            $gd['is_del'] = 0;
            $gd['is_buy'] = 0;
            $gd['is_sale'] = 1;
            $gd['shenhe'] = 1;
            $gd['id'] = array('in',$goodids);
            // print_r($goodids);
            $goodss = M('goods')->where($gd)->select();
            //print_r($goodss);
            //$this->assign('goodstj',$goodss);
            if($goodss){
                foreach($goodss as $key=>$val){
                    $goodss[$key]['tj_status'] = 1;//推荐订单
                }
                $res1 = array_merge($res1,$goodss);
                //print_r($res1);
            }
        }

        $this->assign('res',$res);
        $this->assign('res1',$res1);
        $this->assign('num',count($res1));
        $this->display();
    }

    public function artistList(){
        $id = I('get.id');
        $level_id = I('get.level');
        if($id){
            $map['series_ids'] = $id;
        }
        if($level_id){
            $map['level'] = $level_id;
        }
        $slogan = M('slogan')->getField('content');
        $this->assign('slogan',$slogan);
        //$map['shenhe'] = 2;
        $map['type'] = 0;
        $map['ruzhu_status'] = 5;
        $count = M('apply')->where($map)->count();
        $Page  = getpage($count,10);
        $res = M('apply')->where($map)
            ->order('addtime desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('res',$res);
        $level = M('artist_level')->select();
        $this->assign('level',$level);
        /*$name = M('artist_level')->where(array('id'=>$_GET['level']))->getField('level_name');
        $this->assign('name',$name);*/

        $name = M('art_cate')->where(array('id'=>$_GET['id']))->getField('name');

        $this->assign('name',$name);

        $this->img();
        $this->display();
    }

    public function get_artistList()
    {
        if (IS_AJAX) {
            $id = I('post.id');
            $level_id = I('post.level');
            $p = I("post.p");
            $_GET['p'] = $p;
            if($id){
                $map['series_ids'] = $id;
            }
            if($level_id){
                $map['level'] = $level_id;
            }
            $slogan = M('slogan')->getField('content');
            $this->assign('slogan',$slogan);
            //$map['shenhe'] = 2;
            $map['type'] = 0;
            $map['ruzhu_status'] = 5;
            $count = M('apply')->where($map)->count();
            $Page  = getpage($count,10);
            $res = M('apply')->where($map)
                ->order('addtime desc')->limit($Page->firstRow,$Page->listRows)->select();
            if($res){
                $str = '';
                foreach($res as $k=>$v){

                    $str .= '<div class="ysjItem">';
                    $str .= '<div class="ysj_list"> ';
                    $str .= '<a href="/Wxin/ArtCommunity/artistShow?id='.$v['id'].'">';
                    $str .= '<div class="ysj_list_wz">';
                     //.$v['artist_name'].' • '
                    $str .= '<h5>'.msubstr($v['desc'],1,10,'utf-8').'</h5>';
                    $str .= '</div><img src="'.$v['logo_pic'].'" width="100%" /> </a> </div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    /*public function artistList(){
        $id = I('get.id');
        $level = I('get.level');
        if($id){
            $map['art_cate'] = $id;
        }
        if($level){
            $map['level_id'] = $level;
        }
        $map['shenhe'] = 1;
        $res = M('artist')->where($map)->select();
        //dump($res);
        $this->assign('res',$res);
        $level = M('artist_level')->select();
        $this->assign('level',$level);


        $name = M('art_cate')->where(array('id'=>$_GET['id']))->getField('name');
        $this->assign('name',$name);

        $this->img();
        $this->display();
    }*/

    //不要
    /*public function apply(){
		
		 if(IS_AJAX){
            $user_id = I('post.id');
            $artist_res = M('artist')->where(array('member_id'=>$user_id))->find();
            $count8 = M('artist')->where(array('member_id'=>$user_id))->count();
            $count11 = M('authentication')->where(array('member_id'=>$user_id))->count();
            $artist_zc = M('authentication')->where(array('member_id'=>$user_id))->find();
            $artist_fa = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>1))->count();
            $artist_bus = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>1))->count();
            $this->assign('count8',$count8);
            $this->assign('artist_fa',$artist_fa);
            $this->assign('artist_bus',$artist_bus);
            $this->assign('artist_res',$artist_res);
            $this->assign('artist_zc',$artist_zc);
            $this->assign('count11',$count11);

            if($count11 != 0){     //如果提交过个人审核
                if($artist_zc['status'] == 1){      //如果个人审核通过
                    if($count8 != 0){                       //如果提交了店铺审核                        
                        if($artist_res['shenhe'] ==1){          //通过了店铺审核
                            $this->ajaxReturn(array('status'=>0));
                        }elseif($artist_res['shenhe'] ==2){       //店铺审核被拒绝
                            $this->ajaxReturn(array('status'=>1));
                        }else{                                      //店铺审核中
                            $this->ajaxReturn(array('status'=>3));
                        }
                    }else{                                  //如果未提交过店铺审核
                        $this->ajaxReturn(array('status'=>1));
                    }
                }elseif($artist_zc['status'] == 2){        //如果个人审核被拒绝
                    $this->ajaxReturn(array('status'=>2));
                }else{ 
                    if($artist_zc['remind_type'] != 0){                                       //如果个人审核正在审核
                        if(($artist_fa != 0) or ($artist_bus != 0)){   //如果企业审核有一项不为审核则进入个人注册
                        $this->ajaxReturn(array('status'=>4));
                        }elseif(($artist_fa == 0) and ($artist_bus == 0)){  //如果企业审核全部为正在审核则进入等待审核页面
                        $this->ajaxReturn(array('status'=>4));
                    }
                    }
                    elseif($artist_zc['remind_type'] == 0){
                        $this->ajaxReturn(array('status'=>3));
                    }                                        
                    
                }
            }else{         //如果未提交过个人审核
                $this->ajaxReturn(array('status'=>2));
            }

        }
    }*/

    public function overseas(){
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }

        $count = M('art_train')->where(array('is_sale'=>1,'type'=>2))->count();
        $Page  = getpage($count,10);
        $res = M('art_train')->where(array('is_sale'=>1,'type'=>2))->order('start desc')->limit($Page->firstRow,$Page->listRows)->select();
        $this->assign('res',$res);
        $this->assign('res',$res);

        $this->display();
    }

    public function get_overseas(){
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $count = M('art_train')->where(array('is_sale'=>1,'type'=>2))->count();
            $Page  = getpage($count,10);
            $res = M('art_train')->where(array('is_sale'=>1,'type'=>2))->order('start desc')->limit($Page->firstRow,$Page->listRows)->select();
            if($res){
                $str = '';
                foreach($res as $k=>$v){

                    $str .= '<li><a href="/Wxin/ArtCommunity/overseasdot?id='.$v['id'].'">';
                    $str .= '<div class="CraUl-img"><img src="'.$v['logo'].'" /></div>';
                    $str .= '<div class="CraUl-txt"><h2>'.$v['title'].'</h2>';
                    $str .= '<span> <i class="fa fa-clock-o"></i>时间：'.date('Y-m-d',$v['start']).'——'.date('Y-m-d',$v['end']).'</span>';
                    $str .= '<span> <i class="fa fa-map-marker" style=" font-size:16px;">';
                    $str .= '</i>地点：'.$v['address'].'</span> </div>';
                    $str .= '</a><h3 class="peixunH peixunH3">';
                    $str .= '<a href="/Wxin/ArtCommunity/overseasdot?id='.$v['id'].'">';
                    $str .= '<i class="fa fa-plus-square"></i>查看详情</a></h3>';
                    $str .= '<h4 class="peixunH peixunH4">';
                    $str .= '<a href="javascript:;" id="'.$v['id'].'" onclick="myFunction(this)">';
                    $str .= '<i class="fa fa-user-plus"></i>我要报名</a></h4></li>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    public function overseasdot()
    {
        $res = M('art_train')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }
}