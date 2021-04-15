<?php namespace Wxin\Controller;

use Think\Controller;

class PersonalCenterController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',5);
          $result = M('member')->where(array('id' => $_SESSION['member_id']))->find();
        $this->assign('result', $result);

		$artist_res = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->find();
		$count8 = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->count();
        $count11 = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->count();
        $artist_zc = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->find();
        $artist_fa = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>1))->count();
        $artist_fa1 = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>1))->find();

        $artist_bus = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>2))->count();
        $artist_bus1 = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>2))->find();
		$this->assign('count8',$count8);
        $this->assign('artist_res',$artist_res);
        $this->assign('artist_zc',$artist_zc);
        $this->assign('artist_fa',$artist_fa);
        $this->assign('artist_fa1',$artist_fa1);
        $this->assign('artist_bus',$artist_bus);
        $this->assign('artist_bus1',$artist_bus1);
		$this->assign('count11',$count11);
        $this->checkLogin();
    }

    public function shopcar()
    {
        $userid = $_SESSION['member_id'];
        $heji_all_price = 0;
        $checked_num = 0;
        $all_num = 0;
        $data = M("cart")->where(array('user_id' => $userid))->order('id desc')->select();
        foreach ($data as $k => $val) {
            $goodsInfo = M("goods")->where(array('id' => $val['goods_id']))->field('goods_name,index_pic,price,store,cstore')->find();
            $data[$k]['price'] = sprintf("%.2f", $goodsInfo['price']);
            $data[$k]['allprice'] = sprintf("%.2f", $goodsInfo['price']*$val['num']);
            $data[$k]['goods_name'] = $goodsInfo['goods_name'];
            $data[$k]['index_pic'] = $goodsInfo['index_pic'];
            $data[$k]['store'] = $goodsInfo['store'];
            $data[$k]['cstore'] = $goodsInfo['cstore'];
            $checked_num += 1;
            $all_num += $data[$k]['num'];
            $heji_all_price += sprintf("%.2f", $data[$k]['allprice']);
        }
        //print_r($data);
        $this->assign('data', $data);
        $this->assign('heji_all_price', sprintf("%.2f", $heji_all_price));
        $this->assign('checked_num', $checked_num);
        $this->assign('all_num', $all_num);
        $this->display();
    }

    public function myOrder()
    {
		
        $o_m   = M("order_info");
        $o_g_m = M("order_goods");
        $type  = I("get.status");
        if($type==""){
            $map['order_status'] = array('gt',0);
        }else{
            $map['order_status'] = $type;
        }
        $map['user_id'] = $_SESSION['member_id'];
        $map['is_del'] = 0;
        $map['is_recommend'] = 1;
        $count = $o_m->where($map)->order("update_time desc")->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = $o_m->where($map)->order("order_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = $o_g_m->where(array("user_id"=>$map['user_id'],"order_id"=>$v['id']))->select();
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }
        $this->assign("s",$type);
		//print_r($order);
        $this->assign("cache", $order)->display();
    }

    public function get_myOrder()
    {
        if (IS_AJAX) {
            $type = I("post.status");
            $p = I("post.p");
            $_GET['p'] = $p;
            $o_m   = M("order_info");
            $o_g_m = M("order_goods");
            $type  = I("get.status");
            if($type==""){
                $map['order_status'] = array('gt',0);
            }else{
                $map['order_status'] = $type;
            }
            $map['user_id'] = $_SESSION['member_id'];
            $map['is_del'] = 0;
            $map['is_recommend'] = 1;
            $count = $o_m->where($map)->order("update_time desc")->count();
            $Page  = getpage($count,5);
            $show  = $Page->show();//分页显示输出
            $this->assign("page",$show);
            $order = $o_m->where($map)->order("order_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach($order as $k=>$v){
                $order[$k]['data'] = $v['data'] = $o_g_m->where(array("user_id"=>$map['user_id'],"order_id"=>$v['id']))->select();
                $order[$k]['count'] = $v['count'] = count($v['data']);
                $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
                $order[$k]['index_name']=$v['data'][0]['goods_name'];
                $order[$k]['price']=$v['data'][0]['goods_price'];
                $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
            }
            if($order){
                $str = '';
                foreach($order as $k=>$val){

                    $str .= '<div class="all_dingdan_one">';
                    $str .= '<div class="allorder_topz">';
                    $str .= '<div class="allorder_topz_center">';
                    $str .= '<div class="allorder_topz_right">';
                    switch($val['order_status']){
                        case 1:
                            $str .= '未付款';
                            break;
                        case 2:
                            $str .= '已付款待发货';
                            break;
                        case 3:
                            $str .= '已发货待收货';
                            break;
                        case 4:
                            $str .= '已签收';
                            break;
                        case 5:
                            $str .= '已完成';
                            break;
                        case 6:
                            $str .= '退款中';
                            break;
                        case 7:
                            $str .= '已关闭';
                            break;
                    }
                    $str .= '</div><div class="clear"></div>';
                    $str .= '</div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp">';
                    $str .= '<div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd">';
                    $str .= '<a href="javascript:void();"><img src="'.$val['index_pic'].'" width="100%" /></a> ';
                    $str .= '</div><div class="shop_xx_right shop_xx_fd">';
                    $str .= ' <p><b>'.$val['index_name'].'</b><br />订单号：<i>'.$val['order_no'].'</i></p>';
                    $str .= '<p>收货人：<i>'.$val['consignee'].'</i><em>×'.$val['goods_nums'].'</em></p>';
                    $str .= '<h3 class="shop_xx_jg"><b>下单时间：</b><b>'.date('Y-m-d',$val['order_time']).'</b></h3>';
                    $str .= '</div><div class="clear"></div></div>';
                    $str .= '</div><div class="llk_border">';
                    $str .= '<div class="llk"><div class="od_zongji">共<b>'.$val['goods_nums'].'</b>';
                    $str .= '件商品 合计：<span>¥'.$val['total_fee'].'</span></div>';
                    $str .= '</div><div class="clear"></div></div>';
                    $str .= '<div class="od_button">';
                    switch($val['order_status']){
                        case 1:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" onclick="fukuan(this)" data-id="'.$val['order_no'].'">付款</a></div>';
                            $str .= '<div class="od_quxiao"><a href="javascript:;" data-id="'.$val['id'].'" onclick="quxiao(this)">取消订单</a></div>';
                            break;
                        case 3:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" onclick="qianshou(this)" data-id="'.$val['id'].'">确认收货</a></div>';
                            break;
                    }
                    $str .= '<div class="od_quxiao"><a href="/Wxin/PersonalCenter/orderDetails/tag/myOrder/value/1?id='.$val['id'].'">查看详情</a></div>';
                    $str .= '<div class="clear"></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
	/*
	*	ZQJ 修改 20171028
	*/
    public function lease()
    {
        if (IS_GET) {
            $status = $_GET['order_status'];
            if($status == null){
				 $counts1 = M('order_info')->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>array('gt',0)))->count();
				$Page  = getpage($counts1,10);
				$show  = $Page->show();//分页显示输出
                $res = M('order_info')->order('order_time desc')->limit($Page->firstRow.','.$Page->listRows)->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>array('gt',0)))->select();
            }else{
				$counts1 = M('order_info')->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>$status))->count();
				$Page  = getpage($counts1,10);
				$show  = $Page->show();//分页显示输出
                $res = M('order_info')->order('order_time desc')->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>$status))->limit($Page->firstRow.','.$Page->listRows)->select();
            }
            foreach ($res as $k=>$v){
                $order_goods = M('order_goods')->where(array('order_id'=>$v['id']))->find();
                $res[$k]['goods_name'] = $order_goods['goods_name'];
                $res[$k]['goods_spic'] = $order_goods['goods_spic'];
                $res[$k]['goods_nums'] = $order_goods['goods_nums'];
                $res[$k]['goods_price'] = $order_goods['goods_price'];
                $username = M('member')->where(array('id'=>$v['user_id']))->find();
                $res[$k]['realname'] = $username['realname'];
                $goods_cap = M('goods')->where(array('id'=>$order_goods['goods_id']))->find();
                $res[$k]['goods_cap'] = $goods_cap['goods_cap'];
            }
        }
        /**
         * 物流公司 2016-1-3   Jaw
         */
        $express = M("express")->order("id asc")->select();
        $this->assign("express_list", $express);
        //print_r($res);
        $this->assign('page',$show);
        $this->assign('res',$res);
            $this->display();

    }

    public function get_lease()
    {
        if (IS_AJAX) {
            $status = I("post.order_status");
            $p = I("post.p");
            $_GET['p'] = $p;
            if($status == null){
                $counts1 = M('order_info')->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>array('gt',0)))->count();
                $Page  = getpage($counts1,10);
                $res = M('order_info')->order('order_time desc')->limit($Page->firstRow.','.$Page->listRows)->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>array('gt',0)))->select();
            }else{
                $counts1 = M('order_info')->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>$status))->count();
                $Page  = getpage($counts1,10);
                $res = M('order_info')->order('order_time desc')->where(array('is_recommend'=>0,'user_id'=>$_SESSION['member_id'],'order_status'=>$status))->limit($Page->firstRow.','.$Page->listRows)->select();
            }
            foreach ($res as $k=>$v){
                $order_goods = M('order_goods')->where(array('order_id'=>$v['id']))->find();
                $res[$k]['goods_name'] = $order_goods['goods_name'];
                $res[$k]['goods_spic'] = $order_goods['goods_spic'];
                $res[$k]['goods_nums'] = $order_goods['goods_nums'];
                $res[$k]['goods_price'] = $order_goods['goods_price'];
                $username = M('member')->where(array('id'=>$v['user_id']))->find();
                $res[$k]['realname'] = $username['realname'];
                $goods_cap = M('goods')->where(array('id'=>$order_goods['goods_id']))->find();
                $res[$k]['goods_cap'] = $goods_cap['goods_cap'];
            }
            if($res){
                $str = '';
                foreach($res as $k=>$val){
                    $str .= '<div class="all_dingdan_one">';
                    $str .= '<div class="allorder_topz">';
                    $str .= '<div class="allorder_topz_center">';
                    $str .= '<div class="allorder_topz_right">';
                    switch($val['order_status']){
                        case 1:
                            $str .= '未付款';
                            break;
                        case 2:
                            $str .= '已付款待发货';
                            break;
                        case 3:
                            $str .= '已发货待收货';
                            break;
                        case 4:
                            $str .= '已签收';
                            break;
                        case 5:
                            $str .= '已完成';
                            break;
                        case 6:
                            $str .= '退款中';
                            break;
                        case 7:
                            $str .= '已关闭';
                            break;
                        case 8:
                            $str .= '归还中';
                            break;
                    }
                    $str .= '</div><div class="clear"></div>';
                    $str .= '</div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp">';
                    $str .= '<div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd">';
                    $str .= '<a href="javascript:void();"><img src="'.$val['index_pic'].'" width="100%" /></a> ';
                    $str .= '</div><div class="shop_xx_right shop_xx_fd">';
                    $str .= ' <p><b>'.$val['index_name'].'</b><br />订单号：<i>'.$val['order_no'].'</i></p>';
                    $str .= '<p>收货人：<i>'.$val['consignee'].'</i><em>×'.$val['goods_nums'].'</em></p>';
                    $str .= '<h3 class="shop_xx_jg"><b>下单时间：</b><b>'.date('Y-m-d',$val['order_time']).'</b></h3>';
                    $str .= '</div><div class="clear"></div></div>';
                    $str .= '</div><div class="llk_border">';
                    $str .= '<div class="llk"><div class="od_zongji">共<b>'.$val['goods_nums'].'</b>';
                    $str .= '件商品 合计：<span>¥'.$val['total_fee'].'</span></div>';
                    $str .= '</div><div class="clear"></div></div>';
                    $str .= '<div class="od_button">';
                    switch($val['order_status']){
                        case 1:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" onclick="fukuan(this)" data-id="'.$val['order_no'].'">付款</a></div>';
                            $str .= '<div class="od_quxiao"><a href="javascript:;" data-id="'.$val['id'].'" onclick="quxiao(this)">取消订单</a></div>';
                            break;
                        case 3:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" onclick="qianshou(this)" data-id="'.$val['id'].'">确认收货</a></div>';
                            break;
                        case 4:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" data-id="'.$val['id'].'" onclick="gh(this)">归还</a></div>';
                            break;
                        case 5:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" style="background: gainsboro;border-color:gainsboro" data-id="'.$val['id'].'">已归还</a></div>';
                            break;
                        case 8:
                            $str .= '<div class="od_fukuan"><a href="javascript:void();" style="background: gainsboro;border-color:gainsboro" data-id="'.$val['id'].'">已归还</a></div>';
                            break;
                    }
                    $str .= '<div class="od_quxiao"><a href="/Wxin/PersonalCenter/orderDetails/tag/myOrder/value/1?id='.$val['id'].'">查看详情</a></div>';
                    $str .= '<div class="clear"></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    //归还
    //选择快递公司
    public function express(){
        $data["zuexpress_name"]    = I("post.express_name");//编码

        $data["zuexpress_no"]      = I("post.express_no");
        $data["zuis_send"]         = 1;
        $id                      = I('post.id');
        $m          = M('order_info');
        $res = $m->where(array("id"=>$id))->save($data);
        $Info=$m->where(array("id"=>$id))->find();
        $data["zuexpress_name"]    = M("express")->where(array('express_ma'=>$data['zuexpress_name']))->getField("express_company");//快递公司名称
        if($res){
            //发货成功添加发货时间 修改订单状态
            $res1 = $m->where(array("id"=>$id))->setField(array("order_status"=>8,"shipping_time"=>time()));
            if($res1){
                $d=array(
                    'order_id'=>$Info['id']
                );
                $this->sendSystemMessage($Info['user_id'],"订单已发货","您的订单【".$Info['order_no']."】已发货，【".$data['express_name']."】运单编号：".$data["express_no"]."请注意查收！",$d);
                $this->ajaxReturn(array("status"=>1,'info'=>"发货成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
            }
        }else{
            $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
        }
    }
    public function changeOrderStatus(){

        $res = M('order_info')->where(array('id'=>$_POST['id']))->save(array('order_status'=>4,'receive_time'=>time()));
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"签收成功"));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"签收失败"));
        }
    }

    public function returnGoods()
    {
        $this->display();
    }
    //待评价列表
    public function pendEvaluate()
    {
        $this->display();
    }

    //去评价
    public function goEvaluate()
    {
        $this->display();
    }

    //已评价列表
    public function haveEvaluate()
    {
        $this->display();
    }

    public function cashGift()
    {
        $member_id = $_SESSION['member_id'];
        $fields = array('c.condition','type','integral','money','over_time','status','get_time');
        $link_coupon = M('link_coupon as l')->where(array('l.user_id'=>$member_id))->join('app_coupon as c on l.coupon_id = c.id')->field($fields)->select();
        foreach($link_coupon as $key=>$val){
            $link_coupon[$key]['start_time'] = $val['get_time'];
            $over_time = $val['over_time'];
            $link_coupon[$key]['end_time'] = strtotime(" +$over_time day",$val['get_time']);
            if(strtotime(" +$over_time day",$val['get_time']) < time()){
                $link_coupon[$key]['status'] = 4;
            }
            if(time() < $link_coupon[$key]['end_time']){
                $link_coupon[$key]['over_time']= floor(($link_coupon[$key]['end_time']-time())/(60*60*24));
            }
        }
         $this->assign('coupon',$link_coupon);
        $this->display();
    }

    public function bank()
    {
        $count = M('bank_list')->where(array('user_id' => $_SESSION['member_id']))->count();
        $this->assign('count', $count);
        $res = M('bank_list')->where(array('user_id' => $_SESSION['member_id']))->select();
        $this->assign('res', $res);
        $this->display();
    }

    public function deleteBankCard()
    {
        $res = M('bank_list')->where(array('id' => $_POST['id']))->delete();
        if ($res) {
            $this->ajaxReturn(array("status" => 1, "info" => "删除成功！"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => "删除失败！"));
        }
    }

    //提现
    public function cash(){
        if(IS_AJAX){
            $id = I('post.id');
            $money = I('post.money');
            if(!$id){
                $this->ajaxReturn(array('stauts'=>0,'info'=>'参数错误！'));
            }
            $data['money'] = $money;
            $data['user_id'] = $_SESSION['member_id'];
            $data['addtime'] = time();
            $data['bank_id'] = $id;
            $res = M('cash')->add($data);
            $res2 = M('member')->where(array('id'=>$_SESSION['member_id']))->getField('wallet');
            if($res2<$money){
                $this->ajaxReturn(array('status'=>0,'info'=>'余额不足！'));
            }
            $res1 = M('member')->where(array('id'=>$_SESSION['member_id']))->setDec('wallet',$data['money']);
            if(!$res1){
                $this->ajaxReturn(array('status'=>0,'info'=>'申请失败，请重新申请！'));
            }
            if(!$res){
                $this->ajaxReturn(array('status'=>0,'info'=>'申请失败，请重新申请！'));
            }else{
                $this->ajaxReturn(array('status'=>1,'info'=>'申请成功！请等待后台审核！'));
            }
        }
    }

    //个人资料
    public function userInfo()
    {
        $cate = M('member_cate')->select();
        $this->assign('cate',$cate);
        $this->display();
    }

    //修改个人资料
    public function editCenter()
    {
        if ($_POST['nowpass'] == "" || $_POST['nowpass'] == null) {
            //print_r($_POST);exit;
            $data['type'] = $_POST['type'];
            $data['realname'] = $_POST['realname'];
            $data['person_name'] = $_POST['person_name'];
            $data['sex'] = $_POST['sex'];
            $data['birth'] = $_POST['birth'];
            $data['telephone'] = $_POST['telephone'];
            $data['email'] = $_POST['email'];
            $data['country'] = $_POST['country'];
            $res = M('member')->where(array('id' => $_SESSION['member_id']))->save($data);
            if ($res) {
                $this->ajaxReturn(array('status' => 1, 'info' => "修改成功"));
            } else {
                $this->ajaxReturn(array('status' => 0, 'info' => "修改失败"));
            }
        } else {
            $password = M('member')->where(array('id' => $_SESSION['member_id']))->getField('password');
            if ($password != md5($_POST['nowpass'])) {
                $this->ajaxReturn(array('status' => 0, 'info' => "当前密码不正确！"));
            } else {
                /*if(md5($_POST['nowpass']) == md5($_POST['password'])){
                    $this->ajaxReturn(array('status'=>0,'info'=>'新密码不能跟旧密码一样'));
                }*/
                $data['realname'] = $_POST['realname'];
                $data['person_name'] = $_POST['person_name'];
                $data['sex'] = $_POST['sex'];
                $data['birth'] = $_POST['birth']?$_POST['birth']:'';
                $data['telephone'] = $_POST['telephone'];
                $data['email'] = $_POST['email'];
                $data['country'] = $_POST['country'];
                $data['password'] = md5($_POST['password']);
                $ress = M('member')->where($data)->find();
                if($ress){
                    $this->ajaxReturn(array('status' => 1, 'info' => "修改成功"));
                }
                $res = M('member')->where(array('id' => $_SESSION['member_id']))->save($data);
                if ($res) {
                    $this->ajaxReturn(array('status' => 1, 'info' => "修改成功"));
                } else {
                    $this->ajaxReturn(array('status' => 0, 'info' => "修改失败"));
                }
            }
        }


    }

    public function invoice()
    {
        $this->display();
    }

    public function address()
    {
        $user_id = $_SESSION['member_id'];
        $address = M('Address');
        $addressList = $address->where(array('user_id' => $user_id))->order("`default` desc ,id desc")->select();
        $count = $address->where(array('user_id' => $user_id))->count();
        $num = 10 - $count;
        $this->assign('num', $num>0?$num:0);
        $this->assign('result', $addressList);
        $this->display();
    }

    /**
     * 添加地址
     */
    public function addressadd()
    {
        $user_id = $_SESSION['member_id'];
        $m = M('Address');
        $id = I('post.id');

        if (empty($id) || !isset($id)) {
            $num = $m->where(array("user_id" => $user_id))->count();
            if ($num >= 10) {
                $this->ajaxReturn(array("status" => 0, "info" => "地址最多10条记录不能再加了"));
            }
        }

        if (I('defaults')) {
            $default['default'] = 0;
            $m->where('user_id = %d', $user_id)->save($default);
            $data['default'] = 1;
        } else {
            $data['default'] = 0;
        }

        //组织数据
        $data['user_id'] = $user_id;
        $data['consignee'] = I('post.consignee');
        $data['province'] = I('post.province');
        $data['city'] = I('post.city');
        $data['district'] = I('post.district');
        $data['telephone'] = I('post.telephone');
        $data['place'] = I('post.place');

        if (empty($id) || !isset($id)) {
            $res = $m->add($data);
        } else {
            if(!$data['province'] || !$data['city'] || !$data['district']){
                unset($data['province']);
                unset($data['city']);
                unset($data['district']);
            }
            $res = $m->where('id = %d', $id)->save($data);
        }
        if ($res !== false) {
            $this->ajaxReturn(array("status" => 1, "info" => $id ? "修改成功！" : "添加成功！"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => $id ? "修改失败！" : "添加失败！"));
        }
    }

    /**
     * 设置默认地址
     */
    public function address_do()
    {
        $id = I('post.id');
        $user_id = $_SESSION['member_id'];
        $m = M('address');
        $default['default'] = 0;
        $m->where('user_id = %d', $user_id)->save($default);

        $data['id'] = $id;
        $data['user_id'] = $user_id;
        $default['default'] = 1;

        $res = $m->where($data)->save($default);
        if ($res) {
            $this->ajaxReturn(array("status" => 1, "info" => "设置成功！"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => "设置失败！"));
        }
    }

    /**
     * 地址删除
     */
    public function address_del()
    {
        $id = I('post.id');
        $user_id = $_SESSION['member_id'];
        $data['id'] = $id;
        $data['user_id'] = $user_id;
        $m = M('Address');
        $res = $m->where($data)->delete();
        if (!$res) {
            $this->ajaxReturn(array("status" => 0, "info" => "删除失败！"));
            exit;
        }
        $is_default = $m->where(array('user_id' => $user_id, 'default' => 1))->order("`default` desc ,id desc")->getfield('id');
        if (!$is_default) {
            $result = $m->where(array('user_id' => $user_id))->order("`default` desc ,id desc")->getfield('id');
            if ($result) {
                $set_default = $m->where(array('user_id' => $user_id))->order('id desc')->setfield('default', 1);
                if (!$set_default) {
                    $this->ajaxReturn(array('status' => 0, 'info' => '设置默认地址失败！'));
                    exit;
                }
            }
        }
        $this->ajaxReturn(array("status" => 1, "info" => "删除成功！"));
        exit;
    }

    public function password()
    {
        $this->display();
    }

    public function editPassword()
    {
        $password = M('member')->where(array('id' => $_SESSION['member_id']))->getField('password');
        if ($password != md5($_POST['nowpass'])) {
            $this->ajaxReturn(array('status' => 1, 'info' => "当前密码不正确！"));
        }

        $data['password'] = md5($_POST['password']);
        $res = M('member')->where(array('id' => $_SESSION['member_id']))->save($data);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => "修改成功"));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => "修改失败"));
        }

    }


    public function headImg()
    {
        if (IS_AJAX) {
            $data = $this->uploadImg();
            $a = $data[0]["savepath"] . substr(1) . $data[0]["savename"];
            $img = substr($a, 1);
            $Info = M('member')->where(array('id' => $_SESSION['member_id'], 'isdel' => 0, 'status' => 0))->save(array('person_img' => $img));

            if ($Info) {
                $this->ajaxReturn($data);
                $this->ajaxReturn(array("status" => 1, "info" => "头像修改成功！！"));
                exit;
            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "头像修改失败！！"));
                exit;
            }

        }
        $headimg = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
        //dump($headimg);exit;
        $this->assign('headimg',$headimg);
        $this->display();
    }


    public function SelIdentity(){
        $cardImg = M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->find();
        $this->assign('cardImg',$cardImg);
        $this->display();
    }

    public function headImg2()
    {
        if (IS_AJAX) {
            $data = $this->uploadImg();
            $a = $data[0]["savepath"] . substr(1) . $data[0]["savename"];
            $img = substr($a, 1);
            $Info = M('authentication')->where(array('user_id' => $_SESSION['member_id']))->save(array('card_img' => $img));

            if ($Info) {
                $this->ajaxReturn($data);
                $this->ajaxReturn(array("status" => 1, "info" => "头像修改成功！！"));
                exit;
            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "头像修改失败！！"));
                exit;
            }

        }
        $this->display();
    }

    public function headImg3()
    {
        if (IS_AJAX) {
            $data = $this->uploadImg();
            $a = $data[0]["savepath"] . substr(1) . $data[0]["savename"];
            $img = substr($a, 1);
            $Info = M('authentication')->where(array('user_id' => $_SESSION['member_id']))->save(array('card_img1' => $img));

            if ($Info) {
                $this->ajaxReturn($data);
                $this->ajaxReturn(array("status" => 1, "info" => "头像修改成功！！"));
                exit;
            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "头像修改失败！！"));
                exit;
            }

        }
        $this->display();
    }
    /**
     * /ZQJ 20171031 云推荐
     * @return [status] 
     */
    public function upload_logo(){
     
        
        $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>0))->count();
        if($count == 1){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，正在审核"));die;
        }
        header('Content-type:textml;charset=utf-8');
        $base64_image_content = $_POST['pic1'];
//匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $savepath = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath)) {
                mkdir($savepath);
            }
            $type_arr=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type,$type_arr)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type));exit;
            }
           $new_file = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file))
            {
                mkdir($new_file, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file = $savepath.time().".{$type}";
            if (!file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $this->ajaxReturn(array('status'=>0,'info'=>'图片上传失败','file_path'=>ltrim($new_file,'.')));exit;
            }
        }

        $base64_image_content2 = $_POST['pic2'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content2, $result2)){
            $type2 = $result2[2];
            $savepath2 = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath2)) {
                mkdir($savepath2);
            }
            $type_arr2=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type2,$type_arr2)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type2));exit;
            }
            $new_file2 = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file2))
            {
                mkdir($new_file2, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file2 = $savepath2.(time()+10).".{$type2}";
            if (file_put_contents($new_file2, base64_decode(str_replace($result2[1], '', $base64_image_content2)))){
                $data = I('post.');
                $data['addtime'] = strtotime(date("Y-m-d"));
                $data['user_id'] = $_SESSION['member_id'];
                $data['card_img'] = $new_file;
                $data['card_img1'] = $new_file2;
                M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->add($data);
                $this->ajaxReturn(array('status'=>1,'info'=>'提交成功','file_path'=>ltrim($new_file2,'.')));exit;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'提交失败','file_path'=>ltrim($new_file2,'.')));exit;
            }
        }

    }

    public function upload_base64(){
        import('@.ORG.Image.ThinkImage');
        $return=array('flag'=>0,'msg'=>'','img'=>'');
        $dir="./Uploads/image/headimg";

        $rand=substr(time(),-4);
        $image_name =$_SESSION['member_id'].'_'.$rand.".jpg";
        $img_str=$_POST['img_str'];
        $img_str=str_replace('data:image/jpeg;base64,','',$img_str);
        $img_str=str_replace('data:image/png;base64,','',$img_str);
        $img_str=str_replace('data:image/gif;base64,','',$img_str);
        file_put_contents($dir.'/'.$image_name,base64_decode($img_str));

        $return['flag']=1;
        $return['msg']='上传成功!';
        $return['img']= trim($dir, ".").'/thumb_'.$image_name;
        $img_source=$dir.'/'.$image_name;
        //生成缩略图
        $thumb=$dir.'/thumb_'.$image_name;
        $img = new \ThinkImage(THINKIMAGE_GD,$img_source);
        $img->thumb(200,200,THINKIMAGE_THUMB_FIXED)->save($thumb);
        //保存数据库
        M('authentication')->where(array('id'=>$_SESSION['member_id']))->save(array('card_img'=>trim($thumb, ".")));
        echo json_encode($return);
        exit;
    }
    /**
     *上传图片 czq
     */
    public function uploadImg() {
        $upload = new \Think\UploadFile;
        // $upload = new upload();// 实例化上传类
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg',"svg");// 设置附件上传类型
        $savepath='./Uploads/Picture/'.date('Ymd').'/';
        if (!file_exists($savepath)){
            mkdir($savepath);
        }
        $upload->savePath =  $savepath;// 设置附件上传目录
        if(!$upload->upload()) {// 上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
            $info =  $upload->getUploadFileInfo();
        }
        return $info;
    }
    public function addImage() {
        $data = $this->uploadImg();
        echo $data;exit();
        $this->ajaxReturn($data);
    }
    public function headImg1()
    {
        if (IS_AJAX) {
            $data = $this->uploadImg();
            $a = $data[0]["savepath"] . substr(1) . $data[0]["savename"];
            $img = substr($a, 1);
            $Info = M('member')->where(array('id' => $_SESSION['member_id'], 'isdel' => 0, 'status' => 0))->save(array('person_img' => $img));

            if ($Info) {
                $this->ajaxReturn($data);
                $this->ajaxReturn(array("status" => 1, "info" => "头像修改成功！！"));
                exit;
            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "头像修改失败！！"));
                exit;
            }

        }
        $headimg = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
        $this->assign('headimg',$headimg);
        $this->display();
    }

    //添加银行卡 jxx
    public function addBankCard()
    {
        $id = I('post.id');
        //var_dump(I('post.'));
        $map['user_id'] = $_SESSION['member_id'];
        $map['bank_no'] = $_POST['bank_no'];
        $map['bank_name'] = $_POST['bank_name'];
        $map['bank_branch'] = $_POST['bank_branch'];
        $map['username'] = $_POST['username'];
        $map['telephone'] = $_POST['telephone'];
        $map['create_at'] = strtotime(date("Y-m-d"));

        $ws = strlen($map['bank_no']);

        // if ($ws > 25 || $ws < 16) {

        //     $this->ajaxReturn(array("status" => 0, "info" => "请输入正确的银行卡号！"));
        // }
        // if (!preg_match("/^\d*$/", $map['bank_no'])) {

        //     $this->ajaxReturn(array("status" => 0, "info" => "请输入正确的银行卡号！！"));
        // }
        if (empty($id) || !isset($id)) {
            $res1 = M('bank_list')->where(array('bank_no'=>$map['bank_no'],'user_id'=>$map['user_id']))->find();
            if ($res1){
                $this->ajaxReturn(array("status" => 0, "info" => '该银行卡已被添加！'));
            }
            $res = M('bank_list')->add($map);
        } else {
            $res1 = M('bank_list')
                ->where(array('bank_no'=>$map['bank_no'],'id'=>array('neq',$id),'user_id'=>$map['user_id']))
                ->find();
            if ($res1){
                $this->ajaxReturn(array("status" => 0, "info" => '该银行卡已被添加！'));
            }
            $res = M('bank_list')->where('id = %d', $id)->save($map);
        }
        if ($res != false) {
            $this->ajaxReturn(array("status" => 1, "info" => $id ? "修改成功！" : "添加成功！"));
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => $id ? "修改失败！" : "添加失败！"));
        }
    }

    public function favorite()
    {
        $res = M('goods_collect')->where(array('user_id'=>$_SESSION['member_id']))->select();

        foreach ($res as $k=>$v){
            $goods = M('goods')->where(array('id'=>$v['good_id']))->select();
            $res[$k]['goods_name'] = $goods[0]['goods_name'];
            $res[$k]['goods_cap']  = $goods[0]['goods_cap'];
            $res[$k]['index_pic']  = $goods[0]['index_pic'];
            $res[$k]['price']      = $goods[0]['price'];
        }

        $this->assign('res',$res);
        $this->display();
    }

    public function delCollect(){
        $res = M('goods_collect')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->ajaxReturn(array("status" => 1, "info" => "移除成功"));
        }else{
            $this->ajaxReturn(array("status" => 0, "info" => "移除失败"));
        }
    }

    public function share()
    {
        $this->display();
    }

    public function shareDetails()
    {
        $this->display();
    }

    public function memberLevel()
    {
        $res = M('member_level')->find();
        $this->assign('res',$res);

        $person_name = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
        $this->assign('person_name',$person_name);

        $rz = M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->getField('status');
        $this->assign('rz',$rz);
        $tel = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>1))->find();
        $this->assign('tel',$tel);
        $this->display();
    }

    public function evaluateDetails()
    {
        $this->display();
    }

	/*
	*ZQJ 20171028
	*
	*/
    public function orderDetails()
    {
		if(IS_AJAX){
			$order_no  = I('order_no');
			if(!$order_no){
				$data['status'] = 0;
				$data['info'] = "订单不存在！";
 				$this->ajaxReturn($data);
			}
			$res = M('order_info')->where(array('order_no'=>$order_no))->find();
			if(!$res){
				$data['status'] = 0;
				$data['info'] = "订单不存在！";
 				$this->ajaxReturn($data);
			}
			$data['status'] = 1;
			$this->ajaxReturn($data);
			
		}
        $res = M('order_info')->where(array('id'=>$_GET['id']))->find();


        $res1 = M('order_goods')->where(array('order_id'=>$_GET['id']))->select();
        foreach ($res1 as $k=>$v){
            //$order_goods = M('order_goods')->where(array('order_id'=>$v['id']))->find();
            $zujin = M('goods')->where(array('id'=> $v['goods_id']))->getField('zujin');
            $res1[$k]['goods_name'] = $v['goods_name'];
            $res1[$k]['goods_spic'] = $v['goods_spic'];
            $res1[$k]['goods_cap'] = $v['goods_cap'];
            $res1[$k]['goods_nums'] = $v['goods_nums'];
			$res1[$k]['goods_price'] = $v['goods_price'];
			$username = M('member')->where(array('id'=>$v['user_id']))->find();
			$res1[$k]['realname'] = $username['realname'];
			$goods_cap = M('goods')->where(array('id'=>$v['goods_id']))->find();
			$res1[$k]['goods_cap'] = $goods_cap['goods_cap'];
            $res1[$k]['zujin'] =  $zujin;
            $res1[$k]['is_groom'] = $goods_cap['is_groom'];

        }
        //print_r($res1);
        $this->assign('res1',$res1);

        //物流信息
        $res2 = $this->getOrderTracesByJson($res['express_name'],$res['express_no']);
        $express = json_decode($res2,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $res['express_name'] =  M("express")->where(array("express_ma"=>$res['express_name']))->getField("express_company");
        //todo 加入优惠卷
        $this->assign("express", $exp);

        //物流信息
        $reszu = $this->getOrderTracesByJson($res['zuexpress_name'],$res['zuexpress_no']);
        $zuexpress = json_decode($reszu,true);
        if($zuexpress['Success']){
            $zuexp = $zuexpress['Traces'];
        }
        //快递编码转换成快递公司名称
        $res['zuexpress_name'] =  M("express")->where(array("express_ma"=>$res['zuexpress_name']))->getField("express_company");
        //todo 加入优惠卷
        $this->assign("zuexpress", $zuexp);

		//print_r($res1[0]['is_recommend']);
		//print_r($res1);
        $this->assign('res',$res);
        
		$this->assign('is_groom',$res1[0]['is_recommend']);
        $this->display();
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
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    public  function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }

    public function delOrder(){
        $res = M('order_info')->where(array('id'=>$_POST['id']))->save(array('order_status'=>0));
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"取消成功"));
        }else{
            $this->ajaxReturn(array('status'=>1,'info'=>"取消失败"));
        }
    }

    /**
     * WZZ
     * 取消订单
     * 判断订单状态是否处于可取消状态  假如使用优惠券  使优惠券解锁
     * 可取消状态：1
     */
    public function cancelOrder(){
        if(IS_AJAX){
            $userid = $_SESSION['member_id'];
            $id = I("post.order_id");
            $m = M("order_info");
            $map = array("user_id"=>$userid,"id"=>$id,"order_status"=>1);
            $order_res = $m->where($map)->find();
            if(!$order_res){
                $this->ajaxReturn(array("status"=>0, "info"=>"无效的订单！"));
            }
            M()->startTrans();
            $order_gooods = M('order_goods')->where(array('order_id'=>$id))->select();
            $res = $m->where($map)->save(array("order_status"=>0, "is_valid"=>0));
            if(!$res){
                M()->rollback();
                $this->ajaxReturn(array("status"=>0, "info"=>"取消订单失败！"));
            }
            //取消订单 恢复代金券
            if($order_res['couponsid']){
                //print_r($order_res['couponsid']);die;
                $oror = M('link_coupon')->where(array('user_id'=>$userid,'id'=>$order_res['couponsid']))->find();
                if($oror){
                    if($oror['status'] == 2){
                        $coup = M('link_coupon')->where(array('user_id'=>$userid,'id'=>$order_res['couponsid']))->setField('status',1);
                        if(!$coup){
                            M()->rollback();
                            $this->ajaxReturn(array("status"=>0, "info"=>"取消订单失败！"));
                        }
                    }

                }

            }
            //取消订单回复库存
            foreach ($order_gooods as $v){
                $cstore = M("goods")->where(array('id'=>$v['goods_id']))->getField('cstore');
                if($cstore == 0){//艺术品
                    $res1 = M("goods")->where(array('id'=>$v['goods_id']))->setField('store',1);
                }else{
                    $res1 = M("goods")->where(array('id'=>$v['goods_id']))->setInc('store',$v['goods_nums']);
                }
                if (!$res1) {
                    M()->rollback();
                    $this->ajaxReturn(array("status"=>0, "info"=>"取消订单失败！"));
                }
            }
            //结束
            //如果使用优惠券 解锁优惠券
            /*if($order_res['coupon_id']){
                M('link_coupon')->where(array('user_id'=>$userid,'coupon_id'=>$order_res['coupon_id'],'status'=>2))->setField('status',1);//待使用状态
            }*/
            M()->commit();
            $this->ajaxReturn(array("status"=>1, "info"=>"取消订单成功！"));
        }
        $this->error("非法访问！");
    }



    /**
     * 参拍宝贝
     */
    public function buyerCan(){
        $user_id = $this->user_id;


        $count = M('order_pmding as o')
            ->join('left join app_pm as p on o.goods_id =p.id')
            ->where(array('o.user_id'=>$user_id,'o.order_status'=>1,'p.end'=>array('gt',time())))
            ->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('order_pmding as o')
            ->join('left join app_pm as p on o.goods_id =p.id')
            ->where(array('o.user_id'=>$user_id,'o.order_status'=>1,'p.end'=>array('gt',time())))
            ->field('o.*,p.end,p.promulgator,p.dangqian')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('p.start')
            ->select();
        foreach ($res as $k=>$v){
            $chujia = M('chujia')->where(array('goods_id'=>$v['goods_id']))->order('id desc')->find();
            if ($chujia!=''&& $chujia!=null){
                $res[$k]['dangqian']=$chujia['jiage'];
            }
            if ($chujia['user_id']==$user_id){
                $res[$k]['zt']=1;
            }else{
                $res[$k]['zt']=0;
            }
        }

        $this->assign("res",$res );
        $this->display();
    }

    /**
     * 已拍下
     */
    public function buyerXia(){
        $user_id = $this->user_id;

        $count = M('order_pm')->where(array('user_id'=>$user_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('order_pm')
            ->where(array('user_id'=>$user_id))
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('id desc')
            ->select();
        foreach ($res as $k=>$v){
            $pm = M('pm')->where(array('id'=>$v['goods_id']))->find();
            $pmding = M('order_pmding')->where(array('goods_id'=>$v['goods_id']))->find();
            $res[$k]['promulgator']=$pm['promulgator'];
            $res[$k]['chengjiao'] = $v['total_price']+$pmding['baoding'];
            $res[$k]['logo_pic'] = $pm['logo_pic'];
            $res[$k]['goods_name'] = $pm['goods_name'];
            $res[$k]['goods_cap'] = $pm['goods_cap'];
            $res[$k]['heji'] = $v['total_price']+$pmding['baoding']+$v['return_price'];
            $res[$k]['ding'] = $pmding['id'];
            $res[$k]['baoding'] = $pmding['baoding'];
            /*if ($v['end']>time()){
                $res[$k]['times'] = $v['end'] - time();
                $res[$k]['times_h'] = floor($res[$k]['times']/60/60%24);
                $res[$k]['times_m'] = floor($res[$k]['times']/60%60);
                $res[$k]['times_s'] = floor($res[$k]['times']%60);
            }else{*/
            // $res[$k]['times'] = 0;
            //}
        }
        //dump($res);
        $this->assign("res",$res );
        $this->display();
    }
    /**
     * 已拍下
     */
    public function buyerXia1(){
        $user_id = $this->user_id;
        $res = M('order_pm')->where(array('user_id'=>$user_id))->order('id desc')->select();
        foreach ($res as $k=>$v){
            $pm = M('pm')->where(array('id'=>$v['goods_id']))->find();
            $pmding = M('order_pmding')->where(array('goods_id'=>$v['goods_id']))->find();
            $res[$k]['promulgator']=$pm['promulgator'];
            $res[$k]['chengjiao'] = $v['total_price']+$pmding['baoding'];
            $res[$k]['logo_pic'] = $pm['logo_pic'];
            $res[$k]['goods_name'] = $pm['goods_name'];
            $res[$k]['goods_cap'] = $pm['goods_cap'];
            $res[$k]['heji'] = $v['total_price']+$pmding['baoding']+$v['return_price'];
            $res[$k]['ding'] = $pmding['id'];
            $res[$k]['baoding'] = $pmding['baoding'];
            /*if ($v['end']>time()){
                $res[$k]['times'] = $v['end'] - time();
                $res[$k]['times_h'] = floor($res[$k]['times']/60/60%24);
                $res[$k]['times_m'] = floor($res[$k]['times']/60%60);
                $res[$k]['times_s'] = floor($res[$k]['times']%60);
            }else{*/
               // $res[$k]['times'] = 0;
            //}
        }
        //dump($res);
        $this->assign("res",$res );
        $this->display();
    }

    /**
     * 拍卖订单详情
     */
    /*
    public function buyerXiadd(){
        $user_id = $this->user_id;
        $id = I('get.id');
        $res = M('order_pm')->where(array('user_id'=>$user_id,'id'=>$id))->find();

            $pm = M('pm')->where(array('id'=>$res['goods_id']))->find();

            $pmding = M('order_pmding')->where(array('goods_id'=>$res['goods_id']))->find();

            $res['chengjiao'] = $res['total_price']+$res['baoding'];


            $res['heji'] = $res['total_price']+$res['baoding']+$res['return_price'];

        dump($pm);
        $this->assign("pm",$pm );
        $this->assign("pmding",$pmding );
        $this->assign("res",$res );
        $this->display();
    }*/

    /**
     * 保证金
     */
    public function buyerJin(){
        $user_id = $this->user_id;

        $count = M('order_pmding')->where(array('user_id'=>$user_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        //->join('app_pm ON order_pmding.goods_id = app_pm.goods_id')
        $pm = M('order_pmding')->where(array('user_id'=>$user_id))->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
        //dump($pm);die;
        $this->assign("pm",$pm );
        $this->display();
    }

    //删除提醒
    public function remindDel(){
        if (IS_AJAX){
            $user_id = $_SESSION['member_id'];
            $id = I('post.id');
            $res = M('pmtel_remind')->where(array('user_id'=>$user_id,'id'=>$id))->save(array('is_del'=>1));
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"删除成功"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"删除失败"));
            }
        }
    }

    /**
     * 我的提醒
     */
    public function buyerMy(){
        $user_id = $this->user_id;
        $res = M('pmtel_remind')->where(array('user_id'=>$user_id,'is_lx'=>0,'is_del'=>0))->select();
        foreach ($res as $k=>$v){
            $pm = M('pm')->where(array('id'=>$v['goods_id'],'end'=>array('gt',time())))->find();
            if ($pm){
                $chujia = M('chujia')->where(array('goods_id'=>$v['goods_id']))->order('jiage desc')->find();
                $res[$k]['end']=$pm['end'];
                $res[$k]['start']=$pm['start'];
                $res[$k]['logo_pic']=$pm['logo_pic'];
                $res[$k]['promulgator']=$pm['promulgator'];
                if ($chujia!=''&& $chujia!=null){
                    $res[$k]['dangqian']=$chujia['jiage'];
                }else{
                    $res[$k]['dangqian']=$pm['dangqian'];
                }
                if ($chujia['user_id']==$user_id){
                    $res[$k]['zt']=1;
                }else{
                    $res[$k]['zt']=0;
                }
            }else{
                unset($res[$k]);
            }

        }


        $res1 = M('pmtel_remind')->where(array('user_id'=>$user_id,'is_lx'=>1,'is_del'=>0))->select();
        foreach ($res1 as $k=>$v){
            $num = M('pm_num')->where(array('id'=>$v['num_id'],'end_time'=>array('gt',time())))->find();
            if ($num){
                $pm1 = M('pm')->where(array('num_id'=>$num['id']))->select();
                $pm_ids = '';
                foreach ($pm1 as $v){
                    $pm_ids .= $v['id'];
                }
                $chujia = M('chujia')->where(array('goods_id'=>array('in',$pm_ids)))->count();
                $res1[$k]['end']=$num['end_time'];
                $res1[$k]['zcj']=$chujia;
                $res1[$k]['start']=$num['start_time'];
            }else{
                unset($res1[$k]);
            }

        }
        $this->assign("res",$res );
        $this->assign("res1",$res1 );
        $this->assign("now_time",time() );
        $this->display();
    }

    /**
     * 查看保定金
     */
    public function buyerJinDetails(){
        $id = I('get.baoding');
        $res = M('order_pmding')->where(array('id'=>$id))->find();
        $pm = M('pm')->where(array('id'=>$res['goods_id']))->find();
        $res['promulgator']=$pm['promulgator'];
        //dump($pm);die;
        $this->assign("res",$res );
        $this->display();
    }

    /*
    *店铺管理
    */
    public function selCenter(){
        $user_id = $_SESSION['member_id'];
        //$owner = M('member')->where(array('id'=>$user_id))->getField('person_name');
        $sql = "select person_name,realname,telephone,card_id,email from app_member where id=$user_id";
        $owner = M()->query($sql);
        /*if(!$owner){
            $this->error('您的账号信息不够完善！',U('/Home/PersonalCenter/userInfo/id/').{$user_id});
        }*/
        $this->assign('owner',$owner);
        $this->display();
    }

    public function seldpsy(){
        $this->display();
    }
	
    public function selNotice()
    {
        $this->display();
    }

    public function selCompanyNotice()
    {
        $this->display();
    }

    public function selCertified()
    {	
		//console.log($count11);
        $res = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>1))->find();
        if($res == null | $res == ''){
            $this->assign('res',0);
        }else{
            $this->assign('res',$res);
        }

        $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->count();
        $this->assign('count',$count);

        $person_type = M('my_shop')->where(array('user_id'=>$_SESSION['member_id']))->getField('person_type');
        $this->assign('type',$person_type);
        $this->display();
    }

    public function selAgree()
    {
        $personType = $_GET['personType'];
        $this->assign('personType',$personType);
        $is_depute = $_GET['is_depute'];
        $this->assign('is_depute',$is_depute);
        $this->display();
    }
    public function zl(){
        $res = M('my_shop')->where(array('person_type'=>$_POST['personType'],'is_depute'=>$_POST['is_depute'],'user_id'=>$_SESSION['member_id']))->find();
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，后台正在为您审核！请稍等"));die;
        }
        $data['person_type'] = $_POST['personType'];
        $data['is_depute'] = $_POST['is_depute'];
        $data['user_id'] = $_SESSION['member_id'];
        $data['create_time'] = time();
        $res = M('my_shop')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"资料提交失败"));
        }
    }

    public function hlgl(){

        $user_id = $_SESSION['member_id'];        
        if(IS_POST){
            $data = I('post.');

            $data['create_at'] = time();       
            $data['owner_id'] = $user_id;
            $data['art_cate'] = "";
            //dump($data);exit;
            $res = M('gallery')->add($data);
            if($res){
                $this->success('提交成功',U('Wxin/PersonalCenter/userinfo'));
            }else{
                $this->error('提交失败',U('Wxin/PersonalCenter/hlgl'));
            }
            $this->redirect('Wxin/PersonalCenter/userinfo');
            
        }
        $art_cate = M('art_cate')->select();
        $this->assign('art_cate',$art_cate);
        $this->display();
    }


    /**分类
     * screens
     */
    public function screens(){

        $user_id = $this->user_id;
        $res = M('ruzhu')->where(array('user_id'=>$user_id))->getField('series_ids');
        $cate = M('pm_cate')->where(array('level=2','isdel'=>0,'id'=>array('in',$res)))->select();
        $this->assign('screens',$cate);
    }

    /**
     * 添加拍卖
     */
    public function buyerAddPm(){
        $user_id = $_SESSION['member_id'];
        $res = M('ruzhu')->where(array('user_id'=>$user_id,'pay_status'=>1))->find();
        if ($res){
            if (IS_AJAX){
                $data1 = I('post.');

                if(!$data1['series_id']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作品分类必选！';
                    $this->ajaxReturn($dataAj);die;
                }
                /*if(!$data1['goods_des']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作品描述必填！';
                    $this->ajaxReturn($dataAj);die;
                }*/
                if(!$data1['logo_pic']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作品展示图必传！';
                    $this->ajaxReturn($dataAj);die;
                }
                /*if(!$data1['serial']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作者头像必传！';
                    $this->ajaxReturn($dataAj);die;
                }*/
              /*  if(!$data1['detail']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作者简介必填！';
                    $this->ajaxReturn($dataAj);die;
                }*/


                $m      = M("pm");
                $g_s  = M("pm_slide");
                $data   = I("post.");
                //保存产品属性 zj
                //dump($data);die;
                //发拍卖方
                $res = M('ruzhu')->where(array('user_id'=>$user_id,'pay_status'=>1))->find();
                $data['promulgator']=$res['id'];
                /*$data['start'] = strtotime($data['start']);
                $data['end'] = strtotime($data['end']);*/

                $data['member']=$_SESSION['member_id'];
                $data['dangqian'] = $data['start_price'];
                $data['weight'] = $data['weight']?$data['weight']:0;
                $data['shenhe']=0;
                $slide_pic = $data['pic1'];
                unset($data['pic1']);
                $res = $m->add($data);
                if($res){
                    foreach($slide_pic as $k=>$v){
                        $slide_data = array(
                            "goods_id"   => $res,
                            "sort"       => $k,
                            "create_at"  => time(),
                            "pic"        => $v,
                            "status"     => 1,
                        );
                        $g_s->add($slide_data);
                    }
                }else{

                    $dataAj['status'] = 0;
                    $dataAj['info'] = '新增拍卖失败！';
                    $this->ajaxReturn($dataAj);die;
                    //$iUrl = U("/Home/PersonalCenter/buyerListPm/tag/buyerListPm");
                    //echo "<script>alert('新增拍卖失败！');window.location.href='".$iUrl."';</script>";
                    //$this->error("新增拍卖失败！",U('/Home/PersonalCenter/buyerListPm/tag/buyerListPm'));
                }
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增拍卖成功！';
                $this->ajaxReturn($dataAj);die;
            }
            $this->screens();

            //产品属性选择  zj
            $mm = M("goods_attribute");
            $map = array(
                "pid" => 0,
                "isdel" => 0,
            );

            //$attr1 = $mm->where($map)->where(array('classname'=>'材质'))->find();
            $caizhi = $mm->where(array("pid" => 25))->select();
            $this->assign("caizhi", $caizhi);

            //$attr2 = $mm->where($map)->where(array('classname'=>'材料'))->find();
            $cailiao = $mm->where(array("pid" => 23))->select();
            $this->assign("cailiao", $cailiao);

            //$attr3 = $mm->where($map)->where(array('classname'=>'尺寸'))->find();
            $chichun = $mm->where(array("pid" => 7))->select();
            $this->assign("chichun", $chichun);

            //$attr4 = $mm->where($map)->where(array('classname'=>'年代'))->find();
            $niandai = $mm->where(array("pid" => 13))->select();
            $this->assign("niandai", $niandai);

            //$attr5 = $mm->where($map)->where(array('classname'=>'品相'))->find();
            $pinxiang = $mm->where(array("pid" => 24))->select();
            $this->assign("pinxiang", $pinxiang);

            $this->display();
        }else{
            $iUrl = U("/Wxin/Pm/paimaiRuzhu");
            echo "<script>window.location.href='".$iUrl."';</script>";
            $this->display();
            //$this->error("你还未入驻！",U('/Home/Pm/paimaiRuzhu'));
        }


    }




    /**
     * 修改拍卖
     */
    public function buyerEditPm(){
        $user_id = $_SESSION['member_id'];
        $res = M('ruzhu')->where(array('user_id'=>$user_id,'pay_status'=>1))->find();
        if ($res){
            if (IS_AJAX){
                $data1 = I('post.');

                /*if(!$data1['goods_des']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作品描述必填！';
                    $this->ajaxReturn($dataAj);die;
                }*/

                /*if(!$data1['detail']){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = '作者简介必填！';
                    $this->ajaxReturn($dataAj);die;
                }*/

                $m      = M("pm");
                $g_s  = M("pm_slide");
                $data   = I("post.");
                //dump($data);die;
                //保存产品属性 zj
                //dump($data);die;
                //发拍卖方
                //$data['promulgator']=1;
                /*$data['start'] = strtotime($data['start']);
                $data['end'] = strtotime($data['end']);*/
                $id                 = $data['id'];
                $data['dangqian'] = $data['start_price'];
                $data['shenhe']=0;
                $data['weight'] = $data['weight']?$data['weight']:0;
                $slide_pic = $data['pic1'];
                unset($data['pic1']);
                unset($data['id']);
                if (!$id) {

                    $dataAj['status'] = 0;
                    $dataAj['info'] = '缺少参数！';
                    $this->ajaxReturn($dataAj);die;
                    //$iUrl = U("/Home/PersonalCenter/buyerListPm/tag/buyerListPm");
                    //echo "<script>alert('缺少参数！');window.location.href='".$iUrl."';</script>";
                    //$this->error("缺少参数！");
                }
                if ($data['is_chaogao']==''){
                    $data['is_chaogao']=0;
                }
                $res = $m->where(array("id"=>$id,'isdel'=>0))->save($data);
                if ($res !== false) {
                    foreach ($slide_pic as $k=>$v) {
                        $slide_data = array(
                            "goods_id"   => $id,
                            "sort"       => $k,
                            "create_at"  => NOW_TIME,
                            "pic"        => $v,
                            "status"     => 1,
                        );
                        $g_s->add($slide_data);
                    }
                }else{

                    $dataAj['status'] = 0;
                    $dataAj['info'] = '修改拍卖失败！';
                    $this->ajaxReturn($dataAj);die;
                    //$iUrl = U("/Home/PersonalCenter/buyerListPm/tag/buyerListPm");
                    //echo "<script>alert('修改拍卖失败！');window.location.href='".$iUrl."';</script>";
                    //$this->error("修改拍卖失败！",U('/Home/PersonalCenter/buyerListPm/tag/buyerListPm'));
                }

                $dataAj['status'] = 1;
                $dataAj['info'] = '修改拍卖成功！';
                $this->ajaxReturn($dataAj);die;

            }

            $this->screens();


            $id = I("id");
            if (!$id) {
                echo "<script>alert('缺少参数！');window.history.back();</script>";
            }
            $goods = M("pm")->where(array('id'=>$id, "is_del"=>0))->find();
            if (!$goods) {
                echo "<script>alert('无此拍卖！');window.history.back();</script>";
            }
            $this->assign("goods", $goods);

            $pm_slide = M("pm_slide")->where(array('goods_id'=>$id, "status"=>1))->select();
            $this->assign("pm_slide", $pm_slide);

            //产品属性选择  zj
            $mm = M("goods_attribute");
            $map = array(
                "pid" => 0,
                "isdel" => 0,
            );

            //$attr1 = $mm->where($map)->where(array('classname'=>'材质'))->find();
            $caizhi = $mm->where(array("pid" => 25))->select();
            $this->assign("caizhi", $caizhi);

            //$attr2 = $mm->where($map)->where(array('classname'=>'材料'))->find();
            $cailiao = $mm->where(array("pid" => 23))->select();
            $this->assign("cailiao", $cailiao);

            //$attr3 = $mm->where($map)->where(array('classname'=>'尺寸'))->find();
            $chichun = $mm->where(array("pid" => 7))->select();
            $this->assign("chichun", $chichun);

            //$attr4 = $mm->where($map)->where(array('classname'=>'年代'))->find();
            $niandai = $mm->where(array("pid" => 13))->select();
            $this->assign("niandai", $niandai);

            //$attr5 = $mm->where($map)->where(array('classname'=>'品相'))->find();
            $pinxiang = $mm->where(array("pid" => 24))->select();
            $this->assign("pinxiang", $pinxiang);


            $this->display();
        }else{
            $iUrl = U("/Wxin/Pm/paimaiRuzhu");
            echo "<script>window.location.href='".$iUrl."';</script>";
            $this->display();
            //$this->error("你还未入驻！",U('/Home/Pm/paimaiRuzhu'));
        }


    }


    /**
     * 拍卖列表
     */
    public function buyerListPm(){
        $user_id = $_SESSION['member_id'];
        $ruzhu = M('ruzhu')->where(array('user_id'=>$user_id,'pay_status'=>1))->find();

        $count = M('pm')->where(array('is_del'=>0,'promulgator'=>$ruzhu['id']))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('pm')->where(array('is_del'=>0,'promulgator'=>$ruzhu['id']))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("res", $res);

        /*//拍卖成功
        $res1 = M('settl as s')->where(array('s.user_id'=>$ruzhu['id']))->join('left join app_pm as p on p.id = s.goods_id')
            ->field('s.*,p.goods_name')
            ->order('s.addtime desc')->select();
        $this->assign("res1", $res1);*/
        //dump($res);
        $this->display();

    }

    /**
     * 拍卖结算列表
     */
    public function buyerListSettl(){
        $user_id = $_SESSION['member_id'];
        $ruzhu = M('ruzhu')->where(array('user_id'=>$user_id,'pay_status'=>1))->find();
        //拍卖成功
        $count = M('settl as s')->where(array('s.user_id'=>$ruzhu['id']))->join('left join app_pm as p on p.id = s.goods_id')->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res1 = M('settl as s')->where(array('s.user_id'=>$ruzhu['id']))->join('left join app_pm as p on p.id = s.goods_id')
            ->field('s.*,p.goods_name')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order('s.addtime desc')->select();
        $this->assign("res1", $res1);
        //dump($res);
        $this->display();

    }

    /**
     * 删除拍卖
     */
    public function buyerDelPm(){
        $id  = $_GET['id'];
        $res = M("pm")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $iUrl = U("/Wxin/PersonalCenter/buyerListPm/tag/buyerListPm");
            echo "<script>alert('删除成功！');window.location.href='".$iUrl."';</script>";
            //$this->success("删除成功！");die;
        }
        $iUrl = U("/Wxin/PersonalCenter/buyerListPm/tag/buyerListPm");
        echo "<script>alert('删除失败！');window.location.href='".$iUrl."';</script>";
        //$this->error("删除失败！");die;
        $this->display();
    }


    public function changePmOrderStatus(){

        $res = M('order_pm')->where(array('id'=>$_POST['id']))->save(array('order_status'=>4,'receive_time'=>time()));
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"签收成功"));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"签收失败"));
        }
    }

    public function orderPmDetails(){
        $id = I('get.id');
        $res = M('order_pm')->where(array('id'=>$id))->find();
        $pmding = M('order_pmding')->where(array('goods_id'=>$res['goods_id']))->find();
        //dump($res);
        $res['heji'] = $res['total_price']+$pmding['baoding']+$res['return_price'];
        $this->assign("res", $res);

        $goods = M('pm')->where(array('id'=>$res['goods_id']))->find();
        $this->assign("goods", $goods);

        //物流信息
        $res2 = $this->getOrderTracesByJson($res['express_name'],$res['express_no']);
        $express = json_decode($res2,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $order['express_name'] =  M("express")->where(array("express_ma"=>$res['express_name']))->getField("express_company");
        //todo 加入优惠卷
        $this->assign("express", $exp);


        $this->display();
    }

    //展览  参展
    public function canzhan(){
        $user_id = $_SESSION['member_id'];
        $count = M('cz as c')->join('app_art_show as s on s.id=c.show_id')->where(array('c.user_id'=>$user_id,'c.is_del'=>0))->field('c.*,s.title')->order("c.create_time desc")->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('cz as c')
            ->join('app_art_show as s on s.id=c.show_id')
            ->where(array('c.user_id'=>$user_id,'c.is_del'=>0))
            ->field('c.*,s.title')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->order("c.create_time desc")
            ->select();
        $this->assign("res", $res);
        //dump($res);
        $this->display();
    }
    //展览  参展 详情
    public function czDetail(){
        $id = I('get.id');
        $user_id = $_SESSION['member_id'];
        $res = M('cz')->where(array('id'=>$id,'user_id'=>$user_id))->find();
        $this->assign("res", $res);
        $img = M('cz_pic')->where(array('cz_id'=>$res['id']))->select();
        $this->assign("img", $img);

        $series = M('series')->where(array('id'=>$res['series']))->find();
        $this->assign("series", $series);

        $this->display();
    }

    //展览  办展
    public function banzhan(){

        $user_id = $_SESSION['member_id'];
        $count = M('art_show')->where(array('user_id'=>$user_id,'is_del'=>0))->order("create_time desc")->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('art_show')
            ->where(array('user_id'=>$user_id,'is_del'=>0))
            ->order("create_time desc")
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $this->assign("res", $res);
        $this->display();
    }

    //展览  办展 详情
    public function bzDetail(){

        $id = I('get.id');
        $user_id = $_SESSION['member_id'];
        $res = M('art_show')->where(array('user_id'=>$user_id,'id'=>$id))->find();
        $this->assign("res", $res);
        /*$series = M('series')->where(array('id'=>$res['series']))->find();
        $this->assign("series", $series);*/
        $this->display();
    }

    //删除参展
    public function canzhanDel(){
        if (IS_AJAX){
            $user_id = $_SESSION['member_id'];
            $id = I('post.id');
            $res = M('cz')->where(array('user_id'=>$user_id,'id'=>$id))->save(array('is_del'=>1));
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"删除成功"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"删除失败"));
            }
        }
    }

    //删除办展
    public function banzhanDel(){
        if (IS_AJAX){
            $user_id = $_SESSION['member_id'];
            $id = I('post.id');
            $res = M('art_show')->where(array('user_id'=>$user_id,'id'=>$id))->save(array('is_del'=>1));
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"删除成功"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"删除失败"));
            }
        }
    }

    //申请入驻机构发布众筹
    /*
     * 阅读协议
     * */
    public function crowdAgree(){
        if(IS_AJAX){
            $data['user_id'] = $_SESSION['member_id'];
            $data['xieyi'] = 1;
            $data['ruzhu_status'] = 1;
            $res = M('crowd_apply')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/PersonalCenter/crowdIdentity'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'请重新选择同意！'));
            }
        }
        $content = M('protocol')->where(array('id'=>3))->getField('content');
        $this->assign('content',$content);
        $this->display();
    }

    public function crowdIdentity(){
        if(IS_AJAX){
            $data = I('post.');
            //print_r($data);exit;
            $date['name'] = $data['name'];
            $date['tel'] = $data['tel'];
            $date['f_card'] = $data['cardID'];
            $date['address'] = $data['address'];
            $date['f_zpic'] = $data['pic1'];
            $date['f_fpic'] = $data['pic2'];
            $date['s_province'] = $data['province'];
            $date['s_city'] = $data['city'];
            $date['s_county'] = $data['district'];
            $date['qy_name'] = $data['org_name'];
            $date['qy_zhi'] = $data['business'];
            $date['zhuz_jigou'] = $data['organize'];
            $date['qy_zhipic'] = $data['business_img'];
            $date['zhuz_pic'] = $data['organize_img'];
            $date['addtime'] = time();
            $date['shenhe'] = 1;
            $date['ruzhu_status'] = 2;
            $res1 = M('crowd_apply')->where(array('user_id'=>$_SESSION['member_id']))->save($date);
            if($res1){
                $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/PersonalCenter/crowdAudit'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'提交失败，请重新填写！'));
            }
        }
        $res = M('crowd_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        $this->assign('res',$res);
        $this->display();
    }

    public function crowdAudit(){

        $res = M('crowd_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        //dump($res);exit;
        $this->assign('res',$res);
        $this->display();
    }

    //参与众筹
    public function crowdCan(){
        $user_id = $_SESSION['member_id'];
        $count = M('order_crowd')
            ->alias('a')
            ->join('left join app_crowd_apply b on a.shop_id=b.id')
            ->join('left join app_crowd c on a.crowd_id=c.id')
            //->join('left join app_member c on a.user_id=c.id')
            ->field('a.*,b.qy_name,c.goods_name,c.logo_pic,c.goods_cap')
            //->where(array('user_id'=>$_SESSION['member_id'],'order_status'=>2))->select();
            ->where(array('a.user_id'=>$_SESSION['member_id'],'a.order_status'=>2))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('order_crowd')
            ->alias('a')
            ->join('left join app_crowd_apply b on a.shop_id=b.id')
            ->join('left join app_crowd c on a.crowd_id=c.id')
            //->join('left join app_member c on a.user_id=c.id')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->field('a.*,b.qy_name,c.goods_name,c.logo_pic,c.goods_cap')
            //->where(array('user_id'=>$_SESSION['member_id'],'order_status'=>2))->select();
            ->where(array('a.user_id'=>$_SESSION['member_id'],'a.order_status'=>2))->select();
        $this->assign('res',$res);
       //dump($res);exit;
        $this->display();
    }

    public function crowdRec(){
        $user_id = $_SESSION['member_id'];
        $apply_id = M('crowd_apply')->where(array('user_id'=>$user_id,'shenhe'=>2))->getField('id');
        $res = M('crowd')
            ->where(array('promulgator'=>$user_id))
            ->select();
        foreach($res as $k=>$v){
            $res[$k]['total'] = M('order_crowd')->where(array('crowd_id'=>$v['id']))->sum('pay_price');
            $res[$k]['end'] = $res[$k]['end']+24*3600;
        }
        $this->assign('res',$res);
        $this->display();
    }

    //添加投稿
    public function user_vote(){
        if(IS_AJAX) {

            $m      = M("news");
            $data   = I("post.");
            $data['user_id'] = $_SESSION['member_id'];
            $data['addtime'] = strtotime(I('post.addtime'));
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                $this->ajaxReturn($dataAj);
                die;
                //$this->success("新增成功！",U('Admin/goods/news'));

            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '新增失败！';
                $this->ajaxReturn($dataAj);
                die;
                //$this->error("新增失败！",U('Admin/goods/news'));
            }
            //$this->redirect('Admin/goods/news');
        }

        $news_cate = M('news_cate')->select();
        $this->assign('news',$news_cate);
        $this->display();
    }

    //投稿列表
    public function newlist(){

        $user_id = $_SESSION['member_id'];
        $count = M('news')->where(array('user_id'=>$user_id,'is_del'=>0))->order("addtime desc")->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);/*->limit($Page->firstRow.','.$Page->listRows)*/
        $res = M('news')->where(array('user_id'=>$user_id,'is_del'=>0))->order("addtime desc")->select();
        $this->assign("res", $res);
        $this->display();
    }

    //修改投稿
    public function edituser_vote(){
        if(IS_AJAX) {
            $m      = M("news");
            $data   = I("post.");
            $data['addtime'] = strtotime(I('post.addtime'));
            if(!$data['id']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '非法操作！';
                $this->ajaxReturn($dataAj);
                die;
            }
            $res = $m->where(array('id'=>$data['id']))->save($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '修改成功！';
                $this->ajaxReturn($dataAj);
                die;
                //$this->success("新增成功！",U('Admin/goods/news'));

            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '修改失败！';
                $this->ajaxReturn($dataAj);
                die;
                //$this->error("新增失败！",U('Admin/goods/news'));
            }
            //$this->redirect('Admin/goods/news');
        }

        $id = I('get.id');
        if(!$id){
            $this->error("非法操作！",U('/Wxin/PersonalCenter/newlist/tag/newlist/value/8'));
        }
        $info = M('news')->where(array('user_id'=>$_SESSION['member_id'],'id'=>$id))->find();
        $news_cate = M('news_cate')->select();
        $this->assign('news',$news_cate);
        $this->assign('info',$info);
        $this->display();
    }

    //运费配置
    public function carriage_regulation(){

        $m = M('freight_config');
        $express = $m->where(array('user_id'=>$_SESSION['member_id']))->order('sort asc')->select();
        foreach ($express as $key => $val) {
            $region = M('frei_link_region')->where(array('freight_id'=>$val['id']))->field('region_id')->select();
            $region_name = '';
            if(!$region){
                $region_name = '无';
            }else{
                foreach ($region as $k => $v) {
                    $reg = M('region')->where(array('id'=>$v['region_id']))->field('region_name')->find();
                    $region_name .= $reg['region_name'].' , ';
                }
                $region_name = rtrim($region_name,', ');
            }
            $express[$key]['region_name'] = $region_name;
        }

        $this->assign("express", $express);
        $this->assign("urlname", 'express');
        $this->display();

    }

    //添加运费规则
    public function addExpress(){
        $first_price  = I("post.first_price");
        //$fregithid  = I("post.fregithid");
        $feeid  = I("post.feeid");
        $next_price  = I("post.next_price");

        $map['first_price'] = $first_price;
        $map['next_price']  = $next_price;
        $map['user_id']  = $_SESSION['member_id'];

        $reg = M('freight_config')->where($map)->find();
        if($reg){
            $data['info']   =   '运费规则已存在';
            $data['status'] =   0;
        }else{
            if($feeid){
                $map['sort'] = 0;
                $map['create_at'] = time();
                $map['id'] = $feeid;
                $res = M('freight_config')->where(array('id'=>$feeid))->save($map);
                if($res===false){
                    $data['info']   =   '运费规则修改失败';
                    $data['status'] =   0;
                }else{
                    $data['info']   =   '运费规则修改成功';
                    $data['status'] =   1;
                }
            }else{
                $map['sort'] = 0;
                $map['create_at'] = time();
                $res = M('freight_config')->add($map);
                if($res){
                    $data['info']   =   '运费规则添加成功';
                    $data['status'] =   1;
                }else{
                    $data['info']   =   '运费规则添加失败';
                    $data['status'] =   0;
                }
            }
        }
        $this->ajaxReturn($data);die;
    }

    //获取区域列表
    public function regionList(){
        $feeid  = I("post.feeid");
        $hasThisRegion = M('frei_link_region')->where(array('freight_id'=>$feeid))->field('region_id')->select();
        //当前选中
        foreach ($hasThisRegion as $key => $value) {
            $name = M('region')->where(array('id'=>$value['region_id']))->find();
            $data['info'][] = array('id'=>$value['region_id'],'name'=>$name['region_name'],'status'=>1);
        }

        $hasRegion = M('frei_link_region')->where(array('user_id'=>$_SESSION['member_id']))->field('region_id')->select();
        $id = '';
        foreach ($hasRegion as $key => $value) {
            $id .= $value['region_id'].',';
        }
        $id = rtrim($id,',');
        $map['id'] = array('not in',$id);
        $map['parent_id'] = 1;
        $otherRegion = M('region')->where($map)->select();
        foreach ($otherRegion as $k => $v) {
            $data['info'][] = array('id'=>$v['id'],'name'=>$v['region_name'],'status'=>0);
        }

        // $data['status'] = 1;
        // $data['id'] = $id;
        $this->ajaxReturn($data);
        return;
    }

    //修改区域
    public function getRegionSet(){
        $feeid  = I("post.feeid");
        $region_id  = I("post.region_id");
        if(empty($region_id)){
            $res = M('frei_link_region')->where(array('freight_id'=>$feeid))->delete();
            /*  if($res){
                  $data['info']   =   '修改运费区域成功';
                  $data['status'] =   1;
              }else{
                  $data['info']   =   '修改运费区域失败';
                  $data['status'] =   0;
              }*/
            $data['info']   =   '修改运费区域成功';
            $data['status'] =   1;
        }else{
            $map['freight_id'] = $feeid;
            $map['user_id'] = $_SESSION['member_id'];
            //$map['region_id'] = array('in',$region_id);
            $reg1 = M('frei_link_region')->where($map)->delete();
            $region_id = explode(",", $region_id);
            foreach ($region_id as $k => $v) {
                $reee['freight_id'] = $feeid;
                $reee['region_id'] = $v;
                $reee['status'] = 1;
                $reee['user_id'] = $_SESSION['member_id'];
                $reg2 = M('frei_link_region')->add($reee);
            }
            if($reg2){
                $data['info']   =   '修改运费区域成功';
                $data['status'] =   1;
            }else{
                $data['info']   =   '修改运费区域失败';
                $data['status'] =   0;
            }
        }
        $this->ajaxReturn($data);
        return;
    }

    //个人中心提现
    public function addcash(){
        $id = I('get.id');
        $this->assign("id", $id);
        $this->display();
    }
    public function addbank(){
        $id = I('get.id');
        if($id){
            $user_id = $_SESSION['member_id'];
            $res = M('bank_list')->where(array('id'=>$id,'user_id'=>$user_id))->find();
            $this->assign("res", $res);
        }
        $this->display();
    }

    public function address_add(){
        $id = I('get.id');
        if($id){
            $user_id = $_SESSION['member_id'];
            $res = M('address')->where(array('id'=>$id,'user_id'=>$user_id))->find();
            $this->assign("res", $res);
        }
        $this->display();
    }

    public function user(){
        $this->display();
    }

    /**
     * 我的评论
     */
    public function comment()
    {

        $artist_id = M('apply')->where(array('user_id'=>$_SESSION['member_id'], 'shenhe'=>2))->getField('id');
//        var_dump($_SESSION['member_id']);die;
//        var_dump($artist_id);die;
        $artist_id = 207;
        if (!$artist_id) {
            $this->redirect("Home/Order/order_error/msg/'您不是艺术家,请先申请开店铺!'");
        }
        $status = $_GET['status'];

        if ($status) {
            $sql = "select a.*, b.realname, b.person_img from app_comment as a left join app_member as b on a.user_id = b.id where a.artist_id =" . $artist_id .
                " and a.status = " . $status;
        } else {
            $sql = "select a.*, b.realname, b.person_img from app_comment as a left join app_member as b on a.user_id = b.id where a.artist_id =" . $artist_id;
        }

        $comment = M()->query($sql);
        $this->assign('comment', $comment);
        $this->display();
    }

    /**
     * 评论详情
     */
    public function commentDetail()
    {
        $comment_id = $_GET['id'];
        $comment = M('comment')->where(array('id'=>$comment_id))->select();
        if (!$comment) {
            $this->ajaxReturn(array("code"=>10001, "msg"=>'该评论不存在'));
        }
        $sql = "select a.*, b.realname, b.person_img from app_comment as a left join app_member as b on a.user_id = b.id where a.id =" . $comment_id;
        $detail = M()->query($sql);
        $detail = $detail[0];
        if ($detail['status'] == 1) {
            $detail['status'] = '未审批';
        } elseif ($detail['status'] == 2) {
            $detail['status'] = '审批通过';
        } else {
            $detail['status'] = '审批未通过';
        }

        $this->assign("comment", $detail);
        $this->display();
    }

    /**
     * 评论审核
     */
    public function checkComment()
    {
        $data = I('post.');
        $comment = M('comment')->where(array('id'=>$data['id']))->select();
        if (!$comment) {
            $this->ajaxReturn(array("code"=>10001, "msg"=>'该评论不存在'));
        }
        $comment_info['status'] = $data['status'];
        $comment_info['reason'] = $data['reason'];
        $comment_info['checked_at'] = date("Y-m-d H:i:s");
        $res = M('comment')->where(array('id'=>$data['id']))->save($comment_info);
        if (!$res) {
            $this->ajaxReturn(array('code'=>10001, "msg"=>"评论审核失败"));
        }
        $this->ajaxReturn(array('code'=>0, "msg"=>"评论审核成功"));
    }
}