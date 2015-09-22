<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;

/**
 * 前台控制器
 * APP支付宝支付
 */
class AlipayController extends HomeController {
	
	public function alipayapi(){
		$data['service']='mobile.securitypay.pay';				//接口名称	string	not null
		$data['partner']='2088711825914372';					//合作者身份id	string	not null
		$data['_input_charset']='utf-8';						//参数编码字符集	string	not null
		$sign_type='RSA';										//签名方式	string	not null
		$data['notify_url']='http://hileyou.52xqb.com/index.php?s=home/Alipay/aaa';							//服务器异步通知页面路径	string	not null
		$data['app_id']='';										//客户端号	string
		$data['appenv']='';										//客户端来源	string
		$data['out_trade_no']='123456789';						//商户网站唯一订单号	string	not null
		$data['subject']='测试';									//商品名称	string	not null
		$data['payment_type']='1';								//支付类型	string	not null
		$data['seller_id']='pay@itelland.com';					//卖家支付宝账号	string	not null
		$data['total_fee']='1';									//总金额		number   ps:0.01	not null
		$data['body']='123';									//商品详情	string	not null
		$data['it_b_pay']='30m';								//未付款交易的超时时间		string
		$data['extern_token']='';								//授权令牌	string
		$data['paymethod']='';									//使用银行卡支付	string
		$data['sign']=$this->signCreate($data);					//签名	string not null
		dump($data);
	}
	
	public function signCreate($data=array()){
		if(!$data){
			$this->error('请求失败，请联系管理员！');
		}
		foreach ($data as $key=>$val){
			$arr.=$key."='".$val."'&";
		}
		$arr=substr($arr,0,-1);
		return $arr;
	}
	
	public function aaa(){
		
	}
	
}