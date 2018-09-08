<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 15:44
 */

namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    public function login()
    {
        if (request()->isGet()){
            $this->view->engine->layout(false);
            return view();
        }
        if (request()->isPost()){
            $data = request()->param();
            if (!captcha_check($data['code'])){
                $this->error('验证码错误');
            }
            $where = [
                'username' => $data['username'],
                'password' => encrypt_password($data['password']),
            ];
            $info = \app\admin\model\Manager::where($where)->find();
            if ($info){
                session('user_info',$info->toArray());
                $this->redirect('admin/index/index');
            }else{
                $this->error('用户名或密码错误');
            }

        }

    }

    public function logout()
    {
        session(null);
        $this->redirect('login/login');
    }
}