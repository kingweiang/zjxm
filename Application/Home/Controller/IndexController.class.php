<?php
namespace Home\Controller;
class IndexController extends NavController {
    public function index(){
        // 测试静态化结束时并发调用的代码
        $file = uniqid();  //基于以微秒计的当前时间，生成一个唯一的 ID
        file_put_contents('./piao/'.$file,'abc'); //  每次执行生成一个文件
        // 获取首页楼层的数据
        $cateModel = D('Admin/Category');
        $floorData = $cateModel->floorData();
        // 获取促销商品
        $goodsModel =D('Admin/Goods');
        $goods1 = $goodsModel->getPromoteGoods();
        $goods2 = $goodsModel->getRecGoods('is_new');   // 新品
        $goods3 = $goodsModel->getRecGoods('is_hot');   // 热卖
        $goods4 = $goodsModel->getRecGoods('is_best');   // 精品
        $this->assign(array(
            'goods1'=>$goods1,
            'goods2'=>$goods2,
            'goods3'=>$goods3,
            'goods4'=>$goods4,
            'floorData'=>$floorData,
        ));

        // 页面信息设置
        $this->assign(array(
            '_page_title'=>'首页',
            '_show_nav'=>1,                  //  控制导航条是否显示
            '_page_keywords'=>'首页',      //  页面关键字
            '_page_description'=>'描述',   //  页面描述
        ));

        $this->display();
    }

    public function goods(){
        $id = I('get.id');  // 获取商品的id
        //根据ID 取出商品的详情
        $gModel = D('Admin/Goods');
        $good_info = $gModel->find($id);
        // 在根据主分类ID 找出这个分类所有上级分类制作导航（面包屑）
        $catModel = D('Admin/Category');
        $catPath = $catModel->parentPath($good_info['cate_id']);
        dump($catPath);
        $this->assign(array(
            'info'=>$good_info,
            'catPath'=>$catPath,
        ));
        // 页面信息设置
        $this->assign(array(
            '_page_title'=>'商品详情页',
            '_show_nav'=>0,                  //  控制导航条是否显示
            '_page_keywords'=>'商品详情',      //  页面关键字
            '_page_description'=>'商品描述',   //  页面描述
        ));

        $this->display();
    }

    /**
     * 记录浏览历史
     */
    public function displayHistory()
    {
       $id =I('get.id');
       //  先从cookie中取出浏览历史的id ，因cookie不能存数组，只能序列化，所以使用unserialize() 方法进行转换
        $data = isset($_COOKIE['display_history'])?unserialize($_COOKIE['display_history']):array();
        // 把最新流量的商品放在最前面,使用函数把最新的id 插入最前面
        array_unshift($data,$id);
        // 去重复的商品
        $data = array_unique($data);
        // 只保留访问的前6个
        if(count($data)>6)
            $data = array_slice($data,0,6);
        // 数组存回cookie里，将数组转为序列,存储当前时间延后15天,指定根目录
        setcookie('display_history', serialize($data),time()+15*86400,'/');
        // 根据商品的Id 取出商品详细信息
        $goodsModel = D('Admin/Goods');
        $data = implode(',',$data); //  将数组转化为字符串
        $gData=$goodsModel->field('id,mid_logo,goods_name')->where(array(
            'id'=>array('in',$data),
            'is_on_sale'=>array('eq','是')
        ))->order("FIELD(id,$data)")         //  指定排序方式
        ->select();

        echo json_encode($gData);
    }
}