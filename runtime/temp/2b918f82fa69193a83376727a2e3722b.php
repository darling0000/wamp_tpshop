<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:62:"D:\WWW\tpshop\public/../application/admin\view\goods\edit.html";i:1528814703;s:48:"D:\WWW\tpshop\application\admin\view\layout.html";i:1528732815;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>后台管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="/static/admin/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="/static/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/static/admin/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
    <script src="/static/admin/js/jquery-1.8.1.min.js"></script>
    <script src="/static/admin/js/bootstrap.min.js"></script>

</head>
<body>
<!-- 上 -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <ul class="nav pull-right">
                <li id="fat-menu" class="dropdown">
                    <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user icon-white"></i> <?php echo $user; ?>
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="javascript:void(0);">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="<?php echo url('login/logout'); ?>">安全退出</a></li>
                    </ul>
                </li>
            </ul>
            <a class="brand" href="index.html"><span class="first">后台管理系统</span></a>
            <ul class="nav">
                <li class="active"><a href="javascript:void(0);">首页</a></li>
                <li><a href="javascript:void(0);">系统管理</a></li>
                <li><a href="<?php echo url('admin/auth/index'); ?>">权限管理</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- 左 -->
<div class="sidebar-nav">
    <?php foreach($top as $k=>$top_v): ?>
    <a href="#error-menu<?php echo $k; ?>" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i><?php echo $top_v['auth_name']; ?></a>
    <ul id="error-menu<?php echo $k; ?>" class="nav nav-list collapse in">
        <?php foreach($second as $second_v): if(($second_v['pid'] == $top_v['id'])): ?>
        <li><a href="<?php echo url($second_v['auth_c'].'/'.$second_v['auth_a']); ?>"><?php echo $second_v['auth_name']; ?></a></li>
        <?php endif; endforeach; ?>
    </ul>
    <?php endforeach; ?>
</div>

<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/ueditor.all.min.js"> </script>
<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
<script type="text/javascript" charset="utf-8" src="/plugins/ueditor/lang/zh-cn/zh-cn.js"></script>

<!-- 右 -->
    <div class="content">
        <div class="header">
            <h1 class="page-title">商品编辑</h1>
        </div>
        
        <!-- edit form -->
        <form action="<?php echo url('update',['id' => $data['id']]); ?>" method="post" id="tab" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <ul class="nav nav-tabs">
              <li role="presentation" class="active"><a href="#basic" data-toggle="tab">基本信息</a></li>
              <li role="presentation"><a href="#desc" data-toggle="tab">商品描述</a></li>
              <li role="presentation"><a href="#attr" data-toggle="tab">商品属性</a></li>
              <li role="presentation"><a href="#pics" data-toggle="tab">商品相册</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="basic">
                    <div class="well">
                        <label>商品名称：</label>
                        <input type="text" name="goods_name" value="<?php echo $data['goods_name']; ?>" class="input-xlarge">
                        <label>商品价格：</label>
                        <input type="text" name="goods_price" value="<?php echo $data['goods_price']; ?>" class="input-xlarge">
                        <label>商品数量：</label>
                        <input type="text" name="goods_number" value="<?php echo $data['goods_number']; ?>" class="input-xlarge">
                        <label>商品logo：</label>
                        <input type="file" name="goods_logo" value="" class="input-xlarge">
                        <label>商品分类：</label>
                        <select name="" class="input-xlarge" id="cate_one">
                            <option value="">请选择一级分类</option>
                            <?php foreach($cate as $v): ?>
                            <option value="<?php echo $v['id']; ?>" <?php if(($v['id'] == $cate_two_info['pid'])): ?>selected="selected"<?php endif; ?>><?php echo $v['cate_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="" class="input-xlarge" id="cate_two">
                            <option value="">请选择二级分类</option>
                            <?php foreach($cate_two_all as $v): ?>
                            <option value="<?php echo $v['id']; ?>" <?php if(($v['id'] == $cate_two_info['id'])): ?>selected="selected"<?php endif; ?>><?php echo $v['cate_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="cate_id" class="input-xlarge" id="cate_three">
                            <option value="">请选择三级分类</option>
                            <?php foreach($cate_three_all as $v): ?>
                            <option value="<?php echo $v['id']; ?>" <?php if(($v['id'] == $data['cate_id'])): ?>selected="selected"<?php endif; ?>><?php echo $v['cate_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="tab-pane fade in" id="desc">
                    <div class="well">
                        <label>商品简介：</label>
                        <textarea id="editor" value="Smith" name="goods_introduce" class="input-xlarges" width:1000px;height: 500px;><?php echo $data['goods_introduce']; ?></textarea>
                    </div>
                </div>
                <div class="tab-pane fade in" id="attr">
                    <div class="well">
                        <label>商品类型：</label>
                        <select name="" class="input-xlarge">
                            <option value="2">电脑</option>
                            <option value="1">手机</option>
                        </select>
                        <div>
                            <label>商品品牌：</label>
                            <input type="text" name="" value="edit" class="input-xlarge">
                            <label>商品型号：</label>
                            <input type="text" name="" value="edit" class="input-xlarge">
                            <label>商品重量：</label>
                            <input type="text" name="" value="edit" class="input-xlarge">
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pics">
                    <div class="well">
                        <?php foreach($goodspics as $v): ?>
                            <div>
                                <img src="<?php echo $v['pics_sma']; ?>" style="width: 100px;">[<a class="delpics" pics_id="<?php echo $v['id']; ?>" href="javascript:;">删除</a>]
                            </div>
                        <?php endforeach; ?>
                        <div class="well">
                            <div>[<a href="javascript:void(0);" class="add">+</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">保存</button>
            </div>
        </form>
        <!-- footer -->
        <footer>
            <hr>
            <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
        </footer>
    </div>
    <script type="text/javascript">
        $(function(){
            //实例化编辑器
            //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
            UE.getEditor('editor');

            $('.add').click(function(){
                var add_div = '<div>[<a href="javascript:void(0);" class="sub">-</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>';
                $(this).parent().after(add_div);
            });
            $('.sub').live('click',function(){
                $(this).parent().remove();
            });
            $('.delpics').click(function () {
                var id = $(this).attr('pics_id');
                var data = {
                    "id":id
                };
//                console.log(data);
                var _this = this;
                $.ajax({
                    'url':"<?php echo url('admin/goods/delpics'); ?>",
                    'type':"post",
                    "data":data,
                    "dataType":"json",
                    "success":function (res) {
                        if(res.code != 10000){
                            alert(res.msg);
                            return;
                        }else{
                            $(_this).parent().remove();
                        }
                    }
                })
            })
            $('#cate_one').change(function () {
                $('#cate_two').html("<option value=''>请选择二级分类</option>");
                $('#cate_three').html("<option value=''>请选择三级分类</option>");
                var id = $(this).val();
                if(id ==  ''){
                    return;
                }
                var data = {"id":id};
                $.ajax({
                    "url":"<?php echo url('admin/goods/getsubcate'); ?>",
                    "type":"post",
                    "data":data,
                    "dataType":"json",
                    "success":function (res) {
                        if(res.code != 10000){
                            alert(res.msg);
                            return;
                        }else {
                            var data = res.data;
                            var str = "<option value=''>请选择二级分类</option>";
                            $.each(data,function (i,v) {
                                str += "<option value='" + v.id + "'>" + v.cate_name + "</option>";
                            })
                            $('#cate_two').html(str);
                        }
                    }
                })
            });
            $('#cate_two').change(function () {
                $('#cate_three').html("<option value=''>请选择三级分类</option>");
                var id = $(this).val();
                if(id ==  ''){
                    return;
                }
                var data = {"id":id};
                $.ajax({
                    "url":"<?php echo url('admin/goods/getsubcate'); ?>",
                    "type":"post",
                    "data":data,
                    "dataType":"json",
                    "success":function (res) {
                        if(res.code != 10000){
                            alert(res.msg);
                            return;
                        }else {
                            var data = res.data;
                            var str = "<option value=''>请选择三级分类</option>";
                            $.each(data,function (i,v) {
                                str += "<option value='" + v.id + "'>" + v.cate_name + "</option>";
                            })
                            $('#cate_three').html(str);
                        }
                    }
                })
            });
        });
    </script>


</body>
</html>