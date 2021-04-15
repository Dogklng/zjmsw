<?php namespace Wxin\Controller;

use Think\Controller;

class UserController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->assign('on',5);
    }
	/**
	 * 执行登录
	 */
	public function doLogin()
	{
		if( IS_AJAX ) {
			$telephone = I("post.telephone");
			$password  = I("post.password");
			if (!$telephone) {
				$this->ajaxReturn(array("status"=>0, "info"=>"请填写手机号！"));
			}
			if (!$password) {
				$this->ajaxReturn(array("status"=>0, "info"=>"请填写密码！"));
			}
			if (!preg_match("/^1[35789][0-9]{9}$/", $telephone)) {
				$this->ajaxReturn(array("status"=>0, "info"=>"手机号码格式错误！"));
			}
			$res = M("member")->where(array('telephone'=>$telephone, "isdel"=>0))->find();
			if (!$res) {
				$this->ajaxReturn(array("status"=>0, "info"=>"账号不存在！"));
			}
			if ($res['status']) {
				$this->ajaxReturn(array("status"=>0, "info"=>"您的账号已被冻结，请联系管理员"));
			}
			if ($res["password"] == md5($password)) {
				session("user_id", $res['id']);
				session("username", $res['telephone']);
                $this->user_info  = $res;
                $this->user_id    = $res['id'];
				$this->ajaxReturn(array("status"=>1, "info"=>"登录成功！", "url" => current_url()));
			} else {
				$this->ajaxReturn(array("status"=>0, "info"=>"用户或密码错误！"));
			}
		}
	}

    /**
     *
     * 验证码生成
     */
    public function verify_c(){
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize = 18;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->codeSet = '0123456789';
        $Verify->imageW = 130;
        $Verify->imageH = 50;
        $Verify->entry();
    }
	
	/**
	 * 注册初始化
	 */
	public function zhuce()
	{
      if(IS_AJAX){
          if($_SESSION['member_id']){
            unset($_SESSION['member_id']);
            $this->ajaxReturn(array('status'=>1));
          }
          $this->ajaxReturn(array('status'=>1));
      }
        $this->display();
	}

	/**
	 * @执行注册
	 * @这里需要检测验证码
	 */
	public function doReg()
	{
		if ( IS_AJAX ) {
			$telephone   =  I("post.telephone");
			$password    =  I("post.password");
			$code  	     =  I("post.code");
            $member_id   =  I("post.member_id");
            $member      = M("member");
			if (!$telephone) {
				$this->ajaxReturn(array("status"=>0, "info"=>"请填写手机号！"));
			}
			if (!$password) {
				$this->ajaxReturn(array("status"=>0, "info"=>"请填写密码！"));
			}
			if (!$code) {
				$this->ajaxReturn(array("status"=>0, "info"=>"请填写验证码！"));
			}
			if (!preg_match("/^1[345789][0-9]{9}$/", $telephone)) {
				$this->ajaxReturn(array("status"=>0, "info"=>"手机号码格式错误！"));
			}
			// 检测密码格式
			if (!preg_match("/.{6,24}/", $password)) {
				$this->ajaxReturn(array("status"=>0, "info"=>"密码格式错误！"));
			}
			// 判断手机号是否存在
			$count = $member->where(array("telephone"=>$telephone))->count();
			if ($count) {
				$this->ajaxReturn(array("status"=>0, "info"=>"手机号已存在！"));
			}
			$res = $this->checkMessage($telephone, $code, 1);
			if ($res['status'] != 1) {
				$this->ajaxReturn($res);
			} else {
				// 注册成功
				$data['telephone']     =  $telephone;
				$data['password']      =  md5($password);
				$data['person_name']   =  $telephone;
				$data['addtime']       =  date("Y-m-d H:i:s", time());
				$res = $member->add($data);
				if ($res) {
					session("user_id", $res);
					session('username', $telephone);
					$this->ajaxReturn(array("status"=>1, "info"=>"注册成功！", "url"=>U('Wxin/PersonalCenter/user')));
				} else {
					$this->ajaxReturn(array("status"=>0, "info"=>"注册失败！"));
				}
			}
		}
	}
	
	

	/**
	 * 获取验证码   1、注册  2、忘记密码
	 */
	public function getMessage()
	{
		if (IS_AJAX) {
			$phone = I("post.telephone");
			$code_type    = I('post.type');
			$piccode      = I('post.piccode');
			if (!$phone) {
				$this->ajaxReturn(array("status"=>0, "info"=>"请填写手机号！"));
			}
			if (!preg_match("/^1[35789][0-9]{9}$/", $phone)) {
				$this->ajaxReturn(array("status"=>0, "info"=>"手机号码格式错误！"));
			}
            // 检查验证码
            if(!check_verify($piccode)){
                $data['info']   =   '亲，验证码输错了哦！'; // 提示信息内容
                $data['status'] =   0;  // 状态 如果是success是1 error 是0
                $this->ajaxReturn($data);
                exit;
            }
			if($code_type == 1){//注册
				$user_tel = M('Member')->where(array('telephone'=>$phone))->find();
				if($user_tel){
					$this->ajaxReturn(array('status'=>0, 'info'=>'该手机已被注册'));
				}
			}
			if($code_type == 2){
				$user_tel = M('Member')->where(array('telephone'=>$phone))->find();
				if(!$user_tel){
					$this->ajaxReturn(array('status'=>0, 'info'=>'该手机不存在'));
				}
			}
			$res = sendMessage($code_type,$phone);
			$this->ajaxReturn($res);
		}
	}


    #用户登录
    public function login()
    {

        if ( IS_POST ) {
            $account	= I("name_account");
            $password 	= I("password");
            if (empty($account) || !isset($account)) {
                $this->ajaxReturn(array("status" => 0 , "info" => "请填写帐号"));
            }

            $user = M("Member");
            //根据输入帐号去匹配

            if (preg_match("/^1[3-9][0-9]{9}$/", $account)) {
                $user_info = $user->where( array("telephone" => $account, "password" => md5($password)) )->find();

                if ($user_info) {
                    if($user_info['status']=='0'){
                        session("member_id", $user_info['id']);
                        if(empty($user_info['realname'])){
                            session("username",  $user_info['telephone']);
                        }else{
                            session("username",  $user_info['realname']);
                        }
                        $tagss = true;
                    }else{
                        $this->ajaxReturn(array("status" => 0 , "info" => "帐号被禁用！"));

                    }
                } else {

                    $tagss = false;
                }
            } else if (preg_match("/^([a-zA-Z0-9]+[_|\_|\.] )*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.] )*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/", $account)) {
                $user_info = $user->where( array("email"     => $account, "password" => md5($password.'abcd')) )->find();
                if ($user_info) {
                    if($user_info['status']=='0'){
                        session("member_id", $user_info['id']);
                        if(empty($user_info['realname'])){
                            session("username",  $user_info['email']);
                        }else{
                            session("username",  $user_info['realname']);
                        }
                        $tagss = true;
                    }else{
                        $this->ajaxReturn(array("status" => 0 , "info" => "帐号被禁用！"));
                    }
                } else {
                    $tagss = false;
                }
            } else {
                $this->ajaxReturn(array("status" => 0 , "info" => "帐号或密码输入错误！"));
            }

            //判断帐号是否正确
            if ($tagss === true ) {
                $url=session("url") ? session('url') : '/Wxin/PersonalCenter/user';
                unset($_SESSION['url']);
                if($_COOKIE['remember_user']==1){
                    cookie('telephone',$account);
                    cookie('password',$password);
                }else{
                    cookie('telephone',null);
                    cookie('password',null);
                }
                $this->ajaxReturn(array("status" => 1, "info" => "登录成功！", "url" =>$url));

            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "帐号或密码输入错误！"));
            }
        }
        $wx_openid = $_SESSION['wx_openid'];
        $this->assign('wx_openid',$wx_openid?$wx_openid:0);
        $this->display();
    }

    public function doRegs()
    {
        if (IS_AJAX) {
            $phone				= I("telephone");
            $password 			= I("password");
            $identify			= I('code');

            if ( !$phone) {
                $this->ajaxReturn(array( "status" => 0,  "info" => "请填写手机号！"));
            }
            if ( !preg_match("/^1[3-9][0-9]{9}$/", $phone)) {
                $this->ajaxReturn(array( "status" => 0,  "info" => "手机格式错误！"));
            }
            if (M("Member")->where(array("telephone" => $phone))->count()) {
                $this->ajaxReturn(array( "status" => 0,  "info" => "该手机号已被注册！"));
            }
            if (!$password) {
                $this->ajaxReturn(array( "status" => 0,  "info" => "请输入密码！"));
            }
            if ( !preg_match("/^.{6,24}$/", $password)) {
                $this->ajaxReturn(array( "status"  => 0, "info" => "密码长度在6-24位！"));
            }

            $re = $this->checkMessage($phone,$identify,1);
            if ($re["status"] != 1) {
                $this->ajaxReturn($re);
            }

            $box = $_POST['box'];
            $box=substr($box,0,strlen($box)-1);
            $arr=explode(',', $box);
            foreach ($arr as $k=>$v){
               if($v==1){
                   $data['buy'] = $v;
               } else if($v==2){
                   $data['seller'] = $v;
               }else if($v==3){
                   $data['artist'] = $v;
               }
            }
            $data['person_img'] = '/Public/Home/Images/user_tx.jpg';
            $data['telephone']	= $phone;					//手机号
            $data['password']	= md5($password);	//密码
            $data['addtime']	= date("Y-m-d H:i:s");		//注册时间

            $data['status']	= '0';
            $data['is_reg']	= '0';
            #用户表
            $users 		= M("Member");
            $reg_result = $users->add( $data );
            if ($reg_result) {
                session("member_id",	$reg_result);
                session("username",		$phone);
                $this->ajaxReturn(array("status" => 1, "info" => "注册成功！", "url" => U("Wxin/User/login")));
            } else {
                $this->ajaxReturn(array("status" => 0, "info" => "注册失败，再来一次！"));
            }
        }
    }

    #找回密码
    public function forgetPassword(){

        if(IS_AJAX){
            $phone=I("post.username",0);
            $identify=I("post.code",0);
            $password=I("post.password",0);
            if ( !preg_match("/^.{6,24}$/", $password)) {
                $this->ajaxReturn(array( "re"  => 0, "info" => "密码长度在6-24位！"));
            }
            /* $num_code=cookie('num_code'); */

            $res = $this->checkMessage($phone,$identify,2);
            if ($res["status"] != 1) {
                $this->ajaxReturn($res);
            }

            if(!$res){
                $this->ajaxReturn(array("re" =>0, "info" => "验证码错误"));
            }
            $pass=md5($password);
            if (!preg_match("/^1[3-9][0-9]{9}$/", $phone)) {//通过邮箱找回密码
                $ress=M("Member")->where(array("email"=>$phone,'password'=>$pass))->find();
                if($ress){
                    $data['re']=1;
                    $data['info']="修改成功";
                    $this->ajaxReturn($data);

                }
                $re=M("Member")->where(array("email"=>$phone))->setField('password',$pass);
            }else{
                $ress=M("Member")->where(array("telephone"=>$phone,'password'=>$pass))->find();
                if($ress){
                    $data['re']=1;
                    $data['info']="修改成功";
                    $this->ajaxReturn($data);

                }
                $re=M("Member")->where(array("telephone"=>$phone))->setField('password',$pass);
            }

            if($re){
                $data['re']=1;
                $data['info']="修改成功";

            }else{
                $data['re']=0;
                $data['info']='修改失败';
            }
            $this->ajaxReturn($data);

        }

        $this->display();

    }


    /**
	 * 前台用户退出
	 */
	public function logout()
	{
		if(session('member_id')) session('member_id', null);
		if(session('username')) session('username', null);
		$this->redirect( U('Wxin/Index/Index', '', false));
	}
	
	/**
	 * 用户切换帐号
	 */
	public function change_account()
	{
		if(session('user_id')) session('user_id', null);
		if(session('username')) session('username', null);
		$this->redirect( U('Wxin/User/login', '', false));
	}


	public function forget()
    {
        $this->display();
    }

    // 手机端微信授权登录
    public function weixin_phone_login(){

        //发起微信登录
        $state  = MD5(uniqid(rand(),TRUE));
        session('wx_state',$state);
        $AppID = 'wxd4ffd6bcf1b0c3e7';
        $AppSecret='d6f8900af097c7a6fce90084bdc1d328';
        $query = array(
            'appid'         => $AppID,
            'redirect_uri'  => "http://". $_SERVER['HTTP_HOST']."/Wxin/User/phone_wxcallback",    //回调地址
            'response_type' => 'code',
            'scope'         => 'snsapi_userinfo',
            'state'         => $state,
        );
        header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?".http_build_query($query)."#wechat_redirect");

    }
    public function phone_wxcallback(){


        if($_GET['state']!=$_SESSION["wx_state"]){
            $this->error('校验码不正确！');
        }
        $AppID = 'wxd4ffd6bcf1b0c3e7';
        $AppSecret='d6f8900af097c7a6fce90084bdc1d328';
        $url='https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$AppID.'&secret='.$AppSecret.'&code='.$_GET['code'].'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr1=json_decode($json,1);
        // $url='https://api.weixin.qq.com/sns/userinfo?access_token='.$arr1['access_token'].'&openid='.$arr1['openid'].'&lang=zh_CN';
        $url='https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$AppID.'&grant_type=refresh_token&refresh_token='.$arr1['refresh_token'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr=json_decode($json,1);
        // dump($arr);exit;
        $url2='https://api.weixin.qq.com/sns/userinfo?access_token=' .$arr1['access_token']. '&openid=' .$arr['openid'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url2);
        $json =  curl_exec($ch);
        curl_close($ch);
        $arr2=json_decode($json,1);

        $wx_openid=$arr2['openid'];//$arr2['unionid'];
        $wx_openid_gzh = $arr2['openid'];
        $act=M('member');
        $member = $act->where(array('wx_openid'=>$wx_openid))->find();
        if($member && $wx_openid!=''){
            if($member['status']!=0){//异常账号
                $this->redirect("http://".$_SERVER['HTTP_HOST']."/Wxin/Index/Index");
                exit;
            }
            $_SESSION['member_id']=$member['id'];
            $_SESSION['wx_openid']=$member['wx_openid'];
            if(!$member['wx_openid_gzh']){
                $date['wx_openid_gzh'] = $wx_openid_gzh;
            }
            $act->where(array('id'=>$member['id']))->save($date);
            $this->redirect("http://" . $_SERVER['HTTP_HOST'] . "Wxin/PersonalCenter/user");exit;
        }else {
            $_SESSION['wx_openid'] = $wx_openid;
            $_SESSION['wx_openid_gzh'] = $wx_openid_gzh;
            $this->redirect("http://" . $_SERVER['HTTP_HOST'] . "Wxin/User/login");exit;
        }
    }
	
}