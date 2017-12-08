<?php
// +----------------------------------------------------------------------
// | wuliu.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yoursite.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <597852546@qq.com> <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Model;
/**
 * 订单照片负责人模型类
 * @time 2017年12月1日14:54:26
 * @author zhangye
 */
class OrderImgModel extends BaseModel
{


    protected $tableName = "orderimg";


    /**
     * 根据订单id获取照片
     * @author zhangye
     * @time 2017年12月8日20:55:18
     * @param $orderId 订单id
     * @param $type int 1 装货 2 卸货
     */
    public function getPhoto($orderId,$type){
        $imgArr = [];
         switch($type){
             case 1:
                $where['orderid'] = $orderId;
                $where['type'] = 1; //装货货照片
                $loadImg = $this->where($where)->select();
                $loadPhoto = [];
                if(!empty($loadImg)){
                    foreach ($loadImg as $key => $value){
                        $loadPhoto[] = getImg($value['img']);
                    }
                }

                unset($where['type']);

                $where['type'] = 3; //装货签名照片
                $signImg = $this->where($where)->find();
                $signPhoto = "";
                if(!empty($signImg)){
                    $signPhoto = getImg($signImg['img']);
                }
                break;
             case 2:
                 $where['orderid'] = $orderId;
                 $where['type'] = 2; //卸货货照片
                 $loadImg = $this->where($where)->select();
                 $loadPhoto = [];
                 if(!empty($loadImg)){
                     foreach ($loadImg as $key => $value){
                         $loadPhoto[] = getImg($value['img']);
                     }
                 }

                 unset($where['type']);

                 $where['type'] = 4; //卸货签名照片
                 $signImg = $this->where($where)->find();
                 $signPhoto = "";
                 if(!empty($signImg)){
                     $signPhoto = getImg($signImg['img']);
                 }
                 break;
         }
        return $imgArr = ['loadImg'=>$loadPhoto,'signImg'=>$signPhoto];
    }

}