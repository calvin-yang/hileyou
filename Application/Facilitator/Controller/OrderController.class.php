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
class OrderController extends FacilitatorController {
	public function index(){
		//$this->display();
	}
	
	public function ordlist(){
        $model = M('pro_order');
        $uid = UID;
        $map['b.status'] = array('not in','2,3,8,9');
        if(I('get.status') != "")
            $map['b.status'] = array('eq',I('get.status'));
        if(I('get.title'))
            $map['b.number'] = array('like','%'.I('get.title').'%');
        $map['a.fa_uid'] = array('eq',$uid);
        $count=$model->alias('a')->join('tv_order b on a.id=b.pro_order_id')->where($map)->count();
        $page=new Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
        $list = $model->field('a.id,a.number,a.pro_type,a.pro_id,a.unit_price,a.discount_price,a.total_price,a.insert_time,b.id order_id,b.number order_number,b.status,b.title')->alias('a')->join('tv_order b on a.id=b.pro_order_id')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        order_int_to_string($list);
        
        $this->assign('_list',$list);
        $this->display();
    }
    
    public function ord_detail(){
        $model = M('pro_order');
        $pro_order_id = I('get.pro_order_id');
        $uid = UID;
        $map['a.fa_uid'] = array('eq',$uid);
        $map['a.id'] = array('eq',$pro_order_id);
        #产品信息
        $info = $model->field('a.*,b.number order_number,b.title,b.pay_type,b.status')->alias('a')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->limit(1)->select();
        unset($map);
        if(!$info)
            $this->error('非法操作');
        order_int_to_string($info,$msg);
        $info = $info['0'];
        
        #产品联系人id、电话
        if($info['pro_type'] == 1){
            $proinfo = M('hel')->field('uid,hel_tel pro_tel')->where('id = '.$info['pro_id'])->find();
        }else if($info['pro_type'] == 2 || $info['pro_type'] == 5){
            $proinfo = M('restaurant')->field('uid,foot_tel pro_tel')->where('id = '.$info['pro_id'])->find();
        }else if($info['pro_type'] == 3){
            $proinfo = M('play')->field('uid,tel pro_tel')->where('id = '.$info['pro_id'])->find();
        }else if($info['pro_type'] == 4){
            $proinfo = M('route')->field('uid,tel pro_tel')->where('id = '.$info['pro_id'])->find();
        }
        #商家信息
        $map['a.uid'] = array('eq',$proinfo['uid']);
        $memberInfo = M('facilitator_data')->field('a.realname,a.IDcard,a.tel,b.mobile')->alias('a')->join(C('DB_PREFIX').'ucenter_member b on a.uid = b.id')->where($map)->find();
        $memberInfo['pro_tel'] = $proinfo['pro_tel'];

        #购买者信息
        $buyerInfo = M('ucenter_member')->field('a.mobile,b.IDcard')->alias('a')->join(C('DB_PREFIX').'member b on a.id = b.uid')->where('a.id ='.$info['uid'])->find();
        #检测用户类型
        unset($map);
        $map['a.uid'] = array('eq',$info['uid']);
        //$map['a.end_date'] = array('egt',time());
        $vipinfo = M('member_vip')->field('a.start_date,a.end_date,a.vip_id,b.name')->alias('a')->join(C('DB_PREFIX').'vip b on a.vip_id = b.id')->where($map)->find();

        if($vipinfo){
            $vip['msg'] = 'VIP';
            $vip['vip_name'] = $vipinfo['name'];
            if($vipinfo['end_date'] < time())
                $vip['status_msg'] = '已过期';
            else
                $vip['status_msg'] = '正常';
            $vip['start_date'] = time_format($vipinfo['start_date'],'Y-m-d');
            $vip['end_date'] = time_format($vipinfo['end_date'],'Y-m-d');
            $vip['status'] = true;

        }else{
            $vip['status'] = false;
        }
        $this->assign('info',$info);
        $this->assign('memberInfo',$memberInfo);
        $this->assign('buyerInfo',$buyerInfo);
        $this->assign('vip',$vip);
        $this->display();


  
    }
    /**
     * [finanordlist 提现订单列表]
     * @return [type] [description]
     */
    public function finanordlist(){
        $model = M('pro_order');
        $uid = UID;
        $map['b.status'] = array('in','8,9');
        $map['a.uid'] = $uid;
        if(I('get.status') != "")
            $map['b.status'] = array('eq',I('get.status'));
        if(I('get.title'))
            $map['b.number'] = array('like','%'.I('get.title').'%');
        
        $count=$model->alias('a')->join('tv_order b on a.id=b.pro_order_id')->where($map)->count();
        $page=new Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
        $list = $model->field('a.id,a.number,a.pro_type,a.pro_id,a.unit_price,a.discount_price,a.total_price,a.insert_time,b.id order_id,b.number order_number,b.status,b.title')->alias('a')->join('tv_order b on a.id=b.pro_order_id')->where($map)->limit($page->firstRow.','.$page->listRows)->select();
        
        order_int_to_string($list);
        
        $this->assign('_list',$list);
        $this->display();
    }
    /**
     * [finanord_detail 提现订单详情]
     * @return [type] [description]
     */
    public function finanord_detail(){
        if(!I('get.pro_order_id'))
            $this->error('非法操作');
        $pro_order_id = I('get.pro_order_id');
        $uid = UID;
        $model = M('pro_order');
        $map['b.status'] = array('in','8,9');
        $map['a.id'] = $pro_order_id;
        $map['a.uid'] = $uid;

        $infos = $model->alias('a')->field('a.discount_price,a.pro_type,b.number order_number,b.status,c.mobile,d.back_china,d.back_card,d.account_name,d.back_branch,d.type')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->join(C('DB_PREFIX').'ucenter_member c on a.uid = c.id')->join(C('DB_PREFIX').'back_infor d on a.pro_id = d.id')->where($map)->limit(1)->select();
        if(!$infos)
            $this->error('非法操作');
        order_int_to_string($infos);
        $info = $infos['0'];
        $this->assign('info',$info);
        $this->display();
    }
    
    /*
    
     public function ord_changeStatus($method=null){
        $model = M('order');
        $ids = array_unique((array)I('id',0));
        $id = is_array($ids) ? implode(',',$ids) : $ids;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'finish':
                $map['id'] = array('in',$id);
                $map['status'] = array('eq',1);
                $data['status'] = 4;
                $list = $model->where($map)->select();
                if(count($list) != count($ids))
                    $this->error('您只能选择已支付的订单进行操作');

                $result = $model->where($map)->save($data);
                if($result){
                    unset($map);unset($data);
                    for ($i=0; $i < count($ids); $i++) { 
                        $map['b.id'] = array('eq',$ids[$i]);
                        #订单信息
                        $order_info = M('pro_order')->field('a.pro_id,a.pro_type,a.discount_price,a.voucher_number,a.voucher_price')->alias('a')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->find();
                        #获取商家id
                        
                        if($order_info['pro_type'] == 1){
                            $uid = M('hel')->where('id = '.$order_info['pro_id'])->getField('uid');
                        }elseif($order_info['pro_type'] == 2 || $order_info['pro_type'] == 5){
                            $uid = M('restaurant')->where('id = '.$order_info['pro_id'])->getField('uid');

                        }elseif($order_info['pro_type'] == 3){
                            $uid = M('play')->where('id = '.$order_info['pro_id'])->getField('uid');
                        }elseif($order_info['pro_type'] == 4){
                            $uid = M('route')->where('id = '.$order_info['pro_id'])->getField('uid');
                        }else{
                            $this->error('非法操作');
                        }

                        if(empty($order_info['voucher_number'])){
                            $price = $order_info['discount_price'];
                        }else{
                            $price = $order_info['discount_price'] + $order_info['voucher_price'] * $order_info['voucher_number'];
                        }
                        $f_price = M('financial')->where('uid = '.$uid)->getField('price');

                        if($f_price){
                            $datas['price'] = $f_price + $price;
                            M('financial')->where('uid = '.$uid)->save($datas);
                        }else{
                            $datas['price'] = $price;
                            $datas['uid'] = $uid;
                            M('financial')->add($datas);
                        }
                    }
                }
                // $this->forbid('order', array('id'=>array('in',$id)) );
                break;
            case 'refund':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','1,5');
                $data['status'] = 6;
                $list = $model->where($map)->select();
                if(count($list) != count($ids))
                    $this->error('您只能选择(已支付/退费中)的订单进行操作');
                $result = $model->where($map)->save($data);
                if($result){
                    unset($map);unset($data);
                    for ($i=0; $i < count($ids); $i++) { 
                        # code...
                        $map['b.id'] = array('eq',$ids[$i]);
                        #订单信息
                        $order_info = M('pro_order')->field('a.uid,a.discount_price,a.voucher_number,a.voucher_price')->alias('a')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->find();

                        $data[$i]['insert_time'] = time();
                        $data[$i]['fish_time'] = time();
                        $data[$i]['reason'] = '系统强制退款给消费者';
                        $data[$i]['order_id'] = $ids[$i];
                        $data[$i]['uid'] = $order_info['uid'];

                        if(empty($order_info['voucher_number'])){
                            $price = $order_info['discount_price'];
                        }else{
                            $price = $order_info['discount_price'] + $order_info['voucher_price'] * $order_info['voucher_number'];
                        }
                        $f_price = M('financial')->where('uid = '.$order_info['uid'])->getField('price');

                        if($f_price){
                            $datas['price'] = $f_price + $price;
                            M('financial')->where('uid = '.$order_info['uid'])->save($datas);
                        }else{
                            $datas['price'] = $price;
                            $datas['uid'] = $order_info['uid'];
                            M('financial')->add($datas);
                        }
                    }
                    M('order_refund')->addAll($data);
                }
                    

                    
                //$this->resume('order', array('id'=>array('in',$id)) );
                break;
            case 'deleteuser':
                $map['id'] = array('in',$id);
                //$map['status'] = array('in','1,5');
                $data['status'] = 3;
                $result = $model->where($map)->save($data);
                //$this->delete('order', array('id'=>array('in',$id)) );
                break;
            case 'fsrefund':
                $map['b.id'] = array('in',$id);
                $map['b.status'] = array('in','5');
                $data['status'] = 1;
                $list = $model->alias('b')->where($map)->select();
                if(count($list) != count($ids))
                    $this->error('您只能选择(退费中)的订单进行操作');
                #订单信息
                $order_info = M('pro_order')->field('a.uid')->alias('a')->join(C('DB_PREFIX').'order b on a.id = b.pro_order_id')->where($map)->select();
                $uid = '';
                foreach ($order_info as $value) {
                    # code...
                    $uid .= $value['uid'].',';
                }
                #删除指定退款数据
                $maps['order_id'] = array('in',$id);
                $maps['uid'] = array('in',$uid);
                $de_or_re = M('order_refund')->where($maps)->delete();
                if($de_or_re){
                    $result = $model->where($map)->save($data);
                }else{
                    $result = false;
                }
                
                break;
            default:
                $this->error('参数非法');
        }
        if($result)
            $this->success('订单操作成功');
        else
            $this->error('订单操作失败');
    }
    */
    /**
     * [financial 财务统计]
     * @return [type] [description]
     */
    /*
    public function financial(){
        $model = M('financial');
        $list = $model->alias('a')->field('a.price,a.uid,b.mobile,b.email,c.nickname,c.realname')->join(C('DB_PREFIX').'ucenter_member b on a.uid = b.id')->join(C('DB_PREFIX').'member c on a.uid = c.uid')->select();
        #平台总金额
        $price_num = $model->getField('sum(price)');
        $this->assign('price_num',$price_num);
        $this->assign('_list',$list);
        $this->display();
    }
    */
}