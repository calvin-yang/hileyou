<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

/**
 * 前台公共库文件
 * 主要定义前台公共函数库
 */

/**
 * 检测验证码
 * @param  integer $id 验证码ID
 * @return boolean     检测结果
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function check_verify($code, $id = 1){
	$verify = new \COM\Verify();
	return $verify->check($code, $id);
}

/**
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status   数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1){
    static $count;
    if(!isset($count[$category])){
        $count[$category] = D('Document')->listCount($category, $status);
    }
    return $count[$category];
}

/**
 * 获取段落总数
 * @param  string $id 文档ID
 * @return integer    段落总数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_part_count($id){
    static $count;
    if(!isset($count[$id])){
        $count[$id] = D('Document')->partCount($id);
    }
    return $count[$id];
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url){
    switch ($url) {
        case 'http://' === substr($url, 0, 7):
            break;
        case '#' === substr($url, 0, 1):
            break;        
        default:
            $url = U($url);
            break;
    }
    return $url;
}

/**
 * 生成验证码
 * @param  string $length 生成几位数
 * @author calvin <977639814@qq.com>
 */
function randomkeys($length = '4'){
    $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
    for($i = 0 ; $i < $length ; $i++){
        $key .= $pattern{mt_rand(0,35)};
    }
    return $key;
}


function getPKey($filePath){
        if(!file_exists($filePath)) { 
            return false; 
        } 
        
        $bankCerts = array();
        $bankPcks12 = file_get_contents($filePath); 
    
        // if (openssl_pkcs12_read($bankPcks12, $bankCerts)) { 
        //     return $bankCerts;
        // }else{ 
        //     return false; 
        // } 
        return $bankPcks12;

    }

// 对签名字符串转义
function createLinkstring($para) {
    $arg  = "";
    while (list ($key, $val) = each ($para)) {
        
        $arg.= ($key.'="'.$val.'"&');
    }
    //去掉最后一个&字符
    $arg = substr($arg,0,count($arg)-2);
    //如果存在转义字符，那么去掉转义
    if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
    return $arg;
}

// 签名生成订单信息
function rsaSign($data) {
    $filePath = "./Public/rsa_private_key.pem";
    $priKey = getPKey($filePath);
    $res = openssl_get_privatekey($priKey);
    openssl_sign($data, $sign,$priKey);
    openssl_free_key($priKey);
    $sign = base64_encode($sign);
    //$sign = urlencode($sign);
    return $sign;
}
/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
// function createLinkstring($para) {
//     $arg  = "";
//     while (list ($key, $val) = each ($para)) {
//         $arg.=$key."=".$val."&";
//     }
//     //去掉最后一个&字符
//     $arg = substr($arg,0,count($arg)-2);
    
//     //如果存在转义字符，那么去掉转义
//     if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
    
//     return $arg;
// }
/**
 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
 * @param $para 需要拼接的数组
 * return 拼接完成以后的字符串
 */
function createLinkstringUrlencode($para) {
    $arg  = "";
    while (list ($key, $val) = each ($para)) {
        $arg.=$key."=".urlencode($val)."&";
    }
    //去掉最后一个&字符
    $arg = substr($arg,0,count($arg)-2);
    
    //如果存在转义字符，那么去掉转义
    if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
    
    return $arg;
}
/**
 * 除去数组中的空值和签名参数
 * @param $para 签名参数组
 * return 去掉空值与签名参数后的新签名参数组
 */
function paraFilter($para) {
    $para_filter = array();
    while (list ($key, $val) = each ($para)) {
        if($key == "sign" || $key == "sign_type" || $val == "")continue;
        else    $para_filter[$key] = $para[$key];
    }
    return $para_filter;
}
/**
 * 对数组排序
 * @param $para 排序前的数组
 * return 排序后的数组
 */
function argSort($para) {
    ksort($para);
    reset($para);
    return $para;
}
/**
 * RSA签名
 * @param $data 待签名数据
 * @param $private_key_path 商户私钥文件路径
 * return 签名结果
 */
// function rsaSign($data, $private_key_path) {
//     $priKey = file_get_contents($private_key_path);
//     $res = openssl_get_privatekey($priKey);
//     openssl_sign($data, $sign, $res);
//     openssl_free_key($res);
//     //base64编码
//     $sign = base64_encode($sign);
//     return $sign;
// }