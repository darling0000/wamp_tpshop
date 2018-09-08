<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    //使用获取器对字段进行转化
    public function getPayStatusAttr($value)
    {
        $pay_status = ['未付款','已付款','已收货','已取消','已完成'];
        return $pay_status[$value];
    }

    public function getPayTypeAttr($value)
    {
        $pay_type = config('paytype');
        return $pay_type[$value];
    }

    public function getShippingTypeAttr($value)
    {
        $shipping_type = [
            'yuantong' => '圆通',
            'shentong' => '申通',
            'yunda' => '韵达',
            'zhongtong' => '中通',
            'shunfeng' => '顺丰',
        ];
        return $shipping_type[$value];
    }
}
