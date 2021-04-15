<?php

namespace Admin\Controller;

use Common\Controller\CommonController;

class ActivityController extends CommonController {

    public function indexs() {
        $map = array();
//        $price = trim(I('price'));
//        if(!empty($price)){
//            $this->assign('price',$price);
////            $map['price'] = array('like','%'.$car_num.'%');
//            $map['price'] = $price;
//        }
//        $is_show = trim(I('is_show'));
//        if(!empty($is_show)){
//            $this->assign('is_show',$is_show);
////            $map['price'] = array('like','%'.$car_num.'%');
//            if($is_show == 2){
//                $is_show = 0;
//            }
//            $map['is_show'] = $is_show;
//        }
//        $is_order_price = I('is_order_price');
//        if(!empty($is_order_price)){
//            $this->assign('is_order_price',$is_order_price);
//            $map['is_order_price'] = $is_order_price;
//        }
//        $integral = I('integral');
//        if(!empty($car_unit)){
//            $this->assign('integral',$integral);
//            $map['integral'] = $integral;
//        }
        $starttime = trim(I('starttime'));
        if (!empty($starttime)) {
            $this->assign('starttime', $starttime);
            $map['_string'] = "to_days(start_time) >= to_days(from_unixtime(" . strtotime($starttime) . "))";
        }
        $endtime = trim(I('endtime'));
        if (!empty($endtime)) {
            $this->assign('endtime', $endtime);
            if (!empty($map['_string'])) {
                $map['_string'] .= " and to_days(end_time) <= to_days(from_unixtime(" . strtotime($endtime) . "))";
            } else {
                $map['_string'] = "to_days(end_time) <= to_days(from_unixtime(" . strtotime($endtime) . "))";
            }
        }
        $title = trim(I('title'));
        if (!empty($title)) {
            $this->assign('title', $title);
            $map['title'] = array('like', '%' . $title . '%');
        }

        $action = M('Activitys');
        $count = $action->where($map)->count();
        $p = getpage($count, 10);
        $page = $p->show();
        $res = $action->where($map)->order('id desc')->limit($p->firstRow, $p->listRows)->select();
//        echo M()->getLastSql();
        $this->assign('page', $page);
        $this->assign('activity_list', $res);
        $this->display();
    }

    public function ajaxUpdateShop() {

        $goosid = I('post.goodsid');
        $m = D("Activity");

        $res = $m->where('id=' . $goosid)->find();
        if ($res['is_show'] == 1) {
            $rs = $m->where('id=' . $goosid)->setField('is_show', 0);
        } else {
            $rs = $m->where('id=' . $goosid)->setField('is_show', 1);
        }
        $data['info'] = $res['is_show'];

        $this->ajaxReturn($data);
        return;
    }

    public function add() {

        //查询所有经销商
        $dealer = D('Dealer');
        $deal = $dealer->where('is_show=1')->select();
        //print_r($deal);
        $this->assign('deal', $deal);

        //调用Category控制器中的方法,获取类列表
        $action = A('Category');
        $rs = $action->categorylist();

        //调用Category控制器中的方法,获取水果类列表   
        //$fruittype=$action->fruittypelist();

        $title = I('post.title');

        if (!empty($title)) {

            $date['goodsid'] = I('post.goodsid');
            $date['title'] = $title;
            $date['dealer_id'] = I('post.dealer_id');
            $date['subtitle'] = I('post.subtitle');
            $date['pic'] = I('post.pic');
            $date['guige'] = I('post.guige');
            $date['is_show'] = I('post.is_show');
            $date['sequence'] = I('post.rank');
            $m = M('Activity');
            $rs = $m->add($date);

            if ($rs) {
                $this->success('添加成功', U('/Admin/trial/trialx'));
            } else {
                $this->error('添加失败');
            }
        } else {

            $goodsModel = M('goods');
            $goodsRecord = $goodsModel->select();
            //查询有那几个经销商
            $dealer = $goodsModel->distinct(true)->field('dealers_id')->select();
            //print_r($dealer);
            $goodsRecord = array();
            foreach ($dealer as $value) {
                $goodsRecord[$value['dealers_id']] = $goodsModel->where('dealers_id=' . $value['dealers_id'])->select();
            }

            $this->assign('goods', $goodsRecord);
            $this->assign('urlname', "addActivity");
            $this->assign('categorylist', $rs);
            $this->assign('munetype', 8);
            $this->display();
        }
    }

    public function delgoods() {
        $goosid = I('get.id');
        $m = M("goods"); // 实例化User对象
        $rs = $m->where("id=$goosid")->delete(); // 删除id为5的用户数据
        if ($rs) {
            $this->success('删除成功', U('/Admin/Goods/index'));
        } else {
            $this->error('删除失败');
        }
    }

    public function edit() {

        $id = I('get.id');
        $title = I('post.title');
        $action = M('Activity');

        if (!empty($title)) {

            $data['id'] = I('post.id');
            $data['goodsid'] = I('post.goodsid');
            $data['title'] = $title;
            $data['subtitle'] = I('post.subtitle');
            $data['pic'] = I('post.pic');
            $data['guige'] = I('post.guige');
            $data['is_show'] = I('post.is_show');
            $data['sequence'] = I('post.rank');
            $data['dealer_id'] = I('post.dealer_id');
            $result = $action->save($data);
            if ($result) {
                $this->success('修改成功', U("/Admin/trial/trial"));
                exit;
            } else {
                $this->success('没有修改', U("/Admin/trial/trial"));
                exit;
            }
        } else {

            //查询所有经销商
            $dealer = D('Dealer');
            $deal = $dealer->where('is_show=1')->select();
            //print_r($deal);
            $this->assign('deal', $deal);

            $goodsModel = M('goods');
            //查询有那几个经销商
            $dealer = $goodsModel->distinct(true)->field('dealers_id')->select();
            //print_r($dealer);
            $goodsRecord = array();
            foreach ($dealer as $value) {
                $goodsRecord[$value['dealers_id']] = $goodsModel->where('dealers_id=' . $value['dealers_id'])->select();
            }
            $this->assign('goods', $goodsRecord);

            $result = $action->where('id=' . $id)->find();

            $goodsone = $goodsModel->where('id=' . $result['goodsid'])->find();
            $result['goodsname'] = $goodsone['good_name'];
            $this->assign('editmarketing', $result);
            $this->assign('urlname', "indexActivity");
            $this->assign('munetype', 8);

            $this->display();
        }
    }

    public function activitys() {
        if (IS_POST) {
//            p($_POST);
            $post_data = I('post.');
//            p($post_data);
            //todo  处理数据
            $goodsid = implode(',', $post_data['goodsid']);
            unset($post_data['goodsid']);

            $couponid = implode(',', $post_data['couponid']);
            unset($post_data['couponid']);
            $post_data['goods_ids'] = $goodsid;
            $post_data['coupon_ids'] = $couponid;
            $post_data['addtime'] = time();
            $result = M('Activitys')->add($post_data);
            if ($result) {
                $this->success('添加成功', U("/Admin/activity/indexs"));
                exit;
            } else {
                $this->error('添加失败');
                exit;
            }
        }
        $goodsRecord = M('goods')->where('is_sale=1')->order('id desc')->select();
//			p($goodsRecord);
        $this->assign('goods', $goodsRecord);
        $coupon = M('coupon')->select();
        $this->assign('coupon', $coupon);

        $this->assign('urlname', "activitys");
        $this->display();
//
    }

    public function editactivity() {
        if (IS_POST) {
//            p($_POST);
            $post_data = I('post.');
            $id = $post_data['id'];
            unset($post_data['id']);
//            p($post_data);
//            die();
            //todo  处理数据
            if (!empty($post_data['goodsid'])) {
                $goodsid = implode(',', $post_data['goodsid']);
                unset($post_data['goodsid']);
                $post_data['goods_ids'] = $goodsid;
            }

            if (!empty($post_data['couponid'])) {
                $couponid = implode(',', $post_data['couponid']);
                unset($post_data['couponid']);
                $post_data['coupon_ids'] = $couponid;
            }
//            $post_data['addtime'] = time();
//            if($id){
//
//            }
            $result = M('Activitys')->where(array('id' => $id))->save($post_data);
            if ($result) {
                $this->success('修改成功', U("/Admin/activity/indexs"));
                exit;
            } else {
                $this->error('修改失败');
                exit;
            }
        }
        $id = $_GET['id'];
        $res = M('Activitys')->where(array('id' => $id))->find();
        $goods_ids = array_filter(explode(',', $res['goods_ids']));
        $res['goods_ids'] = $goods_ids;
        $coupon_ids = array_filter(explode(',', $res['coupon_ids']));
        $res['coupon_ids'] = $coupon_ids;
        $this->assign('editmarketing', $res);
//        p($res);
        $goodsRecord = M('goods')->where('is_sale=1')->order('id desc')->select();
//			p($goodsRecord);
        $this->assign('goods', $goodsRecord);
        $coupon = M('coupon')->select();
        $this->assign('coupon', $coupon);

        $this->assign('urlname', "activitys");
        $this->display();
    }

    public function activitys_datainfo() {
        $model = M('Activitys');
        if (I('get.title')) {
            $where = 'activitys_name like "%' . I('get.title') . '%"';
        } else {
            $where = "1=1";
        }
        $count = $model->where($where)->count();
        $p = getpage($count, 10);
        $list = $model->where($where)->order('id desc')->limit($p->firstRow, $p->listRows)->select();
        $dealer = D('Dealer');
        foreach ($list as $key => $v) {
            $list[$key]['dealername'] = $dealer->where('id=' . $v['dealer_id'])->getField('username');
        }
        $this->assign('list', $list);
        $this->assign('count', $count);
        $this->assign('page', $p->show());
        $this->assign('urlname', "activitys_datainfo");
        $this->display();
    }

    public function activity_detail() {

        $data['activitys_name'] = I('post.title');
        if (!empty($data['activitys_name'])) {
            $data['id'] = I('post.id');
            $data['dealer_id'] = I('post.dealer_id');
            $data['activitys_goods_ids'] = substr(I('post.goodsIds'), 0, -1);
            $data['addtime'] = time();
            $data['typeid'] = I('post.typeid');
            $data['activitys_con'] = I('post.activitys_con');
            $data['is_close'] = I('post.is_close');
            $result = M('Activitys')->save($data);
            echo $result;
            exit;
        } else {

            //查询所有经销商
            $dealer = D('Dealer');
            $deal = $dealer->where('is_show=1')->select();
            //print_r($deal);
            $this->assign('deal', $deal);

            //$goodsRecord = M('goods')->where('is_show=1')->select();
            $id = intval(I('get.id'));

            $goodsModel = M('goods');
            //查询有那几个经销商
            $dealer = $goodsModel->distinct(true)->field('dealers_id')->select();
            //print_r($dealer);
            $goodsRecord = array();
            foreach ($dealer as $value) {
                $goodsRecord[$value['dealers_id']] = $goodsModel->where('dealers_id=' . $value['dealers_id'])->order('id desc')->select();
            }

            if ($id) {
                $data = M('Activitys')->where("id=$id")->find();
                if ($data['activitys_goods_ids']) {
                    $data['goods'] = M('Goods')->field('id,good_name')->where("id in($data[activitys_goods_ids])")->select();
                    $data['activitys_goods_ids'] = explode(',', $data['activitys_goods_ids']);
                    foreach ($goodsRecord as $key => $value) {
                        foreach ($value as $k => $val) {
                            if (in_array($val['id'], $data['activitys_goods_ids'])) {
                                $goodsRecord[$key][$k]['is_checked'] = 1;
                            } else {
                                $goodsRecord[$key][$k]['is_checked'] = 0;
                            }
                        }
                    }
                }
                $this->assign('data', $data);
            }
            $this->assign('goods', $goodsRecord);
            $this->display();
        }
    }

    public function activity_goods() {
        if (IS_POST) {
            $data = I('post.');
            unset($data['select_class_id']);
            unset($data['select_series_id']);
            $only = M('ActivityGoods')->where(array('goods_id' => $data['goods_id']))->count();
            if ($only) {
                $this->error('该商品已在活动中');
            }
            $res = M('ActivityGoods')->add($data);
            if ($res) {
                M('Goods')->where(array('id' => $data['goods_id']))->save(array('is_activity' => $data['activity_id']));
                $this->redirect('Admin/Activity/Goods/id/' . $data['activity_id']);
            } else {
                $this->error('添加失败');
            }
        }
        $id = I('get.id');
        if (!$id) {
            $this->error('参数错误');
        }
        //分类
        $c = M("cate");
        $categorylist = $c->where(array("pid" => 0, "isdel" => 0))->select();
        foreach ($categorylist as $k => $v) {
            $categorylist[$k]['cate'] = $c->where(array('pid' => $v['id'], 'isdel' => 0))->select();
        }
        $this->assign("cate", $categorylist);
        //系列
        $s = M("series");
        $serieslist = $s->where(array("pid" => 0, "isdel" => 0))->select();
        foreach ($serieslist as $k => $v) {
            $serieslist[$k]['cate'] = $s->where(array('pid' => $v['id'], 'isdel' => 0))->select();
        }
        // $goods = M('ActivityGoodsView')->select();
        $this->assign('goods', $goods);
        $this->assign('attr', $serieslist);
        $this->display();
    }

    public function goods() {
        $id = I('get.id');
        if (!$id) {
            $this->error('参数错误');
        }
        $name = I('get.name');
        if ($name) {
            $where['goods_name'] = array('like', "%$name%");
        }
        $where['activity_id'] = $id;
        $count = M('ActivityGoodsView')->where($where)->count();
        $p = getpage($count, 10);
        $page = $p->show();
        $goods = M('ActivityGoodsView')->where($where)->order('id desc')->limit($p->firstRow, $p->listRows)->select();
        $this->assign('page', $page);
        $this->assign('goods', $goods);
        $this->assign('count', $count);
        $this->assign('name', $name);
        $this->display();
    }

    public function edit_activity_goods() {
        $goods_id = I('get.goods_id');
        if (IS_POST) {
            $data = I('post.');
            $activity_id = I('post.activity_id');
            $id = I('post.id');
            $only = M('ActivityGoods')->where(array('goods_id' => $data['goods_id']))->find();
            $onlys = M('ActivityGoods')->where($where)->count();
            $is_only = M('ActivityGoods')->find($id);
            if ($is_only['goods_id'] != $data['goods_id']) {
                if ($onlys) {
                    $this->error('该商品已在活动中');
                }
            }
            unset($data['select_class_id']);
            unset($data['select_series_id']);
            unset($data['activity_id']);
            $res = M('ActivityGoods')->save($data);
            if ($res) {
                if ($is_only['goods_id'] != $data['goods_id']) {
                    M('Goods')->where(array('id' => $is_only['goods_id']))->save(array('is_activity' => 0));
                    M('Goods')->where(array('id' => $data['goods_id']))->save(array('is_activity' => $activity_id));
                }
                $this->redirect('/Admin/Activity/goods/id/' . $activity_id);
            } else {
                $this->error('修改失败！');
            }
        }
        if ($goods_id) {
            $goods = M('ActivityGoodsView')->find($goods_id);
            $this->assign('cache', $goods);
        }
        //分类
        $c = M("cate");
        $categorylist = $c->where(array("pid" => 0, "isdel" => 0))->select();
        foreach ($categorylist as $k => $v) {
            $categorylist[$k]['cate'] = $c->where(array('pid' => $v['id'], 'isdel' => 0))->select();
        }
        $this->assign("cate", $categorylist);
        //系列
        $s = M("series");
        $serieslist = $s->where(array("pid" => 0, "isdel" => 0))->select();
        foreach ($serieslist as $k => $v) {
            $serieslist[$k]['cate'] = $s->where(array('pid' => $v['id'], 'isdel' => 0))->select();
        }
        // $goods = M('ActivityGoodsView')->select();
        $this->assign('goods', $goods);
        $this->assign('attr', $serieslist);
        $this->display();
    }

    /**
     * 删除活动商品
     */
    public function ajaxDelActivityGoods() {
        if (IS_AJAX) {
            $id = I('post.id');
            if (!$id) {
                $this->ajaxReturn(array('status' => 0, 'info' => '参数有误!'));
            }
            $res = M('ActivityGoods')->delete($id);
            if ($res) {
                $this->ajaxReturn(array('status' => 1, 'info' => '删除成功'));
            } else {
                $this->ajaxReturn(array('status' => 0, 'info' => '删除失败'));
            }
        }
    }

    public function CjConfig()
    {
        if (IS_POST) {
            $data = I("post.");
            unset($data['id']);
            $data['update_time'] = NOW_TIME;
            $res = M("luck_config")->where("id=1")->save($data);
            if ($res !== false) {
                $this->ajaxReturn(array("status" => 1, "info" => "保存成功！"));
            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "保存失败！"));
            }

        }
        $cache = M("luck_config")->where(array("id" => 1))->find();
        $this->assign("cache", $cache);
        $this->display();
    }

    /**
     * 抽奖规则设置
     *
     */
    public function Guize() {
        if (IS_AJAX) {
            $data               = I("post.");
            $luck_class = $data['luck_class'];
            $integral           = $data['integral'];
            $goodsid            = $data['goodsid'];
            $probability        = $data['probability'];
            $luck['title']      = $data['title'];
            $luck['img']        = $data['img'];
            $luck['start_time'] = strtotime($data['start']);
            $luck['end_time']   = strtotime($data['stop']);
            $probabilitys       = array_sum($probability);
            if ($probabilitys > 100) {
                $this->ajaxReturn(array('status' => 0, 'info' => '总的中奖概率不能超过100%'));
            }
            if (!$data['img']) {
                $this->ajaxReturn(array('status' => 0, 'info' => '请上传大转盘图片'));
            }
            if ($luck['start_time'] >= $luck['end_time']) {
                $this->ajaxReturn(array('status' => 0, 'info' => '开始时间不可大于结束时间'));
            }
            if (empty($luck['title'])) {
                $this->ajaxReturn(array('status' => 0, 'info' => '请输入活动标题'));
            }
            $luck['creat_at'] = NOW_TIME;
            M("luck")->where('1')->setField("status",2);
            $res = M("luck")->data($luck)->add();
            if (!$res) {
                $this->ajaxReturn(array('status' => 0, 'info' => '创建失败'));
            }
            foreach ($luck_class as $k => $val) {
                $luckgoods = array();
                if ($val == 1) {   //赠送积分
                    $luckgoods['integral'] = $integral[$k];
                } else {   //赠送产品
                    $luckgoods['goods_id'] = $goodsid[$k];
                    $goods = M("goods")->where(array('id' => $luckgoods['goods_id']))->field('goods_name,logo_pic')->find();
                    $luckgoods['goods_name'] = $goods['goods_name'];
                    $luckgoods['goods_pic'] = $goods['logo_pic'];
                }
                $luckgoods['luck_class']    = $val;
                $luckgoods['luck_id']       = $res;
                $luckgoods['probability']   = round(floatval($probability[$k]),2);
                $res1 = M("luck_goods")->add($luckgoods);
                if (!$res1) {
                    $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
                }
            }
            $this->ajaxReturn(array('status' => 1, 'info' => '创建成功'));
        }
        $goods_list = M("goods")->where(array('is_sale' => 1, 'isdel' => 0))->field("id,goods_name,logo_pic,price")->select();
        $this->assign('goods_list', $goods_list);
        $this->display();
    }


    /**
     * 活动的启用与禁用 1启动 2禁用
     */
    public function Enable() {
        $status = I('post.status');
        $id = I('post.id');
        if($status==1){
            $end_time = M('luck')->where('id='.$id)->getField("end_time");
            if (NOW_TIME >= $end_time) {
                $this->ajaxReturn(array('status' => 3, 'info' => '当前已超出结束时间，无法启用'));//失败
            }
            M('luck')->save(array("status"=>2));
            $data['status']=1;
            $re=M('luck')->where('id='.$id)->save($data);           
            if($re){
                $this->ajaxReturn(array('status' => 1, 'info' => '启用成功'));//成功
            }else{
                $this->ajaxReturn(array('status' => 3, 'info' => '操作失败'));//失败
            }
        }else{
            $data['status']=2;
            $re=M('luck')->where('id='.$id)->save($data);
            if($re){
                $this->ajaxReturn(array('status' => 2, 'info' => '禁用成功'));//成功
            }else{
                $this->ajaxReturn(array('status' => 3, 'info' => '操作失败'));//失败
            }
        }
    }


    /**
     * 生成中奖名单
     */
    public function luckExport(){
        $id = I('get.id');
        $map['u.luck_id']  = $id;
        $map['u.type']  = array('neq',0);
        $luckuser=M('user_luck')->field('u.*,m.realname,l.title')->alias('u')->join('left join app_member m ON u.user_id = m.id')
                                ->join('left join app_luck l ON u.luck_id = l.id')
                                 ->where($map)->select();
//        echo "<pre>";
//        var_dump($luckuser);exit;
        //$this->ajaxReturn($luckuser);
        //导入phpexcel类方法
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $objPHPExcel = new \PHPExcel();
        // Set properties
        $objPHPExcel->getProperties()->setCreator("ctos")
            ->setLastModifiedBy("ctos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        //set width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);       

        //设置行高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

        //set font size bold
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(16);
        /*$objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:M2')->getBorders()->getAllBorders()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);*/

        //设置水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //合并cell
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');

        // set table header content
        $objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A1', $luckuser[0]['title'])
            ->setCellValue('A2', '序号')
            ->setCellValue('B2', '用户姓名')
            ->setCellValue('C2', '中奖物品')
            ->setCellValue('D2', '中奖时间');           
        if (!empty($luckuser)){
            foreach($luckuser as $key=>$val){
                foreach(range('A','D') as $v){
                    //设置水平靠左
                    $objPHPExcel->getActiveSheet(0)->getStyle($v.($key+3))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    //设置垂直居中
                    $objPHPExcel->setActiveSheetIndex(0)->getStyle($v.($key+3))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }
                $objPHPExcel->getActiveSheet(0)->setCellValue('A'.($key+3), $key+1);
                $objPHPExcel->getActiveSheet(0)->setCellValue('B'.($key+3), $val['realname']);
                if($val['type'] == 1){
                    $objPHPExcel->getActiveSheet(0)->setCellValue('C'.($key+3), $val['integral'].'积分');
                }else{
                    $objPHPExcel->getActiveSheet(0)->setCellValue('C'.($key+3), $val['goods_name']);
                }                
                $objPHPExcel->getActiveSheet(0)->setCellValue('D'.($key+3), date('Y-m-d H:i:s',$val['luck_time']));               
            }
        }
        //  sheet命名
        $objPHPExcel->getActiveSheet()->setTitle('中奖者公告');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        // excel头参数
        //header('Content-Type: application/vnd.ms-excel');
        //header('Content-Disposition: attachment;filename="中奖者公告.xls"');  //日期为文件名后缀
        //header('Cache-Control: max-age=0');
        //ob_clean();//关键
        //flush();//关键
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  //excel5为xls格式，excel2007为xlsx格式
        $savepath='./Uploads/Picture/uploads/'.date('Ymd').'/';
        if (!file_exists($savepath)){
            mkdir($savepath);
        }
        $filename = $savepath.uniqid().'.xls';
        $objWriter->save($filename);
        $luck=M('luck')->find($id);
        $data=array();
        if(!empty($luck['notice'])){
            unlink('.'.$luck['notice']);
        }
        $data['notice']=ltrim($filename,'.');
        M('luck')->where('id='.$id)->save($data);
        echo '<script language="javascript" type="text/javascript">alert("生成成功");history.go(-1)</script>';
        exit;
    }
    /**
     *
     * 抽奖规则列表1500566400
     *
     */
    public function lucklist() {
        if (IS_AJAX) {
            $this->ajaxReturn(array('status' => 1, 'info' => '创建成功'));
        }
        $time=  time();
        $luck_list = M("luck")->select();
        foreach ($luck_list as $k => $v) {
            if($v['end_time']<$time){
                M("luck")->where('id='.$v['id'])->save(array('status'=>2));
            }
        }
        $this->assign('luck_list', $luck_list);
        $this->assign('time',$time);
        $this->display();
    }

    /**
     * 抽奖规则详情
     *
     */
    public function luckdetail() {
        if (IS_AJAX) {
            $this->ajaxReturn(array('status' => 1, 'info' => '创建成功'));
        }
        $id = I("param.id");
        $luck = M("luck")->find($id);
        $detail = M("luck_goods")->where(array('luck_id' => $id))->select();
        $this->assign('luck', $luck);
        $this->assign('detail', $detail);
        $this->display();
    }
    //评价设置
    public function comment(){
        if(IS_POST){
            $d = I('post.');
            $data['user_one'] = $d['user'];
            $data['pic_one']  = $d['logo_pic'];
            $data['content_one'] = $d['content'];
            $data['user_two'] = $d['user1'];
            $data['pic_two'] = $d['index_pic'];
            $data['content_two'] = $d['content1'];
            $data['add_time_one'] = time();
            $data['add_time_two'] = time();
            $data['id'] = 1;
            $res = M('activity_comment')->save($data);
            if($res){
                $this->redirect('Admin/Activity/comment');
            }else{
                $this->error('Admin/Activity/comment');
            }
        }
        $comment = M('activity_comment')->where('id=1')->find();
        $this->assign('cache',$comment);
        $this->display();
    }

}
