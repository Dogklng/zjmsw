<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class CstoreController extends CommonController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function store(){
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
        $map['cstore'] = 1;

        /*销售中*/
        $count1=$m->where(array("is_del"=>0, "is_sale"=>1,'cstore'=>1))->count();
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =$m->where($map)->count();
        }
        /*未销售 下架*/
        $count2=$m->where(array("is_del"=>0, "is_sale"=>0,'cstore'=>1))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=$m->where($map)->count();
        }
//加的
		/*待审核*/
		$count3=$m->where(array("is_del"=>0,"shenhe"=>0,"cstore"=>1))->count();
		if($is_sale==3){
			//$map['is_sale'] = intval($is_sale)-1;
			$map['is_del'] = 0;
			$map['shenhe'] = 0;
			$map['cstore'] = 1;
			$count3=$m->where($map)->count();
		}
		/*审核通过*/
		$count4=$m->where(array("is_del"=>0,"shenhe"=>1,"cstore"=>1))->count();
		if($is_sale==4){
			//$map['is_sale'] = intval($is_sale)-1;
			$map['is_del'] = 0;
			$map['shenhe'] = 1;
			$map['cstore'] = 1;
			$count4=$m->where($map)->count();
		}
		/*审核拒绝*/
		$count5=$m->where(array("is_del"=>0,"shenhe"=>2,"cstore"=>1))->count();
		if($is_sale==5){
			//$map['is_sale'] = intval($is_sale)-1;
			$map['is_del'] = 0;
			$map['shenhe'] = 2;
			$map['cstore'] = 1;
			$count5=$m->where($map)->count();
		}
//
        /*商品数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0,'cstore'=>1))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('is_groom desc,is_sale desc,id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach($res as $k=>$v){
            $res[$k]['classname'] = M("cate")->where(array('id'=>$v['cate_id']))->getField('classname');
        }

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
        $this->assign("count3",$count3 );   //待审核
        $this->assign("count4",$count4 );   //审核通过
        $this->assign("count5",$count5 );   //审核拒绝
        $this->assign("counts", $countss);//全部




        $this->assign("cache", $res);
        $this->display();
    }
	//审核通过
   public function agree(){
		$res = M('goods')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1,'disagree_detail'=>$_POST['disagree_detail']));
		if($res){
			$this->ajaxReturn(array('status'=>1, "info"=>"审核通过成功！"));
		}else{
			$this->ajaxReturn(array('status'=>0, "info"=>"审核通过失败！"));
		}
	}
	//审核拒绝
    public function disagree(){
        $res = M('goods')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    public function addStore(){
        if(IS_AJAX){
            $data1 = I('post.');


            if(!$data1['index_pic']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作品展示图必传！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data1['pic1']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作品切换图必传！';
                $this->ajaxReturn($dataAj);die;
            }

            /*if(!$data1['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作者简介必填！';
                $this->ajaxReturn($dataAj);die;
            }*/


            $m      = M("goods");
            $g_s_m  = M("goodsSlide");
            $data   = I("post.");
            //保存产品属性 zj
            $attrList = $data['attr_id'];
            //dump($data);exit;
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
            $data['weight'] = $data['weight']/1000;
            $slide_pic = $data['pic1'];
            if (I("post.is_sale")) {
                $data['sale_at'] = NOW_TIME;
            }
            //$data['is_like'] =
            unset($data['pic1']);
            $data['create_at'] = NOW_TIME;
            $data['cstore'] = 1;
            $data['is_groom'] = 1;
            $data['shenhe'] = 1;
            //print_r($data);exit;
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
                //$this->error("新增产品失败！",U('Admin/Cstore/store'));
            }
            $dataAj['status'] = 1;
            $dataAj['info'] = '新增产品成功！';
            $this->ajaxReturn($dataAj);die;
            //$this->redirect('Admin/Cstore/store');
        }
        $c    = M("cate");
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->group('classname')->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("categorylist", $categorylist);
        $s=M("series");
        $serieslist=$s->where(array("pid"=>0, "isdel"=>0,'cstores'=>1))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0,'cstores'=>1))->select();
        }
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

    public function editStore(){
        if(IS_AJAX){
            $data1 = I('post.');

            /*if(!$data1['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作者简介必填！';
                $this->ajaxReturn($dataAj);die;
            }*/



            $m                  = M("goods");
            $g_s_m              = M("goodsSlide");
            $data               = I("post.");
            $data['cate_id']    = implode(',',$data['cate_id']);
            $id                 = $data['id'];
            $slide_pic          = $data['pic1'];
            unset($data['id']);
            unset($data['pic1']);
            $data['create_at'] = NOW_TIME;
            if (!$id) {
                $dataAj['status'] = 0;
                $dataAj['info'] = '缺少参数！';
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
            $data['is_groom'] = 1;
            $data['weight'] = $data['weight']/1000;
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
                $dataAj['status'] = 0;
                $dataAj['info'] = '修改商品失败！';
                $this->ajaxReturn($dataAj);die;
                //$this->error("修改商品失败！",U('Admin/Cstore/store'));
            }
            $dataAj['status'] = 1;
            $dataAj['info'] = '修改商品成功！';
            $this->ajaxReturn($dataAj);die;
            //$this->redirect('Admin/Cstore/store');
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
        $serieslist = $s->where(array("pid"=>0, "isdel"=>0,'cstores'=>1))->order('sort asc')->select();
        foreach ($serieslist as $k => $v) {
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0,'cstores'=>1))->order('sort asc')->select();
        }
        $this->assign("serieslist", $serieslist);
        $goods_slide = M("goodsSlide")->where(array('goods_id'=>$id, "status"=>1,'isdel'=>0))->select();
        $this->assign("goods_slide", $goods_slide);
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

    public function delStore(){
        $id  = $_GET['id'];
        $res = M("goods")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }

    // public function changeStatus(){
    //     if(IS_AJAX){
    //         $id   = I("post.id");
    //         $item = I("post.item");
    //         $m    = M("goods");
    //         $res  = $m->where(array("id"=>$id))->find();
    //         if(!$res){
    //             $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
    //         }
    //         if($item == "is_sku"){
    //             $res3 = M("skuList")->where(array("goods_id"=>$id, "status"=>1))->count();
    //             if(!$res3 || !$res['goods_sku_info']){
    //                 $this->ajaxReturn(array("status"=>0 ,"info"=>"请先设置sku！"));
    //             }
    //         }
    //         $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
    //         if($res2){
    //             $sale=$m->where(array("id"=>$id))->getfield("is_sale");
    //             if($sale==1)
    //             {
    //                 $m->where(array("id"=>$id))->setField('sale_at',time());
    //             }else{
    //                 $m->where(array("id"=>$id))->setField('sale_at'."");
    //             }
    //             $arr = array(1,2);
    //             $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
    //         }
    //         $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
    //     }
    // }
    /*
    *zqj 20171106
     */
    public function changeStatus(){
        if(IS_AJAX){
            $id   = I("post.id");
          
            $m    = M("goods");
            $res  = $m->where(array("id"=>$id,'cstore'=>1,'shenhe'=>1))->find();
            if(!$res){
                $data['status'] = 0;
                $data['info'] = '没有商品';
                $this->ajaxReturn($data);

            }
            if($res['is_sale'] == 1){
               $res2 = $m->where(array("id"=>$id,'cstore'=>1,'shenhe'=>1))->setField('is_sale',0);
                if($res2){
                    $data['status'] = 2;
                    $data['info'] = '修改成功';
                   $this->ajaxReturn($data);
                }
            }
            if($res['is_sale'] == 0){
               $res2 = $m->where(array("id"=>$id,'cstore'=>1,'shenhe'=>1))->setField('is_sale',1);
                if($res2){
                    $data['status'] = 1;
                    $data['info'] = '修改成功';
                   $this->ajaxReturn($data);
                }
            }
           
            if(!$res2){
                 $data['status'] = 2;
                $data['info'] = '修改失败';
               $this->ajaxReturn($data);
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
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
        $map['cstores'] = 1;
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
            $data['cstores']      = 1;
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
                "cstore"    => 1,
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
            $data['cstores']      = 1;
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


}
