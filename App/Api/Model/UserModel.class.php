<?php
namespace Api\Model;
use Think\Model;

/**
 * 用户模块model类
 * @author zhangye
 * @time 2017年12月1日14:13:50
 */
class UserModel extends Model{

    /**
     * 登录验证
     * @author: zy
     * @param $userName
     * @param $password
     */
    public function login($userName,$password){
        $where['userName'] = $userName;
        $where['pwd'] = md5($password.'yunpeihuo1234567');
        $result = $this->where($where)->find();
        if(empty($result)){
            return array('state'=>0,'message'=>'账号或者密码错误');
        }
        return array('state'=>1,'result'=>$result);
    }
}