<?php
// 应用公共文件
if (!function_exists('encrypt_password')){
    function encrypt_password($password){
        $salt = 'fd!sr23thj23hh67ug';
        $password = md5(md5($password).$salt);
        return $password;
    }
}

if (!function_exists('remove_xss')) {
    //使用htmlpurifier防范xss攻击
    function remove_xss($string){
        //相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
        require_once './plugins/htmlpurifier/HTMLPurifier.auto.php';

        // 生成配置对象
        $cfg = HTMLPurifier_Config::createDefault();
        // 以下就是配置：
        $cfg -> set('Core.Encoding', 'UTF-8');
        // 设置允许使用的HTML标签
        $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
        // 设置允许出现的CSS样式属性
        $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
        // 设置a标签上是否允许使用target="_blank"
        $cfg -> set('HTML.TargetBlank', TRUE);
        // 使用配置生成过滤用的对象
        $obj = new HTMLPurifier($cfg);
        // 过滤字符串
        return $obj -> purify($string);
    }
}

if (!function_exists('getTree')){
    function getTree($that,$pid = 0, $level = 0)
    {
        static $tree = array();
        foreach ($that as $row){
            if($row['pid'] == $pid){
                $row['level'] = $level;
                $tree[] = $row;
                getTree($that,$row['id'],$level + 1);
            }
        }
        return $tree;
    }
}

if (!function_exists('curl_request')){
    function curl_request($url,$post = false,$param = [],$https = false){
        //1.
        $ch = curl_init($url);
        //2.
        if ($post){
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$param);
        }
        //
        if ($https){
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        }
        //3.
        //
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $res = curl_exec($ch);
        //4.
        curl_close($ch);
        return $res;
    }
}

if (!function_exists('sendmsg')){
    //
    function sendmsg($phone,$msg)
    {
        //
        $gateway = config('msg.gateway');
        $appkey = config('msg.appkey');
        //
        $url = $gateway."?mobile=$phone&content=$msg&appkey=$appkey";
        $res = curl_request($url,false,[],true);
        if(!$res){
            return '请求失败';
        }
        //成功返回json字符串
        $arr = json_decode($res,true);
        if($arr['code'] == 10000){
            //
            return true;
        }else{
            return $arr['msg'];
        }
    }
}

if(!function_exists('sendmail')){
    //使用PHPMailer插件发送邮件
    function sendmail($email, $subject, $body)
    {
//        use PHPMailer\PHPMailer\PHPMailer;
//        use PHPMailer\PHPMailer\Exception;
//        require 'vendor/autoload.php';
        $mail = new \PHPMailer\PHPMailer\PHPMailer();       //传参数true，表示使用异常机制处理错误
        //Server settings
//            $mail->SMTPDebug = 2;                                 // 如果设置不为0，会输出一些调试信息
        $mail->isSMTP();                                      // 设置使用SMTP服务
        $mail->Host = config('email.host');                       // 设置发件服务器的地址
        $mail->SMTPAuth = true;                               // 设置进行SMTP认证
        $mail->Username = config('email.username');                 // 发件账号
        $mail->Password = config('email.password');                    // 发件授权码
        $mail->SMTPSecure = 'tls';                            // 安全加密方式 tls ssl
        $mail->Port = 25;                                    // 发送邮件的端口
        $mail->CharSet = 'UTF-8';                           //设置邮件内容的编码

        //Recipients
        $mail->setFrom(config('email.username'));       //设置发件人(及昵称)
        $mail->addAddress($email);     // 添加收件人(及昵称)
//            $mail->addAddress('ellen@example.com');               // Name is optional
//            $mail->addReplyTo('info@example.com', 'Information'); //添加回复人
//            $mail->addCC('cc@example.com');//添加抄送人
//            $mail->addBCC('bcc@example.com');//添加密送人

        //Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // 添加附件
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //Content
        $mail->isHTML(true);                                  // 设置邮件内容是html格式
        $mail->Subject = $subject;                          // 设置邮件主题
        $mail->Body    = $body;                               // 设置邮件内容
//            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; //邮件客户端不支持html时，显示的普通文本

        $res = $mail->send();
        if($res){
            return true;
        }else{
            return $mail->ErrorInfo;
        }
    }
}

if(!function_exists('encrypt_phone')){
    //手机号加密函数  15312345678   =》  153****5678
    function encrypt_phone($phone){
        return substr($phone, 0, 3) . '****' . substr($phone, 7);
    }
}