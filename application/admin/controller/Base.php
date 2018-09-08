<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/27
 * Time: 21:17
 */

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if (!session('?user_info')){
            $this->redirect('admin/login/login');
        }
        $this->checkauth();
        $this->getauth();
    }
    //获取当前登陆的管理员的菜单权限
    public function getauth()
    {
        //获取打钱登陆的管理员角色id 读取session
        $user = session('user_info.username');
        $role_id = session('user_info.role_id');
        //判断角色ID  ==1 超级管理员
        if($role_id == 1){
            //超级管理员 直接查询权限表
            //$top = \app\admin\model\Auth::where('pid',0)->where('is_nav',1)->select();
            $top = \app\admin\model\Auth::where(['pid'=>0,'is_nav'=>1])->select();
            //$second = \app\admin\model\Auth::where('pid','>',0)->where('is_nav',1)->select();
            $second = \app\admin\model\Auth::where(['pid'=>['>',0],'is_nav'=>1])->select();

        }else{
            //其他管理员 先查角色表 获取权限ids
            $role_info = \app\admin\model\Role::find($role_id);
            $role_auth_ids = $role_info['role_auth_ids'];
            //在查询权限表
            $top = \app\admin\model\Auth::where([
                'pid'=>0,
                'is_nav'=>1,
                'id'=>['in',$role_auth_ids]
            ])->select();
            $second = \app\admin\model\Auth::where([
                'pid'=>['>',0],
                'is_nav'=>1,
                'id'=>['in',$role_auth_ids]
            ])->select();
        }
        $this->assign('top',$top);
        $this->assign('second',$second);
        $this->assign('user',$user);

    }

    public function checkauth()
    {
        $role_id = session('user_info.role_id');
        if(1 == $role_id){
            return;
        }
        $controller = request()->controller();
        $action = request()->action();
        if($controller == 'Index' && $action == 'index'){
            return;
        }
        $role_info = \app\admin\model\Role::find($role_id);
        $role_auth_ids = explode(',',$role_info['role_auth_ids']);
        $auth = \app\admin\model\Auth::where(['auth_c'=>strtolower($controller),'auth_a'=>$action])->find();
        if(!in_array($auth['id'],$role_auth_ids)){
            $this->error('没有权限','admin/index/index');
        }
        return;
    }
}