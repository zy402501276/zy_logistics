<?php
// +----------------------------------------------------------------------
// | wuliu.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yoursite.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <597852546@qq.com> <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Model;
use Think\Model;

/**
 * 基础模型
 */
class BaseModel extends Model 
{    
    //----------------------------------
    // 方法 - 检索数据
    //----------------------------------
    /**
     * 获得数据[ID]
     * @param int $id ID
     * @return array 结果数据
     * @author shigin <597852546@qq.com>
     */
    public function getById($id) {
        // ###结果数据
        $result = NULL;

        // ###处理数据
        if ($id !== 0) {
            $result = $this->where('id='.$id)->find();
        }

        // ###返回结果数据
        return $result;
    }

    //----------------------------------
    // 方法 - 数据库CRUD
    //----------------------------------
    /**
     * 保存或更新数据
     * @param array $data 数据
     * @return int ID
     * @author shigin <597852546@qq.com>
     */
    public function saveOrUpdateData($data) 
    {
        // ###操作数据
        $id = $data['id'];
        
        // ###数据操作
        if ($id !== NULL && $id !== 0) {
            return $this->updateData($data);
        } else {
            return $this->saveData($data);
        }
    }
    
    
    /**
     * 保存数据[批量]
     * @param array $data 数据
     * @return int ID/bool FALSE
     * @author shigin <597852546@qq.com>
     */
    public function saveDataAll($data) {
        return $this->addAll($data);

    }

    /**
     * 获取数据[批量]
     * @return int ID/bool FALSE
     * @author shigin <597852546@qq.com>
     */
    public function getAll() {
        return $this->select();

    }


    /**
     * 保存数据
     * @param array $data 数据
     * @return int ID/bool FALSE
     * @author shigin <597852546@qq.com>
     */
    public function saveData($data) {
        return $this->data($data)->add();
    }

    /**
     * 更新数据
     * @param array $data 数据
     * @return int ID/bool FALSE
     * @author shigin <597852546@qq.com>
     */
    public function updateData($data) {
        $id = $data['id'];
        $this->where('id='.$id)->save($data);
        return $id;
    }

    /**
     * 删除数据
     * @param int $id ID
     * @return bool y/n
     * @author shigin <597852546@qq.com>
     */
    public function deleteData($id, $true=FALSE) {
        if ($true === FALSE) {
            return $this->deleteDataFalse($id);
        } else {
            return $this->deleteDataTrue($id);
        }
    }

    /**
     * 删除数据[真]
     * @param int $id ID
     * @return bool y/n
     * @author shigin <597852546@qq.com>
     */
    public function deleteDataTrue($id) {
        return $this->where('id='.$id)->delete();
    }

    /**
     * 删除数据[假]
     * @param int $id ID
     * @return bool y/n
     * @author shigin <597852546@qq.com>
     */
    public function deleteDataFalse($id) {
        return $this->where('id='.$id)->save(array('state'=>STATE_OFF,'updateTime'=>time()));
    }
}