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
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
// 引用邮箱发送api
use Common\Model\Api\SendEailApi;
class PayController extends HomeController {

    //系统首页
    
    public function index(){



    	// 获取支付金额
$amount='';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $amount=$_POST['total'];
}else{
    $amount=$_GET['total'];
}

$total = floatval($amount);
if(!$total){
    $total = 1;
}




// 支付宝合作者身份ID，以2088开头的16位纯数字
$partner = "2088711825914372";
// 支付宝账号
$seller_id = 'pay@itelland.com';
// 商品网址
$base_path = urlencode('http://www.dcloud.io/helloh5/');
// 异步通知地址
$notify_url = 'http://hileyou.52xqb.com';
// 订单标题
$subject = 'DCloud项目捐赠';
// 订单详情
$body = 'DCloud致力于打造HTML5最好的移动开发工具，包括终端的Runtime、云端的服务和IDE，同时提供各项配套的开发者服务。'; 
// 订单号，示例代码使用时间值作为唯一的订单ID号
$out_trade_no = '20150916170234';//date('YmdHis', time());

$parameter = array(
    'service'        => 'mobile.securitypay.pay',   // 必填，接口名称，固定值
    'partner'        => '2088801273866834',                   // 必填，合作商户号
    '_input_charset' => 'utf-8',                    // 必填，参数编码字符集
    'out_trade_no'   => "20150916170234",              // 必填，商户网站唯一订单号
    'subject'        => "23432423423432",                   // 必填，商品名称
    'payment_type'   => '1',                        // 必填，支付类型
    'seller_id'      => "mobile.securitypay.pay",                 // 必填，卖家支付宝账号
    'total_fee'      => "10.00",                     // 必填，总金额，取值范围为[0.01,100000000.00]
    'body'           => "423234234",                      // 必填，商品详情
    'it_b_pay'       => '1d',                       // 可选，未付款交易的超时时间
    'notify_url'     => $notify_url                // 可选，服务器异步通知页面路径
    //'show_url'       => "http%3A%2F%2Fdemo.dcloud.net.cn%2Fhelloh5%2Fpayment%2F"                  // 可选，商品展示网站
 );
$url = urlencode("http://hileyou.52xqb.com");
$parameter = 'service="mobile.securitypay.pay"&partner="2088711825914372"&_input_charset="utf-8"&out_trade_no="20150916170234"&subject="23432423423432"&payment_type="1"&seller_id="pay@itelland.com"&total_fee="10.00"&body="423234234"&it_b_pay="1d"&notify_url="'.$url.'"&sign="fOREYa3QvluKAtW4lLl6Kf8zNl6NhvKLV7BlX0UdCGd6rwaoOJDFWB5qYe2QD%2FoRFhGSK53GQrdZIzw2QiLNNXeQPMyPbdUigHoQuZ4tXTshVEcv%2B5xq2RGELAVlFMMiP6ba7cb%2BWK5ydzzGtquJ2%2B%2BT5Cha1F9jNIi67oWiaow%3D"&sign_type="RSA"';
echo $parameter;
exit;
// $parameter = paraFilter($parameter);
// $parameter = argSort($parameter);
$parameter = createLinkstring($parameter);
$sign = rsaSign($parameter);
// var_dump($sign);
// echo $order_number = $parameter.'&sign="'.$sign.'"&sign_type="RSA"';
// exit;
//生成需要签名的订单
$orderInfo = createLinkstringUrlencode($parameter);
//签名
$sign = rsaSign($parameter);//'k4vsOKlD%2Bz9tz%2BfqLrEroTvGrM%2F0EAtAjvJIwyLPqNwK%2FVzbwSE4BGCOPUZJ1lvG9XfNJQEoGz1XHYt7QZ%2BHTNus60U4lpgnBxBpQAQmVOb9PqQrWfrKoDlf1eMArGQxQVMkRRfbMs3kBQpGn13nI0GVO1fFceTpYGn4V5RHNfk%3D';//rsaSign($orderInfo);

//生成订单
// echo $order_number = $orderInfo.'&sign="'.$sign.'"&sign_type="RSA"';
//echo $order_number = 'service="mobile.securitypay.pay"&partner="2088801273866834"&_input_charset="UTF-8"&out_trade_no="20150916170234"&subject="DCloud项目捐赠"&payment_type="1"&seller_id="payservice@dcloud.io"&total_fee="10"&body="DCloud致力于打造HTML5最好的移动开发工具，包括终端的Runtime、云端的服务和IDE，同时提供各项配套的开发者服务。"&it_b_pay="1d"&notify_url="http%3A%2F%2Fdemo.dcloud.net.cn%2Fhelloh5%2Fpayment%2Fnotify.php"&show_url="http%3A%2F%2Fdemo.dcloud.net.cn%2Fhelloh5%2Fpayment%2F"&sign="k4vsOKlD%2Bz9tz%2BfqLrEroTvGrM%2F0EAtAjvJIwyLPqNwK%2FVzbwSE4BGCOPUZJ1lvG9XfNJQEoGz1XHYt7QZ%2BHTNus60U4lpgnBxBpQAQmVOb9PqQrWfrKoDlf1eMArGQxQVMkRRfbMs3kBQpGn13nI0GVO1fFceTpYGn4V5RHNfk%3D"&sign_type="RSA"';
//exit;
$parameter = '{
"sign":"fOREYa3QvluKAtW4lLl6Kf8zNl6NhvKLV7BlX0UdCGd6rwaoOJDFWB5qYe2QD%2FoRFhGSK53GQrdZIzw2QiLNNXeQPMyPbdUigHoQuZ4tXTshVEcv%2B5xq2RGELAVlFMMiP6ba7cb%2BWK5ydzzGtquJ2%2B%2BT5Cha1F9jNIi67oWiaow%3D",
"body":"423234234",
"_input_charset":"utf-8",
"it_b_pay":"1d",
"total_fee":"10.00",
"subject":"23432423423432",
"sign_type":"RSA",
"service":"mobile.securitypay.pay",
"notify_url":"http://hileyou.52xqb.com",
"seller_id":"pay@itelland.com",
"partner":"2088711825914372",
"out_trade_no":"20150916170234",
"payment_type":"1"
}
';
$parameter = json_decode($parameter,true);
$parameter = argSort($parameter);
$order_number = createLinkstring($parameter);
echo $order_number;
exit;
    }

}