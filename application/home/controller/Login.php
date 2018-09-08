<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 21:27
 */

namespace app\home\controller;


use app\home\model\User;
use think\Controller;

class Login extends Controller
{
    public function login()
    {
        $this->view->engine->layout(false);
        return view();
    }

    public function register()
    {
        $this->view->engine->layout(false);
        return view();
    }

    //邮箱注册
    public function registeremail()
    {
        //临时关闭模板布局
        $this->view->engine->layout(false);
        return view('register_email');
    }

    //邮箱注册 表单提交
    public function email()
    {
        //接收数据
        $data = request()->param();
        //参数检测
        //验证规则
        $rule = [
            'email' => 'require|email|unique:user',
            'password' => 'require|length:6,16|confirm:repassword',
        ];
        //提示信息
        $msg = [
            'email.require' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱已被注册',
            'password.require' => '密码不能为空',
            'password.length' => '密码长度必须为6到16个字符',
            'password.confirm' => '两次密码输入必须一致'
        ];
        //实例化验证类
        $validate = new \think\Validate($rule, $msg);
        //执行验证
        if(!$validate->check($data)){
            //验证不通过，报错
            $error = $validate->getError();
            $this->error($error);
        }
        //添加数据到用户表
        //密码加密
        $data['password'] = encrypt_password($data['password']);
        //特殊字段
        $data['username'] = $data['email'];
        //验证码用于后续激活时做校验
        $data['email_code'] = mt_rand(1000, 9999);
        //添加用户记录，属于未激活状态
        $user = \app\home\model\User::create($data, true);
        //发送激活邮件
        $subject = "TP5商城注册激活邮件";
        $url = "http://www.tpshop.com/home/login/jihuo/id/" . $user['id'] . "/code/" . $data['email_code'];
        $body = "欢迎注册，请点击以下链接进行激活：<br><a href='$url'>点我激活</a><br>如果点击无法跳转，请复制链接到浏览器地址栏直接打开";
        $res = sendmail($data['email'], $subject, $body);
        //页面跳转  正常情况下，需要显示html页面进行提示
        if($res === true){
            //邮件发送成功
            $this->success('邮件发送成功，请进行激活', 'login');
        }else{
            //邮件发送失败
            $this->error('邮件发送失败,请联系客服');
        }
    }

    //邮箱账号激活
    public function jihuo()
    {
        //接收参数
        $data = request()->param();
        //参数检测 略
        //激活账号
        //①直接修改 用户记录的  is_check字段
//        \app\home\model\User::update(['is_check' => 1], ['id' => $data['id'], 'email_code' => $data['code']]);
        //跳转页面
//        $this->success('账号激活成功', 'login');

        //②先查询再修改
        $user = \app\home\model\User::where(['id' => $data['id'], 'email_code' => $data['code']])->find();
        if($user){
            //修改is_check字段
            $user->is_check = 1;
            $user->save();
            $this->success('账号激活成功', 'login');
        }else{
            $this->error('用户不存在');
        }
    }
    //检测手机号是否已被注册
    public function checkphone()
    {
        sleep(2);
        $phone = request()->param('phone');
        if(!preg_match('/^1[3-9]\d{9}$/',$phone)){
            $res = [
                'code' => 10001,
                'msg'  => '手机号格式不正确',
            ];
            echo json_encode($res);die;
        }
        $user = \app\home\model\User::where('phone',$phone)->find();
        if ($user){
            $res = [
                'code' => 10000,
                'msg'  => 'success',
                'status' => 1
            ];
            echo json_encode($res);die;
        }else{
            $res = [
                'code' => 10000,
                'msg'  => 'success',
                'status' => 0
            ];
            echo json_encode($res);die;
        }
    }

    //注册 发送短信验证码
    public function sendcode($phone)
    {
        if(empty($phone)){
            return ['code'=>10002,'msg'=>'参数错误'];
        }
        //短信内容

        //接收手机号
        $phone = request()->param('phone');
        //验证号码格式
        if(!preg_match('/^1[3-9]\d{9}$/',$phone)){
            //
            return json(['code'=>10001,'msg'=>'手机号格式不正确']);
        }
        //频率检测
        $last_time = session('register_sendtime'.$phone)?:0;
        if(time() - $last_time <60){
            return json(['code'=>1003,'msg'=>'发送太频繁']);
        }
        //发送之前 ip检测 当天日志
        $ip = $_SERVER['REMOTE_ADDR'];
        $day = date('Ymd');
        $num = session('register_ip_num_'.$ip.$day)?:0;
        if($num > 10){
            return json(['code'=>10004,'msg'=>'发送次数达到上限']);
        }
        $code = mt_rand(1000,9999);
        $msg = "【大领科技】验证码为：{$code},欢迎注册平台！";
//        $msg = "【成都创信信息】验证码为：5873,欢迎注册平台！";
//        $msg = "【凯信通】您的授权码是：{$code},绑定手机号码15810875598，如非本人操作，请联系客服17600401420";
        //
        $res = sendmsg($phone,$msg);
//        $res = true;
        if($res === true){
            //发送成功
            //记录验证码 后续校验用 且需保留验证码和手机的对应关系
            session('register_code_' . $phone,$code);
            //记录发送时间
            session('register_sendtime_'.$phone,time());
            //根据ip 限制发送频率 当天日期
            session('register_ip_num_'.$ip.$day,$num + 1) ?:0;
            //return ['code'=>10000,'msg'=>'发送成功']; //项目上线时
            return ['code'=>10000,'msg'=>'发送成功','data'=>$code]; //开发测试时data
        }else{
            //return ['code'=>10001,'msg'=>'发送失败']; //项目上线时
            return ['code'=>10001,'msg'=>$res]; //开发测试时
        }
    }

    //手机号注册 提交表单
    public function phone()
    {
        //接收参数
        $data = request()->param();
        //参数检测 表单验证
        //验证规则
        $rule = [
            'phone' => 'require|regex:/^1[3-9]\d{9}$/|unique:user',
            'code' => 'require|regex:/^\d{4}$/',
            'password' => 'require|length:6,16|confirm:repassword',
        ];
        //提示信息
        $msg = [
            'phone.require' => '手机号不能为空',
            'phone.regex' => '手机号格式不正确',
            'phone.unique' => '手机号已被注册',
            'code.require' => '验证码不能为空',
            'code.regex' => '验证码格式不正确',
            'password.require' => '密码不能为空',
            'password.length' => '密码长度必须为6到16个字符',
            'password.confirm' => '两次密码输入必须一致'
        ];
        //实例化验证类
        $validate = new \think\Validate($rule, $msg);
        //执行验证
        if(!$validate->check($data)){
            //验证不通过，报错
            $error = $validate->getError();
            $this->error($error);
        }
        //检测验证码
        $code = session('register_code_' . $data['phone']);
        if($code != $data['code']){
            $this->error('验证码错误');
        }
        //验证验证码有效期
        $sendtime = session('register_sedtime_'.$data['phone']);
        if(time() - $sendtime > 300){
            //超过5分钟过期
            $this->error('验证码过期');
        }
        //让验证码失效，从session删除掉
        session('register_code_'.$data['phone'],null);
        //接下来才是正常的注册， 添加数据
        $data['password'] = encrypt_password($data['password']);
        //用户名设置为手机号，是否激活状态，设置为已激活
        $data['username'] = $data['phone'];
        $data['is_check'] = 1;
        \app\home\model\User::create($data, true);
        //跳转页面
        $this->success('注册成功', 'login');
    }

    public function dologin()
    {
        //接收数据
        $data = request()->param();
        //参数检测 略
        //根据用户名密码查询用户表
        $password = encrypt_password($data['password']);
//        //①先查询用户，再比对密码
//        $user = \app\home\model\User::where('phone', $data['username'])->whereOr('email', $data['username'])->find();
////        //用户存在，密码正确，已激活
//        if($user && $user['password'] == $password && $user['is_check'] == 1){
//            //登录成功，设置登录标识
//            session('user', $user->toArray());
//            //页面跳转
//            $this->success('登录成功', 'home/index/index');
//        }else{
//            //用户名或者密码错误
//            $this->error('用户名或者密码错误');
//        }

        //②直接根据用户名、密码等条件一起查询用户表
        $user = \app\home\model\User::where(function($query)use($data){
            $query->where('phone', $data['username'])->whereOr('email', $data['username']);
        })->where('password', $password)->where('is_check', 1)->find();
        if($user){
            //设置登录标识
            session('user', $user->toArray());
            //购物车数据的迁移到数据表
            \app\home\model\Cart::cookieTodb();
            //获取session中的跳转地址
            $back_url = session('back_url') ? session('back_url') : 'home/index/index';
            $this->success('登录成功',$back_url);
        }else{
            //用户名或者密码错误
            $this->error('用户名或者密码错误');
        }
    }

    //qq登录回调
    public function qqcallback()
    {
        //echo "I am here";
        require_once("./plugins/qq/API/qqConnectAPI.php");
        $qc = new \QC();
        $access_token = $qc->qq_callback();
        $openid = $qc->get_openid();
        //重新实例化qc类 获取用户信息
        $qc = new \QC($access_token,$openid);
        $info = $qc->get_user_info();
//        dump($info);die;
        //自动注册和登录
        //先根据openid查询用户表 如不存在则创建用户
        $user = \app\home\model\User::where('openid',$openid)->find();
        if($user){
            //用户存在更新用户信息（昵称）
            $user->username = $info['nickname'];
            $user->save();
        }else{
            //用户不存在
            \app\home\model\User::create(['openid'=>$openid,'username'=>$info['nickname']]);
        }
        //设置登录标识
        $user = \app\home\model\User::where('openid',$openid)->find();
        session('user',$user->toArray());
        //购物车数据的迁移到数据表
        \app\home\model\Cart::cookieTodb();
        //页面跳转 首页
        //获取session中的跳转地址
        $back_url = session('back_url') ? session('back_url') : 'home/index/index';
        $this->redirect($back_url);
    }
    //退出
    public function logout()
    {
        //清空session
        session(null);
        //跳转到登录页面
        $this->redirect('login');
    }

    //模拟接口编程
    public function test_api()
    {
        //接收数据
        $data = request()->param();
        //处理数据
        //返回数据
        $res = [
            'code' => 10000,
            'msg' => 'success',
            'data' => $data,
        ];
        return json($res);
    }
    //模拟接口调用
    public function test_request()
    {
        //
        $url = "http://www.tpshop.com/home/login/test_api/id/10/page/100";
        //
//        $res = curl_request($url);
        $param = [
            'id'=>10,
            'page'=>100,
        ];
        $res = curl_request($url,true,$param);
        return $res;die;
    }

    public function test_msg()
    {
        $phone = '15810875598';
        $msg = '【成都创信信息】验证码为：****,欢迎注册平台！';
        $res = sendmsg($phone,$msg);
        dump($res);die;
    }

}