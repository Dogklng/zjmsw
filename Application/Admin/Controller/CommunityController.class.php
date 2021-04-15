<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class CommunityController extends CommonController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign("urlname", ACTION_NAME);
    }
    /*
     * 参展审核
     */
    public function canzhan(){
        $count=M('cz')->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('cz')->order('id desc')->limit($Page->firstRow.",".$Page->listRows)->select();
        foreach ($res as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $res[$k]['classname'] = $series['classname'];
        }
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function canzhanDetail(){
        $id = $_GET['id'];

        $res = M('cz')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $pic = M("cz_pic")->where(array('cz'=>$id, "status"=>1))->select();
        $this->assign("pic", $pic);
        $this->display();
    }

    /*public function agree(){
        $res = M('cz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function disagree(){
        $res = M('cz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"拒绝审核失败！"));
        }
    }*/

    public function banzhan(){
        $res = M('bz')->order('id desc')->select();
        foreach ($res as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $res[$k]['classname'] = $series['classname'];
        }
        $this->assign('res',$res);
        $this->display();
    }

    public function banzhanDetail(){
        $id = $_GET['id'];

        $res = M('bz')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }


    /*
    * 艺术列表
    */
    public function art(){
        $count1=M('art')->where(array("is_sale"=>1))->count();
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =M('art')->where($map)->count();
        }
        /* 下架*/
        $count2=M('art')->where(array("is_del"=>0, "is_sale"=>0))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=M('art')->where($map)->count();
        }
        $counts = M('art')->count();
        $res = M('art')->where($map)->select();
        $count = M('art')->where($map)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign('res',$res);
        $this->assign('count',$counts);
        $this->assign("count1",$count1);  //出售
        $this->assign("count2",$count2 );   //未出售
        $this->assign("page",  $show);
        $this->display();
    }

    public function addArt(){
        if (IS_POST) {
            $m      = M("art");
            $data   = I("post.");
            $res = $m->add($data);
            if($res){
                $this->success("新增成功！",U('Admin/Community/art'));

            }else{
                $this->error("新增失败！",U('Admin/Community/art'));
            }
            $this->redirect('Admin/Community/art');
        }
        $art_cate = M('art_cate')->select();
        $this->assign('art_cate',$art_cate);
        $school_cate = M('school_cate')->select();
        $this->assign('school_cate',$school_cate);
        $person_cate = M('person_cate')->select();
        $this->assign('person_cate',$person_cate);
        $this->display();
    }

    public function editArt(){
        if (IS_POST) {
            $m                  = M("art");
            $data               = I("post.");
            $id                 = $_POST['id'];

            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $this->success("修改成功！",U('Admin/Community/art'));
            } else {
                $this->error("修改失败！",U('Admin/Community/art'));
            }
            $this->redirect('Admin/Community/art');
        }
        $art_cate = M('art_cate')->select();
        $this->assign('art_cate',$art_cate);
        $school_cate = M('school_cate')->select();
        $this->assign('school_cate',$school_cate);
        $person_cate = M('person_cate')->select();
        $this->assign('person_cate',$person_cate);
        $res = M('art')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }
    /*
     * 游戏列表
     */
    public function game(){
        $res = M('game')->select();
        $this->assign('res',$res);
        $this->display();
    }

    public function addGame(){
        if(IS_AJAX){
            $classname = I("post.name");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $detail    = I('post.detail');
            $url       = I('post.url');
            $m = M("game");
            $res = $m->where(array("name"=>$classname, "isdel"=>0))->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"名称已存在！"));
            }
            $data['name'] = $classname;
            $data['sort']      = $sort;
            $data['detail'] = $detail;
            $data['url'] = $url;
            $data['create_time'] = time();
            $pic && $data['pic'] = $pic;
            $res = $m->add($data);
            if($res){
                $this->ajaxReturn(array("status"=>1, "info"=>"增加成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"新增失败！"));
            }
        }
    }

    public function editGame(){
        if(IS_AJAX){
            $id        = I("post.bannertypegoryid");
            $classname = I("post.classname");
            $pic       = I("post.pic");
            $sort      = I("post.sort");
            $detail    = I('post.detail');
            $url       = I('post.url');
            $m = M("game");
            $map = array(
                "name" => $classname,
                "id"        => array("neq", $id),
            );
            $res = $m->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"名称已存在！"));
            }

            $data['name'] = $classname;
            $data['detail'] = $detail;
            $data['create_time'] = time();
            $data['sort']      = $sort;
            $data['url'] = $url;
            $pic && $data['pic'] = $pic;
            $res = $m->where(array('id'=>$id))->save($data);
            if($res !== false){
                $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
            }else{
                $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
            }
        }
    }

    public function delGame(){
        $id = $_GET['id'];

        $m  = M("game");
        $res = $m->where(array('id'=>$id))->delete();
        if($res){
            $this->success("删除成功！");
        }

    }
    /*
     * 画廊
     */
    public function hualang(){
        /* 未审核 */
        $count0 = M('gallery')->where(array('shenhe'=>0))->count();
        $shenhe = I('shenhe');
        if($shenhe == 1){
            $map['shenhe'] = intval($shenhe)-1;
            $count0 = M('gallery')->where($map)->count();
        }
        /* 审核通过 */
        $count1 = M('gallery')->where(array('is_del'=>0,'shenhe'=>1))->count();
        if($shenhe == 2){
            $map['shenhe'] = intval($shenhe)-1;
            $count2 = M('gallery')->where($map)->count();
        }
        /* 审核拒绝 */
        $count2 = M('gallery')->where(array('is_del'=>0,'shenhe'=>2))->count();
        if($shenhe == 3){
            $map['shenhe'] = intval($shenhe)-1;
            $count2 = M('gallery')->where($map)->count();
        }
        $counts = M('gallery')->count();
        //$res1 = M('art_cate')->where(array('art_cate'=>$res['art_cate']))
        $res = M('gallery')->where($map)->select();
        $count = M('gallery')->where($map)->count();
        $Page = getPage($count,10);
        $show = $Page->show(); //分页显示输出
        $this->assign('res',$res);
        $this->assign('count',$counts);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('page',$show);
        $this->display();
    }

    public function delGallery(){
        $id  = $_GET['id'];
        $res = M('gallery')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功！');die;
        }
        $this->error('删除失败！');die;
    }

    public function galleryAgree(){
        $create_at = time();
        $res = M('gallery')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1,'create'=>$create_at));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function galleryDisagree(){
        $create_at = time();
        $res = M('gallery')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail'],'create'=>$create_at));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"拒绝审核！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"拒绝审核失败！"));
        }
    }

    public function hualangDetail(){
        $id = $_GET['id'];
        $res = M('gallery')->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $user = M('member')->where(array('id'=>$res['owner_id']))->find();
        $this->assign('user',$user);
        //dump($user);exit;
        $this->display();
    }

    public function changeStatus6(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("gallery");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1);/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $shenhe=$m->where(array("id"=>$id))->getfield("shenhe");
                if($shenhe==1)
                {
                    $m->where(array("id"=>$id))->setField('shenhe_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('shenhe_at'."");
                }
                $arr = array(1,2);

                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));}
        }
    }

    public function galleryGoods(){
        /* 未审核 */
        $count0 = M('gallery_goods')->where(array('is_shenhe'=>0))->count();
        $is_shenhe = I('is_shenhe');
        if($is_shenhe == 1){
            $map['is_shenhe'] = intval($is_shenhe)-1;
            $count0 = M('gallery_goods')->where($map)->count();
        }
        /* 审核通过 */
        $count1 = M('gallery_goods')->where(array('is_del'=>0,'is_shenhe'=>1))->count();
        if($is_shenhe == 2){
            $map['is_shenhe'] = intval($is_shenhe)-1;
            $count1 = M('gallery_goods')->where($map)->count();
        }
        /* 审核拒绝 */
        $count2 = M('gallery_goods')->where(array('is_del'=>0,'is_shenhe'=>2))->count();
        if($is_shenhe == 3){
            $map['is_shenhe'] = intval($is_shenhe)-1;
            $count2 = M('gallery_goods')->where($map)->count();
        }
        $counts = M('gallery_goods')->count();
        $res = M('gallery_goods')->alias("a")->join("app_gallery b on a.gallery_id=b.id")->where($map)->select();
        $count = M('gallery_goods')->where($map)->count();

        //$shop = M('gallery')->where(array('id'=>$res['gallery_id']))->Field('name');
        //dump($shop);exit;
        $Page = getPage($count,10);
        $show = $Page->show(); //分页显示输出
        $this->assign('res',$res);
        $this->assign('shop',$shop);
        $this->assign('count',$counts);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('page',$show);
        $this->display();
    }

    public function delGalleryGoods(){
        $id  = $_GET['id'];
        $res = M('gallery_goods')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功！');die;
        }
        $this->error('删除失败！');die;
    }

    public function galleryGoodsAgree(){
        $res = M('gallery_goods')->where(array('id'=>$_POST['id']))->save(array('is_shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function galleryGoodsDisagree(){
        $res = M('gallery_goods')->where(array('id'=>$_POST['id']))->save(array('is_shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"拒绝审核！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"拒绝审核失败！"));
        }
    }

    public function changeStatus7(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("galleryGoods");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1);/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $shenhe=$m->where(array("id"=>$id))->getfield("shenhe");
                if($shenhe==1)
                {
                    $m->where(array("id"=>$id))->setField('shenhe_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('shenhe_at'."");
                }
                $arr = array(1,2);

                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }else{
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));}
        }
    }

    /*    public function hualang(){
            $count1=M('hualang')->where(array("is_sale"=>1))->count();
            $is_sale = I("is_sale");
            if($is_sale==2){
                $map['is_sale'] = intval($is_sale)-1;
                $count1 =M('hualang')->where($map)->count();
            }
            /* 下架*/
    /*$count2=M('hualang')->where(array("is_del"=>0, "is_sale"=>0))->count();
    if($is_sale==1){
        $map['is_sale'] = intval($is_sale)-1;
        $count2=M('hualang')->where($map)->count();
    }
    $counts = M('hualang')->count();
    $res = M('hualang')->where($map)->select();
    $count = M('hualang')->where($map)->count();
    $Page  = getpage($count,10);
    $show  = $Page->show();//分页显示输出
    $this->assign('res',$res);
    $this->assign('count',$counts);
    $this->assign("count1",$count1);  //出售
    $this->assign("count2",$count2 );   //未出售
    $this->assign("page",  $show);
    $this->display();
}

public function addhl(){
    if (IS_POST) {
        $m      = M("hualang");
        $data   = I("post.");
        $res = $m->add($data);
        if($res){
            $this->success("新增成功！",U('Admin/Community/hualang'));

        }else{
            $this->error("新增失败！",U('Admin/Community/hualang'));
        }
        $this->redirect('Admin/Community/hualang');
    }
    $this->display();
}

public function edithl(){
    if (IS_POST) {
        $m                  = M("hualang");
        $data               = I("post.");
        $id                 = $_POST['id'];

        $res = $m->where(array("id"=>$id))->save($data);
        if($res){
            $this->success("修改成功！",U('Admin/Community/hualang'));
        } else {
            $this->error("修改失败！",U('Admin/Community/hualang'));
        }
        $this->redirect('Admin/Community/hualang');
    }
    $res = M('hualang')->where(array('id'=>$_GET['id']))->find();
    $this->assign('res',$res);
    $this->display();
}
*/
    /**
     * 删除
     */
    public function delArt(){
        $id  = $_GET['id'];
        $res = M("art")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }

    public function delhl(){
        $id  = $_GET['id'];
        $res = M("art")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
    public function changeStatus1(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("art");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $sale=$m->where(array("id"=>$id))->getfield("is_sale");
                if($sale==1)
                {
                    $m->where(array("id"=>$id))->setField('sale_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('sale_at'."");
                }
                $arr = array(1,2);
                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }

    /*
     * 学院分类
     */
    public function schoolcate(){
        $name = trim($_GET['name']);
        if($name){
            $data['name'] = array('like',"%$name%");
            $this->assign('title',$name);
        }
        $count = M('school_cate')->where($data)->count();
        $Page    = getpage($count,10);
        $show    = $Page->show();
        $res = M('school_cate')->where($data)->limit($Page->firstRow.','.$Page->listRows)->order('sort asc')->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }
    public function addSchoolCate(){
        if(IS_POST){
            $map = array(
                "name" => $_POST['name'],
            );
            $res = M('school_cate')->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }

            $data = I('post.');
            $data['create_at'] = time();
            $res = M('school_cate')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
            }
        }

    }
    public function editSchoolCate(){
        $m = M("school_cate");
        $map = array(
            "name" => $_POST['name'],
            "id"        => array("neq", $_POST['id']),
        );
        $res = $m->where($map)->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['name'] = $_POST['name'];
        $data['sort'] = $_POST['sort'];
        $data['create_at'] = time();
        $res = $m->where(array('id'=>$_POST['id']))->save($data);
        if($res !== false){
            $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
        }
    }

    public function delSchoolCate(){
        $id  = $_GET['id'];
        $res = M("school_cate")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
    /*
     * 艺术分类
     */
    public function artCate(){
        $name = trim($_GET['name']);
        if($name){
            $data['name'] = array('like',"%$name%");
            $this->assign('title',$name);
        }
        $count = M('art_cate')->where($data)->count();
        $Page    = getpage($count,10);
        $show    = $Page->show();
        $res = M('art_cate')->where($data)->limit($Page->firstRow.','.$Page->listRows)->order('sort asc')->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function editArtCate(){
        $m = M("art_cate");
        $map = array(
            "name" => $_POST['name'],
            "id"        => array("neq", $_POST['id']),
        );
        $res = $m->where($map)->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['name'] = $_POST['name'];
        $data['sort'] = $_POST['sort'];
        $data['type'] = $_POST['type'];
        $data['create_at'] = time();
        $res = $m->where(array('id'=>$_POST['id']))->save($data);
        if($res !== false){
            $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
        }
    }

    public function addArtCate(){
        if(IS_POST){
            $map = array(
                "name" => $_POST['name'],
            );
            $res = M('art_cate')->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data = I('post.');
            $data['create_at'] = time();
            $res = M('art_cate')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
            }
        }
    }

    public function delArtCate(){
        $res = M("art_cate")->where(array('id'=>$_GET['id']))->delete();
        if($res !== false){
            $this->success("删除成功!", U('Admin/Community/artCate', '', false));exit;
        }else{
            $this->error("删除失败!", U('Admin/Community/artCate', '', false));exit;
        }
    }



    /*
    * 人物分类
    */
    public function personCate(){
        $level_name = trim($_GET['level_name']);
        if($level_name){
            $data['level_name'] = array('like',"%$level_name%");
            $this->assign('title',$level_name);
        }
        $count = M('artist_level')->where($data)->count();
        $Page    = getpage($count,10);
        $show    = $Page->show();
        $res = M('artist_level')->where($data)->limit($Page->firstRow.','.$Page->listRows)->order('sort asc')->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function editPersonCate(){
        $m = M("artist_level");
        $map = array(
            "level_name" => $_POST['level_name'],
            "id"        => array("neq", $_POST['id']),
        );
        $res = $m->where($map)->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['level_name'] = $_POST['level_name'];
        $data['sort'] = $_POST['sort'];
        $data['create_at'] = time();
        $res = $m->where(array('id'=>$_POST['id']))->save($data);
        if($res !== false){
            $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
        }
    }

    public function addPersonCate(){
        if(IS_POST){
            $map = array(
                "level_name" => $_POST['level_name'],
            );
            $res = M('artist_level')->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data = I('post.');
            $data['create_time'] = time();
            $res = M('artist_level')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
            }
        }
    }

    public function delPersonCate(){
        $res = M("artist_level")->where(array('id'=>$_GET['id']))->delete();
        if($res !== false){
            $this->success("删除成功!", U('Admin/Community/personCate', '', false));exit;
        }else{
            $this->error("删除失败!", U('Admin/Community/personCate', '', false));exit;
        }
    }

    /*
     * 展览
     */
    public function show(){
        $count1=M('art_show')->where(array("is_sale"=>1))->count();
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =M('art_show')->where($map)->count();
        }
        /* 下架*/
        $count2=M('art_show')->where(array("is_del"=>0, "is_sale"=>0))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=M('art_show')->where($map)->count();
        }
        $counts = M('art_show')->count();
        $count = M('art_show')->where($map)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('art_show')->where($map)->limit($Page->firstRow.",".$Page->listRows)->select();

        $this->assign('res',$res);
        $this->assign('count',$counts);
        $this->assign("count1",$count1);  //出售
        $this->assign("count2",$count2 );   //未出售
        $this->assign("page",  $show);
        $this->display();
    }

    public function agreeOne(){
        $res = M('art_show')->where(array('id'=>$_POST['id']))->save(array('status'=>2));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function disagreeOne(){
        $res = M('art_show')->where(array('id'=>$_POST['id']))->save(array('status'=>3,'reason'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }
    public function addShow(){
        if (IS_AJAX){
            $m      = M("art_show");
            $data   = I("post.");

            if(!$data['logo']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传logo图片！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data['detail_img']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品展示图！';
                $this->ajaxReturn($dataAj);die;
            }


            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写作品简介！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['create_time'] = time();
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '新增失败！';
            $this->ajaxReturn($dataAj);die;
                //$this->error("新增失败！",U('Admin/Community/show'));
        }
        $this->display();
    }
    public function editShow(){
        if (IS_AJAX){
            $m      = M("art_show");
            $data   = I("post.");

            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写作品简介！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $id                 = $_POST['id'];

            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '修改成功！';
                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '修改失败！';
            $this->ajaxReturn($dataAj);die;
            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        $res = M('art_show')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }
    public function changeStatus2(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("art_show");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $sale=$m->where(array("id"=>$id))->getfield("is_sale");
                if($sale==1)
                {
                    $m->where(array("id"=>$id))->setField('sale_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('sale_at'."");
                }
                $arr = array(1,2);
                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }
    public function delShow(){
        $id  = $_GET['id'];
        $res = M("art_show")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
    /*
     * 培训
     */
    public function train(){
        $count1=M('art_train')->where(array("is_sale"=>1,'type'=>1))->count();
        $is_sale = I("is_sale");
        $map['type'] = 1;
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =M('art_train')->where($map)->count();
        }
        /* 下架*/
        $count2=M('art_train')->where(array("is_del"=>0, "is_sale"=>0,'type'=>1))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=M('art_train')->where($map)->count();
        }
        $counts = M('art_train')->where(array("is_del"=>0,'type'=>1))->count();
        $res = M('art_train')->where($map)->select();
        $count = M('art_train')->where($map)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $this->assign('res',$res);
        $this->assign('count',$counts);
        $this->assign("count1",$count1);  //出售
        $this->assign("count2",$count2 );   //未出售
        $this->assign("page",  $show);
        $this->display();
    }

    public function addTrain(){
        if (IS_AJAX){
            $m      = M("art_train");
            $data   = I("post.");

            if(!$data['logo']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传logo图片！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data['detail_img']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品展示图！';
                $this->ajaxReturn($dataAj);die;
            }


            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写简介内容！';
                $this->ajaxReturn($dataAj);die;
            }

            if ($data['is_activity'] == 1) {
                if (!empty($data['num1']) && !empty($data['price1'])) {
                    $data2['nums'] = $data['num1'];
                    $data2['price'] = $data['price1'];
                }

                if (!empty($data['num2']) && !empty($data['price2'])) {
                    $data3['nums'] = $data['num2'];
                    $data3['price'] = $data['price2'];
                }
            }

            $data['create_time'] = time();
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                if (!empty($data2)) {
                    $data2['train_id'] = $res;
                    M('train_activity_price')->add($data2);
                }

                if (!empty($data3)) {
                    $data3['train_id'] = $res;
                    M('train_activity_price')->add($data3);
                }

                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '新增失败！';
            $this->ajaxReturn($dataAj);die;
            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        /*if(IS_POST){
            $m      = M("art_train");
            $data   = I("post.");
            $data['create_time'] = time();
            $res = $m->add($data);
            if($res){
                $this->success("新增成功！",U('Admin/Community/train'));

            }else{
                $this->error("新增失败！",U('Admin/Community/train'));
            }
            $this->redirect('Admin/Community/train');
        }*/
        $this->display();
    }

    public function editTrain(){
        if (IS_AJAX){
            $m      = M("art_train");
            $data   = I("post.");

            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写简介内容！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $id                 = $_POST['id'];

            if ($data['is_active'] == 1) {
                if (!empty($data['num1']) && !empty($data['price1'])) {
                    $data2['nums'] = $data['num1'];
                    $data2['price'] = $data['price1'];
                    $data2['train_id'] = $id;
                }

                if (!empty($data['num2']) && !empty($data['price2'])) {
                    $data3['nums'] = $data['num2'];
                    $data3['price'] = $data['price2'];
                    $data3['train_id'] = $id;
                }
            }

            $res = $m->where(array("id"=>$id))->save($data);

            $dataAj['status'] = 1;
            $dataAj['info'] = '修改成功！';
            M('train_activity_price')->where(array('train_id'=>$id))->delete();

                    //$this->success("新增成功！",U('Admin/Community/show'));

            if (!empty($data2)) {
                M('train_activity_price')->add($data2);
            }
            if (!empty($data3)) {
                M('train_activity_price')->add($data3);
            }
            $this->ajaxReturn($dataAj);die;
//                $dataAj['status'] = 0;
//                $dataAj['info'] = '修改失败！';
//                $this->ajaxReturn($dataAj);die;


            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        /*if(IS_POST){
            $m                  = M("art_train");
            $data               = I("post.");
            $id                 = $_POST['id'];

            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $this->success("修改成功！",U('Admin/Community/train'));
            } else {
                $this->error("修改失败！",U('Admin/Community/train'));
            }
            $this->redirect('Admin/Community/train');
        }*/
        $res = M('art_train')->where(array('id'=>$_GET['id']))->find();
        $acitvity = M('train_activity_price')->where(array('train_id'=>$_GET['id']))->select();
        if (!empty($acitvity)) {
            $res['num1'] = $acitvity[0]['nums'];
            $res['price1'] = $acitvity[0]['price'];
            if (count($acitvity) == 2) {
                $res['num2'] = $acitvity[1]['nums'];
                $res['price2'] = $acitvity[1]['price'];
            }
            $res['is_active'] = 1;
        } else {
            $res['is_active'] = 0;
            $res['num1'] = '';
            $res['price1'] = '';
            $res['price2'] = '';
            $res['num2'] = '';
        }

        $this->assign('res',$res);
        $this->display();
    }
    public function changeStatus3(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("art_train");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $sale=$m->where(array("id"=>$id))->getfield("is_sale");
                if($sale==1)
                {
                    $m->where(array("id"=>$id))->setField('sale_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('sale_at'."");
                }
                $arr = array(1,2);
                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }
    public function delTrain(){
        $id  = $_GET['id'];
        $res = M("art_train")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }
    /*
     * 众筹
     */
    public function crowd(){
        //判断该众筹作品时间是否超过截止日期
       //$name=I('get.name');
        /*$time = time();
        $data1 = M('crowd')->select();
        foreach($data1 as $k=>$v){
            if($data1[$k]['end']<$time){
                $sql = "update app_crowd set is_sale1=0 where id=".$data1[$k]['id'];
                $res1 = M()->execute($sql);
            }
        }

        //设置展示众筹结束，众筹失败的作品
        $data2 = M('crowd')->where(array('is_sale1'=>0))->select();//获取所有的众筹结束的作品
        //dump($data2);exit;
        foreach($data2 as $k=>$v){
            $res2 = M('order_crowd')->where(array('crowd_id'=>$data2[$k]['id']))->sum('total_fee');
            //遍历获得这些作品的总金额，比较是否为众筹失败，再添加一个字段为is_zc为0时众筹成功，1为众筹失败
            if(($data2[$k]['total_price']*10000) > $res2){
                $sql6 = "update app_crowd set is_zc=1 where id=".$data2[$k]['id'];
                $res6 = M()->execute($sql6);
                $sql5 = "update app_order_crowd set is_refund=0 where id=".$data2[$k]['id'];
                $res5 = M()->execute($sql5);
            }
        }*/

        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['goods_name'] = array('like',"%$name%");
        }

        $m   = M("crowd");
        $map['is_del'] = 0;


        /*
        *众筹中
        */
        $count1 = $m->where(array("is_del"=>0,"is_sale1"=>1))->count();
        $is_sale1 = I("is_sale1");
        if($is_sale1==2){
            $map['is_sale1'] = intval($is_sale1)-1;
            $count1 =$m->where($map)->count();
        }
        /*
       *众筹结束
       */
        $count2 = $m->where(array("is_del"=>0,"is_sale1"=>0))->count();
        if($is_sale1==1){
            $map['is_sale1']=intval($is_sale1)-1;
            $count2 = $m->where($map)->count();
        }
        /*
         * 未审核
         */
        $count3=$m->where(array("is_del"=>0, "shenhe"=>0))->count();
        if($is_sale1==3){
            $map['shenhe'] = intval($is_sale1)-3;
            $count3=M('crowd')->where($map)->count();
        }

        /*
         * 审核通过
         */
        $count4=$m->where(array("is_del"=>0, "shenhe"=>1))->count();
        if($is_sale1==4){
            $map['shenhe'] = intval($is_sale1)-3;
            $count4=M('crowd')->where($map)->count();
        }
        /*
         * 审核拒绝
         */
        $count5=$m->where(array("is_del"=>0, "shenhe"=>2))->count();
        if($is_sale1==5){
            $map['shenhe'] = intval($is_sale1)-3;
            $count5=$m->where($map)->count();
        }
        $counts = $m->where($map)->count();
        //dump($counts);exit;
        $Page  = getpage($counts,10);
        $show  = $Page->show();//分页显示输出
        $res = $m->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($res as $k=>$v){
            $res[$k]['promulgator_name'] = M("crowd_apply")->where(array('id'=>$v['promulgator']))->getField('name');
        }
        //dump($res);exit;
        $this->assign('res',$res);
        $this->assign('page',$show);
        $this->assign('count',$counts);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('count3',$count3);
        $this->assign('count4',$count4);
        $this->assign('count5',$count5);
        $this->display();
    }
    public function addCrowd(){
        if(IS_AJAX){

            $data1 = I('post.');

            if(!$data1['tz_desc']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写投资概述！';
                $this->ajaxReturn($dataAj);die;
            }


            if(!$data1['zcb_desc']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写资产包介绍！';
                $this->ajaxReturn($dataAj);die;
            }


            $m = M('crowd');
            $data = I('post.');
            $data['create_at'] = time();
            $data['start'] = strtotime($_POST['start']);
            $data['end'] = strtotime($_POST['end']);
            //$data['tz_desc'] = $data['tz_desc'];
            //$data['zcb_desc'] = $data['zcb_desc'];

            $goods_care=I('param.goods_care');

            $year=date('Y',strtotime($data['create_at']));
            if((int)$year>(int)$goods_care){
                $dataAj['status'] = 0;
                $dataAj['info'] = '创作时间不能晚于当前时间！';
                $this->ajaxReturn($dataAj);die;
                //$this->error("创作时间不能晚于当前时间！");exit;
            }
            $res  = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                $this->ajaxReturn($dataAj);die;
               // $this->success('新增成功！',U('Admin/Community/crowd'));
            }else{
                $dataAj['status'] = 0;
                $dataAj['info'] = '新增失败！';
                $this->ajaxReturn($dataAj);die;
                //$this->error('新增失败！',U('Admin/Community/crowd'));
            }
            //$this->redirect('Admin/Community/crowd');
        }
        $crowd_cate = M('crowd_cate')->select();
        $this->assign('crowd_cate',$crowd_cate);
        $this->display();

    }

    public function editCrowd(){
        if(IS_POST){
            $m  = M('crowd');
            $data = I('post.');
            $data['start'] = strtotime($_POST['start']);
            $data['end']   = strtotime($_POST['end']);
            $id  = $_POST['id'];
            //dump($_POST);exit;
            $res = $m->where(array('id'=>$id))->save($data);
            //dump($res);exit;
            if($res ||($res === 0)){
                $this->success('修改成功！',U('Admin/Community/crowd'));
            }else{
                $this->error('修改失败！',U('Admin/Community/crowd'));
            }
            $this->redirect('Admin/Community/crowd');
        }
        $res = M('crowd')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $crowd_cate = M('crowd_cate')->select();
        $this->assign('crowd_cate',$crowd_cate);
        $this->display();
    }

    public function changeStatus4(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("crowd");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            if($res['end']<time()){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"众筹已结束！"));die;
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $sale=$m->where(array("id"=>$id))->getfield("is_sale1");
                if($sale==1)
                {
                    $m->where(array("id"=>$id))->setField('sale_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('sale_at'."");
                }
                $arr = array(1,2);
                $this->ajaxReturn(array("status"=>$arr[$res[$item]],"info"=>($res[$item]?"结束众筹成功！":"发起众筹成功！")));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }

    public function delCrowd(){
        $id  = $_GET['id'];
        $res = M('crowd')->where(array('id'=>$id))->delete();
        if($res){
            $this->success('删除成功！');die;
        }
        $this->error('删除失败！');die;
    }

    public function agree(){
        $res = M('crowd')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function disagree(){
        $res = M('crowd')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"拒绝审核！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"拒绝审核失败！"));
        }
    }

    /*
     * 众筹作品分类
     */
    public function crowdCate(){
        $name = trim($_GET['name']);
        if($name){
            $data['name'] = array('like',"%$name%");
            $this->assign('title',$name);
        }
        $count = M('crowd_cate')->where($data)->count();
        $Page    = getpage($count,10);
        $show    = $Page->show();
        $res = M('crowd_cate')->where($data)->limit($Page->firstRow.','.$Page->listRows)->order('sort asc')->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function editCrowdCate(){
        $m = M("crowd_cate");
        $map = array(
            "name" => trim($_POST['name']),
            "id"        => array("neq", $_POST['id']),
        );
        $res = $m->where($map)->find();
        if($res){
            $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
        }
        $data['name'] = $_POST['name'];
        $data['sort'] = $_POST['sort'];
        $data['create_at'] = time();
        $res = $m->where(array('id'=>$_POST['id']))->save($data);
        if($res !== false){
            $this->ajaxReturn(array("status"=>1, "info"=>"修改成功！"));
        }else{
            $this->ajaxReturn(array("status"=>0, "info"=>"修改失败！"));
        }
    }

    public function addCrowdCate(){
        if(IS_POST){
            $map = array(
                "name" => trim($_POST['name']),
            );
            $name = trim($_POST['name']);
            if($name == ''){
                $this->ajaxReturn(array("status"=>0,"info"=>"类名不能为空！"));
            }
            $res = M('crowd_cate')->where($map)->find();
            if($res){
                $this->ajaxReturn(array("status"=>0, "info"=>"类名已存在！"));
            }
            $data = I('post.');
            $data['create_at'] = time();
            $res = M('crowd_cate')->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>'添加成功'));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>'添加失败'));
            }
        }
    }

    public function delCrowdCate(){
        $res = M("crowd_cate")->where(array('id'=>$_GET['id']))->delete();
        if($res !== false){
            $this->success("删除成功!", U('Admin/Community/crowdCate', '', false));exit;
        }else{
            $this->error("删除失败!", U('Admin/Community/crowdCate', '', false));exit;
        }
    }

    public function crowdOrder(){
       /* $time = time();
        $data1 = M('crowd')->select();
        foreach($data1 as $k=>$v){
            if($data1[$k]['end']<$time){
                $sql6 = "update app_crowd set is_sale1=0 where id=".$data1[$k]['id'];
                $res6 = M()->execute($sql6);
            }
        }

        //设置展示众筹结束，众筹失败的作品
        $data2 = M('crowd')->where(array('is_sale1'=>0))->select();//获取所有的众筹结束的作品
        //dump($data2);exit;
        foreach($data2 as $k=>$v){
            $res2 = M('order_crowd')->where(array('crowd_id'=>$data2[$k]['id']))->sum('total_fee');
            //遍历获得这些作品的总金额，比较是否为众筹失败，再添加一个字段为is_zc为0时众筹成功，1为众筹失败
            if(($data2[$k]['total_price']*10000) > $res2){
                $sql7 = "update app_crowd set is_zc=1 where id=".$data2[$k]['id'];
                $res3 = M()->execute($sql7);
                $sql8 = "update app_order_crowd set is_refund=0 where id=".$data2[$k]['id'];
                $res5 = M()->execute($sql8);
            }
        }*/

        if(IS_GET){
            $status = $_GET['order_status'];
            $telephone = trim(I('get.telephone'));
            $person_name = trim(I('get.person_name'));
            $order_no = trim(I('get.order_no'));
            $starttime    = I('starttime');
            $endtime      = I('endtime');
            $this->assign('starttime',$starttime);
            $this->assign('endtime',$endtime);
            $starttime    = strtotime($starttime);
            $endtime      = strtotime($endtime);
            $this->assign('telephone',$telephone);
            $this->assign('person_name',$person_name);
            $this->assign('order_no',$order_no);
            $where1 = array();
            if($starttime != ''){
                $starttime      = trim(strtotime($starttime));
            }else{
                $starttime ='';
            }
            if($endtime!= ''){
                $endtime        = trim(strtotime($endtime))+24*3600;
            }else{
                $endtime   ='';
            }
            if($telephone){
                $where['b.telephone'] = array('like',"%$telephone%");
                $where1['b.telephone'] = array('like',"%$telephone%");
            }
            if($person_name){
                $where['b.person_name'] = array('like',"%$person_name%");
                $where1['b.person_name'] = array('like',"%$person_name%");
            }
            if($starttime && $endtime){
                $where['a.order_time'] = array('between',array($starttime,$endtime));
                $where1['a.order_time'] = array('between',array($starttime,$endtime));

            }else{
                if($starttime){
                    $where['a.order_time'] = array('gt',$starttime);
                    $where1['a.order_time'] = array('gt',$starttime);
                }
                if($endtime){
                    $where['a.order_time'] = array('lt',$endtime);
                    $where1['a.order_time'] = array('lt',$endtime);
                }
            }
            if($order_no){
                $where['a.order_no'] = array('like',"%$order_no%");
                $where1['a.order_no'] = array('like',"%$order_no%");
            }
            if($status === null){
                $count = M('order_crowd')->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where($where)->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $res = M('order_crowd')->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('a.order_time desc')->select();
                $this->assign('page',$show);
            }else{
                $where['a.order_status']=$status;
                $count = $count = M('order_crowd')->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where($where)->count();
                $Page  = getpage($count,5);
                $show  = $Page->show();//分页显示输出
                $res = M('order_crowd')->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->field('a.*,b.person_name,b.telephone')->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order('a.order_time desc')->select();
                $this->assign('page',$show);
            }
                $this->assign('cache',$res);
        }
        

        //dump(count($res));exit;
        $m = M('order_crowd');
        $count  = $m->count();
        $count0 = $m->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where(array("order_status"=>0))->where($where1)->count();//已取消
        $count1 = $m->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where(array("order_status"=>1))->where($where1)->count();//待付款
        $count2 = $m->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where(array("order_status"=>2))->where($where1)->count();//已完成
        $count3 = $m->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where(array("order_status"=>3))->where($where1)->count();//已关闭
        $count4 = $m->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where(array("order_status"=>4))->where($where1)->count();//退款
        $count5 = $m->alias('a')->join('LEFT JOIN app_member b on a.user_id=b.id')->where(array("order_status"=>5))->where($where1)->count();//订单删除
        $this->assign("count",  $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->assign("count2", $count2);
        $this->assign("count3", $count3);
        $this->assign("count4", $count4);
        $this->assign("count5", $count5);
        $this->display();
    }

    //查看详情
    public function orderDetail(){

        $id    = I("get.id");  // 得到order_infolist的id
        //dump($id);exit;
        $order = M("order_crowd")->find($id);

        if(!$order){
            goback("没有此订单！");
        }
        $user        = M('member')->find($order['user_id']);
        $order['user'] = $user;
        $db_prefix   = C("DB_PREFIX");
        //$order_goods = M("order_crowd")->where(array('id'=>$order['id']))->select();
        $goods = M('crowd')->where(array('id'=>$order['crowd_id']))->select();
        $order['goods'] = $goods;
        //dump($order);exit;
        $this->assign("cache", $order);
        $this->display();
    }

    //同意退款
    public function alreturn(){
        $id     = $_GET['id'];
        $m      = M('order_crowd');
        $time   = time();//退款时间
        //支付状态pay_status 已退款2
        //同意退款关闭订单3
        $Info=$m->where(array("id"=>$id))->find();
        //dump($info);exit;
        $res = $m->where(array("id"=>$id))->setField(array("order_status"=>3,"refund_time"=>$time,'refund_type'=>4,'refund_fee'=>$Info['total_fee']));
        $ding = M("order_crowd")->where(array("crowd_id"=>$id))->find();
        $member = M('member')->where(array('id'=>$ding['user_id']))->find();
        $ye = $member['wallet']+$ding['total_fee'];
        $data['wallet']=$ye;
        $tui = M('member')->where(array('id'=>$ding['user_id']))->save($data);
        if($res){
            $data=array(
                'order_id'=>$Info['id']
            );
            $this->sendSystemMessage($Info['user_id'],"您的退款进度消息","您的订单退款已完成，请注意查收！",$data);
            $this->success("退款成功");exit;
        }else{
            $this->success("退款失败");exit;
        }
    }
    //取消退款
    public function dereturn(){
        $id     = $_GET['id'];
        $m      = M('order_crowd');
        $res = $m->where(array("id"=>$id))->find();

        $result  = $m->where(array("id"=>$id))->setField(array("order_status"=>3,"refund_type"=>0));
        if($result){
            $data=array(
                'order_id'=>$res['id']
            );
            $this->sendSystemMessage($res['user_id'],"您的退款进度消息","您的订单退款被拒绝，请注意查收！",$data);
            $this->success("取消成功");
        }else{
            $this->error("取消失败");
        }
    }

    /*
    * 众筹结束退款列表展示
    */
    public function crowdtk(){
        /*$time = time();
        $data1 = M('crowd')->select();
        foreach($data1 as $k=>$v){
            if($data1[$k]['end']<$time){
                $sql = "update app_crowd set is_sale1=0 where id=".$data1[$k]['id'];
                $res1 = M()->execute($sql);
            }
        }

        //设置展示众筹结束，众筹失败的作品
        $data2 = M('crowd')->where(array('is_sale1'=>0))->select();//获取所有的众筹结束的作品
        //dump($data2);exit;
        foreach($data2 as $k=>$v){
            $res2 = M('order_crowd')->where(array('crowd_id'=>$data2[$k]['id']))->sum('total_fee');
            //遍历获得这些作品的总金额，比较是否为众筹失败，再添加一个字段为is_zc为0时众筹成功，1为众筹失败
            if(($data2[$k]['total_price']*10000) > $res2){
                $sql3 = "update app_crowd set is_zc=1 where id=".$data2[$k]['id'];
                $res3 = M()->execute($sql3);
             }
                
         }  
        $result = M('crowd')->where(array('is_zc'=>1))->select();
        foreach($result as $k=>$v){
            $res3 = M('order_crowd')->where(array('crowd_id'=>$v['id']))->save(array('is_zc'=>1));
        }*/



        $crowdtk = M('order_crowd');
        $refund_type = I('get.refund_type');
        if($refund_type){
            $where['a.refund_type'] = $refund_type;
            $wheres['refund_type'] = $refund_type;
        }
        $where['a.pay_status'] = 1;
        $wheres['pay_status']=1;
        $where['a.is_zc'] = 1;
        $wheres['is_zc']=1;
        $where['a.is_del'] = 0;
        $wheres['is_del']=0;
        $count      = M('order_crowd')->where($wheres)->count();
        //dump($count);exit;
        //$res = M('order_crowd')->where($wheres)->select();
        //dump($res);exit;
        $Page       = getpage($count,10);
        $show       = $Page->show();
        //$res10 = M('order_crowd')->where(array('is_zc'=>1,'refund_type'=>1,'is_del'=>0,'pay_status'=>1))->select();
        //dump($res10);exit;

        $res = M('order_crowd')
        ->alias('a')
        ->join('left join app_member b on a.user_id=b.id')
        ->join('app_crowd c on a.crowd_id=c.id')
        ->group('a.id')
        ->field('a.*,b.person_name,b.telephone,c.goods_name')
        ->where($where)
        ->limit($Page->firstRow, $Page->listRows)
        ->select();
//dump($res);exit;
        $this->assign('page',$show);
        $this->assign('cache',$res);
        //dump($res);exit;
        /*$aa = M('order_crowd')->where($wheres)->select();
        dump($aa);exit;*/
        unset($wheres['refund_type']);
        //$res2 = M('order_crowd')->where(array('pay_status'=>1,'is_zc'=>1,'is_del'=>0))->limit($Page->firstRow, $Page->listRows)->select();
        $this->assign('count',$crowdtk->where($wheres)->count());
        $wheres['refund_type']=1;
        $this->assign('count0',$crowdtk->where($wheres)->count());
        $wheres['refund_type']=4;
        $this->assign('count1',$crowdtk->where($wheres)->count());
        
        $this->display();
        /*$result = M('order_crowd')->alias('a')->join('app_crowd b on a.crowd_id=b.id')->where(array('b.is_zc'=>1))->save(array('a.is_zc'=>1));
                $sql5 = "update app_order_crowd set is_refund=0,is_zc=1 where crowd_id=".$data2[$k]['id'];
                $res5 = M()->execute($sql5);*/

        /* $res = M('crowd')->where(array('is_zc'=>1))->select();
         //dump($res);exit;
         foreach($res as $k=>$v){
             $res1[$k] = M('order_crowd')->where(array('crowd_id'=>$res[$k]['id'],'pay_status'=>1))->select();
         }
         dump($res1);exit;*/

        /*$is_refund = I('get.is_refund');
        if($is_refund == 1){
            
            $res = M('order_crowd')->select();
            $count = M('order_crowd')->where(array('pay_status'=>2,'is_refund'=>1,'is_zc'=>1))->count();
        }elseif($is_refund == ''){
            //$sql4 = "select a.id,a.pay_way,a.pay_status,c.goods_name,a.total_fee,a.is_refund,a.refund_time,a.order_no,b.person_name,b.telephone from app_order_crowd a inner join app_member b on a.user_id=b.id left join app_crowd c on a.crowd_id = c.id where c.is_zc=1 and a.pay_status=1";
            //$res=M('order_crowd')->where(array('pay_status'=>1,'is_zc'=>1))->select();
            $res = M('order_crowd')->where(array('pay_status'=>1,'is_zc'=>1))->select();
            //$res = M()->query($sql4);
            $count = M('order_crowd')->where(array('pay_status'=>1,'is_zc'=>1))->count();
            //$count = M('order_crowd')->where(array('pay_status'=>1,'is_zc'=>1))->count();
            //$count = M()->query($sql6);
        }elseif($is_refund == 3){
            $res = M('order_crowd')->where(array('pay_status'=>1,'is_refund'=>3,'is_zc'=>1))->select();
            $count = M('order_crowd')->where(array('pay_status'=>1,'is_refund'=>3,'is_zc'=>1))->count();
           // $res=M('order_crowd')->where(array('pay_status'=>1,'is_refund'=>2,'is_zc'=>1))->select();
            $sql4 = "select a.id,a.pay_way,a.pay_status,c.goods_name,a.total_fee,a.is_refund,a.refund_time,a.order_no,b.person_name,b.telephone from app_order_crowd a inner join app_member b  on a.user_id=b.id left join app_crowd c on a.crowd_id = c.id where c.is_zc=1 and a.pay_status=1 and a.is_refund=0";
            $res = M()->query($sql4);
           // $count = M('order_crowd')->alias('a')->join('app_crowd b on a.crowd_id=b.id')->where(array('a.pay_status'=>2,'a.is_refund'=>1,'b.is_zc'=>1))->count();
        }
        //$count = M('order_crowd')->alias('a')->join('app_crowd b on a.crowd_id=b.id')->where(array('b.is_zc'=>1))->count();
        //$sql4 = "select * from app_order_crowd a left join app_crowd b on a.crowd_id=b.id where b.is_zc=1";
        //$res = M('order_crowd')->alias('a')->join('app_crowd b on a.crowd_id=b.id')->where(array('b.is_zc'=>1,'a.pay_status'=>1))->select();
      
        $this->assign('cache',$res);
      
       
        $Page  = getpage($count,5);
        $show  = $Page->show();//分页显示输出
        $this->assign("page",$show);
        $count0 = M('order_crowd')->where(array('pay_status'=>1,'is_refund'=>3,'is_zc'=>1))->count();
        $count1 = M('order_crowd')->where(array('pay_status'=>2,'is_refund'=>1,'is_zc'=>1))->count();

        $this->assign("count",  $count);
        $this->assign("count0", $count0);
        $this->assign("count1", $count1);
        $this->display();*/
    }

    /*    public function refundOk(){
            $data['id'] = I('post.id');
            $data['refund_type'] = 2;
            $res = M('order_crowd')->save($data);
            if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'受理成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'受理失败'));
            }
        }

        public function refundNo(){
            $data['id'] = I('post.id');
            $data['refund_type'] = 3;
            $res = M('order_goods')->save($data);
            if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'拒绝成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'拒绝失败'));
            }
        }

        public function orderOk(){
            $data['id'] = I('post.id');
            $data['refund_type'] = 4;
            $data['return_price'] = I('post.return_price');
            $res = M('order_crowd')->save($data);
            console.log($res);exit;
            if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'确认成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'确认失败'));
            }
        }*/

    /*退款详情*/
    public function refundDetail(){
        $id = $_GET['id'];
        $refund = M('order_crowd')->find($id);
        $crowd = M('crowd')->find($refund['crowd_id']);
        $user = M('member')->find($refund['user_id']);
        $this->assign('goods',$crowd);
        $this->assign('refund',$refund);
        $this->assign('user',$user);
        $this->display();
    }

    /*会员发布众筹资格审核*/
    public function crowdMember(){
        $m = M('crowd_member');
        $count = $m->count();
        $count1 = $m->where(array('is_approved'=>0))->count(); //未审核
        $count1 = $m->where(array('is_approved'=>1))->count(); //审核通过
        $count2 = $m->where(array('is_approved'=>2))->count(); //审核拒绝
        $this->assign('count',$count);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->display();
    }

    /*public function crowdMember(){
        $name = I('post.title');
        if($name){
            $data['name'] = array('like',"%$name%");
            $data['tel'] = array('like',"%$name%");
            $data['_logic'] = 'or';
            $map['_complex'] = $data;
            $this->assign('title',$name);
        }
        $count= M('authentication')->count();
        $this->assign('count',$count);
        $Page = getpage($count, 10);
        $show = $Page->show();//分页显示输出
        $res = M('authentication')->where($data)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('res',$res);
        $this->assign("page", $show);
        $this->display();
    }
*/

    //店铺列表
    public function artcommunity(){
        $user_id = I("param.user_id");
        if ($user_id) {
            $map['member_id'] = $user_id;
        }
        $map['ruzhu_status'] = array('egt',3);
        /* 未审核 */
        $count0 = M('apply')->where(array('shenhe'=>1,'ruzhu_status'=>3))->order('sorting desc')->count();
        $shenhe = I('shenhe');
        if($shenhe == 2){
            $map['shenhe'] = intval($shenhe)-1;
            //$count0 = M('apply')->where($where)->where($map)->count();
            $count0 = M('apply')->where($map)->count();
        }
        /* 审核通过 */
        $count1 = M('apply')->where(array('ruzhu_status'=>5,'shenhe'=>2))->order('sorting desc')->count();
        if($shenhe == 3){
            $map['shenhe'] = intval($shenhe)-1;
            //$count2 = M('apply')->where($where)->where($map)->count();
            $count2 = M('apply')->where($map)->count();
        }
        /* 审核拒绝 */
        $count2 = M('apply')->where(array('ruzhu_status'=>4,'shenhe'=>3))->order('sorting desc')->count();
        if($shenhe == 4){
            $map['shenhe'] = intval($shenhe)-1;
            $count2 = M('apply')->where($map)->count();
            //$count2 = M('apply')->where($where)->where($map)->count();
        }
        $count = M('apply')->where($map)->count();
        //$count = M('apply')->where($where)->where($map)->count();
        $Page = getPage($count,10);
        $show = $Page->show(); //分页显示输出
        $where['ruzhu_status'] = array('egt',3);
        $counts = M('apply')->where($where)->count();
        $num = $Page->firstRow;
        $res = M('apply')->where($map)->limit($Page->firstRow.",".$Page->listRows)->order('sorting desc')->select();
        $i = 0;
        foreach($res as $k=>$v){
            if($i==0){
                $s_id = M('apply')->where($map)->where(array('sorting'=>array('gt',$v['sorting'])))->order('sorting desc')->getField('id');
            }
            if($i==9){
                $x_id = M('apply')->where($map)->where(array('sorting'=>array('lt',$v['sorting'])))->order('sorting desc')->getField('id');
            }
            ++$i;
            $res[$k]['cate'] = M('art_cate')->where(array('id'=>$res[$k]['series_ids']))->getField('name');
        }
        $this->assign('s_id',$s_id);
        $this->assign('x_id',$x_id);
        $this->assign('res',$res);
        //dump($res);exit;
        //$cate = M('art_cate')->alias('a')->join('app_artist b on a.id=b.art_cate')->select();
        $this->assign('count',$counts);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('page',$show);
        $this->display();
    }

    //移动
    public function sorting(){
        $id = I('post.id');
        $s_id = I('post.s_id');
        $type = I('post.type');
        $s_sorting = M('apply')->where(array('id'=>$s_id))->getField('sorting');
        $sorting = M('apply')->where(array('id'=>$id))->getField('sorting');
        $new_s_sorting = $sorting;
        $new_sorting = $s_sorting;
        M()->startTrans();
        $res = M('apply')->where(array('id'=>$s_id))->setField('sorting',$new_s_sorting);
        $res1 = M('apply')->where(array('id'=>$id))->setField('sorting',$new_sorting);
        if($res && $res1){
            M()->commit();
            $this->ajaxReturn(array('status'=>1, "info"=>($type==1)?'上移成功':"下移成功"));
        }else{
            M()->rollback();
            $this->ajaxReturn(array('status'=>0, "info"=>($type==1)?'上移失败':"下移失败"));
        }
    }
    public function return_apply(){
        $id = I('post.id');
        $content = I('post.content');
        $res = M('apply')->where(array('id'=>$id))->save(array('ruzhu_status'=>1,'return'=>$content));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"退回成功！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"退回失败！"));
        }
    }
    public function rzDetail()
    {
        if(IS_AJAX){
            $data = I('post.');
          
           // exit;
            foreach($data as $k=>$v){
                if(empty($v)){
                    unset($data[$k]);
                }
            }
            $info = M('apply')->where(array('id' => $data['id']))->where($data)->count();
            if($info){
                $this->ajaxReturn(array('status'=>0, "info"=>"修改了主页名称和简介！"));
            }
           
            $res1 = M('apply')->where(array('id' => $data['id']))->save($data);
            if($res1){
                $this->ajaxReturn(array('status'=>1, "info"=>"修改了主页名称和简介！"));
            }else{
                $this->ajaxReturn(array('status'=>0, "info"=>"修改失败！"));
            }
        }
        $id = $_GET['id'];
        $res = M('apply')
            ->alias('a')
            ->join('left join app_artist_level b on a.level=b.id')
            ->field('a.*,b.level_name')
            ->where(array('a.id' => $id))
            ->find();
        $level_list = M('artist_level')->where(array('type'=>$res['type']))->select();
        $this->assign('level_list',$level_list);
        $cate = M('art_cate')->select();
        
        $this->assign('cate',$cate);
        $this->assign('res',$res);
        $this->display();
    }
    /**
     * 上传视频
     */
    public function addVideo(){
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
            $data['url'] = I('post.video');
            $data['video'] = I('post.video');
            $id = I('post.id');
            $data['user_id'] = $id;
           //  dump($id);
           // dump($data['video']);exit;
            // if($id){
            //     if(!$data['url']){
            //         unset($data['url']);
            //     }
            //     $data['id'] = $id;
            //     $res = M('apply')->where('id',$id)->save(['video'=>$data['video']]);
            // }else{
            //     $res = M('apply')->where('id',$id)->update(['video'=>$data['video']]);
            // }
            
            $res = M('apply_video')->add($data);
            //dump($res);exit;
            if($res){
                $this->redirect('/admin/Community/artcommunity');
            }else{
                $this->error('操作失败','/admin/Community/artcommunity');
            }
        }
        
        $av = M('apply')->find($id);
        $this->assign('cache',$av);
        $this->display();
    }
    public function communityAgree(){
        $content = I('post.content');
        $res = M('apply')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'ruzhu_status'=>5,'feedback'=>$content,'return'=>''));
        $info = M('apply')->where(array('id'=>$_POST['id']))->field('user_id,type')->find();
        $user  = M('member')->where(array('id'=>$info['user_id']))->setField(array('user_type'=>2));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function communityDisagree(){
        $res = M('apply')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>3,'ruzhu_status'=>4,'feedback'=>$_POST['content'],'return'=>''));
        //$res1 = M('apply')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    //店铺列表
    public function crowdCheck(){

        $user_id = I("param.user_id");
        if ($user_id) {
            $map['member_id'] = $user_id;
        }
        $map['ruzhu_status'] = array('EGT',2);
        /* 未审核 */
        $count0 = M('crowd_apply')->where(array('shenhe'=>1,'ruzhu_status'=>2))->count();
        $shenhe = I('shenhe');
        /*if($shenhe == 2){
            $map['shenhe'] = intval($shenhe)-1;
            //$count0 = M('apply')->where($where)->where($map)->count();
            $count0 = M('crowd_apply')->where($map)->count();
        }*/
        /* 审核通过 */
        $count1 = M('crowd_apply')->where(array('ruzhu_status'=>5,'shenhe'=>2))->count();
        /*if($shenhe == 3){
            $map['shenhe'] = intval($shenhe)-1;
            //$count1 = M('apply')->where($where)->where($map)->count();
            $count1 = M('crowd_apply')->where($map)->count();
        }*/
        /* 审核拒绝 */
        $count2 = M('crowd_apply')->where(array('ruzhu_status'=>4,'shenhe'=>3))->count();
        /*if($shenhe == 4){
            $map['shenhe'] = intval($shenhe)-1;
            $count2 = M('crowd_apply')->where($map)->count();
            //$count2 = M('apply')->where($where)->where($map)->count();
        }*/
        if($shenhe!=''){
            $map['shenhe'] = $shenhe;
        }
        //dump($shenhe);exit;
        $count = M('crowd_apply')->where($map)->count();
        //$count = M('apply')->where($where)->where($map)->count();
        $Page = getPage($count,10);
        $show = $Page->show(); //分页显示输出
        $where['ruzhu_status'] = array('EGT',2);
        $counts = M('crowd_apply')->where($where)->count();
        //$res1 = M('art_cate')->where(array('art_cate'=>$res['art_cate']))
        $res = M('crowd_apply')->where($map)->limit($Page->firstRow.",".$Page->listRows)->select();
        //$res = M('apply')->where($where)->where($map)->limit($Page->firstRow.",".$Page->listRows)->select();
        //dump($count);exit;
       /* foreach($res as $k=>$v){
            $res[$k]['cate'] = M('art_cate')->where(array('id'=>$res[$k]['series_ids']))->getField('name');
        }*/


        $this->assign('res',$res);
        //dump($count1);exit;
        //$cate = M('art_cate')->alias('a')->join('app_artist b on a.id=b.art_cate')->select();
        $this->assign('count',$counts);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('page',$show);
        $this->display();
    }

    public function crowdDetail()
    {
        $id = $_GET['id'];
        $res = M('crowd_apply')
            //->alias('a')
           // ->join('left join app_artist_level b on a.level=b.id')
            //->field('a.*,b.level_name')
            ->where(array('id' => $id))
            ->find();
        $this->assign('res',$res);

        $this->display();
    }

    public function crowdAgree(){
        $content = I('post.content');
        $res = M('crowd_apply')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'ruzhu_status'=>5,'feedback'=>$content));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function crowdDisagree(){
        $res = M('crowd_apply')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>3,'ruzhu_status'=>4,'feedback'=>$_POST['content']));
        //$res1 = M('apply')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }



    /*public function artcommunity(){

        $user_id = I("param.user_id");
        if ($user_id) {
            $map['member_id'] = $user_id;
        }
        /* 未审核 */
        /*$count0 = M('artist')->where(array('shenhe'=>0))->count();
        $shenhe = I('shenhe');
        if($shenhe == 1){
            $map['shenhe'] = intval($shenhe)-1;
            $count0 = M('artist')->where($map)->count();
        }*/
        /* 审核通过 */
        /*$count1 = M('artist')->where(array('is_del'=>0,'shenhe'=>1))->count();
        if($shenhe == 2){
            $map['shenhe'] = intval($shenhe)-1;
            $count2 = M('artist')->where($map)->count();
        }*/
        /* 审核拒绝 */
        /*$count2 = M('artist')->where(array('is_del'=>0,'shenhe'=>2))->count();
        if($shenhe == 3){
            $map['shenhe'] = intval($shenhe)-1;
            $count2 = M('artist')->where($map)->count();
        }
        $count = M('artist')->where($map)->count();
        $Page = getPage($count,10);
        $show = $Page->show(); //分页显示输出
        $counts = M('artist')->count();
        //$res1 = M('art_cate')->where(array('art_cate'=>$res['art_cate']))
        $res = M('artist')->where($map)->limit($Page->firstRow.",".$Page->listRows)->select();
        foreach($res as $k=>$v){
            $res[$k]['cate'] = M('art_cate')->where(array('id'=>$res[$k]['art_cate']))->getField('name');
        }

        //dump($res);exit;
        $this->assign('res',$res);
        //dump($res);exit;
        //$cate = M('art_cate')->alias('a')->join('app_artist b on a.id=b.art_cate')->select();
        $this->assign('count',$counts);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('page',$show);
        $this->display();*/
   //}*/

    /*public function communityAgree(){
        $res = M('artist')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }*/

    /*public function communityDisagree(){
        $res = M('artist')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
		$res1 = M('artist')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }*/

   /* public function communityDetail(){
        $id = $_GET['id'];
        $res = M('apply')->where(array('id'=>$id))->find();
        $res1 = M('member')->where(array('id'=>$res['member_id']))->find();
        $art_cate = M('art_cate')->where(array('id'=>$res['art_cate']))->getField('name');
        $artist_level = M('artist_level')->where(array('id'=>$res['level_id']))->getField('level_name');
        $school_cate = M('school_cate')->where(array('id'=>$res['school_id']))->getField('name');
        //dump($res);exit;
        $this->assign('art_cate',$art_cate);
        $this->assign('artist_level',$artist_level);
        $this->assign('school_cate',$school_cate);
        $this->assign('res1',$res1);
        $this->assign('res',$res);
        $this->display();
    }*/

    /*public function rzDetail()
    {
        $id = $_GET['id'];
        $member = M('artist')->where(array('id' => $id))->getField('member_id');
        $res = M('authentication')->where(array('member_id' => $member))->find();
        $res1 =  M('authentication')->where(array('member_id' => $member,'remind_type'=>0))->find();
        $res2 =  M('authentication')->where(array('member_id' => $member,'remind_type'=>1))->find();
        $res3 =  M('authentication')->where(array('member_id' => $member,'remind_type'=>2))->find();
        if($res['remind_type'] == 0){
            $res1 = $res;
        }elseif($res['remind_type']== 1){
            $res1[0] = $res;
            $res1[1] = M('authentication')->where(array('member_id'=>$member,'remind_type'=>2))->find();
        }elseif($res['remind_type']== 2){
            $res1[1] = $res;
            $res1[0] = M('authentication')->where(array('member_id'=>$member,'remind_type'=>1))->find();
        }
        //dump($res3);exit;
        $this->assign('res',$res1);
        $this->assign('res2',$res2);
        $this->assign('res3',$res3);
        $this->display();
    }*/

    /*public function communityGoods(){
        // 未审核
        $count0 = M('artist_goods')->where(array('is_shenhe'=>0))->count();
        $is_shenhe = I('is_shenhe');
        if($is_shenhe == 1){
            $map['is_shenhe'] = intval($is_shenhe)-1;
            $count0 = M('artist_goods')->where($map)->count();
        }
        // 审核通过
        $count1 = M('artist_goods')->where(array('is_del'=>0,'is_shenhe'=>1))->count();
        if($is_shenhe == 2){
            $map['is_shenhe'] = intval($is_shenhe)-1;
            $count1 = M('artist_goods')->where($map)->count();
        }
        // 审核拒绝
        $count2 = M('artist_goods')->where(array('is_del'=>0,'is_shenhe'=>2))->count();
        if($is_shenhe == 3){
            $map['is_shenhe'] = intval($is_shenhe)-1;
            $count2 = M('artist_goods')->where($map)->count();
        }
        $counts = M('artist_goods')->count();
        $res = M('artist_goods')->alias("a")->join("app_artist b on a.artist_id=b.id")->where($map)->select();
        $count = M('artist_goods')->where($map)->count();

        //$shop = M('gallery')->where(array('id'=>$res['gallery_id']))->Field('name');
        //dump($shop);exit;
        $Page = getPage($count,10);
        $show = $Page->show();
        $this->assign('res',$res);
        //$this->assign('shop',$shop);
        $this->assign('count',$counts);
        $this->assign('count0',$count0);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('page',$show);
        $this->display();
    }*/

   /* public function communityGoodsAgree(){
        $res = M('artist_goods')->where(array('id'=>$_POST['id']))->save(array('is_shenhe'=>1));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    public function communityGoodsDisagree(){
        $res = M('artist_goods')->where(array('id'=>$_POST['id']))->save(array('is_shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"拒绝审核！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"拒绝审核失败！"));
        }
    }

    public function communityGoodsDetail(){
        $res = M('artist_goods')->select();
        $this->assign('res',$res);
        $this->display();
    }*/


    /*public function canzhan(){
        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['name'] = array('like',"%$name%");
        }

        $m   = M("cz");

        $is_sale = I("is_sale");
        $map['is_del']=0;
        // 未审核

        $count1=$m->where(array("shenhe"=>0,'is_del'=>0))->count();
        if($is_sale==1){
            $map['shenhe'] = 0;
            //$count3=$m->where($map)->count();
        }


        // 审核通过

        $count2=$m->where(array("shenhe"=>1,'is_del'=>0))->count();
        if($is_sale==2){
            $map['shenhe'] = 1;
            //$count4=$m->where($map)->count();
        }

        //审核拒绝

        $count3=$m->where(array("shenhe"=>2,'is_del'=>0))->count();
        if($is_sale==3){
            $map['shenhe'] = 2;
            //$count5=$m->where($map)->count();
        }

        //商品数量
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出

        $res = M('cz')->where($map)->order("create_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count1",$count1 );
        $this->assign("count2",$count2 );
        $this->assign("count3",$count3 );
        $this->assign("res", $res);

        $this->display();
    }*/


    //审核通过
    public function czAgree(){
        $res = M('cz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>1));
        //$data['shenhe'] = 1;
        //$res = M('cz')->where(array('id'=>$_POST['id']))->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    //审核拒绝
    public function czDisagree(){
        $res = M('cz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }
/*
    public function canzhanDetail(){
        $id = I('get.id');
        $res = M('cz')->where(array('id'=>$id))->find();
        $this->assign("res", $res);
        $img = M('cz_pic')->where(array('cz_id'=>$res['id']))->select();
        $this->assign("img", $img);

        $series = M('series')->where(array('id'=>$res['series']))->find();
        $this->assign("series", $series);

        //print_r($res);
        $this->display();
    }*/


    /*public function banzhan(){
        $name=trim(I('get.name'));
        $this->assign('title',$name);
        //查询商品名称
        if($name)
        {
            $map['name'] = array('like',"%$name%");
        }

        $m   = M("bz");

        $is_sale = I("is_sale");
        $map['is_del']=0;
        // 未审核

        $count1=$m->where(array("shenhe"=>0,'is_del'=>0))->count();
        if($is_sale==1){
            $map['shenhe'] = 0;
            //$count3=$m->where($map)->count();
        }


        // 审核通过

        $count2=$m->where(array("shenhe"=>1,'is_del'=>0))->count();
        if($is_sale==2){
            $map['shenhe'] = 1;
            //$count4=$m->where($map)->count();
        }

        //审核拒绝

        $count3=$m->where(array("shenhe"=>2,'is_del'=>0))->count();
        if($is_sale==3){
            $map['shenhe'] = 2;
            //$count5=$m->where($map)->count();
        }

        //商品数量
        $count=$m->where($map)->count();
        $countss = $m->where(array('is_del'=>0))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出

        $res = M('bz')->where($map)->order("create_time desc")->limit($Page->firstRow.','.$Page->listRows)->select();

        $this->assign("page",$show);
        $this->assign("counts", $countss);//全部
        $this->assign("count1",$count1 );
        $this->assign("count2",$count2 );
        $this->assign("count3",$count3 );
        $this->assign("res", $res);

        $this->display();
    }*/


    //审核通过
    public function bzAgree(){
        $data['shenhe'] = 1;
        $res = M('bz')->where(array('id'=>$_POST['id']))->save($data);
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核通过！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核失败！"));
        }
    }

    //审核拒绝
    public function bzDisagree(){
        $res = M('bz')->where(array('id'=>$_POST['id']))->save(array('shenhe'=>2,'disagree_detail'=>$_POST['disagree_detail']));
        if($res){
            $this->ajaxReturn(array('status'=>1, "info"=>"审核拒绝！"));
        }else{
            $this->ajaxReturn(array('status'=>0, "info"=>"审核拒绝失败！"));
        }
    }

    /*public function banzhanDetail(){
        $id = I('get.id');
        $res = M('bz')->where(array('id'=>$id))->find();
        $this->assign("res", $res);

        $series = M('series')->where(array('id'=>$res['series']))->find();
        $this->assign("series", $series);

        //print_r($res);
        $this->display();
    }*/

    public function overseas(){
        $count1=M('art_train')->where(array("is_sale"=>1,'type'=>2))->count();
        $is_sale = I("is_sale");
        $map['type'] = 2;
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
            $count1 =M('art_train')->where($map)->count();
        }
        /* 下架*/
        $count2=M('art_train')->where(array("is_del"=>0, "is_sale"=>0,'type'=>2))->count();
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
            $count2=M('art_train')->where($map)->count();
        }
        $counts = M('art_train')->where(array("is_del"=>0,'type'=>2))->count();
        $count = M('art_train')->where($map)->count();
        $Page  = getpage($count,10);
        $res = M('art_train')->where($map)->limit($Page->firstRow.",".$Page->listRows)->select();
        $show  = $Page->show();//分页显示输出
        $this->assign('res',$res);
        $this->assign('count',$counts);
        $this->assign("count1",$count1);  //出售
        $this->assign("count2",$count2 );   //未出售
        $this->assign("page",  $show);
        $this->display();
    }


    public function addOverseas(){
        if (IS_AJAX){
            $m      = M("art_train");
            $data   = I("post.");

            if(!$data['logo']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传logo图片！';
                $this->ajaxReturn($dataAj);die;
            }

            if(!$data['detail_img']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请上传作品展示图！';
                $this->ajaxReturn($dataAj);die;
            }


            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写简介内容！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['type'] = 2;
            $data['create_time'] = time();
            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $res = $m->add($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '新增成功！';
                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '新增失败！';
            $this->ajaxReturn($dataAj);die;
            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        /*if(IS_POST){
            $m      = M("art_train");
            $data   = I("post.");
            $data['create_time'] = time();
            $res = $m->add($data);
            if($res){
                $this->success("新增成功！",U('Admin/Community/train'));

            }else{
                $this->error("新增失败！",U('Admin/Community/train'));
            }
            $this->redirect('Admin/Community/train');
        }*/
        $this->display();
    }

    public function editOverseas(){
        if (IS_AJAX){
            $m      = M("art_train");
            $data   = I("post.");

            if(!$data['content']){
                $dataAj['status'] = 0;
                $dataAj['info'] = '请填写简介内容！';
                $this->ajaxReturn($dataAj);die;
            }

            $data['start'] = strtotime($data['start']);
            $data['end'] = strtotime($data['end']);
            $id                 = $_POST['id'];

            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $dataAj['status'] = 1;
                $dataAj['info'] = '修改成功！';
                $this->ajaxReturn($dataAj);die;
                //$this->success("新增成功！",U('Admin/Community/show'));

            }
            $dataAj['status'] = 0;
            $dataAj['info'] = '修改失败！';
            $this->ajaxReturn($dataAj);die;
            //$this->error("新增失败！",U('Admin/Community/show'));
        }
        /*if(IS_POST){
            $m                  = M("art_train");
            $data               = I("post.");
            $id                 = $_POST['id'];

            $res = $m->where(array("id"=>$id))->save($data);
            if($res){
                $this->success("修改成功！",U('Admin/Community/train'));
            } else {
                $this->error("修改失败！",U('Admin/Community/train'));
            }
            $this->redirect('Admin/Community/train');
        }*/
        $res = M('art_train')->where(array('id'=>$_GET['id']))->find();
        $this->assign('res',$res);
        $this->display();
    }
    public function changeStatush(){
        if(IS_AJAX){
            $id   = I("post.id");
            $item = I("post.item");
            $m    = M("art_train");
            $res  = $m->where(array("id"=>$id))->find();
            if(!$res){
                $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
            }

            $res2 = $m->where(array("id"=>$id))->setField($item, 1-intval($res[$item]));/*array('$item'=>'ThinkPHP','email'=>'ThinkPHP@gmail.com');*/
            if($res2){
                $sale=$m->where(array("id"=>$id))->getfield("is_sale");
                if($sale==1)
                {
                    $m->where(array("id"=>$id))->setField('sale_at',time());
                }else{
                    $m->where(array("id"=>$id))->setField('sale_at'."");
                }
                $arr = array(1,2);
                $this->ajaxReturn(array("status"=>$arr[$res[$item]]));
            }
            $this->ajaxReturn(array("status"=>0 ,"info"=>"修改失败！"));
        }
    }
    public function delOverseas(){
        $id  = $_GET['id'];
        $res = M("art_train")->where(array("id"=>$id))->delete();
        if($res!==false){
            $this->success("删除成功！");die;
        }
        $this->error("删除失败！");die;
    }

    public function Overseaslist(){
        $train_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }
        $count=M('tel_train')->where($map)->where(array("train_id"=>$train_id,'type'=>2))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('tel_train')->where($map)->where(array("train_id"=>$train_id,'type'=>2))->limit($Page->firstRow.",".$Page->listRows)->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function trainlist(){
        $train_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }
        $count=M('tel_train')->where($map)->where(array("train_id"=>$train_id,'type'=>1))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('tel_train')->where($map)
            ->field('app_tel_train.*, app_train_order.pay_status')
            ->join('left join app_train_order on app_tel_train.order_id = app_train_order.id')
            ->where(array("app_tel_train.train_id"=>$train_id,'app_tel_train.type'=>1))
            ->limit($Page->firstRow.",".$Page->listRows)
            ->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    public function showlist(){
        $show_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);

        $is_sale = I('get.is_sale');
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }

        if($is_sale){
            $map['shenhe'] = $is_sale-1;
        }
        $count=M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('cz')->where($map)->where(array("show_id"=>$show_id))->limit($Page->firstRow.",".$Page->listRows)->select();
        foreach ($res as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $res[$k]['classname'] = $series['classname'];
        }

        unset($map['shenhe']);
        $counts = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $map['shenhe']=0;
        $count1 = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $map['shenhe']=1;
        $count2 = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();
        $map['shenhe']=2;
        $count3 = M('cz')->where($map)->where(array("show_id"=>$show_id))->count();

        $this->assign('counts',$counts);
        $this->assign('count1',$count1);
        $this->assign('count2',$count2);
        $this->assign('count3',$count3);

        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    //观展列表
    public function exhibition(){
        $train_id = I('get.id');
        $count=M('tel_gtrain')->where(array("show_id"=>$train_id))->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $res = M('tel_gtrain')->where(array("show_id"=>$train_id))->limit($Page->firstRow.",".$Page->listRows)->select();
        $this->assign('res',$res);
        $this->assign("page",  $show);
        $this->display();
    }

    //展览导出
    public function indexshow(){
        $is_sale = I("is_sale");
        if($is_sale==2){
            $map['is_sale'] = 1;
        }
        if($is_sale==1){
            $map['is_sale'] = 2;
        }
        $info = M('art_show')->where($map)->select();
        $name ="展览详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,展览标题,地点,作者,发布者,联系电话,是否上架,状态,观展人数";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['title']    = $val['title']?$val['title']:"无";
            $data['address']    = $val['address']?$val['address']:"无";
            $data['auth']      =$val['auth']?$val['auth']:"无";
            if($val['user_id']){
                $data['user_id']=$val['auth']?$val['auth']:"无";
            }else{
                $data['user_id']='平台';
            }
            $data['tel']  = $val['tel']?$val['tel']:"无";
            if($val['is_sale']==1){
                $data['is_sale']='上架';
            }else{
                $data['is_sale']='下架';
            }
            switch($val['status']){//0：，1：，2：,3:
                case 1:
                    $data['status']="待审核";
                    break;
                case 2:
                    $data['status']="审核通过";
                    break;
                case 3:
                    $data['status']='审核拒绝';
                    break;
                default:
                    $data['pay_way']='未知';
                    break;
            }
            $count = M('tel_gtrain')->where(array('show_id'=>$val['id']))->count();
            $data['gshow']  = $count?$count.'人':"0人";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    //参展导出
    public function indexcz(){
        $show_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');

        $is_sale = I('get.is_sale');
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }

        if($is_sale){
            $map['shenhe'] = $is_sale-1;
        }
        $info = M('cz')->where($map)->where(array("show_id"=>$show_id))->select();
        foreach ($info as $k=>$v){
            $series = M('series')->where(array('id'=>$v['series']))->find();
            $info[$k]['classname'] = $series['classname'];
        }
        $info_show = M('art_show')->where(array('id'=>$show_id))->find();
        $name ="参展详情".date("Y.m.d");
        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,展览标题,地点,参展姓名,作品类型,联系电话,微信,邮箱,状态,申请时间";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['title']    = $info_show['title']?$info_show['title']:"无";
            $data['address']    = $info_show['address']?$info_show['address']:"无";
            $data['name']      =$val['name']?$val['name']:"无";
            $data['classname']  = $val['classname']?$val['classname']:"无";
            $data['tel']  = $val['tel']?$val['tel']:"无";
            $data['wx']  = $val['wx']?$val['wx']:"无";
            $data['email']  = $val['email']?$val['email']:"无";
            switch($val['shenhe']){//0：，1：，2：,3:
                case 0:
                    $data['shenhe']="待审核";
                    break;
                case 1:
                    $data['shenhe']="审核通过";
                    break;
                case 2:
                    $data['shenhe']='审核拒绝';
                    break;
                default:
                    $data['pay_way']='未知';
                    break;
            }
            $data['create_time']  = $val['create_time']?date('Y-m-d H:i:s',$val['create_time']):"无";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    //培训 海外交流 导出
    public function indeTrain(){
        $is_sale = I("get.is_sale");
        $type = I("get.type");
        $map['type'] = $type;
        if($is_sale==2){
            $map['is_sale'] = intval($is_sale)-1;
        }
        if($is_sale==1){
            $map['is_sale'] = intval($is_sale)-1;
        }
        $info = M('art_train')->where($map)->select();
        if($type==1){
            $name ="培训详情".date("Y.m.d");
        }else{
            $name ="海外交流详情".date("Y.m.d");
        }

        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,标题,地点,组织人,开始时间,结束时间,状态,报名人数";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['title']    = $val['title']?$val['title']:"无";
            $data['address']    = $val['address']?$val['address']:"无";
            $data['auth']      =$val['auth']?$val['auth']:"无";
            $data['start']  = $val['start']?date('Y-m-d H:i:s',$val['start']):"无";
            $data['end']  = $val['end']?date('Y-m-d H:i:s',$val['end']):"无";
            switch($val['is_sale']){//0：，1：，2：,3:
                case 0:
                    $data['is_sale']="下架";
                    break;
                case 1:
                    $data['is_sale']="上架";
                    break;
                default:
                    $data['is_sale']='未知';
                    break;
            }
            $count = M('tel_train')->where(array('train_id'=>$val['id']))->count();
            $data['ren']  = $count?$count.'人':"0人";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    //众筹记录列表 未完成
    public function crowdlist(){
        $crowd_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);
        if($title){
            $map_h['b.realname']=array('like',"%$title%");
            $map_h['b.telephone']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }
        $res = M('order_crowd')
            ->alias('a')
            ->join('left join app_member b on a.user_id=b.id')
            ->join('left join app_crowd c on a.crowd_id=c.id')
            ->join('left join app_crowd_apply d on a.shop_id=d.id')
            ->field('a.*,b.realname,b.person_name,b.telephone,c.logo_pic,c.goods_name,c.goods_cap,c.mini,d.qy_name')
            //->where(array('crowd_id'=>$crowd_id))
            ->where(array('crowd_id'=>$crowd_id,'pay_status'=>1))
            ->select();
        //dump($res);exit;
        $this->assign('res',$res);
        $this->display();
    }

    //众筹记录导出 未完成
    public function indecrowd(){
        $crowd_id = I('get.id');
        $title = trim(trim(I('get.title')),'+');
        $this->assign('title',$title);
        if($title){
            $map_h['name']=array('like',"%$title%");
            $map_h['tel']=array('like',"%$title%");
            $map_h['_logic'] = 'or';
            $map['_complex'] = $map_h;
        }
        $info = M('art_train')->where($map)->select();
        $name ="众筹记录详情".date("Y.m.d");

        @header("Content-type: application/unknown");
        @header("Content-Disposition: attachment; filename=" . $name.".csv");
        $title="序号,标题,地点,组织人,开始时间,结束时间,状态,报名人数";
        $title= iconv('UTF-8','GB2312//IGNORE',$title);
        echo $title . "\r\n";
        foreach($info as $key=>$val){
            $data['id']			 =$val['id'];
            $data['title']    = $val['title']?$val['title']:"无";
            $data['address']    = $val['address']?$val['address']:"无";
            $data['auth']      =$val['auth']?$val['auth']:"无";
            $data['start']  = $val['start']?date('Y-m-d H:i:s',$val['start']):"无";
            $data['end']  = $val['end']?date('Y-m-d H:i:s',$val['end']):"无";
            switch($val['is_sale']){//0：，1：，2：,3:
                case 0:
                    $data['is_sale']="下架";
                    break;
                case 1:
                    $data['is_sale']="上架";
                    break;
                default:
                    $data['is_sale']='未知';
                    break;
            }
            $count = M('tel_train')->where(array('train_id'=>$val['id']))->count();
            $data['ren']  = $count?$count.'人':"0人";
            $tmp_line = str_replace("\r\n", '', join(',', $data));
            $tmp_line= iconv('UTF-8','GB2312//IGNORE',$tmp_line);
            echo $tmp_line . "\r\n";
        }
        exit;
    }

    public function slogan(){
        if (IS_POST) {
            $edit_notice = M("slogan");
            //print_r($_POST);exit;
            $count = $edit_notice->count();

            if($count == 0){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Community/slogan', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Community/slogan', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Community/slogan', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Community/slogan', '', false));exit;
                }
            }
        }

        $id= M('slogan')->getField('id');

        $res = M("slogan")->where(array('id'=>$id))->find();
        $this->assign('res',$res);
        $this->display();
    }

    //设置入驻协议
    public function protocols(){
        if (IS_POST) {
            $edit_notice = M("protocol");
            //print_r($_POST);exit;
            $count = $edit_notice->where(array('id'=>2))->find();

            if(!$count){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Community/protocols', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Community/protocols', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Community/protocols', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Community/protocols', '', false));exit;
                }
            }
        }

        $res = M("protocol")->where(array('id'=>2))->find();
        $this->assign('res',$res);
        $this->display();
    }

    //设置发布众筹协议
    public function protocol(){
        if (IS_POST) {
            $edit_notice = M("protocol");
            //print_r($_POST);exit;
            $count = $edit_notice->where(array('id'=>3))->count();

            if(!$count){
                $result = $edit_notice->add(I('post.'));
                if($result){
                    $this->success("编辑成功!", U('Admin/Community/protocol', '', false));exit;
                }else{
                    $this->error("编辑失败", U('Admin/Community/protocol', '', false));exit;
                }
            }else{

                $result  = $edit_notice->save( I("post.") );

                if ($result) {
                    $this->success("编辑成功!", U('Admin/Community/protocol', '', false));exit;
                } else {
                    $this->error("编辑失败", U('Admin/Community/protocol', '', false));exit;
                }
            }
        }

        $res = M("protocol")->where(array('id'=>3))->find();
        $this->assign('res',$res);
        $this->display();
    }

    public function changeStatus(){
        if(IS_AJAX){
            $id = I("id");
            $m = M("apply");
            $res = $m->where("id=$id")->field("id,is_show")->find();
            if($res){
                $res['is_show'] = $res['is_show']==1?0:1;
                $res2 = $m->save($res);
                if($res2){
                    $arr = array("显示","隐藏");
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
	public function ysjdelete(){
		if($_GET['delid']){
			//var_dump($_GET['delid']);
			//die();
			$data['id']=$_GET['delid'];
			$data['shenhe']='0';
			$res=M('apply')->save($data); 
			if($res){
				 $this->success('删除成功', 'http://www.zhejiangart.com.cn/Admin/Community/artcommunity');
			}
		}
		if($_GET['addid']){
			//var_dump($_GET['addid']);
			//die();
			$data['id']=$_GET['addid'];
			$data['shenhe']='1';
			$res=M('apply')->save($data); 
			if($res){
				 $this->success('请重新审核通过', 'http://www.zhejiangart.com.cn/Admin/Community/artcommunity');
			}
		}
	}
}
