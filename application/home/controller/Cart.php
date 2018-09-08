<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 21:29
 */

namespace app\home\controller;


use think\Controller;

class Cart extends Base
{
    public function index()
    {
        //dump(unserialize(cookie('cart')));die;
        //查询购物车数据 调用Cart模型getAllCart方法
        $list = \app\home\model\Cart::getAllCart();
//        dump($list);die;
        //查询每一条购物记录中的商品信息
        foreach($list as $k => &$v){
            //$v['goods_id']
            //查询商品表基本信息
            $v['goods'] = \app\home\model\Goods::find($v['goods_id'])->toArray();
            //查询商品属性值 属性名称信息
//            select t1.*,t2.attr_name from tpshop_goods_attr t1 left join tpshop_attribute t2 on t1.attr_id = t2.id in (8,11);
            $v['goodsattr'] = \app\home\model\GoodsAttr::alias('t1')
                ->field('t1.*,t2.attr_name')
                ->join('tpshop_attribute t2','t1.attr_id = t2.id','left')
                ->where('t1.id','in',$v['goods_attr_ids'])
                ->select();
        }
        return view('index',['list'=>$list]);
    }
    //购物车列表优化写法
    public function index1()
    {
        //查询购物车数据 调用Cart模型getAllCart方法
        $list = \app\home\model\Cart::getAllCart();
        //将所有购物记录中的商品id 取出来
        $goods_ids = [];
        foreach ($list as $v){
            $goods_ids[$v['goods_id']] = $v['goods_id'];
//            $goods_ids[] = $v['goods_id'];//可以foreach外面使用array_unique函数去重
        }
        //查询所有商品信息
        $goods = \app\home\model\Goods::where('id','in',$goods_ids)->select();
//        dump($goods);die;
        //更好的写法
        //[obj,obj]  [49=>obj,50=>obj]
        $new_goods = []; //新的商品数组中 以商品id为下标
        foreach($goods as $v){
            $new_goods[$v['id']] = $v;
        }
        unset($v);
        //遍历购物车数据$list
        foreach ($list as &$v){
            //$v['goods_id'] 根据商品id为下标 从new_goods中取出对应的商品信息
            $v['goods'] = $new_goods[$v['goods_id']];
        }
        unset($v);
//        dump($list);die;
        //查询商品属性值 属性名称信息 优化
        //将所有的属性值对应的主键id放到一个数组
        $goods_attr_ids = [];
        foreach($list as $v){
            $temp = explode(',',$v['goods_attr_ids']);
            //数组合并 arr1 + arr2 ; 数组函数 array_merge()
            $goods_attr_ids = array_merge($goods_attr_ids,$temp);
        }
        unset($v);
        //数组去重
        $goods_attr_ids = array_unique($goods_attr_ids);
//        dump($goods_attr_ids);die;
        //查询所有属性值 属性名称
        $goodsattr = \app\home\model\GoodsAttr::alias('t1')
            ->field('t1.*,t2.attr_name')
            ->join('tpshop_attribute t2','t1.attr_id = t2.id','left')
            ->where('t1.id','in',$goods_attr_ids)
            ->select();
        //将属性值数组中 主键id作为下标
        $new_goodsattr = [];
        foreach ($goodsattr as $v){
            $new_goodsattr[$v['id']] = $v;
        }
        unset($v);
        //将购物车数组$list 和 属性值 $new_goodsattr 整合到一起
        foreach($list as &$v){
            //$v['goods_attr_ids'] //8,11
            //在每条购物车数据中 对goods_attr_ids中的每一个值 从$new_goodsattr取出属性数据
            $temp = explode(',',$v['goods_attr_ids']);
            foreach ($temp as $id){
                $v['goodsattr'][] = $new_goodsattr[$id];
            }
        }
        unset($v);
//        dump($list);die;
        return view('index',['list'=>$list]);
    }
    public function addcart()
    {
        //如果以get方式请求 直接跳到首页
        if(request()->isGet()){
            $this->redirect('home/index/index');
        }
        //接受参数
        $data = request()->param();
        //参数检测 略
        //处理数据 调用模型的addcart方法
        \app\home\model\Cart::addcart($data['goods_id'],$data['number'],$data['goods_attr_ids']);
        //显示成功页面
        //查询商品信息 logo 和名称等信息
        $goods = \app\home\model\Goods::find($data['goods_id']);
        return view('addcart',['goods'=>$goods]);
    }

    public function changenum()
    {
        //接收参数
        $data = request()->param();
        //参数检测 略
        //处理数据
        \app\home\model\Cart::changeNum($data['goods_id'],$data['goods_attr_ids'],$data['number']);
        //返回数据
        return json(['code'=>10000,'msg'=>'success']);
    }

    public function delcart()
    {
        //接受参数
        $data = request()->param();
        //参数验证 略
        //数据处理
        \app\home\model\Cart::delCart($data['goods_id'],$data['goods_attr_ids']);
        //返回数据
        return ['code'=>10000,'msg'=>'success'];
    }
}