<?php
/**
 * 通用公共方法
 * @author zhangye
 * @time 2017年12月1日13:53:49
 */

/**
 * 获取状态
 * @param array $data  定义的状态数组
 * @param string $status 数组中对应的状态值
 * @param boolean $returnString 是否强制输出字符串
 * @return 数组或者数组中的某一个元素
 *
 * @descript 如果数组中对应的状态值存在, 则直接返回值, 如果不存在, 则直接返回整个定义的数组
 */
function getState(array $data, $status = '', $echoString = false) {
    if (isset($data[$status])) {
        return $data[$status];
    }
    if ($echoString) {
        return $status;
    }
    return $data;
}

/**
 * 获取图片
 * @author zhangye
 */
function getImg($img) {
    //$img = getcwd().'/../Static/Upload/'.$img;
    $img = IMG_URL.'/'.$img;
    return $img;
}
