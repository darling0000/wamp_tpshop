<?php

namespace app\home\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        //$mem = new \Memcached();
        //$mem->addServer('127.0.0.1',11211);
        //$category = $mem->get('category');
        //if($category === false){
            $category = \app\home\model\Category::where('is_show',1)->select();
            //$mem->set('category',$category,time()+5);
        //}

        $this->assign('category',$category);
    }
}
