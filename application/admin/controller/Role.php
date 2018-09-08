<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Role extends Base
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $list = \app\admin\model\Role::select();
        return view('index',['list' => $list]);
    }

    public function setauth($id)
    {
        $role = \app\admin\model\Role::find($id);
        $top_all = \app\admin\model\Auth::where('pid',0)->select();
        $second_all = \app\admin\model\Auth::where('pid','>',0)->select();
        return view('setauth',[
            'role' => $role,
            'top_all' => $top_all,
            'second_all' => $second_all,
        ]);

    }

    public function saveauth(Request $request,$id)
    {
        $role_id = $request->param('role_id');
        $auth_id = $request->param('id/a');
//        dump($auth_id);die;
        $role_auth_ids = implode(',',$auth_id);
        \app\admin\model\Role::update(['role_auth_ids' => $role_auth_ids],['id' => $role_id]);
        $this->success('操作成功','index');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
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
