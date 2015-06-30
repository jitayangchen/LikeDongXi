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
			$userId = $row['user_id'];
			echo json_encode(array('status' => '1', 'userId' => $userId));
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