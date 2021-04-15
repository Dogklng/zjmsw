<?php namespace Wxin\Controller;

use Think\Controller;

class PmController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',1);
    }

    public function img(){
        $images = M('banner')->where(array('type'=>5,'isdel'=>0))->find();
        $this->assign('images',$images);
    }

    /*
     * 添加手机提醒
     */
    public function addRemind(){
        if(!$_POST['goods_id']=='' || !$_POST['goods_id']==null){
            $res = M('pmtel_remind')->where(array('user_id'=>$_SESSION['member_id'],'goods_id'=>$_POST['goods_id']))->find();
            if($res != null){
                $this->ajaxReturn(array('status'=>1,'info'=>"您已提交短信通知"));
            }
            $data = I('post.');
            $data['user_id'] = $_SESSION['member_id'];
            $res = M('pmtel_remind')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"短信通知添加成功"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"短信通知添加失败"));
            }
        }
        if (!$_POST['num_id']=='' || !$_POST['num_id']==null){
            $res = M('pmtel_remind')->where(array('user_id'=>$_SESSION['member_id'],'num_id'=>$_POST['num_id']))->find();
            if($res != null){
                $this->ajaxReturn(array('status'=>1,'info'=>"您已提交短信通知"));
            }
            $data = I('post.');
            $data['user_id'] = $_SESSION['member_id'];
            $data['is_lx'] = 1;
            $res = M('pmtel_remind')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"短信通知添加成功"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"短信通知添加失败"));
            }
        }


    }

    //保障金  服务保障

    public function service(){
        //服务保障
        $service = M("goods_service")->where('id=1')->find();
        $this->assign('service',$service);

        //保障金
        $baozhangjin = M("goods_bz")->where('id=1')->find();
        $this->assign('baozhangjin',$baozhangjin);

        //友情提醒
        $remind = M("goods_remind")->where('id=1')->find();
        $this->assign('remind',$remind);
    }

    /**
     * 出价
     */
    public function chuJia(){
        if (IS_AJAX){
            $data = I('post.');
            $data['user_id'] = $this->user_id;
            $data['time'] = time();
            $pm = M('pm')->where(array('id'=>$data['goods_id']))->find();

            if ($data['user_id']==$pm['member_id']){
                $this->ajaxReturn(array('status'=>0,'info'=>"自己的拍品不可竞拍！"));
            }


            if ($pm['end']<=time()){
                $this->ajaxReturn(array('status'=>2,'info'=>"拍卖已结束！".$pm['end'].','.time()));
            }else{
                $res = M('chujia')->where(array('goods_id'=>$data['goods_id']))->order('id desc')->find();
                if ($res){

                    if ($data['jiage'] >=($res['jiage']+$pm['fudu'])){
                        if ($res['jiage']>=$pm['baoliu']){
                            if ($res['user_id']==$data['user_id']){
                                $this->ajaxReturn(array('status'=>1,'info'=>array('err'=>"你已经领先！",'dangqian'=>$res['jiage'])));
                            }
                        }
                        $res2 = M('pm')->where(array('id'=>$data['goods_id']))->setField(array('dangqian'=>$data['jiage']));
                        $res = M('chujia')->add($data);
                        if ($res){
                            $this->ajaxReturn(array('status'=>1,'info'=>array('err'=>"出价成功！",'dangqian'=>$data['jiage'])));
                        }
                        $this->ajaxReturn(array('status'=>0,'info'=>array('err'=>"出价失败！",'dangqian'=>$res['jiage'])));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>array('err'=>"出价失败！价格过低！",'dangqian'=>$res['jiage'])));
                    }
                }else{
                    if ($data['jiage'] >=($pm['start_price'])){
                        $res = M('chujia')->add($data);
                        if ($res){
                            $this->ajaxReturn(array('status'=>1,'info'=>array('err'=>"出价成功！",'dangqian'=>$data['jiage'])));
                        }
                        $this->ajaxReturn(array('status'=>0,'info'=>array('err'=>"出价失败！",'dangqian'=>$pm['start_price'])));
                    }else{
                        $this->ajaxReturn(array('status'=>0,'info'=>array('err'=>"出价失败！价格过低！",'dangqian'=>$pm['start_price'])));
                    }
                }
            }
        }
    }

    /**
     * 出价记录
     */
    public function chujiaJL(){
        if (IS_AJAX){
            $goods_id = I('get.goods_id');
            $id = I('get.id',0);

            $info = M('chujia as a')
                ->join('left join app_member as b on a.user_id = b.id')
                ->where(array('a.goods_id'=>$goods_id,'a.id'=>array('gt',$id)))
                ->order('a.id desc')
                ->field('b.person_name,a.id,a.goods_id,a.user_id,a.jiage,a.time,a.zan')
                ->select();

            //dump($info);
            foreach ($info as $k=>$v){
                $map['chujia_id'] = $v['id'];
                $map['user_id'] = $_SESSION['member_id'];
                $is_zan= M('zan')->where($map)->where(array('is_quxiao'=>0))->count();
                $info[$k]['is_zan'] = $is_zan?$is_zan:0;
                $info[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
            }

            if ($info){
                $this->ajaxReturn(array('status'=>1,'info'=>$info));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>0));
            }
        }
    }


    public function zan(){
        if (IS_AJAX){
            $chujia_id = I('get.chujia_id');
            $goods_id = I('get.goods_id');
            $data['goods_id'] = $goods_id;
            $data['chujia_id'] = $chujia_id;
            $data['user_id'] = $_SESSION['member_id'];

            $res = M('zan')->where($data)->find();
            $chujia = M('chujia')->where(array('id'=>$chujia_id))->find();
            if ($res){
                $resg = M('zan')->where($data)->save(array('is_quxiao'=>1-$res['is_quxiao']));
                if ($resg){
                    if ($res['is_quxiao']==1){
                        M('chujia')->where(array('id'=>$chujia_id))->save(array('zan'=>$chujia['zan']+1));
                        $this->ajaxReturn(array('status'=>1,'info'=>'点赞成功！','data'=>$chujia_id));
                    }else{
                        M('chujia')->where(array('id'=>$chujia_id))->save(array('zan'=>$chujia['zan']-1));
                        $this->ajaxReturn(array('status'=>-1,'info'=>'取消成功！','data'=>$chujia_id));
                    }
                }

                //$this->ajaxReturn(array('status'=>0,'info'=>'已点赞！','data'=>$chujia_id));
            }
            $zan = M('zan')->add($data);
            if ($zan){
                M('chujia')->where(array('id'=>$chujia_id))->save(array('zan'=>$chujia['zan']+1));
                $this->ajaxReturn(array('status'=>1,'info'=>'点赞成功！','data'=>$chujia_id));
            }
            $this->ajaxReturn(array('status'=>0,'info'=>'点赞失败！'));
        }
    }

    /**分类
     * screens
     */
    public function screens(){

        $cate = M('pm_cate')->where(array('level=2','isdel'=>0))->select();
        //$screens = M('series')->where(array("pid"=>0, "isdel"=>0))->select();
        $this->assign('screens',$cate);
    }
    /**
     * 预拍卖场次
     */
    public function paimaiY()
    {
        $start_time = I('get.start_time');
        $cate = I('get.cate');

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }


        //拍卖场次
        /*$num = M('pm_num')->where(array('is_xs'=>0,'is_del'=>0,'start_time'=>array('gt',time())))->order('start_time')->select();*/
        $num = M('pm_num')->where(array('is_del'=>0,'start_time'=>array('gt',time())))->order('start_time')->select();

        if (!$cate =='' && !$cate==null){
            $map['series_id'] = array('in',$cate);
        }

        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $map['is_shang']=1;
            $map['num_id']=$v['id'];
            //围观weiguan
            $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

            $num[$k]['wgcont'] = $wgcont[0]['wg'];
            $res = M('pm')->where($map)->order('start')->select();

            if ($res){
                //总出价次数
                $num[$k]['zcj']=0;
                foreach ($res as $kk=>$vv){
                    //出价数
                    $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                    //$res[$k]['chujia'] =$ccont;
                    $num[$k]['zcj'] +=$ccont;
                }

                $num[$k]['pm'] = $res[0];
            }else{
                unset($num[$k]);
            }
        }

        $count =count($num);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $num = $ArrayObj->page_array($num,0);//数组分页
        $this->assign('page',$page);
        $this->assign('cate',$cate);
        $this->assign('num',$num);
        $this->screens();

        $this->img();
        $this->display();
    }

    public function get_paimaiY()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $cate = I("post.cate");
            $res = M('pm_num')
                ->where(array('is_del'=>0,'start_time'=>array('gt',time())))
                //->where(array('is_xs'=>0,'is_del'=>0,'start_time'=>array('lt',time()),'end_time'=>array('gt',time())))
                ->order('start_time')
                ->select();
            if (!$cate =='' && !$cate==null){
                $map['series_id'] = array('in',$cate);
            }
            foreach ($res as $k=>$v){
                $map['is_del']=0;
                $map['is_shang']=1;
                $map['num_id']=$v['id'];
                //围观weiguan
                $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

                $res[$k]['wgcont'] = $wgcont[0]['wg'];
                $res1 = M('pm')->where($map)->order('start')->select();

                if ($res1){
                    //总出价次数
                    $res[$k]['zcj']=0;
                    foreach ($res1 as $kk=>$vv){
                        //出价数
                        $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                        //$res[$k]['chujia'] =$ccont;
                        $res[$k]['zcj'] +=$ccont;
                    }

                    $res[$k]['pm'] = $res1[0];
                }else{
                    unset($res[$k]);
                }
            }
            $data = array();
            $i=0;
            $j = ($p-1)*6;
            foreach($res as $k=>$v){
                if($i<$j+10 && $i>=$j){
                    $data[] = $v;
                }
                $i++;
            }
            if($data){
                $str = '';
                foreach($data as $k=>$v){

                    $str .= '<div class="left-store"><div class="store">';
                    $str .= '<a href="/Wxin/Pm/paimaiYNum?num_id='.$v['id'].'"> <img src="'.$v['backg_pic'].'" width="100%" /></a>';
                    $str .= '<div class="store-det"> <a href="/Wxin/Pm/paimaiYNum?num_id='.$v['id'].'">';
                    $str .= '<h3>'.$v['name'].'</h3></a><div class="sms icon tip"  >';
                    $str .= '<span style="display: none;" onclick="addRemind(this)" data-id="'.$v['id'].'">短信提醒</span></div>';
                    $str .= '<span class="time">'.date('Y年m月d日 H:i',$v['start_time']).' - '.date('Y年m月d日 H:i',$v['end_time']).'</span>';
                    $str .= '<br /><span class="cishu">出价次数：<b>'.($v['zcj']?$v['zcj']:0).'</b></span>';
                    $str .= '<span class="cishu">围观数：<b>'.($v['wgcont']?$v['wgcont']:0).'</b></span>';
                    $str .= '</div><div class="store-mai"><h2>'.date('d',$v['start_time']).'</h2><p>';
                    $m = $this->returnm(date('m',$v['start_time']));
                    $str .= $m;
                    $str .= '月</p></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    /**
     * 卖场次
     */
    public function paimaiS()
    {
        $start_time = I('get.start_time');
        $cate = I('get.cate');

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }

        //拍卖场次
        $num = M('pm_num')->where(array('is_xs'=>0,'is_del'=>0,'start_time'=>array('lt',time()),'end_time'=>array('gt',time())))->order('start_time')->select();

        if (!$cate =='' && !$cate==null){
            $map['series_id'] = array('in',$cate);
        }

        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $map['is_shang']=1;
            $map['num_id']=$v['id'];
            //围观weiguan
            $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

            $num[$k]['wgcont'] = $wgcont[0]['wg'];
            $res = M('pm')->where($map)->order('start')->select();

            if ($res){
                //总出价次数
                $num[$k]['zcj']=0;
                foreach ($res as $kk=>$vv){
                    //出价数
                    $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                    //$res[$k]['chujia'] =$ccont;
                    $num[$k]['zcj'] +=$ccont;
                }

                $num[$k]['pm'] = $res[0];
            }else{
                unset($num[$k]);
            }
        }

        $count =count($num);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $num = $ArrayObj->page_array($num,0);//数组分页
        $this->assign('page',$page);
        $this->assign('cate',$cate);
        $this->assign('num',$num);
        $this->screens();

        $this->img();
        $this->display();
    }


    public function get_paimaiS()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $cate = I("post.cate");
            $res = M('pm_num')
                ->where(array('is_xs'=>0,'is_del'=>0,'start_time'=>array('lt',time()),'end_time'=>array('gt',time())))
                ->order('start_time')
                ->select();
            if (!$cate =='' && !$cate==null){
                $map['series_id'] = array('in',$cate);
            }
            foreach ($res as $k=>$v){
                $map['is_del']=0;
                $map['is_shang']=1;
                $map['num_id']=$v['id'];
                //围观weiguan
                $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

                $res[$k]['wgcont'] = $wgcont[0]['wg'];
                $res1 = M('pm')->where($map)->order('start')->select();

                if ($res1){
                    //总出价次数
                    $res[$k]['zcj']=0;
                    foreach ($res1 as $kk=>$vv){
                        //出价数
                        $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                        //$res[$k]['chujia'] =$ccont;
                        $res[$k]['zcj'] +=$ccont;
                    }

                    $res[$k]['pm'] = $res1[0];
                }else{
                    unset($res[$k]);
                }
            }
            $data = array();
            $i=0;
            $j = ($p-1)*6;
            foreach($res as $k=>$v){
                if($i<$j+10 && $i>=$j){
                    $data[] = $v;
                }
                $i++;
            }
            if($data){
                $str = '';
                foreach($data as $k=>$v){

                    $str .= '<div class="left-store"><div class="store">';
                    $str .= '<a href="/Wxin/Pm/paimaiSNum?num_id='.$v['id'].'"> <img src="'.$v['backg_pic'].'" width="100%" /></a>';
                    $str .= '<div class="store-det"> <a href="/Wxin/Pm/paimaiSNum?num_id='.$v['id'].'">';
                    $str .= '<h3>'.$v['name'].'</h3></a><span class="action">';
                    $str .= '</span> <span class="time">'.date('Y年m月d日 H:i',$v['start_time']).' - '.date('Y年m月d日 H:i',$v['end_time']).'</span>';
                    $str .= '<br /><span class="cishu">出价次数：<b>'.($v['zcj']?$v['zcj']:0).'</b></span>';
                    $str .= '<span class="cishu">围观数：<b>'.($v['wgcont']?$v['wgcont']:0).'</b></span>';
                    $str .= '</div><div class="store-mai"><h2>'.date('d',$v['start_time']).'</h2><p>';
                    $m = $this->returnm(date('m',$v['start_time']));
                    $str .= $m;
                    $str .= '月</p></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }

    public function returnm($m)
    {
        switch($m){
            case '01':
                return '一';
                break;
            case '02':
                return '二';
                break;
            case '03':
                return '三';
                break;
            case '04':
                return '四';
                break;
            case '05':
                return '五';
                break;
            case '06':
                return '六';
                break;
            case '07':
                return '七';
                break;
            case '08':
                return '八';
                break;
            case '09':
                return '九';
                break;
            case '10':
                return '十';
                break;
            case '11':
                return '十一';
                break;
            case '12':
                return '十二';
                break;
        }
    }
    /**
     * 预拍卖场次内 倒计时
     */
    public function paimaiYNum()
    {
        $num_id = I('get.num_id');


        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }
        $map['is_del']=0;
        $map['is_shang']=1;
        $map['num_id']=$num_id;


        $num = M('pm_num')->where(array('id'=>$num_id))->find();
        //围观weiguan
        $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

        //拍卖件数
        $cont = M('pm')->where($map)->count();
        $num['cont'] = $cont;
        $num['wgcont'] = $wgcont[0]['wg'];
        $res = M('pm')->where($map)->order('start')->select();

        //总出价次数
        $num['zcj']=0;
        foreach ($res as $kk=>$vv){
            //出价数
            $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
            $res[$kk]['chujia'] =$ccont;
            $num['zcj'] +=$ccont;
        }

        $sponsor = M('pm')->where(array('num_id'=>$num_id))->limit(1)->find();
        $org = M('ruzhu')->where(array('id'=>$sponsor['promulgator']))->find();
        //dump($sponsor);exit;
        $this->assign('org',$org);
        $this->assign('num',$num);
        $this->assign('res',$res);
        //$this->paimai('start');

        $this->img();
        $this->display();
    }

    /**
     * 正在拍卖paimaiSNum
     */
    public function paimaiSNum()
    {

        $num_id = I('get.num_id');

        $num = M('pm_num')->where(array('id'=>$num_id))->find();

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        //拍卖场次
        //$num = M('pm_num')->where(array('is_xs'=>0,'is_del'=>0,'end_time'=>array('gt',time()),'start_time'=>array('lt',time())))->order('end_time')->find();
        $this->assign('djtime',$num['end_time']);

        $map['num_id']=$num['id'];

        $map['is_del']=0;
        $map['is_shang']=1;

        //进行中的拍卖
        $map['end']=array('gt',time());
        //拍卖件数
        $cont = M('pm')->where($map)->count();
        //围观weiguan
        $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();
        //dump($wgcont);die;
        $res = M('pm')->where($map)->order('end')->select();
        //总出价次数
        $zcj=0;
        foreach ($res as $k=>$v){
            //出价数
            $ccont = M('chujia')->where(array('goods_id'=>$v['id']))->count();
            $res[$k]['chujia'] =$ccont;
            $zcj +=$ccont;
        }

        $sponsor = M('pm')->where(array('num_id'=>$num_id))->limit(1)->find();
        $org = M('ruzhu')->where(array('id'=>$sponsor['promulgator']))->find();
        //dump($sponsor);exit;
        $this->assign('org',$org);
        //dump($res);

        $this->assign('now_time',time());
        $this->assign('wgcont',$wgcont);
        $this->assign('cjcont',$zcj);
        $this->assign('cont',$cont);
        $this->assign('res',$res);

        $this->assign('num',$num);

        $this->img();
        $this->display();
    }

    /**
     * 拍卖结果场次
     */
    public function result1()
    {
        $start_time = I('get.start_time');
        $cate = I('get.cate');

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }



        $data['page'] = I('get.page');
        $data['frist'] = I('get.frist');
        $data['prev'] = I('get.prev');
        $data['next'] = I('get.next');
        $data['last'] = I('get.last');

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }

        $count = M('pm_num')->where(array('is_del'=>0,'end_time'=>array('lt',time())))->count();
        //$Page  = getpage($count,10);
        //$show  = $Page->show();//分页显示输出->limit($Page->firstRow.','.$Page->listRows)
        $Page = PaGe($count,10,$data);
        //dump($page);

        if ($data['page']==''){
            $page=1;
        }else{
            $page=$data['page'];
        }

        $star = 10*($page-1);

        //拍卖场次
        $num = M('pm_num')->where(array('is_del'=>0,'end_time'=>array('lt',time())))->order('end_time ')->limit($star.',10')->select();

        if (!$cate =='' && !$cate==null){
            if (!is_string($cate)){
                $cate=implode(',',$cate);
            }

            $map['series_id'] = array('in',$cate);
        }

        $this->assign("page",$Page);
        $cate = explode(',',$cate);
        $this->assign('cate',$cate);

        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $map['is_shang']=1;
            $map['end']=array('lt',time());
            $map['num_id']=$v['id'];
            //围观weiguan
            $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

            $num[$k]['wgcont'] = $wgcont[0]['wg'];
            $res = M('pm')->where($map)->order('start')->select();

            if ($res){
                //总出价次数
                $num[$k]['zcj']=0;
                foreach ($res as $kk=>$vv){
                    //出价数
                    $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                    //$res[$k]['chujia'] =$ccont;
                    $num[$k]['zcj'] +=$ccont;
                }

                $num[$k]['pm'] = $res[0];
            }else{
                unset($num[$k]);
            }
        }

        //dump($num);

        $this->assign('num',$num);

        $this->screens();

        $this->img();
        $this->display();
    }
    /**
     * 拍卖结果场次
     */
    public function result()
    {
        $start_time = I('get.start_time');
        $cate = I('get.cate');

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }

        //拍卖场次
        $num = M('pm_num')->where(array('is_del'=>0,'end_time'=>array('lt',time())))->order('end_time ')->select();

        if (!$cate =='' && !$cate==null){
            $map['series_id'] = array('in',$cate);
        }
        $this->assign('cate',$cate);

        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $map['is_shang']=1;
            $map['end']=array('lt',time());
            $map['num_id']=$v['id'];
            //围观weiguan
            $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

            $num[$k]['wgcont'] = $wgcont[0]['wg'];
            $res = M('pm')->where($map)->order('start')->select();

            if ($res){
                //总出价次数
                $num[$k]['zcj']=0;
                foreach ($res as $kk=>$vv){
                    //出价数
                    $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                    $num[$k]['zcj'] +=$ccont;
                }
                $num[$k]['pm'] = $res[0];
            }else{
                unset($num[$k]);
            }
        }
        $count =count($num);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $num = $ArrayObj->page_array($num,0);//数组分页
        $this->assign('page',$page);
        $this->assign('num',$num);

        $this->screens();

        $this->img();
        $this->display();
    }

    public function get_result()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $cate = I("post.cate");
            $res = M('pm_num')
                ->where(array('is_del'=>0,'end_time'=>array('lt',time())))->order('end_time ')
                ->select();
            if (!$cate =='' && !$cate==null){
                $map['series_id'] = array('in',$cate);
            }
            foreach ($res as $k=>$v){
                $map['is_del']=0;
                $map['is_shang']=1;
                $map['num_id']=$v['id'];
                //围观weiguan
                $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

                $res[$k]['wgcont'] = $wgcont[0]['wg'];
                $res1 = M('pm')->where($map)->order('start')->select();

                if ($res1){
                    //总出价次数
                    $res[$k]['zcj']=0;
                    foreach ($res1 as $kk=>$vv){
                        //出价数
                        $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                        //$res[$k]['chujia'] =$ccont;
                        $res[$k]['zcj'] +=$ccont;
                    }

                    $res[$k]['pm'] = $res1[0];
                }else{
                    unset($res[$k]);
                }
            }
            $data = array();
            $i=0;
            $j = ($p-1)*6;
            foreach($res as $k=>$v){
                if($i<$j+10 && $i>=$j){
                    $data[] = $v;
                }
                $i++;
            }
            if($data){
                $str = '';
                foreach($data as $k=>$v){
                    $str .= '<div class="left-store">';
                    $str .= '<a href="Wxin/Pm/resultNum?num_id='.$v['id'].'">';
                    $str .= '<div class="store"> <img src="'.$v['backg_pic'].'"  style="width:100%;"/>';
                    $str .= '<div class="store-det">';
                    $str .= '<a href="javascript:;" class="names">'.$v['name'].' </a>';
                    $str .= '<br /><span class="action"> <em class="price">￥ '.$v['pm.dangqian'].' </em> </span>';
                    $str .= ' <br /><span class="time">'.date('Y年m月d日 H:i',$v['start_time']).' - '.date('Y年m月d日 H:i',$v['end_time']).'</span>';
                    $str .= '</div>';
                    $str .= '<div class="store-mai">';
                    $str .= ' <h2>'.date('d',$v['start_time']).'</h2><p>';
                    $m = $this->returnm(date('m',$v['start_time']));
                    $str .= $m;
                    $str .= '月</p></div></div></a></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    /**
     * 拍卖结果场次内
     */
    public function resultNum()
    {
        $num_id = I('get.num_id');


        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }


        $map['id_del']=0;
        //$map['is_shang']=1;
        $map['num_id']=$num_id;
        $num = M('pm_num')->where(array('id'=>$num_id))->find();
        $res = M('pm')->where($map)->order('end')->select();

        foreach ($res as $kk=>$vv){
            //出价数
            $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
            $res[$kk]['chujia'] =$ccont;
        }

        $this->assign('num',$num);
        $this->assign('res',$res);

        $this->img();
        $this->display();
    }


    /**
     * 限时拍卖场次
     */
    public function paimaiXS()
    {

        $cate = I('get.cate');

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        //拍卖场次
        $num = M('pm_num')->where(array('is_xs'=>1,'is_del'=>0,'end_time'=>array('gt',time())))->order('start_time')->select();
        //拍卖数量
        if (!$cate =='' && !$cate==null){
            $map['series_id'] = array('in',$cate);
        }

        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $map['is_shang']=1;
            $map['num_id']=$v['id'];
            //围观weiguan
            $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

            $num[$k]['wgcont'] = $wgcont[0]['wg'];
            $res = M('pm')->where($map)->order('start')->select();
            //dump($res);exit;
            if ($res){
                //总出价次数
                $num[$k]['zcj']=0;
                foreach ($res as $kk=>$vv){
                    //出价数
                    $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                    //$res[$k]['chujia'] =$ccont;
                    $num[$k]['zcj'] +=$ccont;
                }

                $num[$k]['pm'] = $res[0];
            }else{
                unset($num[$k]);
            }
        }
        //dump($num);exit;

        $count =count($num);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $num = $ArrayObj->page_array($num,0);//数组分页
        $this->assign('page',$page);
        $this->assign('cate',$cate);
        $this->assign('num',$num);
        $this->screens();

        $this->img();
        $this->display();
    }

    public function get_paimaiXS()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $cate = I("post.cate");
            $res = M('pm_num')
                ->where(array('is_xs'=>1,'is_del'=>0,'end_time'=>array('gt',time())))->order('start_time')
                ->select();
            if (!$cate =='' && !$cate==null){
                $map['series_id'] = array('in',$cate);
            }
            foreach ($res as $k=>$v){
                $map['is_del']=0;
                $map['is_shang']=1;
                $map['num_id']=$v['id'];
                //围观weiguan
                $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

                $res[$k]['wgcont'] = $wgcont[0]['wg'];
                $res1 = M('pm')->where($map)->order('start')->select();

                if ($res1){
                    //总出价次数
                    $res[$k]['zcj']=0;
                    foreach ($res1 as $kk=>$vv){
                        //出价数
                        $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                        //$res[$k]['chujia'] =$ccont;
                        $res[$k]['zcj'] +=$ccont;
                    }

                    $res[$k]['pm'] = $res1[0];
                }else{
                    unset($res[$k]);
                }
            }
            $data = array();
            $i=0;
            $j = ($p-1)*6;
            foreach($res as $k=>$v){
                if($i<$j+10 && $i>=$j){
                    $data[] = $v;
                }
                $i++;
            }
            if($data){
                $str = '';
                foreach($data as $k=>$v){

                    $str .= '<div class="left-store"><div class="store">';
                    $str .= '<a href="/Wxin/Pm/paimaiXSNum?num_id='.$v['id'].'"> <img src="'.$v['backg_pic'].'" width="100%" /></a>';
                    $str .= '<div class="store-det"> <a href="/Wxin/Pm/paimaiXSNum?num_id='.$v['id'].'">';
                    $str .= '<h3>'.$v['name'].'</h3></a><span class="action">';
                    $str .= '</span> <span class="time">'.date('Y年m月d日 H:i',$v['start_time']).' - '.date('Y年m月d日 H:i',$v['end_time']).'</span>';
                    $str .= '<br /><span class="cishu">出价次数：<b>'.($v['zcj']?$v['zcj']:0).'</b></span>';
                    $str .= '<span class="cishu">围观数：<b>'.($v['wgcont']?$v['wgcont']:0).'</b></span>';
                    $str .= '</div><div class="store-mai"><h2>'.date('d',$v['start_time']).'</h2><p>';
                    $m = $this->returnm(date('m',$v['start_time']));
                    $str .= $m;
                    $str .= '月</p></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    /**
     * 限时拍卖
     */
    public function paimaiXSNum()
    {
        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }
        $this->screens();
        $start_time = I('get.start_time');
        //dump($start_time);exit;
        if ($start_time==''||$start_time==null){
            $h = date('H',time());
            /*if ($h<=10){
                $start_time='10:00';
            }elseif (10<$h&&$h<=12){
                $start_time='12:00';
            }elseif (12<$h&&$h<=14){
                $start_time='14:00';
            }elseif (14<$h&&$h<=15){
                $start_time='15:00';
            }elseif (15<$h&&$h<=17){
                $start_time='17:00';
            }else{
                $start_time='19:00';
            }*/
            $start_time2 = strtotime(date('Y-m-d',time()).$start_time);
            $start_time3 = ($start_time2+3600);

        }
        //dump($start_time2);
        //dump($start_time3);exit;
        //$start = strtotime(date('Y-m-d',time()).$start_time);
        $start = strtotime(date('Y-m-d',time()));
      // $start2 = ($start+24*60*60);
        $start1 = strtotime(date('Y-m-d',time()+24*60*60).$start_time);
       // dump($start);exit;

        $start_time4 = strtotime(date('Y-m-d',time()));
       // $where['start'] = array('between',array($start,$start2));
       /* $where['start'] = array('elt',$start);
        $where['end'] = array('egt',$start);*/
        $start_time5 = $start_time4+24*60*60;
        $start_time6 = $start_time5+24*60*60;
        $where['start'] = array('between',array($start,$start_time5));
        $where1['start'] = array('between',array($start_time5,$start_time6));
        //dump($start_time5);exit;
        $this->assign('start_time',$start_time);

        $num_id = I('get.num_id');

        $num = M('pm_num')->where(array('id'=>$num_id))->find();
        //拍卖场次
        //$num = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1,'end_time'=>array('gt',time())))->order('start_time')->find();
        $this->assign('num',$num);
        $cate = I('get.cate');
         if (!$cate =='' && !$cate==null){
             $map['series_id'] = array('in',$cate);
         }

        $map['is_shang']=1;
        $map['num_id']=$num['id'];
        $map['is_del'] = 0;

        //当天.''
        //$time1 = strtotime(date('Y-m-d',time()).'23:59:59');
        //date('Y-m-d H:i:s',$time1);
        //dump(date('Y-m-d H:i:s',$time1));
        //$map['start'] = array('egt',$start);
        /*$map['start'] = array('eq',$start);
        if ($start_time=='14:00'){
            $map['end'] = array('eq',$start+1*60*60);
        }else{
            $map['end'] = array('eq',$start+2*60*60);
        }*/

        $res = M('pm')->where($where)->where($map)->select();
        $this->assign('res',$res);
        //dump($res);

        //第二天
        //$map['start'] = array('egt',$start1);
        /*$map['start'] = array('eq',$start1);
        if ($start_time=='14:00'){
            $map['end'] = array('eq',$start1+60*60*1);
        }else{
            $map['end'] = array('eq',$start1+60*60*2);
        }*/


        $res1 = M('pm')->where($where1)->where($map)->select();
        $this->assign('res1',$res1);

//dump($res1);exit;
        /*//拍卖场次
        $map['start_time'] = array('eq',$start);
        if ($start_time=='14:00'){
            $map['end_time'] = array('eq',$start+1*60*60);
        }else{
            $map['end_time'] = array('eq',$start+2*60*60);
        }*/
        //$num = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1))->where($map)->find();
        //$this->assign('num',$num);

        /*$cate = I('get.cate');
        if (!$cate =='' && !$cate==null){
            if (!is_string($cate)){
                $cate=implode(',',$cate);
            }

            $pmmap['series_id'] = array('in',$cate);
        }

        $pmmap['is_shang']=1;
        $pmmap['num_id']=$num['id'];*/

        //当天.''

        /*$res = M('pm')->where($pmmap)->select();
        $this->assign('res',$res);


        //第二天
        $map['start_time'] = array('eq',$start1);
        if ($start_time=='14:00'){
            $map['end_time'] = array('eq',$start1+1*60*60);
        }else{
            $map['end_time'] = array('eq',$start1+2*60*60);
        }
        $num1 = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1))->where($map)->find();
        //$this->assign('num',$num);

        $pmmap['num_id']=$num1['id'];
        $res1 = M('pm')->where($pmmap)->select();
        $this->assign('res1',$res1);*/
        $this->assign('cate',$cate);

        $this->img();
        $this->display();
    }

    /**
     * 拍卖结果
     */
    /*
    public function result()
    {

        $start_time = I('get.start_time');
        $cate = I('get.cate');
        $data['page'] = I('get.page');
        $data['frist'] = I('get.frist');
        $data['prev'] = I('get.prev');
        $data['next'] = I('get.next');
        $data['last'] = I('get.last');

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }

        if (!$cate =='' && !$cate==null){
            if (!is_string($cate)){
                $cate=implode(',',$cate);
            }

            $map['series_id'] = array('in',$cate);
        }

        //dump($wgcont);die;
        $map['is_del']=0;
        $map['is_shang']=1;
        $map['end']=array('lt',time());

        $count = M('pm')->where($map)->count();
        //$Page  = getpage($count,10);
        //$show  = $Page->show();//分页显示输出->limit($Page->firstRow.','.$Page->listRows)
        $Page = PaGe($count,10,$data);
        //dump($page);

        if ($data['page']==''){
            $page=1;
        }else{
            $page=$data['page'];
        }

        $star = 10*($page-1);
        //dump($star);
        $res = M('pm')->where($map)->limit($star.',10')->select();
        foreach ($res as $k=>$v){
            //出价数
            $ccont = M('chujia')->where(array('goods_id'=>$v['id']))->count();
            $res[$k]['chujia'] =$ccont;
        }

        $this->assign("page",$Page);
        $cate = explode(',',$cate);
        $this->assign('cate',$cate);
        $this->assign('res',$res);

    }*/


    /**
     * 拍卖详情
     */

    public function pmxq()
    {

        $user_id = $_SESSION['member_id'];
        $user_id = $user_id?$user_id:0;
        $this->assign('name',$user_id);

        //调生成订单
        $contab = new \Home\Controller\ContabController();
        $contab->order_pm();

        $goods_id = I('get.id');
        $mapm = array('id'=>$goods_id);
        $res = M('pm')->where($mapm)->find();
        $map['goods_id']=$goods_id;
        $image = M('pm_slide')->where($map)->where(array('status'=>1))->select();
        $baomin = M('order_pmding')->where($map)->where(array('order_status'=>array('gt',0)))->count();
        $res['baomin'] = $baomin;
        $cjcont = M('chujia')->where($map)->count();
        //提醒
        $tx = M('pmtel_remind')->where(array('goods_id'=>$goods_id))->count();
        $this->assign('tx',$tx);
        //围观
        $pm = M('pm')->where($mapm)->find();
        M('pm')->where($mapm)->save(array('weiguan'=>$pm['weiguan']+1));
        $info = M('chujia as a')
            ->join('left join app_member as b on a.user_id = b.id')
            ->where(array('a.goods_id'=>$goods_id))
            ->order('a.id desc')
            ->field('b.person_name,a.id,a.goods_id,a.user_id,a.jiage,a.time,a.zan')
            ->select();
        foreach ($info as $k=>$v){
            $map['chujia_id'] = $v['id'];
            $map['user_id'] = $user_id;
            $is_zan= M('zan')->where($map)->where(array('is_quxiao'=>0))->count();
            $info[$k]['is_zan'] = $is_zan?$is_zan:0;
        }
        if ($info){
            $res['dangqian'] = $info[0]['jiage'];
        }
        $this->assign('cjcont',$cjcont);
        $this->assign('res',$res);
        $this->assign('image',$image);
        $this->assign('chujia',$info);
        $this->service();

        if ($res['start']>time()){
            $this->display('pmxqY');
        }
        if ($res['start']<=time()){
            $mapd['user_id'] = $user_id;
            $mapd['goods_id'] = $res['id'];
            $mapd['order_status'] = array('gt',0);
            $baoding = M('order_pmding')->where($mapd)->find();
            if ($res['end']>time()){
                //正在拍卖
                if ($res['paimai_zt'] != 1){
                    M('pm')->where(array('id'=>$res['id']))->save(array('paimai_zt'=>1));
                }

                if ($baoding){
                    //交过保定金
                    $this->display('pmxqCJ');
                }else{
                    //未交保定金
                    $peizhi = M('ms_ruzhu')->where('id=1')->find();
                    $this->assign('peizhi',$peizhi);
                    $this->display('pmxqJB');
                }
            }else{
                if ($res['mai_id']==$user_id && $user_id!=0){
                    //成功拍下
                    $this->display('pmxqPX');
                }elseif ($res['mai_id']!=null){
                    //出局
                    $this->assign('is_chuju',$baoding?1:0);
                    $this->display('pmxqCJU');
                }else{
                    //流拍
                    $this->display('pmxqLP');
                }
            }
        }
    }

    /**
     * 交保定金
     */

    public function pmxq_bzj(){
        if (IS_AJAX){
            //保定金订单
            $data = I('post.');
            $data['dizhi']=$data['s_province'].'-'.$data['s_city'].'-'.$data['s_county'];
            $res = M('pm')->where(array('id'=>$data['goods_id']))->find();
            $data['user_id'] = $this->user_id;
            if ($data['user_id']==$res['member_id']){
                $this->ajaxReturn(array('status'=>0,'info'=>"自己的拍品不可参与竞拍！"));
            }
            $data['baoding'] = $res['baoding'];
            $data['logo_pic'] = $res['logo_pic'];
            $data['goods_name'] = $res['goods_name'];
            $data['order_time'] = time();
            $baoding = M('order_pmding')->add($data);
            if ($baoding){
				unset($_SESSION['bzjId']);
				$_SESSION['bzjId'] = $baoding;
                //订单生成成功
                $this->ajaxReturn(array('status'=>1,'info'=>array('err'=>"订单生成成功",'dingid'=>$baoding)));
            }else{
                //订单生成失败
                $this->ajaxReturn(array('status'=>0,'info'=>"订单生成失败"));
            }
        }
        $id = I('get.id');
        $this->assign('id',$id);
        $this->display();
    }

    /**
     * 支付保定金  完成 ZQJ
     */
    public function pmxq_bzjT(){
		if(IS_AJAX){
			//判断是否有保证金表的ID  order_pmding
			if(!$_SESSION['bzjId']){
				$this->ajaxReturn(array('info'=>'请重新提交！','status'=>0));die;
			}
			//todo 四种支付方式
			$post_data = I('post.');
			$type = $post_data['type'];
			$order_no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
			$user_id = $this->user_id;
			file_put_contents('order.log',$user_id.'|'.$order_no);
			$data['order_time'] = time();
			$data['order_no'] = $order_no;
			$data['pay_way'] = $type;
			if(!M('order_pmding')->where(array('id'=>$_SESSION['bzjId'],'user_id'=>$user_id))->save($data)){
				$this->ajaxReturn(array('info'=>'订单生成失败，请重新提交！','status'=>0));die;
			}
			switch ($type) {
				case 1: //支付宝
	                $this->ajaxReturn(array('info'=>'提交订单成功，请支付','url'=>"/Wxin/Pm/alipay/style/baoding/type/1/order_no/".$order_no,'status'=>1));
                    break;
				case 2:
                    $this->ajaxReturn(array("status" => 2,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpaypm/pay.php?order_no={$order_no}&type=1"));
                    break;
				case 3:
                    $url = $this->wx_pay($type=1,$order_no);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 3, "order_id" => $order_no, 'url' => $url));
                    break;
                case 4:
                    $this->balance($type=1,$order_no);
                    break;
				default:
				$this->ajaxReturn(array('info'=>"请选择支付方式",'status'=>0));
				
			}
			
		}
        $ding_id = I('get.dingid');
        $user_id = $this->user_id;
        $res = M('order_pmding')->where(array('id'=>$ding_id,'user_id'=>$user_id))->find();
        //dump($res);die;
        $this->assign('res',$res);
        $this->display();
    }


    public function balance($type,$order_no){
        $out_trade_no = $order_no;
        if($type==1){//支付保定金
            $order = M("order_pmding")->where(array('order_no' => $out_trade_no))->find();
            $total_amount = $order['baoding'];
            if ($order['order_status'] != 0) {
                $this->ajaxReturn(array('info'=>"订单无法支付",'status'=>0));
            }
            if (!$order) {
                $this->ajaxReturn(array('info'=>"无此订单",'status'=>0));
            }
            $member = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
            if($member['wallet']<$total_amount){
                $this->ajaxReturn(array('info'=>"余额不足",'status'=>0));die;
            }
            M()->startTrans();
            $res = M('member')->where(array('id'=>$_SESSION['member_id']))->save(array('wallet'=>($member['wallet']-$total_amount)));
            if(!$res){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }

            $data_w['user_id']=$_SESSION['member_id'];
            $data_w['type']=2;
            $data_w['posttime']=time();
            $data_w['order_id']=$order['id'];
            $data_w['cate']=0;
            $data_w['wallet']=$total_amount;
            $data_w['way_name']="支付拍品保定金";
            $res1 = M('money_water')->add($data_w);
            if(!$res1){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
            $b_data['pay_way'] = 1;
            $b_data['order_status'] = 1;
            $b_data['pay_price'] =  $total_amount;
            $b_data['pay_time'] = time();
            $res2 = M("order_pmding")->where(array('id' => $order['id']))->save($b_data);
            if(!$res2){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
            M()->commit();
            $this->ajaxReturn(array('info'=>"/Wxin/Pm/pmxq/id/".$order['goods_id'],'status'=>4));
        }elseif($type==2){//申请入驻拍卖 缴纳保证金
            $order = M("ruzhu")->where(array('pay_order' => $out_trade_no))->find();
            $total_amount = $order['price'];
            if ($order['pay_status'] != 0) {
                $this->ajaxReturn(array('info'=>"订单无法支付",'status'=>0));
            }
            if (!$order) {
                $this->ajaxReturn(array('info'=>"无此订单",'status'=>0));
            }
            $member = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
            if($member['wallet']<$total_amount){
                $this->ajaxReturn(array('info'=>"余额不足",'status'=>0));die;
            }

            M()->startTrans();
            $res = M('member')->where(array('id'=>$_SESSION['member_id']))->save(array('wallet'=>($member['wallet']-$total_amount)));
            if(!$res){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }

            $data_w['user_id']=$_SESSION['member_id'];
            $data_w['type']=2;
            $data_w['posttime']=time();
            $data_w['order_id']=$order['id'];
            $data_w['cate']=0;
            $data_w['wallet']=$total_amount;
            $data_w['way_name']="申请入驻拍卖 缴纳保证金";
            $res1 = M('money_water')->add($data_w);
            if(!$res1){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
            $r_data['pay_type'] = 1;
            $r_data['pay_status'] = 1;
            $r_data['pay_endtime'] = time();
            $res2 = M("ruzhu")->where(array('id' => $order['id']))->save($r_data);
          if(!$res2){
              M()->rollback();
              $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
          }
          M()->commit();
            $this->ajaxReturn(array('info'=>"/Wxin/PersonalCenter/buyerAddPm/tag/buyerAddPm",'status'=>4));
        }elseif($type==3){//拍品支付
            $order = M("order_pm")->where(array('order_no' => $out_trade_no))->find();
            $total_amount = $order['total_fee'];
            if ($order['pay_status'] != 0) {
                $this->ajaxReturn(array('info'=>"订单无法支付",'status'=>0));
            }
            if ($order['order_status'] != 1) {
                $this->ajaxReturn(array('info'=>"订单无法支付",'status'=>0));
            }
            if (!$order) {
                $this->ajaxReturn(array('info'=>"无此订单",'status'=>0));
            }

            $member = M('member')->where(array('id'=>$_SESSION['member_id']))->find();
            if($member['wallet']<$total_amount){
                $this->ajaxReturn(array('info'=>"余额不足",'status'=>0));die;
            }

            M()->startTrans();
            $res = M('member')->where(array('id'=>$_SESSION['member_id']))->save(array('wallet'=>($member['wallet']-$total_amount)));
            if(!$res){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }

            $data_w['user_id']=$_SESSION['member_id'];
            $data_w['type']=2;
            $data_w['posttime']=time();
            $data_w['order_id']=$order['id'];
            $data_w['cate']=0;
            $data_w['wallet']=$total_amount;
            $data_w['way_name']="拍品支付";
            $res1 = M('money_water')->add($data_w);
            if(!$res1){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
            $b_data['pay_way'] = 1;
            $b_data['order_status'] = 2;
            $b_data['pay_status'] = 1;
            $b_data['pay_price'] =  $total_amount;
            $b_data['pay_time'] = time();
            $res2 = M("order_pm")->where(array('id' => $order['id']))->save($b_data);
            if(!$res2){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
            $pm = M('pm')->where(array('id'=>$order['goods_id']))->find();
            $s_data['user_id'] = $pm['promulgator'];
            $s_data['price'] = $order['goods_price'];
            $s_data['yongjin_price'] = $order['goods_price']*$pm['yongjin']/100;
            $s_data['huode_price'] = $order['goods_price']-$s_data['yongjin_price'];
            $s_data['addtime'] = time();
            $s_data['is_settl'] = 0;
            $s_data['order_id'] = $order['id'];
            $s_data['goods_id'] = $pm['id'];
            $res3 = M('settl')->add($s_data);
            if(!$res3){
                M()->rollback();
                $this->ajaxReturn(array('info'=>"支付失败",'status'=>0));
            }
            M()->commit();
            $this->ajaxReturn(array('info'=>"/Wxin/PersonalCenter/myOrder/tag/myOrder",'status'=>4));
        }else{
            $this->ajaxReturn(array('info'=>"非法操作",'status'=>0));
        }
    }
    /**
     * 申请入驻拍卖 签署协议
     */

    public function paiCenter(){
        if (IS_AJAX){
            $xy = I('get.xy');
            $data['xieyi'] = $xy;
            $data['user_id'] = $this->user_id;
            $data['ruzhu_status']=0;
            $res = M('ruzhu')->where(array('user_id'=>$data['user_id']))->find();
            if ($res){
                if ($res['xieyi']==1&&$res['ruzhu_status']==0&&$data['xieyi']==0){
                    M('ruzhu')->where(array('user_id'=>$data['user_id']))->save($data);
                    $this->ajaxReturn(array('status'=>1, "info"=>'协议签署失败！'));
                }

                if ($res['xieyi']==1&&$res['ruzhu_status']==0){
                    $this->ajaxReturn(array('status'=>1, "info"=>'协议签署成功！'));
                }
                $res1 = M('ruzhu')->where(array('user_id'=>$data['user_id']))->save($data);
                if ($res1){
                    if ($data['xieyi']==0){
                        $this->ajaxReturn(array('status'=>1, "info"=>'协议签署失败！'));
                    }
                    $this->ajaxReturn(array('status'=>1, "info"=>'协议签署成功！'));
                }
                $this->ajaxReturn(array('status'=>0, "info"=>'协议签署失败！'));
            }
            $res2 = M('ruzhu')->add($data);
            if ($res2){
                if ($data['xieyi']==0){
                    $this->ajaxReturn(array('status'=>1, "info"=>'协议签署失败！'));
                }
                $this->ajaxReturn(array('status'=>1, "info"=>'协议签署成功！'));
            }
            $this->ajaxReturn(array('status'=>0, "info"=>'协议签署失败！'));
        }
        $content = M('protocol')->where(array('id'=>1))->getField('content');
        $this->assign('content',$content);
        $this->display();

    }

    /**申请入驻拍卖 选择类目
     * paiLeimu
     */

    public function paiLeimu(){
        if (IS_AJAX){
            $user_id = $this->user_id;
            $data = I('post.');
            $data['pids'] = rtrim($data['pids'],',');
            $series_ids = rtrim($data['ids'],',');
            $data['series_ids'] = $series_ids;
            $data['ruzhu_status']=1;
            $rz = M('ruzhu')->where(array('user_id'=>$user_id))->find();
            if ($rz['series_ids']==$data['series_ids']&&$rz['ruzhu_status']==1&&$rz['price']==$data['price']){
                $this->ajaxReturn(array('status'=>1, "info"=>'类型选择成功！'));
            }
            $res = M('ruzhu')->where(array('user_id'=>$user_id))->save($data);
            if ($res){
                $this->ajaxReturn(array('status'=>1, "info"=>'选择类目成功！'));
            }
            $this->ajaxReturn(array('status'=>0, "info"=>'选择类目失败！'));
        }
    }


    /**
     *  判断字符串是否是身份证号
     *  author:xiaochuan
     *  @param string $idcard    身份证号码
     */
    function isIdCard(){

        $idcard = I('post.f_card');
        #  转化为大写，如出现x
        $idcard = strtoupper($idcard);
        #  加权因子
        $wi = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        $ai = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        #  按顺序循环处理前17位
        $sigma = 0;
        #  提取前17位的其中一位，并将变量类型转为实数
        for ($i = 0; $i < 17; $i++) {
            $b = (int)$idcard{$i};
            #  提取相应的加权因子
            $w = $wi[$i];
            #  把从身份证号码中提取的一位数字和加权因子相乘，并累加
            $sigma += $b * $w;
        }
        #  计算序号
        $sidcard = $sigma % 11;
        #  按照序号从校验码串中提取相应的字符。
        $check_idcard = $ai[$sidcard];
        if ($idcard{17} == $check_idcard) {
            $this->ajaxReturn(array('status'=>1));
            //return '是正确的身份证';
        } else {
            $this->ajaxReturn(array('status'=>0, "info"=>'请输入正规身份证号！'));
        }
    }

    /**申请入驻拍卖 提交资料
     *ZQJ
     */

    public function paiZiliao(){
        if (IS_AJAX){
            $user_id = $this->user_id;
            $data = I('post.');
            $data['zhuce_time'] = strtotime($data['zhuce_time']);
            $data['youxiao_time'] = strtotime($data['youxiao_time']);
            $data['zhuz_time'] = strtotime($data['zhuz_time']);
            $data['ruzhu_status']=2;
            $res = M('ruzhu')->where(array('user_id'=>$user_id))->save($data);
            if ($res){
                $this->ajaxReturn(array('status'=>1, "info"=>'资料添加成功！'));
            }

            $this->ajaxReturn(array('status'=>0, "info"=>'资料添加失败！'));
        }
    }


    /**申请入驻拍卖 缴纳保证金
     *
     */

    public function paiBaozj(){
			if(IS_AJAX){
			//todo 四种支付方式
			$post_data = I('post.');
			$type = $post_data['type'];
			$order_no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
			$user_id = $this->user_id;
			file_put_contents('order.log',$user_id.'|'.$order_no);
			
			$data['pay_time'] = time();
			$data['pay_order'] = $order_no;
			$data['pay_type'] = $type;
			if(!M('ruzhu')->where(array('user_id'=>$user_id))->save($data)){
				$this->ajaxReturn(array('info'=>'订单生成失败，请重新提交！','status'=>0));die;
			}
			switch ($type) {
				case 1: //支付宝
	                $this->ajaxReturn(array('info'=>'提交订单成功，请支付','url'=>"/Wxin/Pm/alipay/style/ruzhu/type/1/order_no/".$order_no,'status'=>1));
                    break;
				case 2:
                    $this->ajaxReturn(array("status" => 2,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpaypm/pay.php?order_no={$order_no}&type=2"));
                    break;
				case 3:
                    $url = $this->wx_pay($type=2,$order_no);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 3, "order_id" => $order_no, 'url' => $url));
                    break;
                case 4:
                    $this->balance($type=2,$order_no);
                    break;
				default:
				$this->ajaxReturn(array('info'=>"请选择支付方式",'status'=>0));
			}
			
		}
        $user_id = $this->user_id;
        $res = M('ruzhu')->where(array('user_id'=>$user_id))->find();
        if ($res['shenhe']!=2){
            $this->error("审核未通过！",U('Wxin/Pm/paimaiS'));
            die;
        }
        $this->assign('res',$res);
        $this->display();
    }
	/**付款金
     *
     */

    public function buy(){
			if(IS_AJAX){
			//todo 四种支付方式
			$post_data = I('post.');
			$type = $post_data['type'];
			$user_id = $this->user_id;
			$order_no = $post_data['order_no'];
			$m = M('order_pm')->where(array('user_id'=>$user_id,'order_no'=>$order_no))->getField('pay_way',$type);
			file_put_contents('order.log',$user_id.'|'.$order_no);
			switch ($type) {
				case 1: //支付宝
                    $this->ajaxReturn(array("status" => 1,'order_no' => $order_no, "url" =>"/Wxin/Pm/alipay/style/pm/type/1/order_no/".$order_no));
                    break;
				case 2:
                    $this->ajaxReturn(array("status" => 2,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpaypm/pay.php?order_no={$order_no}&type=3"));
                    break;
				case 3:
                    $url = $this->wx_pay($type=3,$order_no);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 3, "order_id" => $order_no, 'url' => $url));
                    break;
                case 4:
                    $this->balance($type=3,$order_no);
                    break;
				default:
				$this->ajaxReturn(array('info'=>"请选择支付方式",'status'=>0));
			}
		}
		$id = I('get.id');
        $user_id = $this->user_id;
        $res = M('order_pm')->where(array('user_id'=>$user_id,'id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /**
     *微信支付
     */
    public function wx_pay($type,$order_no)
    {
        if($type==1){
            $info = M("order_pmding")->where(array('order_no' => $order_no,'pay_status'=>0))->find();
            if (!$info) {
                return false;
            }
            $total_fee = $info['baoding'];
            $or_g = M('pm');
            $o_g_r = $or_g->where(array('id' => $info['goods_id']))->find();
        }elseif($type==2){
            $info = M("ruzhu")->where(array('pay_order' => $order_no,'pay_status'=>0))->find();
            if (!$info) {
                return false;
            }
            $info['order_no'] = $info['pay_order'];
            $total_fee = $info['price'];
            $o_g_r['goods_name'] = "入驻拍卖";
        }elseif($type==3){
            $info = M("order_pm")->where(array('order_no' => $order_no,'order_status'=>1))->find();
            if (!$info) {
                return false;
            }
            $total_fee = $info['total_fee'];
            $or_g = M('pm');
            $o_g_r = $or_g->where(array('id' => $info['goods_id']))->find();
        }elseif($type==4){
            $info = M("order_info")->where(array('order_no' => $order_no,'order_status'=>1))->find();
            if (!$info) {
                return false;
            }
            $total_fee = $info['total_fee'];
            $or_g = M('order_goods');
            $o_g_r = $or_g->where(array('order_id' => $info['id']))->find();
        }else{
            return false;
        }
        $info['order_no'] = $type.$info['order_no'];
        //===========测试数据=============
        $money = $total_fee * 100;
        //===========测试数据=============
        Vendor('WxPayPubHelper.WxPayApi');
        Vendor('WxPayPubHelper.WxPayNativePay');
        Vendor('WxPayPubHelper.log');
        $notify = new \WxPayNativePay();
        $input = new \WxPayUnifiedOrder();

        $input->SetBody("浙江美术网");
        $input->SetAttach($info['order_no']);
        $input->SetOut_trade_no($info['order_no']);
        $input->SetTotal_fee($money);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($o_g_r['goods_name']);
        $input->SetNotify_url("http://" . $_SERVER['HTTP_HOST'] . "/Home/Pay/weixin_pmpay");
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($info['order_no']);
        $result = $notify->GetPayUrl($input);
        if ($result['error'] != "") {
            return $result;
        }
        $url = $result["code_url"];
        return $url;
    }


    /**
     *微信支付  查询订单是否支付成功
     */
    public function order_status()
    {
        if (IS_POST) {
            $id = I('post.order_id');
            $type = I('post.type');
            if($type==1){
                $order = M('order_pmding');
                $res = $order->where(array('order_no' => $id))->find();
                if ($res['pay_status'] != 0) {
                    $url = '/Wxin/Pm/pmxq/id/'.$res['goods_id'];
                    $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
                }
            }elseif($type==2){
                $order = M('ruzhu');
                $res = $order->where(array('pay_order' => $id))->find();
                if ($res['pay_status'] != 0) {
                    $url = U('/Wxin/PersonalCenter/buyerAddPm/tag/buyerAddPm');
                    $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
                }
            }elseif($type==3){
                $order = M('order_pm');
                $res = $order->where(array('order_no' => $id))->find();
                if ($res['pay_status'] != 0) {
                    $url = U('/Wxin/PersonalCenter/buyerXia/tag/buyerXia');
                    $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
                }
            }else{
                $order = M('order_info');
                $res = $order->where(array('order_no' => $id))->find();
                if ($res['pay_status'] != 0) {
                    $url = U('/Wxin/PersonalCenter/myOrder/tag/myOrder');
                    $this->ajaxReturn(array("status" => 1, 'info' => "", 'url' => $url));
                }
            }
        }
    }
    /**
     * 支付订单 zj
     */
    public function PayOrder(){
        if(IS_AJAX){
            $saveData = I("post.");
            $order_no = $saveData['order_no'];
            $userId = $_SESSION['member_id'];
            if(!$userId){
                $this->ajaxReturn(array('status' => 0, 'info' => '请登录'));
            }
            $order = M("orderInfo")->where(array('user_id'=>$userId,'order_no'=>$order_no,'order_status'=>1))->find();
            if(!$order){
                $this->ajaxReturn(array('status' => 0, 'info' => '订单无法支付'));
            }
            $saveData['update_time'] = time();
            $res = M("orderInfo")->where(array('user_id'=>$userId,'order_no'=>$order_no,'order_status'=>1))->save($saveData);
            if(!$res){
                $this->ajaxReturn(array('status' => 0, 'info' => '操作失败'));
            }
            $pay_way = $saveData['pay_way'];
            switch ($pay_way) {
                case "1";
                    $this->ajaxReturn(array("status" => 1,'order_no' => $order_no, "url" => U('Pay/alipay', array("order_no" =>$order_no))));
                    break;
                case "2";
                    $url = $this->wx_pay(4,$order['order_no']);
                    if (!is_string($url)) {
                        $this->ajaxReturn(array("status" => 0, 'order_id' => 0, "info" => "请求超时,请重新下单!"));
                    }
                    $url = IMG_URL.'example/qrcode.php?data=' . $url;
                    $this->ajaxReturn(array("status" => 2, "order_id" => $order['id'], 'url' => $url));
                    break;
                case "3";
                    $this->ajaxReturn(array("status" => 3,"url" => "http://" . $_SERVER['HTTP_HOST'] . "/unionpay/pay.php?order_id={$order[id]}"));
                    break;
                default:
                    $this->ajaxReturn(array("status" => 0, 'info' => "无效的支付方式！"));
                    break;
            }
        }
    }

    /**申请入驻拍卖 支付
     * paiLeimu
     */

    public function paiSuccess(){
        $this->display();
    }

    /**
     * 入驻金额
     */
    public function msRuzhu(){
        $ms_ruzhu = M('ms_ruzhu')->where('id=1')->find();
        $this->assign('ms_ruzhu',$ms_ruzhu);
    }


    //是否入驻

    function isRuZhu(){
        if (IS_AJAX){
            //dump($_POST);die;
            $user_id = $this->user_id;
            $res = M('ruzhu')->where(array('user_id'=>$user_id,'pay_status'=>1))->find();
            //dump($res);die;
            if ($res){

                $this->ajaxReturn(array('status'=>1, "info"=>'已成功入驻过！'));
                //$this->success('资料添加成功',U('Home/Pm/paiShenhe'));
                //die;
            }

            $this->ajaxReturn(array('status'=>0, "info"=>'未成功入驻！'));
        }
    }

    /**
     * 入驻整合
     */

    public function paimaiRuzhu(){
        $user_id = $this->user_id;
        $tui = I('get.tui');
        if (!$user_id==''||!$user_id==null){

            $res = M('ruzhu')->where(array('user_id'=>$user_id))->find();
            if ($res){

                if ($res['pay_status']==1){
                    $iUrl = U("Wxin/Pm/paimaiS");
                    echo "<script>alert('已成功入驻过！');window.location.href='".$iUrl."';</script>";
                }
                if (($tui!=='' && $tui==0)||$res['xieyi']==0){
                    //待 签署协议
                    $content = M('protocol')->where(array('id'=>1))->getField('content');
                    //print_r($content);exit;
                    $this->assign('content',$content);

                    $this->display('paiCenter');
                }elseif($res['ruzhu_status']==0 ||$tui==1){
                    //待 选取类目
                    $this->msRuzhu();
                    $cate = M('pm_cate')->where(array('level=1','isdel'=>0))->select();
                    foreach ($cate as $k=>$v){
                        $cate_two = M('pm_cate')->where(array('pid'=>$v['id'],'isdel'=>0))->select();
                        if($cate_two){
                            $cate[$k]['data']=$cate_two;
                        }else{
                            unset($cate[$k]);
                        }
                    }


                    $catexz = explode(',',$res['series_ids']);
                    $pids = explode(',',$res['pids']);
                    if(!is_array($catexz)){
                        $catexz[0] = $res['series_ids'];
                    }
                    if(!is_array($pids)){
                        $pids[0] = $res['pids'];
                    }

                    //dump($catexz);
                    $this->assign('pids',$pids);
                    $this->assign('catexz',$catexz);
                    $this->assign('cate',$cate);
                    $this->assign('res',$res);
                    $this->display('paiLeimu');
                }elseif ($res['ruzhu_status']==1 || $tui==2){
                    //待 提交资料
                    $ms_ruzhu = M('ms_ruzhu')->where('id=1')->find();
                    $this->assign('moban',$ms_ruzhu['moban']);

                    $this->assign('res',$res);
                    $this->display('paiZiliao');
                }elseif ($res['ruzhu_status']==2){
                    //待 审核
                    $member = M('member')->where(array('id'=>$user_id))->find();
                    $res['user_name']=$member['realname'];
                    $this->assign('res',$res);
                    $this->display('paiShenhe');
                }
            }else{
                //待 签署协议
                $content = M('protocol')->where(array('id'=>1))->getField('content');
                //print_r($content);exit;
                $this->assign('content',$content);
                $this->display('paiCenter');
            }
        }else{
            $iUrl = U("/Wxin/User/login");
            echo "<script>alert('请登录！');window.location.href='".$iUrl."';</script>";
            //echo "<script>alert('已成功入驻过！');window.location.href='/Home/User/login';</script>";
            $this->display();
            /*$this->error('请登录！',U('/Home/User/login'));*/
        }


    }
	
	/** 20170713 wzz
     *电脑支付配置
     **/
    protected  function alipay_config($style = '')
    {
		if($style == 'baoding'){
            //"http://" . $_SERVER['HTTP_HOST'] . "/unionpaypm/pay.php?order_no={$order_no}&type=1"));
			$returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pm/ReturnBURL";
			$notufyUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Home/Pm/NotifyBURl";
		}else if($style == 'ruzhu'){
			$returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pm/ReturnRURL";
			$notufyUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Home/Pm/NotifyRURl";
		}else if($style == 'pm'){
			$returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Pm/ReturnPURL";
			$notufyUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Home/Pm/NotifyPURl";
		}else if($style == 'libao'){
            $returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Wxin/Index/ReturnLURL";
            $notufyUrl = "http://" . $_SERVER['HTTP_HOST'] . "/Home/Index/NotifyLURl";
        }
        $alipay_config = array(
            //APPID 即创建应用后生成       更新5-1
            'app_id' => "2015122301028610",
            //同步跳转地址，公网可以访问   更新5-2
            //'return_url' => "http://msw.unohacha.com/Home/CrowedPay/ReturnURL",
			'return_url' => $returnUrl,
            //异步通知地址，公网可以访问   更新5-3
            //'notify_url' => "http://msw.unohacha.com/Home/CrowedPay/NotifyURL",
			'notify_url' => $notufyUrl ,
            //开发者私钥，由开发者自己生成 更新5-4 https://openhome.alipay.com/platform/keyManage.htm
            'merchant_private_key' => "MIIEpAIBAAKCAQEA3gocNFZmdhg1K3QcgTeKoPadg87+d+n/XWo7rqYxQG06w/4pGCUfV7xRTElTA1R0neWYWAMT7TUNZ4sYFEN9ioUGoin22pbinjXGGAwN5ShqyTNeBeJYK67UsMM06mjrOD5FYrf7GMOjkkD8GBqIAm7f23Th6j36GkFMm4Z9AA0ixPQTCAiWVhXEMG20/SamnYsgd1mvDP3y0LBQlCDZ1/Hczl1QxPfZd4rY/gGhYUGe87vvXmU1PUG4KIBM00vwStUml/JQcr90/7KziB1Akio5vzwkbWzbY474IFFBIb9D62yIWqjg0hdFLnIFtnwZMEhciR3w60+5BK9PVVY4uwIDAQABAoIBADcEjE6Pph3XC72zrKh8CbauxQL3FGjEK4mLHDS/a27KYghUfvxDnouP1xkvBgnKMIc7b89HG/Xn8mVYuuOygXYEVktyWH97abXIH0iwG/VPWX53YvHUTwKr9HnENOVsj/REwc6fRfGx8GL6BT03vcHUlVV8lcoEB2fgDEpxPaH4KO2QysWNr7qaN8vAj+vM8eqqpL6/n9iTLQ+bTu5m2y5Decih4WrCj+D4GvAxha4Ts0dCO4mDQrtTFP9EhQcdmenUrly+gP9tuhxZN7/9TQYRcok6nsjwen9YXOEvHYTU5jsKTcA2nejjEqaAdaTYqsb8Y6HjYj8eejkv2G7fpxECgYEA/MPfOdng8Y0QU1k3Nje6rLZcmVQQSh2ybWnxJwOhb1r4pGvBm0a2SeFuIi3b7b7xhhG5WIik+s0vRgnTkyLqcqMLMuYDHQvR6BDwaritPpLwH5rQv6r5VjB/loZRy8ZK7ZQKYYisnOTE/lPR9v/6MU5gRhPTODMIin+7Hxaw7TkCgYEA4OGSlLGbonKRyTePWWNGJVMc0V3ksmoJhVNx9H1pBWuDCG2Fx5y+uJjnGbcG8nZCxUS8ODhojtTvtiNhUaoo4UfGCg7mXGgZTeeo4t+ojg8UIbLVbO66yOksisUVF48nzK/AOMidkOGn6rudXARtMnhIHYw+qNpRaFE+wrefCZMCgYEAh2XdE740ku//iMZHnxFnO9FL9Q5k027o/1c6yK1XMrFGc70NLsJIL3dEaaarIsWf1zNzV4uK5JY49omY/j473ECeZRt1G4ATZv576o8WrmhDnIpvu9w4SAUes2EsO73ysSUWEn0GCd058QqxdGBWg0b6p09DW91qe9ZERDkBeXECgYB2vgU1KJcibtaV5hV2QJowaTNlRevVXXJLiSU50OKcbwmQcKxcG2MFfA9DH8a2TkWxfjrYgMiM6tjsVsAza+MMGWbztqxijMEXxsQBj9GjuUiLBq/1RhUwsxbG64vYlcmRJhgco6m3b7/HjWtoxBmYtbR2jbAkXqrvpz65eFWsqwKBgQCFr8ARaCgXYb0ih7nsriNMj4zTMNfN5wR8cNhYe4khuKtwnw2YhngKQJQwH3mdK7CrINC59bjZXiCo7UC6aAvY8Qu8/cnlXytFmHmr1NKkPXsmYKMlTVQ09nlv5n7EDaha7LwSvi5XUJs70l+W/iJgXY4CQcGaUjKoJTH28X+Qxg==",
            //支付宝公钥，由支付宝生成 更新5-5 https://openhome.alipay.com/platform/keyManage.htm
            'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmPjlstEsSTWqspVb9pJa+vxqvNm1T6R1VNEzFEsQ6IOj2eAD9keP6EoZNklfLDJpXPFHu4jb/31nW/F76Joao8cEERqbb9ehNzOQcc/l7wRCgvKdG8IaUTpuqbvshF5uBrUhJu5A7nVCBeVMny4cc6kmxQlgMF2m05iKQPmznXnmrVwQuP0SbYuNKFeHmAY96t1YMjufpbiKpmsfIkDNGROGAx5wUwzWnE/WW+6Rm2ntlhrMuXYlwaOL9KJoQSeyETj0G3sWuTxEjIAw+yLeJF2sdZ1XTApMpLQ+EPP5HX+o0XJMxeAiS4zXSOPxuYYHFHq3EoNVM5wNYvMG1T7WlQIDAQAB",
            //编码格式
            'charset' => "UTF-8",
            //签名方式
            'sign_type' => "RSA2",
            //支付宝网关
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        );
        return $alipay_config;
    }
	/*
	*保定金同步 ZQJ
	*/
	public function ReturnBURL(){
		$arr = $_GET;
        log_result("./ReturnURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $result = $alipaySevice->check($arr);
		if ($result) {
            //验证成功
            ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
            $total_amount = htmlspecialchars($_GET['total_amount']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            //验证订单
            $m = M("order_pmding");
            $order = $m->where(array("order_no" => $out_trade_no))->find();

            if ($order) {
                $this->redirect('/Wxin/Pm/pmxq/id/'. $order['goods_id']);
            } else {
                $this->order_error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->order_error("订单支付失败！");
        }
		
	}
	/*
	*保定金异步 ZQJ
	*/
	public function NotifyBURl(){
		$arr = $_POST;
        log_result("./NotifyURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);
		if ($result) {
            //验证成功
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //订单的资金总额
            $total_amount = $_POST['total_amount'];
            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
                $m = M("order_pmding");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
				$total_fee = $order['price'];
               if($order['pay_status'] == 0){
				   $b_data['pay_way'] = 1;
				   $b_data['order_status'] = 1;
				   $b_data['pay_price'] =  $total_amount;
				   $b_data['pay_time'] = time();
				   
				   $m->where(array('id' => $order['id']))->save($b_data);
			    }

                //2.记录流水账
                $data_w['user_id']=$order['user_id'];
                $data_w['type']=2;
                $data_w['posttime']=time();
                $data_w['order_id']=$order['id'];
                $data_w['cate']=0;
                $data_w['expend']=$total_amount;
                $data_w['way_name']="支付拍品保证金";
                $res1 = M('money_water')->add($data_w);
            }
                ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
            
            echo "success";    //请不要修改或删除

        } else {
            //验证失败
            echo "fail";
        }
	}
	
	/*
	*pm同步 ZQJ
	*/
	public function ReturnPURL(){
		$arr = $_GET;
        log_result("./ReturnURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $result = $alipaySevice->check($arr);
		if ($result) {
            //验证成功
            ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
            $total_amount = htmlspecialchars($_GET['total_amount']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            //验证订单
            $m = M("order_pm");
            $order = $m->where(array("order_no" => $out_trade_no))->find();

            if ($order) {
                $this->redirect('/Wxin/PersonalCenter/buyerXia/tag/buyerXia');
            } else {
                $this->order_error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->order_error("订单支付失败！");
        }
		
	}
	/*
	*pm异步 ZQJ
	*/
	public function NotifyPURl(){
		$arr = $_POST;
        log_result("./NotifyURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);
		if ($result) {
            //验证成功
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //订单的资金总额
            $total_amount = $_POST['total_amount'];
            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
                $m = M("order_pm");
                $order = $m->where(array("order_no" => $out_trade_no))->find();
				$total_fee = $order['price'];
               if($order['pay_status'] == 0){
				   $b_data['pay_way'] = 1;
				   $b_data['order_status'] = 2;
				   $b_data['pay_status'] = 1;
				   $b_data['pay_price'] =  $total_amount;
				   $b_data['pay_time'] = time();
				   
				   $m->where(array('id' => $order['id']))->save($b_data);

				   $res = M('pm')->where(array('id'=>$order['goods_id']))->find();
				   /*if($res['promulgator']!=0){*/
				       $s_data['user_id'] = $res['promulgator'];
                       $s_data['price'] = $order['goods_price'];
                       $s_data['yongjin_price'] = $order['goods_price']*$res['yongjin']/100;
                       $s_data['huode_price'] = $order['goods_price']-$s_data['yongjin_price'];
                       $s_data['addtime'] = time();
                       $s_data['is_settl'] = 0;
                       $s_data['order_id'] = $order['id'];
                       $s_data['goods_id'] = $res['id'];
                       M('settl')->add($s_data);
                  /* }*/
			    }

                $data_w['user_id']=$order['user_id'];
                $data_w['type']=2;
                $data_w['posttime']=time();
                $data_w['order_id']=$order['id'];
                $data_w['cate']=0;
                $data_w['expend']=$total_amount;
                $data_w['way_name']="拍品支付";
                $res1 = M('money_water')->add($data_w);
                  
            }
                //2.记录流水账


                ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
            
            echo "success";    //请不要修改或删除

        } else {
            //验证失败
            echo "fail";
        }
	}
	
	
	
	
	
	
	/*
	*入驻金同步 ZQJ
	*/
	public function ReturnRURL(){
		
		$arr = $_GET;
        log_result("./ReturnURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $result = $alipaySevice->check($arr);
		 if ($result) {
            //验证成功
            ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
            //该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
            $total_amount = htmlspecialchars($_GET['total_amount']);
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            //验证订单
            $m = M("ruzhu");
            $order = $m->where(array("pay_order" => $out_trade_no))->find();

            if ($order) {
                $this->redirect('/Wxin/Pm/paiSuccess');
            } else {
                $this->order_error("支付失败！");
            }
            ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            $this->order_error("订单支付失败！");
        }
	}
	/*
	*入驻金异步 ZQJ
	*/
	public function NotifyRURl(){
		$arr = $_POST;
        log_result("./NotifyURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);
		if ($result) {
            //验证成功
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            //订单的资金总额
            $total_amount = $_POST['total_amount'];
            if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                ///////////////////////////////////////////////////////更新1//////////////////////////////////////////////////////////////////////////////
                $m = M("ruzhu");
                $order = $m->where(array("pay_order" => $out_trade_no))->find();
				$total_fee = $order['price'];
               if($order['pay_status'] == 0){
				   $r_data['pay_type'] = 1;
				   $r_data['pay_status'] = 1;
				   $r_data['pay_endtime'] = time();
				   
				   $m->where(array('id' => $order['id']))->save($r_data);
			    }

                $data_w['user_id']=$order['user_id'];
                $data_w['type']=2;
                $data_w['posttime']=time();
                $data_w['order_id']=$order['id'];
                $data_w['cate']=0;
                $data_w['expend']=$total_amount;
                $data_w['way_name']="申请入驻拍卖 缴纳保证金";
                $res1 = M('money_water')->add($data_w);
                  
            }
                //2.记录流水账

                ///////////////////////////////////////////////////////更新2//////////////////////////////////////////////////////////////////////////////
            
            echo "success";    //请不要修改或删除

        } else {
            //验证失败
            echo "fail";
        }
	}
	
    /** 20170713 wzz
     * 电脑支付同步通知 公共方法
     **/
    public function ReturnURL()
    {
        $arr = $_GET;
        log_result("./ReturnURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $result = $alipaySevice->check($arr);
		return $result;
        
    }


    /** 20170713 wzz
     * 电脑支付异步通知 公共方法
     * 1.更新订单状态
     **/
    public function NotifyURL()
    {
        $arr = $_POST;
        log_result("./NotifyURL.txt", var_export($arr, true));
        vendor("Alipay.pagepay.service.AlipayTradeService");
        $alipay_config = $this->alipay_config();
        $alipaySevice = new \AlipayTradeService($alipay_config);
        $alipaySevice->writeLog(var_export($_POST, true));
        $result = $alipaySevice->check($arr);
        return $result;

    }


    /**20170711 wzz
     * 电脑网站支付
     */
    public function alipay()
    {

        //$out_trade_no = $_GET["order_no"];
		$out_trade_no = trim(I("order_no"));

        if (!$out_trade_no) {
            $this->error("无此订单号不存在！");
        }
		$style = trim(I("style"));
		if($style == 'baoding'){
			$order = M("order_pmding")->where(array('order_no' => $out_trade_no))->find();
			$total_amount = $order['baoding'];
			 if ($order['order_status'] != 0) {
				$this->error("订单无法支付！");
			}
		}else if($style == 'ruzhu'){
			$order = M("ruzhu")->where(array('pay_order' => $out_trade_no))->find();
			$total_amount = $order['price'];
			 if ($order['pay_status'] != 0) {
				$this->error("订单无法支付！");
			}
		}else if($style == 'pm'){
			$order = M("order_pm")->where(array('order_no' => $out_trade_no))->find();
			$total_amount = $order['total_fee'];
			 if ($order['pay_status'] != 0) {
				$this->error("订单无法支付！");
			}

            if ($order['order_status'] != 1) {
                $this->error("订单无法支付！");
            }
		}else if($style == 'libao'){
            $order = M("gift_order")->where(array('order_no' => $out_trade_no))->find();
            $total_amount = $order['total_fee'];
            if ($order['pay_status'] != 0) {
                $this->error("订单无法支付！");
            }
        }
        if (!$order) {
            $this->error("无此订单！");
        }
       
        $subject = "浙江美术网支付宝订单支付";
		//$total_amount = $order['price'];
        $body = "浙江美术网支付宝订单支付";

        /******************测试数据 1******************/
        //$subject = "浙江美术网支付宝支付测试";
        //$total_amount = 0.01;
        //$body = "浙江美术网支付宝支付测试";
        /******************测试数据 2******************/

        /*********************封装 1***********************/
        $BizContent = array(
            "product_code" => "FAST_INSTANT_TRADE_PAY",
            "out_trade_no" => $out_trade_no,        //商户订单号，64个字符以内、可包含字母、数字、下划线；需保证在商户端不重复
            "subject" => $subject,            //订单标题
            "total_amount" => $total_amount,        //订单总金额，单位为元，精确到小数点后两位，取值范围[0.01,100000000]
            "body" => $body                //订单描述
        );
        $BizContent = json_encode($BizContent);
        $alipay_config = $this->alipay_config($style);
        vendor("Alipay.AopSdk");
        $aop = new \AopClient;
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $alipay_config['app_id'];
        $aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset = 'UTF-8';
        $aop->format = 'json';
        $request = new \AlipayTradePagePayRequest ();
        $request->setReturnUrl($alipay_config['return_url']);
        $request->setNotifyUrl($alipay_config['notify_url']);
        $request->setBizContent($BizContent);
        //请求
        $result = $aop->pageExecute($request); //支付宝返回的信息
        //输出
        echo $result;
        /*********************封装 2***********************/
    }


    public function xgruzhu(){
        if (IS_AJAX){
            $user_id = $this->user_id;
            $data['ruzhu_status']=1;
            $data['shenhe']=1;
            $res = M('ruzhu')->where(array('user_id'=>$user_id))->save($data);
            if ($res){
                $this->ajaxReturn(array('status'=>1, "info"=>'修改入驻申请成功'));
            }
            $this->ajaxReturn(array('status'=>0, "info"=>'修改入驻申请失败！'));
        }
    }


    //实现商品logo图片上传处理
    public function pmLogo(){
        //给商品实现logo图片上传

        if (IS_AJAX){
            $upload = new \Think\UploadFile;
            //$upload->maxSize  = 3145728 ;// 设置附件上传大小
            $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','svg','mp4','3gp','avi','rmvb','flv');// 设置附件上传类型
            $savepath='./Uploads/Picture/uploads/'.date('Ymd').'/';
            if (!file_exists($savepath)){
                mkdir($savepath);
            }
            $upload->savePath =  $savepath;// 设置附件上传目录
            if(!$upload->upload()) {// 上传错误提示错误信息
                $this->error($upload->getErrorMsg());
            }else{// 上传成功 获取上传文件信息
                $info =  $upload->getUploadFileInfo();
            }

            $data = $upload->savePath.$info[0]['savename'];

            $img = new \Think\Image();//创建对象
            $img -> open($data);//找到被处理原图并打开
            $img -> thumb(383,264,6);//制作缩略图，严格缩放大小为383*264
            //制作好的缩略图存储到服务器
            //./Public/Uploads/logo/2017-02-09/small_589be3664197e.jpg
            $info1 = $upload->savePath.$info['savepath'].'index_'.$info[0]['savename'];
            $img -> save($info1);

            $info1=substr($info1,1);

            $img1 = new \Think\Image();//创建对象
            $img1 -> open($data);//找到被处理原图并打开
            $img1 -> thumb(260,260,6);//制作缩略图，严格缩放大小为383*264
            //制作好的缩略图存储到服务器
            //./Public/Uploads/logo/2017-02-09/small_589be3664197e.jpg
            $info2 = $upload->savePath.$info['savepath'].'logo_'.$info[0]['savename'];
            $img1 -> save($info2);

            $info2=substr($info2,1);


            $this->ajaxReturn(array("index"=>$info1,'logo'=>$info2));
            //return $smallPathName;
        }

    }

    //实现商品相册图片上传处理
    public function pmPics(){
        //实现商品相册图片上传处理

        if (IS_AJAX){
            $upload = new \Think\UploadFile;
            $upload->maxSize  = 3145728 ;// 设置附件上传大小
            $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','svg','mp4','3gp','avi','rmvb','flv');// 设置附件上传类型
            $savepath='./Uploads/Picture/uploads/'.date('Ymd').'/';
            if (!file_exists($savepath)){
                mkdir($savepath);
            }
            $upload->savePath =  $savepath;// 设置附件上传目录
            if(!$upload->upload()) {// 上传错误提示错误信息
                $this->error($upload->getErrorMsg());
            }else{// 上传成功 获取上传文件信息
                $info =  $upload->getUploadFileInfo();
            }

            $data = $upload->savePath.$info[0]['savename'];

            $img = new \Think\Image();//创建对象
            $img -> open($data);//找到被处理原图并打开
            $img -> thumb(1050,1000,6);//制作缩略图，严格缩放大小为1050X1000
            //制作好的缩略图存储到服务器
            //./Public/Uploads/logo/2017-02-09/small_589be3664197e.jpg
            $info = $upload->savePath.$info['savepath'].'pics_'.$info[0]['savename'];
            $img -> save($info);

            $info=substr($info,1);

            $this->ajaxReturn(array('img'=>$info));
            //return $smallPathName;
        }

    }


    /**
     * 删除商品轮播图
     */
    public function delPmSlide()
    {
        if(IS_AJAX){
            $id  = I("id");
            $res = M("pm_slide")->where(array('id'=>$id))->save(array("status"=>0));
            if ($res) {
                $this->ajaxReturn(array('status'=>1, "info"=>"删除图片成功！"));
            } else {
                $this->ajaxReturn(array('status'=>0, "info"=>"删除图片失败！"));
            }
        }
    }

    /**
     * 公益场次
     */
    public function paimaiW()
    {
        $start_time = I('get.start_time');
        $cate = I('get.cate');

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        if ($start_time){
            $map['start'] = array('gt',strtotime($start_time));
        }

        //拍卖场次
        $num = M('pm_num')->where(array('is_xs'=>2,'is_del'=>0,'end_time'=>array('gt',time())))->order('start_time')->select();

        if (!$cate =='' && !$cate==null){
            $map['series_id'] = array('in',$cate);
        }

        foreach ($num as $k=>$v){
            $map['is_del']=0;
            $map['is_shang']=1;
            $map['num_id']=$v['id'];
            //围观weiguan
            $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

            $num[$k]['wgcont'] = $wgcont[0]['wg'];
            $res = M('pm')->where($map)->order('start')->select();

            if ($res){
                //总出价次数
                $num[$k]['zcj']=0;
                foreach ($res as $kk=>$vv){
                    //出价数
                    $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                    //$res[$k]['chujia'] =$ccont;
                    $num[$k]['zcj'] +=$ccont;
                }

                $num[$k]['pm'] = $res[0];
            }else{
                //unset($num[$k]);
            }
        }

        $count =count($num);
        $ArrayObj = new \Org\Util\Arraypage($count,6);
        $page =  $ArrayObj->showpage();//分页显示
        $num = $ArrayObj->page_array($num,0);//数组分页
        $this->assign('page',$page);
        $this->assign('cate',$cate);
        $this->assign('num',$num);
        $this->screens();

        $this->img();
        $this->display();
    }

    public function get_paimaiW()
    {
        if (IS_AJAX) {
            $p = I("post.p");
            $cate = I("post.cate");
            $res = M('pm_num')
                ->where(array('is_xs'=>2,'is_del'=>0,'end_time'=>array('gt',time())))->order('start_time')
                ->select();
            if (!$cate =='' && !$cate==null){
                $map['series_id'] = array('in',$cate);
            }
            foreach ($res as $k=>$v){
                $map['is_del']=0;
                $map['is_shang']=1;
                $map['num_id']=$v['id'];
                //围观weiguan
                $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();

                $res[$k]['wgcont'] = $wgcont[0]['wg'];
                $res1 = M('pm')->where($map)->order('start')->select();

                if ($res1){
                    //总出价次数
                    $res[$k]['zcj']=0;
                    foreach ($res1 as $kk=>$vv){
                        //出价数
                        $ccont = M('chujia')->where(array('goods_id'=>$vv['id']))->count();
                        //$res[$k]['chujia'] =$ccont;
                        $res[$k]['zcj'] +=$ccont;
                    }

                    $res[$k]['pm'] = $res1[0];
                }else{
                    unset($res[$k]);
                }
            }
            $data = array();
            $i=0;
            $j = ($p-1)*6;
            foreach($res as $k=>$v){
                if($i<$j+10 && $i>=$j){
                    $data[] = $v;
                }
                $i++;
            }
            if($data){
                $str = '';
                foreach($data as $k=>$v){

                    $str .= '<div class="left-store"><div class="store">';
                    $str .= '<a href="/Wxin/Pm/paimaiWNum?num_id='.$v['id'].'"> <img src="'.$v['backg_pic'].'" width="100%" /></a>';
                    $str .= '<div class="store-det"> <a href="/Wxin/Pm/paimaiWNum?num_id='.$v['id'].'">';
                    $str .= '<h3>'.$v['name'].'</h3></a><span class="action">';
                    $str .= '</span> <span class="time">'.date('Y年m月d日 H:i',$v['start_time']).' - '.date('Y年m月d日 H:i',$v['end_time']).'</span>';
                    $str .= '<br /><span class="cishu">出价次数：<b>'.($v['zcj']?$v['zcj']:0).'</b></span>';
                    $str .= '<span class="cishu">围观数：<b>'.($v['wgcont']?$v['wgcont']:0).'</b></span>';
                    $str .= '</div><div class="store-mai"><h2>'.date('d',$v['start_time']).'</h2><p>';
                    $m = $this->returnm(date('m',$v['start_time']));
                    $str .= $m;
                    $str .= '月</p></div></div></div>';
                }
                $this->ajaxReturn(array('status'=>1,'html'=>$str));
            }
            $this->ajaxReturn(array('status'=>0,'data'=>''));
        }
    }
    //公益场次详情
    public function paimaiWNum(){
        $num_id = I('get.num_id');

        $num = M('pm_num')->where(array('id'=>$num_id))->find();

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        //拍卖场次
        //$num = M('pm_num')->where(array('is_xs'=>0,'is_del'=>0,'end_time'=>array('gt',time()),'start_time'=>array('lt',time())))->order('end_time')->find();
        if($num['start_time']>time()){
            $this->assign('djtime',$num['start_time']);
            $this->assign('type',1);
        }else{
            $this->assign('djtime',$num['end_time']);
            $this->assign('type',2);
        }


        $map['num_id']=$num['id'];

        $map['is_del']=0;
        $map['is_shang']=1;

        //进行中的拍卖
        $map['end']=array('gt',time());
        //拍卖件数
        $cont = M('pm')->where($map)->count();
        //围观weiguan
        $wgcont = M('pm')->where($map)->field('sum(weiguan) as wg')->select();
        //dump($wgcont);die;
        $res = M('pm')->where($map)->order('end')->select();
        //总出价次数
        $zcj=0;
        foreach ($res as $k=>$v){
            //出价数
            $ccont = M('chujia')->where(array('goods_id'=>$v['id']))->count();
            $res[$k]['chujia'] =$ccont;
            $zcj +=$ccont;
        }
        //dump($res);

        $this->assign('now_time',time());
        $this->assign('wgcont',$wgcont);
        $this->assign('cjcont',$zcj);
        $this->assign('cont',$cont);
        $this->assign('res',$res);

        $this->assign('num',$num);

        $this->img();
        $this->display();
    }

    public function companyDetails(){
        $id = I('get.id');
        $res = M('ruzhu')->where(array('id'=>$id))->find();
        $pic = M('pm')->where(array('promulgator'=>$id))->order('shang_time desc')->limit(1)->find();
        //dump($pic['index_pic']);exit;
        $this->assign('res',$res);
        $this->assign('pic',$pic);
        $this->display();
    }

    public function numDetail(){
        $id = I('get.id');
        $res = M('pm_num')->where(array('id'=>$id))->find();
       // dump($res);exit;
        $this->assign('res',$res);
        $this->display();
    }

    public function baozhengjin()
    {
        $goods_id = I('get.id');
        $mapm = array('id'=>$goods_id);
        $res = M('pm')->where($mapm)->find();
        $this->assign('res',$res);
        $this->display();
    }
}