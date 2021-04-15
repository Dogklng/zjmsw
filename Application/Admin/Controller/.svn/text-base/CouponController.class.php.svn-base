<?php
namespace Admin\Controller;
//use Think\Controller;
use Common\Controller\CommonController;
class CouponController extends CommonController {

    //优惠券列表
    public function couponList(){
        $res = M('coupon')->select();
        $this->assign('res',$res);
        $this->display();
    }

    //添加优惠券
    public function addCoupon(){
        if(IS_AJAX){
            $data = I('post.');
            if ($data['over_time'] == '') {
                $this->ajaxReturn(array('status'=>0,'info'=>"过期时间不能为空！"));
            }
            /*if ($data['integral'] == '') {
                $this->ajaxReturn(array('status'=>0,'info'=>"积分售价不能为空！"));
            }*/
            $data['coupon_no'] = createNonceStr();
            $data['create_at'] = time();
            $res =  M("coupon")->add($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"添加成功！"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"添加失败！"));
            }
        }
    }

    //修改优惠券
    public function editCoupon(){
        if(IS_AJAX){
            $data = I('post.');
            if ($data['over_time'] == '') {
                $this->ajaxReturn(array('status'=>0,'info'=>"过期时间不能为空！"));
            }
            /*if ($data['integral'] == '') {
                $this->ajaxReturn(array('status'=>0,'info'=>"积分售价不能为空！"));
            }*/
            $res =  M("coupon")->where(array('id'=>$data['id']))->save($data);
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"修改成功！"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"修改失败！"));
            }
        }
    }


    //删除优惠券
    public function delCoupon(){
        if(IS_AJAX){
            $id = I('post.id');
            $res =  M("coupon")->where(array('id'=>$id))->delete();
            if($res){
                $this->ajaxReturn(array('status'=>1,'info'=>"删除成功！"));
            }else{
                $this->ajaxReturn(array('status'=>0,'info'=>"删除失败！"));
            }
        }
    }
    /**
     * 优惠券赠送记录 zj
     */
    public function CouponRecord(){
        $count=M('link_coupon')->count();
        $Page  = getpage($count,8);
        $show  = $Page->show();//分页显示输出
        $couponList = M('link_coupon')->alias('a')
            ->join('app_coupon b ON b.id = a.coupon_id')
            ->join('app_member c ON c.id = a.user_id')
            ->field('a.status,a.get_time,a.coupon_id,b.over_time,b.money,b.coupon_no,b.condition,b.condition1,b.type,c.nickname,c.wx_img')
            ->order('b.create_at desc')
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();//我的券包
        $this->assign('couponList',$couponList);
        $this->assign("page",$show);
        $this->display();
    }








}
?>