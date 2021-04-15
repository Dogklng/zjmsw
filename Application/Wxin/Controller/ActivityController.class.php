<?php

namespace Wxin\Controller;

use Think\Controller;

class ActivityController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function img()
    {
        $images = M('banner')->where(array('type'=>78,'isdel'=>0))->find();
        $this->assign('images',$images);
    }

    public function index()
    {
        $start_time = I('get.start_time');
        $status = I('get.status');

//        $name = $_SESSION['member_id'];
//        if($name == ''){
//            $this->assign('name',0);
//        }else{
//            $this->assign('name',$name);
//        }

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }

//        if ($status == 1) {
//            // 未开始
//            $num = M('Activities')->where(array('is_del'=>0))->where(array('started_at'=>array('gt',date("Y-m-d H:i:s"))))->order('started_at desc')->select();
//        } elseif ($status == 3) {
//            // 已结束
//            $num = M('Activities')->where(array('is_del'=>0))->where(array('expired_at'=>array('lt', date("Y-m-d H:i:s"))))->order('started_at desc')->select();
//        } elseif ($status == 2) {
//            // 进行中
//            $num = M('Activities')->where(array('is_del'=>0))->where(array('started_at'=>array('elt',date("Y-m-d H:i:s" )), 'expired_at'=>array('egt', date("Y-m-d H:i:s"))))->order('started_at desc')->select();
//        } else {
//            $num = M('Activities')->where(array('is_del'=>0))->order('started_at desc')->select();
//        }

        $num = M('Activities')->where(array('is_del'=>0))->order('started_at desc')->select();
        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $goods_num = M("Goods")->where(array('is_del'=>0,'activity_id'=>$v['id']))->count();

            if ($v['type'] == 1) {
                $num[$k]['description'] = "该活动内所有商品满" . $v['amount'] . "减" . $v['discount_amount'];
            } else if ($v['type'] == 2) {
                $num[$k]['description'] = "该活动内所有商品" . bcdiv($v['discount'], 10) . "折";
            } else if ($v['type'] == 3) {
                $num[$k]['description'] = "该活动内所有商品满" . $v['amount'] . "元所有商品" . bcdiv($v['discount'], 10) . "折";
            }
            $num[$k]['goods_num'] = $goods_num;
            $num[$k]['started_at'] = strtotime($v['started_at']);
            $num[$k]['expired_at'] = strtotime($v['expired_at']);
        }

        $count = count($num);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $num = $ArrayObj->page_array($num,0);//数组分页

        $this->assign('page',$page);

        $this->assign('num',$num);

        $this->img();
        $this->display();
    }

    public function activityDetail()
    {
        $activity_id = I('get.activity_id');
        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        $activity = M("activities")->where(array('id'=>$activity_id))->find();
        if ($activity['type'] == 1) {
            $activity['description'] = "该活动内所有商品满" . $activity['amount'] . "减" . $activity['discount_amount'];
        } else if ($activity['type'] == 2) {
            $activity['description'] = "该活动内所有商品" . bcdiv($activity['discount'], 10) . "折";
        } else if ($activity['type'] == 3) {
            $activity['description'] = "该活动内所有商品满" . $activity['amount'] . "元所有商品" . bcdiv($activity['discount'], 10) . "折";
        }

        $res = M('Goods')->where(array('is_del'=>0,'activity_id'=>$activity_id))->order('sort desc')->select();
        foreach ($res as $key=>$value) {
            if ($activity['type'] == 2) {
//                if ($value['price'] >= $activity['amount']) {
//                    $value['zhehoujia'] = bcsub($value['price'], $activity['discount_amount']);
//                } else {
//                    $value['zhehoujia'] = $value['price']
//                }
                $res[$key]['zhehoujia'] = bcdiv(bcmul($value['price'], $activity['discount']), 100);
            }
        }

        //dump($sponsor);exit;
        $this->assign('res',$res);
        $this->assign('activity',$activity);
        //$this->paimai('start');

        $this->img();
        $this->display();
    }
}