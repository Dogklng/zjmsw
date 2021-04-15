<?php namespace Wxin\Controller;

use Think\Controller;
use Think\Model;

class ShopController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',5);
        $this->checkLogin();
		$result = M('member')->where(array('id' => $_SESSION['member_id']))->find();
        $this->assign('result', $result);

		/*$artist_res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
		$count8 = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->count();
        $count11 = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->count();
        $artist_zc = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->find();
        $artist_fa = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>1))->find();
        $artist_bus = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'remind_type'=>2))->find();

		$this->assign('count8',$count8);
        $this->assign('artist_res',$artist_res);
        $this->assign('artist_zc',$artist_zc);
		$this->assign('count11',$count11);
         $this->assign('artist_fa',$artist_fa);
        $this->assign('artist_bus',$artist_bus);*/

    }

    public function shop()
    {
        $this->display();
    }

    public function index(){
        if(IS_AJAX){
            $id = I('post.id');
            $userid = $_SESSION['member_id'];
            $data['series_ids'] = $id;
            //$member_id = $userid;
            $type = M('art_cate')->where(array('id'=>$id))->getField('type');
            $data['type'] = $type;
            $data['ruzhu_status'] = 0;
            $data['user_id'] = $userid;
            //print_r($data);exit;
            $res2 = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
            if(!$res2){
                $sorting = M('apply')->order('sorting desc')->getField('sorting');
                $data['sorting'] = $sorting+1;
                $res1 = M('apply')->add($data);
            }else{
                $res1 = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->save($data);
            }

            if($res1){
                $this->ajaxReturn(array('status'=>1,'info'=>'选择成功!','url'=>'/Wxin/Shop/selNotice'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'选择失败!'));
            }
        }
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($yun['shenhe']==2){
            $this->error('您已经是云推荐，不能申请入驻！');
        }
        $res = M('art_cate')->order('sort asc')->select();
        $this->assign('res',$res);
        $this->display();
    }

    public function selNotice(){
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($yun['shenhe']==2){
            $this->error('您已经是云推荐，不能申请入驻！');
        }
        $this->display();
    }

    public function selAgree(){
        if(IS_AJAX){
            $userid = $_SESSION['member_id'];
            $res = M('apply')->where(array('user_id'=>$userid))->setField(array('xieyi'=>1,'ruzhu_status'=>1));
            $type = M('apply')->where(array('user_id'=>$userid))->getField('type');

            if($res){
                if($type==0){
                    $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/selIdentity'));
                }else{
                    $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/SelIdentityone'));
                }
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'请重新选择!'));
            }
        }
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($yun['shenhe']==2){
            $this->error('您已经是云推荐，不能申请入驻！');
        }
        $content = M('protocol')->where(array('id'=>2))->getField('content');
        $this->assign('content',$content);
        $this->display();
    }

    public function selCenter(){

        $this->display();
    }

    public function selIdentity(){
        if(IS_AJAX){
            $data = I('post.');
            $date['name'] = $data['name'];
            $date['tel'] = $data['tel'];
            $date['f_card'] = $data['cardID'];
            $date['address'] = $data['address'];
            $date['f_zpic'] = $data['pic1'];
            $date['f_fpic'] = $data['pic2'];
            $date['s_province'] = $data['province'];
            $date['s_city'] = $data['city'];
            $date['s_county'] = $data['district'];
            $date['zy_name'] = $data['zy_name'];
            $date['zy_pic'] = $data['zy_pic'];
            $date['logo_pic'] = $data['logo_pic'];
            $date['desc'] = $data['desc'];
            $date['level'] = $data['level'];
            $date['addtime'] = time();
            $date['shenhe'] = 1;
            $date['ruzhu_status'] = 3;
            $user = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
            if($user){
                $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->save($date);
            }else{
                $sorting = M('apply')->order('sorting desc')->getField('sorting');
                $data['sorting'] = $sorting+1;
                $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->add($date);
            }

            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'上传成功,请等待审核!'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败,请重新上传!'));
            }
        }
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($yun['shenhe']==2){
            $this->error('您已经是云推荐，不能申请入驻！');
        }
        $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        $this->assign('res',$res);
        $level = M('artist_level')->where(array('type'=>0))->select();
        $this->assign('level',$level);
        $this->display();
    }

    public function SelIdentityone(){
        if(IS_AJAX){
            $res1 = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();

            $data = I('post.');
            $date['name'] = $data['name'];
            $date['tel'] = $data['tel'];
            $date['f_card'] = $data['cardID'];
            $date['address'] = $data['address'];
            $date['f_zpic'] = $data['pic1'];
            $date['f_fpic'] = $data['pic2'];
            $date['s_province'] = $data['province'];
            $date['s_city'] = $data['city'];
            $date['s_county'] = $data['district'];
            $date['qy_name'] = $data['org_name'];
            $date['qy_zhi'] = $data['business'];
            $date['zhuz_jigou'] = $data['organize'];
            $date['qy_zhipic'] = $data['business_img'];
            $date['zhuz_pic'] = $data['organize_img'];
            $date['ruzhu_status'] = 2;
            $user = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
            if($user){
                $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->save($date);
            }else{
                $sorting = M('apply')->order('sorting desc')->getField('sorting');
                $data['sorting'] = $sorting+1;
                $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->add($date);
            }
            //$res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->save($date);
            if($res1){
                $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/ysjgl'));
            }else{
                if($res){
                    $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/ysjgl'));
                }else{
                    $this->ajaxReturn(array('status'=>0,'提交失败,请重新填写提交'));
                }
            }
        }
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($yun['shenhe']==2){
            $this->error('您已经是云推荐，不能申请入驻！');
        }
        $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        $this->assign('res',$res);
        $this->display();
    }

    public function ysjgl(){
        if(IS_AJAX){
            //dump(123);return false;
            $data = I('post.');
            //print_r($data);exit;
            $data['ruzhu_status'] = 3;
            $data['addtime'] = time();
            $data['qy_name'] = $data['org_name'];
            //$data['member_id'] = $_SESSION['member_id'];
            //$data['create_at'] = time();
            //dump($data)
            //$res = M('artist')->add($data);
            /*if ($data['art_cate'] == 16) {
                M("member")->where(array('id'=>$_SESSION['member_id']))->setField('user_type',1);//艺术品经纪人
            } else {
                M("member")->where(array('id'=>$_SESSION['member_id']))->setField('user_type',2);//艺术家
            }*/
            $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->save($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'创建成功,请等待审核！'));
                //$this->success('创建成功,请等待审核！',U('Home/Shop/selAudit'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'创建失败！'));
                //$this->error('创建失败！',U('Home/Shop/ysjgl'));
            }
            //$this->redirect('Home/PersonalCenter/userinfo');
        }
        $yun = M('yun_apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        if($yun['shenhe']==2){
            $this->error('您已经是云推荐，不能申请入驻！');
        }
        $res2 = M('apply')
            ->alias('a')
            ->join('left join app_art_cate b on a.series_ids=b.id')
            ->where(array('a.user_id'=>$_SESSION['member_id'],'b.name'=>'画廊'))
            ->find();
        if($res2){
            $type = 1;
        }else{
            $type = 0;
        }
        $level = M('artist_level')->where(array('type'=>1))->select();
        $this->assign('level',$level);
        $this->assign('type',$type);
        $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        $this->assign('res',$res);
        //$art_cate = M('art_cate')->select();
        //$school_cate = M('school_cate')->select();
        //$this->assign('school_cate',$school_cate);
        //$this->assign('art_cate',$art_cate);
        $this->display();
    }

    public function selAudit()
    {
        $member_id =$_SESSION['member_id'];
        $res = M('apply')
            ->alias('a')
            ->join('left join app_art_cate b on a.series_ids=b.id')
            ->field('a.*,b.name as cate_name')
            ->where(array('user_id'=>$member_id))->find();
        //$res = M('artist')->where(array('member_id'=>$member_id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*
    *店铺产品列表
    */
   public function dianpu(){
        header('Content-Type:text/html;charset=UTF-8;');
        $member_id = $_SESSION['member_id'];
        $id = $_GET['yunid'];
        //dump($_GET);exit;
        if($id){

           $yun_id = M('yun_apply')->where(array('id'=>$id,'shenhe'=>2))->find();
           $res = M('recommend')->where(array('artist_id'=>$id))->field('good_id')->select();
           $goods2 = array();
           foreach($res as $key=>$value){
               $goods2[] = $value['good_id'];
           }

           $goods3 = array();
           foreach($goods2 as $k=>$v){
                   $goods3[] = M('goods')->where(array('id'=>$v))->select();
           }

           $goods1 = array();
            foreach($goods3 as $ke=>$val){
                foreach($val as $key1=>$val1){
                    $goods1[] = $val1;
                }

            }
            //dump($goods1);exit;

           $userid = M('yun_apply')->where(array('id'=>$id))->getField('user_id');
           $user = M('member')->where(array('id'=>$userid))->find();
            $yun_id['zy_name'] = $user['realname'];
            $yun_id['logo_pic'] = $user['person_img'];

        }else{
            $type = I('get.type');
            $m = M('apply')->where(array('user_id'=>$member_id,'shenhe'=>2))->find();
            // dump($m);exit;

            //$this->assign('artist',$m);
            $map['promulgator'] = $m['id'];
            $map['shenhe'] = 1;   //审核通过
            $map['is_del'] = 0;   //未删除
            $map['is_sale'] = 1; //上架
            $goods1 = M('goods')->where($map)->select();//店铺自己的
            if($type == 2){
                $yun_id = M('yun_apply')->where(array('user_id'=>$member_id,'shenhe'=>2))->find();
                $user = M('member')->where(array('id'=>$yun_id['user_id']))->find();
                $yun_id['zy_name'] = $user['realname'];
                $yun_id['logo_pic'] = $user['person_img'];
                $this->assign('shop_id',$yun_id['id']);
            }else{
                $yun_id = $m;
                $this->assign('shop_id',$m['id']);
            }
            if($yun_id){
                $yun=1;
            }else{
                $yun=2;
            }
            //dump($yun_id);exit;
            $this->assign('type',$type);
            $this->assign('yun',$yun);
            // print_r($yun_id);exit;
            $this->assign('artist',$yun_id);
            $rec = M('recommend')->where(array('artist_id'=>$yun_id['id']))->select();

            $goodids = array();
            if($rec){
                foreach($rec as $Key=>$val){
                    $goodids[] = $val['good_id'];
                }
                $gd['is_del'] = 0;
                $gd['is_sale'] = 1;
                //$gd['shenhe'] = 1;
                $gd['id'] = array('in',$goodids);
                //print_r($goodids);exit;
                $goodss = M('goods')->where($gd)->select();
                // print_r($goodss);exit;
                $this->assign('goodstj',$goodss);
            }

        }
       //dump($yun_id);exit;
        //print_r($goods);
        //推荐来的商品



        $this->assign('goods',$goods1);
        $this->display();
   }

   //云推荐我的店铺
    public function yunpsy(){

        header('Content-Type:text/html;charset=utf-8;');
        $map['is_del'] = 0;
        $map['user_id'] = $_SESSION['member_id'];
        $map['shenhe'] = 2;
        $artists = M('yun_apply')->where($map)->find();
        //dump($artists['id']);exit;
        $this->assign('artists',$artists);
        unset($map);
        //$map['is_del'] = 0;
        $map['tj_shop'] = $artists['id'];
        $detail = 7;
        $map['tj_status'] = 1; //0 否 1是推荐订单
        $this->assign('detail',$detail);

        $map['order_status'] = array('gt',1);

        $count = M('order_info')->order('update_time desc')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        //dump($order);exit;
        foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }
        $summoney = M('order_info')->order('update_time desc')->where($map)->sum('yong_fee');
        //dump($summoney);exit;
        $this->assign('order',$order);
        $this->assign('count',$count);
        $this->assign('summoney',$summoney);



        //先计算当月的 件数 销售额
        $starttime =strtotime(date('Y-m-d H:i:s',mktime(0, 0 , 0,date('m'),1,date('Y')))) ;
        $endtime = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y'))));
        //var_dump($endtime);
        if($map['tj_status'] == 1){
            $map['order_status'] = 4; // 已完成订单
            //$map['update_time'] = array('between',('$starttime,$endtime'));
            $sum = M('order_info')->order('update_time desc')->where($map)->sum('yong_fee');
            //$counts =  M('order_info')->order('update_time desc')->where($map)->count();
            //计算抽佣
            $this->assign('jyun',$sum);

        }
        //print_r($order);
        //die;
        $res = M('bank_list')->where(array('user_id' => $_SESSION['member_id']))->select();
        $this->assign('res', $res);
        $this->display();
    }

    public function get_yunpsy()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $map['is_del'] = 0;
            $map['user_id'] = $_SESSION['member_id'];
            $map['shenhe'] = 2;
            $artists = M('yun_apply')->where($map)->find();
            //dump($artists['id']);exit;
            $this->assign('artists',$artists);
            unset($map);
            //$map['is_del'] = 0;
            $map['tj_shop'] = $artists['id'];
            $detail = 7;
            $map['tj_status'] = 1; //0 否 1是推荐订单
            $this->assign('detail',$detail);

            $map['order_status'] = array('gt',1);

            $count = M('order_info')->order('update_time desc')->where($map)->count();
            $Page  = getpage($count,5);
            $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach($order as $k=>$v){
                $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
                $order[$k]['count'] = $v['count'] = count($v['data']);
                $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
                $order[$k]['index_name']=$v['data'][0]['goods_name'];
                $order[$k]['price']=$v['data'][0]['goods_price'];
                $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
            }
            if($order){
                $str = '';
                foreach($order as $k=>$v){

                    $str .= '<div class="user_r_list">';
                    $str .= '<div class="allorder_topz allorder_topz_sy">';
                    $str .= '<div class="allorder_topz_center">';
                    $str .= '<h5><span>时间：'.date('Y-m-d H:i:s',$v['order_time']).'</span></h5>';
                    $str .= '<h5><span>订单号：'.$v['order_no'].'</span></h5>';
                    $str .= '</div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp"> <div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd"> <a href="javascript:;"><img src="'.$v['index_pic'].'" width="100%" /></a> </div>';
                    $str .= '<div class="shop_xx_right shop_xx_fd">';
                    $str .= '<p><b>'.$v['index_name'].'</b><br />';
                    if($v['is_recommend']==1){
                        $str .= '数量';
                    }else{
                        $str .= '租赁天数';
                    }
                    $str .= '<i>'.$v['goods_nums'].'</i></p><p>';
                    if($v['is_recommend']==1){
                        $str .= '出售价格';
                    }else{
                        $str .= '押金';
                    }
                    $str .= '<i>¥'.$v['price'].'</i></p>';
                    $str .= '<h3 class="shop_xx_jg"><b>';
                    if($detail==6){
                        $str .= '收益';
                    }else if($detail==7){
                        $str .= '佣金';
                    }
                    $str .= '</b><b>¥';
                    if($detail==6){
                        $str .= $v['sub_tree']?$v['sub_tree']:0;
                    }else if($detail==7){
                        $str .= $v['yong_fee']?$v['yong_fee']:0;
                    }
                    $str .= '</b></h3><p>状态 ';
                    switch($v['order_status']){
                        case 1:
                            $str .= '未付款</br>(付款时间24小时)';
                            break;
                        case 2:
                            $str .= '已付款待发货';
                            break;
                        case 3:
                            $str .= '已发货待收货';
                            break;
                        case 4:
                            $str .= '已签收';
                            break;
                        case 5:
                            $str .= '已完成';
                            break;
                        case 6:
                            $str .= '退款中';
                            break;
                        case 7:
                            $str .= '已关闭';
                            break;
                    }
                    $str .= '</p></div><div class="clear"></div></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }

   /*
   *zqj 20171103
    */
    public function seldpsy(){

        header('Content-Type:text/html;charset=utf-8;');


        $map['is_del'] = 0;
        $map['user_id'] = $_SESSION['member_id'];
        $map['shenhe'] = 2;
        $artists = M('apply')->where($map)->find();
        $this->assign('artists',$artists);
        unset($map);
        $map['is_del'] = 0;
        $map['tj_shop'] = $artists['id'];
       if(I('get.detail')){
            $detail = I('get.detail');
            if($detail == 6){
                //店铺订单
                $map['tj_status'] = 0; //0 否 1是推荐订单
            }else if($detail == 7){

                $map['tj_status'] = 1; //0 否 1是推荐订单
            }

              $this->assign('detail',$detail);
        }else{
            $detail = 6;
            $map['tj_status'] = 0;
           // unset($map['tj_status']);
            $this->assign('detail',$detail);
        }
        // if($status){
        //     $map['order_status'] = $status;
        //     $this->assign('status',$status);
        // }else{
        //    unset($map['status']);
        //    $this->assign('status','');
        // }
        $map['order_status'] = array('gt',1);

        $count = M('order_info')->order('update_time desc')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }
        $summoney = M('order_info')->order('update_time desc')->where($map)->sum('sub_tree');
        $this->assign('order',$order);
        $this->assign('count',$count);
        $this->assign('summoney',$summoney);



         //先计算当月的 件数 销售额
        $starttime =strtotime(date('Y-m-d H:i:s',mktime(0, 0 , 0,date('m'),1,date('Y')))) ;
        $endtime = strtotime(date('Y-m-d H:i:s',mktime(23,59,59,date('m'),date('t'),date('Y'))));
        //var_dump($endtime);
        if($map['tj_status'] == 1){
           // $map['order_status'] = 4; // 已完成订单
           // $map['update_time'] = array('between',('$starttime,$endtime'));
           // $sum = M('order_info')->order('update_time desc')->where($map)->sum('total_price');
           // $counts =  M('order_info')->order('update_time desc')->where($map)->count();
           //  //计算云推荐的收益
           //  $yun = M('yunrecomm as ys')->where(array('is_del'=>0))->select();
           //  $juan = "";
           //  foreach($yun as $key => $val){
           //      if($val['company'] == '万'){
           //          $val['salesquota'] = $val['salesquota']*10000;
           //      }else{
           //          $val['salesquota'] = $val['salesquota'];
           //      }
           //      if($counts >= $val['product'] && $sum >= $val['salesquota']){
           //          $juan += $val.","; //把可以获取的卷的id存起来
           //      }
           //  }
           //  $juan = explode(',',$juan);
           //  if(!empty($juan)){
           //      //获得可以得到最多的卷
           //  //print_r($juan);die;
           //      $ju['is_del'] = 0;
           //      $ju['id'] = array('in',$juan);

           //      $jyun = M('yunrecomm')->where($ju)->max('giftcard');
           //      if($jyun){
           //          $this->assign('jyun',$jyun);
           //      }
           //  }
           $map['order_status'] = 4; // 已完成订单
           //$map['update_time'] = array('between',('$starttime,$endtime'));
           $sum = M('order_info')->order('update_time desc')->where($map)->sum('yong_fee');
           //$counts =  M('order_info')->order('update_time desc')->where($map)->count();
            //计算抽佣
            $this->assign('jyun',$sum);

        }
       //print_r($order);
        //die;
        $res = M('bank_list')->where(array('user_id' => $_SESSION['member_id']))->select();
        $this->assign('res', $res);
        $this->display();
    }

    public function get_seldpsy()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $map['is_del'] = 0;
            $map['user_id'] = $_SESSION['member_id'];
            $map['shenhe'] = 2;
            $artists = M('apply')->where($map)->find();
            $this->assign('artists',$artists);
            unset($map);
            $map['is_del'] = 0;
            $map['tj_shop'] = $artists['id'];
            if(I('get.detail')){
                $detail = I('get.detail');
                if($detail == 6){
                    //店铺订单
                    $map['tj_status'] = 0; //0 否 1是推荐订单
                }else if($detail == 7){

                    $map['tj_status'] = 1; //0 否 1是推荐订单
                }

                $this->assign('detail',$detail);
            }else{
                $detail = 6;
                $map['tj_status'] = 0;
                // unset($map['tj_status']);
                $this->assign('detail',$detail);
            }
            // if($status){
            //     $map['order_status'] = $status;
            //     $this->assign('status',$status);
            // }else{
            //    unset($map['status']);
            //    $this->assign('status','');
            // }
            $map['order_status'] = array('gt',1);

            $count = M('order_info')->order('update_time desc')->where($map)->count();
            $Page  = getpage($count,5);
            $show  = $Page->show();//分页显示输出
            $this->assign("page",$show);
            $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach($order as $k=>$v){
                $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
                $order[$k]['count'] = $v['count'] = count($v['data']);
                $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
                $order[$k]['index_name']=$v['data'][0]['goods_name'];
                $order[$k]['price']=$v['data'][0]['goods_price'];
                $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
            }
            if($order){
                $str = '';
                foreach($order as $k=>$v){

                    $str .= '<div class="user_r_list">';
                    $str .= '<div class="allorder_topz allorder_topz_sy">';
                    $str .= '<div class="allorder_topz_center">';
                    $str .= '<h5><span>时间：'.date('Y-m-d H:i:s',$v['order_time']).'</span></h5>';
                    $str .= '<h5><span>订单号：'.$v['order_no'].'</span></h5>';
                    $str .= '</div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp"> <div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd"> <a href="javascript:;"><img src="'.$v['index_pic'].'" width="100%" /></a> </div>';
                    $str .= '<div class="shop_xx_right shop_xx_fd">';
                    $str .= '<p><b>'.$v['index_name'].'</b><br />';
                    if($v['is_recommend']==1){
                        $str .= '数量';
                    }else{
                        $str .= '租赁天数';
                    }
                    $str .= '<i>'.$v['goods_nums'].'</i></p><p>';
                    if($v['is_recommend']==1){
                        $str .= '出售价格';
                    }else{
                        $str .= '押金';
                    }
                    $str .= '<i>¥'.$v['price'].'</i></p>';
                    $str .= '<h3 class="shop_xx_jg"><b>';
                    if($detail==6){
                        $str .= '收益';
                    }else if($detail==7){
                        $str .= '佣金';
                    }
                    $str .= '</b><b>¥';
                    if($detail==6){
                        $str .= $v['sub_tree']?$v['sub_tree']:0;
                    }else if($detail==7){
                        $str .= $v['yong_fee']?$v['yong_fee']:0;
                    }
                    $str .= '</b></h3><p>状态 ';
                    switch($v['order_status']){
                        case 1:
                            $str .= '未付款</br>(付款时间24小时)';
                            break;
                        case 2:
                            $str .= '已付款待发货';
                            break;
                        case 3:
                            $str .= '已发货待收货';
                            break;
                        case 4:
                            $str .= '已签收';
                            break;
                        case 5:
                            $str .= '已完成';
                            break;
                        case 6:
                            $str .= '退款中';
                            break;
                        case 7:
                            $str .= '已关闭';
                            break;
                    }
                    $str .= '</p></div><div class="clear"></div></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    /**
     * 提现
     */
    public function withd(){
        if(IS_AJAX){
           $oid = I('post.oid');//订单id
           $bid = I('post.bid');//订单id
           $oid1 = explode(',',$oid);
           $order_info = M('order_info')->where(array('id'=>array('in',$oid1)))->select();

           if(!$order_info){
                $this->ajaxReturn(array('status'=>0,'info'=>'订单不存在'));
           }
           $bank_list = M('bank_list')->find($bid);
           //判断是否有银行卡
           if(!$bank_list){
                $this->ajaxReturn(array('status'=>0,'info'=>'银行卡不存在'));
           }
           if(!$bank_list['bank_no']){
                $this->ajaxReturn(array('status'=>0,'info'=>'银行卡号不存在'));
           }
           if(!$bank_list['bank_name']){
                $this->ajaxReturn(array('status'=>0,'info'=>'银行卡名字不存在'));
           }
           if(!$bank_list['username']){
                $this->ajaxReturn(array('status'=>0,'info'=>'开户名不存在'));
           }
           if(!$bank_list['telephone']){
                $this->ajaxReturn(array('status'=>0,'info'=>'银行预留手机号不存在'));
           }
           //M('takemoney')->where(array(''))->find();
           $artists = M('apply')->where(array('shenhe'=>2,'is_del'=>0,'user_id'=>$_SESSION['member_id']))->find();
            $data['user_id'] = $_SESSION['member_id'];
            $data['bank_no'] = $bank_list['bank_no'];
            $data['bank_name'] = $bank_list['bank_name'];
            $data['truename'] = $bank_list['username'];
            $data['mobile'] = $bank_list['telephone'];
            $data['addtime'] = time();
            $data['status'] = 1;
            $data['order_ids'] =  $oid;
            $data['artist_id'] =  $artists['id'];
            $yong_fee = '';
            $sub_tree = '';
            foreach($order_info as $key=>$val){
                if($val['tj_status'] == 1){
                    if($val['is_handle'] == 1){
                    //推荐订单
                        $this->ajaxReturn(array('status'=>0,'info'=>'该订单已结算'));
                    }
                      $yong_fee = $yong_fee + $val['yong_fee'];
                    M('order_info')->where(array('id'=>$val['id']))->setField('is_handle',2);//2等待后台审核
                }else{
                        if($val['is_handshop'] == 1){
                        //店铺订单
                            $this->ajaxReturn(array('status'=>0,'info'=>'该订单已结算'));
                        }
                        $sub_tree = $sub_tree + $val['sub_tree'];//店铺订单 店铺收益

                   M('order_info')->where(array('id'=>$val['id']))->setField('is_handshop',2);//2等待后台审核
                 }
            }
           if($order_info[0]['tj_status'] == 1){
                $data['money'] =$yong_fee;
                 $data['class'] = 1;
           }else{
                $data['money'] =$sub_tree;
                 $data['class'] = 2;

           }

          //print_r($data);die;
           $res = M('takemoney')->add($data);
           if($res){

                $this->ajaxReturn(array('status'=>1,'info'=>'提交成功等待后台审核'));
            }else{

                $this->ajaxReturn(array('status'=>0,'info'=>'提交失败！'));
            }
           //$artists = M('artists')->where(array('shenhe'=>1,'is_del'=>0,'member_id'=>$_SESSION['member_id']))->find();
        }
    }
    public function selcpsy()
    {
        $this->display();
    }

    public function selRec()
    {
        $user_id = $_SESSION['member_id'];
        $rec = M('recommend')->where(array('user_id'=>$user_id))->select();

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
            $this->assign('goods',$goodss);
        }

        $this->display();
    }

    public function removeRec()
    {
        $id = I('post.id');
        $res = M('recommend')->where(array('good_id'=>$id))->delete();
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"删除成功"));die;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"删除失败"));die;
        }
    }

    public function selSellout()
    {
        header("Content-Type:text/html;charset=utf-8;");
        if(IS_AJAX){
            $id = I('get.id');
            if(!$id){
                $this->ajaxReturn(array('status'=>0,'info'=>'请选择商品！'));
            }
            $data['is_del'] = 1;
            $data['update_time'] = time();
            $res = M('order_info')->where(array('id'=>$id))->save($data);
            unset($data['update_time']);
            $goods = M('order_goods')->where(array('order_id'=>$id))->save($data);
            if($res){

                $this->ajaxReturn(array('status'=>1,'info'=>'删除成功！'));
            }else{

                $this->ajaxReturn(array('status'=>1,'info'=>'删除失败！'));
            }
        }
        $map['is_del'] = 0;
        $map['user_id'] = $_SESSION['member_id'];
        $map['shenhe'] = 2;
        $artists = M('apply')->where($map)->find();
        $this->assign('artists',$artists);
        unset($map);
        /*$map['is_del'] = 0;
       // $map['tj_shop'] = $artists['id'];
        $map['order_status'] = array('in',array(4,5));
        $count = M('order_info')->order('update_time desc')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
            $order[$k]['person_name'] = M('member')->where(array("id"=>$v['user_id']))->getField('person_name');
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }
        $this->assign('order',$order);*/
        $map['b.is_del'] = 0;
        $map['a.shop_id'] = $artists['id'];
        //$map['b.order_status'] = array('in',array(4,5));
        $map['b.order_status'] = array('egt',2);
        $count = M('order_goods')
            ->alias('a')
            ->join('left join app_order_info b on a.order_no=b.order_no')
            ->where($map)->count();
        //$count = M('order_info')->order('update_time desc')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = M('order_goods')
            ->alias('a')
            ->join('left join app_order_info b on a.order_no=b.order_no')
            ->join('left join app_member c on a.user_id=c.id')
            ->order('b.update_time desc')
            ->field('b.*,c.person_name,a.goods_spic,a.goods_name,a.goods_price,a.goods_nums')
            ->where($map)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
        /*foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
            $order[$k]['person_name'] = M('member')->where(array("id"=>$v['user_id']))->getField('person_name');
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }*/
        $this->assign('order',$order);
        //print_r($order);
        $this->display();
    }

    public function get_selSellout()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $map['is_del'] = 0;
            $map['user_id'] = $_SESSION['member_id'];
            $map['shenhe'] = 2;
            $artists = M('apply')->where($map)->find();
            $this->assign('artists',$artists);
            unset($map);
            $map['b.is_del'] = 0;
            $map['a.shop_id'] = $artists['id'];
            $map['b.order_status'] = array('egt',2);
            $count = M('order_goods')
                ->alias('a')
                ->join('left join app_order_info b on a.order_no=b.order_no')
                ->where($map)->count();
            $Page  = getpage($count,5);
            $order = M('order_goods')
                ->alias('a')
                ->join('left join app_order_info b on a.order_no=b.order_no')
                ->join('left join app_member c on a.user_id=c.id')
                ->order('b.update_time desc')
                ->field('b.*,c.person_name,a.goods_spic,a.goods_name,a.goods_price,a.goods_nums')
                ->where($map)
                ->limit($Page->firstRow.','.$Page->listRows)
                ->select();
            if($order){
                $str = '';
                foreach($order as $k=>$vo){

                    $str .= '<div class="all_dingdan_one">';
                    $str .= '<div class="allorder_topz">';
                    $str .= '<div class="allorder_topz_center">';
                    $str .= '<div class="allorder_topz_right">';
                    switch($vo['order_status']){
                        case 1:
                            $str .= '未付款</br>(付款时间24小时)';
                            break;
                        case 2:
                            $str .= '已付款待发货';
                            break;
                        case 3:
                            $str .= '已发货待收货';
                            break;
                        case 4:
                            $str .= '已签收';
                            break;
                        case 5:
                            $str .= '已完成';
                            break;
                        case 6:
                            $str .= '退款中';
                            break;
                        case 7:
                            $str .= '已关闭';
                            break;
                    }
                    $str .= '</div><div class="clear"></div>';
                    $str .= '</div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp"><div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd"> ';
                    $str .= '<a href="javascript:;"><img src="'.$vo['goods_spic'].'" width="100%" /></a>';
                    $str .= '</div><div class="shop_xx_right shop_xx_fd shop_xx_revenue">';
                    $str .= '<p><b>'.$vo['goods_name'].'</b><br />订单号 <i>'.$vo['order_no'].'</i></p>';
                    $str .= ' <p>买家<i>'.$vo['person_name'].'</i><em></em></p>';
                    $str .= '<h3 class="shop_xx_jg"><b>卖出时间</b><b>'.date('Y-m-d H:i:s',$vo['order_time']).'</b></h3>';
                    $str .= '</div><div class="clear"></div></div></div>';
                    $str .= '<div class="llk_border"><div class="llk">';
                    $str .= '<div class="od_zongji">共<b>'.$vo['goods_nums'].'</b>件商品 实付：<span>¥'.$vo['total_fee'].'</span></div>';
                    $str .= '</div><div class="clear"></div></div>';
                    $str .= ' <div class="od_button">';
                    $str .= '<div class="od_fukuan"><a href="javascript:void(0); " onclick="fukuan(this)" data-id="'.$vo['id'].'">删除订单</a></div>';
                    $str .= '<div class="od_quxiao"><a href="/Wxin/PersonalCenter/orderDetails/tag/selSellout?id='.$vo['id'].'">查看详情</a></div>';
                    $str .= '<div class="clear"></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    public function selEvaluate()
    {
        $this->display();
    }

    public function selDeliver()
    {
        header("Content-Type:text/html;charset=utf-8;");
        if(IS_AJAX){
            $id = I('get.id');
            if(!$id){
                $this->ajaxReturn(array('status'=>0,'info'=>'请选择商品！'));
            }
            $data['is_del'] = 1;
            $data['update_time'] = time();
            $res = M('order_info')->where(array('id'=>$id))->save($data);
            unset($data['update_time']);
            $goods = M('order_goods')->where(array('order_id'=>$id))->save($data);
            if($res){

                $this->ajaxReturn(array('status'=>1,'info'=>'删除成功！'));
            }else{

                $this->ajaxReturn(array('status'=>1,'info'=>'删除失败！'));
            }
        }
        $map['is_del'] = 0;
        $map['user_id'] = $_SESSION['member_id'];
        $map['shenhe'] = 2;
        $artists = M('apply')->where($map)->find();
        $this->assign('artists',$artists);
        unset($map);
        $map['is_del'] = 0;
        $map['shop_id'] = $artists['id'];
        if(I('get.status') == null){

            $map['order_status'] = array('in',array(2,3,4));

        }else{
            $status = I('get.status');
            $map['order_status'] = $status;
        }
        $count = M('order_info')->order('update_time desc')->where($map)->count();
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($order as $k=>$v){
            $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
            $order[$k]['person_name'] = M('member')->where(array("id"=>$v['user_id']))->getField('person_name');
            $order[$k]['count'] = $v['count'] = count($v['data']);
            $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
            $order[$k]['index_name']=$v['data'][0]['goods_name'];
            $order[$k]['price']=$v['data'][0]['goods_price'];
            $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
        }





       //print_r($order);

        /**
         * 物流公司 2016-1-3   Jaw
         */
       $express = M("express")->order("id asc")->select();
        $this->assign("express_list", $express);
        $this->assign('order',$order);
        $this->display();
    }

    public function get_selDeliver()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $map['is_del'] = 0;
            $map['user_id'] = $_SESSION['member_id'];
            $map['shenhe'] = 2;
            $artists = M('apply')->where($map)->find();
            $this->assign('artists',$artists);
            unset($map);
            $map['is_del'] = 0;
            $map['shop_id'] = $artists['id'];
            if(I('get.status') == null){

                $map['order_status'] = array('in',array(2,3,4));

            }else{
                $status = I('get.status');
                $map['order_status'] = $status;
            }
            $count = M('order_info')->order('update_time desc')->where($map)->count();
            $Page  = getpage($count,5);
            $order = M('order_info')->order('update_time desc')->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach($order as $k=>$v){
                $order[$k]['data'] = $v['data'] = M('order_goods')->where(array("order_id"=>$v['id']))->select();
                $order[$k]['person_name'] = M('member')->where(array("id"=>$v['user_id']))->getField('person_name');
                $order[$k]['count'] = $v['count'] = count($v['data']);
                $order[$k]['index_pic']=$v['data'][0]['goods_spic'];
                $order[$k]['index_name']=$v['data'][0]['goods_name'];
                $order[$k]['price']=$v['data'][0]['goods_price'];
                $order[$k]['goods_nums']=$v['data'][0]['goods_nums'];
            }
            if($order){
                $str = '';
                foreach($order as $k=>$vo){
                    $str .= '<div class="user_r_list">';
                    $str .= '<div class="allorder_topz allorder_topz_sy">';
                    $str .= '<div class="allorder_topz_center" style="margin: 47px 0;">';
                    $str .= '<h5><span>时间：'.date('Y-m-d H:i:s',$vo['order_time']).'</span></h5>';
                    $str .= '<h5><span>订单号：'.$vo['order_no'].'</span></h5>';
                    $str .= '<div class="allorder_topz_right delivery_topz_right">';
                    switch($vo['order_status']){
                        case 0:
                            $str .= '已取消';
                            break;
                        case 2:
                            $str .= '待发货';
                            break;
                        case 3:
                            $str .= '已发货';
                            break;
                        case 4:
                            $str .= '已完成';
                            break;
                        case 6:
                            $str .= '退款中';
                            break;
                    }
                    $str .= '</div></div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp"> <div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd"> <a href="javascript:;"><img src="'.$vo['index_pic'].'" width="100%" /></a> </div>';
                    $str .= '<div class="shop_xx_right shop_xx_fd">';
                    $str .= '<p><b>'.$vo['index_name'].'</b><br />数量 <i>'.$vo['goods_nums'].'</i></p>';
                    $str .= '<p>收货人<i>'.$vo['person_name'].'</i></p>';
                    $str .= '<h3 class="shop_xx_jg"><b>单价</b><b>¥'.$vo['price'].'</b></h3>';
                    $str .= '</div><div class="clear"></div></div></div><div class="llk_border">';
                    $str .= '<div class="llk"><div class="od_zongji"> 实付：<span>¥'.$vo['total_fee'].'</span></div>';
                    $str .= ' </div><div class="clear"></div></div>';
                    $str .= '<div class="od_button">';
                    $str .= '<div class="od_fukuan"><a href="/Wxin/PersonalCenter/orderDetails/tag/selSellout?id='.$vo['id'].'">查看详情</a></div>';
                    if($vo['order_status']==2){
                        $str .= '<div class="od_quxiao"><a href="javascript:void();" onclick="quxiao(this)" data-id="'.$vo['id'].'">发货</a></div>';
                    }
                    $str .= '<div class="clear"></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    //发货
    //选择快递公司
    public function express(){
        $data["express_name"]    = I("post.express_name");//编码

        $data["express_no"]      = I("post.express_no");
        $data["is_send"]         = 1;
        $id                      = I('post.id');
        $m          = M('order_info');
        $res = $m->where(array("id"=>$id))->save($data);
        $Info=$m->where(array("id"=>$id))->find();
        $data["express_name"]    = M("express")->where(array('express_ma'=>$data['express_name']))->getField("express_company");//快递公司名称
        if($res){
            //发货成功添加发货时间 修改订单状态
            $res1 = $m->where(array("id"=>$id))->setField(array("order_status"=>3,"shipping_time"=>time()));
            if($res1){
                $d=array(
                    'order_id'=>$Info['id']
                );
                $this->sendSystemMessage($Info['user_id'],"订单已发货","您的订单【".$Info['order_no']."】已发货，【".$data['express_name']."】运单编号：".$data["express_no"]."请注意查收！",$d);
                $this->ajaxReturn(array("status"=>1,'info'=>"发货成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
            }
        }else{
            $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
        }
    }
    //zqj 20171103 查物流
    // public function selExp(){
    //     if(IS_AJAX){

    //     }
    // }



    public function selBill()
    {
        $this->display();
    }

    /*public function selRelease()
    {
        $data['user_id'] = $_SESSION['member_id'];
        $data['shenhe'] = 1;
        $data['shijian'] = array('neq',2);
        $goods = M('goods')->where($data)->select();
        $this->assign('res',$goods);

        $ck = M('goods')->where(array('user_id'=>$_SESSION['member_id'],'shenhe'=>1,'shijian'=>2))->select();
        $this->assign('ck',$ck);
        $this->display();
    }*/
    public function selRelease(){
        $artist_id = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
        $goods = M('goods')->where(array('shenhe'=>1,'is_sale'=>1,'promulgator'=>$artist_id))->select();
        $this->assign('goods',$goods);
        $data['promulgator'] = $artist_id;
        $data['shenhe'] = array('neq',1);
        $data['is_sale'] = 0;
        $ck = M('goods')->where($data)->select();
        $this->assign('ck',$ck);
        $this->display();
    }

    public function delGoods(){
        $res = M('goods')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"删除成功"));die;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"删除失败"));die;
        }
    }

    public function fabu(){
        $res = M('goods')->where(array('id'=>$_POST['id']))->save(array('shijian'=>0));
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"发布成功"));die;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"发布失败"));die;
        }
    }

    /*public function selWarehouse()
    {
        $is_sale = I("is_sale");
        $m = M('goods');
        $map['is_sale'] = 1;
        $map['shenhe'] = 1;
        if($is_sale==1){
            $map['promulgator'] = intval($is_sale);
        }

        if($is_sale==2){
            $map['promulgator'] = intval($is_sale)-2;
        }

        $res = $m->where($map)->order('sort asc')->select();
        foreach ($res as $k=>$v){
            $goods = M('goods_collect')->where(array('good_id'=>$v['id']))->count();
            $res[$k]['count'] = $goods[0]['count'];
        }

        $this->assign('res',$res);
        $this->display();
    }*/

    public function selWarehouse(){
        $apply_id = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
        $map['shenhe'] = array('neq',1);
        $count =  M('goods')->where($map)->where(array('promulgator'=>$apply_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $goods = M('goods')->where($map)->where(array('promulgator'=>$apply_id))->limit($Page->firstRow.','.$Page->listRows)->select();
        /*$m = M('recommend');
        $res1 = $m->select();
        $goods_id = '';
        foreach($res1 as $k=>$v){
            $goods_id .= ($res1[$k]['good_id'].',');
        }
        $goods_id = explode(',',$goods_id);
        $goods_id = array_filter(array_unique($goods_id));
        $map['id'] = array('in',$goods_id);
        //$map['store'] = 1;
        //$map['is_sale'] = 0;//仓库中的
        $res = M('goods')->where($map)->select();
        $this->assign('res',$res);
		$id = $_SESSION['member_id'];
		$res2 = M('apply')->where(array('user_id'=>$id,'is_del'=>0))->find();
		$goods1 = M('goods')->where(array('promulgator'=>$res2['id'],'is_del'=>0,'shenhe'=>1,'is_sale'=>1))->select();

        $goods = M('goods')->where(array('promulgator'=>$res2['id'],'is_del'=>0))->select();*/
        $this->assign('goods',$goods);
		//$this->assign('goods1',$goods1);
        $this->display();
    }

    public function get_selWarehouse()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $apply_id = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
            $map['shenhe'] = array('neq',1);
            $count =  M('goods')->where($map)->where(array('promulgator'=>$apply_id))->count();
            $Page  = getpage($count,10);
            $goods = M('goods')->where($map)->where(array('promulgator'=>$apply_id))->limit($Page->firstRow.','.$Page->listRows)->select();
            if($goods){
                $str = '';
                foreach($goods as $k=>$vo){

                    $str .= '<div class="user_r_list" style="margin-top: 48px;">';
                    $str .= '<div class="allorder_topz">';
                    $str .= '<div class="allorder_topz_center">';
                    $str .= '<h5><span>仓库商品</span></h5>';
                    $str .= '<div class="allorder_topz_right publish_topz_right">';
                    if($vo['shenhe']==1){
                        if($vo['is_sale']==1){
                            $str .='<td>出售</td>';
                        }else{
                            $str .='<td>仓库中</td>';
                        }
                    }elseif($vo['shenhe']==0){
                        $str .='<td>审核中</td>';
                    }elseif($vo['shenhe']==2){
                        $str .='<td>审核拒绝</td>';
                    }
                    $str .= '</div></div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp"><div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd">';
                    $str .= '<a href="javascript:;"><img src="'.$vo['index_pic'].'" width="100%" /></a> </div>';
                    $str .= '<div class="shop_xx_right shop_xx_fd shop_xx_revenue">';
                    $str .= '<p><b>'.$vo['goods_name'].' '.$vo['goods_cap'].'</b><br />喜欢 <i>'.$vo['collection'].'</i></p>';
                    $str .= '<p>价格<i>¥'.$vo['price'].'</i></p>';
                    $str .= '<h3 class="shop_xx_jg" style="margin:0"><b>浏览次数</b><b>'.$vo['browser'].'</b></h3>';
                    $str .= '</div><div class="clear"></div></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    public function selRights()
    {
        $this->display();
    }

    public function selReport()
    {
        $this->display();
    }

    public function selData()
    {
        $this->display();
    }

    /*public function selIdentity()
    {
        $this->display();
    }*/

    public function SelIdentitytwo()
    {
        if(IS_AJAX){
           if(!$_SESSION['member_id']){
                $dataAj['status'] = 2;
                $dataAj['info'] = "请登录";
                $this->ajaxReturn($dataAj);
            }
            $data = I('post.');
            if($data['business'] == ""){
                $dataAj['status'] = 0;
                $dataAj['info'] = "请输入营业执照号";
                $this->ajaxReturn($dataAj);
            }
            if($data['organize'] == ""){
                $dataAj['status'] = 0;
                $dataAj['info'] = "组织机构代码号必填";
                $this->ajaxReturn($dataAj);
            }
            if($data['pic1'] == ""){
                $dataAj['status'] = 0;
                $dataAj['info'] = "请上传营业执照";
                $this->ajaxReturn($dataAj);
            }
            if($data['pic2'] == ""){
                $dataAj['status'] = 0;
                $dataAj['info'] = "组织机构照片不能为空";
                $this->ajaxReturn($dataAj);
            }
            $count = M('yun_shop_authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->count();
            $dataAdd['business'] = $data['business'];
            $dataAdd['organize'] = $data['organize'];
            $dataAdd['business_img'] = $data['pic1'];
            $dataAdd['organize_img'] = $data['pic2'];
            $dataAdd['bus_status'] = 3;
            alert($data);
            if($count  >0){
                $res = M('yun_shop_authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->save($dataAdd);

            }else{
                $res = M('yun_shop_authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->add($dataAdd);
            }
            if($res){

                    $dataAj['status'] = 1;
                    $dataAj['info'] = "提交成功等待后台审核";
                    $this->ajaxReturn($dataAj);
            }else{
                 $dataAj['status'] = 0;
                $dataAj['info'] = "提交失败!请重新提交！";
                $this->ajaxReturn($dataAj);
            }
        }

        $this->display();
    }
    public function legalPerson()
    {
        $this->display();
    }

    public function selClient()
    {
        $this->display();
    }

    public function selCertificates()
    {
        $this->display();
    }

    /*public function selAudit()
    {
		$member_id =$_SESSION['member_id'];
		$res = M('authentication')->where(array('member_id'=>$member_id))->find();
		//$res = M('artist')->where(array('member_id'=>$member_id))->find();
		$this->assign('res',$res);
        $this->display();
    }*/

    public function selAuditSuccess()
    {
        $res = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /*public function selAgree()
    {
        $personType = $_GET['personType'];
        $this->assign('personType',$personType);
        $is_depute = $_GET['is_depute'];
        $this->assign('is_depute',$is_depute);
        $this->display();
    }*/
     public function zl(){
         $res = M('authentication')->where(array('person_type'=>$_POST['personType'],'is_depute'=>$_POST['is_depute'],'user_id'=>$_SESSION['member_id']))->find();
         $res1 = M('member')->where(array('id'=>$_SESSION['member_id']))->save(array('person_type'=>$_POST['personType']));
         if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，后台正在为您审核！请稍等"));die;
        }
         $data['person_type'] = $_POST['personType'];
         $data['is_depute'] = $_POST['is_depute'];
         $data['user_id'] = $_SESSION['member_id'];
         $data['create_time'] = time();
         $res = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->save($data);
         if($res){
             $this->ajaxReturn(array('status'=>1));
         }else{
             $this->ajaxReturn(array('status'=>0,'info'=>"资料提交失败"));
         }
     }
/*    public function zl(){
        if(IS_AJAX){
            $res = M('yun_shop_authentication')->where(array('member_id'=>$_SESSION['member_id']))->find();
            if($res['status'] == 3){
                $this->ajaxReturn(array('status'=>2,'info'=>"您的资料已提交，后台正在为您审核！"));die;
            }
            if($res['status'] == 2){
                $this->ajaxReturn(array('status'=>2,'info'=>"资料审核失败！"));die;
            }
            $data['fuse_type'] = $_POST['personType'];
            $data['is_fa'] = $_POST['is_depute'];
            $data['member_id'] = $_SESSION['member_id'];
            $data['addtime'] = time();
            $data['status'] = 3;
            $res1 = M('yun_shop_authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->save($data);
            if($res1){
                $this->ajaxReturn(array('status'=>1));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"资料提交失败"));
            }
        }


    }
*/
    public function upload_logo2(){
        $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>0,'remind_type'=>2))->count();
        if($count == 1){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，正在审核"));die;
        }
        header('Content-type:textml;charset=utf-8');
        $base64_image_content = $_POST['pic1'];
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $savepath = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath)) {
                mkdir($savepath);
            }
            $type_arr=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type,$type_arr)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type));exit;
            }
            $new_file = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file))
            {
                mkdir($new_file, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file = $savepath.time().".{$type}";
            if (!file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $this->ajaxReturn(array('status'=>0,'info'=>'图片上传失败','file_path'=>ltrim($new_file,'.')));exit;
            }
        }



        $base64_image_content2 = $_POST['pic2'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content2, $result2)){
            $type2 = $result2[2];
            $savepath2 = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath2)) {
                mkdir($savepath2);
            }
            $type_arr2=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type2,$type_arr2)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type2));exit;
            }
            $new_file2 = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file2))
            {
                mkdir($new_file2, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file2 = $savepath2.(time()+10).".{$type2}";
            if (file_put_contents($new_file2, base64_decode(str_replace($result2[1], '', $base64_image_content2)))){
                $data = I('post.');
                $data['addtime'] = strtotime(date("Y-m-d"));
                $data['user_id'] = $_SESSION['member_id'];
                $data['remind_type'] = 2;
                $data['business_img'] = trim($new_file,'.');
                $data['organize_img'] = trim($new_file2,'.');

                M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->add($data);
                $this->ajaxReturn(array('status'=>1,'info'=>'提交成功','file_path'=>ltrim($new_file2,'.')));exit;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'提交失败','file_path'=>ltrim($new_file2,'.')));exit;
            }
        }

    }
    public function upload_logo1(){
        $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>0,'remind_type'=>1))->count();
        if($count == 1){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，正在审核"));die;
        }
        header('Content-type:textml;charset=utf-8');
        $base64_image_content = $_POST['pic1'];
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $savepath = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath)) {
                mkdir($savepath);
            }
            $type_arr=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type,$type_arr)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type));exit;
            }
            $new_file = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file))
            {
                mkdir($new_file, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file = $savepath.time().".{$type}";
            if (!file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $this->ajaxReturn(array('status'=>0,'info'=>'图片上传失败','file_path'=>ltrim($new_file,'.')));exit;
            }
        }



        $base64_image_content2 = $_POST['pic2'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content2, $result2)){
            $type2 = $result2[2];
            $savepath2 = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath2)) {
                mkdir($savepath2);
            }
            $type_arr2=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type2,$type_arr2)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type2));exit;
            }
            $new_file2 = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file2))
            {
                mkdir($new_file2, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file2 = $savepath2.(time()+10).".{$type2}";
            if (file_put_contents($new_file2, base64_decode(str_replace($result2[1], '', $base64_image_content2)))){
                $data = I('post.');
                $data['addtime'] = strtotime(date("Y-m-d"));
                $data['user_id'] = $_SESSION['member_id'];
                $data['remind_type'] = 1;
                $data['card_img'] = trim($new_file,'.');
                $data['card_img1'] = trim($new_file2,'.');

                M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->add($data);
                $this->ajaxReturn(array('status'=>1,'info'=>'提交成功','file_path'=>ltrim($new_file2,'.')));exit;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'提交失败','file_path'=>ltrim($new_file2,'.')));exit;
            }
        }

    }

    public function upload_logo3(){
        $count = M('authentication')->where(array('user_id'=>$_SESSION['member_id'],'status'=>0,'remind_type'=>3))->count();
        if($count == 1){
            $this->ajaxReturn(array('status'=>1,'info'=>"您的资料已提交，正在审核"));die;
        }
        header('Content-type:textml;charset=utf-8');
        $base64_image_content = $_POST['pic1'];
//匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $savepath = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath)) {
                mkdir($savepath);
            }
            $type_arr=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type,$type_arr)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type));exit;
            }
            $new_file = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file))
            {
                mkdir($new_file, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file = $savepath.time().".{$type}";
            if (!file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                $this->ajaxReturn(array('status'=>0,'info'=>'图片上传失败','file_path'=>ltrim($new_file,'.')));exit;
            }
        }

        $base64_image_content3 = $_POST['pic3'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content3, $result3)){
            $type3 = $result3[2];
            $savepath3 = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath3)) {
                mkdir($savepath3);
            }
            $type_arr3=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type3,$type_arr3)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type3));exit;
            }
            $new_file3 = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file3))
            {
                mkdir($new_file3, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file3 = $savepath3.(time()+20).".{$type3}";
            if (!file_put_contents($new_file3, base64_decode(str_replace($result3[1], '', $base64_image_content3)))){
                $this->ajaxReturn(array('status'=>0,'info'=>'图片上传失败','file_path'=>ltrim($new_file3,'.')));exit;
            }
        }



        $base64_image_content2 = $_POST['pic2'];
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content2, $result2)){
            $type2 = $result2[2];
            $savepath2 = './Uploads/Picture/uploads/' . date('Ymd') . '/';
            if (!file_exists($savepath2)) {
                mkdir($savepath2);
            }
            $type_arr2=array('jpg', 'gif', 'png', 'jpeg', 'svg');
            if(!in_array($type2,$type_arr2)){
                $this->ajaxReturn(array('status'=>0,'info'=>'上传失败！图片格式不正确！','type'=>$type2));exit;
            }
            $new_file2 = "upload/active/img/".date('Ymd',time())."/";
            if(!file_exists($new_file2))
            {
                mkdir($new_file2, 0700);//检查是否有该文件夹，如果没有就创建，并给予最高权限
            }
            $new_file2 = $savepath2.(time()+10).".{$type2}";
            if (file_put_contents($new_file2, base64_decode(str_replace($result2[1], '', $base64_image_content2)))){
                $data = I('post.');
                $data['addtime'] = strtotime(date("Y-m-d"));
                $data['user_id'] = $_SESSION['member_id'];
                $data['remind_type'] = 3;
                $data['card_img'] = trim($new_file,'.') ;
                $data['card_img1'] = trim($new_file2,'.');
                $data['depute_img'] = trim($new_file3,'.');
                M('authentication')->where(array('user_id'=>$_SESSION['member_id']))->add($data);
                $this->ajaxReturn(array('status'=>1,'info'=>'提交成功','file_path'=>ltrim($new_file2,'.')));exit;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'提交失败','file_path'=>ltrim($new_file2,'.')));exit;
            }
        }

    }

    public function selSuccess()
    {
        $id = I('get.id');
        if($id){
            $this->assign('status',$id);
        }
        $this->display();
    }

    public function selUpload()
    {
        $id = I('get.id');
        if(!empty($id)){
            $goods = M('goods')->where(array('id'=>$id))->find();
            $slide = M('goods_slide')->where(array('goods_id'=>$goods['id']))->select();
            $this->assign('goods',$goods);
            $this->assign('slide',$slide);
        }

        $mm = M("goods_attribute");
        $map = array(
            "pid" => 0,
            "isdel" => 0,
            "type" => 1,
        );
        $attr = $mm->where($map)->order("sort desc")->select();
        foreach ($attr as $k => $v) {
            $attr[$k]["data"] = $mm->where(array("pid" => $v['id']))->select();
        }
        $this->assign("attr", $attr);
        $res = M('series')->where(array('isdel'=>'0','cstores'=>0))->select();
        $res1 = M('series')->where(array('isdel'=>'0','cstores'=>1))->order('id asc')->select();
        $this->assign('res',$res);
        $this->assign('res1',$res1);
        $this->display();
    }

    public function addGoods()
    {
        if (IS_AJAX){
            $freight = M('freight_config')->where(array('user_id'=>$_SESSION['member_id']))->find();
            if(!$freight){
                $this->ajaxReturn(array('status'=>0,'info'=>'请先添加运费规则！'));
            }
            $artist_id = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
            $data = I('post.');
            //print_r($data);exit;
            $qiehuan_pic = $data['qiehuan_pic'];
			$type=M('series')->where("id=".$data['series_id'])->getField('cstores');
			$data['cstore']=$type;
            $data['is_groom'] = 1;
            $data['promulgator'] = $artist_id;
            $data['sort'] = 0;
            M()->startTrans();
            if(!empty($data['id'])){
                $data['shenhe'] = 0;
                $goods = M('goods')->where($data)->find();
                if(!$goods){
                    $res = M('goods')->where(array('id'=>$data['id']))->save($data);
                    if(!$res){
                        M()->rollback();
                        $this->ajaxReturn(array('status'=>0,'info'=>'修改失败！'));
                    }
                }
                foreach($qiehuan_pic as $k=>$v){
                    $slide_data = array(
                        "goods_id"   => $data['id'],
                        "sort"       => $k,
                        "create_at"  => time(),
                        "pic"        => $v,
                        "status"     => 1,
                    );
                    $res1 = M("goodsSlide")->add($slide_data);
                    if(!$res1){
                        M()->rollback();
                        $this->ajaxReturn(array('status'=>0,'info'=>'修改失败！'));
                    }
                }
            }else{
                $res = M('goods')->add($data);
                if(!$res){
                    M()->rollback();
                    $this->ajaxReturn(array('status'=>0,'info'=>'发布失败！'));
                }
                foreach($qiehuan_pic as $k=>$v){
                    $slide_data = array(
                        "goods_id"   => $res,
                        "sort"       => $k,
                        "create_at"  => time(),
                        "pic"        => $v,
                        "status"     => 1,
                    );
                    $res1 = M("goodsSlide")->add($slide_data);
                    if(!$res1){
                        M()->rollback();
                        $this->ajaxReturn(array('status'=>0,'info'=>'发布失败！'));
                    }
                }
            }
            M()->commit();
            $this->ajaxReturn(array('status'=>1,'info'=>$data['id']?'修改成功':'发布成功！'));
        }
    }

    /*public function addGoods(){
        $artist_id = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->getField('id');
        if(IS_POST){
            $m     = M('goods');
            $g_s_m = M('goodsSlide');
            $data  = I('post.');
            $slide_pic = $data['pic1'];
            unset($data['pic1']);
            $data['promulgator'] = $artist_id;
            dump($data);exit;
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
                $this->error("提交失败！",U('Home/Shop/selUpload'));
            }
        $this->redirect('Home/Shop/selUpload');
        }
    }*/

   /* public function selCenter(){
        $user_id = $_SESSION['member_id'];
        $artist = M("artist")->where(array('member_id'=>$user_id))->getField('id');
        if($artist){
            $this->redirect('Home/shop/seldpsy');
        }
        //$owner = M('member')->where(array('id'=>$user_id))->getField('person_name');
        $sql = "select person_name,realname,telephone,card_id,email from app_member where id=$user_id";
        $owner = M()->query($sql);
        //if(!$owner){
         //   $this->error('您的账号信息不够完善！',U('/Home/PersonalCenter/userInfo/id/').{$user_id});
       // }
        $this->assign('owner',$owner);
        $this->display();
    }*/

    /*public function selNotice()
    {
        $this->display();
    }*/

    public function selCompanyNotice()
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

        $person_type = M('authentication')->where(array('member_id'=>$_SESSION['member_id']))->getField('person_type');
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
        $res = M('member')->where(array('id'=>$_SESSION['member_id'],'is_del'=>0))->find();
        $res1 = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'is_del'=>0,'remind_type'=>1))->find();
        //print_r($res);
        if($res1['fa_status'] == 1 && $res1['bus_status'] == 1){
            $this->assign('status',1);
        }

        $res2 = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'is_del'=>0,'remind_type'=>2))->find();

		$count1 = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'is_del'=>0,'remind_type'=>1))->count();
		$count2 = M('authentication')->where(array('member_id'=>$_SESSION['member_id'],'is_del'=>0,'remind_type'=>2))->count();
        //dump($_SESSION['member_id']);exit;
		$this->assign('count1',$count1);
		$this->assign('count2',$count2);
        $this->assign('res1',$res1);
        $this->assign('res2',$res2);
        $this->assign('res',$res);
        $this->display();
    }
    public function selOnSale()
    {
        $artist_id = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
       // dump($)
        //dump($artist_id);exit;
        $count = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id))->limit($Page->firstRow.','.$Page->listRows)->select();
        //dump($res);exit;
        foreach ($res as $k=>$v){
            $goods = M('goods_collect')->where(array('good_id'=>$v['id']))->count();
            $res[$k]['count'] = $goods[0]['count'];
        }

        //dump($res);exit;
        $this->assign('res',$res);
        $this->display();
    }

    public function get_selOnSale(){
        if (IS_AJAX) {
            $p = I("post.p");
            $_GET['p'] = $p;
            $artist_id = M('apply')->where(array('user_id'=>$_SESSION['member_id']))->getField('id');
            // dump($)
            //dump($artist_id);exit;
            $count = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id))->count();
            $Page  = getpage($count,10);
            $res = M('goods')->where(array('shenhe'=>1,'promulgator'=>$artist_id))->limit($Page->firstRow.','.$Page->listRows)->select();
            //dump($res);exit;
            foreach ($res as $k=>$v){
                $goods = M('goods_collect')->where(array('good_id'=>$v['id']))->count();
                $res[$k]['count'] = $goods[0]['count'];
            }
            if($res){
                $str = '';
                foreach($res as $k=>$v){

                    $str .= '<div class="user_r_list" style="margin-top: 48px;">';
                    $str .= '<div class="allorder_topz"><div class="allorder_topz_center">';
                    $str .= '<h5><span>';
                    if($v['is_sale']==1){
                        $str .= '<td>出售中</td>';
                    }elseif($v['is_sale']==0){
                        $str .= '<td>下架中</td>';
                    }
                    $str .= ' </span></h5><div class="allorder_topz_right publish_topz_right">';
                    if($v['is_sale']==1){
                        $str .= '<td>出售中</td>';
                    }elseif($v['is_sale']==0){
                        $str .= '<td>下架中</td>';
                    }
                    $str .= '</div></div></div><div class="allorder_kuang">';
                    $str .= '<div class="shop_xx_warp"> <div class="shop_xx_center">';
                    $str .= '<div class="shop_xx_left shop_xx_fd">';
                    $str .= '<a href="javascript:;"><img src="'.$v['index_pic'].'" width="100%" /></a> </div>';
                    $str .= '<div class="shop_xx_right shop_xx_fd shop_xx_revenue">';
                    $str .= ' <p><b>'.$v['goods_name'].' '.$v['goods_cap'].'</b><br />喜欢 <i>'.$v['count'].'</i></p>';
                    $str .= ' <p>价格<i>¥'.$v['price'].'</i></p>';
                    $str .= '<h3 class="shop_xx_jg" style="margin:0"><b>浏览次数</b><b>'.$v['browser'].'</b></h3>';
                    $str .= '</div><div class="clear"></div></div></div>';
                    $str .= ' <div class="od_button">';
                    if($v['is_sale']==1){
                        $str .= '<div class="od_fukuan"><a onclick="fukuan(this)" href="javaScript:;" data-id="'.$v['id'].'" data-type="'.$v['is_sale'].'">下架</a></div>';
                    }
                    if($v['is_sale']==0){
                        if($v['is_buy']==1){
                            $str .= '<div class="od_fukuan"><a href="##" data-id="'.$v['id'].'" data-type="'.$v['is_sale'].'">已出售</a></div>';
                        }else{
                            $str .= '<div class="od_quxiao"><a onclick="fukuan(this)" href="javaScript:;" data-id="'.$v['id'].'" data-type="'.$v['is_sale'].'">上架</a></div>';
                        }
                    }
                    $str .= '<div class="clear"></div></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    public function selGroom()
    {
        $artist_id = M('artist')->where(array('member_id'=>$_SESSION['member_id']))->getField('id');
        //dump($artist_id);exit;
        $res = M('recommend')
            ->alias('a')
            ->join('left join app_goods b on a.good_id=b.id')
            ->where(array('a.user_id'=>$_SESSION['member_id'],'b.is_sale'=>1))->order('a.id desc')->select();
        //dump($res);exit;
        /*foreach ($res as $k=>$v){
            $goods = M('goods_collect')->where(array('good_id'=>$v['id']))->count();
            $res[$k]['count'] = $goods[0]['count'];
        }*/
        //dump($_SESSION['member_id']);exit;
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
               // dump($data);

            $fdata['fa_name'] = $data['name'];
            $fdata['member_id'] = $_SESSION['member_id'];
			//dump($fdata['member_id']);exit;
            if($remind_type == 1){
                $data['card_img'] = $data['pic1'];
                $data['card_img1'] = $data['pic2'];
            } else{
                $data['business_img'] = $data['pic1'];
                $data['organize_img'] = $data['pic2'];
            }

			$data['card_img'] = $data['pic1'];
			$data['card_img1'] = $data['pic2'];
			$data['member_id'] = $_SESSION['member_id'];
			$data['addtime'] = time();
           /* if($data['remind_type'] == 1){
                $data['fa_status'] = 0;
            }
            if($data['remind_type'] == 2){
                $data['bus_status'] = 0;
            }*/

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
			$data['card_img'] = $data['pic1'];
			$data['card_img1'] = $data['pic2'];
			$data['member_id'] = $_SESSION['member_id'];
			$data['addtime'] = time();
            $count = M('authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->count();
             if($count>0){

                 $res = M('authentication')->where(array('is_del'=>0,'member_id'=>$_SESSION['member_id']))->save($data);

             }else{
                  $res = M('authentication')->add($data);

             }

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
                $this->success('提交成功',U('Wxin/Shop/hlgl'));
            }else{
                $this->error('提交失败',U('Wxin/Shop/hlgl'));
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
                $this->success('提交成功',U('Wxin/Shop/hlgl'));
            }else{
                $this->error('提交失败',U('Wxin/Shop/hlgl'));
            }
				$this->redirect('Wxin/PersonalCenter/userinfo');
			}


		$this->display();
	}

	/*public function ysjgl(){
		if(IS_POST){
			$data = I('post.');
			$data['member_id'] = $_SESSION['member_id'];
			$data['create_at'] = time();
            //dump($data)
			$res = M('artist')->add($data);
			if ($data['art_cate'] == 16) {
			    M("member")->where(array('id'=>$_SESSION['member_id']))->setField('user_type',1);//艺术品经纪人
            } else {
                M("member")->where(array('id'=>$_SESSION['member_id']))->setField('user_type',2);//艺术家
            }
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
	}*/

	public function fbzc(){
	    if(IS_POST){
	        $data = I('post.');
            $data['promulgator'] = $_SESSION['member_id'];
            $data['create_at'] = time();
            $data['start'] = strtotime($_POST['start']);
            $data['end'] = strtotime($_POST['end']);
            $res = M('crowd')->add($data);
            if($res){
                $this->success('新增成功！',U('Wxin/PersonalCenter/crowdRec/tag/crowdRec/value/7'));
            }else{
                $this->error('新增失败！',U('Wxin/PersonalCenter/crowdRec/tag/crowdRec/value/7'));
            }
        }
        $crowd_cate = M('crowd_cate')->select();
	    $this->assign('crowd_cate',$crowd_cate);
	    $this->display();
    }


    /*
     * 入驻
     * */
    public function apply(){
        $id = I('post.id');
        $res = M('apply')->where(array('user_id'=>$id))->find();
        if($res['ruzhu_status'] == 0){
            $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/index'));
        }elseif($res['ruzhu_status'] == 1){
            if($res['type'] == 0){
                $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/selIdentity'));
            }else{
                $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/selIdentityOne'));
            }
        }elseif($res['ruzhu_status'] == 2){
            $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/ysjgl'));
        }elseif($res['ruzhu_status'] == 3){
            $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/selAudit'));
        }elseif($res['ruzhu_status'] == 4){
            $this->ajaxReturn(array('status'=>1,'url'=>'/Wxin/Shop/selAudit'));
        }else{
            $this->ajaxReturn(array('status'=>2,'url'=>'/Wxin/Shop/seldpsy'));
        }
    }

    //运费配置
    public function carriage_regulation(){

        $m = M('freight_config');
        $express = $m->where(array('user_id'=>$_SESSION['member_id']))->order('sort asc')->select();
        foreach ($express as $key => $val) {
            $region = M('frei_link_region')->where(array('freight_id'=>$val['id']))->field('region_id')->select();
            $region_name = '';
            if(!$region){
                $region_name = '无';
            }else{
                foreach ($region as $k => $v) {
                    $reg = M('region')->where(array('id'=>$v['region_id']))->field('region_name')->find();
                    $region_name .= $reg['region_name'].' , ';
                }
                $region_name = rtrim($region_name,', ');
            }
            $express[$key]['region_name'] = $region_name;
        }

        $this->assign("express", $express);
        $this->assign("urlname", 'express');
        $this->display();

    }

    public function link(){
        $res = M('goods')->where(array('cstore'=>1,'is_like'=>0,'is_del'=>0,'is_sale'=>1))->select();
        $count = count($res);
        $goods = array();
        if($count>=3){
            $number = range(1,$count);
            shuffle($number);
            $result = array_slice($number,0,3);
            $num1 = $result[0]-1;
            $num2 = $result[1]-1;
            $num3 = $result[2]-1;
            $goods[] = $res["{$num1}"];
            $goods[] = $res["{$num2}"];
            $goods[] = $res["{$num3}"];
        }

        $res1 = M('recommend')
            ->alias('a')
            ->join('left join app_goods b on a.good_id=b.id')
            ->field('a.*,b.goods_name,b.index_pic,b.price')
            ->where(array('a.user_id'=>$_SESSION['member_id']))->select();
        //dump($res1);exit;
        $this->assign('res1',$res1);
        $this->assign('goods',$goods);
        $this->display();
    }




    public function goodslist(){

        if(IS_AJAX){
            $goods_name = trim(I('post.goods_name'));

            $res = M('recommend')
                ->alias('a')
                ->join('left join app_goods b on a.good_id=b.id')
                ->field('a.good_id')
                ->where(array('a.user_id'=>$_SESSION['member_id']))->select();
            if ($res){
                $goods_ids = $this->goods_ids($res);
                if($goods_name){
                    $where = array(
                        'isdel'=>0,
                        'is_sale'=>1,
                        'goods_name'=>array('like',"%$goods_name%"),
                        'cstore'=>1,
                        'id'=>array('notin',$goods_ids)
                    );
                }else{
                    $where = array(
                        'isdel'=>0,
                        'is_sale'=>1,
                        'cstore'=>1,
                        'id'=>array('notin',$goods_ids)
                    );
                }
            }else{
                if($goods_name){
                    $where = array(
                        'isdel'=>0,
                        'is_sale'=>1,
                        'goods_name'=>array('like',"%$goods_name%"),
                        'cstore'=>1
                    );
                }else{
                    $where = array(
                        'isdel'=>0,
                        'is_sale'=>1,
                        'cstore'=>1
                    );
                }
            }
            $info = M('goods')->where($where)->select();
            if($info){
                $this->ajaxReturn(array('status'=>1,'info'=>$info));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'暂无更多推荐商品'));
            }

        }
    }

    //返回goods_ids
    public function goods_ids($res){
        $goods_ids = '';
        foreach ($res as $k=>$v){
            $goods_ids .=$v['good_id'].',';
        }
        $goods_ids = rtrim($goods_ids,',');
        return $goods_ids;
    }

    public function addrecommend(){

        if(IS_AJAX){
            $goods_ids = rtrim(I('post.goods_ids'),',');
            $goods_ids = explode(',',$goods_ids);
            $user_id = $_SESSION['member_id'];
            if(!$user_id){
                $this->ajaxReturn(array('status'=>0,'info'=>'请登录'));die;
            }
            $yun_apply = M('yun_apply')->where(array('user_id'=>$user_id))->find();
            $old_num = M('recommend')->where(array('user_id'=>$user_id))->count();
            if((count($goods_ids)+$old_num)>$yun_apply['nums']){
                $this->ajaxReturn(array('status'=>0,'info'=>'推荐商品数量超过剩余可推荐数量'));die;
            }
            foreach ($goods_ids as $k=>$v){
                $data=array(
                    'good_id'=>$v,
                    'user_id'=>$user_id,
                    'artist_id'=>$yun_apply['id']
                );
                $res = M('recommend')->add($data);
                if(!$res){
                    $this->ajaxReturn(array('status'=>0,'info'=>'添加推荐商品失败'));die;
                }
            }
            $this->ajaxReturn(array('status'=>1,'info'=>'添加推荐商品成功'));
        }
    }

    public function delslide(){
        if(IS_AJAX){
            $id = I('post.slide_id');
            if(!$id){
                $this->ajaxReturn(array('status'=>0,'info'=>'非法操作'));die;
            }
            $res = M('goods_slide')->where(array('id'=>$id))->delete();
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'删除成功'));die;
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'删除失败'));die;
            }
        }
    }
}