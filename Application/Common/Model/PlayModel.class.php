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
class PlayModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('logo_img_url', 'require', '请上传景点封面图', self::MUST_VALIDATE),
        array('title', 'require', '请填写景点名称', self::MUST_VALIDATE),
        // array('title', '/^[^,|;]$/', '景点名称不能包含(, | ;)等特殊符号', self::MUST_VALIDATE),
        array('contact', 'require', '请填写联系人', self::MUST_VALIDATE),
        array('tel', 'require', '请填写联系人电话', self::MUST_VALIDATE),
        array('provinces', 'require', '请选择省份', self::MUST_VALIDATE),
        array('citys', 'require', '请选择市区', self::MUST_VALIDATE),
        array('countys', 'require', '请选择县区', self::MUST_VALIDATE),
        array('address', 'require', '请填写详细地址', self::MUST_VALIDATE),
        //array('price', 'require', '请填写价格', self::MUST_VALIDATE),

    );
	public function admin_add($data){
		if($this->create()){
            $user = session('user_auth');
            $uid = $user['uid'];
            $data['uid'] = $uid;
            $data['insert_time'] = time();
            $data['status'] = '1';
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            if($this->add($data)){
                return '1';
            }else{
                

                return '0';
            }
        }else{

            return $this->getError();
        }
	}
    public function admin_edit($data){
        if($this->create()){
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            if($this->save($data)){
                return '1';
            }else{
                echo $this->getLastSql();
                return '0';
            }
        }else{
            echo $this->getLastSql();
            return $this->getError();
        }
    }
    public function fr_add($data){
        if($this->create()){
            $uid = UID;
            $data['uid'] = $uid;
            $data['insert_time'] = time();
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            if($this->add($data)){
                return '1';
            }else{
                return '0';
            }
        }else{
            return $this->getError();
        }
    }
    public function fr_edit($data){
        if($this->create()){
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            if($this->save($data)){
                return '1';
            }else{
                return '0';
            }
        }else{
            return $this->getError();
        }
    }
}