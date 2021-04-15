<?php
namespace Admin\Model;
use Think\Model;
class ResumeModel extends Model{
	function get_resume_list(){
		$title = I("title");
		if($title){
			$where["m.realname"]  = array("like","%$title%"); 
			$where["m.telephone"] = array("like","%$title%"); 
			$where["_logic"]      = "or";
			$map["_complex"]      = $where;
		}
		$DB_PREFIX = C("DB_PREFIX");
		$map["r.isdel"] = 0;
		$map["m.isdel"] = 0;
		$str = "inner join {$DB_PREFIX}member as m on m.id = r.userid";
        // 分页
        $count = $this->alias("r")->where($map)->join($str)->count();
        $p = getpage($count,8);
        $res['cache'] = $this->alias("r")->where($map)->field("
        	r.id,m.realname,email,personalnote,worklifeid,r.addtime,m.telephone")->
        	join($str)->
        	order("r.addtime desc")->limit($p->firstRow, $p->listRows)->select();
        $res['page']= $p->show();
        return $res;
	}
}