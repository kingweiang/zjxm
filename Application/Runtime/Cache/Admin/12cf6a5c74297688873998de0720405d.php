<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
</head>
<body>
<h1>
	<?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!--  内容  -->


<!-- 搜索 -->
<div class="form-div search_form_div">
	<!--搜索只能使用get方法，使用post会一直提示需要提交表单-->
    <form action="/index.php/Admin/Goods/lst" method="GET" name="search_form">
		<!--/index.php/Admin/Goods/lst 返回当前页，但不带具体页面信息-->
		<!--/index.php/Admin/Goods/lst.html返回当前页，但带具体页面信息-->
		<p>
			分　　类：
			<?php
 $catId = I('get.cate_id'); ?>
			<select name="cate_id" id="">
				<option value="">请选择商品分类</option>
				<?php foreach ($cateData as $k => $v ): if($v['id']==$catId) $select = 'selected = "selected"'; else $select = ""; ?>
				<option <?php echo $select;?>  value="<?php echo $v['id'];?>"><?php echo str_repeat('-',5*$v['level']).$v['cat_name']; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			品　　牌：
			<?php buildSelect('brand','brand_id','id','brand_name',I('get.brand_id'));?>
			<!--通过get获取goods_name 的值 <?php echo I('get.goods_name'); ?> 获取搜索的内容-->
		</p>
		<p>
			商品名称：
	   		<input type="text" name="goods_name" size="30" value="<?php echo I('get.goods_name'); ?>" />
			<!--通过get获取goods_name 的值 <?php echo I('get.goods_name'); ?> 获取搜索的内容-->
		</p>
		<!--<p>-->
			<!--市场价格：-->
	   		<!--从 <input id="market_pricefrom" type="text" name="market_pricefrom" size="15" value="<?php echo I('get.market_pricefrom'); ?>" /> -->
		    <!--到 <input id="market_priceto" type="text" name="market_priceto" size="15" value="<?php echo I('get.market_priceto'); ?>" />-->
		<!--</p>-->
		<p>
			价　　格：
	   		从 <input id="shop_pricefrom" type="text" name="shop_pricefrom" size="15" value="<?php echo I('get.shop_pricefrom'); ?>" /> 
		    到 <input id="shop_priceto" type="text" name="shop_priceto" size="15" value="<?php echo I('get.shop_priceto'); ?>" />
		</p>
		<!--<p>-->
			<!--商品描述：-->
	   		<!--<input type="text" name="goods_desc" size="30" value="<?php echo I('get.goods_desc'); ?>" />-->
		<!--</p>-->
		<p>
			是否上架：
			<?php $ios = I('get.is_on_sale'); ?>
			<input type="radio" name="is_on_sale" value="" <?php if($ios == '') echo 'checked="checked"'; ?> /> 全部
			<input type="radio" name="is_on_sale" value="是" <?php if($ios == '是') echo 'checked="checked"'; ?>  /> 上架
			<input type="radio" name="is_on_sale" value="否" <?php if($ios == '否') echo 'checked="checked"'; ?>  /> 下架
			<!--<input type="radio" value="-1" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == -1) echo 'checked="checked"'; ?> /> 全部 -->
			<!--<input type="radio" value="" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == '') echo 'checked="checked"'; ?> />  -->
		</p>
		<!--<p>-->
			<!--：-->
			<!--<input type="radio" value="-1" name="is_delete" <?php if(I('get.is_delete', -1) == -1) echo 'checked="checked"'; ?> /> 全部 -->
			<!--<input type="radio" value="" name="is_delete" <?php if(I('get.is_delete', -1) == '') echo 'checked="checked"'; ?> />  -->
		<!--</p>-->
		<p>
			添加时间：
	   		从 <input id="addtimefrom" type="text" name="addtimefrom" size="15" value="<?php echo I('get.addtimefrom'); ?>" /> 
		    到 <input id="addtimeto" type="text" name="addtimeto" size="15" value="<?php echo I('get.addtimeto'); ?>" />
		</p>
		<p>
			排序方式：
			<?php $odby = I('get.odby','id_desc'); ?>
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="id_desc" <?php if($odby == 'id_desc') echo 'checked="checked"'; ?> /> 以添加时间降序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="id_asc" <?php if($odby == 'id_asc') echo 'checked="checked"'; ?> /> 以添加时间升序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="price_desc" <?php if($odby == 'price_desc') echo 'checked="checked"'; ?> /> 以价格降序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="price_asc" <?php if($odby == 'price_asc') echo 'checked="checked"'; ?> /> 以价格升序

			<!--<input type="radio" value="-1" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == -1) echo 'checked="checked"'; ?> /> 全部 -->
			<!--<input type="radio" value="" name="is_on_sale" <?php if(I('get.is_on_sale', -1) == '') echo 'checked="checked"'; ?> />  -->
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>
</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >商品ID</th>
            <th >商品名称</th>
            <th >主分类</th>
            <th >扩展分类</th>
			<th >商品品牌</th>
            <th >商品图片</th>
            <th >市场价格</th>
            <th >本店价格</th>
            <th >添加时间a</th>
            <th >上架</th>
			<th width="120">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td align="center"><?php echo $v['id']; ?></td>
				<td align="center"><?php echo $v['goods_name']; ?></td>
				<td align="center"><?php echo $v['cat_name']; ?></td>
				<td align="center"><?php echo $v['ext_cat_name']; ?></td>
				<td align="center"><?php echo $v['brand_name']; ?></td>
				<!--<td align="center"><img src="/Public/Uploads/<?php echo $v['sm_logo']; ?>" alt=""></td>   写死的方法-->
				<!--<td align="center"><img src="<?php echo C('IMAGE_CONFIG')['viewPath'].$v['sm_logo']; ?>" alt=""></td>  读取配置文件的方法-->
				<!--使用自定义函数showImage()的方法-->
				<td align="center"><?php showImage($v['sm_logo']); ?></td>
				<td align="center"><?php echo $v['market_price']; ?></td>
				<td align="center"><?php echo $v['shop_price']; ?></td>
				<td align="center"><?php echo $v['addtime']; ?></td>
				<td align="center"><?php echo $v['is_on_sale']; ?></td>
		        <td align="center">
		        	<a href="<?php echo U('goods_number?id='.$v['id']); ?>" title="编辑">库存量</a> |
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> |
	                <a href="<?php echo U('delete?id='.$v['id'].'&p='.I('get.p')); ?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a>
		        </td>
	        </tr>
        <?php endforeach; ?>
		<!--分页-->
		<?php if(preg_match('/\d/', $page)): ?>  
        <tr><td align="right" nowrap="true" colspan="99" height="30" id="page-link"><?php echo $page; ?></td></tr>
        <?php endif; ?> 
	</table>
</div>
<!-- 时间插件 -->
<link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script>$.timepicker.setDefaults($.timepicker.regional['zh-CN']);</script>
		<script>
$('#addtimefrom').datetimepicker(); $('#addtimeto').datetimepicker(); </script>

<!--鼠标所在的记录行高亮显示出来-->
<script src="/Public/Admin/Js/tron.js"></script>

<div id="footer"> 39期 </div>
</body>
</html>