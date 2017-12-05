<?php
/**
 * 订单模块服务层
 * @time 2017年12月4日11:34:12
 * @author zhangye
 */
namespace Home\Service;
use Think\Exception;
use Think\Model;
class OrderService {
    /**
     * 新增订单
     * @author: zy
     * @param $data array 表单提交的数据
     */
    public function add($data){
        $model = new Model();
        try{
            $model->startTrans();

            $orderModel = D('Order'); //订单表
            $orderData['orderType'] = $data['orderType'];//订单类型
            $orderData['transType'] = $data['transType'];//运输类型
            $orderData['vehicleType'] = $data['vehicleType'];//用车类型
            $orderData['departArea'] = $data['departArea'];//出发地
            $orderData['destArea'] = $data['destArea'];//目的地
//            $orderData['departTime'] = strtotime($data['departTime']);//预估出发时间
//            $orderData['arrivedTime'] = strtotime($data['arrivedTime']) ;//预估到达时间
            $orderData['departTime'] = time();//预估出发时间
            $orderData['arrivedTime'] = time() ;//预估到达时间
            $result = $orderModel->orderValidate($orderData);
            if($result){
                $orderData['orderNum'] = generateOrderSn(); //订单号
                $orderData['orderState'] = $orderModel::ORDER_STATE_PUBLISH; //订单状态变更为发布中 1
                $orderData['state'] = $orderModel::STATE_ON;
                $orderData['createTime'] = $orderData['updateTime'] = time();
                //todo登入系统后加上userId以及费用的算法
                $orderId = $orderModel->add($orderData);
            }else{
                return array('state'=>false,'message'=>$result['message']);
            }

            $chargerModel = D('OrderCharger');

            //todo装货人信息
            $loadData['name'] = trim($data['loadName']);
            $loadData['mobile'] = trim($data['loadMobile']);
            $loadData['area'] = $data['departArea'];
            $loadData['address'] = $data['departAddress'];
            $loadData['address'] = $data['departAddress'];
            $loadData['address'] = $data['departAddress'];



            $model->commit();
        }catch (Exception $e){
        }
    }
}