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
 * @author  shigin <597852546@qq.com>
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
    protected $model_order_goods   = NULL;

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
        $this->model_order_goods   = D('OrderGoods');

        

    }

    /**
     * 保存订单
     * @author shigin <597852546@qq.com>
     */
    public function save()
    {    
        // ----------------------------
        // *.操作数据
        // ----------------------------
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
        $s_longitude     = explode('  ', I('s_LngAndLat', '', 'strval'))[0];
        // 纬度
        $s_latitude      = explode('  ', I('s_LngAndLat', '', 'strval'))[1];
        // 装货时间
        $s_startTime     = strtotime(I('s_startTime', '', 'strval'));
        // 预估时间
        $s_estimatedTime = I('s_estimatedTime', '', 'strval');
        // type
        $s_type          = I('s_type', '', 'intval');
        // 备注
        $s_desc          = I('s_desc', '', 'strval');

        // ###卸货人信息
        // 姓名
        $d_name          = I('d_name', '', 'strval');
        // 手机号码
        $d_mobile        = I('d_mobile', '', 'strval');
        // 地理位置
        $d_area          = I('d_area', '', 'strval');
        // 具体位置
        $d_address       = I('d_address', '', 'strval');
        // 经度
        $d_longitude     = explode('  ', I('d_LngAndLat', '', 'strval'))[0];
        // 纬度
        $d_latitude      = explode('  ', I('d_LngAndLat', '', 'strval'))[1];
        // 卸货时间
       // $d_startTime     = strtotime(I('d_startTime', '', 'intval'));
        $d_startTime     = strtotime($_POST['d_startTime']);
        // 预估时间
        $d_estimatedTime = I('d_estimatedTime', '', 'intval');
        // type
        $d_type          = I('d_type', '', 'intval');
        // 备注
        $d_desc          = I('d_desc', '', 'strval');

        // ###物品信息
        // 姓名
        $goodsName   = I('goodsName');
        // 货物长度
        $goodsLength = I('goodsLength');
        // 货物宽度
        $goodsWidth  = I('goodsWidth');
        // 货物高度
        $goodsHeight = I('goodsHeight');
        // 货物重量
        $goodsWeight = I('goodsWeight');
        // 货物数量
        $count       = I('count');
        // 货物类型
        $goodsType   = I('goodsType');
        // ###检验数据   
        // $result = $this->orderValidate($data);

        if(($s_startTime+$s_estimatedTime*3600)>($d_startTime)){    //判断装货完成时间是否大于卸货时间
            $this->error('装货完成时间必须小于卸货时间');
        }
        // ###保存数据
        do {
            // 状态值
            $status = true;
            // ###开启事务
            $this->startTrans();

            //----------------------
            // *.保存订单表
            //----------------------
            if(true) {
                // ###封装数据
                // 赋值数据[订单类型]
                $data['userId']        = session('userId');  
                // 赋值数据[订单类型]
                $data['orderType']     = $orderType;
                 // 赋值数据[运输类型]  
                $data['transType']     = $transType;
                // 赋值数据[用车类型]
                $data['vehicleType']   = $vehicleType;
                // 赋值数据[装货率]
                $data['loadRate']      = $loadRate;
                // 赋值数据[总费用]
                $data['sumPrice']      = $sumPrice;
                // 赋值数据[出发地]
                $data['departArea']    = $s_area.''.$s_address;
                // 赋值数据[目的地]
                $data['destArea']      = $d_area.''.$d_address;
                // 赋值数据[预估出发时间]
                $data['departTime']    = $s_startTime + $s_estimatedTime * 3600;
                // 赋值数据[预估到达时间]
                $data['arrivedTime']   = $d_startTime + $d_estimatedTime * 3600;
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
                $data['name']          = $s_name;
                // 赋值数据[手机号码]
                $data['mobile']        = $s_mobile;
                // 赋值数据[地理位置]
                $data['area']          = $s_area;
                // 赋值数据[具体位置]
                $data['address']       = $s_address;
                // 赋值数据[经度]
                $data['longitude']     = $s_longitude;
                // 赋值数据[纬度]
                $data['latitude']      = $s_latitude;
                // 赋值数据[装货时间]
                $data['startTime']     = $s_startTime;
                // 赋值数据[装货最终时间]
                $data['endTime']       = $s_startTime + $s_estimatedTime * 3600;
                // 赋值数据[类型]
                $data['type']          = 1; 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[描述]
                $data['desc']          = $s_desc;
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
                $data['name']          = $d_name;
                // 赋值数据[手机号码]
                $data['mobile']        = $d_mobile;
                // 赋值数据[地理位置]
                $data['area']          = $d_area;
                // 赋值数据[具体位置]
                $data['address']       = $d_address;
                // 赋值数据[经度]
                $data['longitude']     = $d_longitude;
                // 赋值数据[纬度]
                $data['latitude']      = $d_latitude;
                // 赋值数据[卸货时间]
                $data['startTime']     = $d_startTime;
                // 赋值数据[卸货最终时间]
                $data['endTime']       = $d_startTime + $d_estimatedTime * 3600;
                // 赋值数据[类型]
                $data['type']          = 2; 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[描述]
                $data['desc']          = $d_desc;
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
            foreach ($goodsName as $key => $value) {
               if (true) {
                    // ###释放数据
                    unset($data);
                    // 货物名称
                    $name      = strval($goodsName[$key]);
                    // 货物长度
                    $length    = strval($goodsLength[$key]);
                    // 货物宽度
                    $width     = strval($goodsWidth[$key]);
                    // 货物高度
                    $height    = strval($goodsHeight[$key]);
                    // 货物重量
                    $weight    = strval($goodsWeight[$key]);
                    // 货物数量
                    $no        = intval($count[$key]);
                    // 货物类型
                    $type      = intval($goodsType[$key]);

                    // ###封装数据
                    // 赋值数据[订单id]
                    $data['orderId']       = $orderId;
                    // 赋值数据[货物名称]  
                    $data['goodsName']     = $name;
                    // 赋值数据[货物长度]
                    $data['goodsLength']   = $length;
                    // 赋值数据[货物宽度]
                    $data['goodsWidth']    = $width;
                    // 赋值数据[货物高度]
                    $data['goodsHeight']   = $height;
                    // 赋值数据[货物重量]
                    $data['goodsWeight']   = $weight;
                    // 赋值数据[货物数量]
                    $data['count']         = $no;
                    // 赋值数据[货物类型]
                    $data['goodsType']     = $type;
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
            $this->success('新增成功', U('orderList/lists'));
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
        $this->display('order/add');
    }

    /**
     * 编辑页面
     * @author shigin <597852546@qq.com>
     */
    public function edit()
    {   
        // ###操作数据
        // 订单id
        $ordeId = I('id', '', 'intval');

        if (!$ordeId) $this->error('订单不存在');

        // 指定变量[订单数据]
        $this->assign('order',       $this->getOrder($ordeId));
        // 指定变量[装卸数据]
        $this->assign('stevedoring', $this->stevedoring($ordeId));
        // 指定变量[物品数据]
        $this->assign('goods',       $this->getGoods($ordeId)); 
        
        // ###渲染页面
        $this->display('order/edit');
    }

    /**
     * 更新
     * @author shigin <597852546@qq.com>
     */
    public function update()
    {   
        // ###操作数据
        // id
        
        // ----------------------------
        // *.操作数据
        // ----------------------------
        // ###订单信息
        $orderId     = I('id', '', 'intval');
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
        $s_longitude     = explode('  ', I('s_LngAndLat', '', 'strval'))[0];
        // 纬度
        $s_latitude      = explode('  ', I('s_LngAndLat', '', 'strval'))[1];
        // 装货时间
        $s_startTime     = strtotime(I('s_startTime', '', 'strval'));
        // 预估时间
        $s_estimatedTime = I('s_estimatedTime', '', 'strval');
        // type
        $s_type          = I('s_type', '', 'intval');
        // 备注
        $s_desc          = I('s_desc', '', 'strval');

        // ###卸货人信息
        // 姓名
        $d_name          = I('d_name', '', 'strval');
        // 手机号码
        $d_mobile        = I('d_mobile', '', 'strval');
        // 地理位置
        $d_area          = I('d_area', '', 'strval');
        // 具体位置
        $d_address       = I('d_address', '', 'strval');
        // 经度
        $d_longitude     = explode('  ', I('d_LngAndLat', '', 'strval'))[0];
        // 纬度
        $d_latitude      = explode('  ', I('d_LngAndLat', '', 'strval'))[1];
        // 装货时间
        // $d_startTime     = strtotime(I('d_startTime', '', 'intval'));
        $d_startTime     = strtotime($_POST['d_startTime']);
        // 预估时间
        $d_estimatedTime = I('d_estimatedTime', '', 'intval');
        // type
        $d_type          = I('d_type', '', 'intval');
        // 备注
        $d_desc          = I('d_desc', '', 'strval');

        // ###物品信息
        // 姓名
        $goodsName   = I('goodsName');
        // 货物长度
        $goodsLength = I('goodsLength');
        // 货物宽度
        $goodsWidth  = I('goodsWidth');
        // 货物高度
        $goodsHeight = I('goodsHeight');
        // 货物重量
        $goodsWeight = I('goodsWeight');
        // 货物数量
        $count       = I('count');
        // 货物类型
        $goodsType   = I('goodsType');

        // ###检验数据   
        // $result = $this->orderValidate($data);
        if(($s_startTime+$s_estimatedTime*3600)>($d_startTime)){    //判断装货完成时间是否大于卸货时间
            $this->error('装货完成时间必须小于卸货时间');
        }
        // ###更新数据
        do {
            // 状态值
            $status = true;
            // ###开启事务
            $this->startTrans();

            //----------------------
            // *.保存订单表
            //----------------------
            if(true) {
                // ###封装数据
                // 赋值数据[订单id]
                $data['id']            = $orderId;
                // 赋值数据[订单类型]
                $data['orderType']     = $orderType;
                 // 赋值数据[运输类型]  
                $data['transType']     = $transType;
                // 赋值数据[用车类型]
                $data['vehicleType']   = $vehicleType;
                // 赋值数据[装货率]
                $data['loadRate']      = $loadRate;
                // 赋值数据[总费用]
                $data['sumPrice']      = $sumPrice;
                // 赋值数据[出发地]
                $data['departArea']    = $s_area.''.$s_address;
                // 赋值数据[目的地]
                $data['destArea']      = $d_area.''.$d_address;
                // 赋值数据[预估出发时间]
                $data['departTime']    = $s_startTime + $s_estimatedTime * 3600;
                // 赋值数据[预估到达时间]
                $data['arrivedTime']   = $d_startTime + $d_estimatedTime * 3600;
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

                
                 //todo登入系统后加上userId以及费用的算法
                $orderId = $this->model_order->updateData($data);

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
                // 删除装卸货信息
                $this->model_order_charger->deleteDataByOrderId($orderId);
                
                // ###释放数据
                unset($data);

                // ###封装数据
                // 赋值数据[订单id]
                $data['orderId']       = $orderId;
                 // 赋值数据[装货人名称]  
                $data['name']          = $s_name;
                // 赋值数据[手机号码]
                $data['mobile']        = $s_mobile;
                // 赋值数据[地理位置]
                $data['area']          = $s_area;
                // 赋值数据[具体位置]
                $data['address']       = $s_address;
                // 赋值数据[经度]
                $data['longitude']     = $s_longitude;
                // 赋值数据[纬度]
                $data['latitude']      = $s_latitude;
                // 赋值数据[装货时间]
                $data['startTime']     = $s_startTime;
                // 赋值数据[装货最终时间]
                $data['endTime']       = $s_startTime + $s_estimatedTime * 3600;
                // 赋值数据[类型]
                $data['type']          = 1; 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[描述]
                $data['desc']          = $s_desc;
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
                $data['name']          = $d_name;
                // 赋值数据[手机号码]
                $data['mobile']        = $d_mobile;
                // 赋值数据[地理位置]
                $data['area']          = $d_area;
                // 赋值数据[具体位置]
                $data['address']       = $d_address;
                // 赋值数据[经度]
                $data['longitude']     = $d_longitude;
                // 赋值数据[纬度]
                $data['latitude']      = $d_latitude;
                // 赋值数据[卸货时间]
                $data['startTime']     = $d_startTime;
                // 赋值数据[卸货最终时间]
                $data['endTime']       = $d_startTime + $d_estimatedTime * 3600;
                // 赋值数据[类型]
                $data['type']          = 2; 
                // 赋值数据[订单状态变更为发布中 1]
                $data['orderState']    = ORDER_STATE_PUBLISH; 
                // 赋值数据[状态]
                $data['state']         = STATE_ON;
                // 赋值数据[描述]
                $data['desc']          = $d_desc;
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
            // 删除货品信息
            $this->model_order_goods->deleteDataByOrderId($orderId);
            foreach ($goodsName as $key => $value) {
               if (true) {
                    // ###释放数据
                    unset($data);
                    // 货物名称
                    $name      = strval($goodsName[$key]);
                    // 货物长度
                    $length    = strval($goodsLength[$key]);
                    // 货物宽度
                    $width     = strval($goodsWidth[$key]);
                    // 货物高度
                    $height    = strval($goodsHeight[$key]);
                    // 货物重量
                    $weight    = strval($goodsWeight[$key]);
                    // 货物数量
                    $no        = intval($count[$key]);
                    // 货物类型
                    $type      = intval($goodsType[$key]);

                    // ###封装数据
                    // 赋值数据[订单id]
                    $data['orderId']       = $orderId;
                    // 赋值数据[货物名称]  
                    $data['goodsName']     = $name;
                    // 赋值数据[货物长度]
                    $data['goodsLength']   = $length;
                    // 赋值数据[货物宽度]
                    $data['goodsWidth']    = $width;
                    // 赋值数据[货物高度]
                    $data['goodsHeight']   = $height;
                    // 赋值数据[货物重量]
                    $data['goodsWeight']   = $weight;
                    // 赋值数据[货物数量]
                    $data['count']         = $no;
                    // 赋值数据[货物类型]
                    $data['goodsType']     = $type;
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
            $this->success('更新成功', U('orderInfo/wait',['id'=>$orderId]));
        } else {
            $this->error('更新失败');
        }
    }

    /**
     * 获取装卸货信息
     * @param int $id 订单id
     * @author shigin <597852546@qq.com>
     */
    public function stevedoring($id)
    {
        return $this->model_order_charger->getDataByOrderId($id);
    }
    
    /**
     * 获取下单信息
     * @param int $id 订单id
     * @author shigin <597852546@qq.com>
     */
    public function getOrder($id)
    {   
        return $this->model_order->getById($id);
    }

    /**
     * 获取货物信息
     * @param int $id 订单id
     * @author shigin <597852546@qq.com>
     */
    public function getGoods($id)
    {
        return $this->model_order_goods->getDataByOrderId($id);
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