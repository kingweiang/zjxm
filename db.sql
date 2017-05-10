create database php39;
use php39;
set names utf8;

drop table if exists p_goods;
create table p_goods
(
	id mediumint unsigned not null auto_increment comment 'Id',
	goods_name varchar(150) not null comment '商品名称',
	market_price decimal(10,2) not null comment '市场价格',
	shop_price decimal(10,2) not null comment '本店价格',
	goods_desc longtext comment '商品描述',
	is_on_sale enum('是','否') not null default '是' comment '是否上架',
	is_delete enum('是','否') not null default '否' comment '是否放到回收站',
	addtime datetime not null comment '添加时间',
	logo varchar(150) not null default '' comment '原图',
	sm_logo varchar(150) not null default '' comment '小图',
	mid_logo varchar(150) not null default '' comment '中图',
	big_logo varchar(150) not null default '' comment '大图',
	mbig_logo varchar(150) not null default '' comment '更大图',
	brand_id mediumint unsigned not null default '0' comment '品牌ID',
	cate_id mediumint unsigned not null default '0' comment '主分类ID',
	type_id mediumint unsigned not null default '0' comment '类型ID',
  promote_price decimal(10,2) NOT NULL DEFAULT '0.00'COMMENT '促销价格',
  promote_start_date DATETIME NOT NULL COMMENT '添加时间',
  promote_end_date DATETIME NOT NULL COMMENT '结束时间',
  is_new ENUM('是','否') NOT NULL DEFAULT '否'COMMENT '是否新品',
  is_hot ENUM('是','否') NOT NULL DEFAULT '否'COMMENT '是否热卖',
  is_best ENUM('是','否') NOT NULL DEFAULT '否'COMMENT '是否精品',
  is_floor ENUM('是','否') NOT NULL DEFAULT '否'COMMENT '是否楼层推荐',
  sort_num TINYINT UNSIGNED NOT NULL DEFAULT '100'COMMENT '排序的数字',
	primary key (id),
  key promote_price(promote_price),
  key promote_start_date(promote_start_date),
  key promote_end_date(promote_end_date),
	key shop_price(shop_price),
	key addtime(addtime),
	key brand_id(brand_id),
	key cate_id(cate_id),
	key sort_num(sort_num),
	key is_on_sale(is_on_sale)
)engine=InnoDB default charset=utf8 comment '商品';

-- alter table p_category add is_floor  ENUM('是','否') NOT NULL DEFAULT '否' COMMENT '是否楼层推荐';


drop table if exists p_brand;
create table p_brand
(
	id mediumint unsigned not null auto_increment comment 'Id',
	brand_name varchar(150) not null comment '品牌名称',
	site_url VARCHAR (150) not NULL DEFAULT  '' comment '官网地址',
	logo VARCHAR(150) not NULL DEFAULT  '' comment '品牌logo图片',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '品牌';

drop table if exists p_member_level;
create table p_member_level
(
	id mediumint unsigned not null auto_increment comment 'Id',
	level_name varchar(50) not null comment '级别名称',
	jifen_bottom mediumint unsigned not null comment '积分下限',
	jifen_top mediumint unsigned not null comment '积分上限',
	primary key (id)
)engine=InnoDB default charset=utf8 comment '会员级别';

drop table if exists p_member_price;
create table p_member_price
(
   price decimal(10,2) not null comment '会员价格',
   level_id mediumint unsigned not null comment '级别ID',
   goods_id mediumint unsigned not null comment '商品ID',
   key level_id(level_id),
   key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '会员价格表';

drop table if exists p_category;
create table p_category
(
   id mediumint unsigned not null auto_increment comment 'Id',
   cat_name varchar(30) not null comment '分类名称',
   parent_id mediumint unsigned not null default '0' comment '上级分类ID，0为顶级分类',
  is_floor  ENUM('是','否') NOT NULL DEFAULT '否' COMMENT '是否楼层推荐',
  primary key (id)
)engine=InnoDB default charset=utf8 comment '分类表';


drop table if exists p_goods_cate;
create table p_goods_cate
(
   cate_id mediumint unsigned not null comment '分类ID',
   goods_id mediumint unsigned not null comment '商品ID',
   key goods_id(goods_id),
   key cate_id(cate_id)
)engine=InnoDB default charset=utf8 comment '商品扩展分类表';

/**********************************属性相关表****************************************/

drop table if exists p_type;
create table p_type
(
   id mediumint unsigned not null auto_increment comment 'Id',
   type_name varchar(30) not null comment '类型名称',
   primary key (id)
)engine=InnoDB default charset=utf8 comment '类型表';

drop table if exists p_attribute;
create table p_attribute
(
   id mediumint unsigned not null auto_increment comment 'Id',
   attr_name varchar(30) not null comment '属性名称',
   attr_type enum('唯一','可选') not null comment '属性类型',
   attr_option_values varchar(300) not null DEFAULT '' comment '属性可选值',
   type_id mediumint unsigned not null comment '类型Id',
   primary key (id),
   key type_id(type_id)
)engine=InnoDB default charset=utf8 comment '属性表';

drop table if exists p_goods_attr;
create table p_goods_attr
(
   id mediumint unsigned not null auto_increment comment 'Id',
   attr_value varchar(15) not null  DEFAULT '' comment '属性的值',
   attr_id mediumint unsigned not null comment '属性Id',
   goods_id mediumint unsigned not null comment '商品Id',
   primary key (id),
   key attr_id(attr_id),
   key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '商品属性表';

drop table if exists p_goods_number;
create table p_goods_number
(
  goods_id mediumint unsigned not null comment '商品Id',
  goods_number mediumint unsigned not null DEFAULT '0' comment '商品库存量',
  goods_attr_id varchar(150) not null  DEFAULT '' comment '商品属性id',
  key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '商品库存表';


/****************** RBAC **************************/

drop table if exists p_privilege;
create table p_privilege
(
  id mediumint unsigned not null auto_increment comment 'Id',
  pri_name VARCHAR(30) not null comment '权限名称',
  module_name VARCHAR(30) not null DEFAULT '' comment '模块名称',
  controller_name VARCHAR(30) not null DEFAULT '' comment '控制器名称',
  action_name VARCHAR(30) not null DEFAULT '' comment '方法名称',
  parent_id mediumint unsigned not null DEFAULT '0' comment '上级权限Id',
  primary key (id)
)engine=InnoDB default charset=utf8 comment '权限表';

drop table if exists p_role_pri;
create table p_role_pri
(
  pri_id mediumint unsigned not null comment '权限ID',
  role_id mediumint unsigned not null comment '角色ID',
  key pri_id(pri_id),
  key role_id(role_id)
)engine=InnoDB default charset=utf8 comment '角色权限关系表';

drop table if exists p_role;
create table p_role
(
  id mediumint unsigned not null auto_increment comment 'Id',
  role_name  VARCHAR(30) not null comment '角色名称',
  primary key (id)
)engine=InnoDB default charset=utf8 comment '角色权限关系表';

drop table if exists p_admin_role;
create table p_admin_role
(
  admin_id mediumint unsigned not null comment '管理ID',
  role_id mediumint unsigned not null comment '角色ID',
  key admin_id(admin_id),
  key role_id(role_id)
)engine=InnoDB default charset=utf8 comment '管理角色关系表';

drop table if exists p_admin;
create table p_admin
(
  id mediumint unsigned not null auto_increment comment 'Id',
  username VARCHAR(30) not null comment '用户名',
  password CHAR(32) not null comment '密码',
  primary key (id)
)engine=InnoDB default charset=utf8 comment '管理用户表';

# SELECT md5('admin');   查询admin的密码
insert into p_admin(id,username,password) values(1,'admin','21232f297a57a5a743894a0e4a801fc3');