<?php
/*
	*ZQJ
*/
namespace Admin\Controller;
use Common\Controller\CommonController;
class CallforpaperController extends CommonController {
   
   //征稿列表
    public function index(){
		$name=I('get.name');
		$start=I('get.is_sale');
        $this->assign('title',$name);
		 if($name)
        {
            $map['n.number'] = $name;
        }
		
		$map['p.is_del'] = 0;
		$map['n.is_del'] = 0;
		if($start != null)
        {
            $map['p.start'] = $start;
        }
		$counts1 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		$Page  = getpage($counts1,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		
		$arr_user = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->order('n.number asc')->limit($Page->firstRow.','.$Page->listRows)->field(array('p.id','n.number','n.theme','n.contonts','m.person_name','n.start_time','n.end_time','p.start','p.picp','n.picn'))->select();
		unset($map['p.start']);
		$counts = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		$map['p.start'] = 0;
		$counts3 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		$map['p.start'] = 1;
		$counts4 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		$map['p.start'] = 2;
		$counts5 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		//print_r($arr_user);
		$this->assign('zhenggao',$arr_user);
		$this->assign('counts',$counts);
		$this->assign('count3',$counts3);
		$this->assign('count4',$counts4);
		$this->assign('count5',$counts5);
        $this->display();
    }
	//征稿详情
	public function editPaper(){
		
		$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		$mp['p.id'] = $id;
		$mp['p.is_del'] = 0;
		$mp['n.is_del'] = 0;
		$fields = array('p.id','p.zpbute','n.number','n.judgeid','n.theme','n.contonts','p.author','p.phone','p
		.email','p.wname','p.wtype','wsize','wmaterial','sfid','p.picp','wpic1','wpic2','wpic3','wpic4','start_time','end_time','person_detail','zuo_detail','p.counts','p.visits','p.start','p.disagree_detail');
		$paper_list = M("paper_list as p")->join("left join app_number_list as n on n.id = p.number_id")->field($fields)->where($mp)->find();
		//print_r($paper_list);
		//评委列表
		$map['is_del'] = 0;
		$judges = M('judges')->where($map)->select();

        //作品属性
        $attrList = M("zpbute")->where(array('pid'=>0))->select();
        $attrMap1['id'] = array('in',$paper_list['zpbute']);
        foreach ($attrList as $a=>$b){
            $attrMap1['pid'] = $b['id'];
            $attrList[$a]['child'] = M("zpbute")->where($attrMap1)->select();
        }
        //print_r($attrList);
        if($attrList){
            $this->assign('counattr',M("zpbute")->where(array('pid'=>0))->count());
            $this->assign('attrList',$attrList);
        }


		$this->assign('judges',$judges);
		$this->assign('ids',explode(',',$paper_list['judgeid']));
	    $this->assign('paper_list',$paper_list);
		$this->display();
	}
	
	//发布信息
	public function release(){
        $name=I('get.name');
        $this->assign('title',$name);
		 if($name)
        {
            $map['number'] = $name;
        }
		$map['is_del'] = 0;

		$nu = M('number_list');
		$counts = $nu->where($map)->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
		
		$number = $nu->where($map)->order('number asc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("page",$show);
		$this->assign('counts',$counts);
		$this->assign('num',$number);
        $this->display();
    }
	
	//期数不能重复
	public function ajaxNumber(){
		if(IS_AJAX){
			$number = $_POST['number'];
			if(!preg_match("/^\d*$/",$number)){
				 $this->ajaxReturn(array('status'=>0, "info"=>"期数请输入数字！"));exit;
			}
			$res = M('number_list')->where(array('number'=>$number,'is_del'=>0))->select();//$_POST['number']
	        if($res){
	            $this->ajaxReturn(array('status'=>0, "info"=>"期数已存在！"));exit;
	        }
	         $this->ajaxReturn(array('status'=>1));die;
		}
		
	}
	/**
     * 发布期数
     */
	public function addRelease(){
		if(IS_AJAX){
			$data1 = I('post.');
			//var_dump($data1);die;
			if($data1['endtime']){

				if(strtotime($data1['endtime']) < strtotime(date('Y-m-d'))){
					$dataAj['status'] = 0;
					$dataAj['info'] = '大赛结束时间不能早于当前时间！';
					$dataAj['data'] = $data1;
					$this->ajaxReturn($dataAj);die;
				}
			}
			if(!trim($data1['detail'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = '请输入主题描述！';
				$this->ajaxReturn($dataAj);die;
			}
			/*if(!$data1['judges']){
				$dataAj['status'] = 0;
				$dataAj['info'] = '至少添加一名评委！';
				$this->ajaxReturn($dataAj);die;
			}*/
			//$dataAj['status'] = 1;
			//$this->ajaxReturn($dataAj);
            $data = I('post.');
            $datan['number']=$data['title'];
            $datan['theme']=$data['theme'];
            $datan['contonts']=$data['detail'];
            $datan['start_time']=strtotime($data['starttime']);
            $datan['collectiontime']=strtotime($data['collectiontime']);//征集作品结束时间
            $datan['selectiontime']=strtotime($data['selectiontime']);//作品评选结束时间
           if($data['endtime']){
			   $datan['end_time']=strtotime($data['endtime']);
		   }else{
			   $datan['end_time'] = '';
		   }
            $datan['contractor1']=$data['contractor1'];
            $datan['contractor2']=$data['contractor2'];
            if($data['judges'] != ''){
                $datan['judgeId']=implode(',',$data['judges']);
            }else{
                $datan['judgeId'] = 0;
            }

            if($data['pic']){
                $datan['picn']=$data['pic'];
                unset($data['pic']);
            }
            if($data['piccon1']){
                $datan['piccon1']=$data['piccon1'];
            }
            if($data['piccon2']){
                $datan['piccon2']=$data['piccon2'];
            }
            $res = M('number_list')->add($datan);
            if($res){
                $datap['number_id']=$res ;
                $datap['first_name']=$data['first_name'];
                $datap['second_name']=$data['second_name'];
                $datap['third_name']=$data['third_name'];
                $datap['create_name']=$data['create_name'];

                $datap['first_number']=$data['first_number'];
                $datap['second_number']=$data['second_number'];
                $datap['third_number']=$data['third_number'];
                $datap['create_number']=$data['create_number'];

                $datap['first_money']=$data['first_money'];
                $datap['second_money']=$data['second_money'];
                $datap['third_money']=$data['third_money'];
                $datap['create_money']=$data['create_money'];


                if($data['pic3']){
                    $datap['first_picture']=$data['pic3'];
                }
                if($data['pic4']){
                    $datap['second_picture']=$data['pic4'];
                }
                if($data['pic5']){
                    $datap['third_picture']=$data['pic5'];
                }
                if($data['pic6']){
                    $datap['create_picture']=$data['pic6'];
                }

                //if(!$data['pic3'] && !$data['pic4'] && !$data['pic5'] && !$data['pic6']){
                if($data['pic3'] || $data['pic4'] || $data['pic5'] || $data['pic6']){
                    $cc=M('prize')->add($datap);
                    if(!$cc){
                        $this->error("添加失败", U('Admin/Callforpaper/release', '', false));exit;
                    }else{

                    }
                }
                $this->success("添加成功!", U('Admin/Callforpaper/release', '', false));exit;
                /*if($cc){
                    $this->success("添加成功!", U('Admin/Callforpaper/release', '', false));exit;
                }else{
                    $this->error("添加失败", U('Admin/Callforpaper/release', '', false));exit;
                }*/
            }else{
                $this->error("添加失败", U('Admin/Callforpaper/release', '', false));exit;
            }
		}
		
		//评委列表
		$judges = M('judges')->where(array('is_del'=>0))->select();
		$this->assign('judges',$judges);
		$this->display();
	}
	/**
     * 编辑期数
     */
	public function editRelease(){
		header("Content-Type:text/html;charset=utf-8;");
		if(IS_AJAX){
            $data1 = I('post.');
            //var_dump($data1);die;
			if($data1['endtime']){
				if(strtotime($data1['endtime']) < strtotime(date('Y-m-d'))){
					$dataAj['status'] = 0;
					$dataAj['info'] = '大赛结束时间不能早于当前时间！';
					$dataAj['data'] = $data1;
					$this->ajaxReturn($dataAj);die;
				}
			}
            if(!trim($data1['detail'])){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请输入主题描述！';
                $this->ajaxReturn($dataAj);die;
            }
            /*if(!$data1['judges']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '至少添加一名评委！';
                $this->ajaxReturn($dataAj);die;
            }*/
			$nu = M('number_list');
			$data  = I("post.");
			$datan['number']=$data['title'];
			$datan['theme']=$data['theme'];
			$datan['contonts']=$data['detail'];
			$datan['start_time']=strtotime($data['starttime']);
			if($data['endtime']){
				$datan['end_time']=strtotime($data['endtime']);
			}else{
				$datan['end_time'] = '';
			}
			$datan['collectiontime']=strtotime($data['collectiontime']);//征集作品结束时间
			$datan['selectiontime']=strtotime($data['selectiontime']);//作品评选结束时间
			
			$datan['contractor1']=$data['contractor1'];//承办方
			$datan['contractor2']=$data['contractor2'];
			
			if($data['judges']){
				$datan['judgeId']=implode(',',$data['judges']);
			}
			
			$datap['first_name']=$data['first_name'];
			$datap['second_name']=$data['second_name'];
			$datap['third_name']=$data['third_name'];
			$datap['create_name']=$data['create_name'];
			
			$datap['first_number']=$data['first_number'];
			$datap['second_number']=$data['second_number'];
			$datap['third_number']=$data['third_number'];
			$datap['create_number']=$data['create_number'];
			
			$datap['first_money']=$data['first_money'];
			$datap['second_money']=$data['second_money'];
			$datap['third_money']=$data['third_money'];
			$datap['create_money']=$data['create_money'];
			
			unset($data['starttime']);
			unset($data['endtime']);
			if(!$data['id']){
				  $this->error("缺少参数！");
			}
			$id = $data['id'];
			unset($data['id']);
			
			if($data['pic']){
				$datan['picn']=$data['pic'];
				unset($data['pic']);
			}
			if($data['piccon1']){
				$datan['piccon1']=$data['piccon1'];
			}
			if($data['piccon2']){
				$datan['piccon2']=$data['piccon2'];
			}
			if($data['pic3']){
				$datap['first_picture']=$data['pic3'];
			}
			if($data['pic4']){
				$datap['second_picture']=$data['pic4'];
			}
			if($data['pic5']){
				$datap['third_picture']=$data['pic5'];
			}
			if($data['pic6']){
				$datap['create_picture']=$data['pic6'];
			}
            if($data['pic3'] || $data['pic4'] || $data['pic5'] || $data['pic6']){
                M('prize')->where(array('number_id'=>$id))->save($datap);

            }
			$res =$nu->where(array('id'=>$id))->save($datan);
			//$id_del=M('prize')->where(array('number_id'=>$id))->getField('is_del');
			//M('prize')->where(array('number_id'=>$id))->save($datap);
			if ($res !== false) {
                 //$this->redirect('Admin/Callforpaper/release');
				 $this->success("修改成功！",U('Admin/Callforpaper/release'));die;
            } else {
                $this->error("修改失败！",U('Admin/Callforpaper/release'));die;
            }
		}
		$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		$number=M('number_list')->where(array('id'=>$id, "is_del"=>0))->find();
	    // if(!$number){
		   // echo "<script>alert('无此大赛期数！');window.history.back();</script>";die;
	    // }
	    
		$prize=M('prize')->where(array('number_id'=>$id,'is_del'=>0))->find();
		
		//评委列表
		$map['is_del'] = 0;
		$judges = M('judges')->where($map)->select();
		
		$this->assign('judges',$judges);
	    $this->assign('number',$number);
		$this->assign('ids',explode(',',$number['judgeid']));
	    $this->assign('prize',$prize);
		$this->display();
	}
	/**
     * 删除期数
     */
	public function delRelease(){
		header("Content-Type:text/html;charset=utf-8;");
		$id  = $_GET['id'];
        $res = M("number_list")->where(array("id"=>$id))->save(array("is_del"=>1));
		M("prize")->where(array("number_id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！",U('Admin/Callforpaper/release'));die;
        }
        $this->error("删除失败！",U('Admin/Callforpaper/release'));die;
	}
	/**
     * 删除征稿
     */
    public function delPaper(){
        $id  = $_GET['id'];
        $res = M("paper_list")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
	/**
     * 审核
     */
    public function agree(){
        $res = M('paper_list')->where(array('id'=>$_POST['id']))->save(array('start'=>1,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核通过失败！"));
        }
    }

    public function disagree(){
        $res = M('paper_list')->where(array('id'=>$_POST['id']))->save(array('start'=>2,'disagree_detail'=>$_POST['disagree_detail']?$_POST['disagree_detail']:"拒绝审核！"));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }
	
	//奖品列表
	public function prize_list(){
		$name=I('get.name');
        $this->assign('title',$name);
		 if($name)
        {
            $map['n.number'] = $name;
        }
		$map['p.is_del'] = 0;
		$map['n.is_del'] = 0;
		$counts=M('prize as p')->join('left join app_number_list as n on n.id = p.number_id')->field(array('p.*','n.number','n.theme','n.picn'))->where($map)->count();
        $Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		$prize=M('prize as p')->join('left join app_number_list as n on n.id = p.number_id')->field(array('p.*','n.number','n.theme','n.picn'))->where($map)->order('n.number asc')->limit($Page->firstRow.','.$Page->listRows)->select();

		$this->assign('prize',$prize);
		$this->assign('counts',$counts);
		$this->display();
	}
	/**
     * 添加奖品信息
     */
	 public function addprize(){
		 header("Content-Type:text/html;charset=utf-8");
		$nu=M('number_list');
		 if(IS_AJAX){
		
			 $number_ids= M('prize')->where(array('is_del'=>0))->select();
			 $ids=array();
			 foreach($number_ids as $key=>$val){
				 $ids[]=$val['number_id'];
			 }
			$mp['id']=array('not in',$ids);
			$mp['is_del']=0;
			$nu=$nu->where($mp)->select();
			if(!$nu){
				//echo "<script>alert('没有可以添加奖品的期数！');window.history.back();</script>";die;
				 $dataAja['status']=0;
				 $dataAja['info'] = '没有可以添加奖品的大赛期数！';
				 $this->ajaxReturn($dataAja);die;
			}
			$dataAja['status']=1;
			 $this->ajaxReturn($dataAja);die;
		 }
		 if(IS_POST){
			$data = I('post.');
			$datap['number_id']=$data['title'];
			$datap['first_name']=$data['first_name'];
			$datap['second_name']=$data['second_name'];
			$datap['third_name']=$data['third_name'];
			$datap['create_name']=$data['create_name'];
			
			$datap['first_picture']=$data['pic3'];
			$datap['second_picture']=$data['pic4'];
			$datap['third_picture']=$data['pic5'];
			$datap['create_picture']=$data['pic6'];
			
			$datap['first_number']=$data['first_number'];
			$datap['second_number']=$data['second_number'];
			$datap['third_number']=$data['third_number'];
			$datap['create_number']=$data['create_number'];
			
			$datap['first_money']=$data['first_money'];
			$datap['second_money']=$data['second_money'];
			$datap['third_money']=$data['third_money'];
			$datap['create_money']=$data['create_money'];
			
			
			$cc=M('prize')->add($datap);
			if($cc){
				$this->success("添加成功!", U('Admin/Callforpaper/prize_list', '', false));exit;
				
			}else{
				$this->error("添加失败", U('Admin/Callforpaper/prize_list', '', false));exit;
			}
        }
		$nu=M('number_list');
		
		$number_ids= M('prize')->where(array('is_del'=>0))->select();
		$ids=array();
		foreach($number_ids as $key=>$val){
			$ids[]=$val['number_id'];
		}
		$mp['id']=array('not in',$ids);
		$mp['is_del']=0;
		$nu=$nu->where($mp)->select();
		
		$this->assign('number',$nu);
		$this->display();
	 }
	/**
     * 修改奖品信息
     */
	public function editprize(){
		header("Content-Type:text/html;charset=utf-8;");
		if(IS_POST){
			$data  = I("post.");
			$datap['first_name']=$data['first_name'];
			$datap['second_name']=$data['second_name'];
			$datap['third_name']=$data['third_name'];
			$datap['create_name']=$data['create_name'];
			
			$datap['first_number']=$data['first_number'];
			$datap['second_number']=$data['second_number'];
			$datap['third_number']=$data['third_number'];
			$datap['create_number']=$data['create_number'];
			
			$datap['first_money']=$data['first_money'];
			$datap['second_money']=$data['second_money'];
			$datap['third_money']=$data['third_money'];
			$datap['create_money']=$data['create_money'];
			if(!$data['id']){
				  $this->error("缺少参数！");
			}
			$id = $data['id'];
			unset($data['id']);
			if($data['pic']){
				$data['picn']=$data['pic'];
				unset($data['pic']);
			}
			if($data['pic3']){
				$datap['first_picture']=$data['pic3'];
			}
			if($data['pic4']){
				$datap['second_picture']=$data['pic4'];
			}
			if($data['pic5']){
				$datap['third_picture']=$data['pic5'];
			}
			if($data['pic6']){
				$datap['create_picture']=$data['pic6'];
			}
			$res=M('prize')->where(array('number_id'=>$id))->save($datap);
			if ($res !== false) {
                $this->success("修改成功！",U('Admin/Callforpaper/prize_list'),'',false);die;
            } else {
                $this->error("修改失败！",U('Admin/Callforpaper/prize_list'),'',false);die;
            }
		}
		
		$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		
		$prize=M('prize')->where(array('id'=>$id))->find();
	    // if(!$prize){
		   // echo "<script>alert('无此奖品！');window.history.back();</script>";die;
	    // }
	    
		$number=M('number_list')->where(array('id'=>$prize['number_id'], "is_del"=>0))->find();
		
		// if(!$number){
		   // echo "<script>alert('无此期数！');window.history.back();</script>";die;
	    // }
		// foreach($number  as $key=> $val){
			// $number[$key]['contonts'] = strip_tags($val['contonts']);
	
		// }	print_r($number);
		$this->assign('prize',$prize);
		$this->assign('number',$number);
		$this->display();
	}
	
	/**
     * 删除奖品信息
     */
	 // public function delPrize(){
		 
		// $id  = $_GET['id'];
        // $res = M("prize")->where(array("id"=>$id))->save(array("is_del"=>1));
        // if($res!==false){
            // $this->success("删除成功！");die;
        // }
        // $this->error("删除失败！");die;
	 // }
    /*
*作品属性列表
*/
    public function zpbute(){
        if(IS_AJAX){
            $id       = I("post.categoryid");
            $classname = I("post.classname");
            $pid       = I("post.pid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $m = M("zpbute");
            $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0))->find();
            if(!$id && $res){
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
        $m = M("zpbute");
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
    /*
    *作品属性添加修改
     */
    // public function addzpsx(){

    // 	$this->display();
    // }
    /*
    *作品属性列表
     */
    public function delzpsx(){
        $id  = $_GET['id'];
        $m = M("zpbute");
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
	/**
     * 作品尺寸
     */
	 public function wsize(){
		 
		$counts = M('size as s')->where(array('is_del'=>0))->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		$sizes = M('size as s')->limit($Page->firstRow.','.$Page->listRows)->where(array('is_del'=>0))->select();
		//print_r($sizes);
		$this->assign('sizes',$sizes);
		$this->assign('counts',$counts);
		$this->display();
	 }
	/**
     * 作品尺寸编辑
     */
	 public function editWsize(){
		header("Content-Type:text/html;charset=utf-8");
		
		
		if(IS_AJAX){
			$data1 = I('get.');
			if(!trim($data1['sname'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入尺寸名！";
				$this->ajaxReturn($dataAj);
			}
			if($data1['sid']){
				$sname1 =  M('size')->where(array('id'=>$data1['sid']))->getField('sname');
				if($sname1){
					if($sname1 != $data1['sname']){
						$sname = M('size')->where(array('sname'=>trim($data1['sname']),'is_del'=>0))->select();
						if($sname){
							$dataAj['status'] = 0;
							$dataAj['info'] = "该尺寸已存在！";
							$this->ajaxReturn($dataAj);
						}
					}
				}
				
			}else{
				$sname = M('size')->where(array('sname'=>trim($data1['sname']),'is_del'=>0))->select();
				if($sname){
					$dataAj['status'] = 0;
					$dataAj['info'] = "该尺寸已存在！";
					$this->ajaxReturn($dataAj);
				}
			}
			if(!trim($data1['minrange'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入最小尺寸！";
				$this->ajaxReturn($dataAj);
			}
			if(!trim($data1['maxrange'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入最大尺寸！";
				$this->ajaxReturn($dataAj);
			}
			if(!preg_match("/^\d*$/",$data1['minrange'] )){
				//echo "<script>alert('请输入数字');window.history.back();</script>";die;
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入数字!";
				$this->ajaxReturn($dataAj);
			}
			if(!preg_match("/^\d*$/",$data1['maxrange'] )){
				//echo "<script>alert('请输入数字');window.history.back();</script>";die;
				$dataAj['status'] = 0;
				$dataAj['info'] = "请输入数字！";
				$this->ajaxReturn($dataAj);
			}
			if($data1['minrange'] >= $data1['maxrange']){
				//echo "<script>alert('最小尺寸应该小于最大尺寸');window.history.back();</script>";die; 
				$dataAj['status'] = 0;
				$dataAj['info'] = "最小尺寸应该小于最大尺寸";
				$this->ajaxReturn($dataAj);
			}
			
			
			
			$dataAj['status'] = 1;
			$this->ajaxReturn($dataAj);
			
		}
		$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		if(IS_POST){
			$data = I('post.');
			$datas['sname'] = $data['sname'];
			$datas['minRange'] = $data['minrange'];
			$datas['maxRange'] = $data['maxrange'];
			$cc=M('size')->where(array('id'=>$id))->save($datas);
			if($cc){
				$this->success("修改成功!", U('Admin/Callforpaper/wsize', '', false));exit;
				
			}else{
				$this->error("修改失败", U('Admin/Callforpaper/wsize', '', false));exit;
			}
        }
		
		$wsize = M('size')->where(array('id'=>$id))->find();
		$this->assign('wsize',$wsize);
		$this->display();
	 }
	 public function ccYz(){
		 
	 }
	 /**
     * 添加尺寸
     */
	 public function addWsize(){
		 header("Content-Type:text/html;charset=utf-8");
		 if(IS_POST){
			$data = I('post.');
			$datas['sname'] = $data['sname'];
			//if($data['minrange'] >= $data['maxrange']){echo "<script>alert('最小尺寸应该小于最大尺寸');window.history.back();</script>";die; }
			$datas['minRange'] = $data['minrange'];
			$datas['maxRange'] = $data['maxrange'];
			$cc=M('size')->add($datas);
			if($cc){
				$this->success("添加成功!", U('Admin/Callforpaper/wsize', '', false));exit;
				
			}else{
				$this->error("添加失败", U('Admin/Callforpaper/wsize', '', false));exit;
			}
        }

		
		$this->display();
	 }
	 /**
     * 删除作品尺寸
     */
	 public function delWsize(){
		 
		$id  = $_GET['id'];
		if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $res = M("size")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！", U('Admin/Callforpaper/wsize', '', false));die;
        }
        $this->error("删除失败！", U('Admin/Callforpaper/wsize', '', false));die;
	 }
	 
	 
	 /**
     * 作品类型
     */
	 public function wtype(){
		 
		$counts = M('wtype as s')->where(array('is_del'=>0))->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		$wtype = M('wtype as s')->limit($Page->firstRow.','.$Page->listRows)->where(array('is_del'=>0))->select();
		//print_r($sizes);
		$this->assign('wtype',$wtype);
		$this->assign('counts',$counts);
		$this->display();
	 }
	/**
     * 作品类型编辑
     */
	 public function editWtype(){
		header("Content-Type:text/html;charset=utf-8");
		if(IS_AJAX){
			$data  = I('get.');
			if(!trim($data['wtype'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "类型不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['eid']){
				$wtype = M('wtype')->where(array('id'=>$data['eid'],'is_del'=>0))->getField('wtype');
				if(trim($wtype) != $data['wtype']){
					$wtype = M('wtype')->where(array('wtype'=>trim($data['wtype']),'is_del'=>0))->select();
					if($wtype){
						$dataAj['status'] = 0;
						$dataAj['info'] = "不能重复添加类型！";
						$this->ajaxReturn($dataAj);
					}
				}
			}else{
				$wtype = M('wtype')->where(array('wtype'=>trim($data['wtype']),'is_del'=>0))->select();
				if($wtype){
					$dataAj['status'] = 0;
					$dataAj['info'] = "不能重复添加类型！";
					$this->ajaxReturn($dataAj);
				}
					
					
			}
					$dataAj['status'] = 1;
					$this->ajaxReturn($dataAj);
			
		}
		$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		if(IS_POST){
			$data = I('post.');
			
			// if($data['wtype'] == M('wtype')->where(array('id'=>$id))->getField('wtype')){
				 // echo "<script>alert('不能重复添加类型！');window.history.back();</script>";die;
			// }
			$datas['wtype'] = $data['wtype'];
			$cc=M('wtype')->where(array('id'=>$id))->save($datas);
			if($cc){
				$this->success("编辑成功!", U('Admin/Callforpaper/wtype', '', false));exit;
				
			}else{
				$this->error("编辑失败", U('Admin/Callforpaper/wtype', '', false));exit;
			}
        }
		
		$wtype = M('wtype')->where(array('id'=>$id))->find();
		$this->assign('wtype',$wtype);
		$this->display();
	 }
	 /**
     * 添加类型
     */
	 public function addWtype(){
		 header("Content-Type:text/html;charset=utf-8");
		 if(IS_POST){
			$data = I('post.');
			$datas['wtype'] = $data['wtype'];
			
			$cc=M('wtype')->add($datas);
			if($cc){
				$this->success("添加成功!", U('Admin/Callforpaper/wtype', '', false));exit;
				
			}else{
				$this->error("添加失败", U('Admin/Callforpaper/wtype', '', false));exit;
			}
        }

		
		$this->display();
	 }
	 /**
     * 删除作品类型
     */
	 public function delWtype(){
		 
		header("Content-Type:text/html;charset=utf-8");
		$id  = $_GET['id'];
		if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $res = M("wtype")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
	 }
	 
	 
	 /**
     * 作品材质
     */
	 public function wmaterial(){
		 
		$counts = M('wmaterial as s')->where(array('is_del'=>0))->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		$wmaterial = M('wmaterial as s')->limit($Page->firstRow.','.$Page->listRows)->where(array('is_del'=>0))->select();
		//print_r($sizes);
		$this->assign('wmaterial',$wmaterial);
		$this->assign('counts',$counts);
		$this->display();
	 }
	/**
     * 作品材质编辑
     */
	 public function editWmaterial(){
		header("Content-Type:text/html;charset=utf-8");
		if(IS_AJAX){
			$data  = I('get.');
			if(!trim($data['wmaterial'])){
				$dataAj['status'] = 0;
				$dataAj['info'] = "材质不能为空！";
				$this->ajaxReturn($dataAj);
			}
			if($data['eid']){
				$wmaterial = M('wmaterial')->where(array('id'=>$data['eid'],'is_del'=>0))->getField('wmaterial');
				if(trim($wmaterial) != trim($data['wmaterial'])){
					$wmaterial = M('wmaterial')->where(array('wmaterial'=>trim($data['wmaterial']),'is_del'=>0))->select();
					if($wmaterial){
						$dataAj['status'] = 0;
						$dataAj['info'] = "不能重复添加材质！";
						$this->ajaxReturn($dataAj);
					}
				}
			}else{
				$wmaterial = M('wmaterial')->where(array('wmaterial'=>trim($data['wmaterial']),'is_del'=>0))->select();
				if($wmaterial){
					$dataAj['status'] = 0;
					$dataAj['info'] = "不能重复添加材质！";
					$this->ajaxReturn($dataAj);
				}
					
					
			}
					$dataAj['status'] = 1;
					$this->ajaxReturn($dataAj);
			
		}
		
		
		$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		if(IS_POST){
			$data = I('post.');
			
			// if($data['wmaterial'] == M('wmaterial')->where(array('id'=>$id))->getField('wmaterial')){
				 // echo "<script>alert('不能重复添加材质！');window.history.back();</script>";die;
			// }
			$datas['wmaterial'] = $data['wmaterial'];
			$cc=M('wmaterial')->where(array('id'=>$id))->save($datas);
			if($cc){
				$this->success("编辑成功!", U('Admin/Callforpaper/wmaterial', '', false));exit;
				
			}else{
				$this->error("编辑失败", U('Admin/Callforpaper/wmaterial', '', false));exit;
			}
        }
		
		$wmaterial = M('wmaterial')->where(array('id'=>$id))->find();
		$this->assign('wmaterial',$wmaterial);
		$this->display();
	 }
	 /**
     * 添加材质
     */
	 public function addWmaterial(){
		header("Content-Type:text/html;charset=utf-8");
		 if(IS_POST){
			$data = I('post.');
			$datas['wmaterial'] = $data['wmaterial'];
			
			$cc=M('wmaterial')->add($datas);
			if($cc){
				$this->success("添加成功!", U('Admin/Callforpaper/wmaterial', '', false));exit;
				
			}else{
				$this->error("添加失败", U('Admin/Callforpaper/wmaterial', '', false));exit;
			}
        }
		$this->display();
	 }
	 /**
	 /**
     * 删除作品材质
     */
	 public function delWmaterial(){
		 
		$id  = $_GET['id'];
		if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
        $res = M("wmaterial")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
	 }
	 
	 
	 
	 
	/**
     * 评委列表
     */	
	public function judges(){
		$name=trim(I('get.name'));
		 if($name)
        {
            $mp['aname'] = array('like','%'.$name.'%');
        }
        $this->assign('title',$name);
		$mp['is_del'] = 0;
		$counts = M('judges')->where($mp)->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		$judges = M('judges')->where($mp)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('judges',$judges);
		$this->assign('counts',$counts);
		$this->display();
	}
	
	/**
     * 添加评委
     */	
	public function addJudges(){
		header("Content-Type:text/html;charset=utf-8;");
		if(IS_AJAX){
			$data2 = I('get.');
			if(!trim($data2['aname'])){
				//echo "<script>alert('评委姓名不能为空！');window.history.back();</script>";die;
				$data1['status'] = 0;
				$data1['info'] = '评委姓名不能为空！';
				
				$this->ajaxReturn($data1);die;
			}
			if(!trim(strip_tags($data2['content']))){
				//echo "<script>alert('评委简介不能为空！');window.history.back();</script>";die;
				$data1['status'] = 0;
				$data1['info'] = '评委简介不能为空！';
				$this->ajaxReturn($data1);die;
			}
				$data1['status'] = 1;	
				$this->ajaxReturn($data1);die;
		}
		if(IS_POST){
			$data = I('post.');
			$dataj['aname'] = trim($data['aname']);
			$dataj['school'] = trim($data['school']);
			$dataj['adetail'] = trim($data['content']);
			if($data['news_pic']){
				
				$dataj['picj'] = $data['news_pic'];
			}
			$cc=M('judges')->add($dataj);
			if($cc){
				$this->success("添加成功!", U('Admin/Callforpaper/judges', '', false));exit;
				
			}else{
				$this->error("添加失败", U('Admin/Callforpaper/judges', '', false));exit;
			}
        }
		$nu=M('number_list');
		$mp['is_del']=0;
		$nu=$nu->where($mp)->select();
		$this->assign('numbers',$nu);
		$this->display();
	}
	/*
	*判断评委
	*/
	public function ajaxJudges(){
		$this->display();
	}
	
	/**
     * 修改评委
     */	
	public function editJudges(){
		header("Content-Type:text/html;charset=utf-8;");
		if(IS_POST){
			$data = I('post.');
			$dataj['aname'] = trim($data['aname']);
			$dataj['school'] = trim($data['school']);
			$dataj['adetail'] = trim($data['content']);
			if($data['news_pic']){
				
				$dataj['picj'] = $data['news_pic'];
			}
			if($data['jid']){
				$jid=$data['jid'];
				unset($data['jid']);
			}
			$cc=M('judges')->where(array('id'=>$jid))->save($dataj);
			if($cc){
				$this->success("修改成功!", U('Admin/Callforpaper/judges', '', false));exit;
				
			}else{
				$this->error("修改失败", U('Admin/Callforpaper/judges', '', false));exit;
			}
        }
		
      	$id = I("get.id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		$judges = M('judges')->where(array('id'=>$id,'is_del'=>0))->find();
		$nu=M('number_list');
		$mp['is_del']=0;
		$nu=$nu->where($mp)->select();
		$this->assign('numbers',$nu);
		$this->assign('judges',$judges);
		$this->display();
	}
	
	/**
     * 删除评委
     */
	 public function delJudges(){
		 
		$id  = $_GET['id'];
		if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";die;
        }
		
        $res = M("judges")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $this->success("删除成功！", U('Admin/Callforpaper/judges', '', false));die;
        }
        $this->error("删除失败！", U('Admin/Callforpaper/judges', '', false));die;
	 }
		
	//投票
	public function vote(){
		$name=I('get.name');
		$start=I('get.is_sale');
        $this->assign('title',$name);
		 if($name)
        {
            $map['n.number'] = $name;
        }
		if($start !=null)
        {
            $map['p.start'] = $start;
        }else{
			 $map['p.start'] = 1;
		}
		$map['p.is_del'] = 0;
		$map['n.is_del'] = 0;
		
		$counts = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		
		$arr_user = M('paper_list as p')->join('left join app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->order('p.counts desc')->limit($Page->firstRow.','.$Page->listRows)->field(array('p.id','n.number','n.theme','n.contonts','m.person_name','n.start_time','n.end_time','p.start','p.counts','p.picp','n.picn'))->select();
		
		$map['p.start'] = 0;
		$counts3 = M('paper_list as p')->join('left join app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		
		$map['p.start'] = 1;
		$counts4 = M('paper_list as p')->join('left join app_number_list as n on n.id = p.number_id')->join('app_member as m on m.id = p.member_id')->where($map)->count();
		$this->assign('zhenggao',$arr_user);
		$this->assign('counts',$counts);
		$this->assign('count3',$counts3);
		$this->assign('count4',$counts4);
        $this->display();
    }
	/**
     * 颁奖
     */
	 public function aprize(){
		 header("Content-Type:text/html;charset=utf-8;");
		$name = 1;
		if(I('get.name')){
			$name=I('get.name');

			$this->assign('title',$name);
			$mp['n.number'] = $name;
		}
		
		
		//获奖的共有多少人
		$nid = M('number_list')->where(array('number'=>$name))->getField('id');
		$first_nu = M('prize')->where(array('number_id'=>$nid ))->getField('first_number');  //yi 
		$second_nu = M('prize')->where(array('number_id'=>$nid) )->getField('second_number');//er
		$third_nu = M('prize')->where(array('number_id'=>$nid ))->getField('third_number');  //san
		$create_nu = M('prize')->where(array('number_id'=>$nid ))->getField('create_number');  //chuang
		
		
		//$mp['p.prize_status'] = array('eq',0);
		$mp['p.start'] = 1;
		$mp['p.is_del'] = 0;
		$mp['n.is_del'] = 0;
		$counts = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->where($mp)->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		
		$paper_list = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->where($mp)->field(array('n.number','n.theme','n.picn','m.person_name','p.id','p.picp','p.counts','p.prize_status'))->order('n.number desc,counts desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		//一等奖
		$paper_list1 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->where($mp)->order('counts desc')->limit("0,$first_nu")->select();
		//二等奖
		$paper_list2 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->where($mp)->order('counts desc')->limit("".($first_nu+1).",$second_nu")->select();
		//三等奖
		$paper_list3 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->where($mp)->order('counts desc')->limit("".($first_nu+$second_nu+2).",$third_nu")->select();
		//创新奖
		$paper_list4 = M('paper_list as p')->join('app_number_list as n on n.id = p.number_id')->where($mp)->order('counts desc')->limit("".($first_nu+$second_nu+$third_nu+3).",$create_nu")->select();
		//print_r($paper_list);
		$this->assign('counts',$counts);
		$this->assign('paper_list',$paper_list);
		$this->assign('paper_list1',$paper_list1);
		$this->assign('paper_list2',$paper_list2);
		$this->assign('paper_list3',$paper_list3);
		$this->assign('paper_list4',$paper_list4);
		$this->display();
	 }
	 
	 public function editPrizes(){
		 $id = I('post.id');
		 $pid = I('post.pid');
		 if(!$id){
			 $this->ajaxReturn(array('status'=>0,'info'=>"没有参数"));
		 }
		 // if(M('paper_list')->where(array('id'=>$pid))->getField('prize_status')){
			 
			// $this->ajaxReturn(array('status'=>2,'info'=>"不能重复颁奖"));
		 // }
		 
		 if($id == 1){
			 
			$pstatus = M('paper_list')->where(array('id'=>$pid))->setField('prize_status',1);
			$this->ajaxReturn(array('status'=>1,'info'=>"一等奖颁奖成功"));
			
		 }else if($id == 2){
			$pstatus = M('paper_list')->where(array('id'=>$pid))->setField('prize_status',2);
			$this->ajaxReturn(array('status'=>1,'info'=>"二等奖颁奖成功"));
			 
		 }else if($id == 3){
			$pstatus = M('paper_list')->where(array('id'=>$pid))->setField('prize_status',3);
			$this->ajaxReturn(array('status'=>1,'info'=>"三等奖颁奖成功"));
			 
		 }else	{
			$pstatus = M('paper_list')->where(array('id'=>$pid))->setField('prize_status',4);
			$this->ajaxReturn(array('status'=>1,'info'=>"创意奖颁奖成功"));
			 
		 }
	 }
	 
	 /*
	 *获奖名单
	 */
	 public function person_prize(){
	
		if(I('get.name')){
			$name=I('get.name');
			$mp['n.number'] = $name;
			$this->assign('title',$name);
		}
		
		$mp['p.prize_status'] = array('gt',0);
		$mp['p.start'] = 1;
		$mp['p.is_del'] = 0;
		$mp['n.is_del'] = 0;
		$counts = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->order('counts desc')->where($mp)->count();
		$Page  = getpage($counts,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
		
		$paper_list = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->where($mp)->order('counts desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		 //print_r($paper_list);
		$this->assign('counts',$counts);
		$this->assign('paper_list',$paper_list);
		 $this->display();
		 
	 }

    //设置参赛须知
    public function cansai(){
        if (IS_POST) {
            $edit_notice = M("protocol");
            //print_r($_POST);exit;
            $count = $edit_notice->where(array('id'=>4))->find();

            if(!$count){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Callforpaper/cansai', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Callforpaper/cansai', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Callforpaper/cansai', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Callforpaper/cansai', '', false));exit;
                }
            }
        }

        $res = M("protocol")->where(array('id'=>4))->find();
        $this->assign('res',$res);
        $this->display();
    }

    //设置获奖须知
    public function prizeRule(){
        if (IS_POST) {
            $edit_notice = M("protocol");
            //print_r($_POST);exit;
            $count = $edit_notice->where(array('id'=>5))->find();

            if(!$count){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Callforpaper/prizeRule', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Callforpaper/prizeRule', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Callforpaper/prizeRule', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Callforpaper/prizeRule', '', false));exit;
                }
            }
        }

        $res = M("protocol")->where(array('id'=>5))->find();
        $this->assign('res',$res);
        $this->display();
    }
	 
	 
	 
	 
	 
}

