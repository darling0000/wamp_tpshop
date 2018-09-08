<?php

namespace app\home\model;

use think\Model;

class Cart extends Model
{
    //封装加入购物车的方法
    public static function addcart($goods_id,$number,$goods_attr_ids)
    {
        //根据登录状态判断 已登录 添加到数据表 未登录 添加到 cookie
        if(session('?user')){
            //已登录 添加到数据表
            //先判断 是否存在相同的购物记录--user_id goods_id goods_attr_ids--一起作为条件
            $user_id = session('user.id');
            $where = [
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'goods_attr_ids' => $goods_attr_ids,
            ];
            //查询
            $info = self::where($where)->find();
            if($info){
                //存在相同记录 累加购买数量
                $info->number += $number;
                $info->save();
            }else{
                //不存在相同记录 添加新记录
//                $data = $where;
                $where['number'] = $number;
                self::create($where);
            }
            return true;
        }else{
            //未登录 添加到cookie
            $cart = cookie('cart') ? unserialize(cookie('cart')) : [];
            //拼接要添加的记录的下标
            $key = $goods_id . '-' . $goods_attr_ids;
            //判断是否存在相同记录
            if(isset($cart[$key])){
                $cart[$key] += $number;
            }else{
                $cart[$key] = $number;
            }
            //将新的数组 重新转化为字符串 存储到cookie
            cookie('cart',serialize($cart),86400 * 7);
            return true;
        }
    }
    //封装获取所有购物车数据的方法
    public static function getAllCart()
    {
        //判断登录状态 已登录 查询数据表 未登录查询cookie
        if(session('?user')){
            //已登录 查询数据表
            $user_id = session('user.id');
            //根据user_id为条件查询购物车表[obj,obj]
            $data = self::where('user_id',$user_id)->select();
            //将结果下的数据对象 转化为数组
            foreach ($data as &$v){
                $v = $v->toArray();
            }
            return $data;
        }else{
            //未登录查询cookie
            $cart = cookie('cart') ? unserialize(cookie('cart')) : [];
//            dump($cart);die;
            $data = [];
            //遍历数组 将一维数组 转化为二维数组 （和数据表取出的数据一致）
            foreach($cart as $k=>$v){
                //$k  goods_id - goods_attr_ids : $v  number
                //['goods'=>'','goods_attr_ids'=>'','number'=>'']
                //将$k 用 - 分割为数组
//                dump($k);
                $temp = explode('-',$k);
//                dump($temp);
                $data[] = [
                    'id' => '',
                    'goods_id' => $temp[0],
                    'goods_attr_ids' => $temp[1],
                    'number' => $v,
                ];
            }
//            dump($data);die;
            //最终的二维数组结构 $data   [[],[],[]]
            return $data;
        }
    }
    //登录时将cookie中的购物车数据迁移到数据表
    public static function cookieTodb()
    {
        //从cookie取数据
        $cart = cookie('cart') ? unserialize(cookie('cart')) : array();
        if(empty($cart)){
            return;
        }
        //
        foreach($cart as $k=>$v){
            $temp = explode('-',$k);
            $goods_id = $temp[0];
            $goods_attr_ids = $temp[1];
            $number = $v;
            //接下来 登录状态下 加入购物车的过程
            self::addcart($goods_id,$number,$goods_attr_ids);
        }
        //清除cookie
        cookie('cart',null);
        return true;
    }
    //修改指定的购物记录的购买数量
    public static function changeNum($goods_id,$goods_attr_ids,$number)
    {
        //判断登录状态 已登录 修改数据表 未登录 修改cookie
        if(session('?user')){
            //已登录 修改数据表
            //获取用户id
            $user_id = session('user.id');
            //修改条件
            $where = [
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'goods_attr_ids' => $goods_attr_ids,
            ];
            //修改数据到数据表
            $data = ['number' => $number];
//            dump($where);
//            dump($data);die;
            //调用update方法修改数据
            self::update($data,$where);//调用模型方法
//            self::where($where)->update($data);//调用Query方法
            return true;
        }else{
            //未登录 修改cookie
            $data = cookie('cart') ? unserialize(cookie('cart')) : [];
            //拼接下标key
            $key = $goods_id . '-' . $goods_attr_ids;
            //修改购买数量
            $data[$key] = $number;
            //将修改后的数据 重新保存到cookie中
            cookie('cart',serialize($data),86400*7);
            return true;
        }
    }
    //删除购物车指定记录
    public static function delCart($goods_id,$goods_attr_ids)
    {
        //判断登录状态 已登录 修改数据表 未登录 修改cookie
        if(session('?user')) {
            //已登录 修改数据表
            //获取用户id
            $user_id = session('user.id');
            //修改条件
            $where = [
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'goods_attr_ids' => $goods_attr_ids,
            ];
            //删除数据
            self::where($where)->delete();
            return true;
        }else{
            //未登录 修改cookie
            $cart = cookie('cart') ? unserialize(cookie('cart')) : [];
            //拼接下标key
            $key = $goods_id . '-' . $goods_attr_ids;
            //从数组中删除一个键值对
            unset($cart[$key]);
            //将数据 重新保存到cookie中
            cookie('cart',serialize($cart),86400*7);
            return true;
        }
    }
}
