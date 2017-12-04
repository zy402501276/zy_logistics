/*
Navicat MySQL Data Transfer

Source Server         : apache
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : logistics

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-12-04 17:14:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `distribute`
-- ----------------------------
DROP TABLE IF EXISTS `distribute`;
CREATE TABLE `distribute` (
  `id` int(11) unsigned NOT NULL COMMENT '接单表主键id',
  `userId` int(11) unsigned DEFAULT NULL COMMENT '用户-关联user表主键',
  `type` tinyint(3) unsigned DEFAULT '1' COMMENT '接单状态[1申请接单 |2已结单 |3取消]',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1正常 | 0 禁用]',
  `createTime` int(40) unsigned DEFAULT NULL COMMENT '新增时间',
  `updateTime` int(40) unsigned DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='接单表';

-- ----------------------------
-- Records of distribute
-- ----------------------------

-- ----------------------------
-- Table structure for `driveraddress`
-- ----------------------------
DROP TABLE IF EXISTS `driveraddress`;
CREATE TABLE `driveraddress` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '司机位置表主键',
  `longitude` varchar(20) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(20) DEFAULT NULL COMMENT '纬度',
  `driverId` int(11) unsigned DEFAULT NULL COMMENT '司机',
  `createTime` int(40) unsigned DEFAULT NULL COMMENT '新增时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='司机位置表';

-- ----------------------------
-- Records of driveraddress
-- ----------------------------
INSERT INTO `driveraddress` VALUES ('1', '3', '1', '2', '1512369714');
INSERT INTO `driveraddress` VALUES ('2', '3', '3', '3', '1512369724');

-- ----------------------------
-- Table structure for `loginlog`
-- ----------------------------
DROP TABLE IF EXISTS `loginlog`;
CREATE TABLE `loginlog` (
  `id` int(11) unsigned NOT NULL COMMENT '登录日志表主键',
  `userId` int(11) unsigned DEFAULT NULL COMMENT '用户-关联user表主键',
  `userName` varchar(40) DEFAULT NULL COMMENT '用户名',
  `userType` tinyint(4) unsigned DEFAULT '1' COMMENT '用户身份[1司机 | 2 货主 | 3车队]',
  `isLogin` tinyint(3) unsigned DEFAULT '1' COMMENT '登录状态[1已登录 |0注销]',
  `ip` varchar(40) DEFAULT NULL COMMENT '登录ip',
  `userAgent` tinyint(3) unsigned DEFAULT '1' COMMENT '设备类型[1手机 | 2pc]',
  `loginTime` int(40) unsigned DEFAULT NULL COMMENT '登录时间',
  `logoutTime` int(40) unsigned DEFAULT NULL COMMENT '登出时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='登录日志表';

-- ----------------------------
-- Records of loginlog
-- ----------------------------

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表主键id',
  `userId` int(11) unsigned DEFAULT NULL COMMENT '用户-关联user表主键',
  `orderType` tinyint(3) unsigned DEFAULT '1' COMMENT '订单类型[1标准货物 | 2非标准货物]',
  `transType` tinyint(3) unsigned DEFAULT '1' COMMENT '运输类型[1 正常模式 | 2 拼车模式]',
  `vehicleType` tinyint(3) unsigned DEFAULT '1' COMMENT '用车类型[1 重量体积 |2 包车]',
  `desc` varchar(40) DEFAULT NULL COMMENT '备注',
  `loadRate` varchar(20) DEFAULT NULL COMMENT '装货率',
  `sumPrice` varchar(20) DEFAULT NULL COMMENT '总费用',
  `orderNum` varchar(30) DEFAULT NULL COMMENT '订单号',
  `orderState` tinyint(5) unsigned DEFAULT '1' COMMENT '订单状态',
  `departArea` varchar(40) DEFAULT NULL COMMENT '出发地址(快照)',
  `destArea` varchar(40) DEFAULT NULL COMMENT '目的地址(快照)',
  `departTime` int(40) unsigned DEFAULT NULL COMMENT '出发时间',
  `arrivedTime` int(40) unsigned DEFAULT NULL COMMENT '到货时间',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1正常 | 0失效]',
  `createTime` int(40) unsigned DEFAULT NULL COMMENT '新增时间',
  `updateTime` int(40) unsigned DEFAULT NULL COMMENT '最后更新时间',
  `driverId` int(11) unsigned DEFAULT NULL COMMENT '司机-关联user表主键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '1', '1', '1', '1', '第一笔订单', '80', '600', '123456adbcd', '2', '广东省 深圳市 南山区 中山大学', '广东省 惠州市 CBD 万达广场', '1512318454', '1512403200', '1', '1512105949', '1512105949', '1');
INSERT INTO `order` VALUES ('2', '1', '1', '1', '1', '第二笔订单', '90', '1000', '123123123', '3', '广东省 深圳市 南山区 中山大学', '广东省 惠州市 CBD 万达广场', '1512403300', '1512576000', '1', '1512489600', '1512376295', '2');

-- ----------------------------
-- Table structure for `ordercharger`
-- ----------------------------
DROP TABLE IF EXISTS `ordercharger`;
CREATE TABLE `ordercharger` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单-负责人表主键id',
  `orderId` int(11) unsigned DEFAULT NULL COMMENT '订单-关联order表主键',
  `name` varchar(20) DEFAULT NULL COMMENT '负责人姓名',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `area` varchar(40) DEFAULT NULL COMMENT '地理位置',
  `address` varchar(30) DEFAULT NULL COMMENT '具体位置',
  `startTime` int(40) unsigned DEFAULT NULL COMMENT '装卸货开始时间',
  `endTime` int(40) unsigned DEFAULT NULL COMMENT '装卸货结束时间',
  `type` tinyint(3) unsigned DEFAULT '1' COMMENT '类型[1 装货 | 2 卸货]',
  `photo` varchar(60) DEFAULT NULL COMMENT '装卸货照片',
  `signature` varchar(60) DEFAULT NULL COMMENT '签字照片',
  `longitude` varchar(20) DEFAULT NULL COMMENT '经度',
  `latitude` varchar(20) DEFAULT NULL COMMENT '纬度',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1 正常 | 0 禁用]',
  `createTime` int(40) unsigned DEFAULT NULL COMMENT '新增时间',
  `updateTime` int(40) unsigned DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='订单负责人';

-- ----------------------------
-- Records of ordercharger
-- ----------------------------
INSERT INTO `ordercharger` VALUES ('1', '1', '小王', '110', '深圳市 南山区', '广door人', '1512111909', '1514736000', '1', null, null, null, null, '1', null, null);
INSERT INTO `ordercharger` VALUES ('2', '1', '老王', '123', '惠州市 惠州路', ' 老乡', '1519837260', '1522515660', '2', null, null, null, null, '1', null, null);

-- ----------------------------
-- Table structure for `ordergoods`
-- ----------------------------
DROP TABLE IF EXISTS `ordergoods`;
CREATE TABLE `ordergoods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单-货物表主键id',
  `orderId` int(11) unsigned DEFAULT NULL COMMENT '订单-关联order表主键',
  `goodsName` varchar(20) DEFAULT NULL COMMENT '货物名',
  `goodsLength` varchar(20) DEFAULT NULL COMMENT '长',
  `goodsWidth` varchar(20) DEFAULT NULL COMMENT '宽',
  `goodsHeight` varchar(20) DEFAULT NULL COMMENT '高',
  `goodsWeight` varchar(20) DEFAULT NULL COMMENT '重量',
  `count` varchar(20) DEFAULT NULL COMMENT '数量',
  `goodsType` int(11) unsigned DEFAULT NULL COMMENT '货物类型-关联GoodsType表主键',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1正常 |0禁用]',
  `createTime` int(40) unsigned DEFAULT NULL COMMENT '新增时间',
  `updateTime` int(40) unsigned DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='订单货物表';

-- ----------------------------
-- Records of ordergoods
-- ----------------------------
INSERT INTO `ordergoods` VALUES ('1', '1', '货物1', '1', '2', '3.0', '4', '100', '1', '1', null, null);

-- ----------------------------
-- Table structure for `orderimg`
-- ----------------------------
DROP TABLE IF EXISTS `orderimg`;
CREATE TABLE `orderimg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '图片表id',
  `img` varchar(60) DEFAULT NULL COMMENT '图片路径',
  `type` tinyint(3) unsigned DEFAULT NULL COMMENT '类型[1装货 |2 卸货 | 3装货签字 | 4卸货签字]',
  `orderid` int(11) unsigned DEFAULT NULL COMMENT '订单id',
  `createTime` int(40) DEFAULT NULL COMMENT '新增时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderimg
-- ----------------------------
INSERT INTO `orderimg` VALUES ('1', './Upload/20171204/5a2506c16a4d2.jpg1', '1', '1', '1512376071');
INSERT INTO `orderimg` VALUES ('2', './Upload/20171204/5a2506c16a4d2.jpg', '1', '2', '1512376295');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表主键id',
  `account` varchar(40) DEFAULT NULL COMMENT '账号',
  `pwd` varchar(32) DEFAULT NULL COMMENT '密码',
  `userName` varchar(20) DEFAULT NULL COMMENT '用户名',
  `mobile` varchar(30) DEFAULT NULL COMMENT '手机',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `role` tinyint(4) unsigned DEFAULT '1' COMMENT '用户类型[1 司机 | 2 货主 | 3车队]',
  `utoken` varchar(20) DEFAULT NULL COMMENT '用户令牌',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1 正常 | 0禁用]',
  `createTime` int(40) DEFAULT NULL COMMENT '新增时间',
  `updateTime` int(40) unsigned DEFAULT NULL COMMENT '最后更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '小野君', '0890c785bd9e23fc5df3d39e5425834c', '18649717819', '18649717819', '4012000@qq.com', '1', '123456789', '1', '1512105949', '1512105949');
INSERT INTO `user` VALUES ('2', '小野君2号', '0890c785bd9e23fc5df3d39e5425834c', '13823517819', '13823517819', '4012000@qq.com', '1', '3214567', '1', '1512105949', null);
INSERT INTO `user` VALUES ('5', '小野君4', '0890c785bd9e23fc5df3d39e5425834c', '18649717813', null, '402501276@qq.com', '1', null, '1', '1512316160', '1512316160');
