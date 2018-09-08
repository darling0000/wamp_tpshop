<?php

namespace app\admin\model;

use think\Model;

class Attribute extends Model
{
    public function getAttrTypeAttr($value)
    {
        return $value ? '单选属性' : '唯一属性';
    }
    public function getAttrInputTypeAttr($value)
    {
        $attr_input_type = ['input输入框','下拉列表','多选框'];
        return $attr_input_type[$value];
    }
}
