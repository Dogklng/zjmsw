<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class StoreController extends CommonController {

    public function _initialize(){
        parent::_initialize();
        $this->assign("munetype",7);
    }

    public function store(){
        $title = I('name');
        $C_m   = D("Store");
        /*$CC_m  = D("StoreClass");*/
        $where['name'] = array("like","%$title%");
        $where['isdel'] = 0;
        /*$where['cate']  = 1;*/
        $stores = $C_m->where($where)->select();
        //dump($stores);
        $count  = $C_m->where($where)->count();
        /*$cclass = $CC_m->where("isdel=0")->select();*/
        /*foreach ($cclass as $k=>$v){
            $arr[$v["id"]] = $v;
        }*/
        /*foreach ($stores as $k =>$v){
            $stores[$k]['type'] = $arr[$v['type']]['classname'];

        }*/

        $this->assign("store",$stores);
        $this->assign("title",$title);
        $this->assign("count",$count);
        $this->assign("comptype",0);
        $this->assign('com',5);
        $this->display();
    }




    // 增加专卖店
    public function addStore(){
        if(IS_POST){
            unset($_POST["id"]);
            $m = M("store");
            // 上传图片
            $data = I("post.");
    /*        if ($_FILES) {
                foreach ($_FILES as $key=>$file) {
                    if ($file['error']==0) {
                        # 配置上传目录
                        $cfg=array(
                            'rootPath' => './Public/Admin/Upload_pic/', //保存根路径
                        );
                        $up=new \Think\Upload($cfg);
                        $move=$up->uploadOne($_FILES[$key]);
                        $picPath=$up->rootPath.$move['savepath'].$move['savename'];
                        $data[$key]="/".trim(trim($picPath,"."),"/");
                    }
                }
            }
            $data["addtime"] = Gettime();*/
            $res = $m->add($data);
            if($res){
                $this->success('添加成功',U('/Admin/Store/store'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $this->display();
        }
    }





    // 修改专卖店
    public function editstore(){
        $id = I("id");
        if(IS_POST){
            $m = M("store");
            // 上传图片
            $data = I("post.");
            if ($_FILES) {
                foreach ($_FILES as $key=>$file) {
                    if ($file['error']==0) {
                        # 配置上传目录
                        $cfg=array(
                            'rootPath' => './Public/Admin/Upload_pic/', //保存根路径
                        );
                        $up=new \Think\Upload($cfg);
                        $move=$up->uploadOne($_FILES[$key]);
                        $picPath=$up->rootPath.$move['savepath'].$move['savename'];
                        $data[$key]="/".trim(trim($picPath,"."),"/");
                    }
                }
            }
            $data["addtime"] = Gettime();
            if($data['password']){
                $data['password'] = md5($data['password']);
            }else{
                unset($data['password']);
            }
            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $this->success('编辑成功',U('/Admin/Store/store',array('id'=>$id)));
            }else{
                $this->success('编辑失败');
            }
        }else{
            $storeClass = M("storeClass")->where(array("isdel"=>0))->field("id,classname")->order("sequence desc")->select();
            $cache = M("store")->where(array("id"=>$id,"isdel"=>0))->find();
            $this->assign("title","修改专卖店");
            $this->assign("storeClass",$storeClass);
            $this->assign("cache",$cache);
            $this->assign("comptype",0);
            $this->assign('com',5);
            $this->display();
        }
    }




    // 删除专卖店
    public function delStore(){
        $id = I("id");
        $res = M("store")->where(array("id"=>$id))->delete();
        if($res){
            $this->success('删除成功',U('/Admin/Store/store'));exit;
        }else{
            $this->error('删除失败');
        }
    }
    /*
     *专卖店类型多选删除
     */
    public function storealldel(){

        if(IS_POST){
            $id = I('post.id');
            $arr = explode('_',$id);
            $newsid = array_filter($arr);
            foreach ($newsid as $key => $vo) {
                $del = M('Store')->where(array('id'=>$vo))->delete();
            }

            if($del){
                $result = array(
                    'status'=>1,
                    'info'=>'删除成功'
                );
                echo json_encode($result);exit;

            }

        }
    }
}