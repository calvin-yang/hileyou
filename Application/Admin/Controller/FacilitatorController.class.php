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
 * 服务商管理
 * @author calvin <977639814@qq.com>
 */
use Admin\Model\FacilitatorDataModel;

use Common\Model\Api\SendEailApi;
//加载上传类  
 use ORG\Util;

 use ORG\Net;


class FacilitatorController extends AdminController {
	public function index(){
        /**********************
        //以下三条读取配置文件中的内容即可
        $http = C('SMS_URL');
        $uid = 'y60445';//C('message.uid');
        $pwd = 'y60445';//C('message.pwd');
        //要接受信息的手机号码，多个以英文逗号隔开，这里只是一个用于测试的手机号，按找个项目需求操作即可
        $mobile  = '182156';
        //消息编号，该参数用于发送短信收取状态报告用，格式为消息编号+逗号；与接收号码一一对应，可以重复出现多次。
        //这里只用一个编号即可，手机号加上微秒，应该是唯一的了吧。
        $mobileids   = intval('182156').microtime();
        //要发送的内容
        $content = urlencode('我是樱桃小丸子，感觉自己萌萌哒');
        //即时发送，即：操作后就会进行发送，以下有定时发送
        //调用封装好的短信接口类。
        $send = new Net\Send;
        $res = $send->sendSMS($http,$uid,$pwd,$mobile,$content,$mobileids);
        dump($res);
        //以下为测试是否发送成功！
        if (substr($res,9,11) == 100) {
            //如果成功就，这里只是测试样式，可根据自己的需求进行调节
            echo "<script>alert('获取购物券密码成功，请注意查收短信');</script>";
        }else{
            //如果不成功
            echo "<script>alert('未知错误，请联系客服');</script>";
        }

        exit;
        ********************************/

        $model = M('facilitator_data');
        $map['a.status'] = array('neq',2);
        if(I('get.nickname')){
            if(is_numeric(I('get.nickname')))
                $map['b.mobile'] = array('like','%'.I('get.nickname').'%');
            else
                $map['a.realname'] = array('like','%'.I('get.nickname').'%');
        }
        
        $list = $model->field('a.*,b.mobile')->alias('a')->join(C('DB_PREFIX').'ucenter_member b on a.uid = b.id')->where($map)->select();
        int_to_string($list,$map=array('status'=>array(1=>'启用',2=>'删除',0=>'禁用',3=>'待审核',4=>'不通过'))); 

        $this->assign('_list',$list); 
		$this->display();
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
                    $title = '海乐游！服务商审核通知';
                    if(strstr($data['uid'], ',') === false){
                        $map['id'] = array('eq',$data['uid']);
                        $receiver_mail = M('ucenter_member')->where('id = '.$data['uid'])->getField('email');
                        if(!$receiver_mail)
                            $this->error('该服务商暂无填写邮箱.');

                        $content = $data['message_text'];
                        $mail->SendMail($receiver_mail,$title,$content);
                    }else{
                        $map['id'] = array('in',$data['uid']);
                        $receiver_mail = M('ucenter_member')->field('email')->where($map)->select();

                        
                        $content = $data['message_text'];
                        #检测要发送的用户是否含有邮箱
                        foreach ($receiver_mail as $key => $vo) {
                            if(empty($vo['email']))
                                $this->error('您要发送的服务商当中含有：含有没有填写邮箱的用户.');
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
	/**
	 * 添加服务商
	 * @author calvin <977639814@qq.com>
	 */
	public function add(){
        if(IS_POST){
            $model = new FacilitatorDataModel();
            $data = I('post.');
            $data['type'] = '2';
            $IDcard = I('post.id_card_positive').','.I('post.id_card_opposite');
            $data['IDcard_url'] = $IDcard; 
            $result = $model->add($data);
            if($result > 0){
                M('member')->save(array("uid" => $data['uid'],"type" => "2","realname"=>$data['realname'],"nickname" => $data['realname']));
                $this->success('更新成功',U('index'));
            }else{
                $this->error($result);
            }
        }
		$this->meta_title = '新增服务商用户';
        $MemberModel = M('ucenter_member');
        // 用户列表
        $memberList= $MemberModel->cache(true,30,'xcache')->field('id,mobile')->where('status <> 0 and status <>2')->select();

        $this->assign('memberList',$memberList);
		$this->display();
	}
    /**
     * 编辑服务商
     * @author calvin <977639814@qq.com>
     */
    public function edit(){
        if(IS_POST){
            $model = new FacilitatorDataModel();
            $data = I('post.');
            $IDcard = I('post.id_card_positive').','.I('post.id_card_opposite');
            $data['IDcard_url'] = $IDcard; 
            $result = $model->edit($data);
            if($result > 0){
                $this->success('更新成功',U('index'));
            }else{
                $this->error($result);
            }
        }
        if(IS_GET){
            $id = I('get.id');
            $model = M('FacilitatorData');
            $MemberModel = M('ucenter_member');
            $info = $model->where('id = '.$id)->find();
            // 用户列表
            $memberList= $MemberModel->cache(true,30,'xcache')->where('status <> 0')->select();
            if(!empty($info['IDcard_url'])){
                $IDcard_img = str2arr($info['IDcard_url']);
                $info['id_card_positive'] = $IDcard_img['0'];
                $info['id_card_opposite'] = $IDcard_img['1'];
            }
            $this->meta_title = '编辑服务商用户';
            $this->assign('info',$info);
            $this->assign('memberList',$memberList);
            $this->display();

        }
    }
    // 获取用户信息
    public function memberInfo(){
        if(IS_POST and I('post.uid')){
            $info = M('member')->field('realname,IDcard')->where('uid = '.I('post.uid'))->find();

        }
        $this->ajaxReturn(array('info' => $info, 'status' => true));
    }
    /**
     * 服务商状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $this->forbid('FacilitatorData', array('id'=>array('in',$id)) );
                break;
            case 'resumeuser':
                $this->resume('FacilitatorData', array('id'=>array('in',$id)) );
                break;
            case 'deleteuser':
                $this->delete('FacilitatorData', array('id'=>array('in',$id)) );
                break;

            case 'falsestatus':
                $this->falsestatus('FacilitatorData', array('id'=>array('in',$id)) );
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
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
        $uid = M('FacilitatorData')->field('uid')->where($map)->select();
        $uid_str = "";
        if(M('FacilitatorData')->where($map)->delete()){
            foreach ($uid as $value) {
                $uid_str .= ($value['uid'].",");
            }
            M('member')->where(array('uid'=>array('in',$uid_str)))->save(array("type" => 1));
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
	/**
	 * 图片上传
	 * @author calvin <977639814@qq.com>
	 */

    Public function imgUplode() {
        $upload = new Util\ImgUpload();
        $upload->annexFolder = "./Uploads/Facilitator";//$annexFolder;   //附件存放路径
        $upload->upFileType = C('IMG_PIC_SUFFIX');
        $upload->smallFolder =  "./Uploads/Facilitator/smallimg";//$smallFolder;   //缩略图存放路径
        $upload->markFolder = "./Uploads/Facilitator/mark";//$markFolder;     //水印图片存放处
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

}