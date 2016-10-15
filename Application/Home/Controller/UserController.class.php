<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController {
    public function index(){
    	// todo:检查登录,
    	// $this->redirect('Index/index');
    	$this->show("首页,登录注册入口,介绍产品,展示部分照片");
    }
}