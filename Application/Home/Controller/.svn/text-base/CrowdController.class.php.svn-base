<?php
namespace Home\Controller;
use Think\Controller;

class CrowdController extends BaseController 
{
	public function index(){
		$user_id = $_SESSION['member_id'];
		$res = M('crowd')->where(array('promulgator'=>$user_id))->select();
		$this->assign('res',$res);
		$this->display();
	}


	/*
    *众筹管理
    */
	public function sqzc(){
		$this->display();
	}

    public function fbzc(){
        $user_id = $_SESSION['member_id'];
        if(IS_POST){
            $data = I('post.');
            $start = str_replace('年','-',$data['start']);
            $start = str_replace('月','-',$start);
            $start = str_replace('日','',$start);
            $end = str_replace('年','-',$data['end']);
            $end = str_replace('月','-',$end);
            $end = str_replace('日','',$end);
            //dump($start);exit;
            $data['promulgator'] = $user_id;
            $data['create_at'] = time();
            $data['start'] = strtotime($start);
            $data['end'] = strtotime($end);
			//dump($data);exit;
            $res = M('crowd')->add($data);
            if($res){
                $this->success('发布成功请等待后台审核',U('/Home/PersonalCenter/userinfo'));
            }else{
                $this->error('发布失败',U('/Home/PersonalCenter/userinfo'));
            }
            $this->redirect('Home/PersonalCenter/userinfo');
        }
        $crowd_cate = M('crowd_cate')->select();
        $this->assign('crowd_cate',$crowd_cate);
        $this->display();
    }
	
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

    public function selNotice()
    {
        $this->display();
    }

    public function selCompanyNotice()
    {
        $this->display();
    }

	  public function selIdentity()
    {
        $this->display();
    }
	
    public function selCertified()
    {
        $res = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'status'=>1))->find();
        if($res == null | $res == ''){
            $this->assign('res',0);
        }else{
            $this->assign('res',$res);
        }

        $count = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->count();
        $this->assign('count',$count);

        $person_type = M('my_shop')->where(array('member_id'=>$_SESSION['member_id']))->getField('person_type');
        $this->assign('type',$person_type);
        $this->display();
    }

    // public function selCompanyCertified()
    // {
    //     $res = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>1,'remind_type'=>1))->find();
    //     if($res == null | $res == ''){
    //         $this->assign('res',0);
    //     }else{
    //         $this->assign('res',$res);
    //     }
    //     $res1 = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>1,'remind_type'=>2))->find();
    //     if($res1 == null | $res1 == ''){
    //         $this->assign('res1',0);
    //     }else{
    //         $this->assign('res1',$res1);
    //     }
    //     $res2 = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>1,'remind_type'=>3))->find();
    //     if($res2 == null | $res2 == ''){
    //         $this->assign('res2',0);
    //     }else{
    //         $this->assign('res2',$res);
    //     }

    //     $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'remind_type'=>1))->count();
    //     $this->assign('count',$count);
    //     $count1 = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'remind_type'=>2))->count();
    //     $this->assign('count1',$count1);
    //     $count2 = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'remind_type'=>3))->count();
    //     $this->assign('count2',$count2);


    //     $person_type = M('my_shop')->where(array('user_id'=>$_SESSION['member_id'],'is_depute'=>1))->getField('person_type');
    //     $this->assign('type',$person_type);

    //     $person_type1 = M('my_shop')->where(array('user_id'=>$_SESSION['member_id'],'is_depute'=>1))->getField('is_depute');
    //     $this->assign('type1',$person_type1);
    //     $this->display();
    // }
    /**
     * /
     * ZQJ  20171031 免费开店页面
     */
    public function selCompanyCertified(){
        $res = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'is_del'=>0))->find();
        //print_r($res);
        if($res['fa_status'] == 1 && $res['bus_status'] == 1){
            $this->assign('status',1);
        }
        $this->assign('res',$res);
        $this->display();
    }
    public function selOnSale()
    {
        $artist_id = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->getField('id');
        //dump($artist_id);exit;
        $res = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id,'is_sale'=>1))->select();
        //dump($res);exit;
        foreach ($res as $k=>$v){
            $goods = M('goods_collect')->where(array('good_id'=>$v['id']))->count();
            $res[$k]['count'] = $goods[0]['count'];
        }
        //dump($res);exit;
        $this->assign('res',$res);
        $this->display();
    }

    public function changeStatus(){
        $is_sale = I('post.is_sale');
        $id = I('post.id');
        if($is_sale == 0){
            M('goods')->where(array('id'=>$id))->save(array('is_sale'=>1));
            $this->ajaxReturn(array('status'=>1,'info'=>"上架成功！"));
        }else{
            M('goods')->where(array('id'=>$id))->save(array('is_sale'=>0));
            $this->ajaxReturn(array('status'=>1,'info'=>"下架成功！"));
        }
    }
	
	public function selfSel(){
		if(IS_AJAX){
            if(!$_SESSION['member_id']){
                $dataAj['status'] = 0;
                $dataAj['info'] = "请登录！";
                $this->ajaxReturn($dataAj);

             }
             
            $data = I('post.');

 
            $fdata['fa_name'] = $data['name'];
            $fdata['member_id'] = $_SESSION['member_id'];
			//dump($fdata['member_id']);exit;
            
           
			$data['card_img'] = $data['pic1'];
			$data['card_img1'] = $data['pic2'];
			$data['member_id'] = $_SESSION['member_id'];
			$data['addtime'] = time();  
			
            $count = M('authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->count();            
            $res = M('authentication')->add($data);
                                    
            if($res){
                  $dataAj['status'] = 1;
                  $dataAj['info'] = " 成功提交审核！";
                  $this->ajaxReturn($dataAj);
             }
        }
		
	}



    /*
    *ZQJ 20171031  法人提交
     */
    public function ajaxSel(){

        //var_dump(I('post.'));die;
        if(IS_AJAX){
            if(!$_SESSION['member_id']){
                $dataAj['status'] = 0;
                $dataAj['info'] = "请登录！";
                $this->ajaxReturn($dataAj);

             }
             
            $data = I('post.');
            if(!trim($data['name'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "姓名不能为空！";
                $this->ajaxReturn($dataAj);
            }

            if(!trim($data['tel'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "电话不能为空！";
                $this->ajaxReturn($dataAj);
            } 

            if(!trim($data['cardID'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "身份证不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            if(trim($data['type']) === ''){
                $dataAj['status'] = 0;
                $dataAj['info'] = "证件类型不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            if(!trim($data['address'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "详细地址不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            if(!trim($data['pic1'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "身份证正面不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            if(!trim($data['pic2'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "身份证反面不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            if(!trim($data['province'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "省份不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            if(!trim($data['city'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = "城市不能为空！";
                $this->ajaxReturn($dataAj);
            } 
            $fdata['fa_name'] = $data['name'];
            $fdata['member_id'] = $_SESSION['member_id'];
			dump($fdata['member_id']);exit;
            $fdata['ftel'] = $data['tel']; //身份证类型 -
            $fdata['fcard_type'] = $data['type']; //身份证类型 -
            $fdata['fcardID'] = $data['cardID'];  //身份证号
            $fdata['fcard_img'] = $data['pic1'];  //身份证正面
            $fdata['fcard_img1'] = $data['pic2'];  //身份证反面
            $fdata['province'] = $data['province'];  //省
            $fdata['city'] = $data['city'];  //市
            $fdata['district'] = $data['district'];  //县
            $fdata['address'] = $data['address'];  //详细地址
            $fdata['addtime'] = time();  //提交时间
            $fdata['fa_status'] = time();  //审核状态
			//$data['card_img'] = $data['pic1'];
			//$data['card_img1'] = $data['pic2'];
			//$data['member_id'] = $_SESSION['member_id'];
			//$data['addtime'] = time();  
			
            $count = M('shop_authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->count();
             
                  $res = M('shop_authentication')->add($fdata);
                  
            
          
            if($res){
                  $dataAj['status'] = 1;
                  $dataAj['info'] = " 成功提交审核！";
                  $this->ajaxReturn($dataAj);
             }

        }
    }


    // /*lyw 2017.11.2 我的店铺*/
    // public function seldpsy(){
    //     $this->display();
    // }
	
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
                $this->success('提交成功',U('Home/Shop/hlgl'));
            }else{
                $this->error('提交失败',U('Home/Shop/hlgl'));
            }
            $this->redirect('Home/PersonalCenter/userinfo');
            
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
                $this->success('提交成功',U('Home/Shop/hlgl'));
            }else{
                $this->error('提交失败',U('Home/Shop/hlgl'));
            }
				$this->redirect('Home/PersonalCenter/userinfo');
			}
		
			
		$this->display();
	}
	
	public function ysjgl(){       
		if(IS_POST){
			$data = I('post.');
			$data['member_id'] = $_SESSION['member_id'];
			$data['create_at'] = time();           
			$res = M('artist')->add($data);		
			if($res){
				$this->success('创建成功！',U('Home/shop/ysjgl'));
			}else{
				$this->error('创建失败！',U('Home/shop/ysjgl'));
			}
			$this->redirect('Home/PersonalCenter/userinfo');
		}
		$level = M('artist_level')->select();
		$this->assign('level',$level);
		$art_cate = M('art_cate')->select();
		$school_cate = M('school_cate')->select();
		$this->assign('school_cate',$school_cate);
		$this->assign('art_cate',$art_cate);
		$this->display();	
	}


}
	