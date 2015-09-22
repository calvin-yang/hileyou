<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: huajie <banhuajie@163.com>
// +----------------------------------------------------------------------

namespace Admin\Model;
use Think\Model;

/**
 * 产品类型模型
 */
class LvTypeModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('name', 'require', '标配不能为空', self::MUST_VALIDATE),
        array('type', '', '该品种已存在', self::VALUE_VALIDATE, 'unique', self::MODEL_BOTH),
    );

}