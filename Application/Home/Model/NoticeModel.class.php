<?php
namespace Home\Model;
use Think\Model\RelationModel;
class NoticeModel extends RelationModel{
	public function gets()
	{
		$arr = $this->where(array("userid"=>session("userid"),"readed"=>"0"))->select();
		return $arr;
	}

	public function commentNotice($pid,$sid)
	{
		$uid = D("photo")->field("userid")->where(array("id"=>$pid))->find();

		$data = array("userid"=>$uid["userid"],"type"=>"info","description"=>"新评论","href"=>"__APP__/Index/share/id/$sid");
		$this->add($data);
	}
}