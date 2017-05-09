<?php
namespace Home\Controller;
class IndexController extends NavController {
    public function index(){
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