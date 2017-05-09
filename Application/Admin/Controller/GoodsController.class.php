<?php
namespace Admin\Controller;


class GoodsController extends BaseController
{
	// 显示和处理表单（添加）
	public function add()
	{

	    // 判断是否使用post方法提交了表单
	    if(IS_POST){
	        $model = D('goods');
            /**Create():1 接受数据并保持到模型中 2根据模型定义的规则定义表单
             *
             */
	        if($model->create(I('post.'),1)){
	            if($model->add()){ // 在这之前调用了_before_insert方法
                    $this->success('添加成功',U('lst'));
                    exit;
                }
            }
            $error=$model->getError();
	        $this->error($error);
        }
        // 取出品牌信息
//        $brandModel=D('Brand');
//        $brandData = $brandModel->select();
        // 取出会员信息
        $memberModel=D('member_level');
        $memberData = $memberModel->select();

//        分类下拉框
        $cateModel = D('category');
        $cateData = $cateModel->getTree();
        // 设置页面标题等信息
        $this->assign(array(
            'cateData' => $cateData,
//            'brandData'=>$brandData,
            'mlData'=>$memberData,
            '_page_title'=>'添加新商品',
            '_page_btn_name'=>'商品列表',
            '_page_btn_link'=>U('lst'),
        ));
        $this->display();
	}

    // 显示和处理表单（修改）
    public function edit()
    {

        $id=I('get.id');  // 获取ID
        $model = D('goods');
        // 判断是否使用post方法提交了表单
        if(IS_POST){
//                    dump($_POST);die;
             if($model->create(I('post.'),2)){  // 2 表示修改
                if(FALSE !== $model->save()){
                    // save()的返回值是，如果失败返回false，如果成功返回受影响的条数。如果修改前和修改后一样就返回0.所以需要设置false不为真
                    $this->success('修改成功',U('lst'));
                    exit;
                }
            }
            $error=$model->getError();
            $this->error($error);
        }


        //  根据ID取出要修改的商品的原信息
        $data = $model->find($id);
        $this->assign('data',$data);

        //        分类下拉框
        $cateModel = D('category');
        $cateData = $cateModel->getTree();

        // 取出品牌信息
//        $brandModel=D('Brand');
//        $brandData = $brandModel->select();
        //        取出扩展分类
        $gcModel = D('goods_cate');
        $gcData = $gcModel->field('cate_id')->where(array(
            'goods_id'=>array('eq',$id)
        ))->select();
        // 取出会员信息
        $memberModel=D('member_level');
        $memberData = $memberModel->select();

//         取出会员价信息
        $mpModel=D('member_price');
        $mpData = $mpModel->where(array(
            'goods_id'=>array('eq',$id),
        ))->select();
//        var_dump($mpData);
            // 把二维数组转为一维数组： leve_id => price
        $_mpData = array();
        foreach ($mpData as $k => $v)
        {
            $_mpData[$v['level_id']] = $v['price'];
        }
//        var_dump($_mpData);
        // 取出当前类型下所有的属性
        $attrModel = D('Attribute');
        $attrData = $attrModel->alias('a')
            ->field('a.id attr_id,a.attr_name,a.attr_type,a.attr_option_values,b.attr_value,b.id')
            ->join('LEFT JOIN __GOODS_ATTR__ b ON (a.id=b.attr_id AND b.goods_id='.$id.')')
            ->where(array(
                'a.type_id' => array('eq', $data['type_id']),
            ))->order('attr_id desc')->select();
//        var_dump( $data['type_id']);
        //dump($attrData);

        // 取出这个商品的已设置的属性值
//        $gaModel= D('goods_attr');
//        $gaData = $gaModel->alias('a')
//            ->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')
//            ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
//            ->where(array(
//                'goods_id'=>array('eq',$id),
//            ))->select();

//        var_dump($gaData);
        // 设置页面标题等信息
        $this->assign(array(
            'gaData'=> $attrData,
            'gcData'=>$gcData,
            'cateData' => $cateData,
            'mlData'=>$memberData,
            'mpData'=>$_mpData,
            '_page_title'=>'修改商品',
            '_page_btn_name'=>'商品列表',
            '_page_btn_link'=>U('lst'),
        ));
        $this->display();

    }
	// 商品列表页
	public function lst()
	{
	    $model = D('goods');
	    // 返回数据和翻页
        $data = $model->search();
//        var_dump($data);die;
        // 回调数据,assign第一种写法
        $this->assign($data);
//        //assign第二种写法
//        $this->assign('data',$data['data']);
//        $this->assign('page',$data['page']);

//        //assign第三种写法
//        $this->assign(array(
//            'data'=>$data['data'],
//            'page'=>$data['page'],
//        ));
        // 取出会员信息
        $memberModel=D('member_level');
        $memberData = $memberModel->select();

        //        分类下拉框
        $cateModel = D('category');
        $cateData = $cateModel->getTree();



        // 设置页面标题等信息
        $this->assign(array(
            'cateData'=>$cateData,
            'mlData'=>$memberData,
            '_page_title'=>'商品列表',
            '_page_btn_name'=>'添加商品',
            '_page_btn_link'=>U('add'),
        ));
        $this->display();
	}

    public function delete()
    {
        $model=D('goods');
        if (FALSE  !== $model->delete(I('get.id')))
            $this->success('删除成功!',U('lst'));
        else
            $this->error('删除失败！失败原因：'.$model->getError());
	}

	// 处理获取属性的ajax请求
    public function ajaxGetAttr()
    {
        $typeId = I('get.type_id');
        $attrModel=D('Attribute');
        $attrData =$attrModel->where(array(
            'type_id' => array('eq',$typeId),
        ))->select();
        echo json_encode($attrData);
	}

    // 处理删除属性的ajax请求
    public function ajaxDelAttr()
    {
        $goodsId=addslashes(I('get.goods_id'));
        $gaId = addslashes(I('get.gaid'));
        $gaModel=D('goods_attr');
        $gaModel->delete($gaId);
        // 删除对应相关库存
        $gnModel=D('goods_number');
        // 通过exp 扩展成原生sql语法，但是这样容易造成sql注入所以在定义变量时加入 addslashes 函数
        $gnModel->where(array(
            'goods_id'=>array('EXP',"=$goodsId AND FIND_IN_SET($gaId,attr_list)"),
        ))->delete();
    }

    // 商品库存处理
    public function goods_number()
    {
//        如果打印显示乱码可以定义页头
        header('Content-Type:text/html;charset=utf8');
        $id = I('get.id');
        $gnModel = D('goods_number');

        // 处理表单
        if(IS_POST){
            // 添加之前删除原数据
            $gnModel->where(array(
                'goods_id'=> array('eq',$id),
            ))->delete();

//            dump($_POST);die;
            $gaid = I('post.goods_attr_id');
            $gn = I('post.goods_number');
            // 计算商品属性ID与库存量的比例
            $gaidCount = count($gaid);
            $gnCount = count($gn);
            $rate = $gaidCount/$gnCount;
//            循环库存量
            $_i=0; // 取出第几个商品属性ID
            foreach($gn as $k => $v){
                $_goodsAttrId = array(); // 把下面取出来的ID放到这里
                // 从商品属性ID 数组中取出$rate 个,循环一次取一个
                for ($i=0;$i<$rate;$i++){
                    $_goodsAttrId[]=$gaid[$_i];
                    $_i++;
                }
                // 先升序排列SORT，以数字的算法排序SORT_NUMERIC
                sort($_goodsAttrId,SORT_NUMERIC);
//                把取出来的商品属性ID转化字符串
                $_goodsAttrId=(string)implode(',',$_goodsAttrId);
                $gnModel->add(array(
                    'goods_id' =>$id,
                    'goods_attr_id'=>$_goodsAttrId,
                    'goods_number'=>$v,
                ));
            }
            $this->success('商品库存更新成功！',U('goods_number?id='.I('get.id')));
            exit;
        }
        // 先取出这件商品已经设置过的库存量
        $gnData = $gnModel->where(array(
            'goods_id'=>$id,
        ))->select();
//        dump($gnData);

//        根据商品ID取出对应属性
        $gaModel = D('goods_attr');
        $gaData=$gaModel->alias('a')
        ->field('a.*,b.attr_name')
        ->join('LEFT JOIN __ATTRIBUTE__ b ON a.attr_id=b.id')
        ->where(array(
            'a.goods_id'=>array('eq',$id),
            'b.attr_type'=>array('eq','可选'),
        ))->select();
//        dump($gaData);die;
        // 处理这个二维数组，转化成为三维数组；把属性相同的放到一起
        $_gaData = array();
        foreach ($gaData as $k => $v){
            // 以属性名称做为下标，这样相同属性的就在一起了
            $_gaData[$v['attr_name']][]=$v;
        }
//        dump($_gaData);die;
        $this->assign(array(
            'gnData'=>$gnData,
            'gaData'=>$_gaData,
            '_page_title'=>'商品库存表',
            '_page_btn_name'=>'商品列表',
            '_page_btn_link'=>U('add'),
        ));

        $this->display();
    }
}