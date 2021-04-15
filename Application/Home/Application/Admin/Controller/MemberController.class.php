<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class MemberController extends CommonController {

    public function _initialize() {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }

    public function index()
    {
        header("Content-Type:text/html;charset=utf-8;");
        $action = D('member');
        $rsdate = $action->getmemberlist();
        $rs = $rsdate['list'];
		$count = $rsdate['count'];
        $page = $rsdate['page'];
        //dump($rsdate);exit;

        $this->assign('memberlist',$rs);
		$this->assign('count',$count);
		if($count>10)
		{
		$this->assign('page',$page);
		}
		$map['yun_level'] = array('gt',0);

		$m = M("member");
		$this->assign('count',$count);
        $cate = M('member_cate')->order('id')->select();
        $catelist = array();
        foreach ($cate as $k=>$v){
            $catelist[$v['id']] = $v;
        }
        $catelist[0]['classname'] = '普通会员';
        $this->assign('cate',$catelist);
		$this->assign('count0',$m->where(array('user_type'=>0,'isdel'=>0))->count());
		$this->assign('count1',$m->where(array('user_type'=>1,'isdel'=>0))->count());
		$this->assign('count2',$m->where(array('user_type'=>2,'isdel'=>0))->count());
		$this->assign('count3',$m->where(array('isdel'=>0))->count());
        $this->assign("title",I("title"));
        $this->assign("isexamine",I("isexamine"));
        $this->assign("comptype",0);
        $this->display();
    }

    public function find(){
        $userid = I('post.userid');
        $res = M('yun_apply')->where(array('user_id'=>$userid))->getField('id');
        //print_r($res);;exit;
        $this->ajaxReturn(array('status'=>1,'url'=>"/Admin/Yunrecomm/aushopDetail/id/{$res}"));
    }

    //会员等级
    public function level(){
        if (IS_POST) {
            $edit_notice = M("member_level");

            $count = $edit_notice->count();

            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Member/level', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Member/level', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Member/level', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Member/level', '', false));exit;
                }
            }
        }

        $id= M('member_level')->getField('id');

        $res = M("member_level")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    //会员等级认证
    public function authentication(){
        $name = trim(I('post.title'));
        if($name){
            $map['name'] = array('like',"%$name%");
            $map['tel'] = array('like',"%$name%");
            $map['_logic'] = 'or';
            $map['_complex'] = $map;
            $this->assign('title',$name);
        }
        /* 未审核 */
        $count0 = M('authentication')->where(array('status'=>0))->count();
        $status = I('status');      
        if($status == 1){
            $map['status'] = 0;
            $count0 = M('authentication')->where($map)->count();
        }
        /* 审核通过 */
        $count1 = M('authentication')->where(array('is_del'=>0,'status'=>1))->count();
        if($status == 2){
            $map['status'] = 1;
            $count1 = M('authentication')->where($map)->count();
        }
        /* 审核拒绝 */
        $count2 = M('authentication')->where(array('is_del'=>0,'status'=>2))->count();
        if($status == 3){
            $map['status'] = 2;
            $count2 = M('authentication')->where($map)->count();
        }
        
        $count= M('authentication')->where($map)->count();
        $count3 = M('authentication')->count();
        $this->assign('count',$count);
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = M('authentication')->where($map)->limit($Page->firstRow . ',' . $Page->listRows)->order('addtime desc')->select();
		foreach($res as $k=>$v){
            $res[$k]['person_name'] = M('member')->where(array('id'=>$res[$k]['member_id']))->getField('person_name');
        }
		//dump($res);exit;
        $this->assign('res',$res);
        $this->assign("page", $show);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('count3',$count3);
        $this->display();
    }

    public function authenticationAgree(){
        
        $res = M('authentication')->where(array('id'=>$_POST['id']))->find();
        if($res['remind_type'] == 0){
            $res1 = M('authentication')->where(array('id'=>$_POST['id']))->save(array('status'=>1));
        }elseif($res['remind_type'] == 1){
            $res1 = M('authentication')->where(array('id'=>$_POST['id']))->save(array('fa_status'=>1));
        }elseif($res['remind_type'] == 2){
            $res1 = M('authentication')->where(array('id'=>$_POST['id']))->save(array('bus_status'=>1));
        }

        $res2 = M('authentication')->where(array('id'=>$_POST['id']))->find();
        //当法人验证成功加上证件验证成功他的状态才为验证成功。或者个人验证成功也为验证成功
        if($res2['bus_status']==1){
            $res4 = M('authentication')->where(array('member_id'=>$res2['member_id'],'fa_status'=>1,))->find();
     
            if($res4){
                 M('authentication')->where(array('member_id'=>$res2['member_id']))->save(array('status'=>1));  
                 $res3 = M('member')->where(array("id"=>$res2['member_id']))->save(array('isexamine'=>1));   
            }                
        }

        if($res2['fa_status']==1){
            $res4 = M('authentication')->where(array('member_id'=>$res2['member_id'],'bus_status'=>1))->find();
            if($res4){
                 M('authentication')->where(array('member_id'=>$res2['member_id']))->save(array('status'=>1)); 
                 $res3 = M('member')->where(array("id"=>$res2['member_id']))->save(array('isexamine'=>1));    
            }                
        }

        if($res2['status']==1){
            $res3 = M('member')->where(array("id"=>$res2['member_id']))->save(array('isexamine'=>1));
        }
      

        
        if($res1){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function authenticationDisagree(){
        
        /*$res1 = M('authentication')->where(array('id'=>$_POST['id']))->select();
        if($res1['remind_type'] == 0){
            $res = M('authentication')->where(array('id'=>$_POST['id']))->save(array('status'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        }elseif($res1['remind_type'] == 1){
            $res = M('authentication')->where(array('id'=>$_POST['id']))->save(array('fa_status'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        }elseif($res1['remind_type'] == 2){
            $res = M('authentication')->where(array('id'=>$_POST['id']))->save(array('bus_status'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        }*/
		$res = M('authentication')->where(array('id'=>$_POST['id']))->delete();
        //$res2 = M('authentication')->where(array('id'=>$_POST['id']))->select();
        //$res3 = M('member')->where(array("id"=>$res2['member_id']))->save(array('isexamine'=>2));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }
	

	
	
    /*public function changeAuthentication(){
        if(IS_AJAX){
            $id = I("post.id");
            $m = M("authentication");
            $res = $m->where("id=$id")->field("id,status")->find();
            if($res){
                $res['status'] = $res['status']==1?0:1;
                $res2 = $m->save($res);
                if($res2){
                    $arr = array("已认证","未认证");
                    $return = array(
                        "status" => 1,
                        "info" => $arr[$res['status']]
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
    }*/

    public function authenticationDetail(){
        $res = M('authentication')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }


     // 加盟/退盟
    public function changeVip(){
        if(IS_AJAX){
            $id = I("id");
            $m = M("member");
            $res = $m->where("id=$id")->field("id,vip")->find();
            if($res){
                $res['vip'] = $res['vip']==1?0:1;
                $res2 = $m->save($res);
                if($res2){
                    $arr = array("否","是");
                    $return = array(
                        "status" => 1,
                        "info" => $arr[$res['vip']]
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

    // 冻结/解冻
    public function changeStatus(){
        if(IS_AJAX){
            $id = I("id");
            $m = M("member");
            $res = $m->where("id=$id")->field("id,status")->find();
            if($res){
                $res['status'] = $res['status']==1?0:1;
                $res2 = $m->save($res);
                if($res2){
                    $arr = array("正常","冻结");
                    $return = array(
                        "status" => 1,
                        "info" => $arr[$res['status']]
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
    // 编辑个人资料
    public function editMember()
    {
        $id   = I("id");
        $data = I("post.");

        
        if (IS_POST) {

            // 编辑个人资料
            // 判断密码
            $data["adsasad"] = 1;
            if ($data["password"] === "") {
                unset($data['password']);
            } else {
                $data["password"] = md5($data["password"]);
            }
            // 判断余额
            if($data["integral"] === $data["integral_old"]){
                unset($data["integral"]);
            }
            // 判断积分
            if($data["wallet"] === $data["wallet_old"]){
                unset($data["wallet"]);
            }
            $m = M("member");
            $res = $m->create($data);
           // dump($res);exit;
            if ($res) {
                $res2 = $m->save($res);
                if ($res2) {
                	
                    $info["status"]  = 1;
                    $info["info"]    = "更新成功";
                    $this->ajaxReturn($info);
                    
                } else {
                	
                    $info["status"] = 0;
                    $info["info"]   = "更新失败";
                    $this->ajaxReturn($info);
                }
                
            } else {
            	
                $info["status"] = 0;
                $info["info"]   = "更新失败";
                $this->ajaxReturn($info);
            }
            
        } else {
            $cate = M('member_cate')->select();
            $this->assign('cate',$cate);

            $map["id"] = $id;
            $cache     = M("member")->where($map)->find();
            $this->assign("cache", $cache);
            $this->display();
        }
    }


    public function jifen(){
        $openid = I('openid');
        if(!empty($openid)){
            $member = M('Member')->where('weixin_openid="%s"',$openid)->find();
            if(empty($member)){
                $this->assign('empty',"无该用户数据!");
            }else{
                $this->assign('member',$member);
            }
            $this->assign('openid',$openid);
        }
        $this->display();
    }
    public function updatejifen(){
        $jifen = intval(I('post.jifen'));
        if(!empty($jifen)){
            $ret = M('Member')->where('id=%d',I('post.id',0,'int'))->setInc('jifen',$jifen);
            if($ret){
                echo '0';
            }else{
                echo '1';
            }
        }
    }


    public function friend(){
        $action=D('member');
        $rsdate=$action->getfriend();
        $rs=$rsdate['list'];
        $count=$rsdate['count'];
        $this->assign('memberlist',$rs);
        $this->assign('count',$count);
        $this->display();

    }


	public function delmember(){
        $memberid=I('get.id');
        $m = M("member"); // 实例化User对象
        $rs=$m->where("id=$memberid")->delete(); // 删除id为5的用户数据
        if($rs){
            $this->success('删除成功',U('/Admin/Member/index'));
        }else{
            $this->error('删除失败');
        }
    }

    public function agent_list(){

		$action=D('member');
        $rsdate=$action->getmember();
		$lv=I('post.dengji');

		$ar=$rsdate;

		//重组数组，放入上级分销商
		$superior=$action->getMemberSuperior($ar);
//        var_dump($rsdate);
        $rs=$superior['list'];
		$count=$superior['count'];
        $page=$superior['page'];

		$this->assign('member',$rs);
        $this->assign('page',$page);
		$this->assign('lv',$lv);
		$this->assign('count',$count);
        $this->assign('munetype',6);
        $this->display();
    }

    public function jiangli(){
        if(IS_POST){
            $ret = M('Systemglobal')->where("blname='yongjinshezhi'")->setField('blvalue',json_encode($_POST));
            if($ret){
                $this->assign('修改成功!');
                $this->success();
            }else{
                $this->error("修改失败!");
            }
        }else{
            $blvalue = M('Systemglobal')->where("blname='yongjinshezhi'")->getField('blvalue');
            $blvalue = json_decode($blvalue,true);
            $this->assign('blvalue',$blvalue);
            $this->display();
        }
    }


	public function detail(){
        $mid=I('get.id');
        $act=D('Member');


        $memberdetail=$act->where('id='.$mid)->find();
        $this->assign('memberdetail',$memberdetail);
        $this->assign("img",IMG_URL."Public/Admin/Upload_pic/header.png");
		$this->assign('categorylist',$rs);
		$this->assign('munetype',5);
		$this->display();

    }

    public function updatehdid(){
        $data['hdid'] = I('post.hdid',0,'int');
        $memberModel = M('Member');
        $whe = $memberModel->where('hdid=%d',$data['hdid'])->getField('id');
        if($whe){
            echo '3';//已存在
        }else{
            $ret = $memberModel->where("id=%d",I('post.id',0,'int'))->save($data);
            if($ret){
                echo '0';//成功
            }else{
                echo '1';//失败
            }
        }
    }

	public function agent_edit(){


        $mid=I('get.id');
        $act=D('Member');
        $memberdetail=$act->where('id='.$mid)->find();
		$superior=$act->where('id='.$memberdetail['fid'])->find();
		$memberdetail['superior']=$superior['telephone'];

        $this->assign('memberdetail',$memberdetail);


		$this->assign('munetype',6);
		$this->display();

    }

    public function memberAddMoney(){
        $id = I('post.id',0,'int');
        $money = I('post.money',0);
        if(is_numeric($money)){
            $upRet = M('Member')->where("id=%d",$id)->setInc('balance',$money);
            if($upRet){
                $data = array(
                    'yongjintype'=>1,
                    'addtime'=>date('Y-m-d H:i:s'),
                    'userid'=>$id,
                    'num'=>$money,
                    'description'=>I('post.beizhu')
                );
                $ret = M('Balance')->add($data);
            }
            if($ret){
                echo '1';//成功
            }else{
                echo '2';//失败
            }
        }else{
            echo "3";
        }
    }



    public function sign(){
        $action=D('member');
        $rsdate=$action->getsign();
        $rs=$rsdate['cache'];
        $count=$rsdate['count'];
        $page=$rsdate['page'];
        $this->assign('signlist',$rs);
        $this->assign('count',$count);
        if($count>10)
        {
        $this->assign('page',$page);
        }
        $this->assign("comptype",1);
        $this->display();
    }


    public function delsign(){
        $id = I('cid');
        $res = M('sign')->where('id='.$id)->setField('isdel','1');
        if($result !== false){
            $this->success();
        }else{
             $this->error();
        }


    }

    // 审核身份证
    public function examine(){
        if(IS_AJAX){
            $map["id"] = I("id");
            $data["isexamine"] = I("isexamine");
            $data["examine_msg"] = I("examinemsg");
            $res = M("member")->where($map)->save($data);
            if($res){
                $interface = A("Interface");
                if($data["isexamine"]==1){
                    $res2 = $interface->jpush_msg($map["id"],"您的身份证已通过审核");
                }else{
                    $res2 = $interface->jpush_msg($map["id"],"身份证审核失败：".$data["examine_msg"],"14");
                }
                $result["info"] = "操作成功";
                $result["status"] = 1;
                $result["jpush"] = $res2;
            }else{
                $result["info"] = "操作失败";
                $result["status"] = 0;
            }
            $this->ajaxReturn($result);
        }
    }


    //设置起充
    public function setpromote()
    {
        if(IS_POST){
            $money = I("post.money",0);
            if (!$money) {
                $this->ajaxReturn(array("status"=>0,"info"=>"请填写起充金额"));
            }
            $res = M("charge_set")->where(array("id"=>1))->setField("money",$money);
            if ($res) {
                $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
            } else {
                $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
            }
        }
        $data = M("charge_set")->find(1);
        $this->assign("charge",$data)->display();
    }

    //分销提成点
    public function memberLeval(){
        if (IS_AJAX) {
            $data = I('post.');
            if(!$data['leval1']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写等级一提成点！'));
            }
            if(!$data['leval2']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写等级二提成点！'));
            }
            if(!$data['leval3']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写等级三提成点！'));
            }
            $data['id'] = 1;
            $res = M('member_fleval')->save($data);
            if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败','data'=>$data));
            }
        }
        $info = M('member_fleval')->find(1);
        $this->assign('info',$info);
        $this->display();
    }

    /*
    * 会员分类
    */
    public function memberCate(){
        $level_name = trim($_GET['classname']);
        if($level_name){
            $data['classname'] = array('like',"%$level_name%");
            $this->assign('title',$level_name);
        }
        $count = M('member_cate')->where($data)->count();
        $Page    = getpage($count,10);
        $show    = $Page->show();
        $res = M('member_cate')->where($data)->limit($Page->firstRow.','.$Page->listRows)->order('sort asc')->select();
        //dump($res);exit;
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function editMemberCate(){
        $m = M("member_cate");
        $map = array(
            "classname" => $_POST['classname'],
            "id"        => array("neq", $_POST['id']),
        );
        $res = $m->where($map)->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['classname'] = $_POST['classname'];
        $data['sort'] = $_POST['sort'];
        $data['create_at'] = time();
        $res = $m->where(array('id'=>$_POST['id']))->save($data);
        if($res !== false){
            $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
        }
    }

    public function addMemberCate(){
        if(IS_POST){
            $map = array(
                "classname" => $_POST['classname'],
            );
            $res = M('member_cate')->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data = I('post.');
            //dump($data);exit;
            $data['create_time'] = time();
            //$data['classname'] = $
            $res = M('member_cate')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
            }
        }
    }

    public function delMemberCate(){
        $res = M("member_cate")->where(array('id'=>$_GET['id']))->delete();
        if($res !== false){
            $this->success("删除成功!", U('Admin/Member/memberCate', '', false));exit;
        }else{
            $this->error("删除失败!", U('Admin/Member/memberCate', '', false));exit;
        }
    }



}