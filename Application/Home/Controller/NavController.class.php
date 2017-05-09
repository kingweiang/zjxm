<?php
namespace Home\Controller;
use Think\Controller;
class NavController extends Controller {
    function __construct()    {
        // 必须先调用父类的构造函数
        parent::__construct();
        $cateModel = D('Admin/Category');
        $cateData = $cateModel->getNavData();
        $this->assign('cateDate',$cateData);
    }
}