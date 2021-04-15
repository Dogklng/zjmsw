<?php
namespace Admin\Controller;

use Common\Controller\CommonController;

class GoodsController extends CommonController {
    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function index(){

    }

    /**
     * 产品属性管理 zj
     */
    public function Attribute()
    {
        if(IS_AJAX){
            $id       = I("post.categoryid");
            $classname = I("post.classname");
            $pid       = I("post.pid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $m = M("goods_attribute");

            if(!$id){
                $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0))->find();
            }else{
                $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0,'id'=>array('neq',$id)))->find();
            }
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['create_at'] = time();
            $data['is_show']   = I('post.is_show');
            $pic && $data['pic'] = $pic;
            if(!$id){
                $res = $m->add($data);
            }else{
                $res = $m->where(array('id'=>$id))->save($data);
            }
            if($res){
                $this->ajaxReturn(array("status"=>1, "info"=>$id?"修改成功":"添加成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"操作失败！"));
            }
        }
        $m = M("goods_attribute");
        $map = array(
            "pid" => 0,
            "isdel" => 0,
        );
        $res = $m->where($map)->order("sort desc")->select();
        foreach ($res as $k => $v) {
            $res[$k]["data"] = $m->where(array("pid" => $v['id']))->select();
        }
        $this->assign('count',count($res));
        $this->assign("cache", $res);
        $this->assign("cate", $res);
        $this->assign("comptype", 1);
        $this->display();
    }

    /**
     * 删除属性 zj
     */
    public function Del_Attribute()
    {
        $id  = $_GET['id'];
        $m = M("goods_attribute");
        $data = $m->where(array('pid'=>$id))->find();
        $res = $m->where(array("id"=>$id))->delete();
        if($data){
            $res1 = $m->where(array('pid'=>$id))->delete();
            if($res && $res1){
                $this->success("删除成功！");die;
            }
        }else{
            if($res){
                $this->success("删除成功！");die;
            }
        }
        $this->error("删除失败！");die;
    }

    public function active(){
        $res = M('goods_active')->select();
        foreach ($res as $k=>$v){
            $goods = M('goods')->where(array('goods_id'=>$v['id']))->select();
            $res[$k]['goods_name'] = $goods[$k]['goods_name'];
        }
        $this->assign('res',$res);
        $this->display();
    }

    public function addActive(){
        if(IS_POST){
            $data = I('post.');
            $data['goods_id'] = implode(',',$data['goods_name']);
            $data['start'] = strtotime($_POST['start']);
            $data['end'] = strtotime($_POST['end']);

            $res = M('goods_active')->add($data);
            if($res){
                $this->success("添加成功!", U('Admin/Goods/active', '', false));exit;
            }else{
                $this->error("添加失败", U('Admin/Goods/active', '', false));exit;
            }
        }
        $goods_name = M('goods')->where(array('is_del'=>0))->select();
        $this->assign('goods_name',$goods_name);
        $this->display();
    }

    public function editActive(){
        if (IS_POST) {
            $m                  = M("goods_active");
            $data               = I("post.");
            $data['goods_id']    = implode(',',$data['goods_id']);
            $data['start'] = strtotime($_POST['start']);
            $data['end'] = strtotime($_POST['end']);
            $id                 = $data['id'];

            $res = $m->where(array("id"=>$id,'isdel'=>0))->save($data);
            if($res){
                $this->success("编辑成功!", U('Admin/Goods/active', '', false));exit;
            }
            else {
                $this->error("编辑失败！",U('Admin/goods/active'));
            }
        }

        $id = I("id");

        $goods_active = M("goods_active")->where(array('id'=>$id))->find();

        $c                  = M("goods");
        $goods_active['classname'] = $c->where(array('id'=>$goods_active['goods_id'],'isdel'=>0))->getField('goods_name');
        $categorylist = $c->where(array("is_pm"=>1, "isdel"=>0))->order('sort asc')->select();
        foreach ($categorylist as $k => $v) {
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id']))->order('sort asc')->select();
        }

        $this->assign("cache", $goods_active);
        $this->assign("categorylist", $categorylist);

        $this->display();
    }


    /**
     * 删除
     */
    public function delActive(){
        $id  = $_GET['id'];
        $res = M("goods_active")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }

    /*
     * 服务保障
     */
    public function service(){
        if (IS_POST) {
            $edit_notice = M("goods_service");

            $count = $edit_notice->count();


            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("添加成功!", U('Admin/Goods/service', '', false));exit;
                }else{
                    $this->error("添加失败", U('Admin/Goods/service', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Goods/service', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Goods/service', '', false));exit;
                }
            }
        }

        $id= M('goods_service')->getField('id');

        $res = M("goods_service")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*
     * 保障金
     */
    public function baozhangjin(){
        if (IS_POST) {
            $edit_notice = M("goods_bz");

            $count = $edit_notice->count();


            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("添加成功!", U('Admin/Goods/baozhangjin', '', false));exit;
                }else{
                    $this->error("添加失败", U('Admin/Goods/baozhangjin', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Goods/baozhangjin', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Goods/baozhangjin', '', false));exit;
                }
            }
        }

        $id= M('goods_bz')->getField('id');

        $res = M("goods_bz")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }
    /*
     * 友情提醒
     */
    public function remind(){
        if (IS_POST) {
            $edit_notice = M("goods_remind");

            $count = $edit_notice->count();


            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("添加成功!", U('Admin/Goods/remind', '', false));exit;
                }else{
                    $this->error("添加失败", U('Admin/Goods/remind', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Goods/remind', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Goods/remind', '', false));exit;
                }
            }
        }

        $id= M('goods_remind')->getField('id');

        $res = M("goods_remind")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*
     * 新闻列表
     */
    public function news(){
        $is_sale = I("is_sale");
        $m = M('news');
        /*
        * 未审核
        */
        $count1=$m->where(array("shenhe"=>0))->count();
        if($is_sale==1){
            $map['shenhe'] = intval($is_sale)-1;
            $count1=$m->where($map)->count();
        }

        /*
         * 审核通过
         */
        $count2=$m->where(array( "shenhe"=>1))->count();
        if($is_sale==2){
            $map['shenhe'] = intval($is_sale)-1;
            $count2=$m->where($map)->count();
        }

        /*
        * 审核拒绝
        */
        $count3=$m->where(array( "shenhe"=>2))->count();
        if($is_sale==3){
            $map['shenhe'] = intval($is_sale)-1;
            $count3=$m->where($map)->count();
        }

        $count=$m->where($map)->count();
        $countss = $m->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("page",$show);
        $this->assign("count1",$count1);
        $this->assign("count2",$count2 );
        $this->assign("count3",$count3 );
        $this->assign("counts", $countss);//全部
        $this->assign('res',$res);
        $this->display();
    }

    public function agree1(){
        $res = M('news')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核通过失败！"));
        }
    }

    public function disagree1(){
        $res = M('news')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'shenhe_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    /**
     * 分类列表
     */
    public function cateList(){
        $m   = M("cate");
        $count = $m->group('classname')->where(array( "pid"=>0, "isdel"=>0))->count();

        $Page    = getpage($count,10);
        $show    = $Page->show();
        $res = $m->where(array("pid"=>0, "isdel"=>0))->group('classname')->limit($Page->firstRow.','.$Page->listRows)->order("sort asc")->select();           //获取每页数据

        $cate = $m->where(array("pid"=>0, "isdel"=>0))->group('classname')->order("sort Asc")->field("id,classname,pic")->select();
        foreach($res as $k=>$v){
            $res[$k]["data"] = $m->where(array("pid"=>$v['id'], "isdel"=>0))->group('classname')->order("sort Asc")->select();
        }
        $this->assign("page",  $show);
        $this->assign("cache", $res);
        $this->assign("cate",  $cate);
        $this->display();

    }

    public function addNews(){
        if(IS_AJAX) {
            $data1 = I('post.');
            if (!$data1['content']) {
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写新闻详情！';
                $this->ajaxReturn($dataAj);
                die;
            }

            $m      = M("news");
            $data   = I("post.");
            $data['show_id'] = $data['display'];
            $data['addtime'] = strtotime(I('post.addtime'));
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                $this->ajaxReturn($dataAj);
                die;
                //$this->success("新增成功！",U('Admin/goods/news'));

            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '新增失败！';
                $this->ajaxReturn($dataAj);
                die;
                //$this->error("新增失败！",U('Admin/goods/news'));
            }
            $this->redirect('Admin/goods/news');
        }
        $display = M('art_show')->where(array('is_sale'=>1))->select();
        //dump($display);
        $news_cate = M('news_cate')->select();
        $this->assign('news',$news_cate);
        $this->assign('display',$display);
        $this->display();
    }



    public function editNews(){
        if (IS_POST) {
            $m                  = M("news");
            $data               = I("post.");
            $data['show_id'] = $data['display'];
            $id                 = $_POST['id'];
            $data['addtime'] = strtotime(I('post.addtime'));
            $new = $m->where($data)->find();
            if($new){
                $this->error("内容未做修改！",U('Admin/goods/news'));
            }
            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $this->success("修改成功！",U('Admin/goods/news'));
            } else {
                $this->error("修改失败！",U('Admin/goods/news'));
            }
            $this->redirect('Admin/goods/news');
        }
        $display = M('art_show')->where(array('is_sale'=>1))->select();
        //dump($display);exit;
        $res = M('news')->where(array('id'=>$_GET['id']))->find();
        //dump($res);exit;
        $this->assign('res',$res);
        $this->assign('display',$display);

        $news_cate = M('news_cate')->select();
        $this->assign('news',$news_cate);
        $this->display();
    }

    public function deleteNews(){
        $id  = $_GET['id'];
        $res = M("news")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }

    public function changeNewsStatus(){
        if(IS_AJAX){
            $id = I("id");
            $type = I('post.type');
            $m = M("news");
            $res = $m->where("id=$id")->field("id,status,is_show")->find();
            if($res){
                if($type=='is_show'){
                    $res['is_show'] = $res['is_show']==1?0:1;
                }else{
                    $res['status'] = $res['status']==1?0:1;
                }

                $res2 = $m->save($res);
                if($res2){
                    $arr = array("显示","隐藏");
                    $return = array(
                        "status" => 1,
                        "info" => $arr[$res['status']]
                    );
                }else{
                    $return = array(
                        "status" => 0
                    );
                }
            }else{
                $return = array(
                    "status" => 2
                );
            }
            $this->ajaxReturn($return);
        }
    }

    //新闻分类
    public function newsCate(){
        $res = M('news_cate')->select();
        $this->assign('res',$res);
        $this->display();
    }

    public function addNewsCate(){
        $name = I('post.name');
        $sort = I('post.sort');
        $ename = I('post.ename');

        $res = M('news_cate')->where(array('name'=>$name))->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['name'] = $name;
        $data['ename'] = $ename;
        $data['sort']      = $sort;
        $data['create_at'] = time();
        $res = M('news_cate')->add($data);
        if($res){
            $this->ajaxReturn(array("status"=>1, "info"=>"增加成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"新增失败！"));
        }
    }

    public function editNewsCate(){
        $m = M("news_cate");
        $map = array(
            "name" => $_POST['name'],
            "id"        => array("neq", $_POST['id']),
        );
        $res = $m->where($map)->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['name'] = $_POST['name'];
        $data['ename'] = $_POST['ename'];
        $data['sort'] = $_POST['sort'];
        $data['create_at'] = time();
        $res = $m->where(array('id'=>$_POST['id']))->save($data);
        if($res !== false){
            $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
        }
    }

    public function delNewsCate(){
        $res = M("news_cate")->where(array('id'=>$_GET['id']))->delete();
        if($res !== false){
            $this->success('删除成功!');
           // $this->ajaxReturn(array("status"=>1, "info"=>"删除成功！"));
        }else{
            $this->error('删除失败！');
           //$this->ajaxReturn(array("status"=>0, "info"=>"删除失败！"));
        }
    }




    /**
     * 增加分类
     */
    public function addCate(){
        if(IS_AJAX){
            $classname = I("post.classname");
            $pid       = 0;
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $m = M("cate");
            $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0))->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['create_at'] = time();
            $data['is_show']   = I('post.is_show');
            $pic && $data['pic'] = $pic;
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array("status"=>1, "info"=>"增加成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"新增失败！"));
            }
        }
    }

    /**
     * 删除分类
     */
    public function delCate(){
        $id = I("id");
        $m  = M("cate");
        $data = $m->find($id);
        if(!$data){
            $this->error("分类不存在!");
        }
        if($data['pid']){
            $res = $m->where(array("id"=>$id))->delete();
            if($res){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }else{
            $res1 = $m->where(array("id"=>$id))->delete();
            $res2 = $m->where(array("pid"=>$id))->delete();
            if($res1!==false && $res2!==false){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }
    }

    /**
     * 编辑分类
     */
    public function editCate(){

        if(IS_AJAX){

            $id        = I("post.categoryid");
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $describe1      = I("post.describe1");
            $describe4     = I("post.describe4");
            $m = M("cate");
            $map = array(
                "classname" => $classname,
                "pid"       => $pid,
                "id"        => array("neq", $id),
                "isdel"     => 0,
            );
            $res = $m->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $parid = $m->where(array("id"=>$id, "isdel"=>0))->getField("pid");
            if($parid == 0 && $pid != 0){
                $this->ajaxReturn(array("status"=>0, "info"=>"顶级分类无法改变分类！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['describe1']      = $describe1;
            $data['is_show']        = I('post.is_show');
            $pic && $data['pic'] = $pic;
            $res = $m->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
            }
        }
    }




    /**
     * 系列列表
     */
    public function seriesList(){
        $m   = M("series");
        $name = trim(I("get.name"));
        if ($name) {
            $map['classname'] = array('like',"%$name%");
            $this->assign('title',$name);
        }
        $map['isdel'] = 0;
        $map['cstores'] = 0;
        $count = $m->where($map)->count();
        $p = getpage($count, 10);
        $res = $m->where($map)->limit($p->firstRow,$p->listRows)->order("sort asc")->select();

        $this->assign("page",  $p->show());

        $this->assign("cache", $res);
        $this->display();
    }

    /**
     * 增加系列分类
     */
    public function addSeries(){
        if(IS_AJAX){
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            //$cstores      = I("post.cstores");
            $m = M("series");
            $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0))->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['cstores']      = 0;
            $data['create_at'] = time();
            $pic && $data['pic'] = $pic;
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array("status"=>1, "info"=>"增加成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"新增失败！"));
            }
        }
    }

    /**
     * 删除系列分类
     */
    public function delSeries(){
        $id = I("id");
        $m  = M("series");
        $data = $m->find($id);
        if(!$data){
            $this->error("分类不存在!");
        }
        if($data['pid']){
            $res = $m->where(array("id"=>$id))->setField("isdel", 1);
            if($res){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }else{
            $res1 = $m->where(array("id"=>$id))->setField("isdel", 1);
            $res2 = $m->where(array("pid"=>$id))->setField("isdel", 1);
            if($res1!==false && $res2!==false){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }
    }

    /**
     * 编辑系列分类
     */
    public function editSeries(){
        if(IS_AJAX){
            $id        = I("post.seriesgoryid");
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            //$cstores      = I("post.cstores");
            $wxin_title1      = I("post.wxin_title1");
            $wxin_title2      = I("post.wxin_title2");
            $m = M("series");
            $map = array(
                "classname" => $classname,
                "pid"       => $pid,
                "id"        => array("neq", $id),
                "isdel"     => 0,
            );
            $res = $m->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $parid = $m->where(array("id"=>$id, "isdel"=>0))->getField("pid");
            if($parid == 0 && $pid != 0){
                $this->ajaxReturn(array("status"=>0, "info"=>"顶级分类无法改变分类！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['cstores']      = 0;
            $pic && $data['pic'] = $pic;
            $data["wxin_title1"] = $wxin_title1;
            $data["wxin_title2"] = $wxin_title2;

            $res = $m->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
            }
        }
    }

    /**
     * sku列表
     */
    public function skuList(){
        $m   = M("skuAttr");
        //$count = $m->where(array("pid"=>0, "isdel"=>0))->count();
        //$p = getpage($count, 3);
        $res = $m->where(array("pid"=>0, "isdel"=>0))->
        // limit($p->firstRow,$p->listRows)->
        order("sort desc")->select();
        $cate = $m->where(array("pid"=>0, "isdel"=>0))->order("sort desc")->field("id,classname")->select();
        foreach($res as $k=>$v){
            $res[$k]["data"] = $m->where(array("pid"=>$v['id'], "isdel"=>0))->select();
        }
        // $this->assign("page",  $p->show());
        $this->assign("cache", $res);
        $this->assign("cate",  $cate);
        $this->display();
    }

    /**
     * 增加sku
     */
    public function addSku(){
        if(IS_AJAX){
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $sort      = I("post.sort");
            $m = M("skuAttr");
            $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0))->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['create_at'] = time();
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array("status"=>1, "info"=>"增加成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"新增失败！"));
            }
        }
    }

    /**
     * 删除sku
     */
    public function delSku(){
        $id = I("id");
        $m  = M("skuAttr");
        $data = $m->find($id);
        if(!$data){
            $this->error("sku不存在!");
        }
        if($data['pid']){
            $res = $m->where(array("id"=>$id))->setField("isdel", 1);
            if($res){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }else{
            $res1 = $m->where(array("id"=>$id))->setField("isdel", 1);
            $res2 = $m->where(array("pid"=>$id))->setField("isdel", 1);
            if($res1!==false && $res2!==false){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }
    }

    /**
     * 编辑sku
     */
    public function editSku(){
        if(IS_AJAX){
            $id        = I("post.categoryid");
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $sort      = I("post.sort");
            $m = M("skuAttr");
            $map = array(
                "classname" => $classname,
                "pid"       => $pid,
                "id"        => array("neq", $id),
            );
            $res = $m->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $parid = $m->where(array("id"=>$id, "isdel"=>0))->getField("pid");
            if($parid == 0 && $pid != 0){
                $this->ajaxReturn(array("status"=>0, "info"=>"顶级sku无法改变sku！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $res = $m->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
            }
        }
    }



    /**
     * 产品列表
     */
    public function goodsList(){
        $cate_id=I('get.cate_id');
        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询分类
        if($cate_id){
            $pid=M('cate')->where(array('id'=>$cate_id))->getfield('pid');
            if(!$pid)
            {
                $arr=M('cate')->where(array('pid'=>$cate_id))->getfield('id',true);
                $map['cate_id'] = array('in',$arr);
            }else{
                $map['cate_id'] = $cate_id;
            }
        }
        //查询商品名称
        if($name)
        {
            $map['goods_name'] = array('like',"%$name%");
        }

        $m   = M("goods");
        $map['is_del'] = 0;
        $map['cstore'] = 0;

        /*销售中*/
        $count1=$m->where(array("is_del"=>0, "is_sale"=>1,'shenhe'=>1,'cstore'=>0))->count();
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $map['shenhe'] = 1;
            //$count1 =$m->where($map)->count();
        }
        /*未销售 下架*/
        $count2=$m->where(array("is_del"=>0, "is_sale"=>0,'shenhe'=>1,'cstore'=>0))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $map['shenhe'] = intval($is_sale);
            //$count2=$m->where($map)->count();
        }

        /*
         * 未审核
         */
        $count3=$m->where(array("is_del"=>0, "shenhe"=>0,'cstore'=>0))->count();
        if($is_sale==3){
            $map['shenhe'] = intval($is_sale)-3;
            //$count3=$m->where($map)->count();
        }

        /*
         * 审核通过
         */
        $count4=$m->where(array("is_del"=>0, "shenhe"=>1,'cstore'=>0))->count();
        if($is_sale==4){
            $map['shenhe'] = intval($is_sale)-3;
            //$count4=$m->where($map)->count();
        }
        /*
         * 审核拒绝
         */
        $count5=$m->where(array("is_del"=>0, "shenhe"=>2,'cstore'=>0))->count();
        if($is_sale==5){
            $map['shenhe'] = intval($is_sale)-3;
            //$count5=$m->where($map)->count();
        }

        /*商品数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0,'cstore'=>0))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('is_groom desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach($res as $k=>$v){
            $res[$k]['classname'] = M("cate")->where(array('id'=>$v['cate_id']))->getField('classname');
        }

        foreach($res as $k=>$v){
            $res[$k]['artist_name'] = M("apply")->where(array('id'=>$v['promulgator']))->getField('name');
        }
        //dump($res);exit;

        //分类列表
        $categorylist = M("cate")->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = M("cate")->where(array('pid'=>$v['id']))->select();
        }
        $this->assign("categorylist", $categorylist);

        //系列列表
        $serieslist=M("series")->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = M("series")->where(array('pid'=>$v['id']))->select();
        }
        $this->assign("serieslist", $serieslist);

        $this->assign("page",$show);
        //$this->assign("counts", $m->where(array("isdel"=>0))->count());     //全部
        $this->assign("count1",$count1);  //出售
        $this->assign("count2",$count2 );   //未出售
        $this->assign("count3",$count3 );
        $this->assign("count4",$count4 );
        $this->assign("count5",$count5 );
        $this->assign("counts", $countss);//全部




        $this->assign("cache", $res);
        $this->display();
    }


    public function addGoodsy(){
        if(IS_AJAX){
            //所属系列 0艺术品 1创意商店
            // $s=M("series");
            // $serieslist=$s->where(array("pid"=>0, "isdel"=>0))->select();
            // foreach($serieslist as $k=>$v){
            //     $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
            // }
            $cstore = I('get.cstore');
            if($cstore === NULL){
                $dataAj['status'] = 0;
                $dataAj['info'] ='请选择系列分类';
                $this->ajaxReturn($dataAj);

            }

            $s=M("series");
            $serieslist=$s->where(array("pid"=>0, "isdel"=>0,'cstores'=>$cstore))->select();
            foreach($serieslist as $k=>$v){
                $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0,'cstores'=>$cstore))->select();
            }
            if(!$serieslist){
                $dataAj['status'] = 0;
                $dataAj['info'] ='请选择系列分类';
                $this->ajaxReturn($dataAj);
            }
            $dataAj['status'] = 1;
            $dataAj['info'] = $serieslist;
            $this->ajaxReturn($dataAj);

        }
    }

    /**
     * 新增产品
     */
    public function addGoods()
    {

        if (IS_AJAX){
            $data1 = I('post.');

            /*if(!$data1['logo_pic']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作者头像！';
                $this->ajaxReturn($dataAj);die;
            }*/


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

            /*if(!$data1['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写作者简介！';
                $this->ajaxReturn($dataAj);die;
            }*/


            $m      = M("goods");
            $g_s_m  = M("goodsSlide");
            $data   = I("post.");
            $data['weight'] = $data['weight']/1000;
            $data['price'] = $data['price']?$data['price']:$data['b_price'];
            $data['oprice'] = $data['oprice']?$data['oprice']:0;
            /*$goods_list=I('param.goods_list');
            $goods_care=I('param.goods_care');
            $year=date('Y',strtotime($goods_list));
            if((int)$year<(int)$goods_care){
                $dataAj['info'] = '创作时间不能晚于上架时间！';
                $dataAj['status'] = 0;
                $this->ajaxReturn($dataAj);die;
                //$this->error("创作时间不能晚于上架时间！");exit;
            }*/
            //保存产品属性 zj
            $attrList = $data['attr_id'];
            unset($data['attr_id']);
            $attr_list = '';
            foreach ($attrList as $val){
                $attr_list .= $val.',';
            }
            $data['attr_list'] = $attr_list;
            //保存产品属性 zj
            $data['start'] = strtotime(date("Y-m-d H:i:s"));
            $data['end'] = strtotime(date("Y-m-d H:i:s"));
            $data['cate_id'] = implode(',',$data['cate_id']);
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
        $c    = M("cate");
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->group('classname')->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("categorylist", $categorylist);


        $s=M("series");
        $serieslist=$s->where(array("pid"=>0,'cstores'=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        header('Content-Type:text/html;charset=utf-8;');
        $this->assign('serieslist',$serieslist);
        //print_r($serieslist);

        //print_r($serieslist);
        //产品属性选择  zj
        $mm = M("goods_attribute");
        $map = array(
            "pid" => 0,
            "isdel" => 0,
            "type" => 1,
        );
        $attr = $mm->where($map)->order("sort desc")->select();
        foreach ($attr as $k => $v) {
            $attr[$k]["data"] = $mm->where(array("pid" => $v['id']))->select();
        }
        $this->assign("attr", $attr);
        //产品属性选择 zj
        $this->assign("serieslist", $serieslist);
        $this->display();
    }

    /**
     * 编辑产品
     */
    public function editGoods()
    {
        header("Content-Type:text/html;charset=UTF-8;");
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
            /*$goods_list=I('param.goods_list');
            $goods_care=I('param.goods_care');
            $year=date('Y',strtotime($goods_list));
            if((int)$year<(int)$goods_care){
                $dataAj['info'] = '创作时间不能晚于上架时间！';
                $dataAj['status'] = 0;
                $this->ajaxReturn($dataAj);die;
                //$this->error("创作时间不能晚于上架时间！");exit;
            }*/
            //print_r($data);exit;
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
            $attrList = $data['attr_id'];
            unset($data['attr_id']);
            foreach ($attrList as $val){
                $attr_list .= $val.',';
            }
            $data['attr_list'] = $attr_list;
            $data['cstore'] = 0;//0艺术品1创意商店

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
        $goods['attr_list'] = explode(',',$goods['attr_list']);
        //print_r($goods);exit;
        $c                  = M("cate");
        $goods['classname'] = $c->where(array('id'=>$goods['cate_id'],'isdel'=>0))->getField('classname');
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->group('classname')->order('sort asc')->select();
        foreach ($categorylist as $k => $v) {
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id']))->group('classname')->order('sort asc')->select();
        }

        $s                      = M("series");
        $goods['seriesname']    = $s->where(array('id'=>$goods['series_id'],'isdel'=>0))->getField('classname');
        $serieslist = $s->where(array("pid"=>0,'cstores'=>0, "isdel"=>0))->order('sort asc')->select();
        foreach ($serieslist as $k => $v) {
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->order('sort asc')->select();
        }
        $this->assign("serieslist", $serieslist);
        $goods_slide = M("goodsSlide")->where(array('goods_id'=>$id, "status"=>1,'isdel'=>0))->select();
        $this->assign("goods_slide", $goods_slide);
       // dump($goods);exit;
        $this->assign("cache", $goods);
        $this->assign("categorylist", $categorylist);
        //产品属性选择  zj
        $mm = M("goods_attribute");
        $map = array(
            "pid" => 0,
            "isdel" => 0,
            "type" => 1,
        );
        $attr = $mm->where($map)->order("sort desc")->select();
        foreach ($attr as $k => $v) {
            $attr[$k]["data"] = $mm->where(array("pid" => $v['id']))->select();
        }
        $this->assign("attr", $attr);
        //产品属性选择 zj
        $this->display();
    }

    /**
     * 删除商品轮播图
     */
    public function delGoodsSlide()
    {
        if(IS_AJAX){
            $id  = I("id");
            $res = M("goods_slide")->where(array('id'=>$id))->save(array("status"=>0));
            if ($res) {
                $this->ajaxReturn(array('status'=>1, "info"=>"删除图片成功！"));
            } else {
                $this->ajaxReturn(array('status'=>0, "info"=>"删除图片失败！"));
            }
        }
    }


    /**
     * 删除产品
     */
    public function delGoods(){
        $id  = $_GET['id'];
        $res = M("goods")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }

    public function agree(){
        $res = M('goods')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核通过失败！"));
        }
    }

    public function disagree(){
        $res = M('goods')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    /**
     * 修改商品部分状态
     */
    public function changeStatus(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("goods");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }
            if($item == "is_sale"){
                if ($res[$item] == 0) {
                    $m->where(array("id"=>$id))->setField('goods_list',time());
                }
                $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));
                if(!$res2){
                    $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
                }else{
                    $this->ajaxReturn(array("status"=>1 ,"info"=>"操作成功！"));
                }
            }
            //$res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res['is_show'] == 1){
                $res2 = $m->where(array("id"=>$id))->setField('is_show',0);
                if($res2){
                    $this->ajaxReturn(array("status"=>2 ,"info"=>"修改成功！"));
                }
            }else{
                $res2 = $m->where(array("id"=>$id))->setField('is_show',1);
                if($res2){
                    $this->ajaxReturn(array("status"=>1 ,"info"=>"修改成功！"));
                }
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }


    /**
     * 修改选中商品部分状态
     */
    public function changeAllStatus(){
        if(IS_AJAX){
            $ids   = array_filter(explode("-", I("post.ids")));
            $item = I("post.item");
            $m    = M("goods");
            foreach($ids as $id){
                $res  = $m->where(array("id"=>$id))->find();
                if(!$res){
                    $this->ajaxReturn(array("status"=>0 ,"info"=>"部分产品修改失败！"));
                }
                if($item == "is_sku"){
                    $res3 = M("skuList")->where(array("goods_id"=>$id, "status"=>1))->count();
                    if(!$res3 || !$res['goods_sku_info']){
                        $this->ajaxReturn(array("status"=>0 ,"info"=>"部分产品修改失败！"));
                    }
                }
                $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));
                if(!$res2){
                    $sale=$m->where(array("id"=>$id))->getfield("is_sale");
                    if($sale==1)
                    {
                        $m->where(array("id"=>$id))->setField('sale_at',time());
                    }else{
                        $m->where(array("id"=>$id))->setField('sale_at',"");
                    }

                    $this->ajaxReturn(array("status"=>0 ,"info"=>"部分产品修改失败！"));
                }
            }
            $this->ajaxReturn(array("status"=>1));
        }
    }



    /**
     * 设置sku页面
     */
    public function setSKU(){
        if(!($id = I("id"))){
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $m = M("skuAttr");
        // 得到商品
        $goods = M("goods")->find($id);
        if(!$goods){
            echo "<script>alert('没有这个产品！');window.history.back();</script>";die;
        }
        $table_str = "<tr></tr>";
        $goods_skus = M("sku_list")->where(array("goods_id"=>$id, "status"=>1))->select();
        foreach($goods_skus as $k=>$v){
            $table_str .= "<tr>";
            $skus_arr = array_filter(explode("-", $v['attr_list']));
            foreach($skus_arr as $kk=>$vv){
                $table_str .= "<td class='sku-attr-data' data-id='{$vv}'>";
                $table_str .= $m->where(array('id'=>$vv))->getField("classname");
                $table_str .= "</td>";
            }
            $table_str .= "<td>库存<input name='store' value='{$v['store']}'></td>";
            $table_str .= "<td>原价<input name='oprice' value='{$v['oprice']}'></td>";
            $table_str .= "<td>现价<input name='price' value='{$v['price']}'></td>";
            $table_str .= "</tr>";
        }
        $sku   = $this->skuNameList();
        $this->assign("sku",   json_encode($sku));
        $this->assign("table", $table_str);
        $this->assign("goods_name", $goods['goods_name']);
        $this->assign("id",    $id);
        $this->assign("skuCache", $sku);
        $this->display();
    }


    /**
     * sku列表
     */
    public function skuNameList(){
        $m   = M("skuAttr");
        $res = $m->where(array('pid'=>0, "isdel"=>0))->field("id,classname")->select();
        // foreach($res as $k=>$v){
        //     $res[$k]['sku_attr'] = $m->where(array("pid"=>$v['id'], "isdel"=>0))->field("id,classname")->select();
        // }
        return $res?$res:array();
    }

    /**
     * 生成对应的sku表格
     *     得到sku的id,组合成表格
     */
    public function makeSkuTable(){
        $ids = I("ids");
        // 获取到子sku参数
        $m = M("skuAttr");
        $skuarr=array();
        $str = "<tr>";
        foreach($ids as $id){
            $skuarr[] = $m->where(array("pid"=>$id, "isdel"=>0, "status"=>1))->field("id,classname")->order("sort desc")->select();
            $str .= "<th>";
            $str .= $m->where(array('id'=>$id))->getField("classname");
            $str .= "</th>";
        }
        $str .= "<th>库存</th><th>原价</th><th>现价</th></tr>";
        $str .= makeTable(mixSku($skuarr), "<td><input name='store'></td><td><input name='oprice'></td><td><input name='price'></td>");
        exit($str);
    }

    /**
     * 保存商品对应的sku
     * 保存sku，并保存商品对应的sku选项，例如：
     *   array(
     *       "颜色" => array("1"=>"红色","2"=>"蓝色"),
     *       "尺寸" => array(3=>"S",4=>"M",5=>"L"),
     *   )
     */
    public function addGoodsSkuAttr(){
        if(IS_AJAX){
            $m        = M("skuList");
            $sku_m    = M("skuAttr");
            $sku_arr  = I("post.");
            $goods_id = $sku_arr['goods_id'];
            unset($sku_arr['goods_id']);
            // 查询旧sku，将暂时用不到的sku isdel=》1

            // 添加新的sku
            $arrs=array();
            $goods_sku_info=array();
            foreach($sku_arr as $k=>$v){
                $ids_arr = array_filter(explode("-",$v['ids']));
                sort($ids_arr);
                foreach($ids_arr as $kk=>$vv){
                    $sku_a  = $sku_m->where(array('id'=>$vv))->find();
                    $pid  = $sku_a['pid'];
                    $psku = $sku_m->where(array('id'=>$pid, "pid"=>0, "isdel"=>0))->getField("classname");
                    if(array_key_exists($psku, $goods_sku_info)){
                        $goods_sku_info[$psku][$sku_a['id']] = $sku_a['classname'];
                    }else{
                        $goods_sku_info[$psku] = array($sku_a['id']=>$sku_a['classname']);
                    }
                }
                $arrs[$k] = "-".implode("-", $ids_arr)."-";
            }
            // 得到对应pid的classname，并组成下表
            $old_sku = $m->where(array("goods_id"=>$goods_id))->select();
            $arr_keys = array_flip($arrs);
            foreach($old_sku as $k=>$v){
                if(in_array($v['attr_list'], $arrs)){
                    // 这里未做完
                    $data = array(
                        "oprice" => $sku_arr[$arr_keys[$v['attr_list']]]['oprice'],
                        "price"  => $sku_arr[$arr_keys[$v['attr_list']]]['price'],
                        "store"  => $sku_arr[$arr_keys[$v['attr_list']]]['store'],
                        "status" => 1,
                    );
                    // 这里未做完
                    $m->where(array('id'=>$v['id']))->save($data);
                    unset($sku_arr[$arr_keys[$v['attr_list']]]);
                }else{
                    $m->where(array('id'=>$v['id']))->setField("status", 0);
                }
            }
            foreach($sku_arr as $k=>$v){
                $data = array(
                    "goods_id"  => $goods_id,
                    "attr_list" => $arrs[$k],
                    "oprice"    => $v['oprice'],
                    "price"     => $v['price'],
                    "store"     => $v['store'],
                    "status"    => 1,
                );
                $m->add($data);
            }
            $goods_sku_info = serialize($goods_sku_info);
            M("goods")->where(array('id'=>$goods_id))->setField(array("goods_sku_info"=>$goods_sku_info,"is_sku"=>1));
            $this->ajaxReturn(array("status"=>1 ,"info"=>"执行成功！"));
        }
    }


    //抢购配置
    public function limitbuy()
    {
        $m=M('limitbuy_config');
        $Info=$m->where(array('id'=>1))->find();
        $this->assign('Info',$Info);
        $this->display();
    }
    public function savelimitbuy()
    {
        if(IS_AJAX){

            $data['title']=I("post.title");
            $data['starttime']=I("post.starttime", 0 ,"strtotime");
            $data['endtime']=I("post.endtime", 0 ,"strtotime");
            $data['status']=I("post.status");

            $Info=M('limitbuy_config')->where(array('id'=>1))->find();
            if($Info) {
                $res = M('limitbuy_config')->where(array('id' => 1))->save($data);
                if ($res) {
                    $this->ajaxReturn(array("status" => 1, "info" => "修改成功！"));
                }else{
                    $this->ajaxReturn(array("status" => 0, "info" => "修改失败！"));
                }
            }else{
                $res =M('limitbuy_config')->add($data);
                if ($res) {
                    $this->ajaxReturn(array("status" => 1, "info" => "修改成功！"));
                }else {
                    $this->ajaxReturn(array("status" => 0, "info" => "修改失败！"));
                }
            }
        }
    }
    /*
     * 收藏列表
     * */
    public function collection(){
        $m = M('CollectionView');
        //$collection = $m->select();
        $search = I('get.name');
        $where['is_del'] = 0;
        if($search){
            $where['goods_name'] =  array('like',"%$search%");
        }
        $count   = $m->where($where)->count();
        $Page    = getpage($count,5);
        $show    = $Page->show();//分页显示输出
        $collection = $m->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('collection desc')->select();
        $this->assign('page',$show);
        $this->assign('collection',$collection);
        $this->display();
    }

    /*
     * 删除收藏
     * */
    public function delCollection(){
        if(IS_POST){
            $id = I('post.id');
            $m = M('CollectionView');
            $idArr = explode(",",$id);
            if(count($idArr) > 1){
                $affRow = $m->where("id in (".$id.")")->setField("is_del",1);
            }else{
                $affRow = $m->where("id=".$id)->setField("is_del",1);
            }
            if($affRow){
                $this->ajaxReturn(array('status'=>1, 'info'=>'删除成功！'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'删除失败！'));
            }
        }
    }
    /*
     * 搜索
     * */
    public function goodsSearch(){
        if(IS_POST){
            $where['goods_name'] = array('like', "%".$_POST['search']."%");
            $m = M('CollectionView');
            $res = $m->where($where)->select();
        }
    }
    //评价管理
    public function evaluate(){
        //获取所有的评价列表
        $m = M('AdminDiscuss');
        $name = I('post.name');
        $this->assign('name',$name);
        if($name){
            $sql['goods_name'] = $name;
        }
        $sql['is_del'] = 2;
        $count   = $m->where($sql)->count();
        $Page    = getpage($count,10);
        $show    = $Page->show();//分页显示输出
        $discuss = $m->limit($Page->firstRow.','.$Page->listRows)->where($sql)->select();
        $this->assign('discuss',$discuss);
        $this->assign('page',$show);
        $this->display();
    }
    //评论回复
    public function Reply(){
        $discuss_id = I('post.commemt_id');
        $content    = I('post.content');
        if(!$discuss_id){
            $this->ajaxReturn(array('status'=>0,'info'=>'未知错误！'));
        }
        if(!$content){
            $this->ajaxReturn(array('status'=>0,'info'=>'请输入回复内容'));
        }
        $sql['reply_status'] = 1;
        $sql['reply']        = $content;
        $sql['level']        = $discuss_id;
        $res = M('GoodsDiscuss')->where(array('id'=>$discuss_id))->save($sql);
        if($res){
            $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
        }else{
            $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
        }
    }
    //评论详情
    public function pjxq(){
        $id = I('get.id');
        $discuss = M('GoodsDiscuss')->find($id);
        if($discuss['reply_status'] == 2){
            $huifu = M('GoodsDiscuss')->where(array('level'=>$id))->find();
        }
        $slide = M('DiscussSlide')->where(array('goods_id'=>$id))->select();
        $discuss['star'] = unserialize($discuss['star']);
        $this->assign('huifu',$huifu);
        $this->assign('slide',$slide);
        $this->assign('discuss',$discuss);
        $this->display();
    }
    //评价审批
    public function changeCommentStatus(){
        $id = I('post.id');
        $status = M('GoodsDiscuss')->find($id);
        if($status['status'] == 1){
            $res = M('GoodsDiscuss')->where(array('id'=>$id))->save(array('status'=>2));
        }else{
            $res = M('GoodsDiscuss')->where(array('id'=>$id))->save(array('status'=>1));
        }
        if($res){
            $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
        }else{
            $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
        }
    }
    public function delDiscuss(){
        $id = I('get.id');
        if(!$id){
            $this->error("未知错误");
        }
        $ress = M('GoodsDiscuss')->find($id);
        if($ress['is_del'] == 1){
            $res = M('GoodsDiscuss')->where(array('id'=>$id))->save(array('is_del'=>2));
        }else{
            $res = M('GoodsDiscuss')->where(array('id'=>$id))->save(array('is_del'=>1));
        }
        if($res){
            $this->redirect('Admin/Goods/evaluate');
        }else{
            $this->error("删除失败！");
        }
    }

    /**
     * 视屏列表
     */
    public function Video(){
        $av = M('av')->alias('a')
            ->join('left join app_video_cate b on a.cate=b.id')
            ->field('a.*,b.name')
            ->select();
        $this->assign('cache',$av);
        $this->display();
    }
    /**
     * 设置
     */
    public function setVideo(){
        if(IS_AJAX){
            $input = I('get.video');
            $output = I('get.picture');
            echo "Converting $input to $output<br />";
            $command = "ffmpeg -v 0 -y -i $input -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 $output ";
            echo "$command<br />";
            shell_exec( $command );
            return "Converted<br />";
        }
        $id = I('get.id');
        if(IS_POST){
            $data['title'] = I('post.av_title');
            $data['url'] = I('post.video');
            $data['video_name'] = I('post.video_name');
            $data['sort'] = I('post.sort');
            $data['cate'] = I('post.cate');
            if(I('post.logo_pic'))
            {
                $data['pic'] = I('post.logo_pic');
            }
            $id = I('post.id');
            //var_dump($data);die;
            if($id){
                if(!$data['url']){
                    unset($data['url']);
                }
                $data['id'] = $id;
                $res = M('av')->save($data);
            }else{
                $res = M('av')->add($data);
            }
            if($res){
                $this->redirect('/admin/index/Video');
            }else{
                $this->error('操作失败','/admin/index/Video');
            }
        }
        $res = M('video_cate')->select();
        $this->assign('res',$res);
        $av = M('av')->find($id);
        $this->assign('cache',$av);
        $this->display();
    }

    public function convertToFlv() {

    }
    /**
     * 删除
     */
    public function delVideo(){
        $id = I('post.id');
        if(!$id){
            $this->ajaxReturn(array('status'=>0, 'info'=>'参数有误'));
        }
        $res = M('av')->delete($id);
        if(!$id){
            $this->ajaxReturn(array('status'=>0, 'info'=>'删除失败'));
        }else{
            $url = M('av')->where(array('id'=>$id))->getField('url');
            $url = '.'.$url;
            unlink($url);
            $this->ajaxReturn(array('status'=>1, 'info'=>'删除成功'));
        }
    }
    /*
    * 视频分类
    */
    public function VideoCate(){
        if(IS_AJAX){
            $id = I("post.id");
            $data['name'] = I("post.name");
            $data['sort'] = I("post.sort");
            if(!$id){
                $data['add_time'] = time();
                $res = M("video_cate")->add($data);
            }else{
                $res = M("video_cate")->where(array('id'=>$id))->save($data);
            }
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>$id?'修改成功！':'添加成功！'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败！'));
            }
        }
        $res = M('video_cate')->select();
        $this->assign('res',$res);
        $this->display();
    }

    public function delVideoCate(){
        $res = M('video_cate')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'删除成功!'));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'删除失败!'));
        }
    }

    /**
     * 3D展厅列表
     */
    public function third(){
        $res = M('third')->alias('a')
            ->join('left join app_series b on a.series_id=b.id')
            ->field('a.*,b.classname')
            ->select();
        foreach($res as $k=>$v){
            $res[$k]['goods_cap'] = mb_substr($v['goods_cap'],0,30,'utf-8');
        }
        $this->assign('cache',$res);
        $this->display();
    }

    public function addThird(){
        if (IS_AJAX){
        $m      = M("third");
        $g_s_m  = M("third_slide");
        $data   = I("post.");
        //print_r($data);exit;
            if(!$data['pic1']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品切换图！';
                $this->ajaxReturn($dataAj);die;
            }

        $slide_pic = $data['pic1'];
        unset($data['pic1']);
        $data['addtime'] = NOW_TIME;
        $res = $m->add($data);
        if($res){
            foreach($slide_pic as $k=>$v){
                $slide_data = array(
                    "third_id"   => $res,
                    "sort"       => $k,
                    "create_at"  => time(),
                    "pic"        => $v,
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
        $s=M("series");
        $serieslist=$s->where(array("pid"=>0,'cstores'=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        header('Content-Type:text/html;charset=utf-8;');
        $this->assign('serieslist',$serieslist);
        $this->display();
    }

    /**
     * 编辑产品
     */
    public function editThird()
    {
        header("Content-Type:text/html;charset=UTF-8;");
        if (IS_AJAX) {
            $m                  = M("third");
            $g_s_m              = M("thirdSlide");
            $data               = I("post.");
            $id                 = $data['id'];
            $slide_pic          = $data['pic1'];
           // print_r($data);exit;
            unset($data['id']);
            unset($data['pic1']);
            $data['addtime'] = NOW_TIME;
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
                        "third_id"   => $id,
                        "sort"       => $k,
                        "addtime"  => NOW_TIME,
                        "pic"        => $v,
                    );
                    $g_s_m->add($slide_data);
                }
            } else {
                $dataAj['info'] = '修改失败！';
                $dataAj['status'] = 0;
                $this->ajaxReturn($dataAj);die;
                //$this->error("修改商品失败！",U('Admin/goods/goodslist'));
            }
            $dataAj['info'] = '修改成功！';
            $dataAj['status'] = 1;
            $this->ajaxReturn($dataAj);die;
            //$this->redirect('Admin/goods/goodslist');
        }
        $id = I("id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $goods = M("third")->where(array('id'=>$id, "isdel"=>0))->find();
        if (!$goods) {
            echo "<script>alert('无此展览！');window.history.back();</script>";die;
        }


        $s                      = M("series");
        $goods['seriesname']    = $s->where(array('id'=>$goods['series_id'],'isdel'=>0))->getField('classname');
        $serieslist = $s->where(array("pid"=>0,'cstores'=>0, "isdel"=>0))->order('sort asc')->select();
        foreach ($serieslist as $k => $v) {
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->order('sort asc')->select();
        }
        $this->assign("serieslist", $serieslist);
        $goods_slide = M("thirdSlide")->where(array('third_id'=>$id, "status"=>1,'isdel'=>0))->select();
        $this->assign("goods_slide", $goods_slide);
        $this->assign("cache", $goods);
        //产品属性选择 zj
        $this->display();
    }

    public function delThird(){
        $id = I('post.id');
        $res = M("third")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->ajaxReturn(array('id'=>1,'info'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('id'=>0,'info'=>'删除失败！'));
        }
       // $this->display();
    }

    /**
     * 删除商品轮播图
     */
    public function delThirdSlide()
    {
        if(IS_AJAX){
            $id  = I("post.id");
            $res = M("third_slide")->where(array('id'=>$id))->delete();
            if ($res) {
                $this->ajaxReturn(array('status'=>1, "info"=>"删除图片成功！"));
            } else {
                $this->ajaxReturn(array('status'=>0, "info"=>"删除图片失败！"));
            }
        }
    }

    public function canzhan(){
        $count=M('cz')->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('cz')->order('id desc')->limit($Page->firstRow.",".$Page->listRows)->select();
        foreach ($res as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $res[$k]['classname'] = $series['classname'];
        }
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function canzhanDetail(){
        $id = $_GET['id'];

        $res = M('cz')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $pic = M("cz_pic")->where(array('cz'=>$id, "status"=>1))->select();
        $this->assign("pic", $pic);
        $this->display();
    }

    public function banzhan(){
        $res = M('bz')->order('id desc')->select();
        foreach ($res as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $res[$k]['classname'] = $series['classname'];
        }
        $this->assign('res',$res);
        $this->display();
    }

    public function banzhanDetail(){
        $id = $_GET['id'];

        $res = M('bz')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    //审核通过
    public function czAgree(){
        $res = M('cz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        //$data['shenhe'] = 1;
        //$res = M('cz')->where(array('id'=>$_POST['id']))->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    //审核拒绝
    public function czDisagree(){
        $res = M('cz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    public function trainlist(){
        $train_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }
        $count=M('tel_train')->where($map)->where(array("train_id"=>$train_id,'type'=>1))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('tel_train')->where($map)->where(array("train_id"=>$train_id,'type'=>1))->limit($Page->firstRow.",".$Page->listRows)->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function showlist(){
        $show_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);

        $is_sale = I('get.is_sale');
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }

        if($is_sale){
            $map['shenhe'] = $is_sale-1;
        }
        $count=M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('cz')->where($map)->where(array("show_id"=>$show_id))->limit($Page->firstRow.",".$Page->listRows)->select();
        foreach ($res as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $res[$k]['classname'] = $series['classname'];
        }

        unset($map['shenhe']);
        $counts = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $map['shenhe']=0;
        $count1 = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $map['shenhe']=1;
        $count2 = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $map['shenhe']=2;
        $count3 = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();

        $this->assign('counts',$counts);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('count3',$count3);

        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    //观展列表
    public function exhibition(){
        $train_id = I('get.id');
        $count=M('tel_gtrain')->where(array("show_id"=>$train_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('tel_gtrain')->where(array("show_id"=>$train_id))->limit($Page->firstRow.",".$Page->listRows)->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    //展览导出
    public function indexshow(){
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = 1;
        }
        if($is_sale==1){
            $map['is_sale'] = 2;
        }
        $info = M('art_show')->where($map)->select();
        $name ="展览详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,展览标题,地点,作者,发布者,联系电话,是否上架,状态,观展人数";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['title']    = $val['title']?$val['title']:"无";
            $data['address']    = $val['address']?$val['address']:"无";
            $data['auth']      =$val['auth']?$val['auth']:"无";
            if($val['user_id']){
                $data['user_id']=$val['auth']?$val['auth']:"无";
            }else{
                $data['user_id']='平台';
            }
            $data['tel']  = $val['tel']?$val['tel']:"无";
            if($val['is_sale']==1){
                $data['is_sale']='上架';
            }else{
                $data['is_sale']='下架';
            }
            switch($val['status']){//0：，1：，2：,3:
                case 1:
                    $data['status']="待审核";
                    break;
                case 2:
                    $data['status']="审核通过";
                    break;
                case 3:
                    $data['status']='审核拒绝';
                    break;
                default:
                    $data['pay_way']='未知';
                    break;
            }
            $count = M('tel_gtrain')->where(array('show_id'=>$val['id']))->count();
            $data['gshow']  = $count?$count.'人':"0人";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    //参展导出
    public function indexcz(){
        $show_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');

        $is_sale = I('get.is_sale');
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }

        if($is_sale){
            $map['shenhe'] = $is_sale-1;
        }
        $info = M('cz')->where($map)->where(array("show_id"=>$show_id))->select();
        foreach ($info as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $info[$k]['classname'] = $series['classname'];
        }
        $info_show = M('art_show')->where(array('id'=>$show_id))->find();
        $name ="参展详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,展览标题,地点,参展姓名,作品类型,联系电话,微信,邮箱,状态,申请时间";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['title']    = $info_show['title']?$info_show['title']:"无";
            $data['address']    = $info_show['address']?$info_show['address']:"无";
            $data['name']      =$val['name']?$val['name']:"无";
            $data['classname']  = $val['classname']?$val['classname']:"无";
            $data['tel']  = $val['tel']?$val['tel']:"无";
            $data['wx']  = $val['wx']?$val['wx']:"无";
            $data['email']  = $val['email']?$val['email']:"无";
            switch($val['shenhe']){//0：，1：，2：,3:
                case 0:
                    $data['shenhe']="待审核";
                    break;
                case 1:
                    $data['shenhe']="审核通过";
                    break;
                case 2:
                    $data['shenhe']='审核拒绝';
                    break;
                default:
                    $data['pay_way']='未知';
                    break;
            }
            $data['create_time']  = $val['create_time']?date('Y-m-d H:i:s',$val['create_time']):"无";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    /*
     * 展览
     */
    public function show(){
        $count1=M('art_show')->where(array("is_sale"=>1))->count();
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =M('art_show')->where($map)->count();
        }
        /* 下架*/
        $count2=M('art_show')->where(array("is_del"=>0, "is_sale"=>0))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=M('art_show')->where($map)->count();
        }
        $counts = M('art_show')->count();
        $count = M('art_show')->where($map)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('art_show')->where($map)->limit($Page->firstRow.",".$Page->listRows)->select();

        $this->assign('res',$res);
        $this->assign('count',$counts);
        $this->assign("count1",$count1);  //出售
        $this->assign("count2",$count2 );   //未出售
        $this->assign("page",  $show);
        $this->display();
    }

    public function editShow(){
        if (IS_AJAX){
            $m      = M("art_show");
            $data   = I("post.");

            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写作品简介！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $id                 = $_POST['id'];
            $time = time();
            if($data['end']<$time){
                $data['now_status']=2;
            }elseif($data['start']<$time && $time<$data['end']){
                $data['now_status']=1;
            }

            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '修改成功！';
                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '修改失败！';
            $this->ajaxReturn($dataAj);die;
            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        $res = M('art_show')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }

    public function changeStatus2(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("art_show");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $sale=$m->where(array("id"=>$id))->getfield("is_sale");
                if($sale==1)
                {
                    $m->where(array("id"=>$id))->setField('sale_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('sale_at'."");
                }
                $arr = array(1,2);
                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }

    public function addShow(){
        if (IS_AJAX){
            $m      = M("art_show");
            $data   = I("post.");

            if(!$data['logo']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传logo图片！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data['detail_img']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品展示图！';
                $this->ajaxReturn($dataAj);die;
            }


            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写作品简介！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['create_time'] = time();
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '新增失败！';
            $this->ajaxReturn($dataAj);die;
            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        $this->display();
    }

    public function agreeOne(){
        $res = M('art_show')->where(array('id'=>$_POST['id']))->save(array('status'=>2));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function disagreeOne(){
        $res = M('art_show')->where(array('id'=>$_POST['id']))->save(array('status'=>3,'reason'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    public function delShow(){
        $id  = $_GET['id'];
        $res = M("art_show")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
}