<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/26
 * Time: 10:14
 */

namespace app\admin\model;


use think\Model;

class Goods extends Model
{
    //特殊表可使用table属性 指定模型对应的数据表
//    protected $table = 'think_goods';
    use \traits\model\SoftDelete;
    protected $deleteTime = 'delete_time';

}