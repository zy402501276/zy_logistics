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
     * 订单状态-发布中
     */
    CONST ORDER_STATE_PUBLISH = 1;
    /**
     * 订单状态-前往装货
     */
    CONST ORDER_STATE_GOTOLOADING = 2;
    /**
     * 订单状态-装货并拍照
     */
    CONST ORDER_STATE_PHOTO = 3;
    /**
     * 订单状态-装货完成并且确认
     */
    CONST ORDER_STATE_CONFIRM = 4;
    /**
     * 订单状态-开始卸货
     */
    CONST DOWNORDER_STATE_START = 5;
    /**
     * 订单状态-卸货完成
     */
    CONST DOWNORDER_STATE_FINISH = 6;
    /**
     * 订单状态-卸货完成并且缺
     */
    CONST DOWNORDER_STATE_CONFIRM = 7;
    /**
     * 订单状态-完成
     */
    CONST ORDER_STATE_FINISH = 8;

    /**
     * 根据主键id查询
     * @author: zy
     * @param $id int  订单表主键id
     * @param $type  int 1,根据主键id查询，2根据orderNum查询
     * @return array
     */
    public function getOrderInfo($id,$type = 1){
        if($type == 1){
            $model = $this->find($id);//ORM方式查询订单
        }elseif($type == 2){
            $model = $this->where(array('orderNum'=>$id))->find();
        }
        $result = array();
        if(empty($model)){
            return $result;
        }
        $userModel  = D('User');
        $userInfo = $userModel->find($model['userId']);//用户信息

        $charger = D('OrderCharger');
        $loadTime = $charger->getTimes($model['id'],$charger::TYPE_LOAD);//装货时间 second
        $unloadTime = $charger->getTimes($model['id'],$charger::TYPE_UNLOAD);//卸货时间 second
        $loader = $charger->getLoader($model['id'],$charger::TYPE_LOAD);//装货人信息
        $unloader = $charger->getLoader($model['id'],$charger::TYPE_UNLOAD);//卸货人信息

        $lct_depart = array('region'=>$this->explodeArea($loader['area']),'detail'=>$loader['address'],'coords'=>array($loader['longitude'],$loader['latitude']));//出发地
        $lct_dest =  array('region'=>$this->explodeArea($unloader['area']),'detail'=>$unloader['address'],'coords'=>array($unloader['longitude'],$unloader['latitude']));//终点

        $goodsModel = D('OrderGoods');
        $goodsInfo = $goodsModel->findByOrderId($model['id']);


        $loadImg = $this->getImg($id,1);
        $signatureImg = $this->getImg($id,3);
        $unloadImg = $this->getImg($id,2);
        $unsignatureImg = $this->getImg($id,4);


        $result = array(
                    'orderid'    => $model['ordernum'],//订单号
                    'status'     => intval($model['orderstate']),//订单状态
                    'price'      => intval($model['sumprice']),//费用
                    'master'     => array($userInfo['account'],$userInfo['mobile']),//货主信息
                    'cargo_type' => intval($model['ordertype']),//货物类型
                    'rent_type'  => intval($model['vehicletype']),//用车类型
                    'lct_depart' => $lct_depart,//出发地
                    'lct_dest'   => $lct_dest,//目的地
                   // 'times'       => array(intval($model['departtime']),$loadTime,intval($model['arrivedtime']),$unloadTime),//出发时间戳，装货时间，到达时间戳，卸货时间
                    'times'       => array($loader['starttime'],$loadTime,$unloader['starttime'],$unloadTime),//出发时间戳，装货时间，到达时间戳，卸货时间
                    'loader'     => array($loader['name'],$loader['mobile']),//装货人信息
                    'unloader'   => array($unloader['name'],$unloader['mobile']),//卸货人信息
                    'cargo'      => $goodsInfo,//货物
                    'loadphoto'  => $loadImg,//装货照片
                    'loadsignature' => $signatureImg,//装货签名照
                    'unloadphoto' => $unloadImg,//卸货照片
                    'unloadsignature' => $unsignatureImg,//卸货签名照
                    );
        return $result;
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
    /**
     * 分割地区
     */
    private function explodeArea($string){
        $array = explode("  ",$string);
        return $array;
    }

    /**
     * 获取图片
     * @param $orderId
     * @param $type
     * @return array
     */
    private function getImg($orderId,$type){
        $model = M('orderimg');
        $where['type'] = $type ;
        $where['orderid'] = $orderId;
        $result = $model->where($where)->select();
        $array = array();
        if(!empty($result)){
            foreach ($result as $key => $value){
                $array[] = $value['img'];
            }
        }
        return $array;
    }

}