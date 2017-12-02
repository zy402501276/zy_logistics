<?php
/**
 * API--订单模块接口
 * @time 2017年11月30日23:25:18
 * @author zhangye
 */
namespace Api\Controller;
use Think\Controller;
class OrderController extends Controller{

    /**
     * 获取货物信息
     * @time 2017年11月30日23:25:45
     * @author: zy
     */
    public function getGoods(){
        $id = I('id'); //货物ID;
        if(empty($id)){
            output(-1,'','没有传货物id');
        }
        $model = D('OrderGoods');
        $res = $model->findGoodsByPk($id);
        output(0,$res);
    }

    /**
     * 订单详情
     * @time 2017年12月1日11:43:29
     * @author zhangye
     */
    public function orderInfo(){
        $orderId = I('id');//物流单id
        if(empty($orderId)){
            output(-1,'','没有传订单id');
        }
        $model = D('Order');
        $model->getOrderInfo(1);
    }
}