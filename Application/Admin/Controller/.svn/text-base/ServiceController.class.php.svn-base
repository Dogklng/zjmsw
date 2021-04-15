<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class ServiceController extends CommonController {

    public function _initialize(){
        parent::_initialize();
        $this->assign("munetype",7);
    }

    public function index(){
        $cache  = M('service')->find();
        if(IS_POST){
            $id = I('post.id');
            $data['company_name'] = I('post.company_name');
            $data['address'] = I('post.address');
            $data['phone'] = I('post.phone');
            $data['phone2'] = I('post.phone2');
            $data['fax'] = I('post.fax');
            $data['url'] = I('post.url');
            $data['email'] = I('post.email');
            $data['mphone'] = I('post.mphone');
            $data['sphone'] = I('post.sphone');
            $data['fphone'] = I('post.fphone');
            $data['tphone'] = I('post.tphone');
            $data['zphone'] = I('post.zphone');
            //$data['codepic'] = I('post.pic');
            $res = M('contact')->where(array('id'=>$id))->save($data);

            if($res){
                $this->success('保存成功！',U('/Admin/Service/index'));exit;
            }else{
                $this->error('保存失败！');exit;
            }
        }

        $this->assign('cache',$cache);
        parent::_initialize();
        $this->assign("service",1);
        $this->display();
    }

    //·þÎñÐÅÏ¢ÁÐ±í
    public function service(){
        $m = M('service');
        $count=$m->count();
        $p  = getpage($count,10);
        $page  = $p->show();//分页显示输出
        $this->page=$page;
        $info = $m->order('type asc,sort asc,id asc')->limit($p->firstRow.','.$p->listRows)->select();
        $this->assign('info',$info);
        parent::_initialize();
        $this->assign("service",2);
        //$this->assign("page",  $info['page']);
        $this->display();
    }



    /**
     * Ìí¼Ó·þÎñÐÅÏ¢
     */
    public function addservice(){

        if(IS_POST){
            $data['title'] = I('post.title');
            $data['sort'] = I('post.sort');
            $data['content'] = I('post.content');
            $data['addtime'] = date("Y-m-d H:i:s");
            if(I('post.pic')){
                $data['img'] = I('post.pic');
            }
            $data['digest'] = $_POST['digest'];
            $data['type'] = I('post.type');

            $rs=M('service')->add($data);
            if($rs){
                $this->success('添加成功！',U('/Admin/Service/service'));exit;
            }else{
                $this->error('添加失败！');exit;
            }

        }

        $this->assign("service",2);
        $this->display();
    }

    /**
     * ÐÞ¸Ä·þÎñÐÅÏ¢
     */

    public function editservice(){
        $where['id'] = I('get.id');
        $info = $M->where($where)->find();

        $info['service']=str_ireplace('\"','"',htmlspecialchars_decode($info['service']));

        if(IS_POST){
            echo 1; die; 
            $where['id'] = I('post.id');
            $data['title'] = I('post.title');
            $data['sort'] = I('post.sort');
            $data['title_en'] = I('post.title_en');
            if(I('post.pic')){
                $data['img'] = I('post.pic');
            }
            $data['content'] = I('post.content');
            $data['addtime'] = date("Y-m-d H:i:s");
            $data['digest'] = $_POST['digest'];
            $data['type'] = I('post.type');
            $rs=$M->where($where)->save($data);
            if($rs){
                $this->success('保存成功！');exit;
            }else{
                $this->error('保存失败！');exit;
            }

        }

        $this->assign("info",$info);
        parent::_initialize();
        $this->assign("service",2);
        $this->display();
    }
    /**
     * É¾³ý·þÎñÐÅÏ¢
     */

    public function delservice(){
        $where['id'] = I('get.id');
        $rs=M('service')->where($where)->delete();
        if($rs){
            $this->success('删除成功！',U('/Admin/Service/service'));exit;
        }else{
            $this->error('删除失败！');exit;
        }
    }

    // ÐÞ¸ÄÖ÷Óª·þÎñ²úÆ·
    public function server(){
        $res = M("service")->where(array("type"=>"1"))->order('id asc')->select();
        $this->assign("cache", $res);
        $this->assign("service", 3);
        $this->display();
    }

// ÐÞ¸ÄÖ÷Óª·þÎñ²úÆ·
    public function editServer(){
        $id = I('post.id');
        $data = array(
            "title"   => I("post.title"),
            "digest" => $_POST["service"],
            "url"     => I("post.url"),
        );
        $res = M("service")->where(array("id"=>$id))->order('id asc')->save($data);
        if($res){
            $this->ajaxReturn(array("status"=>1 ,"info"=>"保存成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0 ,"info"=>"保存失败！"));
        }
    }


    // Ö÷Óª·þÎñ²úÆ·×Ö·ÖÀàÁÐ±í
    public function servercont(){
        $id = I('get.id');
        $res = M("serviceServer")->where(array("classid"=>$id))->order('id asc')->select();
        $this->assign("cache", $res);
        $this->assign("service", 3);
        $this->display();
    }

    // Ìí¼Ó·þÎñ²úÆ·×Ö·ÖÀàÁÐ±í
    public function addserver(){
        $res = M("service")->where(array("type"=>"1"))->order('id asc')->select();
        if(IS_POST){

            $data['title'] = I('post.title');
            $data['service'] = I('post.service');
            if(I('post.pic')){
                $data['img'] = I('post.pic');
            }
            $data['classid'] = I('post.type');
            $rs=M('serviceServer')->add($data);
            if($rs){
                $this->success('新增成功！',U('/Admin/Service/servercont/id/'.$data['classid'].''));exit;
            }else{
                $this->error('新增失败！');exit;
            }

        }

        $this->assign("caches", $res);
        $this->assign("service", 3);
        $this->display();
    }


    /**
     * ÐÞ¸Ä
     */
    public function editservers(){
        $M = M('serviceServer');
        $where['id'] = I('get.id');
        $info = $M->where($where)->find();
        if(IS_POST){
            $where['id'] = I('post.id');
            $data['title'] = I('post.title');
            $data['service'] = I('post.service');
            if(I('post.pic')){
                $data['img'] = I('post.pic');
            }
            $data['classid'] = I('post.type');
            $rs=$M->where($where)->save($data);
            if($rs){
                $this->success('保存成功！',U('/Admin/Service/servercont/id/'.$data['classid'].''));exit;
            }else{
                $this->error('保存成功！');exit;
            }
        }
        $res = M("service")->where(array("type"=>"1"))->order('id asc')->select();
        $this->assign("caches", $res);

        $this->assign("info",$info);
        $this->assign("service",2);
        $this->display();
    }


    public function delserver(){
        $M = M('serviceServer');
        $where['id'] = I('get.id');
        $info = $M->where($where)->find();
        $classid=$info['classid'];
        $rs=M('serviceServer')->where($where)->delete();
        if($rs){
            $this->success('删除成功！',U('/Admin/Service/servercont/id/'.$classid.''));exit;
        }else{
            $this->error('删除失败！');exit;
        }
    }

    public function ceshi(){
        mysql_check();
    }


}