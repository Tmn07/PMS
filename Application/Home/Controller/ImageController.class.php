<?php
namespace Home\Controller;
use Think\Controller;
class ImageController extends BaseController {

    public function index()
    {
        dump(getcwd());
        $this->display();
    }

    public function napi($n1,$n2,$n3,$filename){
        // 参数范围应该在20,100,100内，不能为0
        // $this->show('imageapi');
        dump(getcwd());
        $cmd = system("/usr/bin/python py/napi.py $filename -i $n1 $n2 $n3",$ret);
        echo("ret is $ret");
        // $ret = shell_exec("/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51");
        // dump($ret);
        // $program="/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51"; 
        // exec ($program);
    }

    public function api($n1,$n2,$n3){
        // $this->show('imageapi');
        dump(getcwd());
        $cmd = system("/usr/bin/python py/api.py t.png -i $n1 $n2 $n3",$ret);
    	echo("ret is $ret");
        // $ret = shell_exec("/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51");
        // dump($ret);
  		// $program="/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51"; 
		// exec ($program);
    }
}