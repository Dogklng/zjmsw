<?php
namespace Admin\Controller;
use Common\Controller\CommonController;
class IntegralController extends CommonController {

    public function index(){
        $title = I('get.name');
        $sql['is_del'] = 0;
        if($title){
            $sql['goods_name'] = $title;
            $this->assign('title',$title);
        }
        $count = M('IntegralView')->where($sql)->count();
        $list = M('IntegralView')->where($sql)->select();
        foreach($list as $k=>$v){
            $sku = unserialize($v['sku']);
            foreach($sku as $kk=>$vv){
                unset($list[$k]['sku']);
                $list[$k]['skus'] .= $vv.',';
            }
        }
        $this->assign('count',$count);
        $this->assign('list',$list);
        $this->display();
    }

    //添加商品
    public function set(){
        if(IS_AJAX){
            $goods_id = I('post.goods_id');
            $sku = M('SkuList')->where(array('goods_id'=>$goods_id))->select();
            if($sku){
                foreach($sku as $k=>$v){
                    $sku_name = $this->getSkuDes($v['id']);
                    $ss .= "<option value='{$sku_name}{$v['price']}'>{$sku_name}{$v['price']}</option>";
                }
                $this->ajaxReturn(array('status'=>1, 'html'=>$ss));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'未知错误！'));
            }

        }

        if(IS_POST){
            $data   = I('post.');
            $type   = I("post.type");
            $id     = I("post.id",0,"intval");
            if ($type == 0) {
                $goods = M('Goods')->field('goods_name,logo_pic')->where(array('id'=>$data['goods_name']))->find();
                $data['logo_pic'] = $goods['index_pic'];
                $data['goods_name'] = $goods['goods_name'];
                $data['cate_id'] = $data['select_class_id'];
                $data['series_id'] = $data['select_series_id'];
                $data['oprice'] = substr($data['goods_sku'],strripos($data['goods_sku'],',')+1);
                $data['sku'] = explode(',',$data['goods_sku']);
                unset($data['sku']['2']);
                $data['sku'] = serialize($data['sku']);
            } else {
                $data['goods_name'] = "一次性包邮卡";
                $data['logo_pic']   = $data['logo_pic'];
            }
            $data['price'] = $data['integral'];
            $data['create_at'] = time();
            $data['start'] = strtotime($data['start']);
            $data['stop'] = strtotime($data['stop']);
            unset($data['select_cate_id']);
            unset($data['select_series_id']);
            unset($data['integral']);
            unset($data['goods_sku']);
            unset($data['select_class_id']);
            if ($id) {
                unset($data['id']);
                $res = M('IntegralGoods')->where(array("id"=>$id))->save($data);
            } else {
                $res = M('IntegralGoods')->data($data)->add();
            }
            if($res){
                $this->redirect('Admin/Integral/index');
            }else{
                $this->error('添加失败',U('Admin/Integral/set'));
            }
        }
         //分类
        $c    = M("cate");
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("cate", $categorylist);
        //系列
        $s=M("series");
        $serieslist=$s->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $id = I("get.id");
        $IntegralGoods = M("IntegralGoods")->where(array("id"=>$id))->find();
        $this->assign('IntegralGoods',$IntegralGoods);
        $this->assign('attr',$serieslist);
        $this->display();
    }

    //添加新商品
    public function sets(){
         if(IS_POST){
            $id = I('post.id');
            $m = M("IntegralGoods");
            $data = I("post.");
            $data['sku'] = serialize($data['sku']);
            $data['start'] = strtotime($data['start']);
            $data['stop'] = strtotime($data['stop']);
            $data['is_del'] = 0;
            if($id){
                $res = $m->save($data);
            }else{
                $data['create_at'] = time();
                $res = $m->add($data);
            }
            if($res){
                $this->redirect('Admin/integral/index');
            }else{
                $this->error("操作失败",U('Admin/integral/index'));
            }
        }
        if(IS_GET){
            $id = I('get.id');
            $goods = M('IntegralGoods')->find($id);
            $goods['sku'] = unserialize($goods['sku']);
            $cate_name = M('Cate')->find($goods['cate_id']);
            $attr = M('Series')->find($goods['series_id']);
            $this->assign('cate_name',$cate_name['classname']);
            $this->assign('attr',$attr['classname']);
            $this->assign('goods',$goods);
        }
        //分类
        $c    = M("cate");
        $categorylist = $c->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($categorylist as $k=>$v){
            $categorylist[$k]['cate'] = $c->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("categorylist", $categorylist);
        //系列
        $s=M("series");
        $serieslist=$s->where(array("pid"=>0, "isdel"=>0))->select();
        foreach($serieslist as $k=>$v){
            $serieslist[$k]['cate'] = $s->where(array('pid'=>$v['id'],'isdel'=>0))->select();
        }
        $this->assign("serieslist", $serieslist);
        //sku
        $k = M('SkuAttr');
        $skuA = $k->where('pid=0')->select();
        $skuB = $k->where('pid>0')->select();
        $this->assign('skuA',$skuA);
        $this->assign('skuB',$skuB);
        $this->display();
    }
       /**
     * 删除产品
     */
    public function delGoods(){
        if(IS_AJAX){
            $id  = I("ids");
            $m   = M("IntegralGoods");
            $ids = array_filter(explode("-", $id));
            if(empty($ids)){
                $this->ajaxReturn(array("status"=>0, "info"=>"请选择商品！"));
            }
            foreach($ids as $v){
                $res = $m->where(array("id"=>$v))->save(array("is_del"=>1,'del_time'=>time()));
                if($res === false){
                    $this->ajaxReturn(array("status"=>0, "info"=>"删除商品失败！"));
                }
            }
            $this->ajaxReturn(array("status"=>1, "info"=>"删除商品成功！"));
        }
        $id  = I("id");
        $res = M("IntegralGoods")->where(array("id"=>$id))->save(array("is_del"=>1,'del_time'=>time()));
        if($res!==false){
            $this->redirect('Admin/Integral/index');die;
        }
        $this->error("删除失败！");die;
    }
    public function ajaxclass(){
        if(IS_AJAX){
            $cate_id = I('post.cate_id');
            $attr_id = I('attr_id');
            $res = M('Goods')->where(array('cate_id'=>$cate_id,'series_id'=>$attr_id))->select();
            if($res){
                $s = '';
                foreach($res as $k=>$v){
                    $s .= "<option value='{$v['id']}'>{$v['id']}-{$v['goods_name']}</option>";
                }
                $sku = M('SkuList')->where(array('goods_id'=>$v['id']))->select();
                $ss = '';
                foreach($sku as $k=>$v){
                    $sku_name = $this->getSkuDes($v['id']);
                    $ss .= "<option value='{$sku_name}'>{$sku_name}{$v['price']}</option>";
                    $yy[$k] = $v['price'];
                }
                    $this->ajaxReturn(array('status'=>1, 'html'=>$s,'sku'=>$ss));
            }else{
                    $this->ajaxReturn(array('status'=>0, 'info'=>'未查询到商品！'));
            }
        }
    }
    function ajaxsku(){
        foreach($sku as $k=>$v){
            $sku_name = $this->getSkuDes($v['id']);
            $ss .= "<option value='{$sku_name}'>{$sku_name}{$v['price']}</option>";
            $yy[$k] = $v['price'];
        }
    }
    function getSkuDes($skuid){
        if(!$skuid){
            return "";
        }
        $sku_l_m = M("sku_list");
        $sku_a_m = M("sku_attr");
        $skuids  = $sku_l_m->find($skuid);
        if(!$skuids){
            return "";
        }
        $sku_arr = array_filter(explode("-", $skuids['attr_list']));
        $str     = "";
        foreach($sku_arr as $v){
            $sku_info = $sku_a_m->where(array("id"=>$v))->find();
            $sku_pname = $sku_a_m->where(array("id"=>$sku_info['pid']))->getField('classname');
            $str .= $sku_info['classname'].",";
        }
        return trim($str, "<br>");
    }
      //订单列表
    public function integralOrderList(){
        $telephone = I('get.telephone');
        $person_name = I('get.person_name');
        $order_num = I('get.order_no');
        $starttime = strtotime(I('get.starttime'));
        $endtime = strtotime(I('get.endtime'));
        $order_status = I('get.order_status');
        if($order_status == 1){
            $sql['is_send'] = 1;
        }
        if($order_status == 2){
            $sql['is_send'] = 2;
        }
        if($telephone){
            $sql['telephone'] = $telephone;
            $this->assign('telephone',$telephone);
        }
        if($person_name){
            $sql['person_name'] = $person_name;
            $this->assign('person_name',$person_name);
        }
        if($order_num){
            $sql['order_no'] = $order_num;
            $this->assign('order_no',$order_num);
        }
        if($starttime){
            $sql['add_time'] = array('gt',$starttime);
            $this->assign('starttime',I('get.starttime'));
        }
        if($endtime){
            $sql['add_time'] = array('lt',$endtime);
            $this->assign('endtime',I('get.endtime'));
        }

        $counts = M('IntegralOrderView')->count();
        $count = M('IntegralOrderView')->where($sql)->count();
        $Page  = getpage($count,10);
        $show  = $Page->show();//分页显示输出
        $order  = M('IntegralOrderView')->order('id desc')->where($sql)->limit($Page->firstRow.','.$Page->listRows)->select();
        $express = M("express")->order("id asc")->select();
        $this->assign("express_list",$express);
        $this->assign('page',$show);
        $this->assign('order',$order);
        $this->assign('count',$counts);
        $this->assign('countA',M('IntegralOrderView')->where(array('is_send'=>1))->count());
        $this->assign('countB',M('IntegralOrderView')->where(array('is_send'=>0))->count());
        $this->display();
    }
    public function integralOrderDetail(){
        $id = I('get.id');
        if(!$id){
            echo '参数错误!';die;
        }
        $goods = M('IntegralOrderView')->find($id);
        $this->assign('goods',$goods);
        $this->display();
    }
    public function express(){
        $data["express"]    = I("post.express_name");//编码
        $data["express_num"]      = I("post.express_no");
        $data["is_send"]         = 1;
        $id                      = I('post.id');
        $m          = M('IntegralOrder');
        $res = $m->where(array("id"=>$id))->save($data);
        $Info=$m->where(array("id"=>$id))->find();
        $data["express"]    = M("express")->where(array('express_ma'=>$data['express']))->getField("express_company");//快递公司名称
        if($res){
            //发货成功添加发货时间 修改订单状态
            $res1 = $m->where(array("id"=>$id))->setField(array("order_status"=>1,"express_time"=>time()));
            if($res1){
                $d=array(
                    'order_id'=>$Info['id']
                );
                $this->sendSystemMessage($Info['user_id'],"订单已发货","您的订单【".$Info['order_no']."】已发货，【".$data['express_name']."】运单编号：".$data["express_no"]."请注意查收！",$d);
                $this->ajaxReturn(array("status"=>1,'info'=>"发货成功"));
            }else{
                $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
            }
        }else{
            $this->ajaxReturn(array("status"=>0,'info'=>"发货失败"));
        }
    }
    //查看详情
    public function orderDetail(){
        $id    = I("get.id");  // 得到order_infolist的id
        $order = M("integral_order")->find($id);
        if(!$order){
            goback("没有此订单！");
        }
        $user        = M('member')->find($order['user_id']);
        $db_prefix   = C("DB_PREFIX");
        $order_goods = M("order_goods")->where(array('order_id'=>$order['id']))->select();

        /**
         * 加入评价
         */
        $c_m = M("goods_comment");
        foreach($order_goods as $k=>$v){
            if($v['status']){
                $order_goods[$k]['comment'] = $c_m->where(array('goods_id'=>$v['goods_id'],"order_id"=>$v['order_id']))->find();
            }
        }
       // dump($order);die();
        /*
            这里需要加入物流查询
        */
        //物流信息
        $res = $this->getOrderTracesByJson($order['express'],$order['express_num']);
        $express = json_decode($res,true);
        if($express['Success']){
            $exp = $express['Traces'];
        }
        //快递编码转换成快递公司名称
        $order['express_name'] =  M("express")->where(array("express_ma"=>$order['express']))->getField("express_company");

        $this->assign("cache", $order);
        $this->assign("express", $exp);
        $this->display();
    }
    /**
    * Json方式 查询订单物流轨迹
    */
     public function getOrderTracesByJson($express,$LogisticCode){

        //jaw 2016-12-28
        //
        // $name = array(
        //     '顺丰快递'=>'SF',
        //     '申通快递'=>'STO',
        //     '韵达快递'=>'YD',
        //     '圆通速递'=>'YTO',
        //     '天天快递'=>'HHTT',
        //     '德邦'=>'DBL',
        //     'EMS'=>'EMS',
        //     '中通快递'=>'ZTO'
        // );
        $ShipperCode = $express;
        $LogisticCode = $LogisticCode;

        $EBusinessID = '1265531';
        $AppKey = '2fac2b65-0f6e-4738-abcb-52ff176ca90a';
        $ReqURL = 'http://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';

        $requestData= "{'OrderCode':'','ShipperCode':'".$ShipperCode."','LogisticCode':'".$LogisticCode."'}";
        $datas = array(
            'EBusinessID' => $EBusinessID,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = self::encrypt($requestData, $AppKey);
        $result=self::sendPost($ReqURL, $datas);

        //根据公司业务处理返回的信息......

        return $result;
    }
    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
   public  function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
       /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    public  function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if($url_info['port']=='')
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }


    /**
     * 积分赠送管理
     */
    public function percent_integral()
    {
        if (IS_AJAX) {
            $data = I('post.');
            if(!$data['register']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写注册赠送积分！'));
            }
            if(!$data['check_in']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写签到赠送积分！'));
            }
            if(!$data['inviting_in']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写邀请好友赠送积分！'));
            }
            if(!$data['evaluate']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写评价赠送积分！'));
            }
            if(!$data['shopping']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写购物赠送积分！'));
            }
            if(!$data['recharge']){
                $this->ajaxReturn(array('status'=>0, 'info'=>'请填写充值赠送积分！'));
            }
            $data['id'] = 1;
            $res = M('PercentIntegral')->save($data);
             if($res){
                $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
            }else{
                $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
            }
        }
        $percent = M('PercentIntegral')->find(1);
        $this->assign('percent',$percent);
        $this->display();
    }

    //积分等级设置
    public function grade()
    {
        $integral_grade = M("integral_grade");
        if (IS_AJAX) {
            $data = I("post.");
            if (count($data['title']) < 5) {
                $this->ajaxReturn(array('status'=>0, 'info'=>'等级名称请填写完整！'));
            }
            if (count($data['integral']) < 5) {
                $this->ajaxReturn(array('status'=>0, 'info'=>'升级所需积分请填写完整！'));
            }
            if (count($data['get_integral']) < 5) {
                $this->ajaxReturn(array('status'=>0, 'info'=>'获取积分比例请填写完整！'));
            }
            if (count($data['consumption_deduction']) < 5) {
                $this->ajaxReturn(array('status'=>0, 'info'=>'消费抵扣比例请填写完整！'));
            }
            $integral_grade->where('1')->delete();
            for ($i = 0; $i < 5; $i++) {
                $where = array();
                $where["title"]                 = $data['title'][$i];
                $where["integral"]              = $data['integral'][$i];
                $where["get_integral"]          = $data['get_integral'][$i];
                $where["consumption_deduction"] = $data['consumption_deduction'][$i];
                $where["type"]                  = $i+1;
                $res = $integral_grade->data($where)->add();
                if (!$res) {
                    $this->ajaxReturn(array('status'=>0, 'info'=>'操作失败'));
                }
            }
            $this->ajaxReturn(array('status'=>1, 'info'=>'操作成功'));
        }
        $data = $integral_grade->select();
        $this->assign("grade",$data)->display();
    }

    //积分兑换比例
    public function integralMoney(){
        if(IS_POST){
            $proportion=I('post.proportion');
            if(!$proportion){
                $this->error("请填写兑换比例");exit;
            }
            $data['proportion']=$proportion;
            $res=M('integral_money')->where(array('id'=>1))->save($data);
            if($res){
                   $this->success('保存成功');exit;
            }else{
                $this->error('保存失败');exit;
            }
        }
        $info=M('integral_money')->where(array('id'=>1))->find();
        $this->assign('info',$info);
        $this->display();
    }
}