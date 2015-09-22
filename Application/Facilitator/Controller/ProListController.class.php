<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace Facilitator\Controller;
/**
 * 产品控制器 Product
 * 用于产品的管理
 */
//加载上传类
 use ORG\Util;
 use Common\Model\HelModel;
 use Common\Model\RouteModel;
 use Common\Model\RestaurantModel;
 use Common\Model\PlayModel;

class ProListController extends FacilitatorController {

    public function index(){
        $this->display();
    }
    
    /**
     * 房源列表
     * @author calvin <banhuajie@163.com>
     */
    public function rmlist(){
        $model = M("hel");
        $uid = UID;
        $map['a.status'] = array('neq',2);
        $map['a.uid'] = array('eq',$uid);
        if(I('get.status') != "")
            $map['a.status'] = array('eq',I('get.status'));
        if(I('get.title'))
            $map['a.hel_name'] = array('like','%'.I('get.title').'%');
        $count=$model->alias('a')->join(C('DB_PREFIX').'member b on a.uid = b.uid')->where($map)->count();
        $page=new Util\Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
        $list=$model->field('a.*,b.realname,b.nickname')->alias('a')->join(C('DB_PREFIX').'member b on a.uid = b.uid')->where($map)->order('a.sort,a.insert_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $msg=array('status'=>array('0'=>'下架','1'=>'上架','2'=>'删除','3'=>'待通过','4'=>'不通过'));
        int_to_string($list,$msg);

        $this->assign('_list',$list);
        $this->display('rmlist');
    }
    
    public function rmadd(){
        if(IS_POST){
            $user = session('user_auth');
            $uid = $user['uid'];
            $model = new HelModel();
            $data = I('post.');
            $data['uid'] = $uid;
            $data['insert_time'] = time();
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            $result = $model->fr_add($data);
            if($result == '1'){
                $this->success('数据添加成功,请等待审核',U('rmlist'));
            }else if($result == '0'){
                $this->error('数据添加失败');
            }else{
                $this->error($result);
            }
            
        }
        $model = M('LvType');
        $vipmodel = M('vip');
        // 床型列表
        $bed_list = $model->where('facilities_type = 1 and type = 3')->field('id,name')->find();
        $str2arr = str2arr($bed_list['name']);
        $bed_list['name'] = $str2arr;
        //设备列表
        $facilities_list = $model->where('facilities_type = 1 and type = 2')->field('id,name')->find();
        $str2arr = str2arr($facilities_list['name']);
        $facilities_list['name'] = $str2arr;
        //房源类型列表
        $room_type_list = $model->where('facilities_type = 1 and type = 1')->field('id,name')->find();
        $str2arr = str2arr($room_type_list['name']);
        $room_type_list['name'] = $str2arr;
        unset($str2arr);
        //VIP类型
        $vip_list = $vipmodel->where('status <> 0')->select();

        $this->assign('bed_list',$bed_list);
        $this->assign('facilities_list',$facilities_list);
        $this->assign('room_type_list',$room_type_list);
        $this->assign('vip_list',$vip_list);
        unset($bed_list,$facilities_list,$room_type_list,$vip_list);
        $this->display();
    }
    
    /**
     * 房源信息编辑
     * @author calvin <977639814@qq.net>
     */
    public function rmedit(){
        if(IS_POST){
            $model = new HelModel();
            $data = I('post.');
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            $result = $model->fr_edit($data);
            if($result == '1'){
                $this->success('数据编辑成功',U('rmlist'));
            }else{
                $this->error($result);
            }
            
        }
        $model = M('LvType');
        $vipmodel = M('vip');
        $rmModel = M('hel');
        $uid = UID;
        // 床型列表
        $bed_list = $model->where('facilities_type = 1 and type = 3')->field('id,name')->find();
        $str2arr = str2arr($bed_list['name']);
        $bed_list['name'] = $str2arr;
        //设备列表
        $facilities_list = $model->where('facilities_type = 1 and type = 2')->field('id,name')->find();
        $str2arr = str2arr($facilities_list['name']);
        $facilities_list['name'] = $str2arr;
        //房源类型列表
        $room_type_list = $model->where('facilities_type = 1 and type = 1')->field('id,name')->find();
        $str2arr = str2arr($room_type_list['name']);
        $room_type_list['name'] = $str2arr;
        unset($str2arr);
        //VIP类型
        $vip_list = $vipmodel->where('status <> 0')->select();

        //房源信息
        $info = $rmModel->where('id='.I('get.id').' and uid = '.$uid)->find();

        $this->assign('info',$info);
        $this->assign('bed_list',$bed_list);
        $this->assign('facilities_list',$facilities_list);
        $this->assign('room_type_list',$room_type_list);
        $this->assign('vip_list',$vip_list);
        unset($bed_list,$facilities_list,$room_type_list,$vip_list);
        $this->display();
    }
    /**
     * 游玩信息编辑
     * @author calvin <977639814@qq.net>
     */
    public function pylist(){
        $model = M("play");
        $uid = UID;
        $map['b.status'] = array('neq',2);
        $map['b.uid'] = array('eq',$uid);
        if(I('get.status') != "")
            $map['b.status'] = array('eq',I('get.status'));
        if(I('get.title'))
            $map['b.title'] = array('like','%'.I('get.title').'%');
        $count=$model->alias('b')->join(C('DB_PREFIX').'member a on b.uid = a.uid')->where($map)->count();
        $page=new Util\Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
        $list=$model->field('b.logo_img_url,b.title,b.favorable_price,b.id,b.tel,b.contact,b.sort,b.price,b.status,a.realname,a.nickname')->alias('b')->join(C('DB_PREFIX').'member a on a.uid = b.uid')->where($map)->order('b.sort,b.insert_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $msg=array('status'=>array('0'=>'已下架','1'=>'已上架','2'=>'删除','3'=>'待通过','4'=>'不通过'));
        int_to_string($list,$msg);

        $this->assign('_list',$list);
        $this->display();
    }
    /**
     * 景点信息添加
     * @author  calvin <[<email address>]>
     */
    public function pyadd(){
        if(IS_POST){
            $model = new PlayModel();
            $data = I('post.');
            $result = $model->fr_add($data);
            if($result == '1'){
                $this->success('数据添加成功',U('pylist'));
            }else{
                $this->error($result);
            }
        }
        $model = M('LvType');
        $vipmodel = M('vip');
        //景点类型
        $type_list = $model->where('facilities_type = 3 and type = 0 and status = 1')->field('id,name')->find();
        $str2arr = str2arr($type_list['name']);
        $type_list['name'] = $str2arr;
        //VIP类型
        $vip_list = $vipmodel->where('status <> 0')->select();

        $this->assign('provinces_list',$provinces_list);
        $this->assign('type_list',$type_list);
        $this->assign('vip_list',$vip_list);
        $this->display();
    }
    /**
     * 景点信息编辑
     * @author  calvin <[<email address>]>
     */
    public function pyedit(){
        $uid = UID;
        if(IS_POST){
            $model = new PlayModel();
            $data = I('post.');
            $result = $model->fr_edit($data);
            if($result == '1'){
                $this->success('数据编辑成功',U('pylist'));
            }else{
                $this->error($result);
            }
        }
        $model = M('play');
        $LvTypeList = M('LvType');
        $info = $model->where('id = '.I('get.id').' and uid = '.$uid)->find();
        $region = str2arr($info['region']);

        //景点类型
        $type_list = $LvTypeList->where('facilities_type = 3 and type = 0 and status = 1')->field('id,name')->find();
        $str2arr = str2arr($type_list['name']);
        $type_list['name'] = $str2arr;

        $this->assign('region',$region); //省市区
        $this->assign('type_list',$type_list); //景点类型
        $this->assign('info',$info);
        $this->display();

    }
    /**
     * 景点状态修改
     * @author 朱亚杰 <zhuyajie@topthink.net>
     */
    public function py_changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        $uid = UID;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('play')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->forbid('play', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'resumeuser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('play')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->resume('play', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'deleteuser':
                $this->delete('play', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'falsestatus':
                $this->falsestatus('play', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            default:
                $this->error('参数非法');
        }
    }
    /**
     * 房源状态修改
     * @author calvin <977639814@qq.net>
     */
    public function rm_changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        $uid =UID;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('hel')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->forbid('hel', array('id'=>array('in',$id),'uid'=>array('eq',$uid)) );
                break;
            case 'resumeuser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('hel')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->resume('hel', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'deleteuser':
                $this->delete('hel', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'falsestatus':
                $this->falsestatus('hel', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            default:
                $this->error('参数非法');
        }
    }
    /**
     * 餐饮数据删除
     * @author calvin <zhuyajie@topthink.net>
     */
    public function eat_delete(){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
        if(M('Restaurant')->where($map)->delete()){

            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 房源数据删除
     * @author calvin <zhuyajie@topthink.net>
     */
    public function rm_delete(){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
        if(M('hel')->where($map)->delete()){

            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 景点数据删除
     * @author calvin <zhuyajie@topthink.net>
     */
    public function py_delete(){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
        if(M('play')->where($map)->delete()){

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
        if(I('get.type') == 'play'){
            $upload->annexFolder = "./Uploads/play";//$annexFolder;   //附件存放路径
            $upload->smallFolder =  "./Uploads/play/smallimg";//$smallFolder;   //缩略图存放路径
            $upload->markFolder = "./Uploads/play/mark";//$markFolder;     //水印图片存放处
        }elseif (I('get.type') == 'eat'){
            $upload->annexFolder = "./Uploads/eat";//$annexFolder;   //附件存放路径
            $upload->smallFolder =  "./Uploads/eat/smallimg";//$smallFolder;   //缩略图存放路径
            $upload->markFolder = "./Uploads/eat/mark";//$markFolder;     //水印图片存放处
        }elseif (I('get.type') == 'route'){
            $upload->annexFolder = "./Uploads/route";//$annexFolder;   //附件存放路径
            $upload->smallFolder =  "./Uploads/route/smallimg";//$smallFolder;   //缩略图存放路径
            $upload->markFolder = "./Uploads/route/mark";//$markFolder;     //水印图片存放处
        }else{
            $upload->annexFolder = "./Uploads/Room";//$annexFolder;   //附件存放路径
            $upload->smallFolder =  "./Uploads/Room/smallimg";//$smallFolder;   //缩略图存放路径
            $upload->markFolder = "./Uploads/Room/mark";//$markFolder;     //水印图片存放处
        }
        
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
     * 餐饮遍历
     *
     */
    public function eatlist(){
    	$model = M('Restaurant');
        $uid = UID;
        $map['a.status'] = array('neq',2);
        $map['a.uid'] = array('eq',$uid);
        if(I('get.status') != "")
            $map['a.status'] = array('eq',I('get.status'));
        if(I('get.title'))
            $map['a.foot_name'] = array('like','%'.I('get.title').'%');
    	$count=$model->alias('a')->join('tv_member b on a.uid=b.uid')->where($map)->count();
    	$page=new Util\Page($count,10);
    	$show=$page->show();
        $this->assign('_page',$show);
    	$list=$model->field('a.*,b.realname,b.nickname')->alias('a')->join('tv_member b on a.uid=b.uid')->where($map)->order('a.sort,a.insert_time desc')->limit($page->firstRow.','.$page->listRows)->select();
    	$msg=array('status'=>array('0'=>'已下架','1'=>'已上架','2'=>'删除','3'=>'待通过','4'=>'不通过'));
        int_to_string($list,$msg);
        $this->assign('_list',$list);
        $this->display();
    }
    
    /**
     * 餐饮添加
     *
     */
    public function eatadd(){
    	if(IS_POST){
            $user = session('user_auth');
            $uid = $user['uid'];
            $model = new RestaurantModel();
            $data = I('post.');
            $data['uid'] = $uid;
            $data['effective_time'] = strtotime($data['effective_time']);
            $data['insert_time']=time();
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['business_hours']=$data['business_hours1'].'-'.$data['business_hours2'];
            $data['vip_price'] = $str;
            $result = $model->fr_add($data);
            if($result == '1'){
                $this->success('数据添加成功,请等待审核。',U('eatlist'));
            }else if($result == '0'){
                $this->error('数据添加失败');
            }else{
                $this->error($result);
            }
        }
        
        $model = M('LvType');
        $vipmodel = M('vip');
        //餐饮类型列表
        $eat_type_list = $model->where('facilities_type = 2')->field('id,name')->find();
        $str2arr = str2arr($eat_type_list['name']);
        $eat_type_list['name'] = $str2arr;
        unset($str2arr);
        //VIP类型
        $vip_list = $vipmodel->where('status <> 0')->select();
        
        $this->assign('eat_type_list',$eat_type_list);
        $this->assign('vip_list',$vip_list);
        unset($eat_type_list,$vip_list);
    	$this->display();
    }
    /**
     * 餐饮修改
     */
    public function eatedit(){
        $uid = UID;
    	if(IS_POST){
            $user = session('user_auth');
            $uid = $user['uid'];
            $model = new RestaurantModel();
            $data = I('post.');
            $data['effective_time'] = strtotime($data['effective_time']);
            $data['uid'] = $uid;
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            $data['business_hours']=$data['business_hours1'].'-'.$data['business_hours2'];
            $result = $model->fr_edit($data);
            if($result == '1'){
                $this->success('数据编辑成功',U('eatlist'));
            }else{
                $this->error($result);
            }
        }
    	$model = M('LvType');
        $vipmodel = M('vip');
        $eatmodel=M('Restaurant');
        //餐饮类型列表
        $eat_type_list = $model->where('facilities_type = 2')->field('id,name')->find();
        $str2arr = str2arr($eat_type_list['name']);
        $eat_type_list['name'] = $str2arr;
        unset($str2arr);
        //VIP类型
        $vip_list = $vipmodel->where('status <> 0')->select();
        
        $info = $eatmodel->where('id = '.I('get.id').' and uid = '.$uid)->find();
        $business_hours=explode('-',$info['business_hours']);
        $info['business_hours1']=$business_hours['0'];
        $info['business_hours2']=$business_hours['1'];
        $this->assign('info',$info);
        $this->assign('eat_type_list',$eat_type_list);
        $this->assign('vip_list',$vip_list);
        unset($eat_type_list,$vip_list);
    	$this->display('eatadd');
    }
    /**
     *餐饮状态修改
     * @param unknown_type $method
     */
    public function eat_changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        $uid = UID;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('restaurant')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->forbid('Restaurant', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'resumeuser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('restaurant')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->resume('Restaurant', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'deleteuser':
                $this->delete('Restaurant', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'falsestatus':
                $this->falsestatus('Restaurant', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            default:
                $this->error('参数非法');
        }
    }
    /**
     * 线路列表
     * @author calvin <977639814@163.com>
     */
    public function relist(){
        $model = M('route');
        $uid = UID;
        $map['a.status'] = array('neq',2);
        $map['a.uid'] = array('eq',$uid);
        if(I('get.status') != "")
            $map['a.status'] = array('eq',I('get.status'));
        if(I('get.title'))
            $map['a.title'] = array('like','%'.I('get.title').'%');
        $count=$model->alias('a')->join(C('DB_PREFIX').'member b on a.uid = b.uid')->where($map)->count();
        $page=new Util\Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
        $list = $model->field('a.id,a.logo_img_url,a.favorable_price,a.title,a.chief,a.tel,a.price,a.day,a.night,a.team_number,a.price,a.day,a.night,a.insert_time,a.status,b.nickname,b.realname')->alias('a')->join('left join '.C('DB_PREFIX').'member b on a.uid = b.uid and a.uid = '.$uid)->where($map)->order('a.sort,a.insert_time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $map=array('status'=>array(1=>'已上架',0=>'已下架',3=>'待通过',4=>'不通过'));
        int_to_string($list,$map);
        $this->assign('_list',$list);
        $this->display();
    }
    /**
     * 添加路线数据
     * @author calvin <banhuajie@163.com>
     */
    public function readd(){
        if(IS_POST){
            $uid = UID;
            $model = new RouteModel();
            $data = I('post.');
            $data['uid'] = $uid;
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $data['vip_price'] = $str;
            $result = $model->fr_add($data);
            if($result){
                $this->success('数据添加成功',U('re_pro_add',array('route'=>$result,'day'=>I('post.day'),'night'=>I('post.night'))));
            }else{
                $this->error($result);
            }

        }
        //VIP类型
        $vipmodel = M('vip');
        $vip_list = $vipmodel->where('status <> 0')->select();
        $this->assign('vip_list',$vip_list);
        $this->display();
    }
    /**
     * 编辑路线数据
     */
    public function reedit(){
        if(IS_POST){
            $model = new RouteModel();
            $data = I('post.');
            for($i=0;$i<count($data['vip']);$i++){
                $str .= ($data['vip_id'][$i]."|".$data['vip'][$i].",");
            }
            $result = $model->fr_edit($data);

            if($result == 1){
                $this->success('路线更新成功');
            }else{
                $this->error($result);
            }
            exit;

        }
        $model=M('Route');
        $uid = UID;
        $info=$model->where('id='.I('get.id').' and uid = '.$uid)->find();
        $id=$info['id'];

        //VIP类型
        $vipmodel = M('vip');
        $vip_list = $vipmodel->where('status = 1')->select();
        $this->assign('vip_list',$vip_list);
        $this->assign('info',$info);
        $this->display();
    }
    /**
     * 编辑活动数据
     */
    public function re_pro_edit(){
        if(IS_POST){
            $model = M('route_details');
            $day = I('post.day');
            // dump(I('post.'));
            // exit;
            $r = 0;
            $u = 0;
            $d = 0;
            for($i=1;$i<=count($day);$i++){
                
                $start_time = I('post.start_time'.$i);
                $end_time = I('post.end_time'.$i);
                $bewrite = I('post.bewrite'.$i);
                $pro_id = I('post.pro_id'.$i);
                $type = I('post.type'.$i);
                $day = I('post.day');
                $id = I('post.id'.$i);


                for($j=0;$j<count($start_time);$j++){
                    if($id[$j]){
                        $data[$r]['route_id'] = I('post.route_id');
                        $data[$r]['start_time'] = $start_time[$j];
                        $data[$r]['end_time'] = $end_time[$j];
                        $data[$r]['bewrite'] = $bewrite[$j];
                        $data[$r]['type']=$type[$j];
                        $pro=explode('-',$pro_id[$j]);
                        $data[$r]['pro_id']=$pro['0'];
                        $data[$r]['pro_name']=$pro['1'];
                        $data[$r]['day'] = $day[$u];
                        $data[$r]['id'] = $id[$j];
                        $model->save($data[$r]);
                        $r++;
                    }else{
                        $datas[$d]['route_id'] = I('post.route_id');
                        $datas[$d]['start_time'] = $start_time[$j];
                        $datas[$d]['end_time'] = $end_time[$j];
                        $datas[$d]['bewrite'] = $bewrite[$j];
                        $datas[$d]['type']=$type[$j];
                        $pro=explode('-',$pro_id[$j]);
                        $datas[$d]['pro_id']=$pro['0'];
                        $datas[$d]['pro_name']=$pro['1'];
                        $datas[$d]['day'] = $day[$u];
                        $d++;
                    }
                    
                    
                }
                $u++;
                
            }

            //$result = $model->save($data);
            // echo $model->getLastSql();
            // exit;
            //dump($data);
            //$result = $model->addAll($data);
            $results = $model->addAll($datas);
            if($result){
                $this->success('数据编辑成功',U('relist'));
            }else{
                echo $model->getError();
                exit;
                //$this->error('添加失败');
            }

        }

        $this->display();
    }
    //删除活动
    public function pro_delete(){
        $id = I('post.id');
        //dump($id);
        $this->delete('route_details', array('id'=>array('in',$id)) );

    }
    
    public function re_pro_add(){
        if(IS_POST){
            $model = D('route_details');
            $day = I('post.day');
            $r = 0;
            $u = 0;
            for($i=1;$i<=count($day);$i++){
                
                $start_time = I('post.start_time'.$i);
                $end_time = I('post.end_time'.$i);
                $bewrite = I('post.bewrite'.$i);
                $pro_id = I('post.pro_id'.$i);
                $type = I('post.type'.$i);
                $day = I('post.day');

                for($j=0;$j<count($start_time);$j++){
                    $data[$r]['route_id'] = I('post.route_id');
                    $data[$r]['start_time'] = $start_time[$j];
                    $data[$r]['end_time'] = $end_time[$j];
                    $data[$r]['bewrite'] = $bewrite[$j];
                    $data[$r]['type']=$type[$j];
                    $pro=explode('-',$pro_id[$j]);
                    $data[$r]['pro_id']=$pro['0'];
                    $data[$r]['pro_name']=$pro['1'];
                    $data[$r]['day'] = $day[$u];
                    $r++;
                }
                $u++;
                
            }
            $result = $model->addAll($data);
            if($result){
                $this->success('添加成功',U('relist'));
            }else{
                $this->error('添加失败');
            }

        }
        $this->display();
    }
    public function pro_select(){
        if(IS_POST){
            if(I('post.pro_type')){
                switch (I('post.pro_type')) {
                    case '1':
                        # code...
                        $model = M('hel');
                        $list = $model->field('id,hel_name name')->where("status = 1")->cache(true,60,'xcache')->select();
                        //echo $model->getLastSql();
                        break;
                    case '2':
                        # code...
                        $model = M('restaurant');
                        $list = $model->field('id,foot_name name')->where("status = 1")->cache(true,60,'xcache')->select();
                        //echo $model->getLastSql();
                        break;

                    case '3':
                        # code...
                        $model = M('play');
                        $list = $model->field('id,title name')->where("status = 1")->cache(true,60,'xcache')->select();
                        //echo $model->getLastSql();
                        break;

                    default:
                        # code...
                        break;
                }
                echo json_encode($list);
            }
        }
    }

    /**
     *路线状态修改
     * @param unknown_type $method
     */
    public function re_changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        $uid = UID;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('Route')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->forbid('Route', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'resumeuser':
                $map['id'] = array('in',$id);
                $map['status'] = array('in','2,3');
                if(M('Route')->where($map)->field('id')->find()){
                    $this->error('不能上架/下架未通过的数据');
                    exit;
                }
                $this->resume('Route', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'deleteuser':
                $this->delete('Route', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            case 'falsestatus':
                $this->falsestatus('Route', array('id'=>array('in',$id),'uid' => array('eq',$uid)) );
                break;
            default:
                $this->error('参数非法');
        }
    }
}