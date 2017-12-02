<?php
namespace Api\Model;
use Think\Model;

/**
 * 订单表模型类
 * @author zhangye
 * @time    2017年12月1日13:26:48
 */
class OrderModel extends Model{

    /**
     * 订单类型-标准货物
     */
    CONST ORDER_NORMAL = 1;
    /**
     * 订单类型-非标准货物
     */
    CONST ORDER_ABNORMAL = 2;

    /**
     * 运输类型-正常
     */
    CONST TRANS_NORMAL = 1;
    /**
     * 运输类型-拼车
     */
    CONST TRANS_CARPOOL = 2;

    /**
     * 用车类型-重量体积
     */
    CONST VEHICLE_VOL = 1;
    /**
     * 用车类型-包车
     */
    CONST VEHICLE_RENT = 2;

    /**
     * 状态--正常
     */
    CONST STATE_ON = 1;
    /**
     * 状态--冻结
     */
    CONST STATE_OFF = 0;


    /**
     * 根据主键id查询
     * @author: zy
     * @param $id int  订单表主键id
     * @return array
     */
    public function getOrderInfo($id){
        $userModel  = D('User');
        $userInfo = $userModel->find(1);//用户信息

        $model = $this->find($id);//ORM方式查询订单
        $result = array();
        if(empty($model)){
            return $result;
        }
        $charger = D('OrderCharger');
        $loadTime = $charger->getTimes($model['id'],$charger::TYPE_LOAD);//装货时间 second
        $unloadTime = $charger->getTimes($model['id'],$charger::TYPE_UNLOAD);//卸货时间 second
        $loader = $charger->getLoader($model['id'],$charger::TYPE_LOAD);
        $unloader = $charger->getLoader($model['id'],$charger::TYPE_UNLOAD);

        $result = array(
                    'orderid'    => $model['ordernum'],//订单号
                    'status'     => intval($model['orderstate']),//订单状态
                    'price'      => intval($model['sumprice']),//费用
                    'master'     => array($userInfo['userName'],$userInfo['mobile']),//货主信息
                    'cargo_type' => intval($model['orderType']),//货物类型
                    'rent_type'  => intval($model['vehicleType']),//用车类型
                    'lct_depart' => json_encode($model['departArea']),//出发地
                    'lct_dest'   => json_encode($model['destArea']),//目的地
                    'time'       => array($model['departTime'],$loadTime,$model['arrivedTime'],$unloadTime),//出发时间戳，装货时间，到达时间戳，卸货时间
                    'loader'     => array($loader['name'],$loader['mobile']),//装货人信息
                    'unloader'   => array($unloader['name'],$unloader['mobile']),//卸货人信息
                    'cargo'      =>'',//货物
                    'loadphoto'  => $loader['photo'],//装货照片
                    'loadsignature'  => $loader['signature'],//装货签名照
                    'unloadphoto'  => $unloader['photo'],//卸货照片
                    'unloadsignature'  => $unloader['signature'],//卸货签名照
                    );
    }

    /**
     * 获取订单类型
     * @time 2017年12月1日14:00:40
     * @author zhangye
     */
    public static function orderTypeArr($type = '', $echoString = false){
        $array = array(
                    SELF::ORDER_NORMAL => '标准货物',
                    SELF::ORDER_ABNORMAL => '非标准货物',
                );
        return getState($array, $type, $echoString);
    }
    /**
     * 获取运输类型
     * @time 2017年12月1日14:00:45
     * @author zhangye
     */
    public static function TransTypeArr($type = '', $echoString = false){
        $array = array(
            SELF::TRANS_NORMAL => '正常模式',
            SELF::TRANS_CARPOOL => '拼车模式',
        );
        return getState($array, $type, $echoString);
    }
    /**
     * 获取用车类型
     * @time 2017年12月1日14:00:45
     * @author zhangye
     */
    public static function VehicleTypeArr($type = '', $echoString = false){
        $array = array(
            SELF::VEHICLE_VOL => '重量体积',
            SELF::VEHICLE_RENT => '包车',
        );
        return getState($array, $type, $echoString);
    }
}