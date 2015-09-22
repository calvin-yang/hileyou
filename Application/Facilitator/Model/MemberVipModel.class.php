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
class MemberVipModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('uid', '', '该VIP用户已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('date', 'require', 'vip天数不能为空', self::MUST_VALIDATE),
        array('date', '/^[1-9]\d*$/', 'vip天数只能为阿拉伯数字', self::MUST_VALIDATE),
    );
	public function add(){
		
	}
}