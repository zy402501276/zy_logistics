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
 * 司机信息模型类
 * @time 2017年12月1日14:54:26
 * @author zhangye
 */
class DriverInfoModel extends BaseModel
{


    protected $tableName = "driverinfo";


    /**
     * 获取装卸货人信息
     * @time 2017年12月1日15:17:553
     * @author zhangy
     */
    public function getDriver($userId){
        $where['userId'] = $userId;
        $result = $this
                ->JOIN("LEFT JOIN `user` ON (`user`.id = `driverinfo`.userId)")
                ->JOIN("LEFT JOIN `driveraddress` ON (`driveraddress`.driverId = `driverinfo`.userId)")
                ->WHERE($where)
                ->FIND();
        return $result;
    }

}