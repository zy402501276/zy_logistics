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
                        'goodsType' => 'type',
                        'count' => 'number',
                        'goodsWeight' => 'weight',
                        'goodsLength',
                        'goodsWidth',
                        'goodsHeight',
                        );
        $result = $this->field($field)->where($where)->find();
        $result['volumn'] = intval($result['goodslength'])*intval($result['goodswidth'])*intval($result['goodsheight']);
        unset($result['goodsheight']);
        unset($result['goodslength']);
        unset($result['goodswidth']);

        $result['number'] = intval($result['number']);
        $result['weight'] = intval($result['weight']);
        return $result;
    }

}