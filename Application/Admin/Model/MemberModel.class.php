<?php
namespace Admin\Model;
use Think\Model;
use Think\Verify;

class MemberModel extends Model
{
	protected $insertFields = array('username','password','cpassword','chkcode','must_click');
	protected $updateFields = array('id','username','password','cpassword');
	protected $_validate = array(
	    array('must_click','require','必须同意注册协议',1,'regex',3),
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('username', '', '用户名已经存在！', 1, 'unique', 3),
		// 第6个参数，规则在什么时候生效。 1 添加时 2 修改时 3 所有情况都
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('password', '6,20', '密码长度必须是6至20位！', 1, 'length', 1),
		array('cpassword', 'password', '两次密码输入不一致！', 1, 'confirm', 3),
        array('chkcode','require','验证码不能为空！',1),
        array('chkcode','check_verify','验证码输入有误！',1,'callback'),
	);
	// 登录验证规则
    public $_login_validate = array(
        array('username','require','用户名不能为空！',1),
        array('password','require','密码不能为空！',1),
        array('chkcode','require','验证码不能为空！',1),
        array('chkcode','check_verify','验证码输入有误！',1,'callback'),
    );
    // 验证码验证
    public function check_verify($code,$id='')
    {
        $verify = new Verify();
        return $verify->check($code,$id);

    }
    // 登录方法验证数据
    public function login()
    {
        // 从模型中获取用户名和密码
        $username= $this->username;   // I('post.username')
        $password=$this->password;

        // 查询这个用户是否存在
        $user =$this->where(array(
            'username' => array('eq',$username),
        ))->find();

        if ($user){
            if ($user['password']==md5($password)){
                // 登录成功，写入session
                session('m_id',$user['id']);
                session('m_username',$user['username']);
                return TRUE;
            }else{
                $this->error = '密码错误!';
                return false;
            }
        }else{
            $this->error = '用户名错误!';
            return false;
        }
    }

    public function logout()
    {
        session(null);
    }

	// 添加前
	protected function _before_insert(&$data, $option)
	{
	    $data['password'] = md5($data['password']);
	}
    // 添加后
    protected function _after_insert($data, $options)
    {

    }

	// 修改前
	protected function _before_update(&$data, $option)
	{
	    if ($data['password'])
            $data['password'] = md5($data['password']);
	    else
	        unset($data['password']);  //  从表中删除这个字段，就不会修改这个内容
	}
	// 删除前
	protected function _before_delete($option)
	{

	}
	/************************************ 其他方法 ********************************************/
}