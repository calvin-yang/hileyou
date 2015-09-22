<?php
/**
 * 简讯发送
 */
namespace ORG\Net;

use Home\Model;
use ORG\Util\Curl;

class Sms
{
    private static $mobile;
    private static $content;
    private static $userId;
    private static $verifyCode;
    private static $errno;
    private static $error;
    private static $VerifycodeModel;
    private static $type;
    private static $errorSmsArr = array('0' => '手机号码格式不正确!',
                                        '1' => '用户Id不存在',
                                        '2' => '验证码不存在',
                                        '3' => '短信发送失败',
                                        '4' => '验证码验证错误',
                                        '5'=>'验证码有效时间为5分钟，已超时！',
                                       );
    private static $contentArr = array('sendMobileVerify' => '您的验证码是[@str@]，请验证','sendVerify'=>'您的验证码是：[@str@]');

    static public function __callStatic($name, $args)
    {
        if (!self::$VerifycodeModel) {
            self::$VerifycodeModel = D('Verifycode');
        }
        self::$mobile = $args[0];

        //生成验证码
        $code = self::makeRand(5);
        self::$content = str_replace("@str@", $code, self::$contentArr[$name]);

        switch ($name) {
            case 'sendVerify':
                $type = $args[1];
                //发送验证内容
                $result = self::_sendCode();
                if (!$result)
                    return false;

                //验证
                $result = self::check(array('mobile'));
                if (!$result)
                    return false;

                //保存发送数据
                $data['mobile'] = self::$mobile;
                $data['content'] = self::$content;
                $data['type'] = $type?$type:'reg';
                $data['code'] = $code;
                $data['status'] = $result ? 1 : 2;
                $data['create_time'] = time();
                $data['verify_validity'] = time()+300;
                $result = self::$VerifycodeModel->addData($data);
                break;
            case 'sendMobileVerify':
                self::$userId = $args[1];
                //验证
                $result = self::check(array('mobile', 'userId'));
                if (!$result)
                    return false;

                //发送验证内容
                $result = self::_sendCode();
                if (!$result)
                    return false;

                //保存发送数据
                $data['mobile'] = self::$mobile;
                $data['user_id'] = self::$userId;
                $data['content'] = self::$content;
                $data['type'] = 'mobile_verify';
                $data['code'] = $code;
                $data['status'] = $result ? 1 : 2;
                $data['create_time'] = time();
                $data['verify_validity'] = time()+300;
                $result = self::$VerifycodeModel->addData($data);
                break;
            case 'mobileVerify':
                self::$type = $args[1];
                self::$verifyCode = $args[2];
                //验证
                $result = self::check(array('mobile', 'verifyCode'));
                if (!$result)
                    return false;

                $result = self::_mobileVerify();
                break;
        }
        if ($result)
            return true;

        return false;
    }

    /*
     * 验证 验证码
     */
    public static function _mobileVerify()
    {
        $map['mobile'] = self::$mobile;
        $map['code'] = self::$verifyCode;
        $map['verify_time'] = 0;
        $map['type'] = self::$type;
        $map['status'] = 1;
        $verify_obj = self::$VerifycodeModel->where($map)->order(' id desc ')->limit(1)->find();

        if ($verify_obj['id']) {
            if(time() > $verify_obj['verify_validity'])
            {
                self::$error = self::$errorSmsArr[5];
                return false;
            }
            //修改验证信息状态
            $data['id'] = $verify_obj['id'];
            $data['verify_time'] = time();
            $data['status'] = 3;
            $edit_id = self::$VerifycodeModel->save($data);
            if ($edit_id) {
                return true;
            }
        }
        self::$error = self::$errorSmsArr[4];
        return false;
    }

    //发送验证码
    public static function _sendCode()
    {

        //curl请求短信厂商
        $api = C('SMS_URL');
        $data = array(
            'c' => self::$content,
            'm' => self::$mobile
        );
        $Curl = new Curl();
        $xml = $Curl::get($api, $data);

        //解析xml
        $result = simplexml_load_string($xml);
        $result = get_object_vars($result);
        $result = $result['@attributes']['result'];
        if ($result == '-4') {
            self::$error = self::$errorSmsArr[3];
            return false;
        } else
            return true;

    }

    //验证
    private function check($check_arr = array())
    {

        if (in_array('mobile', $check_arr) & (!is_numeric(self::$mobile) || strlen(self::$mobile) != 11)) {
            self::$error = self::$errorSmsArr[0];
            return false;
        }
        if (in_array('userId', $check_arr) & !self::$userId) {
            self::$error = self::$errorSmsArr[1];
            return false;
        }
        if (in_array('verifyCode', $check_arr) & !self::$verifyCode) {
            self::$error = self::$errorSmsArr[2];
            return false;
        }
        return true;
    }

    // 获取错误
    public static function getError()
    {
        return self::$error;
    }

    // 获取错误编号
    public static function getErrno()
    {
        return self::$errno;
    }

    private static function makeRand($length = "5")
    {
//        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789";
        $str = '0123456789';
        $result = "";
        for ($i = 0; $i < $length; $i++) {
            $num[$i] = rand(0, 34);
            $result .= $str[$num[$i]];
        }
        return $result;
    }
}

