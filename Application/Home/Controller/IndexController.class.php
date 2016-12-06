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
    	$this->display();
    }
    public function share(){
        $sid = I('get.id');
        $arr = M('share')->find($sid);
        //dump($arr);
        $this->assign('url',$arr['url']);
        $this->assign('id',$arr['photoid']);
        $this->display();

    	// $this->show("您的好友username给您分享的照片");
    }
    public function tim(){
        dump(time());
        dump(date('Y-m-d'));
    }
}