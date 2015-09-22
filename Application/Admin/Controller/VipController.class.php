<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: calvin <977639814@qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
/**
 * 后台用户控制器
 * @author calvin <977639814@qq.com>
 */
use Common\Model\Api\SendEailApi;
use ORG\Net;

class VipController extends AdminController {
	public function index(){

	}
	/**
     * vip 用户
     * @author calvin <977639814@qq.com>
     */
    public function user(){
        if(S('admin_user_list')){
            $list = S('admin_user_list');
        }else{
           $model = M('member_vip');
            $map['c.status'] = array('neq',2);
            if(I('get.mobile'))
                $map['a.mobile'] = I('get.mobile');
            $list = $model->field('a.mobile,b.name,c.*')->alias('c')->join(C('DB_PREFIX')."ucenter_member a on a.id = c.uid")->join(C('DB_PREFIX').'vip b on b.id = c.vip_id')->where($map)->select();
            //echo M('member_vip')->getLastSql();
            int_to_string($list); 
            // 缓存数据300秒
            S('admin_user_list',$list,10);
        }
        
        $this->assign('_list',$list);
    	$this->display();
    }
    /**
     * vip 新增用户
     * @author calvin <977639814@qq.com>
     */
    public function user_add(){
        if(IS_POST){
            $model = D("MemberVip");
            $data = array_filter(I('post.'));
            $data['start_date'] = strtotime(I('post.start_date'));
            $data['end_date'] = strtotime(I('post.end_date'));
            if($data['end_date'] < $data['start_date']){
                $this->error('vip结束时间不能小于开始时间');
                exit;
            }
            if($model->create()){
                $result = M('MemberVip')->add($data);

                if($result){
                    $user = array('uid' => I('post.uid'), 'vip_id' => $result);
                    M('Member')->save($user);
                    $this->success('添加成功',U('user'));
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($model->getError());
            }
            exit;
        }
        $this->meta_title = '新增VIP用户';
        $MemberModel = M('ucenter_member');
        $VIPModel = M('vip');
        // 用户列表
        $memberList = $MemberModel->where('status not in (0,2)')->select();
        // vip类型列表
        $VIPList = $VIPModel->where('status not in (0,2)')->select();
        $this->assign('memberList',$memberList);
        $this->assign('VIPList',$VIPList);
        $this->display();
    }
     /**
     * vip 用户
     * @author calvin <977639814@qq.com>
     */
    public function user_edit(){
        if(IS_POST){
            $model = D("MemberVip");
            $data = array_filter(I('post.'));
            $data['start_date'] = strtotime(I('post.start_date'));
            $data['end_date'] = strtotime(I('post.end_date'));
            if($data['end_date'] < $data['start_date']){
                $this->error('vip结束时间不能小于开始时间');
                exit;
            }
            if($model->create()){
                $result = M('MemberVip')->save($data);

                if($result){
                    $user = array('uid' => I('post.uid'), 'vip_id' => $result);
                    M('Member')->save($user);
                    $this->success('编辑成功',U('user'));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error($model->getError());
            }
            exit;
        }
        if(!I('get.id')){ 
            $this->error('非法操作',U('user'));
        }
        $id = I('get.id');
        $this->meta_title = '编辑VIP用户';
        $MemberModel = M('member');
        $VIPModel = M('vip');
        $MemberVip = M('MemberVip');
        
        // 用户数据
        $info = $MemberVip->where('id = '.$id)->find();
        // 用户列表
        $memberList = $MemberModel->where('uid = '.$info['uid'])->find();
        // vip类型列表
        $VIPList = $VIPModel->where('status not in (0,2)')->select();

        $this->assign('memberList',$memberList);
        $this->assign('VIPList',$VIPList);
        $this->assign('info',$info);
        $this->display();
    }
    /**
     * vip 类目
     * @author calvin <977639814@qq.com>
     */
    public function category(){
        $list = M('vip')->where('status not in (2)')->select();
        int_to_string($list);
        $this->assign('_list',$list);
    	$this->display();
    }

    /**
     * VIP状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $map['vip_id'] = array('in',$id);
                $user = get_table_fields('member_vip', 'id', $map, '1');
                if($user){
                    $this->error('含有该vip用户，请勿禁用');
                    unset($map);
                    
                }
                $this->forbid('vip', array('id'=>array('in',$id)) );
                break;
            case 'resumeuser':
                $this->resume('vip', array('id'=>array('in',$id)) );
                break;
            case 'deleteuser':
                $this->delete('vip', array('id'=>array('in',$id)) );
                break;
            default:
                $this->error('参数非法');
        }
    }
    /**
     * VIP类目删除
     * @author calvin <zhuyajie@topthink.net>
     */
    public function delete(){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['vip_id'] = array('in',$id);
        $user = M('MemberVip')->where($map)->find();
        if($user){
            $this->error('含有该vip用户，请勿删除');
            unset($map);
            
        }
        if(M('vip')->where($map)->delete()){

            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * VIP用户删除
     * @author calvin <zhuyajie@topthink.net>
     */
    public function user_delete(){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
        if(M('member_vip')->where($map)->delete()){
            $maps['vip_id'] = array('in',$id);
            $user = array('vip_id' => '0');
            M('Member')->where($maps)->save($user);
           
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * VIP用户状态修改
     * @author calvin <zhuyajie@topthink.net>
     */
    public function user_changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        if( in_array(C('USER_ADMINISTRATOR'), $id)){
            $this->error("不允许对超级管理员执行该操作!");
        }
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('member_vip', array('id'=>array('in',$id)) );
                break;
            case 'resumeuser':
                $this->resume('member_vip', array('id'=>array('in',$id)) );
                break;
            case 'deleteuser':
                $this->delete('member_vip', array('id'=>array('in',$id)) );
                break;
            default:
                $this->error('参数非法');
        }
    }
    /**
     * vip 添加类目
     * @author calvin <977639814@qq.com>
     */
    public function add(){
        if(IS_POST){
            $model = D('Vip');
            $data = array_filter(I('post.'));
            if($model->create()){
                $result = M('Vip')->add($data);
                if($result){
                    $this->success('添加成功',U('category'));
                }else{
                    $this->error('添加失败');
                }
            }else{
                $this->error($model->getError());
            }

        }else{
           $this->meta_title = '新增VIP类目';
            $this->display(); 
        }
        
    }
    /**
     * vip 编辑类目
     * @author calvin <977639814@qq.com>
     */
    public function edit(){
        if(IS_POST){
            $model = D('Vip');
            $data = array_filter(I('post.'));
            if($model->create()){
                $result = M('Vip')->save($data);
                if($result){
                    $this->success('编辑成功',U('category'));
                }else{
                    $this->error('编辑失败');
                }
            }else{
                $this->error($model->getError());
            }

        }else{

           $this->meta_title = '编辑VIP类目';
           if(!I('get.id')){ 
                $this->error('非法操作',U('user'));
            }
            $id = I('get.id');
            $info = M('vip')->where('id='.$id)->find();
            $this->assign('info',$info);
            $this->display(); 
        }
        
    }

    /**
     * 发送信息   短信、邮箱
     * @return [type] [description]
     */
    public function sendMessgae(){
        if(IS_POST){
            $model = M('message_text');
            if(!I('post.message_text'))
                $this->error('请填写发送内容');
            if(!I('post.uid'))
                $this->error('请选择要发送的用户');

            $data = I('post.');
            

            switch ($data['type']) {
                #短信
                case '1':
                    # code...
                    $this->error('暂未开通手机发送功能.');
                    break;
                
                #邮箱
                case '2':
                    $mail = new SendEailApi();
                    $title = '海乐游系统vip通知';
                    if(strstr($data['uid'], ',') === false){
                        $map['id'] = array('eq',$data['uid']);
                        $receiver_mail = M('ucenter_member')->where('id = '.$data['uid'])->getField('email');
                        if(!$receiver_mail)
                            $this->error('该用户暂无填写邮箱.');

                        
                        $content = $data['message_text'];
                        $mail->SendMail($receiver_mail,$title,$content);
                    }else{
                        $map['id'] = array('in',$data['uid']);
                        $receiver_mail = M('ucenter_member')->field('email')->where($map)->select();

                        $content = $data['message_text'];
                        #检测要发送的用户是否含有邮箱
                        foreach ($receiver_mail as $key => $vo) {
                            if(empty($vo['email']))
                                $this->error('您要发送的用户当中含有：含有没有填写邮箱的用户.');
                        }
                        
                        foreach ($receiver_mail as $key => $vo) {
                            $mail->SendMail($vo['email'],$title,$content);
                        }
                        


                    }
                    
                    
                    break;
                default:
                    # code...
                    break;
            }
            $data['sender_id'] = UID;
            $data['message_title'] = $title;
            $message_text_id = $model->add($data);

            if(strstr($data['uid'], ',') === false){
                $data['receiver_id'] = $data['uid'];
                $data['send_time'] = time();
                $data['message_text_id'] = $message_text_id;
                $result = M('message')->add($data);
            }else{
                $cou_id = explode(',', $data['uid']);
                for($i=0; $i<count($cou_id); $i++){
                    $datas[$i]['receiver_id'] = $cou_id[$i];
                    $datas[$i]['send_time'] = time();
                    $datas[$i]['message_text_id'] = $message_text_id;
                    $datas[$i]['sender_id'] = UID;

                }
                $result = M('message')->addAll($datas);
            }
            
            //echo $model->getLastSql();
            if($result){
                $this->success('发送成功');
            }


        }else{
            $this->error('非法操作');
        }
    }

}