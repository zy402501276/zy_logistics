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
 * 订单负责人模型类
 * @time 2017年12月1日14:54:26
 * @author zhangye
 */
class OrderChargerModel extends BaseModel
{
    /**
     * 负责人类型-装货
     */
    CONST TYPE_LOAD = '1';
    /**
     * 负责人类型-卸货
     */
    CONST TYPE_UNLOAD = '2';

    protected $tableName = "ordercharger";

    /**
     * 获取装卸货时长
     * @time 2017年12月1日14:55:48
     * @param $type int 1 装货  2 卸货
     * @param $orderId int 订单id
     */
    public function getTimes($orderId,$type){
        $where['orderId'] = $orderId;
        switch ($type){
            case 1 ://装货
                $where['type'] = 1;
            break;
            case 2 ://卸货
                $where['type'] = 2;
            break;

        }
        $obj = $this->where($where)->find();
        $times = intval($obj['endtime'])-intval($obj['starttime']);
        return $times;
    }

    /**
     * 获取装卸货人信息
     * @time 2017年12月1日15:17:553
     * @author zhangy
     */
    public function getLoader($orderId,$type){
        $where['orderId'] = $orderId;
        $where['type'] = $type;
        $result = $this->where($where)->find();
        if(!empty($result)){
            return $result;
        }else{
            return array();
        }
    }
}