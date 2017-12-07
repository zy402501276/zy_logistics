<?php
// +----------------------------------------------------------------------
// | wuliu.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yoursite.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <597852546@qq.com> <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Model;
/**
 * 订单模型
 */
class OrderModel extends BaseModel
{

    /**
     * 根据订单状态获取用户所有的订单
     * @author: zy
     * @param $userId  int user表主键
     * @param $orderState int  1 未处理 2 中间各种状态 8 订单已完成
     */

    public function getOrderList($userId,$orderState){
        if($orderState == 2){
            $where['orderState'] = array('not in','1,8');
        }else{
            $where['orderState'] = $orderState;
        }
        $where['userId'] = $userId;
        $result = $this
        //          ->JOIN("LEFT JOIN `ordergoods` ON `order`.id = `ordergoods`.orderId")
         //         ->JOIN("LEFT JOIN `ordercharger` ON `order`.id = `ordercharger`.orderId")
                  ->WHERE($where)
                  ->select();
        $array = [];
        foreach ( $result as $key => $value) {
            $loader   = D('OrderCharger')->getLoader($value['id'],1); //获取装货人信息
            $unloader = D('OrderCharger')->getLoader($value['id'],2);//获取卸货人信息
            $goodsInfo = D('OrderGoods')->getGoodsInfo($value['id']);//货物数量重量
            $goodsType =  D('OrderGoods')->getGoodsType($value['id']);//货物类型

            $array[] = ['id'          => $value['id'],
                        'createTime' => date('Y-m-d',$value['createtime']),
                        'orderNum'   => $value['ordernum'],
                        'depart'      => getCity($loader['area']),
                        'dest'        => getCity($unloader['area']),
                        'startTime'   => date('Y-m-d',$loader['endtime']),
                        'startTimeDay'=> getWeek($loader['endtime']),
                        'endTime'     => date('Y-m-d',$unloader['starttime']),
                        'endTimeDay'  => getWeek($unloader['starttime']),
                        'loadTime'    => date('H:i',$loader['starttime']),
                        'loadTimeH'   =>'预计装货'.getCostTime($loader['starttime'],$loader['endtime']),
                        'unloadTime'  => date('H:i',$unloader['starttime']),
                        'unloadTime'  =>'预计卸货'.getCostTime($unloader['starttime'],$unloader['endtime']),
                        'num'          => $goodsInfo['sum(count)'],
                        'weight'       => $goodsInfo['sum(goodsweight)'],
                        'goodsType'    => $goodsType,
                        'cost'          => $value['sumprice'],
                       ];
        }
        return $array;
    }


    /**
     * 根据订单id获取订单详情
     * @author: zy
     * @param $ordeId int order表主键
     */

    public function getOrderInfo($orderId){
        $model = $this->find($orderId);
        if(empty($model)){
            return ['state'=>false,'message'=>'订单不存在'];
        }
        $orderArr = [
                'orderType' => $this->orderTypeArr($model['ordertype']), //货物类型
                'transType' => $this->transTypeArr($model['transtype']),//运输类型
                'vehicleType' => $this->vehicleTypeArr($model['vehicletype']),//车辆类型
                'loadRate'  => $model['loadrate'],//装货率
                'sumPrice'  => $model['sumprice'],//总费用
                'orderNum'  => $model['ordernum'],//订单号
                'driverId' => $model['driverid'],//司机id
                'createTime'=> $model['createtime'],//创建时间
                'distributeTime' => $model['distributetime'],//接单时间
                ];
        return ['state'=>true,'result'=>$orderArr];
    }

    /**
     * 获取货物类型
     * @time 2017年12月1日14:00:45
     * @author zhangye
     */
    private function orderTypeArr($type = '', $echoString = false){
        $array = array(
            ORDER_NORMAL => '标准货物',
            ORDER_ABNORMAL => '非标准货物',
        );
        return getState($array, $type, $echoString);
    }
    /**
     * 获取运输类型
     * @time 2017年12月1日14:00:45
     * @author zhangye
     */
    private function transTypeArr($type = '', $echoString = false){
        $array = array(
            TRANS_NORMAL => '正常模式',
            TRANS_CARPOOL => '拼车模式',
        );
        return getState($array, $type, $echoString);
    }
    /**
     * 获取车辆类型
     * @time 2017年12月1日14:00:45
     * @author zhangye
     */
    private function vehicleTypeArr($type = '', $echoString = false){
        $array = array(
            VEHICLE_VOL => '重量体积',
            VEHICLE_RENT => '包车',
        );
        return getState($array, $type, $echoString);
    }

}