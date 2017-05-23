/*
Navicat MySQL Data Transfer

Source Server         : 111
Source Server Version : 50709
Source Host           : localhost:3306
Source Database       : zjxm

Target Server Type    : MYSQL
Target Server Version : 50709
File Encoding         : 65001

Date: 2017-05-23 09:17:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for p_admin
-- ----------------------------
DROP TABLE IF EXISTS `p_admin`;
CREATE TABLE `p_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='管理用户表';

-- ----------------------------
-- Records of p_admin
-- ----------------------------
INSERT INTO `p_admin` VALUES ('1', 'admin', '21232f297a57a5a743894a0e4a801fc3');
INSERT INTO `p_admin` VALUES ('2', 'root', 'root');
INSERT INTO `p_admin` VALUES ('3', 'goods', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `p_admin` VALUES ('4', '111', '698d51a19d8a121ce581499d7b701668');
INSERT INTO `p_admin` VALUES ('5', '222', 'bcbe3365e6ac95ea2c0343a2395834dd');

-- ----------------------------
-- Table structure for p_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `p_admin_role`;
CREATE TABLE `p_admin_role` (
  `admin_id` mediumint(8) unsigned NOT NULL COMMENT '管理ID',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色ID',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理角色关系表';

-- ----------------------------
-- Records of p_admin_role
-- ----------------------------
INSERT INTO `p_admin_role` VALUES ('5', '1');
INSERT INTO `p_admin_role` VALUES ('5', '2');

-- ----------------------------
-- Table structure for p_attribute
-- ----------------------------
DROP TABLE IF EXISTS `p_attribute`;
CREATE TABLE `p_attribute` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `attr_type` enum('唯一','可选') NOT NULL COMMENT '属性类型',
  `attr_option_values` varchar(300) NOT NULL DEFAULT '' COMMENT '属性可选值',
  `type_id` mediumint(8) unsigned NOT NULL COMMENT '类型Id',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='属性表';

-- ----------------------------
-- Records of p_attribute
-- ----------------------------
INSERT INTO `p_attribute` VALUES ('1', '颜色', '可选', '白色,银色,黑色,玫瑰金', '1');
INSERT INTO `p_attribute` VALUES ('2', '尺寸', '可选', '4.8寸,5寸,5.5寸,6寸', '1');
INSERT INTO `p_attribute` VALUES ('5', '手机内存', '可选', '1GB,2GB,4GB', '1');
INSERT INTO `p_attribute` VALUES ('6', '生产日期', '唯一', '', '1');

-- ----------------------------
-- Table structure for p_brand
-- ----------------------------
DROP TABLE IF EXISTS `p_brand`;
CREATE TABLE `p_brand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `brand_name` varchar(150) NOT NULL COMMENT '品牌名称',
  `site_url` varchar(150) NOT NULL DEFAULT '' COMMENT '官网地址',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌logo图片',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='品牌';

-- ----------------------------
-- Records of p_brand
-- ----------------------------
INSERT INTO `p_brand` VALUES ('2', '11', '11', 'Brand/2017-05-10/5912d557b2746.jpg');

-- ----------------------------
-- Table structure for p_category
-- ----------------------------
DROP TABLE IF EXISTS `p_category`;
CREATE TABLE `p_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID，0为顶级分类',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否楼层推荐',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='分类表';

-- ----------------------------
-- Records of p_category
-- ----------------------------
INSERT INTO `p_category` VALUES ('1', '家用电器', '0', '是');
INSERT INTO `p_category` VALUES ('2', '手机、数码、京东通信', '0', '是');
INSERT INTO `p_category` VALUES ('3', '电脑、办公', '0', '否');
INSERT INTO `p_category` VALUES ('4', '家居、家具、家装、厨具', '0', '否');
INSERT INTO `p_category` VALUES ('5', '男装、女装、内衣、珠宝', '0', '否');
INSERT INTO `p_category` VALUES ('6', '个护化妆', '0', '否');
INSERT INTO `p_category` VALUES ('8', '运动户外', '0', '否');
INSERT INTO `p_category` VALUES ('9', '汽车、汽车用品', '0', '否');
INSERT INTO `p_category` VALUES ('10', '母婴、玩具乐器', '0', '否');
INSERT INTO `p_category` VALUES ('11', '食品、酒类、生鲜、特产', '0', '否');
INSERT INTO `p_category` VALUES ('12', '营养保健', '0', '否');
INSERT INTO `p_category` VALUES ('13', '图书、音像、电子书', '0', '否');
INSERT INTO `p_category` VALUES ('14', '彩票、旅行、充值、票务', '0', '否');
INSERT INTO `p_category` VALUES ('15', '理财、众筹、白条、保险', '0', '否');
INSERT INTO `p_category` VALUES ('16', '大家电', '1', '是');
INSERT INTO `p_category` VALUES ('17', '生活电器', '1', '是');
INSERT INTO `p_category` VALUES ('18', '厨房电器', '1', '否');
INSERT INTO `p_category` VALUES ('19', '个护健康', '1', '是');
INSERT INTO `p_category` VALUES ('20', '五金家装', '1', '是');
INSERT INTO `p_category` VALUES ('21', 'iphone', '2', '是');
INSERT INTO `p_category` VALUES ('22', '冰箱', '16', '是');
INSERT INTO `p_category` VALUES ('23', '空调', '16', '否');
INSERT INTO `p_category` VALUES ('24', '变频空调', '23', '否');

-- ----------------------------
-- Table structure for p_goods
-- ----------------------------
DROP TABLE IF EXISTS `p_goods`;
CREATE TABLE `p_goods` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `is_on_sale` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  `is_delete` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否放到回收站',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '原图',
  `sm_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '小图',
  `mid_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '中图',
  `big_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '大图',
  `mbig_logo` varchar(150) NOT NULL DEFAULT '' COMMENT '更大图',
  `brand_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '品牌ID',
  `cate_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '主分类ID',
  `type_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '类型ID',
  `promote_price` decimal(10,2) DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_date` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `promote_end_date` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '结束时间',
  `is_new` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否新品',
  `is_hot` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否热卖',
  `is_best` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否精品',
  `sort_num` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '排序的数字',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否楼层推荐',
  PRIMARY KEY (`id`),
  KEY `shop_price` (`shop_price`),
  KEY `addtime` (`addtime`),
  KEY `is_on_sale` (`is_on_sale`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='商品';

-- ----------------------------
-- Records of p_goods
-- ----------------------------
INSERT INTO `p_goods` VALUES ('2', '钱币1', '100.00', '80.00', '<p>1111</p>', '是', '否', '2017-04-18 11:21:47', 'Goods/2017-04-18/58f5864ae9844.png', 'Goods/2017-04-18/sm_58f5864ae9844.png', 'Goods/2017-04-18/mid_58f5864ae9844.png', 'Goods/2017-04-18/big_58f5864ae9844.png', 'Goods/2017-04-18/mbig_58f5864ae9844.png', '0', '1', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('3', '钱币2', '1300.00', '1200.00', '<p>范德萨发生11111</p>', '是', '否', '2017-04-19 11:10:39', 'Goods/2017-04-19/58f6da8777a2c.jpg', 'Goods/2017-04-19/sm_58f6da8777a2c.jpg', 'Goods/2017-04-19/mid_58f6da8777a2c.jpg', 'Goods/2017-04-19/big_58f6da8777a2c.jpg', 'Goods/2017-04-19/mbig_58f6da8777a2c.jpg', '2', '0', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('5', '发的发', '11221.00', '1213.00', '<p>范德萨发生</p>', '是', '否', '2017-04-19 17:19:22', 'Goods/2017-04-19/58f72b9a1b5e6.jpg', 'Goods/2017-04-19/thumb_3_58f72b9a1b5e6.jpg', 'Goods/2017-04-19/thumb_2_58f72b9a1b5e6.jpg', 'Goods/2017-04-19/thumb_1_58f72b9a1b5e6.jpg', 'Goods/2017-04-19/thumb_0_58f72b9a1b5e6.jpg', '0', '0', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('6', '111', '11111.00', '11111111.00', '<p>111111111111</p>', '是', '否', '2017-04-20 10:48:11', 'Goods/2017-04-20/58f8216a8837f.jpg', 'Goods/2017-04-20/thumb_3_58f8216a8837f.jpg', 'Goods/2017-04-20/thumb_2_58f8216a8837f.jpg', 'Goods/2017-04-20/thumb_1_58f8216a8837f.jpg', 'Goods/2017-04-20/thumb_0_58f8216a8837f.jpg', '2', '17', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '是');
INSERT INTO `p_goods` VALUES ('7', '111', '111.00', '110.00', '<p>123123</p>', '是', '否', '2017-04-21 10:08:39', 'Goods/2017-04-21/58f969a676455.jpg', 'Goods/2017-04-21/thumb_3_58f969a676455.jpg', 'Goods/2017-04-21/thumb_2_58f969a676455.jpg', 'Goods/2017-04-21/thumb_1_58f969a676455.jpg', 'Goods/2017-04-21/thumb_0_58f969a676455.jpg', '2', '1', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('8', '放水电费是', '100.00', '99.00', '', '是', '否', '2017-04-24 16:22:16', 'Goods/2017-04-24/58fdb5b780407.jpg', 'Goods/2017-04-24/thumb_3_58fdb5b780407.jpg', 'Goods/2017-04-24/thumb_2_58fdb5b780407.jpg', 'Goods/2017-04-24/thumb_1_58fdb5b780407.jpg', 'Goods/2017-04-24/thumb_0_58fdb5b780407.jpg', '2', '1', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('9', '范德萨发', '100.00', '99.00', '', '是', '否', '2017-04-24 16:23:18', 'Goods/2017-04-24/58fdb5f579fe2.jpg', 'Goods/2017-04-24/thumb_3_58fdb5f579fe2.jpg', 'Goods/2017-04-24/thumb_2_58fdb5f579fe2.jpg', 'Goods/2017-04-24/thumb_1_58fdb5f579fe2.jpg', 'Goods/2017-04-24/thumb_0_58fdb5f579fe2.jpg', '2', '17', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '是');
INSERT INTO `p_goods` VALUES ('10', '11', '1.00', '1.00', '', '是', '否', '2017-04-24 17:09:34', 'Goods/2017-04-24/58fdc0cd2d563.jpg', 'Goods/2017-04-24/thumb_3_58fdc0cd2d563.jpg', 'Goods/2017-04-24/thumb_2_58fdc0cd2d563.jpg', 'Goods/2017-04-24/thumb_1_58fdc0cd2d563.jpg', 'Goods/2017-04-24/thumb_0_58fdc0cd2d563.jpg', '2', '1', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('11', '111', '111.00', '11.00', '', '是', '否', '2017-04-24 17:17:03', 'Goods/2017-04-24/58fdc28e8fd47.jpg', 'Goods/2017-04-24/thumb_3_58fdc28e8fd47.jpg', 'Goods/2017-04-24/thumb_2_58fdc28e8fd47.jpg', 'Goods/2017-04-24/thumb_1_58fdc28e8fd47.jpg', 'Goods/2017-04-24/thumb_0_58fdc28e8fd47.jpg', '2', '1', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '100', '否');
INSERT INTO `p_goods` VALUES ('13', '科龙空调', '1111.00', '111.00', '<p>范德萨发</p>', '是', '否', '2017-04-26 09:23:49', 'Goods/2017-05-12/59157e3d568e5.jpg', 'Goods/2017-05-12/sm_59157e3d568e5.jpg', 'Goods/2017-05-12/mid_59157e3d568e5.jpg', 'Goods/2017-05-12/big_59157e3d568e5.jpg', 'Goods/2017-05-12/mbig_59157e3d568e5.jpg', '2', '1', '0', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '否', '否', '否', '120', '是');
INSERT INTO `p_goods` VALUES ('14', '12121', '1111.00', '1111.00', '<p>发顺丰</p>', '是', '否', '2017-04-26 09:28:05', 'Goods/2017-05-12/59157e207ea9a.jpg', 'Goods/2017-05-12/sm_59157e207ea9a.jpg', 'Goods/2017-05-12/mid_59157e207ea9a.jpg', 'Goods/2017-05-12/big_59157e207ea9a.jpg', 'Goods/2017-05-12/mbig_59157e207ea9a.jpg', '2', '1', '0', '99.00', '2017-05-10 00:00:00', '2017-05-10 23:59:00', '是', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('15', '范德萨发', '100.00', '100.00', '<p>范德萨发</p>', '是', '否', '2017-04-26 09:40:16', 'Goods/2017-05-12/5915560aaae39.jpg', 'Goods/2017-05-12/sm_5915560aaae39.jpg', 'Goods/2017-05-12/mid_5915560aaae39.jpg', 'Goods/2017-05-12/big_5915560aaae39.jpg', 'Goods/2017-05-12/mbig_5915560aaae39.jpg', '2', '16', '1', '999.00', '2017-05-10 09:18:00', '2017-05-11 00:00:00', '是', '否', '否', '99', '是');
INSERT INTO `p_goods` VALUES ('16', '11', '1.00', '1.00', '&lt;p&gt;啊啊啊啊&lt;/p&gt;', '是', '否', '2017-05-23 00:00:00', '', '', '', '', '', '2', '1', '1', '1.00', '2017-05-23 00:00:00', '2017-05-31 00:00:00', '是', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('17', '111', '111.00', '111.00', '', '是', '否', '2017-05-12 22:22:30', 'Goods/2017-05-12/5915c525d125c.jpg', 'Goods/2017-05-12/thumb_3_5915c525d125c.jpg', 'Goods/2017-05-12/thumb_2_5915c525d125c.jpg', 'Goods/2017-05-12/thumb_1_5915c525d125c.jpg', 'Goods/2017-05-12/thumb_0_5915c525d125c.jpg', '2', '1', '0', '11.00', '2017-05-12 00:00:00', '2017-05-12 22:22:00', '否', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('18', '111', '111.00', '111.00', '<p>11111</p>', '是', '否', '2017-05-12 22:24:33', 'Goods/2017-05-12/5915c5a1749d7.jpg', 'Goods/2017-05-12/thumb_3_5915c5a1749d7.jpg', 'Goods/2017-05-12/thumb_2_5915c5a1749d7.jpg', 'Goods/2017-05-12/thumb_1_5915c5a1749d7.jpg', 'Goods/2017-05-12/thumb_0_5915c5a1749d7.jpg', '2', '1', '2', '111.00', '2017-05-12 22:24:00', '2017-05-12 22:24:00', '是', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('19', 'fafds', '11.00', '11.00', '', '是', '否', '2017-05-12 22:35:02', 'Goods/2017-05-12/5915c8165a290.jpg', 'Goods/2017-05-12/thumb_3_5915c8165a290.jpg', 'Goods/2017-05-12/thumb_2_5915c8165a290.jpg', 'Goods/2017-05-12/thumb_1_5915c8165a290.jpg', 'Goods/2017-05-12/thumb_0_5915c8165a290.jpg', '2', '1', '0', '111.00', '2017-05-12 22:34:00', '2017-05-12 22:34:00', '是', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('20', '111', '111.00', '111.00', '', '是', '否', '2017-05-12 22:35:41', 'Goods/2017-05-12/5915c83dafa16.jpg', 'Goods/2017-05-12/thumb_3_5915c83dafa16.jpg', 'Goods/2017-05-12/thumb_2_5915c83dafa16.jpg', 'Goods/2017-05-12/thumb_1_5915c83dafa16.jpg', 'Goods/2017-05-12/thumb_0_5915c83dafa16.jpg', '2', '1', '0', '111.00', '2017-05-12 22:35:00', '2017-05-12 22:35:00', '是', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('21', '1111', '111.00', '111.00', '', '是', '否', '2017-05-12 22:36:20', 'Goods/2017-05-12/5915c864755f4.jpg', 'Goods/2017-05-12/thumb_3_5915c864755f4.jpg', 'Goods/2017-05-12/thumb_2_5915c864755f4.jpg', 'Goods/2017-05-12/thumb_1_5915c864755f4.jpg', 'Goods/2017-05-12/thumb_0_5915c864755f4.jpg', '2', '1', '0', '111.00', '2017-05-12 22:36:00', '2017-05-12 22:36:00', '否', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('22', 'qqq', '11.00', '111.00', '', '是', '否', '2017-05-12 22:37:12', 'Goods/2017-05-12/5915c898ad14e.jpg', 'Goods/2017-05-12/thumb_3_5915c898ad14e.jpg', 'Goods/2017-05-12/thumb_2_5915c898ad14e.jpg', 'Goods/2017-05-12/thumb_1_5915c898ad14e.jpg', 'Goods/2017-05-12/thumb_0_5915c898ad14e.jpg', '2', '16', '0', '111.00', '2017-05-12 22:37:00', '2017-05-12 22:37:00', '是', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('23', '到底是广东省', '111.00', '11.00', '', '是', '否', '2017-05-12 22:47:56', 'Goods/2017-05-12/5915cb1c458a0.jpg', 'Goods/2017-05-12/thumb_3_5915cb1c458a0.jpg', 'Goods/2017-05-12/thumb_2_5915cb1c458a0.jpg', 'Goods/2017-05-12/thumb_1_5915cb1c458a0.jpg', 'Goods/2017-05-12/thumb_0_5915cb1c458a0.jpg', '2', '1', '0', '111.00', '2017-05-12 22:47:00', '2017-05-31 00:00:00', '否', '是', '是', '100', '是');
INSERT INTO `p_goods` VALUES ('24', '风刀霜剑覅啥', '11.00', '111.00', '<p>发的萨芬撒女的发生大沙发<img src=\"http://zjxm.com/Public/umeditor1_2_2-utf8-php/php/upload/20170515/14948169835180.jpg\" alt=\"14948169835180.jpg\" /></p>', '是', '否', '2017-05-15 10:57:08', 'Goods/2017-05-15/59191903e1f12.jpg', 'Goods/2017-05-15/thumb_3_59191903e1f12.jpg', 'Goods/2017-05-15/thumb_2_59191903e1f12.jpg', 'Goods/2017-05-15/thumb_1_59191903e1f12.jpg', 'Goods/2017-05-15/thumb_0_59191903e1f12.jpg', '2', '1', '1', '111.00', '2017-05-15 10:56:00', '2017-05-15 10:56:00', '是', '是', '是', '100', '是');

-- ----------------------------
-- Table structure for p_goods_attr
-- ----------------------------
DROP TABLE IF EXISTS `p_goods_attr`;
CREATE TABLE `p_goods_attr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `attr_value` varchar(15) NOT NULL DEFAULT '' COMMENT '属性的值',
  `attr_id` mediumint(8) unsigned NOT NULL COMMENT '属性Id',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  PRIMARY KEY (`id`),
  KEY `attr_id` (`attr_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='商品属性表';

-- ----------------------------
-- Records of p_goods_attr
-- ----------------------------
INSERT INTO `p_goods_attr` VALUES ('1', '白色', '1', '14');
INSERT INTO `p_goods_attr` VALUES ('2', '银色', '1', '14');
INSERT INTO `p_goods_attr` VALUES ('3', '黑色', '1', '14');
INSERT INTO `p_goods_attr` VALUES ('4', '5寸', '2', '14');
INSERT INTO `p_goods_attr` VALUES ('5', '银色', '1', '15');
INSERT INTO `p_goods_attr` VALUES ('6', '4.8寸', '2', '15');
INSERT INTO `p_goods_attr` VALUES ('7', '1GB', '5', '15');
INSERT INTO `p_goods_attr` VALUES ('8', '白色', '1', '15');
INSERT INTO `p_goods_attr` VALUES ('9', '5寸', '2', '15');
INSERT INTO `p_goods_attr` VALUES ('10', '4GB', '5', '15');
INSERT INTO `p_goods_attr` VALUES ('11', '2GB', '5', '15');
INSERT INTO `p_goods_attr` VALUES ('12', '5.5寸', '2', '15');
INSERT INTO `p_goods_attr` VALUES ('13', '黑色', '1', '15');
INSERT INTO `p_goods_attr` VALUES ('14', '白色', '1', '24');
INSERT INTO `p_goods_attr` VALUES ('15', '银色', '1', '24');
INSERT INTO `p_goods_attr` VALUES ('16', '黑色', '1', '24');
INSERT INTO `p_goods_attr` VALUES ('17', '4.8寸', '2', '24');
INSERT INTO `p_goods_attr` VALUES ('18', '5寸', '2', '24');
INSERT INTO `p_goods_attr` VALUES ('19', '5.5寸', '2', '24');
INSERT INTO `p_goods_attr` VALUES ('20', '2GB', '5', '24');
INSERT INTO `p_goods_attr` VALUES ('21', '1GB', '5', '24');
INSERT INTO `p_goods_attr` VALUES ('22', '4GB', '5', '24');
INSERT INTO `p_goods_attr` VALUES ('23', '发发的撒法萨芬', '6', '15');

-- ----------------------------
-- Table structure for p_goods_cate
-- ----------------------------
DROP TABLE IF EXISTS `p_goods_cate`;
CREATE TABLE `p_goods_cate` (
  `cate_id` mediumint(8) unsigned NOT NULL COMMENT '分类ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  KEY `goods_id` (`goods_id`),
  KEY `cate_id` (`cate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品扩展分类表';

-- ----------------------------
-- Records of p_goods_cate
-- ----------------------------
INSERT INTO `p_goods_cate` VALUES ('1', '11');
INSERT INTO `p_goods_cate` VALUES ('2', '11');
INSERT INTO `p_goods_cate` VALUES ('3', '11');
INSERT INTO `p_goods_cate` VALUES ('4', '11');
INSERT INTO `p_goods_cate` VALUES ('5', '11');
INSERT INTO `p_goods_cate` VALUES ('6', '11');
INSERT INTO `p_goods_cate` VALUES ('18', '14');
INSERT INTO `p_goods_cate` VALUES ('16', '13');
INSERT INTO `p_goods_cate` VALUES ('22', '22');
INSERT INTO `p_goods_cate` VALUES ('22', '23');
INSERT INTO `p_goods_cate` VALUES ('22', '2');
INSERT INTO `p_goods_cate` VALUES ('16', '24');
INSERT INTO `p_goods_cate` VALUES ('23', '15');
INSERT INTO `p_goods_cate` VALUES ('24', '15');
INSERT INTO `p_goods_cate` VALUES ('17', '15');
INSERT INTO `p_goods_cate` VALUES ('19', '15');

-- ----------------------------
-- Table structure for p_goods_number
-- ----------------------------
DROP TABLE IF EXISTS `p_goods_number`;
CREATE TABLE `p_goods_number` (
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  `goods_number` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存量',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性id',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品库存表';

-- ----------------------------
-- Records of p_goods_number
-- ----------------------------
INSERT INTO `p_goods_number` VALUES ('15', '1111', '5,6,10');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '5,7,9');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '5,11,12');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '6,8,10');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '7,8,9');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '8,9,10');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '9,11,13');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '6,10,13');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '5,6,10');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '5,7,9');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '5,11,12');
INSERT INTO `p_goods_number` VALUES ('15', '1111', '6,8,10');

-- ----------------------------
-- Table structure for p_goods_pic
-- ----------------------------
DROP TABLE IF EXISTS `p_goods_pic`;
CREATE TABLE `p_goods_pic` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pic` varchar(150) NOT NULL COMMENT '原图',
  `sm_pic` varchar(150) NOT NULL COMMENT '小图',
  `mid_pic` varchar(150) NOT NULL COMMENT '中图',
  `big_pic` varchar(150) NOT NULL COMMENT '大图',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品Id',
  PRIMARY KEY (`id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='商品相册';

-- ----------------------------
-- Records of p_goods_pic
-- ----------------------------
INSERT INTO `p_goods_pic` VALUES ('1', 'Goods/2017-05-15/59191904e3d95.jpg', 'Goods/2017-05-15/thumb_2_59191904e3d95.jpg', 'Goods/2017-05-15/thumb_1_59191904e3d95.jpg', 'Goods/2017-05-15/thumb_0_59191904e3d95.jpg', '24');
INSERT INTO `p_goods_pic` VALUES ('2', 'Goods/2017-05-15/591919051ec08.jpg', 'Goods/2017-05-15/thumb_2_591919051ec08.jpg', 'Goods/2017-05-15/thumb_1_591919051ec08.jpg', 'Goods/2017-05-15/thumb_0_591919051ec08.jpg', '24');
INSERT INTO `p_goods_pic` VALUES ('3', 'Goods/2017-05-15/591919053d052.jpg', 'Goods/2017-05-15/thumb_2_591919053d052.jpg', 'Goods/2017-05-15/thumb_1_591919053d052.jpg', 'Goods/2017-05-15/thumb_0_591919053d052.jpg', '24');
INSERT INTO `p_goods_pic` VALUES ('4', 'Goods/2017-05-15/591958043c26c.jpg', 'Goods/2017-05-15/thumb_2_591958043c26c.jpg', 'Goods/2017-05-15/thumb_1_591958043c26c.jpg', 'Goods/2017-05-15/thumb_0_591958043c26c.jpg', '18');
INSERT INTO `p_goods_pic` VALUES ('5', 'Goods/2017-05-15/59195804678c6.jpg', 'Goods/2017-05-15/thumb_2_59195804678c6.jpg', 'Goods/2017-05-15/thumb_1_59195804678c6.jpg', 'Goods/2017-05-15/thumb_0_59195804678c6.jpg', '18');
INSERT INTO `p_goods_pic` VALUES ('6', 'Goods/2017-05-15/5919580485ed2.jpg', 'Goods/2017-05-15/thumb_2_5919580485ed2.jpg', 'Goods/2017-05-15/thumb_1_5919580485ed2.jpg', 'Goods/2017-05-15/thumb_0_5919580485ed2.jpg', '18');
INSERT INTO `p_goods_pic` VALUES ('7', 'Goods/2017-05-15/59195804aba1a.jpg', 'Goods/2017-05-15/thumb_2_59195804aba1a.jpg', 'Goods/2017-05-15/thumb_1_59195804aba1a.jpg', 'Goods/2017-05-15/thumb_0_59195804aba1a.jpg', '18');
INSERT INTO `p_goods_pic` VALUES ('8', 'Goods/2017-05-15/59195822641f6.jpg', 'Goods/2017-05-15/thumb_2_59195822641f6.jpg', 'Goods/2017-05-15/thumb_1_59195822641f6.jpg', 'Goods/2017-05-15/thumb_0_59195822641f6.jpg', '15');
INSERT INTO `p_goods_pic` VALUES ('9', 'Goods/2017-05-15/59195822978e7.jpg', 'Goods/2017-05-15/thumb_2_59195822978e7.jpg', 'Goods/2017-05-15/thumb_1_59195822978e7.jpg', 'Goods/2017-05-15/thumb_0_59195822978e7.jpg', '15');
INSERT INTO `p_goods_pic` VALUES ('10', 'Goods/2017-05-15/59195822c1c39.jpg', 'Goods/2017-05-15/thumb_2_59195822c1c39.jpg', 'Goods/2017-05-15/thumb_1_59195822c1c39.jpg', 'Goods/2017-05-15/thumb_0_59195822c1c39.jpg', '15');
INSERT INTO `p_goods_pic` VALUES ('11', 'Goods/2017-05-15/59195822f30ea.jpg', 'Goods/2017-05-15/thumb_2_59195822f30ea.jpg', 'Goods/2017-05-15/thumb_1_59195822f30ea.jpg', 'Goods/2017-05-15/thumb_0_59195822f30ea.jpg', '15');

-- ----------------------------
-- Table structure for p_member
-- ----------------------------
DROP TABLE IF EXISTS `p_member`;
CREATE TABLE `p_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '用户头像',
  `jifen` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '会员积分',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员用户表';

-- ----------------------------
-- Records of p_member
-- ----------------------------

-- ----------------------------
-- Table structure for p_member_level
-- ----------------------------
DROP TABLE IF EXISTS `p_member_level`;
CREATE TABLE `p_member_level` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `level_name` varchar(50) NOT NULL COMMENT '级别名称',
  `jifen_bottom` mediumint(8) unsigned NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) unsigned NOT NULL COMMENT '积分上限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='会员级别';

-- ----------------------------
-- Records of p_member_level
-- ----------------------------
INSERT INTO `p_member_level` VALUES ('1', '一级会员', '0', '5000');
INSERT INTO `p_member_level` VALUES ('2', '二级会员', '5001', '10000');
INSERT INTO `p_member_level` VALUES ('3', '三级会员', '10001', '20000');

-- ----------------------------
-- Table structure for p_member_price
-- ----------------------------
DROP TABLE IF EXISTS `p_member_price`;
CREATE TABLE `p_member_price` (
  `price` decimal(10,2) NOT NULL COMMENT '会员价格',
  `level_id` mediumint(8) unsigned NOT NULL COMMENT '级别ID',
  `goods_id` mediumint(8) unsigned NOT NULL COMMENT '商品ID',
  KEY `level_id` (`level_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员级别价格表';

-- ----------------------------
-- Records of p_member_price
-- ----------------------------
INSERT INTO `p_member_price` VALUES ('101.00', '1', '7');
INSERT INTO `p_member_price` VALUES ('102.00', '2', '7');
INSERT INTO `p_member_price` VALUES ('103.00', '3', '7');
INSERT INTO `p_member_price` VALUES ('111.00', '1', '14');
INSERT INTO `p_member_price` VALUES ('111.00', '2', '14');
INSERT INTO `p_member_price` VALUES ('111.00', '3', '14');
INSERT INTO `p_member_price` VALUES ('1000.00', '1', '13');
INSERT INTO `p_member_price` VALUES ('100.00', '2', '13');
INSERT INTO `p_member_price` VALUES ('100.00', '3', '13');
INSERT INTO `p_member_price` VALUES ('111.00', '1', '24');
INSERT INTO `p_member_price` VALUES ('11.00', '2', '24');
INSERT INTO `p_member_price` VALUES ('111.00', '3', '24');
INSERT INTO `p_member_price` VALUES ('111.00', '1', '24');
INSERT INTO `p_member_price` VALUES ('11.00', '2', '24');
INSERT INTO `p_member_price` VALUES ('111.00', '3', '24');
INSERT INTO `p_member_price` VALUES ('11.00', '1', '18');
INSERT INTO `p_member_price` VALUES ('11.00', '2', '18');
INSERT INTO `p_member_price` VALUES ('11.00', '3', '18');
INSERT INTO `p_member_price` VALUES ('22.00', '1', '15');
INSERT INTO `p_member_price` VALUES ('222.00', '2', '15');
INSERT INTO `p_member_price` VALUES ('333.00', '3', '15');

-- ----------------------------
-- Table structure for p_privilege
-- ----------------------------
DROP TABLE IF EXISTS `p_privilege`;
CREATE TABLE `p_privilege` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '模块名称',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '上级权限Id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of p_privilege
-- ----------------------------
INSERT INTO `p_privilege` VALUES ('1', '商品模块', '', '', '', '0');
INSERT INTO `p_privilege` VALUES ('2', '商品列表', 'Admin', 'Goods', 'lst', '1');
INSERT INTO `p_privilege` VALUES ('3', '添加商品', 'Admin', 'Goods', 'add', '2');
INSERT INTO `p_privilege` VALUES ('4', '修改商品', 'Admin', 'Goods', 'edit', '2');
INSERT INTO `p_privilege` VALUES ('5', '删除商品', 'Admin', 'Goods', 'delete', '2');
INSERT INTO `p_privilege` VALUES ('6', '分类列表', 'Admin', 'Category', 'lst', '1');
INSERT INTO `p_privilege` VALUES ('7', '添加分类', 'Admin', 'Category', 'add', '6');
INSERT INTO `p_privilege` VALUES ('8', '修改分类', 'Admin', 'Category', 'edit', '6');
INSERT INTO `p_privilege` VALUES ('9', '删除分类', 'Admin', 'Category', 'delete', '6');
INSERT INTO `p_privilege` VALUES ('10', 'RBAC', '', '', '', '0');
INSERT INTO `p_privilege` VALUES ('11', '权限列表', 'Admin', 'Privilege', 'lst', '10');
INSERT INTO `p_privilege` VALUES ('12', '添加权限', 'Privilege', 'Admin', 'add', '11');
INSERT INTO `p_privilege` VALUES ('13', '修改权限', 'Admin', 'Privilege', 'edit', '11');
INSERT INTO `p_privilege` VALUES ('14', '删除权限', 'Admin', 'Privilege', 'delete', '11');
INSERT INTO `p_privilege` VALUES ('15', '角色列表', 'Admin', 'Role', 'lst', '10');
INSERT INTO `p_privilege` VALUES ('16', '添加角色', 'Admin', 'Role', 'add', '15');
INSERT INTO `p_privilege` VALUES ('17', '修改角色', 'Admin', 'Role', 'edit', '15');
INSERT INTO `p_privilege` VALUES ('18', '删除角色', 'Admin', 'Role', 'delete', '15');
INSERT INTO `p_privilege` VALUES ('19', '管理员列表', 'Admin', 'Admin', 'lst', '10');
INSERT INTO `p_privilege` VALUES ('20', '添加管理员', 'Admin', 'Admin', 'add', '19');
INSERT INTO `p_privilege` VALUES ('21', '修改管理员', 'Admin', 'Admin', 'edit', '19');
INSERT INTO `p_privilege` VALUES ('22', '删除管理员', 'Admin', 'Admin', 'delete', '19');
INSERT INTO `p_privilege` VALUES ('23', '类型列表', 'Admin', 'Type', 'lst', '1');
INSERT INTO `p_privilege` VALUES ('24', '添加类型', 'Admin', 'Type', 'add', '23');
INSERT INTO `p_privilege` VALUES ('25', '修改类型', 'Admin', 'Type', 'edit', '23');
INSERT INTO `p_privilege` VALUES ('26', '删除类型', 'Admin', 'Type', 'delete', '23');
INSERT INTO `p_privilege` VALUES ('27', '属性列表', 'Admin', 'Attribute', 'lst', '23');
INSERT INTO `p_privilege` VALUES ('28', '添加属性', 'Admin', 'Attribute', 'add', '27');
INSERT INTO `p_privilege` VALUES ('29', '修改属性', 'Admin', 'Attribute', 'edit', '27');
INSERT INTO `p_privilege` VALUES ('30', '删除属性', 'Admin', 'Attribute', 'delete', '27');
INSERT INTO `p_privilege` VALUES ('31', 'ajax删除商品属性', 'Admin', 'Goods', 'ajaxDelGoodsAttr', '4');
INSERT INTO `p_privilege` VALUES ('32', 'ajax删除商品相册图片', 'Admin', 'Goods', 'ajaxDelImage', '4');
INSERT INTO `p_privilege` VALUES ('33', '会员管理', '', '', '', '0');
INSERT INTO `p_privilege` VALUES ('34', '会员级别列表', 'Admin', 'MemberLevel', 'lst', '33');
INSERT INTO `p_privilege` VALUES ('35', '添加会员级别', 'Admin', 'MemberLevel', 'add', '34');
INSERT INTO `p_privilege` VALUES ('36', '修改会员级别', 'Admin', 'MemberLevel', 'edit', '34');
INSERT INTO `p_privilege` VALUES ('37', '删除会员级别', 'Admin', 'MemberLevel', 'delete', '34');
INSERT INTO `p_privilege` VALUES ('38', '品牌列表', 'Admin', 'Brand', 'lst', '1');

-- ----------------------------
-- Table structure for p_role
-- ----------------------------
DROP TABLE IF EXISTS `p_role`;
CREATE TABLE `p_role` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色权限关系表';

-- ----------------------------
-- Records of p_role
-- ----------------------------
INSERT INTO `p_role` VALUES ('1', '商品管理员');
INSERT INTO `p_role` VALUES ('2', '商品管理员1');

-- ----------------------------
-- Table structure for p_role_pri
-- ----------------------------
DROP TABLE IF EXISTS `p_role_pri`;
CREATE TABLE `p_role_pri` (
  `pri_id` mediumint(8) unsigned NOT NULL COMMENT '权限ID',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色ID',
  KEY `pri_id` (`pri_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关系表';

-- ----------------------------
-- Records of p_role_pri
-- ----------------------------
INSERT INTO `p_role_pri` VALUES ('1', '1');
INSERT INTO `p_role_pri` VALUES ('2', '1');
INSERT INTO `p_role_pri` VALUES ('3', '1');
INSERT INTO `p_role_pri` VALUES ('4', '1');
INSERT INTO `p_role_pri` VALUES ('31', '1');
INSERT INTO `p_role_pri` VALUES ('32', '1');
INSERT INTO `p_role_pri` VALUES ('5', '1');
INSERT INTO `p_role_pri` VALUES ('1', '2');
INSERT INTO `p_role_pri` VALUES ('2', '2');
INSERT INTO `p_role_pri` VALUES ('3', '2');
INSERT INTO `p_role_pri` VALUES ('4', '2');
INSERT INTO `p_role_pri` VALUES ('31', '2');
INSERT INTO `p_role_pri` VALUES ('32', '2');
INSERT INTO `p_role_pri` VALUES ('5', '2');

-- ----------------------------
-- Table structure for p_type
-- ----------------------------
DROP TABLE IF EXISTS `p_type`;
CREATE TABLE `p_type` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='类型表';

-- ----------------------------
-- Records of p_type
-- ----------------------------
INSERT INTO `p_type` VALUES ('1', '手机');
INSERT INTO `p_type` VALUES ('2', '内存');
INSERT INTO `p_type` VALUES ('4', '服装');
