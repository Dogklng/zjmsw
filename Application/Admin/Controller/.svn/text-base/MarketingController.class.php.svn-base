<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class MarketingController extends CommonController {
	
    public function index(){
        $map = array();
        $price = trim(I('price'));
        if(!empty($price)){
            $this->assign('price',$price);
//            $map['price'] = array('like','%'.$car_num.'%');
            $map['price'] = $price;
        }
        $is_show = trim(I('is_show'));
        if(!empty($is_show)){
            $this->assign('is_show',$is_show);
//            $map['price'] = array('like','%'.$car_num.'%');
            if($is_show == 2){
                $is_show = 0;
            }
            $map['is_show'] = $is_show;
        }
        $is_order_price = I('is_order_price');
        if(!empty($is_order_price)){
            $this->assign('is_order_price',$is_order_price);
            $map['is_order_price'] = $is_order_price;
        }
        $integral = I('integral');
        if(!empty($car_unit)){
            $this->assign('integral',$integral);
            $map['integral'] = $integral;
        }
        $starttime = trim(I('starttime'));
        if(!empty($starttime)){
            $this->assign('starttime',$starttime);
            $map['_string'] = "to_days(start_time) >= to_days(from_unixtime(".strtotime($starttime)."))";
        }
        $endtime = trim(I('endtime'));
        if(!empty($endtime)){
            $this->assign('endtime',$endtime);
            if(!empty($map['_string'])){
                $map['_string'] .= " and to_days(end_time) <= to_days(from_unixtime(".strtotime($endtime)."))";
            }else{
                $map['_string'] = "to_days(end_time) <= to_days(from_unixtime(".strtotime($endtime)."))";
            }
        }
        $title = trim(I('title'));
        if(!empty($title)){
            $this->assign('title',$title);
            $map['title'] = array('like','%'.$title.'%');
        }

        $action=M('Coupon');
        $count = $action->where($map)->count();
        $p = getpage($count,10);
        $page = $p->show();
        $res = $action->where($map)->order('id desc')->limit($p->firstRow,$p->listRows)->select();
//        echo M()->getLastSql();
        $this->assign('page',$page);
        $this->assign('goodslist',$res);
        $this->display();












//		$is_show=I('get.is_show');
		
//        $action=M('Coupon');
//        $rsdate=$action->getCouponList();
//        $rs=$rsdate['list'];
//
		
//		$counts=$action->where('1=1')->count();
//		$count1=$action->where('is_show=1')->count();
//		$count2=$action->where('is_show=2')->count();
		
		
		
//        $this->assign('categorylist',$categorylist);
//        $this->assign('goodslist',$rs);
//		$this->assign('count',$rsdate['count']);
//		$this->assign('counts',$counts);
//		$this->assign('count1',$count1);
//		$this->assign('count2',$count2);
//		$this->assign('is_show',empty($is_show)?1:$is_show);
//        $this->assign('page',$rsdate['page']);
//        $this->assign('munetype',8);
//        $this->display();
    }


    public function add()
    {
		$action=M('coupon');
		$title=I('post.title');
		if (IS_POST) {
			$data['goods_id'] = implode(',',$_POST['goodsid']);
			$data['classid']=I('post.classid');
			$data['title']=$title;
			$data['price']=I('post.price');
			$data['is_order']=I('post.is_order');
			$data['is_order_price']=I('post.is_order_price');
			if($data['is_order']==1){$data['is_order_price']='';}
			$data['kucun']=I('post.kucun');
			$data['integral']=I('post.integral');
			$data['pic']=I('post.pic');
			$data['rank']=I('post.rank');
			$data['exchange']=I('post.exchange');
			$data['is_exchange']=I('post.is_exchange');
			$data['content']=I('post.content');
			$data['start_time']=I('post.start_time');
			$data['end_time']=I('post.end_time');
			$data['addtime']=Gettime();
			$data['is_show']=I('post.is_show');
			$data['day']=I('post.day');
			$data['cate_type']=I('post.cate_type');
			$result=$action->add($data);
			if ($result) {
				$this->success('添加成功',U('/Admin/Marketing/index'));exit;
            } else {
                $this->error('添加失败');
            }
        }
		$goods = M('goods');
		$goodsRecord = $goods->where(array('is_sale'=>1))->select();
//		p($goodsRecord);
		$this->assign('goods', $goodsRecord);
        $this->assign('munetype', 8);
        $this->display();

    }
	
    public function delmarketing(){
        $couponid=I('get.id');
		$couponids=I('get.ids');
        $m = M("coupon"); 
		if($couponid){
        $rs=$m->where("id=$couponid")->setField('is_show',2); 
		}else{
			$rs=$m->where("id=$couponids")->delete(); 
			}
        if($rs){
            $this->success('作废成功',U('/Admin/Marketing/index'));
        }else{
            $this->error('作废失败');
        }
    }

    public function edit(){

        $markid=I('get.id');
		
		$action=M('coupon');
		
		$title=I('post.title');
		if(IS_POST){
			$data['goods_id'] = implode(',',$_POST['goodsid']);
			$data['title']=$title;
			$data['price']=I('post.price');
			$data['is_order']=I('post.is_order');
			$data['is_order_price']=I('post.is_order_price');
			if($data['is_order']==1){$data['is_order_price']='';}
			$data['kucun']=I('post.kucun');
            $data['integral']=I('post.integral');
			$data['start_time']=I('post.start_time');
			$data['end_time']=I('post.end_time');
			//$data['pic']=I('post.pic');
			$data['rank']=I('post.rank');
			$data['exchange']=I('post.exchange');
			$data['is_exchange']=I('post.is_exchange');
			$data['content']=I('post.content');
            $data['is_show']=I('post.is_show');
            $data['day']=I('post.day');
            $data['cate_type']=I('post.cate_type');
			$result=$action->where('id='.$markid)->save($data);
			
			if($result){
				$this->success('修改成功',U("/Admin/Marketing/index"));exit;
				}else{
						$this->success('没有修改',U("/Admin/Marketing/index"));exit;
					}
			}
		
		$goodsModel = M('goods');

		$goodsRecord = $goodsModel->where(array('is_sale'=>1))->select();
		$this->assign('goods', $goodsRecord);

		$result=$action->where('id='.$markid)->find();
		$result['goods_ids'] = explode(',',$result['goods_id']);
		$this->assign('editmarketing', $result);

        $this->assign('munetype', 8);

        $this->display();
    }
	
	
	/* 判断订单是否已经取货 */
	public function changeorderstate( $id ){
		$M_Orderlist = M('Orderlist');
		$M_Coupon_record = M('Coupon_record');	
		$arrOne = $M_Orderlist->where('id='.$id)->find();
		$return = 0;
		
		/* 判断待收货是否已经取货 */
		if($arrOne['orderstate']==3){
			$data['online_order_no'] = $arrOne['orderno'];
			$res = erpgetorder($data);
			
			if($res['code']==0 && $res['data']['online_order_status']==2){
				
				$data_order['id'] = $id;
				$data_order['orderstate'] = 4;
				$data_order['confirm_status'] = 1;
				$data_order['confirmtime'] = $res['data']['online_order_send_time'];
				$data_order['confirm_name'] = '新希望';
				$M_Orderlist->save($data_order);
				$return = 1;
			}	
		}
		
		if($arrOne['orderstate']==4){
			$num = $M_Coupon_record->where('orderno='.$arrOne['orderno'])->count();
			if($num==0){
				$return = 1;
			}
		}
		
		return $return;
	}
	

	public function addcoupon(){
		$orderid = I("get.id");
		if(empty($orderid)){
			echo "参数错误";
			exit;
		}
		
		$return = $this->changeorderstate($orderid);
		if(!$return){
			echo "参数错误1";
			exit;
		}
		
		//$orderid=1687476;
		$couponid=16;
		$M_Coupon = M('Coupon');
		$M_Orderlist = M('Orderlist'); 
		$M_Coupon_record = M('Coupon_record');		
		
		$out_trade_no = $M_Orderlist->where('id='.$orderid)->getField('orderno');
		$goods_id = $M_Orderlist->where('id='.$orderid)->getField('goods_id');
		$branch_num = $M_Orderlist->where('id='.$orderid)->getField('erpstoreid');
		$userid = $M_Orderlist->where('id='.$orderid)->getField('userid');
		//$couponOne = $M_Coupon->where('id='.$couponid)->find();
		
		
		$goodsidarr1 = array("3963","3964","3965","3966","3967","3968","3970","3971","3972","3973","3974","3975","3976","6446","6447","6448","6449","6450","6451","6452","6453","6454","6455","6456","6457","6458","6459","6460","6600","6601","6602","6603","6604","6605","6606","6607","6608","6609","6610","6611","6612","6613","6614","6636"); // 双12褚橙优惠券
		$goodsidarr2 = array("6491","6492","6493","6494","6495","6496","6497","6498","6499","6500","6501","6502","6503","6504","6505"); // 铂金农夫鲜橙
		$goodsidarr3 = array("6476","6477","6478","6479","6480","6481","6482","6483","6484","6485","6486","6487","6488","6489","6490","6585","6586","6587","6588","6589","6590","6591","6592","6593","6594","6595","6596","6597","6598","6599"); // 双12每日坚果优惠券
		
		/* 双12褚橙优惠券 */
		if (in_array($goods_id, $goodsidarr1)){
			$data['branch_num'] = 99; //发券分店编号
			$data['coupon_count'] = 1; //发券数量
			$data['coupon_type_name'] = '双12褚橙优惠券'; //消费券类型名称
			$data['operator'] = '叶氏兄弟'; //发券人
			$data['card_id'] = ''; //会员卡主键
			$data['out_trade_no'] = $out_trade_no; //第三方单据编号 用于撤销消费券发放
			//$data['coupon_valid_day'] = 5; //券有效天数  不传的话默认为30天
			$date = date('Y-m-d H:i:s');
			$starttime = '2016-12-11';
			$endtime = '2016-12-29';
			$datetime1 = date_create(date('Y-m-d',time()));  
			$datetime2 = date_create($endtime);  
			$interval = date_diff($datetime1, $datetime2);  
			$data['coupon_valid_day'] = $interval->format('%a')+1;  //券有效天数  不传的话默认为30天	
		}
		
		/* 铂金农夫鲜橙 */
		if (in_array($goods_id, $goodsidarr2)){
			$data['branch_num'] = 99; //发券分店编号
			$data['coupon_count'] = 1; //发券数量
			$data['coupon_type_name'] = '双12农夫鲜橙优惠券'; //消费券类型名称
			$data['operator'] = '叶氏兄弟'; //发券人
			$data['card_id'] = ''; //会员卡主键
			$data['out_trade_no'] = $out_trade_no; //第三方单据编号 用于撤销消费券发放

			$date = date('Y-m-d H:i:s');
			$starttime = '2016-12-11';
			$endtime = '2016-12-29';
			$datetime1 = date_create(date('Y-m-d',time()));  
			$datetime2 = date_create($endtime);  
			$interval = date_diff($datetime1, $datetime2);  
			$data['coupon_valid_day'] = $interval->format('%a')+1;  //券有效天数  不传的话默认为30天
		}
		
		/* 双12每日坚果优惠券 */
		if (in_array($goods_id, $goodsidarr3)){
			$data['branch_num'] = 99; //发券分店编号
			$data['coupon_count'] = 1; //发券数量
			$data['coupon_type_name'] = '双12每日坚果优惠券'; //消费券类型名称
			$data['operator'] = '叶氏兄弟'; //发券人
			$data['card_id'] = ''; //会员卡主键
			$data['out_trade_no'] = $out_trade_no; //第三方单据编号 用于撤销消费券发放

			$date = date('Y-m-d H:i:s');
			$starttime = '2016-12-11';
			$endtime = '2016-12-29';
			$datetime1 = date_create(date('Y-m-d',time()));  
			$datetime2 = date_create($endtime);  
			$interval = date_diff($datetime1, $datetime2);  
			$data['coupon_valid_day'] = $interval->format('%a')+1;  //券有效天数  不传的话默认为30天
		}
		/* print_r($data);	
		exit; */
		$result = json_decode(xxw_coupon_api(2,$data),true); // 与新希望绑定微信号  if 绑定成功 else 绑定失败	
		
		if($result['code']==0){
			$data_coupon['coupon_id'] = $couponid;
			$data_coupon['addtime'] = date('Y-m-d H:i:s',time());
			$data_coupon['is_use'] = 0;
			$data_coupon['is_end'] = 0;
			$data_coupon['user_id'] = $userid;
			$data_coupon['starttime'] = $starttime;
			$data_coupon['endtime'] = $endtime;
			$data_coupon['orderno'] = $out_trade_no;
			$data_coupon['coupon_money'] = $result['data'][0]['coupon_money'];
			$data_coupon['coupon_print_num'] = $result['data'][0]['coupon_print_num'];
			$data_coupon['coupon_type_name'] = $result['data'][0]['coupon_type_name'];
			$data_coupon['branch_num'] = $data['branch_num'];
			$data_coupon['coupon_valid_date'] = $result['data'][0]['coupon_valid_date'];
			$rs = $M_Coupon_record->add($data_coupon);
			if($rs){
				echo "OK";
			}
			
		}	
			
		
	}
	
	
	
	

}