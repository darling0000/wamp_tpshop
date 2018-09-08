<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:64:"D:\WWW\tpshop\public/../application/admin\view\goods\create.html";i:1528985894;s:48:"D:\WWW\tpshop\application\admin\view\layout.html";i:1528732815;}*/ ?>
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
            <h1 class="page-title">商品新增</h1>
        </div>

        <!-- add form -->
        <form action="<?php echo url('save'); ?>" method="post" id="tab" enctype="multipart/form-data">
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
                        <input type="text" name="goods_name" value="" class="input-xlarge">
                        <label>商品价格：</label>
                        <input type="text" name="goods_price" value="" class="input-xlarge">
                        <label>商品数量：</label>
                        <input type="text" name="goods_number" value="" class="input-xlarge">
                        <label>商品logo：</label>
                        <input type="file" name="goods_logo" value="" class="input-xlarge">
                        <label>商品分类：</label>
                        <select name="" class="input-xlarge" id="cate_one">
                            <option value="">请选择一级分类</option>
                            <?php foreach($cate as $v): ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo $v['cate_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <select name="" class="input-xlarge" id="cate_two">
                            <option value="">请选择二级分类</option>
                        </select>
                        <select name="cate_id" class="input-xlarge" id="cate_three">
                            <option value="">请选择三级分类</option>
                        </select>
                    </div>
                </div>
                <div class="tab-pane fade in" id="desc">
                    <div class="well">
                        <label>商品简介：</label>
                        <textarea id="editor" value="Smith" name="goods_introduce" class="input-xlarges" width:1000px;height: 500px;></textarea>
                    </div>
                </div>
                <div class="tab-pane fade in" id="attr">
                    <div class="well">
                        <label>商品类型：</label>
                        <select name="type_id" class="input-xlarge">
                            <option value="">==请选择==</option>
                            <?php foreach($type as $v): ?>
                            <option value="<?php echo $v['id']; ?>"><?php echo $v['type_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="attrs">
                            <!--<label>商品品牌：</label>-->
                            <!--<input type="text" name="" value="" class="input-xlarge">-->
                            <!--<label>商品型号：</label>-->
                            <!--<input type="text" name="" value="" class="input-xlarge">-->
                            <!--<label>商品重量：</label>-->
                            <!--<input type="text" name="" value="" class="input-xlarge">-->
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="pics">
                    <div class="well">
                        <div>
                            [<a href="javascript:void(0);" class="add">+</a>]商品图片：
                            <input type="file" name="goods_pics[]" value="" class="input-xlarge">
                        </div>
                    </div>
                </div>
                <!--<button class="btn btn-primary" type="submit" onclick="return false">保存</button>-->
                <button class="btn btn-primary" type="submit" >保存</button>
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


//        document.getElementById('cate_one').onchange = function () {
//            document.getElementById('cate_two').innerHTML = "<option value=''>请选择二级分类</option>";
//            document.getElementById('cate_three').innerHTML = "<option value=''>请选择三级分类</option>";
//            var id = this.value;
//            var data = "id=" + id;
//            var xhr = new XMLHttpRequest();
//            xhr.onreadystatechange = function () {
//                if(xhr.readyState == 4 && xhr.status == 200){
////                    console.log(xhr.responseText);
//                    var res = xhr.responseText;
//                    var json = JSON.parse(res);
//                    if(json.code != 10000){
//                        alert(json.msg);
//                    }else{
//                        var data = json.data;
//                        var str = "<option value=''>请选择二级分类</option>";
//                        for(var i=0;i<data.length;i++){
//                            str += "<option value='" + data[i].id + "'>" + data[i].cate_name + "</option>";
//                        }
//                        document.getElementById('cate_two').innerHTML = str;
//                    }
//                }
//            }
//            xhr.open('post',"<?php echo url('admin/goods/getsubcate'); ?>");
//            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//            xhr.send(data);
//        }
//        document.getElementById('cate_two').onchange = function () {
//            //document.getElementById('cate_three').innerHTML = "<option value=''>请选择三级分类</option>";
//            var id = this.value;
//            var data = "id=" + id;
//            var xhr = new XMLHttpRequest();
//            xhr.onreadystatechange = function () {
//                if(xhr.readyState == 4 && xhr.status == 200){
////                    console.log(xhr.responseText);
//                    var res = xhr.responseText;
//                    var json = JSON.parse(res);
//                    if(json.code != 10000){
//                        alert(json.msg);
//                    }else{
//                        var data = json.data;
//                        var str = "<option value=''>请选择三级分类</option>";
//                        for(var i=0;i<data.length;i++){
//                            str += "<option value='" + data[i].id + "'>" + data[i].cate_name + "</option>";
//                        }
//                        document.getElementById('cate_three').innerHTML = str;
//                    }
//                }
//            }
//            xhr.open('post',"<?php echo url('admin/goods/getsubcate'); ?>");
//            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
//            xhr.send(data);
//        }
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
            //保存 绑定点击事件
//            $('.btn-primary').click(function () {
//                var data = {
//                    "goods_name":$('input[name=goods_name]').val(),
//                    "goods_price":$('input[name=goods_price]').val(),
//                    "goods_number":$('input[name=goods_number]').val(),
//                    "goods_logo":$('input[name=goods_logo]').val(),
//                };
//    //            console.log(data);
//                $.ajax({
//                    "url":"<?php echo url('admin/goods/jqajaxsave'); ?>",
//                    "type":"post",
//                    "data":data,
//                    "dataType":"json",
//                    "success":function (res) {
//                        if(res.code != 10000){
//                            alert(res.msg);
//                            return;
//                        }else {
//                            alert('添加成功');
//                        }
//                    }
//                });
//            });
            //给商品类型下拉列表绑定change事件
            $('select[name=type_id]').change(function () {
                var type_id = $(this).val();
                var data = {"id":type_id};
                $.ajax({
                    "url":"<?php echo url('admin/attribute/getattr'); ?>",
                    "type":"post",
                    "data":data,
                    "dataType":"json",
                    "success":function (res) {
//                        console.log(res);
                        if(res.code != 10000){
                            alert(res.msg);return;
                        }else{
                            var attrs = res.data;
                            var str = "";
                            $.each(attrs,function (i,v) {
                                str += "<label>" + v.attr_name + "：</label>";
                                if(v.attr_input_type == 'input输入框'){
                                    str += '<input type="text" name="attr_value[' + v.id + '][]" value="" class="input-xlarge">';
                                }else if(v.attr_input_type == '下拉列表'){
                                    str += '<select name="attr_value[' + v.id + '][]">';
                                    $.each(v.attr_values,function (index,value) {
                                        str += '<option value="' + value + '">'+ value +'</option>';
                                    });
                                    str += '</select>';
                                }else{
                                    $.each(v.attr_values,function (index,value) {
                                        str += '<input type="checkbox" name="attr_value[' + v.id + '][]" value="' + value + '" class="input-xlarge">' + value;
                                    });
                                }
                            })
                            $('#attrs').html(str);
                        }
                    }
                })
            })
        });
    </script>


</body>
</html>