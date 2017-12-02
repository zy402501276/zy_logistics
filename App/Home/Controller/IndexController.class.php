<?php
// +----------------------------------------------------------------------
// | Count.System [ All demangs in it! ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.tool.pub All rights reserved.
// +----------------------------------------------------------------------
// | Author: shigin <597852546@qq.com> <http://shigin.cc>
// +----------------------------------------------------------------------
namespace Home\Controller;
class IndexController extends BaseController 
{
   	//----------------------------------
    // 变量 - 成员变量
    //----------------------------------

    /**
     * 引用对象[redis]
     * @var $object
     */
    protected $redis         = NULL;

    /**
     * 引用对象[es]
     * @var $model
     */
    protected $elasticsearch = NULL;

    /**
     * 模型对象[设备]
     * @var $model
     */
    protected $model_device  = NULL;

     /**
     * 模型对象[APP]
     * @var $model
     */
    protected $model_app     = NULL;


   	/**
     * 初始化
     * @return void
     * @author shigin <597852546@qq.com>
     */
    protected function _initialize() 
    {
        // ###超类调用
        parent::_initialize();

        // ###本类调用
        // 实例模型[设备]
        // $this->model_app    = D('Api/App');
    }

    public function index()
    {	
    	echo 111; exit;
    }

   	/**
   	 * 订单加载
   	 * @author Loring<597852546@qq.com>
   	 */
   	public function orderLoading()
   	{	
    	$this->display();
	}



}
