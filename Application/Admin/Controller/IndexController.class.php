<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Controller\CommonController;
class IndexController extends CommonController {
    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function index(){

        $this->display();
    }

    /*修改密码*/

    public function updatepwd(){
        if(IS_AJAX){
            $oldpass = I('post.id');
            //var_dump($_SESSION);die;
            $id = $_SESSION['admin_id'];
            $pas = M('User')->where(array('isdel'=>0,'is_open'=>1,'id'=>$id))->getField('password');
            //var_dump(   $pas);die;
            if($pas != md5($oldpass)){
                $this->ajaxReturn(array('status'=>0,'info'=>'旧密码输入不正确'));
            }
            $this->ajaxReturn(array('status'=>1));
        }
        $action=D('User');
        $pass=I('post.password');
        if($pass){
            $md5_pass=md5($pass);
            $re=$action->where("username='".$_SESSION['admin']."'")->setField('password',$md5_pass);
            if($re){
                $this->success('修改成功',U('/Admin/Index/index'));die;
            }else{
                $this->error('修改失败');die;
            }
        }
        $this->assign('munetype',9);
        $this->display('updatepwd');
    }

    /*广告列表*/

    public function banner(){

        $type=I('get.type');
        // $name = I('get.class_name');
        if($type){
            $where['b.type'] = $type;
            $this->assign('type',$type);
        }
        // if($name){
        //     $where['bt.classname'] = array('like',"%$name%");
        //     $this->assign('name',$name);
        // }
        $where['b.isdel'] = 0;
        $where['bt.isdel'] = 0;
        $action=M('banner');
        $count=$action->join('as b LEFT JOIN app_bannertype as bt ON b.type=bt.id')->where($where)->count();
        $p  = getpage($count,10);
        $page  = $p->show();//分页显示输出
        $this->page=$page;
        $result=$action->join('as b LEFT JOIN app_bannertype as bt ON b.type=bt.id')
            ->where($where)
            ->field('bt.classname,b.tel_pic,b.pic,b.url,b.tel_url,b.title,b.title1,b.type,b.id,b.content')
            ->order('b.type asc')->limit($p->firstRow.','.$p->listRows)->select();


        foreach($result as $k=>$v){
            $result[$k]["pic"] = "/".trim(trim($v["pic"],"."),"/");
        }


        $bannertype=M('bannertype');
        $bannertypelist=$bannertype->where(array('isdel'=>0))->field("id,classname")->select();

        $this->assign('bannertypelist',$bannertypelist);

        $count=count($result);
        $this->assign('piclist', $result);
        $this->assign('count', $count);
        $this->display();
    }
    /**
     * 删除广告列表
     */
    public function delBanner(){
        $id = I("id");
        $m  = M("banner");
        $data = $m->find($id);
        if(!$data){
            $this->error("分类不存在!");
        }
        if($data['pid']){
            $res = $m->where(array("id"=>$id))->setField("isdel", 1);
            if($res){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }
        // else{
        //     $res1 = $m->where(array("id"=>$id))->setField("isdel", 1);
        //     $res2 = $m->where(array("pid"=>$id))->setField("isdel", 1);
        //     $res3 = M('banner')->where(array("type"=>$id))->setField("isdel", 1);
        //     if($res1!==false && $res2!==false){
        //         $this->success("删除成功！");die;
        //     }else{
        //         $this->error("删除失败！");
        //     }
        // }
    }


    /**
     * 添加广告
     *
     * @author Chandler_qjw  ^_^
     */
    public function addpic(){
        if(IS_AJAX){
            $action=M('banner');
            $type=I('post.type');
            $pic=I('post.pic');
            $url=I('post.url');
            $title=I('post.title');
            $title1=I('post.title1');
            $tel_pic=I('post.tel_pic');
            $content   = I("post.content");
            $tel_url = I("post.tel_url");
            if(!$type || !$pic){
                $this->ajaxReturn(array("status"=>0,"info"=>"缺少参数"));
            }
            $data["pic"] = $pic;
            $data['content']   = $content;
            $data["tel_pic"] = $tel_pic;
            $data["type"] = $type;
            $data["url"] = $url;
            $data["title"] = $title;
            $data["title1"] = $title1;
            $data["tel_url"] = $tel_url;
            $result=$action->add($data);
            if($result){
                $this->ajaxReturn(array("status"=>1,"info"=>"添加成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,"info"=>"添加失败"));
            }
        }
    }

    /**
     * 修改广告
     *
     * @author Chandler_qjw  ^_^
     */
    public function editpic(){
        if(IS_AJAX){
            $action=M('banner');
            $title=I('post.title');
            $title1=I('post.title1');
            $type=I('post.type');
            $id=I('post.id');
            $pic=I('post.pic');
            $url=I('post.url');
            $tel_pic=I('post.tel_pic');
            $content   = I("post.content");
            $tel_url = I("post.tel_url");
            if(!$type || !$id || !$pic){
                $this->ajaxReturn(array("status"=>0,"info"=>"缺少参数"));
            }
            $data["pic"] = $pic;
            $data['content']   = $content;
            $data["tel_pic"] = $tel_pic;
            $data["type"] = $type;
            $data["url"] = $url;
            $data["title"] = $title;
            $data["title1"] = $title1;
            $data["tel_url"] = $tel_url;
            $result=$action->where(array("id"=>$id))->save($data);
            if($result){
                $this->ajaxReturn(array("status"=>1,"info"=>"修改成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,"info"=>"修改失败"));
            }
        }
    }



    /**
     * 删除广告
     *
     * @author Chandler_qjw  ^_^
     */
    public function delpic(){
        $picid=I('get.id');
        $action=M('banner');
        if(!empty($picid)){

            $arr=$action->where('id='.$picid)->find();
            //$result=$action->where('id='.$picid)->delete();

            // if($result){
            //     if($arr['classid']==1){
            //         $this->success('删除成功');exit;
            //     }else{
            //         $this->success('删除成功');exit;
            //     }
            // }else{
            //     $this->error('删除失败');
            // }
            // 
            // 
            $res = $action->where(array("id"=>$picid))->setField("isdel", 1);
            if($res){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }
    }


    /**
     * 广告分类列表
     */
    public function bannertype(){
        $m   = M("bannertype");
        $count = $m->where(array("pid"=>0, "isdel"=>0))->count();
        $p = getpage($count, 10);
        $page  = $p->show();//分页显示输出
        $this->page=$page;
        $res = $m->where(array("pid"=>0, "isdel"=>0))->order("sort desc")->limit($p->firstRow.','.$p->listRows)->select();
        $bannertype = $m->where(array("pid"=>0, "isdel"=>0))->order("sort desc")->field("id,classname")->select();
        foreach($res as $k=>$v){
            $res[$k]["data"] = $m->where(array("pid"=>$v['id'], "isdel"=>0))->select();
        }
        $this->assign("cache", $res);
        $this->assign("bannertype",  $bannertype);
        $this->display();
    }

    /**
     * 增加广告分类
     */
    public function addBannertype(){
        if(IS_AJAX){
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $m = M("bannertype");
            $res = $m->where(array("classname"=>$classname, "pid"=>$pid, "isdel"=>0))->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $data['create_at'] = time();
            $pic && $data['pic'] = $pic;
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array("status"=>1, "info"=>"增加成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"新增失败！"));
            }
        }
    }

    /**
     * 删除广告分类
     */
    public function delBannertype(){
        $id = I("id");
        $m  = M("bannertype");
        $data = $m->find($id);
        if(!$data){
            $this->error("分类不存在!");
        }
        if($data['pid']){
            $res = $m->where(array("id"=>$id))->setField("isdel", 1);
            if($res){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }else{
            $res1 = $m->where(array("id"=>$id))->setField("isdel", 1);
            $res2 = $m->where(array("pid"=>$id))->setField("isdel", 1);
            $res3 = M('banner')->where(array("type"=>$id))->setField("isdel", 1);
            if($res1!==false && $res2!==false){
                $this->success("删除成功！");die;
            }else{
                $this->error("删除失败！");
            }
        }
    }

    /**
     * 编辑广告分类
     */
    public function editBannertype(){
        if(IS_AJAX){
            $id        = I("post.bannertypegoryid");
            $classname = I("post.classname");
            $pid       = I("post.fid");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $m = M("bannertype");
            $map = array(
                "classname" => $classname,
                "pid"       => $pid,
                "id"        => array("neq", $id),
                "isdel"     => 0,
            );
            $res = $m->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $parid = $m->where(array("id"=>$id, "isdel"=>0))->getField("pid");
            if($parid == 0 && $pid != 0){
                $this->ajaxReturn(array("status"=>0, "info"=>"顶级分类无法改变分类！"));
            }
            $data['classname'] = $classname;
            $data['pid']       = $pid;
            $data['sort']      = $sort;
            $pic && $data['pic'] = $pic;
            $res = $m->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
            }
        }
    }

    /**
     * 官网配置详情Jaw
     */
    public function indexConfig(){

        if(IS_POST){
            $data = I('post.');
            $res = M('IndexConfig')->where('id=1')->save($data);
            if($res !== false){
                $this->redirect('Admin/Index/Indexconfig');exit;
            }else{
                $this->error("保存失败！",U('Admin/Index/Indexconfig'));
            }
        }
        $res = M("IndexConfig")->where(array('id'=>1))->find();
        $this->assign("cache",$res);
        $this->assign('left_urlname', ACTION_NAME);
        $this->display();
    }

    /*删除多条记录限时抢购列表*/
    public function delallbanner(){

        if(IS_POST){
            $id = I('post.id');
            $arr = explode('_',$id);
            $newsid = array_filter($arr);
            foreach ($newsid as $key => $vo) {
                $del = M('banner')->where(array('id'=>$vo))->delete();
            }
            if($del){
                $result = array('status'=>1, 'info'=>'删除成功');
                echo json_encode($result);exit;
            }
        }
    }

    public function seoConfig(){
        $m = M('seo_config');
        $res = $m->find(1);
        $this->assign("cache", $res)->display();
    }

    public function seoChange(){
        if(IS_AJAX){
            $data['url']         = I("post.url");
            $data['logo']        = I("post.logo");
            $data['logo1']        = I("post.logo1");
            $data['title']       = I("post.title");
            $data['keywords']    = I("post.keywords");
            $data['description'] = I("post.description");
            $data['copyright']   = I("post.copyright");
            $data['tel']   = I("post.tel");
            $data['address']   = I("post.address");
            $data['qq'] = I('post.qq');
            $data['weixin'] = I('post.weixin');
            $data['weibo'] = I('post.weibo');
            if(!$data['weixin']){
                unset($data['weixin']);
            }
            if(empty($data['logo'])){
                unset($data['logo']);
            }
            if(empty($data['logo1'])){
                unset($data['logo1']);
            }
            if(!preg_match("/(http|https):\/\/[\w\-_]+(\.[\w\-_]+)+/i", $data['url'])){
                $this->ajaxReturn(array("status"=>0,"info"=>"网站网址格式错误！"));
            }
            if(empty($data['title'])){
                $this->ajaxReturn(array("status"=>0,"info"=>"SEO标题不能为空！"));
            }
            if(empty($data['keywords'])){
                $this->ajaxReturn(array("status"=>0,"info"=>"SEO关键字不能为空！"));
            }
            if(empty($data['description'])){
                $this->ajaxReturn(array("status"=>0,"info"=>"SEO描述不能为空！"));
            }
            if(empty($data['copyright'])){
                $this->ajaxReturn(array("status"=>0,"info"=>"版权不能为空！"));
            }




            $res = M("seo_config")->where(array('id'=>1))->save($data);
            if($res!==false){
                $this->ajaxReturn(array("status"=>1,"info"=>"修改成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,"info"=>"修改失败！"));
            }
        }
    }







    /*wzz
     * 运费规则配置
     */
    public function freightfee(){
        $cache=M('freight_config')->where(array('is_del'=>0))->order('sort desc')->select();

        $cityAll=M('region')->where(array('region_type'=>1))->select();

        foreach($cache as $key=>$val)
        {
            $cache[$key]['region_name'] = M('frei_link_region')->alias('a')->join(' LEFT JOIN app_region as b ON a.region_id=b.id ')->where(array('a.freight_id'=>$val['id'],'a.status'=>1))->getField('region_name',true);
            $cache[$key]['region_name']=implode('-',$cache[$key]['region_name']);
        }

        $this->assign('cityAll',$cityAll);
        $this->assign('count',count($cache));

        $this->assign('cache',$cache);
        $this->display();
    }

    /**wzz
     * 添加/编辑运费规则
     */
    public function addfreightfee(){
        if(IS_AJAX){

            $action=M('freight_config');

            $id=I('post.id');
            $first_price=I('post.first_price');
            $next_price=I('post.next_price');
            $ratio=I('post.ratio');
            $sort=I('post.sort');


            if(!$first_price || !$next_price){
                $this->ajaxReturn(array("status"=>0,"info"=>"缺少参数"));
            }
            $data["first_price"] = $first_price;
            $data["next_price"] = $next_price;
            $data["ratio"] = $ratio;
            $data["sort"] = $sort;
            $data['create_at']=time();

            if($id){
                $res =$action->where(array('id'=>$id))->save($data);
            }else{
                $res = $action->add($data);
            }
            if($res){
                $this->ajaxReturn(array("status"=>1,"info"=>$id?"修改成功！":"添加成功！",'url'=>U('Admin/Index/freightfee')));
            }else{
                $this->ajaxReturn(array("status"=>0,"info"=>$id?"修改失败！":"添加失败！"));
            }
        }
    }

    /**wzz
     * 删除运费规则
     */
    public function delfreightfee()
    {
        if (IS_POST) {
            $id = I('post.id');
            $arr = explode('_', $id);
            $newsid = array_filter($arr);
            foreach ($newsid as $key => $vo) {
                $del = M('freight_config')->where(array('id' => $vo))->delete();
            }
            if ($del) {
                $this->ajaxReturn(array("status" => 1, "info" => "删除成功"));
            } else {

                $this->ajaxReturn(array("status" => 0, "info" => "删除失败"));
            }
        }
    }


    /*wzz
     * 获取当前规则的省份
     * */
    public function getcity(){
        $id=I("post.id");
        $city=M('frei_link_region')->field('freight_id,region_id')->select();                                                    //已经选择过的省份;;


        foreach($city as $key =>$val)
        {
            $cityoall[$key]=$val['region_id'];               //全部被选择的
            if($val['freight_id']==$id){
                $city_now[]=$val['region_id'];               //此规则选择的
            }
        }
        $cityold=array_diff($cityoall,$city_now);            //除此规则被选择的
        $this->assign('cityold',$cityold);               //除此规则被选择的                禁用
        $this->assign('city_now',$city_now);             //此规则选择的            chencked

    }

    /*添加城市*/

    public function addcity()
    {
        if (IS_AJAX) {
            $m=M("frei_link_region");
            $id = I("post.id");
            $cityid = I("post.city");

            $res=M('frei_link_region')->where(array('freight_id'=>$id))->select();          //取出关联表的数据
            //dump($res);
            foreach($res as $key =>$val)
            {
                $ress[]=$val['region_id'];
                if($val['status']==0)
                {
                    $res0[]=$val['region_id'];
                }elseif($val['status']==1){
                    $res1[]=$val['region_id'];
                }
            }

            $resdif=array_diff($ress,$cityid);
            foreach($cityid as $k =>$v)
            {
                if(in_array($v,$res0)){
                    $m->where(array('freight_id'=>$id,'region_id'=>$v))->setField('status',1);
                    continue;
                }elseif(in_array($v,$res1)){
                    continue;
                }else{
                    $data=array(
                        'freight_id'=>$id,
                        'region_id'=>$v
                    );
                    $m->add($data);
                    continue;
                }
            }

            foreach($resdif as $ke=>$va)
            {
                $m->where(array('freight_id'=>$id,'region_id'=>$va))->setField('status',0);
            }

            $this->ajaxReturn(array("status"=>1,"info"=>"操作成功"));

        }
    }
    public function contact(){
        if(IS_AJAX){
//            $data['gs'] = I('post.gs');
//            $data['touch'] = I('post.touch');
//            $data['service'] = I('post.service');
//            $data['address'] = I('post.address');
            $data = I('post.');
            $res = M("Touch")->where('id=1')->data($data)->save();
            if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
            }
        }
        $touch = M('Touch')->where('id=1')->find();
        $this->assign('cache',$touch);
        $this->display();
    }
    /**
     * 视屏列表
     */
    public function Video(){
        $av = M('av')->alias('a')
            ->join('left join app_video_cate b on a.cate=b.id')
            ->field('a.*,b.name')
            ->select();
        $this->assign('cache',$av);
        $this->display();
    }
    /**
     * 设置
     */
    public function setVideo(){
        if(IS_AJAX){
            $input = I('get.video');
            $output = I('get.picture');
            echo "Converting $input to $output<br />";
            $command = "ffmpeg -v 0 -y -i $input -vframes 1 -ss 5 -vcodec mjpeg -f rawvideo -s 286x160 -aspect 16:9 $output ";
            echo "$command<br />";
            shell_exec( $command );
            return "Converted<br />";
        }
        $id = I('get.id');
        if(IS_POST){
            $data['title'] = I('post.av_title');
            $data['url'] = I('post.video');
            $data['video_name'] = I('post.video_name');
            $data['sort'] = I('post.sort');
            $data['cate'] = I('post.cate');
            dd($_POST);
            if(I('post.logo_pic'))
            {
                $data['pic'] = I('post.logo_pic');
            }
            $id = I('post.id');
            //var_dump($data);die;
            if($id){
                if(!$data['url']){
                    unset($data['url']);
                }
                $data['id'] = $id;
                $res = M('av')->save($data);
            }else{
                $res = M('av')->add($data);
            }
            if($res){
                $this->redirect('/admin/index/Video');
            }else{
                $this->error('操作失败','/admin/index/Video');
            }
        }
        $res = M('video_cate')->select();
        $this->assign('res',$res);
        $av = M('av')->find($id);
        $this->assign('cache',$av);
        $this->display();
    }

    public function convertToFlv() {

    }
    /**
     * 删除
     */
    public function delVideo(){
        $id = I('post.id');
        if(!$id){
            $this->ajaxReturn(array('status'=>0, 'info'=>'参数有误'));
        }
        $res = M('av')->delete($id);
        if(!$id){
            $this->ajaxReturn(array('status'=>0, 'info'=>'删除失败'));
        }else{
            $url = M('av')->where(array('id'=>$id))->getField('url');
            $url = '.'.$url;
            unlink($url);
            $this->ajaxReturn(array('status'=>1, 'info'=>'删除成功'));
        }
    }
    /*
    * 视频分类
    */
    public function VideoCate(){
        if(IS_AJAX){
            $id = I("post.id");
            $data['name'] = I("post.name");
            $data['sort'] = I("post.sort");
            if(!$id){
                $data['add_time'] = time();
                $res = M("video_cate")->add($data);
            }else{
                $res = M("video_cate")->where(array('id'=>$id))->save($data);
            }
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>$id?'修改成功！':'添加成功！'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'操作失败！'));
            }
        }
        $res = M('video_cate')->select();
        $this->assign('res',$res);
        $this->display();
    }
    /*
     * 底部导航栏
     */
    public function footercate(){
        $res = M('footer_cate')->select();
        $this->assign('res',$res);
        $this->display();
    }

    public function addFooterCate(){
        $data = I('post.');
        $res = M('footer_cate')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'添加成功！'));die;
            //$this->success('添加成功',U('/Admin/Index/footercate'));die;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'添加失败！'));die;
            //$this->error('添加失败');
        }
    }

    public function editFooterCate(){
        $data = I('post.');
        $res = M('footer_cate')->where(array('id'=>$_POST['id']))->save($data);
        if($res){
            $this->success('修改成功',U('/Admin/Index/footercate'));die;
        }else{
            $this->error('修改失败');die;
        }
    }

    public function delFooterCate(){
        $res = M('footer_cate')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->success('删除成功',U('/Admin/Index/footercate'));die;
        }else{
            $this->error('删除失败');die;
        }
    }


    public function footerservice(){

        $count=M('footer_service')->count();
        $p=getpage($count,10);
        $page=$p->show();
        $ser = M('footer_service')->order('id desc')->limit($p->firstRow,$p->listRows)->select();
        foreach ($ser as $k=>$v){
            $rel = M('footer_cate')->where(array('id'=>$v['cate']))->find();
            $ser[$k]['name'] = $rel['name'];
        }
        $this->assign('ser',$ser);
        $this->assign('page',$page);
        $this->display();
    }
    public function fservice(){
        $res = M('footer_cate')->select();
        $this->assign('res',$res);
        $footer = M('footer_service')->where(array('id'=>$_GET['id']))->find();
        $this->assign('footer',$footer);
        $this->display();
    }
    public function addFooterService(){
        $data = I('post.');
        /*if (!$data['content']){
            $this->ajaxReturn(array('status'=>0,'info'=>'请填写内容！'));die;
        }*/
        $data['create_time'] = strtotime(date("Y-m-d"));
        $res = M('footer_service')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'添加成功！'));die;
            //$this->success('添加成功',U('/Admin/Index/footerservice'));die;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'添加失败！'));die;
            //$this->error('添加失败');die;
        }
    }

    public function eservice(){
        $res = M('footer_cate')->select();
        $this->assign('res',$res);

        $rel = M('footer_service')->where(array('id'=>$_GET['id']))->find();
        $this->assign('r',$rel);
        $this->display();
    }

    public function editFooterService(){
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        $data['is_show'] = $_POST['is_show'];
        $data['cate'] = $_POST['cate'];
        $data['create_time'] = strtotime(date("Y-m-d"));
        /*if (!$data['content']){
            $this->ajaxReturn(array('status'=>0,'info'=>'请填写内容！'));die;
        }*/
        $res = M('footer_service')->where(array('id'=>$_POST['id1']))->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'修改成功！'));die;
            //$this->success('修改成功',U('/Admin/Index/footerservice'));die;
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'修改失败！'));die;
            //$this->error('修改失败');die;
        }
    }

    public function delFooterService(){
        $res = M('footer_service')->where(array('id'=>$_GET['id']))->delete();
        if($res){
            $this->success('删除成功',U('/Admin/Index/footerservice'));die;
        }else{
            $this->error('删除失败');die;
        }
    }

    //留言列表

    public function liuyanList(){
        $m   = M("liuyan");
        $map['is_del'] = 0;

        $is_sale = I("is_sale");

        // 未处理

        $count1=$m->where(array("is_del"=>0,'is_chuli'=>0))->count();
        if($is_sale==1){
            $map['is_chuli'] = 0;
            //$count1=$m->where($map)->count();
        }

        // 已处理

        $count2=$m->where(array("is_del"=>0,'is_chuli'=>1))->count();
        if($is_sale==2){
            $map['is_chuli'] = 1;
            //$count2=$m->where($map)->count();
        }

        /*数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出->order('sort asc')
        $res = $m->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count1",$count1 );
        $this->assign("count2",$count2 );
        $this->assign("cache", $res);
        $this->display();
    }

    //留言详情
    public function liuyanXQ(){
        $id=I('get.id');
        $m   = M("liuyan");
        $res = $m->where(array('id'=>$id))->find();
        $this->assign("res", $res);
        $this->display();
    }



    //留言处理
    public function chuli(){
        if (IS_AJAX){
            $data = I('post.');
            if ($data['lx']==1){
                $res1 = M('liuyan')->where(array('id'=>$data['id']))->save(array('is_chuli'=>1));
                if($res1){
                    $this->ajaxReturn(array('status'=>1, 'info'=>'处理成功'));
                }else{
                    $this->ajaxReturn(array('status'=>0, 'info'=>'处理失败'));
                }
            }

            if ($data['lx']==0){
                $res2 = M('liuyan')->where(array('id'=>$data['id']))->save(array('is_del'=>1));
                if($res2){
                    $this->ajaxReturn(array('status'=>1, 'info'=>'删除成功'));
                }else{
                    $this->ajaxReturn(array('status'=>0, 'info'=>'删除失败'));
                }
            }
        }
    }

    /*
     * 访问记录
     */
    public function visitLog()
    {
        $data  = M('visit_log');
        $count = $data->count();

        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出->order('sort asc')
        $res = $data->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();

        $this->assign("page",$show);
        $this->assign("counts", $count);//全部
        $this->assign("data", $res);
        $this->display();
    }

    //招聘列表
    public function joinList(){
        $m   = M("join");
        $map['is_del'] = 0;

        $is_sale = I("is_sale");

        // 未发布

        $count1=$m->where(array("is_del"=>0,'join_status'=>0))->count();
        if($is_sale==1){
            $map['join_status'] = 0;
            //$count1=$m->where($map)->count();
        }

        // 发布中

        $count2=$m->where(array("is_del"=>0,'join_status'=>1))->count();
        if($is_sale==2){
            $map['join_status'] = 1;
            //$count1=$m->where($map)->count();
        }

        // 终止

        $count3=$m->where(array("is_del"=>0,'join_status'=>2))->count();
        if($is_sale==3){
            $map['join_status'] = 2;
            //$count2=$m->where($map)->count();
        }

        /*数量*/
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count1",$count1 );
        $this->assign("count2",$count2 );
        $this->assign("count3",$count3 );
        $this->assign("cache", $res);
        $this->display();
    }

    //添加职位
    public function addJoin(){
        if (IS_AJAX){
            $data = I('post.');

            if(!$data['join_pic']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传图片！';
                $this->ajaxReturn($dataAj);die;
            }
            if(!$data['responsibility']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写岗位职责！';
                $this->ajaxReturn($dataAj);die;
            }


            if(!$data['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写职位简介！';
                $this->ajaxReturn($dataAj);die;
            }
            $m      = M("join");
            $data['add_time'] = time();
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增职位成功！';
                $this->ajaxReturn($dataAj);
            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '新增职位失败！';
                $this->ajaxReturn($dataAj);
            }

        }
        $this->display();
    }

    //编辑职位
    public function editJoin(){
        if (IS_AJAX){
            $data = I('post.');
            if(!$data['responsibility']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写岗位职责！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data['detail']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写职位简介！';
                $this->ajaxReturn($dataAj);die;
            }
            $id                 = $data['id'];
            if (!$id){

                $dataAj['status'] = 0;
                $dataAj['info'] = '缺少参数！';
                $this->ajaxReturn($dataAj);
            }
            $m      = M("join");
            $res = $m->where(array("id"=>$id,'isdel'=>0))->save($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '修改职位成功！';
                $this->ajaxReturn($dataAj);
            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '修改职位失败！';
                $this->ajaxReturn($dataAj);
            }

        }

        $id = I("id");
        if (!$id) {
            echo "<script>alert('缺少参数！');window.history.back();</script>";
        }
        $res = M("join")->where(array('id'=>$id, "is_del"=>0))->find();
        if (!$res) {
            echo "<script>alert('无此职位！');window.history.back();</script>";
        }

        $this->assign("res", $res);
        $this->display();
    }

    //职位处理
    public function chuliJoin(){
        if (IS_AJAX){
            $data = I('post.');
            if ($data['lx']==1){
                $res1 = M('join')->where(array('id'=>$data['id']))->save(array('join_status'=>1,'join_time'=>time()));
                if($res1){
                    $this->ajaxReturn(array('status'=>1, 'info'=>'发布成功'));
                }else{
                    $this->ajaxReturn(array('status'=>0, 'info'=>'发布失败'));
                }
            }

            if ($data['lx']==2){
                $res1 = M('join')->where(array('id'=>$data['id']))->save(array('join_status'=>2));
                if($res1){
                    $this->ajaxReturn(array('status'=>1, 'info'=>'终止成功'));
                }else{
                    $this->ajaxReturn(array('status'=>0, 'info'=>'终止失败'));
                }
            }

            if ($data['lx']==0){
                $res2 = M('join')->where(array('id'=>$data['id']))->save(array('is_del'=>1));
                if($res2){
                    $this->ajaxReturn(array('status'=>1, 'info'=>'删除成功'));
                }else{
                    $this->ajaxReturn(array('status'=>0, 'info'=>'删除失败'));
                }
            }
        }
    }

    //申请
    public function shenqing(){
        $id=I('get.id');
        $m   = M("join");
        $ress = $m->where(array('id'=>$id))->find();
        $this->assign("ress", $ress);

        $count = M('resume as r')->join('app_member as m on r.member_id = m.id')->where(array('r.join_id'=>$id,'r.is_del'=>0))->count();
        $this->assign("counts", $count);
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $res = M('resume as r')->join('app_member as m on r.member_id = m.id')->where(array('r.join_id'=>$id,'r.is_del'=>0))->limit($Page->firstRow.','.$Page->listRows)->order('r.addtime desc')->field('r.*,m.telephone,m.realname,m.sex')->select();
        $this->assign("res", $res);

        $this->display();
    }

    //删除申请
    public function delShen(){
        $data = I('post.');
        $res = M('resume')->where(array('id'=>$data['id']))->save(array('is_del'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, 'info'=>'删除成功'));
        }else{
            $this->ajaxReturn(array('status'=>0, 'info'=>'删除失败'));
        }
    }

    //合作伙伴
    public function partner(){
        /*if(IS_AJAX){
            $data['pic'] = I('post.pic');
            $data['']
        }*/
        $res = M('partner')->order('sort asc')->select();
        /*foreach($res as $k=>$v){
            $res[$k]['info'] = $v;
        }*/
        $count = count($res);
        $this->assign('res',$res);
        $this->assign('count',$count);
        $this->display();
    }

    public function addPartner(){
        $data = I('post.');
        $data['addtime'] = time();
        $res = M('partner')->add($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'添加成功！'));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'添加失败！'));
        }
    }

    public function editPartner(){
        $id = I('post.id');
        $data['pic'] = I('post.pic');
        $data['name'] = I('post.name');
        $data['sort'] = I('post.sort');
        $data['url'] = I('post.url');
       // print_r($_POST);exit;
        $res = M('partner')->where(array('id'=>$id))->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'编辑成功！'));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'编辑失败！'));
        }
    }

    public function delPartner(){
        $id = I('post.id');
        $res = M('partner')->where(array('id'=>$id))->delete();

        if($res){
            $this->ajaxReturn(array('status'=>1,'info'=>'删除成功！'));
        }else{
            $this->ajaxReturn(array('status'=>0,'info'=>'删除失败！'));
        }
    }
}

