<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends BaseController {
    public function none()
    {
        $this->display();
    }
    public function test(){
    	// 检查登录
    	if (session('?user')) {
    		// dump(session('user'));
    	}
    	else{
    		$this->redirect('index/index');
    	}

        $arr = D('User')->relation('album')->where(array('id'=>session('userid')))->find();

        // dump (Protoid());
        $this->assign('prid',Protoid());

        $this->assign('info',$arr);
        // dump($arr);
        $this->assign('albums',$arr['album']);

        $this->display('index-old');
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

        $this->assign('albums',$arr['album']);
        $this->display('album');
    }

    public function map()
    {
        $arr = M("photo")->where(array("userid"=>session("userid")))->select();
        $this->assign("photos",json_encode($arr));
        $this->assign("username",json_encode(session("user")));
        $this->display();
    }

    public function getAlbumphotos()
    {
        $aid = I("post.aid");
        $data['username'] = session('user');
        
        $model = D('album');
        $ret = $model->pd($aid,session('userid'));
        if ($ret) {
            $arr = $model->relation(true)->where(array('id'=>$aid))->find();
            $data['photos'] = $arr['photo'];
        }
        else{
            $this->error('非该用户相册','index',2);
        }
        $this->ajaxReturn($data);
    }

    public function uploader()
    {
        $arr = D('User')->relation('album')->where(array('id'=>session('userid')))->find();
        $this->assign('albums',$arr['album']);
        $this->assign('prid',Protoid());

        $this->display('upload');
    }

    public function updir()
    {
        dump (I("post."));
        $arr = I("post.");
        session("aid",$arr['album']);
        session("address",$arr['loc']);
        session("desc",$arr['des']);
    }

    public function up()
    {

        $arr = I("post.");
        //dump($arr);
        
        $uploader = new \Org\Util\UploadHandler();

        // Specify the list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $uploader->allowedExtensions = array("jpeg","jpg","png"); // all files types allowed by default

        // Specify max file size in bytes.
        $uploader->sizeLimit = 512000;

        // Specify the input name set in the javascript.
        $uploader->inputName = "qqfile"; // matches Fine Uploader's default inputName value by default

        // If you want to use the chunking/resume feature, specify the folder to temporarily save parts.
        $uploader->chunksFolder = "./Public/photo/".session("user");

        $method = $_SERVER["REQUEST_METHOD"];
        if ($method == "POST") {
            header("Content-Type: text/plain");

            // Assumes you have a chunking.success.endpoint set to point here with a query parameter of "done".
            // For example: /myserver/handlers/endpoint.php?done
            if (isset($_GET["done"])) {
                $result = $uploader->combineChunks("files");
            }
            // Handles upload requests
            else {
                // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
                $result = $uploader->handleUpload("./Public/photo/".session("user"));

                // To return a name used for uploaded file you can use the following line.
                $result["uploadName"] = $uploader->getUploadName();
            }
            echo json_encode($result);
            if ($result['success']==true) {
                // 插入数据库
                $model = M('photo');
                $data = array();
                $data['address'] = session("address");
                $data['userid'] = session('userid');
                $data['filename'] = $result['uploadName'];
                $data['addtime'] = date('Y-m-d');
                $data['albumid'] = session("aid");
                $data['name'] = $uploader->getName();
                $data['description'] = session("desc");
                $model->add($data);
            }
        }
        // for delete file requests
        else if ($method == "DELETE") {
            $result = $uploader->handleDelete("files");
            echo json_encode($result);
        }
        else {
            header("HTTP/1.0 405 Method Not Allowed");
        }

    }

    public function show_shares()
    {
        $arr = D("photo")->getShared(session("userid"));
        $this->assign('username',session('user'));
        $this->assign("photos",$arr);
        $this->display("show_photos");
    }

    public function show_photos()
    {
        $aid = I('get.id');
        $model = D('album');
        $ret = $model->pd($aid,session('userid'));
        if ($ret) {
            $arr = $model->relation(true)->where(array('id'=>$aid))->find();
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
            // dump($arr);
            if ($arr['share']) {
                # code...
                $share_arr = M('share')->where(array('photoid'=>$arr['id']))->find();
                $this->assign('sid',$share_arr['id']);
            }
            else{
                $this->assign('sid',0);
            }
            $this->display();
        }
        else{
            $this->error('非该用户相片','index',2);
        }   
        // dump($arr);
    }



    public function add_album(){
        $data = I('post.');
        $data['addtime'] = date('Y-m-d');
        $data['userid'] = session('userid');
        return M('album')->add($data);
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
            $data['address'] = I('post.pro');
            $data['userid'] = session('userid');
            $data['filename'] = $info['photo']['savename'];
            $data['addtime'] = date('Y-m-d');
            $data['albumid'] = I('post.aid');
            $data['name'] = I('post.name');
            // var_dump($data);
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