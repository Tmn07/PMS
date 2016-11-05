<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController {
    public function test(){
    	// 检查登录
    	if (session('?user')) {
    		// dump(session('user'));
    	}
    	else{
    		$this->redirect('index/index');
    	}

        $arr = D('User')->relation('album')->where(array('id'=>session('userid')))->find();

        $this->assign('info',$arr);
        // dump($arr);
        $this->assign('albums',$arr['album']);

        $this->display('index');
    }

    public function uploader()
    {
        $arr = D('User')->relation('album')->where(array('id'=>session('userid')))->find();

        $this->assign('info',$arr);
        // dump($arr);
        $this->assign('albums',$arr['album']);
        
        $this->display('upload');
    }

    public function index()
    {
        // 检查登录
        if (session('?user')) {
            // dump(session('user'));
        }
        else{
            $this->redirect('index/index');
        }

        $arr = D('User')->relation('album')->where(array('id'=>session('userid')))->find();

        $this->assign('info',$arr);
        // dump($arr);
        $this->assign('albums',$arr['album']);
        $this->display('album');
    }

    public function show_album()
    {
        // 检查登录
        if (session('?user')) {
            // dump(session('user'));
        }
        else{
            $this->redirect('index/index');
        }

        $arr = D('User')->relation('album')->where(array('id'=>session('userid')))->find();

        $this->assign('info',$arr);
        // dump($arr);
        $this->assign('albums',$arr['album']);
        $aid = I('get.id');
        $model = D('album');
        $ret = $model->pd($aid,session('userid'));
        if ($ret) {
            $arr = $model->relation(true)->where(array('id'=>$aid))->find();
            // dump($arr);
            $this->assign('username',json_encode(session('user')));
            $this->assign('photos', json_encode($arr['photo']));
            // var_dump($arr['photo']);
            // $this->display();
        }
        else{
            $this->error('非该用户相册','index',2);
        }

        $this->display();
    }

    public function show_photos()
    {
        $aid = I('get.id');
        $model = D('album');
        $ret = $model->pd($aid,session('userid'));
        if ($ret) {
            $arr = $model->relation(true)->where(array('id'=>$aid))->find();
            // dump($arr);
            $this->assign('username',session('user'));
            $this->assign('photos',$arr['photo']);
            $this->display();
        }
        else{
            $this->error('非该用户相册','index',2);
        }
    }

    public function show_photo()
    {
        $id = I("get.id");
        $model = D('photo');
        $arr = $model->where(array('id'=>$id,'userid'=>session('userid')))->find();
        if (isset($arr)) {
            $this->assign('username',session('user'));
            $this->assign('photo',$arr);
            if ($arr['share']) {
                # code...
                $share_arr = M('share')->where(array('photoid'=>$arr['id']))->find();
                $this->assign('sid',$share_arr['id']);
            }
            $this->display();
        }
        else{
            $this->error('非该用户相片','index',2);
        }   
        // dump($arr);
    }

    public function set_share(){
        $id = I("get.id");
        $model = D('photo');
        $arr = $model->where(array('id'=>$id,'userid'=>session('userid')))->find();
        if (isset($arr)) {
            $arr['share'] = 1;
            $ret = $model->save($arr);
            $data['photoid'] = $arr['id'];
            $data['url'] = session('user').'/'.$arr['filename'];
            $sid = M('share')->add($data);
            $this->success('分享成功',U("index/share?id=$sid"),2);
        }
        else{
            $this->error('非该用户相片','index',2);
        }
    }

    public function add_album(){
        $data = I('post.');
        $data['addtime'] = date('Y-m-d');
        $data['userid'] = session('userid');
        // dump($data);
        M('album')->add($data);
    }

    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './Public/photo/'; // 设置附件上传根目录
        $upload->autoSub   =     false;
        $upload->savePath  =     session('user').'/'; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            // var_dump($info);
            $model = M('photo');
            $data = array();
            $data['userid'] = session('userid');
            $data['filename'] = $info['photo']['savename'];
            $data['addtime'] = date('Y-m-d');
            $data['albumid'] = I('post.aid');
            $data['name'] = I('post.name');
            $model->add($data);
            $this->success('上传成功！');
            // foreach($info as $file){
            //     echo $file['savepath'].$file['savename'];
            // }
        }
    }

    public function signin(){
    	$data = $_POST;
    	$status1 = D('User')->login($data);
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