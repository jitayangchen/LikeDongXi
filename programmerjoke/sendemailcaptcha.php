<?php
require_once('sendemail.php');
require_once('function.php');

$email = $_GET["email"];
$type = $_GET["type"];  // 0:Ϊע����֤      1:Ϊ�һ�����

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

function addAccountNumber($email, $type, $code)
{
	$con = connectDB();

	$sql;
	$email = iconv("UTF-8", "GBK", $email);
	$create_time = date("Y-m-d H:i:s");

	$sql = "select * from pj_captcha where email = '$email'";
	
	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{
		$sql = "update pj_captcha set email_captcha = '$code', email_captcha_time = '$create_time' where email='$email'";
	}
	else
	{
		$sql = "insert into pj_captcha (email, email_captcha, email_captcha_time) values ('$email', '$code', '$create_time')";
	}
	mysql_query($sql, $con);
	mysql_free_result($res);
	return $con;
}

$isSendSuccess = postmail($email, $subject, $body);

if(isSendSuccess) {
	$con = addAccountNumber($email, $type, $code);

	echo json_encode(array('status' => '1', 'function' => 'sendemailcaptcha.php'));
	mysql_close($con);
} else {
	echo json_encode(array('status' => '0', 'error info' => 'send email error', 'function' => 'sendemailcaptcha.php'));
}