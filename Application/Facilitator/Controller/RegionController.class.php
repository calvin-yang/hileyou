<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Facilitator\Controller;
use Think\Controller;
/**
 * 地区控制器 Product
 * 用于省市区的显示
 */

class RegionController extends Controller {
	public function action(){
		$model = M('global_region');
		$type = isset($_GET["type"]) ? $_GET["type"] : "";
		$parent_id = isset($_GET["parent_id"]) ? $_GET["parent_id"] : "";
		$list = $model->where("parent_id={$parent_id} and region_type={$type}")->select();
		echo $provinces_json = json_encode($list);
	}
}