<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;

use Think\Model;
use User\Api\UserApi;

/**
 * 文档基础模型
 */
class UCenterMemberModel extends Model
{

    protected $rules = array(
        array('newPwd', 'reNewPwd', '确认密码不一致！', 0, 'confirm'), // 验证确认密码是否和密码一致
        array('password', '6,15', '密码长度为6-15个字节！', self::EXISTS_VALIDATE, 'length'), //密码长度不合法
    );

    /* 用户模型自动完成 */
    protected $_auto = array(
        array('password', 'think_ucenter_md5', self::MODEL_BOTH, 'function', UC_AUTH_KEY),
        array('update_time', NOW_TIME, self::MODEL_BOTH)
    );

    /*
     * 修改密码
     */
    function editPwd($id, $newPwd = '', $reNewPwd = '')
    {
        $data['id'] = $id;
        $data['password'] = $newPwd;
        $data['newPwd'] = $newPwd;
        $data['reNewPwd'] = $reNewPwd;
        if (!$this->validate($this->rules)->create($data)) {
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            $this->error = $this->getError();
            return false;
        } else {
            return $this->save();
            // 验证通过 可以进行其他数据操作
        }
    }

    /*
     * 找回密码
     */
    function forgetPwd($mobile = '', $newPwd = '', $reNewPwd = '')
    {
        $map['mobile'] = $mobile;
        $data['password'] = $newPwd;
        $data['newPwd'] = $newPwd;
        $data['reNewPwd'] = $reNewPwd;
        if (!$this->validate($this->rules)->create($data)) {
            // 如果创建失败 表示验证没有通过 输出错误提示信息
            $this->error = $this->getError();
            return false;
        } else {
            return $this->where($map)->save();
            // 验证通过 可以进行其他数据操作
        }
    }

    /*
     * 找回密码
     */
    function saveData($map,$data)
    {
        return $this->where($map)->save($data);
    }
}
