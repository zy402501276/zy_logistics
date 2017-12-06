<?php
/**
 * 订单列表控制器
 * @author zhangy
 * @time 2017年12月6日20:40:08
 */
namespace Home\Controller;
class OrderListController extends BaseController{
    //----------------------------------
    // 变量 - 成员变量
    //----------------------------------

    /**
     * 用户信息
     */
    public $userInfo = NULL;

    /**
     * 模型对象[订单]
     * @var $model
     */
    protected $model_order         =  NULL;

    /**
     * 引用对象[下单用户信息表]
     * @var $model
     */
    protected $model_order_charger = NULL;

    /**
     * 引用对象[下单货物信息表]
     * @var $model
     */
    protected $model_order_goods = NULL;

    /**
     * 初始化
     * @return void
     * @author shigin <597852546@qq.com>
     */
    protected function _initialize() {
        // ###超类调用
        parent::_initialize();

        // ###本类调用
        // 实例模型[订单]
        $this->model_order         = D('Order');

        // ###本类调用
        // 实例模型[下单用户信息表]
        $this->model_order_charger = D('OrderCharger');

        // ###本类调用
        // 实例模型[下单货物信息表]
        $this->model_order_charger = D('OrderGoods');

        //###登录信息赋值
        //$this->userInfo = session('user');
        $this->userInfo =  ['id'=>1];
    }

    public function lists(){
        $orderState = I('orderState',1);
        $userInfo = $this->userInfo;
        $result = $this->model_order->getOrderList($userInfo['id'],$orderState);
        $this->assign('list',$result);
        $this->assign('state',$orderState);
        $this->display();
    }

}