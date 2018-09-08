<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:63:"D:\WWW\tpshop\public/../application/admin\view\goods\index.html";i:1528632112;s:48:"D:\WWW\tpshop\application\admin\view\layout.html";i:1528732815;}*/ ?>
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

<style type="text/css">
    .pagination li{list-style:none;float:left;margin-left:10px;
        padding:0 10px;
        background-color:#5a98de;
        border:1px solid #ccc;
        height:26px;
        line-height:26px;
        cursor:pointer;color:#fff;
    }
    .pagination li a{color:white;padding: 0;line-height: inherit;border: none;}
    .pagination li a:hover{background-color: #5a98de;}
    .pagination li.active{background-color:white;color:gray;}
    .pagination li.disabled{background-color:white;color:gray;}
</style>
<!-- 右 -->
    <div class="content">
        <div class="header">
            <h1 class="page-title">商品列表</h1>
        </div>

        <div class="well">
            <!-- search button -->
            <form action="" method="get" class="form-search">
                <div class="row-fluid" style="text-align: left;">
                    <div class="pull-left span4 unstyled">
                        <p> 商品名称：<input class="input-medium" name="" type="text"></p>
                    </div>
                </div>
                <button type="submit" class="btn">查找</button>
                <a class="btn btn-primary" href="<?php echo url('create'); ?>">新增</a>
            </form>
        </div>
        <div class="well">
            <!-- table -->
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th>商品名称</th>
                        <th>商品价格</th>
                        <th>商品数量</th>
                        <th>商品logo</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($list as $v): ?>
                <tr class="success">
                    <td><?php echo $v['id']; ?></td>
                    <td><a href="<?php echo url('detail',['id' => $v['id']]); ?>"><?php echo $v['goods_name']; ?></a></td>
                    <td><?php echo $v['goods_price']; ?></td>
                    <td><?php echo $v['goods_number']; ?></td>
                    <td><img src="<?php echo $v['goods_logo']; ?>"></td>
                    <td><?php echo $v['create_time']; ?></td>
                    <td>
                        <a href="<?php echo url('edit',['id' => $v['id']]); ?>"> 编辑 </a>
                        <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='<?php echo url('delete',['id'=>$v['id']]); ?>'"> 删除 </a>
                        <!--<a href="javascript:void(0);" class="del"> 删除 </a>-->
                    </td>
                </tr>
                <?php endforeach; ?>
                    <!--<tr class="success">
                        <td>1</td>
                        <td><a href="javascript:void(0);">宏辉果蔬 苹果 烟台红富士 12枚75mm 单果约170-190g 总重4.2斤</a></td>
                        <td>23.90</td>
                        <td>100</td>
                        <td><img src="/static/admin/img/goods01_thumb.jpg"></td>
                        <td>2017-04-01 08:00:00</td>
                        <td>
                            <a href="javascript:void(0);"> 编辑 </a>
                            <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='#'"> 删除 </a>
                        </td>
                    </tr>
                    <tr class="error">
                        <td>2</td>
                        <td><a href="javascript:void(0);">百草味 坚果零食干果 内含开果器 夏威夷果奶油味200g/袋</a></td>
                        <td>16.90</td>
                        <td>300</td>
                        <td><img src="/static/admin/img/goods02_thumb.jpg"></td>
                        <td>2017-04-01 08:00:00</td>
                        <td>
                            <a href="javascript:void(0);"> 编辑 </a>
                            <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='#'"> 删除 </a>
                        </td>
                    </tr>
                    <tr class="warning">
                        <td>3</td>
                        <td><a href="javascript:void(0);">玖原农珍 广西百香果 3斤水果 大果约80-90g </a></td>
                        <td>35.80</td>
                        <td>100</td>
                        <td><img src="/static/admin/img/goods03_thumb.jpg"></td>
                        <td>2017-04-01 08:00:00</td>
                        <td>
                            <a href="javascript:void(0);"> 编辑 </a>
                            <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='#'"> 删除 </a>
                        </td>
                    </tr>
                    <tr class="info">
                        <td>4</td>
                        <td><a href="javascript:void(0);">三只松鼠 坚果炒货 零食奶油味 碧根果225g/袋</a></td>
                        <td>22.90</td>
                        <td>300</td>
                        <td><img src="/static/admin/img/goods04_thumb.jpg"></td>
                        <td>2017-04-01 08:00:00</td>
                        <td>
                            <a href="javascript:void(0);"> 编辑 </a>
                            <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='#'"> 删除 </a>
                        </td>
                    </tr>-->
                </tbody>
            </table>
            <!-- pagination -->
            <?php echo $list->render(); ?>
            <!--<div class="pagination">
                <ul>
                    <li><a href="#">Prev</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">Next</a></li>
                </ul>
            </div>-->
        </div>
        
        <!-- footer -->
        <footer>
            <hr>
            <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
        </footer>
    </div>
<script type="text/javascript">
    $(function () {
        $('.del').click(function () {
            if(!confirm('确认吗？'))return;
            var id = $(this).closest('td').prev().prev().prev().prev().prev().prev().html();
            //console.log(id);
            if(id ==  ''){
                return;
            }
            var data = {"id":id};
            $.ajax({
                "url":"<?php echo url('admin/goods/jqajaxdelete'); ?>",
                "type":"post",
                "data":data,
                "dataType":"json",
                "success":function (res) {
                    if(res.code != 10000){
                        alert(res.msg);
                        return;
                    }else {
                        alert('删除成功');
                    }
                }
            })
        });
    })
</script>


</body>
</html>