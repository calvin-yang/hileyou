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
class IndexController extends HomeController {

    //系统首页
    
    public function index(){
        $pro_type = I('request.pro_type');
        $map['a.status'] = array('eq',1);
        if(I('request.provinces'))
            $map['a.provinces'] = array('eq',I('request.provinces'));
        if(I('request.city'))
            $map['a.citys'] = array('eq',I('request.city'));
        if(I('request.country'))
            $map['a.countys'] = array('eq',I('request.country'));
        switch ($pro_type) {
            /***
            ** 首页列表
            **@string logo_img_url 封面图
            **@string title 路线标题
            **@string destination 目的地
            **@string comment_number 评论数量
            ***/
            case '1'://房源
                # code...
                $model = M('hel');

                //查询条数
                $data_count = $model->alias('a')->where($map)->count();
                if(I('request.page') != ""){
                    $page = I('request.page'); //第几页
                }else{
                    $page = '1'; //第几页
                }
                $page_size = '5'; //每页五条数据
                $page_count = ceil($data_count/$page_size);//几页
                $page_number = ($page-1)*$page_size;

                if($page_count < $page){
                    $this->ajaxReturn(array('msg'=>'暂无数据','status' => false));
                    exit;
                }
                $list = $model->field('a.id,a.pro_type,a.logo_img_url,a.title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                getImg($list,array('logo_img_url','face_max_url'));
                
                $data['list'] = $list;
                $this->ajaxReturn(array('msg' => $data, 'status' => true));
                exit;

                break;
            case '2'://餐饮
                # code...
                $model = M('restaurant');
                //查询条数
                $data_count = $model->alias('a')->where($map)->count();
                if(I('request.page') != ""){
                    $page = I('request.page'); //第几页
                }else{
                    $page = '1'; //第几页
                }
                
                $page_size = '5'; //每页五条数据
                $page_count = ceil($data_count/$page_size);//几页
                $page_number = ($page-1)*$page_size;

                if($page_count < $page){
                    $this->ajaxReturn(array('msg'=>'暂无数据','status' => false));
                    exit;
                }
                $list = $model->field('a.id,a.pro_type,a.logo_img_url,a.foot_name title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                getImg($list,array('logo_img_url','face_max_url'));

                $data['list'] = $list;
                $this->ajaxReturn(array('msg' => $data, 'status' => true));
                break;
            case '3'://景点
                # code...
                $model = M('play');
                //查询条数
                
                $data_count = $model->alias('a')->where($map)->count();
                if(I('request.page') != ""){
                    $page = I('request.page'); //第几页
                }else{
                    $page = '1'; //第几页
                }

                $page_size = '5'; //每页五条数据
                $page_count = ceil($data_count/$page_size);//几页
                $page_number = ($page-1)*$page_size;

                if($page_count < $page){
                    $this->ajaxReturn(array('msg'=>'暂无数据','status' => false));
                    exit;
                }
                $list = $model->field('a.id,a.pro_type,a.logo_img_url,a.title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                getImg($list,array('logo_img_url','face_max_url'));

                $data['list'] = $list;
                $this->ajaxReturn(array('msg' => $data, 'status' => true));
                break;
            case '4'://路线
                # code...
                $model = M('route');
                
                //查询条数
                $data_count = $model->alias('a')->where($map)->count();
                if(I('request.page') != ""){
                    $page = I('request.page'); //第几页
                }else{
                    $page = '1'; //第几页
                }
                $page_size = '5'; //每页五条数据
                $page_count = ceil($data_count/$page_size);//几页
                $page_number = ($page-1)*$page_size;
                if($page_count < $page){
                    $this->ajaxReturn(array('msg'=>'暂无数据','status' => false));
                    exit;
                }
                $list = $model->field('a.id,a.pro_type,a.logo_img_url,a.title,a.destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=4')->where("a.status = 1")->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                getImg($list,array('logo_img_url','face_max_url'));

                $data['list'] = $list;
                $this->ajaxReturn(array('msg' => $data, 'status' => true));
                break;
            default:#全部
                
                #缓存
                if(S('list')){
                    $list = S('list');
                }else{
                    #路线列表数据
                    $routelist = M('route')->field('a.id,a.pro_type,a.logo_img_url,a.title,a.destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=4')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                    #游玩列表数据
                    $playlist = M('play')->field('a.id,a.pro_type,a.logo_img_url,a.title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                    $list = array_merge($routelist,$playlist);
                    #餐饮列表数据
                    $restaurantlist = M('restaurant')->field('a.id,a.pro_type,a.logo_img_url,a.foot_name title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                    $list = array_merge($list,$restaurantlist);
                    #房源列表数据
                    $hellist = M('hel')->field('a.id,a.pro_type,a.logo_img_url,a.title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
                    $list = array_merge($list,$hellist);
                    S('list',$list,60);
                }
                

                if(I('request.page') != ""){
                    $page = I('request.page'); //第几页
                }else{
                    $page = '1'; //第几页
                }
                $page_size = '5'; //每页五条数据
                $page_count = ceil(count($list)/$page_size);//几页
                $page_number = ($page-1)*$page_size;
                if($page_count < $page){
                    $this->ajaxReturn(array('msg'=>'暂无数据','status' => false));
                    exit;
                }
                $j = 1;
                $lists = array();
                for($i = $page_number; $i<=count($list); $i++){
                    if($j > 5){
                        #跳出循环
                        break;
                    }
                    #尾部添加数组
                    array_push($lists,$list[$i]);
                    $j++;
                }
                $list = $lists;

                break;
        }
         /***
        ** 导航栏目两大块
        **@string img_url 封面图
        **@string type 类型(1：房源；2：餐饮；3：景点；4：路线；5；小栏目路线)
        ***/
        $HomeImgConfigModel = M('home_img_config');
        $navigation_list = $HomeImgConfigModel->field('id,img_url,retitle,title,type')->where('status = 1 and type=4')->limit(4)->select();
        getImg($navigation_list,array('img_url'));

        $navigation_list2 = $HomeImgConfigModel->field('id,img_url,title,retitle,type')->where('type in (1,2,3,5) and status = 1')->order('type = 1 DESC,type=2 DESC,type=3 DESC,type=5 desc')->limit(4)->select();
        getImg($navigation_list2,array('img_url'));

        $data['navigation_list'] = $navigation_list;
        $data['navigation_list2'] = $navigation_list2;
        if (!$list) {
            $this->ajaxReturn(array('msg' => '暂无数据', 'status' => false));
            exit;
        }
        getImg($list,array('logo_img_url','face_max_url'));
        $data['list'] = $list;
        $this->ajaxReturn(array('msg' => $data, 'status' => true));
    
    }
    

    public function upload(){
        if(IS_POST){
            //又拍云
            // $config = array(
            //     'host'     => 'http://v0.api.upyun.com', //又拍云服务器
            //     'username' => 'zuojiazi', //又拍云用户
            //     'password' => 'thinkphp2013', //又拍云密码
            //     'bucket'   => 'thinkphp-static', //空间名称
            // );
            // $upload = new \COM\Upload(array('rootPath' => 'image/'), 'Upyun', $config);
            //百度云存储
            $config = array(
                'AccessKey'  =>'3321f2709bffb9b7af32982b1bb3179f',
                'SecretKey'  =>'67485cd6f033ffaa0c4872c9936f8207',
                'bucket'     =>'test-upload',
                'size'      =>'104857600'
            );
            $upload = new \COM\Upload(array('rootPath' => './Uploads/bcs'), 'Bcs', $config);
            $info   = $upload->upload($_FILES);
        } else {
            $this->display();
        }
    }

    public function upyun(){
        $policydoc = array(
            "bucket"             => "thinkphp-static", /// 空间名
            "expiration"         => NOW_TIME + 600, /// 该次授权过期时间
            "save-key"            => "/{year}/{mon}/{random}{.suffix}",
            "allow-file-type"      => "jpg,jpeg,gif,png", /// 仅允许上传图片
            "content-length-range" => "0,102400", /// 文件在 100K 以下
        );

        $policy = base64_encode(json_encode($policydoc));
        $sign = md5($policy.'&'.'56YE3Ne//xc+JQLEAlhQvLjLALM=');

        $this->assign('policy', $policy);
        $this->assign('sign', $sign);
        $this->display();
    }

    public function test(){
        $table = new \OT\DataDictionary;
        echo "<pre>".PHP_EOL;
        $out = $table->generateAll();
        echo "</pre>";
        // print_r($out);
    }
    public function send_mail(){
        $mail = new SendEailApi();
        echo C('POINTS_ON_OFF');
        //$mail->SendMail('1357853614@qq.com','邮件标题2343','邮件正4324文');
    }


}
