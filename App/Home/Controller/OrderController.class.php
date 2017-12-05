<?php

// +----------------------------------------------------------------------
// | wuliu.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yoursite.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangy  <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Controller;
/**
 * 订单模块控制器
 * @author zhangy
 * @time 2017年12月5日21:08:50
 */
class OrderController extends BaseController
{
    
    //----------------------------------
    // 变量 - 成员变量
    //----------------------------------

    /**
     * 模型对象[订单]
     * @var $model
     */
    protected $model_order         =  NULL;

    /**
     * 引用对象[下单用户信息表]
     * @var $model
     */
    protected $model_order_charger = NULL;

    /**
     * 初始化
     * @return void
     * @author shigin <597852546@qq.com>
     */
    protected function _initialize() {
        // ###超类调用
        parent::_initialize();

        // ###本类调用
        // 实例模型[订单]
        $this->model_order         = D('Order');

        // ###本类调用
        // 实例模型[下单用户信息表]
        $this->model_order_charger = D('OrderCharger');

    }

    /**
     * 保存订单
     * @author: zy
     */
    public function save()
    {    
        // ###操作数据
        // 订单信息
        // 订单类型
        $orderType   = I('orderType', '', 'intval');
        // 运输类型
        $transType   = I('transType', '', 'intval');
        // 用车类型
        $vehicleType = I('vehicleType', '', 'intval');
        // 出发地
        $departArea  = I('departArea', '', 'strval');
        // 目的地
        $destArea    = I('destArea', '', 'strval');

        // 装货人信息
        // 姓名
        $name    = I('loadName', '', 'strval');
        // 手机号码
        $mobile  = I('loadMobile', '', 'strval');
    
        // $loadName    = I('loadName', '', 'strval');
        // $loadData['name'] = trim($data['loadName']);
        // $loadData['mobile'] = trim($data['loadMobile']);
        // $loadData['area'] = $data['departArea'];
        // $loadData['address'] = $data['departAddress'];
        // $loadData['address'] = $data['departAddress'];
        // $loadData['address'] = $data['departAddress'];

        
        // ###封装数据
        // 订单类型
        $data['orderType']        = $orderType;
         // 运输类型  
        $data['transType']        = $transType;
        // 用车类型
        $data['vehicleType']      = $vehicleType;
        // 出发地
        $data['departArea']       = $departArea;
        // 目的地
        $data['destArea']         = $destArea;
        // 预估出发时间
        $data['departTime']       = time();
        // 预估到达时间
        $data['arrivedTime']      = time();
        // 生成订单号
        $data['orderNum']      = generateOrderSn(); 
        //订单状态变更为发布中 1
        $data['orderState']    = ORDER_STATE_PUBLISH; 
        // 
        $data['state']         = STATE_ON;
        // 订单生成时间
        $data['createTime']    = time();
        // 订单修改时间
        $data['updateTime']    = time();


        // ###检验数据   
        $result = $this->orderValidate($data);
        if ($result !== ture) $this->error('新增失败'.$result['message']);

        // ###保存数据
        // ###开启事务
        $this->startTrans();
       
        //todo登入系统后加上userId以及费用的算法
        $orderId = $this->model_order->saveData($data);


        // 释放数据
        unset($data);
        // ###封装信息
        // 
        $chargerId = $this->model_order_charger->saveData($data);

        // 事务状态
        $status = $orderId && $chargerId;

        // ###结束事务
        $this->endTrans($status);

        if ($status) {
            $this->success('新增成功', U('index'));
        } else {
            $this->error('新增失败');
        }
    }

    /**
     * 展示页面
     * @author shigin <597852546@qq.com>
     */
    public function index()
    {
        // ###渲染页面
        $this->display();
    }


    /**
     * 新增页面
     * @author shigin <597852546@qq.com>
     */
    public function add()
    {
        // ###渲染页面
        $this->display();
    }

    /**
     * 编辑页面
     * @author shigin <597852546@qq.com>
     */
    public function edit()
    {
        // ###渲染页面
        $this->display();
    }

    /**
     * 更新
     * @author shigin <597852546@qq.com>
     */
    public function update()
    {

    }




    /**
     * 检验数据
     * @param  array $data 数据源
     * @author shigin <597852546@qq.com>
     */
    public function orderValidate($data){
        if(empty($data['departArea'])){
            return ['state'=>false,'message'=>'请选择出发地'];
        }
        if(empty($data['destArea'])){
            return ['state'=>false,'message'=>'请选择目的地'];
        }
        if(empty($data['departArea'])){
            return ['state'=>false,'message'=>'请选择出发地'];
        }
        if(empty($data['departTime'])){
            return ['state'=>false,'message'=>'请选择出发时间'];
        }
        if(empty($data['arrivedTime'])){
            return ['state'=>false,'message'=>'请选择到货时间'];
        }
        return true;
    }


}