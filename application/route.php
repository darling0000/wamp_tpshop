<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
//商品列表页 list.html
//\think\Route::rule('list', 'admin/goods/index', 'GET', ['ext' => 'html']);
//商品编辑页 edit/42.html
//\think\Route::rule('edit/:id', 'admin/goods/edit', 'GET', ['ext' => 'html'], ['id'=>'\d+']);
//首页 定义的路由可以和普通情况下的地址一样
//\think\Route::rule('admin/index/index', 'admin/index/index', 'GET');

//路由分组
//\think\Route::group('hm', function(){
//    //登录页面
//    \think\Route::get('login', 'home/login/login');
//    //注册页面
//    \think\Route::get('register', 'home/login/register');
//});
//伪静态处理
//前台商品详情页伪静态处理  /goods/50.html   /home/goods/detail/id/50
//\think\Route::rule('goods/:id', 'home/goods/detail', 'GET', ['ext' => 'html'], ['id' => '\d+']);

//前台商品详情页伪静态处理  /goods_50.html   /home/goods/detail/id/50
//使用组合变量的写法
//\think\Route::rule('goods_<id>', 'home/goods/detail', 'GET', ['ext' => 'html'], ['id' => '\d+']);

