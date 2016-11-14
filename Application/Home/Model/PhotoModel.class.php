<?php
namespace Home\Model;
use Think\Model\RelationModel;
class PhotoModel extends RelationModel{

	public function getProphotos($name,$uid)
	{
		$prid = Protoid($name);
		$arr = $this->where(array("userid"=>$uid,"prid"=>$prid))->select();
		
		return $arr;
	}


}
