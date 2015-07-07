<?php
require_once('class.phpmailer.php');
include('class.smtp.php');

function postmail($to, $subject = '', $body = ''){

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
    $mail->Username   = 'jitayangchen@163.com';  // SMTP服务器用户名，PS：我乱打的
    $mail->Password   = 'yc6881090';            // SMTP服务器密码
    $mail->SetFrom('jitayangchen@163.com', '程序员笑话');
    $mail->AddReplyTo('jitayangchen@163.com','程序员笑话');
    $mail->Subject    = $subject;
    $mail->AltBody    = 'To view the message, please use an HTML compatible email viewer!'; //邮件正文不支持HTML的备用显示 // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, '');
    return $mail->Send();
}