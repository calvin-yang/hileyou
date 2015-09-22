<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Facilitator\Controller;

use Common\Controller\Page;
/**
 * 订单控制器 Product
 * 用于订单的管理
 */
class FinanceController extends FacilitatorController {
	public function index(){
		$model = M('pro_order');
		$uid = UID;
		$map['b.status'] = array('not in','2,3');
		$map['a.uid'] = $uid;
		$count=$model->alias('a')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->count();
        $page=new Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
		$list = $model->alias('a')->field('a.id,a.discount_price,a.insert_time,a.pro_type,b.number order_number,b.status,b.title')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		order_int_to_string($list);
		$this->assign('_list',$list);

		#我的金额
		$maps['uid'] = $uid;
		$price = M('financial')->where($maps)->getField('price');
		$this->assign('price',$price);
		$this->display();
	}
	public function withdrawals(){
		#我的金额
		$uid = UID;
		$maps['uid'] = $uid;
		$price = M('financial')->where($maps)->getField('price');
		if(!$price)
			$this->error('很抱歉，您暂时还无余额');
		if(IS_POST){
			if(!I('post.price'))
				$this->error('您好，请输入您要提现的金额');
			$ti_price = I('post.price');
			if($ti_price > $price)
				$this->error('您好，你暂无这么多金额供你提现');
			#支付信息（支付宝，银行卡）
			$map['uid'] = $uid;
			$map['type'] = 1;
			$map['status'] = 1;
			$pay_info = M('back_infor')->field('id,back_card,account_name')->where($map)->find();
			if(!$pay_info)
				$this->error('您好，请去账户信息里面填写您的支付信息');
			$data['uid'] = $uid;
			$data['insert_time'] = time();
			$data['discount_price'] = $ti_price;
			#所属提现类型
			$data['pro_type'] = '6';
			#支付信息id
			$data['pro_id'] = $pay_info['id'];
			$pro_order_id = M('pro_order')->add($data);
			if($pro_order_id){
				unset($data);
				$data['pro_order_id'] = $pro_order_id;
				$data['number'] = order_number('5');
				$data['title'] = '提现';
				$data['status'] = 8;
				$result = M('order')->add($data);
				if($result){
					unset($data);unset($map);
					$s_price = $price - $ti_price;
					$map['uid'] = $uid;
					$data['price'] = $s_price;
					$data['last_price'] = $ti_price;
					$data['last_time'] = time();
					M('financial')->where($map)->save($data);
					unset($data);unset($map);
					$data['uid'] = $uid;
					$data['order_id'] = $result;
					$data['price'] = $ti_price;
					$data['content'] = '用户提现金额';
					$data['type'] = 2;
					$data['insert_time'] = time();
					M('finance_log')->add($data);

					$this->success('提现审核已被提交，请耐心等待');
				}else{
					M('pro_order')->where('id = '.$pro_order_id)->delete();
					$this->error('申请提现失败');
				}
			}else{
				$this->error('申请提现失败');
			}
		}
		$this->assign('price',$price);
		$this->display();
	}

}