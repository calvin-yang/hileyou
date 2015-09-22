<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;

/**
 * 文档基础模型
 */
class RouteModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('logo_img_url', 'require', '请上传封面图片', self::MUST_VALIDATE),
        array('title', 'require', '请填写路线名', self::MUST_VALIDATE),
        array('chief', 'require', '请填写联系人名', self::MUST_VALIDATE),
        array('tel', 'require', '请填写联系人电话', self::MUST_VALIDATE),
        array('day', 'require', '请填写游玩时间', self::MUST_VALIDATE),
        array('night', 'require', '请填写游玩时间', self::MUST_VALIDATE),
    );

    public function admin_add($data){
        if($this->create()){
            $data['insert_time'] = time();
            return $this->add($data);
        }else{
            return $this->getError();
        }
    }
    public function admin_edit($data){
    	if($this->create()){
            $data['updata_time'] = time();
    		$this->save($data);
            // echo $this->getLastSql();
            // exit;
    		return '1';
    	}else{
    		return $this->getError();
    	}
    }

    public function fr_add($data){
        if($this->create()){
            $data['insert_time'] = time();
            return $this->add($data);
        }else{
            return $this->getError();
        }
    }
    public function fr_edit($data){
        
        if($this->create()){
            $data['updata_time'] = time();
            $this->save($data);
            //$this->getLastSql();
            //exit;
            return '1';
        }else{
            return $this->getError();
        }
    }
}