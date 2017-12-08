<?php
namespace Home\Model;

/**
 * 用户模块model类
 * @author zhangye
 * @time 2017年12月1日14:13:50
 */
class UserModel extends BaseModel{
    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;

    /**
     * 用户密码生成规则
     */
    CONST PWD_KEY ='yunpeihuo1234567';

    /**
     * 登录验证
     * @author: zy
     * @param $userName
     * @param $password
     */
    public function correct($userName, $password) 
    {
        $where['userName'] = $userName;
        $where['pwd'] = md5($password.'yunpeihuo1234567');
        return $this->where($where)->count();
    }

    /**
     * 根据用户名获取数据
     * @param string 用户名
     * @author shigin <597852546@qq.com>
     */
    public function getDetailByName($name)
    {
        return $this->where(['userName' => $name])->find();
    }
}