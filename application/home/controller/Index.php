<?php
namespace app\home\controller;

use think\Controller;

class Index extends Base
{
    public function index1()
    {
        //页面缓存
        ob_start();
        //模板渲染
        $html = $this->fetch();
        //获取缓存内容
//        $html = ob_get_clean();
        //将内容写入静态文件
        file_put_contents('./static.html',$html);
        //跳转到static.html
        $this->redirect('http://www.tpshop.com/static.html');
//        header('location:http://www.tpshop.com/static.html');die;
    }
    public function index()
    {
        //页面缓存
//        ob_start();
        //模板渲染
        $html = $this->fetch();
        //获取缓存内容
//        $html = ob_get_clean();
        //将内容写入静态文件
//        file_put_contents('./static.html',$html);
        //跳转到static.html
//        $this->redirect('http://www.tpshop.com/static.html');
//        header('location:http://www.tpshop.com/static.html');die;
        echo $html;
    }
}
