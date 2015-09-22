<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Facilitator\Controller;


/**
 * 账户控制器 Mebmer
 * 用于订单的管理
 */
class MemberController extends FacilitatorController {
	public function index(){
		$model = M('facilitator_data');
		$uid = UID;
		$info = $model->where('uid = '.$uid)->find();
		$this->assign('info',$info);
		$this->display();
	}
}