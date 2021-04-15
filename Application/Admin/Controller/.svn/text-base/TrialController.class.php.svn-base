<?php namespace Admin\Controller;

use Common\Controller\CommonController;

class TrialController extends CommonController
{
	/**
	 * 试用中心首页面
	 * 
	 */
	public function trial()
    {
		$trial_name =  I("trial_name"); 	//模糊查询
		$goods 	    =  M("Trial"); 			//商品表
		$where['is_del']    = 0;  			// 0 没有是删除， 1 删除
		#分页实现
		$count  = $goods->where($where)->count();
		$page   = getpage($count, 5);
		$show   = $page->show();
		
		#获取商品(实现分页形式获取)
		$result = $goods->where(array(
				"is_del" 	 => 0,
				"trial_name" => array("like", "%" .$trial_name. "%"),
			))
			->limit($page->firstRow. ',' .$page->listRows)
			->select();
		
		#组织数据进行分配
		$this->assign("result", $result);
		$this->assign("page",	$show);
		$this->display();
	}
	
	/**
	 * 试用产品添加
	 */
	public function addTrial()
	{
		if (IS_POST) {
			
			$trial_name  = I("post.trial_name");
		 	$trial_num   = I("post.trial_num");
			$trial_price = I("post.trial_price");
			$trial_start_time = I("post.trial_start_time");
			$trial_end_time   = I("post.trial_end_time");
			
			if (empty($trial_name)) {
				$this->error("产品名称不能为空");
			}
			if ( empty($trial_num) ) {
				$this->error("产品数量不能为空"); 
			}
			if ( !preg_match("/^\d{1,3}$/", $trial_num)) {
				$this->error("产品数量值不能大于255，且只能是数字");
			}
			if ( empty($trial_price)) {
				$this->error("产品价格不能为空");
			}
			if ( !preg_match("/^([1-9]\d*|0)(\.\d{1,3})?$/", $trial_price)) {
				$this->error("产品价格格式错误，只能是数字值");
			}
			
			#判断开始时间和结束时间前后的差异
			$trial_start_time  = strtotime($trial_start_time);
			$trial_end_time    = strtotime($trial_end_time);
			if ($trial_start_time < time()) {
				$this->error("开始时间不能小于现在时间");
			}
			if ($trial_end_time <= time() || $trial_end_time == $trial_start_time) {
				$this->error("结束时间不能小于等于现在时间");
			}
			
			$data  = I("post.");
			$trial = M("Trial");
			$goods = M("Goods");
			
			#根据商品名称获取到商品的详细信息
			$goods_info = $goods->where(array(
				"classname"	=> $trial_name,	
			))->find();
			
			$data['trial_small_img']  = $goods_info['logo_pic'];
			$data['trial_big_img']    = $goods_info['index_pic'];
			
		
			$result = $trial->add($data);	
			if ($result) {
				$this->success("添加成功", U("Admin/Trial/trial")); exit;
			} else {
				$this->success("添加失败"); exit;
			}
		}
		
		$goods = M("Goods");
		$where['is_newac'] = 1;
		$result = $goods->where($where)->select();
		
		#组织数据进行分配
		$this->assign("result", $result);
		$this->display();
	}
	
	/**
	 * 试用产品编辑
	 */
	public function editTrial()
	{
	 	$id = I("id");
	 	$goods  = M("Goods");	//商品
		$trial  = M("Trial");	//试用商品
		
	 	$where['is_newac'] = 1;
		$goods_list = $goods->where($where)->select();
		
		$result = $trial->where(array(
			"id"  => $id,
		))->find();
		
		$this->assign("goods_list", $goods_list);
		$this->assign("result", $result);
		$this->display();
	}
	
	/**
	 * 编辑后的数据值
	 */
	public function doEditTrial()
	{
		$trial_name  = I("post.trial_name");
		$trial_num   = I("post.trial_num");
		$trial_price = I("post.trial_price");
		$trial_start_time = I("post.trial_start_time");
		$trial_end_time   = I("post.trial_end_time");
			
		if (empty($trial_name)) {
			$this->error("产品名称不能为空");
		}
		if ( empty($trial_num) ) {
			$this->error("产品数量不能为空");
		}
		if ( !preg_match("/^\d{1,3}$/", $trial_num)) {
			$this->error("产品数量值不能大于255，且只能是数字");
		}
		if ( empty($trial_price)) {
			$this->error("产品价格不能为空");
		}
		if ( !preg_match("/^([1-9]\d*|0)(\.\d{1,3})?$/", $trial_price)) {
			$this->error("产品价格格式错误，只能是数字值");
		}
			
		#判断开始时间和结束时间前后的差异
		$trial_start_time  = strtotime($trial_start_time);
		$trial_end_time    = strtotime($trial_end_time);
		if ($trial_start_time < time()) {
		$this->error("开始时间不能小于现在时间");
		}
		if ($trial_end_time <= time() || $trial_end_time == $trial_start_time) {
		$this->error("结束时间不能小于等于现在时间");
		}
		
		
		$id    = I("id");
		$data  = I("post.");
		$trial = M("Trial");
			
		$result = $trial->where(array(
			"id"  => $id,
		))->save($data);
		
		if ($result) {
			$this->success("修改成功", U("Admin/Trial/trial", '', false)); exit;
		} else {
			$this->error("修改失败"); exit;
		}
	}
	
	
	/**
	 * 试用产品删除
	 */
	public function delTrial()
	{	
		$id    = I("id");
		$trial  = M("Trial");
		$result = $trial->where(array(
			"id"  => $id,
		))->save(array(
			'is_del'  => 1,
		));
		if ($result) $this->success("删除成功", U("Admin/Trial/trial",'', false)); exit;
	}
	
	
	/**
	 * 改变试用产品状态
	 */
	public function changeStatus()
	{
		if (IS_AJAX) {
		
			$id    = I("post.id");
			$goods = M("Trial");
			
			$result = $goods->where( array( "id"      => $id, ))->find();
			
			if (!$result) {
				$this->ajaxReturn(   array( "status"  => 0, "info" => "修改失败！"));
			}
			
			$res2 = $goods->where(   array(  "id"      => $id, ))->setField( "is_trial", 1-intval( $result["is_trial"] ));
	
			if ($res2) {
				$this->ajaxReturn(   array(  "status"  => 1, ));
			}
			
			$this->ajaxReturn(       array(  "status"  => 0 , "info" => "修改失败！", ));
		}
	}
	
	
	###################### 申请产品处理 ##########################
	
	/**
	 * 申请产品列表
	 */
	public function apply()
    {
        //模糊查询
        if (IS_POST) {
            $person_name = I("post.person_name");
            $telephone   = I("post.telephone");
            $start_time  = I("post.start_time");
            $end_time    = I("post.end_time");

            if ($start_time != null) {
                $sql = "select c.trial_name,c.trial_price,b.person_name,b.realname,b.telephone,a.goods_img,a.goods_time,a.goods_status,a.num from app_trial_order a inner join app_member b on a.user_id = b.id inner join app_trial c on a.goods_id=c.id where a.is_del = 0 and b.telephone like '%{$telephone}%' and b.person_name like '%{$person_name}%' and a.goods_time between '{$start_time}' and '{$end_time}' order by a.goods_time desc ";
            } else {
                $sql = "select c.trial_name,c.trial_price,b.person_name,b.telephone,b.realname,a.goods_img,a.goods_time,a.goods_status,a.num from app_trial_order a inner join app_member b on a.user_id = b.id inner join app_trial c on a.goods_id=c.id where a.is_del = 0 and b.telephone like '%{$telephone}%' and b.person_name like '%{$person_name}%' order by a.goods_time desc";
            }
            $trial_list = M("Trial_order")->query($sql);
            if ($trial_list) {
                $this->assign('trial_list', $trial_list);
            } else {
                $this->error("未找到相关数据！");
            }

        } else {

            $goods_status = I("goods_status");      //传递过来的商品状态 0： 申请中... 1：申请成功... 2：申请失败...
            $user_id = session("user_id");          //用户id
            $trial = M("Trial");                    //试用产品表
            $trial_order = M("Trial_order");        //申请试用产品订单表
            $user = M("Member");                    //用户表

            if ($goods_status === null || $goods_status === "") {
                //实现分页
                $count = $trial_order->where(array("is_del" => 0))->count();
                $page = getpage($count, 6);
                $show = $page->show();

                //申请产品订单列表
                $trial_list = $trial_order->where(array(
                    "is_del" => 0,
                ))
                    ->limit($page->firstRow . ',' . $page->listRows)
                    ->Order("goods_time desc")
                    ->select();

            } else {
                //实现分页
                $count = $trial_order->where(array("goods_status" => intval($goods_status), "is_del" => 0))->count();
                $page = getpage($count, 6);
                $show = $page->show();

                //申请产品订单列表
                $trial_list = $trial_order->where(array(
                    "is_del" => 0,
                    "goods_status" => intval($goods_status),
                ))
                    ->limit($page->firstRow . ',' . $page->listRows)
	                ->Order("goods_time desc")
                    ->select();
            }


            //获取申请产品用户
            foreach ($trial_list as $key => $names) {
                $user_name[$key] = $user->where(array(
                    "id" => $names['user_id'],
                ))
                    ->field("id,realname,telephone")
                    ->select();
            }

            //获取产品价格和名称
            foreach ($trial_list as $key => $vals) {
                $datas[$key] = $trial->where(array(
                    "id" => $vals['goods_id'],
                    "is_del" => 0,
                ))
                    ->field("id,trial_price,trial_name")
                    ->select();
            }

            //对数据进行组合
            foreach ($datas as $key => $valss) {
                $trial_list[$key]['trial_name'] = $valss[0]['trial_name'];
                $trial_list[$key]['end_time'] = $valss[0]['trial_end_time'];
                $trial_list[$key]['price'] = $valss[0]['trial_price'];
            }

            //整合用户信息
            foreach ($user_name as $key => $va) {
                $trial_list[$key]['realname'] = $va[0]['realname'];
                $trial_list[$key]['telephone'] = $va[0]['telephone'];
            }
        }

        $trial_order = M("Trial_order");
        //根据商品状态获取和区分商品不同的状态数量
        $apply_all      = $trial_order->where(array("is_del" => 0,))->count();
        $apply_underway = $trial_order->where(array("is_del" => 0, "goods_status" => 0,))->count();
        $apply_sucess   = $trial_order->where(array("is_del" => 0, "goods_status" => 1,))->count();
        $apply_fall     = $trial_order->where(array("is_del" => 0, "goods_status" => 2,))->count();


        //物流公司
	    $express = M("express")->order("id asc")->select();
	    $this->assign("express_list",$express);

		//组织数据进行分配
		$this->assign("trial_list",   	$trial_list);
		$this->assign("user_name",	  	$user_name);
		$this->assign("page",	      	$show);
		$this->assign("apply_all", 		$apply_all);
		$this->assign("apply_underway", $apply_underway);
		$this->assign("apply_sucess",	$apply_sucess);
		$this->assign("apply_fall",     $apply_fall);
		
		$this->display();
	}
	
	/**
	 * 申请产品状态改变（1 通过申请   0 未通过申请）
	 */
	public function applyChangeStatus()
	{
		if (IS_AJAX) {
	
			$id    = I("post.id");
			$goods = M("Trial_order");
			$val   = I("post.val");
			//判断该订单商品是否存在
			$result = $goods->where(array("id" => $id ))->find();
			if (!$result) {
				$this->ajaxReturn(array("status" => 0, "info" => "修改失败！" ));
			}

			//修改状态
			$affRows = $goods->where(array("id" => $id))->setField("goods_status", $val);
			if ($affRows) {
				$this->ajaxReturn(array("status" => 1 , "info"=>"修改成功！"));
			}
				
			//修改失败，信息提示
			$this->ajaxReturn(array("status" => 0, "info"=>"修改失败！" ));
		}
	}


	/**
	 * 活动商品列表
	 */
	public function trial_list(){
		$cate_id=I('get.cate_id');
        $name=I('get.name');
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

        $m   = M("ActivityGoods");
        $map['isdel'] = 0;

        /*销售中*/
        $count1=$m->where(array("isdel"=>0, "is_sale"=>1))->count();
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =$m->where($map)->count();
        }
        /*未销售 下架*/
        $count2=$m->where(array("isdel"=>0, "is_sale"=>0))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=$m->where($map)->count();
        }


        /*商品数量*/
        $count=$m->where($map)->count();
        $countss = $m->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

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

        $this->assign("counts", $countss);//全部
        $this->assign("cache", $res);
		$this->display();
	}


	/**
	 * 活动商品添加
	 */
    public function addGoods(){
        if(IS_POST){
            $m = M("goods");
            $g_s_m = M("goodsSlide");
            // dd(I('post.'));
            $data = I("post.");
            $slide_pic = $data['pic1'];
            if(I("post.is_sale")){
                $data['sale_at']=time();
            }
            unset($data['pic1']);
            $data['create_at'] = time();
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
                $this->error("新增产品失败！",U('Admin/goods/goodslist'));
            }
            $this->redirect('Admin/goods/goodslist');
        }
        $c    = M("cate");
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("categorylist", $categorylist);
        $s=M("series");
        $serieslist=$s->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("serieslist", $serieslist);
        $this->display();
    }

    /**
     * 活动商品编辑
     */
    public function editGoods(){
        if(IS_POST){
            $m = M("goods");
            $g_s_m = M("goodsSlide");
            // dd(I('post.'));
            $data = I("post.");
            $id   = $data['id'];
            $slide_pic = $data['pic1'];
            unset($data['id']);
            unset($data['pic1']);
            $data['create_at'] = time();
            if(!$id){
                $this->error("缺少参数！");
            }
            $res = $m->where(array("id"=>$id,'isdel'=>0))->save($data);
            if($res !== false){
                foreach($slide_pic as $k=>$v){
                    $slide_data = array(
                            "goods_id"   => $id,
                            "sort"       => $k,
                            "create_at"  => time(),
                            "pic"        => $v,
                            "status"     => 1,
                        );
                    $g_s_m->add($slide_data);
                }
            }else{
                $this->error("修改商品失败！",U('Admin/goods/goodslist'));
            }
            $this->redirect('Admin/goods/goodslist');
        }
        $id = I("id");
        if(!$id){
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $goods = M("goods")->where(array('id'=>$id, "isdel"=>0))->find();
        if(!$goods){
            echo "<script>alert('无此商品！');window.history.back();</script>";die;
        }
        $c    = M("cate");
        $goods['classname'] = $c->where(array('id'=>$goods['cate_id'],'isdel'=>0))->getField('classname');
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->order('sort asc')->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id']))->order('sort asc')->select();
        }

        $s=M("series");
        $goods['seriesname'] = $s->where(array('id'=>$goods['series_id'],'isdel'=>0))->getField('classname');
        $serieslist=$s->where(array("pid"=>0, "isdel"=>0))->order('sort asc')->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->order('sort asc')->select();
        }
        $this->assign("serieslist", $serieslist);
        $goods_slide = M("goodsSlide")->where(array('goods_id'=>$id, "status"=>1,'isdel'=>0))->select();
        $this->assign("goods_slide", $goods_slide);
        $this->assign("cache", $goods);
        $this->assign("categorylist", $categorylist);
        $this->display();
    }

    /**
     * 删除商品轮播图
     */
    public function delGoodsSlide(){
        if(IS_AJAX){
            $id  = I("id");
            $res = M("goods_slide")->where(array('id'=>$id))->save(array("status"=>0));
            if($res){
                $this->ajaxReturn(array('status'=>1, "info"=>"删除图片成功！"));
            }else{
                $this->ajaxReturn(array('status'=>0, "info"=>"删除图片失败！"));
            }
        }
    }
    /*
     * 试用产品发货
     * */
    public function goodsShipments(){

    	if(IS_AJAX){
		    $data["express_name"]    = I("post.express_name");//编码
		    $data["express_no"]      = I("post.express_no");
		    $data["is_deliver"]      = 1;
		    $id                      = I('post.id');
		    $m = M('trial_order');
		    $res = $m->where("id=".$id)->save($data);
		    if($res){
			    $Info=$m->where(array("id"=>$id))->find();
			    $d=array(
				    'id'=>$Info['id']
			    );
			    $data["express_name"]    = M("express")->where(array('express_ma'=>$data['express_name']))->getField("express_company");//快递公司名称
			    $this->sendSystemMessage($Info['user_id'],"订单已发货","您的订单【".$Info['goods_no']."】已发货，【".$data['express_name']."】运单编号：".$data["express_no"]."请注意查收！",$d);
			    $this->ajaxReturn(array("status"=>1,'info'=>"发货成功"));
		    }else{
			    $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
		    }
	    }
    }

    // 试用产品 一键抽选
    public function selected()
    {
        if (IS_AJAX) {
            $type       = I("post.type",0,"intval");
            $num        = I("post.num",0,"intval");
            $goods_id   = I("post.id",0,"intval");
            if (empty($type)) {
                $this->ajaxReturn(array("status"=>0,"info"=>"请选择抽选方式"));
            }
            if (empty($num)) {
                $this->ajaxReturn(array("status"=>0,"info"=>"请填写抽选人数"));
            }
            if (!preg_match('/^[1-9]\d*$/',$num)) {
                $this->ajaxReturn(array("status"=>0,"info"=>"请填写正确的抽选人数"));
            }
            if (empty($goods_id)) {
                $this->ajaxReturn(array("status"=>0,"info"=>"非法操作"));
            }
            $Trial_order = M("Trial_order");
            $count = $Trial_order->where(array("goods_id"=>$goods_id,"goods_status"=>0))->count();
            if ($num > $count) {
                $this->ajaxReturn(array("status"=>0,"info"=>"抽选人数大于申请人数，当前申请人数为".$count."人"));
            }
            if ($type == 1) {
                $data = $Trial_order->where(array("goods_id"=>$goods_id,"goods_status"=>0))->order("goods_time asc")->limit($num)->select();
                foreach ($data as $v) {
                    $Trial_order->where(array("id"=>$v['id']))->setField("goods_status",1);
                }
                $this->ajaxReturn(array("status"=>1,"info"=>"一键抽选成功"));
            } elseif ($type == 2) {
                $data = $Trial_order->where(array("goods_id"=>$goods_id,"goods_status"=>0))->order('rand()')->limit($num)->select();
                foreach ($data as $v) {
                    $Trial_order->where(array("id"=>$v['id']))->setField("goods_status",1);
                }
                $this->ajaxReturn(array("status"=>1,"info"=>"一键抽选成功"));
            } else {
                $this->ajaxReturn(array("status"=>0,"info"=>"非法操作"));
            }
        }
    }
}




