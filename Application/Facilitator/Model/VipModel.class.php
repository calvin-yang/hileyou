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
class VipModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('name', 'require', 'VIP名称不能为空', self::MUST_VALIDATE),
        //array('name', '/^[^\,\|\;]$/i', 'VIP名称不能包含(, | ;)等特殊符号', self::MUST_VALIDATE),
        array('name', '', '该VIP类目已经存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
        array('remark','0,30','描述长度不能超过30个字符！',0,'length'),
        array('monthly_price', 'require', '月价不能为空', self::MUST_VALIDATE),
        array('monthly_price', '/^(([0-9]+\.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*\.[0-9]+)|([0-9]*[1-9][0-9]*))$/', '月价只能为一个阿拉伯数字', self::MUST_VALIDATE),
    );
	public function add(){
		
	}
}