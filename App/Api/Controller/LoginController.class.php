<?php
namespace Api\Controller;
use Think\Controller;

/**
 * 手机端用户登录模块控制器
 * @author zhangye
 * @time 2017年12月1日22:57:16
 */
class LoginController extends Controller{
    /**
     * 登录
     * @author: zy
     */
    public function login(){
        $userName = I('username');
        $password = I('password');
        $code     = I('code');
        $role     = I('role');
        $m        = I('m',1);
        $ip       = I('ip');
        $mac      = I('mac');
        $user = session('user');
        if(isset($user) && !empty($user)){
            echo json_encode(array('status'=>0,'msg'=>'登录成功','login_name'=>$user['account']));exit;
        }
        $user = D('User');
        $res = $user->login($userName,$password);
        if(!$res['state']){
            output(-1,'',$res['message']);
        }
        session(array('id','expire'=>'60'));//session_id和过期时间
        session('user',$res['result']);
        echo json_encode(array('status'=>0,'msg'=>'登录成功','login_name'=>$res['result']['account']));exit;
    }

    /**
     * 登出
     * @author: zy
     */
    public function logout(){
        session(null);
        output(0,'','退出成功');
    }

}