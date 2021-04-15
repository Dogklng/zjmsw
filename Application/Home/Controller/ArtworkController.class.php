<?php namespace Home\Controller;

use Think\Controller;

class ArtworkController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
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
        $map['activity_id'] = 0;

        $series_id = $_GET['id'];
        if($series_id){
            $map['series_id'] = $series_id;
        }
        $res = M('goods')->where($map)->order('is_groom desc,id desc')->select();
        //Zj  产品筛选 20170909
        unset($map['goods_name']);
        unset($map['series_id']);
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
        $count =count($res);
        $ArrayObj = new \Org\Util\Arraypage($count,12);
        $page =  $ArrayObj->showpage();//分页显示
        $res = $ArrayObj->page_array($res,0);//数组分页
        $this->assign('res',$res);
        $this->assign('page',$page);
        $sel = M('series')->where(array('isdel'=>0,'cstores'=>0))->select();
        $this->assign('sel',$sel);
        $art = M('banner')->where(array('type'=>3,'isdel'=>0))->select();
        $this->assign('art',$art);
        $this->display();
    }
    /**
     * ajax 请求数据 zj  20170909
     */
    public function get_data()
    {
        if(IS_AJAX){
            $series_id = I("post.series_id");
            $attr_ids = I("post.attr_ids");
            $is_groom = I("post.is_groom");
            if($is_groom == 0 || $is_groom == 1){
                $map['is_groom'] = $is_groom;
            }
            $map['is_del'] = 0;
            $map['is_sale'] = 1;
            $map['shenhe'] = 1;
            $map['cstore'] = 0;
            $map['store'] = 1;//艺术品的库存为1
            $map['activity_id'] = 0;
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
            $goods = M('goods')->where($map)->order('is_groom desc,id desc')->select();
            foreach ($goods as $k=>$val)
            {
                $attr = explode(',',$val['attr_list']);
                $flag = $this->Is_Contain($attrIds,$attr);
                if(!$flag){
                    unset($goods[$k]);
                }
            }
            $count =count($goods);
            $ArrayObj = new \Org\Util\Arraypage($count,12);
            $data['page'] =  $ArrayObj->showpage();//分页显示
            $data['goods'] = $ArrayObj->page_array($goods,0);//数组分页
            $this->ajaxReturn(array('status'=>1,'data'=>$data));
        }
    }


}