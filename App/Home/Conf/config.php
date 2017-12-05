<?php
return [
	/* 模板相关配置 */
    'TMPL_PARSE_STRING'     => [
        '__ASSETS__'      	=> __ROOT__ . '/Public/' . MODULE_NAME . '/assets',
        '__IMG__'           => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '__CSS__'           => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'            => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__SND__'           => __ROOT__ . '/Public/' . MODULE_NAME . '/snd'
    ],
    //开启模板布局
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'layout/layout',
];