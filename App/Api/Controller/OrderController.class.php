<?php
/**
 * API--订单模块接口
 * @time 2017年11月30日23:25:18
 * @author zhangye
 */
namespace Api\Controller;
use Think\Controller;
class OrderController extends Controller
{

    /**
     * 获取货物信息
     * @time 2017年11月30日23:25:45
     * @author: zy
     */
    public function getGoods()
    {
        $id = I('id'); //货物ID;
        if (empty($id)) {
            output(-1, '', '没有传货物id');
        }
        $model = D('OrderGoods');
        $res = $model->findGoodsByPk($id);
        output(0, $res);
    }


    /**
     * 获取待接单列表
     * @author zhangye
     * @time 2017年12月4日00:00:13
     */
    public function orderList()
    {
        $cur_page = I('cur_page', 1);
        $page_num = I('page_num', 1);

        $model = D('Order');
        $result = $model->where(['orderState'=>$model::ORDER_STATE_PUBLISH])->select();
        $orderList = array();
        foreach ($result as $key => $value){
            $orderList[] = $model->getOrderInfo($value['id']);
        }
        var_dump($orderList);
    }

    /**
     * 申请接单
     * @author: zy
     */
    public function newOrder(){

    }
}