<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
    public function _empty(){
		$this->redirect('Index/index');
    }
}