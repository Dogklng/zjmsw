/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-23 14:56:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `app_order_crowd`
-- ----------------------------
DROP TABLE IF EXISTS `app_order_crowd`;
CREATE TABLE `app_order_crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `shop_id` int(11) DEFAULT '0' COMMENT '店铺id【官方店铺】 店主用户id 0为美术网',
  `order_no` varchar(255) DEFAULT '' COMMENT '订单编号',
  `crowd_id` int(11) unsigned DEFAULT NULL COMMENT '商品id ',
  `order_status` tinyint(4) DEFAULT '1' COMMENT '订单状态（0：已取消，1：待付款,2：已完成，3：已关闭，4：退款中， 5：订单删除）',
  `pay_status` tinyint(4) DEFAULT '0' COMMENT '支付状态(0:未支付，1:已支付，2:退款)',
  `order_time` int(11) DEFAULT '0' COMMENT '下单时间',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付时间',
  `pay_way` tinyint(4) DEFAULT '1' COMMENT '1支付宝支付，2银联支付，3微信支付， 4余额支付',
  `is_refund` tinyint(4) DEFAULT NULL COMMENT '是否退款0-未完成  1-完成  2-拒绝',
  `refund_type` tinyint(5) DEFAULT '0' COMMENT '退款状况0：未退款，1：申请退款，2：已受理，3：已拒绝，4：完成 , 5:确认退款',
  `refund_time` int(11) DEFAULT NULL COMMENT '退款时间',
  `refund_fee` decimal(11,2) DEFAULT NULL,
  `is_valid` tinyint(1) DEFAULT '1' COMMENT '是否有效（0，取消订单；1有效订单）',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '系统内部交易单号',
  `trade_no` varchar(255) DEFAULT NULL COMMENT '支付平台交易单号',
  `invoice_type` text COMMENT '发票类型\n001 纸质发票-冠名发票 \n002 纸质发票-增值专票 \n003 纸质发票-增值普票 \n004 电子发票-增值专票 \n005 电子发票-增值普票',
  `invoice_title` text COMMENT '发票抬头',
  `invoice_company` varchar(100) DEFAULT NULL,
  `invoice_taxpayer_id` varchar(80) DEFAULT NULL,
  `source` tinyint(4) DEFAULT NULL COMMENT '订单来源【1.PC官网，2.移动官网、3.移动pc、4微信商城】',
  `balance` decimal(11,2) DEFAULT '0.00' COMMENT '余额支付--账户剩余金额',
  `total_fee` decimal(10,0) DEFAULT '0' COMMENT '订单金额',
  `pay_price` decimal(10,0) DEFAULT '0' COMMENT '实际付款',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of app_order_crowd
-- ----------------------------
INSERT INTO `app_order_crowd` VALUES ('8', '68', '0', 'ZC201710231424347616', '32', '1', '0', '1508739874', '0', '1', null, '0', null, null, '1', null, null, null, null, null, null, null, '0.00', '5000', '0');
INSERT INTO `app_order_crowd` VALUES ('3', '68', '0', 'ZC201710231037197952', '32', '1', '0', '1508726239', '0', '1', null, '0', null, null, '1', null, null, null, null, null, null, null, '0.00', null, '0');
INSERT INTO `app_order_crowd` VALUES ('4', '68', '0', 'ZC201710231055547754', '32', '1', '0', '1508727354', '0', '1', null, '0', null, null, '1', null, null, null, null, null, null, null, '0.00', null, '0');
INSERT INTO `app_order_crowd` VALUES ('5', '67', '0', 'ZC201710231059014240', '32', '1', '0', '1508727541', '0', '1', null, '0', null, null, '1', null, null, null, null, null, null, null, '0.00', null, '0');
INSERT INTO `app_order_crowd` VALUES ('6', '68', '0', 'ZC201710231104257249', '32', '1', '0', '1508727865', '0', '1', null, '0', null, null, '1', null, null, null, null, null, null, null, '0.00', null, '0');
INSERT INTO `app_order_crowd` VALUES ('7', '68', '0', 'ZC201710231110058020', '32', '1', '0', '1508728205', '0', '1', null, '0', null, null, '1', null, null, null, null, null, null, null, '0.00', '5000', '0');
