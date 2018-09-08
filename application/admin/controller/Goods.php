<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/25
 * Time: 16:43
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;

class Goods extends Base
{
    public function read($id)
    {
        $data = \app\admin\model\Goods::find($id);
        dump($data);
        dump($data->goods_name);die();
    }
    public function index()
    {
//        echo encrypt_password('123456');die();
        /*$list = \app\admin\model\Goods::select();
        foreach ($list as $v){
            dump($v->toarray());
        }*/
        //where用法
        /*$info = \app\admin\model\Goods::where('id','33')->find();
        dump($info);die;*/
        /*$list = \app\admin\model\Goods::where('goods_name','like','%Plus%')->select();
        $list = \app\admin\model\Goods::where([
            'id'=>1,
            'goods_name'=>['like','%Plus%']
        ])->select();
        dump($list);die;*/
        /*$goods_name = \app\admin\model\Goods::where('id','33')->value('goods_name');
        $goods_name = \app\admin\model\Goods::where('id','>','33')->column('goods_name','id');
        dump($goods_name);*/
        $list = \app\admin\model\Goods::order('id desc')->paginate(5);
//        dump($list);die;
        return view('index',['list'=>$list]);
    }
    public function save(Request $request)
    {
        $data = $request->param();

        $data['goods_introduce'] = $request->param('goods_introduce','','remove_xss');
        //参数检测（表单验证）
        //定义验证规则数组$rule
        $rule = [
            'goods_name' => 'require',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
            'cate_id' => 'require|integer|gt:0',
        ];
        //定义提示信息数组$msg
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格必须是数字',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须是整数',
            'goods_number.gt' => '商品数量必须大于0',
            'cate_id.require' => '商品分类必须选择',
            'cate_id.integer' => '商品分类必须是整数',
            'cate_id.gt' => '商品分类必须大于0',
        ];
        //实例化验证码类
        $validate = new \think\Validate($rule,$msg);
        //调用方法check验证
        if (!$validate->check($data)){
            //
            $error = $validate->getError();
            $this->error($error);
        }
        $data['goods_logo'] = $this->upload_logo();

        $goods = \app\admin\model\Goods::create($data,true);
        $this->upload_pics($goods->id);
        //商品属性值 添加到tpshop_goods_attr表
        $goodsattr_data = [];
        foreach($data['attr_value'] as $k => $v){
            //$k 是属性id ； $v是多个属性值的数组
            foreach($v as $value){
                //$value 是一个属性值
                //组装一条数据
                $row = [
                    'goods_id' => $goods->id,
                    'attr_id' => $k,
                    'attr_value' => $value
                ];
                //放到结果数据，最后批量添加
                $goodsattr_data[] = $row;
            }
        }
        //批量添加数据到tpshop_goods_attr表
        $goodsattr = new \app\admin\model\GoodsAttr();
        $goodsattr->saveAll($goodsattr_data);
//        dump($goods);die;
        //页面跳转
        $this->success('成功','index');

    }

    public function upload_pics($goods_id)
    {
        $files = request()->file('goods_pics');
//        dump($files);die;
        $goods_pics =[];
        foreach ($files as $file){
            $info = $file->validate(['size' => 5*1024*1024,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH.'public'.DS.'uploads');
            if($info){
                $pics = DS."uploads".DS.$info->getSaveName();
                $temp = explode(DS,$info->getSaveName());
                $pics_sma = DS.'uploads'.DS.$temp[0].DS.'thumb_400_'.$temp[1];
                $pics_big = DS.'uploads'.DS.$temp[0].DS.'thumb_800_'.$temp[1];
                $img = \think\Image::open('.'.$pics);
                $img->thumb(800,800)->save('.'.$pics_big);
                //$img = \think\Image::open('.'.$pics);
                $img->thumb(400,400)->save('.'.$pics_sma);
                $row = [
                    'goods_id' => $goods_id,
                    'pics_big' => $pics_big,
                    'pics_sma' => $pics_sma,
                ];
                $goods_pics[] = $row;
            }
        }
//        dump($goods_pics);die;
        $goodspics_model = new \app\admin\model\Goodspics();
        $goodspics_model->saveAll($goods_pics);
    }
    public function create()
    {
        $cate = \app\admin\model\Category::where('pid',0)->select();
        $type = \app\admin\model\Type::select();
        return view('create',['cate' => $cate,'type'=>$type]);
    }
    public function edit($id)
    {
        $data = \app\admin\model\Goods::find($id);
//        dump($data);die;
        $cate = \app\admin\model\Category::where('pid',0)->select();
        $cate_three_info = \app\admin\model\Category::find($data['cate_id']);
        $cate_two_info = \app\admin\model\Category::find($cate_three_info['pid']);
        $cate_two_all = \app\admin\model\Category::where('pid',$cate_two_info['pid'])->select();
        $cate_three_all = \app\admin\model\Category::where('pid',$cate_two_info['id'])->select();
        $goodspics = \app\admin\model\Goodspics::where('goods_id',$id)->select();
//        dump($data);dump($cate_two_info);die;
        return view('edit',[
            'data' => $data,
            'cate' => $cate,
            'cate_two_info' => $cate_two_info,
            'cate_two_all' => $cate_two_all,
            'cate_three_all' => $cate_three_all,
            'goodspics' => $goodspics,
        ]);
    }
    public function update(Request $request,$id)
    {
        $data = $request->param();
//        dump($data['goods_introduce']);die;
        $data['goods_introduce'] = remove_xss($data['goods_introduce']);
//        dump($data['goods_introduce']);die;
        $goods = new \app\admin\model\Goods();
//        dump($id);dump($data);die;
        //数据检测
        //验证规则数组
        $rule = [
            'goods_name' => 'require',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
            'cate_id' => 'require|integer|gt:0',
        ];
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格必须是数字',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须是整数',
            'goods_number.gt' => '商品数量必须大于0',
            'cate_id.require' => '商品分类必须选择',
            'cate_id.integer' => '商品分类必须是整数',
            'cate_id.gt' => '商品分类必须大于0',
        ];
        $validate = new \think\Validate($rule,$msg);
        if (!$validate->check($data)){
            $error = $validate->getError();
            $this->error($error);
        }
        //修改图片
        $file = request()->file('goods_logo');
        if ($file){
            $data['goods_logo'] = $this->upload_logo();
        }
//        $res = $goods->allowField(true)->save($_POST,['id'=>$id]);
        $res = \app\admin\model\Goods::update($data,[],true);
        $this->upload_pics($id);
        $this->success('成功','index');
    }
    public function delete(Request $request)
    {
        $data = $request->param();
//        dump($data);die;
        \app\admin\model\Goods::destroy($data['id']);
        $this->success('成功','index');
    }
    public function detail(Request $request,$id)
    {
        $data = $request->param();
//        dump($data);die;
        $list = \app\admin\model\Goods::find($data['id']);
        $attribute = \app\home\model\Attribute::where('type_id',$list.type_id)->select();
        return view('detail',['list'=>$list,'attribute'=>$attribute]);
    }
    private function upload_logo(){
        //图片上传
        //获取上传文件
        $file = request()->file('goods_logo');
        //判断是否上传
        if (empty($file)){
            $this->error('请上传logo图片');
        }

        //
        $info = $file->validate(['size' => 1024*1024*5,'ext' => 'jpg,png,gif,jpeg']) ->move(ROOT_PATH.'public'.DS.'uploads');
        if ($info){
//            dump($info);die;
            //拼接图片访问路径
            $goods_logo = DS.'uploads'.DS.$info->getSaveName();
            //$data['goods_logo'] = $goods_logo;
//            dump($goods_logo);die;
            //生成缩略图
            //调用open打开原始图
            $image = \think\Image::open('.'.$goods_logo);
            //调用thumb方法生成缩略图，调用save保存
            $image->thumb(210,240)->save('.'.$goods_logo);
            return $goods_logo;
        }else{
            //上传出错
            $error= $file->getError();
            $this->error($error);
        }
    }

    public function getsubcate()
    {
        $id = request()->param('id');
//        dump($id);die;
        if (!preg_match('/^\d+$/',$id)){
            $res = [
                'code' => 10001,
                'msg'  => '参数错误',
            ];
            echo json_encode($res);die;
        }
        $data = \app\admin\model\Category::where('pid',$id)->select();
        $res = [
            'code' => 10000,
            'msg'  => 'success',
            'data' => $data,
        ];
        echo json_encode($res);die;
    }

    public function jqajaxsave(Request $request)
    {
        $data = $request->param();
//        dump($data);die;
        //参数检测（表单验证）
        //定义验证规则数组$rule
        $rule = [
            'goods_name' => 'require',
            'goods_price' => 'require|float|gt:0',
            'goods_number' => 'require|integer|gt:0',
        ];
        //定义提示信息数组$msg
        $msg = [
            'goods_name.require' => '商品名称不能为空',
            'goods_price.require' => '商品价格不能为空',
            'goods_price.float' => '商品价格必须是数字',
            'goods_price.gt' => '商品价格必须大于0',
            'goods_number.require' => '商品数量不能为空',
            'goods_number.integer' => '商品数量必须是整数',
            'goods_number.gt' => '商品数量必须大于0',
        ];
        //实例化验证码类
        $validate = new \think\Validate($rule,$msg);
        //调用方法check验证
        if (!$validate->check($data)){
            //
            $error = $validate->getError();
            $res = [
                "code" => 10001,
                "msg" => $this->error($error),
            ];
        }
//        dump($data{'goods_logo'});die;
//        $data{'goods_logo'} = $this->upload_logo();

        $goods = \app\admin\model\Goods::create($data,true);
        $res = [
            'code' => 10000,
            'msg'  => 'success',
            //'data' => $goods,
        ];
        echo json_encode($res);
        //$this->success('成功','create');
        die;
    }
    public function jqajaxdelete(Request $request)
    {
        $id = request()->param('id');
//        dump($id);die;
        if (!preg_match('/^\d+$/',$id)){
            $res = [
                'code' => 10001,
                'msg'  => '参数错误',
            ];
            echo json_encode($res);die;
        }
        $data = \app\admin\model\Goods::destroy($id);
        $res = [
            'code' => 10000,
            'msg'  => 'success',
            'data' => $data,
        ];
        echo json_encode($res);die;
    }

    public function delpics()
    {
        $id = request()->param('id');
//        dump($id);die;
        \app\admin\model\Goodspics::destroy($id);
        $res = [
            'code' => 10000,
            'msg' => 'success',
        ];
        return json($res);
    }
}