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
}