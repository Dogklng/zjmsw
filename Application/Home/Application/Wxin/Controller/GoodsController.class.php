<?php
namespace Wxin\Controller;

use Think\Controller;

class GoodsController extends BaseController
{
    //商品模块
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',1);
    }

    public function addGoods(){
        $this->display();
    }
    public function hall(){
        $cate_id = I('get.cate_id');

        $screens = M('series')->where(array('isdel'=>0,'cstores'=>0))->select();
        if(!$cate_id){
            $count = M('third')->count();
            $Page  = getpage($count,6);
            $show  = $Page->show();//分页显示输出
            $res = M('third')->order('id desc')->limit($Page->firstRow,$Page->listRows)->select();
        }else{
            $count = M('third')->where(array('series_id'=>$cate_id))->count();
            $Page  = getpage($count,6);
            $show  = $Page->show();//分页显示输出
            $res = M('third')->where(array('series_id'=>$cate_id))->order('id desc')->limit($Page->firstRow,$Page->listRows)->select();
        }


        //dump($res);exit;
        foreach($res as $k=>$v){
            $res[$k]['detail'] = mb_substr($res[$k]['detail'],0,30,'utf-8');
            $res[$k]['goods_cap'] = mb_substr($v['goods_cap'],0,20,'utf-8');
            $res[$k]['pic'] = M('third_slide')->where(array('third_id'=>$v['id']))->limit(1)->getField('pic');
        }
        $this->assign('res',$res);
        $this->assign('page',$show);

        //$this->assign('res',$res);
        $this->assign('cate_id',$cate_id);

        $this->assign('screens',$screens);
        $this->display();
    }

    public function get_hall(){
        if (IS_AJAX) {
            $cate_id = I("post.cate_id");
            $p = I("post.p");
            $_GET['p'] = $p;
            if(!$cate_id){
                $count = M('third')->count();
                $Page  = getpage($count,6);
                $res = M('third')->order('id desc')->limit($Page->firstRow,$Page->listRows)->select();
            }else{
                $count = M('third')->where(array('series_id'=>$cate_id))->count();
                $Page  = getpage($count,6);
                $res = M('third')->where(array('series_id'=>$cate_id))->order('id desc')->limit($Page->firstRow,$Page->listRows)->select();
            }
            if($res){
                $str = '';
                foreach($res as $k=>$v){
                    $str .= '<div class="prod_cont">';
                    $str .= '<p class="prod_cont_img">';
                    $str .= '<a href="/Wxin/Goods/hallDetail?id='.$v["id"].'">';
                    $str .= '<img src="'.$v['pic'].'" /></a></p>';
                    $str .= '<div class="prod_cont_text">';
                    $str .= '<h4><b>'.$v['goods_name'].'</b></span></h4>';
                    $str .= '<h4 style="color:black;" >'.$v['title'].'</h4>';
                    $str .= '<h3 >作者简介: '.$v['goods_cap'].'...</h3>';
                    $str .= '<h3 >作品简介: '.$v['detail'].'...</h3>';
                    $str .= '<div class="clear"></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
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
	
	
	 public function ztzt(){
        if($_GET['id']){
			$id=$_GET['id'];
			$res=M('third_slide')->where('third_id='.$id)->select();
			$this->assign('res',$res);
		}
        $this->display();
    }
	public function zt(){
		$this->display();
	}


}