<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        /*$request = request();
//        $request = Request::request();
        $data = request()->param();
        $id = request()->param('id');
        var_dump($data);
        var_dump($id);die();*/
        $data = input();
        $id = input('id');
        dump($data);
        dump($id);die();

    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
//<?php
//require_once("wx_http_request.php");
//header("Content-type: application/json; charset=utf-8");
//$params = array(
//'mobile' => '13568813957',
//'content' => '【成都创信信息】验证码为：5873,欢迎注册平台！',
//'appkey' => '102fb21d9ce27fa9b3b1cbb00b61bca6'
//);
//$url = 'https://way.jd.com/chuangxin/dxjk';
//echo wx_http_request($url, $params );
    public function sendmail()
    {
        //发送邮件
        $email = '382843659@qq.com';
        $subject = '测试PHPMailer';
        $body = 'PHPMailer发送的邮件。哈哈哈';
        $res = sendmail($email,$subject,$body);
        dump($res);die;
    }
}
