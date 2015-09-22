<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie <yangweijiester@gmail.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use ORG\Util;

/**
 * 前台配置控制器
 * @author yangweijie <yangweijiester@gmail.com>
 */

class HomeController extends AdminController {
	public function index(){
		$model = M('home_img_config');
		$list = $model->where('type = 4')->limit(4)->select();
		if(IS_POST){
			$img = I('post.img_url');
			$id = I('post.id');
			$title = I('post.title');
			$retitle = I('post.retitle');

			$uid = UID;
			for($i = 0;$i<count($img);$i++){
				if($id[$i] == ""){

					if($img[$i] == ''){
						$this->error('请上传顶部栏'.$i.'图片');
						exit;
					}
					$data[$i] = I('post.');
					unset($data[$i]['id']);
					$data[$i]['img_url'] = $img[$i];
					$data[$i]['title'] = $title[$i];
					$data[$i]['retitle'] = $retitle[$i];
					$data[$i]['type'] = '4';
					$data[$i]['status'] = $data[$i]['status'.($i+1)];
					$data[$i]['uid'] = $uid;
					$data[$i]['insert_time'] = time();
				}else{

					$data = I('post.');
					$data['status'] = $data['status'.($i+1)];
					$data['img_url'] = $img[$i];
					$data['title'] = $title[$i];
					$data['retitle'] = $retitle[$i];
					$data['id'] = $id[$i];
					$data['update_time'] = time();

					$result = $model->save($data);
					//echo $model->getLastSql();

				}
			}
			
			if(!$list){
				$result = $model->addAll($data);
			}
			//if($result){
				$this->success('数据操作成功');
			// }else{
			// 	$this->error('数据操作失败');
			// }
		}
		
		$this->assign('_list',$list);
		$this->display();
	}

	public function protyp(){
		$model = M('home_img_config');
		$list = $model->where('type in (1,2,3,5)')->order('type = 1 DESC,type=2 DESC,type=3 DESC,type=5 desc')->limit(4)->select();
		// echo $model->getLastSql();
		// exit;
		if(IS_POST){
			$img = I('post.img_url');
			$id = I('post.id');
			$type = I('post.type');
			$title = I('post.title');
			//$retitle = I('post.retitle');

			$uid = UID;
			for($i = 0;$i<count($img);$i++){
				if($id[$i] == ""){

					if($img[$i] == ''){
						$this->error('请上传顶部栏'.$i.'图片');
						exit;
					}
					$data[$i] = I('post.');
					unset($data[$i]['id']);
					$data[$i]['img_url'] = $img[$i];
					$data[$i]['title'] = $title[$i];
					//$data[$i]['retitle'] = $retitle[$i];
					$data[$i]['type'] = $type[$i];
					$data[$i]['status'] = $data[$i]['status'.($i+1)];
					$data[$i]['uid'] = $uid;
					$data[$i]['insert_time'] = time();
				}else{

					$data = I('post.');
					$data['status'] = $data['status'.($i+1)];
					$data['img_url'] = $img[$i];
					$data['id'] = $id[$i];
					$data['title'] = $title[$i];
					//$data['retitle'] = $retitle[$i];
					$data['update_time'] = time();

					$result = $model->save($data);
					//echo $model->getLastSql();

				}
			}
			// dump($data);
			// exit;
			if(!$list){
				$result = $model->addAll($data);
			}
			//if($result){
				$this->success('数据操作成功');
			// }else{
			// 	$this->error('数据操作失败');
			// }
		}
		
		$this->assign('_list',$list);
		$this->display();
	}
    /**
     * 网站LOGO图
     * @return [type] [description]
     */
    public function site_logo(){
        $model = M('home_img_config');
        $info = $model->where('type = 6')->find();
        if(IS_POST){
            $data = I('post.');
            if(I('post.id')){
                $data['update_time'] = time();
                $result = $model->save($data);
            }else{
                $data['insert_time'] = time();
                $result = $model->add($data);
            }
            if($result)
                $this->success('数据操作成功');
            else
                $this->error('数据操作失败');
            exit;
        }

        $this->assign('info',$info);
        $this->display();

    }
    /**
     * 文章分类
     * @return [type] [description]
     */
    public function news_sort(){
        $model = M('news_sort');
        $sort_type = I('get.sort','1');
        if(I('get.pid'))
            $map['pid'] = array('eq',I('get.pid'));

        $map['sort_type'] = array('eq',$sort_type);
        $map['status'] = array('neq',2);

        $list = $model->field('id,name,sort_type,status')->where($map)->select();
        int_to_string($list);

        $this->assign('_list',$list);
        $this->display();

    }
    /**
     * 添加文章分类
     * @return [type] [description]
     */
    public function news_sort_add(){
        $model = M('news_sort');
        if(IS_POST){
            $data = I('post.');
            if(!I('post.name'))
                $this->error('类名不能为空');

            if(I('post.id') == I('post.pid'))
                $this->error('父级分类不能为自己');

            if(I('post.pid'))
                $data['sort_type'] = '2';
            else
                $data['sort_type'] = '';

            if(I('post.id'))
                $result = $model->save($data);
            else
                $result = $model->add($data);
            
            
            if($result)
                $this->success('数据操作成功');
            else
                $this->error('数据操作失败');
            exit;
        }

        if(I('get.id')){
            $info = $model->where('id = '.I('get.id'))->find();
            $this->assign('info',$info);
        }
        if(S('sort_list')){
            $sort_list = S('sort_list');
        }else{
            $map['status'] = array('neq',2);
            $map['sort_type'] = array('eq',1);
            #父级分类
            $sort_list = $model->field('id,name')->where($map)->select();
            #子级分类
            unset($map['sort_type']);
            if($sort_list){
                foreach ($sort_list as $key => $value) {
                    $map['pid'] = $value['id'];
                    $sort_lists = $model->field('id,name')->where($map)->select();
                    if($sort_lists){
                        $sort_list[$key]['sorts'] = $sort_lists;
                    }else{
                        $sort_list[$key]['sorts'] = false;
                    }
                    
                }
            }else{
                $sort_list = false;
            }
            S('sort_list',$sort_list,5);
        }
        
        $this->assign('sort_list',$sort_list);
        $this->display();
        
    }
	/**
     * 图片上传
     * @author calvin <977639814@qq.com>
     */

    Public function imgUplode() {
        $upload = new Util\ImgUpload();
        if(I('get.type') == 'news'){
	        $upload->annexFolder = "./Uploads/news";//$annexFolder;   //附件存放路径
	        $upload->smallFolder =  "./Uploads/news/smallimg";//$smallFolder;   //缩略图存放路径
	        $upload->markFolder = "./Uploads/news/mark";//$markFolder;     //水印图片存放处
        }else{
        	$upload->annexFolder = "./Uploads/home";//$annexFolder;   //附件存放路径
	        $upload->smallFolder =  "./Uploads/home/smallimg";//$smallFolder;   //缩略图存放路径
	        $upload->markFolder = "./Uploads/home/mark";//$markFolder;     //水印图片存放处
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
     * 文章列表
     */
    public function inforList(){
    	$model=M('news');
        $map['status'] = array('neq',2);
        $map['type'] = array('eq',2);
    	$count=$model->field('count(id) as count')->where($map)->count();
    	$page=new Util\Page($count,10);
    	$show=$page->show();
    	$this->assign('_page',$show);
    	$list=$model->field('id,title,news_sort_id,sort,stick,insert_time,publisher,status')->where($map)->limit($page->firstRow.','.$page->listRows)->order('sort,insert_time desc')->select();
    	
        foreach ($list as $key=>$val) {
    		$sorts_name = get_table_field($val['news_sort_id'],'id','name','news_sort');
            $list[$key]['news_sort_name'] = $sorts_name;
    	}
    	$msg=array('status'=>array('1'=>'启用','0'=>'禁用'));
    	int_to_string($list,$msg);
    	$this->assign('_list',$list);
    	$this->display('inforList');
    }
    /**
     * 文章置顶操作
     * @return [type] [description]
     */
    public function news_stick(){
        $model=M('news');
        if(I('get.id')){
            $data = I('get.');
            if(I('get.stick') == 1)
                $data['stick'] = "0";
            else
                $data['stick'] = '1';
            
            if($model->save($data))
                $this->success('数据操作成功');
            else
                $this->error('数据操作失败');

        }else{
            $this->error('非法操作');
        }
    }
    /**
     * 新增文章
     */
    public function inforadd(){
    	if(IS_POST){
    		$model=M('news');
    		$data=I('post.');
            if(!I('post.type')){
                $data['type'] = 2;
            }
            
            $data['uid'] = UID;
            $data['publisher'] = get_username(UID);
    		$data['insert_time']=time();
    		if(!$data['title'] || !$data['content']){
    			$this->error('标题或内容不能为空');
    		}
    		if($model->add($data)){
                if(I('post.type') && I('post.type') == 1)
                    $this->success('数据添加成功',U('inforList',array('type' => 1)));
                else
                    $this->success('数据添加成功',U('inforList'));
    			 
    		}else{
    			$this->error('数据添加失败');
    		}
    	}

        if(!I('get.type')){
            $model = M('news_sort');

            if(S('sort_list')){
                $sort_list = S('sort_list');
            }else{
                $map['status'] = array('neq',2);
                $map['sort_type'] = array('eq',1);
                #父级分类
                $sort_list = $model->field('id,name')->where($map)->select();
                #子级分类
                unset($map['sort_type']);
                if($sort_list){
                    foreach ($sort_list as $key => $value) {
                        $map['pid'] = $value['id'];
                        $sort_lists = $model->field('id,name')->where($map)->select();
                        if($sort_lists){
                            $sort_list[$key]['sorts'] = $sort_lists;
                        }else{
                            $sort_list[$key]['sorts'] = false;
                        }
                        
                    }
                }else{
                    $sort_list = false;
                }
                S('sort_list',$sort_list,5);
            }
            $this->assign('sort_list',$sort_list);
            $this->display();
        }else if(I('get.type') && I('get.type') == 1){
            $this->display('tladd');
        }
        
    	
    }
    
    /**
     * 编辑文章
     */
    public function inforedit(){
    	$id=I('get.id');
    	$model=M('news');
    	if(IS_POST){
    		$data=I('post.');
    		if(!$data['title'] || !$data['content']){
    			$this->error('标题或内容不能为空');
    		}
    		if($model->save($data)){
                if(I('post.type') && I('post.type') == 1)
                    $this->success('数据修改成功',U('inforList',array('type' => 1)));
                else
                    $this->success('数据修改成功',U('inforList'));
    			
    		}else{
    			$this->error('数据修改失败');
    		}
    	}
    	$info=$model->where('id='.$id)->find();

        if(!I('get.type')){
            $model = M('news_sort');

            if(S('sort_list')){
                $sort_list = S('sort_list');
            }else{
                $map['status'] = array('neq',2);
                $map['sort_type'] = array('eq',1);
                #父级分类
                $sort_list = $model->field('id,name')->where($map)->select();
                #子级分类
                unset($map['sort_type']);
                if($sort_list){
                    foreach ($sort_list as $key => $value) {
                        $map['pid'] = $value['id'];
                        $sort_lists = $model->field('id,name')->where($map)->select();
                        if($sort_lists){
                            $sort_list[$key]['sorts'] = $sort_lists;
                        }else{
                            $sort_list[$key]['sorts'] = false;
                        }
                        
                    }
                }else{
                    $sort_list = false;
                }
                S('sort_list',$sort_list,5);
            }
            $this->assign('sort_list',$sort_list);
            $this->assign('info',$info);
            $this->display('inforadd');

        }else if(I('get.type') && I('get.type') == 1){
            $this->assign('info',$info);
            $this->display('tladd');
        }
        
    	
    }
    /**
     * 美景贴图
     * @return [type] [description]
     */
    public function travel(){
        $model=M('news');
        $map['status'] = array('neq',2);
        $map['type'] = array('eq',1);
        $count=$model->field('count(id) as count')->where($map)->count();
        $page=new Util\Page($count,10);
        $show=$page->show();
        $this->assign('_page',$show);
        $list=$model->field('id,title,news_sort_id,sort,stick,insert_time,publisher,status')->where($map)->limit($page->firstRow.','.$page->listRows)->order('sort,insert_time desc')->select();
        
        // foreach ($list as $key=>$val) {
        //     $sorts_name = get_table_field($val['news_sort_id'],'id','name','news_sort');
        //     $list[$key]['news_sort_name'] = $sorts_name;
        // }
        $msg=array('status'=>array('1'=>'启用','0'=>'禁用'));
        int_to_string($list,$msg);
        $this->assign('_list',$list);
        $this->display();
    }
    
    /**
     *文章状态修改
     * @param unknown_type $method
     */
    public function infor_changeStatus($method=null){
        $id = array_unique((array)I('id',0));
        $id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        switch ( strtolower($method) ){
            case 'forbiduser':
                if(I('get.type') and I('get.type') == 'nt'){
                    $this->forbid('news_sort', array('id'=>array('in',$id)) );
                }else{
                    $this->forbid('News', array('id'=>array('in',$id)) );
                }
                
                break;
            case 'resumeuser':
                if(I('get.type') and I('get.type') == 'nt'){
                    $this->resume('news_sort', array('id'=>array('in',$id)) );
                }else{
                    $this->resume('News', array('id'=>array('in',$id)) );
                }
                break;
            case 'deleteuser':
                if(I('get.type') and I('get.type') == 'nt'){
                    $this->delete('news_sort', array('id'=>array('in',$id)) );
                }else{
                    $this->delete('News', array('id'=>array('in',$id)) );
                }
                break;
            case 'falsestatus':
                if(I('get.type') and I('get.type') == 'nt'){
                    $this->falsestatus('news_sort', array('id'=>array('in',$id)) );
                }else{
                    $this->falsestatus('News', array('id'=>array('in',$id)) );
                }
                break;
            default:
                $this->error('参数非法');
        }
    }
    
}