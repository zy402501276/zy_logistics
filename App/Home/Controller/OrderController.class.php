<?php

// +----------------------------------------------------------------------
// | wuliu.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yoursite.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Controller;
/**
 * 订单操作模块控制器
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
     * 引用对象[下单货物信息表]
     * @var $model
     */
    protected $model_order_goods = NULL;

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

        // ###本类调用
        // 实例模型[货品信息表]
        $this->model_order_goods   = D('Ordergoods');

        

    }

    /**
     * 保存订单
     * @author shigin <597852546@qq.com>
     */
    public function save()
    {    
        echo '<pre>';
        print_r($_POST);
        // ###操作数据
        // ###订单信息
        // 订单类型
        $orderType   = I('orderType', '', 'intval');
        // 运输类型
        $transType   = I('transType', '', 'intval');
        // 用车类型
        $vehicleType = I('vehicleType', '', 'intval');
        // 装货率
        $loadRate    = I('loadRate', '', 'strval');
        // 总费用
        $sumPrice    = I('sumPrice', '', 'intval');
        // 出发时间
        $departTime  = I('departTime', '', 'strval');
        // 到货时间
        $arrivedTime = I('arrivedTime', '', 'strval');


        // ###装货人信息
        // 姓名
        $s_name          = I('s_name', '', 'strval');
        // 手机号码
        $s_mobile        = I('s_mobile', '', 'strval');
        // 地理位置
        $s_area          = I('s_area', '', 'strval');
        // 具体位置
        $s_address       = I('s_address', '', 'strval');
        // 经度
        $s_longitude     = I('s_longitude', '', 'strval');
        // 纬度
        $s_latitude      = I('s_latitude', '', 'strval');
        // 装货时间
        $s_startTime     = I('s_startTime', '', 'strval');
        // 预估时间
        $s_estimatedTime = I('s_estimatedTime', '', 'strval');
        // type
        $s_type          = I('s_type', '', 'intval');
        // 备注
        $s_desc          = I('s_desc', '', 'strval');

        // ###卸货人信息
        // 姓名
        $name          = I('loadName', '', 'strval');
        // 手机号码
        $mobile        = I('loadMobile', '', 'strval');
        // 地理位置
        $area          = I('area', '', 'strval');
        // 具体位置
        $address       = I('address', '', 'strval');
        // 经度
        $longitude     = I('longitude', '', 'strval');
        // 纬度
        $latitude      = I('latitude', '', 'strval');
        // 装货时间
        $startTime     = I('startTime', '', 'intval');
        // 预估时间
        $estimatedTime = I('estimatedTime', '', 'intval');
        // type
        $type          = I('type', '', 'intval');
        // 备注
        $desc          = I('desc', '', 'strval');

        // ###物品信息
        // 物品集合
        $goods   = I('goods');

        // ###检验数据   
        $result = $this->orderValidate($data);
        
        // ###保存数据
        do {
            // ###开启事务
            $this->startTrans();

            //----------------------
            // *.保存订单表
            //----------------------
            if(true) {
                // ###封装数据
                // 赋值数据[订单类型]
                $data['orderType']        = $orderType;
                 // 赋值数据[运输类型]  
                $data['transType']        = $transType;
                // 赋值数据[用车类型]
                $data['vehicleType']      = $vehicleType;
                // 赋值数据[装货率]
                $data['loadRate']         = $loadRate;
                // 赋值数据[总费用]
                $data['sumPrice']         = $sumPrice;
                // 赋值数据[出发地]
                $data['departArea']       = $area.''.$area;
                // 赋值数据[目的地]
                $data['destArea']         = $area.''.$area;
                // 赋值数据[预估出发时间]
                $data['departTime']       = $departTime;
                // 赋值数据[预估到达时间]
                $data['arrivedTime']      = $arrivedTime;
                // 赋值数据[生成订单号]
                $data['orderNum']      = generateOrderSn(); 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[订单生成时间]
                $data['createTime']    = time();
                // 赋值数据[订单修改时间]
                $data['updateTime']    = time();

                echo '<pre>';
                print_r($data);exit;
                
                 //todo登入系统后加上userId以及费用的算法
                $orderId = $this->model_order->saveData($data);

                if ($orderId === false) {
                    // ###设置结果
                    $status  = false;
                    // ###中断流程
                    break;
                }
            }

            //----------------------
            // *.保存装货人信息
            //----------------------
            if (true) {
                // ###释放数据
                unset($data);

                // ###封装数据
                // 赋值数据[订单id]
                $data['orderId']       = $orderId;
                 // 赋值数据[装货人名称]  
                $data['name']          = $name;
                // 赋值数据[手机号码]
                $data['mobile']        = $mobile;
                // 赋值数据[地理位置]
                $data['area']          = $area;
                // 赋值数据[具体位置]
                $data['address']       = $address;
                // 赋值数据[经度]
                $data['longitude']     = $longitude;
                // 赋值数据[纬度]
                $data['latitude']      = $latitude;
                // 赋值数据[装货时间]
                $data['startTime']     = $startTime;
                // 赋值数据[卸货时间]
                $data['endTime']       = $startTime + $estimatedTime * 3600;
                // 赋值数据[类型]
                $data['type']          = 1; 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[描述]
                $data['desc']          = $desc;
                // 赋值数据[订单生成时间]
                $data['createTime']    = time();
                // 赋值数据[订单修改时间]
                $data['updateTime']    = time();


                // ###保存
                $chargerId = $this->model_order_charger->saveData($data);

                if ($orderId === false) {
                    // ###设置结果
                    $status  = false;
                    // ###中断流程
                    break;
                }
            } 

            //----------------------
            // *.保存卸货人信息
            //----------------------
            if (true) {
                // ###释放数据
                unset($data);

                // ###封装数据
                // 赋值数据[订单id]
                $data['orderId']       = $orderId;
                 // 赋值数据[装货人名称]  
                $data['name']          = $name;
                // 赋值数据[手机号码]
                $data['mobile']        = $mobile;
                // 赋值数据[地理位置]
                $data['area']          = $area;
                // 赋值数据[具体位置]
                $data['address']       = $address;
                // 赋值数据[经度]
                $data['longitude']     = $longitude;
                // 赋值数据[纬度]
                $data['latitude']      = $latitude;
                // 赋值数据[装货时间]
                $data['startTime']     = $startTime;
                // 赋值数据[卸货时间]
                $data['endTime']       = $startTime + $estimatedTime * 3600;
                // 赋值数据[类型]
                $data['type']          = 2; 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[描述]
                $data['desc']          = $desc;
                // 赋值数据[订单生成时间]
                $data['createTime']    = time();
                // 赋值数据[订单修改时间]
                $data['updateTime']    = time();


                // ###保存
                $chargerId = $this->model_order_charger->saveData($data);

                if ($orderId === false) {
                    // ###设置结果
                    $status  = false;
                    // ###中断流程
                    break;
                }
            } 

            //----------------------
            // *.保存货品信息
            //----------------------
            foreach ($goods as $key => $value) {
               if (true) {
                    // ###释放数据
                    unset($data);
                    // 货物名称
                    $goodsName   = strval($value['goodsName']);
                    // 货物长度
                    $goodsLength = strval($value['goodsLength']);
                    // 货物宽度
                    $goodsWidth  = strval($value['goodsWidth']);
                    // 货物高度
                    $goodsHeight = strval($value['goodsHeight']);
                    // 货物重量
                    $goodsWeight = strval($value['goodsWeight']);
                    // 货物数量
                    $count       = intval($value['count']);
                    // 货物类型
                    $goodsType   = intval($value['goodsType']);

                    // ###封装数据
                    // 赋值数据[订单id]
                    $data['orderId']       = $orderId;
                     // 赋值数据[货物名称]  
                    $data['goodsName']     = $goodsName;
                    // 赋值数据[货物长度]
                    $data['goodsLength']   = $goodsLength;
                    // 赋值数据[货物宽度]
                    $data['goodsWidth']    = $goodsWidth;
                    // 赋值数据[货物高度]
                    $data['goodsHeight']   = $goodsHeight;
                    // 赋值数据[货物重量]
                    $data['goodsWeight']   = $goodsWeight;
                    // 赋值数据[货物数量]
                    $data['count']         = $count;
                    // 赋值数据[货物类型]
                    $data['goodsType']     = $goodsType;
                    // 赋值数据[状态]
                    $data['state']         = STATE_ON;
                    // 赋值数据[订单生成时间]
                    $data['createTime']    = time();
                    // 赋值数据[订单修改时间]
                    $data['updateTime']    = time();


                    // ###保存
                    $goodsId = $this->model_order_goods->saveData($data);

                    if ($goodsId === false) {
                        // ###设置结果
                        $status  = false;
                        // ###中断流程
                        break;
                    }
                }
            } 
        } while (false);
            
        // if ($status !== ture) $this->error('新增失败'.$result['message']);
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