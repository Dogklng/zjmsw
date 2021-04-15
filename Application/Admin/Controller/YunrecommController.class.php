<?php
/*
	*ZQJ 云推荐
*/
namespace Admin\Controller;
use Common\Controller\CommonController;
class YunrecommController extends CommonController {
	/*public function index(){
		$name = trim(I('get.name'));
		if($name){
			$map['name']=array('like',"%".$name."%");
		$this->assign('title',$name);
		}
		$map['is_del']=0;
		$counts = M('yunrecomm')->where($map)->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		$yun = M('yunrecomm')->limit($Page->firstRow.','.$Page->listRows)->where($map)->select();
		$this->assign('yun',$yun);
		$this->assign('counts',$counts);
		//print_r($yun);
		$this->display();
	}*/

	public function index(){
        $name = trim(I('get.name'));
        if($name){
            $map['name']=array('like',"%".$name."%");
            $this->assign('title',$name);
        }
        $counts = M('yun_right')->where($map)->count();
        $Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $yun = M('yun_right')->limit($Page->firstRow.','.$Page->listRows)->where($map)->select();
        $this->assign('yun',$yun);
        $this->assign('counts',$counts);
        //print_r($yun);
        $this->display();
    }

    public function editIndex(){
	    if(IS_POST){
	        $data = I('post.');
	        //print_r($data);exit;
            $data['edittime'] = time();
	        $res1 = M('yun_right')->where(array('id'=>$data['sid']))->save($data);
	        if($res1){
	            $this->ajaxReturn(array('status'=>1,'info'=>'修改成功!'));
            }else{
	            $this->ajaxReturn(array('status'=>0,'info'=>'修改失败!'));
            }
        }
	    $id = I('get.id');
	    $res = M('yun_right')->where(array('id'=>$id))->find();
	    $this->assign('res',$res);
	    $this->display();
    }

    public function rule(){
        if (IS_POST) {
            $edit_notice = M("yun_rule");
            //print_r($_POST);exit;
            $count = $edit_notice->count();

            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Yunrecomm/rule', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Yunrecomm/rule', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Yunrecomm/rule', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Yunrecomm/rule', '', false));exit;
                }
            }
        }

        $id= M('yun_rule')->getField('id');

        $res = M("yun_rule")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*
     * 云推荐礼包配置
     * */
    public function yungift(){
        $res = M('yun_gift')->select();
        $this->assign('res',$res);
        $this->display();
    }


    /**
     * 添加云推荐礼包
     */
    public function addGift(){
        header("Content-Type:text/html;charset=utf-8;");
            if(IS_POST){
            $data2 = I('post.');
            //print_r($data2);exit;
            if(!trim($data2['aname'])){
                //echo "<script>alert('评委姓名不能为空！');window.history.back();</script>";die;
                $data1['status'] = 0;
                $data1['info'] = '名称不能为空！';

                $this->ajaxReturn($data1);die;
            }
            if(!trim(strip_tags($data2['content']))){
                //echo "<script>alert('评委简介不能为空！');window.history.back();</script>";die;
                $data1['status'] = 0;
                $data1['info'] = '礼包简介不能为空！';
                $this->ajaxReturn($data1);die;
            }
            //$data1['status'] = 1;
            $dataj['name'] = trim($data2['aname']);
            $dataj['detail'] = trim($data2['content']);
            if($data2['news_pic']){

                $dataj['pic'] = $data2['news_pic'];
            }
            //print_r($dataj);
            $cc=M('yun_gift')->add($dataj);
            if($cc){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败!'));
            }

        }
        /*if(IS_POST){
            $data = I('post.');
            print_r($data);exit;
            $dataj['name'] = trim($data['aname']);
            $dataj['detail'] = trim($data['content']);
            if($data['news_pic']){

                $dataj['pic'] = $data['news_pic'];
            }
            $cc=M('yun_gift')->add($dataj);
            print_r($cc);exit;
            if($cc){
                $this->success("添加成功!", U('Admin/Yunrecomm/yungift', '', false));exit;

            }else{
                $this->error("添加失败", U('Admin/Yunrecomm/yungift', '', false));exit;
            }
        }*/
        $this->display();
    }

    /**
     * 修改评委
     */
    public function editGift(){
        header("Content-Type:text/html;charset=utf-8;");
        if(IS_AJAX){
            $data = I('post.');
            //print_r($data);exit;
            $dataj['name'] = trim($data['aname']);
            $dataj['detail'] = trim($data['content']);
            $dataj['price'] = $data['price'];
            if($data['news_pic']){

                $dataj['pic'] = $data['news_pic'];
            }
            if($data['jid']){
                $jid=$data['jid'];
                unset($data['jid']);
            }
            $dataj['edit_time'] = time();
            //print_r($dataj);die;
            $cc=M('yun_gift')->where(array('id'=>$jid))->save($dataj);
            if($cc){
                $this->ajaxReturn(array('status'=>1,'info'=>'修改成功!'));

            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'修改失败!'));
            }
        }

        $id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $res = M('yun_gift')->where(array('id'=>$id,'is_del'=>0))->find();
        /*$nu=M('number_list');
        $mp['is_del']=0;
        $nu=$nu->where($mp)->select();
        $this->assign('numbers',$nu);*/
        $this->assign('res',$res);
        $this->display();
    }




	/*
	*修改添加
	*/
	/*public function editIndex(){
		header("Content-Type:text/html;charset=utf-8;");
		if(IS_AJAX){
			$data = I('get.');
			if(!trim($data['name'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "等级不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if(!trim($data['salesquota'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "销售额度不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if(!trim($data['company'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "单位不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if(preg_match("/^\d*$/",$data['company'] )){
				$dataAj['status'] = 0;
				$dataAj['info'] = "单位不能为数字！";
				$this->ajaxReturn($dataAj);
			}
			if(!trim($data['giftcard'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "礼金券不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if(!trim($data['product'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "销售件数不能为空！";
				$this->ajaxReturn($dataAj);
			}
		
			if(!preg_match("/^\d*$/",$data['giftcard'] )){
				//echo "<script>alert('请输入数字');window.history.back();</script>";die;
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入数字!";
				$this->ajaxReturn($dataAj);
			}
			if(!preg_match("/^\d*$/",$data['product'] )){
				//echo "<script>alert('请输入数字');window.history.back();</script>";die;
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入数字!";
				$this->ajaxReturn($dataAj);
			}
			if($data['sid']){
				$name = M('yunrecomm')->where(array('id'=>$data['sid']))->getField('name');
				if(trim($data['name']) != trim($name)){
					$res = M('yunrecomm')->where(array('name'=>trim($data['name'])))->select();
					if($res){
						$dataAj['status'] = 0;
						$dataAj['info'] = "等级不能重复!";
						$this->ajaxReturn($dataAj);
					}
				}else{
					
					$dataAj['status'] = 1;
					$this->ajaxReturn($dataAj);
				}
			}else{
				$res = M('yunrecomm')->where(array('name'=>trim($data['name'])))->select();
					if($res){
						$dataAj['status'] = 0;
						$dataAj['info'] = "等级不能重复!";
						$this->ajaxReturn($dataAj);
					}
			}
			$dataAj['status'] = 1;
			$this->ajaxReturn($dataAj);
			
		}
		
		$id = I('get.id');
		if(!$id){
		}else{
			$res = M('yunrecomm')->where(array('is_del'=>0,'id'=>$id))->find();
			$this->assign('res',$res);
		}
		
		
		if(IS_POST){
			$data = I('post.');
			$datay['name'] = $data['name'];
			$datay['product'] = $data['product'];
			$datay['salesquota'] = $data['salesquota'];
			$datay['company'] = $data['company'];
			$datay['giftcard'] = $data['giftcard'];
				if($data['sid']){
					$res1 = M('yunrecomm')->where(array('id'=>$data['sid'],'is_del'=>0))->save($datay);
					if($res1){
						$this->success('编辑成功！',U('Admin/Yunrecomm/index','',false));exit;
					}else{
						$this->error('编辑失败！',U('Admin/Yunrecomm/index','',false));exit;
					}
				
				}else{
					$res1 = M('yunrecomm')->add($datay);
					if($res1){
						$this->success('添加成功！',U('Admin/Yunrecomm/index','',false));exit;
					}else{
						$this->error('添加失败！',U('Admin/Yunrecomm/index','',false));exit;
					}
					
				}
		}
		
			$this->display('editIndex');
	}*/
	
	/*
	*添加
	*/
	public function addIndex(){
		$this->display();
	}
	/*
	*删除
	*/
	public function delIndex(){
		$id = I('get.id');
		$data['is_del'] = 1;
		$res = M('yunrecomm')->where(array('id'=>$id))->save($data);
	
		if($res){
			$this->success('删除成功！',U('Admin/Yunrecomm/index','',false));exit;
		}else{
			$this->error('删除失败！',U('Admin/Yunrecomm/index','',false));exit;
		}
	}

	/*
	 * 云推荐店铺列表
	 * */
    public function shop(){
        $name = trim(I('get.name'));
        if($name){
            $map['name']=array('like',"%".$name."%");
            $map1['a.name']=array('like',"%".$name."%");
            $this->assign('title',$name);
        }
        $mp['shenhe'] = array('neq',0);
        $is_sale = I('get.is_sale');
        if($is_sale == 3){
            $mp['shenhe'] = 3;
        }else if($is_sale == 1){
            $mp['shenhe'] = 1;
        }else if($is_sale == 2){
            $mp['shenhe'] = 2;
        }
//        /$mp['is_del'] = 0;
        $count = M('yun_apply')->where($map)->where($mp)->count();
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = M('yun_apply')
            ->alias('a')
            ->join('left join app_yun_right b on a.level=b.id')
            ->join('left join app_member c on a.user_id=c.id')
            ->field('a.*,b.name as level_name,c.telephone,c.card_id,c.realname')
            ->limit($Page->firstRow . ',' . $Page->listRows)->where($map1)->where($mp)->select();
        //dump($res);exit;

        //print_r($res);
        //全部店铺
        unset($mp['shenhe']);
        $counts = M('yun_apply')->where($map)->where($mp)->count();
        //待审核店铺 0
        $mp['shenhe'] = 1;
        $count3 = M('yun_apply')->where($map)->where($mp)->count();
        $this->assign("count3", $count3);
        //审核通过店铺 1
        $mp['shenhe'] = 2;
        $count4 = M('yun_apply')->where($map)->where($mp)->count();
        $this->assign("count4", $count4);
        //审核拒绝店铺 2
        $mp['shenhe'] = 3;
        $count5 = M('yun_apply')->where($map)->where($mp)->count();
        $this->assign("count5", $count5);

        $this->assign("counts", $counts);
        $this->assign("res", $res);
        $this->assign("page", $show);
        $this->display();
    }
    public function aushopDetail(){
        $id = I('get.id');
        if(!$id){
            $this->ajaxReturn(array('status'=>0,'info'=>'请选择店铺'));
        }
        $res = M('yun_apply')->where(array('id'=>$id))->find();
        //print_r($res);
        $this->assign('res',$res);
        $this->display();
    }

    public function shopAgree(){
        if(IS_AJAX){
            $data = I('post.');
           // print_r($data);exit;
            if(trim($data['disagree_detail']) == ""){
                $dataAj['status'] = 0;
                $dataAj['info'] = "评论不能为空！";
                $this->ajaxReturn($dataAj);
            }
            if($data['id']){
                $data1['feedback'] = trim($data['disagree_detail']);
                $data1['shenhe'] = 2;
                $data1['ruzhu_status'] = 3;
                $res = M('yun_apply')->where(array('id'=>$data['id']))->save($data1);
                $info = M('yun_apply')->where(array('id'=>$data['id']))->field('user_id,level')->find();
                /*$res1 = M('member')->where(array('id'=>$info['user_id']))->setField(array('yun_level'=>$info['level']));*/
                if(!$res){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = "审核失败！";
                    $this->ajaxReturn($dataAj);
                }
                $dataAj['status'] = 1;
                $dataAj['info'] = "审核通过！";
                $this->ajaxReturn($dataAj);
            }
        }
    }
    /*
    *店铺审核拒绝
     */
    public function shopDisagree(){
        if(IS_AJAX){
            $data = I('post.');
            if(trim($data['disagree_detail']) == ""){
                $dataAj['status'] = 0;
                $dataAj['info'] = "评论不能为空！";
                $this->ajaxReturn($dataAj);
            }
            if($data['id']){
                $data1['feedback'] = trim($data['disagree_detail']);
                $data1['shenhe'] = 3;
                $res = M('yun_apply')->where(array('id'=>$data['id']))->save($data1);
                if(!$res){
                    $dataAj['status'] = 0;
                    $dataAj['info'] = "审核失败！";
                    $this->ajaxReturn($dataAj);
                }
                $dataAj['status'] = 1;
                $this->ajaxReturn($dataAj);
            }
        }
    }

    public function giftOrder(){
        $telephone      = trim(I("param.telephone"));
        $person_name    = trim(I("param.person_name"));
        $order_no       = trim(I("param.order_no"));
        $starttime      = I("param.starttime");
        $endtime        = I("param.endtime");
        $this->assign('starttime',$starttime);
        $this->assign('endtime',$endtime);

        $this->assign('telephone',$telephone );
        $this->assign('person_name',$person_name );
        $this->assign('order_no',$order_no );
        if($telephone){
            $map['b.telephone']=array('like',"%$telephone%");
        }
        if($person_name){
            $map['b.person_name']=array('like',"%$person_name%");
        }
        if($order_no){
            $map['a.order_no']=array('like',"%$order_no%");
        }
        $order_status=I('param.order_status');
        if($order_status){
            $map['a.order_status']=$order_status==10?0:$order_status;
        }
        if($starttime){
            $starttime      = strtotime($starttime.'00:00:00');
            $endtime        = strtotime($endtime.'23:59:59');
            $map['a.order_time']=array('between',array($starttime,$endtime));
        }
        $count = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->field('b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name')
            ->where($map)
            ->count();
        $Page = getpage($count,5);
        $show  = $Page->show();
        $res=M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->join('left join app_yun_gift as c on a.gift_id=c.id')
            ->field('b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name,c.name as gift_name')
            ->where($map)
            ->limit($Page->firstRow,$Page->listRows)
            ->order('order_time desc')
            ->select();
//dump($res);exit;
        $this->assign("page",$show);
        $this->assign('cache',$res);

        unset($map['a.order_status']);
        $count = M('gift_order') ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->count();
        $count0 = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)
            ->where(array("order_status"=>0))
            ->count();//已取消
        $count1 =  M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)
            ->where(array("order_status"=>1))
            ->count();//待付款
        $count2 = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>2))->count();//待发货
        $count3 = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>3))->count();//待收货
        $count4 = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>4))->count();//已签收
        $count5 = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>5))->count();//已关闭
        $count6 = M('gift_order')
            ->alias('a')
            ->join('left join app_member as b on a.user_id=b.id')
            ->where($map)->where(array("order_status"=>6))->count();//退款
        $this->assign("count",  $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);
        $this->assign("count4", $count4);
        $this->assign("count5", $count5);
        $this->assign("count6", $count6);
        $this->display();

    }


	/*
	
	*云推荐店铺列表
	 */
	/*public function shop(){
			$mp['status'] = array('neq',0);
			$is_sale = I('get.is_sale');
			if($is_sale == 3){
				$mp['status'] = 3;
			}else if($is_sale == 4){
				$mp['status'] = 1;
			}else if($is_sale == 5){
				$mp['status'] = 2;
			}
			$mp['is_del'] = 0;
			$count = M('yun_shop_authentication')->where($mp)->count();
	        $Page = getpage($count, 10);
	        $show = $Page->show();//分页显示输出
			$res = M('yun_shop_authentication')->limit($Page->firstRow . ',' . $Page->listRows)->where($mp)->select();

			//print_r($res);
			//全部店铺
			unset($mp['status']);
			$counts = M('yun_shop_authentication')->where($mp)->count();
			//待审核店铺 0
			$mp['status'] = 3;
			$count3 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count3", $count3);
			//审核通过店铺 1
			$mp['status'] = 1;
			$count4 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count4", $count4);
			//审核拒绝店铺 2
			$mp['status'] = 2;
			$count5 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count5", $count5);



        	$this->assign("counts", $counts);
        	$this->assign("res", $res);
        	$this->assign("page", $show);
			$this->display();

	}
	public function aushopDetail(){
		$id = I('get.id');
		if(!$id){
			$this->ajaxReturn(array('status'=>0,'info'=>'请选择店铺'));
		}
		$res = M('yun_shop_authentication')->where(array('is_del'=>0,'id'=>$id))->find();
		//print_r($res);
		$this->assign('res',$res);
		$this->display();
	}*/
	/*
	*店铺审核通过
	 */
	/*public function shopAgree(){
		if(IS_AJAX){
			$data = I('post.');
			if(trim($data['disagree_detail']) == ""){
				$dataAj['status'] = 0;
				$dataAj['info'] = "评论不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['id']){
				$data1['detail'] = trim($data['disagree_detail']);
				$data1['status'] = 1;
				$res = M('yun_shop_authentication')->where(array('id'=>$data['id']))->save($data1);
				if(!$res){
					$dataAj['status'] = 0;
					$dataAj['info'] = "审核失败！";
					$this->ajaxReturn($dataAj);
				}
				$dataAj['status'] = 1;
				$this->ajaxReturn($dataAj);
			}
		}
	}

	public function shopDisagree(){
		if(IS_AJAX){
			$data = I('post.');
			if(trim($data['disagree_detail']) == ""){
				$dataAj['status'] = 0;
				$dataAj['info'] = "评论不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['id']){
				$data1['detail'] = trim($data['disagree_detail']);
				$data1['status'] = 2;
				$res = M('yun_shop_authentication')->where(array('id'=>$data['id']))->save($data1);
				if(!$res){
					$dataAj['status'] = 0;
					$dataAj['info'] = "审核失败！";
					$this->ajaxReturn($dataAj);
				}
				$dataAj['status'] = 1;
				$this->ajaxReturn($dataAj);
			}
		}
	}*/
	/*
	*法人列表
	 */
	public function legal(){
			$mp['fa_status'] = array('neq',0);
			$is_sale = I('get.is_sale');
			if($is_sale == 3){
				$mp['fa_status'] = 3;
			}else if($is_sale == 4){
				$mp['fa_status'] = 1;
			}else if($is_sale == 5){
				$mp['fa_status'] = 2;
			}
			$mp['is_del'] = 0;
			$count = M('yun_shop_authentication')->where($mp)->count();
	        $Page = getpage($count, 10);
	        $show = $Page->show();//分页显示输出
			$res = M('yun_shop_authentication')->limit($Page->firstRow . ',' . $Page->listRows)->where($mp)->select();

			//print_r($res);
			//全部
			unset($mp['fa_status']);
			$counts = M('yun_shop_authentication')->where($mp)->count();
			//待审核 0
			$mp['fa_status'] = 3;
			$count3 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count3", $count3);
			//审核通过1
			$mp['fa_status'] = 1;
			$count4 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count4", $count4);
			//审核拒绝2
			$mp['fa_status'] = 2;
			$count5 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count5", $count5);



        	$this->assign("counts", $counts);
        	$this->assign("res", $res);
        	$this->assign("page", $show);
			$this->display();
	}
	/*
	*法人详情
	 */
	public function leDetail(){
		$id = I('get.id');
		if(!$id){
			$this->ajaxReturn(array('status'=>0,'info'=>'请重新选择！'));
		}
		$res = M('yun_shop_authentication')->where(array('is_del'=>0,'id'=>$id))->find();
		//print_r($res);
		$this->assign('res',$res);
		$this->display();
	}
	/*
	*法人审核通过
	 */
	public function leAgree(){
		
		if(IS_AJAX){
			$data = I('post.');
			if(trim($data['disagree_detail']) == ""){
				$dataAj['status'] = 0;
				$dataAj['info'] = "评论不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['id']){
				$data1['detail'] = trim($data['disagree_detail']);
				$data1['fa_status'] = 1;
				$res = M('yun_shop_authentication')->where(array('id'=>$data['id'],'is_del'=>0))->save($data1);
				if(!$res){
					$dataAj['status'] = 0;
					$dataAj['info'] = "审核失败！";
					$this->ajaxReturn($dataAj);
				}
				$dataAj['status'] = 1;
				$dataAj['info'] = "审核成功！";
				$this->ajaxReturn($dataAj);
			}
		}
	}
	/*
	*法人审核失败
	 */
	public function leDisagree(){
		
		if(IS_AJAX){
			$data = I('post.');
			if(trim($data['disagree_detail']) == ""){
				$dataAj['status'] = 0;
				$dataAj['info'] = "评论不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['id']){
				$data1['detail'] = trim($data['disagree_detail']);
				$data1['fa_status'] = 2;
				$res = M('yun_shop_authentication')->where(array('id'=>$data['id']))->save($data1);
				if(!$res){
					$dataAj['status'] = 0;
					$dataAj['info'] = "审核失败！";
					$this->ajaxReturn($dataAj);
				}
				$dataAj['status'] = 1;
				$this->ajaxReturn($dataAj);
			}
		}
	}
	/*
	*证件列表
	 */
	public function certificates(){
			$mp['bus_status'] = array('neq',0);
			$is_sale = I('get.is_sale');
			if($is_sale == 3){
				$mp['bus_status'] = 3;
			}else if($is_sale == 4){
				$mp['bus_status'] = 1;
			}else if($is_sale == 5){
				$mp['bus_status'] = 2;
			}
			$mp['is_del'] = 0;
			$count = M('yun_shop_authentication')->where($mp)->count();
	        $Page = getpage($count, 10);
	        $show = $Page->show();//分页显示输出
			$res = M('yun_shop_authentication')->limit($Page->firstRow . ',' . $Page->listRows)->where($mp)->select();

			//print_r($res);
			//全部
			unset($mp['bus_status']);
			$counts = M('yun_shop_authentication')->where($mp)->count();
			//待审核 0
			$mp['bus_status'] = 0;
			$count3 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count3", $count3);
			//审核通过1
			$mp['bus_status'] = 1;
			$count4 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count4", $count4);
			//审核拒绝2
			$mp['bus_status'] = 2;
			$count5 = M('yun_shop_authentication')->where($mp)->count();
        	$this->assign("count5", $count5);



        	$this->assign("counts", $counts);
        	$this->assign("res", $res);
        	$this->assign("page", $show);
			$this->display();
	}

	/*
	*证件详情
	 */
	public function ceDetail(){
		$id = I('get.id');
		if(!$id){
			$this->ajaxReturn(array('status'=>0,'info'=>'请重新选择！'));
		}
		$res = M('yun_shop_authentication')->where(array('is_del'=>0,'id'=>$id))->find();
		//print_r($res);
		$this->assign('res',$res);
		$this->display();
	}
	/*
	*证件审核通过
	 */
	public function ceAgree(){
		
		if(IS_AJAX){
			$data = I('post.');
			if(trim($data['disagree_detail']) == ""){
				$dataAj['status'] = 0;
				$dataAj['info'] = "评论不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['id']){
				$data1['bus_detail'] = trim($data['disagree_detail']);
				$data1['bus_status'] = 1;
				$res = M('yun_shop_authentication')->where(array('id'=>$data['id'],'is_del'=>0))->save($data1);
				if(!$res){
					$dataAj['status'] = 0;
					$dataAj['info'] = "审核失败！";
					$this->ajaxReturn($dataAj);
				}
				$dataAj['status'] = 1;
				$dataAj['info'] = "审核成功！";
				$this->ajaxReturn($dataAj);
			}
		}
	}
	/*
	*证件审核失败
	 */
	public function ceDisagree(){
		
		if(IS_AJAX){
			$data = I('post.');
			if(trim($data['disagree_detail']) == ""){
				$dataAj['status'] = 0;
				$dataAj['info'] = "评论不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['id']){
				$data1['bus_detail'] = trim($data['disagree_detail']);
				$data1['bus_status'] = 2;
				$res = M('yun_shop_authentication')->where(array('id'=>$data['id']))->save($data1);
				if(!$res){
					$dataAj['status'] = 0;
					$dataAj['info'] = "审核失败！";
					$this->ajaxReturn($dataAj);
				}
				$dataAj['status'] = 1;
				$this->ajaxReturn($dataAj);
			}
		}
	}
}

