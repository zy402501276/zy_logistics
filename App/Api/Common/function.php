<?php
/**
 * 格式化json
 * @param $status int  状态码 0 成功
 * @param $msg string  信息
 * @param $obj array
 * @return json
 */
function output($status ,$obj,$message=''){
    echo json_encode(array('status'=>$status,'msg'=>$message,'obj'=>$obj));exit;
}