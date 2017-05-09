<?php
namespace Admin\Model;
use Admin\Controller\IndexController;
use Think\Model;
use Think\Page;


class GoodsModel extends Model 
{
	 // 添加时调用create方法允许接收的字段
	protected $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,cate_id,ext_cate_id,type_id';
    // 修改时调用update方法允许接收的字段
	protected $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,cate_id,ext_cate_id,type_id';
	// 定义验证规则
	protected $_validate = array(
		array('goods_name', 'require', '商品名称不能为空！', 1),
		array('cate_id', 'require', '主分类不能为空！', 1),
		array('market_price', 'currency', '市场价格必须是货币类型！', 1),
		array('shop_price', 'currency', '本店价格必须是货币类型！', 1),
	);
	
	// 这个方法在添加之前会自动被调用 --》 钩子方法
	// 第一个参数：表单中即将要插入到数据库中的数据->数组
	// &按引用传递：函数内部要修改函数外部传进来的变量必须按钮引用传递，除非传递的是一个对象,因为对象默认是按引用传递的
	protected function _before_insert(&$data, $option)
	{

	    /**************** 处理LOGO *******************/
		// 判断有没有选择图片  var_dump($_FILES );查看文件信息
//		if($_FILES['logo']['error'] == 0)
//		{
//			$upload = new \Think\Upload();// 实例化上传类
//		    $upload->maxSize = 1024 * 1024 ; // 1M
//		    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
//		    $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
//		    $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
//		    // 上传文件
//		    $info   =   $upload->upload();
//		    if(!$info)
//		    {
//		        // 在控制器中才能使用 $this->error($upload->getError());因为model不负责打印信息只负责传递真假
//		    	// 获取失败原因把错误信息保存到 model的error属性中，
//                //然后在控制器里会调用$model->getError()获取到错误信息并由控制器打印
//		    	$this->error = $upload->getError();
//		        return FALSE;
//		    }
//		    else
//		    {
//		        //var_dump($info);die;  测试上传是否成功
//		    	/**************** 生成缩略图 *****************/
//		    	// 先拼成原图上的路径  存储路径 + 存储名称
//		    	$logo = $info['logo']['savepath'] . $info['logo']['savename'];
//		    	// 拼出缩略图的路径和名称
//		    	$mbiglogo = $info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];
//		    	$biglogo = $info['logo']['savepath'] .'big_'. $info['logo']['savename'];
//		    	$midlogo = $info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
//		    	$smlogo = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
//		    	// 实例化image 类
//		    	$image = new \Think\Image();
//		    	// 打开要生成缩略图的图片
//		    	$image->open('./Public/Uploads/'.$logo);
//		    	// 生成缩略图，设置相应宽，高
//		    	$image->thumb(700, 700)->save('./Public/Uploads/'.$mbiglogo);
//		    	$image->thumb(350, 350)->save('./Public/Uploads/'.$biglogo);
//		    	$image->thumb(130, 130)->save('./Public/Uploads/'.$midlogo);
//		    	$image->thumb(50, 50)->save('./Public/Uploads/'.$smlogo);
//		    	/**************** 把路径放到表单中 *****************/
//		    	$data['logo'] = $logo;
//		    	$data['mbig_logo'] = $mbiglogo;
//		    	$data['big_logo'] = $biglogo;
//		    	$data['mid_logo'] = $midlogo;
//		    	$data['sm_logo'] = $smlogo;
//		    }
//		}

//        使用函数上传图片并生成缩略图
        $ret = uploadOne('logo', 'Goods', array(
            array(700, 700),
            array(350, 350),
            array(130, 130),
            array(50, 50),
        ));
        if($ret['ok'] == 1)
        {
            $data['logo']=$ret['images'][0];   // 原图地址
            $data['mbig_logo']=$ret['images'][1];   // 第一个缩略图地址
            $data['big_logo']=$ret['images'][2];   // 第二个缩略图地址
            $data['mid_logo']=$ret['images'][3];   // 第三个缩略图地址
            $data['sm_logo']=$ret['images'][4];   // 第三个缩略图地址
        }
        else
        {
            $this->error = $ret['error'];
            return FALSE;
        }
		// 获取当前时间并添加到表单中这样就会插入到数据库中
		$data['addtime'] = date('Y-m-d H:i:s', time());
		// 通过公共自定义方法过滤这个字段
		$data['goods_desc'] = removeXSS($_POST['goods_desc']);

	}

    protected function _before_update(&$data, $options)
    {
        //$id = I('get.id');  I函数需要接受再过滤，效率比较慢
        $id = $options['where']['id'];  // 直接在变量里面取ID更快
        /************ 修改商品属性 *****************/
        $gaid = I('post.goods_attr_id');
        $attrValue = I('post.attr_value');
        $gaModel = D('goods_attr');
        $_i = 0;  // 循环次数
        foreach ($attrValue as $k => $v)
        {
            foreach ($v as $k1 => $v1)
            {
                // 这个replace into可以实现同样的功能
                // replace into ：如果记录存在就修改，记录不存在就添加。以主键字段来判断一条记录是否存在
                //$gaModel->execute('REPLACE INTO p39_goods_attr VALUES("'.$gaid[$_i].'","'.$v1.'","'.$k.'","'.$id.'")');
                // 找这个属性值是否有id
                if($gaid[$_i] == '')
                    $gaModel->add(array(
                        'goods_id' => $id,
                        'attr_id' => $k,
                        'attr_value' => $v1,
                    ));
                else
                    $gaModel->where(array(
                        'id' => array('eq', $gaid[$_i]),
                    ))->setField('attr_value', $v1);  // 修改一个属性值，setfield

                $_i++;
            }
        }

        /************ 处理扩展分类 ***************/
        $ecid = I('post.ext_cate_id');
        $gcModel = D('goods_cate');
        // 先删除原分类数据
        $gcModel->where(array(
            'goods_id' => array('eq', $id),
        ))->delete();
        if($ecid)
        {
            // 去重
            $ecid = array_unique($ecid);
            foreach ($ecid as $k => $v)
            {
//                var_dump($v);die;
                if(empty($v))
                    continue ;
                $gcModel->add(array(
                    'cate_id' => $v,
                    'goods_id' => $id,
                ));
            }
        }

        /**************** 处理LOGO *******************/
        // 判断有没有选择图片  var_dump($_FILES );查看文件信息
        if($_FILES['logo']['error'] == 0)
        {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize = 1024 * 1024 ; // 1M
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath = './Public/Uploads/'; // 设置附件上传根目录
            $upload->savePath = 'Goods/'; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->upload();
            if(!$info)
            {
                // 在控制器中才能使用 $this->error($upload->getError());因为model不负责打印信息只负责传递真假
                // 获取失败原因把错误信息保存到 model的error属性中，
                //然后在控制器里会调用$model->getError()获取到错误信息并由控制器打印
                $this->error = $upload->getError();
                return FALSE;
            }
            else
            {
                //var_dump($info);die;  测试上传是否成功
                /**************** 生成缩略图 *****************/
                // 先拼成原图上的路径  存储路径 + 存储名称
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                // 拼出缩略图的路径和名称
                $mbiglogo = $info['logo']['savepath'] .'mbig_'. $info['logo']['savename'];
                $biglogo = $info['logo']['savepath'] .'big_'. $info['logo']['savename'];
                $midlogo = $info['logo']['savepath'] .'mid_'. $info['logo']['savename'];
                $smlogo = $info['logo']['savepath'] .'sm_'. $info['logo']['savename'];
                // 实例化image 类
                $image = new \Think\Image();
                // 打开要生成缩略图的图片
                $image->open('./Public/Uploads/'.$logo);
                // 生成缩略图，设置相应宽，高
                $image->thumb(700, 700)->save('./Public/Uploads/'.$mbiglogo);
                $image->thumb(350, 350)->save('./Public/Uploads/'.$biglogo);
                $image->thumb(130, 130)->save('./Public/Uploads/'.$midlogo);
                $image->thumb(50, 50)->save('./Public/Uploads/'.$smlogo);
                /**************** 把路径放到表单中 *****************/
                $data['logo'] = $logo;
                $data['mbig_logo'] = $mbiglogo;
                $data['big_logo'] = $biglogo;
                $data['mid_logo'] = $midlogo;
                $data['sm_logo'] = $smlogo;
                /**************** 删除原来的图片 *****************/
                // 查询出原来的图片路径
                $oldlogo=$this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
                // 删除硬盘上的图片
//                unlink('./public/uploads/'.$oldlogo['logo']);
//                unlink('./public/uploads/'.$oldlogo['mbig_logo']);
//                unlink('./public/uploads/'.$oldlogo['big_logo']);
//                unlink('./public/uploads/'.$oldlogo['mid_logo']);
//                unlink('./public/uploads/'.$oldlogo['sm_logo']);
                // 通过自定义函数 删除图片
                deleteImage($oldlogo);
            }
        }

        /************ 处理会员价格 ****************/
        $mp = I('post.member_price');
        $mpModel = D('member_price');
        // 先删除原来的会员价格
        $mpModel->where(array(
            'goods_id' => array('eq', $id),
        ))->delete();
        foreach ($mp as $k => $v)
        {
            $_v = (float)$v;
            // 如果设置了会员价格就插入到表中
            if($_v > 0)
            {
                $mpModel->add(array(
                    'price' => $_v,
                    'level_id' => $k,
                    'goods_id' => $id,
                ));
            }
        }
        // 通过公共自定义方法过滤这个字段
        $data['goods_desc'] = removeXSS($_POST['goods_desc']);
    }

    public function search($perPage = 10)
    {
        // 获取get数据
        $where = array();  // 定义where 条件
        // 商品名称搜索
        $gn = I('get.goods_name');
        if($gn)
            $where['goods_name']= array('like',$gn); // WHERE goods_name LIKE '%$gn%'
        // 价格搜索
        $fp = I('get.shop_pricefrom');  // 开始价格
        $tp = I('get.shop_priceto');  // 结束价格
        if ($fp && $tp)
            $where['shop_price']=array('between',array($fp,$tp)); // WHERE shop_price BETWEEN $fp AND $tp
        elseif ($fp)
            $where['shop_price']=array('egt',$fp); // WHERE shop_price >= $fp
        elseif ($tp)
            $where['shop_price']=array('elt',$tp); // WHERE shop_price <= $tp
        // 上架状态搜索
        $ios = I('get.is_on_sale');
        if($ios)
            $where['is_on_sale'] = array('eq',$ios); // WHERE is_on_sale = $ios
        // 上架时间搜索
        $tf = I('get.addtimefrom');  // 开始价格
        $tt = I('get.addtimeto');  // 结束价格
        if ($tf && $tt)
            $where['addtime']=array('between',array($tf,$tt)); // WHERE shop_price BETWEEN $fp AND $tp
        elseif ($tf)
            $where['addtime']=array('egt',$tf); // WHERE shop_price >= $fp
        elseif ($tt)
            $where['addtime']=array('elt',$tt); // WHERE shop_price <= $tp
        //  品牌搜索
        $brandID = I('get.brand_id');
        if($brandID)
            $where['a.brand_id'] = array('eq',$brandID);
        //  分类搜索
        $cateID = I('get.cate_id');
        if($cateID){
            //先查询出这个分类ID下所有的商品ID
            $gids = $this->getGoodsIdByCatId($cateID);
            $where['a.id']=array('IN',$gids);
        }



        //  翻页，取出总的记录数
        $count = $this->where($where)->count();
        // 生成翻页对象,总数 每页显示几条数据 根据上面$perPage定义默认10条
        $pageObj= new Page($count,$perPage);
        // 设置样式
        $pageObj->setConfig('next','下一页');
        $pageObj->setConfig('prev','上一页');
        //  生成页面的上一页、下一页的字符串
        $pageString = $pageObj->show();

        // 排序方法
        $orderby = 'id';
        $orderway ='desc';  // 定义默认的排序

        $odby = I('get.odby');
        if($odby){
            if ($odby=='id_asc')
                $orderway = 'asc';
            elseif ($odby=='price_desc')
                $orderby='shop_price';
            elseif ($odby=='price_asc'){
                $orderby = 'shop_price';
                $orderway ='asc';
            }
        }
//        多表查询
//       原生写法 select a.*,b.brand_name from p_goods a left join p_brand b on a.brand_id=b.id \G;
        // 获取某一页的数据
        $data = $this->order("$orderby $orderway")
            ->field('a.*,b.brand_name,c.cat_name,GROUP_CONCAT(e.cat_name SEPARATOR "<br />") ext_cat_name')                       //  需要查询的字段
            ->alias('a')                                        //  给goods表定义别名
            ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.id  
                 LEFT JOIN __CATEGORY__ c ON a.cate_id=c.id
                 LEFT JOIN __GOODS_CATE__ d ON d.goods_id=a.id 
                 LEFT JOIN __CATEGORY__ e ON d.cate_id=e.id' )  // 连接分类表，取主分类
            ->where($where)                                         // 设定where
            ->limit($pageObj->firstRow.','.$pageObj->listRows)  //  分页
            ->group('a.id')   // 将重复的数据合并，分组之后只取一个了
            ->select();
       //  返回数据（页数，单页的数据）
        return array(
            'data' => $data,   //  单页详细数据
            'page' => $pageString,  // 翻页字符串
        );
	}

    protected function _before_delete($options)
    {
        $id = $options['where']['id'];
        // 查询出原来的图片路径
        $oldlogo=$this->field('logo,mbig_logo,big_logo,mid_logo,sm_logo')->find($id);
        // 删除硬盘上的图片
        unlink('./public/uploads/'.$oldlogo['logo']);
        unlink('./public/uploads/'.$oldlogo['mbig_logo']);
        unlink('./public/uploads/'.$oldlogo['big_logo']);
        unlink('./public/uploads/'.$oldlogo['mid_logo']);
        unlink('./public/uploads/'.$oldlogo['sm_logo']);
        //  删除商品属性
        $gaModel = D('goods_attr');
        $gaModel->where(array(
            'goods_id'=>array('eq',$id),
        ))->delete();

        //  删除会员价格
        $mpModel = D('member_price');
        $mpModel->where(array(
            'goods_id'=>array('eq',$id),
        ))->delete();

        // 删除商品库存数据
        $gnModel = D('goods_number');
        $gnModel->where(array(
            'goods_id'=> array('eq',$id),
        ))->delete();

        //  删除扩展分类
        $mpModel = D('goods_cate');
        $mpModel->where(array(
            'goods_id'=>array('eq',$id),
        ))->delete();
    }

    /**
     * 商品添加之后调用这个方法，其中$data['id']就是新添加商品的ID
     */
    protected function _after_insert($data, $options)
    {
        //  处理商品属性
        $attrValue = I('post.attr_value');
//        var_dump($attrValue);
        $gaModel = D('goods_attr');
        foreach ($attrValue as $k => $v){
            // 防止重复使用array_unique
            $v =array_unique($v);
            foreach ($v as $k1 => $v1){
                $gaModel->add(array(
                    'goods_id'=>$data['id'],
                    'attr_id'=>$k,
                    'attr_value'=>$v1,
                ));
            }
        }
        /**************** 处理扩展分类 *******************/
        $ecid = I('post.ext_cate_id');
        if ($ecid){
            $gcModel=D('goods_cate');
            foreach ($ecid as $k=>$v){
                if (empty($v))  //  如果为空直接跳过
                    continue;
                $gcModel->add(array(
                    'cate_id'=>$v,
                    'goods_id'=>$data['id'],
                ));
            }
        }

        $mp = I('post.member_price');
        $mpModel = D('member_price');
        foreach ($mp as $k => $v){
            $_v =(float)$v; // 将价格转为浮点型，如果是字母则为0
            if($_v > 0) {   // 当大于0 时，进行插入操作
                $mpModel->add(array(
                    'price' => $v,
                    'level_id' => $k,
                    'goods_id' => $data['id'],
                ));
            }
        }
    }

    /**
     * 取出一个分类(主分类和扩展分类)下所有商品的ID
     */
    public function getGoodsIdByCatId($cateID)
    {
//            先取出所有子分类的id
        $cateModel = D('category');
        $children = $cateModel->getChildren($cateID);
//            把当前ID和子分类ID放到一起
        $children[] = $cateID;
        /**********取出主分类或者扩展分类在这些分类中的商品***********/
        // 取出主分类下的商品ID
        $gids = $this->field('id')->where(array(
            'cate_id' => array('in',$children),  // 主分类下的所有商品
        ))->select();
        // 取出扩展分类下的商品ID
        $gcModel=D('goods_cate');
        $gids1 = $gcModel->field('DISTINCT goods_id is')->where(array(
            'cate_id'=>array('IN',$children)
        ))->select();
        // 把主分类的ID和扩展分类下的商品ID合并成一个二维数组
        if ($gids && $gids1)  //  当两个数组不为空时合并数组
            $gids = array_merge($gids,$gids1);
        elseif ($gids1)
            $gids=$gids1;
        // 二维数组转一维
        $id =array();
        foreach ($gids as $k => $v){
            if (!in_array($v['id'],$id))   // 除去重复的ID
                $id[]=$v['id'];
        }
        return $id;
    }
}












