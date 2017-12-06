<?php

/**
 * 订单号生成方法
 * @author: zy
 * @return string
 */
function generateOrderSn() {
    return date('ymdH') . substr(microtime(), 2, 6) . str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
}

/**
 * 获取市级信息
 * @author zhangye
 */
function getCity($area){
    if(empty($area)) return ;
    $arr = explode(" ",$area);
    return $arr[1];
}

/**
 * 获取当前时间戳为周几
 * @author zhangy
 */
function getWeek($time){
    $day = "星期".mb_substr( "日一二三四五六",date("w",$time),1,"utf-8" );
    return $day;
}
/**
 * 获取时间损耗
 * @author zhangye
 */
function getCostTime($startTime,$endTime){
    $startTime = intval($startTime);
    $endTime = intval($endTime);
    return (($endTime-$startTime)/3600) .'小时';
}