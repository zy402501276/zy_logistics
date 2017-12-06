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
            ->where("orderId=$ordeId")
            ->select();
        if(!empty($result)){
            foreach ($result as $key =>$value){
                $string .= $value['name'].'/';
            }
            $string = substr($string,0,-1);
        }
        return $string;
    }

}