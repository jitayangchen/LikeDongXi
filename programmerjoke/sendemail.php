<?php
require_once('class.phpmailer.php');
include('class.smtp.php');
require_once('function.php');

$email = $_GET["email"];
$type = $_GET["type"];  // 0:Ϊע����֤      1:Ϊ�һ�����

$email = iconv("UTF-8", "GBK", $email);
$type = iconv("UTF-8", "GBK", $type);

$subject;
$body;
$code = rand(1000, 9999);

if($type == 0)
{
	$subject = '����ԱЦ��-ע����֤';
	$body = '����ԱЦ��-ע����֤��: ' . $code;
}
else
{
	$subject = '����ԱЦ��-�һ�������֤';
	$body = '����ԱЦ��-�һ�������֤��: ' . $code;
}

function postmail($to, $subject = '', $body = '', $type, $code){

    //$to ��ʾ�ռ��˵�ַ $subject ��ʾ�ʼ����� $body��ʾ�ʼ�����
    //error_reporting(E_ALL);
    error_reporting(E_STRICT);
    date_default_timezone_set('Asia/Shanghai');//�趨ʱ��������
    
    $mail             = new PHPMailer(); //newһ��PHPMailer�������
    $body            = eregi_replace("[\]",'',$body); //���ʼ����ݽ��б�Ҫ�Ĺ���
    $mail->CharSet ="GBK";//�趨�ʼ����룬Ĭ��ISO-8859-1����������Ĵ���������ã���������
    $mail->IsSMTP(); // �趨ʹ��SMTP����
    $mail->SMTPDebug  = 0;                     // ����SMTP���Թ���
    // 1 = errors and messages
    // 2 = messages only
    $mail->SMTPAuth   = true;                  // ���� SMTP ��֤����
//    $mail->SMTPSecure = "ssl";                 // ��ȫЭ�飬����ע�͵�
    $mail->Host       = 'smtp.163.com';      // SMTP ������
    $mail->Port       = 25;                   // SMTP�������Ķ˿ں�
    $mail->Username   = 'android151@163.com';  // SMTP�������û�����PS�����Ҵ��
    $mail->Password   = 'yc15169792295';            // SMTP����������
    $mail->SetFrom('android151@163.com', '����ԱЦ��');
    $mail->AddReplyTo('android151@163.com','����ԱЦ��');
    $mail->Subject    = $subject;
    $mail->AltBody    = 'To view the message, please use an HTML compatible email viewer!'; //�ʼ����Ĳ�֧��HTML�ı�����ʾ // optional, comment out and test
    $mail->MsgHTML($body);
    $address = $to;
    $mail->AddAddress($address, '');
    //$mail->AddAttachment("images/phpmailer.gif");      // attachment
    //$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
    if(!$mail->Send()) {
//        echo 'Mailer Error: ' . $mail->ErrorInfo;
		echo json_encode(array('status' => '0', 'error info' => 'send email error', 'function' => 'sendemail.php'));
    } else {
		addAccountNumber($to, $type, $code);
        echo json_encode(array('status' => '1', 'function' => 'sendemail.php'));
    }
}

function addAccountNumber($email, $type, $code)
{
	$con = connectDB();

	$create_time = date("Y-m-d H:i:s");
	$status = 0;
	$sql;

	if($type == 0)
	{
		$sql = "insert into pj_user (email, email_captcha, email_captcha_time, status) values ('$email', '$code', '$create_time', '$status')";
	}
	else
	{
		$userId = $_GET["userId"];
		$userId = iconv("UTF-8", "GBK", $userId);
		$sql = "update pj_user set email_captcha = '$code', email_captcha_time = '$create_time' where user_id='$userId'";
	}
	
	mysql_query($sql, $con);
}

postmail($email, $subject, $body, $type, $code);