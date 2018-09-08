<?php

namespace app\admin\model;

use think\Model;

class Auth extends Model
{
    public function getIsNavAttr($value)
    {
        return $value ? '是' : '否';
    }
}
