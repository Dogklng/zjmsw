<?php
namespace Admin\Model;
use Think\Model;
class WithdrawalModel extends Model{
	public function getWithdrawalList(){

		$DB_PREFIX = C("DB_PREFIX");
		$join_str = "left join {$DB_PREFIX}member as m on w.userid = m.id";
		$count = $this->alias("w")->where(array("w.isdel"=>0,"m.isdel"=>0))->join($join_str)->count();
		$p = getpage($count,8);
		$cache["cache"] = $this->alias("w")->where(array("w.isdel"=>0,"m.isdel"=>0))->
							join($join_str)->
							field("m.person_name,m.telephone,w.realname,
								w.id,w.card_id,w.withdraw_amount,
								w.withdraw_type,w.status,w.addtime,w.truemoney")->
							limit($p->firstRow, $p->listRows)->
							select();
		$cache["page"] = $p->show();
		return $cache;
	}
}