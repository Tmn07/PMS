<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends BaseController {
	public function setComment()
	{
		$arr = I("get.");
		$data = array('photoid' => $arr['pid'],
					'guestname' => $arr['name'],
					'addtime'  => date('Y-m-d H:i:s'),
					'content' => $arr['content'],
					);
		$re = M('comment')->add($data);
		if (is_numeric($re)) {
			// dump($re);
			return $re;
		}
		else{
			return false;
		}
	}
	public function getComment($pid)
	{
		$arr = M("comment")->where(array('photoid'=>$pid))->order('addtime desc')->select();
		$this->ajaxReturn($arr);
	}

	// 根据评论，搜索照片。对该userid用户的照片做如下search
	public function searchComment($pid,$keyword)
	{
		$Model = new \Think\Model();

		if (preg_match("/[\x7f-\xff]/", $keyword)) { 
			// 中文使用like%%
			$arr = $Model->query("SELECT * FROM  `comment` WHERE  `content` LIKE  '%$keyword%' AND  `photoid` =  $pid");
		}else{ 
			// 只含英文单词，使用全文索引
			$arr = $Model->query("SELECT * FROM  `comment` WHERE  MATCH(content) AGAINST('$keyword') AND  `photoid` =  $pid");
			// 全文索引存在搜索不到的情况。
			if (sizeof($arr) == 0) {
				# code...
				$arr = $Model->query("SELECT * FROM  `comment` WHERE  `content` LIKE  '%$keyword%' AND  `photoid` =  $pid");
			}
		} 
		dump($arr);
		// $this->ajaxReturn($arr);
	}

}