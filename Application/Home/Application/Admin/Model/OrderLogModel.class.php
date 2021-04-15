<?php
namespace Admin\Model;
use Think\Model;
class OrderLogModel extends Model
{
    public function getAllLog(){
        $map = array(
                "l.isdel" => 0,
                "m.isdel" => 0,
                "o.isdel" => 0
            );
        // 获取到用户的realname  telephone 和 订单的title 
        $DB_PREFIX = C("DB_PREFIX");
        $join_str1 = "inner join {$DB_PREFIX}member as m on l.userid=m.id";
        $join_str2 = "inner join {$DB_PREFIX}orderlist as o on l.orderid=o.id";
        $count = $this->alias("l")->where($map)->join($join_str1)->join($join_str2)->count();
        $p     = getPage($count,10);

        $res["cache"]   = $this->alias("l")->where($map)->
        					join($join_str1)->join($join_str2)->
        					field("l.id,m.telephone,l.orderstate,m.realname,l.title,l.msg,l.addtime,l.orderid,o.title as otitle")->
        					limit($p->firstRow, $p->listRows)->order("l.addtime desc")->select();

        $res["page"]    = $p->show();
        return $res;
    }
}