<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends BaseController {

	public function index()
	{
		$this->display();
	}

    // public function show(){
    //     if (session("?adminid"))
    //     {
    //         $this->assign("datas",$datas);
    //         $this->display('setNotice');
    //     }
    // }

    public function signin(){
    	$data = I("post.");
    	$status = M('admin')->where(array('name' => $data['username'],'pwd' => $data['pwd']))->find();
    	if (isset($status)) {
			session("adminid",$status['id']);
            $this->display('setNotice');
    	}
    	else{
    		$this->error('密码错误或者用户不存在','index',2);
    	}
    }
    // http://localhost:8001/PMS/index.php/Admin/alert?content=OK%E5%95%A6
    public function alert()
    {
    // 全员公告
    	if (session("?adminid")) {
    		$data = I("get.");
    		$arr = M('user')->field("id")->select();
    		foreach ($arr as $key => $value) {
                if ($data['content'] == '') {
                    // alert("内容不能为空");
                    $this->ajaxReturn(array(0,"内容不能为空"));
                }
                else
                {
                    $tmp = array('userid'=>$value['id'],'description'=>$data['content'],"type"=>"warning");
                    M('notice')->add($tmp);
                    dump("ok");
                }

    		}
    	}
    	else{
    		dump("err");
    	}
    	
    }

    public function logout()
    {
    	session(null);
    }

}