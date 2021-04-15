<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class ContabController extends Controller {

    public function index(){
        $this->dsceshi();
        $this->qx_order1();
        $this->auto_confirm1();
        $this->auto_complete();
//        $this->remind();
    }

    public function dsceshi(){
        $time=date('Y-m-d H:i:s',time());
        $name='contab2.log';
        $txt='执行了定时任务！';
        $filename=iconv('utf-8', 'gbk','定时任务日志文件');
        if(!file_exists($filename)){
            @mkdir($filename,0777);
        }
        file_put_contents($filename.'/'.$name,$time.':'.$txt.PHP_EOL,FILE_APPEND);
    }


    public function delivery_message(){
        $o_m  =M('order_info');
        $infos=$o_m
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->join('left join app_user as c on a.admin_user=c.id')
            ->field('a.id,a.order_no,a.order_status,a.pay_time,a.jh_message,b.telephone,b.id as user_id,c.tel')
            ->where(array('order_status'=>2))
            ->select();
        $o_g_m=M('order_goods');
        $hour=date("G");
        $date=strtotime(date('Y-m-d',time()));
        foreach($infos as $key=>$val){
            $res=$o_g_m->field('min(delivery_day)')->where(array('order_no'=>$val['order_no']))->find();
            $info=timediff($val['pay_time'],NOW_TIME);
            $days=($res['delivery_day']>$info['day'])?intval($res['delivery_day']-$info['day']):0;
            if($days<=3 && $hour>=11 && $val['jh_message']!=$date){
                $res3= sendmessage(13,$val['tel'],'',$val['order_no']);
                $res4=$o_m->where(array('id'=>$val['id']))->setField('jh_message',$date);
                if(!$res3){
                    addToOrderErrorLog($val['user_id'],$val['order_no'],'用户交货期限将至发送短信通知客服失败！');
                }
            }
        }
    }

    /*
     * 到期提醒
     */

    public function remind()
    {
        $now = strtotime(date("Y-m-d H:i:s"));
        $where['order_status'] = 2;
        $time = M('order_info')->alias('a')->join("app_order_note as u on a.id=u.order_id")->field('a.*,u.days,u.n_time,u.admin_id')->where($where)->select();

//        $count = count($time);
        $arr=array();
        foreach ($time as $k=>$v){
            $user = M('user')->where(array('id'=>$v['admin_id']))->find();

            $start_time = $v['n_time'];
            $days = $v['days'];
            $e = ($now - $start_time);//当前时间-取出来的时间
            $day = floor($e/(3600*24))-$days;
            $orderid = $v['order_no'];
            $phone = $user['tel'];
            $type = 8;
            $day = 1;

//            $res = sendmessage($type,$phone,'',$orderid,'','','','',$day);
            $id = $v['id'];
            M('order_note')->where(array('id' => $id))->save(array('days' => $day));
            if ($day == 1) {
                $res = sendmessage($type,$phone,'',$orderid,'','','','',$day);
            }
        }

        $this->ajaxReturn($res);
    }
//msw zqj 所有未付款订单超过$ten就自动取消
    public function qx_msworder(){
        $this->crowd();
        $this->display1();
        $this->qx_pmorder();
        $this->order_pm();
        $this->pm_status();
        $this->pmremind();
        $time = time();
        $rows=M('shop_config')->where(array('id'=>1))->find();
        $ten = $rows['out_time'] * 3600;
        //$ten = 60*60*1;
        $ten_time = $time-(int)$ten;

        $order['order_status'] = 1;
        $order['pay_status'] = 0;
        $order['is_handle'] = 0;
        $order['is_handshop'] = 0;
        $order['order_time']=array('lt',$ten_time);
        $orders = M('order_info')->where($order)->select();

        if(empty($orders)){
            return;
        }
        foreach($orders as $key=>$v){
            file_put_contents('order_error.log',$v);
            $res1=M('order_info')->where(array('order_no'=>$v['order_no']))->save(array('order_status'=>0));

            if(!$res1){
                $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单失败！');
            }
            //增加库存
            $order_goods = M('order_goods')->where(array('order_id'=>$v['id']))->select();
            if(empty($order_goods)){
                return;
            }
            foreach($order_goods as $k=>$val){
                $cstore = M("goods")->where(array('id'=>$val['goods_id']))->getField('cstore');
                if($cstore == 0){//艺术品
                    $res1 = M("goods")->where(array('id'=>$val['goods_id']))->setField('store',1);
                }else{
                    $res1 = M("goods")->where(array('id'=>$val['goods_id']))->setInc('store',$val['goods_nums']);
                }
                if(!$res1){
                    $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单失败！');
                }
            }
            if($v['couponsid']){
                $coupons=array_filter(explode(',',$v['couponsid']));
                if(empty($coupons)){
                    break;
                }
                $data['status']=1;
                $res2=M('link_coupon')->where(array('id'=>array('in',$coupons)))->save($data);
                if(!$res2){
                    $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单返还用户优惠券失败！');
                }
            }
        }

    }
//所有未付款订单超过半小时就自动取消订单
    public function qx_order1(){
        $time = time();
        $rows=M('shop_config')->where(array('id'=>1))->find();
        $ten=$rows['out_time'];
        $ten = 3600 * $ten;
        $ten_time = $time-(int)$ten;
        $map['order_status']=1;
        $map['pay_status']=0;
        $map['order_time']=array('lt',$ten_time);
        $result=M('order_info')->field('id,order_no,couponsid,user_id')->where($map)->select();
        if(empty($result)){
          return;
        }

        foreach($result as $k=>$v){
            $res1=M('order_info')->where(array('order_no'=>$v['order_no']))->save(array('order_status'=>0));
            if(!$res1){
                $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单失败！');
            }
            //增加库存
            $order_goods = M('order_goods')->where(array('order_id'=>$v['id']))->select();
            if(empty($order_goods)){
                return;
            }
            foreach($order_goods as $k=>$val){
                $cstore = M("goods")->where(array('id'=>$val['goods_id']))->getField('cstore');
                if($cstore == 0){//艺术品
                    $res1 = M("goods")->where(array('id'=>$val['goods_id']))->setField('store',1);
                }else{
                    $res1 = M("goods")->where(array('id'=>$val['goods_id']))->setInc('store',$val['goods_nums']);
                }
                if(!$res1){
                    $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单失败！');
                }
            }
            if($v['couponsid']){
                $coupons=array_filter(explode(',',$v['couponsid']));
                if(empty($coupons)){
                    break;
                }
                $data['uid']=$v['user_id'];
                $data['use_status']=0;
                $data['use_time']=0;
                $data['use_money']=0;
                $data['order_id']="";
                $res2=M('coupon_list')->where(array('id'=>array('in',$coupons)))->save($data);
                if(!$res2){
                    $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单返还用户优惠券失败！');
                }
            }
        }
    }

//所有已发货订单超过14天未申请售后就默认已收货
    public function auto_confirm1(){
        $time = time();
        $row=M('shop_config')->where(array('id'=>1))->find();
        $date=$row['out_date'];
        $ten = $date*24*3600;
        $ten_time = $time-(int)$ten;
        //$ten_time=$time-60;
        $result=M('order_info')->field('id,order_no')->where(array('order_status'=>3,'pay_status'=>1,'shipping_time'=>array('lt',$ten_time)))->select();
        $news=array();
        foreach($result as $k=>$v){
            $news[]=$v['id'];
        }
        if (!empty($news)){
            $res1=M('order_info')->where(array('order_status'=>3,'pay_status'=>1,'id'=>array('in',$news)))->save(array('order_status'=>4,'receive_time'=>time()));
        }

    }

//所有待评价订单超过配置时间未申请售后就默认已完成  order_status 变为5  complete_time更新为当前时间
    public function auto_complete(){
        $time = time();
        $row=M('shop_config')->where(array('id'=>1))->find();
        $date=$row['complete_date'];
        $ten = $date*24*3600;
        $ten_time = $time-(int)$ten;
        //$ten_time=$time-60;
        $result=M('order_info')->field('id,order_no')->where(array('order_status'=>4,'pay_status'=>1,'receive_time'=>array('lt',$ten_time)))->select();
        $news2=array();
        foreach($result as $k=>$v){
            $news2[]=$v['id'];
        }
        if (!empty($news2)) {
            $res1=M('order_info')->where(array('order_status'=>4,'pay_status'=>1,'id'=>array('in',$news2)))->save(array('order_status'=>5,'complete_time'=>time()));
        }
    }

    public function addToOrderErrorLog($userid=null,$orderid=null,$msg=null,$goodsid=null,$nums=null,$skuid=null,$skuinfo=null){
        $data = array(
            "user_id"   => $userid,
            "order_id"  => $orderid,
            "msg"		=> $msg,
            "goods_id"	=> $goodsid,
            "nums"		=> $nums,
            "sku_id"	=> $skuid,
            "sku_info"	=> $skuinfo,
            "create_at" => time(),
            "status"	=> 0,
        );
        M("order_error_log")->add($data);
    }

    public function contab_log($info){
        $contab=M('contab_log');
        $data['log_info']=$info;
        $data['log_time']=time();
        $res=$contab->add($data);
        if(!$res){
            $this->error('日志记录失败！');exit;
        }
    }


    //租赁快到期提醒

    public function zlremind()
    {
        $this->gzremind();
        $now = strtotime(date("Y-m-d"));
        $where['a.pay_status'] = 1;
        $where['a.is_recommend'] = 1;
        $info = M('order_info')->alias('a')->join("app_order_goods as g on a.id=g.order_id")->field('a.*,g.goods_name')->where($where)->select();
        foreach ($info as $v){
            $old = strtotime(date("Y-m-d",$v['pay_time']));

            $t = $now-$old;
            if($t==(3*24*60*60)){
                $member = M('member')->where(array('id'=>$v['user_id']));
             $phone = $member['telephone'];
             $type = 5;
             C('goods_name',$v['goods_name']);
             C('start_time','3天');
             sendmessage($type,$phone);
            }

            if($t==(24*60*60)){
                $member = M('member')->where(array('id'=>$v['user_id']));
                $phone = $member['telephone'];
                $type = 5;
                C('goods_name',$v['goods_name']);
                C('start_time','1天');
                sendmessage($type,$phone);
            }
        }

        return;
    }

    //观展提醒

    public function gzremind()
    {
        $now = strtotime(date("Y-m-d"));
        $where['a.is_remd'] = 0;
        $info = M('tel_gtrain')->alias('a')->join("app_art_show as s on a.show_id=s.id")->field('a.*,s.title,s.start')->where($where)->select();
        foreach ($info as $v){
            $old = strtotime(date("Y-m-d",$v['start']));
            $t = $now-$old;
            if($t<=(24*60*60)){
                $phone = $info['tel'];
                $type = 6;
                C('goods_name',$v['title']);
                C('start_time',date('Y-m-d H:i:s',$info['start']));
                M('tel_gtrain')->where(array('id'))->save(array('is_remd'=>1));
                sendmessage($type,$phone);
            }
        }

        return;
    }

    //定时取消拍卖订单

    public function qx_pmorder()
    {
        $map['end'] = array('lt',time());
        $map['order_status']=1;
        $map['pay_status']=0;
        $result=M('order_pm')->field('id,order_no,user_id')->where($map)->select();
        if(empty($result)){
            return;
        }

        foreach($result as $k=>$v){
            $res1=M('order_pm')->where(array('order_no'=>$v['order_no']))->save(array('order_status'=>0));
            if(!$res1){
                $this->addToOrderErrorLog($v['user_id'],$v['id'],'自动取消订单失败！');
            }
        }
        return;
    }

    /**
     * 定时任务生成订单
     * crontab  -e
     *  * * * * * *  curl = "http://msw.unohacha.com/Home/Pm/order_pm";
     */
    public function order_pm(){
        $map['end'] = array('lt',time());
        $map['paimai_zt'] = array('neq',3);
        $map['is_shang'] = 1;
        $pm = M('pm');
        $res = $pm->where($map)->select();
        //var_dump($res);
        if ($res){
            foreach ($res as $k=>$v){
                $goods_id = $v['id'];
                $chujia = M('chujia')->where(array('goods_id'=>$goods_id))->order('jiage desc')->find();
                if ($chujia){
                    if ($chujia['jiage']>=$v['baoliu']){
                        M()->startTrans();
                        $goods_data['mai_id'] = $chujia['user_id'];
                        $goods_data['paimai_zt'] = 3;
                        $goods_data['dangqian'] = $chujia['jiage'];
                        $goods_data['cy_user'] = M('order_pmding')->where(array('goods_id'=>$goods_id,'order_status'=>array('gt',0)))->count();
                        $pm_mai = $pm->where(array('id'=>$goods_id))->save($goods_data);

                        //订单信息
                        $data['goods_id'] = $goods_id;
                        $data['user_id'] = $chujia['user_id'];
                        //价格

                        $data['goods_price'] = $chujia['jiage'];
                        $ding = M('order_pmding')->where(array('goods_id'=>$goods_id,'user_id'=>$chujia['user_id']))->find();
                        //地址 省份

                        //读取用户默认地址计算运费   zj

                        $province = explode('-',$ding['dizhi']);
                            //读取用户默认地址计算运费   zj
                        $province_ID = D('region')->get_id_by_name($province[0], 1);


                        if($v['promulgator']==0){
                            $user_id = 0;
                        }else{
                            $info  = M('ruzhu')
                                ->where(array('id'=>$v['promulgator']))->find();
                            $user_id = $info['user_id'];
                        }
                        //计算总的运费
                        $express_fee = D("freight_config")->get_freight($v['weight'], $province_ID,$user_id);

                        $data['province'] = $province[0];
                        $data['city'] = $province[1];
                        $data['district'] = $province[2];
                        $data['address'] = $ding['address'];

                        $data['consignee'] = $ding['name'];
                        $data['mobile'] = $ding['telephone'];

                        $res = M('ms_ruzhu')->where('id=1')->find();
                        $data['end'] = time()+$res['zfsx']*60*60;

                        //运费
                        //$express_fee=$express_fee;
                        $data['express_fee'] = $express_fee;


                        //订单金额
                        $data['total_fee'] = $data['goods_price']+$data['express_fee'];

                        if($data['total_fee']<$v['baoding']){
                            $retrievable_price = sprintf('%.2f',$v['baoding']-$data['total_fee']);
                            $data['total_price'] = 0;
                            $if = true;
                            //抵扣金额
                            $data['deductible_price'] = $data['total_fee'];
                        }else{
                            $retrievable_price = 0;
                            $data['total_price'] = $data['total_fee']-$v['baoding'];
                            //抵扣金额
                            $if = false;
                            $data['deductible_price'] = $v['baoding'];
                        }


                        if($goods_data['cy_user']>1){
                            $pm_ding_other = M("order_pmding")->where(array("id"=>array('neq',$ding['id'],'goods_id'=>$goods_id)))->save(array("status"=>1,'retrievable_price'=>$ding['baoding']));
                        }
                        $pm_ding = M("order_pmding")->where(array("id"=>$ding['id']))->save(array("status"=>2,'retrievable_price'=>$retrievable_price,'deductible_price'=>$data['deductible_price']));

                        //订单编号
                        $data['order_no'] = 'PM'.date('YmdHis',time()).rand(1000,9999);

                        //$data['goods_name'] = $res[$k]['goods_name'];
                        //$data['goods_spic'] = $res[$k]['logo_pic'];
                        $data['order_time'] = time();
                        //$data['goods_cap'] = $res[$k]['goods_cap'];
                        $data['baoding'] = $res[$k]['baoding'];
                        $data['dizhi'] = $ding['dizhi'];
                        $order_pm = M('order_pm')->add($data);
                        //var_dump($order_pm);
                        //拍得竞品则短信提示付款加链接
                        $data_sms['pm_id'] = $v['id'];
                        $data_sms['create_at'] = time();
                        $data_sms['code_type'] = 8;
                        $data_sms['is_send'] = 0;
                        $data_sms['user_id'] = $chujia['user_id'];
                        M('sms_log')->add($data_sms);
                       // echo 1;
                        //拍得竞品则短信提示付款加链接
                        if($goods_data['cy_user']>1){
                            if ($pm_mai==true && $order_pm==true && $pm_ding && $pm_ding_other){
                                M()->commit();
                                if($if){
                                    $order = M("order_pm")->where(array('id' => $order_pm))->find();
                                    $total_amount = 0;
                                    $b_data['pay_way'] = 4;
                                    $b_data['order_status'] = 2;
                                    $b_data['pay_status'] = 1;
                                    $b_data['pay_price'] =  0;
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
                            }else{
                                M()->rollback();
                            }
                        }else{
                            if ($pm_mai==true && $order_pm==true && $pm_ding){
                                M()->commit();
                                if($if){
                                    $order = M("order_pm")->where(array('id' => $order_pm))->find();
                                    $total_amount = 0;
                                    $b_data['pay_way'] = 4;
                                    $b_data['order_status'] = 2;
                                    $b_data['pay_status'] = 1;
                                    $b_data['pay_price'] =  0;
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
                            }else{
                                M()->rollback();
                            }
                        }
                    }else{
                        //流拍
                        $data_lp['paimai_zt']=2;
                        $data_lp['is_shang']=0;
                        $data_lp['cy_user'] = M('order_pmding')->where(array('goods_id'=>$goods_id,'order_status'=>array('gt',0)))->count();
                        M('pm')->where(array('id'=>$goods_id))->setField($data_lp);
                        //流拍更改保证金订单状态
                        $ding = M('order_pmding')->where(array('goods_id'=>$goods_id,'user_id'=>$chujia['user_id']))->find();
                        M("order_pmding")->where(array('goods_id'=>$goods_id))->save(array("status"=>1,'retrievable_price'=>$ding['baoding']));
                    }
                }else{
                    //无人竞价
                    $data_wr['paimai_zt']=2;
                    $data_wr['is_shang']=0;
                    $data_wr['cy_user'] = M('order_pmding')->where(array('goods_id'=>$goods_id,'order_status'=>array('gt',0)))->count();
                    M('pm')->where(array('id'=>$goods_id))->setField($data_wr);
                    //流拍更改保证金订单状态
                    $ding = M('order_pmding')->where(array('goods_id'=>$goods_id,'user_id'=>$chujia['user_id']))->find();
                    M("order_pmding")->where(array('goods_id'=>$goods_id))->save(array("status"=>1,'retrievable_price'=>$ding['baoding']));
                }
            }
        }
        $this->baoding();
    }

    /**
     * 定时刷新拍卖状态
     */

    public function pm_status(){
        $time = time();
        $map['is_shang'] = 1;
        $map['paimai_zt'] = array('lt',2);
        $pm = M('pm');
        $res = $pm->where($map)->select();
        foreach ($res as $k=>$v){
            if ($v['start']<$time){
                $pm->where(array('id'=>$v['id']))->save(array('paimai_zt'=>1));
            }
        }
    }

    //拍卖结束保定金状态修改保定金
    public function baoding(){
        $mapd['is_del'] = 0;
        $mapd['order_status'] = array('in','1,2');
        $mapd['is_jieshu'] = 0;
        $baoding = M('order_pmding')->where($mapd)->select();
        //dump($baoding);
        foreach ($baoding as $k=>$v){
            $res = M('pm')->where(array('end'=>array('lt',time()),'id'=>$v['goods_id']))->find();
            if ($res){
                M('order_pmding')->where(array('id'=>$v['id']))->save(array('is_jieshu'=>1));
            }
        }
    }

    /**
     * 定时提醒
     * crontab  -e
     *  * * * * * * curl = "http://msw.unohacha.com/Home/Pm/remind";
     */

    public function pmremind(){
        $res = M('pmtel_remind')->where(array('is_tx'=>0))->select();
        foreach ($res as $k=>$v){
            if ($v['is_lx']==0){
                //拍品提醒
                $pm = M('pm')->where(array('id'=>$v['goods_id']))->find();
                $now = time();
                if ($pm['start'] <($now+60*5)){

                    //达成提醒
                    M('pmtel_remind')->where(array('id'=>$v['id']))->save(array('is_tx'=>1));
                    C('goods_name',$pm['goods_name']);
                    C('start_time',date('Y-m-d H:i:s',$pm['start']));
                    if($v['tel'] && $pm['end']>$now){
                        sendmessage('4',$v['tel']);
                    }

                }
            }else{
                //拍场提醒
                $num = M('pm_num')->where(array('id'=>$v['num_id']))->find();
                $now = time();
                if ($num['start_time'] <($now+60*5)){
                    //达成提醒
                    M('pmtel_remind')->where(array('id'=>$v['id']))->save(array('is_tx'=>1));
                    C('pm_num',$num['num']);
                    C('start_time',date('Y-m-d H:i:s',$num['start_time']));
                    if($v['tel'] && $num['end_time']>$now) {
                        sendmessage('3', $v['tel']);
                    }
                }
            }
        }
    }


    //定时检查众筹
    public function crowd(){
        //M()->startTrans();
        $time = time();
        $time = $time+(24*3600);
        $map['end'] = array('elt',$time);
        $map['is_zc'] = 0;
        $map['is_sale1'] = 1;
        $map['is_del'] = 0;
        $data1 = M('crowd')->where($map)->select();
        $money = 0;
        foreach($data1 as $k=>$v){
            $num = M('order_crowd')->where(array('crowd_id'=>$v['id']))->sum('pay_price');
            $money += $num;
            $res2 = M('order_crowd')->where(array('crowd_id'=>$v['id']))->select();
            if($money<$v['total_price']){
                foreach($res2 as $key=>$val){
                    $user = M('member')
                        ->alias('a')
                        ->where(array('id'=>$val['user_id']))
                        ->setInc('wallet',$val['pay_price']);
                    /*if(!$user){
                        M()->rollback();
                    }*/
                }
                $res3 = M('order_crowd')->where(array('crowd_id'=>$v['id']))->setfield(array('is_zc'=>1));
                $res = M('crowd')->where(array('id'=>$v['id']))->setField(array('is_zc'=>1,'is_sale1'=>0));
            }else{
                $res3 = M('order_crowd')->where(array('crowd_id'=>$v['id']))->setfield(array('is_zc'=>2));
                $res = M('crowd')->where(array('id'=>$v['id']))->setField(array('is_zc'=>2,'is_sale1'=>0));
            }
        }
    }

    //判断展览状态
    public function display1(){
        $time = time();
        $where['now_status'] = array('elt',2);
        $res1 = M('art_show')->where($where)->select();
        foreach($res1 as $k=>$v){
            if($res1[$k]['end']<$time){
                $status = M('art_show')->where(array('id'=>$v['id']))->setField(array('now_status'=>2));
            }elseif($v['start']<$time && $time<$v['end']){
                $status = M('art_show')->where(array('id'=>$v['id']))->setField(array('now_status'=>1));
            }
        }
    }

    //拍卖结束前两小时要提示参拍者(短信加拍品详情链接)
    public function pm_end_sms()
    {
       
        //查询进行中的场次
        $num = M('pm_num')->where(array('is_xs'=>0,'is_del'=>0,'start_time'=>array('lt',time()),'end_time'=>array('gt',time())))->order('start_time')->select();

        foreach ($num as $key => $value) {

            // 拍卖结束提醒时间点
            $remind_time = strtotime('-2 hours',$value['end_time']);
            if($remind_time<=time()){

                //查询拍卖作品
                $pmList = M('pm')->where(array('num_id'=>$value['id']))->order('end')->select();
                foreach ($pmList as $val) {

                    //短信是否发送？
                    $is_sms = M('sms_log')->where(array('pm_id'=>$val['id']))->count();
                    if($is_sms==0){

                        //查询已交保证金的用户
                        $pmdingList = M('order_pmding')->where(array('goods_id'=>$val['id'],'order_status'=>array('gt',0)))->order('id asc')->select();
                        //是否有用户
                        $phone = "";
                        //var_dump($val['id']);
                        if(!empty($pmdingList)){

                            foreach ($pmdingList as $v) {
                                $memberList = M('member')->where(array('id'=>$v['user_id']))->order('id asc')->select();
                                foreach ($memberList as $k => $v1) {
                                    if($k==0){
                                        $phone = $v1['telephone'];
                                    }else{
                                        $phone = $phone . ',' . $v1['telephone'];
                                    }
                                }   
                            }

                            //发送短信提醒
                            $end_time = date('Y-m-d H:i:s',$val['end']);
                            $goods_name = $val['goods_name'];
                            $url = "http://www.zhejiangart.com.cn/Pm/pmxq/id/".$val['id'];
                            C('goods_name',$goods_name);
                            C('end_time',$end_time);
                            C('url',$url);
                            $res = sendmessage(7,$phone);

                            if($res['status']==1){
                                $data['pm_id'] = $val['id'];
                                $data['create_at'] = time();
                                $data['code_type'] = 7;
                                M('sms_log')->add($data);
                            }   
                        }
                    }else{ }
                }
            }
        }
    }

    // 竞拍成功短信通知
    public function pm_success_sms()
    {
       
        // 竞拍成功短信通知
        $smsList = M('sms_log')->where(array('code_type'=>8,'is_send'=>0))->select();
        //var_dump($smsList);
        foreach ($smsList as $key => $value) {
            if($value['user_id']){
                $phone = M('member')->where(array('id'=>$value['user_id']))->getField('telephone');
                $goods_name = M('pm')->where(array('id'=>$value['pm_id']))->getField('goods_name');
                $url = "http://www.zhejiangart.com.cn/Home/PersonalCenter/buyerXia/tag/buyerXia/value/2";
                C('goods_name',$goods_name);
                C('url',$url);
                $res = sendmessage(8,$phone);
                //var_dump($res);
                if($res['status']==1){
                    $data['is_send'] = 1;
                    M('sms_log')->where(array('id'=>$value['id']))->save($data);
                }  

            }

        }
    }


}