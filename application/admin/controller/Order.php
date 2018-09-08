<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Order extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function order_list()
    {
        //查询订单数据表
        $list = \app\admin\model\Order::select();
        return view('order_list',['list'=>$list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function setauth()
    {
        return view();
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
    public function order_detail($id)
    {
        //查询订单表数据
        $order = \app\admin\model\Order::find($id);
        //查询订单商品表的数据
        $order_goods = \app\admin\model\OrderGoods::where('order_id', $id)->select();
        //查询每个订单商品的属性值属性名称数据
        foreach($order_goods as &$v){
            //$v['goods_attr_ids']
            //select t1.*,t2.attr_name from tpshop_goods_attr t1 left join tpshop_attribute t2 on t1.attr_id = t2.id where t1.id in (8,9)
            $v['goodsattr'] = \app\admin\model\GoodsAttr::alias('t1')
                ->field('t1.*, t2.attr_name')
                ->join('tpshop_attribute t2', 't1.attr_id = t2.id', 'left')
                ->where('t1.id', 'in', $v['goods_attr_ids'])
                ->select();
        }
        //查询快递信息
        // 快递公司 zhongtong  快递单号 211619589454
        $type = 'zhongtong';
        $postid = '211619589454';
        $url = "https://www.kuaidi100.com/query?type=$type&postid=$postid";
        //发送请求
        $res = curl_request($url, false, [], true);
        if(!$res){
            //请求发送失败
//            $this->error('请求发送失败');
            $kuaidi = [];
        }else{
            //解析json格式字符串
            $arr = json_decode($res, true);
            if($arr['status'] == 200){
                $kuaidi = $arr['data'];
            }else{
                $kuaidi = [];
            }
        }
        return view('order_detail', ['order' => $order, 'order_goods' => $order_goods, 'kuaidi' => $kuaidi]);
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
}
