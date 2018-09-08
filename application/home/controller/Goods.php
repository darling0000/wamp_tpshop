<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 21:26
 */

namespace app\home\controller;


use think\Controller;

class Goods extends Base
{
    public function index($cate_id)
    {
        $cate_info = \app\home\model\Category::find($cate_id);
        $list = \app\home\model\Goods::where('cate_id',$cate_id)->order('id desc')->paginate(10);
        return view('index',['list'=>$list,'cate_info'=>$cate_info]);
    }

    public function detail($id)
    {
        $goods = \app\home\model\Goods::find($id);
        $goodspics = \app\home\model\Goodspics::where('goods_id',$id)->select();
        $attribute = \app\home\model\Attribute::where('type_id',$goods->type_id)->select();
        $goodsattr = \app\home\model\GoodsAttr::where('goods_id',$id)->select();
        //为了方便页面展示 将所有的属性值 按照属性id做分组
        $new_goodsattr = [];
        foreach($goodsattr as $k=>$v){
            //$v['attr_id'] 属性id
            $new_goodsattr[$v['attr_id']][] = $v->toArray();
        }
//        dump($goodsattr);die;
        return view('detail',[
            'goods' => $goods,
            'goodspics' => $goodspics,
            'attribute' => $attribute,
            'new_goodsattr' => $new_goodsattr,
        ]);
    }
}