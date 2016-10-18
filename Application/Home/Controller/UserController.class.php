<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController {
    public function index(){
    	// 检查登录
    	if (session('?user')) {
    		dump(session('user'));
    	}
    	else{
    		$this->redirect('index/index');
    	}
    	$this->display();
    }

    public function signin(){
    	$data = $_POST;
    	$status1 = D('user')->login($data);
    	if ($status1 || $status2) {
    		$this->redirect('index');
    	}
    	else{
    		$this->error('密码错误或者用户不存在','index/index',2);
    	}
    }

    public function logout(){
    	session(null);
    	$this->redirect('index/index');
    }

    public function signup(){
    	$data = $_POST;
    	$status = D('user')->signup($data);
    	if ($status == 1) {
    		$this->redirect('index');
    	}
    	else{
            $this->error($status,'index/index',2);
    	}
    }
}