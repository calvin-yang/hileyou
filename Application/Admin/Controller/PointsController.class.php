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

class PointsController extends AdminController {
	public function index(){
		$this->display();
	}
	public function set_up(){
		$this->display();
	}
	public function uslist(){
		$model = M();
		$sql = "select a.*,b.mobile from ".C("DB_PREFIX")."score_member_log a,".C("DB_PREFIX")."member b where a.uid = b.uid order by id desc";
		$list = $model->query($sql);
		$this->assign("_list",$list);
		$this->display();
	}
	public function usdelete(){
		$id = array_unique((array)I('id',0));
		$id = is_array($id) ? implode(',',$id) : $id;
        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }
        $map['id'] = array('in',$id);
		if(M('score_member_log')->where($map)->delete()){

            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
	}
}
