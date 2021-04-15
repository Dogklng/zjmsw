<?php namespace Home\Controller;

use Think\Controller;

class CeshiController extends Controller
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



    public function index()
    {
       
    	header("Content-Type: text/html; charset=UTF-8");
    	// 查询出局并且已经支付的订单
    	$pmdingList = M('order_pmding')->where('id >518 and status = 1 and is_jieshu = 1 and order_status = 1 and pay_status=1')->select();

    	var_dump($pmdingList);
    }





	function AliPayPlaceRefund(){
//        var_dump(trim($this->alipay_config['sign_type']));
//        var_dump(trim($this->alipay_config['input_charset']));
//        exit;

        // $refund_order = generateOrderId(9);
        $alipay_config = $this->alipay_config();
        $refund_order = 'BDJ2021022449524957';
        $refund_amount = '0.01';

        $BizContent = array(
            "out_trade_no" => $refund_order,  //商户订单号，64个字符以内、可包含字母、数字、下划线；需保证在商户端不重复
            "refund_amount" => $refund_amount,        //退款金额 单位为元，精确到小数点后两位，取值范围[0.01,100000000]
            "refund_reason" => '正常退款',            //退款原因说明，商家自定义。
            "out_request_no" => '',        //标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
            "operator_id" => '',        //商户的操作员编号
            "store_id" => '',        //商户门店编号，由商家自定义。需保证当前商户下唯一。
            "terminal_id" => '',        //商户的终端编号
        );
        $BizContent = json_encode($BizContent);

        vendor("Alipay.AopSdk");
        $aop = new \AopClient;
        $aop->gatewayUrl =  'https://openapi.alipay.com/gateway.do';
        $aop->appId = $alipay_config['app_id'];
        $aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $aop->alipayrsaPublicKey = $alipay_config['alipay_public_key'];
        $aop->apiVersion = '1.0';
//        $aop->signType = trim($this->alipay_config['sign_type']);
        $aop->signType = 'RSA2';
//        $aop->postCharset=trim($this->alipay_config['input_charset']);
        $aop->postCharset='utf-8';
//        $aop->format="JSON";
        $aop->format="json";//使用大写获取到的$resultCode为空
        $request = new \AlipayTradeRefundRequest();
        $request->setBizContent($BizContent);
        //var_dump($aop);exit;

        $result = $aop->execute( $request );
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        var_dump($result->$responseNode);exit;
        if(!empty($resultCode)&&$resultCode == 10000){
//            echo "成功";
            return true;
        } else {
//            echo "失败";
            throw new Exception($result->$responseNode->sub_msg);
        }
    }



}