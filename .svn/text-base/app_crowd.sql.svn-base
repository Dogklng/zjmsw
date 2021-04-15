/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : ms

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-10-23 14:57:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `app_crowd`
-- ----------------------------
DROP TABLE IF EXISTS `app_crowd`;
CREATE TABLE `app_crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) DEFAULT NULL COMMENT '众筹作品名称',
  `logo_pic` varchar(255) DEFAULT NULL COMMENT '作品logo(小)',
  `index_pic` varchar(255) DEFAULT NULL COMMENT '作品展示图片（大）',
  `goods_skin` varchar(255) DEFAULT NULL COMMENT '材质',
  `goods_range` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '尺寸',
  `goods_care` varchar(255) DEFAULT NULL COMMENT '上市时间',
  `num` int(10) DEFAULT '0' COMMENT '点击量',
  `cate_id` int(10) unsigned DEFAULT '0' COMMENT '分类id',
  `goods_cap` varchar(255) DEFAULT NULL COMMENT '作者',
  `goods_cap_pic` varchar(255) DEFAULT NULL COMMENT '作者图片',
  `goods_cap_des` text COMMENT '作品作者介绍',
  `desc` text COMMENT '作品介绍',
  `start` varchar(255) DEFAULT NULL COMMENT '起始时间',
  `end` varchar(255) DEFAULT NULL COMMENT '结束时间',
  `total_price` decimal(10,0) DEFAULT NULL COMMENT '目标价格',
  `per_price` decimal(10,0) DEFAULT NULL COMMENT '众筹一股单价',
  `is_del` tinyint(4) unsigned DEFAULT '0' COMMENT '是否删除 1是删除 0未删除',
  `shenhe` tinyint(4) DEFAULT '0' COMMENT '审核:0.待审核1.通过2.拒绝',
  `promulgator` tinyint(2) DEFAULT '1' COMMENT '发布者0.会员1.美术网平台',
  `create_at` varchar(20) DEFAULT NULL COMMENT '发布日期',
  `zcb_desc` text COMMENT '资产包介绍',
  `is_zc` tinyint(2) unsigned DEFAULT '0' COMMENT '众筹状态 1众筹结束 0众筹中',
  `gz` decimal(11,0) DEFAULT NULL COMMENT '估值',
  `crgf` int(10) DEFAULT '100' COMMENT '出让股份',
  `mini` decimal(10,0) DEFAULT NULL COMMENT '起投金额',
  `is_sale1` tinyint(5) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='众筹作品表';

-- ----------------------------
-- Records of app_crowd
-- ----------------------------
INSERT INTO `app_crowd` VALUES ('32', '众象不可说', '/Uploads/Picture/uploads/20171021/59eaf6e86e85d.png', '/Uploads/Picture/uploads/20171021/59eaf6ea7de75.png', '木质', ' 60cm*80cm', '2000', '84', '5', '蓝正辉', '/Uploads/Picture/uploads/20171021/59eaf6e548ae5.jpg', '蓝正辉资深艺术家。1959年 生于四川省隆昌 2003年 《水墨疾走》个展及研讨会，广东美术馆，中国广东 2004年 《景德镇1000年庆典——蓝正辉水墨特展》，景德镇，中国江西 《水墨疾走》大多伦多中华文化中心，多伦多，加拿大 2005年 《飞流直下大瀑布》，多伦多，加拿大 2006年 《“水墨•当代”——中国宋庄水墨同盟首届邀请展》，宋庄，中国北京 《“东方欲晓“——蓝正辉体量水墨展”》', ' 有幸生长在大时代，如果不选择画画，我必将消失在平庸里。在画室过着隐居的日子，使我有意无意间与社会保持了距离，因此没那么容易轻信与盲从，不去膜拜也不去狂热。总有太多曾经的真实成为了现在的泡沫，谁也不知道最后还会剩下什么，所以人们在不安中放弃了对神灵的敬畏、对精神家园的坚守，开始慢慢的习惯于失去信仰的生活。失去信仰的我是茫然的，也是自由的。日复一日画气泡便成为我用以净心的修行，每一个气泡都是生命与时代，无论大小，破裂后它们都无踪无影。每次当我感到茫然时，真希望有神灵存在并得到指引，但他们却像是传说，', '1507132800', '1508860800', '50', '5000', '0', '1', '1', null, '&lt;p&gt;1&lt;/p&gt;&lt;p&gt;2&lt;/p&gt;&lt;p&gt;3&lt;/p&gt;&lt;p&gt;4&lt;/p&gt;', '0', '10', '100', '5', '1');
INSERT INTO `app_crowd` VALUES ('35', '恣意的泼笔', '/Uploads/Picture/uploads/20171023/59ed87d9eec50.jpg', '/Uploads/Picture/uploads/20171023/59ed87dc88ea0.jpg', '木质', ' 60cm*80cm', '2000', '0', '9', '蓝正辉', '/Uploads/Picture/uploads/20171023/59ed87d4ee098.png', '蓝正辉资深艺术家。1959年 生于四川省隆昌 2003年 《水墨疾走》个展及研讨会，广东美术馆，中国广东 2004年 《景德镇1000年庆典——蓝正辉水墨特展》，景德镇，中国江西 《水墨疾走》大多伦多中华文化中心，多伦多，加拿大 2005年 《飞流直下大瀑布》，多伦多，加拿大 2006年 《“水墨•当代”——中国宋庄水墨同盟首届邀请展》，宋庄，中国北京 《“东方欲晓“——蓝正辉体量水墨展”》', '有幸生长在大时代，如果不选择画画，我必将消失在平庸里。在画室过着隐居的日子，使我有意无意间与社会保持了距离，因此没那么容易轻信与盲从，不去膜拜也不去狂热。总有太多曾经的真实成为了现在的泡沫，谁也不知道最后还会剩下什么，所以人们在不安中放弃了对神灵的敬畏、对精神家园的坚守，开始慢慢的习惯于失去信仰的生活。失去信仰的我是茫然的，也是自由的。日复一日画气泡便成为我用以净心的修行，每一个气泡都是生命与时代，无论大小，破裂后它们都无踪无影。\r\n\r\n每次当我感到茫然时，真希望有神灵存在并得到指引，但他们却像是传说，使', '1507564800', '1508169600', null, '10000', '0', '0', '1', '1508739105', null, '0', '25', '100', '3', '1');
