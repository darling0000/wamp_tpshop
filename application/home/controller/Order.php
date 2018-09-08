<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24
 * Time: 21:30
 */

namespace app\home\controller;


use think\Controller;

class Order extends Base
{
    public function create()
    {
        //登录判断
        if(!session('?user')){
            //没有登录 跳到登录页
            //指定登陆成功后 调回地址 比如重新进入购物车列表
            $back_url = 'home/cart/index';
            session('back_url',$back_url);
            $this->redirect('home/login/login');
        }
        //接受参数
        $cart_ids = request()->param('cart_ids');
        //参数检测 略
        //查询当前用户的收货地址信息tpshop_address表
        $user_id = session('user.id');
        $address = \app\home\model\Address::where('user_id',$user_id)->select();
//        dump($address);die;
        //获取支付方式
        $paytype = config('paytype');
        //查询选中的购物记录信息
        //SELECT t1.*, t2.goods_name, t2.goods_logo, t2.goods_price, t2.goods_number FROM `tpshop_cart` t1 left join tpshop_goods t2 on t1.goods_id = t2.id where t1.id in (5,6);
        $data = \app\home\model\Cart::alias('t1')
            ->field('t1.*, t2.goods_name, t2.goods_logo, t2.goods_price, t2.goods_number')
            ->join('tpshop_goods t2', 't1.goods_id = t2.id', 'left')
            ->where('t1.id', 'in', $cart_ids)
            ->select();
        //计算总金额 和总数量
        $total_price = 0;
        $total_number = 0;
        foreach($data as $v){
            $total_price += $v['number'] * $v['goods_price'];
            $total_number += $v['number'];
        }
//        dump($total_price);die;
        return view('create', ['address' => $address, 'paytype' => $paytype, 'data' => $data, 'total_price' => $total_price, 'total_number' => $total_number]);
    }

    public function save()
    {
        //接收参数
        $data = request()->param();
        //参数检测 略
        //订单编号 唯一
        $order_sn = mt_rand(100000,999999).time();
        //用户id
        $user_id = session('user.id');
        //收货地址信息
        $address = \app\home\model\Address::find($data['address_id']);
        //订单总金额 根据cart_ids查询 购物车表 和 商品表 累加计算
        //select t1.*,t2.goods_name,t2.logo,t2.goods_price,t2.number from tpshop_cart t1 left join tpshop_goods t2 on t1.goods_id = t2.id where t1.id in ();
        $cart_data = \app\home\model\Cart::alias('t1')
            ->field('t1.*,t2.goods_name,t2.goods_logo,t2.goods_price,t2.goods_number')
            ->join('tpshop_goods t2','t1.goods_id=t2.id','left')
            ->where('t1.id','in',$data['cart_ids'])
            ->select();
        //计算订单金额
        $order_amount = 0;
        foreach($cart_data as $v){
            $order_amount += $v['goods_price'] * $v['number'];
        }
        //组装一条订单数据
        $row = [
            'order_sn' => $order_sn,
            'order_amount' => $order_amount,
            'user_id' => $user_id,
            'consignee_name' => $address->consignee,
            'consignee_phone' => $address->phone,
            'consignee_address' => $address->address,
            'shipping_type' => 'yuantong',
            'pay_type' => $data['pay_type']
        ];
        //开启事务：
        \think\Db::startTrans();
        try{
            //将数据添加到订单表
            $order = \app\home\model\Order::create($row);
            //向订单商品表 添加多条数据
            $ordergoods_data = [];
            foreach($cart_data as $v){
                //组装一条 订单商品表的数据
                $row_goods = [
                    'order_id' => $order->id,
                    'goods_id' => $v['goods_id'],
                    'goods_name' => $v['goods_name'],
                    'goods_price' => $v['goods_price'],
                    'goods_logo' => $v['goods_logo'],
                    'number' => $v['number'],
                    'goods_attr_ids' => $v['goods_attr_ids']
                ];
                //放到结果数组，用于后续批量添加
                $ordergoods_data[] = $row_goods;

//            //减库存操作
//            //查询商品库存
//            $goods = \app\home\model\Goods::find($v['goods_id']);
//            $store = $goods['goods_number'] - $v['number'];
//            if($store < 0){
//                //库存不够
//                $this->error('创建订单失败，库存不够');
//            }
//            \app\home\model\Goods::update(['goods_number' => $store], ['id' => $v['goods_id']]);
            }
            //批量添加数据到订单商品表
            $ordergoods = new \app\home\model\OrderGoods();
            $ordergoods->saveAll($ordergoods_data);
            //减库存
            // 将购物记录中  同一个商品的 购买数量进行累加  哪个商品一共购买多少个
            $new_data = [];
            foreach($cart_data as $v){
                //商品id$v['goods_id']  购买数量$v['number']  原始库存$v['goods_number']
                if(!isset($new_data[$v['goods_id']])){
                    $new_data[$v['goods_id']] = $v['number'];
                }else{
                    $new_data[$v['goods_id']] += $v['number'];
                }
            }
            //针对每一个商品，进行减库存
            foreach($new_data as $k => $v){
                //$k  goods_id;  $v  购买数量
                $goods = \app\home\model\Goods::find($k);
                //计算新的库存
                $store = $goods['goods_number'] - $v;
                if($store < 0){
//                    $this->error('库存不足');
                    //抛出异常
                    throw new \Exception('10001', '库存不足');
                }
                //修改商品表的库存
                \app\home\model\Goods::update(['goods_number' => $store], ['id' => $k]);
            }
            //将购物车表中的对应记录删除  cart_ids   5,6
            \app\home\model\Cart::destroy($data['cart_ids']);
//        \app\home\model\Cart::where('id', 'in', $data['cart_ids'])->delete();
            //接下来去支付
//            echo '接下来是支付流程';
            switch ($data['pay_type']){
                case 'alipay':
                    //支付宝支付
                    $html = "<form id='alipayment' action='/plugins/alipay/pagepay/pagepay.php' method='post' style='display: none'>
<input id='WIDout_trade_no' name='WIDout_trade_no' value='$order_sn' />
<input id='WIDsubject' name='WIDsubject' value='TPSHOP订单'/>
<input id='WIDtotal_amount' name='WIDtotal_amount' value='$order_amount'/>
<input id='WIDbody' name='WIDbody' value='TPSHOP商城订单下的商品'/>
</form><script>document.getElementById('alipayment').submit();</script>";
                    echo $html;
                    break;
                case 'wechat':
                    //微信支付
                    break;
                case 'card':
                    //银联
                    break;
                case 'cash':
                    //货到付款
                    break;
            }
            //提交事务
            \think\Db::commit();
        }catch(\Exception $e){
            //回滚事务
            \think\Db::rollback();
            //获取异常信息 错误码 $e->getCode();
//            $code = $e->getCode();
            $error = $e->getMessage();
            //进行报错
            $this->error($error);
        }
    }

    //支付宝异步通知地址
    public function notify()
    {
//        echo 'notify';die;
        $data = request()->param();
        dump($data);die;
        //验证签名
        require_once ("./plugins/alipay/config.php");
        require_once ("./plugins/alipay/pagepay/service/AlipayTradeSevice.php");
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($data);
        dump($result);die;
        if($result){
            //验证成功
            if($_POST['trade_status'] == 'TRADE_FINISHED'){
                //订单已处理过
                echo 'success';die;
            }
            $order_sn = $data['out_trade_no'];
            $order = \app\home\model\Order::where('order_sn',$order_sn)->find();
            if($order){
                //修改订单状态
                $order->pay_status = 1;
                $order->save();
                echo 'success';die;
            }
            echo 'fail';die;
        }else{
            //验证失败
            echo 'fail';die;
        }
    }
    //支付宝同步通知地址
    public function callback()
    {
//        echo 'callback';die;
        $data = request()->param();
//        dump($data);die;
        //验证签名
        require_once ("./plugins/alipay/config.php");
        require_once ("./plugins/alipay/pagepay/service/AlipayTradeService.php");
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($data);
//        dump($result);die;
        if($result){
            //验证成功
            //展示支付成功页面
            return view('paysuccess',['total_amount'=>$data['total_amount'],'pay_type'=>'支付宝']);
        }else{
            //验证失败
            return view('payfail',['msg'=>'参数验证失败']);
        }
    }
}