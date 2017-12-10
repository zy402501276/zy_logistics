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
        //output(0, $orderList);
        echo json_encode(array('status'=>0,'msg'=>'获取订单列表成功','orders'=>$orderList));exit;
    }


    /**
     * 司机查看自己所接的正在进行的订单
     * @author zhangye
     * @time 2017年12月4日00:00:13
     */
    public function driveringOrderList()
    {
        $cur_page = I('cur_page', 1);
        $page_num = I('page_num', 1);
        $driver = session('user');
        if(empty($driver)){
            output(-1, '', '请重新登录');

        }
        $model = D('Order');
        $where['orderState'] = array('neq',$model::ORDER_STATE_FINISH);
        $where['driverId'] = $driver['id'];
        $result = $model->where($where)->select();
        $orderList = array();
        foreach ($result as $key => $value){
            $orderList[] = $model->getOrderInfo($value['id']);
        }
        //output(0, $orderList);
        echo json_encode(array('status'=>0,'msg'=>'获取列表成功','orders'=>$orderList));exit;
    }
    /**
     * 司机查看自己所接的正在进行的订单
     * @author zhangye
     * @time 2017年12月4日00:00:13
     */
    public function driverFinishOrderList()
    {
        $cur_page = I('cur_page', 1);
        $page_num = I('page_num', 1);
        $driver = session('user');
        if(empty($driver)){
            output(-1, '', '请重新登录');

        }

        $model = D('Order');
        $where['orderState'] = array('eq',$model::ORDER_STATE_FINISH);
        $where['driverId'] = $driver['id'];
        $result = $model->where($where)->select();
        $orderList = array();
        foreach ($result as $key => $value){
            $orderList[] = $model->getOrderInfo($value['id']);
        }
        //output(0, $orderList);
        echo json_encode(array('status'=>0,'msg'=>'获取列表成功','orders'=>$orderList));exit;
    }

    /**
     * 申请接单
     * @author: zy
     */
    public function newOrder(){
        $orderId = I('orderid');
        if(empty($orderId)){
            output(-1, '', '没有传订单id');
        }
        $orderModel = D('Order');
        $order = $orderModel->where("orderNum = '$orderId'")->find();
        if(empty($order)){
            output(-1, '', '该订单不存在');
        }
        $service = D('Order','Service');
        $result = $service->distributeOrder($orderId);
        if(!$result['state']){
            output(-1, '', $result['message']);
        }
        echo json_encode(array('status'=>0,'msg'=>"接单成功",'orderid'=>$orderId));exit;
    }

    /**
     * 报告司机位置
     * @time 2017年12月4日14:42:20
     * @author zhangye
     */
    public function location(){

        $lat = I('lat');
        $lng = I('lng');
        if(empty($lat) || empty($lng)){
            output(-1, '', '经纬度丢失');
        }
        $driver = session('user');
        if(empty($driver)){
            output(-1, '', '请重新登录');

        }
        $model = M('driveraddress');
        $where['driverId'] = $driver['id'];
        $result = $model->where($where)->find();
        if(empty($result)){
            $model->longitude = $lng;
            $model->latitude = $lng;
            $model->driverId = $driver['id'];
            $model->createTime = time();
            $model->add();
            exit;
        }
        $model->longitude = $lng;
        $model->latitude = $lat;
        $model->createTime = time();
        $model->save();
        exit;
    }


    /**
     * 开始装货
     * @time 2017年12月4日15:45:01
     */
    public function startOrder(){
        $orderid = I('orderid');
        if(empty($orderid)){
            output(-1, '', 'id为空');
        }
        $model = D('order');
        //$model->orderState = $model::ORDER_STATE_GOTOLOADING;//前往装货
       // $data['orderState'] = $model::ORDER_STATE_GOTOLOADING;
        $data['orderState'] = $model::ORDER_STATE_PHOTO; //状态3
        $data['updateTime'] = time();
       // $model->updateTime = time();
        $model->where("orderNum='$orderid'")->save($data);
        echo json_encode(array('status'=>0,'msg'=>"",'orderid'=>$orderid));exit;

    }

    /**
     * 装货完成
     * @time 2017年12月4日16:10:24
     */
    public function endOrder(){
        $orderid = I('orderid');
        if(empty($orderid)){
            output(-1, '', 'id为空');
        }
        $model = D('order');
        //$model->orderState = $model::ORDER_STATE_PHOTO;//装货并拍照
        //$data['orderState'] = $model::ORDER_STATE_PHOTO;
        $data['orderState'] = $model::ORDER_STATE_CONFIRM; //状态4
        $data['updateTime'] = time();
        //$model->updateTime = time();
        $model->where("orderNum='$orderid'")->save($data);
        
        $order = $model->where("orderNum='$orderid'")->find();
        $imgModel = M('orderimg');
        $data = array();
        if(isset($_REQUEST['img1'])){
            $data[] = array('img' => $_REQUEST['img1'],'type'=>1,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(isset($_REQUEST['img2'])){
            $data[] = array('img' => $_REQUEST['img2'],'type'=>1,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(isset($_REQUEST['img3'])){
            $data[] = array('img' => $_REQUEST['img3'],'type'=>1,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(isset($_REQUEST['simg'])){//签名图
            $data[] = array('img' => $_REQUEST['simg'],'type'=>3,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(empty($data)){
            output(-1, '', '请拍摄照片并上传');
        }
        $imgModel->addAll($data);

        echo json_encode(array('status'=>0,'msg'=>"",'orderid'=>$orderid));exit;
    }

    /**
     * 装货完成并且确认
     * @time 2017年12月4日16:33:38
     */
    public function confirmOrder(){
        $orderid = I('orderid');
        if(empty($orderid)){
            output(-1, '', 'id为空');
        }
        $model = D('order');
        //$model->orderState = $model::ORDER_STATE_CONFIRM;//完成确认
//        $data['orderState'] = $model::ORDER_STATE_CONFIRM;
//        $data['updateTime'] = time();
       // $model->updateTime = time();
        $result = $model->where("orderNum='$orderid'")->find();
        if($result['orderstate'] == $model::DOWNORDER_STATE_START){
            echo json_encode(array('status'=>0,'msg'=>"",'orderid'=>$orderid,'type'=>$model::DOWNORDER_STATE_START));exit;
        }else{
            output(-1, '', '订单还没有被确认');
        }

    }

    /**
     * 开始卸货
     * @time 2017年12月4日16:33:38
     */
    public function downstartOrder(){
        $orderid = I('orderid');
        if(empty($orderid)){
            output(-1, '', 'id为空');
        }
        $model = D('order');
        $data['orderState'] = $model::DOWNORDER_STATE_FINISH;
        $data['updateTime'] = time();
//        $model->orderState = $model::DOWNORDER_STATE_START;//开始卸货
//        $model->updateTime = time();
        $model->where("orderNum='$orderid'")->save($data);
        echo json_encode(array('status'=>0,'msg'=>"",'orderid'=>$orderid,'type'=>$model::DOWNORDER_STATE_FINISH));exit;
    }
    /**
     * 卸货完成
     * @time 2017年12月4日16:10:24
     */
    public function downendOrder(){
        $orderid = I('orderid');
        if(empty($orderid)){
            output(-1, '', 'id为空');
        }
        $model = D('order');
        $data['orderState'] = $model::DOWNORDER_STATE_CONFIRM;
        $data['updateTime'] = time();
//        $model->orderState = $model::DOWNORDER_STATE_START;//卸货完成并拍照
//        $model->updateTime = time();
        $model->where("orderNum='$orderid'")->save($data);

        $order = $model->where("orderNum='$orderid'")->find();
        $imgModel = M('orderimg');
        $data = array();
        if(isset($_REQUEST['img1'])){
            $data[] = array('img' => $_REQUEST['img1'],'type'=>2,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(isset($_REQUEST['img2'])){
            $data[] = array('img' => $_REQUEST['img2'],'type'=>2,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(isset($_REQUEST['img3'])){
            $data[] = array('img' => $_REQUEST['img3'],'type'=>2,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(isset($_REQUEST['simg'])){ //签名图
            $data[] = array('img' => $_REQUEST['simg'],'type'=>4,'orderid'=>$order['id'],'createTime'=>time());
        }
        if(empty($data)){
            output(-1, '', '请拍摄照片并上传');
        }
        $imgModel->addAll($data);

        echo json_encode(array('status'=>0,'msg'=>"",'orderid'=>$orderid,'type'=>$model::DOWNORDER_STATE_CONFIRM));exit;
    }

    /**
     * 卸货完成并且确认
     * @time 2017年12月4日16:33:38
     */
    public function downconfirmOrder(){
        $orderid = I('orderid');
        if(empty($orderid)){
            output(-1, '', 'id为空');
        }
        $model = D('order');
       // $data['orderState'] = $model::DOWNORDER_STATE_CONFIRM;
//        $data['updateTime'] = time();
//        $model->orderState = $model::DOWNORDER_STATE_CONFIRM;//卸货完成并且确认
//        $model->updateTime = time();
        $result = $model->where("orderNum='$orderid'")->find();
        if($result['orderstate'] == $model::ORDER_STATE_FINISH){
            echo json_encode(array('status'=>0,'msg'=>"",'orderid'=>$orderid,'type'=>$model::ORDER_STATE_FINISH));exit;
        }else{
            output(-1, '', '订单还没有被确认');
        }
    }

}