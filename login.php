<?php
require_once('function.php');
require_once('config.php');

function updateToken($con, $id, $token)
{
	$tokenCreateTime = date("Y-m-d H:i:s");
	$sql = "update tr_user set token='$token', token_create_time='$tokenCreateTime' where id='$id'";
	mysql_query($sql, $con);
}

// 用户登录
function login($con, $phoneNumber, $password)
{
	$sql = "select * from tr_user where phone_number = '$phoneNumber'";
	
	$res = mysql_query($sql, $con);

	if($row = mysql_fetch_array($res))
	{
		$id = $row['id'];

		global $USER_ID_BASE;
		$userId = $USER_ID_BASE + $id;

		if(0 == strcmp($password, $row['password']))
		{
			$token = createUserToken($phoneNumber, $password);
			updateToken($con, $id, $token);
			echo json_encode(array('status' => '1', 'userId' => $userId, 'token' => $token));
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

$phoneNumber = $_POST["phone_number"];
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