<?php
require_once('function.php');

// 用户登录
function login($con, $phoneNumber, $password)
{
	$sql = "select * from pj_user where phone_num = '$phoneNumber'";
	
	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{

		if(0 == strcmp($password, $row['password']))
		{
			$userId = iconv("GBK", "UTF-8", $row['user_id']);
			$nickName = iconv("GBK", "UTF-8", $row['nick_name']);
			$sex = iconv("GBK", "UTF-8", $row['sex']);
			$age = iconv("GBK", "UTF-8", $row['age']);
			$avatar = iconv("GBK", "UTF-8", $row['avatar']);
			$city = iconv("GBK", "UTF-8", $row['city']);
			$registerTime = iconv("GBK", "UTF-8", $row['register_time']);
			$loginTime = iconv("GBK", "UTF-8", $row['login_time']);
			$loginType = iconv("GBK", "UTF-8", $row['login_type']);

			$userInfo = array('userId' => $userId, 
					'nickName' => $nickName,
					'sex' => $sex,
					'age' => $age,
					'avatar' => $avatar,
					'city' => $city,
					'registerTime' => $registerTime,
					'loginTime' => $loginTime,
					'loginType' => $loginType);

			echo json_encode(array('status' => '1', 'userInfo' => $userInfo));
		}
		else
		{
			echo json_encode(array('status' => '2', 'error' => 'password error'));
		}
	}
	else
	{
		echo json_encode(array('status' => '3', 'error' => 'user non-existent'));
	}

	mysql_free_result($res);
}

$phoneNumber = $_POST["phoneNumber"];
$password = $_POST["password"];

if (isset($phoneNumber) && !empty($phoneNumber) && isset($password) && !empty($password))
{
	$con = connectDB();

	login($con, $phoneNumber, $password);

	mysql_close($con);
}
else
{
	echo json_encode(array('status' => '4', 'error' => 'phoneNumber or password null'));
}
	
?>