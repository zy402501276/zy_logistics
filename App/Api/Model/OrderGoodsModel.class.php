<?php
namespace Api\Model;
use Think\Model;

/**
 * 订单货物表模型类
 * @author zhangye
 * @time
 */
class OrderGoodsModel extends Model{
    protected $tableName = "ordergoods";

    /**
     * 根据主键id查询
     * @author: zy
     * @param $id int  订单-货物表主键id
     * @return array
     */
    public function findGoodsByPk($id){
        $where['id'] = $id;
        $field = array('goodsName'  =>'name',
                        'goodstype.name' => 'type',
                        'count' => 'number',
                        'goodsWeight' => 'weight',
                        'goodsLength' =>'length',
                        'goodsWidth' => 'width',
                        'goodsHeight' =>'height',
                        );
        $result = $this
                ->field($field)
                ->join("LEFT JOIN `goodstype` ON (`goodstype`.id = `ordergoods`.goodstype) ")
                ->where($where)->find();
        $result['volumn'] = intval($result['length'])*intval($result['width'])*intval($result['height']);
        $result['number'] = intval($result['number']);
        $result['weight'] = intval($result['weight']);
        return $result;
    }
    /**
     * 根据订单ID查询
     * @author: zy
     * @param $id int  订单主键id
     * @return array
     */
    public function findByOrderId($orderId){
        $where['orderId'] = $orderId;
        $field = array('goodsName'  =>'name',
            'goodstype.name' => 'type',
            'count' => 'number',
            'goodsWeight' => 'weight',
            'goodsLength',
            'goodsWidth',
            'goodsHeight',
        );
        $result = $this
                ->field($field)
                ->join("LEFT JOIN `goodstype` ON (`goodstype`.id = `ordergoods`.goodstype) ")
                ->where($where)
                ->select();
        $goodsArr = array();
        if(!empty($result)){
            foreach ($result as $key => $value){
                $goodsArr[] = array(
                    'name' => $value['name'],
                    'type' => $value['type'],
                    'number' => intval($value['number']),
                    'weight' => intval($value['weight']),
                    'volumn' => intval($value['goodslength'])*intval($value['goodswidth'])*intval($value['goodsheight']),
                    'length' => intval($value['goodslenght']),
                    'width' => intval($value['goodswidth']),
                    'height' => intval($value['goodsheight']),
                );
            }
        }
        return $goodsArr;
    }
}