<?php
/**
 * API--用户模块接口
 * @time 2017年11月30日23:25:18
 * @author zhangye
 */
namespace Api\Controller;
use Think\Controller;
class UserController extends Controller{

    /**
     * 用户注册
     * @author: zy
     */
    public function doregister(){
        $service = D('User','Service');
        $res = $service->register();
        var_dump($res);
    }
}