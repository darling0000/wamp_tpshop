<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"D:\WWW\tpshop\public/../application/admin\view\order\order_detail.html";i:1529765815;s:48:"D:\WWW\tpshop\application\admin\view\layout.html";i:1528732815;}*/ ?>
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

    <!-- 右 -->
    <div class="content">
        <div class="header">
            <h1 class="page-title">订单详情</h1>
        </div>
        
        <div class="well">
            订单编号：<?php echo $order['order_sn']; ?>
        </div>

        <div class="well">
            <!-- table -->
            <table class="table table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>商品id</th>
                    <th>商品名称</th>
                    <th>商品logo</th>
                    <th>商品价格</th>
                    <th>购买数量</th>
                    <th>商品属性</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($order_goods as $v): ?>
                <tr class="success">
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['goods_id']; ?></td>
                    <td><?php echo $v['goods_name']; ?></td>
                    <td><img src="<?php echo $v['goods_logo']; ?>"></td>
                    <td><?php echo $v['goods_price']; ?></td>
                    <td><?php echo $v['number']; ?></td>
                    <td>
                        <?php foreach($v['goodsattr'] as $attr): ?>
                        <?php echo $attr['attr_name']; ?>:<?php echo $attr['attr_value']; ?>
                        <br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <a href="javascript:void(0);"> 编辑 </a>
                        <a href="javascript:void(0);" onclick="if(confirm('确认删除？')) location.href='#'"> 删除 </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="well">
            收货地址：<?php echo $order['consignee_address']; ?><br>
            <iframe frameborder="0" width="800" height="800" src="http://api.map.baidu.com/geocoder?address=北京市顺义区黑马程序员&output=html&src=传智播客"></iframe>
        </div>
        <div class="well">
            物流信息：
            <?php foreach($kuaidi as $k => $v): ?>
            <br>
            <div <?php if(($k == 0)): ?>style="color:red;"<?php endif; ?>><?php echo $v['time']; ?> ------- <?php echo $v['context']; ?></div>
        <?php endforeach; ?>
        </div>
        <!-- footer -->
        <footer>
            <hr>
            <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
        </footer>
    </div>


</body>
</html>