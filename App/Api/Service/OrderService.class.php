<?php
/**
 * 订单模块服务层
 * @time 2017年12月4日11:34:12
 * @author zhangye
 */
namespace Api\Service;
use Think\Model;
class OrderService extends Model{

    /**
     * 司机接单
     * @author: zy
     * @param $post array 原始数据
     * @return array
     */
    public function distributeOrder($orderId){
        try{
            $driver = session('user');
            if(empty($driver)){
                return array('state'=>false,'message'=>'请重新登录');
            }

            $orderInfo = D('Order')->where("orderNum = $orderId")->find();

            //todo判断该订单是否与之前接的单子时间冲突
            $where['driverId'] = $driver['id'];
            $where['arrivedTime'] = array('egt',$orderInfo['departtime']);
            $isConfilct = D('Order')->where($where)->select();
            if(!empty($isConfilct)){
                return array('state'=>false,'message'=>'请先完成之前的订单');
            }
            $order = D('Order');
//            $order->driverId = $driver['id'];
            $data['driverId'] = $driver['id'];//司机ID
            $data['updateTime'] = time();
            $data['distributeTime'] = time(); //司机接单时间
            $data['orderState'] = 2;  //状态改为前往装货
//            $order->orderState = ORDER_STATE_GOTOLOADING;//状态改为前往装货
//            $order->updateTime = time();
            $order->where("orderNum=$orderId")->save($data);
            return array('state'=> true);

        }catch (Exception $e){
            return ['state' => false ,'message'=>$e->getMessage()];
        }
    }
}