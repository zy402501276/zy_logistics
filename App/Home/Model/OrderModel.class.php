<?php
namespace Home\Model;
use Think\Model;
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
     * 新增订单字段验证
     * @author: zy
     * @param $data
     */
    public function orderValidate($data){
        if(empty($data['departArea'])){
            return array('state'=>false,'message'=>'请选择出发地');
        }
        if(empty($data['destArea'])){
            return array('state'=>false,'message'=>'请选择目的地');
        }
        if(empty($data['departArea'])){
            return array('state'=>false,'message'=>'请选择出发地');
        }
        if(empty($data['departTime'])){
            return array('state'=>false,'message'=>'请选择出发时间');
        }
        if(empty($data['arrivedTime'])){
            return array('state'=>false,'message'=>'请选择到货时间');
        }
        return true;
    }
}