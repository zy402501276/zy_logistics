<?php

// +----------------------------------------------------------------------
// | wuliu.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yoursite.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Controller;
/**
 * 登录控制器
 */
class LoginController extends BaseController
{
    
    //----------------------------------
    // 变量 - 成员变量
    //----------------------------------

    /**
     * 模型对象[用户]
     * @var $model
     */
    protected $model_user   =  NULL;

    /**
     * 初始化
     * @return void
     * @author shigin <597852546@qq.com>
     */
    protected function _initialize() {
        // ###超类调用
        parent::_initialize();

        // ###本类调用
        // 实例模型[用户]
        $this->model_user = D('User');
    }

    /**
     * 登陆[首页]
     * @author shigin <63371896@qq.com>
     */
    public function index() 
    {   
        // ####关闭全局加载
        layout(false);

        // ###渲染界面
        $this->display('login/index');
    }

    /**
     * 处理登陆
     * @author shigin <63371896@qq.com>
     */
    public function login() 
    {
        // ###操作数据
        // 账号
        $userName     = I('userName', ' ', 'strval');
        // 密码
        $pwd          = I('pwd', '', 'strval');
        // ###处理逻辑
        // 判断用户帐号是否存在
        if (empty($userName)) {
            $this->error('用户名不能为空');
        }  elseif ($pwd === '') {
             $this->error('密码不能为空');
        } elseif (!$this->model_user->correct($userName, $pwd)) {
           $this->error('账号或密码错误');
        } else {
            $data = $this->model_user->getDetailByName($userName);
            // 判断数据有效性
            if ($data !== NULL) {
                // 用户名
                session('userName', $data['username']);
                // 昵称
                session('account', $data['account']);
                // 用户id
                session('userId', $data['id']);

                $this->success('登录成功', U('OrderList/lists'));
               
            } else {
                $this->error('登录异常');
            }
        }
    }

    /**
     * 处理登出
     * @author shigin <597852546@qq.com>
     */
    public function logout() {
        // 更新数据
        $this->updateLogoutTimeById(session('STAFF_ID'));
        // 清空SESSION
        $this->unsetSessions();
        // 跳转页面
        // $this->redirect('/');
    }
}