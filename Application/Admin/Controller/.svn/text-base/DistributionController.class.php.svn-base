<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Controller\CommonController;
class DistributionController extends CommonController {
    public function _initialize(){
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function index(){	
        $m   = D("DistributeOrder");
        $res = D("DistributeOrder")->getList();
        $count1 = $m->count();
        $count2 = $m->where(array("type"=>1))->count();
        $count3 = $m->where(array("type"=>2))->count();
        $count4 = $m->where(array("type"=>3))->count();
        $this->assign("cache", $res['data']);
        $this->assign("page",  $res['page']);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);
        $this->assign("count4", $count4);
        $this->assign($_GET);
        $this->display();
    }

    /*
        订单下架
    */
    public function delOrder(){
        $id = I("post.id");
        if($id){
            $isdel = M("DistributeOrder")->where(array("id"=>$id))->getField("isdel");
            $isdel = +(!$isdel);
            $res = M("DistributeOrder")->where(array("id"=>$id))->save(array("isdel"=>$isdel));
            if($res!==false){
                $this->ajaxReturn(array("status"=>1,"info"=>"操作成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,"info"=>"操作失败"));
            }
        }else{
            $this->ajaxReturn(array("status"=>0,"info"=>"操作失败"));
        }
    }


    /**
     * 查看分佣订单详情
     */
    public function orderDetail(){
        $id          = I("get.id");  // 得到orderlist的id
        $orderdetail = M("DistributeOrder")->find($id);
        if(!$orderdetail){
            goback("没有此订单！");
        }
        $user        = M('member')->find($orderdetail['user_id']);
        $db_prefix   = C("DB_PREFIX");
        $join_str    = "join {$db_prefix}member as m on f.user_id=m.id";
        $log         = M('fxLog')->alias("f")->
                        join($join_str)->
                        field("m.person_name, m.telephone, m.status as stat, m.isdel,f.*")->
                        where(array("order_id"=>$id))->
                        select();
        $orderdetail['user'] = $user;
        $orderdetail['log']  = $log;
        $this->assign("cache", $orderdetail);
        $this->display();
    }


    /**
     * 分销配置列表
     */
    public function configList(){
        $res = M("distributConfig")->select();
        foreach($res as $k=>$v){
            $res[$k]['admin_name'] = M("user")->where(array("id"=>$v['admin_id']))->getField("username");
        }
        $this->assign("cache", $res);
        $this->display();
    }

    // 冻结/解冻
    public function changeStatus(){
        if(IS_AJAX){
            $id = I("id");
            $m = M("distributConfig");
            $res = $m->where("id=$id")->field("id,status")->find();
            if($res){
                $res['status']    = +(!$res['status']);
                $res['admin_id']  = $_SESSION['admin_id'];
                $res['change_at'] = time();
                $res2 = $m->save($res);
                if($res2){
                    $arr = array("未启用","已启用");
                    $return = array(
                        "status"     => 1,
                        "info"       => $arr[$res['status']],
                        "admin_name" => $_SESSION['admin'],
                        "change_at"  => date("Y-m-d H:i:s", $res['change_at']),
                    );
                }else{
                    $return = array(
                        "status" => 0
                    );
                }
            }else{
                $return = array(
                    "status" => 2
                );
            }
           $this->ajaxReturn($return);
        }
    }

    /**
     * 配置详情
     */
    public function configDetail(){
        
        $this->display();
    }

    /**
     * 编辑配置
     */
    public function editConfig(){
        if(IS_AJAX){
            $data = I("post.");
            $id   = $data['id'];
            $data['admin_id']  = $_SESSION['admin_id'];
            $data['change_at'] = time();
            unset($data['id']);
            $res = M("distributConfig")->where(array("id"=>$id))->save($data);
            if($res!==false){
                $this->ajaxReturn(array("status"=>1 ,"info"=>"修改成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }
        }
        $id = I("id");
        $res = M("distributConfig")->find( $id );
        $res['admin_name'] = M("user")->where(array("id"=>$res['admin_id']))->getField("username");
        $this->assign("cache", $res)->display();
    }

    /**
     * B、C计划 奖励列表
     *  列出的是 已经跳出的报单
     */
    public function takeRewardList(){
        $type = I("type");
        $map['can_take'] = 1;
        if($order_no = I("order_no")){
            $map['order_no'] = array("like", "%$order_no%");
        }
        if($take_type = I("take_type")){
            $map['take_type'] = $take_type;
        }
        if(!$type){
            $map['type'] = array('in', "2,3");
        }else{
            $map['type'] = $type;
        }
        $o   = M("DistributeOrder");
        $s   = M("shareLog");
        $m   = M("member");
        $u   = M("user");
        $res = $o->where($map)->order("can_take_at desc")->select();
        foreach($res as $k=>$v){
            $res[$k]['user']       = $m->where(array("id"=>$v['user_id']))->field("realname, person_name, telephone")->find();
            $res[$k]['share_type'] = $s->where(array("order_id"=>$v['id'], "user_id"=>$v['user_id']))->find();
            $res[$k]['share_type']['admin_name'] = $u->where(array('id'=>$res[$k]['share_type']['admin_id']))->getField("username");
        }
        $this->assign(array(
                "count1" => $o->where(array('can_take'=>1))->count(),
                "count3" => $o->where(array('can_take'=>1, "type"=>2))->count(),
                "count4" => $o->where(array('can_take'=>1, "type"=>3))->count(),
            ));
        $this->assign("cache" ,$res);
        $this->display();
    }

    /**
     * 
     */
    public function takeShare(){
        if(IS_AJAX){
            $id = I("post.id");
            if(!$id){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"发放失败！"));
            }
            $m    = M("shareLog");
            $data = array(
                    "admin_id" => $_SESSION['admin_id'],
                    "deal_at"  => time(),
                    "status"   => 1,
                );
            $s_data = $m->find($id); 
            if(!$s_data || $s_data['status']==1){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"发放失败！"));
            }
            $res    = $m->where(array('id'=>$id))->save($data); 
            if($res){
                $sys_data = array(
                        "msg"       => "您已成功提取$s_data[share]股！",
                        "type"      => 2,
                        "islooked"  => 0,
                        "order_id"  => $s_data['order_id'],
                        "user_id"   => $s_data['user_id'],
                        "admin_id"  => $_SESSION['admin_id'],
                        "create_at" => time(),
                    );
                M("systemMessage")->add($sys_data);
                $this->ajaxReturn(array("status"=>1 ,"info"=>"发放成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"发放失败！"));
            }
        }
    }
}

