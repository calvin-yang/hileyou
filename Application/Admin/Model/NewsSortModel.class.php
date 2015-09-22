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
 * 文章分类模型
 */
class NewsSortModel extends Model{
	/* 自动验证规则 */
    protected $_validate = array(
        array('name', 'require', '类名不能为空', self::MUST_VALIDATE),
    );
}