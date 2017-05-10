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

<style>
    #cate_list{background:#EEE;margin:0;}
    #cate_list li{margin: 5px;}
</style>
<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >基本信息</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品图片</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/Goods/add.html" method="post">
            <!--基本信息表-->
            <table width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">主分类：</td>
                    <td>
                        <select name="cate_id" id="">
                            <option value="">请选择商品分类</option>
                            <?php foreach ($cateData as $k => $v ):?>
                            <option value="<?php echo $v['id'];?>"><?php echo str_repeat('-',5*$v['level']).$v['cat_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">扩展分类：
                        <input onclick="$('#cate_list').append($('#cate_list').find('li').eq(0).clone());" type="button" id="btn_add_cate" value="继续扩展">
                    </td>
                    <td >
                        <ul id="cate_list">
                            <li>
                                <select name="ext_cate_id[]" id="">
                                    <option value="">请选择商品分类</option>
                                    <?php foreach ($cateData as $k => $v ):?>
                                    <option value="<?php echo $v['id'];?>"><?php echo str_repeat('-',5*$v['level']).$v['cat_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                        </ul>

                    </td>
                </tr>
                <tr>
                    <td class="label">所在品牌：</td>
                    <td>
                        <?php buildSelect('brand','brand_id','id','brand_name');?>
                    </td>
                </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" />
                        <span class="require-field">*</span></td>
                </tr>
                <tr>
                    <td class="label">LOGO：</td>
                    <td><input type="file" name="logo" size="60" /></td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>

                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="checked" /> 是
                        <input type="radio" name="is_on_sale" value="否" /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">促销价格：</td>
                    <td>
                        价格：￥<input type="text" name="promote_price" size="8" />元
                        开始时间：<input type="text" id="promote_start_date" name="promote_start_date" />
                        结束时间：<input type="text" id="promote_end_date" name="promote_end_date" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="是" /> 是
                        <input type="radio" name="is_new" value="否" checked="checked" /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="是" /> 是
                        <input type="radio" name="is_best" value="否" checked="checked" /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热卖：</td>
                    <td>
                        <input type="radio" name="is_hot" value="是" /> 是
                        <input type="radio" name="is_hot" value="否" checked="checked" /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">推荐到楼层：</td>
                    <td>
                        <input type="radio" name="is_floor" value="是" /> 是
                        <input type="radio" name="is_floor" value="否" checked="checked" /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">排序：</td>
                    <td>
                        <input type="text" name="sort_num" value="100" size="8"/>
                    </td>
                </tr>
            </table>
            <!--商品描述表-->
            <table style="display: none" width="100%" class="tab_table" align="center">
                <tr>
                    <td>
                        <textarea id="goods_desc"  name="goods_desc"></textarea>
                    </td>
                </tr>
            </table>
            <!--会员价格表-->
            <table style="display: none"  width="90%" class="tab_table" align="center">
                <tr>
                    <td align="center">
                        <?php foreach ($mlData as $k => $v): ?>
                        <p>
                            <strong>
                                <?php echo $v['level_name']; ?>：
                            </strong>
                            ￥<input type="text" name="member_price[<?php echo $v['id']; ?>]" size="8" />元<br/>
                        </p>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
            <!--商品属性表-->
            <table style="display: none"  width="90%" class="tab_table" align="center">
                <tr><td>
                    商品类型：<?php buildSelect('Type','type_id','id','type_name');?>
                </td></tr>
                <tr><td>
                    <ul id="attr_list"></ul>
                </td></tr>
            </table>
            <!--商品图片表-->
            <table style="display: none"  width="90%" class="tab_table" align="center">
                <tr>
                    <td>
                        <input id="btn_add_pic" type="button" value="添加一张" />
                        <hr />
                        <ul id="ul_pic_list"></ul>
                    </td>
                </tr>
            </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
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
    $('#promote_start_date').datetimepicker();
    $('#promote_end_date').datetimepicker();
</script>


<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/lang/zh-cn/zh-cn.js"></script>
<script>
UM.getEditor('goods_desc', {
	initialFrameWidth : "100%",
	initialFrameHeight : 350
});

/**切换table方法
 * 通过ID 找到p标签下的span标签，设计点击事件
 */
$("#tabbar-div p span").click(function () {
// 点击的第几个按钮
    var i=$(this).index();
//    先隐藏所有按钮
    $(".tab_table").hide();
    // 显示第i个table
    $(".tab_table").eq(i).show();
    //隐藏其他table，siblings()与i的兄弟标签，此方法会导致按钮也隐藏
//    $(".tab_table").eq(i).siblings().hide();
    // 先取消原按钮的选中状态
    $(".tab-front").removeClass("tab-front").addClass("tab-back");
    // 设置选中状态
    $(this).removeClass("tab-back").addClass("tab-front");

})


$("select[name=type_id]").change(function () {
    // 获取当前选中的类型ID
    var typeId=$(this).val();
//      alert(typeId);
    // 如果选中了一个类型就执行ajax
    if(typeId > 0){
        // 根据类型的ID执行ajax取出类型下的属性，并获取返回的json数据
        $.ajax({
            type:"GET",
            url:"<?php echo U('ajaxGetAttr','',FALSE);?>/type_id/"+typeId,
            dataType:"json",  // 返回json数据类型
            // ajax请求完成后返回数据
            success:function (data) {
//                  alert(data);
                /****把服务器返回的属性循环拼成一个li字符串，并显示在页面中***/
                var li = "";
                // 循环每个属性
                $(data).each(function (k,v) {
                    li += '<li>';
                    // 如果这个属性类型是可选的就有一个+
                    if (v.attr_type == '可选')
                        li += '<a onclick="addNewAttr(this)" href="#">[+]</a>';
                    // 属性名称
                    li += v.attr_name + ' ： ';
                    // 如果属性有可选值就做下拉，否则做文本框
                    if (v.attr_option_values == "")
                        li +='<input type="text" name="attr_value['+v.id+'][]"/>';
                    else
                    {
                        li += '<select name="attr_value['+v.id+'][]" ><option value="">请选择...</option> ';
                        // 把可选值根据，转换成数组
                        var _attr = v.attr_option_values.split(',');
                        // 循环每个值制作option
                        for (var i=0; i<_attr.length; i++){
                            li += '<option value="'+_attr[i]+'">';
                            li += _attr[i];
                            li += '</option>';
                        }
                        li += '</select>';
                    }
                    li += '</li>';
                });
                $("#attr_list").html(li);  // 显示li 字符串

                // 将a标签定义 class="abab"，clone需要深度克隆才能克隆click事件所以里面使用true
                // 因为按钮是 ajax生成的，需要绑定click事件必须放在生成之后，不能放在外面因为按钮还没生成

//               $(".abab").click(function () {
//                    var li =$(a).parent();
//                    if ($(a).text()=='[+]'){
//                        var newLi = li.clone(ture);
//                        // + 变成 -
//                        newLi.find("a").text('[-]');
//                        //  把新的放在li后面
//                        li.after(newLi);
//                    }else
//                        li.remove();
//                })
            }
        });
    }else
        $("#attr_list").html(""); // 如果选中<请选择...>，清空所有li字符串
})

// 点击属性的+
    function addNewAttr(a) {
        // $(a) 把a转换成jQuery中的对象，才能使用jQuery中的方法
        // 也可以使用原生写法 var li = a.parentNode
        // 先获取所在的li
        var li =$(a).parent();
        if ($(a).text()=='[+]'){
            var newLi = li.clone();
            // + 变成 -
            newLi.find("a").text('[-]');
            //  把新的放在li后面
            li.after(newLi);
        }else
            li.remove();
    }
</script>






















<div id="footer"> 39期 </div>
</body>
</html>