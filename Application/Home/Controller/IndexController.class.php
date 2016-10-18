<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
    	// $this->show("首页,登录注册入口,介绍产品,展示部分照片");
    	if (session('?user')) {
    		dump(session('user'));
    		dump(U('user/index'));
    		$this->redirect('user/index');
    	}
    	$this->assign('err',$err);
    	$this->display();
    }
    public function share(){
    	$pid = $_GET['pid'];
    	// $url = func($pid);
    	$this->assign('img_url',$url);
    	$this->show("您的好友username给您分享的照片");
    }
    public function md55(){
    	$pwd = $_GET['pwd'];
    	dump(md5($pwd));
    	return md5($pwd);
    }
    public function tim(){
        dump(time());
        dump(date('Y-m-d'));
    }
}