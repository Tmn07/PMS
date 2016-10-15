<?php
namespace Home\Controller;
use Think\Controller;
class EmptyController extends BaseController{
    public function index(){
        $this->redirect('Index/index');
    }
}