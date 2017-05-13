<?php
namespace Home\Model;
use Think\Model\RelationModel;
class AlbumModel extends RelationModel{
    protected $tableName = 'album'; 

    protected $_link = array(
            'photo' => array(
                'mapping_type'  => self::HAS_MANY,
                'class_name'    => 'photo',
                'foreign_key'   => 'albumid',
            ),
        );
    
    // 判断该相册是否属于该登录用户
    public function pd($aid,$uid)
    {
    	$ret = $this->where(array('id'=>$aid,'userid'=>$uid))->find();
    	return isset($ret);
    }

    // 注册后，增加一个默认相册
    public function init_add($uid)
    {
    	$data['userid'] = $uid;
    	$data['name'] = 'default';
    	$data['description'] = '初始默认相册';
        $data['addtime'] = date("Y-m-d");
    	$this->add($data);
    }
}