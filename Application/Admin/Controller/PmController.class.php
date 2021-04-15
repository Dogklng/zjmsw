<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class PmController extends CommonController {
    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function index(){

    }

    /**
     * 拍卖列表
     */
    public function pmList(){
        //$cate_id=I('get.cate_id');
        $name=trim(I('get.name'));
        $num_num=trim(I('get.num_num'));
        //dump($name);
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['p.goods_name'] = array('like',"%$name%");
        }

        if($num_num){
            $map['n.num'] = $num_num;
            //$count2=$m->where($map)->count();
        }
        $map['p.is_del'] = 0;
        $map['p.shenhe'] = 1;

        //平台发布
        $map['p.promulgator'] = 0;
        $map['p.paimai_zt'] = array('lt',2);

        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['p.is_shang'] = 0;
            //$count2=$m->where($map)->count();
        }
        if($is_sale==1){
            $map['p.is_shang'] = 1;
            //$count1=$m->where($map)->count();
        }
        $str = "left join app_pm_num as n on n.id=p.num_id";

        /*商品数量*/
        $count=M("pm as p")->join($str)->where($map)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M("pm as p")->join($str)->where($map)->field('p.*,n.num as num_num,n.name as num_name')->order('sort asc')->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        /*foreach ($res as $k=>$v){
            if($v['num_id']!=0){
                $res[$k]['num'] = M('pm_num')->where(array('id'=>$v['num_id']))->find();
            }
        }*/

        /*if($num_num){
            foreach ($res as $k=>$v){
                if($v['num']['num']!=$num_num){
                    unset($res[$k]);
                }
            }
        }*/
        unset($map['p.is_shang']);

        $countss = M("pm as p")->join($str)->where($map)->count();

        // 拍卖中
        $count1=M("pm as p")->join($str)->where($map)->where(array('p.is_shang'=>1))->count();
        // 下架中

        $count2=M("pm as p")->join($str)->where($map)->where(array("is_shang"=>0))->count();

        //场次信息
        $num = M('pm_num')->where(array('is_del'=>0,'end_time'=>array('gt',time())))->select();
        $this->assign("num",$num);

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count1",$count1 );
        $this->assign("count2",$count2 );
        $this->assign("cache", $res);
        $this->display();
    }

    /**
     * 拍卖列表-》 出价列表
     */
    public function Pmoffer(){
        $pm_id=I('get.id');
        $str = "left join app_member as m on m.id=c.user_id";

        /*商品数量*/
        $count=M("chujia as c")->join($str)->where(array('goods_id'=>$pm_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M("chujia as c")->join($str)->where(array('goods_id'=>$pm_id))->field('c.*,m.person_name,m.telephone')->order('time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("page",$show);
        $this->assign("cache", $res);
        $this->display();
    }

    /**
     * 添加拍卖
     */
    public function addPm()
    {
        if(IS_AJAX){
            $data1 = I('post.');
            /*if(!$data1['goods_des']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作品描述必填！';
                $this->ajaxReturn($dataAj);die;
            }*/

            /*if(!$data1['serial']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作者头像必传！';
                $this->ajaxReturn($dataAj);die;
            }*/


            if(!$data1['logo_pic']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作品展示图必传！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data1['pic1']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作品切换图必传！';
                $this->ajaxReturn($dataAj);die;
            }

           /* if(!$data1['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作者简介必填！';
                $this->ajaxReturn($dataAj);die;
            }*/


            $m      = M("pm");
            $g_s  = M("pm_slide");
            $data   = I("post.");
            //保存产品属性 zj
            //dump($data);die;
            if($data['is_baoliu']==0){
                $data['baoliu']=0;
            }

            $data['baoliu']=$data['baoliu']?$data['baoliu']:0;
            //$data['start'] = strtotime($data['start']);
            //$data['end'] = strtotime($data['end']);
            $data['dangqian'] = $data['start_price'];
            $data['shenhe']=1;
            $data['cate_id'] = implode(',',$data['cate_id']);
            $slide_pic = $data['pic1'];
            $data['weight'] = $data['weight']/1000;
            unset($data['pic1']);
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
                    $g_s->add($slide_data);
                }
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增拍卖成功！';
                $this->ajaxReturn($dataAj);
                /*$iUrl = U("Admin/Pm/pmlist");
                echo "<script>alert('新增拍卖成功！');window.location.href='".$iUrl."';</script>";*/
            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '新增拍卖失败！';
                $this->ajaxReturn($dataAj);
            }
        }
        /*$s=M("series");
        $serieslist=$s->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }*/

        $cate = M('pm_cate')->where(array('level=1','isdel'=>0))->select();
        foreach ($cate as $k=>$v){
            $cate_two = M('pm_cate')->where(array('pid'=>$v['id'],'isdel'=>0))->select();
            if($cate_two){
                $cate[$k]['data']=$cate_two;
            }else{
                unset($cate[$k]);
            }
        }


        //产品属性选择 zj
        $this->assign("serieslist", $cate);
        $this->display();
    }

    /**
     * 编辑拍卖
     */
    public function editPm()
    {

        if(IS_AJAX){
            $data1 = I('post.');
           /* if(!$data1['goods_des']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作品描述必填！';
                $this->ajaxReturn($dataAj);die;
            }*/

           /* if(!$data1['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '作者简介必填！';
                $this->ajaxReturn($dataAj);die;
            }*/

            $m                  = M("pm");
            $g_s              = M("pm_slide");
            $data               = I("post.");
            if($data['is_baoliu']==0){
                $data['baoliu']=0;
            }

            $data['baoliu']=$data['baoliu']?$data['baoliu']:0;
            //$data['start'] = strtotime($data['start']);
            //$data['end'] = strtotime($data['end']);
            $data['weight'] = $data['weight']/1000;
            $data['cate_id']    = implode(',',$data['cate_id']);
            $id                 = $data['id'];

            $slide_pic          = $data['pic1'];
            $data['dangqian'] = $data['start_price'];
            unset($data['id']);
            unset($data['pic1']);
            if (!$id) {

                $dataAj['status'] = 0;
                $dataAj['info'] = '缺少参数！';
                $this->ajaxReturn($dataAj);
            }
            //保存产品属性 zj
            $res = $m->where(array("id"=>$id,'isdel'=>0))->save($data);
            if ($res !== false) {
                foreach ($slide_pic as $k=>$v) {
                    $slide_data = array(
                        "goods_id"   => $id,
                        "sort"       => $k,
                        "create_at"  => NOW_TIME,
                        "pic"        => $v,
                        "status"     => 1,
                    );
                    $g_s->add($slide_data);
                }
            } else {
                $dataAj['status'] = 0;
                $dataAj['info'] = '修改拍卖失败！';
                $this->ajaxReturn($dataAj);
            }

            $dataAj['status'] = 1;
            $dataAj['info'] = '修改拍卖成功！';
            $this->ajaxReturn($dataAj);
        }
        $id = I("id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";
        }
        $goods = M("pm")->where(array('id'=>$id, "is_del"=>0))->find();
        if (!$goods) {
            echo "<script>alert('无此拍卖！');window.history.back();</script>";
        }

        if($goods['start']){
            if($goods['start']<time()){
                echo "<script>alert('拍卖中不可修改！');window.history.back();</script>";
            }
        }


        //$s                      = M("series");
        $goods['seriesname']    = M('pm_cate')->where(array('id'=>$goods['series_id'],'isdel'=>0))->getField('classname');
        $goods['weight'] = $goods['weight']*1000;
        /*$serieslist = $s->where(array("pid"=>0, "isdel"=>0))->order('sort asc')->select();
        foreach ($serieslist as $k => $v) {
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->order('sort asc')->select();
        }*/

        $cate = M('pm_cate')->where(array('level=1','isdel'=>0))->select();
        foreach ($cate as $k=>$v){
            $cate_two = M('pm_cate')->where(array('pid'=>$v['id'],'isdel'=>0))->select();
            if($cate_two){
                $cate[$k]['data']=$cate_two;
            }else{
                unset($cate[$k]);
            }
        }
        $this->assign("serieslist", $cate);
        $pm_slide = M("pm_slide")->where(array('goods_id'=>$id, "status"=>1))->select();
        $this->assign("pm_slide", $pm_slide);
        $this->assign("cache", $goods);
        //产品属性选择 zj
        $this->display();
    }

    /**
     * 修改拍卖品部分状态
     */
    public function changeStatus(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("pm");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            if($res['start']<time()){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"拍卖中不可下架！"));die;
            }
            if ($res[$item]==0 && $item == 'is_shang'){
                $data['shang_time'] = time();
            }

            $data[$item] = 1-intval($res[$item]);

            $data['num_id'] = '';
            $res2 = $m->where(array("id"=>$id))->save($data);
            if($res2){
                    $arr = array(1,2);
                    $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }

    /**
     * 拍卖品上架
     */
    public function glnum(){
        if(IS_AJAX){
            $id   = I("post.id");
            $num_id = I('post.num_id');
            $type = I('post.type');
            $m    = M("pm");
            $res  = $m->where(array("id"=>$id))->find();
            $num  = M('pm_num')->where(array("id"=>$num_id))->find();
            if(!$res || !$num){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"上架失败！"));
            }
           /* if ($res['end']<time()){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"拍品结束时间不能小于当前时间！"));
            }*/

            //时间判断
            /*$num = M('pm_num')->where(array('id'=>$num_id))->find();
            if ($res['start']<$num['start_time']){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"拍品开始时间不能小于场次开始时间！"));
            }*/

            /*if ($res['end']>$num['end_time']){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"拍品结束时间不能大于场次结束时间！"));
            }*/


            $data['shang_time'] = time();

            $data['num_id'] = $num_id;
            $data['is_shang'] = 1;
            $data['paimai_zt'] = 0;

            if($type==1){
                $data['start'] = strtotime(I('post.start'));
                $data['end'] = strtotime(I('post.end'));
                //print_r($data);exit;
               /* $date = I('post.date');
                $date1 = I('post.date1');
                $xiaoshi = I('post.xiaoshi');
                $xiaoshi1 = I('post.xiaoshi1');
                $data['start'] =strtotime($date.$xiaoshi);*/
                /*if ($xiaoshi=="14:00:00"){
                    $data['end'] = $data['start']+1*60*60;
                }else{
                    $data['end'] = $data['start']+2*60*60;
                }*/
                //$data['end'] = strtotime($date1.$xiaoshi1);
            }else{
                $data['start'] =$num['start_time'] ;
                $data['end'] =$num['end_time'] ;
            }
            $res2 = $m->where(array("id"=>$id))->save($data);
            if($res2){
                $this->ajaxReturn(array("status"=>1,"info"=>"上架成功！"));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"上架失败！"));
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
                $this->ajaxReturn(array('status'=>0, "info"=>"删除图片失败！".$id));
            }
        }
    }


    /**
     * 删除产品
     */
    public function delPm(){
        $id  = $_GET['id'];
        $res = M("pm")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){

            $iUrl = U("Admin/Pm/pmlist");
            echo "<script>alert('删除成功！');window.location.href='".$iUrl."';</script>";
            //$this->success("删除成功！");die;
        }

        $iUrl = U("Admin/Pm/pmlist");
        echo "<script>alert('删除失败！');window.location.href='".$iUrl."';</script>";

        $this->display();
        //$this->error("删除失败！");die;
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
     * 拍卖场次列表
     */
    public function pmNumList(){

        $m = M('pm_num');

        $count=$m->where(array('is_del'=>0))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $num = M('pm_num')->where(array('is_del'=>0))->limit($Page->firstRow.','.$Page->listRows)->order('end_time desc')->select();
        $this->assign("page",$show);
        $this->assign("num",  $num);
        $this->display();
    }

    /**
     * 添加拍卖场次
     */
    public function addPmNum(){
        if (IS_AJAX){
            $num = I('post.num');
            $res = M('pm_num')->where(array('num'=>$num,'is_del'=>0))->find();
            if($res){
                $this->ajaxReturn(array('status'=>0, "info"=>"场次重复！"));
            }


            $data = I('post.');
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
            //
            if ($data['is_xs']==0){
                /*$res = M('pm_num')->where(array('is_del'=>0,'is_xs'=>0))->order('end_time desc')->find();
                if ($data['start_time']<$res['end_time']){
                    $this->ajaxReturn(array('status'=>0, "info"=>"开始时间需大于最近场次结束时间！"));
                }*/
            }else{
                /*$resx = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1))->order('end_time desc')->find();
                if ($data['start_time']<$resx['end_time']){
                    $this->ajaxReturn(array('status'=>0, "info"=>"开始时间需大于最近场次结束时间！"));
                }*/
                $data['start_time'] = strtotime(date('Y-m-d',$data['start_time']).'9:00:00');
                $data['end_time'] = strtotime(date('Y-m-d',$data['end_time']).'21:00:00');
            }
            $res3 = M('pm_num')->add($data);
            //dump($data);die;
            if(!$res3){
                $this->ajaxReturn(array('status'=>0, "info"=>"新增拍卖场次失败！"));
            }
            $this->ajaxReturn(array('status'=>1, "info"=>"新增拍卖场次成功！"));
        }
        //$res = M('pm_num')->where(array('is_del'=>0,'is_xs'=>0))->order('end_time desc')->find();
        //$resx = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1))->order('end_time desc')->find();

        //$this->assign("res",  $res);
        //$this->assign("resx",  $resx);
        $this->display();
    }


    /**
     * 编辑拍卖场次
     */

    public function editPmNum(){
        $id = I('get.id');
        $num = M('pm_num');
        if (IS_AJAX){
            $id1 = I('post.id');
            $num_name = I('post.num');
            $res = M('pm_num')->where(array('num'=>$num_name,'is_del'=>0,'id'=>array('neq',$id1)))->find();
            if($res){
                $this->ajaxReturn(array('status'=>0, "info"=>"场次重复！"));
            }

            $data = I('post.');
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);

            $old_num = M('pm_num')->where(array('id'=>$id1))->find();
            if ($data['is_xs']==0 || $data['is_xs']==2){

                $pms = M('pm')->where(array('num_id'=>$id1,'is_shang'=>1))->find();
                if($pms){
                    if($old_num['start_time']!=$data['start_time'] || $old_num['end_time']!=$data['end_time']){
                        M()->startTrans();
                        $pm = M('pm')->where(array('num_id'=>$id1))->save(array('start'=>$data['start_time'],'end'=>$data['end_time']));
                        if(!$pm){
                            M()->rollback();
                            $this->ajaxReturn(array('status'=>0, "info"=>"修改拍卖场次失败！"));
                        }
                    }
                }

                /*$res = M('pm_num')->where(array('is_del'=>0,'is_xs'=>0,'id'=>array('neq',$data['id'])))->order('end_time desc')->find();
                if ($data['start_time']<$res['end_time']){
                    $this->ajaxReturn(array('status'=>0, "info"=>"开始时间需大于最近场次结束时间！"));
                }*/
            }else{
                /*$resx = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1,'id'=>array('neq',$data['id'])))->order('end_time desc')->find();
                if ($data['start_time']<$resx['end_time']){
                    $this->ajaxReturn(array('status'=>0, "info"=>"开始时间需大于最近场次结束时间！"));
                }*/

                $pms = M('pm')->where(array('num_id'=>$id1,'is_shang'=>1))->find();
                if($pms){
                    if($old_num['start_time']!=$data['start_time'] || $old_num['end_time']!=$data['end_time']){
                        M()->startTrans();
                        $pm = M('pm')->where(array('num_id'=>$id1))->save(array('is_shang'=>0));
                        if(!$pm){
                            M()->rollback();
                            $this->ajaxReturn(array('status'=>0, "info"=>"修改拍卖场次失败！"));
                        }
                    }
                }
                $data['start_time'] = strtotime(date('Y-m-d',$data['start_time']).'9:00:00');
                $data['end_time'] = strtotime(date('Y-m-d',$data['end_time']).'21:00:00');
            }



            $res3 = M('pm_num')->where(array('id'=>$data['id'],'is_del'=>0))->save($data);
            //dump($data);die;
            if(!$res3){

                $this->ajaxReturn(array('status'=>0, "info"=>"修改拍卖场次失败！"));
            }
            M()->commit();
            if($data['is_xs']==0){
                $this->ajaxReturn(array('status'=>1, "info"=>"修改拍卖场次成功！"));
            }else{
                $this->ajaxReturn(array('status'=>1, "info"=>"修改拍卖场次成功！场次拍卖品请重新上架"));
            }

        }
        $numinfo = $num->where(array('id'=>$id,'is_del'=>0))->find();
        $this->assign("num",  $numinfo);

        //$res = M('pm_num')->where(array('is_del'=>0,'is_xs'=>0,'id'=>array('neq',$id)))->order('end_time desc')->find();
        //$resx = M('pm_num')->where(array('is_del'=>0,'is_xs'=>1,'id'=>array('neq',$id)))->order('end_time desc')->find();

        //$this->assign("res",  $res);
        //$this->assign("resx",  $resx);

        $this->display();
    }

    /**
     * 拍卖场次拍品
     */

    public function xqPmNum(){
        $id = I('get.id');

        $numinfo = M('pm_num')->where(array('id'=>$id,'is_del'=>0))->find();
        $this->assign("num",  $numinfo);

        $count = M('pm')->where(array('num_id'=>$id,'is_del'=>0,'is_shang'=>1))->count();

        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",  $show);
        $res = M('pm')->where(array('num_id'=>$id,'is_del'=>0,'is_shang'=>1))->order('sort asc')->limit($Page->firstRow.','.$Page->listRows)->select();

        //$res = M('pm')->where(array('num_id'=>$id,'id_del'=>0,'is_shang'=>1))->select();
        $this->assign("res",  $res);
        $this->display();
    }

    /**
     * 拍卖场次拍品详情
     */

    public function xqPmN(){
        $this->xqPm();
    }

    /**
     * 删除拍卖场次
     */

    public function delPmNum(){
        if (IS_AJAX){
            $id  = $_GET['id'];
            $pm = M('pm')->where(array('num_id'=>$id,'is_del'=>0,'paimai_zt'=>array('lt',2)))->select();
            if ($pm){

                $this->ajaxReturn(array('status'=>0, "info"=>"删除失败！有拍卖物品未拍卖！"));die;
            }
            $res = M("pm_num")->where(array("id"=>$id))->save(array("is_del"=>1));
            if($res!=false){
                $this->ajaxReturn(array('status'=>1, "info"=>"删除成功！"));die;
            }
            $this->ajaxReturn(array('status'=>0, "info"=>"删除失败！".$id));die;
        }
    }

    /**
     * 订单状态（0：已取消，1：待付款,2：待发货，3：已发货，4：已完成，5：已关闭，6：退款中， 7：订单删除）
     */
    public function orderPmList() {
        //查询
        /*if(IS_GET){*/
            $status = $_GET['order_status'];
            $telephone      = trim(I("get.telephone"));
            $person_name    = trim(I("get.person_name"));
            $order_no       = trim(I("get.order_no"));
            $starttime      = trim(I("get.starttime"));
            $endtime        = trim(I("get.endtime"));
            $this->assign('starttime',$starttime);
            $this->assign('endtime',$endtime);
            $this->assign('telephone',$telephone );
            $this->assign('person_name',$person_name );
            $this->assign('order_no',$order_no );
            /*if($starttime != null){
                $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_pm a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%' AND a.order_time BETWEEN '{$starttime}' AND '{$endtime}'";
            }else{
                //dump($telephone);die;
                $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.id,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_pm a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%'";
                //dump($sql);die;
            }*/
            if ($telephone){
                $map['b.telephone'] = array('like',"%$telephone%");
            }


            if ($person_name){
                $map['b.person_name'] = array('like',"%$person_name%");
            }

            if ($order_no){
                $map['a.order_no'] = array('like',"%$order_no%");
            }

            if ($starttime && $endtime){
                $starttime      = strtotime($starttime.'00:00:00');
                $endtime        = strtotime($endtime.'23:59:59');
                $map[1]['a.order_time'] =array('gt',$starttime);
                $map[2]['a.order_time'] =array('lt',$endtime);
            }elseif($starttime){
                $starttime      = strtotime($starttime.'00:00:00');
                $map['a.order_time'] =array('gt',$starttime);
            }elseif($endtime){
                dump($endtime);
                $endtime        = strtotime($endtime.'23:59:59');
                $map['a.order_time'] =array('lt',$endtime);
            }

            if($status != null ){
                $map['a.order_status'] =$status;
            }else{
                $map['a.order_status'] = array('lt',5);
            }

            $count = count(M("order_pm a")->join('left join app_member b on a.user_id=b.id')->group('a.id')->where($map)->select());
            //dump($count);
            $Page  = getpage($count,5);
            $show  = $Page->show();//分页显示输出
            $this->assign("page",$show);
            $res = M("order_pm a")->join('left join app_member b on a.user_id=b.id')->where($map)->limit($Page->firstRow.','.$Page->listRows)->field('b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name')->select();
            $this->assign('cache',$res);
        /*}else{
            //显示
            $status = $_GET['order_status'];
            if($status === null ){
                $count = M("order_pm")->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $sql   = "select b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name from app_order_pm a left join app_member b on a.user_id=b.id order by a.id desc limit"." ".$Page->firstRow.",".$Page->listRows."";
                $res = M("order_pm")->query($sql);
                // dump($res);exit;
                //$res  = M("order_info")->alias("a")->join("app_status b on a.order_status=b.status_id")->order_info('a.id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign("page",$show);
            }else{
                $count = M("order_pm")->where("order_status=$status")->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $sql   = "select b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name from app_order_pm a left join app_member b on a.user_id=b.id where a.order_status=$status order by a.id desc limit"." ".$Page->firstRow.",".$Page->listRows." ";
                $res = M("order_pm")->query($sql);
                //$res  = M("order_info")->alias("a")->join("app_order_status b on a.order_status=b.status_id")->where("a.order_status=$status")->order_info('a.id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign("page",$show);
            }
            $this->assign('cache',$res);
        }*/
//        p($res);
        $m = D('order_pm');
        $count  = $m->count();
        $count0 = $m->where(array("order_status"=>0))->count();//已取消
        $count1 = $m->where(array("order_status"=>1))->count();//待付款
        $count2 = $m->where(array("order_status"=>2))->count();//待发货
        $count3 = $m->where(array("order_status"=>3))->count();//待收货
        $count4 = $m->where(array("order_status"=>4))->count();//已签收
        /*$count5 = $m->where(array("order_status"=>5))->count();//已关闭*/
        /*$count6 = $m->where(array("order_status"=>6))->count();//退款*/
        $this->assign("count",  $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);
        $this->assign("count4", $count4);
        /*$this->assign("count5", $count5);*/
        /*$this->assign("count6", $count6);*/
        /**
         * 物流公司 2016-1-3   Jaw
         */
        $express = M("express")->order("id asc")->select();
        $this->assign("express_list",$express);
        $this->display();
    }

    /**
     * 审核列表
     */
    public function pmAuditList(){
        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['goods_name'] = array('like',"%$name%");
        }

        $m   = M("pm");
        $map['is_del'] = 0;
        $map['is_chaogao'] = 0;
        //promulgator
        //其他发布者
        $map['promulgator'] = array('gt',0);

        $is_sale = I("is_sale");

        // 未审核

        $count3=$m->where(array("is_del"=>0,'is_chaogao'=>0, "shenhe"=>0,'promulgator'=>array('gt',0)))->count();
        if($is_sale==3){
            $map['shenhe'] = 0;
            //$count3=$m->where($map)->count();
        }


        // 审核通过

        $count4=$m->where(array("is_del"=>0,'is_chaogao'=>0, "shenhe"=>1,'promulgator'=>array('gt',0)))->count();
        if($is_sale==4){
            $map['shenhe'] = 1;
            //$count4=$m->where($map)->count();
        }

        //审核拒绝

        $count5=$m->where(array("is_del"=>0,'is_chaogao'=>0, "shenhe"=>2,'promulgator'=>array('gt',0)))->count();
        if($is_sale==5){
            $map['shenhe'] = 2;
            //$count5=$m->where($map)->count();
        }

        /*商品数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0,'is_chaogao'=>0,'promulgator'=>array('gt',0)))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('sort asc')->limit($Page->firstRow.','.$Page->listRows)->select();


        //dump($res);
        //场次信息
        $num = M('pm_num')->where(array('is_del'=>0,'end_time'=>array('gt',time())))->select();
        $this->assign("num", $num);

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count3",$count3 );
        $this->assign("count4",$count4 );
        $this->assign("count5",$count5 );
        $this->assign("cache", $res);

        $this->display();
    }

    /**
     * 拍品详情
     */
    public function xqPm(){
        $id=I('get.id');

        $m   = M("pm");
        $map['is_del'] = 0;
        $res = $m->where($map)->where(array('id'=>$id))->find();
        //分类信息
        $cate = M('pm_cate')->where(array('id'=>$res['series_id']))->find();

        $res['cate_name'] = $cate['classname'];
        //dump($res);exit;
        $this->assign("res", $res);

        $pm_slide = M("pm_slide")->where(array('goods_id'=>$id, "status"=>1))->select();
        $this->assign("pm_slide", $pm_slide);
        $this->display('xqPm');
    }


    //拍卖审核通过
    public function agree(){

        //$num = M('pm_num')->where(array('id'=>$_POST['num_id']))->find();
        //$data['start'] = $num['start_time'];
        //$data['end'] = $num['end_time'];

        //$data['shang_time'] = time();
        //$data['num_id'] = $_POST['num_id'];
        //$data['is_shang'] = 1;

        //$res = M('pm')->where(array('id'=>$_POST['id']))->save($data);
        /*if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核通过失败！"));
        }*/

        if(IS_AJAX){
            $id   = I("post.id");
            $num_id = I('post.num_id');
            $type = I('post.type');
            $m    = M("pm");
            $res  = $m->where(array("id"=>$id))->find();
            $num  = M('pm_num')->where(array("id"=>$num_id))->find();
            if(!$res || !$num){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"审核通过失败！"));
            }
            $data['shenhe'] = 1;
            $data['shang_time'] = time();

            $data['num_id'] = $num_id;
            $data['is_shang'] = 1;

            if($type==1){
                $date = I('post.date');
                $xiaoshi = I('post.xiaoshi');
                $data['start'] =strtotime($date.$xiaoshi);
                if ($xiaoshi=="14:00:00"){
                    $data['end'] = $data['start']+1*60*60;
                }else{
                    $data['end'] = $data['start']+2*60*60;
                }
            }else{
                $data['start'] =$num['start_time'] ;
                $data['end'] =$num['end_time'] ;
            }
            $res2 = $m->where(array("id"=>$id))->save($data);
            if($res2){
                $this->ajaxReturn(array("status"=>1,"info"=>"审核通过成功！"));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"审核通过成功！"));
        }
    }

    //拍卖审核拒绝
    public function disagree(){
        $res = M('pm')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }
    //发货
    //选择快递公司
    public function express(){
        $data["express_name"]    = I("post.express_name");//编码

        $data["express_no"]      = I("post.express_no");
        $data["is_send"]         = 1;
        $id                      = I('post.id');
        $m          = M('order_pm');
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

    //同意退款
    public function alreturn(){
        $id     = $_GET['id'];
        $m      = M('order_pm');
        $time   = time();//退款时间
        //支付状态pay_status 已退款2
        //同意退款关闭订单5
        //要收回货之后才能退钱 客服确定收货退款此时的订单应该是被关闭
        $Info=$m->where(array("id"=>$id))->find();
        $res = $m->where(array("id"=>$id))->setField(array("order_status"=>5,"refund_time"=>$time,"pay_status"=>2,'is_refund'=>1,'refund_fee'=>$Info['pay_price']));
        if($res){
            $data=array(
                'order_id'=>$Info['id']
            );
            $this->sendSystemMessage($Info['user_id'],"您的退款进度消息","您的订单退款已完成，请注意查收！",$data);
            $iUrl = U("Admin/Pm/orderPmList");
            echo "<script>alert('退款成功！');window.location.href='".$iUrl."';</script>";
            //$this->success("退款成功");exit;
        }else{
            $iUrl = U("Admin/Pm/orderPmList");
            echo "<script>alert('退款失败！');window.location.href='".$iUrl."';</script>";
            //$this->success("退款失败");exit;
        }
        $this->display();
    }
    //拒绝退款
    public function dereturn(){
        $id     = $_GET['id'];
        $m      = M('order_pm');
        $res = $m->where(array("id"=>$id))->find();
        //未发货的状态
        if($res['is_send'] == 0){
            //改成待发货的状态
            $result  = $m->where(array("id"=>$id))->setField(array("order_status"=>2,"is_refund"=>2));
            if($result){
                $data=array(
                    'order_id'=>$res['id']
                );
                $this->sendSystemMessage($res['user_id'],"您的退款进度消息","您的订单退款被拒绝，请注意查收！",$data);
                $iUrl = U("Admin/Pm/orderPmList");
                echo "<script>alert('取消成功！');window.location.href='".$iUrl."';</script>";
                //$this->success("取消成功");
            }else{
                $iUrl = U("Admin/Pm/orderPmList");
                echo "<script>alert('取消成功！');window.location.href='".$iUrl."';</script>";
                //$this->error("取消失败");
            }
            $this->display();
        }
        //已发货
        if($res['is_send'] == 1){
            //改成待收货的状态
            $result  = $m->where(array("id"=>$id))->setField(array("order_status"=>3,"is_refund"=>2));
            if($result){
                $data=array(
                    'order_id'=>$res['id']
                );
                $this->sendSystemMessage($res['user_id'],"您的退款进度消息","您的订单退款被拒绝，请注意查收！",$data);
                $iUrl = U("Admin/Pm/orderPmList");
                echo "<script>alert('取消成功！');window.location.href='".$iUrl."';</script>";
                //$this->success("取消成功");
            }else{
                $iUrl = U("Admin/Pm/orderPmList");
                echo "<script>alert('取消失败！');window.location.href='".$iUrl."';</script>";
                //$this->error("取消失败");
            }
            $this->display();
        }

    }

    //查看订单详情
    public function orderDetail(){
        $id    = I("get.id");  // 得到order_infolist的id
        $order = M("order_pm")->find($id);
        if(!$order){
            goback("没有此订单！");
        }
        $user        = M('member')->find($order['user_id']);
        $order['user'] = $user;



        //
        $pm = M('pm')->where(array('id'=>$order['goods_id']))->find();

        $order['logo_pic'] = $pm['logo_pic'];
        $order['goods_name'] = $pm['goods_name'];
        //物流信息
        $res = $this->getOrderTracesByJson($order['express_name'],$order['express_no']);
        $express = json_decode($res,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $order['express_name'] =  M("express")->where(array("express_ma"=>$order['express_name']))->getField("express_company");
        $this->assign("cache", $order);
        $this->assign("express", $exp);
        $this->display();
    }

    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    public  function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }

    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    public  function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if($url_info['port']=='')
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * Json方式 查询订单物流轨迹
     */
    public function getOrderTracesByJson($express,$LogisticCode){

        //jaw 2016-12-28
        //
        // $name = array(
        //     '顺丰快递'=>'SF',
        //     '申通快递'=>'STO',
        //     '韵达快递'=>'YD',
        //     '圆通速递'=>'YTO',
        //     '天天快递'=>'HHTT',
        //     '德邦'=>'DBL',
        //     'EMS'=>'EMS',
        //     '中通快递'=>'ZTO'
        // );
        $ShipperCode = $express;
        $LogisticCode = $LogisticCode;

        $EBusinessID = '1265531';
        $AppKey = '2fac2b65-0f6e-4738-abcb-52ff176ca90a';
        $ReqURL = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

        $requestData= "{'OrderCode':'','ShipperCode':'".$ShipperCode."','LogisticCode':'".$LogisticCode."'}";
        $datas = array(
            'EBusinessID' => $EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = self::encrypt($requestData, $AppKey);
        $result=self::sendPost($ReqURL, $datas);

        //根据公司业务处理返回的信息......

        return $result;
    }

    /**
     * 流拍列表
     */
    public function pmLiuList(){
        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['goods_name'] = array('like',"%$name%");
        }

        $m   = M("pm");
        $map['is_del'] = 0;
        $map['shenhe'] = 1;
        $map['paimai_zt'] = 2;

        /*商品数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0,"shenhe"=>1))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('sort asc')->limit($Page->firstRow.','.$Page->listRows)->select();
        //场次信息
        foreach ($res as $k=>$v){
            $num = M('pm_num')->where(array('id'=>$v['num_id']))->find();
            $res[$k]['num_name'] = $num['num'];
        }
        //场次信息
        $num = M('pm_num')->where(array('is_del'=>0,'end_time'=>array('gt',time())))->select();
        $this->assign("num",$num);
        //dump($num);exit;
        $this->assign("page",$show);
        $this->assign("counts", $m->where(array("isdel"=>0,"shenhe"=>1,'paimai_zt'=>2))->count());     //全部
        $this->assign("counts", $countss);//全部
        $this->assign("cache", $res);
        $this->display();
    }

    //liuXQ

    /**
     * 流拍详情
     */
    public function liuXQ(){
        $id=I('get.id');

        $m   = M("pm");
        $map['is_del'] = 0;
        $map['shenhe'] = 1;
        $map['paimai_zt'] = 2;

        $res = $m->where($map)->where(array('id'=>$id))->find();
        $res['weight'] = $res['weight']*1000;
//dump($res);exit;
        //场次信息
        $num = M('pm_num')->where(array('id'=>$res['num_id']))->find();
        $res['num_name'] = $num['num'];
        //分类信息
        $cate = M('pm_cate')->where(array('id'=>$res['series_id']))->find();
        //dump($cate);exit;
        $res['cate_name'] = $cate['classname'];

        $res['num_name'] = $num['num'];
        $this->assign("res", $res);

        $pm_slide = M("pm_slide")->where(array('goods_id'=>$id, "status"=>1))->select();
        $this->assign("pm_slide", $pm_slide);
        $this->display();
    }
    /**
     * 保定金订单列表//0：未支付，1：已支付，2：拒绝退款，3：已退款
     */
    /*public function orderPmDList(){
        //查询
        if(IS_POST){
            $telephone      = I("post.telephone");
            $person_name    = I("post.person_name");
            $order_no       = I("post.order_no");
            $starttime      = I("post.starttime");
            $endtime        = I("post.endtime");
            $this->assign('starttime',$starttime);
            $this->assign('endtime',$endtime);
            $starttime      = strtotime($starttime);
            $endtime        = strtotime($endtime);
            $this->assign('telephone',$telephone );
            $this->assign('person_name',$person_name );
            $this->assign('order_no',$order_no );

            if($starttime != null ){
                $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_pmding a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%' AND a.order_time BETWEEN '{$starttime}' AND '{$endtime}'";
            }else{
                $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_pmding a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%'";
            }
            $res = M("order_pmding")->query($sql);
            if($res){
                $this->assign('cache',$res);
            }else{
                $this->error("未找到相关数据！");
            }
        }else{
            //显示
            $status = $_GET['order_status'];
            if($status === null ){
                $count = M("order_pmding")->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $sql   = "select b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name from app_order_pmding a left join app_member b on a.user_id=b.id order by a.id desc limit"." ".$Page->firstRow.",".$Page->listRows."";
                $res = M("order_pmding")->query($sql);
                // dump($res);exit;
                //$res  = M("order_info")->alias("a")->join("app_status b on a.order_status=b.status_id")->order_info('a.id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign("page",$show);
            }else{
                $count = M("order_pmding")->where("order_status=$status")->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $sql   = "select b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name from app_order_pmding a left join app_member b on a.user_id=b.id where a.order_status=$status order by a.id desc limit"." ".$Page->firstRow.",".$Page->listRows." ";
                $res = M("order_pmding")->query($sql);
                //$res  = M("order_info")->alias("a")->join("app_order_status b on a.order_status=b.status_id")->where("a.order_status=$status")->order_info('a.id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
                $this->assign("page",$show);
            }
            $this->assign('cache',$res);
        }
//        p($res);
        $m = D('order_pmding');
        $count  = $m->count();

        $count0 = $m->where(array("order_status"=>0))->count();//未支付
        $count1 = $m->where(array("order_status"=>1))->count();//已支付
        $count2 = $m->where(array("order_status"=>2))->count();//拒绝退款
        $count3 = $m->where(array("order_status"=>3))->count();//已退款
        $this->assign("count",  $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);

        $this->display();
    }*/

    //保定金查看详情
    /*public function orderDDetail(){
        $id    = I("get.id");  // 得到order_infolist的id
        $order = M("order_pmding")->find($id);
        if(!$order){
            goback("没有此订单！");
        }
        $user        = M('member')->find($order['user_id']);
        $order['user'] = $user;
        $this->assign("cache", $order);
        $this->display();
    }*/

    /**
     * 退保定金列表0：未支付，1：已支付，2：拒绝退款，3：已退款
     */

    public function pmTuiDJin(){
        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['name'] = array('like',"%$name%");
        }

        $m   = M("order_pmding");
        $map['is_del'] = 0;
        $map['is_jieshu'] = 1;
        $map['order_status'] = array('neq',0);

        $is_sale = I("is_sale");

        $counts = $m->where($map)->count();
        /*$count2=0;
        $count3=0;
        $count4=0;
        foreach ($ress as $k=>$v){
            $pm = M('pm')->where(array('id'=>$v['goods_id']))->find();
            if($pm['end']<time()){
                if ($v['order_status']==2){
                    $count3+=1;
                }
                if ($v['order_status']==3){
                    $count4+=1;
                }
                if ($v['order_status']==1){
                    $count2+=1;
                }
                $ress[$k]['mai_id'] = $pm['mai_id'];
            }else{
                unset($ress[$k]);
            }
        }

        $countss = count($ress);*/

        //已抵扣

        $count3=$m->where(array("is_del"=>0, "status"=>2))->count();
        if($is_sale==3){
            $map['status'] = 2;
        }

        //已退款
        $count4=$m->where(array("is_del"=>0, "order_status"=>3))->count();
        if($is_sale==4){
            $map['order_status'] = 3;
        }

        // 待处理

        $count2=$m->where(array("is_del"=>0, "order_status"=>1,'retrievable_price'=>array('gt',0)))->count();
        if($is_sale==2){
            $map['order_status'] = 1;
            $map['retrievable_price'] = array('gt',0);
        }

        /*订单数量*/
        $count=$m->where($map)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('order_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        foreach ($res as $k=>$v){
            $pm = M('pm')->where(array('id'=>$v['goods_id']))->find();
            if($pm['end']<time()){
                $res[$k]['mai_id'] = $pm['mai_id'];
            }else{
                $res[$k]['mai_id'] = 0;
            }
        }

        //dump($res);
        $this->assign("page",$show);
        $this->assign("counts", $counts);//全部
        $this->assign("count2",$count2 );
        $this->assign("count3",$count3 );
        $this->assign("count4",$count4 );
        $this->assign("res", $res);
        $this->display();
    }

    /**
     * 删除保定金订单delPmDing
     */
    public function delPmDing(){
        $id  = $_GET['id'];
        $res = M("order_pmding")->where(array("id"=>$id))->save(array("is_del"=>1));
        if($res!==false){
            $iUrl = U("Admin/Pm/pmTuiDJin");
            echo "<script>alert('删除成功！');window.location.href='".$iUrl."';</script>";
            //$this->success("删除成功！");die;
        }

        $iUrl = U("Admin/Pm/pmTuiDJin");
        echo "<script>alert('删除失败！');window.location.href='".$iUrl."';</script>";
        $this->display();
        //$this->error("删除失败！");die;
    }

    /**
     * 拒绝退款disTuiDJin
     */

    /*public function disTuiDJin(){
        $id  = $_GET['id'];
        $res = M("order_pmding")->where(array("id"=>$id))->save(array("order_status"=>2));
        if($res!==false){

            $iUrl = U("Admin/Pm/pmTuiDJin");
            echo "<script>alert('拒绝退款成功！');window.location.href='".$iUrl."';</script>";
            //$this->success("拒绝退款成功！");die;
        }
        $iUrl = U("Admin/Pm/pmTuiDJin");
        echo "<script>alert('拒绝退款失败！');window.location.href='".$iUrl."';</script>";

        $this->display();
        //$this->error("拒绝退款失败！");
    }*/

    /**
     * 同意退款TuiDJin
     */

    public function TuiDJin(){
        $id  = I('post.id');
        $money  = I('post.money');
        $ding = M("order_pmding")->where(array("id"=>$id))->find();
        if($money>$ding['retrievable_price']){
            $this->ajaxReturn(array('status'=>0, "info"=>"退款金额不能大于可退款金额！"));
        }
        M()->startTrans();
        //退款流程
        $res = M("order_pmding")->where(array("id"=>$id))->save(array("order_status"=>3,'refund_price'=>$money));
        if($money>0){
            $member = M('member')->where(array('id'=>$ding['user_id']))->find();
            $ye = $member['wallet']+$money;
            $data['wallet']=$ye;
            $tui = M('member')->where(array('id'=>$ding['user_id']))->save($data);
        }else{
            $tui = true;
        }

        if ($res==true && $tui==true){
            M()->commit();
            $this->ajaxReturn(array('status'=>1, "info"=>"同意退款成功！"));
        }else{
            M()->rollback();
            $this->ajaxReturn(array('status'=>0, "info"=>"同意退款失败！"));
        }
    }

    //入驻审核列表
    public function ruzhu(){
        /*$name=I('get.name');
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['goods_name'] = array('like',"%$name%");
        }*/

        $m   = M("ruzhu");

        $is_sale = I("is_sale");


        $map['ruzhu_status']=array('gt',1);
        // 未审核

        $count3=$m->where(array("shenhe"=>1,'ruzhu_status'=>array('gt',1)))->count();
        if($is_sale==3){
            $map['shenhe'] = 1;
        }


        // 审核通过

        $count4=$m->where(array("shenhe"=>2,'ruzhu_status'=>array('gt',1)))->count();
        if($is_sale==4){
            $map['shenhe'] = 2;
        }

        //审核拒绝

        $count5=$m->where(array("shenhe"=>3,'ruzhu_status'=>array('gt',1)))->count();
        if($is_sale==5){
            $map['shenhe'] = 3;
        }

        /*入驻数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('ruzhu_status'=>array('gt',1)))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出->order('sort asc')
        $res = $m->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count3",$count3 );
        $this->assign("count4",$count4 );
        $this->assign("count5",$count5 );
        $this->assign("cache", $res);
        $this->display();
    }

    //审核通过
    public function zzagree(){
        $res = M('ruzhu')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核通过失败！"));
        }
    }

    //审核拒绝
    public function zzdisagree(){
        $res = M('ruzhu')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>3,));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    //入驻审核详情
    public function xqRuZhu(){
        $id=I('get.id');
        $m   = M("ruzhu");
        $res = $m->where(array('id'=>$id))->find();
        $this->assign("res", $res);
        $this->display();
    }

    //设置
    public function sezhi(){
        if(IS_AJAX){
            $data = I('post.');
            //dump($data);
            /*if(!$data['moban']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请上传授权书模板'));
                //alert("请上传授权书模板");return false;
            }*/
            //$data['price'] = $data['bao_price']+$data['jishu_price'];
            $res = M("ms_ruzhu")->where('id=1')->data($data)->save();
            if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'保存成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'保存失败'));
            }
        }

        $res = M('ms_ruzhu')->where('id=1')->find();
        $this->assign('res',$res);
        $this->display();

    }

    /**
     * 拍卖场次详情
     * zy
     */
    public function numDetail(){
        if (IS_AJAX){
            $num_id = I('post.num_id');
            $num = M('pm_num')->where(array('id'=>$num_id))->find();
            if ($num){
                $data['start_time'] = date('Y-m-d H:i:s',$num['start_time']);
                $data['end_time'] = date('Y-m-d H:i:s',$num['end_time']);
                $date[]['date'] = date('Y-m-d',$num['start_time']);
                if($num['is_xs']==1){
                    for ($i=1;$i<10;$i++){
                        if (($num['start_time']+$i*24*60*60)<$num['end_time']){
                            $date[]['date']= date('Y-m-d',($num['start_time']+$i*24*60*60));
                        }else{
                            break;
                        }
                    }
                }
                $this->ajaxReturn(array('status'=>1, 'info'=>$data,'date'=>$date));
            }
            $this->ajaxReturn(array('status'=>0, 'info'=>'获取场次详情失败'));
        }
    }

    public function cateList(){
        $cate = M('pm_cate')->where(array('level'=>1,'isdel'=>0))->select();
        foreach ($cate as $k=>$v){
            $cate_two = M('pm_cate')->where(array('pid'=>$v['id'],'isdel'=>0))->select();
            if($cate_two){
                $cate[$k]['two']=$cate_two;
            }
        }
        $this->assign('cate',$cate);
        $this->display();
    }

    public function setCate(){
        if (IS_AJAX) {
            $data = I('post.post');
            $data['price'] = $data['price']?$data['price']:0;
            $data['tech_price'] = $data['tech_price']?$data['tech_price']:0;
            $cate = M('pm_cate')->where(array('id'=>$data['pid']))->find();
            if ($cate['pid'] != null) {
                if ($cate['level']==1) {
                    $data['level'] = 2;
                    $data['price']=0;
                }
            } else {
                $data['level'] = 1;
            }
            if ($data['id']) {
                $cateinfo = M('pm_cate')->where(array('id'=>$data['id']))->find();
                if ($cate['pid']==0 && $cateinfo['pid'] == 0) {
                    unset($data['pid']);
                    unset($data['level']);
                }
                if ($cate['level'] == 2 && $cateinfo['level'] == 2) {
                    unset($data['pid']);
                    unset($data['level']);
                    unset($data['price']);
                }
                $res = M('pm_cate')->save($data);
            } else {
                if ($cate['pid'] != null) {
                    if ($cate['level'] == 1) {
                        $data['level'] = 2;
                        $data['price']=0;
                    }
                } else {
                    $data['level'] = 1;
                }
                $data['create_at'] = NOW_TIME;
                $res = M('pm_cate')->add($data);
            }
            if ($res) {
                $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功！'));
            } else {
                $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败！'));
            }
        }
    }

    /**
     * 删除分类
     */
    public function delCate()
    {
        $id     = I('get.id');
        $info   = M("pm_cate")->where(array('id'=>$id))->find();
        if ($info['pid'] == 0) {
            M("pm_cate")->where(array('pid'=>$id))->save(array('isdel'=>1));
        }
        $res = M('pm_cate')->where(array('id'=>$id))->save(array('isdel'=>1));
        if ($res) {
            $this->success('操作成功。');
        } else {
            $this->error('删除失败！');
        }
    }

    /**
     * 结算列表
     */
    public function settlList() {

        $type = I('get.type');
        $starttime      = trim(I("get.starttime"));
        $endtime        = trim(I("get.endtime"));
        $this->assign('starttime',$starttime);
        $this->assign('endtime',$endtime);

        if ($starttime && $endtime){
            $starttime      = strtotime($starttime.'00:00:00');
            $endtime        = strtotime($endtime.'23:59:59');
            $map[1]['s.addtime'] =array('gt',$starttime);
            $map[2]['s.addtime'] =array('lt',$endtime);
        }elseif($starttime){
            $starttime      = strtotime($starttime.'00:00:00');
            $map['s.addtime'] =array('gt',$starttime);
        }elseif($endtime){
            dump($endtime);
            $endtime        = strtotime($endtime.'23:59:59');
            $map['s.addtime'] =array('lt',$endtime);
        }

        if($type!=''){
            $map['s.is_settl'] =$type;
        }

        $count = count(M('settl as s')->join('left join app_pm as p on p.id = s.goods_id')->where($map)->select());

        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('settl as s')->join('left join app_pm as p on p.id = s.goods_id')->where($map)
            ->limit($Page->firstRow.','.$Page->listRows)
            ->field('s.*,p.goods_name')
            ->order('s.addtime desc')->select();
        $this->assign('cache',$res);

        unset($map['s.is_settl']);
        $counts = count(M('settl as s')->join('left join app_pm as p on p.id = s.goods_id')->where($map)->select());//未结算
        $map['s.is_settl'] = 0;
        $count0 = count(M('settl as s')->join('left join app_pm as p on p.id = s.goods_id')->where($map)->select());//未结算
        $map['s.is_settl'] = 1;
        $count1 = count(M('settl as s')->join('left join app_pm as p on p.id = s.goods_id')->where($map)->select());//已结算
        $this->assign("counts", $counts);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->display();
    }

    //结算
    public function settl(){
        $id     = I('get.id');
        $info  = M('settl as s')
            ->where(array('s.id'=>$id))
            ->join('left join app_ruzhu as r on r.id = s.user_id')
            ->join('left join app_member as m on m.id = r.user_id')
            ->field('s.*,m.id as userid,m.wallet')->find();

        M('settl')->startTrans();
        $res = M('settl')->where(array('id'=>$id))->save(array('is_settl'=>1,'settl_time'=>time()));

        if(!$res){
            M('settl')->rollback();
            $this->error('操作失败！');
        }else{
            $res1 = M('member')->where(array('id'=>$info['userid']))->save(array('wallet'=>($info['wallet']+$info['huode_price'])));
            if(!$res1){
                M('settl')->rollback();
                $this->error('操作失败！');
            }else{
                M('settl')->commit();
                $this->success('操作成功。');
            }
        }
    }

    //拍卖列表导出
    public function indexPmList(){
        $name=trim(I('get.name'));
        $num_num=trim(I('get.num_num'));
        //dump($name);
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['p.goods_name'] = array('like',"%$name%");
        }

        if($num_num){
            $map['n.num'] = $num_num;
            //$count2=$m->where($map)->count();
        }
        $map['p.is_del'] = 0;
        $map['p.shenhe'] = 1;

        //平台发布
        $map['p.promulgator'] = 0;
        $map['p.paimai_zt'] = array('lt',2);

        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['p.is_shang'] = 0;
            //$count2=$m->where($map)->count();
        }
        if($is_sale==1){
            $map['p.is_shang'] = 1;
            //$count1=$m->where($map)->count();
        }
        $str = "left join app_pm_num as n on n.id=p.num_id";

        $info = M("pm as p")->join($str)->where($map)->field('p.*,n.num as num_num,n.name as num_name')->order('sort asc')->select();
        //dump($orders);die();
        $name ="拍卖作品详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,第几场,专场名称,拍品名称,保留价,起拍价,保证金,加价幅度,佣金,状态";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['num_num']    = $val['num_num']?$val['num_num']:"无";
            $data['num_name']      =$val['num_name']?$val['num_name']:"无";
            $data['goods_name']  = $val['goods_name']?$val['goods_name']:"无";
            $data['baoliu']  = $val['baoliu']?$val['baoliu']:0.00;
            $data['start_price']  = $val['start_price']?$val['start_price']:0.00;
            $data['baoding']  = $val['baoding']?$val['baoding']:0.00;
            $data['fudu']  = $val['fudu']?$val['fudu']:0.00;
            $data['yongjin']  = $val['yongjin']?$val['yongjin'].'%':'0%';
            switch($val['paimai_zt']){//0：，1：，2：,3:
                case 0:
                    $data['status']="待拍卖";
                    break;
                case 1:
                    $data['status']="正在拍卖";
                    break;
                case 2:
                    $data['status']='流拍';
                    break;
                case 3:
                    $data['status']='拍卖成功';
                    break;
                default:
                    $data['status']='未知';
                    break;
            }
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";


        }

        //$this->setLog("店铺提现详情",IMG_URL.'Admin/Order/orderExport');
        exit;
    }

    //拍卖订单导出
    public function indexPmOrder(){
        $status = $_GET['order_status'];
        $telephone      = trim(I("get.telephone"));
        $person_name    = trim(I("get.person_name"));
        $order_no       = trim(I("get.order_no"));
        $starttime      = trim(I("get.starttime"));
        $endtime        = trim(I("get.endtime"));
        $this->assign('starttime',$starttime);
        $this->assign('endtime',$endtime);
        $this->assign('telephone',$telephone );
        $this->assign('person_name',$person_name );
        $this->assign('order_no',$order_no );
        /*if($starttime != null){
            $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.id,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_pm a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%' AND a.order_time BETWEEN '{$starttime}' AND '{$endtime}'";
        }else{
            //dump($telephone);die;
            $sql = "SELECT b.telephone,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.id,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name FROM app_order_pm a INNER JOIN app_member b on a.user_id=b.id  WHERE b.telephone LIKE '%{$telephone}%' AND b.person_name LIKE '%{$person_name}%' AND a.order_no LIKE '%{$order_no}%'";
            //dump($sql);die;
        }*/
        if ($telephone){
            $map['b.telephone'] = array('like',"%$telephone%");
        }


        if ($person_name){
            $map['b.person_name'] = array('like',"%$person_name%");
        }

        if ($order_no){
            $map['a.order_no'] = array('like',"%$order_no%");
        }

        if ($starttime && $endtime){
            $starttime      = strtotime($starttime.'00:00:00');
            $endtime        = strtotime($endtime.'23:59:59');
            $map[1]['a.order_time'] =array('gt',$starttime);
            $map[2]['a.order_time'] =array('lt',$endtime);
        }elseif($starttime){
            $starttime      = strtotime($starttime.'00:00:00');
            $map['a.order_time'] =array('gt',$starttime);
        }elseif($endtime){
            dump($endtime);
            $endtime        = strtotime($endtime.'23:59:59');
            $map['a.order_time'] =array('lt',$endtime);
        }

        if($status != null ){
            $map['a.order_status'] =$status;
        }else{
            $map['a.order_status'] = array('lt',5);
        }

        $info = M("order_pm a")->join('left join app_member b on a.user_id=b.id')->where($map)->field('b.telephone,a.id,a.pay_way,a.pay_time,a.pay_price,a.total_price,a.order_no,a.order_status,a.user_id,a.order_time,b.person_name')->select();
        $name ="拍卖订单详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,订单编号,用户昵称,用户电话,订单金额,实际支付,支付时间,支付类型,订单状态";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['order_no']    = $val['order_no']?$val['order_no']:"无";
            $data['person_name']      =$val['person_name']?$val['person_name']:"无";
            $data['telephone']  = $val['telephone']?$val['telephone']:"无";
            $data['goods_price']  = $val['goods_price']?$val['goods_price']:0.00;
            $data['pay_price']  = $val['pay_price']?$val['pay_price']:0.00;
            $data['pay_time']  = $val['pay_time']?date('Y-m-d H:i:s',$val['pay_time']):"无";
            switch($val['pay_way']){//0：，1：，2：,3:
                case 1:
                    $data['pay_way']="支付宝";
                    break;
                case 2:
                    $data['pay_way']="微信支付";
                    break;
                case 3:
                    $data['pay_way']='现金';
                    break;
                default:
                    $data['pay_way']='未知';
                    break;
            }
            switch($val['order_status']){
                case 0:
                    $data['order_status']="已取消";
                    break;
                case 1:
                    $data['order_status']="待付款";
                    break;
                case 2:
                    $data['order_status']="待发货";
                    break;
                case 3:
                    $data['order_status']='待收货';
                    break;
                case 4:
                    $data['order_status']='已签收';
                    break;
                case 5:
                    $data['order_status']='已关闭';
                    break;
                case 6:
                    $data['order_status']='退款中';
                    break;
                default:
                    $data['order_status']='未知';
                    break;
            }
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";


        }

        //$this->setLog("店铺提现详情",IMG_URL.'Admin/Order/orderExport');
        exit;
    }

    //出价记录导出
    public function indexoffer(){
        $pm_id=I('get.id');
        $str = "left join app_member as m on m.id=c.user_id";
        $info_pm = M("pm")->where(array('id'=>$pm_id))->find();
        $info = M("chujia as c")->join($str)->where(array('goods_id'=>$pm_id))->field('c.*,m.person_name,m.telephone')->order('time desc')->select();
        $name ="出价记录详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,拍品名称,用户昵称,手机号,出价,出价时间";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['goods_name']    = $info_pm['goods_name']?$info_pm['goods_name']:"无";
            $data['person_name']      =$val['person_name']?$val['person_name']:"无";
            $data['telephone']  = $val['telephone']?$val['telephone']:"无";
            $data['jiage']  = $val['jiage']?$val['jiage']:0.00;
            $data['time']  = $val['time']?date('Y-m-d H:i:s',$val['time']):"无";

            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    //设置入驻拍卖协议
    public function protocol(){
        if (IS_POST) {
            $edit_notice = M("protocol");
            //print_r($_POST);exit;
            $count = $edit_notice->count();

            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Pm/protocol', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Pm/protocol', '', false));exit;
                }
            }else{

                $result  = $edit_notice->where(array('id'=>1))->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Pm/protocol', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Pm/protocol', '', false));exit;
                }
            }
        }

        $res = M("protocol")->where(array('id'=>1))->find();
        $this->assign('res',$res);
        $this->display();
    }

    /**
     * 流拍品上架
     */
    public function lpnum(){
        if(IS_AJAX){
            $id   = I("post.id");
            $num_id = I('post.num_id');
            $type = I('post.type');
            $m    = M("pm");
            $res  = $m->where(array("id"=>$id))->find();
            $num  = M('pm_num')->where(array("id"=>$num_id))->find();
            if(!$res || !$num){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"上架失败！"));
            }
            /* if ($res['end']<time()){
                 $this->ajaxReturn(array("status"=>0 ,"info"=>"拍品结束时间不能小于当前时间！"));
             }*/

            //时间判断
            /*$num = M('pm_num')->where(array('id'=>$num_id))->find();
            if ($res['start']<$num['start_time']){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"拍品开始时间不能小于场次开始时间！"));
            }*/

            /*if ($res['end']>$num['end_time']){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"拍品结束时间不能大于场次结束时间！"));
            }*/


            $data['shang_time'] = time();

            $data['num_id'] = $num_id;
            $data['is_shang'] = 1;
            $data['paimai_zt'] = 0;

            if($type==1){
                $date = I('post.date');
                $xiaoshi = I('post.xiaoshi');
                $data['start'] =strtotime($date.$xiaoshi);
                if ($xiaoshi=="14:00:00"){
                    $data['end'] = $data['start']+1*60*60;
                }else{
                    $data['end'] = $data['start']+2*60*60;
                }
            }else{
                $data['start'] =$num['start_time'] ;
                $data['end'] =$num['end_time'] ;
            }
            $res2 = $m->where(array("id"=>$id))->save($data);
            if($res2){
                $this->ajaxReturn(array("status"=>1,"info"=>"上架成功！"));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"上架失败！"));
        }
    }
}