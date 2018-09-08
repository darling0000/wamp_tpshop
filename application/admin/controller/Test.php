<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Test extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
//        $list = \app\admin\model\Goods::select();
        $list = \app\admin\model\Goods::order('id desc')->paginate(2);
        return view('index',['list' => $list]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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
        /*$data = $request->param();
//        dump($data);die;
        $goods = \app\admin\model\Goods::find();
        $goo= $goods->allowField(true)->save($data);
        dump($goo);die;*/

        $data = $request->param();
        $goods = \app\admin\model\Goods::create($data,true);
        $this->success('添加成功','admin/test/index');
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function detail($id)
    {
        //
        $list = \app\admin\model\Goods::find($id);
        return view('detail',['list' => $list]);
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
        $data = \app\admin\model\Goods::find($id);
        return view('edit',['data' => $data]);
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
        $data = $request->param();
        \app\admin\model\Goods::update($data,[],true);
        $this->success('修改成功','admin/test/index');
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
        \app\admin\model\Goods::destroy($id);
        $this->success('删除成功','admin/test/index');
    }
}
