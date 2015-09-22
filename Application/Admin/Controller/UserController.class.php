<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use User\Api\UserApi;
use ORG\Util;
use Common\Model\Api\SendEailApi;
use ORG\Net;
/**
 * 后台用户控制器
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */

class UserController extends AdminController {

    static protected $allow = array( 'updatePassword','updateNickname','submitPassword','submitNickname');

    /**
     * 用户管理首页
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public function index(){
    	$mobile = I('mobile');
        $model = M('member');
    	if(isset($mobile)){
    		$map['b.mobile']  = array('like', '%'.(string)$mobile.'%');
    	}
        $map['b.status'] = array('neq',2);
        $map['a.uid'] = array('neq',1);
        $list = $model->field('a.*,b.mobile,b.status')->alias('a')->join(C('DB_PREFIX').'ucenter_member b on a.uid = b.id')->where($map)->select();
        //echo $model->getLastSql();exit;
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户列表';
        $this->display();
    }

    /**
     * 修改昵称初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updateNickname(){
        $nickname = M('Member')->getFieldByUid(UID, 'nickname');
        $this->assign('nickname', $nickname);
        $this->meta_title = '修改昵称';
        $this->display();
    }

    /**
     * 修改昵称提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitNickname(){
        //获取参数
        $uid = UID;
        $nickname = I('post.nickname');
        $password = I('post.password');
        empty($nickname) && $this->error('请输入昵称');
        empty($password) && $this->error('请输入密码');

        //密码验证
        $User = new UserApi();
        $uid = $User->login($uid, $password, 4);
        ($uid == -2) && $this->error('密码不正确');

        $Member = D('Member');
        $data = $Member->create(array('nickname'=>$nickname));
        if(!$data){
            $this->error($Member->getError());
        }

        $res = $Member->where(array('uid'=>$uid))->save($data);

        if($res){
        	$user = session('user_auth');
        	$user['username'] = $data['nickname'];
        	session('user_auth', $user);
        	session('user_auth_sign', data_auth_sign($user));
            $this->success('修改昵称成功！');
        }else{
            $this->error('修改昵称失败！');
        }
    }

    /**
     * 修改密码初始化
     * @author huajie <banhuajie@163.com>
     */
    public function updatePassword(){
    	$this->meta_title = '修改密码';
        $this->display();
    }

    /**
     * 修改密码提交
     * @author huajie <banhuajie@163.com>
     */
    public function submitPassword(){
        //获取参数
        $uid        =   UID;
        $password   =   I('post.old');
        empty($password) && $this->error('请输入原密码');
        $data['password'] = I('post.password');
        empty($data['password']) && $this->error('请输入新密码');
        $repassword = I('post.repassword');
        empty($repassword) && $this->error('请输入确认密码');

        if($data['password'] !== $repassword){
            $this->error('您输入的新密码与确认密码不一致');
        }

        $Api = new UserApi();
        $res = $Api->updateInfo($uid, $password, $data);
        if($res['status']){
            $this->success('修改密码成功！');
        }else{
            $this->error($res['info']);
        }
    }

    /**
     * 用户行为列表
     * @author huajie <banhuajie@163.com>
     */
    public function action(){
        //获取列表数据
        // $Action = M('Action')->where(array('status'=>array('neq',2)));
        // $list   = $this->lists($Action);
        $list   = M('action')->where('status <> 2')->select();
        int_to_string($list);
        $this->assign('_list', $list);
        $this->meta_title = '用户行为';
        $this->display();
    }

    /**
     * 新增行为
     * @author huajie <banhuajie@163.com>
     */
    public function addAction(){
        $this->meta_title = '新增行为';
        $this->display('editaction');
    }

    /**
     * 编辑行为
     * @author huajie <banhuajie@163.com>
     */
    public function editAction(){
        $id = I('get.id');
        empty($id) && $this->error('参数不能为空！');
        $data = M('Action')->field(true)->find($id);

        $this->assign($data);
        $this->meta_title = '编辑行为';
        $this->display();
    }

    /**
     * 更新行为
     * @author huajie <banhuajie@163.com>
     */
    public function saveAction(){
        $res = D('Action')->update();
        if(!$res){
            $this->error(D('Action')->getError());
        }else{
            if($res['id']){
                $this->success('更新行为成功！', U('action'));
            }else{
                $this->success('新增行为成功！', U('action'));
            }
        }
    }

    /**
     * 设置一条或者多条数据的状态
     * @author huajie <banhuajie@163.com>
     */
    public function setStatus(){
        /*参数过滤*/
        $ids = I('request.ids');
        $status = I('request.status');
        if(empty($ids) || !isset($status)){
            $this->error('请选择要操作的数据');
        }
        //删除缓存
        S('action_list', null);

        /*拼接参数并修改状态*/
        $Model = 'Action';
        $map = array();
        if(is_array($ids)){
            $map['id'] = array('in', implode(',', $ids));
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        dump($map);
        exit;
        switch ($status){
            case -1 : $this->delete($Model, $map, array('success'=>'删除成功','error'=>'删除失败'));break;
            case 0 : $this->forbid($Model, $map, array('success'=>'禁用成功','error'=>'禁用失败'));break;
            case 1 : $this->resume($Model, $map, array('success'=>'启用成功','error'=>'启用失败'));break;
            default : $this->error('参数错误');break;
        }
    }

    /**
     * 会员状态修改
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
                $this->forbid('ucenter_member', array('id'=>array('in',$id)) );
                break;
            case 'resumeuser':
                $this->resume('ucenter_member', array('id'=>array('in',$id)) );
                break;
            case 'deleteuser':
                $this->delete('ucenter_member', array('id'=>array('in',$id)) );
                break;
            default:
                $this->error('参数非法');
        }
    }

    public function add($mobile = '', $password = '', $repassword = '', $username = '',$email = '',$face_max_url='',$sex='',$realname='',$IDcard=''){
        if(IS_POST){
            /* 检测密码 */
            if($password != $repassword){
                $this->error('密码和重复密码不一致！');
            }

            /* 调用注册接口注册用户 */
            $User = new UserApi;
            $uid = $User->register($mobile, $password, $username, $email);
            if(0 < $uid){ //注册成功
                $user = array('uid' => $uid, 'nickname' => $username,'reg_time' => NOW_TIME, 'reg_ip' => get_client_ip(1), 'mobile' => $mobile,'face_max_url'=>$face_max_url,'sex'=>$sex,'realname'=>$realname,'IDcard'=>$IDcard,'status' => 1);
                if(!M('Member')->add($user)){
                    $this->error('用户添加失败！');
                } else {
                    $this->success('用户添加成功！',U('index'));
                }
            } else { //注册失败，显示错误信息
                $this->error($this->showRegError($uid));
            }
        } else {
            $this->display();
        }
    }
    
    Public function imgUplode() {
        $upload = new Util\ImgUpload();
        $upload->annexFolder = "./Uploads/user";//$annexFolder;   //附件存放路径
        $upload->smallFolder =  "./Uploads/user/smallimg";//$smallFolder;   //缩略图存放路径
        $upload->markFolder = "./Uploads/user/mark";//$markFolder;     //水印图片存放处
        
        $upload->upFileType = C('IMG_PIC_SUFFIX');
        $upload->upFileMax = C('IMG_MAX_SIZE') * 1024 * 1024;
        $upload->maxWidth = C('MAX_WIDTH');//$maxWidth;         //图片最大宽度 
        $upload->maxHeight = C('MAX_HEIGHT'); //$maxHeight;       //图片最大高度

        $result = $upload->upLoad("img");
        if($result['status'] == '1'){
            if(C('SWITCHIMG_SWITCH') == 1){
                
                $newSmallImg = $upload->smallImg($result['info'],C('MAX_WIDTH'),C('MAX_HEIGHT'));
            }
            if(C('SWITCH_MARK') == '1'){
                $upload->maxWidth = C('WATERMARK_WIDTH');
                $upload->maxHeight = C('WATERMARK_HEIGHT');//设置生成水印图像值 
                $text = array(C('WATERMARK'));
                $upload->toFile = true; 
                $newMark = $upload->waterMark($result['info'],$text);
            }
            $model = M('img');
            $data['url'] = $result['info'];
            $data['insert_time'] = time();
            $img_id = $model->add($data);
            $result['img_id'] = $img_id;
            $this->ajaxReturn(array('msg' => $result, 'status' => true));
        }else{
            $this->error($result['info']);
        }
    }
    
    /**
     * 图片删除
     * @author calvin <977639814@qq.com>
     */
    public function img_delete(){
    	$id = I('post.id');
        $img_url = I('post.img_url');
        $data['uid'] = $id;
    	$model = M('Member');
    	$face_max_url = $model->where('uid='.$id)->getField('face_max_url');
    	$data['face_max_url'] = str_replace($img_url.'|'," ",$face_max_url);
        $model->save($data);
        if(unlink($img_url)){
            echo $data['face_max_url'];
        }
        
    }
    
    /**
     * 注册用户编辑
     * @author calvin <977639814@qq.com>
     */
    public function edit(){
        if(IS_POST){
            /* 检测密码 */
            $uid = I('get.uid');
            $data = I('post.');
            if(I('post.password') != I('post.repassword')){
                $this->error('密码和重复密码不一致！');
                exit;
            }
            
            $model = M('ucenter_member');
            $map['username'] = array('eq',$data['username']);
            $map['mobile'] = array('eq',$data['mobile']);
            $map['email'] = array('eq',$data['email']);
            $map['_logic'] = 'or';
            $maps['_complex'] = $map;
            $maps['id'] = array('neq',$uid);
            $result = M("ucenter_member")->where($maps)->find();

            if($result){
                $this->error('用户名已存在/邮箱/手机号已被注册');
                exit;
            }
            /* 调用注册接口注册用户 */
            $User = new UserApi;
            $uid = $User->admin_edit(I('post.'),$uid);
            if(0 < $uid){
                $this->success('用户修改成功！');
            } else {
                //$this->error($this->showRegError($uid));
                $this->error('未修改任何信息');
            }
        }
        if(I('get.uid')){
            $Member = M('Member');
            $Ucenter_member = M('ucenter_member');
            $uid = I('get.uid');
            $data = $Ucenter_member->join('as a left join '.__MEMBER__.' as b on a.id = b.uid')->field('a.id,a.username,a.mobile,a.email,a.status,a.reg_time,a.reg_ip,b.qq,b.face_max_url,b.sex,b.realname,b.IDcard')->where('a.id = '.$uid)->find();
            $this->assign('info',$data);
            $this->display();
        }else{
            $this->error('非法操作');
        }
    }
    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = '用户名长度必须在16个字符以内！'; break;
            case -2:  $error = '用户名被禁止注册！'; break;
            case -3:  $error = '用户名被占用！'; break;
            case -4:  $error = '密码长度必须在6-30个字符之间！'; break;
            case -5:  $error = '邮箱格式不正确！'; break;
            case -6:  $error = '邮箱长度必须在1-32个字符之间！'; break;
            case -7:  $error = '邮箱被禁止注册！'; break;
            case -8:  $error = '邮箱被占用！'; break;
            case -9:  $error = '手机格式不正确！'; break;
            case -10: $error = '手机被禁止注册！'; break;
            case -11: $error = '手机号被占用！'; break;
            default:  $error = '未知错误';
        }
        return $error;
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
                    $title = '海乐游系统通知';
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
