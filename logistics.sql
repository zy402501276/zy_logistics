/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : logistics

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-12-09 13:10:30
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
-- Table structure for `driverinfo`
-- ----------------------------
DROP TABLE IF EXISTS `driverinfo`;
CREATE TABLE `driverinfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `licence` varchar(20) DEFAULT NULL COMMENT '车牌',
  `vehicleType` varchar(20) DEFAULT NULL COMMENT '车辆类型',
  `userId` int(11) unsigned DEFAULT NULL COMMENT '司机-关联user表主键',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of driverinfo
-- ----------------------------
INSERT INTO `driverinfo` VALUES ('1', '123213', '卡车', '2');

-- ----------------------------
-- Table structure for `goodstype`
-- ----------------------------
DROP TABLE IF EXISTS `goodstype`;
CREATE TABLE `goodstype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) DEFAULT NULL COMMENT '类型',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1正常 | 0 禁用]',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of goodstype
-- ----------------------------
INSERT INTO `goodstype` VALUES ('1', '固体', '1');
INSERT INTO `goodstype` VALUES ('2', '液体', '1');

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
  `loadRate` varchar(20) DEFAULT NULL COMMENT '装货率',
  `sumPrice` varchar(20) DEFAULT NULL COMMENT '总费用',
  `orderNum` varchar(30) DEFAULT NULL COMMENT '订单号',
  `orderState` tinyint(5) unsigned DEFAULT '1' COMMENT '订单状态',
  `departArea` varchar(40) DEFAULT NULL COMMENT '出发地址(快照)',
  `destArea` varchar(40) DEFAULT NULL COMMENT '目的地址(快照)',
  `departTime` int(11) unsigned DEFAULT NULL COMMENT '出发时间',
  `arrivedTime` int(11) unsigned DEFAULT NULL COMMENT '到货时间',
  `state` tinyint(3) unsigned DEFAULT '1' COMMENT '状态[1正常 | 0失效]',
  `createTime` int(11) unsigned DEFAULT NULL COMMENT '新增时间',
  `updateTime` int(11) unsigned DEFAULT NULL COMMENT '最后更新时间',
  `driverId` int(11) unsigned DEFAULT NULL COMMENT '司机-关联user表主键',
  `distributeTime` int(11) unsigned DEFAULT NULL COMMENT '接单时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('5', '1', '1', '1', '1', '', '', '17120823253251278137', '8', '广东省  深圳市  福田区   华富街道  莲花路中山大学', '广东省  深圳市  福田区   园岭街道  红荔路中山大学2', '1512751719', '1512739020', '1', '1512748337', '1512750947', '2', '1512748337');
INSERT INTO `order` VALUES ('6', '1', '2', '1', '2', '', '', '17120823023787537445', '1', '广东省  深圳市  福田区   华富街道  莲科一路打发发呆', '广东省  深圳市  福田区   园岭街道  园岭中路adsf', '1512666000', '1512739020', '1', '1512748599', '1512748599', '2', '1512748337');

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
  `desc` varchar(40) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='订单负责人';

-- ----------------------------
-- Records of ordercharger
-- ----------------------------
INSERT INTO `ordercharger` VALUES ('5', '5', '老王', '12345678911', '广东省  深圳市  福田区   华富街道  莲花路', '中山大学', '1512748119', '1512751719', '1', null, null, '114.067991218923', '22.559365604240295', '1', '1512748337', '1512748337', '111');
INSERT INTO `ordercharger` VALUES ('6', '5', '小王', '1231332131', '广东省  深圳市  福田区   园岭街道  红荔路', '中山大学2', '1512735420', '1512739020', '2', null, null, '114.09751697575894', '114.09751697575894', '1', '1512748337', '1512748337', 'adfasf');
INSERT INTO `ordercharger` VALUES ('7', '6', '131', '123131', '广东省  深圳市  福田区   华富街道  莲科一路', '打发发呆', '1512662400', '1512666000', '1', null, null, '114.07176776921597', '22.56190200143603', '1', '1512748599', '1512748599', '13123213');
INSERT INTO `ordercharger` VALUES ('8', '6', '阿道夫', 'a1231323', '广东省  深圳市  福田区   园岭街道  园岭中路', 'adsf', '1512735420', '1512739020', '2', null, null, '114.09957691228237', '114.09957691228237', '1', '1512748599', '1512748599', '12313');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='订单货物表';

-- ----------------------------
-- Records of ordergoods
-- ----------------------------
INSERT INTO `ordergoods` VALUES ('1', '3', '货物1', '1', '2', '3.0', '4', '100', '1', '1', null, null);
INSERT INTO `ordergoods` VALUES ('2', '3', '23', '3123', '3', '32', '3', '123', '2', '1', null, null);
INSERT INTO `ordergoods` VALUES ('3', '5', '获取', '1', '2', '3', '4', '6', '1', '1', '1512748337', '1512748337');
INSERT INTO `ordergoods` VALUES ('4', '6', '货物2', '3', '2', '1', '3', '13', '1', '1', '1512748599', '1512748599');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderimg
-- ----------------------------
INSERT INTO `orderimg` VALUES ('1', '20171204/5a2506c16a4d2.jpg', '1', '3', '1512376071');
INSERT INTO `orderimg` VALUES ('2', '20171204/5a2506c16a4d2.jpg', '2', '3', '1512376295');
INSERT INTO `orderimg` VALUES ('3', '20171204/5a2506c16a4d2.jpg', '3', '3', '1512376295');
INSERT INTO `orderimg` VALUES ('4', '20171204/5a2506c16a4d2.jpg', '4', '3', '1512376295');

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
  `avatar` varchar(60) DEFAULT NULL COMMENT '头像',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '小野君', '0890c785bd9e23fc5df3d39e5425834c', '18649717819', '18649717819', '4012000@qq.com', '1', '123456789', '1', '1512105949', '1512105949', null);
INSERT INTO `user` VALUES ('2', '小野君2号', '0890c785bd9e23fc5df3d39e5425834c', '13823517819', '13823517819', '4012000@qq.com', '1', '3214567', '1', '1512105949', null, '20171204/5a2506c16a4d2.jpg');
INSERT INTO `user` VALUES ('7', '小野菌', '0890c785bd9e23fc5df3d39e5425834c', '18649717815', null, null, '1', null, '1', '1512388971', '1512388971', null);
