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
class RestaurantModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('logo_img_url', 'require', '封面图片不能为空', self::MUST_VALIDATE),
        array('foot_name', 'require', '请填写餐饮店名', self::MUST_VALIDATE),
        array('foot_tel', 'require', '请填写餐饮电话', self::MUST_VALIDATE),
        array('per_capita', 'require', '请填写人均消费', self::MUST_VALIDATE),
        array('voucher', 'require', '请填写现金劵价格', self::MUST_VALIDATE),
        array('address', 'require', '请填写详细地址', self::MUST_VALIDATE),
        array('type', 'require', '请填写餐馆类型', self::MUST_VALIDATE),
    );
	public function admin_add($data){
		if($this->create()){
            //$data['status'] = '1';
            if($this->add($data)){
                
                return '1';
            }else{
                //echo $this->getLastSql();
                // exit;
                return '0';
            }
        }else{
            return $this->getError();
        }
	}
    public function admin_edit($data){
        if($this->create()){
            $this->save($data);
            return '1';
        }else{
            return $this->getError();
        }
    }
    public function fr_add($data){
        if($this->create()){
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
            $this->save($data);
            return '1';
        }else{
            return $this->getError();
        }
    }
}