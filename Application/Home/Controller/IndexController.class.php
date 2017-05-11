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
        // 页面信息设置
        $this->assign(array(
            '_page_title'=>'商品详情页',
            '_show_nav'=>0,                  //  控制导航条是否显示
            '_page_keywords'=>'商品详情',      //  页面关键字
            '_page_description'=>'商品描述',   //  页面描述
        ));

        $this->display();
    }
}