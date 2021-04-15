<?php namespace Wxin\Controller;

use Think\Controller;

class ArtworkController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',2);
    }
	
    /**
     * 艺术品首页 zj  ZQJ 1101 修改
     */
    public function index()
    {
        $member_id = $_SESSION['member_id'];
        if($member_id=="" | $member_id == null){
            $this->assign('member_id',0);
        }else{
            $this->assign('member_id',$member_id);
        }
        $attr_ids = I("get.attr_ids");
        $is_groom = I("get.is_groom");
        if($is_groom == 3){
            $map['is_groom'] = 0;
        }

        if($is_groom == 1){
            $map['is_groom'] = 1;
        }
        if($attr_ids){
            $attr_ids = explode('-',$attr_ids);
            foreach ($attr_ids as $v)
            {
                if($v){
                    $attrIds[] = $v;
                }
            }
        }

		/*关键词查询 ZQJ*/
		if(I('get.key')){
			$key = I('get.key');
			$map['goods_name'] = array('like',"%".$key."%");
		}
		/*关键词查询 ZQJ*/
        $map['is_del'] = 0;
        $map['shenhe'] = 1;
        $map['is_sale'] = 1;//是否上架
        $map['store'] = 1;//艺术品的库存为1
        $map['cstore'] = 0;//艺术品产品 不是创意商店
        $series_id = $_GET['id'];
        if($series_id){
            $map['series_id'] = $series_id;
        }
		/*
			$User = M('User'); // 实例化User对象
			$count      = $User->where('status=1')->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $User->where('status=1')->order('create_time')->limit($Page->firstRow.','.$Page->listRows)->select();
		*/
		$count=M('goods')->where($map)->order('goods_list desc')->count();
		//$Page       = new \Think\Page($count,6);
		$Page = getpage1($count,12);
		$show       = $Page->show();
        $res = M('goods')->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('goods_list desc')->select();
		$this->assign('show',$show);
        if($attr_ids){
            foreach ($res as $k=>$val)
            {
                $attr = explode(',',$val['attr_list']);
                $flag = $this->Is_Contain($attrIds,$attr);
                if(!$flag){
                    unset($res[$k]);
                }
            }
        }
        //Zj  产品筛选 20170909
        unset($map['goods_name']);
        unset($map['series_id']);
        unset($map['is_groom']);
        $all = M('goods')->where($map)->select();
        $attr_ids = array();
        foreach ($all as $value){
            if($value['attr_list']){
                foreach (explode(',',$value['attr_list']) as $vv){
                    $attr_ids[] = $vv;
                }
            }
        }
        $attr_ids = array_filter(array_unique($attr_ids));
        foreach ($attr_ids as $v){
            $pid[] = M("goods_attribute")->where(array('id'=>$v))->getField('pid');
        }
        $pid = array_filter(array_unique($pid));
        if(!empty($pid)){
            $attrMap['id'] = array('in',$pid);
            $attrList = M("goods_attribute")->where($attrMap)->select();
            $attrMap1['id'] = array('in',$attr_ids);
            foreach ($attrList as $a=>$b){
                $attrMap1['pid'] = $b['id'];
                $attrList[$a]['child'] = M("goods_attribute")->where($attrMap1)->select();
            }
        }

        //dump($attrList);exit;
        $this->assign('attrList',$attrList);
        //ZJ  产品筛选 分页 20171103
        //$data = array();
        //foreach($res as $k=>$v){
            //if($k<12){
                //$data[] = $v;
            //}
       // }
        //$count =count($res);
        //$ArrayObj = new \Org\Util\Arraypage($count,12);
        //$page =  $ArrayObj->showpage();//分页显示
        //$res = $ArrayObj->page_array($res,0);//数组分页
        $this->assign('res',$res);
        //$this->assign('page',$page);
        $sel = M('series')->where(array('isdel'=>0,'cstores'=>0))->select();
        $this->assign('sel',$sel);
        $art = M('banner')->where(array('type'=>3,'isdel'=>0))->select();
        $this->assign('art',$art);
        $this->display();
    }

    public function art()
    {
        $this->display();
    }
    /**
     * ajax 请求数据 zj  20170909
     */
    public function get_data()
    {
        if(IS_AJAX){
            $member_id = $_SESSION['member_id'];
            $series_id = I("post.old_id");
            $attr_ids = I("post.old_attr_ids");
            $is_groom = I("post.old_is_groom");
            $p = I("post.p");
            if($is_groom == 3){
                $map['is_groom'] = 0;
            }

            if($is_groom == 1){
                $map['is_groom'] = 1;
            }
            $map['is_del'] = 0;
            $map['is_sale'] = 1;
            $map['shenhe'] = 1;
            $map['cstore'] = 0;
            $map['store'] = 1;//艺术品的库存为1
            if($series_id){
                $map['series_id'] = $series_id;
            }
            $attr_ids = explode('-',$attr_ids);
            foreach ($attr_ids as $v)
            {
                if($v){
                    $attrIds[] = $v;
                }
            }
            $goods = M('goods')->where($map)->select();
            if($attrIds){
                foreach ($goods as $k=>$val)
                {
                    $attr = explode(',',$val['attr_list']);
                    $flag = $this->Is_Contain($attrIds,$attr);
                    if(!$flag){
                        unset($goods[$k]);
                    }
                }
            }

            $data = array();
            foreach($goods as $k=>$v){
                if($k>=$p*12 && $k<($p+1)*12){
                    $data[] = $v;
                }
            }
            if($data){
                $str = '';
                foreach($data as $k=>$v){

                        $str .= '<div class="prod_cont">';
                        $str .= '<p class="prod_cont_img">';
                        $str .= '<a href="/Wxin/Products/buy?id='.$v['id'].'">';
                        $str .= '<img src="'.$v['index_pic'].'" /></a></p>';
                        $str .= '<div class="prod_cont_text">';
                        $str .= '<h4><span>'.$v['goods_name'].'</span></h4>';
                        $str .= '<h3 class="Price-h3">';
                    if($member_id){
                        $str .= '<i>￥</i>';
                        if($v['is_groom']==1){
                            $str .= $v['price'];
                        }else{
                            $str .= $v['zujin'].'/天';
                        }
                    }else{
                        $str .= '<span style="color: #999 !important;font-size: 14px !important;"><a href="/Wxin/User/login" style="color: #333 !important;">登录</a>可查看价格</span>';
                    }

                        $str .= '</h3><div class="clear"></div><p></p>';
                        $str .= '<div class="htx"> <a href="/Wxin/Products/buy?id='.$v['id'].'"> 查看详情 </a> </div></div></div>';

                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }


}