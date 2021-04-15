<?php namespace Wxin\Controller;

use Think\Controller;

class GalleryController extends BaseController
{
	    /*
    *店铺管理
    */
    public function selCenter(){
        $user_id = $_SESSION['member_id'];
        //$owner = M('member')->where(array('id'=>$user_id))->getField('person_name');
        $sql = "select person_name,realname,telephone,card_id,email from app_member where id=$user_id";
        $owner = M()->query($sql);
        /*if(!$owner){
            $this->error('您的账号信息不够完善！',U('/Home/PersonalCenter/userInfo/id/').{$user_id});
        }*/
        $this->assign('owner',$owner);
        $this->display();
    }
       /*
    *店铺产品列表
    */
   public function dianpu(){
        header('Content-Type:text/html;charset=UTF-8;');
        $member_id = $_SESSION['member_id'];

        $m = M('artist')->where(array('member_id'=>$member_id,'shenhe'=>1))->find();
        $this->assign('artist',$m);
        $map['promulgator'] = $m['id'];
        $map['shenhe'] = 1;   //审核通过
        $map['is_del'] = 0;   //未删除
        $map['is_sale'] = 1; //上架
        $goods1 = M('goods')->where($map)->select();//店铺自己的
        //print_r($goods);
        //推荐来的商品
        $rec = M('recommend')->where(array('user_id'=>$member_id,'artist_id'=>$m['id']))->select();

        $goodids = array();
        if($rec){
            foreach($rec as $Key=>$val){
                $goodids[] = $val['good_id'];
            }
            $gd['is_del'] = 0;
            $gd['is_sale'] = 1;
            $gd['shenhe'] = 1;
            $gd['id'] = array('in',$goodids);
            // print_r($goodids);
            $goodss = M('goods')->where($gd)->select();
            //print_r($goodss);
            $this->assign('goodstj',$goodss);
        }
       
        $this->assign('goods',$goods1);
        $this->display();
   }
    public function seldpsy(){

        header('Content-Type:text/html;charset=utf-8;');
        $detail = I('get.detail');
        $status = I('get.status');

        $map['is_del'] = 0;
        $map['member_id'] = $_SESSION['member_id'];
        $map['shenhe'] = 1;
        $artists = M('artist')->where($map)->find();
        $this->assign('artists',$artists);
        unset($map);
        $map['tj_shop'] = $artists['id'];
        if($detail){
            if($detail == 6){
                //店铺订单
                $map['tj_status'] = 0; //0 否 1是推荐订单
            }else if($detail == 7){

                $map['tj_status'] = 1; //0 否 1是推荐订单
            }

              $this->assign('detail',$detail);
        }else{
            unset($map['tj_status']);    
            $this->assign('detail','');
        }
        if($status){
            $map['order_status'] = $status;
            $this->assign('status',$status);
        }else{
           unset($map['status']);
           $this->assign('status','');
        }


        $count = M('order_info')->order('order_time desc')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = M('order_info')->order('order_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }
        $summoney = M('order_info')->order('order_time desc')->where($map)->sum('total_fee');
        $this->assign('order',$order);
        $this->assign('count',$count);
        $this->assign('summoney',$summoney);
       //print_r($order);
        //die;
        $this->display();
    }
	
    public function selNotice()
    {
        $this->display();
    }

    public function selCompanyNotice()
    {
        $this->display();
    }

    public function selCertified()
    {
        $res = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>1))->find();
        if($res == null | $res == ''){
            $this->assign('res',0);
        }else{
            $this->assign('res',$res);
        }

        $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->count();
        $this->assign('count',$count);

        $person_type = M('my_shop')->where(array('user_id'=>$_SESSION['member_id']))->getField('person_type');
        $this->assign('type',$person_type);
        $this->display();
    }

    public function selAgree()
    {
        $personType = $_GET['personType'];
        $this->assign('personType',$personType);
        $is_depute = $_GET['is_depute'];
        $this->assign('is_depute',$is_depute);
        $this->display();
    }
    public function zl(){
        $res = M('my_shop')->where(array('person_type'=>$_POST['personType'],'is_depute'=>$_POST['is_depute'],'user_id'=>$_SESSION['member_id']))->find();
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，后台正在为您审核！请稍等"));die;
        }
        $data['person_type'] = $_POST['personType'];
        $data['is_depute'] = $_POST['is_depute'];
        $data['user_id'] = $_SESSION['member_id'];
        $data['create_time'] = time();
        $res = M('my_shop')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"资料提交失败"));
        }
    }

    public function hlgl(){
		//dump($_POST);exit;
        $user_id = $_SESSION['member_id'];        
        if(IS_POST){
            $data = I('post.');       
            $data['owner_id'] = $user_id;
            $data['art_cate'] = "";
            //dump($data);exit;
            $res = M('gallery')->add($data);
            if($res){
                $this->success('提交成功',U('Wxin/Gallery/hlgl'));
            }else{
                $this->error('提交失败',U('Wxin/Gallery/hlgl'));
            }
            $this->redirect('Wxin/PersonalCenter/userinfo');
            
        }
		$level = M('artist_level')->select();
		$this->assign('level',$level);
        $art_cate = M('art_cate')->select();
        $this->assign('art_cate',$art_cate);
        $this->display();
    }
	
	public function zcArtlist(){
		if(IS_POST){
			$data = I("post.");
			$data['create_at'] = time();
			$data['art_cate'] = $art_cate;
			$res = M('artist')->add($data);
			
			if($res){
                $this->success('提交成功',U('Wxin/Gallery/hlgl'));
            }else{
                $this->error('提交失败',U('Wxin/Gallery/hlgl'));
            }
				$this->redirect('Wxin/PersonalCenter/userinfo');
			}
		
			
		$this->display();
	}
	
	public function ysjgl(){
		//dump($_POST);exit;
		$user_id = $_SESSION['member_id']; 
		//$cate_id = $_GET['art_cate'];	
		//dump($_POST);exit;
		if(IS_POST){
			$data = I('post.');
			$data['create_at'] = time();
			$res = M('artist')->add($data);
			if($res){
				$this->success('创建成功！',U('Wxin/Gallery/ysjgl'));
			}else{
				$this->error('创建失败！',U('Wxin/Gallery/ysjgl'));
			}
			$this->redirect('Wxin/PersonalCenter/userinfo');
		}
		$level = M('artist_level')->select();
		$this->assign('level',$level);
		$this->display();
		$art_cate = M('art_cate')->select();
		//dump($art_cate);exit;
		$this->assign('art_cate',$art_cate);
		$this->display();	
	}
	
	
}