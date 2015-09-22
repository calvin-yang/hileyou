<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi as UserApi;

/**
 * 后台首页控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
class IndexController extends AdminController {

    static protected $allow = array( 'verify');

    /**
     * 后台首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
        if(UID){
            #注册用户
            $member_number = M('member')->alias('a')->where('b.status not in (-1,2)')->join(C('DB_PREFIX').'ucenter_member b on a.uid = b.id')->count();
            #VIP用户
            $vip_member_number = M('member_vip')->where('status <> 2')->count();
            #服务商用户
            $facilitator_number = M('facilitator_data')->where('status <> 2')->count();
            #平台金额
            $financial_price = M('financial')->getField('sum(price)');
            #订单数
            $order_number = M('order')->where('status not in (2,3)')->count();
            $data['member_number'] = $member_number;
            $data['vip_member_number'] = $vip_member_number;
            $data['facilitator_number'] = $facilitator_number;
            $data['financial_price'] = $financial_price;
            $data['order_number'] = $order_number;

            $this->assign('data',$data);
			$this->display();
        } else {
            $this->redirect('Public/login');
        }
    }

}
