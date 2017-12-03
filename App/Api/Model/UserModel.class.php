<?php
namespace Api\Model;
use Think\Model;

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
     * 用户注册修改资料验证
     * @time 2017年12月3日21:29:02
     * @author zhangye
     */
    public function userValidate($data){
        if(isset($data['userName'])){  //验证用户名
            if(preg_match('/[^0-9a-zA-Z]/u', $data['userName'])){ //正则验证中文或特殊字符
                return array('state'=>false,'msg'=>'用户名只能为数字或者英文的组合');
            }
            if(strlen($data['userName'])<6 ||strlen($data['userName'])>18){ //字数长度限制
                return array('state'=>false,'msg'=>'用户名长度在6-18个字数之间');
            }
            $where['userName'] = trim($data['userName']);
            $checkUnique = $this->where($where)->select();
            if($checkUnique){
                return array('state'=>false,'msg'=>'该用户名已存在');
            }
        }else{
            return array('state'=>false,'msg'=>'请输入用户名');
        }

        if(isset($data['account'])){ //账户验证
            if(preg_match('/[^0-9a-zA-Z一-龥]/u', $data['account'])){ //正则验证特殊字符
                return array('state'=>false,'msg'=>'账户名不能含有特殊字符');
            }
        }else{
            return array('state'=>false,'msg'=>'请输入账户名');
        }

        if(isset($data['pwd'])){ //密码验证
            if(strlen($data['pwd'])<6 ||strlen($data['pwd'])>18){ //密码长度
                return array('state'=>false,'msg'=>'密码长度在6-18个字数之间');
            }
        }else{
            return array('state'=>false,'msg'=>'请输入账户名');
        }

        if(isset($data['email'])){ //验证邮箱
            if(!preg_match( "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $data['email'])){ //正则验证特殊字符
                return array('state'=>false,'msg'=>'邮箱不合法');
            }
        }
        if(isset($data['mobile'])){ //账户验证
            if(preg_match('/[^0-9]/u', $data['mobile'])){ //正则验证电话
                return array('state'=>false,'msg'=>'电话号码不正确');
            }
        }else{
            return array('state'=>false,'msg'=>'请输入账户名');
        }
        return array('state'=>true);
    }

}