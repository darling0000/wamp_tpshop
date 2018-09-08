<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Type extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function type_list()
    {
        $list = \app\admin\model\Type::select();
        return view('type_list',['list'=>$list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function type_add()
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
        //接受参数
        $data = $request->param();
        //参数检测
        if(empty($data['type_name'])){
            $this->error('类型名称不能为空');
        }
        //将数据添加到商品类型表 tpshop_type
        \app\admin\model\Type::create($data,true);
        $this->success('操作成功','type_list');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
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
