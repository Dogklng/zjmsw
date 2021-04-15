<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Controller\CommonController;
class ReserveController extends CommonController {
    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }
    //设计预约
    public function index(){
        if(IS_POST){
            $title = I("post.title");
            $res = M('reserve')->where("name like '%$title%' or phone like '%$title%'")->select();
            if($res){
                $this->assign('res',$res);
            }else{
                $this->error("未找到相关数据！");
            }
        }else{
            $status = $_GET['status']+0;
            if($status == null){
                $count = M("reserve")->count();
                $Page  = getpage($count,10);
                $show  = $Page->show();//分页显示输出
                $res  = M("reserve")->alias("a")->join("app_status b on a.status=b.status_id")->order('a.request_time desc')->limit($Page->firstRow.','.$Page->listRows)->field("a.status,a.id,a.name,a.province,a.city,a.phone,a.request_time,a.goods_id,b.status_name")->where("a.goods_id=0")->select();
                // $sql = M("reserve")->getlastSql($sql);
                // dump($sql);die;
                $this->assign("page",$show);
            }else{
                $count = M("reserve")->where("status=$status")->count();
                $Page  = getpage($count,10);
                $show  = $Page->show();//分页显示输出
                $res  = M("reserve")->alias("a")->join("app_status b on a.status=b.status_id")->order('a.request_time desc')->limit($Page->firstRow.','.$Page->listRows)->field("a.status,a.id,a.name,a.province,a.city,a.phone,a.request_time,a.goods_id,b.status_name")->where("status=$status and a.goods_id=0")->select();

                $this->assign("page",$show);
            }
            $this->assign("res",$res);
        }

        $count  = M("reserve")->where(array("goods_id"=>0))->count();
        $count3 = M("reserve")->where(array("status"=>3,"goods_id"=>0))->count();//待接收的预约
        $count4 = M("reserve")->where(array("status"=>4,"goods_id"=>0))->count();//被取消的预约
        $count5 = M("reserve")->where(array("status"=>5,"goods_id"=>0))->count();//接收的预约
        $count6 = M("reserve")->where(array("status"=>6,"goods_id"=>0))->count();//处理中的预约
        $count7 = M("reserve")->where(array("status"=>7,"goods_id"=>0))->count();//完成的预约
        $this->assign('count',$count);
        $this->assign('count3',$count3);
        $this->assign('count4',$count4);
        $this->assign('count5',$count5);
        $this->assign('count6',$count6);
        $this->assign('count7',$count7);
        $this->display();
    }

    //商品预约
    public function goodsReserve(){
        if(IS_POST){
            $title = I("post.title");
            $res = M('reserve')->where("name like '%$title%' or phone like '%$title%'")->select();
            if($res){
                $this->assign('res',$res);
            }else{
                $this->error("未找到相关数据！");
            }
        }else{
            $status = $_GET['status']+0;
            if($status == null){
                $count = M("reserve")->where("goods_id>0")->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $sql  = "SELECT d.id,d.name,d.province,d.goods_id,d.status,d.status_name,d.sku_info,d.city,d.phone,d.request_time,c.goods_name,c.price,c.oprice from app_goods c LEFT JOIN (SELECT a.status,a.id,a.name,a.province,a.sku_info,a.city,a.phone,a.request_time,a.goods_id,b.status_name FROM app_reserve a INNER JOIN app_status b on a.status=b.status_id  WHERE ( a.goods_id!=0)) d on c.id=d.goods_id where c.id=d.goods_id  ORDER BY d.request_time desc limit"." ".$Page->firstRow.",".$Page->listRows."";
                $res = M("reserve")->query($sql);
                // $sql = M("reserve")->getlastSql($sql);
                // dump($sql);die;
                $this->assign("page",$show);
            }else{
                $count = M("reserve")->where("status=$status and goods_id>0")->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $sql  =  "SELECT d.id,d.name,d.province,d.goods_id,d.status,d.status_name,d.sku_info,d.city,d.phone,d.request_time,c.goods_name,c.price,c.oprice from app_goods c LEFT JOIN (SELECT a.status,a.id,a.name,a.province,a.sku_info,a.city,a.phone,a.request_time,a.goods_id,b.status_name FROM app_reserve a INNER JOIN app_status b on a.status=b.status_id  WHERE ( a.goods_id!=0)) d on c.id=d.goods_id where c.id=d.goods_id and status=$status ORDER BY d.request_time desc limit"." ".$Page->firstRow.",".$Page->listRows."";
                $res = M("reserve")->query($sql);
                $this->assign("page",$show);
            }
            $this->assign("res",$res);
        }

        $count  = M("reserve")->where("goods_id>0")->count();
        $count3 = M("reserve")->where("status=3 and goods_id>0")->count();//待接收的预约
        $count4 = M("reserve")->where("status=4 and goods_id>0")->count();//被取消的预约
        $count5 = M("reserve")->where("status=5 and goods_id>0")->count();//接收的预约
        $count6 = M("reserve")->where("status=6 and goods_id>0")->count();//处理中的预约
        $count7 = M("reserve")->where("status=7 and goods_id>0")->count();//完成的预约
        $this->assign('count',$count);
        $this->assign('count3',$count3);
        $this->assign('count4',$count4);
        $this->assign('count5',$count5);
        $this->assign('count6',$count6);
        $this->assign('count7',$count7);
        $this->display();
    }

    //查看详情
    public function reserveDetail(){
        $id     = $_GET['id'];
        $sql    = "SELECT d.id,d.name,d.province,d.goods_id,d.status,d.status_name,d.sku_info,d.city,d.phone,d.request_time,c.goods_name,c.price,c.oprice,c.index_pic from app_goods c LEFT JOIN (SELECT a.status,a.id,a.name,a.province,a.sku_info,a.city,a.phone,a.request_time,a.goods_id,b.status_name FROM app_reserve a INNER JOIN app_status b on a.status=b.status_id  WHERE ( a.goods_id!=0)) d on c.id=d.goods_id where d.id=$id";
        $res = M("reserve")->query($sql);
        $this->assign("res",$res);
        $this->display();
    }


    //接受预约
    public function acceptR(){
        $id = $_GET['id']+0;
        $res = M("reserve")->where("id = $id")->setField(array("status"=>5,"request_time"=>time()));
        if($res){
            $this->success("接收成功");exit;
        }else{
            $this->error("接收失败");exit;
        }
    }
    //取消预约
    public function cancelR(){
        $id = $_GET['id']+0;
        $res = M("reserve")->where("id = $id")->setField(array("status"=>4,"request_time"=>time()));
        if($res){
            $this->success("取消成功");exit;
        }else{
            $this->error("取消失败");exit;
        }
    }
    //处理预约
    public function conductR(){
        $id = $_GET['id']+0;
        $res = M("reserve")->where("id = $id")->setField(array("status"=>6,"request_time"=>time()));
        if($res){
            $this->success("处理中");exit;
        }else{
            $this->error("处理失败");exit;
        }
    }
    //完成预约
    public function sucR(){
        $id = $_GET['id']+0;
        $res = M("reserve")->where("id = $id")->setField(array("status"=>7,"request_time"=>time()));
        if($res){
            $this->success("完成");exit;
        }else{
            $this->error("失败");exit;
        }
    }
    //删除预约
    public function delR(){
        $id = $_GET['id']+0;
        $res = M("reserve")->where("id = $id")->delete();
        if($res){
            $this->success("删除成功");exit;
        }else{
            $this->error("删除失败");exit;
        }
    }


}

?>