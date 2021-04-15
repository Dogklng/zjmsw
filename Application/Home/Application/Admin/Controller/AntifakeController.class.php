<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Controller\CommonController;
class AntifakeController extends CommonController {

    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    /**
     * 防伪码
     */

    //显示
    public function index(){
        if(IS_POST){
            //查询
            $title = I("post.title");
            $res = M('antifake')->where("antifake like '%$title%'")->select();
            if($res){
                $this->assign('res',$res);
            }else{
                $this->error("未找到相关数据！");
            }
        }else{
            //不是提交的数据
            $status = $_GET['status']+0;
            if($status == null ){
                $count = M("antifake")->count();
                $Page  = getpage($count,10);
                $show  = $Page->show();//分页显示输出
                $res  = M("antifake")->alias("a")->join("app_status b on a.status=b.status_id")->order('a.create_time desc')->limit($Page->firstRow.','.$Page->listRows)->field("a.status,a.id,a.antifake,a.create_time,a.select_time,b.status_name")->select();
                $this->assign("page",$show);
            }else{
                $count = M("antifake")->where("status=$status")->count();
                $Page  = getpage($count,10);
                $show  = $Page->show();//分页显示输出
                $res  = M("antifake")->alias("a")->join("app_status b on a.status=b.status_id")->where("a.status=$status")->order('a.select_time desc')->limit($Page->firstRow.','.$Page->listRows)->field("a.status,a.id,a.antifake,a.create_time,a.select_time,b.status_name")->select();
                $this->assign("page",$show);
            }
            $this->assign("res",$res);
        }
        $count   = M("antifake")->count();
        $count8  = M("antifake")->where("status=8")->count();
        $count9  = M("antifake")->where("status=9")->count();
        $count10 = M("antifake")->where("status=10")->count();
        $this->assign('count',$count);
        $this->assign('count8',$count8);
        $this->assign('count9',$count9);
        $this->assign('count10',$count10);
        $this->display();
    }

    //生成防伪码
    public function antifake(){
        //生成100条随机数
        $arr  = array();
        for($i=0;$i<100;$i++){
            $str  = substr(uniqid(),-6);
            $str .= rand();
            $str = substr(md5($str),-16);
            $arr[] = $str;
        }
        foreach($arr as $v){
            $data['create_time'] = time()+0;//生成时间
            $data["antifake"] = $v;
            $res = M("antifake")->add($data);
            if(!$res){
                //插入失败
                continue;
                $data["status"] =11;//插入失败的状态;
            }
        }
            $this->success("全部生成成功");
    }

     //是否印刷
    public function acceptA(){
        //全选印刷
        if(IS_AJAX){
            $str = $_POST["checks"];
            $arr = json_decode($str,true);
            $res = M("antifake")->where(array("id"=>array("in",$arr)))->setField(array("status"=>9));
            if($res!==false){
                $this->ajaxReturn(array("status"=>1 ,"info"=>"全部印刷成功！"));die;
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"印刷失败！"));die;
            }
        }else{
            $id = $_GET;
            $res = M("antifake")->where(array("id"=>array("in",$id)))->setField(array("status"=>9,"create_time"=>time()));
            if($res){
                $this->success("印刷成功");exit;
            }else{
                $this->error("印刷失败");exit;
            }
        }

    }

    //全选删除
    public function alldel(){
        if(IS_AJAX){
            $str = $_POST["checks"];
            $arr = json_decode($str,true);
            $res = M("antifake")->where(array("id"=>array("in",$arr)))->delete();
            if($res!==false){
                $this->ajaxReturn(array("status"=>1 ,"info"=>"删除成功！"));die;
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"删除失败！"));die;
            }
        }else{
            //单个删除
            $id = $_GET['id'];
            $res = M("antifake")->where(array("id"=>$id))->delete();
            if($res!==false){
                $this->success("删除成功");die;
            }else{
                $this->error("删除失败");die;
            }
        }
        // $str = ltrim($str,"[");
        // $str = rtrim($str,"]");
        //$sql = "DELETE from app_antifake where id in($str)";
        //$res = M("antifake")->query($sql);
        //$res = M("antifake")-> getLastSql($sql);
    }

    
    //


}
?>