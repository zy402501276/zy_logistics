<?php

/**
 * 订单号生成方法
 * @author: zy
 * @return string
 */
function generateOrderSn() {
    return date('ymdH') . substr(microtime(), 2, 6) . str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
}