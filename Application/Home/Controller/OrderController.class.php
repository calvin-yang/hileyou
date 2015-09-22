<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;


use Common\Model\Api\SendEailApi;
use ORG\Net;
/**
 * 产品控制器
 */
class OrderController extends HomeController
{	

	protected function _initialize(){
		/* 读取站点配置 */
		$config = api('Config/lists');
		C($config); //添加配置
        /* 判断是否登录 */
       is_login() || $this->ajaxReturn(array('msg' => '您还没有登录，请先登录！','status' => false));
    }
    public function index(){
    	$model = M('restaurant');
    	$list = $model->field('a.id,count(b.id)')->alias('a')->join('left join '.C('DB_PREFIX').'pro_order b on a.id = b.pro_id and b.pro_type = 2')->where('a.status = 1')->group('a.id')->select();
    	echo $model->getLastSql();
    	echo 'dfdfd';
    }
	/**
	 * 预定信息
	 * 
	 * @return [type] [description]
	 */
	public function reservation(){

		if(!I('get.pro_type') || !I('get.proid')){
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		}
		#产品类型
		$protype = I('get.pro_type');
		#产品id
		$proid = I('get.proid');
		$uid=is_login();
		switch ($protype) {
			#房源
			case '1':
				
				//获取产品信息
				if(!I('get.order_id'))
				{
					$model=M('hel');
					$info=$model->field('id pro_id,bed_type,title pro_name,logo_img_url pro_img,type,day_price as price,vip_price,favorable_price')->where('id='.$proid)->find();
				}else{
					/****    已有订单数据  *****/
					$model = M('pro_order');
					$map['b.status'] = array('eq',0);
					$map['a.id'] = array('eq',I('get.order_id'));
					$map['a.pro_type'] = array('eq',1);
					$map['a.pro_id'] = array('eq',$proid);
					$map['a.uid'] = array('eq',$uid);
					$info = $model->field('a.id,a.pro_id,a.pro_name,a.pro_type,a.pro_img,a.number,FROM_UNIXTIME(a.start_time, "%Y-%m-%d") start_time,FROM_UNIXTIME(a.end_time, "%Y-%m-%d") end_time,a.adult,a.name,a.tel,a.unit_price,c.bed_type,c.type')->alias('a')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->join(C('DB_PREFIX').'hel c on a.pro_id = c.id')->where($map)->find();
					
					if(!$info)
						$this->ajaxReturn(array('msg' => '非法操作','status' => false));
					$info['discount_price'] = $info['number'] * $info['unit_price'];
				}
				

				break;
			#餐饮
			case '2':
				if(!I('get.order_id'))
				{
					$model=M('restaurant');
					$info=$model->field('id pro_id,foot_name pro_name,logo_img_url pro_img,type,address,per_capita as price,vip_price,favorable_price')->where('id='.$proid)->find();
					#代金券数量
					$vo['a.uid'] = array('eq',$uid);
					$vo['a.pro_id'] = array('eq',$proid);
					$vo['b.effective_time'] = array('egt',time());
					$voucher_number = M('voucher')->alias('a')->join(C('DB_PREFIX').'restaurant b on a.pro_id = b.id')->where($vo)->getField('sum(number)');

					$voucher['msg'] = '代金券数量';
					$voucher['voucher_number'] = $voucher_number;
					$data['voucher'] = $voucher;
				}else{
					/****    已有订单数据  *****/
					$model = M('pro_order');
					$order_id = I('get.order_id');
					$map['b.status'] = array('eq',0);
					$map['a.id'] = array('eq',$order_id);
					$map['a.pro_type'] = array('eq',2);
					$map['a.pro_id'] = array('eq',$proid);
					$map['a.uid'] = array('eq',$uid);
					$info = $model->alias('a')->field('a.id,a.pro_id,a.pro_name,a.pro_type,a.number,FROM_UNIXTIME(a.start_time, "%Y-%m-%d %H:%i") start_time,a.name,a.tel,a.unit_price,c.address,c.type')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->join(C('DB_PREFIX').'restaurant c on a.pro_id = c.id')->where($map)->find();

					if(!$info)
						$this->ajaxReturn(array('msg' => '非法操作','status' => false));
					$info['discount_price'] = $info['number'] * $info['unit_price'];
					$start_time = explode(' ',$info['start_time']);
					$info['start_date'] = $start_time['0'];
					$info['start_time'] = $start_time['1'];
					#代金券数量
					$vo['a.uid'] = array('eq',$uid);
					$vo['a.pro_id'] = array('eq',$proid);
					$vo['b.effective_time'] = array('egt',time());
					$voucher_number = M('voucher')->alias('a')->join(C('DB_PREFIX').'restaurant b on a.pro_id = b.id')->where($vo)->getField('sum(number)');

					$voucher['msg'] = '代金券数量';
					$voucher['voucher_number'] = $voucher_number;
					$data['voucher'] = $voucher;
				}
				
				break;
			#景点
			case '3':
				if(!I('get.order_id'))
				{
					$model=M('play');
					$info=$model->field('id pro_id,title pro_name,logo_img_url pro_img,type,price,favorable_price,vip_price')->where('id='.$proid)->find();
				}else{
					/****    已有订单数据  *****/
					$model = M('pro_order');
					$order_id = I('get.order_id');
					$map['b.status'] = array('eq',0);
					$map['a.id'] = array('eq',$order_id);
					$map['a.pro_type'] = array('eq',3);
					$map['a.pro_id'] = array('eq',$proid);
					$map['a.uid'] = array('eq',$uid);
					$info = $model->alias('a')->field('a.id,a.pro_id,a.pro_name,a.pro_type,a.number,FROM_UNIXTIME(a.start_time, "%Y-%m-%d") start_time,a.name,a.tel,a.unit_price,c.type')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->join(C('DB_PREFIX').'play c on a.pro_id = c.id')->where($map)->find();
					
					if(!$info)
						$this->ajaxReturn(array('msg' => '非法操作','status' => false));
					$info['discount_price'] = $info['number'] * $info['unit_price'];
				}
				
				break;
			#路线
			case '4':
				if(!I('get.order_id'))
				{
					$model=M('route');
					$info = $model->field('a.id pro_id,a.title pro_name,a.logo_img_url pro_img,a.destination,a.effective_date,a.starting_city,a.price,a.vip_price,a.favorable_price')->alias('a')->where('a.id = '.$proid)->find();					

				}else{
					/****    已有订单数据  *****/
					$model = M('pro_order');
					$order_id = I('get.order_id');
					$map['b.status'] = array('eq',0);
					$map['a.id'] = array('eq',$order_id);
					$map['a.pro_type'] = array('eq',4);
					$map['a.pro_id'] = array('eq',$proid);
					$map['a.uid'] = array('eq',$uid);
					$info = $model->alias('a')->field('a.id,a.pro_id,a.pro_type,a.number,FROM_UNIXTIME(a.start_time, "%Y-%m-%d") start_time,a.starting_city,a.name,a.tel,a.unit_price,c.title pro_name,c.destination,c.effective_date')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->join(C('DB_PREFIX').'route c on a.pro_id = c.id')->where($map)->find();
					if(!$info)
						$this->ajaxReturn(array('msg' => '非法操作','status' => false));
					$info['discount_price'] = $info['number'] * $info['unit_price'];
				}
				/**  获取出发时间与出发地点start **/
				if(strstr($info['effective_date'],','))
					$info['effective_date'] = explode(',',$info['effective_date']);
				else
					$info['effective_date'] = array($info['effective_date']);

				if(strstr($info['starting_city'],','))
					$info['starting_city'] = explode(',',$info['starting_city']);
				else
					$info['starting_city'] = array($info['starting_city']);
				/**  获取出发时间与出发地点end **/
				
				break;

		}

		#获取用户信息
		$user_info = M('ucenter_member')->field('a.mobile,a.id,b.realname,b.score,c.vip_id')->alias('a')->join('left join '.C('DB_PREFIX').'member_vip c on a.id = c.uid and c.status = 1')->join('left join '.C('DB_PREFIX').'member b on a.id = b.uid')->where('a.id = '.$uid)->find();
		#是否开启积分兑换
		$points_on_off = C('POINTS_ON_OFF');
		if(empty($points_on_off)){
			$points['msg'] = '积分兑换已被禁用';
			$points['status'] = false;
		}else{
			#积分兑换值
			$using_integral = C('USING_INTEGRAL');
			if(empty($user_info['score'])){
				$points['msg'] = '用户无积分';
				$points['status'] = false;
			}else{
				$score_price = $using_integral * $user_info['score'];
				$points['msg'] = '积分兑换已被开启';
				$points['status'] = true;
				$points['score'] = intval($user_info['score']);
				$points['score_price'] = $score_price;
			}
			
		}

		if(I('get.order_id')){
			$money['price'] = $info['unit_price'];
			$money['msg'] = '价格';
		}else{
			/**  检测vip价格start **/
			if($user_info['vip_id']){
				$price = vip_price($user_info['vip_id'],$info['vip_price']);
				if(!empty($price) && $price['1']!=0){
					if($info['favorable_price'])
						$money['price'] = round(($price['1'] * $info['favorable_price']),2);
					else
						$money['price'] = round(($price['1'] * $info['price']),2);
							
						$money['msg'] = 'vip价';
				}else{
					if($info['favorable_price']){
						$money['price'] = round($info['favorable_price'],2);
						$money['msg'] = '优惠价';
					}else{
						$money['price'] = round($info['price'],2);
						$money['msg'] = '标准价';
					}
				}
			}else{
				if($info['favorable_price']){
					$money['price'] = round($info['favorable_price'],2);
					$money['msg'] = '优惠价';
				}else{
					$money['price'] = round($info['price'],2);
					$money['msg'] = '标准价';
				}
			}
			/**  检测vip价格end **/
		}
		
		
		
		
		
		if(!$info){
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		}
		#产品信息
		unset($info['price']);unset($info['vip_price']);unset($info['favorable_price']);

		$data['info'] = $info;
		#用户信息
		unset($user_info['id']);unset($user_info['score']);unset($user_info['vip_id']);
		$data['user_info'] = $user_info;
		#产品价格
		$data['money'] = $money;
		#积分兑换
		$data['points'] = $points;
		$this->ajaxReturn(array('data' => $data,'status' => true));

	}
	//代金券预定
	public function voucherorder(){
		if(IS_POST){
			/**
			 * 现金券数量   number
			 * 总价			total_price
			 * 单价			unit_price
			 * 联系人电话	tel
			 */
			if(!I('post.proid') || !I('post.number'))
				$this->ajaxReturn(array('msg' => '非法操作','status' => false));
			
			$model = M('pro_order');
			$uid = is_login();
			$data = I('post.');
			#服务商id
			$fa_uid = M('restaurant')->where('id = '.$data['proid'])->getField('uid');
			$data['fa_uid'] = $fa_uid;
			$data['pro_id'] = $data['proid'];
			$data['total_price'] = $data['discount_price'] = $data['number'] * $data['unit_price'];
			$data['insert_time'] = time();
			$data['pro_type'] = 5;
			$data['uid'] = $uid;

			$pro_order_id = $model->add($data);
			if($pro_order_id){
				unset($data);

				$data['pro_order_id'] = $pro_order_id;
				$data['title'] = '代金券';

				$data['number'] = $uid.date('YmdHis');
				$result = M('order')->add($data);

				if($result)
					$this->ajaxReturn(array('msg' => '下单成功','status' => true));
				else
					$this->ajaxReturn(array('msg' => '下单失败','status' => false));
			}else{
				$this->ajaxReturn(array('msg' => '下单失败','status' => false));
			}
			



		}
		if(!I('get.proid'))
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		$uid = is_login();
		if(!I('get.pro_id')){
			$model=M('restaurant');
			
			$map['a.id'] = array('eq',I('get.proid'));
			#餐饮信息
			$info=$model->field('a.id pro_id,a.foot_name pro_name,a.logo_img_url pro_img,a.voucher unit_price')->alias('a')->where($map)->find();
			unset($map);
			$map['id'] = array('eq',$uid);
			#用户手机号
			$mobile = M('ucenter_member')->where($map)->getField('mobile');

			$data['info'] = $info;
			$data['mobile'] = $mobile;
			$data['msg'] = 'info:餐饮信息;mobile:用户手机号';
		}else{
			$model = M('pro_order');
			$order_id = I('get.order_id');
			$map['b.status'] = array('eq',0);
			$map['a.id'] = array('eq',$order_id);
			$map['a.pro_type'] = array('eq',5);
			$map['a.pro_id'] = array('eq',$pro_id);
			$map['a.uid'] = array('eq',$uid);
			$info = $model->field('a.id,a.pro_id,a.pro_name,a.unit_price,a.number,a.tel mobile')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->find();
			if(!$info)
				$this->ajaxReturn(array('msg' => '非法操作','status' => false));
			$data['info'] = $info;
			$data['mobile'] = $info['mobile'];
			$data['msg'] = 'info:餐饮信息;mobile:用户手机号';
		}
		

		$this->ajaxReturn(array('msg' => '成功访问','data' => $data,'status' => true));

	}

	/**
	 * 添加至订单
	 * ?s=/home/user/sendVerify/mobile/185886132777/type/reservation 发送验证码
	 * @return [type] [description]
	 */
	public function insertorder(){

		#验证验证码
        // $result = Net\Sms::mobileVerify(I('post.tel'), 'reservation', I('post.verify_code'));
        // if (!$result)
        //     $this->returnJson(false, Net\Sms::getError());
		#产品类型
		$pro_type = I('post.pro_type');
		if(!is_numeric($pro_type))
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		
				
				$uid = is_login();
				if(IS_POST){
					/**
					 * score_status   积分状态(1:不使用;2:使用)
					 * pro_id 产品id
					 * pro_type 产品类型
					 * name 联系人
					 * tel 联系电话
					 * number 产品数量
					 * discount_price 折扣价格
					 * unit_price 单价
					 * discount_way  折扣途径
					 * starting_city 出发地点
					 * start_time  开始时间
					 */
					
					
					$data = I('post.');
					
					#房源
					
					if($pro_type == 1){

						#服务商id
						$fa_uid = M('hel')->where('id = '.$data['pro_id'])->getField('uid');
						$data['fa_uid'] = $fa_uid;
						$data['start_time'] = strtotime($data['start_time']);
						$data['end_time'] = strtotime($data['end_time']);
						$date_time = ($data['end_time'] - $data['start_time']);
						if($date_time <= 0)
							$this->ajaxReturn(array('msg' => '结束时间不能小于开始时间','status' => false));
						$day = round($date_time/86400);
						$data['number'] = $day;
					#餐饮
					}else if($pro_type == 2){
						if(!I('post.start_time'))
							$this->ajaxReturn(array('msg' => '请填写预定时间','status' => false));
						#服务商id
						$fa_uid = M('restaurant')->where('id = '.$data['pro_id'])->getField('uid');
						$data['fa_uid'] = $fa_uid;
						$start_time = $data['start_date'].' '.$data['start_time'];
						$data['start_time'] = strtotime($start_time);
						#检测是否使用代金券
						if(I('voucher_number')){
							$voucher_number = I('voucher_number');
							$vo['a.uid'] = array('eq',$uid);
							$vo['a.pro_id'] = array('eq',$data['pro_id']);
							$vo['b.effective_time'] = array('egt',time());
							$vorcher_count = M('voucher')->alias('a')->join(C('DB_PREFIX').'restaurant b on a.pro_id = b.id')->where($vo)->getField('sum(number)');
							$voucher_price = M('voucher')->alias('a')->join(C('DB_PREFIX').'restaurant b on a.pro_id = b.id')->where($vo)->getField('voucher_price');
							$data['voucher_price'] = $voucher_price;
							if($voucher_number > $vorcher_count)
								$this->ajaxReturn(array('msg' => '非法操作','status' => false));

						}
					#景点
					}else if($pro_type == 3){
						if(!I('post.start_time'))
							$this->ajaxReturn(array('msg' => '请填写出行时间','status' => false));
						#服务商id
						$fa_uid = M('play')->where('id = '.$data['pro_id'])->getField('uid');
						$data['fa_uid'] = $fa_uid;
						$data['start_time'] = strtotime($data['start_time']);
					#路线
					}else if($pro_type == 4){
						if(!I('post.start_time'))
							$this->ajaxReturn(array('msg' => '请填写出行时间','status' => false));
						#服务商id
						$fa_uid = M('route')->where('id = '.$data['pro_id'])->getField('uid');
						$data['fa_uid'] = $fa_uid;
						$data['start_time'] = strtotime($data['start_time']);
					}
					#产品总价
					$data['total_price'] = $data['number'] * $data['unit_price'];
					// if(!I('post.score'))
					// 	$this->ajaxReturn(array('msg' => '非法操作','status' => false));

					#判断是否使用了积分,计算折扣价
					if($data['score'] == 2){
						$using_integral = C('USING_INTEGRAL');
						$score = M('member')->where('uid ='.$uid)->getField('score');
						$data['discount_way'] = '积分';
						/***  计算折扣价 ***/
						if($score){
							$ps = $using_integral * $score;
							$data['score_price'] = $ps;
							$data['score'] = $score;
							$data['discount_price'] = ($data['number'] * $data['unit_price'] - $ps);
						}else{
							$data['discount_price'] = ($data['number'] * $data['unit_price']);
						}
						/***  计算折扣价 ***/
						/*
						M('member')->save(array('uid'=>$uid,'score' => '0'));
						if(I('post.order_id')){
							$order_id = I('post.order_id');
							$score_member_log_id = M('pro_order')->where('uid ='.$uid.' and id = '.$order_id)->getField('discount_way');
							if($score_member_log_id)
								M('score_member_log')->where('id = '.$score_member_log_id)->delete();

						}
						*/

						#记录用户使用积分
						/*
						
						switch ($data['pro_type']) {
							case '1':
								$us['url'] = U('Product/rtContent',array('id' => $data['pro_id']));
								break;
							case '2':
								$us['url'] = U('Product/rtContent',array('id' => $data['pro_id']));
								break;
							case '3':
								$us['url'] = U('Product/pyContent',array('id' => $data['pro_id']));
								break;
							case '4':
								$us['url'] = U('Product/eatDesc',array('id' => $data['pro_id']));
								break;
						}
						$us['uid'] = $uid;
						$us['val'] = $score;
						$us['content'] = '用于购买产品';
						$us['insert_time'] = time();
						$us['type'] = 0;
						$score_member_log_id = M('score_member_log')->add($us);
					*/

					}else{
						$data['score'] = 0;
						#计算折扣价格
						$data['discount_price'] = ($data['number'] * $data['unit_price']);
					}

					/***  计算餐饮折扣价 start ***/
					if($voucher_number && $score){
						$data['discount_price'] = ($data['total_price'] - ($using_integral * $score) - (100 * $voucher_number));
						if($data['discount_price'] < 0)
							$data['discount_price'] = 0;
					}else if($voucher_number && !$score){
						$data['discount_price'] = ($data['total_price'] - (100 * $voucher_number));
						if($data['discount_price'] < 0)
							$data['discount_price'] = 0;
					}else if(!$voucher_number && $score){
						$data['discount_price'] = ($data['total_price'] - ($using_integral * $score));
						if($data['discount_price'] < 0)
							$data['discount_price'] = 0;
					}
					/***  计算餐饮折扣价 end ***/

					
					$data['discount_way'] = '积分';
					$data['score_member_log_id'] = $score_member_log_id;
					if(I('post.order_id')){
						$data['id'] = I('post.order_id');
						$pro_order_ids = M('pro_order')->save($data);
					}else{
						$data['insert_time'] = time();
						$data['uid'] = $uid;
						$pro_order_ids = M('pro_order')->add($data);
					}
					$discount_price = $data['discount_price'];
					unset($data);
					if($pro_type == 1){$data['title'] = '住宿';}
					else if($pro_type == 2){$data['title'] = '美食';}
					else if($pro_type == 3){$data['title'] = '景点';}
					else if($pro_type == 4){$data['title'] = '路线';}
					if($pro_order_ids){
						if(I('post.order_id')){
							$pro_order_id = I('post.order_id');
							$result = M('order')->where('pro_order_id = '.$pro_order_id)->save($data);
						}else{
							if(intval($discount_price) == 0)
								$data['status'] = 7;
							$data['pro_order_id'] = $pro_order_ids;
							$data['number'] = $uid.date('YmdHis');
							$result = M('order')->add($data);
						}
						
						if($result){
							if(intval($discount_price) == 0){
								/***   用户代金券表自减  ***/
								$voucher = M('pro_order')->field('pro_id,pro_type,voucher_number')->where('id = '.$pro_order_ids)->find();
								if($voucher){
									$vs['pro_id'] = $voucher['pro_id'];
									$vs['pro_type'] = $voucher['pro_type'];
									$voucher_number = $voucher['voucher_number'];
									M('voucher')->where($vs)->setDec('number',$voucher_number);
								}
								
								/***   用户代金券表自减  ***/
								$this->ajaxReturn(array('msg' => '下单成功,不用跳转支付页面','type'=>2,'status' => true));
							}else{
								$this->ajaxReturn(array('msg' => '下单成功','status' => true));
							}
						}else{
							$this->ajaxReturn(array('msg' => '下单失败','status' => false));
						}
					}else{
						$this->ajaxReturn(array('msg' => '下单失败','status' => false));
					}

				}
			
	}


}