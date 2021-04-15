<?php namespace Wxin\Controller;

use http\Env\Response;
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
                    $url = $this->wx_pay(1, $order_no);
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
                    $this->balance(1, $order_no);
                    break;
                default:
                    $this->ajaxReturn(array("status" => 0, 'info' => "无效的支付方式！"));
                    break;
            }
        }
    }

    public function balance($type, $order_no){
        if ($type == 1) {
            // 众筹订单
            $m = M('order_crowd');
            $data_w['way_name']="众筹支付";
            $order_status = 2;
        } else {
            // 培训订单
            $m = M('train_order');
            $data_w['way_name']="培训报名支付";
            $order_status = 4;
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

        M()->startTrans();
        $res = M('member')->where(array('id'=>$_SESSION['member_id']))->save(array('wallet'=>($member['wallet']-$total_fee)));
        if(!$res){
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }

        $data_w['user_id']=$_SESSION['member_id'];
        $data_w['type']=1;
        $data_w['posttime']=time();
        $data_w['order_id']=$info['id'];
        $data_w['cate']=0;
        $data_w['wallet']=$total_fee;

        $res1 = M('money_water')->add($data_w);
        if(!$res1){
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }

        $order = $m->where(array("order_no" => $order_no))->find();
        $total_fee = $order['total_fee'];
        $data = array(
            "pay_status" => 1,
            "order_status" => $order_status,
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

        if ($type == 1) {
            $this->ajaxReturn(array('info'=>"/Wxin/ArtCommunity/crowdFdot/id/".$order['crowd_id'],'status'=>4));
        } elseif ($type == 2) {
            $this->ajaxReturn(array('info'=>"/Wxin/ArtCommunity/traindot/id/".$order['train_id'],'status'=>4));
        }
    }
    /**
     *微信支付
     */
    public function wx_pay($type, $order_res)
    {
        $data_m['order_no'] = $order_res;
        $data_m['order_status'] = 1;
        if ($type == 1) {
            // 众筹订单
            $m = M('order_crowd');
            $info = $m->where($data_m)->find();

            // $total_fee    = 0.01;
            $or_g = M('crowd');
            $o_g_r = $or_g->where(array('id' => $info['crowd_id']))->find();
            $goods_name = $o_g_r['goods_name'];
            $notify_url = "https://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pay/weixin_payzc";
        } else if ($type == 2) {
            // 培训订单
            $m = M('train_order');
            $info = $m->where($data_m)->find();
            $or_g = M('art_train');
            $o_g_r = $or_g->where(array('id' => $info['train_id']))->find();
            $goods_name = $o_g_r['title'] . '培训报名';
            $notify_url = "https://" . $_SERVER['HTTP_HOST'] . "/Home/Pay/weixin_pay";
        }

        if (!$info) {
            return false;
        } else {
            $total_fee = $info['total_fee'];
            // $total_fee    = 0.01;
//            $or_g = M('crowd');
//            $o_g_r = $or_g->where(array('id' => $info['crowd_id']))->find();
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
            $input->SetGoods_tag($goods_name);
            $input->SetNotify_url($notify_url);
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
            // 也不知道为什么当初order_no叫成id
            $id = I('post.order_no');
            $type = I('post.type', 1);
            if ($type == 1) {
                $order = M('order_crowd');
                $res = $order->where(array('order_no' => $id))->find();
                if ($res['order_status'] > 1) {
                    $url = '/Wxin/ArtCommunity/crowdFdot/id/'.$res['crowd_id'];
                    $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
                }
            } elseif (type == 2) {
                $res = M('train_order')->where(array('order_no' => $id))->find();
                if ($res['pay_status'] == 1) {
                    $url = '/Wxin/ArtCommunity/traindot/id/'.$res['train_id'];
                    $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
                }
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
        // 根本没用
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

    public function addTrain()
    {
        $data = I('post.');
        $train = M('art_train')->where(array('id'=>$_POST['train_id']))->find();
        if ($train['end']<time()){
            if($train['type']==1){
                $this->ajaxReturn(array('status'=>0,'info'=>"该培训已结束！"));die;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"该交流已结束！"));die;
            }
        }
        $num = $data['num'] ? $data['num'] : 1;
        $sql = "select a.* from app_tel_train as a left join app_train_order as b on a.order_id=b.id where a.name='"
        . $data['name'] . "' and a.tel= " . $data['tel'] ." and b.train_id=" . $_POST['train_id'] . " AND  pay_status = 0 and a.user_id=" . $this->user_id;
        $res = M()->query($sql);
        $res = $res[0];
        // 判断用户是否有未支付的订单，要是有的话，就覆盖掉原来的订单，没有的话，就新建订单
//        $res = M('tel_train')->alias('t')->join('app_train_order as o on t.order_id=o.id')
//            ->where(array('name'=>$data['name'],  'tel'=>$data['tel'], 't.train_id'=>$_POST['train_id'], 'pay_status'=>0))
//            ->find();
        // 获取到所有未支付的订单,理论上来说也只有一笔
        if (!empty($res)) {
            if ($res['num'] != $num) {
                $train_data['num'] = $num;
                M('tel_train')->where(array('id'=>$res['id']))->save($train_data);
            }

            if ($train['fee']) {
                $this->ajaxReturn(array('status'=>1,'info'=>array('msg' => "您已报名培训", 'applyID' => $res['id'])));
            }
            $this->ajaxReturn(array('status'=>1, 'info' => array('msg' => "您已报名培训", 'applyID' => 0)));
        }

        // 根据登录用户来的
//        $res = M('tel_train')->where(array('user_id'=>$_SESSION['member_id'],'train_id'=>$_POST['train_id']))->find();
        // 一个账号可以给多个用户报名同一个培训
//        $res = M('tel_train')->where(array('name'=>$data['name'],  'tel'=>$data['tel'], 'train_id'=>$_POST['train_id']))->find();
//        if($res){
//            if ($train['fee']) {
//                $train_order_info = M('train_order')->where(array('id'=>$res['order_id']))->find();
//                if ($train_order_info['pay_status'] != 1) {
//                    $this->ajaxReturn(array('status'=>1,'info'=>array('msg' => "您已报名培训", 'applyID' => $res['id'])));
//                }
//            }
//            $this->ajaxReturn(array('status'=>1, 'info' => array('msg' => "您已报名培训", 'applyID' => 0)));
//        }

        // 报名完成，同时生成订单
        $data['user_id'] = $_SESSION['member_id'];
        if (!$data['user_id']) {
            $this->ajaxReturn(array('status'=>0, 'info'=>'请先登录'));
        }
        $order_info['order_no'] = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

        // 可能不需要付钱
        if ($train['fee'] <= 0) {
            $order_info['pay_way'] = 4;
            $order_info['order_status'] = 4;
            $order_info['pay_status'] = 1;
            $order_info['pay_price'] =  0.00;
            $order_info['total_fee'] =  0.00;
            $order_info['total_price'] =  0.00;
            $order_info['pay_time'] = time();
        }

        $order_info['train_id'] = $_POST['train_id'];
        $order_info['user_id'] = $_SESSION['member_id'];
        $order_info['consignee'] = $data['name'];
        $order_info['mobile'] = $data['tel'];
        $train_order = M('train_order')->add($order_info);

        $data['train_id'] = $_POST['train_id'];
        $data['addtime'] = time();
        $data['order_id'] = $train_order ? $train_order : 0;
        $data['num'] = $num;
        $tel_train_id = M('tel_train')->add($data);


        if ($train_order) {
            if ($train['fee'] <= 0) {
                $this->ajaxReturn(array('status' => 1, 'info' => array('msg'=>'培训报名成功', 'applyID' => 0)));
            }
            $this->ajaxReturn(array('status' => 1, 'info' => array('msg'=>'培训订单生成成功，请立即支付', 'applyID' => $tel_train_id)));
        } else {
            $this->ajaxReturn(array('status'=>0,'info'=>"培训订单生成失败"));
        }
    }

    /**
     * 培训报名需要交钱
     */
    public function trainPay()
    {
        if(IS_AJAX){
            //todo 四种支付方式
            $post_data = I('post.');
            $tel_train_id = $post_data['tel_train_id'];
            $tel_train_info = M('tel_train')->where(array('id' => $tel_train_id))->find();
            if (!$tel_train_info) {
                $this->ajaxReturn(array('status' => 0, 'info' => '用户信息不存在'));
            }
            $train_info = M('art_train')->where(array('id' => $tel_train_info['train_id']))->find();
            if ($train_info['end']<time()){
                if($train_info['type']==1){
                    $this->ajaxReturn(array('status'=>0,'info'=>"该培训已结束！"));die;
                }else{
                    $this->ajaxReturn(array('status'=>0,'info'=>"该交流已结束！"));die;
                }
            }
            $art_train_info = M('art_train')->where(array('id'=>$tel_train_info['train_id']))->find();

            $type = $post_data['type'];
            $train_order_info = M('train_order')->where(array('id'=>$tel_train_info['order_id']))->find();
            $order_no = $train_order_info['order_no'];
//            $order_no = date('Ymd').substr(implode(NULL, array_map('train', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            $user_id = $this->user_id;
            file_put_contents('order.log',$user_id.'|'.$order_no);

            $data['order_time'] = time();
//            $data['order_no'] = $order_no;
            $data['pay_type'] = $type;
            $data['total_fee'] = $art_train_info['fee'];
            $data['total_price'] = $art_train_info['fee'];
            if(!M('train_order')->where(array('id'=>$tel_train_info['order_id']))->save($data)){
                $this->ajaxReturn(array('info'=>'订单生成失败，请重新提交！','status'=>0));die;

            }
            //        $order_data["deductible_price"];  //抵扣金额
            switch ($type) {
                case 1: //支付宝
                    //$this->ajaxReturn(array('info'=>"支付宝未开通",'status'=>0));
                    $this->ajaxReturn(array('info'=>'提交订单成功，请支付','url'=>"/Home/ArtCommunity/alipay/style/train/order_no/".$order_no,'status'=>1));
                    break;
                case 2:
                    $this->ajaxReturn(array('info'=>"银联支付未开通",'status'=>0));
//                    $this->ajaxReturn(array("status" => 2,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpaypm/pay.php?order_no={$order_no}&type=2"));
                    break;
                case 3:
                    $url = $this->wx_pay(2,$order_no);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => $url['return_msg']));
//                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新支付!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 3, "order_id" => $order_no, 'url' => $url));
                    break;
                case 4:
                    $this->balance(2,$order_no);
                    break;
                default:
                    $this->ajaxReturn(array('info'=>"请选择支付方式",'status'=>0));
            }
        }
        $id = I('get.applyID');
        $user_id = $this->user_id;
        $res = M('tel_train')->where(array('id'=>$id, 'user_id'=>$user_id))->find();
        if (!$res){
            $this->error("当前用户与订单不匹配！",U('Home/User/login'));
            die;
        }
        $train_info = M('art_train')->where(array('id' => $res['train_id']))->find();
        $this->assign('res',$res);
        $this->assign('train_info',$train_info);
        $this->display();

    }

    public function alipay()
    {

        //$out_trade_no = $_GET["order_no"];
        $out_trade_no = trim(I("order_no"));

        if (!$out_trade_no) {
            $this->error("无此订单号不存在！");
        }
        $style = trim(I("style"));
        if($style == 'train'){
            $order = M("train_order")->where(array('order_no' => $out_trade_no))->find();
            $total_amount = $order['total_fee'];
            if ($order['order_status'] != 1) {
                $this->error("订单无法支付！");
            }
        }

        if (!$order) {
            $this->error("无此订单！");
        }

        $subject = "浙江美术网支付宝订单支付";
        //$total_amount = $order['price'];
        $body = "浙江美术网支付宝订单支付";

        /******************测试数据 1******************/
        //$subject = "浙江美术网支付宝支付测试";
        //$total_amount = 0.01;
        //$body = "浙江美术网支付宝支付测试";
        /******************测试数据 2******************/

        /*********************封装 1***********************/
        $BizContent = array(
            "product_code" => "FAST_INSTANT_TRADE_PAY",
            "out_trade_no" => $out_trade_no,        //商户订单号，64个字符以内、可包含字母、数字、下划线；需保证在商户端不重复
            "subject" => $subject,            //订单标题
            "total_amount" => $total_amount,        //订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
            "body" => $body                //订单描述
        );
        $BizContent = json_encode($BizContent);
        $alipay_config = $this->alipay_config($style);
//        vendor("Alipay.AopSdk");
        vendor("alipay_phone.AopSdk");
        $aop = new \AopClient;
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $alipay_config['app_id'];
        $aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset = 'UTF-8';
        $aop->format = 'json';
        $request = new \AlipayTradePagePayRequest ();
        $request->setReturnUrl($alipay_config['return_url']);
        $request->setNotifyUrl($alipay_config['notify_url']);
        $request->setBizContent($BizContent);
        //请求
        $result = $aop->pageExecute($request); //支付宝返回的信息
        //输出
        echo $result;
        /*********************封装 2***********************/
    }

    /** 20170713 wzz
     *电脑支付配置
     **/
    protected  function alipay_config($style = '')
    {
        if($style == 'train'){
            //"http://" . $_SERVER['HTTP_HOST'] . "/unionpaypm/pay.php?order_no={$order_no}&type=1"));
            $returnUrl = "https://" . $_SERVER['HTTP_HOST'] . "/Home/ArtCommunity/TrainReturnURL";
            $notifyUrl = "https://" . $_SERVER['HTTP_HOST'] . "/Home/ArtCommunity/TrainNotifyURl";
        }
        $alipay_config = array(
            //APPID 即创建应用后生成       更新5-1
            'app_id' => "2015122301028610",
            //同步跳转地址，公网可以访问   更新5-2
            //'return_url' => "http://msw.unohacha.com/Home/CrowedPay/ReturnURL",
            'return_url' => "https://zhejiangart.com.cn/Wxin/ArtCommunity/TrainReturnURL",
            //异步通知地址，公网可以访问   更新5-3
            //'notify_url' => "http://msw.unohacha.com/Home/CrowedPay/NotifyURL",
            'notify_url' => $notifyUrl ,
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

    public function TrainReturnURL()
    {
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
            $m = M("train_order");
            $order = $m->where(array("order_no" => $out_trade_no))->find();
            if ($order['order_status'] == 4) {
                $url = '/Home/ArtCommunity/traindot/id/' . $order['train_id'];
                $this->redirect($url);
            } else {
                $this->order_error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->order_error("订单支付失败！");
        }
    }

    public function TrainNotifyURl(){
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
                $m = M("train_order");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
                $total_fee = $order['price'];
                if($order['pay_status'] == 0){
                    $b_data['pay_way'] = 1;
                    $b_data['order_status'] = 4;
                    $b_data['pay_status'] = 1;
                    $b_data['pay_price'] =  $total_amount;
                    $b_data['pay_time'] = time();

                    $m->where(array('id' => $order['id']))->save($b_data);
                    /* }*/
                }

                $data_w['user_id']=$order['user_id'];
                $data_w['type']=1;
                $data_w['posttime']=time();
                $data_w['order_id']=$order['id'];
                $data_w['cate']=1;
                $data_w['expend']=$total_amount;
                $data_w['way_name']="培训报名支付";
                $res1 = M('money_water')->add($data_w);

            }
            //2.记录流水账

            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////

            echo "success";    //请不要修改或删除
        } else {
            //验证失败
            echo "fail";
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
        $video = M('apply_video')->where(array('user_id'=>$artist_id))->field('url')->find();
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
        $this->assign('video',$video);
        $this->display('artistShow');
    }

    /**
     * 新的手机端艺术家中心页面
     */
    public function individual()
    {
        $artist_id = $_GET['id'];
        // 艺术家信息
        $artist_info = M('apply')->where(array('shenhe'=>2,'id'=>$artist_id))->find();
        // 艺术家视频
//        $video = M('apply_video')->where(array('user_id'=>$artist_id))->field('url')->find();
        // 艺术家作品
        $artist_goods = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id, 'is_sale'=>1))->select();
        // 艺术家作品数量
        $num = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id, 'is_sale'=>1))->count();

        // 出售中的作品
        $paying_goods = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id, 'is_sale'=>1))->select();

        // 新闻,表里存的promulgator都是错的，直接取user_id
//        $news = M('news')->where(array('promulgator'=>$artist_id, 'is_del'=>0))->select();
//        $news = M('news')->where(array('user_id'=>909, 'is_del'=>0))->select();
        $news = M('news')->where(array('user_id'=>$artist_info['user_id'], 'is_del'=>0))->select();

        // 文章 status 0-已发布
        $article = M('article')->where(array('user_id'=>$artist_info['user_id'], 'status'=>0, 'deleted_at' => null))->select();

        // 动态
        $action = M('action')->where(array('user_id'=>$artist_info['user_id']))->select();
//        var_dump($action);die;
        foreach ($action as &$value) {
            switch ($value['type']) {
                case 1:
                    $goods = M('goods')->where(array('id'=>$value['source_id']))->find();
                    $value['desc'] = '点赞了' . $goods['goods_name'];
                    $value['pic'] = $goods['index_pic'];
                case 2:
                    $artist = M('apply')->where(array('id'=>$value['source_id']))->find();
                    $value['desc'] = '关注了' . $artist['name'];
                    $value['pic'] = $artist['logo_pic'];
                default:
                    break;
            }
            $value['month'] = date("m", strtotime($value['created_at']));
            $value['day'] = date("d", strtotime($value['created_at']));
        }
//var_dump($action);die;
//        $res1 = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id,'is_del'=>0,'is_sale'=>1,'is_buy'=>0))->select();


        // 艺术家的分类名称
        $myname = M('art_cate')->where(array('id'=>$artist_info['series_ids']))->getField('name');

        // 是否关注
        $member_id = $_SESSION['member_id'] ? $_SESSION['member_id'] : 0;
        $is_follow = M('follow')->where(array('artist_id'=>$artist_id, 'user_id'=>$member_id))->select();
        $is_follow = !empty($is_follow) ? 1 : 0;

        // 上次登录时间
        $user_info = M('member')->where(array('id'=>$artist_info['user_id']))->select();
        if (!empty($user_info[0]['last_login_at'])) {
            $time = (time() - strtotime($user_info[0]['last_login_at']))/3600;
            if ($time < 1) {
                $login_at = floor(time() - strtotime($user_info[0]['last_login_at'])/60);
                $last_login_at = $login_at . "分钟前";
            } else if ($time < 24 && $time >= 1) {
                $login_at = floor($time);
                $last_login_at = $login_at . "小时前";
            } else if ($time >= 24 && $time < 720) {
                $login_at = floor($time/30);
                $last_login_at = $login_at . "天前";
            } else if ($time >= 720 && $time < 8760) {
                $login_at = floor($time/720);
                $last_login_at = $login_at . "月前";
            } else if ($time >= 8760) {
                $login_at = floor($time/8760);
                $last_login_at = $login_at . "年前";
            } else {
                $last_login_at = 0;
            }
        } else {
            $last_login_at = 0;
        }

        // 艺术家行为
//        $action = M('action')->where(array('user_id'=>$artist_info['user_id']))->select();

        $login_info['last_login_at'] = $last_login_at;
        $login_info['last_login_location'] = $user_info['last_login_location'];
        $this->assign('myname',$myname);
        $this->assign('artist_info',$artist_info);
        $this->assign('artist_goods',$artist_goods);
        $this->assign('num',$num);
        $this->assign('paying_goods', $paying_goods);
        $this->assign('news', $news);
        $this->assign('article', $article);
        $this->assign('is_follow', $is_follow);
        $this->assign('login_info', $login_info);
        $this->assign('actions', $action);
        $this->display();
    }

    /**
     * 关注或者取关
     */
    public function follow()
    {
        if (IS_AJAX) {
            $member_id = $_SESSION['member_id'] ? $_SESSION['member_id'] : 0;
            if (!$member_id) {
                $this->ajaxReturn(array('code'=>1001 ,'info'=>'请先登录'));
            }
            $artist_id = I('post.artist_id');
            if (!$artist_id) {
                $this->ajaxReturn(array('code'=>10001 ,'info'=>'页面异常，请重新进入'));
            }
            $follow_info = M('follow')->where(array('artist_id'=>$artist_id, 'user_id'=>$member_id))->select();
            // 有就说明是已关注的状态
            if (!$follow_info) {
                // 如果没有，那就新增关注记录
                $data['artist_id'] = $artist_id;
                $data['user_id'] = $member_id;
                $res = M('follow')->add($data);
                if ($res) {
                    $action_data['user_id'] = $member_id;
                    $action_data['source_id']= $artist_id;
                    $action_data['type']    = 2;
                    $action_data['created_at'] = date("Y-m-d H:i:s");
                    // 记录行为
                    $action = M('action')->save($action_data);
                    $this->ajaxReturn(array('code' => 0, 'info' => '关注成功'));
                }
                $this->ajaxReturn(array('code' => 10001, 'info' => '关注失败'));
            } else {
                $res = M('follow')->where(array('artist_id'=>$artist_id, 'user_id'=>$member_id))->delete();
                if (!$res) {
                    $this->ajaxReturn(array('code' => 10001, 'info' => '取关失败'));
                }
                $action_data['deleted_at'] = date("Y-m-d H:i:s");
                $action = M('action')->where(array('user_id'=>$member_id, 'type'=>2, 'source_id'=>$artist_id))->save($action_data);

                // 记录行为
                $action = M('action')->save($action_data);
                $this->ajaxReturn(array('code' => 1, 'info' => '取关成功'));
            }
        }
    }

    /**
     * 艺术家简介
     */
    public function detailPage()
    {
        $artist_id = $_GET['id'];
        $artist_info = M('apply')->where(array('shenhe'=>2,'id'=>$artist_id))->find();
        M('apply')->where(array('id'=>$artist_id))->setInc('browser',1);

        $member_id = $_SESSION['member_id'] ? $_SESSION['member_id'] : 0;
        // 已通过审核的评论
        $comment_sql = "select a.*,b.realname, b.person_img from app_comment as a left join app_member as b on a.user_id=b.id where a.artist_id=$artist_id and a.status=2 and a.type=1";
        $comment = M()->query($comment_sql);

        $like = M('like')
            ->alias('a')
            ->join('left join app_member b on a.user_id=b.id')
            ->where(array('a.type'=>1, 'a.target_id'=>$artist_id))->select();

        $like_nums = M('like')->where(array('type'=>1, 'target_id'=>$artist_id))->count();

        // 评论列表
        if ($member_id) {
            $comment_like = M('like')
                ->alias('a')
                ->join('left join app_comment b on a.target_id = b.id')
                ->where(array('a.target_id'=>$artist_id, 'b.artist_id'=>$artist_id, 'a.type'=>1))
                ->select();
        }  else {
            $comment_like = 0;
        }
        if (empty($like)) {
            $is_like = 0;
        } else {
            $is_like = 1;
        }

        $this->assign('artist_info', $artist_info);
        $this->assign('like', $like);
        $this->assign('is_like', $is_like);
        $this->assign('like_nums', $like_nums);
        $this->assign('comment', $comment);
        $this->assign('comment_like', $comment_like);
        $this->display();
    }

    /**
     * 喜欢或取消喜欢按钮
     */
    public function likeAction()
    {
        if (IS_AJAX) {
            $member_id = $_SESSION['member_id'] ? $_SESSION['member_id'] : 0;
            if (!$member_id) {
                $this->ajaxReturn(array('code'=>1001 ,'info'=>''));
            }
            $target_id = I('post.target_id');
            if (!$target_id) {
                $this->ajaxReturn(array('code'=>10001 ,'info'=>'页面异常，请重新进入'));
            }
            $type = I('post.type');
            $follow_info = M('like')->where(array('target_id'=>$target_id, 'user_id'=>$member_id, 'type'=>$type))->select();
            // 有就说明是已关注的状态
            if (!$follow_info) {
                // 如果没有，那就新增关注记录
                $data['target_id'] = $target_id;
                $data['user_id'] = $member_id;
                $data['type'] = $type;      // 1为艺术家，2为商品, 3为评论，4-news 到时候封装个service
                $data['created_at'] = date("Y-m-d H:i:s");
                $res = M('like')->add($data);
                if ($res) {
                    $this->ajaxReturn(array('code' => 0, 'info' => '点赞成功'));
                }
                $this->ajaxReturn(array('code' => 10001, 'info' => '点赞失败'));
            } else {
                $res = M('like')->where(array('target_id'=>$target_id, 'user_id'=>$member_id, 'type'=>$type))->delete();
                if (!$res) {
                    $this->ajaxReturn(array('code' => 10001, 'info' => '取消点赞失败'));
                }
                $this->ajaxReturn(array('code' => 0, 'info' => '取消点赞成功'));
            }
        }
    }

    /**
     * 评论
     */
    public function comment()
    {
        $data = I('post.');
        $member_id = $_SESSION['member_id'] ? $_SESSION['member_id'] : 0;
        if (!$member_id) {
            $this->ajaxReturn(array('status'=>1001 ,'info'=>'请先登录'));
        }
        $artist_id = $data['artist_id'];
        $prev_comment_id = $data['prev_comment_id'];
        // 查找他回复的评论是否存在
        if ($prev_comment_id) {
            $res = M('comment')->where(array('id'=>$prev_comment_id, 'artist_id'=>$artist_id))->select();
            if (!$res) {
                $this->ajaxReturn(array('code'=>10001, 'info'=>'评论异常'));
            }
        }
        $comment_content['artist_id'] = $artist_id;
        $comment_content['content'] = $data['content'];
        $comment_content['user_id'] = $member_id;
        $comment_content['target_id'] = $artist_id;
        $comment_content['prev_comment_id'] = $prev_comment_id;
        $comment_content['created_at'] = date("Y-m-d H:i:s");

        $comment = M('comment')->add($comment_content);
        if (!$comment) {
            $this->ajaxReturn(array('code'=>10001, 'info'=>'评论异常'));
        }
        $this->ajaxReturn(array('code'=>0, 'info'=>'评论成功，请等待审核'));
    }


    /**
     * 新闻模块
     */
    public function particulars()
    {
        $id = $_GET['id'];
        $member_id = $_SESSION['member_id'] ? $_SESSION['member_id'] : 0;

        $news_sql = "select a.*, b.name, b.logo_pic from app_news as a left join app_apply as b on a.user_id=b.user_id where a.id=$id and a.status = 0 and a.shenhe=1";
        $news = M()->query($news_sql);

        $news[0]['addtime'] = date("Y-m-d", $news[0]['addtime']);
//    var_dump($news_sql);die;
//var_dump($news[0]);die;
        $like = M('like')
            ->alias('a')
            ->join('left join app_member b on a.user_id=b.id')
            ->where(array('a.type'=>4, 'a.target_id'=>$id))->select();

        $like_nums = M('like')->where(array('type'=>4, 'target_id'=>$id))->count();

        // 评论列表
        if ($member_id) {
            $comment_like = M('like')
                ->alias('a')
                ->join('left join app_comment b on a.target_id = b.id')
                ->where(array('a.target_id'=>$id, 'b.id'=>$id))
                ->select();
        }  else {
            $comment_like = array();
        }
        if (empty($like)) {
            $is_like = 0;
        } else {
            $is_like = 1;
        }

        // 已通过审核的评论
        $comment_sql = "select a.*,b.realname, b.person_img from app_comment as a left join app_member as b on a.user_id=b.id where a.target_id=$id and a.status=2 and a.type=4";
        $comment = M()->query($comment_sql);
//var_dump($news[0]);die;
        $this->assign('news', $news[0]);
        $this->assign('like', $like);
        $this->assign('is_like', $is_like);
        $this->assign('like_nums', $like_nums);
        $this->assign('comment_like', $comment_like);
        $this->assign('comment', $comment);
        $this->display();
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
        $map['shenhe'] = 2;
        $map['ruzhu_status'] = 5;
        $count = M('apply')->where($map)->count();
        $Page  = getpage4($count,10);
		$show       = $Page->show();
        $res = M('apply')->where($map)->order('addtime desc')->limit($Page->firstRow,$Page->listRows)->select();
		$this->assign('show',$show);
		/*
		$count=M('goods')->where($map)->order('is_groom desc,id desc')->count();
		//$Page       = new \Think\Page($count,6);
		$Page = getpage1($count,12);
		$show       = $Page->show();
        $res = M('goods')->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('is_groom desc,id desc')->select();
		$this->assign('show',$show);
		<div><center>{$show}</center></div>
		*/
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

    public function artistListce(){
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
        $map['shenhe'] = 2;
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
            $map['shenhe'] = 2;
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

    public function starAction()
    {
        $data = I("post.");
        $member_id = $_SESSION['member_id'];
        $artist_id = $data['artist_id'];
        $action = $data['action'] ? 1 : 2; // 1为点赞，2为取消
        if ($action == 2) {
            M("art_star")->where(array('artist_id' => $artist_id, 'member_id' => $member_id))
                ->select();
        }

    }
}