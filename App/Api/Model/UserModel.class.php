<?php
namespace Api\Model;
use Think\Model;

/**
 * 用户模块model类
 * @author zhangye
 * @time 2017年12月1日14:13:50
 */
class UserModel extends Model{

    protected $_validate = array(
        array('userName','require','请输入用户名',1,'unique',3),//用户名在新增修改的时候必须为唯一值
        array('pwd','8,16','请输入密码',1,'length',3),//密码必须为8-16位的
        array('account','checkAccount','账户名不能含有特殊字符',1,'function'),//验证账户是否有特殊字符
    );

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

    /**
     * 账户名验证是否有特殊符号
     * @author: zy
     * @param $arg
     */
    public function checkAccount($arg){
        $res= preg_match('/[^0-9a-zA-Z一-龥]/u', $arg);
        if($res){
            return true;
        }
        return false;
    }
}