<?php namespace Home\Controller;

use Think\Controller;

class AuctionController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        $cate = M('cate')->group('classname')->select();
        $this->assign('cate',$cate);
        $res = M('banner')->where(array('type'=>5,'isdel'=>0))->select();
        $this->assign('res',$res);

        $data['end'] = array('gt',time());
        $pm = M('goods_active')->where($data)->select();
        foreach ($pm as $k=>$v) {
            $goods = M('goods')->where(array('id' => $v['goods_id']))->find();
            $pm[$k]['goods_name'] = $goods['goods_name'];
            $pm[$k]['index_pic'] = $goods['index_pic'];
        }
        $this->assign('pm',$pm);

        $this->display();
    }
    /*
     * 添加手机提醒
     */
    public function addRemind(){
     $res = M('tel_remind')->where(array('user_id'=>$_SESSION['member_id'],'goods_id'=>$_POST['goods_id']))->find();
      if($res != null){
          $this->ajaxReturn(array('status'=>1,'info'=>"您已提交短信通知"));
      }
      $data = I('post.');
      $data['user_id'] = $_SESSION['member_id'];
      $res = M('tel_remind')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>"短信通知添加成功"));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>"短信通知添加失败"));
        }
    }


    public function result()
    {
        $data['end'] = array('lt',time());
        $pm = M('goods_active')->where($data)->select();

        foreach ($pm as $k=>$v) {
            $goods = M('goods')->where(array('id' => $v['goods_id']))->find();
            $pm[$k]['goods_name'] = $goods['goods_name'];
            $pm[$k]['index_pic'] = $goods['index_pic'];
        }

        $key=array();
        for($i=0;$i<count($pm);$i++){
            $key = $pm[$i]['id'];
        }
        $str = M('goods_active')->where(array('id'=>array('in',$key)))->getField('goods_id',true);
        $arr=explode(",",$str[0]);
        $count = count($arr);
        $this->assign('count',$count);
        $key1=array();
        for($i=0;$i<$count;$i++) {
            $key1[] = $arr[$i];
        }
        $weiguan = M('tel_remind')->where(array('goods_id'=>array('in',$key1)))->count();
        $this->assign('weiguan',$weiguan);

        $this->assign('pm',$pm);
        //1504886400
        $cate = M('cate')->group('classname')->select();
        $this->assign('cate',$cate);
        $this->display();
    }

    public function timeLimit()
    {
        $this->display();
    }

    public function welfare()
    {
        $sql = $sql = "SELECT m.person_name,m.telephone,i.order_time FROM app_order_info i INNER JOIN app_member m on i.user_id=m.id  WHERE i.order_status >1 order by order_time desc";
        $res = M('order_info')->query($sql);
        $this->assign('res',$res);

        $images = M('banner')->where(array('type'=>71,'isdel'=>0))->select();
        $this->assign('images',$images);
        //dump($images);
        $this->display('gongyi');
    }

    public function details()
    {
        $active_id = $_GET['id'];
        $str = M('goods_active')->where(array('id'=>$active_id))->getField('goods_id',true);
        $arr=explode(",",$str[0]);
        $count = count($arr);
        $this->assign('count',$count);
        $key=array();
        for($i=0;$i<$count;$i++) {
            $key[] = $arr[$i];
        }
        $res = M('goods')->where(array('id'=>array('in',$key)))->select();

        foreach ($res as $k=>$v){
            $res[$k]['count'] = M('tel_remind')->where(array('goods_id'=>$v['id']))->count();
        }

        $weiguan = M('tel_remind')->where(array('goods_id'=>array('in',$key)))->count();
        $this->assign('weiguan',$weiguan);
        $this->assign('res',$res);

        $end = M('goods_active')->where(array('id'=>$active_id))->getField('end');
        $this->assign('end',date('Y-m-d H:i:s', $end));

        $this->display();
    }

    public function buy()
    {
        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

      $id = $_GET['id'];
      $res = M('goods')->where(array('id'=>$id))->find();
      $this->assign('res',$res);
      $tel = M('tel_remind')->where(array('goods_id'=>$_GET['id']))->count();
      $this->assign('tel',$tel);

        $res1 = M('goods_slide')->where(array('goods_id'=>$id,'status'=>0))->field('pic')->select();
        $this->assign('goods_slide',$res1);
        $res2 = M('goods')->where(array('id'=>$id))->find();
        $this->assign('res2',$res2);

        $remind = M('goods_remind')->find();
        $this->assign('remind',$remind);

        $service = M('goods_service')->find();
        $this->assign('service',$service);

        $bz = M('goods_bz')->find();
        $this->assign('bz',$bz);
        $this->display();
    }
    public function buy1()
    {
        $name = $_SESSION['member_id'];
        if($name == ''){
            $this->assign('name',0);
        }else{
            $this->assign('name',$name);
        }

        $id = $_GET['id'];
        $res = M('goods')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $tel = M('tel_remind')->where(array('goods_id'=>$_GET['id']))->count();
        $this->assign('tel',$tel);

        $res1 = M('goods_slide')->where(array('goods_id'=>$id,'status'=>0))->field('pic')->select();
        $this->assign('goods_slide',$res1);
        $res2 = M('goods')->where(array('id'=>$id))->find();
        $this->assign('res2',$res2);

        $remind = M('goods_remind')->find();
        $this->assign('remind',$remind);

        $service = M('goods_service')->find();
        $this->assign('service',$service);

        $bz = M('goods_bz')->find();
        $this->assign('bz',$bz);
        $this->display();
    }

    public function resultDetails()
    {
        $active_id = $_GET['id'];

        $str = M('goods_active')->where(array('id'=>$active_id))->getField('goods_id',true);
        $arr=explode(",",$str[0]);
        $count = count($arr);
        $this->assign('count',$count);
        $key=array();
        for($i=0;$i<$count;$i++) {
            $key[] = $arr[$i];
        }
        $res = M('goods')->where(array('id'=>array('in',$key)))->select();

        foreach ($res as $k=>$v){
            $res[$k]['count'] = M('tel_remind')->where(array('goods_id'=>$v['id']))->count();
        }

        $weiguan = M('tel_remind')->where(array('goods_id'=>array('in',$key)))->count();
        $this->assign('weiguan',$weiguan);
        $this->assign('res',$res);
        $this->display();
    }

    public function center()
    {
        $this->display();
    }

    public function select()
    {
        $this->display();
    }

    public function category()
    {
        $this->display();
    }

    public function submitData()
    {
        $this->display();
    }

    public function examine()
    {
        $this->display();
    }

    public function pay()
    {
        $this->display();
    }

    public function paySuccess()
    {
        $this->display();
    }


}