<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Admin\Controller;
use ORG\Util;

class MessageController extends AdminController {

    public function index(){
        $model = M('message');
        $map = '';
        if(I('get.type'))
        	$map['b.type'] = array('eq',I('get.type'));
        if(I('get.title'))
        	$map['_string'] = 'c.mobile like "%'.I('get.title').'%" or d.nickname like "%'.I('get.title').'%"';

        $count=$model->field('a.id')->alias('a')->join('left join '.C('DB_PREFIX').'ucenter_member c on a.sender_id = c.id')->join('left join '.C('DB_PREFIX').'member d on a.sender_id = d.uid')->where($map)->count();
    	$page=new Util\Page($count,10);
    	$show=$page->show();
        $this->assign('_page',$show);
        $list = $model->field('a.id,a.sender_id,a.receiver_id,a.receiver_id receiver_mobile,a.receiver_id receiver_nickname,a.send_time,a.read_flag,b.message_title,b.type,b.message_text,c.mobile sender_mobile,d.nickname sender_nickname')->join(C('DB_PREFIX').'message_text b on a.message_text_id = b.id')->alias('a')->join('left join '.C('DB_PREFIX').'ucenter_member c on a.sender_id = c.id')->join('left join '.C('DB_PREFIX').'member d on a.sender_id = d.uid')->where($map)->order('a.send_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        
        getMb($list);

        $this->assign('_list',$list);
        $this->display();

    }
    /**
     * 发送系统站内信
     * @return [type] [description]
     */
    public function sendmsg(){
    	if(IS_POST){
    		$model = M('message_text');
    		$data = I('post.');
    		if(!$data['receiver_id'])
    			$this->error('请选择收件人');
    		if(!$data['message_title'] || !$data['message_text'])
    			$this->error('请填写信息标题与内容');
    		$data['sender_id'] = UID;
    		$data['type'] = 2;
    		$message_text_id = $model->add($data);

    		$receiver_id_arr = explode(',',$data['receiver_id']);
    		for($i=0;$i<count($receiver_id_arr); $i++){
    			$datas[$i]['sender_id'] = UID;
    			$datas[$i]['receiver_id'] = $receiver_id_arr[$i];
    			$datas[$i]['send_time'] = time();
    			$datas[$i]['message_text_id'] = $message_text_id;

    		}
    		$result = M('message')->addAll($datas);
    		if($result){
    			$this->success('信息发送成功',U('index'));
    		}else{
    			$this->error('信息发送失败');
    		}

    	}
    	$memberModel = M('ucenter_member');
    	$mblist = $memberModel->field('id,mobile')->where('status = 1')->select();

    	$this->assign('mblist',$mblist);
    	$this->display();
    }
    /**
     * 站内信假删除
     * @return [type] [description]
     */
    public function jidelete(){
    	$model = M('message');
    }
}