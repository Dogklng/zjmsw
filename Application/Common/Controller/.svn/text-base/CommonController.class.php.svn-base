<?php
namespace Common\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize() {
        //判断用户是否已经登录

        $uid = $_SESSION['admin_id'] ;
        if (!$uid) {
        	$this->redirect('/Admin/User/login');
        }
        $this->assign('urlname', strtolower(ACTION_NAME));
        $_SESSION['access'] = $this->getAccess($_SESSION['admin_id']);
        
       	$this->checkAuth($_SESSION['admin_id']);
        $this->showNodeList();
        $this->assign("munetype", CONTROLLER_NAME);
    }
    
    public function  checkMemberlogin(){

        $uid = $_SESSION['user_id'] ;
            if (!$uid) {
                $this->redirect("Home/User/login"); //直接跳转，不带计时后跳转
            }
    }
    
    public function uploadImg() {
        $upload = new \Think\UploadFile;
        //$upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','svg','mp4','3gp','avi','rmvb','flv','doc','docx');// 设置附件上传类型
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
        return $info;
    }
    public function uploadImgs() {
        $upload = new \Think\UploadFile;
        $upload->maxSize  = 3145728 ;// 设置附件上传大小
        $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg','svg','mp4','3gp','avi','rmvb','flv');// 设置附件上传类型
        $savepath='./Uploads/Picture/av/'.date('Ymd').'/';
        if (!file_exists($savepath)){
            mkdir($savepath);
        }
        $upload->savePath =  $savepath;// 设置附件上传目录
        if(!$upload->upload()) {// 上传错误提示错误信息
            $this->error($upload->getErrorMsg());
        }else{// 上传成功 获取上传文件信息
            $info =  $upload->getUploadFileInfo();
        }
        return $info;
    }

    public function del() {
        $src=str_replace(__ROOT__.'/', '', str_replace('//', '/', $_GET['src']));
        if (file_exists($src)){
            unlink($src);
        }
        print_r($_GET['src']);
        exit();
    }
    public function  GetInfo($id){
        $action=D('Member');
        $returninfo=$action->GetInfomation($id);
        return $returninfo;
    }


    public function addImage(){
        $data = $this->uploadImg();
        $this->ajaxReturn($data);
    }
     public function addImages(){
        $data = $this->uploadImg();
        $this->ajaxReturn($data);
    }

    
    public function showNodeList(){
        $controller_name = strtolower(CONTROLLER_NAME);
        $action_name     = strtolower(ACTION_NAME);
        // 输出顶部
        $access = $_SESSION['access'];
        $m = M("admin_node");
        $head = $m->
            where(array("level"=>1,"id"=>array("in", $access)))->
            order("sort asc")->
            select();
        $this->assign("node_head_list", $head);
        // 输出左侧导航栏
        $q = $m->
            where(array("controller"=>$controller_name, "action"=>$action_name))->
            order("level desc")->
            find();
        $map['id'] = array("in",$access);
        switch($q['level']){
            case "1":
                $map["pid"] = $q['id'];
            break;
            case "3":
                $map["pid"] = $q['pid2'];
            break;
            case "4":
                $map["pid"] = $q['pid3'];
            break;
            default:
                die("no access");
        }
        $left = $m->
            where($map)->
            order("sort asc")->
            select();
        foreach($left as $k=>$v){
            //$left[$k]['nodes'] = $m->where(array("pid"=>$v['id']))->order("sort asc")->select();
            $left[$k]['nodes'] = $m->where(array("pid"=>$v['id'],'id'=>array("in",$access)))->order("sort asc")->select();
        }
        $this->assign("node_left_list", $left);
        // 输出头部的序号
        $sort = $m->where(array('id'=>$map['pid']))->getField('sort');
        $this->assign("head_munetype", $sort);
    }

    public function checkAuth($uid){
        $controller_name = strtolower(CONTROLLER_NAME);
        $action_name     = strtolower(ACTION_NAME);
        $access = $_SESSION['access'];
        $map["level"] = 4;
        $map["controller"] = $controller_name;
        $map["action"] = $action_name;
        $map["id"] = array("in", $access);
        $m = M("admin_node");
        $res = $m->where($map)->order("level desc")->find();
        // dump($map);die;
        if(!$res){
            if(IS_AJAX){
                $this->ajaxReturn(array('status'=>0,"info"=>"您没有此操作权限"));
            }else{
                die("no access!");
            }
        }
        // 输出左侧的urlname
        $action = $m->where(array('id'=>$res['pid']))->getField('action');
        $this->assign('left_urlname', $action);
    }

    public function getAccess($uid){
        $cate = M("user")->where(array('id'=>$uid))->getField('cate');
        return M('admin_cate')->where(array('id'=>$cate))->getField('module');
    }


    /**
     * 发送系统通知的方法
     * @param int     $userid    接受消息者的id
     * @param string  $msg       需要推送的消息
     * @param array   $data 	 需要修改的参数
     */
    public function sendSystemMessage($userid,$title, $msg, $data=array()){
        $data["title"]=$title;
        $data["msg"]       = $msg;
        $data['user_id']   = $userid;
        $data['create_at'] = time();
        $res = M("systemMessage")->add($data);
        if($res){
            return true;
        }else{
            return false;
        }
    }
        public function webup(){
        
        $chunk=I("post.chunk");
        $chunks=I("post.chunks")-1;
        $save_name=I("post.name");
        $name=I('post.id');
        $arr=explode('.', $save_name);
        $savename=$name."_".$chunk.".".$arr[1];
        $config = array(
                'mimes'         =>  array(), //允许上传的文件MiMe类型
                'maxSize'       =>  0, //上传的文件大小限制 (0-不做限制)
                'exts'          =>  array('mp4','zip','mp3','mov','avi','wmv','V0B','RMVB','FLV','3GP','MKV'), //允许上传的文件后缀
                'autoSub'       =>  true, //自动子目录保存文件
                'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                'rootPath'      =>  './Uploads/video/', //保存根路径
                'savePath'      =>  '',//保存路径
                'saveName'      =>substr($savename,0,-4),
              
        );
        $upload = new \Think\Upload($config);// 实例化上传类
        $info   =   $upload->upload();
        if(!$info){
        // 返回错误信息
            $error=$upload->getError();
            $data['error_info']=$error;
            echo json_encode($data);
        }else{
            // 返回成功信息
            $parth="/Uploads/video/".trim($info['file']['savepath']);
            $data['parth']=$parth;
            $data['exts']=$arr[1];
            $data['save_name']=$arr[0];
            $data['chunks']=$chunks;
            $data['chunk']=$chunk;
            $data['name']=$name;
            echo json_encode($data);
        }
    }
 
     public function getFile1(){
        $parths=I("post.parth");
        $exts=I("post.exts");
        $names=I("post.name");
        $save_name=I("post.save_name");
        $chunks = I("post.chunks");
		
       $parth1=dirname(dirname(dirname(dirname(__FILE__)))).$parths.$names."_";
        $log=$chunks.'/'.$parth1;
		
		file_put_contents('log.txt',$log);
        for($i=0;$i<=$chunks;$i++){
            $name=$parth1.$save_name.".".$exts; 
            $fp=fopen($name, 'a');
            $file=$parth1.$i.".".$exts;
            $s=file_get_contents($file);
            $res=fputs($fp,$s);
            fclose($fp);
            $result=unlink($file);
        }
		
		$p1 = dirname(dirname(dirname(dirname(__FILE__)))).$parths.$names.'_'.'.'.$exts;
		$p2 = dirname(dirname(dirname(dirname(__FILE__)))).$parths.$names.'_'.$save_name.'.'.$exts;
		file_put_contents("p1.log",$p1."|".$p2);
		if( $chunks <0){
			rename($p1,$p2);
		}
			$data['name']=$parths.$names.'_'.$save_name.'.'.$exts;
		
      
       $this->ajaxReturn($data);
        
    }

    /*
    *ZQJ 艺术品头部 header 20171101
    */
    public function selHeader(){
        $m = M('series');
        $res = $m->where(array('isdel'=>0))->select();
        $this->assign('resh',$res);
        $this->display();

    }
    /*
    *ZQJ 创意商店头部 header 20171101
    */
    public function creHeader(){
        $m = M('series');
        $res = $m->where(array('isdel'=>0))->select();
        $this->assign('resh',$res);
        $this->display();

    }

	
}