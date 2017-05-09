<?php
return array(
	'tableName' => 'p_goods',    // 表名
	'tableCnName' => '',  // 表的中文名
	'moduleName' => 'Admin1',  // 代码生成到的模块
	'withPrivilege' => FALSE,  // 是否生成相应权限的数据
	'topPriName' => '',        // 顶级权限的名称
	'digui' => 0,             // 是否无限级（递归）
	'diguiName' => '',        // 递归时用来显示的字段的名字，如cat_name（分类名称）
	'pk' => 'id',    // 表中主键字段名称
	/********************* 要生成的模型文件中的代码 ******************************/
	// 添加时允许接收的表单中的字段
	'insertFields' => "array('goods_name','market_price','shop_price','goods_desc','is_on_sale','is_delete')",
	// 修改时允许接收的表单中的字段
	'updateFields' => "array('id','goods_name','market_price','shop_price','goods_desc','is_on_sale','is_delete')",
	'validate' => "
		array('goods_name', 'require', '不能为空！', 1, 'regex', 3),
		array('goods_name', '1,150', '的值最长不能超过 150 个字符！', 1, 'length', 3),
		array('market_price', 'require', '不能为空！', 1, 'regex', 3),
		array('market_price', 'currency', '必须是货币格式！', 1, 'regex', 3),
		array('shop_price', 'require', '不能为空！', 1, 'regex', 3),
		array('shop_price', 'currency', '必须是货币格式！', 1, 'regex', 3),
		array('is_on_sale', ', \"的值只能是在 ' 中的一个值！\", 2, 'in', 3),
		array('is_delete', ', \"的值只能是在 ' 中的一个值！\", 2, 'in', 3),
	",
	/********************** 表中每个字段信息的配置 ****************************/
	'fields' => array(
		'goods_name' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
		'market_price' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
		'shop_price' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
		'goods_desc' => array(
			'text' => '',
			'type' => 'text',
			'default' => '',
		),
		'is_on_sale' => array(
			'text' => '',
			'type' => 'radio',
			'values' => array(
				'' => '',
			),
			'default' => '',
		),
		'is_delete' => array(
			'text' => '',
			'type' => 'radio',
			'values' => array(
				'' => '',
			),
			'default' => '',
		),
		'logo' => array(
			'text' => 'ԭͼ',
			'type' => 'file',
			'thumbs' => array(
				array(350, 350, 2),
				array(150, 150, 2),
				array(50, 50, 2),
			),
			'save_fields' => array('logo', 'big_logo', 'mid_logo', 'sm_logo'),
			'default' => '',
		),
	),
	/**************** 搜索字段的配置 **********************/
	'search' => array(
		array('goods_name', 'normal', '', 'like', ''),
		array('market_price', 'between', 'market_pricefrom,market_priceto', '', ''),
		array('shop_price', 'between', 'shop_pricefrom,shop_priceto', '', ''),
		array('goods_desc', 'normal', '', 'eq', ''),
		array('is_on_sale', 'in', '', '', ''),
		array('is_delete', 'in', '', '', ''),
		array('addtime', 'betweenTime', 'addtimefrom,addtimeto', '', ''),
	),
);