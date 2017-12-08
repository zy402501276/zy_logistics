<?php
namespace Home\Model;
class OrderGoodsModel extends BaseModel{
    protected $tableName = "ordergoods";

    /*
     * 获取订单物品数量重量
     * @author zhangye
     */
    public function getGoodsInfo($ordeId){
        $array = [];
        $result = $this
                  ->field('sum(count),sum(goodsWeight)')
                  ->where("orderId=$ordeId")
                  ->find();
        if(!empty($result)){
            $array = $result;
        }
        return $array;
    }
    /*
     * 获取订单物品种类
     * @author zhangye
     */
    public function getGoodsType($ordeId){
        $string = '';
        $result = $this
            ->JOIN("LEFT JOIN `goodstype` ON `ordergoods`.goodsType = `goodstype`.id")
            ->WHERE("orderId=$ordeId")
            ->SELECT();
        if(!empty($result)){
            foreach ($result as $key =>$value){
                $string .= $value['name'].'/';
            }
            $string = substr($string,0,-1);
        }
        return $string;
    }

    /**
     * 获取订单的货物信息
     * @author: zy
     * @param $orderId int 订单表主键
     */
    public function getGoodsById($orderId){
        $where['orderId'] = $orderId;
        $result = $this
                  ->WHERE($where)
                  ->JOIN("LEFT JOIN `goodstype` ON `ordergoods`.goodsType = `goodstype`.id")
                  ->SELECT();
        return $result;
    }

    /**
     * 获取货物信息
     * @param int $orderId 订单id
     * @author shigin <597852546@qq.com>
     */
    public function getDataByOrderId($orderId)
    {   
        return  $this->where(['orderId' => $orderId])->select();
    }

    /**
     * 根据订单id删除数据
     * @author shigin <597852546@qq.com>
     */
    public function deleteDataByOrderId($id)
    {
        return $this->where(['orderId' => $id])->delete();
    }
}