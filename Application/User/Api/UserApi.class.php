<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace User\Api;
use User\Api\Api;
use User\Model\UcenterMemberModel;

//require_cache(dirname(__FILE__) . '/Api.class.php');

class UserApi extends Api{
	/**
	 * 构造方法，实例化操作模型
	 */
	protected function _init(){
		$this->model = new UcenterMemberModel();
	}

	/**
	 * 注册一个新用户
	 * @param  string $username 用户名
	 * @param  string $password 用户密码
	 * @param  string $email    用户邮箱
	 * @param  string $mobile   用户手机号码
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	// public function register($username, $password, $email, $mobile = ''){
	// 	return $this->model->register($username, $password, $email, $mobile);
	// }
	public function register($mobile = '',$password = '',$username = ''){
		return $this->model->register($mobile,$password,$username);
	}

	/**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($mobile, $password, $type = 3){
		return $this->model->login($mobile, $password, $type);
	}

	/**
	 * 服务商登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function facilitaorlogin($mobile, $password, $type = 3){
		return $this->model->frlogin($mobile, $password, $type);
	}

	/**
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_username 是否使用用户名查询
	 * @return array                用户信息
	 */
	
	/**
	 * 第一次登录设置密码
	 * @param array $data 用户信息
	 */
	public function insertpwd($data){
		if($data['password'] != $data['repassword']){
			$result = array('status' => '0','info' => '您两次输入的密码不一致');
		}else if(strlen($data['password']) < 6){
			$result = array('status' => '0','info' => '邮箱长度不能少于6位');

		}else{
			$result = $this->model->insertpwd($data);
		}
		return $result;
		
	}
	public function info($uid, $is_username = false){
		return $this->model->info($uid, $is_username);
	}

	/**
	 * 检测用户名
	 * @param  string  $field  用户名
	 * @return integer         错误编号
	 */
	public function checkUsername($username){
		return $this->model->checkField($username, 1);
	}

	/**
	 * 检测邮箱
	 * @param  string  $email  邮箱
	 * @return integer         错误编号
	 */
	public function checkEmail($email){
		return $this->model->checkField($email, 2);
	}

	/**
	 * 检测手机
	 * @param  string  $mobile  手机
	 * @return integer         错误编号
	 */
	public function checkMobile($mobile){
		return $this->model->checkField($mobile, 3);
	}

	/**
	 * 更新用户信息
	 * @param int $uid 用户id
	 * @param string $password 密码，用来验证
	 * @param array $data 修改的字段数组
	 * @return true 修改成功，false 修改失败
	 * @author huajie <banhuajie@163.com>
	 */
	public function updateInfo($uid, $password, $data){
		if($this->model->updateUserFields($uid, $password, $data) !== false){
			$return['status'] = true;
		}else{
			$return['status'] = false;
			$return['info'] = $this->model->getError();
		}
		return $return;
	}
	/**
	 * 管理员修改注册用户信息
	 * @param array $data 用户信息
	 */
	public function admin_edit($data,$uid){
		//echo think_ucenter_md5('qwe123', UC_AUTH_KEY);
		$data['id'] = $uid;
		$data['sex']=$data['sex']['0'];
		return $this->model->edit($data);
	}

}
