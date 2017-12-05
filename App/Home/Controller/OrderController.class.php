<?php
/**
 * 订单模块控制器
 * @author zhangy
 * @time 2017年12月5日21:08:50
 */
namespace Home\Controller;
class OrderController extends BaseController{
    /**
     * 新增订单
     * @author: zy
     */
    public function add(){
        if($_POST){
            $service = D('Order','Service');
            $result = $service->add($_POST);
            var_dump($result);
            die;
        }
//        layout(true);
//        $this->display();
    }
}