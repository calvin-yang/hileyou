<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    'MODULE_DENY_LIST'   => array('Common', 'User','Admin','Facilitator'),
    /* 模块 域名授权 */
    'APP_SUB_DOMAIN_DEPLOY'   =>    1, // 开启子域名配置
    'APP_SUB_DOMAIN_RULES'    =>    array(
        'admin.hileyou.com'  => 'Admin',  // admin.domain1.com域名指向Admin模块
        'dealer.hileyou.com'  => 'Facilitator',  // dealer.hileyou.52xqb.com域名指向Facilitator模块
    ),

);
