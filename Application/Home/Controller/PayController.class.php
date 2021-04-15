<?php

namespace Home\Controller;

use Think\Controller;

class PayController extends Controller
{


    /** 20170713 wzz
     *电脑支付配置
     **/
    private function alipay_config()
    {
        $alipay_config = array(
            //APPID 即创建应用后生成       更新5-1
            'app_id' => "2015122301028610",
            //同步跳转地址，公网可以访问   更新5-2
            'Czreturn_url' => "http://msw.unohacha.com/Home/Pay/CzReturnURL",
            //异步通知地址，公网可以访问   更新5-3
            'Cznotify_url' => "http://msw.unohacha.com/Home/Pay/CzNotifyURL",

            //同步跳转地址，公网可以访问   更新5-2
            'return_url' => "http://msw.unohacha.com/Home/Pay/ReturnURL",
            //异步通知地址，公网可以访问   更新5-3
            'notify_url' => "http://msw.unohacha.com/Home/Pay/NotifyURL",
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


    /** 20170713 wzz
     * 电脑支付同步通知
     **/
    public function CzReturnURL()
    {
        $arr = $_GET;
        log_result("./CzReturnURL.txt", var_export($arr, true));
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
            $m = M("money_order");
            $order = $m->where(array("order_no" => $out_trade_no))->find();
            if ($order['status'] == 1) {
                $this->redirect('Home/PersonalCenter/userinfo');
            } else {
                $this->redirect("Home/Order/order_error/msg/'支付失败!'");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->redirect("Home/Order/order_error/msg/'充值订单支付失败!'");
        }
    }


    /** 20170713 wzz
     * 电脑支付异步通知
     * 1.更新订单状态
     * 2.增加销量 减少库存
     * 3.记录流水账
     * 4.代金券
     **/
    public function CzNotifyURL()
    {
        $arr = $_POST;
        log_result("./CzNotifyURL.txt", var_export($arr, true));
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
                M()->startTrans();
                $m = M("money_order");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
                if ($order['status'] == 0) {
                    $data = array(
                        "status" => 1,
                        'money'  =>$total_amount,
                    );
                    $res = $m->where(array('id' => $order['id']))->save($data);
                    if (!$res) {
                        // 这里记入错误日志
                        $msg = "用户支付成功，充值订单改变状态失败！";
                        $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                    }
                    $res1= M('member')->where(array('id'=>$order['user_id']))->setInc('wallet',$total_amount);
                    if(!$res1){
                        M()->rollback();
                        // 这里记入错误日志
                        $msg = "用户支付成功，改变用户余额失败！";
                        $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                    }
                    M()->commit();
                }
            }
            echo "success";    //请不要修改或删除

        } else {
            //验证失败
            echo "fail";
        }

    }


    /** 20170713 wzz
     * 电脑支付同步通知
     **/
    public function ReturnURL()
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
            $m = M("order_info");
            $order = $m->where(array("order_no" => $out_trade_no))->find();
            if ($order['order_status'] == 2) {
                $this->redirect('Home/PersonalCenter/myOrder');
            } else {
                $this->order_error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->order_error("订单支付失败！");
        }
    }


    /** 20170713 wzz
     * 电脑支付异步通知
     * 1.更新订单状态
     * 2.增加销量 减少库存
     * 3.记录流水账
     * 4.代金券
     **/
    public function NotifyURL()
    {
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
                $m = M("order_info");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
                $total_fee = $order['total_fee'];
                if ($order['pay_status'] == 0) {
                    // 返佣金  return_price
                    $user = M('member')->find($order['user_id']);
                    $data = array(
                        "pay_status" => 1,
                        "trade_no" => $trade_no,
                        "order_status" => 2,
                        "pay_price" => $total_fee,
                        "pay_way" => 1,//支付宝支付
                        "pay_time" => time(),
                    );
                    $res = $m->where(array('id' => $order['id']))->save($data);
                    if (!$res) {
                        // 这里记入错误日志
                        $msg = "用户支付成功，订单改变状态失败！";
                        $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                    }
                    //2.增加销量 减少库存
                    //$res2 = $this->delStore($order['id']);

                    //3.记录流水账
                    $m_data = array(
                        'user_id' => $order['user_id'],
                        'type' => 2,
                        'money' => $total_amount,
                        'cate' => 2,
                        'add_time' => date("Y-m-d H:i:s", time()),
                        'order_id' => $order['id'],
                    );

                    M('money_water')->add($m_data);
                    //如果有使用代金券则改变代金券的状态 zqj 20171104
                    //M('link_coupon')->where(array('status'=>2,'id'=>$order['couponsid']))->setField('status',3);//order/pay那边控制器写的是如果订单生成，则代金券的状态为2已锁定
                    //用商品总金额算收益 排除运费 查看是否达到当月的销售额 销售件数 晋升等级
                    /*if($order['tj_status'] == 1){
                        $tj_shop = $order['tj_shop'];//店铺id
                        //抽佣金 加到余额里面
                        $artist = M('artist')->where(array('shenhe'=>1,'is_del'=>0,'id'=>$tj_shop))->find();
                        $memid = $artist['member_id'];
                        $wallet = M('member')->where(array('isdel'=>0,'id'=>$memid))->getField('wallet');
                        $yong_fee = sprintf('%.2f',$wallet+$order['yong_fee']);
                        M('member')->where(array('isdel'=>0,'id'=>$memid))->setField('wallet',$yong_fee);
                        ////////
                        //先计算当月的 件数 销售额
                        $starttime =strtotime(date('Y-m-d H:i:s',mktime(0, 0 , 0,date('m'),1,date('Y')))) ;
                        $endtime = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y'))));
                        //var_dump($endtime);
                        $map['tj_status'] = 1;
                        $map['order_status'] = 4; // 已完成订单
                        $map['tj_shop'] = $tj_shop; //
                        $map['update_time'] = array('between',('$starttime,$endtime'));
                        $sum = M('order_info')->order('update_time desc')->where($map)->sum('total_price');
                        $counts =  M('order_info')->order('update_time desc')->where($map)->count();
                        //计算云推荐的收益  然后再是否符合条件发放代金券
                        $yun = M('yunrecomm as ys')->where(array('is_del'=>0))->select();
                        $juan = "";
                        foreach($yun as $key => $val){
                            if($val['company'] == '万'){
                                $val['salesquota'] = $val['salesquota']*10000;
                            }else{
                                $val['salesquota'] = $val['salesquota'];
                            }
                            if($counts >= $val['product'] && $sum >= $val['salesquota']){
                                $juan += $val.","; //把可以获取的卷的id存起来
                            }
                        }
                        if(!empty(explode(',',$juan))){
                            //可以获得 得到最多的卷
                            $juan = explode(',',$juan);
                            //print_r($juan);die;
                            $ju['is_del'] = 0;
                            $ju['id'] = array('in',$juan);
                            $jyun = M('yunrecomm')->where($ju)->max('giftcard');
                            if($jyun){
                                //查询到可以获得的优惠券id
                                $yures = M('yunrecomm')->where(array('is_del'=>0,'giftcard'=>$jyun))->find();
                                $cid = M('coupon')->where(array('condition1'=>$yures['id']))->select();//'1：白金经纪人券 2：黄金经纪人 3：黑金经纪人',
                                $aid = $order['tj_shop'];//推荐店铺的id
                                $member_id = M('artist')->where(array('shenhe'=>1,'id'=>$aid))->getField('member_id');
                                $arr['user_id'] = $member_id;
                                $arr['status'] = 1;
                                $arr['get_time'] = time();
                                $arr['coupon_id'] = $cid['id'];
                                M('link_coupon')->add($arr);
                                ////////晋升等级
                                M('member')->where(array('isdel'=>0,'id'=>$member_id))->setField('vip',$yures['id']);

                            }
                        }

                    }*/
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
                                    $msg = "用户支付成功，增加艺术家店铺用户余额失败！";
                                    $this->addToOrderErrorLog($apply['user_id'], $v['id'], $msg);
                                }
                                $data_w['user_id']=$apply['user_id'];
                                $data_w['type']=1;
                                $data_w['posttime']=time();
                                $data_w['cate']=1;
                                $data_w['wallet']=$price;
                                $data_w['way_name']="店铺商品收益";
                                M('money_water')->add($data_w);
                            }
                            $res6 = M('goods')->where(array('id'=>$v['goods_id']))->save(array('is_buy'=>1,'is_sale'=>0));
                            if(!$res6){
                                $msg = "用户支付成功，艺术品修改状态失败！";
                                $this->addToOrderErrorLog($apply['user_id'], $v['id'], $msg);
                            }
                            //已购买
                        }else{//创意商店
                            if($v['is_reed']==1){//推荐购买
                                $yun_apply = M('yun_apply')->where(array('id'=>$v['reed_id']))->find();
                                $info_member =  M('member')->where(array('id'=>$yun_apply['user_id']))->find();
                                $info_right = M('yun_right')->where(array('id'=>$yun_apply['level']))->find();
                                $price = sprintf("%.2f",($v['goods_price']*($info_right['rate']/100)));
                                $res4 = M('member')->where(array('id'=>$yun_apply['user_id']))->save(array('wallet'=>$info_member['wallet']+$price));
                                if(!$res4){
                                    $msg = "用户支付成功，增加推荐店铺用户余额失败！";
                                    $this->addToOrderErrorLog($yun_apply['user_id'], $v['id'], $msg);
                                }
                                $data_w['user_id']=$yun_apply['user_id'];
                                $data_w['type']=1;
                                $data_w['posttime']=time();
                                $data_w['cate']=1;
                                $data_w['wallet']=$price;
                                $data_w['way_name']="推荐店铺商品收益";
                                M('money_water')->add($data_w);
                            }
                            //加销量
                            $goods = M('goods')->where(array('id'=>$v['goods_id']))->find();
                            $res5 = M('goods')->where(array('id'=>$v['goods_id']))->save(array('volume'=>$goods['volume']+$v['goods_nums']));
                            if(!$res5){
                                $msg = "用户支付成功，增加销量失败！";
                                $this->addToOrderErrorLog('', $v['id'], $msg,$goods['goods_id']);
                            }
                        }
                    }
                }
                //2.记录流水账

                ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
            }
            echo "success";    //请不要修改或删除

        } else {
            //验证失败
            echo "fail";
        }

    }

    /**20170711 wzz
     * 电脑网站支付
     */
    public function alipay()
    {

        $out_trade_no = trim(I("order_no"));
        if (!$out_trade_no) {
            $this->error("无此订单号不存在！");
        }
        $order = M("order_info")->where(array('order_no' => $out_trade_no))->find();
        if (!$order) {
            $this->error("无此订单！");
        }
        if ($order['pay_status'] != 0 && $order['order_status'] != 1) {
            $this->error("订单无法支付！");
        }
        $subject = "浙江美术网支付宝订单支付";
        $total_amount = $order['total_fee'];
        $body = "";

        /******************测试数据 1******************/
        //$subject = "浙江美术网支付宝支付";
       // $total_amount = 0.01;
        //$body = "浙江美术网支付宝支付";
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
        $alipay_config = $this->alipay_config();
        vendor("Alipay.AopSdk");
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
        //dump($result);
        //输出
        echo $result;
        /*********************封装 2***********************/
    }

    /**20170711 wzz
     * 电脑网站支付
     */
    public function Czalipay()
    {

        $out_trade_no = trim(I("order_no"));
        if (!$out_trade_no) {
            $this->redirect("Home/Order/order_error/msg/'无此充值单号不存在!'");
        }
        $order = M("money_order")->where(array('order_no' => $out_trade_no))->find();
        if (!$order) {
            $this->redirect("Home/Order/order_error/msg/'无此充值订单!'");
        }
        if ($order['status'] == 1) {
            $this->redirect("Home/Order/order_error/msg/'充值订单已经支付过了!'");
        }
        $subject = "浙江美术网支付宝订单充值";
        $total_amount = $order['money'];
        $body = "";

        /******************测试数据 1******************/
        //$subject = "浙江美术网支付宝充值";
        //$total_amount = $order['money'];
        //$body = "浙江美术网支付宝支付充值";
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
        $alipay_config = $this->alipay_config();
        vendor("Alipay.AopSdk");
        $aop = new \AopClient;
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $alipay_config['app_id'];
        $aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset = 'UTF-8';
        $aop->format = 'json';
        $request = new \AlipayTradePagePayRequest ();


        $request->setReturnUrl($alipay_config['Czreturn_url']);
        $request->setNotifyUrl($alipay_config['Cznotify_url']);
        $request->setBizContent($BizContent);
        //请求
        $result = $aop->pageExecute($request); //支付宝返回的信息
        //dump($result);
        //输出
        echo $result;
        /*********************封装 2***********************/
    }

    public function addToOrderErrorLog($userid = null, $orderid = null, $msg = null, $goodsid = null, $nums = null, $skuid = null, $skuinfo = null)
    {
        $data = array(
            "user_id" => $userid,
            "order_id" => $orderid,
            "msg" => $msg,
            "goods_id" => $goodsid,
            "nums" => $nums,
            "sku_id" => $skuid,
            "sku_info" => $skuinfo,
            "create_at" => time(),
            "status" => 0,
        );
        M("order_error_log")->add($data);
    }


    /**
     * 减少订单对应商品的库存的方法
     */
    private function delStore($orderid)
    {
        $order_goods = M("order_goods")->where(array('order_id' => $orderid))->select();
        if (!$order_goods) {
            return false;
        }
        $g_m = M("goods");
        $sku_m = M("sku_list");
        $return = true;
        foreach ($order_goods as $k) {
            $nums = $k['goods_nums'];
            if ($k['sku_list_id']) {
                //有sku
                $store = $sku_m->where(array("id" => $k['sku_list_id']))->getField("store");
                if ($store < $nums) {
                    // 记入错误日志
                    $msg = "商品库存不足，用户需要{$nums}件，商城只有{$store}";
                    $this->addToOrderErrorLog($k['user_id'], $k['order_id'], $msg, $k['goods_id'], $k['goods_nums'], $k['sku_list_id'], $k['sku_info']);
                    $return = fasle;
                } else {
                    $res = $sku_m->where(array("id" => $k['sku_list_id']))->setDec("store", $nums);
                    //$res2 = $sku_m->where(array("id"=>$k['goods_id']))->setInc("sell_nums", $nums);
                    $res2 = $g_m->where(array("id" => $k['goods_id']))->setInc("sell_nums", $nums);
                    if (!$res) {
                        // 记入错误日志
                        $msg = "减少商品库存失败，需减少{$nums}";
                        $this->addToOrderErrorLog($k['user_id'], $k['order_id'], $msg, $k['goods_id'], $k['goods_nums'], $k['sku_list_id'], $k['sku_info']);
                        $return = fasle;
                    }
                    if (!$res2) {
                        // 记入错误日志
                        $msg = "商品增加销量失败，需增加{$nums}";
                        $this->addToOrderErrorLog($k['user_id'], $k['order_id'], $msg, $k['goods_id'], $k['goods_nums'], $k['sku_list_id'], $k['sku_info']);
                        $return = fasle;
                    }
                }
            } else {
                //无sku
                $store = $g_m->where(array("id" => $k['goods_id']))->getField("store");
                if ($store < $nums) {
                    // 记入错误日志
                    $msg = "商品[{$k['sku_info']}]库存不足，用户需要{$nums}件，商城只有{$store}";
                    $this->addToOrderErrorLog($k['user_id'], $k['order_id'], $msg, $k['goods_id'], $k['goods_nums'], $k['sku_list_id'], $k['sku_info']);
                    $return = fasle;
                } else {
                    $res = $g_m->where(array("id" => $k['goods_id']))->setDec("store", $nums);
                    $res2 = $g_m->where(array("id" => $k['goods_id']))->setInc("sell_nums", $nums);
                    if (!$res) {
                        // 记入错误日志
                        $msg = "减少商品库存失败，需减少{$nums}";
                        $this->addToOrderErrorLog($k['user_id'], $k['order_id'], $msg, $k['goods_id'], $k['goods_nums'], $k['sku_list_id'], $k['sku_info']);
                        $return = fasle;
                    }
                    if (!$res2) {
                        // 记入错误日志
                        $msg = "商品增加销量失败，需增加{$nums}";
                        $this->addToOrderErrorLog($k['user_id'], $k['order_id'], $msg, $k['goods_id'], $k['goods_nums'], $k['sku_list_id'], $k['sku_info']);
                        $return = fasle;
                    }
                }
            }
        }
        return $return;
    }


    /**
     * 验证订单
     * @param $order_num 订单号
     */
    public function checkOrder($order_num)
    {
        //查询订单
        $orderInfo = M("product_record")->where(['order_num' => $order_num])->find();
        if (empty($orderInfo)) {
            $result = [
                'status' => '0',
                'info' => '订单信息不存在'
            ];
            return $result;
        }
        //订单状态
        if ($orderInfo['status'] > 0) {
            $result = [
                'status' => '0',
                'info' => '订单已经支付'
            ];
            return $result;
        }
        return $data = [
            'status' => 1,
            'data' => $orderInfo
        ];
    }

    /**
     * 修改订单状态
     * @param $order_num 订单号
     */
    public function changeOrderStatus($order_num)
    {
        //查询订单
        $orderInfo = M("product_record")->where(['order_num' => $order_num])->find();
        //项目天数
        if ($orderInfo['tender_type'] == 1) {
            $days = $orderInfo['investment_term'] * 86400;
        } elseif ($orderInfo['tender_type'] == 2) {
            $days = $orderInfo['investment_term'] * 30 * 86400;
        }

        $changeData = [
            'status' => 1,
            'expiration_date' => date('Y-m-d H:i:s', time() + $days),
        ];
        $orderChange = M("product_record")->where(['order_num' => $order_num])->save($changeData);
        //修改该订单为有效订单
        M("product_record")->where(['order_num' => $order_num])->setField('is_able', 1);
    }

    /**
     * @param $orderInfo 订单信息
     * @return array|bool 0优惠券状态修改失败
     */
    public function changeCouponStatus($orderInfo)
    {

        log_result("./youhuiquan_info.txt", '代金券' . $orderInfo['pay_voucher_num'] . ',' . '加息券' . $orderInfo['jx_id']);
        if ($orderInfo['pay_voucher_num'] > 0 || $orderInfo['jx_id']) {
            //有优惠券,修改会员优惠券表状态

            //如果代金券   --   更新会员账目表 ---总金额,代金券金额
            if ($orderInfo['pay_voucher_num'] > 0) {
                //查询投资人账目表信息
                $userAccount = M("member_account")->where(['user_id' => $orderInfo['user_id']])->field('total_money,coupon_money')->find();
                $setData = [
                    'total_money' => $userAccount['total_money'] + $orderInfo['pay_voucher_num'],
                    'coupon_money' => $userAccount['coupon_money'] - $orderInfo['pay_voucher_num'],
                ];
                M("member_account")->where(['user_id' => $orderInfo['user_id']])->save($setData);
                //记录使用代金券流水账
                $dataCoupon = [
                    'user_id' => $orderInfo['user_id'],
                    'type' => 5,
                    'order_num' => $orderInfo['order_num'],
                    'money' => $orderInfo['pay_voucher_num'],
                    'msg' => '投资使用代金券'
                ];
                $this->MoneyWater($dataCoupon);
            }

            //修改代金券使用状态
            $setData1 = [
                'status' => 2,
                'user_time' => time(),
                'finrecord_id' => $orderInfo['id'],
            ];
            //分别修改代金券和加息券
            if ($orderInfo['pay_voucher_num'] > 0) {
                $memberCouponId = M("member_coupon")->where(['user_id' => $orderInfo['user_id'], 'id' => $orderInfo['dj_id'], 'status' => 1])->order('id asc')->find();
                $result = M("member_coupon")->where(['id' => $memberCouponId['id']])->save($setData1);
            }
            log_result('./加息券id.txt', $orderInfo['jx_id']);
            if ($orderInfo['jx_id']) {
                $memberCouponId = M("member_coupon")->where(['user_id' => $orderInfo['user_id'], 'id' => $orderInfo['jx_id'], 'status' => 1])->order('id asc')->find();
                $result = M("member_coupon")->where(['id' => $memberCouponId['id']])->save($setData1);
                log_result("./加息券结果.txt", $result);
            }

            if (!$result) {
                //记录错误日志
                $errorData = [
                    'order_id' => $orderInfo['id'],
                    'goods_id' => $orderInfo['product_id'],
                    'type' => 3,
                    'user_id' => $orderInfo['user_id'],
                    'create_at' => date('Y-m-d H:i:s', time()),
                    'msg' => "优惠券状态修改失败,会员优惠券id" . implode(',', [$orderInfo['dj_id'], $orderInfo['jx_id']])
                ];
                M("order_error_log")->add($errorData);
            }

        }
    }


    /**
     * 修改产品已借金额和剩余金额
     * @param $orderInfo 订单信息
     * @return array|bool
     */
    public function changeProductMoney($orderInfo, $productInfo)
    {
        $moneyData = [
            'over_borrow' => $orderInfo['investment_num'] + $productInfo['over_borrow'],
            'surplus_money' => $productInfo['surplus_money'] - $orderInfo['investment_num'],
        ];
        $result = M('product')->where(['id' => $orderInfo['product_id']])->save($moneyData);
        if (!$result) {
            //记录错误日志
            $errorData = [
                'order_id' => $orderInfo['id'],
                'goods_id' => $orderInfo['product_id'],
                'type' => 3,
                'user_id' => $orderInfo['user_id'],
                'create_at' => date('Y-m-d H:i:s', time()),
                'msg' => "余额支付,支付成功,产品已借金额修改失败"
            ];
            M("order_error_log")->add($errorData);
        }
        return;
    }

    /**
     * 修改订单状态
     * @param $order_id 订单id
     * @param $product_id 产品id
     */
    public function changeProductStatus($product_id)
    {
        log_result('./admin_add_result.txt', var_export('./admin_add_test.txt', 66));
        //查询该产品期限
        $investment_term = M("product")->where(['id' => $product_id])->field('mini_time,tender_type,type')->find();
        log_result('./admin_add_result.txt', var_export('./admin_add_test.txt', 1));
        if ($investment_term['tender_type'] == 1) {
            $days = date("Y-m-d", time() + $investment_term['mini_time'] * 86400);
        } else {
            $days = date("Y-m-d", time() + $investment_term['mini_time'] * 30 * 86400);
        }
        //将当前id的产品状态修改为4
        $setData = [
            'status' => 4,
            'plan_repay_time' => $days,
            'tender_complete' => date('Y-m-d H:i:s', time()),
        ];
        $result = M("product")->where(['id' => $product_id])->save($setData);
        log_result('./admin_add_result.txt', var_export($result, true));
        //将待招标中的第一个项目修改为3
        $pro = M("product")->where(['status' => 2, 'type' => $investment_term['type'], 'is_del' => 0, 'is_able' => 0])->order("review_time asc")->getField('id');
        log_result('./admin_add_result.txt', var_export('./admin_add_test.txt', 2));
        $releaseData = [
            'status' => 3,
            'tender_release' => date("Y-m-d H:i:s", time()),
        ];
        $waitProduct = M("product")->where(['id' => $pro])->setField('status', 3);
        log_result('./admin_add_result.txt', var_export('./admin_add_test.txt', 3));
    }

    /**
     * 成功回调
     * @param $orderInfo 订单详情
     * @param $memInfo 会员详情
     * @return array|bool
     * 调用此方法前,订单状态,用户余额已更新过
     * 此方法逻辑:1.修改优惠券状态(位置随意)---2.修改产品的可借金额与已借金额---3.判断该产品剩余金额是否为零(为零满标)
     * ---4.满标调用changeProductStatus(订单id,产品id)修改产品状态---5.增加用户的投资总额---6.增加用户的待收总额---
     * 7.增加用户待收本金---8.增加用户的代收利息---9.增加用户奖励优宝币---10.增加该产品投标人数-记录流水帐
     */
    public function callBack0822($order_num, $mem_id)
    {
        log_result('./a_paySuccess.txt', $order_num . ' || 支付成功回调' . "\n");
        //根据订单号查询汇付支付情况
        $isPay = M("huifu_initiativetender")->where(['ordid' => $order_num])->find();
        if (empty($isPay)) {
            $url = U('Products/products');
            session('backurl', $url);
            $public = A("Home/Common");
            $public->error("请先支付订单", $url);
        }
        //修改订单状态
        $this->changeOrderStatus($order_num);
        $orderInfo = M("product_record")->where(['order_num' => $order_num])->find();
        $memInfo = M("meminfo_view")->where(['id' => $mem_id])->find();
        log_result('./a_paySuccess.txt', $order_num . ' || 支付成功回调2' . "\n");


//      1 //修改优惠券状态
        $this->changeCouponStatus($orderInfo);
        log_result('./a_paySuccess.txt', '修改优惠券状态' . "\n");
        $productInfo = M("product")->where(['id' => $orderInfo['product_id']])->find();
        // 2 修改产品的可借金额与已借金额
        $proMoney = $this->changeProductMoney($orderInfo, $productInfo);
        log_result('./a_paySuccess.txt', '修改产品剩余金额与可借金额' . "\n");
        // 3 修改用户的资产状态
        $this->addMemberAccount($orderInfo, $mem_id);
        log_result('./a_paySuccess.txt', '修改投资用户账目表' . "\n");
        // 4 支付成功后查看该会员是否升级
        $this->checkMemberGrade($memInfo);
        log_result('./a_paySuccess.txt', '查看会员是否升级' . "\n");
        // 5 判断该产品此次支付后是否已满标
        $surplus_money0815 = M("product")->where(['id' => $orderInfo['product_id']])->getField('surplus_money');
        log_result('./a_paySuccess.txt', '查询项目是否满标' . "\n");
        if ($surplus_money0815 <= 0) {   //满标 -- 进行后续操作
            //修改产品状态为已满标,并将待标状态产品更新
            $this->changeProductStatus($orderInfo['product_id']);
            log_result('./a_paySuccess.txt', '修改产品为满标状态' . "\n");

            //调用放款接口
            $obj = A("Api/Huifu");
            $this->fangkuan($orderInfo);

            log_result('./a_paySuccess.txt', '借款人' . $productInfo['user_id'] . '记录居间服务费流水账' . "\n");

        }
        //增加用户优宝币
        if (!empty($orderInfo['invest_ubaobi'])) {
            $ubaobiInc = M("member")->where(['id' => $memInfo['id']])->setInc("ubaobi", $orderInfo['invest_ubaobi']);
            //记录投资任务完成
            $taskData = [
                'user_id' => $memInfo['id'],
                'task_id' => 2,
                'wanc_time' => date("Y-m-d H:i:s", time())
            ];
            M("task_relation")->add($taskData);
            if (!$ubaobiInc) {
                //记录错误日志
                $errorData = [
                    'order_id' => $orderInfo['id'],
                    'order_num' => $orderInfo['order_num'],
                    'goods_id' => $orderInfo['product_id'],
                    'type' => 3,
                    'create_at' => date('Y-m-d H:i:s', time()),
                    'nums' => $orderInfo['invest_ubaobi'],
                    'msg' => "用户优宝币赠送失败"
                ];
                M("order_error_log")->add($errorData);
            }
        }
        log_result('./a_paySuccess.txt', '投资人' . $productInfo['user_id'] . '增加优宝币' . "\n");
        //增加投标人数
        $investPerson = M("product")->where(['id' => $orderInfo['product_id']])->setInc("tender_num", 1);
        if (!$investPerson) {
            //记录错误日志
            $errorData = [
                'order_id' => $orderInfo['id'],
                'order_num' => $orderInfo['order_num'],
                'goods_id' => $orderInfo['product_id'],
                'type' => 3,
                'create_at' => date('Y-m-d H:i:s', time()),
                'msg' => "项目支付成功,投标人数增加失败"
            ];
            M("order_error_log")->add($errorData);
        }
        log_result('./a_paySuccess.txt', '项目' . $orderInfo['product_id'] . '增加投标人数' . "\n");
        if ($orderInfo['invest_ubaobi'] > 0) {
            //记录奖励U宝币记录
            $ubaobiRewardData = [
                'user_id' => $memInfo['id'],
                'income' => 1,
                'pay_num' => $orderInfo['invest_ubaobi'],
                'pay_front' => $memInfo['ubaobi'] - $orderInfo['invest_ubaobi'],
                'pay_after' => $memInfo['ubaobi'],
                'task_id' => 2,
                'msg' => '投资赠送优宝币',
                'add_time' => date("Y-m-d H:i:s", time())
            ];
            M("ubb_log")->add($ubaobiRewardData);
            log_result('./a_paySuccess.txt', '投资人' . $productInfo['user_id'] . '记录奖励优宝币记录' . "\n");
        }
    }


    /**
     * 投资送代金券
     */
    public function giveCoupons($money, $memId)
    {
        $memInfo = M("member")->where(['id' => $memId])->field('invite_code')->find();
        $public = A("Common/Public");
        //首投
        $investCount = M("product_record")->where(['user_id' => $memId, 'status' => ['egt', 1]])->count();
        if ($investCount == 1) {
            $invitePerson = M("member")->where(['reg_code' => $memInfo['invite_code']])->getField('id');
            if (!empty($invitePerson)) {
                $public->checkActiveCoupons($invitePerson, 4, "首投赠送邀请人代金券");
            }
            $public->checkActiveCoupons($memId, 3, "首投赠送代金券");
        }

        $public->checkActiveCoupons($memId, 2, "投标奖励代金券", $money);
    }

    /**
     * 修改用户的资产状态
     */
    public function addMemberAccount($orderInfo, $userId)
    {

        //增加用户投资金额
        $memberInvestMoney = M("member")->where(['id' => $userId])->field('invest_money,invest_time')->find();
        $investData = [
            'invest_money' => $memberInvestMoney['invest_money'] + $orderInfo['investment_num'],
            'invest_time' => date('Y-m-d', time())
        ];
        M("member")->where(['id' => $userId])->save($investData);


        $newMemberAccount = M("member_account")->where(['user_id' => $userId])->field('available_money,total_money,freeze_money,wait_principal,wait_interst,all_interst')->find();
        $saveData = [
            'total_money' => (float)$newMemberAccount['total_money'] + $orderInfo['all_interest'],
            'all_interst' => (float)$newMemberAccount['all_interst'] + $orderInfo['all_interest'],
            'wait_interst' => (float)$newMemberAccount['wait_interst'] + $orderInfo['all_interest']
        ];
        $result = M("member_account")->where(array('user_id' => $userId))->save($saveData);
        //记录投资人待收利息流水账
        $orderUser = M("product_record")->where(['order_num' => $orderInfo['order_num']])->field('user_id,investment_num,all_interest,all_interest_jie')->find();
        $data = [
            'user_id' => $orderUser['user_id'],
            'type' => 8,
            'money' => $orderUser['all_interest'],
            'msg' => '待收利息'
        ];
        $this->MoneyWater($data);
        if (!$result) {
            //记录错误日志
            $errorData = [
                'order_id' => $orderInfo['id'],
                'order_num' => $orderInfo['order_num'],
                'goods_id' => $orderInfo['product_id'],
                'type' => 3,
                'create_at' => date('Y-m-d H:i:s', time()),
                'nums' => $orderInfo['invest_ubaobi'],
                'msg' => "用户投资成功,账目修改失败"
            ];
            M("order_error_log")->add($errorData);
        }
        log_result('./a_paySuccess.txt', '投资人' . $userId . '账目表' . "\n");


        //可用余额减,冻结金额加
        $freezeMoney = M("member_account")->where(['user_id' => $userId])->field('available_money,freeze_money,wait_principal,all_wait_money')->find();
        $freezeData = [
            'available_money' => $freezeMoney['available_money'] - $orderInfo['investment_num'],
            'freeze_money' => $freezeMoney['freeze_money'] + $orderInfo['investment_num'] - $orderInfo['pay_voucher_num'],
            'wait_principal' => (float)$freezeMoney['wait_principal'] + $orderUser['investment_num'],
            'all_wait_money' => (float)$freezeMoney['all_wait_money'] + $orderUser['investment_num'],
        ];
        M('member_account')->where(['user_id' => $userId])->save($freezeData);
        //记录账户冻结金额流水账
        $data = [
            'user_id' => $userId,
            'type' => 6,
            'money' => $orderInfo['investment_num'] - $orderInfo['pay_voucher_num'],
            'msg' => '投标冻结金额'
        ];
        $this->MoneyWater($data);
        log_result('./a_paySuccess.txt', '投资人' . $userId . '记录冻结金额流水账' . "\n");
        return;
    }

    /**
     * 支付成功后检测该用户会员等级是否升级
     */
    private function checkMemberGrade($memInfo)
    {

        //当前会员等级与最高等级
        $gradeNow = $memInfo['grade'];
        $gradeHigh = $memInfo['grade_high'];
        //查询当前用户的投资额
        $investMoney = M('member')->where(['id' => $memInfo['id']])->getField('invest_money');

        //根据投资金额查询会员等级
        $grade = M("member_grade")->where(['min_invest' => ['elt', $investMoney]])->order('grade_num desc')->getField('grade_num');
        log_result("./lq_memberGrade.txt", $grade . "   " . $investMoney);
        $public = A("Common/Public");
        if ($grade > $gradeNow && $grade > $gradeHigh) {

            $public->member_team($memInfo['id'], $grade);
            $saveData = [
                'grade' => $grade,
                'grade_high' => $grade
            ];

        } elseif ($grade > $gradeNow) {
            $public = A("Common/Public");
            $public->member_team($memInfo['id'], $grade);
            $saveData = [
                'grade' => $gradeHigh
            ];
        }
        M("member")->where(['id' => $memInfo['id']])->save($saveData);
    }

    public function weixin_pmpay(){
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();
        $log_name = "./log/wxpay_log.txt"; // 文本日志保存路径
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        log_result($log_name,"【接收到的notify通知1】:\n".$returnXml."\n");
        log_result($log_name,"【接收到的notify通知3】:\n".$xml."\n");
        echo $returnXml;
        //====================================更新订单状态==================================//
        $obj=(array)simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        $transaction_id = $obj['transaction_id'];   //流水账号
        $result_code    = $obj['result_code'];      //成功 SUCCESS
        $return_code    = $obj['return_code'];      //成功 SUCCESS
        $out_trade_no   = $obj['out_trade_no'];    	//订单号

        //==================测试=====================
        $total_fee      =$obj['total_fee']/100;
//        $total_fee      =1000;
        //==================测试=====================

        $openid         = $obj['openid'];			//支付者微信openid

        $timestamp      = time();
        log_result($log_name,"transaction_id:\n".$transaction_id."\n");
        log_result($log_name,"result_code:\n".$result_code."\n");
        log_result($log_name,"return_code:\n".$return_code."\n");
        log_result($log_name,"out_trade_no:\n".$out_trade_no."\n");
        log_result($log_name,"total_fee:\n".$total_fee."\n");
        log_result($log_name,"openid:\n".$openid."\n");
        log_result($log_name,"timestamp:\n".$timestamp."\n");
        log_result($log_name,"【接收到的notify通知2】:\n".$xml."\n");

        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                log_result($log_name,"【通信出错】:\n".$xml."\n");
            }elseif($notify->data["result_code"] == "FAIL"){
                log_result($log_name,"【业务出错】:\n".$xml."\n");
            }else{
                log_result($log_name,"【支付成功】:\n".$xml."\n");
                if($result_code=="SUCCESS" && $return_code=="SUCCESS"){

                    $type = mb_substr($out_trade_no,0,1,'utf-8');
                    $out_trade_no = mb_substr($out_trade_no,1,30,'utf-8');
                    if($type==1){
                        $order = M("order_pmding")->where(array('order_no' => $out_trade_no))->find();
                        $total_amount = $order['baoding'];
                        $b_data['pay_way'] = 3;
                        $b_data['order_status'] = 1;
                        $b_data['pay_status'] = 1;
                        $b_data['pay_price'] = $total_amount;
                        $b_data['pay_time'] = time();
                        $res = M("order_pmding")->where(array('id' => $order['id']))->save($b_data);
                        if (!$res) {
                            // 这里记入错误日志
                            $msg = "用户支付成功，拍卖保证金订单改变状态失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }
                        $data_w['user_id'] = $_SESSION['member_id'];
                        $data_w['type'] = 2;
                        $data_w['posttime'] = time();
                        $data_w['order_id'] = $order['id'];
                        $data_w['cate'] = 0;
                        $data_w['expend'] = $total_amount;
                        $data_w['way_name'] = "支付拍品保定金";
                        M('money_water')->add($data_w);

                    }elseif($type==2){
                        $order = M("ruzhu")->where(array('pay_order' => $out_trade_no))->find();
                        $total_amount = $order['price'];

                        $r_data['pay_type'] = 3;
                        $r_data['pay_status'] = 1;
                        $r_data['pay_endtime'] = time();
                        $res = M("ruzhu")->where(array('id' => $order['id']))->save($r_data);
                        if (!$res) {
                            // 这里记入错误日志
                            $msg = "用户支付成功，拍卖入驻改变状态失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }
                        $data_w['user_id']=$_SESSION['member_id'];
                        $data_w['type']=2;
                        $data_w['posttime']=time();
                        $data_w['order_id']=$order['id'];
                        $data_w['cate']=0;
                        $data_w['expend']=$total_amount;
                        $data_w['way_name']="申请入驻拍卖 缴纳保证金";
                        M('money_water')->add($data_w);
                    }else{
                        $order = M("order_pm")->where(array('order_no' => $out_trade_no))->find();
                        $total_amount = $order['total_fee'];


                        $b_data['pay_way'] = 3;
                        $b_data['order_status'] = 2;
                        $b_data['pay_status'] = 1;
                        $b_data['pay_price'] =  $total_amount;
                        $b_data['pay_time'] = time();

                        $res = M("order_pm")->where(array('id' => $order['id']))->save($b_data);
                        if (!$res) {
                            // 这里记入错误日志
                            $msg = "用户支付成功，拍品订单改变状态失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }

                        $pm = M('pm')->where(array('id'=>$order['goods_id']))->find();
                        /*if($res['promulgator']!=0){*/
                        $s_data['user_id'] = $pm['promulgator'];
                        $s_data['price'] = $order['goods_price'];
                        $s_data['yongjin_price'] = $order['goods_price']*$pm['yongjin']/100;
                        $s_data['huode_price'] = $order['goods_price']-$s_data['yongjin_price'];
                        $s_data['addtime'] = time();
                        $s_data['is_settl'] = 0;
                        $s_data['order_id'] = $order['id'];
                        $s_data['goods_id'] = $pm['id'];
                        $res3 = M('settl')->add($s_data);
                        if(!$res3){
                            // 这里记入错误日志
                            $msg = "用户支付成功，生成结算记录失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }
                        $data_w['user_id']=$_SESSION['member_id'];
                        $data_w['type']=2;
                        $data_w['posttime']=time();
                        $data_w['order_id']=$order['id'];
                        $data_w['cate']=0;
                        $data_w['expend']=$total_amount;
                        $data_w['way_name']="拍品支付";
                        M('money_water')->add($data_w);
                    }
                }
            }
        }else{
            //此处应该更新一下订单状态，商户自行增删操作
            log_result($log_name,"【签名错误】");
        }
    }

    public function weixin_pay(){
        $log_name = "./log/wxpay_log.txt"; // 文本日志保存路径
        log_result($log_name,"【接收到的notify通知1】: 123\n");
        log_result($log_name,"【接收到的notify通知3】:");
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();
        $log_name = "./log/wxpay_log.txt"; // 文本日志保存路径
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        log_result($log_name,"【接收到的notify通知1】:\n".$returnXml."\n");
        log_result($log_name,"【接收到的notify通知3】:\n".$xml."\n");
        echo $returnXml;
        //====================================更新订单状态==================================//
        $obj=(array)simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        $transaction_id = $obj['transaction_id'];   //流水账号
        $result_code    = $obj['result_code'];      //成功 SUCCESS
        $return_code    = $obj['return_code'];      //成功 SUCCESS
        $out_trade_no   = $obj['out_trade_no'];    	//订单号

        //==================测试=====================
        $total_fee      =$obj['total_fee']/100;
//        $total_fee      =1000;
        //==================测试=====================

        $openid         = $obj['openid'];			//支付者微信openid

        $timestamp      = time();
        log_result($log_name,"transaction_id:\n".$transaction_id."\n");
        log_result($log_name,"result_code:\n".$result_code."\n");
        log_result($log_name,"return_code:\n".$return_code."\n");
        log_result($log_name,"out_trade_no:\n".$out_trade_no."\n");
        log_result($log_name,"total_fee:\n".$total_fee."\n");
        log_result($log_name,"openid:\n".$openid."\n");
        log_result($log_name,"timestamp:\n".$timestamp."\n");
        log_result($log_name,"【接收到的notify通知2】:\n".$xml."\n");

        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                log_result($log_name,"【通信出错】:\n".$xml."\n");
            }elseif($notify->data["result_code"] == "FAIL"){
                log_result($log_name,"【业务出错】:\n".$xml."\n");
            }else{
                log_result($log_name,"【支付成功】:\n".$xml."\n");
                if($result_code=="SUCCESS" && $return_code=="SUCCESS") {
                    $header = mb_substr($out_trade_no,0,2,'utf-8');
                    if ($header == 'MS') {
                        $this->orderWxinPay($out_trade_no, $transaction_id, $total_fee);
                    } elseif ($header == 'TR') {
                        $this->trainWxinPay($out_trade_no, $transaction_id, $total_fee);
                    } elseif ($header == 'PM') {
                        $this->pmWxinPay($out_trade_no);
                    } elseif ($header == 'RZ') {
                        $this->ruzhuWxinPay($out_trade_no);
                    } elseif ($header == 'BD') {
                        $this->bdjWxinPay($out_trade_no);
                    }
                }
            }
        }else{
            //此处应该更新一下订单状态，商户自行增删操作
            log_result($log_name,"【签名错误】");
        }
    }

    /**
     * 拍卖保证金微信支付
     * @param $out_trade_no
     */
    public function bdjWxinPay($out_trade_no) {
        $order = M("order_pmding")->where(array('order_no' => $out_trade_no))->find();
        $total_amount = $order['baoding'];
        $b_data['pay_way'] = 3;
        $b_data['order_status'] = 1;
        $b_data['pay_status'] = 1;
        $b_data['pay_price'] = $total_amount;
        $b_data['pay_time'] = time();
        $res = M("order_pmding")->where(array('id' => $order['id']))->save($b_data);
        if (!$res) {
            // 这里记入错误日志
            $msg = "用户支付成功，拍卖保证金订单改变状态失败！";
            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
        }
        $data_w['user_id'] = $_SESSION['member_id'];
        $data_w['type'] = 2;
        $data_w['posttime'] = time();
        $data_w['order_id'] = $order['id'];
        $data_w['cate'] = 0;
        $data_w['expend'] = $total_amount;
        $data_w['way_name'] = "支付拍品保定金";
        M('money_water')->add($data_w);
    }


    /**
     * 拍卖入驻微信支付
     * @param $out_trade_no
     */
    public function ruzhuWxinPay($out_trade_no) {
        $order = M("ruzhu")->where(array('pay_order' => $out_trade_no))->find();
        $total_amount = $order['price'];

        $r_data['pay_type'] = 3;
        $r_data['pay_status'] = 1;
        $r_data['pay_endtime'] = time();
        $res = M("ruzhu")->where(array('id' => $order['id']))->save($r_data);
        if (!$res) {
            // 这里记入错误日志
            $msg = "用户支付成功，拍卖入驻改变状态失败！";
            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
        }
        $data_w['user_id']=$_SESSION['member_id'];
        $data_w['type']=2;
        $data_w['posttime']=time();
        $data_w['order_id']=$order['id'];
        $data_w['cate']=0;
        $data_w['expend']=$total_amount;
        $data_w['way_name']="申请入驻拍卖 缴纳保证金";
        M('money_water')->add($data_w);
    }

    /**
     * 拍卖微信支付
     * @param $out_trade_no
     */
    public function pmWxinPay($out_trade_no) {
        $order = M("order_pm")->where(array('order_no' => $out_trade_no))->find();
        $total_amount = $order['total_fee'];

        $b_data['pay_way'] = 3;
        $b_data['order_status'] = 2;
        $b_data['pay_status'] = 1;
        $b_data['pay_price'] =  $total_amount;
        $b_data['pay_time'] = time();

        $res = M("order_pm")->where(array('id' => $order['id']))->save($b_data);
        if (!$res) {
            // 这里记入错误日志
            $msg = "用户支付成功，拍品订单改变状态失败！";
            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
        }

        $pm = M('pm')->where(array('id'=>$order['goods_id']))->find();
        /*if($res['promulgator']!=0){*/
        $s_data['user_id'] = $pm['promulgator'];
        $s_data['price'] = $order['goods_price'];
        $s_data['yongjin_price'] = $order['goods_price']*$pm['yongjin']/100;
        $s_data['huode_price'] = $order['goods_price']-$s_data['yongjin_price'];
        $s_data['addtime'] = time();
        $s_data['is_settl'] = 0;
        $s_data['order_id'] = $order['id'];
        $s_data['goods_id'] = $pm['id'];
        $res3 = M('settl')->add($s_data);
        if(!$res3){
            // 这里记入错误日志
            $msg = "用户支付成功，生成结算记录失败！";
            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
        }
        $data_w['user_id']=$_SESSION['member_id'];
        $data_w['type']=2;
        $data_w['posttime']=time();
        $data_w['order_id']=$order['id'];
        $data_w['cate']=0;
        $data_w['expend']=$total_amount;
        $data_w['way_name']="拍品支付";
        M('money_water')->add($data_w);
    }

    /**
     * 培训费用微信支付
     * @param $out_trade_no
     * @param $transaction_id
     * @param $total_fee
     */
    public function trainWxinPay($out_trade_no, $transaction_id, $total_fee) {
        $m = M("train_order");
        $order = $m->where(array("order_no" => $out_trade_no))->find();
        if($order['pay_status'] == 0){
            $b_data['pay_way'] = 1;
            $b_data['order_status'] = 4;
            $b_data['pay_status'] = 1;
            $b_data['pay_price'] =  $total_fee;
            $b_data['pay_time'] = time();
            $b_data['trade_no'] = $transaction_id;

            $m->where(array('id' => $order['id']))->save($b_data);
            /* }*/
        }

        $data_w['user_id']=$order['user_id'];
        $data_w['type']=1;
        $data_w['posttime']=time();
        $data_w['order_id']=$order['id'];
        $data_w['cate']=1;
        $data_w['expend']=$total_fee;
        $data_w['way_name']="培训报名支付";
        $res1 = M('money_water')->add($data_w);
    }

    /**
     * order表的微信支付回调
     * @param $out_trade_no
     * @param $transaction_id
     * @param $total_fee
     */
    public function orderWxinPay($out_trade_no, $transaction_id, $total_fee) {
        $m = M("order_info");
        $order = $m->where(array("order_no" => $out_trade_no))->find();
        //$total_fee = $order['total_fee'];
        if ($order['pay_status'] == 0) {
            // 返佣金  return_price
            $user = M('member')->find($order['user_id']);
            $data = array(
                "pay_status" => 1,
                "trade_no" => $transaction_id,//流水号
                "order_status" => 2,
                "pay_price" => $total_fee,
                "pay_way" => 2,//微信支付
                "pay_time" => time(),
            );
            $res = $m->where(array('id' => $order['id']))->save($data);
            if (!$res) {
                // 这里记入错误日志
                $msg = "用户支付成功，订单改变状态失败！";
                $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
            }
            //2.增加销量 减少库存
            //$res2 = $this->delStore($order['id']);

            //3.记录流水账
            $m_data = array(
                'user_id' => $order['user_id'],
                'type' => 2,
                'expend' => $total_fee,
                'cate' => 0,
                'posttime' => time(),
                'order_id' => $order['id'],
            );

            M('money_water')->add($m_data);
            /*//如果有使用代金券则改变代金券的状态 zqj 20171104
            M('link_coupon')->where(array('status'=>2,'id'=>$order['couponsid']))->setField('status',3);//order/pay那边控制器写的是如果订单生成，则代金券的状态为2已锁定
            //用商品总金额算收益 排除运费 查看是否达到当月的销售额 销售件数 晋升等级*/
            /*if($order['tj_status'] == 1){
                $tj_shop = $order['tj_shop'];//店铺id
                //抽佣金 加到余额里面
                $artist = M('artist')->where(array('shenhe'=>1,'is_del'=>0,'id'=>$tj_shop))->find();
                $memid = $artist['member_id'];
                $wallet = M('member')->where(array('isdel'=>0,'id'=>$memid))->getField('wallet');
                $yong_fee = sprintf('%.2f',$wallet+$order['yong_fee']);
                M('member')->where(array('isdel'=>0,'id'=>$memid))->setField('wallet',$yong_fee);
                ////////
                //先计算当月的 件数 销售额
                /*$starttime =strtotime(date('Y-m-d H:i:s',mktime(0, 0 , 0,date('m'),1,date('Y')))) ;
                $endtime = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y'))));
                //var_dump($endtime);
                $map['tj_status'] = 1;
                $map['order_status'] = 4; // 已完成订单
                $map['tj_shop'] = $tj_shop; //
                $map['update_time'] = array('between',('$starttime,$endtime'));
                $sum = M('order_info')->order('update_time desc')->where($map)->sum('total_price');
                $counts =  M('order_info')->order('update_time desc')->where($map)->count();
                //计算云推荐的收益  然后再是否符合条件发放代金券
                $yun = M('yunrecomm as ys')->where(array('is_del'=>0))->select();
                $juan = "";
                foreach($yun as $key => $val){
                    if($val['company'] == '万'){
                        $val['salesquota'] = $val['salesquota']*10000;
                    }else{
                        $val['salesquota'] = $val['salesquota'];
                    }
                    if($counts >= $val['product'] && $sum >= $val['salesquota']){
                        $juan += $val.","; //把可以获取的卷的id存起来
                    }
                }
                if(!empty(explode(',',$juan))){
                    //可以获得 得到最多的卷
                    $juan = explode(',',$juan);
                    //print_r($juan);die;
                    $ju['is_del'] = 0;
                    $ju['id'] = array('in',$juan);
                    $jyun = M('yunrecomm')->where($ju)->max('giftcard');
                    if($jyun){
                        //查询到可以获得的优惠券id
                        $yures = M('yunrecomm')->where(array('is_del'=>0,'giftcard'=>$jyun))->find();
                        $cid = M('coupon')->where(array('condition1'=>$yures['id']))->select();//'1：白金经纪人券 2：黄金经纪人 3：黑金经纪人',
                        $aid = $order['tj_shop'];//推荐店铺的id
                        $member_id = M('artist')->where(array('shenhe'=>1,'id'=>$aid))->getField('member_id');
                        $arr['user_id'] = $member_id;
                        $arr['status'] = 1;
                        $arr['get_time'] = time();
                        $arr['coupon_id'] = $cid['id'];
                        M('link_coupon')->add($arr);
                        ////////晋升等级
                        M('member')->where(array('isdel'=>0,'id'=>$member_id))->setField('vip',$yures['id']);

                    }
                }

            }*/
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
                            $msg = "用户支付成功，增加艺术家店铺用户余额失败！";
                            $this->addToOrderErrorLog($apply['user_id'], $v['id'], $msg);
                        }
                        $data_w['user_id']=$apply['user_id'];
                        $data_w['type']=1;
                        $data_w['posttime']=time();
                        $data_w['cate']=1;
                        $data_w['wallet']=$price;
                        $data_w['way_name']="店铺商品收益";
                        M('money_water')->add($data_w);
                    }
                    $res6 = M('goods')->where(array('id'=>$v['goods_id']))->save(array('is_buy'=>1,'is_sale'=>0));
                    if(!$res6){
                        $msg = "用户支付成功，艺术品修改状态失败！";
                        $this->addToOrderErrorLog($apply['user_id'], $v['id'], $msg);
                    }
                    //已购买
                }else{//创意商店
                    if($v['is_reed']==1){//推荐购买
                        $yun_apply = M('yun_apply')->where(array('id'=>$v['reed_id']))->find();
                        $info_member =  M('member')->where(array('id'=>$yun_apply['user_id']))->find();
                        $info_right = M('yun_right')->where(array('level'=>$yun_apply['level']))->find();
                        $price = sprintf("%.2f",($v['goods_price']*($info_right['rate']/100)));
                        $res4 = M('member')->where(array('id'=>$yun_apply['user_id']))->save(array('wallet'=>$info_member['wallet']+$price));
                        if(!$res4){
                            $msg = "用户支付成功，增加推荐店铺用户余额失败！";
                            $this->addToOrderErrorLog($yun_apply['user_id'], $v['id'], $msg);
                        }
                        $data_w['user_id']=$yun_apply['user_id'];
                        $data_w['type']=1;
                        $data_w['posttime']=time();
                        $data_w['cate']=1;
                        $data_w['wallet']=$price;
                        $data_w['way_name']="推荐店铺商品收益";
                        M('money_water')->add($data_w);
                    }
                    //加销量
                    $goods = M('goods')->where(array('id'=>$v['goods_id']))->find();
                    $res5 = M('goods')->where(array('id'=>$v['goods_id']))->save(array('volume'=>$goods['volume']+$v['goods_nums']));
                    if(!$res5){
                        $msg = "用户支付成功，增加销量失败！";
                        $this->addToOrderErrorLog('', $v['id'], $msg,$goods['goods_id']);
                    }
                }
            }
        }
    }


    public function weixin_payzc(){
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();
        $log_name = "./log/wxpay_log.txt"; // 文本日志保存路径
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        log_result($log_name,"【接收到的notify通知1】:\n".$returnXml."\n");
        log_result($log_name,"【接收到的notify通知3】:\n".$xml."\n");
        echo $returnXml;
        //====================================更新订单状态==================================//
        $obj=(array)simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        $transaction_id = $obj['transaction_id'];   //流水账号
        $result_code    = $obj['result_code'];      //成功 SUCCESS
        $return_code    = $obj['return_code'];      //成功 SUCCESS
        $out_trade_no   = $obj['out_trade_no'];    	//订单号

        //==================测试=====================
        $total_fee      =$obj['total_fee']/100;
//        $total_fee      =1000;
        //==================测试=====================

        $openid         = $obj['openid'];			//支付者微信openid

        $timestamp      = time();
        log_result($log_name,"transaction_id:\n".$transaction_id."\n");
        log_result($log_name,"result_code:\n".$result_code."\n");
        log_result($log_name,"return_code:\n".$return_code."\n");
        log_result($log_name,"out_trade_no:\n".$out_trade_no."\n");
        log_result($log_name,"total_fee:\n".$total_fee."\n");
        log_result($log_name,"openid:\n".$openid."\n");
        log_result($log_name,"timestamp:\n".$timestamp."\n");
        log_result($log_name,"【接收到的notify通知2】:\n".$xml."\n");

        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                log_result($log_name,"【通信出错】:\n".$xml."\n");
            }elseif($notify->data["result_code"] == "FAIL"){
                log_result($log_name,"【业务出错】:\n".$xml."\n");
            }else{
                log_result($log_name,"【支付成功】:\n".$xml."\n");
                if($result_code=="SUCCESS" && $return_code=="SUCCESS"){

                    $header = mb_substr($out_trade_no,0,2,'utf-8');
                    if($header=='YU'){
                        $m = M("gift_order");
                    }else{
                        $m = M("order_crowd");
                    }

                    $order = $m->where(array("order_no" => $out_trade_no))->find();
                    //$total_fee = $order['total_fee'];
                    if ($order['pay_status'] == 0) {
                        // 返佣金  return_price
                        //$user = M('member')->find($order['user_id']);
                        $data = array(
                            "pay_status" => 1,
                            "trade_no" => $transaction_id,//流水号
                            "order_status" => 2,
                            "pay_price" => $total_fee,
                            "pay_way" => 2,//微信支付
                            "pay_time" => time(),
                        );
                        $res = $m->where(array('id' => $order['id']))->save($data);
                        if (!$res) {
                            // 这里记入错误日志
                            $msg = "用户支付成功，订单改变状态失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }
                        //2.增加销量 减少库存
                        //$res2 = $this->delStore($order['id']);

                        //3.记录流水账
                        if($header=='YU'){
                            $info = M('yun_gift')->where(array('id'=>$order['gift_id']))->find();
                            $info2 = M('yun_right')->where(array('level'=>$info['level']))->find();
                            $data3['level'] = $info['level'];
                            $data3['nums'] = $info2['num'];
                            $data3['shenhe'] = 2;
                            $data3['ruzhu_status'] = 3;
                            $data3['user_id'] = $_SESSION['member_id'];
                            $data3['addtime'] = time();
                            $res4 = M('yun_apply')->where(array('user_id'=>$order['user_id']))->add($data3);
                            if(!$res4){
                                $msg = "用户支付成功，云推荐店铺修改等级失败！";
                                $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                            }
                            $yun = M('member')->where(array('id'=>$order['user_id']))->setField(array('yun_level'=>$info['level'],'user_type'=>1));
                            if(!$yun){
                                $msg = "用户支付成功,用户云推荐等级更改失败!";
                                $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                            }
                            $m_data = array(
                                'user_id' => $order['user_id'],
                                'type' => 2,
                                'expend' => $total_fee,
                                'cate' => 0,
                                'way_name'=>'礼包支付',
                                'posttime' => time(),
                                'order_id' => $order['id'],
                            );
                        }else{
                            $m_data = array(
                                'user_id' => $order['user_id'],
                                'type' => 2,
                                'expend' => $total_fee,
                                'cate' => 0,
                                'way_name'=>'众筹支付',
                                'posttime' => time(),
                                'order_id' => $order['id'],
                            );
                        }


                        M('money_water')->add($m_data);
                        /*//如果有使用代金券则改变代金券的状态 zqj 20171104
                        M('link_coupon')->where(array('status'=>2,'id'=>$order['couponsid']))->setField('status',3);//order/pay那边控制器写的是如果订单生成，则代金券的状态为2已锁定
                        //用商品总金额算收益 排除运费 查看是否达到当月的销售额 销售件数 晋升等级
                        if($order['tj_status'] == 1){
                            $tj_shop = $order['tj_shop'];//店铺id
                            //抽佣金 加到余额里面
                            $artist = M('artist')->where(array('shenhe'=>1,'is_del'=>0,'id'=>$tj_shop))->find();
                            $memid = $artist['member_id'];
                            $wallet = M('member')->where(array('isdel'=>0,'id'=>$memid))->getField('wallet');
                            $yong_fee = sprintf('%.2f',$wallet+$order['yong_fee']);
                            M('member')->where(array('isdel'=>0,'id'=>$memid))->setField('wallet',$yong_fee);
                            ////////
                            //先计算当月的 件数 销售额
                            $starttime =strtotime(date('Y-m-d H:i:s',mktime(0, 0 , 0,date('m'),1,date('Y')))) ;
                            $endtime = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y'))));
                            //var_dump($endtime);
                            $map['tj_status'] = 1;
                            $map['order_status'] = 4; // 已完成订单
                            $map['tj_shop'] = $tj_shop; //
                            $map['update_time'] = array('between',('$starttime,$endtime'));
                            $sum = M('order_info')->order('update_time desc')->where($map)->sum('total_price');
                            $counts =  M('order_info')->order('update_time desc')->where($map)->count();
                            //计算云推荐的收益  然后再是否符合条件发放代金券
                            $yun = M('yunrecomm as ys')->where(array('is_del'=>0))->select();
                            $juan = "";
                            foreach($yun as $key => $val){
                                if($val['company'] == '万'){
                                    $val['salesquota'] = $val['salesquota']*10000;
                                }else{
                                    $val['salesquota'] = $val['salesquota'];
                                }
                                if($counts >= $val['product'] && $sum >= $val['salesquota']){
                                    $juan += $val.","; //把可以获取的卷的id存起来
                                }
                            }
                            if(!empty(explode(',',$juan))){
                                //可以获得 得到最多的卷
                                $juan = explode(',',$juan);
                                //print_r($juan);die;
                                $ju['is_del'] = 0;
                                $ju['id'] = array('in',$juan);
                                $jyun = M('yunrecomm')->where($ju)->max('giftcard');
                                if($jyun){
                                    //查询到可以获得的优惠券id
                                    $yures = M('yunrecomm')->where(array('is_del'=>0,'giftcard'=>$jyun))->find();
                                    $cid = M('coupon')->where(array('condition1'=>$yures['id']))->select();//'1：白金经纪人券 2：黄金经纪人 3：黑金经纪人',
                                    $aid = $order['tj_shop'];//推荐店铺的id
                                    $member_id = M('artist')->where(array('shenhe'=>1,'id'=>$aid))->getField('member_id');
                                    $arr['user_id'] = $member_id;
                                    $arr['status'] = 1;
                                    $arr['get_time'] = time();
                                    $arr['coupon_id'] = $cid['id'];
                                    M('link_coupon')->add($arr);
                                    ////////晋升等级
                                    M('member')->where(array('isdel'=>0,'id'=>$member_id))->setField('vip',$yures['id']);

                                }
                            }

                        }*/
                    }
                }
            }
        }else{
            //此处应该更新一下订单状态，商户自行增删操作
            log_result($log_name,"【签名错误】");
        }
    }

    public function czweixin_pay(){
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();
        $log_name = "./log/wxpay_log.txt"; // 文本日志保存路径
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        log_result($log_name,"【接收到的notify通知1】:\n".$returnXml."\n");
        log_result($log_name,"【接收到的notify通知3】:\n".$xml."\n");
        echo $returnXml;
        //====================================更新订单状态==================================//
        $obj=(array)simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        $transaction_id = $obj['transaction_id'];   //流水账号
        $result_code    = $obj['result_code'];      //成功 SUCCESS
        $return_code    = $obj['return_code'];      //成功 SUCCESS
        $out_trade_no   = $obj['out_trade_no'];    	//订单号

        //==================测试=====================
        $total_fee      =$obj['total_fee']/100;
//        $total_fee      =1000;
        //==================测试=====================

        $openid         = $obj['openid'];			//支付者微信openid

        $timestamp      = time();
        log_result($log_name,"transaction_id:\n".$transaction_id."\n");
        log_result($log_name,"result_code:\n".$result_code."\n");
        log_result($log_name,"return_code:\n".$return_code."\n");
        log_result($log_name,"out_trade_no:\n".$out_trade_no."\n");
        log_result($log_name,"total_fee:\n".$total_fee."\n");
        log_result($log_name,"openid:\n".$openid."\n");
        log_result($log_name,"timestamp:\n".$timestamp."\n");
        log_result($log_name,"【接收到的notify通知2】:\n".$xml."\n");

        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                log_result($log_name,"【通信出错】:\n".$xml."\n");
            }elseif($notify->data["result_code"] == "FAIL"){
                log_result($log_name,"【业务出错】:\n".$xml."\n");
            }else{
                log_result($log_name,"【支付成功】:\n".$xml."\n");
                if($result_code=="SUCCESS" && $return_code=="SUCCESS"){
                    M()->startTrans();
                    $m = M("money_order");
                    $order = $m->where(array("order_no" => $out_trade_no))->find();
                    if ($order['status'] == 0) {
                        $data = array(
                            "status" => 1,
                            'money'  =>$total_fee,
                        );
                        $res = $m->where(array('id' => $order['id']))->save($data);
                        if (!$res) {
                            // 这里记入错误日志
                            $msg = "用户支付成功，充值订单改变状态失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }
                        $res1= M('member')->where(array('id'=>$order['user_id']))->setInc('wallet',$total_fee);
                        if(!$res1){
                            M()->rollback();
                            // 这里记入错误日志
                            $msg = "用户支付成功，改变用户余额失败！";
                            $this->addToOrderErrorLog($order['user_id'], $order['id'], $msg);
                        }
                        M()->commit();
                    }
                }
            }
        }else{
            //此处应该更新一下订单状态，商户自行增删操作
            log_result($log_name,"【签名错误】");
        }
    }

    public function train_pay(){
        vendor('WxPayPubHelper.WxPayPubHelper');
        $notify = new \Notify_pub();
        $log_name = "./log/wxpay_log.txt"; // 文本日志保存路径
        $log_name2 = "./a.txt";
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        if($notify->checkSign() == FALSE){
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        log_result($log_name,"【接收到的notify通知1】:\n".$returnXml."\n");
        log_result($log_name,"【接收到的notify通知3】:\n".$xml."\n");
        log_result($log_name2,"【接收到的notify通知1】:\n".$returnXml."\n");
        log_result($log_name2,"【接收到的notify通知3】:\n".$xml."\n");
        echo $returnXml;
        //====================================更新订单状态==================================//
        $obj=(array)simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        $transaction_id = $obj['transaction_id'];   //流水账号
        $result_code    = $obj['result_code'];      //成功 SUCCESS
        $return_code    = $obj['return_code'];      //成功 SUCCESS
        $out_trade_no   = $obj['out_trade_no'];    	//订单号

        //==================测试=====================
        $total_fee      =$obj['total_fee']/100;
//        $total_fee      =1000;
        //==================测试=====================

        $openid         = $obj['openid'];			//支付者微信openid

        $timestamp      = time();
        log_result($log_name,"transaction_id:\n".$transaction_id."\n");
        log_result($log_name,"result_code:\n".$result_code."\n");
        log_result($log_name,"return_code:\n".$return_code."\n");
        log_result($log_name,"out_trade_no:\n".$out_trade_no."\n");
        log_result($log_name,"total_fee:\n".$total_fee."\n");
        log_result($log_name,"openid:\n".$openid."\n");
        log_result($log_name,"timestamp:\n".$timestamp."\n");
        log_result($log_name,"【接收到的notify通知2】:\n".$xml."\n");

        log_result($log_name2,"transaction_id:\n".$transaction_id."\n");
        log_result($log_name2,"result_code:\n".$result_code."\n");
        log_result($log_name2,"return_code:\n".$return_code."\n");
        log_result($log_name2,"out_trade_no:\n".$out_trade_no."\n");
        log_result($log_name2,"total_fee:\n".$total_fee."\n");
        log_result($log_name2,"openid:\n".$openid."\n");
        log_result($log_name2,"timestamp:\n".$timestamp."\n");
        log_result($log_name2,"【接收到的notify通知2】:\n".$xml."\n");

        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                log_result($log_name,"【通信出错】:\n".$xml."\n");
                log_result($log_name2,"【通信出错】:\n".$xml."\n");
            }elseif($notify->data["result_code"] == "FAIL"){
                log_result($log_name,"【业务出错】:\n".$xml."\n");
                log_result($log_name2,"【业务出错】:\n".$xml."\n");
            }else{
                log_result($log_name,"【支付成功】:\n".$xml."\n");
                log_result($log_name2,"【支付成功】:\n".$xml."\n");
                if($result_code=="SUCCESS" && $return_code=="SUCCESS"){
                    M()->startTrans();
                    $m = M("train_order");
                    $order = $m->where(array("order_no" => $out_trade_no))->find();
                    $total_fee = $order['price'];
                    if($order['pay_status'] == 0){
                        $b_data['pay_way'] = 1;
                        $b_data['order_status'] = 4;
                        $b_data['pay_status'] = 1;
                        $b_data['pay_price'] =  $total_fee;
                        $b_data['pay_time'] = time();

                        $m->where(array('id' => $order['id']))->save($b_data);
                        /* }*/
                    }

                    $data_w['user_id']=$order['user_id'];
                    $data_w['type']=1;
                    $data_w['posttime']=time();
                    $data_w['order_id']=$order['id'];
                    $data_w['cate']=1;
                    $data_w['expend']=$total_fee;
                    $data_w['way_name']="培训报名支付";
                    $res1 = M('money_water')->add($data_w);

                    M()->commit();

                }
            }
        }else{
            //此处应该更新一下订单状态，商户自行增删操作
            log_result($log_name,"【签名错误】");
            log_result($log_name2,"【签名错误】");
        }
    }
}
