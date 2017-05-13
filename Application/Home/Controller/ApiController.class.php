<?php
namespace Home\Controller;
use Think\Controller;
class ApiController extends BaseController {
    // public function test()
    // {
    //     dump(date("Y-m-d"));
    // }
	public function setComment()
	{
		$arr = I("get.");

		$data = array('photoid' => $arr['pid'],
					'guestname' => $arr['name'],
					'addtime'  => date('Y-m-d H:i:s'),
					'content' => $arr['content'],
					);
		$re = M('comment')->add($data);
        
        if ($arr['name']!=session('user')) {
            D("Notice")->commentNotice($arr['pid'],$arr['sid']);
        }

		if (is_numeric($re)) {
			// return $re;
			$this->ajaxReturn($re);
		}
		else{
			$this->ajaxReturn(array('code' => "200"));
			return false;
		}
	}

	public function getComment()
	{
		$pid = I("get.")['pid'];
		$arr = M("comment")->where(array('photoid'=>$pid))->order('addtime desc')->select();
		$this->ajaxReturn($arr);
	}

	// 根据评论，搜索照片。对该userid用户的照片做如下search
    public function searchComment($keyword)
    {

        $Model = new \Think\Model();

        $uid = session("userid");
        if (preg_match("/[\x7f-\xff]/", $keyword)) { 
            // 中文使用like%%
            $arr = $Model->query("SELECT c.photoid, c.addtime, c.content, p.filename, p.address FROM `comment` as c inner join `photo` as p on p.id = c.photoid WHERE userid = '$uid' and c.content LIKE '%$keyword%'");
        }else{ 
            // 只含英文单词，使用全文索引
            $arr = $Model->query("SELECT c.photoid, c.addtime, c.content, p.filename, p.address FROM `comment` as c inner join `photo` as p on p.id = c.photoid WHERE userid = '$uid' and  MATCH(c.content) AGAINST('$keyword')");

            // 全文索引存在搜索不到的情况。
            if (sizeof($arr) == 0) {
                $arr = $Model->query("SELECT c.photoid, c.addtime, c.content, p.filename, p.address FROM `comment` as c inner join `photo` as p on p.id = c.photoid WHERE userid = '$uid' and c.content LIKE '%$keyword%'");
            }
        }
        $data = array();
        $pids = array();
        foreach ($arr as $key => $value) {
            $index = array_search($value['photoid'],$pids) ;
            if ( is_int($index)) {
                $data[$index]["comment"][] = array("content"=>$value['content'],"addtime"=>$value['addtime']);
            }
            else{
                $data[] = array('pid'=>$value['photoid'],'filename'=>$value['filename'],'comment'=>array(array("content"=>$value['content'],"addtime"=>$value['addtime'])));
                $pids[] = $value['photoid'];
            }
        }
        $this->ajaxReturn($data);
    }

    public function getNotice()
    {
        $n = D("Notice")->gets();
        $this->ajaxReturn($n);
    }
    public function setNoticereadAll()
    {
    	M("Notice")->where(array("userid"=>session("userid"),"readed"=>"0"))->setField('readed','1');
    }

    public function setNoticeread()
    {
        if (I("get.id")) {
            // notice id
            M("Notice")->where(array("id"=>I("get.id"),"userid"=>session("userid"),"readed"=>"0"))->setField('readed','1');
        }
        else{
            M("Notice")->where(array("href"=>I("get.sid"),"userid"=>session("userid"),"readed"=>"0"))->setField('readed','1');
        }
    	return 0;
    }

    public function set_share(){
        $id = I("get.id");
        $model = D('photo');
        $arr = $model->where(array('id'=>$id,'userid'=>session('userid')))->find();
        if (isset($arr)) {
            $x = M('share')->where(array("photoid"=>$id))->find();
            if (!isset($x))
            {
                $arr['share'] = 1;
                $ret = $model->lock(true)->save($arr);
                $data['photoid'] = $arr['id'];
                $data['url'] = session('user').'/'.$arr['filename'];
                $sid = M('share')->add($data);
                $this->success('分享成功',U("index/share?id=$sid"),2);
            }
            else{
                $sid = $x['id'];
                $this->success('分享成功',U("index/share?id=$sid"),2);
            }
        }
        else{
            $this->error('非该用户相片','index',2);
        }
    }

    public function set_noshare(){
        $id = I("get.id");
        M('photo')->where(array('id'=>$id,'userid'=>session('userid')))->setField("share","0");
        M('share')->where(array('photoid'=>$id))->delete();
        $this->success('已取消分享',U("user/show_photo?id=$id"),2);
    }

    public function del_pic(){
    	$id = I("get.id");
    	$arr = M('photo')->where(array('id'=>$id,'userid'=>session('userid')))->find();
    	// dump($arr);
    	if ($arr['share']) {
    		M('share')->where(array('photoid'=>$id))->delete();
    	}
    	M('photo')->where(array('id'=>$id))->delete();
    	// TODO：跳转的地方?
    	$this->success('删除成功',2);
    }

    // 从某相册随机取一张照片
    public function rand_pic($aid)
    {
        // order by rand() limit 1 
        $arr = M("photo")->where(array("albumid"=>$aid,"userid"=>session("userid")))->order("rand()")->find();
        $this->ajaxReturn($arr['filename']);
    }
}