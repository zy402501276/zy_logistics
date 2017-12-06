<?php
return [
	/* 模板相关配置 */
    'TMPL_PARSE_STRING'     => [
        '__ASSETS__'      	=> __ROOT__ . '/Public/' . MODULE_NAME . '/assets',
        '__IMG__'           => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '__CSS__'           => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'            => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__LAYDATE__'       => __ROOT__ . '/Public/' . MODULE_NAME . '/laydate'
    ],
    //开启模板布局
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'layout/layout',
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'logistics',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  '',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    'DB_FIELDS_CACHE'       =>  false,        // 启用字段缓存
    'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
];