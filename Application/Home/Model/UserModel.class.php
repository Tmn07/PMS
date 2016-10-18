<?php
namespace Home\Model;
use Think\Model\RelationModel;
class UserModel extends RelationModel{
    protected $tableName = 'user'; 
    protected $_validate = array(
    array('username','require ','账号名已被使用',1,'unique',1), // 在新增的时候验证name字段是否唯一
    array('email','email','Email 非法'), //todo: 邮箱的唯一性
    array('password','require','缺少密码'),
    );


    public function login($data='')
    {
        $data['pwd'] = md5($data['pwd']);

        $result1 = $this->where($data)->find();
        $email = $data['username'];
        $result2 = $this->where(array('pwd'=>$data['pwd'],'email'=>$email))->find();

        if (isset($result1) || isset($result2)) {
            if (isset($result2)) {
                $data['username'] = $result2['username'];
            }
            session('user',$data['username']);
            return 1;
        }
        else return 0;
    }

    public function signup($data)
    {
        $data['pwd'] = md5($data['pwd']);
        $data['addtime'] = date('Y-m-d');
        if (!$this->checkemail($data['email'])) {
            return "邮箱已经被使用";
        }
        if (!$this->create($data)) {
            $err = $this->getError();
            return $err;
        }
        else{
            session('user',$data['username']);
            $this->add();
            return 1;
        }
    }

    public function checkemail($email)
    {
        $re = $this->where("email = '$email'")->find();
        if (isset($re)) {
            return 0;
        }
    }

}
