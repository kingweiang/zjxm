<?php
namespace Home\Controller;
class IndexController extends NavController {
    public function index(){
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