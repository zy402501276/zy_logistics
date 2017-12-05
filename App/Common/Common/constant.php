<?php
// +----------------------------------------------------------------------
// | Tool.Pub [ All tools in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.tool.pub All rights reserved.
// +----------------------------------------------------------------------
// | Author: AC.Cai <c1985@vip.qq.com> <http://do.org.cn>
// +----------------------------------------------------------------------

//**********************************
// 逻辑常量定义
// 定义业务逻辑相关的常量等
//**********************************

//----------------------------------
// 通用常量
//----------------------------------
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