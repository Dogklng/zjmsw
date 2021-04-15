<?php namespace Wxin\Controller;

use Think\Controller;

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',1);
    }
    /**
     *   zj  20170902
     *   下单界面，两种情况
     *        可推荐一、来自立即购买
     *       		二、来自购物车  数量
	 *		ZQJ可租赁一、 天数
     * @param  cart_ids -1-2-3-  拼接购物车id
     * @param  goods_id  立即下单时候对应的商品id
     * @param  nums      立即下单时候对应的商品数量
     * @param  skuid     如果有sku则判断sku中的库存
     * @param  type      商品类型  1-艺术品 2-创意商店
     * 整合数据结构
     */
    public function index()
    {
        //dump($_POST);exit;
        // 接收购物车id
        $cart_ids = I('post.cart_ids');
        $userid = $_SESSION['member_id'];
		
        if(I('post.is_groom') === '' || I('post.is_groom') === null){
            $is_groom = 1;
        }else{
            $is_groom = I('post.is_groom');
        }
        
        $order_list = array();
        $g_m = M("goods");
        $countprice = 0;
        $countoprice = 0;
        $express_fee = 0;
        $weight = 0;
        $count_nums = 0;
        if ($cart_ids) {
            // 有购物车id说明来自购物车下单
            $cart_arr = array_filter(explode("-", $cart_ids));
            $c_m = M("cart");
            $activity_goods = array();
            foreach ($cart_arr as $k=>$v) {
                $cart_info = $c_m->where(array("user_id" => $userid, "id" => $v))->find();
                $num_res = $this->checkCartNum($cart_info['goods_id'], $cart_info['num'], $cart_info['sku_list_id']);
                if (!in_array($num_res['status'], array(0, 3))) {
                    $goods_info = $g_m->find($cart_info['goods_id']);
                    $allprice = number_format($num_res['price'] * $num_res['num'], 2);
                    $order_list[] = array(
                        /*"goods_id" => $cart_info['goods_id'],
                        "num" => $num_res['num'],
                        "sku_id" => $cart_info['sku_list_id'],
                        "goods_img" => $goods_info['logo_pic'],
                        "goods_title" => $goods_info['goods_name'],
                        "oprice" => $num_res['oprice'],
                        "price" => $num_res['price'],
                        "sku_info" => $this->getSkuDes($cart_info['sku_list_id']),
                        "store" => $num_res['store'],
                        "allprice" => $allprice,*/
                        "id" => $cart_info['goods_id'],
                        "store" => $num_res['store'],
                        "count" => $num_res['num'],
                        "imageSrc" => $goods_info['index_pic'],
                        "name" => $goods_info['goods_name'] ? $goods_info['goods_name'] : $goods_info['goods_title'],
                        "price" => $num_res['price'],
                        "prices" => $num_res['price']*$num_res['num'],
                        "type"=>$cart_info['type'],
                        "is_reed"=>$cart_info['is_reed'],
                        "reed_id"=>$cart_info['reed_id'],
                        "activity_id"=>$goods_info['activity_id'],
                    );

                    //总重量 = 商品的重量*数量
                    $weight += $goods_info['weight'] * $num_res['num'];
                    $count_nums += $num_res['num'];
                    $countoprice += $num_res['oprice'] * $num_res['num'];
                    if ($goods_info['activity_id'] == 0) {
                        $countprice += $num_res['price'] * $num_res['num'];
                    } else {
                        if (isset($activity_goods[$goods_info['activity_id']]['total_fee'])) {
                            $activity_goods[$goods_info['activity_id']]['total_fee'] += $num_res['price'] * $num_res['num'];
                        } else {
                            $activity_goods[$goods_info['activity_id']]['total_fee'] = $num_res['price'] * $num_res['num'];
                        }

                    }


                    if($goods_info['promulgator']==0){
                        $user_id = 0;
                    }else{
                        $apply = M('apply')->where(array('id'=>$goods_info['promulgator']))->find();
                        $user_id = $apply['user_id'];
                    }
                    //读取用户默认地址计算运费   zj
                    $Defauladdress = M("address")->where(array('user_id' => $userid, 'default' => 1))->find();
                    if ($Defauladdress) {
                        $province_ID = D('region')->get_id_by_name($Defauladdress['province'], 1);
                    } else {
                        $province_ID = 0;
                    }
                    //计算总的运费
                    $express_fee += D("freight_config")->get_freight($weight, $province_ID,$user_id);
                    $express[$k]['weight'] = $goods_info['weight'] * $num_res['num'];
                    $express[$k]['user_id'] = $user_id;
                }
            }


            if (count($activity_goods) >= 1) {
                foreach ($activity_goods as $activity_id => $activity_fee) {
                    $activity = M('activities')->where('id', $activity_id)
                        ->find();
                    if ($activity['type'] == 1) {
                        // 如果是满减活动
                        if ($activity_fee['total_fee'] >= $activity['amount']) {
                            $countprice += ($activity_fee['total_fee'] - $activity['discount_amount']);
                        } else {
                            $countprice += $activity_fee['total_fee'];
                        }
                    } elseif ($activity['type'] == 2) {
                        // 如果是折扣活动
                        $countprice += ($activity_fee['total_fee'] * ($activity['discount']/100));
                    } elseif ($activity['type'] == 3) {
                        // 如果是满减折扣活动
                        if ($activity_fee['total_fee'] >= $activity['amount']) {
                            $countprice += bcdiv(($activity_fee['total_fee'] * $activity['discount']), 100);
                        } else {
                            $countprice += $activity_fee;
                        }
                    }
                }
            }

            if (empty($order_list)) {
                $this->redirect("Wxin/Order/order_error/msg/'无效的购买!'");
            }
            $express = json_encode($express);
            $this->assign("express",$express);
            $this->assign("is_cart",1);
        }else {
            $express = json_encode(0);
            $this->assign("express",$express);
            $this->assign("is_cart",0);
            $goods_id = I('post.goods_id', 0, "intval");
            $nums = I('post.nums', 0, "intval");
            $skuid = I('post.skuid', 0, "intval");
            $zujin = I('post.zujin', 0, "intval");
            $type  = I('post.type', 0, "intval");//1-艺术品 2-创意商店
            $is_reed = I('post.is_reed', 0, "intval");//是否推荐购买
            $reed_id = I('post.reed_id', 0, "intval");//推荐店铺
            // 这里处理
            if (!$goods_id || !$nums) {
                $this->redirect("Wxin/Order/order_error/msg/'无效的购买!'");
            }
            $return = $this->checkCartNum($goods_id, $nums, $skuid);
            if ($return['status'] != 1) {
                //print_r($is_groom);die;
                 if($is_groom == 1){
                     $this->redirect("Wxin/Order/order_error/msg/'{$return['info']}!'");
                 }
//                 else{
//                    $this->error('商品可租天数不足');
//                 }
            }
            $goods_info = $g_m->find($goods_id);
            $allprice = $return['oprice'] * $nums;
            $order_list = array();
            $order_list[] = array(
                //"goods_id" => $goods_id,
                "id" => $goods_id,
                //"num" => $nums,
                "count" => $nums,
                //"sku_id" => $skuid,
                //"goods_img" => $goods_info['logo_pic'],
                "imageSrc" => $goods_info['index_pic'],
                "name" => $goods_info['goods_name'] ? $goods_info['goods_name'] : $goods_info['goods_title'],
                //"goods_title" => $goods_info['goods_name'] ? $goods_info['goods_name'] : $goods_info['goods_title'],
                //"oprice" => $return['oprice'],
                "price" => $return['price'],
                "prices" => $return['price']*$nums,
                //"sku_info" => $this->getSkuDes($skuid),
               "store" => $return['store'],
                "type"=>$type,
                "is_reed"=>$is_reed?$is_reed:0,
                "reed_id"=>$reed_id?$reed_id:0,
                //"allprice" => $allprice,
            );
			$count_nums += $nums;//数量 /天数
			//查看是否是租赁商品 is_groom  ZQJ 0租赁 1推荐
			if($is_groom == 1){
				//总重量 = 商品的重量*数量
				$weight += $goods_info['weight'] * $nums;
				$countprice += $return['price'] * $nums;
				$countoprice += $return['oprice'] * $nums;
				
			}else if($is_groom == 0){
				//押金 天*每天的租金
				$weight += $goods_info['weight'];
				$countprice += $return['price'];
				$zujin = $nums*$zujin;
			}
            $goods = M('goods')->where(array('id'=>$goods_id))->find();
            if($goods['promulgator']==0){
                $user_id = 0;
            }else{
                $apply = M('apply')->where(array('id'=>$goods['promulgator']))->find();
                $user_id = $apply['user_id'];
            }
            $user_id = 0;
            $this->assign("user_id",$user_id);
            //读取用户默认地址计算运费   zj
            $Defauladdress = M("address")->where(array('user_id' => $userid, 'default' => 1))->find();
            if ($Defauladdress) {
                $province_ID = D('region')->get_id_by_name($Defauladdress['province'], 1);
            } else {
                $province_ID = 0;
            }
            //计算总的运费
            $express_fee = D("freight_config")->get_freight($weight, $province_ID,$user_id);

            if ($goods_info['activity_id'] != 0) {
                $activity = M('activities')->where('id', $goods_info['activity_id'])
                    ->find();
                if ($activity['type'] == 1) {
                    // 如果是满减活动
                    if ($countprice >= $activity['amount']) {
                        $countprice = $countprice - $activity['discount_amount'];
                    }
                } elseif ($activity['type'] == 2) {
                    // 如果是折扣活动
                    $countprice = ($countprice * ($activity['discount']/100));
                } elseif ($activity['type'] == 3) {
                    // 如果是满减折扣活动
                    if ($countprice >= $activity['amount']) {
                        $countprice = bcdiv(($countprice * $activity['discount']), 100);
                    }
                }
            }
        }


        //$countoprice1 = sprintf("%.2f", $countoprice);//不带运费
        //$count_oprice = sprintf("%.2f", $countoprice + $express_fee);
		if($is_groom == 1){
			
			$pay_fee = sprintf("%.2f", $countprice + $express_fee);//付款金额 
		}else{
			
			$pay_fee = sprintf("%.2f", $countprice + $zujin);//付款金额 
		}

        /**
         * 得到用户收货地址
         */
        $address = M("address")->where(array("user_id"=>$userid))->order("`default` desc")->select();
        //$address = M("address")->where(array("user_id" => $userid))->select();
        /**
         * 得到用户发票
         */
       /* $receipt = M("receipt")->where(array("user_id" => $userid))->select();*/

        $this->assign("count", count($order_list));
        $this->assign("count_nums", $count_nums);
        $this->assign("type", $type);
        $this->assign("pay_fee", $pay_fee);
        $this->assign("address", $address);
        $this->assign("is_groom", $is_groom);//是否租赁 0租赁 1推荐
        $this->assign("zujin", $zujin);//是否租赁 0租赁 1推荐
        $this->assign("Defauladdress", $Defauladdress);
        $this->assign("weight", $weight);
        $this->assign("express_fee", $express_fee);
        $this->assign("countprice", $countprice);
        $this->assign("order_list", $order_list);
        $this->assign("order_info1", serialize($order_list));
        $this->assign("order_info",json_encode($order_list));
		//print_r(serialize($order_list));
        $this->assign("cart_ids", $cart_ids);

        //print_r($address);
        $artists_id = I('post.artists_id'); // 推荐商品被推荐的店铺id
        if(!$artists_id){
            $artists_id = 0;
        }
        //print_r($artists_id);exit;
        $this->assign("artists_id", $artists_id);// 推荐商品被推荐的店铺id  ZQJ

        //代金券 zqj 20171104
        $member_id = $_SESSION['member_id'];
        $fields = array('l.id','c.condition','type','integral','money','over_time','status','get_time');
        $link_coupon = M('link_coupon as l')->where(array('l.user_id'=>$member_id,'status'=>1))->join('app_coupon as c on l.coupon_id = c.id')->field($fields)->select();
        foreach($link_coupon as $key=>$val){
            $link_coupon[$key]['start_time'] = $val['get_time'];
            $over_time = $val['over_time'];
            $link_coupon[$key]['end_time'] = strtotime(" +$over_time day",$val['get_time']);
            if(strtotime(" +$over_time day",$val['get_time']) < time()){
                $link_coupon[$key]['status'] = 4;
            }
        }
        //print_r($link_coupon);
        //$coupon = M('coupon')->select();
         $this->assign('coupon',$link_coupon);

         //print_r($link_coupon);

        $this->display();
    }
    /**
     * 根据省份计算运费  zj  20170908
     */
    public function get_expressFee(){
        if(IS_AJAX){
            $is_cart = I("post.is_cart");
            $province = I("post.province");
            if($is_cart==0){

                $user_id = I("post.user_id");
                $weight = I("post.weight")>0?I("post.weight"):5;
                if(!$province){
                    $this->ajaxReturn(array('status' => 0, 'info' => '未选择省份'));
                }
                if(!$weight){
                    $this->ajaxReturn(array('status' => 0, 'info' => '商品缺少重量！'));
                }
                $province_ID = D('region')->get_id_by_name($province, 1);
                if(!$province_ID){
                    $province_ID = 0;
                }
                //计算总的运费
                $express_fee = D("freight_config")->get_freight($weight, $province_ID,$user_id);
                $this->ajaxReturn(array('status' => 1, 'info' => $express_fee));
            }elseif($is_cart==1){
                $express_fee = 0;
                $express = I("post.express");
                //$express = json_decode($express,true);
                //dump($express);
                foreach ($express as $k=>$v){
                    $weight = $v['weight']>0?$v['weight']:5;
                    if(!$province){
                        $this->ajaxReturn(array('status' => 0, 'info' => '未选择省份'));
                    }
                    if(!$weight){
                        $this->ajaxReturn(array('status' => 0, 'info' => '商品缺少重量！'));
                    }
                    $province_ID = D('region')->get_id_by_name($province, 1);
                    if(!$province_ID){
                        $province_ID = 0;
                    }
                    //计算总的运费
                    $express_fee += D("freight_config")->get_freight($weight, $province_ID,$v['user_id']);
                }
                $this->ajaxReturn(array('status' => 1, 'info' => $express_fee));
            }

        }
    }

    public function chongzhi()
    {
          $this->display();
    }

    /**
     * 错误页面
     */
    public function order_error($msg){
        header("Content-type:text/html;charset=utf-8");
        $msg = I('get.msg');
        $s   = I('get.s');
        $this->assign('msg',$msg);
        $this->assign('s',$s);
        $this->display();
    }

    /**生成订单页面
        $_POST['address_id']        收货地址id  ok
        $_POST['message']           留言信息  ok
        $_POST['invoice_type']		发票类型  ok
        $_POST['invoice_title']		发票抬头  ok
        $_POST['receipt_id']		发票的id，当发票type=2时：查[receipt]  ok
        $_POST['order_info']		需要反串行化
        $_POST['cart_ids']		    购物车商品id

        逻辑：支付成功后，增加销量
              商品库存放在确认付款后扣除。

        "goods_id"
        "num"
        "sku_id"
        "goods_img"
        "goods_title"
        "price"
        "sku_info"
        "store"
    */
    public function pay()
    {
        $order_no = I("param.order_no");
		//print_r(json_decode($_POST['post_data'], true));die;
        if(!$order_no){
            $post_data = json_decode($_POST['post_data'], true);
//            print_r();
            // 订单中的商品详情
            $order_info = unserialize($post_data['order_info']);
			//print_r($order_info);die;
            // 收货地址
            $address_id = $post_data['address_id'];
            // 留言
            $message = $post_data['liuyan'];
            // 发票信息
            $invoice_type = $post_data['invoice_type'];//发票类型  增值税3 或 普通2 或不开发票1
            $invoice_title = $post_data['invoice_title'];//个人名称或单位名称
            // 登陆者id
            $userid = $_SESSION['member_id'];
            M()->startTrans();
            // 购物车的is拼接
            $cart_ids = $post_data['cart_ids'];
            $cart_arr = array_filter(explode("-", $cart_ids));
            $order_data = array();   // 订单
            $order_goods_data = array();   // 订单详情
            $express_fee = $post_data['express_fee']; // 邮费
            // 判断订单商品是否有效
            if (!$order_info || empty($order_info) || count($order_info) == 0) {
                $this->order_error("请确认下单内容！");
            }
            // 判断登录用户
            if (!$userid ) {
                $this->redirect("Wxin/Order/order_error/msg/'无效的用户!'");
            }
            if (count($cart_arr) <= 0 && $cart_ids) {
                $this->redirect("Wxin/Order/order_error/msg/'作品数量无效!'");
            }
            // 判断收货地址id
            if (!(intval($address_id) > 0)) {
                $this->redirect("Wxin/Order/order_error/msg/'无效的收货地址!'");
            }
            // 整理地址
            $address = M("address")->where(array("id" => $address_id, "user_id" => $userid))->find();
            if (!$address) {
                $this->redirect("Wxin/Order/order_error/msg/'地址信息错误!'");
            }
            $order_data['user_id'] = $userid;
            $order_data['order_no'] = 'MS' . date('YmdHis', time()) . rand(1111, 9999);
            $order_data['order_status'] = 1;//待付款
            $order_data['consignee'] = $address['consignee'];
            $order_data['province'] = $address['province'];
            $order_data['city'] = $address['city'];
            $order_data['district'] = $address['district'];
            $order_data['address'] = $address['place'];
            $order_data['mobile'] = $address['telephone'];
            $order_data["express_fee"] = $express_fee;   // 现在默认包邮
            //$order_data["receive_time"] = 0;
            $order_data["source"] = 1;
            $order_data["pay_way"] = 0;
            $order_data["order_time"] = time();
            $order_data["couponsid"] = 0;
            //保存留言信息 发票信息
            $order_data["liuyan"] = $message;
            $order_data["invoice_type"] = $invoice_type;
            $order_data["invoice_title"] = $invoice_title;
            // 下面是处理商品：同意购物车和立即购买的格式
            if ($cart_ids) {
                $cart_m = M("cart");
                // 检测购物车中的商品是否为传过来的商品
                $cart_res = $this->checkMyCart($cart_arr);
                if ($cart_res['status'] != 1) {
                    //$this->ajaxReturn(array("status" => 0, "info" => $cart_res['info']));
                    $this->redirect("Wxin/Order/order_error/msg/'{$cart_res['info']}!'");
                }
            }
            // 得到total_price
            $goods_m = M("goods");
            $sku_l_m = M("sku_list");
            $total_price = 0;        // 商品实际价格
			
			

            foreach ($order_info as $v) {
                $goods = $goods_m->where(array("id" => $v['id'], "is_sale" => 1, "isdel" => 0))->find();
                if (!$goods) {
                    $this->redirect("Wxin/Order/order_error/msg/'商品已下架!'");
                }
                // 得到商品库存
                $num_res = $this->checkCartNum($goods['id'], $v['count'], $v['sku_id']);

                if ($num_res['status'] != 1) {
                    if(!(!$cart_ids && $goods['is_groom'] == 0)){
                        $this->redirect("Wxin/Order/order_error/msg/'{$num_res['info']}!'");
                    }
                }
                $price = $num_res['price'];
                $oprice = $num_res['oprice'];
                // 记入订单详情
                $order_goods_data[] = array(
                    'goods_id' => $goods['id'],
                    'goods_name' => $goods['goods_name'] ? $goods['goods_name'] : $goods['goods_title'],
                    'goods_nums' => $v['count'],
                    'goods_price' => $price,
                    'goods_oprice' => $oprice,
                    'goods_spic' => $goods['index_pic'],
                    "sku_list_id" => $v['sku_id'] ? $v['sku_id'] : 0,
                    'sku_info' => $this->getSkuDes($v['sku_id']),
                    'user_id' => $userid,
                    'type' => $v['type'],
                    "is_groom"=>$goods['is_groom'],//租赁  购买
                    "shop_id"=>$goods['promulgator'],//店铺id
                    "is_reed"=>$v['is_reed']?$v['is_reed']:0,
                    "reed_id"=>$v['reed_id']?$v['reed_id']:0,
                );
                // 得到商品的价格
				if(!$cart_ids && $goods['is_groom'] == 0){
					//租赁订单ZQJ
					$total_fee = $post_data['total_price'] + $express_fee + $goods['zujin'] * $v['count'];//订单总价=商品价格+运费+租金
					$total_price = $price;//商品金额
				}else{
					
					$total_fee = $post_data['total_price'] + $express_fee;//订单总价=商品价格+运费
					$total_price += $price * $v['count'];
				}
                //不考虑购物车的情况 shop_id
            }
            $coupon_money = 0;
              ////这个是代金券

            /*$coupon = $post_data['coupon'];//代金券的id
            if($coupon != '' && $coupon != NULL){
                $cou = M('link_coupon as lc')->join('app_coupon as c on c.id = lc.coupon_id')->field(array('lc.id','c.money'))->where(array('lc.status'=>1,'lc.id'=>$coupon))->find();
                if($cou){
                    $order_data['couponsid'] = $coupon;//
                    $coupon_money = $cou['money'];
                    $total_fee = $total_fee -  $cou['money'];
                    $order_data['discount'] = sprintf('%.2f',$cou['money']);
                    //print_r( $total_fee);die;                
                }
            }*/

            //租赁订单
            if(!$cart_ids && $goods['is_groom'] == 0){
                $order_data['is_recommend'] =0;
            }


            //租赁订单
            $order_m = M("order_info");
            $order_data['return_score'] = 0;
            $order_data['total_fee'] = round(floatval($total_fee), 2);//包含运费 (租金)-代金券
            $order_data['total_price'] = round(floatval($total_price), 2);//不
            //包含运费
			//print_r($order_data);die;
           //判断被推荐商品的推荐店铺id是否存在  ZQJ 20171102  还要存发布该商品的店铺shop_id;
            $order_data['shop_id'] = $goods['promulgator']; 
            $artists_id = $post_data['artists_id'];

            //print_r($artists_id);exit;
            if($artists_id){
                $order_data['tj_shop'] = $artists_id; 
                $order_data['tj_status'] = 1; 
            }else{

                $order_data['tj_shop'] = $goods['promulgator'];
                $order_data['tj_status'] = 0; 
            }
            //收益 平台收取10% 商家收取90%（针对商品价格）  收益=收取的商品价格90%-运费（租金不管） ZQJ 20171103
            //财务统计 服务费配置
            $finance = M('finance_config')->where(array('id'=>1))->find();
            $fina_tree = ($finance['technology_fee']/100)*($total_price-$express_fee);//平台收取费用
            if($order_data['tj_status'] == 1){
                $yong_fee = ($finance['yong_fee']/100)*($total_price-$express_fee);
                
                 $order_data['yong_fee'] = sprintf('%.2f',$yong_fee);
                 $sub_tree = (1-$finance['technology_fee']/100-$finance['yong_fee']/100)*($total_price-$express_fee);//商家实收取费用 (-运费)-佣金
            }else{
                 $sub_tree = (1-$finance['technology_fee']/100)*($total_price-$express_fee);//商家实收取费用 (-运费)
            }
            $order_data['fina_tree'] = $fina_tree;
            $order_data['sub_tree'] = $sub_tree;
            

            $order_res = $order_m->add($order_data);//保存到订单 order_info
            if (!$order_res) {
                $this->redirect("Wxin/Order/order_error/msg/'下单失败!'");
            }
            /*if($coupon != '' && $coupon != NULL){

                M('link_coupon')->where(array('id'=>$coupon,'status'=>1))->setField('status',2);//更改代金券状态
            }*/
            // 保存到订单详情
            $order_goods_m = M("order_goods");
            foreach ($order_goods_data as $v) {
                //产品下单减库存
                $cstore = M("goods")->where(array('id'=>$v['goods_id']))->getField('cstore');
                if($cstore == 0){//艺术品
                    $res12 = M("goods")->where(array('id'=>$v['goods_id']))->setField('store',0);
                }else{
                    $res12 = M("goods")->where(array('id'=>$v['goods_id']))->setDec('store',$v['goods_nums']);
                }
                if (!$res12) {
                    M()->rollback();
                    $this->redirect("Wxin/Order/order_error/msg/'下单失败!'");
                }
                //结束
                $v['order_id'] = $order_res;
                $v['order_no'] = $order_data['order_no'];
                $v['order_time'] = $order_data['order_time'];
                $o_g_res = $order_goods_m->add($v);
                // dump($v);
                if (!$o_g_res) {
                    M()->rollback();
                    $this->redirect("Wxin/Order/order_error/msg/'下单失败!'");
                }
            }
            if ($cart_ids) {
                foreach ($cart_arr as $v) {
                    $cart_res = $cart_m->where(array('id' => $v, "user_id" => $userid))->delete();
                    if (!$cart_res) {
                        M()->rollback();
                        $this->redirect("Wxin/Order/order_error/msg/'购物车商品错误!'");
                    }
                }
            }
            M()->commit();
        }else{
            $order = M("order_info")->where(array('order_no' => $order_no))->find();
            if (!$order) {
                $this->redirect("Wxin/Order/order_error/msg/'无此订单!'");
            }
            if ($order['pay_status'] != 0 && $order['order_status'] != 1) {
                $this->redirect("Wxin/Order/order_error/msg/'订单无法支付!'");
            }
            $order_data['order_no'] = $order_no;
            $order_data['total_fee'] = $order['total_fee'];
            $this->assign("invoice_type", $order['invoice_type']);//发票类型
            $this->assign("invoice_title", $order['invoice_title']);//发票抬头
            $this->assign("liuyan", $order['liuyan']);//留言信息
        }
        $this->assign("address_info", $address);//收货地址
        $this->assign("order_no", $order_data['order_no']);//订单号
        $this->assign("time", $order_data['order_time']);//下单时间
        $this->assign("order_id", $order_res);//订单id
        $this->assign("total_fee", $order_data['total_fee']);//订单总金额包含运费
        $this->display();
    }
    /**
     * 支付订单 zj
     */
    public function PayOrder(){
        if(IS_AJAX){
            $saveData = I("post.");
            $order_no = $saveData['order_no'];
            $userId = $_SESSION['member_id'];
            if(!$userId){
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $order = M("orderInfo")->where(array('user_id'=>$userId,'order_no'=>$order_no,'order_status'=>1))->find();
            if(!$order){
                $this->ajaxReturn(array('status' => 0, 'info' => '订单无法支付'));
            }
            $saveData['update_time'] = time();
            $res = M("orderInfo")->where(array('user_id'=>$userId,'order_no'=>$order_no,'order_status'=>1))->save($saveData);
            if(!$res){
                $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
            }
            $pay_way = $saveData['pay_way'];
            switch ($pay_way) {
                case "1";
                    $this->ajaxReturn(array("status" => 1,'order_no' => $order_no, "url" => U('Pay/alipay', array("order_no" =>$order_no))));
                    break;
                case "2";
                    $url = $this->wx_pay($order['id']);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 2, "order_id" => $order['id'], 'url' => $url));
                    break;
                case "3";
                    $this->ajaxReturn(array("status" => 3,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpay/pay.php?order_id={$order[id]}"));
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
        $out_trade_no = $order_no;

        $m = M('order_info');
        $data_m['order_no'] = $out_trade_no;
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
        $data_w['way_name']="普通商品支付";
        $res1 = M('money_water')->add($data_w);
        if(!$res1){
            M()->rollback();
            $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
        }


        $m = M("order_info");
        $order = $m->where(array("order_no" => $out_trade_no))->find();
        $total_fee = $order['total_fee'];
        $data = array(
            "pay_status" => 1,
            //"trade_no" => $transaction_id,
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
        //2.增加销量 减少库存
        //$res2 = $this->delStore($order['id']);
        //用商品总金额算收益 排除运费 查看是否达到当月的销售额 销售件数 晋升等级

        $order_goods = M('order_goods')->where(array('order_id'=>$order['id']))->select();
        foreach ($order_goods as $k=>$v){
            if($v['type']==1){//艺术品
                if($v['shop_id']!=0){//艺术家店铺
                    $apply = M('apply')->where(array('id'=>$v['shop_id']))->find();
                    $info_member =  M('member')->where(array('id'=>$apply['user_id']))->find();
                    $info_finan = M('finance_config')->find();
                    $price = sprintf("%.2f",($v['goods_price']*(1-($info_finan['technology_fee']/100))));
                    $res4 = M('member')->where(array('id'=>$apply['user_id']))->save(array('wallet'=>$info_member['wallet']+$price));
                    if(!$res4){
                        M()->rollback();
                        $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
                    }
                    $data_w['user_id']=$apply['user_id'];
                    $data_w['type']=1;
                    $data_w['posttime']=time();
                    $data_w['cate']=1;
                    $data_w['wallet']=$price;
                    $data_w['way_name']="店铺商品收益";
                    $res5 = M('money_water')->add($data_w);
                    if(!$res5){
                        M()->rollback();
                        $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
                    }
                }
                $res6 = M('goods')->where(array('id'=>$v['goods_id']))->save(array('is_buy'=>1,'is_sale'=>0));
                if(!$res6){
                    M()->rollback();
                    $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
                }
                //已购买
            }else{//创意商店
                if($v['is_reed']==1){//推荐购买
                    $yun_apply = M('yun_apply')->where(array('id'=>$v['reed_id']))->find();
                    $info_member =  M('member')->where(array('id'=>$yun_apply['user_id']))->find();
                    $info_right = M('yun_right')->where(array('level'=>$yun_apply['level']))->find();
                    $price = sprintf("%.2f",($v['goods_price']*($info_right['rate']/100)));
                    $res4 = M('member')->where(array('id'=>$yun_apply['user_id']))->save(array('wallet'=>$info_member['wallet']+$price));
                    //dump($price);
                    if(!$res4){
                        M()->rollback();
                        $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
                    }
                    $data_w['user_id']=$yun_apply['user_id'];
                    $data_w['type']=1;
                    $data_w['posttime']=time();
                    $data_w['cate']=1;
                    $data_w['wallet']=$price;
                    $data_w['way_name']="推荐店铺商品收益";
                    $res5 = M('money_water')->add($data_w);
                    if(!$res5){
                        M()->rollback();
                        $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
                    }
                }
                //加销量
                $goods = M('goods')->where(array('id'=>$v['goods_id']))->find();
                $res5 = M('goods')->where(array('id'=>$v['goods_id']))->save(array('volume'=>$goods['volume']+$v['goods_nums']));
                if(!$res5){
                    M()->rollback();
                    $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
                }
            }
        }
        M()->commit();
        $this->ajaxReturn(array('info'=>"/Wxin/PersonalCenter/myOrder",'status'=>4));
    }
    /**
     *微信支付
     */
    public function wx_pay($order_res)
    {
        $m = M('order_info');
        $data_m['id'] = $order_res;
        $data_m['order_status'] = 1;
        $info = $m->where($data_m)->find();
        if (!$info) {
            return false;
        } else {
            $total_fee = $info['total_fee'];
            // $total_fee    = 0.01;
            $or_g = M('order_goods');
            $o_g_r = $or_g->where(array('order_id' => $order_res))->find();
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
            $input->SetGoods_tag($o_g_r['goods_name'] . $o_g_r['sku_info']);
            $input->SetNotify_url("http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pay/weixin_pay");
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
            $order = M('order_info');
            $res = $order->where(array('id' => $id))->find();
            if ($res['order_status'] > 1) {
                $url = U('Wxin/PersonalCenter/myOrder');
                $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
            }
        }
    }


    /**
     * 支付订单 zj
     */
    public function CzPayOrder(){

        if(IS_AJAX){
            $money = I("post.money");
            $pay_way=I('post.pay_way');
            $order_no='MS' . date('YmdHis', time()) . rand(1111, 9999);
            $userId = $_SESSION['member_id'];
            $data=array('money'=>$money,'way'=>$pay_way,'order_no'=>$order_no,'user_id'=>$userId,'addtime'=>NOW_TIME,'status'=>0,'type'=>0);
            $res=M('money_order')->add($data);
            if(!$res){
                $this->ajaxReturn(array('status' => 0, 'info' => '充值失败，请重新提交'));exit;
            }
            if(!$userId){
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));exit;
            }
            switch ($pay_way) {
                case "1";
                    $this->ajaxReturn(array("status" => 1,'order_no' => $order_no, "url" => U('Wxin/Pay/CzAlipay', array("order_no" =>$order_no))));
                    break;
                case "2";
                    $this->ajaxReturn(array("status" => 2,"pay_url" => $res));
                    break;
                case "3";
                    $this->ajaxReturn(array("status" => 3,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionchargepay/pay.php?order_id={$res}"));
                    break;
                default:
                    $this->ajaxReturn(array("status" => 0, 'info' => "无效的支付方式！"));
                    break;
            }
        }
    }
    /**
     *微信支付
     */
    public function czwx_pay($order_res)
    {
        header("Content-type: text/html; charset=utf-8");
        $m = M('money_order');
        $data_m['id'] = $order_res;
        $data_m['status'] = 0;
        $info = $m->where($data_m)->find();
        if (!$info) {
            return false;
        } else {
            $total_fee = $info['money'];
            //===========测试数据=============
            $money = $total_fee * 100;
            //$money = 1;
            $notify_url = "http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pay/czweixin_pay";
            $result = $this->wxhtml_pay($info['order_no'],'浙江美术网微信订单充值',$money,$notify_url);
            if($result['return_code']=='SUCCESS'){//生成支付链接成功
                //配置支付成功后自动跳转地址
                $redirect_url=urlencode('http://www.zhejiangart.com.cn/Wxin/PersonalCenter/userinfo');
                $re['status']=1;
                $re['pay_url']=$result['mweb_url'].'&redirect_url='.$redirect_url;
            }else{
                $re['status']=0;
                $re['info']=$result['return_msg'];
            }
            return $re;
        }
    }
    /**
     *微信支付  查询订单是否支付成功
     */
    public function czorder_status()
    {
        if (IS_POST) {
            $id = I('post.order_id');
            $order = M('money_order');
            $res = $order->where(array('id' => $id))->find();
            if ($res['status'] == 1) {
                $url = U('Wxin/PersonalCenter/userinfo');
                $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
            }
        }
    }

    /**
     * 支付订单 zj
     */
    public function cZMakeOrder(){
        if(IS_AJAX){
            $saveData = I("post.");
            $order_id = $saveData['order_no'];
            $userId = $_SESSION['member_id'];
            if(!$userId){
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $order = M("orderInfo")->where(array('user_id'=>$userId,'order_no'=>$order_id,'order_status'=>1))->find();
            if(!$order){
                $this->ajaxReturn(array('status' => 0, 'info' => '订单无法支付'));
            }
            $saveData['update_time'] = time();
            $res = M("orderInfo")->where(array('user_id'=>$userId,'order_no'=>$order_id,'order_status'=>1))->save($saveData);
            if(!$res){
                $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
            }
            $pay_way = $saveData['pay_way'];
            switch ($pay_way) {
                case "1";
                    $this->ajaxReturn(array("status" => 1,'order_no' => $order_id, "url" => U('Pay/alipay', array("order_no" =>$order_id))));
                    break;
                case "2";
                    //$this->ajaxReturn(array("status" => 2,'order_no' =>$order_id, "url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpayFirst/pay.php?order_id={$order_id}"));
                    $url = U('Wxin/PersonalCenter/myOrder');
                    $this->ajaxReturn(array("status" => 2,'info'=>'银联支付升级中，前往我的订单查看','order_no'=>$order_id,"url" =>$url));
                    break;
                default:
                    $this->ajaxReturn(array("status" => 0, 'info' => "无效的支付方式！"));
                    break;
            }
        }
    }

    /**
     * 清空购物车 zj 20170902
     */
    public function cart_empty()
    {
        if (IS_AJAX) {
            $user_id = $_SESSION['member_id'];
            if (!$user_id) {
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $is_c = M("cart")->where(array('user_id' => $user_id))->select();
            if (!$is_c) {
                $this->ajaxReturn(array('status' => 0, 'info' => '您的购物车没有商品'));
            }
            $del_c = M("cart")->where(array('user_id' => $user_id))->delete();
            if (!$del_c) {
                $this->ajaxReturn(array('status' => 0, 'info' => '购物车清空失败'));
            }
            $this->ajaxReturn(array('status' => 1, 'info' => '清空成功'));
        }
        $this->error("非法访问！");
    }

    /**
     * 单个删除 购物车 zj 20170902
     */
    public function cart_del()
    {
        if (IS_AJAX) {
            $cart_id = I('post.id');
            $user_id = $_SESSION['member_id'];
            if (!$user_id) {
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $is_c = M("cart")->where(array('id' => $cart_id, 'user_id' => $user_id))->find();
            if (!$is_c) {
                $this->ajaxReturn(array('status' => 0, 'info' => '您的购物车不存在此商品'));
            }
            $del_c = M("cart")->where(array('id' => $cart_id, 'user_id' => $user_id))->delete();
            if (!$del_c) {
                $this->ajaxReturn(array('status' => 0, 'info' => '删除失败'));
            }
            $this->ajaxReturn(array('status' => 1, 'info' => '删除成功'));
        }
        $this->error("非法访问！");
    }

    /**
     * 增删购物车数量  zj  20170902
     */
    public function cart_edit()
    {
        if (IS_AJAX) {
            $user_id = $_SESSION['member_id'];
            if (!$user_id) {
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $cart_id = I('post.id');
            $cart = M('cart');
            $is_cart = $cart->where(array('id' => $cart_id))->find();
            if (!$is_cart) {
                $this->ajaxReturn(array('status' => 0, 'info' => '您的购物车不存在此商品'));
            }
            //这里是点购物车加一次 点一次减 减一 1是加 2是减
            $change = I('post.change');
            if ($change == 1) { //加
                $num = $is_cart['num'] + 1;
            } elseif ($change == 2) { //减
                $num = $is_cart['num'] - 1;
                if (empty($num)) {
                    $this->ajaxReturn(array('status' => 0, 'info' => '此商品的数量不能再减了'));
                }
            }
//            $res = checkCartNum($is_cart['goods_id'],$num,$is_cart['sku_list_id']);
//            if($res['status']!=1){
//                $this->ajaxReturn(array("status"=>0, "info"=>$res['info']));
//            }

            $edit_cart = $cart->where(array('id' => $cart_id, 'user_id' => $user_id,))->save(array('num' => $num));
            $price = M("goods")->where(array('id' => $is_cart['goods_id']))->getField('price');
            $all_cost = sprintf("%.2f", $price * $num);;
            if (!$edit_cart) {
                $this->ajaxReturn(array('status' => 0, 'info' => '增加数量失败'));
            }
            $this->ajaxReturn(array('status' => 1, 'num' => $num, 'info' => '增加数量成功', 'all_cost' => $all_cost));
        }
    }
    /**
     * zyf
     * 检测购物车商品数量
     */
    private function checkCartNum($goodsid, $num, $skuid=0){
        $goods = M("goods")->where(array("id"=>$goodsid ,"isdel"=>0))->find();
        $zhekou = 1;
        if($goods['is_cuxiao']){
            $qg_config = M("limitbuy_config")->where(array('id'=>1))->find();
            $time = time();
            if($qg_config['status'] && $time>=$qg_config['starttime'] && $time<=$qg_config['endtime']){
                $zhekou = floatval($goods['discount'])*0.1;
            }
        }
        if(!$goods){
            return array("status"=>'0', "info"=>"没有该商品！","num"=>0);
        }
        if(!$goods['is_sale']){
            return array("status"=>'0', "info"=>"该商品已下架！","num"=>0);
        }
        $store=array();
        if($skuid){
            // 商品没开启sku
            if(!$goods['is_sku']){
                return array("status"=>'0', "info"=>"该商品已下架！","num"=>0);
            }
            $sku = M("sku_list")->where(array("goods_id"=>$goodsid, "id"=>$skuid, "status"=>1))->find();
            if(!$sku){
                return array("status"=>'3' ,"info"=>"商品没有该属性！","num"=>0, "price"=>$sku['price'],"store"=>0,"oprice"=>$sku['oprice']);
            }
            if($sku['store']<$num){
                return array("status"=>'2' ,"info"=>"该商品库存不足！","num"=>$sku['store'], "price"=>$sku['price'],"store"=>$sku['store'],"oprice"=>$sku['oprice']);
            }
            $store  = $sku['store'];
            $oprice = $sku['oprice'];
            $price  = $sku['price'];
        }else{
            if($goods['store']<$num){
                return array("status"=>'2' ,"info"=>"该商品库存不足！","num"=>$goods['store'], "price"=>$goods['price'],"store"=>$goods['store'],"oprice"=>$goods['oprice']);
            }
            $store  = $goods['store'];
            $oprice = $goods['oprice'];
            $price  = $goods['price'];
        }
        if(0<$zhekou && $zhekou<1){
            $price = floor($price*$zhekou);
        }
        return array("status"=>'1',"num"=>$num, "price"=>$price,"store"=>$store,"oprice"=>$oprice);
    }
    /**
     * 检测购物车合法性
     */
    private function checkMyCart($cart_arr){
        $m      = M("cart");
        $userid = $_SESSION['member_id'];
        foreach($cart_arr as $v){
            $cart = $m->where(array("id"=>$v, "user_id"=>$userid))->find();
            if($cart){

            }else{
                return array("status"=>0, "info"=>"请确认购物车的商品！");
            }
        }
        return array("status"=>1, "info"=>"ok");
    }

    /**
     * 编辑地址
     */
    public function addAddress()
    {
        $data = I('post.');
        $m = M('address');
//        if($data['is_default'] == 1){  //如果有默认地址改掉原有的默认
//            $m->where(array('user_id'=>$_SESSION['user_id'],'is_default'=>1))->setField('is_default',0);
//        }
        $id=$data['id'];
        if (empty($id) || !isset($id)) {
            $num = $m->where(array("user_id" => $_SESSION['member_id']))->count();
            if ($num >= 10) {
                $this->ajaxReturn(array("status" => 0, "info" => "地址最多10条记录不能再加了"));
            }
        }


        if ($data['id'] > 0) {
            $res = $m->save($data);
            $this->ajaxReturn(array('status' => 2, 'info' => '操作成功'));
        } else {
            unset($data['id']);
            $data['user_id'] = $_SESSION['member_id'];
            $res = $m->add($data);
            $id = $res;
        }
        if ($res) {
            $url = U('Wxin/Ucenter/address');
            $this->ajaxReturn(array('status' => 1, 'info' => '操作成功', 'url' => $url, 'id' => $id));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
        }
    }

    // 手机端-微信浏览器支付
    public function phoneweixinpay($user_id, $order_id, $money_order,$order_type){
        /*
            配置文件在WxPay.pub.config.php中配置
        */
        header("Content-type: text/html; charset=utf-8");
        vendor('WxPayPubHelper.WxPayPubHelper');
        /*
            验证订单有效性
        */
        if(!$order_id){
            $order_id = I("get.order_id");
        }
        if ($order_type == 1) {
            $body = '浙江美术网';
        } elseif ($order_type == 3) { //普通订单批量支付

        } elseif ($order_type == 4) { //包装辅料订单批量支付

        }elseif ($order_type == 5) { //充值

        }else{

        }
        $money = $money_order * 100;

        //测试数据
        $body         = "快印包包装制品";

        //====================== 获取openid======================//
        $jsApi = new \JsApi_pub();

        /*if(!isset($_GET['code'])){
            //var_dump($_GET);
            //触发微信返回code码
            //dump(\WxPayConf_pub::JS_API_CALL_URL);die;
            $url = $jsApi->createOauthUrlForCode(urlencode(\WxPayConf::JS_API_CALL_URL."?order_no={$orderinfo['order_no']}"));
            $url = trim($url," ");
            // file_put_contents('./1.txt',(string)$url);
            //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxae5d3a0258214651&redirect_uri=http%3A%2F%2Fyouzhu.unohacha.com%2FWeixin%2FPay%2Fwxpay.html%3Forder_no%3DYZ201702172246211717&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
            //https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxae5d3a0258214651&redirect_uri=http://youzhu.unohacha.com/Weixin/Pay/wxpay.html?order_no=YZ201702172246211717&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
            //注意url地址order_no前面需要使用？作为分隔符，不能使用/  它前面的url为http://youzhu.unohacha.com/Weixin/Pay/wxpay.html   这个来自于配置信息中的【JSAPI路径设置】
            header("location:$url");
        }else{
            $code   = $_GET['code'];
            // file_put_contents('./2.txt',(string)$code);
            //获取code码，以获取openid
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
            // file_put_contents('./4.txt',(string)$openid);
        }*/

        $openid = M("member")->where(array('id'=>$user_id))->getField('wx_openid_gzh');



        //=========步骤2：使用统一支付接口，获取prepay_id========//
        //使用统一支付接口
        $out_trade_no     = $out_trade_no;
        $unifiedOrder = new \UnifiedOrder_pub();
        $unifiedOrder->setParameter("openid"      ,$openid);                                                  //商品描述
        $unifiedOrder->setParameter("body"        ,$body);                                                    //商品描述
        $unifiedOrder->setParameter("out_trade_no",$no_order);                                          //商户订单号
        $unifiedOrder->setParameter("total_fee"   , $money);                                            //总金额,腾讯默认支付金额单位为【分】
        $unifiedOrder->setParameter("notify_url"  ,'http://'.$_SERVER['HTTP_HOST'].'/Home/Pay/wxnotify_url.html'); //通知地址
        $unifiedOrder->setParameter("trade_type"  ,"JSAPI");                                                    //交易类型
        $prepay_id = $unifiedOrder->getPrepayId();

        // dump($prepay_id);
        // die();
        //prepay_id 通过微信支付统一下单接口拿到"wx201702172246229800e461870695332694"
        //      file_put_contents('./5.txt',(string)$prepay_id);
        //=========步骤3：使用jsapi调起支付====================//
        $jsApi->setPrepayId($prepay_id);
        $jsApiParameters = $jsApi->getParameters();
        // dump($jsApiParameters);
        // die();                                                       //设置jsapi的参数

        /* $jsApiParameters{参与签名的参数有appId, timeStamp, nonceStr, package, signType。
                "appId":"wxae5d3a0258214651",
                "timeStamp":"‪1487342782‬", // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                "nonceStr":"mt4bmcckpvbzv2qy7jghz0y02u5pl2i1",// 支付签名随机串，不长于 32 位
                "package":"prepay_id=wx201702172246229800e461870695332694",// 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                "signType":"MD5",// 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                "paySign":"65B506402AD97E2AB31B78BFB5BDA0D4"// 支付签名,采用统一的微信支付 Sign 签名生成方法
        }" */

        // $this->assign('domain',          $_SERVER['HTTP_HOST']);                                                 //域名
        // $this->assign('order_id',        $res['id']);                                                            //订单id
        $this->assign('jsApiParameters', $jsApiParameters);                                                     //jsapi参数数组

        $this->display('Order/wxpay_gzh');


    }

    public function payMent()
    {
        $type = I('type');
        $order_id = I('order_id');
        $is_wx = is_weixin();
        // 是否微信支付
        if($is_wx == 1){
            //手机微信浏览器支付
            $res = $this->phoneweixinpay($_SESSION['member_id'],$order_id, $money=0.01,$type);
            return false;

        }else{
            //手机微信支付
            $res = $this->phonewxpay('',$order_id, $money=0.01,$type);
            if ($res['status'] == 1) {
                $this->assign('pay_url',$res['pay_url']);
                $this->display('Order/wxpayH');exit;
            }else{
                dump($res['info']);
            }
            $this->ajaxReturn(array("status" => 0,"pay_url" => $res));
        }
    }

    // 手机端微信支付
    public function phonewxpay($user_id, $order_id, $money_order,$order_type)
    {
        header("Content-type: text/html; charset=utf-8");
        Vendor('WxPayPubHelper.WxPayPubHelper');

        if ($order_type == 1) {
            $m = M('money_order');
            $data_m['id'] = $order_id;
            $data_m['status'] = 0;
            $info = $m->where($data_m)->find();
            $no_order = $info['order_no'];
           $name_goods="美术网";
           $notify_url = '/Wxin/Pay/czweixin_pay';
        } elseif ($order_type == 3) { //普通订单批量支付

        } elseif ($order_type == 4) { //包装辅料订单批量支付

        } elseif ($order_type == 5) { //充值

        }else{

        }

        $money = $money_order * 100;

        //加载配置文件
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";//微信传参地址
        //场景信息
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3';
        $headers[] = 'Accept-Encoding: gzip, deflate';
        $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0';

        $arr['h5_info']['type']='Wap';
        $arr['h5_info']['wap_url']='https://pay.qq.com';
        $arr['h5_info']['wap_name']=$name_goods;
        $info=json_encode($arr,JSON_UNESCAPED_UNICODE);
        $setParameter['appid']='wxd4ffd6bcf1b0c3e7';
        $setParameter['body']='快印包包装制品';
        $setParameter['mch_id']='1493716172';
        $setParameter['nonce_str']=MD5($no_order);
        $setParameter['notify_url']='http://'.$_SERVER['HTTP_HOST'].$notify_url;
        $setParameter['out_trade_no']=$no_order;
        $setParameter['scene_info']=$info;
        $unknown = 'unknown';
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($arr as $v) {
                    $v = trim($v);
                    if ($v != 'unknown') {
                        $ip = $v;
                        break;
                    }
                }
            } else if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } else if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)) {
                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = $unknown;
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)) {
                $ip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)) {
                $ip = getenv("HTTP_CLIENT_IP");
            } else if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)) {
                $ip = getenv("REMOTE_ADDR");
            } else {
                $ip = $unknown;
            }
        }
        $ip = preg_match("/[\d\.]{7,15}/", $ip, $matches) ? $matches[0] : $unknown;
        $setParameter['spbill_create_ip']=$ip;//$_SERVER['REMOTE_ADDR'];
        $setParameter['total_fee']=$money;
        $setParameter['trade_type']='MWEB';
        $unifiedOrder = new \UnifiedOrder_pub();
        $sign=$unifiedOrder->getSign($setParameter);
        $setParameter['sign']=$sign;
        $post_data=$unifiedOrder->arrayToXml($setParameter);
        $result=$this->httpCurl($url,$post_data,$headers);
        if($result['return_code']=='SUCCESS'){//生成支付链接成功
            //配置支付成功后自动跳转地址
            $redirect_url=urlencode('http://'.$_SERVER['HTTP_HOST'].'/Home/PersonalCenter/mypayyes/type/1');
            if($order_type == 1){
                $redirect_url=urlencode('http://'.$_SERVER['HTTP_HOST'].'/Home/PersonalCenter/mypayyes/type/2');
            }
            $re['status']=1;
            $re['pay_url']=$result['mweb_url'].'&redirect_url='.$redirect_url;
        }else{
            $re['status']=0;
            $re['info']=$result['return_msg'];
        }
        return $re;
    }

    /**
     * http 请求
     **/
    public function httpCurl($url,$post_data,$headers){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        curl_close($ch);
        $objectxml =simplexml_load_string($response,'SimpleXMLElement',LIBXML_NOCDATA); //将微信返回的XML 转换成数组
        $result=json_decode( json_encode($objectxml), true );
        return $result;
    }

}