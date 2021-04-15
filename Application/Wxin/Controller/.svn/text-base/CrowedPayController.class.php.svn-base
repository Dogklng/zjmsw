<?php

namespace Wxin\Controller;

use Think\Controller;

class CrowedPayController extends BaseController
{


    /** 20170713 wzz
     *电脑支付配置
     **/
    protected  function alipay_config()
    {
        $alipay_config = array(
            //APPID 即创建应用后生成       更新5-1
            'app_id' => "2015122301028610",
            //同步跳转地址，公网可以访问   更新5-2
            'return_url' => "http://msw.unohacha.com/Home/CrowedPay/ReturnURL",
			
            //异步通知地址，公网可以访问   更新5-3
            'notify_url' => "http://msw.unohacha.com/Home/CrowedPay/NotifyURL",
	
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
			//dump($out_trade_no);
            $m = M("order_crowd");
            $order = $m->where(array("order_no" => $out_trade_no))->find();
            //dump($order);exit;
            if ($order) {
                $this->redirect('/Home/ArtCommunity/crowdFunding');
            } else {
                $this->error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->error("订单支付失败！");
        }
    }


    /** 20170713 wzz
     * 电脑支付异步通知
     * 1.更新订单状态
     * 2.增加销量 减少库存
     * 3.记录流水账
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
                $m = M("order_crowd");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
				$total_fee = $order['price'];
                if ($order['pay_status'] == 0) {
                    $data = array(
                        "pay_status" => 1,
						"trade_no" => $trade_no,
                        "order_status" => 2,
                        "pay_price" => $total_amount,
                        "pay_way" => 1,//支付宝支付
                        "pay_time" => time(),
                    );
                   $m->where(array('id' => $order['id']))->save($data);
                    //2.记录流水账
                    $m_data = array(
                        'user_id' => $order['user_id'],
                        'type' => 2,
                        'expend' => $total_fee,
                        'cate' => 0,
                        'way_name'=>'众筹支付',
                        'posttime' => time(),
                        'order_id' => $order['id'],
                    );

                    M('money_water')->add($m_data);
                }

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

        //$out_trade_no = $_GET["order_no"];
		$out_trade_no = trim(I("order_no"));

        if (!$out_trade_no) {
            $this->error("无此订单号不存在！");
        }
        $order = M("order_crowd")->where(array('order_no' => $out_trade_no))->find();
        if (!$order) {
            $this->error("无此订单！");
        }
        if ($order['pay_status'] != 0) {
            $this->error("订单无法支付！");
        }
        $subject = "浙江美术网支付宝订单支付";
        $total_amount = $order['total_fee'];
        $body = "";

        /******************测试数据 1******************/
        //$subject = "浙江美术网支付宝支付";
        //$total_amount = 0.01;
        //$body = "body测试";
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
        //输出
        echo $result;
        /*********************封装 2***********************/
    }

}
