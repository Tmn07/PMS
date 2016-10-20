<?php
namespace Home\Controller;
use Think\Controller;
class ImageController extends BaseController {
    public function api(){
        // $this->show('imageapi');
        dump(getcwd());
        $cmd = system("/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51",$ret);
    	echo("ret is $ret");
        // $ret = shell_exec("/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51");
        // dump($ret);
  		// $program="/usr/bin/python /opt/lampp/htdocs/PMS/py/api.py t.png -i 11 51 51"; 
		// exec ($program);
    }
}