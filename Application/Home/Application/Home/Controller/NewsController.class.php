<?php namespace Home\Controller;

use Think\Controller;
/*
*ZQJ
*/
class NewsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $res = M('banner')->where(array('type'=>2,'isdel'=>0))->select();
        $this->assign('res',$res);
        $type = $_GET['type'];
        $map['status'] = 0;
        $map['shenhe'] = 1;
        if ($type!='' && $type!=null) {
            $map['cate'] = $type;
        }
        $news = M('news')->where($map)->order('addtime desc')->select();

        $count =count($news);
        $ArrayObj = new \Org\Util\Arraypage($count,8);
        $page =  $ArrayObj->showpage();//分页显示
        $news = $ArrayObj->page_array($news,0);//数组分页
        $this->assign('news',$news);
        $this->assign('page',$page);
		//dump($news);exit;
        //$this->assign('news',$news);
        $newsCate = M("news_cate")->find($type);
        $this->assign('newsCates',$newsCate);
        $count = M('news')->where(array('status'=>0,'shenhe'=>1))->count();
        $this->assign('count',$count);

        $this->display();
    }
	/*
	*@@ZQJ
	*期数列表
	*/
    public function Contest()
    {
		$res = M('number_list')->where(array('is_del'=>0))->order('number desc')->select();
		foreach($res as $key=>$val){
			$res[$key]['number']=$this->numToWord($val['number']);
			
			
		}

        $count =count($res);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $res = $ArrayObj->page_array($res,0);//数组分页
        $this->assign('page',$page);
		$this->assign('res',$res);
		//print_r($res);
		$this->assign('timed',strtotime(date('Y-m-d')));
        $this->display();
    }

    public function video()
    {
        $cate = I("param.cate")?I("param.cate"):1;
        $res = M('av')->where("cate=".$cate)->select();
       // print_r($res);
       foreach($res as $Key1=> $val1){
       		$url = $val1 ['url'];
	        $url = explode('.',$url);
	        $ar = array();
	        foreach($url as $key => $val){
	        	$ar[] = $key;
	        }
	        $num = end($ar);
	        $res[$Key1]['num'] = $url["$num"];
	    }


        $count =count($res);
        $ArrayObj = new \Org\Util\Arraypage($count,2);
        $page =  $ArrayObj->showpage();//分页显示
        $res = $ArrayObj->page_array($res,0);//数组分页
        $this->assign('res',$res);
        $this->assign('page',$page);
	    //dump($res);
        //$this->assign('res',$res);
        //$this->assign('num',$url["$num"]);
        $video = M('video_cate')->select();
        $this->assign('video',$video);
        $this->assign('cate',$cate);
        $this->display();
    }

    public function recommend()
    {
        $this->display();
    }

    public function details()
    {
        //header("");
        $res = M('news')->where(array('id'=>$_GET['id']))->find();
        if($res['cate'] == 2){
            $res['now_status'] = M('art_show')->where(array('id'=>$res['show_id']))->getfield('now_status');

        }

        $res['cate_name'] = M('news_cate')->where(array('id'=>$res['cate']))->getField('name');

//dump($res);exit;
        $this->assign('res',$res);
        $this->display();
    }
	
    public function process()
    {
		if( I('get.id')){
			unset($_SESSION['nid']);
			$_SESSION['nid']=I('get.id');
		}
		$mp['j.is_del']=0;
		$mp['n.is_del']=0;
		$mp['n.id']=$_SESSION['nid'];
		//评委
		// $judges = M('judges as j')->join('app_number_list as n on n.id = j.number_id')->field(array('n.number','n.theme','n.contonts','n.start_time','n.collectiontime','n.selectiontime','n.end_time','n.picn','j.id','j.school','j.aname','j.adetail','j.picj'))->where($mp)->select();
		// $this->assign('judges',$judges);
		//print_r($judges);
		
		$number = M('number_list')->where(array('id'=>$_SESSION['nid'],'is_del'=>0))->find();
		//评委列表
		$ids = explode(',',$number['judgeid']);
		$map['is_del'] = 0;
		$map['id'] = array('in',$ids);
		$judges = M('judges')->where($map)->select();
		
		$this->assign('judges',$judges);
		
		//奖品
        $prize = M('prize')->where(array('number_id'=>$_SESSION['nid']))->find();
        $this->assign('prize',$prize);
        if(!$prize){
            $prizes= M('number_list as p')->where(array('p.id' => $_SESSION['nid'],'p.is_del' => 0))->find();
        }else{
            $prizes = M('number_list as p')->join('app_prize as n on p.id = n.number_id')->where(array('p.id' => $_SESSION['nid'],'p.is_del' => 0))->find();
        }
        //dump($prizes);exit;
		//$prizes = M('prize as p')->join('app_number_list as n on n.id = p.number_id')->where(array('p.number_id' => $_SESSION['nid'],'p.is_del' => 0))->find();
		//$prizes = M('number_list as p')->join('app_prize as n on p.id = n.number_id')->where(array('p.id' => $_SESSION['nid'],'p.is_del' => 0))->find();
		//dump($prizes);exit;
		$this->assign('theme',$number);
		$this->assign('num',$this->getNum());
		$this->assign('prizes',$prizes);
		$this->assign('timed',strtotime(date('Y-m-d')));
	
        $this->display();
    }
	/**
	* @ 大赛详情
	*/
    public function processDetails()
    {
		//查询时间
		$nid = $_SESSION['nid'];
		$time = M('number_list')->where(array('id' => $nid,'is_del'=>0))->find();

		$cansai = M('protocol')->where(array('id'=>4))->find();
		$prize = M('protocol')->where(array('id'=>5))->find();
		$this->assign('cansai',$cansai);
		$this->assign('prize',$prize);


		$this->assign('time',$time);
		$this->assign('timed',strtotime(date('Y-m-d')));
		$this->assign('theme',M('number_list')->where(array('id'=>$_SESSION['nid'],'is_del'=>0))->find());
		$this->assign('num',$this->getNum());
        $this->display();
    }
    public function submission()
    {
			
		header("Content-Type:text/html;charset=utf-8;");
		if(IS_AJAX){
			if(M('paper_list')->where(array('number_id'=>$_SESSION['nid'],'member_id'=>$_SESSION['member_id']))->select()){
				$data1['status'] = 0;
				$data1['info'] = '一个人一期只能投稿一次!';
				$this->ajaxReturn($data1);
			}
			$data1['status'] = 1;
			$this->ajaxReturn($data1);
		}
		if(IS_POST){
			$data = I('post.');
			$datap['number_id']=$_SESSION['nid'];
			$datap['member_id']=$_SESSION['member_id'];
			$datap['author']=$data['author'];
			$datap['sfid']=$data['sfid'];
			$datap['phone']=$data['phone'];
			$datap['birth']=$data['bir'];
			$datap['email']=$data['email'];
			$datap['wname']=$data['wname'];
			$datap['zuo_detail']=$data['zuo_detail'];
			$datap['person_detail']=$data['person_detail'];
			//$datap['wtype']=$data['wtype'];
			//$datap['wsize']=$data['wsize'];
			//$datap['wmaterial']=$data['wmaterial'];
            //$datap['wmaterial']=$data['wmaterial'];
            $datap['zpbute']=substr($data['zpbute'],0,-1);
            /*if(!validation_filter_id_card($datap['sfid'])){
                $this->error("身份证错误", U('Home/News/submission', '', false));exit;
            }*/
			if($data['pic3']){
				$datap['picp']=$data['pic3'];
			}
			if($data['pic4']){
				$datap['wpic1']=$data['pic4'];
			}
			if($data['pic4']){
				$datap['wpic2']=$data['pic5'];
			}
			if($data['pic4']){
				$datap['wpic3']=$data['pic6'];
			}
			if($data['pic4']){
				$datap['wpic4']=$data['pic7'];
			}
			$pap = M('paper_list')->add($datap);
			if($pap){
					$this->success("投稿成功!", U('Home/News/works', '', false));exit;
			}else{
				
				$this->error("投稿失败", U('Home/News/submission', '', false));exit;
			}
			
		}
		
		
		//材质 类型 尺寸
		$wmaterial = M('wmaterial')->where(array('is_del'=>0))->select();
		$wtype = M('wtype')->where(array('is_del'=>0))->select();
		$wsize = M('size')->where(array('is_del'=>0))->select();
		$this->assign('wmaterial',$wmaterial);
		$this->assign('wtype',$wtype);
		$this->assign('wsize',$wsize);
		//登陆人身份
		$mem = M('member')->where(array('id'=>$_SESSION['member_id']))->find();


        $attrList = M("zpbute")->where(array('pid'=>0))->select();
        //$attrMap1['id'] = array('in',$attr_ids);
        foreach ($attrList as $a=>$b){
            $attrMap1['pid'] = $b['id'];
            $attrList[$a]['child'] = M("zpbute")->where($attrMap1)->select();
        }
        //print_r( $attrList);
        if($attrList){
            $this->assign('counattr',M("zpbute")->where(array('pid'=>0))->count());
            $this->assign('attrList',$attrList);
        }



		$this->assign('mem',$mem);
		$this->assign('theme',M('number_list')->where(array('id'=>$_SESSION['nid'],'is_del'=>0))->find());
		$this->assign('timed',strtotime(date('Y-m-d')));
		$this->assign('num',$this->getNum());
        $this->display();
    }
	
	/**
	* @在线作品
	*/
    public function works()
    {
		$nid = $_SESSION['nid'];
		$paper = M('paper_list');
		$fileds = array('p.id','p.author','p.wname','n.number','n.theme','n.start_time','n.collectiontime','m.person_img','m.person_name','p.picp');
		$paper_list = M('paper_list as p')
            ->join('app_number_list as n on n.id = p.number_id')
            ->join('app_member as m on m.id = p.member_id')
            ->field($fileds)
            ->where(array('p.is_del'=>0,'n.is_del'=>0,'p.number_id'=>$nid,'p.start'=>1))->select();
		foreach ($paper_list as $key => $val){
			$paper_list[$key]['number'] = sprintf("%03d", $val['number']) ;
		}

        $count =count($paper_list);
        $ArrayObj = new \Org\Util\Arraypage($count,8);
        $page =  $ArrayObj->showpage();//分页显示
        $paper_list = $ArrayObj->page_array($paper_list,0);//数组分页
        $this->assign('page',$page);
		$this->assign('paper_list',$paper_list);
		//print_r($paper_list);
		$this->assign('num',$this->getNum());
		$this->assign('theme',M('number_list')->where(array('id'=>$_SESSION['nid'],'is_del'=>0,'start'=>1))->find());
		$this->assign('timed',strtotime(date('Y-m-d')));
        $this->display();
    }
	/**
	* @在线作品详情
	*/
    public function worksDetails()
    {	
		$pid = I("get.pid");
		$pUrl = U("Home/News/works");
		if(!$pid){
			echo "<script>alert('缺少参数！');window.history.back();</script>";
		}
		//访问量
		$cou = M('paper_list')->where(array('id'=>$pid))->getField('visits');
		M('paper_list')->where(array('id'=>$pid))->setField('visits',$cou+1);
		//////////
		$mp['p.is_del']=0;
		$mp['p.id'] = $pid;
        $mp['p.start'] = 1;
        //$paper_list = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_wtype as t on
        // t.id = p.wtype')->join('app_size as s on s.id = p.wsize')->join('app_wmaterial as w on w.id = p.wmaterial')->field(array('p.id','p.*','m.person_img','s.sname','s.minrange','s.maxrange','w.wmaterial','t.wtype'))->where($mp)->find();
        $paper_list = M('paper_list as p')
            ->join('app_member as m on m.id = p.member_id')
            ->field(array('p.id','p.*','m.person_img'))->where($mp)->find();

        //print_r($paper_list);
		//将1转化为001
		$number  = M('number_list')->where(array('id'=>$paper_list['number_id']))->getField('number');
		$this->assign('paper_list',$paper_list);

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


		$this->assign('number',sprintf("%03d", $number));
		$this->assign('num',$this->getNum());
        $this->display();
    }
	/**
	* @ 获奖作品
	*/
	public function win(){
		$id = $_SESSION['nid'];//期数id
		$res = M('number_list')->where(array('id'=>$id,'is_del'=>0))->find();
		
		$mp['p.start'] = 1;
		$mp['p.is_del'] = 0;
		$mp['p.number_id'] = $id;
		$mp['p.prize_status'] = array('gt',0);
		$mp['n.is_del'] = 0;
		$mp['n.is_del'] = 0;
		//所有获奖者的名单
		$paper_list = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->field(array('p.id','p.author','m.person_name','p.wname','p.picp','p.person_detail'))->where($mp)->select();
		//一等奖
		unset($mp['p.prize_status']);
		$mp['p.prize_status'] = 1;
		$paper_list1 = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->field(array('p.id','p.author','m.person_name','p.wname','p.picp','p.person_detail'))->where($mp)->select();
		//二等奖
		unset($mp['p.prize_status']);
		$mp['p.prize_status'] = 2;
		$paper_list2 = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->field(array('p.id','p.author','m.person_name','p.wname','p.picp','p.person_detail'))->where($mp)->select();
		//三等奖
		unset($mp['p.prize_status']);
		$mp['p.prize_status'] = 3;
		$paper_list3 = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->field(array('p.id','p.author','m.person_name','p.wname','p.picp','p.person_detail'))->where($mp)->select();
		//创意奖
		unset($mp['p.prize_status']);
		$mp['p.prize_status'] = 4;
		$paper_list4 = M('paper_list as p')->join('app_member as m on m.id = p.member_id')->join('app_number_list as n on n.id = p.number_id')->field(array('p.id','p.author','m.person_name','p.wname','p.picp','p.person_detail'))->where($mp)->select();
		
		
		$this->assign('paper_list1',$paper_list1);
		$this->assign('paper_list2',$paper_list2);
		$this->assign('paper_list3',$paper_list3);
		$this->assign('paper_list4',$paper_list4);
		$this->assign('num',$this->getNum());
		
		$this->assign('timed',strtotime(date('Y-m-d')));
		$this->assign('number',M('number_list')->where(array('id'=>$_SESSION['nid'],'is_del'=>0))->find());
        $this->display();
	}
	/** 
	* @return投票
	*/
	public function addvote(){
		$id = I('post.id');//paper_list.id
		if(!$id){
			$this->ajaxReturn(array('status'=>0,'info'=>'无参数'));
		}
		if(!$_SESSION['member_id']){
			$this->ajaxReturn(array('status'=>0,'info'=>'未登录不能投票'));
		}
		$number = M('number_list')->where(array('id'=>$_SESSION['nid'],'is_del'=>0))->find();
		if(time() < $number['start_time']){$this->ajaxReturn(array('status'=>0,'info'=>'还没开始投票'));}
		if(time() > $number['selectiontime']){$this->ajaxReturn(array('status'=>0,'info'=>'已经结束投票'));}
		$mp['paper_id'] = $id; 
		$mp['member_id'] = $_SESSION['member_id']; 
		if(M('vote')->where($mp)->find()){
			$this->ajaxReturn(array('status'=>0,'info'=>'已经投过了'));
		}else{
			$counts = M('paper_list')->where(array('id'=>$id))->getField('counts');
			M('paper_list')->where(array('id'=>$id))->setField('counts',$counts+1);
			$pmid=M('vote')->add($mp);
			if($pmid){
				
				$this->ajaxReturn(array('status'=>1,'info'=>'投票成功！'));
			}
			
		}
			
	

	}
	
	
	/** 
	* @return 尺寸详细
	*/
	public function cc_detail(){
		$id = I('post.id');
		if(!$id){
			$this->ajaxReturn(array('status'=>0,'info'=>'没有该尺寸'));
		}
		$wsize = M('size')->where(array('id'=>$id))->find();
		$this->ajaxReturn(array('status'=>1,'min'=>$wsize['minrange'],'max'=>$wsize['maxrange']));
	}
	
	
	/**
	* @return 获取期数
	*/
	public function getNum(){
		
		//----------期数--------//
		$id = $_SESSION['nid'];
		$iUrl = U("Home/News/Contest");
		if(!$id){
			echo "<script>alert('缺少参数！');window.location.href='".$iUrl."';</script>";
		}
		$num = M('number_list')->where(array('id'=>$id))->getField('number');
		$num = $this->numToWord($num);
		
		//----------期数--------//
		return $num;
	}
	
	/**
	* @return 判断是否登录
	*/
	public function getName(){
		
		if($_SESSION['member_id']){
			
			if(!M('member')->where(array('id'=>$_SESSION['member_id']))->getField('person_img')){
				return 2;//请上传头像
			}
			
		}else{
			
			return 1;//未登录
		}
	}
	/**
	* @author ja颂 
	* 把数字1-1亿换成汉字表述，如：123->一百二十三
	* @param [num] $num [数字]
	* @return [string] [string]
	*/
	public function numToWord($num)
	{
		$chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
		$chiUni = array('','十', '百', '千', '万', '亿', '十', '百', '千');
		 
		$chiStr = '';
		 
		$num_str = (string)$num;
		 
		$count = strlen($num_str);
		$last_flag = true; //上一个 是否为0
		$zero_flag = true; //是否第一个
		$temp_num = null; //临时数字
		 
		$chiStr = '';//拼接结果
		if ($count == 2) {//两位数
			$temp_num = $num_str[0];
			$chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num].$chiUni[1];
			$temp_num = $num_str[1];
			$chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num]; 
		}else if($count > 2){
			$index = 0;
			for ($i=$count-1; $i >= 0 ; $i--) { 
				$temp_num = $num_str[$i];
				if ($temp_num == 0) {
					if (!$zero_flag && !$last_flag ) {
						$chiStr = $chiNum[$temp_num]. $chiStr;
						$last_flag = true;
					}
				}else{
					$chiStr = $chiNum[$temp_num].$chiUni[$index%9] .$chiStr;
					 
					$zero_flag = false;
					$last_flag = false;
				}
				$index ++;
			}
		}else{
			$chiStr = $chiNum[$num_str[0]]; 
		}
		return $chiStr;
	}
	/*
	* ZQJ 
	* 点击我要投稿按钮 判断是否登录 是否过期 是否上传头像
	*/
	public function buttonRelease(){
		//是否选择期数
		if(!$_SESSION['nid']){
			$data['status'] = 0;
			$data['info'] = '请选择大赛期数！';
			$data['url'] = U('Home/News/Contest');
			$this->ajaxReturn($data);exit;
		}
		//是否在投稿时间内
		$time = strtotime(date('Y-m-d'));//collectiontime
		//作品征集时间段
		$zhengji = M('number_list')->find($_SESSION['nid']);
		if($time < $zhengji['start_time']){
			//echo "<script>alert('投稿还未开始！');window.history.back();</script>";exit;
			$data['status'] = 0;
			$data['info'] = '投稿还未开始！';
			$this->ajaxReturn($data);exit;
		}
		file_put_contents('time.log',$time);
		if($time > $zhengji['collectiontime']){
			//echo "<script>alert('投稿已经结束！');window.history.back();</script>";exit;	
			$data['status'] = 0;
			$data['info'] = '投稿已经结束！';
			$this->ajaxReturn($data);exit;
		}
		//投稿条件，需要登录 ，需要头像
		
		$loginUrl = U('Home/User/login');//登录页面
		$personUrl = U('Home/PersonalCenter/userInfo');//个人中心
		if(!$_SESSION['member_id']){
			$data['status'] = 0;
			$data['info'] = '请先登录！';
			$data['url'] = $loginUrl;
			$this->ajaxReturn($data);exit;
		}
		if(!M('member')->where(array('id'=>$_SESSION['member_id']))->getField('person_img')){
			//echo "<script>alert('请上传头像！');window.location.href='".$personUrl."';</script>";exit;	
			$data['status'] = 0;
			$data['info'] = '请上传头像！';
			$data['url'] = $personUrl;
			$this->ajaxReturn($data);exit;
		}
		$data['status'] = 1;
		$data['url'] = U('/Home/News/submission');
		$this->ajaxReturn($data);exit;
	}
	/*
*崔仲侨1030
*/
	public function delImage(){
		$link = I('post.src');
		if($link){
			if(file_get_contents('./'.$link)){
				file_put_contents('link.log',$link);
				@unlink('./'.$link);
				$this->ajaxReturn(array('status'=>1,'info'=>'文件删除成功！')) ;
			}else{
				$this->ajaxReturn( array('status'=>2,'info'=>'文件不存在！'));
			}
		}else{
			$this->ajaxReturn(array('status'=>0,'info'=>'路径不存在！'));
		}
	}

    public function exhibition()
    {

        $res1 = M('banner')->where(array('type'=>2,'isdel'=>0))->select();
        $this->assign('res1',$res1);

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }


        //$res = M('art_show')->where(array('is_sale'=>1,'status'=>2,'end'=>array('gt',time())))->find();
        $res = M('art_show')->where(array('is_sale'=>1,'status'=>2))->find();
        if($res){
            $res['content'] = html_entity_decode($res['content']);
        }
        //dump($res);exit;
        $this->assign('res',$res);

        $show = M('art_show')->where(array('is_sale'=>1,'status'=>2))->order('create_time desc')->select();
        //$show = M('art_show')->where(array('is_sale'=>1,'status'=>2))->order('start desc')->select();
        /*foreach($show as $k=>$v){
            $show[$k]['content'] = substr($v['contents'],0,30);
        }*/
        $count =count($show);
        $ArrayObj = new \Org\Util\Arraypage($count,8);
        $page =  $ArrayObj->showpage();//分页显示
        $show = $ArrayObj->page_array($show,0);//数组分页
        $this->assign('page',$page);
        $this->assign('show',$show);

        $this->img();
        $this->display();
    }

    public function img(){
        $images = M('banner')->where(array('type'=>4,'isdel'=>0))->find();
        $this->assign('images',$images);
    }

    public function detail(){
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $res = M('art_show')->where(array('id'=>$_GET['id']))->find();

        $this->assign('res',$res);
        $this->display();
    }

    public function exhibitors()
    {
        if(IS_POST){
            $user = $_SESSION['member_id'];
            if($user == '' | $user == null){
                $this->ajaxReturn(array('status'=>0,'info'=>"请先登录！"));die;
                //$this->error("请先登录！",U('Home/User/login'));
            }
            $m      = M("cz");
            $cf = $m->where(array('user_id'=>$_SESSION['member_id'],'show_id'=>$_POST['show_id'],'cate'=>$_POST['cate'],'series'=>$_POST['series']))->find();
            if($cf){
                $this->ajaxReturn(array('status'=>0,'info'=>"您已提交过该类型数据！"));die;
                //$this->error("您已提交过该类型数据！",U('Home/ArtCommunity/exhibition'));
            }
            $g_s_m  = M("cz_pic");
            $data   = I("post.");
            $data['user_id'] = $_SESSION['member_id'];
            $slide_pic = $data['pic'];
            unset($data['pic1']);
            $data['create_time'] = NOW_TIME;
            $res = $m->add($data);
            if($res){
                foreach($slide_pic as $k=>$v){
                    $slide_data = array(
                        "cz_id"   => $res,
                        "create_time"  => time(),
                        "pic"        => $v,
                        "status"     => 1,
                    );
                    $g_s_m->add($slide_data);
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"提交失败！"));die;
                //$this->error("提交失败！",U('Home/ArtCommunity/exhibition'));
            }
            $this->ajaxReturn(array('status'=>1,'info'=>"提交成功！"));die;
            //$this->redirect('Home/ArtCommunity/exhibition');
        }
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $series = M('series')->where(array('isdel'=>0,'pid'=>0))->select();
        $this->assign('series',$series);
        $this->display();
    }

    public function upExhibitors()
    {
        if(IS_POST){
            $user = $_SESSION['member_id'];
            if($user == '' | $user == null){
                $this->ajaxReturn(array('status'=>0,'info'=>"请先登录！"));die;
                //$this->error("请先登录！",U('Home/User/login'));
            }
            $m      = M("art_show");
            /*$cf = $m->where(array('user_id'=>$_SESSION['member_id']))->find();
            if($cf){
                $this->ajaxReturn(array('status'=>0,'info'=>"您已提交过该类型数据！"));die;
                //$this->error("您已提交过该类型数据！",U('Home/ArtCommunity/exhibition'));
            }*/
            $data   = I("post.");
            $data['user_id'] = $_SESSION['member_id'];
            $data['create_time'] = NOW_TIME;
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $data['is_sale'] = 0;
            $data['status'] = 1;
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已经提交成功！"));die;
                //$this->error("您的资料已经提交成功",U('Home/ArtCommunity/exhibition'));
            }else{
                $this->ajaxReturn(array('status'=>1,'info'=>"提交失败！"));die;
                //$this->error("提交失败！",U('Home/ArtCommunity/exhibition'));
            }
        }
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $series = M('series')->where(array('isdel'=>0,'pid'=>0))->select();
        $this->assign('series',$series);
        $this->display();
    }
		
	

}