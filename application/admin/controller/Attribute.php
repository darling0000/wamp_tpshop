<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Attribute extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
//        $list = \app\admin\model\Attribute::select();
        //链表查询 获取商品类型名称 selecte t1.*,t2.type_name from tpshop_attribute t1 left join tpshop_type t2 on t1.type_id = t2.id;
        $list = \app\admin\model\Attribute::alias('t1')
            ->field('t1.*,t2.type_name')
            ->join('tpshop_type t2','t1.type_id = t2.id','left')
            ->select();
        return view('index',['list'=>$list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $type = \app\admin\model\Type::select();
        return view('create',['type'=>$type]);
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //接收数据
        $data = $request->param();
        //检查数据
        //添加到数据表
        \app\admin\model\Attribute::create($data,true);
        $this->success('添加成功','index');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function getattr($id)
    {
        //查询属性表 获取指定类型下的属性信息
        $data = \app\admin\model\Attribute::where('type_id',$id)->select();
        foreach ($data as &$v){
            //分割数组 覆盖原来的字符串
            $v['attr_values'] = explode(',',$v['attr_values']);
        }
        unset($v);  //前面有引用 可以foreach后unset $v
        $res = [
            'code'=> 10000,
            'msg'=> 'success',
            'data'=> $data,
        ];
        return json($res);
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
