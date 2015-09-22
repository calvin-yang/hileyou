<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;


use Common\Model\Api\SendEailApi;
/**
 * 产品控制器
 */
class ProductController extends HomeController
{
	/**
	 * 目的地结果数据
	 * @return [type] [description]
	 */
	public function index(){
		$pro_type = I('request.pro_type');
		$map['a.status'] = array('eq',1);
		if(I('request.provinces'))
			$map['a.provinces'] = array('eq',I('request.provinces'));
		if(I('request.city'))
			$map['a.citys'] = array('eq',I('request.city'));
		if(I('request.country'))
			$map['a.countys'] = array('eq',I('request.country'));
		#价格范围
		if(I('request.price')){
			$prices = explode('-',I('request.price'));
			$map['favorable_price'] = array(array('gt',$prices['0']),array('lt',$prices['1'])) ;
		}

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
                #床型
                if(I('request.bed_type'))
                	$map['a.bed_type'] = array('eq',I('request.bed_type'));
                #房源类型
                if(I('request.type'))
                	$map['a.type'] = array('eq',I('request.type'));
                #房源星级
                if(I('request.star'))
                	$map['a.star'] = array('eq',I('request.star'));
                #房间设施
                if(I('request.facilities'))
                	$map['a.facilities'] = array('like','%'.I('request.facilities').'%');


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



                break;
            case '2'://餐饮
                # code...
                $model = M('restaurant');
                #餐饮星级
                if(I('request.star'))
                	$map['a.star'] = array('eq',I('request.star'));
                #餐饮类型
                if(I('request.type'))
                	$map['a.type'] = array('eq',I('request.type'));
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

                break;
            case '3'://景点
                # code...
                $model = M('play');
                #房间设施
                if(I('request.type'))
                	$map['a.type'] = array('like','%'.I('request.type').'%');
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
                
                break;
            default:#全部
            	$list = array();
            	#缓存
            	if(S('list')){
            		$list = S('list');
            	}else{
            		#路线列表数据
	                $routelist = M('route')->field('a.id,a.pro_type,a.logo_img_url,a.title,a.destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=4')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
	                if($routelist)
	                	$list = array_merge($list,$routelist);
	                #游玩列表数据
	                $playlist = M('play')->field('a.id,a.pro_type,a.logo_img_url,a.title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
	                if($playlist)
	                	$list = array_merge($list,$playlist);
	                #餐饮列表数据
	                $restaurantlist = M('restaurant')->field('a.id,a.pro_type,a.logo_img_url,a.foot_name title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
	                if($restaurantlist)
	                	$list = array_merge($list,$restaurantlist);
	                #房源列表数据
	                $hellist = M('hel')->field('a.id,a.pro_type,a.logo_img_url,a.title,a.address destination,c.face_max_url,count(b.id) as comment_number')->alias('a')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type=1')->where($map)->order('a.sort')->group('a.id')->limit($page_number,$page_size)->select();
	                if($hellist)
	                	$list = array_merge($list,$hellist);
	                S('list',$list,1);
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
                for($i = $page_number; $i<count($list); $i++){
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
        if (!$list) {
        	$this->ajaxReturn(array('msg' => '暂无数据', 'status' => false));
        	exit;
        }
        getImg($list,array('logo_img_url','face_max_url'));
        $data['list'] = $list;
        $this->ajaxReturn(array('msg' => $data, 'status' => true));
    
    }
	/**
	 * 内容页(线路详情页)数据
	 * id:线路id
	 */
	public function lineContent(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.id'))){
			$this->error('参数非法');
		}
		$model = M('route');
		$delModel=M('routeDetails');
		$id=I('post.id');
		$uid = UID;
		//获取单条线路信息
		$result=$model->field('a.id,logo_img_url,title,vip_price,favorable_price,price,day,night,destination,housed_explain,departure_date,rental,insurance,cost_description,notes,count(b.id) as count')->alias('a')->join('left join tv_comment b on a.id=b.pro_id and b.pro_type=4')->where('a.id='.$id)->find();
		$result['price']=intval($result['price']);//价格转整形
		$result['favorable_price']=intval($result['favorable_price']);//价格转整形
		//获取图片信息
		getImg($result,array('logo_img_url'));
		//判断vip会员，取得vip价格
		if(empty($uid)){
			$result['vip_price']=0;
		}else{
			$vip=explode(',',$result['vip_price']);
			$vip_price=explode('|',$vip['0']);
			$result['vip_price']=$vip_price['1'];
		}
			//获取酒店信息
		$hotel=$delModel->field('pro_name')->where('route_id='.$id.' and status=1 and type=1')->select();
		foreach($hotel as $key=>$val){
			$hoteles[$key]=$val['pro_name'];
		}
			//获取游玩信息
		$sights=$delModel->field('pro_name')->where('route_id='.$id.' and status=1 and type=3')->select();
		foreach ($sights as $key=>$val){
			$sightes[$key]=$val['pro_name'];
		}
		$result['hotel']=$hoteles?$hoteles:'暂无';
		$result['sights']=$sightes?$sightes:'暂无';
		//获取线路产品的图片和名称
		$list=$delModel->field('pro_name,pro_id,b.type as types,b.name')->alias('a')->join('left join tv_play b on a.pro_id=b.id')->where('a.route_id='.$id.' and a.status=1 and a.type=3')->limit(4)->select();
		//获取产品封面图片
		foreach ($list as $key=>$val){
		/*if($val['type']=='1'){
			$proModel=M('hel');
			$prores=$proModel->field('logo_img_url')->where('id='.$val['pro_id'])->find();
			getImg($prores,array('logo_img_url'));
			$list[$key]['logo_img_url']=$prores['logo_img_url'];
		}elseif($val['type']=='2'){
			$proModel=M('restaurant');
			$prores=$proModel->field('logo_img_url')->where('id='.$val['pro_id'])->find();
			getImg($prores,array('logo_img_url'));
			$list[$key]['logo_img_url']=$prores['logo_img_url'];
		}elseif($val['type']=='3'){*/
			$proModel=M('play');
			$prores=$proModel->field('logo_img_url')->where('id='.$val['pro_id'])->find();
			getImg($prores,array('logo_img_url'));
			$list[$key]['logo_img_url']=$prores['logo_img_url'];
		//}
		}
		if(!$result || !$list){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		$this->ajaxReturn(array('status'=>true,'msg'=>'数据获取成功','data' =>array('subject'=>$result,'details'=>$list)));
	}
	
	/**
	 * 详细行程页
	 * id:线路id
	 */
	public function desContent(){
			if(!IS_POST){
				$this->error('非法操作');
			}
			if(!is_numeric(I('post.id'))){
				$this->error('参数非法');
			}
			$id=I('post.id');
			$model = M('route');
			$delModel=M('routeDetails');
			//获取线路大概信息
			$result=$model->field('title,logo_img_url,destination,departure_date,day,night')->where('id='.$id)->find();
			//获取图片信息
			getImg($result,array('logo_img_url'));
			//获取产品详细信息
			$list=$delModel->field('day,start_time,pro_name,type')->where('route_id='.$id.' and status=1')->order('day asc,start_time asc')->select();
			foreach($list as $key=>$val){
				$str=explode(':',$val['start_time']);
				if(intval($str['0'])<12){
					$val['apm']='AM';
				}else{
					$val['apm']='PM';
				}
				if($val['type']=='1'){
					$val['type']='房源';
				}elseif($val['type']=='2'){
					$val['type']='餐饮';
				}elseif($val['type']=='3'){
					$val['type']='景点';
				}elseif($val['type']=='4'){
					$val['type']='其它';
				}
				$data[$val['day']][]=$val;
			}
			if(!$result || !$data){
				$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
			}
			$this->ajaxReturn(array('data' =>array('subject'=>$result,'details'=>$data),'status'=>true,'msg'=>'数据获取成功'));
	}
	
	/**
	 * 游玩内容页
	 * id:产品id
	 * type:产品类型
	 */
	public function pyContent(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.id'))){
			$this->error('参数非法');
		}
		$id=I('post.id');
		$proModel=M('play');
		//获取游玩信息
		$result=$proModel->field('logo_img_url,look_number,contact,insert_time,title,type,introduce,play_time,address,provinces,citys,countys,sper_capita,play_strategy,attractions_img_url')->where('id='.$id.' and status=1')->find();
		$result['insert_time']=date('Y-m-d',$result['insert_time']);
		$result['type']=explode(",",$result['type']);
		//取得地区名
		$address=M('globalRegion');
		$row1=$address->field('region_name as name')->where('region_id='.$result['provinces'])->find();
		$row2=$address->field('region_name as name')->where('region_id='.$result['citys'])->find();
		$row3=$address->field('region_name as name')->where('region_id='.$result['countys'])->find();
		$result['provinces']=$row1['name'];
		$result['citys']=$row2['name'];
		$result['countys']=$row3['name'];
			//获取图片信息
		getImg($result,array('logo_img_url','attractions_img_url'));
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面已过时','status'=>false));
		}
		$this->ajaxReturn(array('data'=>$result,'status'=>true,'msg'=>'数据获取成功'));
	}
	
	/**
	 * type:产品类型
	 * id:产品id
	 * content:评论内容
	 * 产品评论添加
	 */
	public function insertMsg(){
		is_login() || $this->ajaxReturn(array('status'=>false,'msg'=>'您还没有登录，请先登录！'));
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.pro_type')) || !is_numeric(I('post.pro_id'))){
			$this->error('参数非法');
		}
		$data['pro_type']=I('post.pro_type');
		$data['pro_id']=I('post.pro_id');
		$data['content']=I('post.content');
		if(empty($data['content'])){
			$this->ajaxReturn(array('msg'=>'内容不能为空','status'=>false));
		}
		$data['insert_time']=time();
		$data['uid']=UID;
		$model=M('comment');
		if($model->add($data)){
			$this->ajaxReturn(array('msg'=>'留言添加成功','status'=>true));
		}else{
			$this->ajaxReturn(array('msg'=>'留言添加失败','status'=>false));
		}
	}
	
	/**
	 * 住房内容页数据提供
	 */
	public function rtContent(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.id'))){
			$this->error('参数非法');
		}
		$id=I('post.id');
		$model=M('hel');
		$uid=UID;
		$cmtModel=M('comment');
		//获取房源信息
		$result=$model->field('a.uid,a.hel_name,a.title,a.star,a.favorable_price,a.day_price,a.vip_price,a.name,a.hel_tel,a.max_man,a.bedroom,a.bed,a.provinces,a.citys,a.countys,a.address,a.hel_img_url,a.logo_img_url,a.introduce,a.type,a.tel_status,a.toilet,a.deposit,a.check_in,a.check_out,a.nearby_traffic,a.facilities,a.kindly_reminder,b.email')->alias('a')->join('left join tv_ucenter_member b on a.uid=b.id')->where('a.id='.$id.' and a.status=1')->find();
		getReg($result,array('citys','countys','provinces'));
		$result['favorable_price']=intval($result['favorable_price']);
		$result['day_price']=intval($result['day_price']);
		//获取更多房源信息
		$list=$model->field('id,logo_img_url,title,day_price')->where("status=1 and id<>$id")->limit(4)->select();
		foreach ($list as $key=>$val){
			$list[$key]['day_price']=intval($val['day_price']);
		}
		//APP取图片
		getImg($result,array('logo_img_url','hel_img_url'));
		getImg($list,array('logo_img_url'));
		//获取评论信息
		$comment=$cmtModel->field('a.uid,b.mobile,a.insert_time,a.content,count(a.uid) as count')->alias('a')->join('tv_ucenter_member b on a.uid=b.id')->where('a.pro_type=1 and a.pro_id='.$id)->find();
		$comment['insert_time']=date('m月d日 H:i',$comment['insert_time']);
		$comment['mobile']=preg_replace("/(1\d{1,2})\d\d(\d{0,3})/","\$1*****$3",$comment['mobile']);		
		//判断vip会员，取得vip价格
		if(empty($uid)){
			$result['vip_price']=0;
		}else{
			$vip=explode(',',$result['vip_price']);
			$vip_price=explode('|',$vip['0']);
			$result['vip_price']=$vip_price['1'];
		}
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		$this->ajaxReturn(array('data' =>array('subject'=>$result,'details'=>$list,'comment'=>$comment),'status'=>true,'msg'=>'数据获取成功'));
	}
	
	/**
	 * 更多评论接口
	 * id:产品id int
	 * type:产品类型 int
	 */
	public function moreComment(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.id')) || !is_numeric(I('post.type'))){
			$this->error('参数非法');
		}
		$id=I('post.id');
		$type=I('post.type');
		$model=M('comment');
		//评论总数
		$row=$model->field('count(id) as count')->where('pro_type='.$type.' and pro_id='.$id)->find();
		if(empty($row['count'])){
			$this->ajaxReturn(array('msg'=>'目前没有评论','status'=>false));
		}
		//评论列表
		$result=$model->field('a.content,a.insert_time,b.mobile')->alias('a')->join('left join tv_ucenter_member b on a.uid=b.id')->where('a.pro_type='.$type.' and a.pro_id='.$id)->select();
		foreach ($result as $key=>$val){
			$result[$key]['insert_time']=date('Y年m月d日 H:i',$val['insert_time']);
		}
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		/* num:评论总数   subject:评论主体*/
		$this->ajaxReturn(array('msg'=>'数据获取成功','status'=>true,'data'=>array('subject'=>$result,'num'=>$row['count'])));
	}
	
	/**
	 * 房东个人页面
	 * uid:房东id
	 */
	public function personData(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.uid')) || !I('post.type')){
			$this->error('参数非法');
		}
		$uid=I('post.uid');
		$type=I('post.type');
		$model=M('ucenterMember');
		$helModel=M('hel');
		//获取房东个人资料
		$result=$model->field('a.mobile,a.reg_time,a.email,b.IDcard')->alias('a')->join('left join tv_facilitator_data b on a.id=b.uid and b.status=1')->where('a.id='.$uid)->find();
		$result['mobile']=preg_replace("/(1\d{1,2})\d\d(\d{0,3})/","\$1*****$3",$result['mobile']);
		$result['reg_time']=date('Y年m月d日',$result['reg_time']);
		//获取优质房源资料
		$list=$helModel->field('id,logo_img_url,title,day_price,favorable_price')->where("status=1 and type='".$type."'")->limit(4)->select();
		foreach ($list as $key=>$val){
			$list[$key]['day_price']=intval($val['day_price']);
			$list[$key]['favorable_price']=intval($val['favorable_price']);
		}
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		getImg($list,array('logo_img_url'));
		$this->ajaxReturn(array('msg'=>'数据获取成功','status'=>true,'data'=>array('subject'=>$result,'details'=>$list)));
	}
	
	/**
	 * 更多房源接口
	 */
	public function moreHel(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		$helModel=M('hel');
		$result=$helModel->field('id,logo_img_url,title,address,praise_number')->where("status=1")->select();
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		getImg($result,array('logo_img_url'));
		$this->ajaxReturn(array('msg'=>'数据获取成功','status'=>true,'data'=>array('subject'=>$result)));
	}
	
	/**
	 * 饮食列表接口
	 * type:饮食类型 string
	 * countys:地区id  int
	 */
	public function eatContent(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		$eatModel=M('restaurant');
		$where=" 1=1 ";
		//筛选条件
		$type=I('post.type');
		$countys=I('post.countys');
		if(!empty($type)){
			$where.=" and type like '".$type."%' ";
		}
		if(!empty($countys) && is_numeric(I('post.countys'))){
			$where.=" and countys='".$countys."'";
		}
		//获取数据
		$result=$eatModel->field('id,foot_name,type,provinces,citys,countys,address,logo_img_url,eat_number,praise_number')->where('status=1 and '.$where)->select();
		//获取封面图
		getImg($result,array('logo_img_url'));
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		$this->ajaxReturn(array('msg'=>'数据获取成功','status'=>true,'data'=>array('subject'=>$result)));
	}
	/**
	 * 现金券信息接口
	 * @return [type] [description]
	 */
	public function eatvoucher(){
		if(!I('request.proid') || !I('request.protype'))
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		$eatModel = M('restaurant');
		$id = I('request.proid');
		$pro_type = I('request.protype');
		$map['a.id'] = array('eq',$id);
		$map['a.status'] = array('eq',1);
		#餐饮数据
		$info = $eatModel->alias('a')->field('a.logo_img_url,a.foot_name,a.voucher,FROM_UNIXTIME(a.effective_time,"%Y年%m月%d") effective_time,a.voucher_rules,a.type')->where($map)->find();
		
		if(!$info)
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		getImg($info,array('logo_img_url'));
		#评论数据
		unset($map);
		$map['a.pro_id'] = array('eq',$id);
		$map['a.pro_type'] = array('eq',$pro_type);
		// $map['a.status'] = array('neq',2);
		$commentlist = M('comment')->alias('a')->field('a.content,FROM_UNIXTIME(a.insert_time, "%Y年%m月%d %H:%i") insert_time,b.mobile,c.nickname')->alias('a')->join('left join tv_ucenter_member b on a.uid=b.id')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->where($map)->order('a.insert_time desc')->find();
		#需找相似餐饮
		unset($map);
		$map['a.status'] = array('eq',1);
		$map['a.id'] = array('neq',$id);
		$map['a.type'] = array('like','%'.$info['type'].'%');
		$similareatlist = $eatModel->alias('a')->field('a.logo_img_url,a.foot_name,a.voucher,FROM_UNIXTIME(a.effective_time,"%Y年%m月%d") effective_time,a.voucher_rules,a.type')->where($map)->order('a.insert_time desc')->limit(4)->select();

		$data['msg'] = 'info:餐饮数据;commentlist:评论数据;similareatlist:相似餐饮';
		$data['info'] = $info;
		$data['commentlist'] = $commentlist;
		$data['similareatlist'] = $similareatlist;


		$this->ajaxReturn(array('msg'=>'成功访问','data' => $data, 'status' => true));

	}
	
	/**
	 * 马上交谈页(发送邮件)
	 *email:收件人邮箱
	 *startime:入驻时间
	 *endtime:离开时间
	 * number:人数
	 * content:内容
	 */
	public function conversation(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.number'))){
			$this->error('参数非法');
		}
		if(!I('post.email')){
			$this->error('该用户目前还没有设置邮箱喔~');
		}
		$startime=I('post.startime');
		$endtime=I('post.endtime');
		$email=I('post.email');
		$number=I('post.number');
		$content=I('post.content');
		$str="拼接组成";
		$mail = new SendEailApi();
		if($mail->SendMail($email,'标题',$str)){
			$this->ajaxReturn(array('msg'=>'发送成功','status'=>true));
		}else{
			$this->ajaxReturn(array('msg'=>'发送失败','status'=>false));
		}
	}
	
	/**
	 * 美食筛选数据提供
	 */
	public function eatselect(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		$model=M('restaurant');
		$address=M('globalRegion');
		//美食类型
		$result=$model->distinct(true)->field('type')->where('status=1')->select();
		foreach ($result as $key=>$val){
			$data[$key]=$val['type'];
		}
		//地区类型
		$addrow=$address->field('region_id as id,region_name as name')->where('parent_id=77')->select();
		if(!$data && !$addrow){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		$this->ajaxReturn(array('msg'=>'获取数据成功','status'=>true,'data'=>array('type'=>$data,'address'=>$addrow)));
	}
	
	/**
	 * 餐饮详情接口
	 */
	public function eatDesc(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.id'))){
			$this->error('参数非法');
		}
		$id=I('post.id');
		$uid=UID;
		$model=M('restaurant');
		$comment=M('comment');
		//获取单个餐饮详细信息
		$result=$model->field('logo_img_url,foot_name,star,per_capita,favorable_price,vip_price,provinces,citys,countys,address,foot_tel,voucher,introduce,eat_number,praise_number')->where('id='.$id.' and status=1')->find();
		getImg($result,array('logo_img_url'));
		//判断vip会员，取得vip价格
		if(empty($uid)){
			$result['vip_price']=0;
		}else{
			$vip=explode(',',$result['vip_price']);
			$vip_price=explode('|',$vip['0']);
			$result['vip_price']=$vip_price['1'];
		}
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面过时了','status'=>false));
		}
		//获取更多房源
		$list=$model->field('id,logo_img_url,foot_name,type,star')->where("id<>{$id} and status=1")->limit(4)->select();
		getImg($list,array('logo_img_url'));
		//获取评论信息
		$row=$comment->field('a.uid,a.content,a.insert_time,b.mobile,count(a.uid) as count')->alias('a')->join('tv_ucenter_member b on a.uid=b.id')->where('a.pro_id='.$id.' and a.pro_type=2')->find();
		$this->ajaxReturn(array('msg'=>'数据获取成功','status'=>true,'data'=>array('subject'=>$result,'morerm'=>$list,'comment'=>$row)));
	}
	
	
	/*
	 *  景点内容页数据接口
	**/
	public function pyinformation(){
		if (!I('get.proid')) {
			# code...
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
			exit;
		}
		$proid = I('get.proid');
		$model = M('play');
		$commentModel = M('comment');

		/**
		 * 用户评论数据
		 */
		$commentlist = $commentModel->field('a.pro_type,a.content,a.score,FROM_UNIXTIME(a.insert_time, "%Y-%m-%d") insert_time,b.mobile,c.face_max_url')->alias('a')->join('left join '.C('DB_PREFIX').'ucenter_member b on a.uid = b.id')->join('left join '.C('DB_PREFIX').'member c on a.uid = c.uid')->where('a.pro_type = 3 and a.pro_id = '.$proid)->find();
	
		if($commentlist){
			getImg($commentlist,array('face_max_url'));  // 获取图片链接
			$data['commentlist'] = $commentlist;
		}else{
			$data['commentlist'] = false;
		}

		/**
		 * 景点数据
		 */
		$result = $model->field(
			'a.id,a.title,a.type,a.price,a.favorable_price,a.provinces,a.citys,a.countys,a.address,'
			.'a.tel,a.introduce,a.play_time,a.logo_img_url,a.attractions_img_url,a.play_strategy,a.nearby_traffic,a.sper_capita,'
			.'count(b.id) comment_number'
			)->alias('a')->join('left join '.C('DB_PREFIX').'comment b on a.id = b.pro_id and b.pro_type = 3')->where('a.status = 1 and a.id = '.$proid)->group('a.id')->find();
		//echo $model->getLastSql();
		if(!$result){
			$this->ajaxReturn(array('msg' => '该数据不可用','status' => false));
			exit;
		}
		getReg($result,array('provinces','citys','countys'));  //获取省市区
		getImg($result,array('logo_img_url','attractions_img_url'));  // 获取图片链接

		$data['pyinfo'] = $result;

		/**
		 * 相似景区
		 */
		$map['status'] = array('eq','1');
		$map['type'] = array('like','%'.$result['type'].'%');
		$similarpy = $model->field('logo_img_url,title,type,id')->where($map)->limit(4)->select();
		if($similarpy){
			getImg($similarpy,array('logo_img_url'));  // 获取图片链接
			$data['similarpy'] = $similarpy;
		}else{
			$data['similarpy'] = false;
		}
		
		$this->ajaxReturn(array('msg' => '数据获取成功','status' => true,'data' =>$data));


	}
	/**
	 * 产品筛选
	 * @return [type] [description]
	 */
	public function proselection(){
		if(!I('request.protype'))
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
		$model = M('lv_type');
		switch (I('request.protype')) {
			#房源
			case '1':
				$map['facilities_type'] = array('eq',1);
				$map['status'] = array('eq',1);
				$list = $model->field('name,type')->where($map)->select();

				break;
			#餐饮
			case '2':
				$map['facilities_type'] = array('eq',2);
				
				break;
			#景点
			case '3':
				$map['facilities_type'] = array('eq',3);
				break;
			#路线
			case '4':
				$map['facilities_type'] = array('eq',4);
				break;
			
		}
		$map['status'] = array('eq',1);
		$list = $model->field('name,type')->where($map)->select();
		if($list){
			for($i=0;$i<count($list);$i++){
				$list[$i]['name'] = explode(',',$list[$i]['name']);
			}
		}
		$data['list'] = $list;
		$this->ajaxReturn(array('msg'=>'获取数据成功','data' => $data,'status' => true));
		
	}
	/**
	 * 目的地
	 */
	public function destination(){
		if(!I('get.line')){
			$this->ajaxReturn(array('msg' => '非法操作','status' => false));
			exit;
		}
		$line = I('get.line');
		$regModel = M('global_region');

		switch ($line) {
			case '1':
				# code...
				$routeModel = M('route');
				$routelist = $routeModel->field('id,pro_type,logo_img_url,title')->where('status = 1')->order('sort,insert_time desc')->limit('4')->select();
				if($routelist)
					getImg($routelist,array('logo_img_url'));
				$data['routelist'] = $routelist;

				$result = $regModel->field('region_id,region_name')->where('region_type = 1')->select();
				break;
			case '2':
				# code...
				$provinces = I('request.regid');
				$result = $regModel->field('region_id,region_name')->where('parent_id = '.$provinces)->select();
				break;
			case '3':
				# code...
				$city = I('request.city');
				$result = $regModel->field('region_id,region_name')->where('parent_id = '.$city)->select();
				
				break;
			default:
				# code...
				$result = $regModel->field('region_id,region_name')->where('region_type = 1')->select();
				
				break;
		}
		if(!$result){
			$this->ajaxReturn(array('msg' => '暂无数据','status' => false));
			exit;
		}
		$data['result'] = $result;
		$this->ajaxReturn(array('data' => $data,'status' => true));
	}
	
	/**
	 * 文章内容页
	 * param:id=>int
	 */
	public function inforContent(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		if(!is_numeric(I('post.id'))){
			$this->error('参数非法');
		}
		$id=I('post.id');
		$model=M('News');
		$result=$model->field('title,insert_time,content')->where('id='.$id)->find();
		$result['insert_time']=date('Y-m-d H:i',$result['insert_time']);
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面不存在','status'=>false));
		}
		$this->ajaxReturn(array('data'=>$result,'status'=>true));
	}
	
	/**
	 * 文章列表
	 * param:type=>1:置顶文章  0：业内文章
	 */
	public function inforList(){
		$model=M('News');
		$page=I('get.page')?I('get.page'):1;
		$epage=$page=='1'?10:5;
		$pageArr=($page-1)*$epage;
		$result=$model->field('id,insert_time,title,logo_img_url,content')->where('status=1 and stick=0 and type=2')->order('sort desc,insert_time desc')->limit($pageArr,$epage)->select();
		foreach ($result as $val) {
			$val['insert_time']=date('Y-m-d H:i',$val['insert_time']);
		}
		getImg($result,array('logo_img_url'));
		if(!$result){
			$this->ajaxReturn(array('msg'=>'您访问的页面不存在','status'=>false));
		}
		$this->ajaxReturn(array('data'=>$result,'status'=>true));
	}
	
	/**
	 * 文章首页
	 */
	public function inforShow(){
		$model=M('News');
		//获取置顶文章
		$result=$model->field('id,title,logo_img_url')->where('status=1 and stick=1 and type=2')->order('insert_time desc')->limit(3)->select();
		getImg($result,array('logo_img_url'));
		//最新资讯
		$list=$model->field('id,title,logo_img_url,address')->where('status=1 and stick=0 and type=2')->order('insert_time desc')->limit(4)->select();
		getImg($list,array('logo_img_url'));
		//平台公告
		$row=$model->field('a.id,a.logo_img_url,a.title,a.content,a.insert_time,a.news_sort_id,b.name')->alias('a')->join('tv_news_sort b on a.news_sort_id=b.id')->where('a.status=1 and a.stick=0 and a.type=2')->order('insert_time desc')->limit(4,5)->select();
		getImg($row,array('logo_img_url'));
		foreach($row as $key=>$val){
			$row[$key]['insert_time']=date('Y-m-d H:i',$val['insert_time']);
		}
		$arr=array();
		foreach ($row as $key=>$val){
			$arr[$val['news_sort_id']]['list'][]=$val;
		}
		foreach ($arr as $key=>$val){
			$arr[$key]['name']=$val['list']['0']['name'];
		}
		if(!$result || !$list || !$row){
			$this->ajaxReturn(array('msg'=>'您访问的页面不存在','status'=>false));
		}
		$this->ajaxReturn(array('msg'=>'数据获取成功','status'=>true,'data'=>array('topsub'=>$result,'newsub'=>$list,'indsub'=>$arr)));
	}
	
	/**
	 * 站内信接口——发送接口
	 */
	public function msgSend(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		is_login() || $this->ajaxReturn(array('status'=>false,'msg'=>'您还没有登录，请先登录！'));
		$data['sender_id']=is_login();					//发件人id
		$data['receiver_id']=I('post.id');				//收件人id
		$data['send_time']=time();						//发送时间
		$data['read_flag']='2';							//1:已读2:未读
		$data['message_text']=I('post.content');		//发送内容
		if(empty($data['message_text'])){
			$this->error('发送内容不能为空');
		}
		$msgModel=M('Message');
		$model=M('MessageText');
		$data['message_text_id']=$model->add(array('sender_id'=>$data['sender_id'],'message_text'=>$data['message_text']));
		if(!$data['message_text_id']){
			$this->ajaxReturn(array('msg'=>'发送失败','status'=>false));
		}
		if($msgModel->add($data)){
			$this->ajaxReturn(array('msg'=>'发送成功','status'=>true));
		}else{
			$this->ajaxReturn(array('msg'=>'发送失败','status'=>false));
		}
	}
	
	
	/**
	 * 产品点赞
	 */
	public function proZambia(){
		if(!IS_POST){
			$this->error('非法操作');
		}
		is_login() || $this->ajaxReturn(array('status'=>false,'msg'=>'您还没有登录，请先登录！'));
		$data['pro_id']=I('post.id');
		$data['pro_type']=I('post.type');
		if(!is_numeric($data['pro_id']) || !is_numeric($data['pro_type'])){
			$this->error('参数非法');
		}
		$data['time']=time();
		$data['uid']=is_login();
		$model=M('Upvote');
		if(!$model->add($data)){
			$this->ajaxReturn(array('msg'=>'点赞失败','status'=>false));
		}
		if($data['pro_type']=='1'){
			$mod=M('Hel');
		}elseif ($data['pro_type']=='2'){
			$mod=M('Restaurant');
		}elseif ($data['pro_type']=='3'){
			$mod=M('Play');
		}elseif ($data['pro_type']=='4'){
			$mod=M('Route');
		}
		$rowline=$mod->where('id='.$data['pro_id'])->setInc('praise_number');
		if($rowline){
			$this->ajaxReturn(array('msg'=>'点赞成功','status'=>true));
		}else{
			$this->ajaxReturn(array('msg'=>'点赞失败','status'=>false));
		}
	}
	/**
	 * 加入购物车
	 * @return [type] [description]
	 */
	public function insertcart(){
		is_login() || $this->ajaxReturn(array('status'=>false,'msg'=>'您还没有登录，请先登录！'));
		if(!IS_POST)
			$this->ajaxReturn(array('msg'=>'非法操作','status'=>false));
		/**
		 * pro_id  产品id
		 * pro_type   产品类型
		 */
		$model = M('cart');
		if(!I('pro_id') || !I('pro_type'))
			$this->ajaxReturn(array('msg'=>'非法操作','status'=>false));
		$uid = is_login();
		$map['pro_id'] = array('eq',I('pro_id'));
		$map['pro_type'] = array('eq',I('pro_type'));
		$map['uid'] = array('eq',$uid);

		$result = $model->where($map)->getField('id');
		if($result)
			$this->ajaxReturn(array('msg'=>'该产品已添加至购物车','status'=>false));
		$data['pro_id'] = I('pro_id');
		$data['pro_type'] = I('pro_type');
		$data['uid'] = $uid;
		$data['insert_time'] = time();
		$result = $model->add($data);
		if($result)
			$this->ajaxReturn(array('msg'=>'添加购物车成功，请前去购物车支付','status'=>true));
		else
			$this->ajaxReturn(array('msg'=>'添加购物车失败','status'=>false));
 
	}
}