<?php
require_once('function.php');

$accountNumber = $_POST['accountNumber'];
$captcha = $_POST['captcha'];
$password = $_POST['password'];
$nickName = $_POST['nickName'];

// 注册
function register($con, $email, $password, $nickName, $registerTime, $captcha)
{
	$sql = "INSERT INTO pj_user (email, password, nick_name, register_time) VALUES ('$email', '$password', '$nickName', '$registerTime')";
	
	mysql_query($sql, $con);
}

// 检查验证码是否正确
function checkCaptcha($con, $accountNumber, $captcha)
{
	$status = -1;  // 0：验证码失效    1：验证码正确   2：验证码错误
	$captchaCreateTime;
	$sql = "SELECT * FROM pj_captcha WHERE email = '$accountNumber'";
	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{
		$captchaCreateTime = $row['email_captcha_time'];
		if(0 == strcmp($captcha, $row['email_captcha']))
		{
			if((time() - strtotime($captchaCreateTime)) > 1800)
			{
				$status = 0;
			}
			else
			{
				$status = 1;
			}
		}
		else
		{
			$status = 2;
		}
	}
	else
	{
		$status = 2;
	}

	mysql_free_result($res);
	return $status;
}

// 检查账户是否存在
function existent($con, $email)
{
	$isExistent;
	$sql = "SELECT * FROM pj_user WHERE email = '$email'";
	
	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{
		$isExistent = true;
	}
	else
	{
		$isExistent = false;
	}
	mysql_free_result($res);
	return $isExistent;
}

if (isset($accountNumber) && isset($password)) {

	$con = connectDB();

	$accountNumber = iconv("UTF-8", "GBK", $accountNumber);
	$captcha = iconv("UTF-8", "GBK", $captcha);

	if(!existent($con, $accountNumber)) {
		$status = checkCaptcha($con, $accountNumber, $captcha);

		if($status == 1)
		{
			$registerTime = date("Y-m-d H:i:s");

			$password = iconv("UTF-8", "GBK", $password);
			$nickName = iconv("UTF-8", "GBK", $nickName);

			register($con, $accountNumber, $password, $nickName, $registerTime, $captcha);
			$userId = mysql_insert_id($con);
			echo json_encode(array('status' => '1', 'userId' => $userId, 'function' => 'register.php'));
		}
		else if($status == 0)
		{
			echo json_encode(array('status' => '4', 'error' => 'captcha invalid', 'function' => 'register.php'));
		}
		else if($status == 2)
		{
			echo json_encode(array('status' => '0', 'error' => 'captcha error', 'function' => 'register.php'));
		}
		else
		{
			echo json_encode(array('status' => $status, 'error' => 'error', 'function' => 'register.php'));
		}
	}
	else
	{
		echo json_encode(array('status' => '2', 'error' => 'account existent', 'function' => 'register.php'));
	}
	mysql_close($con);
}
else
{
	echo json_encode(array('status' => '3', 'error' => 'error', 'function' => 'register.php'));
}
?>