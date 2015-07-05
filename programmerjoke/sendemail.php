<?php
require_once('class.phpmailer.php');
include('class.smtp.php');

function postmail($to,$subject = '',$body = ''){
    //Author:Jiucool WebSite: http://www.jiucool.com
    //$to 表示收件人地址 $subject 表示邮件标题 $body表示邮件正文
    //error_reporting(E_ALL);
    error_reporting(E_STRICT);
    date_default_timezone_set('Asia/Shanghai');//设定时区东八区
    
    $mail             = new PHPMailer(); //new一个PHPMailer对象出来
    $body            = eregi_replace("[\]",'',$body); //对邮件内容进行必要的过滤
    $mail->CharSet ="GBK";//设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP(); // 设定使用SMTP服务
    $mail->SMTPDebug  = 0;                     // 启用SMTP调试功能
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
//    $mail->SMTPSecure = "ssl";                 // 安全协议，可以注释掉
    $mail->Host       = 'smtp.163.com';      // SMTP 服务器
    $mail->Port       = 25;                   // SMTP服务器的端口号
    $mail->Username   = 'android151@163.com';  // SMTP服务器用户名，PS：我乱打的
    $mail->Password   = 'yc15169792295';            // SMTP服务器密码
    $mail->SetFrom('android151@163.com', '程序员笑话');
    $mail->AddReplyTo('android151@163.com','返回lalala');
    $mail->Subject    = $subject;
    $mail->AltBody    = 'To view the message, please use an HTML compatible email viewer!'; // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, '');
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if(!$mail->Send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "Message sent!恭喜，邮件发送成功！";
    }
}

postmail('jitayangchen@163.com','程序员笑话 测试中文字符 lalala','测试中文字符 hahaha');