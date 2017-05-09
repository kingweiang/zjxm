<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller
{
    public function __construct()
    {
        // 必须先调用父类的构造函数
        parent::__construct();
        // 验证session
        if (!session('id'))
            $this->error('请登录后进行访问！',U('Login/login'));
        // 所以用户都可以进入后台的首页
        if(CONTROLLER_NAME == 'index')
            return TRUE;
        $priModel = D('privilege');
        if (!$priModel->chkPri())
            $this->error('无权访问该页面！');
    }
}