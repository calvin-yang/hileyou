<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Common\Model\Api;
use User\Api\Api;
// 调用邮件类
use ORG\Net;

//require_cache(dirname(__FILE__) . '/Api.class.php');

class SendEailApi extends Api{
	/**
	 * 构造方法，实例化操作模型
	 */
	protected function _init(){
		$this->mail = new Net\PHPMailer();
	}

	/**
	 * 发送邮件
	 * @param  string $address 收件人地址
	 * @param  string $title 标题
	 * @param  string $message    内容
	 * @param  string $fromname   发件人名
	 */

	function SendMail($address,$title,$message,$fromname='海乐游')
    {
        $this->mail->IsSMTP();
        $this->mail->CharSet=C('MAIL_CHARSET');
        $this->mail->From= C('MAIL_ADDRESS');
        $this->mail->Host=C('MAIL_SMTP');
        $this->mail->SMTPAuth=C('MAIL_AUTH');
        $this->mail->Username=C('MAIL_LOGINNAME');
        $this->mail->Password=C('MAIL_PASSWORD');
        $this->mail->IsHTML(C('MAIL_HTML'));
        $this->mail->AddAddress($address);
        $this->mail->Body=$message;
        $this->mail->FromName=$fromname;
        $this->mail->Subject=$title;
        return($this->mail->Send());
    }


}
