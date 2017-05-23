<?php
namespace Home\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function login()
    {
        if(IS_POST){
            $model = D('Admin/Member');
            if ($model->validate($model->_login_validate)->create()){
                if($model->login()){
                    $this->success('登录成功！',U('/'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '用户登录',
            '_page_keyword' => '用户登录',
            '_page_description' => '用户登录',
        ));
        $this->display();
    }

    public function regist()
    {
        if(IS_POST){
            $model = D('Admin/Member');
            if ($model->create(I('post.'),1)){
                if($model->add()){
                    $this->success('注册成功！',U('login'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        // 设置页面中的信息
        $this->assign(array(
            '_page_title' => '用户注册',
            '_page_keyword' => '用户注册',
            '_page_description' =>  '用户注册',
        ));
        $this->display();
    }

    // 验证码
    public function chkcode()
    {
        $verify = new \Think\Verify(array(
            'fontSize'=> 13,  // 字体大小
            'length'=>4,     // 验证位数
            'useNoise'=> false,  // 关闭验证码杂点
            'imageW'=> 100,
            'imageH'=>30,
        ));
        $verify->entry();
    }
    public function logout()
    {
        $model = D('Admin/Member');
        $model->logout();
        redirect('/');
    }
}