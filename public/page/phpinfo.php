<?php
////开启ob缓存
//ob_start();
////输出
//phpinfo();
////从ob缓存获取数据
////$str = ob_get_contents();
////从ob缓存获取数据并删除缓存
//$str = ob_get_clean();
////直接删除缓存
//ob_clean();
////$str = 'hello';
//echo $str;

//判断静态文件有效期
if(file_exists('./static.html')){
    $time = filemtime('./static.html');
    if(time() - $time < 60){
        header('location:http://www.tpshop.com/page/static.html');
    }
}
//开启ob缓存
ob_start();
//输出
phpinfo();
//从ob缓存获取数据并清空数据
$html = ob_get_clean();
//将数据保存到指定文件
file_put_contents('./static.html',$html);
//结束
header('location:http://www.tpshop.com/page/static.html');