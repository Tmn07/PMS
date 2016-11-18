<?php
namespace Home\Controller;
use Think\Controller;
class ImageController extends BaseController {

    public function index()
    {
        $this->display();
    }

    public function api($n1,$n2,$n3){
        // $this->show('imageapi');
        dump(getcwd());
        $cmd = system("/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i $n1 $n2 $n3",$ret);
    	echo("ret is $ret");
        // $ret = shell_exec("/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51");
        // dump($ret);
  		// $program="/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51"; 
		// exec ($program);
    }
}