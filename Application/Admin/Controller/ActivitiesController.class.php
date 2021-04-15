<?php

namespace Admin\Controller;

use Common\Controller\CommonController;

class ActivitiesController extends CommonController
{
    public function index()
    {
        $map = array();
        $starttime = trim(I('starttime'));
        if (!empty($starttime)) {
            $this->assign('starttime', $starttime);
            $map['_string'] = "to_days(started_at) >= to_days(from_unixtime(" . strtotime($starttime) . "))";
        }
        $endtime = trim(I('endtime'));
        if (!empty($endtime)) {
            $this->assign('endtime', $endtime);
            if (!empty($map['_string'])) {
                $map['_string'] .= " and to_days(expired_at) <= to_days(from_unixtime(" . strtotime($endtime) . "))";
            } else {
                $map['_string'] = "to_days(expired_at) <= to_days(from_unixtime(" . strtotime($endtime) . "))";
            }
        }
        $title = trim(I('title'));
        if (!empty($title)) {
            $this->assign('title', $title);
            $map['title'] = array('like', '%' . $title . '%');
        }

        $action = M('Activities');
        $count = $action->where($map)->count();
        $p = getpage($count, 10);
        $page = $p->show();
        $res = $action->where($map)->order('id desc')->limit($p->firstRow, $p->listRows)->select();
//        echo M()->getLastSql();
        $this->assign('page', $page);
        $this->assign('activity_list', $res);
        $this->display();
    }

    public function addActivity()
    {
        if (IS_POST) {
//            p($_POST);
            $post_data = I('post.');
//            p($post_data);

            $post_data['created_at'] = date("Y-m-d H:i:s");
            $result = M('Activities')->add($post_data);
            if ($result) {
                $this->success('添加成功', U("/Admin/activities/index"));
                exit;
            } else {
                $this->error('添加失败');
                exit;
            }
        }

        $this->display();
    }

    /**
     * 编辑活动场次
     */
    public function editActivity()
    {
        if (IS_POST) {
//            p($_POST);
            $post_data = I('post.');
            $id = $post_data['id'];
            unset($post_data['id']);
            $post_data['updated_at'] = date("Y-m-d H:i:s");

            $result = M('Activities')->where(array('id' => $id))->save($post_data);
            if ($result) {
                $this->success('修改成功', U("/Admin/Activities/index"));
                exit;
            } else {
                $this->error('修改失败');
                exit;
            }
        }
        $id = $_GET['id'];
        $res = M('Activities')->where(array('id' => $id))->find();
        $this->assign('activities', $res);

        $this->display();
    }

    /**
     * 活动商品列表
     */
    public function activityGoods()
    {
        $activity_id = $_GET['id'];
        $count = M('Goods')->where(array('activity_id'=>$activity_id,'is_del'=>0))->count();

        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",  $show);
        $res = M('Goods')->where(array('activity_id'=>$activity_id,'is_del'=>0))
            ->order('sort asc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();

        $this->assign("res",  $res);
        $this->display();
    }

    /**
     * 给活动添加商品
     */
    public function addActivityGoods()
    {
        if (IS_AJAX){
            $data1 = I('post.');

            if(!$data1['index_pic']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品展示图！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data1['pic1']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品切换图！';
                $this->ajaxReturn($dataAj);die;
            }

            $m      = M("goods");
            $g_s_m  = M("goodsSlide");
            $data   = I("post.");

            $data['weight'] = $data['weight']/1000;
            $data['price'] = $data['price']?$data['price']:$data['b_price'];
            $data['oprice'] = $data['oprice']?$data['oprice']:0;

            $slide_pic = $data['pic1'];
            if (I("post.is_sale")) {
                $data['sale_at'] = NOW_TIME;
            }
            unset($data['pic1']);
            $data['create_at'] = NOW_TIME;
            $data['shenhe'] = 1;
            $data['cstore'] = 0;
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
                    $g_s_m->add($slide_data);
                }
            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '新增产品失败！';
                $this->ajaxReturn($dataAj);die;
                //$this->error("新增产品失败！",U('Admin/goods/goodslist'));
            }
            $dataAj['info'] = '新增产品成功！';
            $dataAj['status'] = 1;
            $this->ajaxReturn($dataAj);die;

        }

        $this->display();
    }

    public function editActivityGoods()
    {
        if (IS_AJAX) {
            $m                  = M("goods");
            $g_s_m              = M("goodsSlide");
            $data               = I("post.");
            $data['oprice'] = $data['oprice']?$data['oprice']:0;
            $data['price'] = $data['price']?$data['price']:$data['b_price'];
            $data['goods_list'] = time();
            $data['cate_id']    = implode(',',$data['cate_id']);
            $data['weight'] = $data['weight']/1000;
            $id                 = $data['id'];
            $slide_pic          = $data['pic1'];
            unset($data['id']);
            unset($data['pic1']);
            $data['create_at'] = NOW_TIME;

            if (!$id) {
                $dataAj['info'] = '缺少参数！';
                $dataAj['status'] = 0;
                $this->ajaxReturn($dataAj);die;
                //$this->error("缺少参数！");
            }

            //保存产品属性 zj
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
                    $g_s_m->add($slide_data);
                }
            } else {
                $dataAj['info'] = '修改商品失败！';
                $dataAj['status'] = 0;
                $this->ajaxReturn($dataAj);die;
                //$this->error("修改商品失败！",U('Admin/goods/goodslist'));
            }
            $dataAj['info'] = '修改商品成功！';
            $dataAj['status'] = 1;
            $this->ajaxReturn($dataAj);die;
            //$this->redirect('Admin/goods/goodslist');
        }
        $id = I("id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $goods = M("goods")->where(array('id'=>$id, "isdel"=>0))->find();
        $goods['weight'] = $goods['weight']*1000;
        if (!$goods) {
            echo "<script>alert('无此商品！');window.history.back();</script>";die;
        }
        $goods_slide = M("goodsSlide")->where(array('goods_id'=>$id, "status"=>1,'isdel'=>0))->select();
        $this->assign("goods_slide", $goods_slide);
        $this->assign("cache", $goods);
        // dump($goods);exit;
        //产品属性选择 zj
        $this->display();
    }

    public function delActivityGoods()
    {
        $id  = $_GET['id'];
        $res = M("goods")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
}