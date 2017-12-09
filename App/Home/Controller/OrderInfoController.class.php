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
        // 实例模型[订单照片信息表]
        $this->model_order_img   = D('OrderImg');

        // ###本类调用
        // 实例模型[用户信息表]
        $this->model_user   = D('User');

        // ###本类调用
        // 实例模型[司机信息表]
        $this->model_driver  = D('DriverInfo');

        //判断该订单的状态是否可以进入下一个页面
        $orderId = I('id',3);
        $is_check = I('checkVal');//当前页的状态值
        $orderModel = $this->model_order->find($orderId);
        if($orderModel['orderstate'] <$is_check){
            $this->error('订单尚未进行该步骤！请稍后再试');
        }
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
        $this->assign("orderId",$orderId);//订单id
        $this->assign("orderState",$order['orderState']);//订单当前状态
        $this->assign("goods",$goods);
        $this->assign("goodsDetail",$goodsDetail);
        $this->assign("loader",$loader);
        $this->assign("unloader",$unloader);

        $this->display('orderInfo/wait');
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


        $driverInfo = $this->model_user->find($order['driverId']);//司机信息

        $this->assign("order",$order);
        $this->assign("orderId",$orderId);//订单id
        $this->assign("orderState",$order['orderState']);//订单当前状态
        $this->assign("goods",$goods);
        $this->assign("goodsDetail",$goodsDetail);
        $this->assign("loader",$loader);
        $this->assign("unloader",$unloader);
        $this->assign("driver",$driverInfo);

        $this->display('orderInfo/finish');
    }

    /**
     * 前往装货/卸货地
     * @author: zy
     */
    public function goArea(){
        $orderId = I('id',3);
        $type = I('type',1);//默认1，前往装货 2，前往卸货

        switch ($type){
            case 1:
                $loader = $this->model_order_charger->getLoader($orderId,CHARGER_LOAD);//获取装货人信息
                $loader['timeDay'] = date('m-d',$loader['starttime']).getWeek($loader['starttime']);//装货日期
                $loader['caculateTime'] = getCostTime($loader['starttime'],$loader['endtime']);//预计时间
                $title = '装货信息';
                break;
            case 2:
                $loader = $this->model_order_charger->getLoader($orderId,CHARGER_UNLOAD);//获取卸货人信息
                $loader['timeDay'] = date('m-d',$loader['starttime']).getWeek($loader['starttime']);//卸货日期
                $loader['caculateTime'] = getCostTime($loader['starttime'],$loader['endtime']);//预计时间
                $title = '卸货货信息';
                break;
        }
        $orderModel = $this->model_order->find($orderId);
        $driverInfo = $this->model_driver->getDriver($orderModel['driverid']); //司机信息
        $driverInfo['avatar'] = getImg($driverInfo['avatar']);

        $this->assign('title',$title);
        $this->assign("orderState",$orderModel['orderstate']);//订单当前状态
        $this->assign("orderId",$orderId);//订单id
        $this->assign('loader',$loader);
        $this->assign('driver',$driverInfo);
        $this->display('orderInfo/goArea');
    }

    /**
     * 确认装卸货
     * @author: zy
     */
    public function check(){
        $orderId = I('id',3);
        $type = I('type',2);//默认1，前往装货 2，前往卸货

        switch ($type){
            case 1:
                $loader = $this->model_order_charger->getLoader($orderId,CHARGER_LOAD);//获取装货人信息
                $loader['timeDay'] = date('m-d',$loader['starttime']).getWeek($loader['starttime']);//装货日期
                $loader['caculateTime'] = getCostTime($loader['starttime'],$loader['endtime']);//预计时间
                $title = '装货信息';
                break;
            case 2:
                $loader = $this->model_order_charger->getLoader($orderId,CHARGER_UNLOAD);//获取卸货人信息
                $loader['timeDay'] = date('m-d',$loader['starttime']).getWeek($loader['starttime']);//卸货日期
                $loader['caculateTime'] = getCostTime($loader['starttime'],$loader['endtime']);//预计时间
                $title = '卸货货信息';
                break;
        }
        $orderModel = $this->model_order->find($orderId);//订单信息

        $driverInfo = $this->model_driver->getDriver($orderModel['driverid']); //司机信息
        $driverInfo['avatar'] = getImg($driverInfo['avatar']);

        $goodsDetail = $this->model_order_goods->getGoodsInfo($orderId);//货物重量数量

        $imgArr = $this->model_order_img->getPhoto($orderId,$type);//获取照片

        $this->assign('type',$type);
        $this->assign('order',$orderModel);
        $this->assign('orderId',$orderId);//订单ID
        $this->assign("orderState",$orderModel['orderstate']);//订单当前状态
        $this->assign('title',$title);
        $this->assign('loader',$loader);
        $this->assign('driver',$driverInfo);
        $this->assign('goods',$goodsDetail);
        $this->assign('loadImg',$imgArr['loadImg']);
        $this->assign('signImg',$imgArr['signImg']);

        $this->display('orderInfo/check');
    }

    /*
     * 确认
     * @author zhangye
     */
    public function checkOrder(){
        $orderId = I('id',3);
        $type = I('type',2);//默认1，前往装货 2，前往卸货
        switch ($type){
            case 1:
                $data['orderState'] = 5;
                $data['updateTime'] =time();
                $data['id'] = $orderId;
                $flag = $this->model_order->saveOrUpdateData($data);
                if($flag){
                    $this->success('放行成功',U('orderInfo/goArea',['id'=>$orderId,'type'=>2]));
                }else{
                    $this->error('放行失败');
                }
                break;
            case 2:
                $data['orderState'] = 8;
                $data['updateTime'] =time();
                $data['id'] = $orderId;
                $flag = $this->model_order->saveOrUpdateData($data);
                if($flag){
                    $this->success('货主确认成功',U('orderInfo/finish',['id'=>$orderId]));
                }else{
                    $this->error('货主确认失败');
                }
                break;
        }
    }
}