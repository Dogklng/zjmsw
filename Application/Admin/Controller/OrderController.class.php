<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Controller\CommonController;
class OrderController extends CommonController {

    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function guihuan(){
        $res = M('order_info')->where(array('id'=>$_POST['id']))->find();
        $m = M('member')->where(array('id'=>$res['user_id']))->find();
        $wallet =sprintf('%.2f',$m['wallet'] + $res['total_price']);
        $mem = M('member')->where(array('id'=>$res['user_id']))->setField('wallet',$wallet);
        $res = M('order_info')->where(array('id'=>$_POST['id']))->save(array('order_status'=>5));
        if($res && $mem){
            $this->ajaxReturn(array("status" => 1, 'info' => "归还成功"));
        }else{
            $this->ajaxReturn(array("status" => 0, 'info' => "归还失败"));
        }
    }

    /**
     * 订单状态（0：已取消，1：待付款,2：待发货，3：已发货，4：已完成，5：已关闭，6：退款中， 7：订单删除）
     */
    public function index() {
        //查询
//        if(IS_GET){
            $telephone      = trim(I("param.telephone"));
            $person_name    = trim(I("param.person_name"));
            $order_no       = trim(I("param.order_no"));
            $starttime      = I("param.starttime");
            $endtime        = I("param.endtime");
            $this->assign('starttime',$starttime);
            $this->assign('endtime',$endtime);

            $this->assign('telephone',$telephone );
            $this->assign('person_name',$person_name );
            $this->assign('order_no',$order_no );
            if($telephone){
                $map['b.telephone']=array('like',"%$telephone%");
            }
           if($person_name){
               $map['b.person_name']=array('like',"%$person_name%");
           }
          if($order_no){
              $map['a.order_no']=array('like',"%$order_no%");
          }
          $order_status=I('param.order_status');
          if($order_status){
              $map['a.order_status']=$order_status==10?0:$order_status;
          }
            if($starttime){
                $starttime      = strtotime($starttime.'00:00:00');
                $endtime        = strtotime($endtime.'23:59:59');
                $map['a.order_time']=array('between',array($starttime,$endtime));
            }

            $order_info_db=M('order_info');

            /*if($starttime != null ){
                $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_info a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%' AND a.order_time BETWEEN '{$starttime}' AND '{$endtime}'";
            }else{
                $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.id,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_info a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%'";
            }
            $res = M("order_info")->query($sql);*/
            $count =$order_info_db
                ->alias('a')
                ->join('left join app_member as b on a.user_id=b.id')
                ->field('b.telephone,a.tj_shop,a.tj_status,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name')
                ->where($map)
                ->count();
//            echo $order_info_db->getLastSql();
            $Page  = getpage($count,5);
            $show  = $Page->show();//分页显示输出
            $res=$order_info_db
                ->alias('a')
                ->join('left join app_member as b on a.user_id=b.id')
                ->field('b.telephone,a.tj_shop,a.tj_status,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name')
                ->where($map)
                ->limit($Page->firstRow,$Page->listRows)
                ->order('order_time desc')
                ->select();
            foreach($res as $key => $val){
                if($val['tj_shop'] == 0){
                    $res[$key]['arname'] = '后台发布';
                }else{
                    $res[$key]['arname'] = M('apply')->where(array('id'=>$val['tj_shop']))->getField('name');
                }

            }
            $this->assign("page",$show);
            $this->assign('cache',$res);


//        }else{
//            //显示
//            $status = $_GET['order_status'];
//            if($status === null ){
//                $count = M("order_info")->count();
//                $Page  = getpage($count,5);
//                $show  = $Page->show();//分页显示输出
//                $sql   = "select b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name from app_order_info a left join app_member b on a.user_id=b.id order by a.id desc limit"." ".$Page->firstRow.",".$Page->listRows."";
//                $res = M("order_info")->query($sql);
//                // dump($res);exit;
//                //$res  = M("order_info")->alias("a")->join("app_status b on a.order_status=b.status_id")->order_info('a.id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
//                $this->assign("page",$show);
//            }else{
//                $count = M("order_info")->where("order_status=$status")->count();
//                $Page  = getpage($count,5);
//                $show  = $Page->show();//分页显示输出
//                $sql   = "select b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name from app_order_info a left join app_member b on a.user_id=b.id where a.order_status=$status order by a.id desc limit"." ".$Page->firstRow.",".$Page->listRows." ";
//                $res = M("order_info")->query($sql);
//                //$res  = M("order_info")->alias("a")->join("app_order_status b on a.order_status=b.status_id")->where("a.order_status=$status")->order_info('a.id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
//                $this->assign("page",$show);
//            }
//            $this->assign('cache',$res);
//        }
//        p($res);
//        $m = D('order_info');
        unset($map['a.order_status']);
        $count = $order_info_db ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->count();
        $count0 = $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)
            ->where(array("order_status"=>0))
            ->count();//已取消
        $count1 =  $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)
            ->where(array("order_status"=>1))
            ->count();//待付款
        $count2 = $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>2))->count();//待发货
        $count3 = $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>3))->count();//待收货
        $count4 = $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>4))->count();//已签收
        $count5 = $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>5))->count();//已关闭
        $count6 = $order_info_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>6))->count();//退款
        $this->assign("count",  $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);
        $this->assign("count4", $count4);
        $this->assign("count5", $count5);
        $this->assign("count6", $count6);
        /**
         * 物流公司 2016-1-3   Jaw
         */
        $express = M("express")->order("id asc")->select();
        $this->assign("express_list",$express);
        $this->display();
    }
    /*
     * 租赁订单
     */
    public function zulin(){
        //查询
        if (IS_GET) {
            $status = $_GET['order_status'];
            $telephone      = trim(I("get.telephone"));
            $person_name    = trim(I("get.person_name"));
            $order_no       = trim(I("get.order_no"));
            $starttime=I('get.starttime');
            $endtime=I('get.endtime');
            $this->assign('telephone',$telephone);
            $this->assign('person_name',$person_name);
            $this->assign('order_no',$order_no);
            $this->assign('starttime',$starttime);
            $this->assign('endtime',$endtime);
            $where1=array();
            if($starttime != ''){
                $starttime      = trim(strtotime($starttime));
            }else{
                $starttime ='';
            }
            if($endtime!= ''){
                $endtime        = trim(strtotime($endtime))+24*3600;
            }else{
                $endtime   ='';
            }
            if($telephone){

                $where['b.telephone'] = array('like',"%$telephone%");
                $where1['b.telephone'] = array('like',"%$telephone%");
            }
            if($person_name){
                $where['b.person_name'] = array('like',"%$person_name%");
                $where1['b.person_name'] = array('like',"%$person_name%");
            }

            if($starttime && $endtime){
                $where['a.order_time'] = array('between',array($starttime,$endtime));
                $where['a.order_time'] = array('between',array($starttime,$endtime));

            }else{
                if($starttime){
                    $where['a.order_time'] = array('gt',$starttime);
                    $where1['a.order_time'] = array('gt',$starttime);
                }
                if($endtime){
                    $where['a.order_time'] = array('lt',$endtime);
                    $where1['a.order_time'] = array('lt',$endtime);
                }
            }
            if($order_no){
                $where['a.order_no'] = array('like',"%$order_no%");
                $where1['a.order_no'] = array('like',"%$order_no%");
            }
            $where['is_recommend'] = 0;
            $where1['is_recommend'] = 0;

            //显示
            if ($status === null) {
                $count = M("order_info")->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->where($where)->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $res = M("order_info")->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow, $Page->listRows)->order('a.id desc')->select();


                $this->assign("page", $show);
            } else {
                $where['a.order_status']=$status;
                $count = M("order_info")->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->where($where)->count();
                $Page = getpage($count, 5);
                $show = $Page->show();//分页显示输出
                //  $where['a.is_del']=0;
                $where['a.order_status']=$status;
                $res = M("order_info")->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow, $Page->listRows)->order('a.id desc')->select();
                $this->assign("page", $show);
            }
            $this->assign('cache', $res);
        }
        $m = D('order_info');
        $count = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where($where1)->count();
        $count0 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 0))->where($where1)->count();//已取消
        $count1 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 1))->where($where1)->count();//待付款
        $count2 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 2))->where($where1)->count();//待发货
        $count3 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 3))->where($where1)->count();//待收货
        $count4 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 4))->where($where1)->count();//已签收
        $count5 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 5))->where($where1)->count();//已关闭
        $count6 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 6))->where($where1)->count();//退款
        $count7 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 7))->where($where1)->count();//退款
        //$count8 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status"=> 8))->where($where1)->count();//退款
        $count8 = $m->alias("a")->join('LEFT JOIN __MEMBER__ b on a.user_id = b.id')->where(array("a.order_status" => 8))->where($where1)->count();//退款
        $this->assign("count", $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);
        $this->assign("count4", $count4);
        $this->assign("count5", $count5);
        $this->assign("count6", $count6);
        $this->assign("count7", $count7);
        $this->assign("count8", $count8);
        /**
         * 物流公司 2016-1-3   Jaw
         */
        $express = M("express")->order("id asc")->select();
        $this->assign("express_list", $express);
        $this->display();
    }


    //发货
    //选择快递公司
    public function express(){
        $data["express_name"]    = I("post.express_name");//编码
       
        $data["express_no"]      = I("post.express_no");
        $data["is_send"]         = 1;
        $id                      = I('post.id');
        $m          = M('order_info');
        $res = $m->where(array("id"=>$id))->save($data);
        $Info=$m->where(array("id"=>$id))->find();
		$data["express_name"]    = M("express")->where(array('express_ma'=>$data['express_name']))->getField("express_company");//快递公司名称
        if($res){
            //发货成功添加发货时间 修改订单状态
            $res1 = $m->where(array("id"=>$id))->setField(array("order_status"=>3,"shipping_time"=>time()));
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

    //同意退款
    public function alreturn(){
        $id     = $_GET['id'];
        $m      = M('order_info');
        $time   = time();//退款时间
        //支付状态pay_status 已退款2
        //同意退款关闭订单5
        //要收回货之后才能退钱 客服确定收货退款此时的订单应该是被关闭
        $Info=$m->where(array("id"=>$id))->find();
        $res = $m->where(array("id"=>$id))->setField(array("order_status"=>5,"refund_time"=>$time,"pay_status"=>2,'is_refund'=>1,'refund_fee'=>$Info['pay_price']));
        if($res){
            $data=array(
                'order_id'=>$Info['id']
            );
            $this->sendSystemMessage($Info['user_id'],"您的退款进度消息","您的订单退款已完成，请注意查收！",$data);
            $this->success("退款成功");exit;
        }else{
            $this->success("退款失败");exit;
        }
    }
    //取消退款
    public function dereturn(){
        $id     = $_GET['id'];
        $m      = M('order_info');
        $res = $m->where(array("id"=>$id))->find();
        //未发货的状态
        if($res['is_send'] == 0){
            //改成待发货的状态
            $result  = $m->where(array("id"=>$id))->setField(array("order_status"=>2,"is_refund"=>2));
            if($result){
                $data=array(
                    'order_id'=>$res['id']
                );
                $this->sendSystemMessage($res['user_id'],"您的退款进度消息","您的订单退款被拒绝，请注意查收！",$data);
                $this->success("取消成功");
            }else{
                $this->error("取消失败");
            }
        }
        //已发货
        if($res['is_send'] == 1){
            //改成待收货的状态
            $result  = $m->where(array("id"=>$id))->setField(array("order_status"=>3,"is_refund"=>2));
            if($result){
                $data=array(
                    'order_id'=>$res['id']
                );
                $this->sendSystemMessage($res['user_id'],"您的退款进度消息","您的订单退款被拒绝，请注意查收！",$data);
                $this->success("取消成功");
            }else{
                $this->error("取消失败");
            }
        }

    }

    //查看详情
    public function orderDetail(){
        $id    = I("get.id");  // 得到order_infolist的id
        $order = M("order_info")->find($id);
        if(!$order){
            goback("没有此订单！");
        }
        $user        = M('member')->find($order['user_id']);
        $order['user'] = $user;
        $db_prefix   = C("DB_PREFIX");
        $order_goods = M("order_goods")->where(array('order_id'=>$order['id']))->select();
        /**
         * 加入评价
         */
        $c_m = M("goods_comment");
        foreach($order_goods as $k=>$v){
            if($v['status']){
                $order_goods[$k]['comment'] = $c_m->where(array('goods_id'=>$v['goods_id'],"order_id"=>$v['order_id']))->find();
            }
        }
        $order['goods'] = $order_goods;
        /*
            这里需要加入物流查询
        */
        //物流信息
        $res = $this->getOrderTracesByJson($order['express_name'],$order['express_no']);
        $express = json_decode($res,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $order['express_name'] =  M("express")->where(array("express_ma"=>$order['express_name']))->getField("express_company");
        //todo 加入优惠卷
        $this->assign("cache", $order);
        $this->assign("express", $exp);
        $this->display();
    }

    public function zlDetail(){
        $id    = I("get.id");  // 得到order_infolist的id
        $order = M("order_info")->find($id);

//        if(!$order){
//            goback("没有此订单！");
//        }
        $user        = M('member')->find($order['user_id']);
        $order['user'] = $user;
        $db_prefix   = C("DB_PREFIX");
        $order_goods = M("order_goods")->where(array('order_id'=>$order['id']))->select();
        /**
         * 加入评价
         */
        $c_m = M("goods_comment");
        foreach($order_goods as $k=>$v){
            if($v['status']){
                $order_goods[$k]['comment'] = $c_m->where(array('goods_id'=>$v['goods_id'],"order_id"=>$v['order_id']))->find();
            }
            $order_goods[$k]['zujin'] = M('goods')->where(array('id'=>$v['goods_id']))->getField('zujin');
        }
        $order['goods'] = $order_goods;
        /*
            这里需要加入物流查询
        */
        //物流信息
        $res = $this->getOrderTracesByJson($order['express_name'],$order['express_no']);
        $express = json_decode($res,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $order['express_name'] =  M("express")->where(array("express_ma"=>$order['express_name']))->getField("express_company");
        //todo 加入优惠卷
        /*
           这里需要加入归还物流查询
       */
        //物流信息
        $zures = $this->getOrderTracesByJson($order['zuexpress_name'],$order['zuexpress_no']);
        $zuexpress = json_decode($zures,true);
        if($zuexpress['Success']){
            $zuexp = $zuexpress['Traces'];
        }
        //快递编码转换成快递公司名称
        $order['zuexpress_name'] =  M("express")->where(array("express_ma"=>$order['zuexpress_name']))->getField("express_company");

        $this->assign("cache", $order);
        $this->assign("express", $exp);
        $this->assign("zuexpress", $zuexp);
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


    //全选删除
    public function alldel(){
        if(IS_AJAX){
            $str = $_POST["checks"];
            $arr = json_decode($str,true);
            $res = M("order_info")->where(array("id"=>array("in",$arr)))->delete();
            if($res!==false){
                $this->ajaxReturn(array("status"=>1 ,"info"=>"删除成功！"));die;
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"删除失败！"));die;
            }
        }else{
            //单个删除
            $id = $_GET['id'];
            $res = M("order_info")->where(array("id"=>$id))->delete();
            if($res!==false){
                $this->success("删除成功");die;
            }else{
                $this->error("删除失败");die;
            }
        }
        // $str = ltrim($str,"[");
        // $str = rtrim($str,"]");
        //$sql = "DELETE from app_order_info where id in($str)";
        //$res = M("order_info")->query($sql);
        //$res = M("order_info")-> getLastSql($sql);
    }


    // 下单错误报告
    public function errorReport(){
        $m = M("order_error_log");
        $type = I("type");
        $title = trim(I("title"));
        if($type ==="" || $type === null){
            unset($map['e.status']);
        }else{

            $map['e.status'] = $type;
        }
        if($title){
            $map['m.person_name'] = array("like","%{$title}%");
            $map['m.telephone'] = array("like","%{$title}%");
            $map['o.order_no'] = array("like","%{$title}%");
            $map["_logic"] = "or";
        }
        if(!empty($map)){
            $m->where($map);
        }
        //print_r($map);
        $DB_PREFIX = C("DB_PREFIX");
        $count = $m->alias('e')->join('app_member as m on e.user_id=m.id')->join('app_order_info as o on e.order_id=o.id')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();
        $a = $Page-> firstRow;
        $b = $Page-> listRows;
        $join_str1 = "left join {$DB_PREFIX}member as m on e.user_id=m.id";
        $join_str2 = "left join {$DB_PREFIX}goods as g on e.goods_id=g.id";
        $join_str3 = "left join {$DB_PREFIX}order_info as o on e.order_id=o.id";
        $res = $m->alias("e")->
            join($join_str1)->
            join($join_str2)->
            join($join_str3)->
            where($map)->
            limit($a,$b)->
            order("create_at")->
            field("m.person_name,m.telephone,g.goods_name,g.logo_pic,e.*,o.order_no,o.trade_no")->
            order("create_at desc")->
            select();
        $admins = M("user")->select();
        foreach($admins as $v){
            $admin[$v['id']] = $v['username'];
        }
        foreach($res as $k=>$v){
            $res[$k]['admin'] = $admin[$v['admin_id']];
        }
        $this->assign("title",  $title);
        $this->assign("page",  $show);
        $this->assign("count",  $m->count());
        $this->assign("count1", $m->where(array('status'=>0))->count());
        $this->assign("count2", $m->where(array('status'=>1))->count());
        //print_r($res);
        $this->assign("cache",  $res)->display();
    }

    // 处理错误报告
    public function dealErrorReport(){
        if(IS_AJAX){
            $id = I("post.id");
            $data['admin_id'] = $_SESSION['admin_id'];
            $data['deal_at']  = time();
            $data['status']   = 1;
            $res = M("order_error_log")->where(array('id'=>$id))->save($data);
            if($res){
                $this->ajaxReturn(array('status'=>1, "info"=>"处理成功！"));
            }else{
                $this->ajaxReturn(array('status'=>0, "info"=>"处理失败！"));
            }
        }
    }

    /**
     * 订单错误报告日志详情
     *     显示商品详情：订单详情
     */
    public function errorReportDetail(){
        $id = I("id");
        $m = M("order_error_log");
        $error_info = $m->find($id);
        if(!$error_info){
            echo "<script>alert('没有这个错误报告！');window.history.back();</script>";die;
        }
        $user_info   = M("member")->find($error_info['user_id']);
        $order_info  = M("order_info")->find($error_info['order_id']);
        if($error_info['goods_id']){
            $order_goods = M("order_goods")->where(array('order_id'=>$error_info['order_id'],'goods_id'=>$error_info['goods_id']))->find();
        }
        if($error_info['sku_id']){
            $sku_info    = M("sku_list")->where(array('id'=>$error_info['sku_id']))->find();
        }
        $admin = $this->getAdmin();
        $error_info['admin'] = $admin[$error_info['admin_id']];

        $this->assign("user_info",   $user_info);
        $this->assign("order_info",  $order_info);
        $this->assign("order_goods", $order_goods);
        $this->assign("sku_info",    $sku_info);
        $this->assign("error_info",  $error_info);
        $this->display();
    }

    public function getAdmin(){
        $admins = M("user")->select();
        foreach($admins as $v){
            $admin[$v['id']] = $v['username'];
        }
        return $admin;
    }



    //运费管理
    public function setexpress(){
        // $region_id  = I("post.region_id");
        // $this->assign('resInfo', $region_id);

        $m = M('freight_config');
        $count  = $m->where(array('user_id'=>0))->count();
        $Page  = getpage($count,15);
        $show  = $Page->show();
        $a = $Page-> firstRow;
        $b = $Page-> listRows;

        $express = $m->where(array('user_id'=>0))->order('sort asc')->limit($a, $b)->select();
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

        $this->assign("page", $show);
        $this->assign("express", $express);
        $this->assign("urlname", 'express');
        $this->assign("count", $count);
        $this->display();

    }

    //添加运费规则
    public function addExpress(){
        $first_price  = I("post.first_price");
        $next_price  = I("post.next_price");

        $map['first_price'] = $first_price;
        $map['next_price']  = $next_price;
        $map['user_id']  = 0;

        $reg = M('freight_config')->where($map)->find();
        if($reg){
            $data['info']   =   '运费规则已存在';
            $data['status'] =   0;
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
        $this->ajaxReturn($data);die;
    }

    //修改运费规则
    public function modifyExpress(){
        $feeid        = I("post.feeid");
        $first_price  = I("post.first_price");
        $next_price  = I("post.next_price");

        $map['first_price'] = $first_price;
        $map['next_price']  = $next_price;
        $map['user_id']  = 0;

        $reg = M('freight_config')->where($map)->find();
        if($reg){
            $data['info']   =   '运费规则已存在';
            $data['status'] =   0;
        }else{
            $map['sort'] = 0;
            $map['create_at'] = time();
            $map['id'] = $feeid;
            $res = M('freight_config')->save($map);
            if($res===false){
                $data['info']   =   '运费规则修改失败';
                $data['status'] =   0;
            }else{
                $data['info']   =   '运费规则修改成功';
                $data['status'] =   1;
            }
        }
        $this->ajaxReturn($data);
        return;
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

        $hasRegion = M('frei_link_region')->where(array('user_id'=>0))->field('region_id')->select();
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
            //$map['region_id'] = array('in',$region_id);
            $reg1 = M('frei_link_region')->where($map)->delete();
            $region_id = explode(",", $region_id);
            foreach ($region_id as $k => $v) {
                $reee['freight_id'] = $feeid;
                $reee['region_id'] = $v;
                $reee['status'] = 1;
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
    public function refund(){
        $type = I('get.order_status');
        if($type){
            if($type == 2){
                $where['refund_type'] = array('in',array('2','6'));
            }else{
                $where['refund_type'] = $type;
            }
        }else{
            $where['refund_type'] = array('neq',0);
        }
        $count  = M('order_goods')->where($where)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();
        $a = $Page-> firstRow;
        $b = $Page-> listRows;
        $refund = M('order_goods')
                ->alias('a')
                ->join('__MEMBER__ b ON a.user_id = b.id')
                ->field('a.id,a.goods_name,a.goods_price,a.return_num,a.refund_type,a.refund_time,a.order_no,a.express_num,a.express_name,b.person_name,b.telephone')
                ->where($where)
                ->limit($a,$b)
                ->select();
        //所有
        $count  = M('order_goods')->where(array('refund_type!=0'))->count();
        //待受理
        $count1  = M('order_goods')->where(array('refund_type=1'))->count();
        //已受理
        $count2  = M('order_goods')->where(array('refund_type=2 or refund_type=6'))->count();
        //已拒绝
        $count3  = M('order_goods')->where(array('refund_type=3'))->count();
        //已成功
        $count4  = M('order_goods')->where(array('refund_type=4'))->count();
        $this->assign('count',$count);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('count3',$count3);
        $this->assign('count4',$count4);
        $this->assign('page',$show);
        $this->assign('refund',$refund);
        $this->display();
    }
    //受理
    public function refundOk(){
        $data['id'] = I('post.id');
        $data['refund_type'] = 2;
        $res = M('order_goods')->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1, 'info'=>'受理成功'));
        }else{
            $this->ajaxReturn(array('status'=>0, 'info'=>'受理失败'));
        }
    }

    public function refundNo(){
        $data['id'] = I('post.id');
        $data['refund_type'] = 3;
        $res = M('order_goods')->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1, 'info'=>'拒绝成功'));
        }else{
            $this->ajaxReturn(array('status'=>0, 'info'=>'拒绝失败'));
        }
    }

    public function orderOk(){
        $data['id'] = I('post.id');
        $data['refund_type'] = 4;
        $data['return_price'] = I('post.return_price');
        $res = M('order_goods')->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1, 'info'=>'确认成功'));
        }else{
            $this->ajaxReturn(array('status'=>0, 'info'=>'确认失败'));
        }
    }
    /**
     * 退货详情
     */
    public function refundDetail(){
        $id = I('get.id');
        $refund = M('OrderGoods')->find($id);
        $user = M('Member')->find($refund['user_id']);
        $order = M('order_info')->find($refund['order_id']);


         //物流信息
        $res = $this->getOrderTracesByJson($refund['express_name'],$refund['express_num']);

        $express = json_decode($res,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $refund['express_name'] =  M("express")->where(array("express_ma"=>$refund['express_name']))->getField("express_company");
        //todo 加入优惠卷
        $this->assign('express',$exp);
        $this->assign('user',$user);
        $this->assign('order',$order);
        $this->assign('refund',$refund);
        $this->display();
    }
    /**
     *zqj 20171109 定时配置
     */
    public function dsceshi(){
        $rows = M('shop_config')->where(array('id'=>1))->find();
        //print_r($rows);
        $this->assign('cache',$rows);
        $this->display();

    }
    public function editdsceshi(){
        if(IS_POST){
            $data = I('post.');
            $data1['out_time'] = $data['out_time'];
            $data1['out_date'] = $data['out_date'];
            $data1['complete_date'] = $data['complete_date'];
            $data1['update_time'] = time();
            if($data['shid']){
                $id = $data['shid'];
                unset($data['shid']);
                $res = M('shop_config')->where(array('id'=>$id))->save($data1);
                
            }else{

                 $res = M('shop_config')->add($data1);
            }
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'操作成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败！'));
            }
        }
        $this->display();
    }

    /*public function rule(){
        if (IS_POST) {
            $edit_notice = M("yun_rule");
            //print_r($_POST);exit;
            $count = $edit_notice->count();

            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Yunrecomm/rule', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Yunrecomm/rule', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Yunrecomm/rule', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Yunrecomm/rule', '', false));exit;
                }
            }
        }

        $id= M('yun_rule')->getField('id');

        $res = M("yun_rule")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }*/

}
?>