<?php
namespace Home\Controller;

use Think\Controller;

class GoodsController extends BaseController
{
    //商品模块
    public function __construct()
    {
        parent::__construct();
    }

    public function addGoods(){
        $this->display();
    }
    public function hall(){
        $cate_id = I('get.cate_id');

        $screens = M('series')->where(array('isdel'=>0,'cstores'=>0))->select();
       /* if(!$cate_id){
            $cate_id = $screens[0]['id'];
        }
        $res = M('third')->where(array('series_id'=>$cate_id))->order('id desc')->select();*/

        if(!$cate_id){
            $res = M('third')->order('id desc')->select();
        }else{
            $res = M('third')->where(array('series_id'=>$cate_id))->order('id desc')->select();
        }


        //dump($res);exit;
        foreach($res as $k=>$v){
            $res[$k]['detail'] = mb_substr($res[$k]['detail'],0,30,'utf-8');
            $res[$k]['goods_cap'] = mb_substr($v['goods_cap'],0,20,'utf-8');
            $res[$k]['pic'] = M('third_slide')->where(array('third_id'=>$v['id']))->limit(1)->getField('pic');
        }

        $count =count($res);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $res = $ArrayObj->page_array($res,0);//数组分页
        $this->assign('res',$res);
        $this->assign('page',$page);

        //$this->assign('res',$res);
        $this->assign('cate_id',$cate_id);

        $this->assign('screens',$screens);
        $this->display();
    }

    public function thirdHall(){
        $id = I('get.id');
        $res = M('third')->where(array('id'=>$id))->find();

            $res['detail'] = mb_substr($res['detail'],0,30,'utf-8');

        //dump($res);exit;
        $pic = M('third_slide')->where(array('third_id'=>$id))->field('pic')->select();
        //$pic = json_encode($pic);

        $pics='';
        foreach ($pic as $k=>$v){
            $pics[$k] = $v['pic'];
        }

        //$pics = json_encode($pics);

        $count = count($pics);
        //dump($pics);exit;
        $this->assign('res',$res);
        $this->assign('pic',$pics);
        $this->assign('count',$count);
        $this->display();
    }

    public function hallDetail(){
        $id = $_GET['id'];
        $res = M('third')->where(array('id'=>$id))->find();
        $res['img'] = M('third_slide')->where(array('third_id'=>$res['id']))->limit(1)->getField('pic');
        $res['classname'] = M('series')->where(array('id'=>$res['series_id']))->getField('classname');
        $this->assign('res',$res);
        $this->display();
    }


}