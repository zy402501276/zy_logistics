<?php
return [
	
	/* 模块配置 */
	// 'MODULE_ALLOW_LIST'=> ['Admin,Api'],
    // 'DEFAULT_MODULE'        =>  'Admin', // 默认模块
    // 'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
    // 'DEFAULT_ACTION'        =>  'index', // 默认操作名称


    'URL_CASE_INSENSITIVE' =>true,
	 /* URL配置 */
    'URL_CASE_INSENSITIVE' => true,                                     // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 3,                                        // URL模式[3:兼容模式]
    'VAR_URL_PARAMS'       => '',                                       // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/',                                      // PATHINFO URL分割符

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '',                                             // 全局过滤函数


    


    /* 路由配置 */
    'URL_ROUTER_ON'   => true,
    'URL_ROUTE_RULES' => [
        /* 设备总览模块 */
        'device/trend_detail'   =>  'Api/DeviceTotal/trend_detail',       // 设备分析-设备总体趋势-数据明细（表格）
        'device/trend_summary'  =>  'Api/DeviceTotal/trend_summary',      // 设备分析-设备总体趋势-数据概览
        'device/retention'      =>  'Api/DeviceKeep/retention',           // 设备分析-设备留存
        'device/os'             =>  'Api/DeviceOs/model',                 // 设备分析-设备操作系统
        'device/model'          =>  'Api/DeviceType/model',               // 设备分析-设备型号
        'device/resolution'     =>  'Api/DeviceResolution/model',         // 设备分析-设备分辨率
        'device/active_detail'  =>  'Api/DeviceActive/active_detail',     // 设备分析-设备活跃-数据明细（表格）
        'device/active_summary' =>  'Api/DeviceActive/active_summary',    // 设备分析-设备活跃-数据概览

        


        /* 总览台 */
        '/^console\/app_manage\/(\d+)\/pages$/'     =>  'Api/console/pageManage?id=:1',        // 总览台-应用管理-位置管理
        'console/app_manage'    =>  'Api/console/appManage',              // 总览台-应用管理-列表数据获取  
        'console/app_overview'  =>  'Api/console/appOverview',            // 总览台-应用管理-列表数据获取
        




        /* 用户管理 */
        'user/login'            =>  'Api/User/login',                     // 登录

        /* app */ 
        'apps_options'          =>  'Api/App/options',                    // 应用选项
        '/^apps\/([\w|-]+)\/console$/'             =>  'Api/App/console?id=:1',                 // 控制面板
        '/^apps\/([\w|-]+)\/behavior_summary$/'    =>  'Api/App/summary?id=:1',                 // 用户行为（表格）
        '/^apps\/([\w|-]+)\/behavior_detail$/'     =>  'Api/App/behavior_detail?id=:1',         // 用户行为（详情）
        '/^apps\/([\w|-]+)\/channel$/'             =>  'Api/AppChannel/channel?id=:1',          // 渠道
        '/^apps\/([\w|-]+)\/version_options$/'     =>  'Api/AppVersion/options?id=:1',          // 版本筛选
        '/^apps\/([\w|-]+)\/version$/'             =>  'Api/AppVersion/version?id=:1',          // 版本
        '/^apps\/([\w|-]+)\/launch_frequency$/'        =>  'Api/AppStart/frequency?id=:1',          // 启动频率
        '/^apps\/([\w|-]+)\/launch_frequency_detail$/' =>  'Api/AppStart/frequency_detail?id=:1',   // 启动频率详情
        '/^apps\/([\w|-]+)\/launch_duration$/'         =>  'Api/AppStart/duration?id=:1',           // 启动时长
        '/^apps\/([\w|-]+)\/launch_duration_detail$/'  =>  'Api/AppStart/duration_detail?id=:1',    // 启动时长详情

        '/^apps\/([\w|-]+)\/areal_distribution$/'  =>  'Api/AppRegion/index?id=:1',             // 用户地域分析
        '/^apps\/([\w|-]+)\/resolution$/'          =>  'Api/AppDeviceResolution/model?id=:1',   // 分辨率
        '/^apps\/([\w|-]+)\/os$/'                  =>  'Api/AppDeviceOs/model?id=:1',           // 操作系统
        '/^apps\/([\w|-]+)\/model$/'               =>  'Api/AppDeviceType/model?id=:1',         // 设备型号
        '/^apps\/([\w|-]+)\/retention$/'           =>  'Api/AppKeep/retention?id=:1',           // 留存

        /* 事件 */
        '/^apps\/([\w|-]+)\/events_manage$/'       =>  'Api/Event/index?id=:1',
        '/^apps\/([\w|-]+)\/event_analysis$/'      =>  'Api/EventData/index?id=:1',             //  事件分析
        '/^apps\/([\w|-]+)\/events_options$/'      =>  'Api/EventDetailData/events_options?id=:1',    //  事件搜索
        '/^apps\/([\w|-]+)\/events\/([\w|-]+)\/event_detail$/'   => 'Api/EventDetailData/event_detail?app_key=:1&event_id=:2', //  事件详情表表格
        '/^apps\/([\w|-]+)\/events\/([\w|-]+)\/event_summary$/'  => 'Api/EventDetailData/event_summary?app_key=:1&event_id=:2', //  事件详情图表
        '/^apps\/([\w|-]+)\/events\/([\w|-]+)\/params_list$/'    => 'Api/EventDetailData/params_list?app_key=:1&event_id=:2', //  事件详情三级事件详情
        '/^apps\/([\w|-]+)\/events\/([\w|-]+)\/params_options$/' => 'Api/EventDetailData/params_options?app_key=:1&event_id=:2', //  事件详情三级事件详情
        '/^apps\/([\w|-]+)\/events\/([\w|-]+)\/param_detail$/'   => 'Api/EventDetailData/param_detail?app_key=:1&event_id=:2', //  事件详情三级事件详情

        /* 流量报告 */
        '/^apps\/([\w|-]+)\/acquisition\/dist$/'      => 'Api/Flow/distsDetail?app_key=:1',        // 流量报告-分发效果-详情
        '/^apps\/([\w|-]+)\/acquisition\/source$/'   => 'Api/Flow/sourcesDetail?app_key=:1',       // 流量报告-来源类型-详情
        '/^apps\/([\w|-]+)\/acquisition\/page_options$/'         => 'Api/Flow/options?app_key=:1', // 流量报告-分发效果-页面位置
        '/^apps\/([\w|-]+)\/acquisition\/dists$/'                => 'Api/Flow/dists?app_key=:1',   // 流量报告-分发效果
        '/^apps\/([\w|-]+)\/acquisition\/sources$/'              => 'Api/Flow/sources?app_key=:1', // 流量报告-来源类型
        '/^apps\/([\w|-]+)\/export_flow_dist$/'                  => 'Api/Flow/export_flow_dist?app_key=:1', // 流量报告-分发导出

        /* 沉默用户 */
        '/^apps\/([\w|-]+)\/silent_summary$/'                    => 'Api/AppSilent/summary?app_key=:1',        // 图表
        '/^apps\/([\w|-]+)\/silent_detail$/'                    =>  'Api/AppSilent/detail?app_key=:1',         // 详情

    ],

    /* 数据库配置 */
	// mysql配置
	'DB_TYPE'   => 'mysqli',
    'DB_HOST'   => '120.77.245.217',
    'DB_NAME'   => 'logistics',
    'DB_USER'   => 'manager',
    'DB_PWD'    => 'manager@123456',
    'DB_PORT'   => 53175,
    'DB_PREFIX' => '',

    // Redis配置
    'RD_CACHE'  => true,
    'RD_EXPIRE' => 86400,
    'RD_HOST'   => '127.0.0.1',
    'RD_AUTH'   => '',
    'RD_PORT'   => 6379,
    'RD_FILTER' => 'callback,_'   ,
    'RD_PREFIX' => 'bbcount',

];