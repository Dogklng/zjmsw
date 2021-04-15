<?php namespace Wxin\Controller;

use Boris\DumpInspector;
use Think\Controller;

class ProductsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',1);
    }


    /*
    *ZQJ 1101修改
     */
    public function index()
    {
        header("Content-type:text/html;charset=utf-8;");
        $res = M('banner')->where(array('type' => 6,'isdel'=>0))->select();
        $this->assign('res', $res);

        $sel = M('series')->where(array('isdel' => 0, 'cstores' => 1))->select();
        $this->assign('sel', $sel);
        $pids = I("get.id");
        $map['is_del'] = 0;
        $map['store'] = array('neq',0);
        $map['is_sale'] = 1;//上架
        $map['cstore'] = 1; //创意商店
        if ($pids) {
            $map['series_id'] = $pids;
        }
        $attr_ids = I("get.attr_ids");
        if($attr_ids){
            $attr_ids = explode('-',$attr_ids);
            foreach ($attr_ids as $v)
            {
                if($v){
                    $attrIds[] = $v;
                }
            }
        }
        $res = M('goods')->where($map)->order('goods_list desc')->select();
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
        unset($map['series_id']);
        $all = M('goods')->where($map)->select();
        //Zj  产品筛选 20170909
        $attr_ids = array();
        foreach ($all as $value) {
            if ($value['attr_list']) {
                foreach (explode(',', $value['attr_list']) as $vv) {
                    $attr_ids[] = $vv;
                }
            }
        }
        $data = array();
        foreach($res as $k=>$v){
            if($k<12){
                $data[] = $v;
            }
        }
        //分页 zj
        $this->assign('rews', $data);

        $attr_ids = array_filter(array_unique($attr_ids));
        foreach ($attr_ids as $v) {
            $pid[] = M("goods_attribute")->where(array('id' => $v))->getField('pid');
        }
        $pid = array_filter(array_unique($pid));
        if(!empty($pid)){
            $attrMap['id'] = array('in', $pid);
            $attrList = M("goods_attribute")->where($attrMap)->select();
            $attrMap1['id'] = array('in', $attr_ids);
            foreach ($attrList as $a => $b) {
                $attrMap1['pid'] = $b['id'];
                $attrList[$a]['child'] = M("goods_attribute")->where($attrMap1)->select();
            }
        }
        //        dump($attrList);
        $this->assign('attrList', $attrList);
        $this->display();
    }

    public function get_data()
    {
        if (IS_AJAX) {
            $series_id = I("post.series_id");
            $attr_ids = I("post.attr_ids");
            $p = I("post.p");
            $map['is_del'] = 0;
            $map['is_sale'] = 1;
            $map['is_pm'] = 0;
            $map['cstore'] = 1;
            $map['store'] = array('neq',0);
            if ($series_id) {
                $map['series_id'] = $series_id;
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
                    $str .= '<a href="Wxin/Products/buy?id='.$v['id'].'">';
                    $str .= '<img src="'.$v['index_pic'].'" /></a></p>';
                    $str .= '<div class="prod_cont_text">';
                    $str .= '<h4><span>'.$v['goods_name'].'</span></h4>';
                    $str .= '<h3 class="Price-h3"><i>￥</i>';
                    $str .= $v['price'];
                    $str .= '</h3><div class="clear"></div><p></p>';
                    $str .= '<div class="htx"> <a href="/ Wxin / products_dot / buy?id='.$v['id'].'"> 查看详情 </a> </div></div></div>';

                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }


    public function Is_Contain($a, $b)
    {
        $flag = 1;
        foreach ($a as $va) {
            if (in_array($va, $b)) {
                continue;
            } else {
                $flag = 0;
                break;
            }
        }
        return $flag;
    }


    public function personality()
    {
        $this->display();
    }


    public function img(){

        $images = M('banner')->where(array('type' => 6,'isdel'=>0))->select();
        $this->assign('images',$images);
    }
    //收藏
    public function ajaxSc()
    {

        $data['good_id'] = $_POST['goods_id'];
        $data['user_id'] = $_SESSION['member_id'];
        $rel = M('goods_collect')->where($data)->count();


        if ($rel == 0) {
            $data['good_id'] = $_POST['goods_id'];
            $data['user_id'] = $_SESSION['member_id'];
            $data['create_at'] = time();
            $data['status'] = 1;
            $c = M('goods_collect');
            $res = $c->add($data);
            $count = M('goods_collect')->where(array('good_id' => $_POST['goods_id']))->count();
            $ress = M('goods')->where(array('id'=>$data['good_id']))->save(array('collection'=>$count));
            if ($res) {
                $this->ajaxReturn(array('status' => 1, 'info' => '收藏成功', 'is_c' => 0, 'count' => $count));
            }
        } else if ($rel == 1) {
            $data['good_id'] = $_POST['goods_id'];
            $data['user_id'] = $_SESSION['member_id'];
            $data['create_at'] = time();
            $data['status'] = 0;
            $c = M('goods_collect');
            $res = $c->where(array('good_id' => $_POST['goods_id'], 'user_id' => $_SESSION['member_id']))->delete();
            $count = M('goods_collect')->where(array('good_id' => $_POST['goods_id']))->count();
            $ress = M('goods')->where(array('id'=>$data['good_id']))->save(array('collection'=>$count));
            if ($res) {
                $this->ajaxReturn(array('status' => 1, 'info' => '取消收藏', 'is_c' => 0, 'count' => $count));
            }
        }

    }

    //推荐 ZQJ 20171102
    public function ajaxSc1()
    {

        $data['good_id'] = $_POST['goods_id'];
        //$promulgator = M('goods')->where(array('id'=>$data['good_id']))->getField('promulgator');

        //$artistid = M('apply')->where(array('user_id'=>$promulgator))->getField('id');
        $data['user_id'] = $_SESSION['member_id'];
        $yun_id = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
        $data['artist_id'] = $yun_id;
        //先查看是否有店铺 查看是否是自己的产品 （自己的产品不做推荐）ZQJ 20171102
       /* $artists = M('apply')->where(array('user_id'=>$_SESSION['member_id'],'shenhe'=>2))->find();//店铺
        //print_r($artistid);exit;
        if($artists == ''){
            $this->ajaxReturn(array('status' => 0, 'info' => '请先创建店铺', 'is_c' => 0));die;
        }

        $goods = M('goods')->where(array('is_del'=>0,'is_sale'=>1,'shenhe'=>1,'promulgator'=>$artists['id']))->select();//产品表
        
         if($goods){
            $arrid = array();
             foreach($goods as $key => $val){
                $arrid[] = $val['id'];
             }  

              //var_dump($arrid);die;
            if(in_array($_POST['goods_id'],$arrid)){

                $this->ajaxReturn(array('status' => 0, 'info' => '店铺已有该商品', 'is_c' => 0));die;
            }
         }*/

        $rel = M('recommend')->where($data)->count();
        if($rel == 0){
            $data['good_id'] = $_POST['goods_id'];
            $data['user_id'] = $_SESSION['member_id'];
            $data['artist_id'] = $yun_id;
            $conunt = M('yun_apply')
                ->alias('a')
                ->join('left join app_yun_right b on a.level=b.id')
                ->where(array('a.user_id'=>$_SESSION['member_id']))
                ->getField('num');
            //print_r($conunt);exit;
            //$conunt = M('finance_config')->where('id=1')->getField('num');
            $num = M('recommend')->where(array('user_id'=>$_SESSION['member_id']))->count();
            if($num>=$conunt){
                $this->ajaxReturn(array('status' => 0, 'info' => '已经达到推荐上限', ));
            }
            $c = M('recommend');
            $res = $c->add($data);
            $count1 = M('recommend')->where(array('good_id'=>$_POST['goods_id']))->count();
            if($res){
                $this->ajaxReturn(array('status' => 1, 'info' => '推荐成功', 'is_c' => 0,'count1'=>$count1));
            }
        } else if($rel == 1){
            $data['good_id'] = $_POST['goods_id'];
            $data['user_id'] = $_SESSION['member_id'];
            $data['artist_id'] = $yun_id;
            $c = M('recommend');
            $res = $c->where(array('good_id'=>$_POST['goods_id'],'user_id'=>$_SESSION['member_id']))->delete();
            $count1 = M('recommend')->where(array('good_id'=>$_POST['goods_id']))->count();
            if($res){
                $this->ajaxReturn(array('status' => 1, 'info' => '取消推荐', 'is_c' => 0,'count1'=>$count1));
            }
        }
    }

    public function buy()
    {
        $member_id = $_SESSION['member_id'];

        if ($member_id == "" | $member_id == null) {
            $this->assign('member_id', 0);
        } else {
            $this->assign('member_id', $member_id);
        }
        $id = I('get.id');
        M("goods")->where(array('id' => $id))->setInc('browser', 1);
        $res1 = M('goods_slide')->where(array('goods_id' => $id, 'status' => 1))->field('pic')->select();
        $this->assign('goods_slide', $res1);
        $res = M('goods')->where(array('id' => $id,'is_del' => 0,'is_sale'=>1,'store'=>1,'cstore'=>0))->find();
        if (empty($res)) {
            $this->redirect("Wxin/Order/order_error/msg/'产品信息不存在!'");
        }
        $this->assign('res', $res);
        //print_r($res);
        if($res['promulgator']==0){
            $rel = M('goods')->where(array('goods_cap' => $res['goods_cap'],'is_del' => 0,'is_sale'=>1,'store'=>1,'cstore'=>0))->limit(4)->select();
            $store = 1;
        }else{
            $rel = M('goods')->where(array('promulgator' => $res['promulgator'],'is_del' => 0,'is_sale'=>1,'store'=>1,'cstore'=>0))->limit(4)->select();
            $store = 2;
        }
        //echo $id;
        $this->assign('store',$store);

        $this->assign('rel', $rel);
        $cate = M('cate')->where(array('is_show' => 1, 'is_del' => 0))->select();
        $this->assign('cate', $cate);
        $like = M('goods')->where(array('is_del' => 0,'is_sale'=>1,'store'=>1,'cstore'=>0,'id'=>array('neq',$id)))->limit(4)->select();

        $this->assign('like', $like);

        $count = M('goods_collect')->where(array('good_id' => $id))->count();
        $this->assign('count', $count);
        $this->assign('is_groom', $res['is_groom']);

        $like_collect = M('goods_collect')->where(array('user_id' => $_SESSION['member_id'], 'good_id' => $id))->count();
        $this->assign('like_collect', $like_collect);

        $recommend = M('recommend')->where(array('user_id' => $_SESSION['member_id'], 'good_id' => $id))->count();
        $this->assign('recommend', $recommend);

        $count1 = M('recommend')->where(array('good_id' => $id))->count();
        $this->assign('count1', $count1);
         //artists_id 判断是否是从推荐店铺过来的
        if(I('get.artists_id')){
            $artists_id = I('get.artists_id');
            $this->assign('artists_id',$artists_id);
        }
        //如果登录则查看是否有可用的代金券
         $member_id = $_SESSION['member_id'];
        $fields = array('c.condition','type','integral','money','over_time','status','get_time');
        $link_coupon = M('link_coupon as l')->where(array('l.user_id'=>$member_id))->join('app_coupon as c on l.coupon_id = c.id')->field($fields)->select();
        foreach($link_coupon as $key=>$val){
            $link_coupon[$key]['start_time'] = $val['get_time'];
            $over_time = $val['over_time'];
            $link_coupon[$key]['end_time'] = strtotime(" +$over_time day",$val['get_time']);
        }
         $this->assign('coupon',$link_coupon);

        $image = M('goods_slide')->where(array('goods_id'=>$id))->select();
        $this->assign('image',$image);

        $artist = M('goods')
            ->alias('a')
            ->join('left join app_apply b on a.promulgator=b.id')
            ->field('b.logo_pic,b.desc,b.name')
            ->where(array('a.id'=>$id))
            ->find();
        $this->assign('artist',$artist);
         
        $this->display();
    
    }

    public function addCate()
    {
        $classname = $_POST['name'];
        $classname = substr($classname, 0, strlen($classname));

        $arr = array_filter(explode(',', $classname));
        $data = array();


        foreach ($arr as $k => $v) {
            $m['classname'] = $v;
            $m['goods_id'] = $_POST['goods_id'];
            $m['user_id'] = $_SESSION['member_id'];
            $data[] = $m;
        }
//        array_pop($data);
        $res = M('cate')->addAll($data);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => "已添加"));
        }

    }

    public function addComment()
    {
        $data['create_time'] = strtotime(date("Y-m-d H:i:s"));
        $data['user_id'] = $_SESSION['member_id'];
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['phone'] = $_POST['phone'];
        $data['cz'] = $_POST['cz'];
        $data['content'] = $_POST['content'];
        $res = M('discuss')->add($data);
        if ($res) {
            $this->ajaxReturn(array('status' => 1, 'info' => "留言成功"));
        } else {
            $this->ajaxReturn(array('status' => 0, 'info' => "留言失败"));
        }
    }

    /*
    *加入购物车
     */
    public function addCart()
    {
        $member_id = $_SESSION['member_id'];
        if (!$member_id) {
            $this->ajaxReturn(array('status' => 0, 'info' => "请先登录！"));
        }
        $cstore = 0;
        if ($_POST['cstore'] == 0) {
            $cstore = 1;
        } else if ($_POST['cstore'] == 1) {
            $cstore = 2;
        }

        //M('cart')->where(array('user_id'=>$_SESSION['member_id'],'goods_id'=>$_POST['goods_id'],'type'=>$cstore))->select();
        //var_dump(I('post.'));die;
        if($_POST['type']==1){
            $count = M('cart')->where(array('user_id' => $_SESSION['member_id'], 'goods_id' => $_POST['goods_id']))->count();
            if ($count != 0) {
                $this->ajaxReturn(array('status' => 0, 'info' => "已加入购物车"));
            }else{
                $data['goods_id'] = $_POST['goods_id'];
                $data['num'] = $_POST['num'];
                $data['create_at'] = strtotime(date("Y-m-d H:i:s"));
                $data['user_id'] = $_SESSION['member_id'];
                $data['type'] = $_POST['type'];
                $data['is_reed'] = $_POST['is_reed'];
                $data['reed_id'] = $_POST['reed_id'];
                $res = M('cart')->add($data);
                if ($res) {
                    $url = "/Wxin/PersonalCenter/shopcar";
                    $cartnum = M("cart")->where(array('user_id'=>$_SESSION['member_id']))->sum('num');
                    $this->ajaxReturn(array('status' => 1, 'info' => "添加购物车成功,前往购物车查看!",'url'=>$url,'cartnum'=>$cartnum));
                } else {
                    $this->ajaxReturn(array('status' => 0, 'info' => "添加失败"));
                }
            }

        }else if($_POST['type']==2){
            $count = M('cart')->where(array('user_id' => $_SESSION['member_id'], 'goods_id' => $_POST['goods_id'],'is_reed'=>$_POST['is_reed'],'reed_id'=>$_POST['reed_id']))->count();
            if ($count != 0) {
                //创意商店商品可以有多个
                $num1 = M('cart')->where(array('user_id' => $_SESSION['member_id'], 'goods_id' => $_POST['goods_id']))->getField('num');
                //var_dump($num1);die;
                $num = $num1 + $_POST['num'];
                $res = M('cart')->where(array('user_id' => $_SESSION['member_id'], 'goods_id' => $_POST['goods_id']))->setField('num', $num);
                $url = "/shopcar.html";
                $cartnum = M("cart")->where(array('user_id'=>$_SESSION['member_id']))->sum('num');
                if ($res) {
                    $this->ajaxReturn(array('status' => 1, 'info' => "添加购物车成功,前往购物车查看!",'url'=>$url,'cartnum'=>$cartnum));
                } else {
                    $this->ajaxReturn(array('status' => 0, 'info' => "添加失败"));
                }

            }else{
                $data['goods_id'] = $_POST['goods_id'];
                $data['num'] = $_POST['num'];
                $data['create_at'] = strtotime(date("Y-m-d H:i:s"));
                $data['user_id'] = $_SESSION['member_id'];
                $data['type'] = $_POST['type'];
                $data['is_reed'] = $_POST['is_reed'];
                $data['reed_id'] = $_POST['reed_id'];
                $res = M('cart')->add($data);
                if ($res) {
                    $url = "/shopcar.html";
                    $cartnum = M("cart")->where(array('user_id'=>$_SESSION['member_id']))->sum('num');
                    $this->ajaxReturn(array('status' => 1, 'info' => "添加购物车成功,前往购物车查看!",'url'=>$url,'cartnum'=>$cartnum));
                } else {
                    $this->ajaxReturn(array('status' => 0, 'info' => "添加失败"));
                }
            }
        }else{
            $this->ajaxReturn(array('status' => 0, 'info' => "参数错误"));
        }

    }

    public function lease()
    {
        $this->display();
    }

    public function products_dot()
    {
        $member_id = $_SESSION['member_id'];
        if ($member_id == "" | $member_id == null) {
            $this->assign('member_id', 0);
        } else {
            $this->assign('member_id', $member_id);
        }

        $id = $_GET['id'];
        M("goods")->where(array('id' => $id))->setInc('browser', 1);
        $res1 = M('goods_slide')->where(array('goods_id' => $id, 'status' => 1))->field('pic')->select();
        $this->assign('goods_slide', $res1);
        $res = M('goods')->where(array('id' => $id,'is_sale'=>1,'cstore'=>1))->find();
        if (empty($res)) {
            $this->redirect("Wxin/Order/order_error/msg/'产品信息不存在!'");
        }
        $this->assign('res', $res);
        //print_r($res);
        $rel = M('goods')->where(array('goods_cap' => $res['goods_cap']))->limit(4)->select();
        $this->assign('rel', $rel);
        $cate = M('cate')->where(array('is_show' => 1, 'is_del' => 0))->group('classname')->select();
        $this->assign('cate', $cate);

        $like = M('goods')->where(array('is_del' => 0,'is_sale'=>1,'cstore'=>1,'id'=>array('neq',$id)))->limit(4)->select();
        $this->assign('like', $like);

        $count = M('goods_collect')->where(array('good_id' => $id))->count();
        $this->assign('count', $count);
        $this->assign('is_groom', $res['is_groom']);

        $like_collect = M('goods_collect')->where(array('user_id' => $_SESSION['member_id'], 'good_id' => $id))->count();
        $this->assign('like_collect', $like_collect);

        $recommend = M('recommend')->where(array('user_id' => $_SESSION['member_id'], 'good_id' => $id))->count();
        $this->assign('recommend', $recommend);

        $count1 = M('recommend')->where(array('good_id' => $id))->count();
        $this->assign('count1', $count1);


        $this->assign('is_groom',$res['is_groom']);//是否租赁
        //artists_id 判断是否是从推荐店铺过来的
        if(I('get.artists_id')){
            $artists_id = I('get.artists_id');
            $this->assign('artists_id',$artists_id);
        }
        $this->display();
    }

}