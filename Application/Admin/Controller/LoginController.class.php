<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Verify;

class LoginController extends Controller
{
    public function login()
    {
        if (IS_POST){
            $model = D('admin');
            // 接收表单并验证
            if ($model->validate($model->_login_validate)->create()){
                if ($model->login()){
                    $this->success('登录成功!',U('index/index'));
                    exit;
                }
            }
            $this->error($model->getError());
        }
        $this->display();
    }

    public function logout()
    {
        $model = D('Admin');
        $model->logout();
        redirect('login');
    }

    // 验证码
    public function chkcode()
    {
        $verify = new Verify(array(
            'fontSize'=> 13,  // 字体大小
            'length'=>4,     // 验证位数
            'useNoise'=> false,  // 关闭验证码杂点
            'imageW'=> 100,
            'imageH'=>30,
        ));
        $verify->entry();
    }
}