<?php
namespace Admin\Controller;

use Common\Controller\CommonController;

class FinanceController extends CommonController
{
    public $begin;
    public $end;

    public function _initialize()
    {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
        //zj 20170911
        $timegap = I('timegap');
        if ($timegap) {
            $gap = explode(' - ', $timegap);
            $begin = $gap[0];
            $end = $gap[1];
        } else {
            $lastweek = date('Y-m-d', strtotime("-1 month"));//默认显示30天前
            $begin = I('begin', $lastweek);
            $end = I('end', date('Y-m-d'));
        }
        $this->begin = strtotime($begin);
        $this->end = strtotime($end) + 86399;
        $this->assign('timegap', date('Y-m-d', $this->begin) . ' - ' . date('Y-m-d', $this->end));
    }

    /**
     * 财务配置
     * zj  20171102
     */
    public function FinanceConfig()
    {
        if(IS_POST){
            $data=I("post.");
            $data['update_time']=time();
            $res = M("finance_config")->where("id=1")->save($data);
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"保存成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"保存失败！"));
            }
        }
        $cache = M("finance_config")->where(array("id"=>1))->find();
        $this->assign("cache",$cache);
        $this->display();
    }
    /**
     * 推荐订单佣金审核
     * zj  20171030
     */
    public function AgentCommission()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $takemoney = M('takemoney');
            $is_take = $takemoney->where(array('id'=>$id))->find();
            if(!$is_take){
                $result["info"] = "没有这个提现数据";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
            $agent = M('artist');
            $a_res = $agent->where(array('id'=>$is_take['artist_id']))->find();
            if(!$a_res){
                $result["info"] = "该店铺不存在";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
            //订单状态变为is_handshop 1 已结佣金
            $where['id'] = array('in',array_filter(explode(',',$is_take['order_ids'])));
            M()->startTrans();
            $res = M("order_info")->where($where)->setField('is_handle',1);
            if(!$res){
                M()->rollback();
                $result["info"] = "操作失败";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
            //结束
            $data= array();
            $data['status'] = 2;
            $data['deal_at']=time();
            $data['admin_id'] = $_SESSION['admin_id'];
            $is_cus = $takemoney->where(array('id' => $id))->save($data);
            if(!$is_cus){
                M()->rollback();
                $result["info"] = "操作失败";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
           /* //佣金发放至会员余额
            $sta = M("member")->where(array('id'=>$a_res['user_id']))->setInc('wallet',$is_take['money']);
            if(!$sta){
                M()->rollback();
                $result["info"] = "操作失败";
                $result["status"] = 0;
            }*/
            M()->commit();
            $result["info"] = "操作成功";
            $result["status"] = 1;
            $this->ajaxReturn($result);
        }
        $takemoney = M('takemoney');
        $data = array();
        $name = trim(I('name'));
        if($name){
            $this->assign('name',$name);
            $data['b.artist_name'] = array('like','%'.$name.'%');
        }
        $tel = I('tel');
        if($tel){
            $this->assign('tel',$tel);
            $data['a.mobile'] = array('like','%'.$tel.'%');
        }
        $a_name = I('a_name');
        if($a_name){
            $this->assign('a_name',$a_name);
            $data['a.truename'] = array('like','%'.$a_name.'%');
        }
        $data['a.status'] = array('in','1,2');
        $data['class'] = 1;//推荐佣金审核
        $status = I("param.status");
        if($status){
            $data['a.status'] = $status;
        }
        $count = $takemoney
            ->alias('a')
            ->join('app_artist as b on a.artist_id = b.id')
            ->where($data)
            ->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $cus_list = $takemoney
            ->alias('a')
            ->field('a.*,b.artist_name')
            ->join('app_artist as b on a.artist_id = b.id')
            ->where($data)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $this->assign('cache',$cus_list);
        $this->assign('count',$count);
        $this->assign('count1',$takemoney->where(array('status'=>1,'class'=>1))->count());
        $this->assign('count2',$takemoney->where(array('status'=>2,'class'=>1))->count());
        $this->assign("page",$show);
        $this->display();
    }
    /**
     * 店铺自传作品金额审核
     * zj  20171030
     */
    public function ShopAutobiographical()
    {
        if(IS_AJAX){
            $id = I('post.id');
            $takemoney = M('takemoney');
            $is_take = $takemoney->where(array('id'=>$id))->find();
            if(!$is_take){
                $result["info"] = "没有这个提现数据";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
            $agent = M('artist');
            $a_res = $agent->where(array('id'=>$is_take['artist_id']))->find();
            if(!$a_res){
                $result["info"] = "该店铺不存在";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
            //订单状态变为is_handle 1 已结佣金
            $where['id'] = array('in',array_filter(explode(',',$is_take['order_ids'])));
            M()->startTrans();
            $res = M("order_info")->where($where)->setField('is_handshop',1);
            if(!$res){
                M()->rollback();
                $result["info"] = "操作失败";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
            //结束
            $data= array();
            $data['status'] = 2;
            $data['deal_at']=time();
            $data['admin_id'] = $_SESSION['admin_id'];
            $is_cus = $takemoney->where(array('id' => $id))->save($data);
            if(!$is_cus){
                M()->rollback();
                $result["info"] = "操作失败";
                $result["status"] = 0;
                $this->ajaxReturn($result);
            }
           /* //佣金发放至会员余额
            $sta = M("member")->where(array('id'=>$a_res['user_id']))->setInc('wallet',$is_take['money']);
            if(!$sta){
                M()->rollback();
                $result["info"] = "操作失败";
                $result["status"] = 0;
            }*/
            M()->commit();
            $result["info"] = "操作成功";
            $result["status"] = 1;
            $this->ajaxReturn($result);
        }
        $takemoney = M('takemoney');
        $data = array();
        $name = trim(I('name'));
        if($name){
            $this->assign('name',$name);
            $data['b.artist_name'] = array('like','%'.$name.'%');
        }
        $tel = I('tel');
        if($tel){
            $this->assign('tel',$tel);
            $data['a.mobile'] = array('like','%'.$tel.'%');
        }
        $a_name = I('a_name');
        if($a_name){
            $this->assign('a_name',$a_name);
            $data['a.truename'] = array('like','%'.$a_name.'%');
        }
        $data['a.status'] = array('in','1,2');
        $data['class'] = 2;//店铺自传作品审核
        $status = I("param.status");
        if($status){
            $data['a.status'] = $status;
        }
        $count = $takemoney
            ->alias('a')
            ->join('app_artist as b on a.artist_id = b.id')
            ->where($data)
            ->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $cus_list = $takemoney
            ->alias('a')
            ->field('a.*,b.artist_name')
            ->join('app_artist as b on a.artist_id = b.id')
            ->where($data)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $this->assign('cache',$cus_list);
        $this->assign('count',$count);
        $this->assign('count1',$takemoney->where(array('status'=>1,'class'=>2))->count());
        $this->assign('count2',$takemoney->where(array('status'=>2,'class'=>2))->count());
        $this->assign("page",$show);
        $this->display();
    }
    /**
     * 推荐店铺推荐订单明细
     * zj
     */
    public function AgentOrderList()
    {
        $takemoney_id = I("param.id");
        $type = I("param.type");
        $cus_ids = M("takemoney")->where(array('id'=>$takemoney_id))->getField('order_ids');
        $cus_ids = array_filter(explode(',',$cus_ids));
        if(!empty($cus_ids)){
            $map['a.id'] = array('in',$cus_ids);
            $count = M("order_info")->alias('a')
                ->join('app_member as b on a.user_id=b.id')->where($map)->count();
            $Page = getpage($count, 5);
            $show = $Page->show();//分页显示输出
            $data = M('order_info')->alias('a')
                ->join('app_member as b on a.user_id=b.id')
                ->field('a.*,b.realname,b.telephone')
                ->where($map)
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order('order_time desc')->select();
            foreach ($data as $k => $val) {
                $data[$k]['total_price'] = number_format($val['total_price'], 2);
                $data[$k]['biaode'] = M("order_goods")->where(array('order_id' => $val['order_id']))->select();
            }
        }
        $this->assign('empty', "<tr><td colspan='13' class='ftnormal' style='background-color:#F2F8FC;text-align:center;'><span>暂无数据</span></td></tr>");
        $this->assign('cache', $data);
        $this->assign('page', $show);
        $this->assign('type', $type);
        $this->display();
    }
    /**
     * 会员统计明细  zj  20170911
     */
    public function MemberRank()
    {
        $m = M("member");
        $start = date("Y-m-d H:i:s", $this->begin);
        $end = date("Y-m-d H:i:s", $this->end);
        $sql = "select COUNT(*) as num from __PREFIX__member where addtime>='{$start}' AND addtime<='{$end}'";
        $new = M()->query($sql);//新增会员趋势
        $day['Counts'] = $new[0]['num'];//总会员数
        //订单总数、下单率、会员购物总额
        $jie['order_time'] = array('between', array($this->begin, $this->end));
        $jie['order_status'] = array('gt', 1);
        $day['order'] = M("order_info")->where($jie)->count();//订单
        $day['order_money'] = M("order_info")->where($jie)->sum('total_fee');
        $day['order_lv'] = number_format($day['order'] / $day['Counts'] * 100, 2);
        $day['order_lv'] .= "%";
        //会员订单数排行  购物金额排行  购物最大量排行
        $member = $m->where(array('status' => 0))->order("addtime desc")->field('id,addtime,telephone,person_name')->select();
        foreach ($member as $k => $val) {
            $jie1['user_id'] = $val['id'];
            $jie1['order_time'] = array('between', array($this->begin, $this->end));
            $jie1['order_status'] = array('gt', 1);
            $count = M("order_info")->where($jie1)->count();//祭祀商品订单
            $money = M("order_info")->where($jie1)->sum('total_fee');
            if ($count) {
                $member[$k]['count'] = $count;
                $member[$k]['money'] = $money;
            } else {
                unset($member[$k]);
            }
        }
        $member = list_sort_by($member, 'count', 'desc');
        $rank = I("param.rank");
        if ($rank == 1) {
            $member = list_sort_by($member, 'money', 'desc');
        }
        $this->assign('rank',$rank);
        $this->assign('data', $member);
        $this->assign('day', $day);
        $this->display();
    }


    /**
     * 会员统计明细  zj  20170911
     */
    public function moneyOrderWater()
    {
        $money_order_db=M('money_order');
        $data['status']=1;
        $data['addtime']=array('between',array($this->begin,$this->end));
        $count1= $money_order_db->group('user_id')->where($data)->select();
        $count1=count($count1);
        $count = $money_order_db->where($data)->count();
        $data1['a.status']=1;
$data1['a.addtime']=array('between',array($this->begin,$this->end));
        $list  = $money_order_db
            ->alias('a')
            ->join('left join app_member as b on a.user_id =b.id')
            ->field('a.*,b.realname,telephone,person_name')
            ->where($data1)
            ->select();
        $this->assign('count', $count);
        $this->assign('count1',$count1);
        $this->assign('data',  $list);
        $this->display();
    }

    /**
     * 订单统计
     */
    public function OrderReport()
    {
        $where = array();
        $m = M("order_info");
        $where['a.order_status'] = array('gt', 1);
        $where['a.order_time'] = array('between', array($this->begin, $this->end));
        $count = $m->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->where($where)->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = $m->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow, $Page->listRows)->order('a.id desc')->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj
        $sql = "SELECT COUNT(*) as tnum,sum(pay_price) as amount, FROM_UNIXTIME(order_time,'%Y-%m-%d') as gap from  __PREFIX__order_info ";
        $sql .= " where order_time>$this->begin and order_time<$this->end AND  order_status>1 group by gap ";
        $res = M()->query($sql);//订单数,交易额
        $tnum = 0;
        $tamount = 0;
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['tnum'];
            $brr[$val['gap']] = $val['amount'];
            $tnum += $val['tnum'];
            $tamount += $val['amount'];
        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_num = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_amount = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_sign = empty($tmp_num) ? 0 : round($tmp_amount / $tmp_num, 2);
            $order_arr[] = $tmp_num;
            $amount_arr[] = $tmp_amount;
            $sign_arr[] = $tmp_sign;
            $date = date('Y-m-d', $i);
            $list[] = array('day' => $date, 'order_num' => $tmp_num, 'amount' => $tmp_amount, 'sign' => $tmp_sign, 'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }

        $this->assign('list', $list);
        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
        $this->assign('result', json_encode($result));
        $map['order_status'] = array('gt', 1);
        $map['order_time'] = array('between', array($this->begin, $this->end));
        $dayZnum = $m->where($map)->count();//订单总数
        $dayMoney = $m->where($map)->sum('total_fee');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);


        $this->display();
    }
    /**
     * 租赁订单 zj 20171103
     */
    public function LeaseOrder()
    {
        $where = array();
        $m = M("order_info");
        $where['a.order_status'] = array('gt', 1);
        $where['a.is_recommend'] = 0;
        $where['a.order_time'] = array('between', array($this->begin, $this->end));
        $count = $m->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->where($where)->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = $m->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow, $Page->listRows)->order('a.id desc')->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj
        $sql = "SELECT COUNT(*) as tnum,sum(pay_price) as amount, FROM_UNIXTIME(order_time,'%Y-%m-%d') as gap from  __PREFIX__order_info ";
        $sql .= " where order_time>$this->begin and order_time<$this->end AND is_recommend=0 AND order_status>1 group by gap ";
        $res = M()->query($sql);//订单数,交易额
        $tnum = 0;
        $tamount = 0;
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['tnum'];
            $brr[$val['gap']] = $val['amount'];
            $tnum += $val['tnum'];
            $tamount += $val['amount'];
        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_num = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_amount = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_sign = empty($tmp_num) ? 0 : round($tmp_amount / $tmp_num, 2);
            $order_arr[] = $tmp_num;
            $amount_arr[] = $tmp_amount;
            $sign_arr[] = $tmp_sign;
            $date = date('Y-m-d', $i);
            $list[] = array('day' => $date, 'order_num' => $tmp_num, 'amount' => $tmp_amount, 'sign' => $tmp_sign, 'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }

        $this->assign('list', $list);
        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
        $this->assign('result', json_encode($result));
        $map['order_status'] = array('gt', 1);
        $map['is_recommend'] = 0;
        $map['order_time'] = array('between', array($this->begin, $this->end));
        $dayZnum = $m->where($map)->count();//订单总数
        $dayMoney = $m->where($map)->sum('total_fee');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);
        $this->display();
    }

    /**
     * 云推荐订单统计
     * zj
     */
    public function CloudReport()
    {
        $where = array();
        $m = M("order_goods");
        $where['b.order_status'] = array('gt', 1);
        $where['a.is_reed'] = 1;//推荐订单
        $where['b.order_time'] = array('between', array($this->begin, $this->end));


        $count = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_yun_apply c on a.reed_id = c.id')
            ->where($where)
            ->group('a.reed_id')->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出

        $res = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_yun_apply c on a.reed_id = c.id')
            ->where($where)
            ->field('sum(a.goods_price) as totalfee,count(a.id) as totalnum,c.name as artist_name')->where($where)
            ->group('a.reed_id')
            ->limit($Page->firstRow, $Page->listRows)
            ->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj

        $dayZnum = $count = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_yun_apply c on a.reed_id = c.id')
            ->where($where)->count();//订单总数
        $dayMoney = $count = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_yun_apply c on a.reed_id = c.id')
            ->where($where)
            ->group('a.reed_id')->sum('a.goods_price');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);
        $this->display();
    }

    /**
     * 云推荐订单统计
     * zj
     */
    public function CloudReport1()
    {
        $where = array();
        $m = M("order_info");
        $where['a.order_status'] = array('gt', 1);
        $where['a.tj_status'] = 1;//推荐订单
        $where['a.order_time'] = array('between', array($this->begin, $this->end));
        $count = $m->alias("a")->join('LEFT JOIN app_yun_apply b on a.tj_shop = b.id')
            ->where($where)
            ->group('a.tj_shop')->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = $m->alias("a")->join('LEFT JOIN app_yun_apply b on a.tj_shop = b.id')
            ->field('sum(a.pay_price) as totalfee,count(a.id) as totalnum,b.name')->where($where)
            ->group('a.tj_shop')
            ->limit($Page->firstRow, $Page->listRows)
            ->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj
        $sql = "SELECT COUNT(*) as tnum,sum(pay_price) as amount, FROM_UNIXTIME(order_time,'%Y-%m-%d') as gap from  __PREFIX__order_info ";
        $sql .= " where order_time>$this->begin and order_time<$this->end AND tj_status=1 AND tj_shop<>0 AND order_status>1 group by gap ";
        $res = M()->query($sql);//订单数,交易额
        $tnum = 0;
        $tamount = 0;
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['tnum'];
            $brr[$val['gap']] = $val['amount'];
            $tnum += $val['tnum'];
            $tamount += $val['amount'];
        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_num = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_amount = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_sign = empty($tmp_num) ? 0 : round($tmp_amount / $tmp_num, 2);
            $order_arr[] = $tmp_num;
            $amount_arr[] = $tmp_amount;
            $sign_arr[] = $tmp_sign;
            $date = date('Y-m-d', $i);
            $list[] = array('day' => $date, 'order_num' => $tmp_num, 'amount' => $tmp_amount, 'sign' => $tmp_sign, 'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }

        $this->assign('list', $list);
        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
        $this->assign('result', json_encode($result));
        $map['order_status'] = array('gt', 1);
        $map['tj_shop'] = array('neq',0);//店铺推荐
        $map['tj_status'] = 1;//推荐订单
        $map['order_time'] = array('between', array($this->begin, $this->end));
        $dayZnum = $m->where($map)->count();//订单总数
        $dayMoney = $m->where($map)->sum('pay_price');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);
        $this->display();
    }
    /**
     * 艺术家自传作品订单统计
     * zj
     */
    public function Autobiography()
    {
        $where = array();
        $m = M("order_goods");
        $where['b.order_status'] = array('gt', 1);
        $where['a.shop_id'] = array('neq',0);//艺术家店铺id
        $where['b.order_time'] = array('between', array($this->begin, $this->end));

        $count = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_apply c on a.shop_id = c.id')
            ->where($where)
            ->group('a.shop_id')->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出

        $res = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_apply c on a.shop_id = c.id')
            ->where($where)
            ->field('sum(a.goods_price) as totalfee,count(a.id) as totalnum,c.name as artist_name')->where($where)
            ->group('a.shop_id')
            ->limit($Page->firstRow, $Page->listRows)
            ->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj

        $dayZnum = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_apply c on a.shop_id = c.id')
            ->where($where)->count();//订单总数
        $dayMoney = $m->alias("a")->join('LEFT JOIN app_order_info b on a.order_id = b.id')->join('LEFT JOIN app_apply c on a.shop_id = c.id')
            ->where($where)->sum('a.goods_price');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);
        $this->display();
    }

    /**
     * 艺术家自传作品订单统计
     * zj
     */
    public function Autobiography1()
    {
        $where = array();
        $m = M("order_info");
        $where['a.order_status'] = array('gt', 1);
        $where['a.shop_id'] = array('neq',0);//艺术家店铺id
        $where['a.order_time'] = array('between', array($this->begin, $this->end));
        $count = $m->alias("a")->join('LEFT JOIN app_apply b on a.shop_id = b.id')
            ->where($where)
            ->group('a.shop_id')->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = $m->alias("a")->join('LEFT JOIN app_apply b on a.shop_id = b.id')
            ->field('sum(a.pay_price) as totalfee,count(a.id) as totalnum,b.name')->where($where)
            ->group('a.shop_id')
            ->limit($Page->firstRow, $Page->listRows)
            ->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj
        $sql = "SELECT COUNT(*) as tnum,sum(pay_price) as amount, FROM_UNIXTIME(order_time,'%Y-%m-%d') as gap from  __PREFIX__order_info ";
        $sql .= " where order_time>$this->begin and order_time<$this->end AND shop_id<>0 AND order_status>1 group by gap ";
        $res = M()->query($sql);//订单数,交易额
        $tnum = 0;
        $tamount = 0;
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['tnum'];
            $brr[$val['gap']] = $val['amount'];
            $tnum += $val['tnum'];
            $tamount += $val['amount'];
        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_num = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_amount = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_sign = empty($tmp_num) ? 0 : round($tmp_amount / $tmp_num, 2);
            $order_arr[] = $tmp_num;
            $amount_arr[] = $tmp_amount;
            $sign_arr[] = $tmp_sign;
            $date = date('Y-m-d', $i);
            $list[] = array('day' => $date, 'order_num' => $tmp_num, 'amount' => $tmp_amount, 'sign' => $tmp_sign, 'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }

        $this->assign('list', $list);
        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
        $this->assign('result', json_encode($result));
        $map['order_status'] = array('gt', 1);
        $map['shop_id'] = array('neq',0);//自传店铺id
        $map['order_time'] = array('between', array($this->begin, $this->end));
        $dayZnum = $m->where($map)->count();//订单总数
        $dayMoney = $m->where($map)->sum('pay_price');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);
        $this->display();
    }

    public function indexShop(){
        $takemoney = M('takemoney');
        $data = array();
        $name = trim(I('name'));
        if($name){
            $this->assign('name',$name);
            $data['b.name'] = array('like','%'.$name.'%');
        }
        $tel = I('tel');
        if($tel){
            $this->assign('tel',$tel);
            $data['a.mobile'] = array('like','%'.$tel.'%');
        }
        $a_name = I('a_name');
        if($a_name){
            $this->assign('a_name',$a_name);
            $data['a.truename'] = array('like','%'.$a_name.'%');
        }
        $data['a.status'] = array('in','1,2');
        $data['class'] = 2;//店铺自传作品审核
        $status = I("param.status");
        if($status){
            $data['a.status'] = $status;
        }

        $info = $takemoney
            ->alias('a')
            ->field('a.*,b.name')
            ->join('app_apply as b on a.artist_id = b.id')
            ->where($data)
            ->select();
        //dump($orders);die();
        $name ="店铺提现详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,店铺名称,卡号,银行名,户名,号码,申请金额,打款时间,状态,创建时间";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['artist_name']    = $val['artist_name']?$val['artist_name']:"无";
            $data['bank_no']      =$val['bank_no']?$val['bank_no']:"无";
            $data['bank_name']  = $val['bank_name']?$val['bank_name']:"无";
            $data['truename']  = $val['truename']?$val['truename']:"无";
            $data['mobile']  = $val['mobile']?$val['mobile']:"无";
            $data['money']  = $val['money']?$val['money']:0.00;
            $data['deal_at']  = $val['deal_at']?date('Y-m-d H:i:s',$val['deal_at']):"无";
            switch($val['status']){
                case 1:
                    $data['status']="待审核";
                    break;
                case 2:
                    $data['status']='已审核';
                    break;
                default:
                    $data['status']='未知';
                    break;
            }

            $data['addtime']  = $val['addtime']?date('Y-m-d H:i:s',$val['addtime']):"无";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";


        }

        //$this->setLog("店铺提现详情",IMG_URL.'Admin/Order/orderExport');
        exit;
    }

    //拍卖订单统计
    public function OrderPm(){
        $where = array();
        $m = M("order_pm");
        $where['a.order_status'] = array('gt', 1);
        $where['a.order_time'] = array('between', array($this->begin, $this->end));
        $count = $m->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->where($where)->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = $m->alias("a")->join('LEFT JOIN app_member b on a.user_id = b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow, $Page->listRows)->order('a.id desc')->select();
        $this->assign("page", $show);
        $this->assign('cache', $res);
        //订单统计 zj
        $sql = "SELECT COUNT(*) as tnum,sum(pay_price) as amount, FROM_UNIXTIME(order_time,'%Y-%m-%d') as gap from  __PREFIX__order_pm ";
        $sql .= " where order_time>$this->begin and order_time<$this->end AND  order_status>1 group by gap ";
        $res = M()->query($sql);//订单数,交易额
        $tnum = 0;
        $tamount = 0;
        foreach ($res as $val) {
            $arr[$val['gap']] = $val['tnum'];
            $brr[$val['gap']] = $val['amount'];
            $tnum += $val['tnum'];
            $tamount += $val['amount'];
        }
        for ($i = $this->begin; $i <= $this->end; $i = $i + 24 * 3600) {
            $tmp_num = empty($arr[date('Y-m-d', $i)]) ? 0 : $arr[date('Y-m-d', $i)];
            $tmp_amount = empty($brr[date('Y-m-d', $i)]) ? 0 : $brr[date('Y-m-d', $i)];
            $tmp_sign = empty($tmp_num) ? 0 : round($tmp_amount / $tmp_num, 2);
            $order_arr[] = $tmp_num;
            $amount_arr[] = $tmp_amount;
            $sign_arr[] = $tmp_sign;
            $date = date('Y-m-d', $i);
            $list[] = array('day' => $date, 'order_num' => $tmp_num, 'amount' => $tmp_amount, 'sign' => $tmp_sign, 'end' => date('Y-m-d', $i + 24 * 60 * 60));
            $day[] = $date;
        }

        $this->assign('list', $list);
        $result = array('order' => $order_arr, 'amount' => $amount_arr, 'sign' => $sign_arr, 'time' => $day);
        $this->assign('result', json_encode($result));
        $map['order_status'] = array('gt', 1);
        $map['order_time'] = array('between', array($this->begin, $this->end));
        $dayZnum = $m->where($map)->count();//订单总数
        $dayMoney = $m->where($map)->sum('goods_price');//订单总金额
        $this->assign('dayZnum', $dayZnum);
        $this->assign('dayMoney', $dayMoney);


        $this->display();
    }

    //提现记录
    public function cash(){
        $type = I('get.type');
        $starttime      = trim(I("get.starttime"));
        $endtime        = trim(I("get.endtime"));
        $this->assign('starttime',$starttime);
        $this->assign('endtime',$endtime);

        if ($starttime && $endtime){
            $starttime      = strtotime($starttime.'00:00:00');
            $endtime        = strtotime($endtime.'23:59:59');
            $map[1]['a.addtime'] =array('gt',$starttime);
            $map[2]['a.addtime'] =array('lt',$endtime);
        }elseif($starttime){
            $starttime      = strtotime($starttime.'00:00:00');
            $map['a.addtime'] =array('gt',$starttime);
        }elseif($endtime){
            dump($endtime);
            $endtime        = strtotime($endtime.'23:59:59');
            $map['a.addtime'] =array('lt',$endtime);
        }

        if($type!=''){
            $map['a.status'] =$type;
        }

        //$count = count(M('settl as s')->join('left join app_pm as p on p.id = s.goods_id')->where($map)->select());
        $count  = M('cash')
            ->alias('a')
            ->join('left join app_bank_list b on a.bank_id=b.id')
            ->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('cash')
            ->alias('a')
            ->join('left join app_bank_list b on a.bank_id=b.id')
            ->field('a.id,a.status,a.money,a.addtime,b.bank_no,b.bank_name,b.bank_branch,b.username,b.telephone')
            ->order('addtime desc')
            ->where($map)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        $count =  M('cash')->count();
        $count1 =  M('cash')->where(array('status'=>0))->count();
        $count2 =  M('cash')->where(array('status'=>1))->count();
        //dump($res);exit;
        $this->assign('res',$res);
        $this->assign('counts',$count);
        $this->assign('count0',$count1);
        $this->assign('count1',$count2);
        $this->display();
    }

    public function cashAgree(){
        $id = I('post.id');
        //print_r($id);exit;
        $res = M('cash')->where(array('id'=>$id))->setField(array('status'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1));
        }else{
            $this->ajaxReturn(array('status'=>0,'同意失败,请重新批准!'));
        }
    }

    public function cashDisagree(){
        $id = I('post.id');
        $feedback = I('post.feedback');
        $res = M('cash')->where(array('id'=>$id))->setField(array('status'=>2,'feedback'=>$feedback));
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'拒绝成功!'));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'拒绝失败,请重新批准!'));
        }
    }
}