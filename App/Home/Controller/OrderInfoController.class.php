<?php

/**
 * 订单详情模块控制器
 * @author zhangye
 * @time 2017年12月7日14:39:55
 */
namespace Home\Controller;
class OrderInfoController extends BaseController{
    //----------------------------------
    // 变量 - 成员变量
    //----------------------------------

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
    protected $model_order_goods   = NULL;


    /**
     * 模型对象[司机信息表]
     * @var $model
     */
    protected $model_user   = NULL;

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
        // 实例模型[货品信息表]
        $this->model_order_goods   = D('OrderGoods');

        // ###本类调用
        // 实例模型[用户信息表]
        $this->model_user   = D('User');


    }

    /**
     * 订单详情-等待接单页
     * @author: zy
     */
    public function wait(){
        $orderId = I('id',3);
        if(empty($orderId)) $this->error('订单id为空');
        $orderResult = $this->model_order->getOrderInfo($orderId);//获取运货车辆订单类型
        if(!$orderResult['state']){
            $this->error($orderResult['message']);
        }
        $order = $orderResult['result'];


        $goods = $this->model_order_goods->getGoodsById($orderId);//获取货物信息
        $goodsDetail = $this->model_order_goods->getGoodsInfo($orderId);//货物重量数量

        $loader = $this->model_order_charger->getLoader($orderId,CHARGER_LOAD);//获取装货人信息
        $loader['timeDay'] = date('m-d',$loader['starttime']).getWeek($loader['starttime']);//装货日期
        $loader['timeLoad'] = date("H:i",$loader['starttime']).'-'.date("H:i",$loader['endtime']);//装货时间

        $unloader = $this->model_order_charger->getLoader($orderId,CHARGER_UNLOAD);//获取卸货人信息
        $unloader['timeDay'] = date('m-d',$unloader['starttime']).getWeek($unloader['starttime']);//卸货日期
        $unloader['timeLoad'] = date("H:i",$unloader['starttime']).'-'.date("H:i",$unloader['endtime']);//卸货时间

        $this->assign("order",$order);
        $this->assign("goods",$goods);
        $this->assign("goodsDetail",$goodsDetail);
        $this->assign("loader",$loader);
        $this->assign("unloader",$unloader);

        $this->display();
    }

    /**
     * 订单详情-订单完成
     * @author zhangye
     */
    public function finish(){
        $orderId = I('id',3);
        if(empty($orderId)) $this->error('订单id为空');
        $orderResult = $this->model_order->getOrderInfo($orderId);//获取运货车辆订单类型
        if(!$orderResult['state']){
            $this->error($orderResult['message']);
        }
        $order = $orderResult['result'];


        $goods = $this->model_order_goods->getGoodsById($orderId);//获取货物信息
        $goodsDetail = $this->model_order_goods->getGoodsInfo($orderId);//货物重量数量

        $loader = $this->model_order_charger->getLoader($orderId,CHARGER_LOAD);//获取装货人信息
        $loader['timeDay'] = date('m-d',$loader['starttime']).getWeek($loader['starttime']);//装货日期
        $loader['timeLoad'] = date("H:i",$loader['starttime']).'-'.date("H:i",$loader['endtime']);//装货时间

        $unloader = $this->model_order_charger->getLoader($orderId,CHARGER_UNLOAD);//获取卸货人信息
        $unloader['timeDay'] = date('m-d',$unloader['starttime']).getWeek($unloader['starttime']);//卸货日期
        $unloader['timeLoad'] = date("H:i",$unloader['starttime']).'-'.date("H:i",$unloader['endtime']);//卸货时间


        $driverInfo = $this->model_user->find($order['driveId']);//司机信息

        $this->assign("order",$order);
        $this->assign("goods",$goods);
        $this->assign("goodsDetail",$goodsDetail);
        $this->assign("loader",$loader);
        $this->assign("unloader",$unloader);
        $this->assign("driver",$driverInfo);

        $this->display();
    }
}