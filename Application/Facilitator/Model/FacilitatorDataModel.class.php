<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Facilitator\Model;
use Think\Model;

/**
 * 文档基础模型
 */
class FacilitatorDataModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('realname', 'require', '请填写真实姓名', self::MUST_VALIDATE),
        array('IDcard', 'require', '请填写身份证号', self::MUST_VALIDATE),
        array('tel', 'require', '请填写固定电话/公司电话', self::MUST_VALIDATE),
        array('id_card_positive', 'require', '请上传身份证正面' , self::MUST_VALIDATE),
        array('id_card_opposite', 'require', '请上传身份证反面' , self::MUST_VALIDATE),

        array('realname', '', '该姓名已存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('uid', '', '该用户已存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
    );
	public function add($data){
		if($this->create($data)){
            M('FacilitatorData')->add($data);
            
            return '1';
            
        }else{
            return $this->getError();
        }
	}
    public function edit($data){
        if($this->create($data)){
            M('FacilitatorData')->save($data);
            
            return '1';
            
        }else{
            return $this->getError();
        }
    }
}